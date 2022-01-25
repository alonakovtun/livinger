<?php
/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.4
 */

defined( 'ABSPATH' ) || exit;

if ( ! wc_coupons_enabled() ) { // @codingStandardsIgnoreLine.
	return;
}

?>
<div class="checkout_coupon-none">
    <a href="#" class="showcoupon woocommerce-form-coupon-toggle checkout__invoice hov-underline-dont">
        <?php wc_print_notice( apply_filters( 'woocommerce_checkout_coupon_message', ' <p class="txt-20 txt-light txt-upper c-black ls-08">' . esc_html__( 'Want to use Gift Card or Coupon Code?', 'woocommerce' ) . '</p>' ), 'notice' ); ?>
        <span class="chagle-plus"></span>
    </a>
    <form class="checkout_coupon woocommerce-form-coupon" method="post" style="display:none">
        <p class="form-row form-row-first">
            <input type="text" name="coupon_code" class="input-text textarea__input" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" id="coupon_code" value="" />
        </p>

        <p class="form-row form-row-last">
            <button type="submit" class="button button__input txt-upper" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_html_e( 'Apply coupon', 'woocommerce' ); ?></button>
        </p>

        <div class="clear"></div>
    </form>
</div>
