<?php

/**
 * Class WC_Gateway_Przelewy24
 */
class WC_Gateway_Przelewy24 extends WC_Payment_Gateway
{
    const PAYMENT_METHOD = 'przelewy24';

    /**
     * The active currency.
     *
     * @var string
     */
    private $active_currency;

    /**
     * The P24_Core instance
     *
     * @var P24_Core
     */
    private $plugin_core;

    /**
     * @var array
     *
     * List of common settings that are used by the gateway class.
     * There could be more keys set by other parts of plugin.
     */
    private $common_settings_keys = [
        'enabled',
    ];

    /**
     * P24_Communication_Parser instance.
     *
     * @var P24_Communication_Parser
     */
    private $communication_parser;

    /**
     * WC_Gateway_Przelewy24 constructor.
     */
    public function __construct()
    {
        $this->plugin_core = get_przelewy24_plugin_instance();
        $this->plugin_core->register_gateway( $this );

        $this->supports = array(
            'products',
            'refunds',
        );

        $this->id = self::PAYMENT_METHOD;
        $this->icon = PRZELEWY24_URI . 'logo.png';
        $this->method_title = 'Przelewy24';
        $this->method_description = __( 'Moduł Przelewy24.pl w tej chwili posiada podstawową funkcjonalność, która sukcesywnie będzie rozszerzana.', 'przelewy24' );
        $this->has_fields = false;

        $this->generator = new Przelewy24Generator( $this );

        $communication_parser = $this->plugin_core->get_communication_parser();
        $communication_parser->parse_status_response( $this );
        /* If we parse some data form Przelewy24, it may change active currency. */
        $this->plugin_core->try_override_active_currency( $communication_parser );
        $this->active_currency = null;
        $this->communication_parser = $communication_parser;

        $this->init_settings();

        $this->title = (isset($this->settings['title']) ? $this->settings['title'] : '');
        $this->description = (isset($this->settings['description'])) ? $this->settings['description'] : '';
        $this->instructions = $this->get_option('instructions', $this->description);
        $this->merchant_id = (isset($this->settings['merchant_id'])) ? $this->settings['merchant_id'] : 0;
        $this->shop_id = (isset($this->settings['shop_id'])) ? $this->settings['shop_id'] : 0;
        $this->salt = (isset($this->settings['CRC_key'])) ? $this->settings['CRC_key'] : '';
        $this->p24_oneclick = (isset($this->settings['p24_oneclick']) ? $this->settings['p24_oneclick'] : 'no');
        $this->p24_payinshop = (isset($this->settings['p24_oneclick']) ? $this->settings['p24_oneclick'] : 'no');
        $this->p24_acceptinshop = (isset($this->settings['p24_acceptinshop']) ? $this->settings['p24_acceptinshop'] : 'no');
        $this->p24_testmod = (isset($this->settings['p24_testmod']) ? $this->settings['p24_testmod'] : 0);
        $this->p24_api = (isset($this->settings['p24_api']) ? $this->settings['p24_api'] : '');
        $this->init_form_fields();

        add_action('woocommerce_update_options_payment_gateways_' . $this->id, array(&$this, 'process_admin_options'));

        add_action('woocommerce_receipt_przelewy24', array(&$this, 'receipt_page'));
        add_action('woocommerce_thankyou_przelewy24', array($this, 'thankyou_page'));
        add_action('woocommerce_email_before_order_table', array($this, 'email_instructions'), 10, 3);
        add_action('admin_enqueue_scripts', array($this, 'load_custom_admin_scripts'));
        add_action('wp_enqueue_scripts',  array($this,'load_custom_scripts'));

        add_action('woocommerce_api_wc_gateway_przelewy24', array($this, 'przelewy24_response'));

        /* This function is to be called at the end of this constructor. */
        $this->plugin_core->after_main_gateway_initiation();
    }

    /**
     * Get active currency.
     *
     * @return string
     */
    private function get_active_currency() {
        if ( ! $this->active_currency ) {
            $this->active_currency = get_woocommerce_currency();
            if ( is_admin() ) {
                $this->active_currency = apply_filters( 'przelewy24_multi_currency_admin_currency', $this->active_currency );
            }
        }
        return $this->active_currency;
    }

    /**
     * Get kay of option record from database.
     *
     * It is different for each currency.
     *
     * @param null|string $for_currency
     *
     * @return string
     */
    public function get_option_key( $for_currency = null ) {
        if ( !$for_currency ) {
            $for_currency = $this->get_active_currency();
        }
        $code = strtolower( $for_currency );
        return $this->plugin_id . $this->id . '_' . $code . '_settings';
    }

    /**
     * Set other variables based on updated settings.
     */
    private function propagate_settings()
    {
        $this->enabled = ! empty( $this->settings['enabled'] ) && 'yes' === $this->settings['enabled'] ? 'yes' : 'no';
    }

    /**
     * Init settings.
     *
     * There is one record for each currency and one common.
     * For new currency, copy data from default one.
     */
    public function init_settings()
    {
        $this->settings = $this->load_settings_form_db();
        $this->settings['alt_nonce'] = wp_create_nonce('p24_action');
        $common_settings = get_option( P24_Request_Support::OPTION_KEY_COMMON, [] );
        $this->common_settings_keys = array_unique( array_merge( array_keys( $common_settings ), $this->common_settings_keys ) );
        $this->settings = $common_settings + $this->settings;
        $this->propagate_settings();
    }

    /**
     * Get config for currency in array.
     *
     * @param null|string $for_currency The currency.
     * @return array
     */
    public function load_settings_form_db( $for_currency = null ) {
        if ( ! $for_currency ) {
            $for_currency = $this->get_active_currency();
        }
        $option_key = $this->get_option_key( $for_currency );
        $settings = get_option( $option_key, null );
        if ( ! is_array( $settings ) && $for_currency === $this->plugin_core->get_default_currency() ) {
            /* Try import legacy config. */
            $alt_key = parent::get_option_key();
            $settings = get_option( $alt_key, null );
            if ( ! isset( $settings['sub_enabled'] ) && isset( $settings['enabled'] ) ) {
                $settings['sub_enabled'] = $settings['enabled'];
            }
        }
        if ( ! is_array( $settings ) ) {
            $form_fields    = $this->get_form_fields();
            $settings = array_merge( array_fill_keys( array_keys( $form_fields ), '' ), wp_list_pluck( $form_fields, 'default' ) );
        }
        return $settings;
    }

    /**
     * Get config for currency in object.
     *
     * @param null|string $for_currency
     * @return P24_Config_Accessor
     */
    public function load_settings_from_db_formatted( $for_currency = null ) {
        if ( ! $for_currency ) {
            $for_currency = $this->get_active_currency();
        }
        $array = $this->load_settings_form_db( $for_currency );
        $config_holder = P24_Settings_Helper::map_array_to_config_holder( $array );
        return new P24_Config_Accessor( $for_currency, $config_holder );
    }

    /**
     * Get config for currency from sanitized fields.
     *
     * @param null|string $for_currency
     * @return P24_Config_Accessor
     */
    private function get_settings_from_sanitized_formatted( $for_currency = null ) {
        if ( ! $for_currency ) {
            $for_currency = $this->get_active_currency();
        }
        $config_holder = P24_Settings_Helper::map_array_to_config_holder( $this->sanitized_fields );
        return new P24_Config_Accessor( $for_currency, $config_holder );
    }

