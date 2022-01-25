<?php
/**
 * File that define P24_Icon_Generator class.
 *
 * @package Przelewy24
 */

defined( 'ABSPATH' ) || exit;


/**
 * The class for extra gateway.
 */
class P24_Icon_Generator {


	/**
	 * URL with CSS.
	 */
	const CSS_URL = 'https://secure.przelewy24.pl/skrypty/ecommerce_plugin.css.php';

	/**
	 * Regular expression to parse CSS.
	 */
	const REX = '/(\\.mobile\\s+)?\\.bank\\-logo\\-(\\d+)\\s*\\{\\s*background\\-image\\:\\s*url\\(([^\\)]+)\\)\\s*\\;\\s*\\}/';

	/**
	 * Id of id from expression.
	 */
	const REX_ID = 2;

	/**
	 * Id of mobile prefix from expression.
	 */
	const REX_MOBILE = 1;

	/**
	 * Id of URL from expression;
	 */
	const REX_URL = 3;

	/**
	 * Icon_set.
	 *
	 * @var array|null
	 */
	private $icon_set = null;

	/**
	 * Generate set.
	 */
	public function generate_set() {
		$this->icon_set = array();
		$file           = wp_remote_get( self::CSS_URL );
		if ( $file instanceof WP_Error ) {
			/* There is a network error. Skip. */
			return;
		} elseif ( ! isset( $file['body'] ) ) {
			/* We cannot download file with the list. */
			return;
		}
		preg_match_all( self::REX, $file['body'], $m, PREG_SET_ORDER );
		foreach ( $m as $rule ) {
			$id = (int) $rule[ self::REX_ID ];
			if ( ! $id ) {
				continue;
			}
			if ( $rule[ self::REX_MOBILE ] ) {
				continue;
			}
			$this->icon_set[ $id ] = $rule[ self::REX_URL ];
		}
		ksort( $this->icon_set, SORT_NUMERIC );
	}

	/**
	 * Get icon.
	 *
	 * @param  int $id Id of payment method.
	 * @return string|null
	 */
	public function get_icon( $id ) {
		if ( ! isset( $this->icon_set ) ) {
			$this->generate_set();
		}

		$id = (int) $id;

		if ( array_key_exists( $id, $this->icon_set ) ) {
			return $this->icon_set[ $id ];
		} else {
			return null;
		}

	}
}
