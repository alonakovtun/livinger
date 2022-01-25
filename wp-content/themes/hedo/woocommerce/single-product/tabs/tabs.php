<?php

/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters('woocommerce_product_tabs', array());

if (!empty($product_tabs)) : ?>

    <div class="woocommerce-tabs wc-tabs-wrapper">
        <div class="tabs wc-tabs" role="tablist">
            <?php foreach ($product_tabs as $keyParent => $product_tab) : ?>
                <div class="<?php echo esc_attr($keyParent); ?>_tab tabs__element" id="tab-title-<?php echo esc_attr($keyParent); ?>" role="tab" aria-controls="tab-<?php echo esc_attr($keyParent); ?>">
                    <a href="#tab-<?php echo esc_attr($keyParent); ?>" class="tabs__element-head">
                        <?php echo wp_kses_post(apply_filters('woocommerce_product_' . $keyParent . '_tab_title', $product_tab['title'], $keyParent)); ?>
                        <span class="plus">+</span>
                        <span class="minus">-</span>
                    </a>
                    <?php foreach ($product_tabs as $key => $product_tab) : ?>
                        <?php if (esc_attr($key) == esc_attr($keyParent)) : ?>
                            <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr($key); ?> panel entry-content wc-tab tabs__element-body" id="tab-<?php echo esc_attr($key); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr($key); ?>">
                                <?php
                                if (isset($product_tab['callback'])) {
                                    call_user_func($product_tab['callback'], $key, $product_tab);
                                }
                                ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>



            <?php if (have_rows('four_accordion')) : ?>
                <?php while (have_rows('four_accordion')) : the_row();
                    $title = get_sub_field('title');
                    $content = get_sub_field('content');
                    ?>
                    <div class="tabs__element">
                        <div class="tabs__element-head">
                            <p><?= $title ?></p>
                            <span class="plus">+</span>
                            <span class="minus">-</span>
                        </div>
                        <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr($key); ?> panel entry-content wc-tab tabs__element-body" id="tab-<?php echo esc_attr($key); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr($key); ?>">
                            <?= $content ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>


        <?php do_action('woocommerce_product_after_tabs'); ?>
    </div>

<?php endif; ?>