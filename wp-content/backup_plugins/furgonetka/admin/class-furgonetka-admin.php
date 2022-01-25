<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://furgonetka.pl
 * @since      1.0.0
 *
 * @package    Furgonetka
 * @subpackage Furgonetka/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two hooks
 *
 * @package    Furgonetka
 * @subpackage Furgonetka/admin
 * @author     Furgonetka.pl <woocommerce@furgonetka.pl>
 */
class Furgonetka_Admin
{

    const API_SOAP_URL = 'https://biznes.furgonetka.pl/api/soap/v2?wsdl';
    const TEST_API_SOAP_URL = 'https://biznes-test.furgonetka.pl/api/soap/v2?wsdl';

    const API_OAUTH_URL = 'https://konto.furgonetka.pl/oauth';
    const TEST_API_OAUTH_URL = 'https://konto-test.furgonetka.pl/oauth';

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
     * Error array.
     *
     * @since    1.0.0
     * @access   public
     * @var      array $errors Array of error messages.
     */
    public $errors;
    /**
     * Messages array.
     *
     * @since    1.0.0
     * @access   public
     * @var      array $messages Array of messages.
     */
    public $messages;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/furgonetka-admin.css', array(), $this->version, 'all');

    }

    /**
     * Add relevant links to plugins page.
     *
     * @@since    1.0.0
     *
     * @param array $links Plugin action links
     *
     * @return array Plugin action links
     */

    public function plugin_action_links($links)
    {

        $plugin_links = array();


        $plugin_links[] = '<a href="' . esc_url(get_admin_url(null, 'admin.php?page=' . $this->plugin_name)) . '">' . esc_html__('Settings', 'furgonetka') . '</a>';

        $plugin_links[] = '<a href="mailto:tech@furgonetka.pl">' . esc_html__('Contact', 'furgonetka') . '</a>';

        return array_merge($plugin_links, $links);
    }

    /**
     * Add column to order list.
     *
     * @@since    1.0.0
     *
     * @param array $columns current columns
     *
     * @return array columns
     */

    public function extra_order_column($columns)
    {

        $columns[$this->plugin_name] = __('Furgonetka.pl', 'furgonetka');
        return $columns;
    }

    /**
     * Adds 'Furgonetka' column content to 'Orders' page
     *
     * @param string[] $column name of column being displayed
     */
    function extra_order_column_content($column)
    {
        global $post;

        if ($this->plugin_name === $column) {
            $this->other_package_link($post);
        }
    }

    /**
     * Add furgonetka Page to woocommerce menu
     *
     * @@since    1.0.0
     */
    public function furgonetka_menu()
    {
        add_submenu_page('woocommerce', __('Furgonetka', 'furgonetka'), __('Furgonetka', 'furgonetka'), 'manage_woocommerce', $this->plugin_name, array($this, 'furgonetka_options'));
    }

    /**
     * Add furgonetka meta box for order
     *
     * @@since    1.0.0
     */
    public function furgonetka_meta_boxes()
    {
        add_meta_box($this->plugin_name . '_delivery', __('Furgonetka.pl', 'furgonetka'), array($this, 'other_package_link_callback'), 'shop_order', 'side', 'core');
    }


    /**
     * Get package link in meta box
     *
     * @@since    1.0.0
     */
    public function other_package_link_callback()
    {
        global $post;
        $this->other_package_link($post);

        $point = esc_html(get_post_meta($post->ID, '_furgonetkaPoint', true));
        $pointName = esc_html(get_post_meta($post->ID, '_furgonetkaPointName', true));
        $service = get_post_meta($post->ID, '_furgonetkaService', true);

        if($service){
            echo esc_html($this->getNameOfService($service)) . '<br/>' . ($pointName?$pointName:$point);
        }


    }

    private function getNameOfService($service)
    {
        switch ($service) {
            case "inpost":
                return 'Inpost paczkomat';
                break;
            case "poczta":
                return 'Poczta';
                break;
            case "kiosk":
                return 'Paczka w ruchu';
                break;
            case "uap":
                return 'UPS Access Point';
                break;
            case "dpd":
                return 'DPD Pickup';
                break;
            case "dhl":
                return 'DHL Parcel';
                break;
            case "fedex":
                return 'FedEx Punkt';
                break;
            default:
                return '';
                break;

        }
    }

    /**
     * Refresh furgonetka token
     *
     * @@since    1.0.0
     */
    public function other_package_link($post)
    {
        echo sprintf('<a class="get-furgonetka" href="%1$s">%2$s</a>',
            esc_url(get_admin_url(null, 'admin.php?page=' . $this->plugin_name . '&idOrder=' . $post->ID)),
            '<img height="33px" src="' . plugin_dir_url(__FILE__) . '/img/furgonetka-kurirer.svg' . '" alt="' . __('Get Furgonetka', 'furgonetka') . '" />'
        );
    }

    /**
     * Furgonetka options page
     *
     * @@since    1.0.0
     */
    public function furgonetka_options()
    {
        $reset = false;

        if (!current_user_can('manage_woocommerce')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }

        $action = (isset($_POST['furgonetkaAction'])?sanitize_text_field($_POST['furgonetkaAction']):'');


            if(!isset($_GET['action']) || (isset($_GET['action']) && sanitize_text_field($_GET['action'])!='oAuthComplete')) {
                if (self::getClientID() && self::getClientSecret() && self::getSourceId() === false) {
                    $this->resetCredentials();
                    $reset = true;
                }
            }

        if(isset($_GET['action']) && sanitize_text_field($_GET['action'])=='oAuthComplete'){
            $this->saveCredentialsCode();
        }
        if (isset($action) && $action == 'saveSenderData') {
            $this->saveSenderData();
        }
        if (isset($action) && $action == 'saveDelivery') {
            $this->saveDelivery();
        }
        if (isset($action) && $action == 'resetCredentials') {
            $this->resetCredentials();
            $reset = true;
        }
        if (isset($action) && $action == 'createIntegration') {
            $this->createIntegration();
        }

        if (get_option($this->plugin_name . '_expires_date') > strtotime('now')) {

            $access_token = get_option($this->plugin_name . '_access_token');

            if (isset($_GET['idOrder'])) {
                try {
                    $url = self::getPackageFormUrl($access_token, (int)sanitize_text_field($_GET['idOrder']));
                    $furgonetka_form_url = esc_url(get_admin_url(null, 'admin.php?page=' . $this->plugin_name));
                    $furgonetka_errors = $this->errors;
                    $furgonetka_messages = $this->messages;
                    $furgonetka_packageFormUrl = $url;
                    //include admin view
                    include_once('partials/furgonetka-admin-getpackageform.php');
                    return;
                } catch (Exception $e) {
                    $this->errors[] = $e->getMessage();
                    $furgonetka_errors = $this->errors;
                    $furgonetka_messages = $this->messages;
                    include_once('partials/furgonetka-admin-display.php');
                }
                return;
            } else {
                //view variables
                $furgonetka_form_url = esc_url(get_admin_url(null, 'admin.php?page=' . $this->plugin_name));
                $furgonetka_errors = $this->errors;
                $furgonetka_messages = $this->messages;
                //include admin view
                include_once('partials/furgonetka-admin-display.php');
            }
        } else {
            if (!$reset && get_option($this->plugin_name . '_expires_date'))
                $this->resetCredentials();

            //view variables
            $furgonetka_form_url = esc_url(get_admin_url(null, 'admin.php?page=' . $this->plugin_name));
            $furgonetka_errors = $this->errors;
            $furgonetka_messages = $this->messages;
            //include admin view
            include_once('partials/furgonetka-admin-display.php');
        }
    }



    /**
     * Validate user by code and save
     *
     * @@since    1.0.0
     */
    private function saveCredentialsCode()
    {
        $code = urldecode(sanitize_text_field($_GET['code']));
        $state = urldecode(sanitize_text_field($_GET['state']));

        if ( ! wp_verify_nonce( $state, 'furgonetka_csrf' ) ) {
            $this->errors[] = 'Incorrect CSRF';
            return;
        }


        $test = self::getTestMode();
        $keyConsumerKey =  get_option($this->plugin_name . '_key_consumer_key');
        $keyConsumerSecret = get_option($this->plugin_name . '_key_consumer_secret');

        try {
            $this->grantCodeAccess($code,self::getClientID(),self::getClientSecret(),$test);

            $access_token = get_option($this->plugin_name . '_access_token');

            $source_id = $this->addIntegrationSource($access_token, $test, $keyConsumerKey, $keyConsumerSecret);
            if (is_int($source_id)) {
                update_option($this->plugin_name . '_source_id', $source_id);
                $this->messages[] = __('Access granted', 'furgonetka');
            }

        } catch (Exception $e) {
            delete_option($this->plugin_name . '_source_id');
            delete_option($this->plugin_name . '_access_token');
            delete_option($this->plugin_name . '_refresh_token');
            delete_option($this->plugin_name . '_expires_date');

            delete_option($this->plugin_name . '_key_consumer_key');
            delete_option($this->plugin_name . '_key_consumer_secret');

            $this->errors[] = $e->getMessage();
        }

    }

    /**
     * Save sender data
     *
     * @@since    1.0.0
     */
    private function saveSenderData()
    {
        $name = sanitize_text_field($_POST['name']);
        $companyName = sanitize_text_field($_POST['companyName']);
        $postCode = sanitize_text_field($_POST['postCode']);
        $city = sanitize_text_field($_POST['city']);
        $street = sanitize_text_field($_POST['street']);
        $email = sanitize_email($_POST['email']);
        $telephone = sanitize_text_field($_POST['telephone']);
        $iban = sanitize_text_field($_POST['iban']);
        $accountOwner = sanitize_text_field($_POST['accountOwner']);

        update_option($this->plugin_name . '_sender_name', $name);
        update_option($this->plugin_name . '_sender_companyName', $companyName);
        update_option($this->plugin_name . '_sender_postCode', $postCode);
        update_option($this->plugin_name . '_sender_city', $city);
        update_option($this->plugin_name . '_sender_street', $street);
        update_option($this->plugin_name . '_sender_email', $email);
        update_option($this->plugin_name . '_sender_telephone', $telephone);
        update_option($this->plugin_name . '_cod_iban', $iban);
        update_option($this->plugin_name . '_cod_accountOwner', $accountOwner);
    }

    /**
     * Save delivery option
     *
     * @@since    1.0.0
     */
    private function saveDelivery()
    {
        $mapToDelivery = isset($_POST['mapToDelivery']) ? $_POST['mapToDelivery'] : '';

        $result_array = array();
        $fail = false;
        if ($mapToDelivery) {
            foreach ($mapToDelivery as $type => $options) {
                foreach ($options as $option) {
                    if (isset($result_array[sanitize_text_field($option)])) {
                        $fail = true;
                        break 2;
                    }
                    $result_array[$option] = sanitize_text_field($type);

                }
            }
        }
        if ($fail) {
            $this->errors[] = __('Every delivery option can have just one map attached.', 'furgonetka');
            return;
        }
        update_option($this->plugin_name . '_deliveryToType', $result_array);
    }

    /**
     * Reset credentials
     *
     * @@since    1.0.0
     */
    private function resetCredentials()
    {

        delete_option($this->plugin_name . '_client_ID');
        delete_option($this->plugin_name . '_client_secret');
        delete_option($this->plugin_name . '_access_token');
        delete_option($this->plugin_name . '_refresh_token');
        delete_option($this->plugin_name . '_expires_date');
        delete_option($this->plugin_name . '_test_mode');
        delete_option($this->plugin_name . '_email');
        delete_option($this->plugin_name . '_source_id');

        delete_option($this->plugin_name . '_key_consumer_key');
        delete_option($this->plugin_name . '_key_consumer_secret');

        $this->messages[] = __('Account reseted', 'furgonetka');
    }

    /**
     * Create Integration OAuth Application
     *
     * @@since    1.0.0
     */
    private function createIntegration()
    {

        $url = self::getTestMode() ? self::TEST_API_SOAP_URL : self::API_SOAP_URL;
        
        $client = new \SoapClient($url, [
            'trace' => true,
            'cache_wsdl' => false,
            'user_agent' => self::getRequestUserAgent()
        ]);

        $apiData = [
            'integration_type' => 'woocommerce',
            'url' => self::getRedirectUri(),
            'data_1' => get_home_url(),
            'data_2' => sanitize_text_field($_POST['key_consumer_key']),
            'data_3' => sanitize_text_field($_POST['key_consumer_secret']),
        ];
        $result = $client->createIntegrationOAuthApplication([
            'data' => $apiData
        ])->createIntegrationOAuthApplicationResult;
        if (!$result->client_id) {
            $this->errors[] = $result->errors->item->message;
        } else {
            $testMode = self::getTestMode() ? true : false;
            update_option($this->plugin_name . '_client_ID', $result->client_id);
            update_option($this->plugin_name . '_client_secret', $result->client_secret);

                        /**
             * save wp access api data in db
             */
            update_option($this->plugin_name . '_key_consumer_key', sanitize_text_field($_POST['key_consumer_key']));
            update_option($this->plugin_name . '_key_consumer_secret', sanitize_text_field($_POST['key_consumer_secret']));

            update_option($this->plugin_name . '_test_mode', $testMode);
            $this->messages[] = __('Integration created. Please add credentials.', 'furgonetka');

            $url = self::getTestMode() ? self::TEST_API_OAUTH_URL : self::API_OAUTH_URL;
            $query = http_build_query(array(
                'client_id'=>$result->client_id,
                'redirect_uri'=>self::getRedirectUri(),
                'state'=>self::getOAuthState(),
                )
            );
            $url .= '/authorize?response_type=code&'.$query;
            header("Location: ".$url);
            die();
        }


    }

    /**
     * Get access tocken by code
     *
     *  @@since    1.0.0
     *
     * @param $code
     * @param $clientID
     * @param $clientSecret
     * @param $testMode
     *
     * @throws Exception
     */
    private function grantCodeAccess($code,$clientID ,$clientSecret,$testMode = null)
    {

        $auth = base64_encode($clientID . ':' . $clientSecret);
        $url = self::getTestMode() ? self::TEST_API_OAUTH_URL : self::API_OAUTH_URL;
        $url .= '/token';

        $args = array(
                'headers'=>array(
                'Authorization' => 'Basic ' . $auth,
                    'content-type'=> 'application/x-www-form-urlencoded'
                ),
                'method'=>'POST',
                'body'=>http_build_query(array(
                    'grant_type' => 'authorization_code',
                    'code' => $code,
                    'redirect_uri' => self::getRedirectUri()
                )),
                'user-agent'=> self::getRequestUserAgent()
        );
        $response = wp_remote_request($url , $args );

        if ( is_wp_error( $response ) ) {
            throw new Exception('Curl error: ' . $response->get_error_message());
        }
        else {
            $http_status = wp_remote_retrieve_response_code( $response );
            $server_output = trim( wp_remote_retrieve_body( $response ) );
            if ($http_status >= 400) {
                $error = json_decode($server_output);
                throw new Exception('HTTP STATUS: ' . $http_status . ' - Message: ' . $error->message);
            } else {
                if ($http_status == 200) {
                    $response = json_decode($server_output);
                    if (isset($response->access_token)) {
                        update_option($this->plugin_name . '_access_token', $response->access_token);
                    }
                    if (isset($response->refresh_token)) {
                        update_option($this->plugin_name . '_refresh_token', $response->refresh_token);
                    }
                    if (isset($response->expires_in)) {
                        $expires_date = strtotime("now") + $response->expires_in;
                        update_option($this->plugin_name . '_expires_date', $expires_date);
                    }
                    $testMode = $testMode ? true : false;
                    update_option($this->plugin_name . '_test_mode', $testMode);
                } else
                    throw new Exception('BAD HTTP STATUS: ' . $http_status);
            }
        }
    }

    /**
     * Add integration source
     *
     *  @@since    1.0.0
     *
     * @param $clientID
     * @param $clientSecret
     *
     * @param $testMode
     *
     * @throws Exception
     */
    private function addIntegrationSource($access_token, $testMode = null, $keyConsumerKey, $keyConsumerSecret)
    {

        $url = self::getTestMode() ? self::TEST_API_SOAP_URL : self::API_SOAP_URL;
        $client = new \SoapClient($url, [
            'trace' => true,
            'cache_wsdl' => false,
            'user_agent' => self::getRequestUserAgent()
        ]);
        $auth = [
            'access_token' => $access_token,
        ];

        $apiData = [
            'auth' => $auth,
            'integration_type' => 'woocommerce',
            'module_version' => $this->version,
            'data_1' => get_home_url(),
            'data_2' => $keyConsumerKey,
            'data_3' => $keyConsumerSecret,
        ];

        delete_option($this->plugin_name . '_key_consumer_key');
        delete_option($this->plugin_name . '_key_consumer_secret');

        $result = $client->addIntegrationSource([

            'data' => $apiData

        ])->addIntegrationSourceResult;

        if ($result->errors) {
            if (!empty($result->errors)) {
                throw new \Exception($result->errors->item->message . ' : ' . $result->errors->item->field);
            }
            throw new \Exception(__('Add integration source problem', 'furgonetka'));
        } else
            return $result->source_id;

    }

    /**
     * Refresh furgonetka token
     *
     * @@since    1.0.0
     */
    public function furgonetka_refresh_token()
    {
        /** break if expiras date > 7 days **/
        if (get_option($this->plugin_name . '_expires_date') > strtotime("+7 day")) return;

        $testMode = get_option($this->plugin_name . '_test_mode');
        $clientID = get_option($this->plugin_name . '_client_ID');
        $clientSecret = get_option($this->plugin_name . '_client_secret');
        $refresh_token = get_option($this->plugin_name . '_refresh_token');

        try {
            $this->refreshToken($clientID, $clientSecret, $testMode, $refresh_token);
            $this->messages[] = __('Access granted', 'furgonetka');

        } catch (Exception $e) {
            $this->errors[] = $e->getMessage();
        }

    }

    /**
     * Refresh user tocken
     *
     * @@since    1.0.0
     *
     * @param $clientID
     * @param $clientSecret
     * @param $testMode
     * @param $refresh_token
     *
     * @throws Exception
     */
    private function refreshToken($clientID, $clientSecret, $testMode, $refresh_token)
    {
        $auth = base64_encode($clientID . ':' . $clientSecret);
        $url = $testMode ? self::TEST_API_OAUTH_URL : self::API_OAUTH_URL;
        $url .= '/token';

        $args = array(
            'headers'=>array(
                'Authorization' => 'Basic ' . $auth,
                'content-type'=> 'application/x-www-form-urlencoded'
            ),
            'method'=>'POST',
            'body'=>http_build_query(array(
                'grant_type' => 'refresh_token',
                'refresh_token' => $refresh_token,
                'redirect_uri' => self::getRedirectUri()
            )),
            'user-agent'=> self::getRequestUserAgent()
        );

        $response = wp_remote_request($url , $args );

        if ( is_wp_error( $response ) ) {
            throw new Exception('Curl error: ' . $response->get_error_message());
        }
        else {
            $http_status = wp_remote_retrieve_response_code( $response );
            $server_output = trim( wp_remote_retrieve_body( $response ) );

            if ($http_status >= 400) {
                $error = json_decode($server_output);
                throw new Exception('HTTP STATUS: ' . $http_status . ' - Message: ' . $error->message);
            } else {
                if ($http_status == 200) {
                    $response = json_decode($server_output);
                    if (isset($response->access_token)) {
                        update_option($this->plugin_name . '_access_token', $response->access_token);
                    }
                    if (isset($response->refresh_token)) {
                        update_option($this->plugin_name . '_refresh_token', $response->refresh_token);
                    }
                    if (isset($response->expires_in)) {
                        $expires_date = strtotime("now") + $response->expires_in;
                        update_option($this->plugin_name . '_expires_date', $expires_date);
                    }
                } else
                    throw new Exception('BAD HTTP STATUS: ' . $http_status);
            }
        }
    }

    /**
     * Get user balance from API
     *
     * @@since    1.0.0
     */
    public static function getBalance($access_token)
    {

        $url = self::getTestMode() ? self::TEST_API_SOAP_URL : self::API_SOAP_URL;
        $client = new \SoapClient($url, [
            'trace' => true,
            'cache_wsdl' => false,
            'user_agent' => self::getRequestUserAgent()
        ]);
        $auth = [
            'access_token' => $access_token,
        ];


        $balance = $client->getBalance([

            'data' => [
                'auth' => $auth,
            ],

        ])->getBalanceResult;
        if (!isset($balance->balance)) {

            if (!empty($balance->errors)) {
                throw new \Exception($balance->errors->item->message);
            }
            throw new \Exception(__('Balance GET problem', 'furgonetka'));
        } else
            return $balance->balance;

    }

    /**
     * Get Package details from API
     *
     * @@since    1.0.0
     */
    public static function getPackageDetails($access_token, $reference)
    {

        $url = self::getTestMode() ? self::TEST_API_SOAP_URL : self::API_SOAP_URL;
        $client = new \SoapClient($url, [
            'trace' => true,
            'cache_wsdl' => false,
            'user_agent' => self::getRequestUserAgent()
        ]);
        $auth = [
            'access_token' => $access_token,
        ];


        $result = $client->getPackageDetails([

            'data' => [
                'auth' => $auth,
                'partner_reference_number' => $reference,
            ],

        ])->getPackageDetailsResult;

        return $result;

    }

    /**
     * Get package form url from API
     *
     * @@since    1.0.0
     */
    public static function getPackageFormUrl($access_token, $reference)
    {

        $order_data = new WC_Order($reference);
        $parcels = array();
        $services = array();


        if ($order_data->get_payment_method() == 'cod') {
            $services['cod'] = [
                'amount' => $order_data->get_total(),
                'iban' => self::getIban(),
                'name' => self::getAccountOwner()
            ];
        }
        foreach ($order_data->get_items() as $item) {
            $product_name = $item['name'];
            $parcels[] = [
                'description' => $product_name,
                'value' => $order_data->get_total(),
            ];
        }
        $sender = self::getSender();
        $receiver = self::getReceiver($order_data);

        $url = self::getTestMode() ? self::TEST_API_SOAP_URL : self::API_SOAP_URL;
        $client = new \SoapClient($url, [
            'trace' => true,
            'cache_wsdl' => false,
	        'user_agent' => self::getRequestUserAgent()
        ]);
        $auth = [
            'access_token' => $access_token,
        ];


        $result = $client->getPackageFormUrl([

            'data' => [
                'auth' => $auth,
                'sender' => $sender,
                'receiver' => $receiver,
                'services' => $services,
                'service' => self::getService($order_data),
                'type' => 'package',
                'partner_reference_number' => $reference,
                'user_reference_number' => $reference,
                'parcels' => $parcels,
                'sale_source_id' => self::getSourceId(),
            ],

        ])->getPackageFormUrlResult;


        if (!$result->url) {

            if (!empty($result->errors)) {
                throw new \Exception($result->errors->item->message);
            }
            throw new \Exception(__('Get package Form URL problem.', 'furgonetka'));
        } else
            return $result->url;


    }

    /**
     * Get sender data from options
     *
     * @@since    1.0.0
     */
    public static function getSender()
    {
        $data = [
            'name' => self::getName(), // nillable
            'email' => self::getSenderEmail(), // nillable
            'company' => self::getCompanyName(), // nillable
            'street' => self::getStreet(),
            'postcode' => self::getPostCode(),
            'city' => self::getCity(),
            'country_code' => '', // nillable
            'county' => '', // nillable
            'phone' => self::getTelephone(), // nillable
            'point' => '', // nillable
        ];
        return $data;
    }

    /**
     * Get receiver from order
     *
     * @@since    1.0.0
     */
    public static function getReceiver($order_data)
    {


        if ($order_data) {
            $point = get_post_meta($order_data->get_id(), '_furgonetkaPoint', true);

            $data = [
                'name' => $order_data->get_shipping_first_name() . ' ' . $order_data->get_shipping_last_name(), // nillable
                'email' => $order_data->get_billing_email(), // nillable
                'company' => $order_data->get_shipping_company(), // nillable
                'street' => $order_data->get_shipping_address_1() . ' ' . $order_data->get_shipping_address_2(),
                'postcode' => $order_data->get_shipping_postcode(),
                'city' => $order_data->get_shipping_city(),
                'country_code' => $order_data->get_shipping_country(), // nillable
                'county' => '', // nillable
                'phone' => $order_data->get_billing_phone(), // nillable
                'point' => $point, // nillable
                'alternative_point' => '', // nillable
            ];
        } else {
            $data = [
                'name' => '', // nillable
                'email' => '', // nillable
                'company' => '', // nillable
                'street' => '',
                'postcode' => '',
                'city' => '',
                'country_code' => '', // nillable
                'county' => '', // nillable
                'phone' => '', // nillable
                'point' => '', // nillable
                'alternative_point' => '', // nillable
            ];
        }
        return $data;
    }

    /**
     * Get furgonetka service name from order
     *
     * @@since    1.0.0
     */
    public static function getService($order_data)
    {
        //dhl, dpd, fedex, ups, inpost, inpostkurier, poczta, kex, ruch, xpress

        $shipping_methods = $order_data->get_shipping_methods();
        $shipping_name = '';
        foreach ($shipping_methods as $shipping_method) {
            $data = $shipping_method->get_data();

            $shipping_name = $data['method_id'] . ':' . $data['instance_id'];
            if($data['method_id'] == 'flexible_shipping'){
                if ( isset( $shipping_method['item_meta'] )
                    && isset( $shipping_method['item_meta']['_fs_method'] )
                ) {
                    $fs_method = $shipping_method['item_meta']['_fs_method'];
                    $shipping_name = $fs_method['id_for_shipping'];
                }
            }

        }
      
        $deliveryToType = get_option(FURGONETKA_PLUGIN_NAME . '_deliveryToType');
        if (isset($deliveryToType[$shipping_name])) {
            switch ($deliveryToType[$shipping_name]) {
                case "inpost":
                    return 'inpost';
                    break;
                case "poczta":
                    return 'poczta';
                    break;
                case "kiosk":
                    return 'ruch';
                    break;
                case "uap":
                    return 'ups';
                    break;
                case "dpd":
                    return 'dpd';
                    break;
                case "dhl":
                    return 'dhl';
                case "fedex":
                    return 'fedex';
                default:
                    return '';
                    break;

            }

        }
        if (!$order_data) return;

        return '';
    }

    /**
     * @@since    1.0.0
     */
    public static function getEmail()
    {
        return isset($_POST['email']) ? sanitize_email($_POST['email']) : get_option(FURGONETKA_PLUGIN_NAME . '_email');
    }

    /**
     * @@since    1.0.0
     */
    public static function getClientID()
    {
        return isset($_POST['clientID']) ? sanitize_text_field($_POST['clientID']) : get_option(FURGONETKA_PLUGIN_NAME . '_client_ID');
    }

    /**
     * @@since    1.0.0
     */
    public static function getClientBalance()
    {
        $access_token = get_option(FURGONETKA_PLUGIN_NAME . '_access_token');

        try {
            $balance = self::getBalance($access_token);
            return $balance;
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return 0;
    }

    /**
     * @@since    1.0.0
     */
    public static function getClientSecret()
    {
        return isset($_POST['clientSecret']) ? sanitize_text_field($_POST['clientSecret']) : get_option(FURGONETKA_PLUGIN_NAME . '_client_secret');
    }

    /**
     * @@since    1.0.0
     */
    public static function getTestMode()
    {
        $action = (isset($_POST['furgonetkaAction'])?sanitize_text_field($_POST['furgonetkaAction']):'');
        return (isset($action) && ($action == 'createIntegration')) ? (isset($_POST['isTestMode'])? sanitize_text_field($_POST['isTestMode'])== 1:false) : get_option(FURGONETKA_PLUGIN_NAME . '_test_mode');
    }

    /**
     * @@since    1.0.0
     */
    public static function getName()
    {
        return isset($_POST['name']) ? sanitize_text_field($_POST['name']) : get_option(FURGONETKA_PLUGIN_NAME . '_sender_name');
    }

    /**
     * @@since    1.0.0
     */
    public static function getCompanyName()
    {
        return isset($_POST['companyName']) ? sanitize_text_field($_POST['companyName']) : get_option(FURGONETKA_PLUGIN_NAME . '_sender_companyName');
    }

    /**
     * @@since    1.0.0
     */
    public static function getPostCode()
    {
        return isset($_POST['postCode']) ? sanitize_text_field($_POST['postCode']) : get_option(FURGONETKA_PLUGIN_NAME . '_sender_postCode');
    }

    /**
     * @@since    1.0.0
     */
    public static function getCity()
    {
        return isset($_POST['city']) ? sanitize_text_field($_POST['city']) : get_option(FURGONETKA_PLUGIN_NAME . '_sender_city');
    }

    /**
     * @@since    1.0.0
     */

    public static function getStreet()
    {
        return isset($_POST['street']) ? sanitize_text_field($_POST['street']) : get_option(FURGONETKA_PLUGIN_NAME . '_sender_street');
    }

    /**
     * @@since    1.0.0
     */
    public static function getSenderEmail()
    {
        return isset($_POST['email']) ? sanitize_email($_POST['email']) : get_option(FURGONETKA_PLUGIN_NAME . '_sender_email');
    }

    /**
     * @@since    1.0.0
     */
    public static function getTelephone()
    {
        return isset($_POST['telephone']) ? sanitize_text_field($_POST['telephone']) : get_option(FURGONETKA_PLUGIN_NAME . '_sender_telephone');
    }

    /**
     * @@since    1.0.0
     */
    public static function getIban()
    {
        return isset($_POST['iban']) ? sanitize_text_field($_POST['iban']) : get_option(FURGONETKA_PLUGIN_NAME . '_cod_iban');
    }

    /**
     * @@since    1.0.0
     */
    public static function getSourceId()
    {
        return get_option(FURGONETKA_PLUGIN_NAME . '_source_id');
    }

    /**
     * @@since    1.0.0
     */
    public static function getAccountOwner()
    {
        return isset($_POST['accountOwner']) ? sanitize_text_field($_POST['accountOwner']) : get_option(FURGONETKA_PLUGIN_NAME . '_cod_accountOwner');
    }

    /**
     * @@since    1.0.0
     */
    public static function getRedirectUri()
    {
        return admin_url('admin.php?page=furgonetka&tab=furgonetka&action=oAuthComplete');
    }
    /**
     * @@since    1.0.0
     */
    public static function getOAuthState()
    {
        return wp_create_nonce( 'furgonetka_csrf' );
    }

    /**
     * Generate multiselect with delivery options
     *
     * @@since    1.0.0
     */
    public static function mapAttachTo($type, $deliveryToType)
    {
        if (!$type) return;
        $options = '';

        $zones = WC_Shipping_Zones::get_zones();

        /**
         * Add "0" zone (that contains shipping methods without assigned real zone)
         */
        $fallbackZone = WC_Shipping_Zones::get_zone(0);

        if ($fallbackZone) {
            /**
             * Get zone data & assigned shipping methods
             */
            $data = $fallbackZone->get_data();
            $data['shipping_methods'] = $fallbackZone->get_shipping_methods(false, 'admin');

            /**
             * Push zone to the array
             */
            $zones[$fallbackZone->get_id()] = $data;
        }

        foreach ($zones as $zoneItem) {
            $shipping_methods = $zoneItem['shipping_methods'];


            foreach ($shipping_methods as $shipping_method) {
                if (!in_array($shipping_method->id, ['flat_rate', 'flexible_shipping_single'])) {
                    continue;
                }
                $instance = $shipping_method->id . ':' . $shipping_method->instance_id;
                $options .= sprintf('<option value="%1$s" %2$s>%3$s</option>',
                    $instance,
                    self::checkSelected($type, $instance, $deliveryToType) ? 'selected' : '',
                    $zoneItem['zone_name'] . ':' . $shipping_method->title
                );
            }
        }
        ?>
        <select multiple size="6" name="mapToDelivery[<?php echo esc_html($type); ?>][]">
            <?php echo $options; ?>
        </select>
        <?php

    }

    /**
     * Admin print messages
     *
     * @@since    1.0.0
     */
    public static function printMessages($messages, $type)
    {
        if (!$messages) return;

        if (!$type) $type = 'message';

        foreach ($messages as $message) {

            echo sprintf(
                '<div id="message" class="updated woocommerce-%1$s inline">
                        <p>%2$s</p>
                    </div>',
                $type,
                $message
            );
        }
    }

    /**
     * Check if map is attach to delivery option
     *
     * @@since    1.0.0
     */
    public static function checkSelected($type, $instance, $deliveryToType)
    {
        if (isset($_POST['mapToDelivery'])) {
            $mapToDelivery = isset($_POST['mapToDelivery']) ? $_POST['mapToDelivery'] : '';
            if (isset($mapToDelivery[$type]) && in_array($instance, $mapToDelivery[$type])) return true;
        } else {
            if (isset($deliveryToType[$instance]) && $deliveryToType[$instance] == $type) return true;
        }
        return false;
    }

    /**
     * Get woocommerce version
     *
     * @@since    1.0.0
     */
    private static function getWcVersion()
    {
        if (function_exists('WC')) {
            return WC()->version;
        }
    }

    /**
     * Check if account is active and enabled
     *
     * @@since    1.0.0
     */
    public static function isAccountActive()
    {
        if (!get_option(FURGONETKA_PLUGIN_NAME . '_expires_date')) return false;
        if (get_option(FURGONETKA_PLUGIN_NAME . '_expires_date') < strtotime('now')) return false;

        return true;
    }

    /**
     * @return string
     */
    private static function getRequestUserAgent() {
    	return 'woocommerce_' . self::getWcVersion() . '_plugin_' . FURGONETKA_VERSION;
    }
}
