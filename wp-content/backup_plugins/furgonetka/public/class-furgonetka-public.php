<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://furgonetka.pl
 * @since      1.0.0
 *
 * @package    Furgonetka
 * @subpackage Furgonetka/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and hooks
 *
 * @package    Furgonetka
 * @subpackage Furgonetka/public
 * @author     Furgonetka.pl <woocommerce@furgonetka.pl>
 */
class Furgonetka_Public
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of the plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        if (!is_checkout()) return;
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/furgonetka-public.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        if (!is_checkout()) return;
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/furgonetka-public.js', array('jquery'), $this->version, false);
        wp_localize_script($this->plugin_name, 'settings', array(
            'ajaxurl' => admin_url('admin-ajax.php')
        ));

    }

    /**
     * Add map script to shipping options and current selected point from session
     *
     * @@since    1.0.0
     */
    public function furgonetka_totals_after_shipping()
    {
        $chosen_method_array = WC()->session->get('chosen_shipping_methods');
        $deliveryToType = get_option(FURGONETKA_PLUGIN_NAME . '_deliveryToType');
        if (isset($deliveryToType[$chosen_method_array[0]]))
            $selectedPoint = $this->getSelectedPointFromSession($deliveryToType[$chosen_method_array[0]], (WC()->session->get('chosen_payment_method') == 'cod'));
        else
            $selectedPoint = $this->getSelectedPointFromSession('', false);

        ?>
        <script type="text/javascript" src="https://furgonetka.pl/js/dist/map/map.js"></script>
        <input type="hidden" id="furgonetkaPoint" name="furgonetkaPoint" value="<?php echo esc_html($selectedPoint['code']); ?>"/>
        <input type="hidden" id="furgonetkaPointName" name="furgonetkaPointName" value="<?php echo esc_html($selectedPoint['name']); ?>"/>
        <input type="hidden" id="furgonetkaService" name="furgonetkaService"
               value="<?php echo esc_html($selectedPoint['service']); ?>"/>
        <?php wp_nonce_field($this->plugin_name . '_setPointAction', $this->plugin_name . '_setPoint'); ?>
        <?php
    }

    /**
     * Save selected pooint to order
     *
     * @@since    1.0.0
     */
    public function save_point_to_order($order, $posted)
    {
        // don't forget appropriate sanitization if you are using a different field type
        if (isset($_POST['furgonetkaPoint'])) {
            $order->update_meta_data('_furgonetkaPoint', sanitize_text_field($_POST['furgonetkaPoint']));
        }
        if (isset($_POST['furgonetkaPointName'])) {
            $order->update_meta_data('_furgonetkaPointName', sanitize_text_field($_POST['furgonetkaPointName']));
        }
        if (isset($_POST['furgonetkaService'])) {
            $order->update_meta_data('_furgonetkaService', sanitize_text_field($_POST['furgonetkaService']));
        }

    }

    /**
     * Save selected point to woocommerce session
     *
     * @@since    1.0.0
     */
    public function save_point_to_session()
    {

        $data = $_POST;

        $currentService = sanitize_text_field($data['currentService']);
        $name = sanitize_text_field($data['name']);
        $code = sanitize_text_field($data['code']);
        $cod = sanitize_text_field($data['cod']);


        // check the nonce
        if (check_ajax_referer($this->plugin_name . '_setPointAction', 'security', false) == false) {
            wp_send_json_error();
        }
        $currentSelection = WC()->session->get($this->plugin_name . '_pointTo');
        if ($cod == "true") {
            $currentSelection = WC()->session->get($this->plugin_name . '_pointToCod');
        }

        if (!$currentSelection) $currentSelection = array();
        $currentSelection[$currentService] = array(
            'service' => $currentService,
            'name' => $name,
            'code' => $code,
        );
        if ($cod == "true") {
            WC()->session->set($this->plugin_name . '_pointToCod', $currentSelection);
        } else {
            WC()->session->set($this->plugin_name . '_pointTo', $currentSelection);
        }
        wp_send_json_success();

    }

    /**
     *
     * Get selected point from woocommerce session
     *
     */
    public function get_point_to_payment()
    {

        $data = $_POST;
        $cod = sanitize_text_field($data['cod']);

        // check the nonce
        if (check_ajax_referer($this->plugin_name . '_setPointAction', 'security', false) == false) {
            wp_send_json_error();
        }

        $chosen_method_array = WC()->session->get('chosen_shipping_methods');

        $deliveryToType = get_option(FURGONETKA_PLUGIN_NAME . '_deliveryToType');

        $selectedPoint = $this->getSelectedPointFromSession($deliveryToType[$chosen_method_array[0]], $cod == "true");

        $data = array(
            'button' => $this->generateDeliveryButton($deliveryToType[$chosen_method_array[0]], $cod == "true"),
            'code' => $selectedPoint['code']
        );

        wp_send_json_success($data);

    }


    /**
     * Add map to shipping option
     *
     * @@since    1.0.0
     */
    public function after_shipping_rate($method, $index)
    {

        if (!is_checkout()) return;
        $chosen_method_array = WC()->session->get('chosen_shipping_methods');

        if ($chosen_method_array[0] != $method->id) return;
        $deliveryToType = get_option(FURGONETKA_PLUGIN_NAME . '_deliveryToType');

        if (isset($method->id) && isset($deliveryToType[$method->id])) {
            echo '<p id="select-point-container">' . $this->generateDeliveryButton($deliveryToType[$method->id], (WC()->session->get('chosen_payment_method') == 'cod')) . '</p>';
        }
    }

    /**
     * Select Point button in delivery list
     *
     * @@since    1.0.0
     */
    public function generateDeliveryButton($methodType, $isCOD)
    {
        $selectedPoint = $this->getSelectedPointFromSession($methodType, $isCOD);
        $customer = WC()->session->get('customer');

        return sprintf('<a id="select-point" href="#" onclick=\'openFurgonetkaMap("%1$s","%4$s","%5$s");return false\'>%2$s</a><span id="selected-point">%3$s</span>',
            $methodType,
            __('Select point', 'furgonetka'),
            $selectedPoint['name'],
            $customer['shipping_city'],
            $customer['shipping_address_1'] . ' ' . $customer['shipping_address_2']
        );
    }

    /**
     * Get selected point from woocommerce session
     *
     * @@since    1.0.0
     */
    public function getSelectedPointFromSession($service, $isCOD)
    {
        $returnSelection = array(
            'service' => '',
            'name' => '',
            'code' => '',
        );
        $currentSelection = WC()->session->get($this->plugin_name . '_pointTo');
        if ($isCOD) {
            $currentSelection = WC()->session->get($this->plugin_name . '_pointToCod');
        }

        if (isset($currentSelection[$service])) {
            return $currentSelection[$service];
        }
        return $returnSelection;
    }
    /**
     * Validate point selection in php
     *
     * @@since    1.0.7
     */
    public function woocommerce_checkout_process() {

        $deliveryToType = get_option(FURGONETKA_PLUGIN_NAME . '_deliveryToType');

        $chosen_method_array = WC()->session->get('chosen_shipping_methods');
        if (isset($chosen_method_array[0]) && isset($deliveryToType[$chosen_method_array[0]])) {
            if ( empty( $_POST['furgonetkaPoint'] ) && true === WC()->cart->needs_shipping() ) {
                wc_add_notice( __( 'Please select delivery point.','furgonetka' ), 'error' );
            }
        }

    }

}
