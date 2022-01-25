<?php

/**
 * Add WooCommerce support
 *
 * @package Hedonizm
 */

add_action('woocommerce_invoice_vat_fields', 'invoice_vat_fields_init');

function invoice_vat_fields_init($checkout)
{

  woocommerce_form_field(
    'vat_nip_number',
    array(
      'type' => 'text',
      'label' => __('NIP/VAT', 'hedonizm'),
    ),
    $checkout->get_value('vat_company_name')
  );

  woocommerce_form_field(
    'vat_company_name',
    array(
      'type' => 'text',
      'label' => __('Company name', 'hedonizm'),
    ),
    $checkout->get_value('vat_company_name')
  );

  woocommerce_form_field(
    'vat_company_addres',
    array(
      'type' => 'text',
      'label' => __('Address', 'hedonizm'),
    ),
    $checkout->get_value('vat_company_addres')
  );

  woocommerce_form_field(
    'vat_company_zip_code',
    array(
      'type' => 'text',
      'label' => __('Zip code', 'hedonizm'),
    ),
    $checkout->get_value('vat_company_zip_code')
  );

  woocommerce_form_field(
    'vat_company_city',
    array(
      'type' => 'text',
      'label' => __('City', 'hedonizm'),
    ),
    $checkout->get_value('vat_company_city')
  );

  woocommerce_form_field(
    'vat_company_country',
    array(
      'type' => 'text',
      'label' => __('Country', 'hedonizm'),
    ),
    $checkout->get_value('vat_company_country')
  );
}

add_action('woocommerce_uwagi_fields', 'uwagi_fields', 10);
function uwagi_fields($checkout)
{
  woocommerce_form_field(
    'uwagi',
    array(
      'type' => 'textarea',
      'label' => __('Zapakuj na prezent.', 'hedonizm'),
    ),
    $checkout->get_value('uwagi')
  );
}

function invoice_uwagi_fields_update($order_id)
{
  if (!empty($_POST['uwagi'])) {
    update_post_meta($order_id, 'Zapakuj na prezent.',  sanitize_text_field($_POST['uwagi']));
  }
}

add_action('woocommerce_admin_order_data_after_shipping_address', 'invoice_uwagi_fields_admin_show', 10, 2);

function invoice_uwagi_fields_admin_show($order)
{
  echo '<br />';
  echo '<h3>Uwagi:</h3>';
  echo '<p><strong>' . __('Uwagi messange') . ':</strong><br>' . get_post_meta($order->id, 'uwagi', true) . '</p>';
}


add_action('woocommerce_checkout_update_order_meta', 'invoice_vat_fields_update');
function invoice_vat_fields_update($order_id)
{
  if (!empty($_POST['vat_nip_number'])) {
    update_post_meta($order_id, 'VAT NIP number',  sanitize_text_field($_POST['vat_nip_number']));
  }
  if (!empty($_POST['vat_company_name'])) {
    update_post_meta($order_id, 'VAT Company name', sanitize_text_field($_POST['vat_company_name']));
  }
  if (!empty($_POST['vat_company_addres'])) {
    update_post_meta($order_id, 'VAT Company Addres', sanitize_text_field($_POST['vat_company_addres']));
  }
  if (!empty($_POST['vat_company_zip_code'])) {
    update_post_meta($order_id, 'VAT Company Zip code', sanitize_text_field($_POST['vat_company_zip_code']));
  }
  if (!empty($_POST['vat_company_city'])) {
    update_post_meta($order_id, 'VAT Company city', sanitize_text_field($_POST['vat_company_city']));
  }
  if (!empty($_POST['vat_company_country'])) {
    update_post_meta($order_id, 'VAT Company country', sanitize_text_field($_POST['vat_company_country']));
  }
}

add_action('woocommerce_admin_order_data_after_shipping_address', 'invoice_vat_fields_admin_show', 10, 1);
function invoice_vat_fields_admin_show($order)
{
  echo '<h3>Invoice VAT data:</h3>';
  echo '<p><strong>' . __('VAT/NIP number') . ':</strong><br>' . get_post_meta($order->id, 'VAT NIP number', true) . '</p>';
  echo '<p><strong>' . __('Company name') . ':</strong><br>' . get_post_meta($order->id, 'VAT Company name', true) . '</p>';
  echo '<p><strong>' . __('Company Address') . ':</strong><br>' . get_post_meta($order->id, 'VAT Company Addres', true) . '</p>';
  echo '<p><strong>' . __('Company Zip code') . ':</strong><br>' . get_post_meta($order->id, 'VAT Company Zip code', true) . '</p>';
  echo '<p><strong>' . __('Company Сity') . ':</strong><br>' . get_post_meta($order->id, 'VAT Company city', true) . '</p>';
  echo '<p><strong>' . __('Company Сountry') . ':</strong><br>' . get_post_meta($order->id, 'VAT Company country', true) . '</p>';
}



// remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
// add_action('woocommerce_sort', 'woocommerce_catalog_ordering');

// function woocommerce_catalog_ordering()
// {
//   if (!wc_get_loop_prop('is_paginated') || !woocommerce_products_will_display()) {
//     return;
//   }
//   $show_default_orderby    = 'menu_order' === apply_filters('woocommerce_default_catalog_orderby', get_option('woocommerce_default_catalog_orderby', 'menu_order'));
//   $catalog_orderby_options = apply_filters(
//     'woocommerce_catalog_orderby',
//     array(
//       'menu_order' => __('Sortuj', 'woocommerce'),
//       'popularity' => __('Sort by popularity2143', 'woocommerce'),
//       'rating'     => __('Sort by average rating', 'woocommerce'),
//       'date'       => __('Sort by latest', 'woocommerce'),
//       'price'      => __('Sort by price: low to high', 'woocommerce'),
//       'price-desc' => __('Sort by price: high to low', 'woocommerce'),
//     )
//   );

//   $default_orderby = wc_get_loop_prop('is_search') ? 'relevance' : apply_filters('woocommerce_default_catalog_orderby', get_option('woocommerce_default_catalog_orderby', ''));
//   // phpcs:disable WordPress.Security.NonceVerification.Recommended
//   $orderby = isset($_GET['orderby']) ? wc_clean(wp_unslash($_GET['orderby'])) : $default_orderby;
//   // phpcs:enable WordPress.Security.NonceVerification.Recommended

//   if (wc_get_loop_prop('is_search')) {
//     $catalog_orderby_options = array_merge(array('relevance' => __('Relevance', 'woocommerce')), $catalog_orderby_options);

//     unset($catalog_orderby_options['menu_order']);
//   }

//   if (!$show_default_orderby) {
//     unset($catalog_orderby_options['menu_order']);
//   }

//   if (!wc_review_ratings_enabled()) {
//     unset($catalog_orderby_options['rating']);
//   }

//   if (!array_key_exists($orderby, $catalog_orderby_options)) {
//     $orderby = current(array_keys($catalog_orderby_options));
//   }

//   wc_get_template(
//     'loop/orderby.php',
//     array(
//       'catalog_orderby_options' => $catalog_orderby_options,
//       'orderby'                 => $orderby,
//       'show_default_orderby'    => $show_default_orderby,
//     )
//   );
// }
