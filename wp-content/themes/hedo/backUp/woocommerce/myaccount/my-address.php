<?php

/**
 * My Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-address.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.6.0
 */

defined('ABSPATH') || exit;

$customer_id = get_current_user_id();

if (!wc_ship_to_billing_address_only() && wc_shipping_enabled()) {
  $get_addresses = apply_filters(
    'woocommerce_my_account_get_addresses',
    array(
      'billing'  => __('Billing address', 'woocommerce'),
      'shipping' => __('Shipping address', 'woocommerce'),
    ),
    $customer_id
  );
} else {
  $get_addresses = apply_filters(
    'woocommerce_my_account_get_addresses',
    array(
      'billing' => __('Billing address', 'woocommerce'),
    ),
    $customer_id
  );
}

$oldcol = 1;
$col    = 1;
?>

<?php if (!wc_ship_to_billing_address_only() && wc_shipping_enabled()) : ?>
  <div class="account__address flex jc-space al-stretch">

  <?php endif; ?>

  <?php foreach ($get_addresses as $name => $address_title) : ?>
    <?php
    $address = wc_get_account_formatted_address($name);
    $col     = $col * -1;
    $oldcol  = $oldcol * -1;
    ?>

    <div class="account__address-col flex1 mr-15 ml-15">
      <header class="checkout__title flex jc-space al-center">
        <h3 class="txt-20 txt-light txt-upper ls-08"><?php echo esc_html($address_title); ?></h3>
        <a href="<?php echo esc_url(wc_get_endpoint_url('edit-address', $name)); ?>" class="account__address-edit txt-16 txt-light txt-upper txt-under hov-underline-dont c-black"><?php echo $address ? esc_html__('Edit', 'woocommerce') : esc_html__('Add', 'woocommerce'); ?></a>
      </header>
      <div class="account__address-body">
        <p class="txt-18 txt-light ls-00 lh-36">
          <?= $address ? wp_kses_post($address) : esc_html_e('You have not set up this type of address yet.', 'woocommerce'); ?>
        </p>
      </div>
    </div>

  <?php endforeach; ?>

  <?php if (!wc_ship_to_billing_address_only() && wc_shipping_enabled()) : ?>
  </div>
<?php
  endif;
