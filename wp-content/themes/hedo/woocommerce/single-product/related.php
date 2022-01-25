<?php

/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.9.0
 */

if (!defined('ABSPATH')) {
  exit;
}

if ($related_products) : ?>

  <section class="related">

    <?php
    $heading = apply_filters('woocommerce_product_related_products_heading', __('Related products', 'woocommerce'));

    if ($heading) :
    ?>
      <h2 class="title-block txt-center txt-upper mtb-80"><?php echo esc_html($heading); ?></h2>
    <?php endif; ?>

    <?php

    /**
     * Product Loop Start
     *
     * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
     *
     * HOWEVER, on occasion WooCommerce will need to update template files and you
     * (the theme developer) will need to copy the new files to your theme to
     * maintain compatibility. We try to do this as little as possible, but it does
     * happen. When this occurs the version of the template file will be bumped and
     * the readme will list any important changes.
     *
     * @see         https://docs.woocommerce.com/document/template-structure/
     * @package     WooCommerce\Templates
     * @version     3.3.0
     */

    if (!defined('ABSPATH')) {
      exit;
    }
    ?>
    <?php if (is_product()) : ?>
      <div class="related__container">
        <div class="related__slider">
          <div class="swiper-container">
            <div class="swiper-wrapper">

            <?php endif; ?>

            <?php foreach ($related_products as $related_product) : ?>
              <div class="swiper-slide wow fadeInUp" data-wow-delay="0.1s">
                <div class="related__item">
                  <?php
                  $post_object = get_post($related_product->get_id());

                  setup_postdata($GLOBALS['post'] = &$post_object); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

                  wc_get_template_part('content', 'product');
                  ?>
                </div>
              </div>
            <?php endforeach; ?>

            <?php

            /**
             * Product Loop End
             *
             * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-end.php.
             *
             * HOWEVER, on occasion WooCommerce will need to update template files and you
             * (the theme developer) will need to copy the new files to your theme to
             * maintain compatibility. We try to do this as little as possible, but it does
             * happen. When this occurs the version of the template file will be bumped and
             * the readme will list any important changes.
             *
             * @see         https://docs.woocommerce.com/document/template-structure/
             * @package     WooCommerce\Templates
             * @version     2.0.0
             */

            if (!defined('ABSPATH')) {
              exit;
            }
            ?>
            </div>

            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-pagination"></div>
          </div>
        </div>
      </div>
  </section>
<?php
endif;

wp_reset_postdata();
