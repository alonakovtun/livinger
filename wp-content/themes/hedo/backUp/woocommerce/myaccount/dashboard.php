<?php

/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

$allowed_html = array(
  'a' => array(
    'href' => array(),
  ),
);
?>
<div class="account__dash">
  <p class="txt-18 txt-light txt-upper c-black-mini txt-center mb-20">
    <?php
    printf(
      /* translators: 1: user display name 2: logout url */
      wp_kses(__('Hello %1$s', 'woocommerce'), $allowed_html),
      '<strong>' . esc_html($current_user->display_name) . '</strong>',
      esc_url(wc_logout_url())
    );
    ?>
  </p>

  <p class="txt-16 lh-27 txt-light c-black-mini txt-center">
    <?= esc_html('From your account dashboard  you can view your recent orders, manage your shipping and billing addresses, and edit your password and account details.', 'woocommerce') ?>
  </p>

  <p class="account__logout txt-16 lh-27 txt-light c-black-mini txt-center mt-20">
    <?php
    printf(
      /* translators: 1: user display name 2: logout url */
      wp_kses(__('Not %1$s? <a class="txt-16 txt-light c-black-mini txt-underline" href="%2$s">Log out</a>', 'woocommerce'), $allowed_html),
      '' . esc_html($current_user->display_name) . '',
      esc_url(wc_logout_url())
    );
    ?>
  </p>

  <?php
  /**
   * My Account dashboard.
   *
   * @since 2.6.0
   */
  do_action('woocommerce_account_dashboard');
  ?>
</div>
<?php

/**
 * Deprecated woocommerce_before_my_account action.
 *
 * @deprecated 2.6.0
 */
do_action('woocommerce_before_my_account');

/**
 * Deprecated woocommerce_after_my_account action.
 *
 * @deprecated 2.6.0
 */
do_action('woocommerce_after_my_account');

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