    /**
     * Get config for currency from internal configuration.
     *
     * @param null|string $for_currency
     * @param bool $ignore_api
     * @return P24_Config_Accessor
     */
    public function get_settings_from_internal_formatted($for_currency = null, $ignore_api = false) {
        if ( ! $for_currency ) {
            $for_currency = $this->get_active_currency();
        }
        $config_holder = new P24_Config_Holder();
        $config_holder->merchant_id = $this->merchant_id;
        $config_holder->shop_id = $this->shop_id;
        $config_holder->salt = $this->salt;
        $config_holder->p24_operation_mode = $this->p24_testmod;
        $config_holder->p24_oneclick = $this->p24_oneclick;
        if (!$ignore_api) {
            $config_holder->p24_api = $this->p24_api;
        }
        return new P24_Config_Accessor( $for_currency, $config_holder );
    }

    /**
     * Update one option in database.
     *
     * There are two records in database.
     * Each record hold an serialized array.
     * The option may be in one of these arrays.
     *
     * The parent method is overwritten.
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public function update_option($key, $value = '')
    {
        if ( empty( $this->settings ) ) {
            $this->init_settings();
        }
        $this->settings[ $key ] = $value;
        $this->propagate_settings();

        $options = apply_filters( 'woocommerce_settings_api_sanitized_fields_' . $this->id, $this->settings );
        if ( in_array( $key, $this->common_settings_keys ) ) {
            $options = array_intersect_key( $options, array_flip( $this->common_settings_keys ) );
            $options_key = P24_Request_Support::OPTION_KEY_COMMON;
        } else {
            $options = array_diff_key( $options, array_flip( $this->common_settings_keys ) );
            $options_key = $this->get_option_key();
        }
        return update_option( $options_key, $options, 'yes' );
    }

    /**
     * Return if gateway is available for selected currency.
     *
     * @return bool
     */
    public function is_available()
    {
        if ( empty( $this->settings ) ) {
            $this->init_settings();
        }
        $is_available = parent::is_available();
        if ( ! array_key_exists( 'sub_enabled', $this->settings ) ) {
            $is_available = false;
        } elseif ( $this->settings[ 'sub_enabled' ] !== 'yes' ) {
            $is_available = false;
        }
        return $is_available;
    }

    /**
     * Validate text fields.
     *
     * This method works for hidden fields too.
     * We have to propagate hack for checkbox.
     *
     * @param string $key Name of fields.
     * @param string $value Value of field.
     *
     * @return string
     */
    public function validate_text_field( $key, $value ) {
        if ( $key === 'sub_enabled' ) {
            return $value ? 'yes' : 'no';
        } else {
            return parent::validate_text_field( $key, $value );
        }
    }

    /**
     * Returns the POSTed data, to be used to save the settings.
     *
     * @return array
     */
    public function get_post_data()
    {
        $post = parent::get_post_data();
        $key = $this->get_field_key( 'active_currency' );
        if ( array_key_exists( $key, $post ) ) {
            $this->active_currency = $post[$key];
        }
        return $post;
    }

    /**
     * Generate Settings HTML.
     *
     * Generate the HTML for the fields on the "settings" screen.
     *
     * @param array $form_fields (default: array()) Array of form fields.
     * @param bool  $echo Echo or return.
     * @return string|null The html for the settings or nothing.
     */
    public function generate_settings_html( $form_fields = array(), $echo = true ) {
        if ( empty( $form_fields ) ) {
            $form_fields = $this->get_form_fields();
        }
        $core = get_przelewy24_plugin_instance();
        $mc   = $core->get_any_active_mc();
        if ( $mc->is_multi_currency_active() ) {
            $this->settings['active_currency'] = $this->get_active_currency();
            $prefix = array(
                'active_currency' => array(
                    'title' => __('Aktywna waluta', 'przelewy24'),
                    'type' => 'select',
                    'options' => get_przelewy24_multi_currency_options(),
                    'class' => 'js_currency_admin_selector',
                    'default' => 'PLN'
                ),
                'alt_nonce' => array(
                    'type' => 'hidden',
                    'class' => 'js-p24-alt-nonce',
                )
            );
            $form_fields = $prefix + $form_fields;
            $form_fields['sub_enabled']['type'] = 'checkbox';
            $form_fields['sub_enabled']['title'] = __('Włącz/Wyłącz', 'przelewy24');
        }
        return parent::generate_settings_html( $form_fields, $echo );
    }

    /**
     * Load scripts for webpage.
     */
    function load_custom_scripts()
    {
        if ( empty( $this->settings ) ) {
            $this->init_settings();
        }
        $is_one_click_enabled = ( isset( $this->settings['p24_oneclick'] ) && 'yes' === $this->settings['p24_oneclick'] );
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-blockui');
        wp_enqueue_style('p24_plugin_css', $this->getCssUrl());
        wp_enqueue_style('p24_css', $this->get_bank_dependant_css_url());
        wp_enqueue_script('p24_payment_script', $this->getJsUrl(), array(), P24_Core::SCRIPTS_VERSION);
        wp_localize_script('p24_payment_script', 'p24_payment_php_vars', array(
                'error_msg4js' => __('Wystąpił błąd. Spróbuj ponownie lub wybierz inną metodę płatności.', 'przelewy24'),
                'payments_msg4js' => '\f078'.__('więcej metod płatności','przelewy24').' \f078',
                'forget_card' => self::get_cc_forget(get_current_user_id()),
                'show_save_card' => (int) ( is_user_logged_in() && $is_one_click_enabled ),
            )
        );
    }

    /**
     *
     */
    function load_custom_admin_scripts($hook)
    {
        if (empty($_REQUEST['section']) || 'woocommerce_page_wc-settings' != $hook || strpos($_REQUEST['section'], 'przelewy24') === false) {
            return;
        }
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-blockui');
        wp_enqueue_style('p24_plugin_css', PRZELEWY24_URI . 'assets/css/paymethods.css');
        wp_enqueue_style('p24_css', $this->get_bank_dependant_css_url());
        wp_enqueue_script('p24_payment_script', PRZELEWY24_URI . 'assets/js/admin.js');
        wp_localize_script('p24_payment_script', 'p24_payment_script_vars', array(
                'php_msg1' => __('Metody płatności widoczne od razu - upuść tutaj max. 5 metod płatności:','przelewy24'),
                'php_msg2' => __('Metody płatności widoczne po kliknięciu przycisku (więcej...):','przelewy24'),
                'php_msg3' => __('Wyróżnione metody płatności:','przelewy24'),
                'php_msg4' => __('Metody płatności możliwe do wyróżnienia:','przelewy24'),
            )
        );
    }

    /**
     * Returns url to css file with styles for bank logos and payment methods previews.
     *
     * @return string
     */
    private function get_bank_dependant_css_url() {
        return Przelewy24Class::getHostStatic( false ) . 'skrypty/ecommerce_plugin.css.php';
    }

