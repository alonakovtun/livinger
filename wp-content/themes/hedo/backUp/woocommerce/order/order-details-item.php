<?php

/**
 * Order Item Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-item.php.
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

if (!defined('ABSPATH')) {
  exit;
}

if (!apply_filters('woocommerce_order_item_visible', true, $item)) {
  return;
}
$product_id = apply_filters('woocommerce_cart_item_product_id', $item['product_id'], $item, $cart_item_key);
?>
<div class="b-cart-item cart-item woocommerce-mini-cart-item <?php echo esc_attr(apply_filters('woocommerce_order_item_class', 'woocommerce-table__line-item order_item', $item, $order)); ?>">
  <div class="cart-item__image">
    <img src="<?= get_the_post_thumbnail_url($product_id); ?>" alt="" />
  </div>
  <div class="cart-item__info flex js-space fl-column">
    <div class="cart-item__head flex jc-space al-start flex1">
      <div class="support-box">
        <div class="cart-item__title txt-18 txt-light txt-upper">
          <?php
          $is_visible        = $product && $product->is_visible();
          $product_permalink = apply_filters('woocommerce_order_item_permalink', $is_visible ? $product->get_permalink($item) : '', $item, $order);

          echo wp_kses_post(apply_filters('woocommerce_order_item_name', $product_permalink ? sprintf('<a href="%s">%s</a>', $product_permalink, $item->get_name()) : $item->get_name(), $item, $is_visible));
          ?>
        </div>
        <p class="product__sku txt-14 lh-24 mb-40">Nr produktu: <?= $product->sku ?></p>
      </div>
      <p class="txt-18 txt-light txt-upper">
        <?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($product, $item['quantity']), $item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        ?>
      </p>
    </div>
    <div class="cart-item__body flex jc-space al-center">
      <div class="cart-item__qty">
        <div data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>" data-key="<?= esc_attr($cart_item_key) ?>" data-qty="<?= $item['quantity']; ?>" class="b-cart-item_qty p_qty product-quantity qib-container flex jc-start al-center">
          <button type="button" class="minus <?= $qty_class; ?>">
            -
          </button>
          <div class="input-qty">
            <?php echo esc_html__('', 'hedonizm') . '<span>' . $item['quantity'] . '</span>'; ?>
          </div>
          <?php $qty_class = ($item['quantity'] > 1) ? '' : 'm-disabled'; ?>
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
  <!-- <div class="woocommerce-table__product-name product-name">
    <?php //
    // $is_visible        = $product && $product->is_visible();
    // $product_permalink = apply_filters('woocommerce_order_item_permalink', $is_visible ? $product->get_permalink($item) : '', $item, $order);

    // // echo wp_kses_post(apply_filters('woocommerce_order_item_name', $product_permalink ? sprintf('<a href="%s">%s</a>', $product_permalink, $item->get_name()) : $item->get_name(), $item, $is_visible));

    // $qty          = $item->get_quantity();
    // $refunded_qty = $order->get_qty_refunded_for_item($item_id);

    // if ($refunded_qty) {
    //   $qty_display = '<del>' . esc_html($qty) . '</del> <ins>' . esc_html($qty - ($refunded_qty * -1)) . '</ins>';
    // } else {
    //   $qty_display = esc_html($qty);
    // }

    // echo apply_filters('woocommerce_order_item_quantity_html', ' <strong class="product-quantity">' . sprintf('&times;&nbsp;%s', $qty_display) . '</strong>', $item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

    // do_action('woocommerce_order_item_meta_start', $item_id, $item, $order, false);

    // wc_display_item_meta($item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

    // do_action('woocommerce_order_item_meta_end', $item_id, $item, $order, false);
    ?>
  </div> -->

  <!-- <td class="woocommerce-table__product-total product-total">
    <?php echo $order->get_formatted_line_subtotal($item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    ?>
  </td> -->

</div>

<?php // if ($show_purchase_note && $purchase_note) :
?>

<!-- <tr class="woocommerce-table__product-purchase-note product-purchase-note">

    <td colspan="2"><?php // echo wpautop(do_shortcode(wp_kses_post($purchase_note))); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    ?></td>

  </tr> -->

<?php // endif;
?>