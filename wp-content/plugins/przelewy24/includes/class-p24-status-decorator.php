<?php
/**
 * File that define P24_Status_Decorator class.
 *
 * @package Przelewy24
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class to decorate order statuses.
 */
class P24_Status_Decorator {

	/**
	 * Suffix to use for status for the database.
	 * The length is very limited.
	 */
	const STATUS_SUFFIX = '-p24';

	/**
	 * Suffix to use for status for humans.
	 */
	const STATUS_SUFFIX_HUMAN = ' Przelewy24';

	/**
	 * Config factory.
	 *
	 * @var callable
	 */
	private $config_factory;

	/**
	 * In_decoration_mode.
	 *
	 * @var bool
	 */
	private $in_decoration_mode = false;

	/**
	 * Status provider.
	 *
	 * @var P24_Status_Provider
	 */
	private $status_provider;

	/**
	 * P24_Status_Decorator constructor.
	 *
	 * @param callable            $config_factory The config factory.
	 * @param P24_Status_Provider $status_provider Status provider.
	 */
	public function __construct( $config_factory, $status_provider ) {
		$this->config_factory  = $config_factory;
		$this->status_provider = $status_provider;
	}

	/**
	 * Get config in strict mode.
	 *
	 * @param string $currency The currency.
	 * @return P24_Config_Accessor
	 * @throws LogicException Should be not thrown in normal operation.
	 */
	private function get_config( $currency ) {
		/* It may be not initialized. */
		if ( is_callable( $this->config_factory ) ) {
			$config_factory = $this->config_factory;
			$config         = $config_factory( $currency );
		} else {
			$config = P24_Settings_Helper::load_settings( $currency );
		}
		if ( ! $config ) {
			throw new LogicException( 'Cannot load config for provided currency.' );
		}
		$config->access_mode_to_strict();

		return $config;
	}

	/**
	 * Set decoration mode.
	 *
	 * @param bool   $mode Desired mode of decorator.
	 * @param string $currency Currency.
	 * @return bool
	 */
	public function try_set_decoration_mode( $mode, $currency ) {
		$config_accessor = $this->get_config( $currency );
		if ( $mode && $config_accessor->get_p24_use_special_status() ) {
			$this->in_decoration_mode = true;
		} else {
			$this->in_decoration_mode = false;
		}

		return $this->in_decoration_mode;
	}

	/**
	 * Check if code is in edit mode of order.
	 *
	 * @return bool
	 */
	private function check_if_in_edit_mode() {
		global $typenow;
		global $editing;
		return 'shop_order' === $typenow && $editing;
	}

	/**
	 * Check if from Przelewy24.
	 *
	 * @param WC_Order $order The order from client.
	 */
	private function check_if_from_przelewy24( $order ) {
		/* We have to support two types of gateways: main and extra. */
		$rx     = '/^przelewy24(\_extra\_\d+)?$/';
		$method = $order->get_payment_method();
		return preg_match( $rx, $method );
	}

	/**
	 * Add pending status.
	 *
	 * @param WC_Order $order The order.
	 * @param array    $data  Additional order data.
	 */
	public function try_set_custom_pending_status( $order, $data ) {
		if ( $this->check_if_from_przelewy24( $order ) ) {
			$config_accessor = $this->get_config( $order->get_currency() );
			if ( $config_accessor->get_p24_use_special_status() ) {
				$custom_pending_status = $config_accessor->get_p24_custom_pending_status();
				if ( $custom_pending_status ) {
					$order->set_status( $custom_pending_status );
				} else {
					$order->set_status( 'pending' . self::STATUS_SUFFIX );
				}
			}
		}
	}

	/**
	 * Decorate order status.
	 *
	 * @param string   $status Proposed new status for order.
	 * @param int      $order_id Order id.
	 * @param WC_Order $order Order object.
	 */
	public function try_set_custom_processing_status( $status, $order_id, $order ) {
		if ( $this->in_decoration_mode ) {
			if ( 'processing' === $status ) {
				$config_accessor          = $this->get_config( $order->get_currency() );
				$custom_processing_status = $config_accessor->get_p24_custom_processing_status();
				if ( $custom_processing_status ) {
					return $custom_processing_status;
				} else {
					return $status . self::STATUS_SUFFIX;
				}
			}
		}

		return $status;
	}