    function init_form_fields()
    {
        $this->form_fields = array(
            'enabled' => array(
                'title' => __('Włącz/Wyłącz', 'przelewy24'),
                'type' => 'checkbox',
                'label' => __('Aktywuj moduł płatności Przelewy24.', 'przelewy24'),
                'default' => 'no'),
            'sub_enabled' => array(
                'type' => 'hidden',
                'label' => __('Aktywuj moduł płatności Przelewy24 dla danej waluty.', 'przelewy24'),
                'default' => 'yes'),
            'title' => array(
                'title' => __('Tytuł:', 'przelewy24'),
                'type' => 'text',
                'description' => __('Tekst który zobaczą klienci podczas dokonywania zakupu', 'przelewy24'),
                'default' => __('Przelewy24', 'przelewy24')),
            'merchant_id' => array(
                'title' => __('ID Sprzedawcy', 'przelewy24'),
                'type' => 'text',
                'description' => __('Identyfikator sprzedawcy nadany w systemie Przelewy24.', 'przelewy24'),
                'default' => 0,
                'required' => true),
            'shop_id' => array(
                'title' => __('ID Sklepu', 'przelewy24'),
                'type' => 'text',
                'description' => __('Identyfikator sklepu nadany w systemie Przelewy24.', 'przelewy24'),
                'default' => 0,
                'required' => true),
            'CRC_key' => array(
                'title' => __('Klucz CRC', 'przelewy24'),
                'type' => 'text',
                'description' => __('Klucz do CRC nadany w systemie Przelewy24.', 'przelewy24'),
                'placeholder' => __('(16 znaków)', 'przelewy24'),
                'required' => true),
            'p24_testmod' => array(
                'title' => __('Tryb modułu', 'przelewy24'),
                'type' => 'select',
                'options' => $this->get_options(),
                'description' => __('Tryb przeprowadzania transakcji', 'przelewy24')),
            'description' => array(
                'title' => __('Opis', 'przelewy24'),
                'type' => 'textarea',
                'description' => __('Tekst który zobaczą klienci przy wyborze metody płatności', 'przelewy24'),
                'default' => __('Płać z Przelewy24', 'przelewy24')),
            'p24_api' => array(
                'title' => __('Klucz API','przelewy24'),
                'type' => 'text',
                'description' => __('Klucz API należy pobrać z panelu Przelewy24 z zakładki Moje dane','przelewy24'),
                'placeholder' => __('(32 znaki)','przelewy24')),
            'p24_paymethods_super_first' => array(
                'type' => 'text',
                'title' => __('Wyróżnione metody płatności','przelewy24'),
                'default' => ''
            ),
            'p24_oneclick' => array(
                'title' => __('Oneclick','przelewy24'),
                'type' => 'checkbox',
                'label' => __('Aktywuj płatności oneclick','przelewy24'),
                'default' => 'no'),
            'p24_payinshop' => array(
                'title' => __('Płatność w sklepie','przelewy24'),
                'type' => 'checkbox',
                'label' => __('Płatność wewnątrz sklepu (kartą, poprzez BLIK)','przelewy24'),
                'default' => 'no'),
            'p24_acceptinshop' => array(
                'title' => __('Akceptacja regulaminu Przelewy24.pl','przelewy24'),
                'type' => 'checkbox',
                'label' => __('Akceptacja regulaminu Przelewy24.pl','przelewy24'),
                'default' => 'no'),
            'p24_paymethods' => array(
                'type' => 'checkbox',
                'title' => __('Pokaż metody płatności','przelewy24'),
                'label' => __('Pokaż dostępne metody płatności w sklepie','przelewy24'),
                'description' => __('Klient może wybrać metodę płatności na stronie potwierdzenia zamówienia','przelewy24'),
                'default' => 'no'),
            'p24_graphics' => array(
                'type' => 'checkbox',
                'label' => __('Użyj graficznej listy metod płatności na stronie potwierdzenia zamówienia','przelewy24'),
                'default' => 'yes'),
            'p24_paymethods_first' => array(
                'type' => 'text',
                'title' => __('Widoczne metody płatności','przelewy24'),
                'default' => '25,31,112,20,65'
            ),
            'p24_paymethods_second' => array(
                'type' => 'text',
                'title' => '',
                'default' => ''),
            'p24_paymethods_all' => array(
                'type' => 'select',
                'options' => $this->get_all_payment_methods(),
                'default' => 0),
            'p24_wait_for_result' => array(
                'type' => 'checkbox',
                'title' => __('Czekaj na wynik transakcji', 'przelewy24'),
                'label' => ' ',
                'default' => 'no'
            ),
            'p24_use_special_status' => array(
                'type' => 'checkbox',
                'title' => __('Użyj statusów Przelewy24', 'przelewy24'),
                'label' => ' ',
                'default' => 'no'
            ),
            'p24_custom_pending_status' => array(
                'type' => 'select',
                'title' => __('Status dla zamówień ocekujacych na płatność', 'przelewy24'),
                'label' => ' ',
                'default' => '',
                'options' => P24_Status_Provider::cet_config_for_select(),
            ),
            'p24_custom_processing_status' => array(
                'type' => 'select',
                'title' => __('Status dla zamówień opłaconych', 'przelewy24'),
                'label' => ' ',
                'default' => '',
                'options' => P24_Status_Provider::cet_config_for_select(),
            ),
            'p24_add_to_alternative_method' => array(
                'type' => 'checkbox',
                'title' => __('Dodaj P24NOW do listy płatności', 'przelewy24'),
                'label' =>   '<a href="https://www.p24now.pl/" target="_blank">Czym jest P24NOW?</a>',
                'default' => 'yes',
            ),
            'p24_custom_promote_p24' => array(
                'type' => 'checkbox',
                'title' => __('Promuj P24NOW', 'przelewy24'),
                'default' => 'yes',
                'label' =>   '<a href="https://www.p24now.pl/" target="_blank">Czym jest P24NOW?</a>',
            ),
        );
    }

    /**
     * @param bool $pay_slow
     *
     * @return array
     */
    public function get_all_payment_methods($pay_slow = false)
    {
        $config_accessor = $this->load_settings_from_db_formatted();
        $P24 = new Przelewy24Class($config_accessor);
        $all = $P24->availablePaymentMethodsSimple($pay_slow, $this->get_active_currency());
        return $all;
    }

    public function validate_payment_methods_status($key)
    {
        $keyVal = "0";
        if (isset($_POST[$this->plugin_id . $this->id . '_' . $key])) {
            $keyVal = $_POST[$this->plugin_id . $this->id . '_' . $key];
            if ($keyVal) {
                try {
                    $is_test_mode = $this->sanitized_fields['p24_testmod'] === 'sandbox';
                    $address = Przelewy24Class::getHostStatic($is_test_mode) . 'external/' . $this->sanitized_fields['merchant_id'] . '.wsdl';
                    $client = new SoapClient($address, array('trace' => true, 'exceptions' => true));
                    if (!$client->PaymentMethods($this->sanitized_fields['merchant_id'], $this->sanitized_fields['p24_api'], 'PL')) {
                        throw new Exception();
                    }
                } catch (Exception $ex) {
                    error_log(__METHOD__ . ' ' . $ex->getMessage());
                    $_POST[$this->plugin_id . $this->id . '_' . $key] = "0";
                    $this->add_error(__("Usługa PaymentMethods nie jest włączona dla tego sprzedawcy.",'przelewy24'));
                    return "no";
                }
            }
        }
        return $keyVal ? "yes" : "no";
    }

    /**
     * @param $key
     * @param $error
     * @return string
     */
    public function validate_id($key, $error)
    {

        $ret = $this->get_option($key);
        $valid = false;
        if (isset($_POST[$this->plugin_id . $this->id . '_' . $key])) {
            $ret = $_POST[$this->plugin_id . $this->id . '_' . $key];
            if (is_numeric($ret) && $ret >= 1000) $valid = true;
        }
        if (!$valid) $this->errors[$key] = $error;
        return $ret;
    }

    /**
     * @param $key
     * @return string
     */
    public function validate_crc($key)
    {
        $ret = $this->get_option($key);
        $valid = false;
        if (isset($_POST[$this->plugin_id . $this->id . '_' . $key])) {
            $ret = $_POST[$this->plugin_id . $this->id . '_' . $key];
            if (strlen($ret) == 16 && ctype_xdigit($ret)) $valid = true;
        }
        if (!$valid) $this->errors[$key] = __('Klucz do CRC powinien mieć 16 znaków.', 'przelewy24');
        return $ret;
    }

    /**
     * @param string $key
     * @param null $empty_value
     * @return string
     */
    public function get_option($key, $empty_value = null)
    {
        if (isset($this->sanitized_fields[$key])) {
            return $this->sanitized_fields[$key];
        }
        return parent::get_option($key, $empty_value);
    }

