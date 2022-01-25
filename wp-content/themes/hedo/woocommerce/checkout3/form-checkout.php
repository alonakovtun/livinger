<?php

/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if (!defined('ABSPATH')) {
  exit;
}

do_action('woocommerce_before_checkout_form', $checkout);

// If checkout registration is disabled and not logged in, the user cannot checkout.
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
  echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
  return;
}

?>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

  <?php if ($checkout->get_checkout_fields()) : ?>

    <?php do_action('woocommerce_checkout_before_customer_details'); ?>
    <div class="flex js-space al-stretch">
      <div class="col2-set flex1 checkout__left" id="customer_details">
        <?php do_action('woocommerce_checkout_billing'); ?>



        <div class="checkout__billing-summary">
          <div class="checkout__title flex jc-start al-center">
            <h3 class="txt-20 txt-light txt-upper ls-08"><?php esc_html_e('Billing &amp; details', 'woocommerce'); ?></h3>
          </div>
          <div class="checkout-total-wrap">
            <div class="cart-coupon-form-wrap">
              <div id="coupon-form">
                <div class="checkout_coupon">
                  <p class="form-row">
                    <input type="text" name="coupon_code" class="input-text" placeholder="<?php esc_attr_e('Want to use Gift Card or Coupon Code?', 'hedonizm'); ?>" id="coupon_code" value="" />
                    <input id="apply_coupon" type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e('Add', 'hedonizm'); ?>" />
                  </p>

                  <div class="clear"></div>
                </div>
              </div>
            </div>

            <?php if (WC()->cart->get_coupons()) : ?>
              <p class="step-title"><?php echo esc_html__('Want to use Gift Card or Coupon Code? ', 'hedonizm'); ?></p>
              <?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
                <div class="cart-discount coupon-<?php echo esc_attr(sanitize_title($code)); ?>">
                  <span><?php wc_cart_totals_coupon_label($coupon); ?></span>
                  <span class="value"><?php wc_cart_totals_coupon_html($coupon); ?></span>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>


            <?php do_action('woocommerce_review_order_before_order_total'); ?>
            <?php
            $cart_totals = WC()->cart->get_totals();
            $curr        = get_woocommerce_currency_symbol();
            ?>
            <div class="order-total-cart checkout__prices txt-20 txt-light flex jc-space al-center">
              <span class="txt-08"><?php _e('Order value', 'hedonizm'); ?></span>
              <span class="value"><?= $cart_totals['cart_contents_total'] + $cart_totals['cart_contents_tax'] . ' ' . $curr; ?></span>
            </div>
            <div class="order-total-ship checkout__prices txt-20 txt-light flex jc-space al-center">
              <span class="txt-08"><?php _e('Shipping value', 'hedonizm'); ?></span>
              <span class="value"><?= $cart_totals['shipping_total'] + $cart_totals['shipping_tax'] . ' ' . $curr; ?></span>
            </div>
            <div class="order-total checkout__prices txt-20 txt-light flex jc-space al-center">
              <span class="txt-08"><?php _e('Total', 'woocommerce'); ?></span>
              <span class="value"><?php wc_cart_totals_order_total_html(); ?></span>
            </div>
          </div>

          <!-- PAYMENT Payments start -->
          <div class="checkout__title checkout__title_payment flex jc-start al-center">
            <h3 class="txt-20 txt-light txt-upper ls-08"><?php _e('Payment method', 'paris_hedzel_shop'); ?></h3>
          </div>
          <div id="payment" class="woocommerce-checkout-payment payment">
            <?php if (WC()->cart->needs_payment()) : ?>
              <div class="payment__menu">
                <?php
                if (!empty($available_gateways)) {
                  foreach ($available_gateways as $gateway) {
                    wc_get_template('checkout/payment-method.php', array('gateway' => $gateway));
                  }
                } else {
                  echo '<div>' . apply_filters('woocommerce_no_available_payment_methods_message', WC()->customer->get_country() ? __('Sorry, it seems that there are no available payment methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce') : __('Please fill in your details above to see available payment methods.', 'woocommerce')) . '</div>';
                }
                ?>
              </div>
            <?php endif; ?>

          </div>
          <!-- ENDPAYMENT Payments end -->

          <?php do_action('woocommerce_review_order_after_order_total'); ?>
        </div>


      </div>
      <div id="order_review" class="checkout__right">
        <?php do_action('woocommerce_checkout_order_review'); ?>
      </div>
    </div>

    <?php do_action('woocommerce_checkout_after_customer_details'); ?>

  <?php endif; ?>

  <?php // do_action('woocommerce_checkout_before_order_review_heading');
  ?>

  <!-- <h3 id="order_review_heading"><?php // esc_html_e('Your order', 'woocommerce');
                                      ?></h3> -->

  <?php do_action('woocommerce_checkout_before_order_review'); ?>

  <!-- <div id="order_review" class="woocommerce-checkout-review-order"> -->
  <?php // do_action('woocommerce_checkout_order_review');
  ?>
  <!-- </div> -->

  <?php do_action('woocommerce_checkout_after_order_review'); ?>

</form>
<script>
  (function($) {

    $(document).ready(function() {

      $(document).on('change', "#vat-fields-tgl", function(event) {

        $(".vat-fields-wrap").slideToggle();

        return false;
      });

      $(document).on('change', "#billing_country, #shipping_country, .country_to_state", function(event) {
        $(document.body).trigger('update_checkout');
      });

      $(document.body).on('click', '#coupon-form #apply_coupon', function(e) {

        var $container = $(this).parent();

        if ($container.is('.processing')) {
          return false;
        }

        $container.addClass('processing').block({
          message: null,
          overlayCSS: {
            background: '#fff',
            opacity: 0.6
          }
        });

        var data = {
          security: wc_checkout_params.apply_coupon_nonce,
          coupon_code: $container.find('input[name="coupon_code"]').val()
        };

        $.ajax({
          type: 'POST',
          url: wc_checkout_params.wc_ajax_url.toString().replace('%%endpoint%%', 'apply_coupon'),
          data: data,
          success: function(code) {
            $('.woocommerce-error, .woocommerce-message').remove();
            $container.removeClass('processing').unblock();

            if (code) {
              $container.before(code);

              $(document.body).trigger('update_checkout');
            }
          },
          dataType: 'html'
        });

        return false;
      });
    });

  })(jQuery);
</script>
<?php do_action('woocommerce_after_checkout_form', $checkout); ?>