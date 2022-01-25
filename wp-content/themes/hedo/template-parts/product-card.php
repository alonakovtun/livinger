<?php $prd = wc_get_product($post->ID); ?>
<div data-prd-id="<?= the_ID(); ?>" class="slider-product wow fadeIn" data-wow-delay="0.2s">
    <?php echo do_shortcode("[yith_wcwl_add_to_wishlist]") ?>
<!--    <img class="slider-product__like" src="--><?php //bloginfo('template_directory') ?><!--/assets/img/Wishlist_gold-01.svg" alt=" love " />-->
    <a href="<?= the_permalink(); ?>" class="slider-product__image trigger-change">
        <?php
        $attachment_ids = $prd->get_gallery_image_ids();
        $hover_img      = wp_get_attachment_image_src($attachment_ids[0], $image_size);
        ?>
        <img src="<?= get_the_post_thumbnail_url($prd->get_id()); ?>" alt="" />
        <div class="slider-product__tag">
            <p class="slider-product__tag-item txt-20 txt-light c-gold wow fadeIn" data-wow-delay="0.5s">
                <?php if (get_field('wyprzedaz_')) : ?>
                    Wyprzedaż
                <?php endif; ?>
            </p>
            <p class="slider-product__tag-item txt-20 txt-light c-green wow fadeIn" data-wow-delay="0.5s">
                <?php if (get_field('product_new')) : ?>
                    Nowość
                <?php endif; ?>
            </p>
        </div>
    </a>
    <div class="slider-product__bottom_width slider-product__bottom bestsellery__slider-product-bottom">
        <div class="flex jc-space al-center">
            <a href="<?= the_permalink(); ?>" class="slider-product__name  txt-20 txt-upper wow fadeIn trigger-change" data-wow-delay="0.5s">
                <?php the_title(); ?>
            </a>
            <p class="slider-product__tag-item flex al-center txt-20 mb-0 txt-light c-black wow fadeIn" data-wow-delay="0.5s">
                <?php if (get_field('wiele_kolorow')) : ?>
                    Wiele kolorów
                <?php endif; ?>
            </p>
        </div>
        <?php if ($price_html = $product->get_price_html()) : ?>
            <a href="<?= the_permalink(); ?>" class="slider-product__price txt-20 txt-bold wow fadeIn trigger-change" data-wow-delay="0.5s">
                <span class="price"><?php echo $price_html; ?></span>
            </a>
        <?php endif; ?>


    </div>
</div>