	/**
	 * Display errors.
	 */
	public function display_errors() {
		foreach ( $this->errors as $v ) {
			WC_Admin_Settings::add_error(
				__( 'Błąd', 'przelewy24' ) . ': ' . filter_var( $v, FILTER_SANITIZE_STRING )
			);
		}
	}

    /**
     * @param string $error
     */
    public function add_error($error)
    {
        if (!in_array($error, $this->errors)) {
            parent::add_error($error);
        }
    }

    /**
     * Update options from admin panel.
     *
     * The parent method is overwritten.
     */
    public function process_admin_options()
    {
       $this->init_settings();
       $post_data = $this->get_post_data();
       foreach ( $this->get_form_fields() as $key => $field ) {
          if ( 'title' !== $this->get_field_type( $field ) ) {
             try {
                $this->settings[ $key ] = $this->get_field_value( $key, $field, $post_data );
             } catch ( Exception $e ) {
                $this->add_error( $e->getMessage() );
             }
          }
       }

       $options =  apply_filters( 'woocommerce_settings_api_sanitized_fields_' . $this->id, $this->settings );
       $common_options =  array_intersect_key( $options, array_flip( $this->common_settings_keys ) );
       $currency_options = array_diff_key( $options, array_flip( $this->common_settings_keys ) );
       update_option( P24_Request_Support::OPTION_KEY_COMMON, $common_options, 'yes' );
       update_option( $this->get_option_key(), $currency_options, 'yes' );

        $this->validate_fields( true );
        if (!empty($this->errors)) {
            $this->display_errors();
        }
    }

    /**
     * @param bool $processing_admin_options
     * @throws Exception
     * @return bool|void
     */
    public function validate_fields( $processing_admin_options = false )
    {
        if ( $processing_admin_options ) {
            $this->sanitized_fields['p24_testmod'] = $_POST[ $this->plugin_id . $this->id . '_p24_testmod' ] == 'secure' ? 'secure' : 'sandbox';
            $this->sanitized_fields['p24_api'] = $_POST[ $this->plugin_id . $this->id . '_p24_api' ];
        }

        $this->sanitized_fields['merchant_id'] = $this->validate_id('merchant_id', __('Błędny ID Sprzedawcy.', 'przelewy24'));
        $this->sanitized_fields['shop_id'] = $this->validate_id('shop_id', __('Błędny ID Sklepu.', 'przelewy24'));
        $this->sanitized_fields['CRC_key'] = $this->validate_crc('CRC_key');
        $this->sanitized_fields['p24_paymethods'] = $this->validate_payment_methods_status('p24_paymethods');

        $config_accessor = $this->get_settings_from_sanitized_formatted();
        $P24 = new Przelewy24Class($config_accessor);
        $ret = $P24->testConnection();
        /* The HTTP force variables to be strings. */
        if (!isset($ret['error']) || $ret['error'] !== '0') {
            $this->errors['p24_testmod'] = __('Błędny ID Sklepu, Sprzedawcy lub Klucz do CRC dla tego trybu pracy wtyczki.', 'przelewy24');
        }

        if (!empty($this->sanitized_fields['p24_api'])) {
            $ret = $P24->apiTestAccess();
            if (!$ret)
                $this->errors['p24_testmod'] = __('Błędny klucz API dla tego ID Sklepu, Sprzedawcy lub trybu pracy wtyczki.','przelewy24');
        }

        $pending = $_POST[ $this->plugin_id . $this->id . '_p24_custom_pending_status' ];
        $processing = $_POST[ $this->plugin_id . $this->id . '_p24_custom_processing_status' ];
        if (!P24_Status_Decorator::validate_statuses($pending, $processing)) {
            $this->errors['p24_statuses'] = __('Ustawione statusy dla zamówień muszą się różnić.','przelewy24');
        }

        $_SESSION['P24'] = $this->sanitized_fields;
    }

    public function admin_options()
    {
        echo '<h3>' . __('Bramka płatności Przelewy24','przelewy24') . '</h3>';
        echo '<table class="form-table">';
        // Generate the HTML For the settings form.
        $this->generate_settings_html();
        echo '</table>';

        $config_holder = P24_Settings_Helper::map_array_to_config_holder( $this->settings );
        $config_holder->p24_api = $this->p24_api;
        $config_accessor = new P24_Config_Accessor($this->get_active_currency(), $config_holder);
        $P24 = new Przelewy24Class($config_accessor);

        if (!$P24->apiTestAccess()) {
            echo '<input type="hidden" id="p24_no_api_key_provided">';
        }
    }

