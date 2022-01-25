<?php
/**
 * Single product short description
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/short-description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post;

$short_description = apply_filters( 'woocommerce_short_description', $post->post_excerpt );

if ( ! $short_description ) {
	return;
}

?>
<div class="woocommerce-product-details__short-description wow fadeInUp" data-wow-delay="1.5s">
	<?php echo $short_description; // WPCS: XSS ok. ?>
</div>
<?php
$featured_posts = get_field('more_product');
if ($featured_posts) : ?>
<div class="variation_custom trigger-change  wow fadeInUp" data-wow-delay="1.5s">
    <div class="product__more flex jc-start al-stretch">
        <?php foreach ($featured_posts as $featured_post) :
            $permalink = get_permalink($featured_post->ID);
            $id = wc_get_product($featured_post->ID);
            $price = $id->price;
            $thumbnail         = apply_filters('woocommerce_cart_item_thumbnail', $id->get_image());
            $title = $featured_post->post_title;
            ?>
            <a href="<?= $permalink ?>" class="product__more-element ">
                <img src="<?= get_the_post_thumbnail_url($id->get_id()); ?>" alt="<?= the_title(); ?>" />
            </a>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

