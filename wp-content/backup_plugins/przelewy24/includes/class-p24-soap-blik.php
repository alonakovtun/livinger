<?php
/**
 * File that define P24_Soap_Blik.
 *
 * @package Przelewy24
 */

defined( 'ABSPATH' ) || exit;


/**
 * Class P24_Soap_Blik
 */
class P24_Soap_Blik {


	/**
	 * Soap client.
	 *
	 * @var SoapClient
	 */
	private $soap_client = null;

	/**
	 * Config_accessor.
	 *
	 * @var P24_Config_Accessor
	 */
	private $config_accessor;

	/**
	 * P24_Soap_Blik constructor.
	 * @param P24_Config_Accessor $config_accessor
	 * @throws SoapFault
	 */
	public function __construct( P24_Config_Accessor $config_accessor ) {
		$this->config_accessor = clone $config_accessor;
		$this->config_accessor->access_mode_to_strict();

		$url               = $this->get_ws_url();
		$soap_config       = array(
			'cache_wsdl' => WSDL_CACHE_NONE,
			'exceptions' => true,
		);
		$this->soap_client = new SoapClient( $url, $soap_config );
	}

	/**
	 * Execute payment by BLIK code.
	 *
	 * @param $token
	 * @param $blik_code
	 * @param $urlStatus
	 * @return object
	 */
	public function execute_payment_by_blik_code( $token, $blik_code ) {
		try {
			$response = $this->soap_client->executePaymentByBlikCode(
				$this->config_accessor->get_merchant_id(),
				$this->config_accessor->get_p24_api(),
				$token,
				$blik_code,
				null
			);

			return $response;
		} catch ( Exception $e ) {
			return (object) array(
				'error' => (object) array(
					'errorCode'    => -1,
					'errorMessage' => $e->getMessage(),
				),
			);
		}
	}

	/**
	 * Get wsdl url.
	 *
	 * @return string
	 */
	private function get_ws_url() {
		$mode = $this->config_accessor->get_p24_operation_mode();
		$url  = 'https://' . $mode . '.przelewy24.pl/external/wsdl/charge_blik_service.php?wsdl';
		return $url;
	}
}