    /**
     * Receipt Page
     **/
    function receipt_page($order)
    {
        global $woocommerce;

        $config = $this->settings;

        $orderObj = new WC_Order($order);

        if (!empty($_POST['p24_cc']) && !empty($_POST['p24_session_id'])) {
            $ra = isset($_POST['p24_regulation_accept']) ? (bool)$_POST['p24_regulation_accept'] : false;
            $ok = $this->chargeCard($orderObj, $_POST['p24_cc'], $ra);

            if (!$ok) {
                //Sorry your transaction did not go through successfully, please try again.
                $this->addNotice(
                    $woocommerce,
                    __('Błąd płatności: ', 'przelewy24') . __('Przepraszamy, ale twoja transakcja nie została przeprowadzona pomyślnie, prosimy spróbować ponownie.', 'przelewy24'),
                    'error'
                );
                wp_redirect($orderObj->get_cancel_order_url_raw());
                error_log(__METHOD__ . ' :(');
            }
        }

        if (!empty($this->p24_api) && $config['p24_paymethods'] == 'yes') {

            $paymethod_all = $this->get_all_payment_methods();

            if(!$this->is_P24NOW_available($this->get_order_total(), get_woocommerce_currency())){
                unset($paymethod_all[266]);
            }

            // usunięcie rat gdy koszyk poniżej kwoty
            if (is_array($paymethod_all) && get_woocommerce_currency() == 'PLN' && $this->get_order_total() < Przelewy24Class::getMinRatyAmount()) {
                $raty = Przelewy24Class::getChannelsRaty();
                foreach ($paymethod_all as $key => $item) {
                    if (in_array($key, $raty)) {
                        unset($paymethod_all[$key]);
                    }
                }
            }

            if (isset($_POST['act']) && $_POST['act'] == 'cardrm' && isset($_POST['cardrm']) && (int)$_POST['cardrm'] > 0) {
                self::del_card(get_current_user_id(), (int)$_POST['cardrm']);
            }

            if (!empty($_POST['p24_cc']) && !empty($_POST['p24_session_id'])) {
                $ra = isset($_POST['p24_regulation_accept']) ? (bool)$_POST['p24_regulation_accept'] : false;
                $ok = $this->chargeCard($orderObj, $_POST['p24_cc'], $ra);

                if (!$ok) {
                    //Sorry your transaction did not go through successfully, please try again.
                    $this->addNotice(
                        $woocommerce,
                        __('Błąd płatności: ', 'przelewy24') . __('Przepraszamy, ale twoja transakcja nie została przeprowadzona pomyślnie, prosimy spróbować ponownie.', 'przelewy24'),
                        'error'
                    );

                    wp_redirect($orderObj->get_cancel_order_url_raw());
                    error_log(__METHOD__ . ' :(');
                }
            }

            $paymethod_first = explode(',', $config['p24_paymethods_first']);
            $paymethod_second = explode(',', $config['p24_paymethods_second']);
            $ccards = $this->get_all_custom_data('user_cards', get_current_user_id());
            $last_method = (int)$this->get_custom_data('user', get_current_user_id(), 'lastmethod');

            $makeUnfold = false;

            $ignore_array = array();
            echo '<ul id="p24-bank-grid">';
            if ($config['p24_graphics'] == 'yes') {
                // P24NOW is promoted
                if($config['p24_custom_promote_p24'] === 'yes' && isset($paymethod_all[266])){
                    if($this->is_P24NOW_available($orderObj->get_total(), $orderObj->get_currency())){
                        echo Przelewy24Helpers::getPayNowHtml(266, $paymethod_all[266]);
                    }
                    $ignore_array[] = 266;
                }
                // lista graficzna
                if ($config['p24_custom_promote_p24']) {
                    if (isset($paymethod_all[$last_method])) {
                        $makeUnfold = true;
                        $ignore_array[] = $last_method;
                        echo Przelewy24Helpers::getBankHtml($last_method, __('Ostatnio używane', 'przelewy24'));
                    }
                }

                // ostatnia metoda płatności
                if ($last_method > 0 && !in_array($last_method, Przelewy24Class::getChannelsCard())) {
                    if (isset($paymethod_all[$last_method])) {
                        $makeUnfold = true;
                        $ignore_array[] = $last_method;
                        echo Przelewy24Helpers::getBankHtml($last_method, __('Ostatnio używane', 'przelewy24'));
                    }
                }

                // recuring
                if (is_array($ccards) && sizeof($ccards)) {
                    foreach ($ccards as $card) {
                        $makeUnfold = true;
                        echo Przelewy24Helpers::getBankHtml(md5($card->custom_value['type']), $card->custom_value['type'], substr($card->custom_value['mask'], -9), $card->id, 'recurring');
                    }
                }

                // wyróżnione metody
                foreach ($paymethod_first as $bank_id) {
                    if (isset($paymethod_all[$bank_id]) && !in_array($bank_id, $ignore_array)) {
                        $makeUnfold = true;
                        $ignore_array[] = $bank_id;
                        $onclick = '';
                        if (in_array($bank_id, Przelewy24Class::getChannelsCard()) && $config['p24_payinshop'] == 'yes') {
                            $onclick = 'showPayJsPopup()';
                        }
                        echo Przelewy24Helpers::getBankHtml($bank_id, $paymethod_all[$bank_id], '', '', '', $onclick);
                    }
                }

                echo "<div style='clear:both'></div>";
                echo '<div class="morePayMethods" style="' . ($makeUnfold ? 'display: none' : '') . '">';
                // pozostałe metody płatności
                foreach ($paymethod_second as $bank_id) {
                    if (isset($paymethod_all[$bank_id]) && !in_array($bank_id, $ignore_array)) {
                        $ignore_array[] = $bank_id;
                        $onclick = '';
                        if (in_array($bank_id, Przelewy24Class::getChannelsCard()) && $config['p24_payinshop'] == 'yes') {
                            $onclick = 'showPayJsPopup()';
                        }
                        echo Przelewy24Helpers::getBankHtml($bank_id, $paymethod_all[$bank_id], '', '', '', $onclick);
                    }
                }

                if ( ! isset( $paymethod_all ) || ! is_array( $paymethod_all ) ) {
                    $paymethod_all = array();
                }
                // metody nieuwględnione w konfiguracji (np nowe)
                foreach ($paymethod_all as $bank_id => $bank_name) {
                    if (!in_array($bank_id, $paymethod_first) && !in_array($bank_id, $ignore_array)) {
                        $ignore_array[] = $bank_id;
                        $onclick = '';
                        if (in_array($bank_id, Przelewy24Class::getChannelsCard()) && $config['p24_payinshop'] == 'yes') {
                            $onclick = 'showPayJsPopup()';
                        }
                        echo Przelewy24Helpers::getBankHtml($bank_id, $paymethod_all[$bank_id], '', '', '', $onclick);
                    }
                }
                echo "<div style='clear:both'></div>";
                echo '</div>';
            } else {
                // lista tekstowa
                $checkedCounter = 0;
                if ($config['p24_custom_promote_p24']) {
                    $onclick = (in_array(266, Przelewy24Class::getChannelsCard()) && $config['p24_payinshop'] == 'yes')
                        ?'showPayJsPopup()'
                        :'';
                    if($this->is_P24NOW_available($orderObj->get_total(), $orderObj->get_currency())){
                        echo Przelewy24Helpers::getBankTxt($checkedCounter, 266, $paymethod_all[266], '', '', '', $onclick);
                    }
                    $ignore_array[] = 266;
                }

                // wyróżnione metody
                foreach ($paymethod_first as $bank_id) {
                    if (isset($paymethod_all[$bank_id]) && !in_array($bank_id, $ignore_array)) {
                        $makeUnfold = true;
                        $ignore_array[] = $bank_id;
                        $onclick = '';
                        if (in_array($bank_id, Przelewy24Class::getChannelsCard()) && $config['p24_payinshop'] == 'yes') {
                            $onclick = 'showPayJsPopup()';
                        }
                        echo Przelewy24Helpers::getBankTxt($checkedCounter, $bank_id, $paymethod_all[$bank_id], '', '', '', $onclick);
                    }
                }
                echo "<div style='clear:both'></div>";
                echo '<div class="morePayMethods" style="' . ($makeUnfold ? 'display: none' : '') . '">';
                // pozostałe metody płatności
                foreach ($paymethod_second as $bank_id) {
                    if (isset($paymethod_all[$bank_id]) && !in_array($bank_id, $ignore_array)) {
                        $ignore_array[] = $bank_id;
                        $onclick = '';
                        if (in_array($bank_id, Przelewy24Class::getChannelsCard()) && $config['p24_payinshop'] == 'yes') {
                            $onclick = 'showPayJsPopup()';
                        }
                        echo Przelewy24Helpers::getBankTxt($checkedCounter, $bank_id, $paymethod_all[$bank_id], '', '', '', $onclick);
                    }
                }

                // metody nieuwględnione w konfiguracji (np nowe)
                foreach ($paymethod_all as $bank_id => $bank_name) {
                    if (!in_array($bank_id, $paymethod_first) && !in_array($bank_id, $ignore_array)) {
                        $ignore_array[] = $bank_id;
                        $onclick = '';
                        if (in_array($bank_id, Przelewy24Class::getChannelsCard()) && $config['p24_payinshop'] == 'yes') {
                            $onclick = 'showPayJsPopup()';
                        }
                        echo Przelewy24Helpers::getBankTxt($checkedCounter, $bank_id, $paymethod_all[$bank_id], '', '', '', $onclick);
                    }
                }
                echo "<div style='clear:both'></div>";
                echo '</div>';
            }

                if ($makeUnfold) {
                    echo '<div class="moreStuff" onclick="jQuery(this).fadeOut(100);jQuery(\'.morePayMethods\').slideDown()" title="' . __('Pokaż więcej metod płatności.', 'przelewy24') . '"></div>';
                    $payments_msg4js = '↓ ' . __('więcej metod płatności', 'przelewy24') . ' ↓';
                }
                echo '</ul>';

            if ($config['p24_payinshop'] == 'yes') {
                $p24_ajax_url = add_query_arg(array('wc-api' => 'WC_Gateway_Przelewy24'), home_url('/'));
                $translate = array(
                    'name' => __('Imię i nazwisko','przelewy24'),
                    'nr' => __('Numer karty','przelewy24'),
                    'cvv' => __('CVV','przelewy24'),
                    'dt' => __('Data ważności','przelewy24'),
                    'pay' => __('Zapłać','przelewy24'),
                    '3ds' => __('Kliknij tutaj aby kontynuować zakupy','przelewy24'),
                    'registerCardLabel' => __('Zapisz kartę','przelewy24'),
                    'description' => __('Zarejestruj i zapłać','przelewy24'),
                );
                $myAccountLink = get_permalink(get_option('woocommerce_myaccount_page_id'));
                echo <<<HTML
                    <span id="p24-link-to-my-account" data-link="{$myAccountLink}"></span>
                    <div id="P24FormAreaHolder" onclick="hidePayJsPopup();" style="display: none"><div onclick="arguments[0].stopPropagation();" id="P24FormArea" class="popup"></div></div>
                    <input type="hidden" id="p24_ajax_url" value="{$p24_ajax_url}">
                    <input type="hidden" id="p24_dictionary" value='{"registerCardLabel":"{$translate['registerCardLabel']}","description":"{$translate['description']}", "cardHolderLabel":"{$translate['name']}", "cardNumberLabel":"{$translate['nr']}", "cvvLabel":"{$translate['cvv']}", "expDateLabel":"{$translate['dt']}", "payButtonCaption":"{$translate['pay']}", "threeDSAuthMessage":"{$translate['3ds']}"}'>
                    <input type="hidden" id="p24_woo_order_id" value='{$order}'>
                    <form method="post" id="cardrm">
                        <input type="hidden" name="act" value="cardrm">
                        <input type="hidden" name="cardrm">
                    </form>
HTML;
                echo P24_Blik_Html::get_modal_html();

            }
            echo $this->generator->generate_przelewy24_form($order, false, $config['p24_oneclick'] == 'yes' && is_array($ccards) && sizeof($ccards));

        } else {
            echo $this->generator->generate_przelewy24_form($order, true);
        }
    }

