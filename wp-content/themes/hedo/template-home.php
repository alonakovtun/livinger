<?php // Template Name: Home
get_header();
?>
<section class="main-screen">
  <?php if (have_rows('main_slider')) : ?>
    <div class="swiper-container">
      <div class="swiper-wrapper">
        <?php while (have_rows('main_slider')) : the_row();
          $image = get_sub_field('main_image');
          $name = get_sub_field('main_name');
          $link = get_sub_field('main_link');
          $link_url = $link['url'];
          $link_title = $link['title'];
          $link_target = $link['target'] ? $link['target'] : '_self';
        ?>
          <div class="swiper-slide">
            <a href="<?= esc_url($link_url); ?>" target="<?= esc_attr($link_target); ?>" class="main-screen__slide">
              <img class="main-screen__shadow" src="<?php bloginfo('template_directory') ?>/assets/img/main-screen_slider-shadow.png" alt="slider shadow" />
              <div class="main-screen__container">
                <?php if (!empty($image)) : ?>
                  <img class="main-screen__bakcground" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
                <?php endif; ?>
                <div class="main-screen__title title-80 wow fadeIn"><?= $name; ?></div>
                <?php if ($link) : ?>
                  <p class="button-link-24 mt-15 wow fadeIn" data-wow-delay="0.3s"><?= esc_html($link_title); ?></p>
                <?php endif; ?>
              </div>
            </a>
          </div>
        <?php endwhile; ?>
      </div>
      <!-- Add Arrows -->
      <div class="swiper-button-next wow fadeIn" data-wow-delay=".3s"></div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-pagination"></div>
    </div>
  <?php endif; ?>
</section>

<section class="category plr-14 mb-91">
  <p class="category__title title-block txt-center txt-upper mtb-80 wow fadeIn">Kategorie</p>
  <div class="category__row">
    <div class="swiper-container">
      <div class="swiper-wrapper slider-category-wrap">
        <?php
        $terms = get_field('category_item');
        $i = 1;
        if ($terms) : ?>
          <?php foreach ($terms as $term) :
            $thumbnail_id = get_woocommerce_term_meta($term->term_id, 'thumbnail_id', true);
            $image = wp_get_attachment_url($thumbnail_id);
            $i += 2;
          ?>
            <div class="swiper-slide">
              <div class="category__item wow fadeIn" data-wow-delay="0.<?= $i > 10 ? $i = 1 : $i ?>s">
                <a href="<?= get_term_link($term->slug, 'product_cat') ?>" class="category__image">
                  <img src="<?= $image ?>" alt="category 1" />
                </a>
                <div class="category__name ptb-38">
                  <a href="<?php echo esc_url(get_term_link($term)); ?>" class="txt-20 txt-green txt-center txt-upper">
                    <?php echo esc_html($term->name); ?>
                  </a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
      <div class="swiper-pagination"></div>
    </div>
  </div>
</section>

<section class="bestsellery plr-14 flex al-stretch jc-space">
  <?php
  $hero = get_field('bestsellery_left');
  if ($hero) :
    $image = $hero['image'];
    $title = $hero['title'];
    $link = $hero['link'];
    $link_url = $link['url'];
    $link_title = $link['title'];
    $link_target = $link['target'] ? $link['target'] : '_self';
  ?>
    <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>" class="bestsellery__left wow fadeIn  order-1">
      <img class="bestsellery__shadow" src="<?php bloginfo('template_directory') ?>/assets/img/bestsellery-shadow.png" alt="shadow" />
      <div class="bestsellery__image">
        <img src="<?= $image ?>" alt="bestsellery" />
      </div>
      <div class="bestsellery__bottom">
        <p class="bestsellery__title title-80 wow fadeIn" data-wow-delay="0.3s"><?= $title; ?></p>
        <?php
        if ($link) :
        ?>
          <p class="button-link-24 mt-38 wow fadeIn" data-wow-delay="0.5s">
            <?php echo esc_html($link_title); ?>
          </p>
        <?php endif; ?>
      </div>
    </a>
  <?php endif; ?>

  <div class="bestsellery__right order-2 wow fadeIn">
    <div class="swiper-container">
      <div class="swiper-wrapper">
        <?php
        $featured_posts = get_field('bestsellery_list');
        if ($featured_posts) : ?>
          <?php foreach ($featured_posts as $featured_post) :
            $permalink = get_permalink($featured_post->ID);
            $id = wc_get_product($featured_post->ID);
            $price = $id->price;
            $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $id->get_image());
            $title = $featured_post->post_title;
          ?>
            <div class="swiper-slide">
              <a href="<?= $permalink; ?>" class="bestsellery__item">
                <div class="bestsellery__product">
                  <img src="<?= get_the_post_thumbnail_url($id->get_id()); ?>" alt="" />
                </div>
                <div class="bestsellery__product-bottom">
                  <p class="product__name txt-upper txt-24 wow fadeIn" data-wow-delay="0.5s"><?= $title ?></p>
                  <p class="txt-24 txt-bold mt-10 wow fadeIn" data-wow-delay="0.5s"><?= $price ?> PLN</p>
                </div>
              </a>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
      <div class="swiper-pagination"></div>
    </div>
  </div>