	/**
	 * Add valid statuses.
	 *
	 * @param array $statuses Default WooCommerce statuses.
	 * @return array
	 */
	public function add_valid_statuses( $statuses ) {
		/*
		 * We have to add status with and without wc- prefix. There is a mess in WooCommerce code.
		 * There is an exception from this rule though.
		 */
		if ( ! $this->check_if_in_edit_mode() ) {
			$statuses[ 'pending' . self::STATUS_SUFFIX ]    = $statuses['wc-pending'] . self::STATUS_SUFFIX_HUMAN;
			$statuses[ 'processing' . self::STATUS_SUFFIX ] = $statuses['wc-processing'] . self::STATUS_SUFFIX_HUMAN;
			$statuses                                      += $this->status_provider->get_additional_valid_statuses( '' );
		}
		$statuses[ 'wc-pending' . self::STATUS_SUFFIX ]    = $statuses['wc-pending'] . self::STATUS_SUFFIX_HUMAN;
		$statuses[ 'wc-processing' . self::STATUS_SUFFIX ] = $statuses['wc-processing'] . self::STATUS_SUFFIX_HUMAN;
		$statuses += $this->status_provider->get_additional_valid_statuses( 'wc-' );

		return $statuses;
	}

	/**
	 * Add valid statuses for unpaid.
	 *
	 * @param array    $defaults Default unpaid statuses.
	 * @param WC_Order $order Order.
	 * @return array
	 */
	public function add_valid_for_unpaid( $defaults, $order ) {
		if ( ! $this->check_if_from_przelewy24( $order ) ) {
			return $defaults;
		} else {
			$defaults[]      = 'pending' . self::STATUS_SUFFIX;
			$config_accessor = $this->get_config( $order->get_currency() );
			$defaults[]      = $config_accessor->get_p24_custom_pending_status();
		}

		return $defaults;
	}

	/**
	 * Add valid status to change from.
	 *
	 * @param array $defaults Default WooCommerce statuses.
	 * @return array
	 */
	public function add_valid_for_from( $defaults ) {
		$defaults[] = 'pending' . self::STATUS_SUFFIX;
		$defaults[] = 'processing' . self::STATUS_SUFFIX;
		$additional = $this->status_provider->get_additional_valid_statuse_codes( '' );
		$defaults   = array_merge( $defaults, $additional );
		/* We have to add status with and without wc- prefix. There is a mess in WooCommerce code. */
		$defaults[] = 'wc-pending' . self::STATUS_SUFFIX;
		$defaults[] = 'wc-processing' . self::STATUS_SUFFIX;
		$additional = $this->status_provider->get_additional_valid_statuse_codes( 'wc-' );
		$defaults   = array_merge( $defaults, $additional );

		return $defaults;
	}

	/**
	 * Fix statuses in args.
	 *
	 * @param array $default Default args.
	 * @param array $extra Extra data.
	 * @return array
	 */
	public function fix_statuses_in_args( $default, $extra ) {
		/* Used on my orders list. */
		$ret = $default;
		if ( isset( $default['post_status'] ) && is_array( $default['post_status'] ) ) {
			$statuses          = $default['post_status'];
			$custom_statuses   = $this->status_provider->get_additional_valid_statuse_codes( '' );
			$custom_statuses[] = 'pending' . self::STATUS_SUFFIX;
			$custom_statuses[] = 'processing' . self::STATUS_SUFFIX;
			foreach ( $statuses as $wk => $wv ) {
				if ( preg_match( '/^wc-(.+)/', $wv, $m ) ) {
					$ck = array_search( $m[1], $custom_statuses, true );
					if ( false !== $ck ) {
						/* There is a mess in WooCommerce code. Fix one of it. */
						$ret['post_status'][ $wk ] = $custom_statuses[ $ck ];
					}
				}
			}
		}

		return $ret;
	}

	/**
	 * Add valid status to change to.
	 *
	 * @param array $defaults Default WooCommerce statuses.
	 * @return array
	 */
	public function add_valid_for_to( $defaults ) {
		if ( $this->in_decoration_mode ) {
			$defaults[] = 'pending' . self::STATUS_SUFFIX;
			$defaults[] = 'processing' . self::STATUS_SUFFIX;
			$additional = $this->status_provider->get_additional_valid_statuse_codes( '' );
			$defaults   = array_merge( $defaults, $additional );
		}

		return $defaults;
	}

	/**
	 * Add description for status.
	 *
	 * @param array $defaults Default WooCommerce statuses.
	 * @return array
	 */
	public function add_all_status_descriptions( $defaults ) {
		$defaults[ 'pending' . self::STATUS_SUFFIX ]    = $this->prep_status_description( $defaults, 'wc-pending' );
		$defaults[ 'processing' . self::STATUS_SUFFIX ] = $this->prep_status_description( $defaults, 'wc-processing' );
		$defaults                                      += $this->status_provider->status_description_list( $defaults );

		return $defaults;
	}

	/**
	 * Prep status description.
	 *
	 * @param array  $defaults Default statuses.
	 * @param string $base_key The code for base status.
	 * @return array
	 */
	public function prep_status_description( array $defaults, $base_key ): array {
		$new          = $defaults[ $base_key ];
		$new['label'] = $new['label'] . self::STATUS_SUFFIX_HUMAN;

		$rx              = '/([^\\<]+)(\\<.*)/';
		$new_label_count = array();
		foreach ( $new['label_count'] as $k => $v ) {
			if ( is_string( $v ) && preg_match( $rx, $v, $m ) ) {
				$new_label_count[ $k ] = $m[1] . self::STATUS_SUFFIX_HUMAN . ' ' . $m[2];
			} else {
				$new_label_count[ $k ] = $v;
			}
		}
		$new['label_count'] = $new_label_count;

		return $new;
	}