    /**
     * Process the payment and return the result
     **/
    function process_payment($order_id)
    {
        $order = new WC_Order($order_id);
        /* This is the default place to reduce stock levels. */
        /* It is safe to call function below multiple times. */
        wc_maybe_reduce_stock_levels($order);
        $order->update_meta_data(P24_Core::CHOSEN_TIMESTAMP_META_KEY, time());
        $order->save_meta_data();
        do_action('wc_gateway_przelewy24_process_payment', $order);

        return array('result' => 'success', 'redirect' => $order->get_checkout_payment_url($order));
    }

    /**
     * @param string $session_id Session id taken from P24 API.
     *
     * @throws SoapFault Soap fault exception.
     *
     * @return mixed
     */
    private function get_transaction_data_from_p24( $session_id ) {
        $soap = $this->getSoapClient();

        try {
            return $soap->GetTransactionBySessionId(
                $this->merchant_id,
                $this->p24_api,
                $session_id
            );
        } catch ( Exception $e ) {
            return false;
        }
    }

    /**
     * @param int        $order_id WC Order Id.
     * @param float|null $amount Order amount.
     * @param string     $reason Reason of refund.
     *
     * @throws SoapFault
     * @return bool|WP_Error
     */
    public function process_refund( $order_id, $amount = null, $reason = '' ) {
        $order = new WC_Order( $order_id );

        if ( ! $this->can_refund_order( $order ) ) {
            return new WP_Error( 'error', __( 'Refund failed.', 'woocommerce' ) );
        }

        $session_id = $order->get_meta(
            P24_Core::ORDER_SESSION_ID_KEY,
            true
        );

        $transaction_data = $this->get_transaction_data_from_p24( $session_id );

        if ( empty( $transaction_data->result->status ) || 2 !== $transaction_data->result->status || 0 !== $transaction_data->error->errorCode ) {
            return new WP_Error( 'error', __( 'Refund failed.', 'woocommerce' ) );
        }

        $refunds = array(
            array(
                'sessionId' => $session_id,
                'orderId'   => $transaction_data->result->orderId,
                'amount'    => P24_Core::convert_stringified_float_to_cents( $amount ),
            ),
        );

        $soap = $this->getSoapClient();

        try {
            $p24_response = $soap->RefundTransaction(
                $this->merchant_id,
                $this->p24_api,
                time(),
                $refunds
            );

            if ( ! empty( $p24_response->error->errorCode ) ) {
                return new WP_Error( 'error', __( 'Return failed.', 'woocommerce' ) );
            }
        } catch ( Exception $e ) {
            return new WP_Error( 'error', __( 'Refund failed.', 'woocommerce' ) );
        }

        return true;
    }

