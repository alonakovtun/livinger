<!-- # START Sidebar Cart - Header -->
<div class="mini-cart__header flex jc-space al-center">
    <div class="mini-cart__total">
        <p class="txt-16 txt-light ls-04 txt-left с-black">
            <?= esc_html__('Ilość rzeczy w koszyku: ' . WC()->cart->get_cart_contents_count() . '', 'hedonizm'); ?>
            <span>
        <?php /**
        global $woocommerce_ultimate_multi_currency_suite;
        $default_currency = get_woocommerce_currency();
        if (empty($woocommerce_ultimate_multi_currency_suite->settings->session_currency)) { // if no currency stored in session
        $current_curr = $default_currency;
        } else {
        $current_curr = $woocommerce_ultimate_multi_currency_suite->settings->session_currency;
        }
         */
        ?>
      </span>
        </p>
    </div>
    <button type="button" class="mini-cart__close txt-16 txt-light ls-04 txt-right">
        Close cart
    </button>
</div>
<!-- # END Sidebar Cart - Header -->

<!-- # START LIST PRODUCT -->
<?php if (!WC()->cart->is_empty()) : ?>
    <!-- <div class="widget woocommerce widget_shopping_cart">
      <div class="widget_shopping_cart_content">

      </div>
    </div> -->
    <ul class="mini-cart__list woocommerce-mini-cart cart_list product_list_widget">
        <?php
        do_action('woocommerce_before_mini_cart_contents');
        // Loop - Begin
        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            $_product     = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
            $product_id   = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

            if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key)) {
                $product_name      = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
                $thumbnail         = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
                $thumbnail_url     = get_the_post_thumbnail_url($product_id);
                $product_price     = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                $product_data      = wc_get_formatted_cart_item_data($cart_item);
                ?>

                <li class="mini-cart__item cart-item woocommerce-mini-cart-item <?php echo esc_attr(apply_filters('woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key)); ?>">
                    <?php get_template_part('template-parts/hedo-loader'); ?>
                    <!-- # Item - Product Image -->
                    <div class="cart-item__image">
                        <img src="<?php echo $thumbnail_url; ?>" alt="" />
                    </div>

                    <div class="cart-item__info flex js-space fl-column">
                        <div class="cart-item__head flex jc-space al-start flex1">
                            <div class="support-box">
                                <?php if (empty($product_permalink)) : ?>
                                    <a href="<?php echo $product_permalink; ?>" class="cart-item__title txt-18 txt-light txt-upper trigger-change"><?= $product_name; ?></a>
                                <?php else : ?>
                                    <a href="<?php echo $product_permalink; ?>" class="cart-item__title txt-18 txt-light txt-upper trigger-change">
                                        <?= $product_name; ?>
                                    </a>
                                <?php endif; ?>
                                <p class="product__sku txt-14 lh-24 mb-40">Nr produktu: <?= $_product->sku ?></p>
                            </div>
                            <p class="txt-18 txt-light txt-upper"><?= $_product->get_price_html(); ?></p>
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
                            <div>
                                <!-- # Item - Remove Button -->
                                <?php
                                echo apply_filters('woocommerce_cart_item_remove_link', sprintf(
                                    '<a href="%s" class="checkout__remove remove trigger-change" aria-label="%s">%s</a>',
                                    esc_url(wc_get_cart_remove_url($cart_item_key)),
                                    __('x', 'woocommerce'),
                                    __('x', 'hedonizm')
                                ), $cart_item_key);
                                ?>
                            </div>
                        </div>
                    </div>
                </li>
                <?php
            }
        }
        // Loop - End

        do_action('woocommerce_mini_cart_contents');
        ?>

    </ul>

<?php else : ?>

    <p class="s-drop-cart_main_list b-cart-list woocommerce-mini-cart__empty-message"><?= _e('No products in the cart.', 'woocommerce'); ?></p>

<?php endif; ?>
<!-- # END LIST PRODUCT -->


<!-- # Sidebar Cart - Footer -->

<?php if (WC()->cart->get_cart_contents_count()) : ?>
    <div class="mini-cart__footer">
        <!-- Total -->
        <div class=" mini-cart__total-price woocommerce-mini-cart__total total flex jc-space al-center txt-20 txt-light txt-upper">
            <span><?= _e('Suma', 'hedonizm'); ?></span>
            <?= WC()->cart->get_cart_subtotal(); ?>
            <div class="preloader preloader2">
                <div class="preloader__container">
                    <div class="preloader__element">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
        </div>

        <?php do_action('woocommerce_widget_shopping_cart_before_buttons'); ?>

        <p class="
      mini-cart__buttons
      woocommerce-mini-cart__buttons buttons
    ">
            <? // do_action( 'woocommerce_widget_shopping_cart_buttons' );
            ?>

            <a href="<?= get_page_link(8); ?>" class="
        mini-cart__checkout
        a-btn
        trigger-change
      ">
                <?= _e('Checkout', 'hedonizm'); ?>
            </a>
        </p>

        <?php do_action('woocommerce_after_mini_cart'); ?>
    </div>
<?php else : ?>
    <div class="
    s-drop-cart_foot
    a-flx-col-btw
  "> </div>
<?php endif; ?>
<!-- # END Sidebar Cart - Footer -->