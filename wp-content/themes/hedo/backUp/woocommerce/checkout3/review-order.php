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

defined('ABSPATH') || exit;
?>
<div class="shop_table woocommerce-checkout-review-order-table">
  <div class="checkout__title flex jc-start al-center">
    <h3 class="txt-20 txt-light txt-upper ls-08"><?php esc_html_e('Delivery address', 'woocommerce'); ?></h3>
  </div>
  <ul class="cart_list">
    <?php
    do_action('woocommerce_review_order_before_cart_contents');
    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
      $_product     = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
      $product_id   = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
      if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key)) {
        $product_name      = apply_filters('woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key);
        $thumbnail         = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
        $product_price     = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
        $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
    ?>
        <li class="b-cart-item cart-item woocommerce-mini-cart-item <?php echo esc_attr(apply_filters('woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key)); ?>">
          <?php get_template_part('template-parts/hedonizm-preloader'); ?>
          <div href="<?php echo $product_permalink; ?>" class="cart-item__image">
            <img src="<?= get_the_post_thumbnail_url($product_id); ?>" alt="" />
          </div>
          <div class="cart-item__info flex js-space fl-column">
            <div class="cart-item__head flex jc-space al-start flex1">
              <div class="support-box">
                <a href="<?php echo esc_url($product_permalink); ?>" class="cart-item__title txt-18 txt-light txt-upper">
                  <?php echo wp_kses_post($product_name); ?>
                </a>
                <p class="product__sku txt-14 lh-24 mb-40">Nr produktu: <?= $_product->sku ?></p>
              </div>
              <p class="txt-18 txt-light txt-upper">
                <?php
                echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key) ?>
              </p>
            </div>
            <div class="cart-item__body flex jc-space al-center">
              <div class="mini-cart-title">
                <?php
                echo wc_get_formatted_cart_item_data($cart_item);
                ?>
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
        </li>

    <?php
      }
    }

    do_action('woocommerce_review_order_after_cart_contents');
    ?>

  </ul>
  <!-- <thead>
    <tr>
      <th class="product-name"><?php esc_html_e('Product', 'woocommerce'); ?></th>
      <th class="product-total"><?php esc_html_e('Subtotal', 'woocommerce'); ?></th>
    </tr>
  </thead>
  <tbody>
    <?php
    do_action('woocommerce_review_order_before_cart_contents');

    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
      $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);

      if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key)) {
    ?>
        <tr class="<?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
          <td class="product-name">
            <?php echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key)) . '&nbsp;'; ?>
            <?php echo apply_filters('woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf('&times;&nbsp;%s', $cart_item['quantity']) . '</strong>', $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            ?>
            <?php echo wc_get_formatted_cart_item_data($cart_item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            ?>
          </td>
          <td class="product-total">
            <?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            ?>
          </td>
        </tr>
    <?php
      }
    }

    do_action('woocommerce_review_order_after_cart_contents');
    ?>
  </tbody>
  <tfoot>

    <tr class="cart-subtotal">
      <th><?php esc_html_e('Subtotal', 'woocommerce'); ?></th>
      <td><?php wc_cart_totals_subtotal_html(); ?></td>
    </tr>

    <?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
      <tr class="cart-discount coupon-<?php echo esc_attr(sanitize_title($code)); ?>">
        <th><?php wc_cart_totals_coupon_label($coupon); ?></th>
        <td><?php wc_cart_totals_coupon_html($coupon); ?></td>
      </tr>
    <?php endforeach; ?>

    <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>

      <?php do_action('woocommerce_review_order_before_shipping'); ?>

      <?php wc_cart_totals_shipping_html(); ?>

      <?php do_action('woocommerce_review_order_after_shipping'); ?>

    <?php endif; ?>

    <?php foreach (WC()->cart->get_fees() as $fee) : ?>
      <tr class="fee">
        <th><?php echo esc_html($fee->name); ?></th>
        <td><?php wc_cart_totals_fee_html($fee); ?></td>
      </tr>
    <?php endforeach; ?>

    <?php if (wc_tax_enabled() && !WC()->cart->display_prices_including_tax()) : ?>
      <?php if ('itemized' === get_option('woocommerce_tax_total_display')) : ?>
        <?php foreach (WC()->cart->get_tax_totals() as $code => $tax) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
        ?>
          <tr class="tax-rate tax-rate-<?php echo esc_attr(sanitize_title($code)); ?>">
            <th><?php echo esc_html($tax->label); ?></th>
            <td><?php echo wp_kses_post($tax->formatted_amount); ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else : ?>
        <tr class="tax-total">
          <th><?php echo esc_html(WC()->countries->tax_or_vat()); ?></th>
          <td><?php wc_cart_totals_taxes_total_html(); ?></td>
        </tr>
      <?php endif; ?>
    <?php endif; ?>

    <?php do_action('woocommerce_review_order_before_order_total'); ?>

    <tr class="order-total">
      <th><?php esc_html_e('Total', 'woocommerce'); ?></th>
      <td><?php wc_cart_totals_order_total_html(); ?></td>
    </tr>

    <?php do_action('woocommerce_review_order_after_order_total'); ?>

  </tfoot> -->
</div>