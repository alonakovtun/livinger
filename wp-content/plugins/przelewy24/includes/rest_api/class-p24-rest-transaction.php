<?php
/**
 * File that define P24_Rest_Transaction class.
 *
 * @package Przelewy24
 */
defined( 'ABSPATH' ) || exit;


/**
 * Class that support transaction API.
 */
class P24_Rest_Transaction extends P24_Rest_Abstract {

	/**
	 * Register.
	 *
	 * @param array $payload
	 * @return array
	 */
	public function register( $payload ) {
		$path            = '/transaction/register';
		$payload['sign'] = $this->sign_sha_384_register( $payload );

		return $this->call( $path, $payload, 'POST' );
	}

	/**
	 * Register.
	 *
	 * @param array $payload
	 * @return array
	 */
	public function verify( $payload ) {
		$path            = '/transaction/verify';
		$payload['sign'] = $this->sign_sha_384_verify( $payload );

		return $this->call( $path, $payload, 'PUT' );
	}

	/**
	 * Sign sha384.
	 *
	 * @param array $payload
	 * @return string
	 */
	private function sign_sha_384_register( $payload ) {
		$data   = array(
			'sessionId'  => $payload['sessionId'],
			'merchantId' => $payload['merchantId'],
			'amount'     => $payload['amount'],
			'currency'   => $payload['currency'],
			'crc'        => $this->cf->get_salt(),
		);
		$string = json_encode( $data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
		$sign   = hash( 'sha384', $string );

		return $sign;
	}

	/**
	 * Sign sha384.
	 *
	 * @param array $payload
	 * @return string
	 */
	private function sign_sha_384_verify( $payload ) {
		$data   = array(
			'sessionId' => $payload['sessionId'],
			'orderId'   => $payload['orderId'],
			'amount'    => $payload['amount'],
			'currency'  => $payload['currency'],
			'crc'       => $this->cf->get_salt(),
		);
		$string = json_encode( $data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
		$sign   = hash( 'sha384', $string );

		return $sign;
	}
}
