<?php
/**
 * File that define P24_Rest_Card class.
 *
 * @package Przelewy24
 */

defined( 'ABSPATH' ) || exit;


/**
 * Class that support card API.
 */
class P24_Rest_Card extends P24_Rest_Abstract {

	/**
	 * Charge with 3ds.
	 *
	 * @param string $token Przelewy24 transaction token.
	 * @return string
	 */
	public function chargeWith3ds( $token ) {
		$path    = '/card/chargeWith3ds';
		$payload = array(
			'token' => $token,
		);
		$ret     = $this->call( $path, $payload, 'POST' );

		return $ret;
	}

    /**
     * Charge without 3ds.
     *
     * @param string $token Przelewy24 transaction token.
     * @return string
     */
    public function chargeWithout3ds( $token ) {
        $path    = '/card/charge';
        $payload = array(
            'token' => $token,
        );
        $ret     = $this->call( $path, $payload, 'POST' );

        return $ret;
    }
}