</section>
<section class="bestsellery bestsellery_reverse plr-14 mb-80 flex al-stretch jc-space">
  <?php
  $hero = get_field('new_product_left');
  if ($hero) :
    $image = $hero['image'];
    $title = $hero['title'];
    $link = $hero['link'];
    $link_url = $link['url'];
    $link_title = $link['title'];
    $link_target = $link['target'] ? $link['target'] : '_self';
  ?>
    <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>" class="bestsellery__left wow fadeIn order-1">
      <img class="bestsellery__shadow" src="<?php bloginfo('template_directory') ?>/assets/img/bestsellery-shadow.png" alt="shadow" />
      <div class="bestsellery__image">
        <img src="<?= $image ?>" alt="bestsellery" />
      </div>
      <div class="bestsellery__bottom">
        <p class="bestsellery__title title-80 wow fadeIn" data-wow-delay="0.5s"><?= $title; ?></p>
        <?php
        if ($link) : ?>
          <p class="button-link-24 mt-38 wow fadeIn" data-wow-delay="0.5s">
            <?php echo esc_html($link_title); ?>
          </p>
        <?php endif; ?>
      </div>
    </a>
  <?php endif; ?>
  <div class="bestsellery__right slide_new order-2 wow fadeIn">
    <div class="swiper-container">
      <div class="swiper-wrapper">
        <?php
        $featured_posts = get_field('new_product_list');
        if ($featured_posts) : ?>
          <?php foreach ($featured_posts as $featured_post) :
            $permalink = get_permalink($featured_post->ID);
            $id = wc_get_product($featured_post->ID);
            $price = $id->price;
            $thumbnail         = apply_filters('woocommerce_cart_item_thumbnail', $id->get_image());
            $title = $featured_post->post_title;
          ?>
            <a href="<?= $permalink; ?>" class="swiper-slide">
              <div class="bestsellery__item">
                <div class="bestsellery__product">
                  <img src="<?= get_the_post_thumbnail_url($id->get_id()); ?>" alt="" />
                </div>
                <div class="bestsellery__product-bottom">
                  <p class="product__name txt-upper txt-24  wow fadeIn" data-wow-delay="0.5s"><?= $title ?></p>
                  <p class="txt-24 txt-bold mt-10 wow fadeIn" data-wow-delay="0.5s"><?= $price ?> PLN</p>
                </div>
              </div>
            </a>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
      <div class="swiper-pagination"></div>
    </div>
  </div>