	/**
	 * Signal internal status changes.
	 *
	 * @param int      $order_id Order id.
	 * @param string   $from Existing status.
	 * @param string   $to Proposed status.
	 * @param WC_Order $order The order.
	 */
	public function signal_more_status_changes( $order_id, $from, $to, $order ) {
		$need_action   = false;
		$internal_from = $from;
		$internal_to   = $to;

		$config_accessor = $this->get_config( $order->get_currency() );

		$statuses = array(
			'pending' . self::STATUS_SUFFIX    => 'pending',
			'processing' . self::STATUS_SUFFIX => 'processing',
			$config_accessor->get_p24_custom_pending_status() => 'pending',
			$config_accessor->get_p24_custom_processing_status() => 'processing',
		);

		foreach ( $statuses as $status => $internal ) {
			if ( $from === $status ) {
				$internal_from = $internal;
				$need_action   = true;
			}
			if ( $to === $status ) {
				$internal_to = $internal;
				$need_action = true;
			}
		}

		if ( $need_action ) {
			do_action( 'woocommerce_order_status_' . $internal_from . '_to_' . $internal_to, $order_id, $order );
			do_action( 'woocommerce_order_status_changed', $order_id, $internal_from, $internal_to, $order );
			if ( $internal_to !== $to ) {
				do_action( 'woocommerce_order_status_' . $internal_to, $order_id, $order );
			}
		}
	}

	/**
	 * Check need of payment.
	 *
	 * @param bool     $default Default need.
	 * @param WC_Order $order The order.
	 * @param array    $statuses List of statuses.
	 * @return bool
	 */
	public function check_need_of_payment( $default, $order, $statuses ) {
		if ( ! $this->check_if_from_przelewy24( $order ) ) {
			return $default;
		} elseif ( $default ) {
			$status                 = $order->get_status();
			$suffixed_paid_statuses = array(
				'processing' . self::STATUS_SUFFIX,
				'wc-processing' . self::STATUS_SUFFIX,
			);
			if ( in_array( $status, $suffixed_paid_statuses, true ) ) {
				return false;
			} else {
				$config_accessor = $this->get_config( $order->get_currency() );
				/* As long it is not precessing, we are fine. */
				return $config_accessor->get_p24_custom_processing_status() !== $status;
			}
		} else {
			return false;
		}
	}

	/**
	 * Validate statuses.
	 *
	 * It should be safe as long as they are different.
	 *
	 * @param string $pending Code for status penging.
	 * @param string $processing Code for status processing.
	 * @return bool
	 */
	public static function validate_statuses( $pending, $processing ) {
		if ( $pending ) {
			$pending = (string) $pending;
		} else {
			$pending = 'pending' . self::STATUS_SUFFIX;
		}
		if ( $processing ) {
			$processing = (string) $processing;
		} else {
			$processing = 'processing' . self::STATUS_SUFFIX;
		}

		return $processing !== $pending;
	}

	/**
	 * Check if module for statuses is active.
	 *
	 * @return bool
	 */
	public static function is_active() {
		$status = get_option( 'p24_statuses_active', 'no' );

		return 'yes' === $status;
	}

	/**
	 * Bind events.
	 */
	public function bind_events() {
		if ( ! self::is_active() ) {
			/* Nothing to bind. */
			return;
		}
		add_action( 'woocommerce_checkout_create_order', array( $this, 'try_set_custom_pending_status' ), 10, 2 );
		add_action( 'woocommerce_order_status_changed', array( $this, 'signal_more_status_changes' ), 5, 4 );
		add_filter( 'woocommerce_payment_complete_order_status', array( $this, 'try_set_custom_processing_status' ), 10, 3 );
		add_filter( 'woocommerce_valid_order_statuses_for_payment_complete', array( $this, 'add_valid_for_unpaid' ), 10, 2 );
		add_filter( 'woocommerce_valid_order_statuses_for_payment', array( $this, 'add_valid_for_from' ) );
		add_filter( 'woocommerce_order_is_paid_statuses', array( $this, 'add_valid_for_to' ) );
		add_filter( 'woocommerce_register_shop_order_post_statuses', array( $this, 'add_all_status_descriptions' ) );
		add_filter( 'wc_order_statuses', array( $this, 'add_valid_statuses' ) );
		add_filter( 'woocommerce_get_wp_query_args', array( $this, 'fix_statuses_in_args' ), 10, 2 );
		add_filter( 'woocommerce_order_needs_payment', array( $this, 'check_need_of_payment' ), 10, 3 );
	}

}
