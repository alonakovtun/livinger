<?php

function hedo_scripts()
{
  wp_enqueue_style('hedo-style', get_stylesheet_uri(), array(), _S_VERSION);
  wp_enqueue_style('hedo-style-default', get_template_directory_uri() . '/assets/css/base.css', array(), _S_VERSION);

  wp_enqueue_script('feather', get_template_directory_uri() . '/assets/js/app.js', array(), _S_VERSION, true);
}

add_action('wp_enqueue_scripts', 'hedo_scripts');

add_action('wp_default_scripts', 'zl_remove_jquery_migrate');
function zl_remove_jquery_migrate($scripts)
{
  if (!is_admin() && isset($scripts->registered['jquery'])) {

    $script = $scripts->registered['jquery'];

    if ($script->deps) {
      $script->deps = array_diff($script->deps, array('jquery-migrate'));
    }
  }
}

add_action('hook_count_all_products', 'my_count_all_products');
function my_count_all_products()
{
  if (is_shop()) {
    $args = array('post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => -1);
    $products = new WP_Query($args);
    echo '<p class="filters__total-product txt-18 c-gold"> Liczba produktów: ' . $products->found_posts . '</p>';
  }
}

add_action('wp_head', 'custom_ajax_spinner', 1000);
function custom_ajax_spinner()
{
?>
  <style>
    .wcapf-before-update {
      background-image: url('<?php echo get_stylesheet_directory_uri() . "/assets/img/preloader.gif"; ?>') !important;
      background-size: 80px;
      ;
    }

    .woocommerce .blockUI.blockOverlay:before,
    .woocommerce .loader:before {
      background-image: url('<?php echo get_stylesheet_directory_uri() . "/assets/img/preloader.gif"; ?>') !important;
    }

    .blockUI {
      background: rgba(255, 255, 255, 0.2) !important;
      background-image: none !important;
    }

    /* .blockUI.blockOverlay */
  </style>
<?php
}

add_filter('woocommerce_enqueue_styles', '__return_false');

function theme_translations_js()
{
  wp_localize_script('jquery', 'pzl', array(
    'url' => array(
      'theme'  => get_template_directory_uri(),
      'ajax'   => admin_url('admin-ajax.php'),
    ),
    'nounce' => wp_create_nonce('ajax'),
    'l18n'   => array(
      'btnAddToCartValidation' => __('Choose option', 'hedo'),
    )
  ));
}
add_action('wp_enqueue_scripts', 'theme_translations_js');

add_filter('woocommerce_form_field', 'my_woocommerce_form_field');
function my_woocommerce_form_field($field)
{
  return preg_replace(
    '#<p class="form-row (.*?)"(.*?)>(.*?)</p>#',
    '<div class="form-row $1 textarea"$2>$3</div>',
    $field
  );
}

function primer_add_wishlist_endpoint()
{
  add_rewrite_endpoint('wish-list', EP_ROOT | EP_PAGES);
}

add_action('init', 'primer_add_wishlist_endpoint');

function primer_wishlist_query_vars($vars)
{
  $vars[] = 'wish-list';
  return $vars;
}

add_filter('query_vars', 'primer_wishlist_query_vars', 0);

function wpb_woo_my_account_order()
{
  $myorder = array(
    'dashboard'       => __('MOje konto', 'woocommerce'),
    'orders'          => __('zamówienia', 'woocommerce'),
    'edit-address'    => _n('moje adresy', 'moje adresy', (int) wc_shipping_enabled(), 'woocommerce'),
    //        'payment-methods' => __( 'Payment methods', 'woocommerce' ),
    'edit-account'    => __('szczegóły konta', 'woocommerce'),
    'wish-list'           => __('ulubione', 'woocommerce'),
    'customer-logout' => __('wyloguj', 'woocommerce'),
  );
  return $myorder;
}

add_filter('woocommerce_account_menu_items', 'wpb_woo_my_account_order');


function woocommerce_wishlist_content()
{
  echo do_shortcode('[yith_wcwl_wishlist]');
}

add_action('woocommerce_account_wish-list_endpoint', 'woocommerce_wishlist_content');

// Hook into the checkout fields (shipping & billing)
add_filter('woocommerce_checkout_fields', 'custom_override_checkout_fields');

// Hook into the default fields
add_filter('woocommerce_default_address_fields', 'custom_override_default_address_fields');



function custom_override_checkout_fields($fields)
{
  unset($fields['billing']['billing_postcode']);
  unset($fields['shipping']['shipping_postcode']);

  return $fields;
}

function custom_override_default_address_fields($address_fields)
{
  unset($address_fields['postcode']);

  return $address_fields;
}

function custom_form_field_args($args, $key, $value)
{
  $args['placeholder'] = $args['label'];
  return $args;
};
add_filter('woocommerce_form_field_args', 'custom_form_field_args',      10, 3);
