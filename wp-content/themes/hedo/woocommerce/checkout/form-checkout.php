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
<div class="checkout__header-title">
  <input type="button" onclick="history.go(-1);" value="Powrót" class="trigger-change button__reset button__back button__back_absolute" />
  <p class="checkout__txt-title txt-center">
    <?= is_user_logged_in() ? esc_html('Podsumowanie', 'hedo') : esc_html('Kup jako', 'hedo') ?>
  </p>
</div>
<?php
if (!is_user_logged_in()) {
  get_template_part('template-parts/hedo-login');
}

?>

<form name="checkout" method="post" class="checkout woocommerce-checkout checkout-swap <?= !is_user_logged_in() ? 'checkout__hidden' : '' ?>" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">
  <div class="flex jc-space al-start ">
    <div class="column-left">
      <?php if ($checkout->get_checkout_fields()) : ?>

        <?php do_action('woocommerce_checkout_before_customer_details'); ?>

        <div class="col2-set checkout__left" id="customer_details">
          <?php do_action('woocommerce_checkout_billing'); ?>
          <?php do_action('woocommerce_checkout_shipping'); ?>
          <p class="form-row checkout__invoice  invoice-vat-fields-tgl checkout__invoice_border">
            <?php _e('Invoice data (optional)', 'hedonizm'); ?>
            <span class="chagle-plus"></span>
          </p>
          <div class="checkout__invoice-bottom">
            <?php do_action('woocommerce_invoice_vat_fields', $checkout); ?>
          </div>
        </div>

        <?php do_action('woocommerce_checkout_after_customer_details'); ?>
      <?php endif; ?>

      <?php do_action('woocommerce_checkout_before_order_review_heading'); ?>

      <?php do_action('woocommerce_checkout_before_order_review'); ?>

      <div id="order_review" class="woocommerce-checkout-review-order">
        <?php do_action('woocommerce_checkout_order_review'); ?>
      </div>

      <?php do_action('woocommerce_checkout_after_order_review'); ?>
    </div>
    <div class="column-right checkout__right">
      <?php do_action('woocommerce_checkout_before_order_review_heading'); ?>

      <?php do_action('woocommerce_checkout_before_order_review'); ?>

      <div id="order_review" class="woocommerce-checkout-review-order">
        <?php do_action('woocommerce_checkout_order_review'); ?>
      </div>

      <div class="uwagi shop_table checkout__left checkout__total">
        <div class="checkout__title flex jc-start al-center billing-summary">
          <h3 class="txt-20 txt-light txt-upper ls-08"><?php esc_html_e('Uwagi', 'woocommerce'); ?></h3>
        </div>
        <div class="uwagi__body">
          <?php do_action('woocommerce_uwagi_fields', $checkout); ?>
        </div>
      </div>


      <?php do_action('woocommerce_checkout_after_order_review'); ?>
    </div>
  </div>
</form>
<?php do_action('woocommerce_after_checkout_form', $checkout); ?>