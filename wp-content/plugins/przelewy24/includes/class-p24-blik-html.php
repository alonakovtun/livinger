<?php
/**
 * File that define P24_Soap_Blik_Html.
 *
 * @package Przelewy24
 */

defined( 'ABSPATH' ) || exit;


/**
 * Class P24_Soap_Blik_Html
 */
class P24_Blik_Html {

	/**
	 * Plugin core.
	 *
	 * @var P24_Core The plugin core.
	 */
	private $core;

	/**
	 * P24_Blik_Html constructor.
	 *
	 * @param P24_Core $core The plugin core.
	 */
	public function __construct( $core ) {
		$this->core = $core;
		add_action( 'woocommerce_checkout_after_order_review', array( $this, 'extend_checkout_page_form' ) );
		add_action( 'woocommerce_after_checkout_form', array( $this, 'extend_checkout_page_bottom' ) );
	}

	/**
	 * Get additional HTML code for checkout form.
	 */
	public function extend_checkout_page_form() {
		echo '<input type="hidden" id="p24-blik-code-input" name="p24-blik-code">';
	}

	/**
	 * Extend_checkout_page_bottom.
	 *
	 * Check and embed code for modal if needed on checkout page.
	 */
	public function extend_checkout_page_bottom() {
		$config = $this->core->get_config_for_currency();
		$config->access_mode_to_strict();
		if ( $config->get_p24_payinshop() ) {
			self::echo_modal_html();
		}
	}

	/**
	 * Get HTML code for modal
	 *
	 * @return string
	 */
	public static function get_modal_html() {
		$header = esc_html( __( 'Wprowadź kod BLIK', 'przelewy24' ) );
		$label  = esc_html( __( 'Wprowadź 6-cyfrowy kod BLIK pobrany z aplikacji bankowej.', 'przelewy24' ) );
		$error  = esc_html( __( 'Niepoprawny kod BLIK.', 'przelewy24' ) );
		$button = esc_html( __( 'Zapłać', 'przelewy24' ) );
		return <<<MODAL
			<div id="p24-blik-modal-background">
				<div id="p24-blik-modal-holder">
					<div id="p24-blik-modal">
						<h1>$header</h1>
						<a href="" class="close-modal">✖</a>
						<form>
							<div>
								<p>$label</p>
								<p>
									<input type="text" name="blik" placeholder="______" pattern="^\d{6}$" maxlength="6">
								</p>
								<p class="error">$error</p>
								<p>
									<button>$button</button>
								</p>
							</div>
						</form>
					</div>
				</div>
			</div>
MODAL;
	}

	/**
	 * Echo HTML code for modal
	 */
	public static function echo_modal_html() {
		echo self::get_modal_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
