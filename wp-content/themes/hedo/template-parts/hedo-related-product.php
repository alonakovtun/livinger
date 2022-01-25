<?php
$items = get_field('klienci_ktorzy_kupili_ten_produkt_kupili_rowniez');
if ($items) : ?>
  <section class="related related_two">
    <h2 class="title-block txt-center txt-upper mtb-80">klienci którzy kupili ten produkt kupili również</h2>
    <div class="related__container">
      <div class="related__slider_2">
        <div class="swiper-container">
          <div class="swiper-wrapper">
            <?php foreach ($items as $item) :
              $permalink = get_permalink($item->ID);
              $id = wc_get_product($item->ID);
              $price = $id->price;
              $thumbnail         = apply_filters('woocommerce_cart_item_thumbnail', $id->get_image());
              $title = $item->post_title;
            ?>
              <div class="swiper-slide wow fadeInUp" data-wow-delay="0.1s">
                <div class="related__item">

                  <div data-prd-id="<?= $item->ID ?>" class="slider-product wow fadeInUp" data-wow-delay="0.2s">
                    <?php echo do_shortcode("[yith_wcwl_add_to_wishlist product_id=" .  $item->ID . "]") ?>
                    <a href="<?= $permalink; ?>" class="slider-product__image">
                      <img src="<?= get_the_post_thumbnail_url($id->get_id()); ?>" alt="<?= the_title(); ?>" />

                      <div class="slider-product__tag">
                        <p class="slider-product__tag-item txt-20 txt-light c-gold"></p>
                        <p class="slider-product__tag-item txt-20 txt-light c-black"></p>
                      </div>
                    </a>

                    <div class="slider-product__bottom bestsellery__slider-product-bottom">
                      <a href="<?= $permalink; ?>" class="slider-product__name txt-20 txt-upper wow fadeInUp" data-wow-delay="0.5s"><?= $title;  ?></a>
                      <?php if ($price_html = $product->get_price_html()) : ?>
                        <a href="<?= $permalink; ?>" class="slider-product__price txt-20 txt-bold wow fadeInUp" data-wow-delay="0.5s">
                          <span class="price"><?php echo $price; ?> PLN</span>
                        </a>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="swiper-button-prev"></div>
          <div class="swiper-button-next"></div>
          <div class="swiper-pagination"></div>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>