    /**
     * /*Check przelewy24 response
     **/
    function przelewy24_response()
    {
        global $wpdb;
        global $woocommerce;

        if (isset($_POST['p24_session_id']) && isset($_POST['action']) && $_POST['action'] === 'trnRegister' && isset($_POST['order_id'])) {
            $config_accessor = $this->get_settings_from_internal_formatted(null, true);
            $P24C = new Przelewy24Class($config_accessor);
            $post_data = $this->generator->generate_fields_array($_POST['order_id'], $_POST['p24_session_id']);
            foreach ($post_data as $k => $v) {
                $P24C->addValue($k, $v);
            }
            $token = $P24C->trnRegister();
            if (is_array($token)) {
                $token = $token['token'];
                exit(json_encode(array(
                    'p24jsURL' => $P24C->getHost() . 'inchtml/card/register_card_and_pay/ajax.js?token=' . $token,
                    'p24cssURL' => $P24C->getHost() . 'inchtml/card/register_card_and_pay/ajax.css',
                    'token' => $token,
                    'p24_sign' => $post_data['p24_sign'],
                    'sessionId' => $post_data['p24_session_id'],
                    'client_id' => get_current_user_id(),
                )));
            }

            exit();
        } elseif (
            isset($_POST['action']) &&
            $_POST['action'] === 'executePaymentByBlikCode' &&
            isset($_POST['token']) &&
            isset($_POST['blikCode'])
        ) {
            $config_accessor = $this->get_settings_from_internal_formatted(null, false);
            $soap_blik = new P24_Soap_Blik($config_accessor);
            $response = $soap_blik->execute_payment_by_blik_code($_POST['token'], $_POST['blikCode']);
            if (is_object($response)) {
                $data = array(
                    'error' => $response->error->errorCode,
                    'success' => $response->error->errorCode ? false : true,
                    'p24_order_id' => $response->result->orderId,
                );
            } else {
                $data = array(
                    'error' => -1,
                    'success' => false,
                    'p24_order_id' => '',
                );
            }
            exit(json_encode($data, true));
        }
        if (
            isset($_POST['action']) &&
            isset($_POST['orderId']) &&
            isset($_POST['oneclickOrderId']) &&
            isset($_POST['sign']) &&
            (int)$_POST['orderId'] > 0 &&
            (int)$_POST['oneclickOrderId'] > 0 &&
            $_POST['action'] == 'rememberOrderId') {

            if (strlen((int)$_POST['oneclickOrderId']) != strlen($_POST['oneclickOrderId']) ||
                strlen((int)$_POST['orderId']) != strlen($_POST['orderId'])) {
                exit('int error');
            }

            if (!$this->checkSign($_POST['sign'], $_POST['sessionId']) ) {
                exit('error');
            }

            if ($wpdb->query("SELECT * FROM `{$wpdb->prefix}woocommerce_p24_data` where `custom_key` = '".md5($_POST['oneclickOrderId'])."'")) {
                exit('oneclickOrderId must be unique');
            }

            Przelewy24Helpers::setCustomData('oneclick', 1, md5($_POST['oneclickOrderId']),json_encode(array(
                'orderId' => $_POST['orderId'],
                'oneclickOrderId' => $_POST['oneclickOrderId'],
                'sessionId' => $_POST['sessionId']

                ))
        );
            exit('ok');
        }


            if (isset($_POST['p24_session_id'])) {

            $p24_session_id = $_POST['p24_session_id'];
            $reg_session = "/^[0-9a-zA-Z_\.]+$/D";
            if (!preg_match($reg_session, $p24_session_id)) exit;
            $session_id = explode('_', $p24_session_id);
            $order_id = $session_id[0];
            $order = new WC_Order($order_id);
            $currency = $order->get_currency();
            $validation = array('p24_amount' => number_format($order->get_total() * 100, 0, "", ""));
            $config_accessor = $this->get_settings_from_internal_formatted($currency, true);

            $p24 = new Przelewy24Class( $config_accessor );
            $result = $p24->trnVerifyEx( $validation );

            if ( null === $result ) {
                exit( "\n" . 'MALFORMED POST' );
            } elseif ( $result ) {
                $card_ref = null;
                $order->add_order_note(__('IPN payment completed', 'woocommerce'));
                $decorator = $this->plugin_core->get_status_decorator_instance();
                $decorator->try_set_decoration_mode(true, $currency);
                $order->payment_complete();
                $decorator->try_set_decoration_mode(false, $currency);

                // zapis ostatniej metody płatności
                if ((int)$_POST['p24_method']) {
                    Przelewy24Helpers::setCustomData('user', $order->get_user_id(), 'lastmethod', (int)$_POST['p24_method']);
                    Przelewy24Helpers::setCustomData('user', $order->get_user_id(), 'accept', 1);

                    // jeśli karta i ma recuring to zapisz
                    if (in_array($_POST['p24_method'], Przelewy24Class::getChannelsCard()) && $this->p24_oneclick == 'yes') {
                        $card_ref = $this->saveCard((int)$order->get_user_id(), (int)$_POST['p24_order_id']);
                    }
                }

                // session id save
                $order->update_meta_data( P24_Core::ORDER_SESSION_ID_KEY, $p24_session_id );
                $order->save_meta_data();

                do_action('p24_payment_complete', $order, $card_ref);
            }
            if (!isset($_GET['order_id'])) exit;
        }

        if (isset($_GET['status']) && $_GET['status'] === 'REST') {
            $config_factory = [$this, 'load_settings_from_db_formatted'];
            $rest_server    = new P24_Rest_Server($config_factory);
            $rest_server->support_status();
            exit;
        }
        global $wpdb;
        $orderHash = ($_GET['order_hash']) ? $_GET['order_hash'] : '';
        $tableName = $wpdb->prefix . 'woocommerce_p24_order_map';

        // Prepared statements should sanitize strings.
        $resultPrep = $wpdb->get_results(
            $wpdb->prepare('SELECT * from '.$tableName.' where order_hash="%s"', $orderHash)
        );

        if(!isset($resultPrep[0]->order_id)){
            error_log(__METHOD__ . 'Cannot find an order for hash '.$orderHash );
            throw new Exception(sprintf('Cannot find an order for hash %s',$orderHash ));
        }
        $orderId = isset($resultPrep[0]->order_id) ? $resultPrep[0]->order_id : null;

        if (null !== $orderId) {
            $order = new WC_Order($orderId);
            if ('failed' === $order->get_status()) {
                $this->addNotice(
                // Sorry your transaction did not go through successfully, please try again.
                    $woocommerce,
                    __('Błąd płatności: ', 'przelewy24') . __('Przepraszamy, ale twoja transakcja nie została przeprowadzona pomyślnie, prosimy spróbować ponownie.', 'przelewy24'),
                    'error'
                );

                wp_redirect($order->get_cancel_order_url_raw());
            } else if ( 'completed' === $order->get_status() || 'processing' === $order->get_status() ) {
                $woocommerce->cart->empty_cart();
                if ( empty( $_GET['return'] ) || ! ( 'true' === $_GET['return'] && 'true' === $_GET['success'] && is_numeric( $_GET['orderId'] ) && is_numeric( $_GET['order_id'] ) ) ) {
                    wp_redirect($this->get_return_url($order));
                }
            } else {
                // We did not received information about payment. If you are sure you completed your payment please contact our customer service
                if ( empty( $_GET['return'] ) || ! ( 'true' === $_GET['return'] && 'true' === $_GET['success'] && is_numeric( $_GET['orderId'] ) && is_numeric( $_GET['order_id'] ) ) ) {
                    $this->addNotice(
                        $woocommerce,
                        __('Płatność realizowana przez Przelewy24 nie została jeszcze potwierdzona. Jeśli potwierdzenie nadejdzie w czasie późniejszym, płatność zostanie automatycznie przekazana do sklepu', 'przelewy24'),
                        'notice'
                    );

                    wp_redirect($this->get_return_url($order));
                }
            }
        }
    }

    /**
     * @param $woocommerce
     * @param $message
     * @param $type
     */
    function addNotice($woocommerce, $message, $type)
    {
        if ($type == 'error' && method_exists($woocommerce, 'add_error')) {
            $woocommerce->add_error($message);
        } else if (in_array($type, array('success', 'notice')) && method_exists($woocommerce, 'add_message')) {
            $woocommerce->add_message($message);
        } else {
            wc_add_notice($message, $type);
        }
    }

    /**
     * @return array
     */
    function get_options()
    {
        $option_list = array();
        $option_list['secure'] = __('normalny', 'przelewy24');
        $option_list['sandbox'] = __('testowy', 'przelewy24');

        return $option_list;
    }


    /**
     * Output for the order received page.
     */

    function thankyou_page()
    {
        if ($this->instructions) {
            echo wpautop(wptexturize($this->instructions));
        }
    }

    /**
     * Add content to the WC emails.
     *
     * @access public
     * @param WC_Order $order
     * @param bool $sent_to_admin
     * @param bool $plain_text
     */

    function email_instructions($order, $sent_to_admin, $plain_text = false)
    {
        if ($this->instructions && !$sent_to_admin && 'przelewy24' === $order->get_payment_method()) {
            echo wpautop(wptexturize($this->instructions)) . PHP_EOL;
        }
    }

    public function getCssUrl()
    {
        return PRZELEWY24_URI . 'assets/css/paymethods.css';
    }

    public function getJsUrl()
    {
        return PRZELEWY24_URI . 'assets/js/payment.js';
    }
    private static function get_custom_data($data_type, $data_id, $key)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'woocommerce_p24_data';

        $query = $wpdb->prepare("SELECT * FROM {$table_name} WHERE data_type = %s AND data_id = %d AND custom_key = %s",
            [
                $data_type,
                $data_id,
                $key
            ]
        );

        $fields = $wpdb->get_results(
            $query,
            OBJECT
        );

