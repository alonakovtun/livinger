<?php
/**
 * File that define P24_Extra_Gateway_Support.
 *
 * @package Przelewy24
 */

/**
 * Class P24_Extra_Gateway_Support
 */
class P24_Extra_Gateway_Support {

	/**
	 * Plugin core.
	 *
	 * @var P24_Core The plugin core.
	 */
	private $core;

	/**
	 * The set of extra gateways.
	 *
	 * @var array
	 */
	private $extra_gateways;

	/**
	 * P24_Extra_Gateway_Support constructor.
	 *
	 * @param P24_Core $core The plugin core.
	 */
	public function __construct( $core ) {
		$this->core = $core;
	}

	/**
	 * Prepare extra gateways.
	 *
	 * @param WC_Gateway_Przelewy24 $main_gateway The main Przelewy24 gateway.
	 */
	public function prep_extra_gateways( WC_Gateway_Przelewy24 $main_gateway ) {
		$currency       = get_woocommerce_currency();
		$config         = $this->core->get_config_for_currency( $currency );
		$all_banks      = $main_gateway->get_all_payment_methods();
		$imploded       = $config->get_p24_paymethods_super_first();
		$to_prep        = explode( ',', $imploded );
		$generator      = new Przelewy24Generator( $main_gateway );
		$icon_generator = new P24_Icon_Generator();

		$this->extra_gateways = array();
		foreach ( $to_prep as $id ) {
			$total = ( null !== WC()->cart ) ? (int) WC()->cart->total : 0;
			if ( ! $this->is_p24_now_allowed( $total, $currency ) && 266 === (int) $id ) {
				continue;
			}
			if ( ! $id ) {
				continue;
			} elseif ( ! isset( $all_banks[ $id ] ) ) {
				continue;
			}
			$icon = $icon_generator->get_icon( $id );
			if ( ! $icon ) {
				/* Fallback. */
				$icon = PRZELEWY24_URI . 'logo.png';
			}

			$this->extra_gateways[] = new P24_Extra_Gateway( $id, $all_banks[ $id ], $generator, $main_gateway, $icon );
		}
	}

	/**
	 * Check if P24 Now is allowed
	 *
	 * @param numeric $amount Amount order.
	 * @param string  $currency Active currency.
	 *
	 * @return bool
	 */
	private function is_p24_now_allowed( $amount, $currency ) {
		return $amount > 0 && $amount < 10000 && 'PLN' === $currency;
	}

	/**
	 * Inject additional gateways.
	 *
	 * Used for super first methods.
	 *
	 * @param array $gateways Prepared gateways.
	 * @return array
	 * @throws LogicException Throws if executed too early.
	 */
	public function inject_additional_gateways( $gateways ) {
		if ( array_key_exists( WC_Gateway_Przelewy24::PAYMENT_METHOD, $gateways ) ) {
			if ( ! isset( $this->extra_gateways ) ) {
				throw new LogicException( 'The extra getways are not prepared yet.' );
			}
			foreach ( $this->extra_gateways as $extra ) {
				$gateways[ $extra->id ] = $extra;
			}
		}
		return $gateways;
	}

	/**
	 * Check gateway name.
	 *
	 * @param string $subject The gateway name.
	 * @return bool
	 */
	private function check_gateway_name( $subject ) {
		$prefix        = WC_Gateway_Przelewy24::PAYMENT_METHOD . '_extra_';
		$prefix_quoted = preg_quote( $prefix, '/' );
		$pattern       = '/^' . $prefix_quoted . '\d+$/';
		return (bool) preg_match( $pattern, $subject );
	}

	/**
	 * Do hack on hidden box.
	 *
	 * @param mixed     $default We are not interested in changing this variable.
	 * @param WP_Screen $screen Data about active screen.
	 * @return mixed Return default value.
	 */
	public function do_hack_on_hidden_box( $default, WP_Screen $screen ) {
		/* Fix refunds */
		if ( 'woocommerce' === $screen->parent_base && 'shop_order' === $screen->post_type ) {
			/* We have to try to overwrite this global variable. */
			global $theorder;
			if ( $theorder instanceof \Automattic\WooCommerce\Admin\Overrides\Order ) {
				$old_method = $theorder->get_payment_method();
				if ( $this->check_gateway_name( $old_method ) ) {
					try {
						$theorder->set_payment_method( WC_Gateway_Przelewy24::PAYMENT_METHOD );
					} catch ( WC_Data_Exception $ex ) {
						error_log( __METHOD__ . ' There is and errow with unkown plugin.' ); // phpcs:ignore
						error_log( __METHOD__ . $ex->getMessage() ); // phpcs:ignore

						return $default;
					}
				}
			}
		}

		/* We are not interested in altering default value. */
		return $default;
	}

	/**
	 * Hack to fix refund.
	 *
	 * @param string   $gateway_name The gateway name.
	 * @param WC_Order $order The order.
	 * @return string
	 */
	public function do_hack_to_fix_refund( $gateway_name, WC_Order $order ) {
		if ( is_admin() ) {
			if ( $this->check_gateway_name( $gateway_name ) ) {
				if ( $order instanceof \Automattic\WooCommerce\Admin\Overrides\Order ) {
					return WC_Gateway_Przelewy24::PAYMENT_METHOD;
				}
			}
		}

		return $gateway_name;
	}

	/**
	 * Bind common events.
	 */
	public function bind_common_events() {
		add_filter( 'woocommerce_available_payment_gateways', array( $this, 'inject_additional_gateways' ), 20, 1 );
		add_filter( 'default_hidden_meta_boxes', array( $this, 'do_hack_on_hidden_box' ), 5, 2 );
		add_filter( 'woocommerce_order_get_payment_method', array( $this, 'do_hack_to_fix_refund' ), 10, 2 );
	}
}
