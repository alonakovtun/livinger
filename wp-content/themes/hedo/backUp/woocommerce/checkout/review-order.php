<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="shop_table woocommerce-checkout-review-order-table checkout__left checkout__total">
    <div class="checkout__title flex jc-start al-center billing-summary">
        <h3 class="txt-20 txt-light txt-upper ls-08"><?php esc_html_e('Billing summary', 'woocommerce'); ?></h3>
    </div>
    <div class="cart_list cart_list-left">
        <?php
        do_action( 'woocommerce_review_order_before_cart_contents' );

        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
            $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
            $product_id   = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
            if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                ?>
                <div class="b-cart-item cart-item woocommerce-mini-cart-item">
                    <div class="cart-item__image">
                        <img src="<?= get_the_post_thumbnail_url($product_id); ?>" alt="" />
                    </div>
                    <div class="cart-item__info flex js-space fl-column">
                        <div class="cart-item__head flex jc-space al-start flex1">
                            <div class="support-box">
                                <a class="cart-item__title txt-18 txt-light txt-upper">
                                    <?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ) . '&nbsp;'; ?>
                                </a>
                                <p class="product__sku txt-14 lh-24 mb-40">Nr produktu: <?= $_product->sku ?></p>
                            </div>
                            <p class="txt-18 txt-light txt-upper">
                                <?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                            </p>
                        </div>
                        <div class="cart-item__body flex jc-space al-center">
                            <div class="cart-item__qty">
                                <div data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>" data-key="<?= esc_attr($cart_item_key) ?>" data-qty="<?= $cart_item['quantity']; ?>" class="b-cart-item_qty p_qty product-quantity qib-container flex jc-start al-center">
                                    <button type="button" class="minus <?= $qty_class; ?>">
                                        -
                                    </button>
                                    <div class="input-qty">
                                        <?php echo esc_html__('', 'hedonizm') . '<span>' . $cart_item['quantity'] . '</span>'; ?>
                                    </div>
                                    <?php $qty_class = ($cart_item['quantity'] > 1) ? '' : 'm-disabled'; ?>
                                    <button type="button" class="plus">
                                        +
                                    </button>
                                </div>
                            </div>
                            <?php
                            echo apply_filters('woocommerce_cart_item_remove_link', sprintf(
                                '<a href="%s" class="checkout__remove remove removed_from_cart" aria-label="%s">%s</a>',
                                esc_url(wc_get_cart_remove_url($cart_item_key)),
                                __('x', 'woocommerce'),
                                __('x', 'hedonizm')
                            ), $cart_item_key);
                            ?>
                        </div>
                    </div>
                </div>
                <?php
            }
        }

        do_action( 'woocommerce_review_order_after_cart_contents' );
        ?>

    </div>
	<div class="cart__bottom-review">

        <a href="#" class="showcoupon woocommerce-form-coupon-toggle checkout__invoice hov-underline-dont">
            <?php wc_print_notice( apply_filters( 'woocommerce_checkout_coupon_message', ' <p class="txt-20 txt-light txt-transform-none c-black ls-08">' . esc_html__( 'Want to use Gift Card or Coupon Code?', 'woocommerce' ) . '</p>' ), 'notice' ); ?>
            <span class="chagle-plus"></span>
        </a>
        <div class="checkout_coupon woocommerce-form-coupon" method="post" style="display:none">
            <p class="form-row form-row-first">
                <input type="text" name="coupon_code" class="input-text textarea__input" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" id="coupon_code" value="" />
            </p>
        </div>
		<div class="review-oreder__total-shipping">
            <div class="cart-subtotal flex jc-space al-center mb-48">
                <p class="txt-18"><?php esc_html_e( 'Item total', 'woocommerce' ); ?></p>
                <p class="txt-18 txt-upper"><?php wc_cart_totals_subtotal_html(); ?></p>
            </div>
            <div class="cart-subtotal flex jc-space al-center">
                <p class="txt-18"><?php esc_html_e( 'Shipping to Poland', 'woocommerce' ); ?></p>
                <p class="txt-18 txt-upper">0 ZŁ</p>
            </div>
            <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
                <div class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>" style="display: none">
                    <div><?php wc_cart_totals_coupon_label( $coupon ); ?></div>
                    <div><?php wc_cart_totals_coupon_html( $coupon ); ?></div>
                </div>
            <?php endforeach; ?>
            <div style="display:none;">
                <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

                    <?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

                    <?php wc_cart_totals_shipping_html(); ?>

                    <?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

                <?php endif; ?>
            </div>

            <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
                <div class="fee">
                    <div><?php echo esc_html( $fee->name ); ?></div>
                    <div><?php wc_cart_totals_fee_html( $fee ); ?></div>
                </div>
            <?php endforeach; ?>

            <?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
                <?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
                    <?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
                        <div class="tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                            <div><?php echo esc_html( $tax->label ); ?></div>
                            <div><?php echo wp_kses_post( $tax->formatted_amount ); ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="tax-total">
                        <div><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></div>
                        <div><?php wc_cart_totals_taxes_total_html(); ?></div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>

		<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

		<div class="order-total flex jc-space al-center">
			<p class="txt-upper"><?php esc_html_e( 'Total', 'woocommerce' ); ?></p>
			<p><?php wc_cart_totals_order_total_html(); ?></p>
		</div>

		<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

	</div>
</div>
