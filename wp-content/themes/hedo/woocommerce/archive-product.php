<?php

/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined('ABSPATH') || exit;

get_header('shop');

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action('woocommerce_before_main_content');

?>


<div class="filters">
  <div class="filters__container">
    <div class="flex jc-center al-center filter">
      <div class="wow fadeInUp filters__element" data-wow-delay="0.8s">
        <div class="filters__head">
          <p class="txt-18 c-gold txt-light"><?php esc_html_e('Sortuj', 'woocommerce'); ?> <span class="filters__head-plus">+</span></p>
        </div>
        <div class="wcapf-price-filter-wrapper filter-body-sort">
          <ul>

          </ul>
        </div>
      </div>
      <div class="wow fadeInUp filters__element" data-wow-delay="0.8s">
        <div class="filters__head">
          <p class="txt-18 c-gold txt-light"><?php esc_html_e('Cena', 'woocommerce'); ?> <span class="filters__head-plus">+</span></p>
        </div>
        <div class="wcapf-price-filter-wrapper filter-body-cena">
          <div class="filter-body-cena__input">
            <label for="od">Od</label>
            <input type="text" placeholder="0.00" class="filter-od">
            <span>zł</span>
          </div>
          <div class="filter-body-cena__input">
            <label for="od">Do</label>
            <input type="text" placeholder="0.00" class="filter-do">
            <span>zł</span>
          </div>
          <a href="#" class="filter-body-cena__button button-ok">Zastosuj</a>
          <a href="#" class="filter-body-cena__button button-reset">wyczyść</a>
        </div>
      </div>
      <div class="filters__mobile">
        <p class="filters__mobile-show">Filtry +</p>
        <p class="filters__mobile-hide">Zwiń filtry</p>
      </div>
      <?php dynamic_sidebar('filters-column'); ?>
    </div>
    <?php do_action('hook_count_all_products'); ?>
  </div>
</div>

<?php

if (have_posts()) {


  /**
   * Hook: woocommerce_before_shop_loop.
   *
   * @hooked wc_print_notices - 10
   * @hooked woocommerce_result_count - 20
   * @hooked woocommerce_catalog_ordering - 30
   */
  do_action('woocommerce_before_shop_loop');

  woocommerce_product_loop_start();

  if (wc_get_loop_prop('total')) {
    while (have_posts()) {
      the_post();

      /**
       * Hook: woocommerce_shop_loop.
       *
       * @hooked WC_Structured_Data::generate_product_data() - 10
       */
      do_action('woocommerce_shop_loop');

      wc_get_template_part('content', 'product');
    }
  }

  woocommerce_product_loop_end();

  /**
   * Hook: woocommerce_after_shop_loop.
   *
   * @hooked woocommerce_pagination - 10
   */
  do_action('woocommerce_after_shop_loop');
} else {
  /**
   * Hook: woocommerce_no_products_found.
   *
   * @hooked wc_no_products_found - 10
   */
  do_action('woocommerce_no_products_found');
}
/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action('woocommerce_after_main_content');

get_footer('shop');
