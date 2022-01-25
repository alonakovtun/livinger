<?php
/**
 * Output a single payment method
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment-method.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<li class="payment-method wc_payment_method payment_method_<?php echo esc_attr( $gateway->id ); ?>">
    <?php
    $icon = '';

    if (is_a($gateway, 'WC_Gateway_Paypal')) {
        $icon =  get_template_directory_uri() . '/assets/img/i-paypal.png';
    } elseif (is_a($gateway, 'WC_Payment_Gateway_BlueMedia')) {
        $icon = get_template_directory_uri() . '/assets/img/i-bluemedia.png';
    }
    ?>
    <input id="payment_method_<?php echo $gateway->id; ?>" type="radio" class="payment-method__check input-radio" name="payment_method" value="<?php echo esc_attr($gateway->id); ?>" <?php checked($gateway->chosen, true); ?> data-order_button_text="<?php echo esc_attr($gateway->order_button_text); ?>" />
    <label for="payment_method_<?php echo $gateway->id; ?>">
        <div class="payment-method__image">
            <img class="payment-method__img" src="<?= $icon; ?>" alt="">
        </div>
        <div class="payment-method__title"><?= $gateway->get_title(); ?></div>
    </label>
</li>