</section>
<section class="news plr-14 mb-80">
  <p class="category__title title-block txt-center txt-upper mtb-75 wow fadeIn" data-wow-delay="0.2s">
    <?php the_field('blog_title') ?>
    <?php
    $link = get_field('blog_link');
    if ($link) :
      $link_url = $link['url'];
      $link_title = $link['title'];
      $link_target = $link['target'] ? $link['target'] : '_self';
    ?>
      <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>">
        <?php echo esc_html($link_title); ?>
      </a>
    <?php endif; ?>
  </p>
  <div class="flex jc-space al-stretch news__descktop">
    <?php
    $bestsellery_left = get_field('blog_1');
    if ($bestsellery_left) :
      $title = get_field('title', $bestsellery_left->ID);
      $permalink = get_permalink($bestsellery_left->ID);
    ?>
      <div class="news__left bestsellery__left news_block order-1 wow fadeIn">
        <img class="bestsellery__shadow" src="<?php bloginfo('template_directory') ?>/assets/img/bestsellery-shadow.png" alt="shadow" />
        <div class="bestsellery__image">
          <img src="<?= get_the_post_thumbnail_url($bestsellery_left->ID); ?>" alt="background" />
        </div>
        <div class="bestsellery__bottom news_bottom">
          <p class="bestsellery__title title-80 wow fadeIn" data-wow-delay="0.5s"><?= $title; ?></p>
          <a href="<?= $permalink; ?>" class="button-link-24 mt-38 wow fadeIn" data-wow-delay="0.5s">Czytaj dalej</a>
        </div>
      </div>
    <?php endif; ?>
    <?php
    $bestsellery_right = get_field('blog_2');
    if ($bestsellery_right) :
      $title = get_field('title', $bestsellery_right->ID);
      $permalink = get_permalink($bestsellery_right->ID);
    ?>
      <div class="news__left bestsellery__left news_block order-1 wow fadeIn">
        <img class="bestsellery__shadow" src="<?php bloginfo('template_directory') ?>/assets/img/bestsellery-shadow.png" alt="shadow" />
        <div class="bestsellery__image">
          <img src="<?= get_the_post_thumbnail_url($bestsellery_right->ID); ?>" alt="background" />
        </div>
        <div class="bestsellery__bottom news_bottom">
          <p class="bestsellery__title title-80 wow fadeIn" data-wow-delay="0.5s"><?= $title ?></p>
          <a href="<?= $permalink; ?>" class="button-link-24 mt-38 wow fadeIn" data-wow-delay="0.5s">Czytaj dalej</a>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>
<section class="mobile-news">
  <div class="mobile-news__container">
    <div class="swiper-container">
      <div class="swiper-wrapper">
        <?php
        $mobile_news = get_field('news_mobile');
        if ($mobile_news) : ?>
          <?php foreach ($mobile_news as $news) :
            $title = get_field('title', $news->ID);
            $permalink = get_permalink($news->ID);
          ?>
            <div class="swiper-slide wow fadeIn" data-wow-delay="0.1s">
              <div class="news__left bestsellery__left news_block order-1 wow fadeIn">
                <img class="bestsellery__shadow" src="<?php bloginfo('template_directory') ?>/assets/img/bestsellery-shadow.png" alt="shadow" />
                <div class="bestsellery__image">
                  <img src="<?= get_the_post_thumbnail_url($news->ID); ?>" alt="background" />
                </div>
                <div class="bestsellery__bottom news_bottom">
                  <p class="bestsellery__title title-80 wow fadeIn" data-wow-delay="0.5s"><?= $title ?></p>
                  <a href="<?= $permalink; ?>" class="button-link-24 mt-38 wow fadeIn" data-wow-delay="0.5s">Czytaj dalej</a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
      <div class="swiper-pagination"></div>
    </div>
  </div>
</section>
<section class="blog blog_home plr-14 mb-80">
  <p class="category__title title-block txt-center txt-upper mtb-80 wow fadeIn">polecane na blogu</p>
  <div class="blog__slider">
    <div class="swiper-container">
      <div class="swiper-wrapper">
        <?php
        $featured_posts = get_field('news_products');
        if ($featured_posts) : ?>
          <?php foreach ($featured_posts as $featured_post) :
            $permalink = get_permalink($featured_post->ID);
            $id = wc_get_product($featured_post->ID);
            $price = $id->price;
            $thumbnail         = apply_filters('woocommerce_cart_item_thumbnail', $id->get_image());
            $title = $featured_post->post_title;
          ?>
            <div class="swiper-slide wow fadeIn" data-wow-delay="0.1s">
              <div data-prd-id="<?= $featured_post->ID ?>" href="<?= $permalink ?>" class="slider-product">
                <?php echo do_shortcode("[yith_wcwl_add_to_wishlist product_id=" .  $featured_post->ID . "]") ?>
                <a href="<?= $permalink ?>" class="slider-product__image">
                  <img src="<?= get_the_post_thumbnail_url($id->get_id()); ?>" alt="" />
                </a>
                <div class="slider-product__bottom bestsellery__slider-product-bottom">
                  <p class="slider-product__name txt-upper txt-20"><?= $title ?></p>
                  <p class="txt-20 txt-bold c-black"><?= $price ?> PLN</p>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
      <div class="swiper-pagination"></div>
    </div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
  </div>
  </div>
