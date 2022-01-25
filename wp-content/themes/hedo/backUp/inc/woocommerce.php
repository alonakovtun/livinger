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