        foreach ($fields as $field) {
            $value = json_decode($field->custom_value, true);
            if ($value != null) return $value;
            else return $field->custom_value;
        }
        return null;
    }

    private static function get_all_custom_data($data_type, $data_id)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'woocommerce_p24_data';

        $query = $wpdb->prepare("SELECT * FROM {$table_name} WHERE data_type = %s AND data_id = %d",
            [
                $data_type,
                $data_id,
            ]
        );

        $fields = $wpdb->get_results(
            $query,
            OBJECT
        );
        foreach ($fields as &$field) {
            $value = json_decode($field->custom_value, true);
            if ($value != null) $field->custom_value = $value;
        }
        return $fields;
    }

    public static function get_all_cards($user_id)
    {
        $user_id = (int)$user_id;
        return self::get_all_custom_data('user_cards', $user_id);
    }

    public static function del_card($user_id, $card_id)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'woocommerce_p24_data';
        $card = self::getCard((int)$user_id, (int)$card_id);
        if ($card) {
            $key = md5($card->custom_value['mask'] . '|' . $card->custom_value['type'] . '|' . $card->custom_value['exp']);

            $wpdb->delete($table_name, [
                'data_type' => 'user_cards',
                'data_id' => $user_id,
                'custom_key' => $key
            ], ['%s', '%d', '%s' ]);

            return true;
        }
        return false;

    }

    public static function get_cc_forget($user_id)
    {
        if ($user_id) {
            return (int)self::get_custom_data('user', $user_id, 'cc_forget');
        } else {
            /* By default forget. */
            return 1;
        }
    }

    public static function set_cc_forget($user_id, $value)
    {
        Przelewy24Helpers::setCustomData('user', $user_id, 'cc_forget', (int)$value == 1);
    }

    /**
     * @throws SoapFault Soap fault exception.
     *
     * @return SoapClient
     */
    protected function getSoapClient() {
        $host = Przelewy24Class::getHostStatic(
            $this->p24_testmod === 'sandbox'
        );

        $address = sprintf(
            '%sexternal/%s.wsdl',
            $host,
            $this->merchant_id
        );

        return new SoapClient(
            $address,
            array(
                'trace'      => true,
                'exceptions' => true,
                'cache_wsdl' => WSDL_CACHE_NONE,
            )
        );
    }

    private static function getCard($user_id, $card_id)
    {
        $all = self::get_all_custom_data('user_cards', $user_id);
        foreach ($all as $item) {
            if ($item->id == $card_id) return $item;
        }
        return false;
    }

    /**
     * Save card.
     *
     * @param int $user_id User id.
     * @param int $order_id Order id.
     * @return string|null Key of saved card, null if none.
     */
    private function saveCard($user_id, $order_id)
    {
        if ($user_id > 0) {
            $oneclickOrderId = $this->getOneclickOrderId($order_id);

            if (self::get_cc_forget($user_id)) return null; // nie zapamiętuj karty - Customer sobie nie życzy

            if ($this->p24_payinshop != 'yes' || $this->p24_oneclick != 'yes') return; // wyłączone w konfiguracji

            try {
                $config_accessor = $this->get_settings_from_internal_formatted();
                $P24 = new Przelewy24Class($config_accessor);
                $s = new SoapClient($P24->getHost() . $P24->getWsdlCCService(), array('trace' => true, 'exceptions' => true));

                $res = $s->GetTransactionReference($this->shop_id, $this->p24_api, $order_id);

                $hasRecurency = $s->GetTransactionReference($this->merchant_id, $this->p24_api, $oneclickOrderId);

                if ($res->error->errorCode === 0) {

                    $ref = $res->result->refId;
                    $exp = substr($res->result->cardExp, 2, 2) . substr($res->result->cardExp, 0, 2);
                    if (!empty($ref)) {

                        if ($oneclickOrderId > 0) {
                            $hasRecurency = $s->GetTransactionReference($this->merchant_id, $this->p24_api, $oneclickOrderId);
                        } else {
                            $hasRecurency = $s->CheckCard($this->merchant_id, $this->p24_api, $ref);
                        }

                        if ($hasRecurency->error->errorCode === 0 && $hasRecurency->result == true) {
                            if (date('ym') <= $exp) {
                                $key =  md5($res->result->mask . '|' . $res->result->cardType . '|' . $exp);
                                $ok = Przelewy24Helpers::setCustomData('user_cards', $user_id, $key, array(
                                    'ref' => $ref,
                                    'exp' => $exp,
                                    'mask' => $res->result->mask,
                                    'type' => $res->result->cardType,
                                    'time' => date('Y-m-d H:i.s'),
                                ));
                                return $ok ? $key : null;
                            } else {
                                error_log(__METHOD__ . ' termin ważności ' . var_export($exp, true));
                            }
                        } else {
                            error_log(__METHOD__ . ' nie ma rekurencji ' . var_export($hasRecurency, true));
                        }
                    }
                }
            } catch (Exception $e) {
                error_log(__METHOD__ . ' ' . $e->getMessage());
            }
        }

        return null;
    }

    /**
     * Charge card.
     *
     * @param WC_Order $order
     * @param int $card_id
     * @param bool $regulation_accept
     * @return bool
     */
    private function chargeCard($order, $card_id, $regulation_accept)
    {
        $card = $this->getCard(get_current_user_id(), (int)$card_id);
        $data = $this->generator->generate_payload_for_rest($order->get_id());

        if ($data && $card) {

            if (empty($card->custom_value['ref'])) return false;

            $data['regulationAccept'] = (bool)$regulation_accept;
            $config_accessor          = $this->get_settings_from_internal_formatted();
            $rest_transaction         = new P24_Rest_Transaction( $config_accessor );
            $data['methodRefId']      = $card->custom_value['ref'];
            $transaction_info         = $rest_transaction->register($data);
            $token                    = $transaction_info['data']['token'];

            if (!$token) {
                error_log(__METHOD__ . ' ' . 'Cannot generate transaction.');
                return false;
            }

            $rest_card    = new P24_Rest_Card( $config_accessor );
            $payment_info = $rest_card->chargeWith3ds($token);
            if (isset($payment_info['data']['redirectUrl'])) {
                if (isset($payment_info['data']['orderId'])) {
                    $order_id = $payment_info['data']['orderId'];
                    $order->update_meta_data(P24_Core::ORDER_P24_ID, $order_id);
                    $order->save_meta_data();
                }
                wp_redirect($payment_info['data']['redirectUrl']);

                return true;
            }
        }
        return false;
    }

    private function getOneclickOrderId($order_id) {
        global $wpdb;
        $query_result = $wpdb->get_var("SELECT json_extract(custom_value,'$.oneclickOrderId') FROM `{$wpdb->prefix}woocommerce_p24_data` where json_extract(custom_value,'$.orderId') = '".$order_id."' limit 1");

        return (int)$query_result;

    }

    private function checkSign($sign, $sessionId)
    {
        list($orderId) = explode('_', $sessionId, 1);

        $orderId = (int)$orderId;

        $order = new WC_Order($orderId);
        $amount = (int)($order->get_total() * 100);
        $currency_code = $order->get_currency();

        $merchantId = $this->merchant_id;
        $salt = $this->salt;
        $countedSign = md5($sessionId . '|' . $merchantId . '|' . $amount . '|' . $currency_code . '|' . $salt);

        if ($sign === $countedSign) {
            return true;
        }
        return false;
    }

    /**
     * Get non auto increment order id.
     *
     * @deprecated Use static version.
     *
     * @param WC_Order $order
     * @return string
     */
    public function getReturnUrl(WC_Order $order)
    {
        return self::getReturnUrlStatic($order);
    }

    /**
     * Get non auto increment order id. Static variant.
     *
     * @param WC_Order $order
     *
     * @return string
     */
    public static function getReturnUrlStatic(WC_Order $order)
    {
        $orderHash = sha1(sha1(rand().time()));
        // side effect - we have to store dictionary.
        self::saveOrderHash($orderHash, $order->get_id());

        return add_query_arg(array('wc-api' => 'WC_Gateway_Przelewy24', 'order_hash' => $orderHash), home_url('/'));
    }

    /**
     * @param $orderHash
     * @param $orderId
     *
     * @throws Exception
     */
    public static function saveOrderHash($orderHash, $orderId) {
        global $wpdb;
        $wpdb->show_errors();

        $table = "{$wpdb->prefix}woocommerce_p24_order_map";
        $result = $wpdb->insert(
            $table,
            array(
                'order_hash' => $orderHash,
                'order_id' => $orderId,
            ),
            array('%s', '%d')
        );

        if ($result < 1) {
            error_log(__METHOD__.' '.'Cannot generate payment url.');
            throw new \Exception(sprintf('Cannot find table %s in method %s', $table, __METHOD__));
        }
    }

    private function is_P24NOW_available($amount, $currency)
    {
        return ($amount < 10000) && ('PLN' == get_woocommerce_currency());
    }
}