</section>
<section class="mobile-video">
  <div class="mobile-video__container">
    <div class="mobile-video__video">
      <img src="<?php bloginfo('template_directory') ?>/assets/img/background2.png" alt="  " />
    </div>
    <span class="mobile-video__play">
      <img src="<?php bloginfo('template_directory') ?>/assets/img/play.svg" alt=" play " />
    </span>
  </div>
</section>
<section class="video">
  <img class="video__background" src="<?php bloginfo('template_directory') ?>/assets/img/image1-2.png" alt=" video background " />
  <div class="video__modal">
    <div class="video__modal-border">
      <div class="video__logo" data-wow-delay="0.1s">
        <img src="<?php bloginfo('template_directory') ?>/assets/img/logo-gold.png" alt=" logo " />
      </div>
      <div class="video__description mb-20" data-wow-delay="0.3s">
        <p class="txt-20 lh-27 c-gold-black txt-center">Tak wiele dzieje się poza domem. Poza nim wpadasz  w wir
          wydarzeń, realizujesz marzenia, mozolnie budujesz sukces, poznajesz nowych ludzi. To ważna część Twojego życia. Ale gdzie rozpoczynają się te wszystkie ważne rzeczy? Gdzie rodzą się marzenia?</p>
      </div>
      <div class="flex jc-center al-center" data-wow-delay="0.5s">
        <a href="/about" class="button-link c-gold-black txt-20 mrl-34">Czytaj dalej</a>
        <a href="#" class="button-link c-gold-black txt-20 mrl-34 modal__trigger">Wlacz video</a>
      </div>
    </div>
  </div>
</section>
<section class="point-mobile">
  <div class="footer__point">
    <div class="footer__point-container flex jc-space">
      <div class="footer__point-item flex jc-space al-center wow fadeIn" data-wow-delay="0.2s">
        <div class="footer__point-icon">
          <img src="<?php bloginfo('template_directory') ?>/assets/img/footer_img1.png" alt=" item 1 " />
        </div>
        <p class="footer__point-txt txt-20 lh-27 txt-upper flex1">Darmowa
          dostawa od 299</p>
      </div>
      <div class="footer__point-item flex jc-space al-center wow fadeIn" data-wow-delay="0.4s">
        <div class="footer__point-icon">
          <img src="<?php bloginfo('template_directory') ?>/assets/img/footer_img2.png" alt=" item 1 " />
        </div>
        <p class="footer__point-txt txt-20 lh-27 txt-upper flex1">Kup prezent. Zapakujemy
          go dla Ciebie</p>
      </div>
      <div class="footer__point-item flex jc-space al-center wow fadeIn" data-wow-delay="0.6s">
        <div class="footer__point-icon">
          <img src="<?php bloginfo('template_directory') ?>/assets/img/footer_img3.png" alt=" item 1 " />
        </div>
        <p class="footer__point-txt txt-20 lh-27 txt-upper flex1">30 dni na zwrot.
          Bez podania przyczyny</p>
      </div>
      <div class="footer__point-item flex jc-space al-center wow fadeIn" data-wow-delay="0.8s">
        <div class="footer__point-icon">
          <img src="<?php bloginfo('template_directory') ?>/assets/img/footer_img3.png" alt=" item 1 " />
        </div>
        <p class="footer__point-txt txt-20 lh-27 txt-upper flex1">Latwe zakupy
          za pobraniem</p>
      </div>
    </div>
  </div>
</section>
<div class="cookies">
  <div class="cookies__container">
    <p class="txt-18 c-white lh-27">We use cookies to improve our site and your shopping experience. By continuing to browse on this website you accept the use of cookies.
      <a href="#" class="txt-18 c-white">More information.</a>
    </p>
    <p class="cookies__close">
      <i></i>
      <i></i>
    </p>
  </div>
</div>
<div class="modal" style="display: none">
  <div class="modal__content">
    video_file
  </div>
</div>
<!-- <?php get_template_part('template-parts/hedo-newsletter'); ?> -->
<?php
get_footer();
