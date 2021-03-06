<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package hedo
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.css" />
  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" /> -->
  <?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>
  <div id="page" class="site">
    <div class="header__mobile-fake"></div>
    <header class="header">
      <div class="header__mobile">
        <div class="header__mobile-container">
          <div class="header__mobile-grid">
            <a href="/" class="header__mobile-logo">
              <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 232 34.79">
                <defs>
                  <style>
                    .cls-1 {
                      fill: #13422d;
                    }
                  </style>
                </defs>
                <g>
                  <g>
                    <g>
                      <path class="cls-1" d="M177.66,9.7V25.09c0,1.55.23,1.9,2.66,1.9v.53h-6.84V27c2.4,0,2.63-.35,2.63-1.9V17.17h-7.9v7.92c0,1.55.2,1.9,2.64,1.9v.53H164V27c2.43,0,2.63-.35,2.63-1.9V9.7c0-1.55-.2-1.9-2.63-1.9V7.27h6.84V7.8c-2.44,0-2.64.35-2.64,1.9v6.61h7.9V9.7c0-1.55-.23-1.9-2.63-1.9V7.27h6.84V7.8C177.89,7.8,177.66,8.15,177.66,9.7Z" />
                      <path class="cls-1" d="M180.52,17.4c0-5.85,2.76-10.64,7.39-10.64s7.4,4.79,7.4,10.64S192.57,28,187.91,28,180.52,23.25,180.52,17.4Zm13-.51c-.51-5.72-3-9.6-6.51-9.29s-5.32,4.55-4.81,10.3,3,9.57,6.53,9.27S194.07,22.64,193.56,16.89Z" />
                      <path class="cls-1" d="M231.47,22.31c-1.12,3.87-1.6,4.35-3.14,4.35h-5c-1,0-1.19-.25-1.19-1.44v-7.9h3.9c1.55,0,1.88.23,1.88,2.91h.56V13.55H228c0,2.68-.33,2.91-1.88,2.91h-3.9V8.13h5.9c1.55,0,1.93.35,2.28,3.62l.54-.05-.43-3.93-.06-.5H212.3L206.25,25h-.08L200.22,7.27h-4.71V7.8c2.43,0,2.63.35,2.63,1.9V25.09c0,1.55-.2,1.9-2.63,1.9v.53h6.13V27c-2.43,0-2.64-.33-2.64-1.88L199,9H199l6.36,19.12h.76L212.7,8.74h.08V25.09c0,1.55-.23,1.9-2.66,1.9v.53h20.39l.12-.45L232,22.46ZM220.6,25.09c0,1.53-.84,1.89-3.22,1.9s-3.06-.37-3.06-1.9V9.7c0-1.53.72-1.89,3.06-1.9s3.22.37,3.22,1.9Z" />
                    </g>
                    <g>
                      <path class="cls-1" d="M64.81,27c2.43,0,2.63-.35,2.63-1.9V9.7c0-1.55-.2-1.9-2.63-1.9V7.27h6.91c5.7,0,9.67,3.72,9.67,10.13s-4.15,10.12-9.67,10.12H64.81ZM79.7,17.4c0-5.6-3.09-9.27-8-9.27A6.6,6.6,0,0,0,69,8.58V26.21a6.6,6.6,0,0,0,2.71.45C76.61,26.66,79.7,23,79.7,17.4Z" />
                      <path class="cls-1" d="M83.37,17.4c0-5.85,2.76-10.64,7.39-10.64s7.4,4.79,7.4,10.64S95.42,28,90.76,28,83.37,23.25,83.37,17.4Zm13-.51c-.51-5.72-3-9.6-6.51-9.29s-5.32,4.55-4.81,10.3,3,9.57,6.53,9.27S96.91,22.64,96.41,16.89Z" />
                      <path class="cls-1" d="M125.33,20.33h.53c0,4.23,2.38,6.84,4.94,6.84a3.43,3.43,0,0,0,3.62-3.72c0-2.46-2.48-4.31-5.09-6.54-2.74-2.4-4-3.57-4-6,0-2.64,2-4.18,4.59-4.18s3.74,1.92,4.28,1.92c.22,0,.32-.15.32-1.44h.56v5.88h-.56c0-3.19-1.92-5.5-4.53-5.5a2.9,2.9,0,0,0-3.24,2.94c0,2.25,2.28,3.8,4.13,5.44,3.34,3,5,4.16,5,7.27A4.67,4.67,0,0,1,131,28c-3,0-3.9-2-4.64-2-.4,0-.53.38-.53,1.49h-.53Z" />
                      <path class="cls-1" d="M147.49,25l6-17.75h4.66V7.8c-2.41,0-2.64.35-2.64,1.9V25.09c0,1.55.23,1.9,2.64,1.9v.53h-6.84V27c2.43,0,2.66-.35,2.66-1.9V8.74h-.08l-6.56,19.37h-.76L140.27,9h-.08l.05,16.1c0,1.55.21,1.9,2.64,1.88v.55h-6.13V27c2.43,0,2.63-.35,2.63-1.9V9.7c0-1.55-.2-1.9-2.63-1.9V7.27h4.71L147.41,25Z" />
                      <path class="cls-1" d="M64,22.3c-1.11,3.87-1.59,4.35-3.14,4.35h-5c-1,0-1.19-.25-1.19-1.44v-7.9h3.9c1.55,0,1.87.23,1.87,2.91h.56V13.53h-.56c0,2.69-.32,2.92-1.87,2.92h-3.9V8.11h5.9c1.55,0,1.93.36,2.28,3.63l.53-.05L63,7.76,63,7.25H42.7v.54c2.4,0,2.63.35,2.63,1.89v6.61h-7.9V9.68c0-1.54.2-1.89,2.63-1.89V7.25H33.23v.54c2.43,0,2.63.35,2.63,1.89v15.4c0,1.55-.2,1.9-2.63,1.9v.53h6.83V27c-2.43,0-2.63-.35-2.63-1.9V17.16h7.9v7.92c0,1.55-.23,1.9-2.63,1.9v.53H63.08l.13-.45,1.37-4.61ZM53.19,11.71V25.08c0,1.55-.75,1.9-3.16,1.9s-3.16-.35-3.16-1.9V9.68c0-1.54.76-1.89,3.16-1.89s3.16.35,3.16,1.89Z" />
                      <path class="cls-1" d="M113.15,6.68h-3.06v.54c2.4,0,2.63.35,2.63,1.89V24h-.07L102,6.68h-3.6v.54A2.7,2.7,0,0,1,101,8.3V24.51c0,1.55-.2,1.9-2.64,1.9v.53h6.13v-.53c-2.4,0-2.63-.35-2.63-1.9V9.67l11,17.85h.65l.11-.18V24h0V9.11c0-1.54.23-1.89,2.63-1.89V6.68Z" />
                      <rect class="cls-1" x="112.93" y="25.97" width="0.65" height="1.55" />
                      <path class="cls-1" d="M120.4,10.18V8.72c.06-1.21.45-1.5,2.63-1.5V6.68H116.2v.54c2.12,0,2.55.27,2.62,1.41v1.55h0V24h0v1.46c0,1.21-.44,1.5-2.63,1.5v.53H123V27c-2.13,0-2.56-.28-2.63-1.41V24h0V10.18Z" />
                    </g>
                  </g>
                  <g>
                    <path class="cls-1" d="M24.17,0H.61A.61.61,0,0,0,0,.61V34.18a.61.61,0,0,0,.61.61H24.17a.61.61,0,0,0,.61-.61V.61A.61.61,0,0,0,24.17,0Zm-.29,32.55c0,1.2-.58,1.24-1.65,1.32l-1.39,0H3.94l-1.39,0C1.49,33.79.9,33.75.9,32.55V2.24C.9,1,1.49,1,2.55.92L3.94.9h16.9l1.39,0C23.3,1,23.88,1,23.88,2.24Z" />
                    <path class="cls-1" d="M16.37,10.38v.37l0,.16h.16a3.42,3.42,0,0,1,1,.08c.17.06.28.16.28.47v5.61H15.18V8.45c0-.47.12-.5.75-.54h.93V7.38H12.6V7.9h.93c.63,0,.75.07.75.54V26.34c0,.5-.07.51-.54.53h-.21l-.77,0H12.6v.52h4.26V26.9H16.7l-.77,0h-.21c-.47,0-.54,0-.54-.53V17.71h2.66v5.64a.56.56,0,0,1-.12.41c-.15.15-.52.15-1,.15h-.37v.52h3.85v-.52h-.37c-.46,0-.83,0-1-.15a.56.56,0,0,1-.12-.41V11.46c0-.31.11-.41.28-.47a3.42,3.42,0,0,1,1-.08h.17l0-.16v-.37H16.37Z" />
                    <path class="cls-1" d="M10.05,7.38H7.92V7.9h.93c.64,0,.75.07.75.54v8.62H6.94V11.46c0-.31.11-.41.28-.47a3.45,3.45,0,0,1,1-.08h.16l0-.16v-.37H4.56v.37l0,.16h.16a3.42,3.42,0,0,1,1,.08c.17.06.28.16.28.47V23.35a.56.56,0,0,1-.12.41c-.15.15-.52.15-1,.15H4.56v.52H8.41v-.52H8c-.46,0-.83,0-1-.15a.56.56,0,0,1-.12-.41V17.71H9.6v8.63c0,.5-.07.51-.54.53h-.2l-.78,0H7.92v.52h4.26V26.9H12l-.77,0H11c-.47,0-.54,0-.54-.53V8.45c0-.47.12-.5.75-.54h.93V7.38H10.05Z" />
                  </g>
                </g>
              </svg>
              <!-- <img src="<?php bloginfo('template_directory') ?>/assets/img/logo_mobile.png" alt="image format png" /> -->
            </a>
            <div class="header__mobile-grid_end">
              <div class="header__mobile-burger">
                <i></i><i></i><i></i>
              </div>
              <div class="header__mobile-basket">
                <!-- <span class="ilosch"><?php // echo WC()->cart->get_cart_contents_count() === 0 ? '' :  WC()->cart->get_cart_contents_count()
                                          ?></span> -->
                <img src="<?php bloginfo('template_directory') ?>/assets/img/Bag-01.svg" alt="search" class="<?php echo WC()->cart->get_cart_contents_count() === 0 ? '' : '' ?>" />
                <span><?= WC()->cart->get_cart_contents_count() ?></span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <nav class="header__menu-mobile">
        <ul class="menu menu-start">
          <li class="menu-item menu-item_sklep">
            <a href="#">Sklep</a>
          </li>
          <li class="menu-item menu-item_sklep">
            <a href="#">PL/PLN</a>
          </li>
          <li class="menu-item menu-item_sklep">
            <a href="/my-account">Konto</a>
          </li>
          <li class="menu-item menu-item_search">
            <a href="#">Szukaj</a>
            <form role="search" method="get" class="woocommerce-product-search" action="<?php echo esc_url(home_url('/')); ?>" class="sub-search">
              <input type="search" id="woocommerce-product-search-field-<?php echo isset($index) ? absint($index) : 0; ?>" class="search-field textarea__search" placeholder="<?php echo esc_attr__('Szukaj products&hellip;', 'woocommerce'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
              <button type="submit" value="<?php echo esc_attr_x('Search', 'submit button', 'woocommerce'); ?>"><?php echo esc_html_x('Szukaj', 'submit button', 'woocommerce'); ?></button>
            </form>
          </li>
        </ul>
        <?php
        wp_nav_menu(
          array(
            'theme_location' => 'mobile',
            'menu_id'        => 'mobile',
          )
        );
        ?>

      </nav>
      <div class="header__container">
        <div class="header__head flex jc-space al-start header__desktop">
          <div class="header__column-left flex jc-start al-center header__desktop">
            <div class="lang">
              <div class="lang__head">
                <p>PL/ENG</p>
              </div>
            </div>
            <div class="social flex jc-start al-center">
              <a href="#">
                <img src="<?php bloginfo('template_directory') ?>/assets/img/FB-01.svg" alt="image format png" />
              </a>
              <a href="#">
                <img src="<?php bloginfo('template_directory') ?>/assets/img/instagram-01.svg" alt="image format png" />
              </a>
            </div>
          </div>
          <a href="/" class="logo header__desktop">
            <img src="<?php bloginfo('template_directory') ?>/assets/img/logo-main.svg" alt="image format png" />
          </a>
          <div class="header__column-right header__desktop">
            <ul class="menu-left flex jc-end al-end">
              <li class="menu-left__item"><a class="search-trigger" href="#"><img src="<?php bloginfo('template_directory') ?>/assets/img/Search-01.svg" alt="search" /></a></li>
              <li class="menu-left__item"><a class="trigger-change" href="/my-account"><img src="<?php bloginfo('template_directory') ?>/assets/img/Account<?= is_user_logged_in() ? '_fill-' : '-' ?>01.svg" alt="search" /></a></li>
              <li class="menu-left__item">
                <a class="trigger-change" href="/my-account/wish-list/">
                  <img src="<?php bloginfo('template_directory') ?>/assets/img/<?= YITH_WCWL()->count_products() === 0 ? 'Wishlist-01.svg' : 'Wishlist_add-01.svg' ?>" alt="search" />
                </a>
              </li>
              <li class="menu-left__item-cart menu-left__item">
                <a href="#" class="mini-cart-trigger">
                  <span class="ilosch"><?php echo WC()->cart->get_cart_contents_count() === 0 ? '' :  WC()->cart->get_cart_contents_count()  ?></span>
                  <img src="<?php bloginfo('template_directory') ?>/assets/img/Bag-01.svg" alt="search" class="<?php echo WC()->cart->get_cart_contents_count() === 0 ? '' : 'ml-5' ?>" />
                </a>
              </li>
            </ul>
          </div>
        </div>
        <div class="mini-cart">
          <?php get_template_part('template-parts/hedo-mini-cart'); ?>
        </div>
      </div>
      <?php get_template_part('template-parts/hedo-search'); ?>
      <div class="header__bottom header__desktop">
        <div class="header__container">
          <!-- #site-navigation -->
          <nav id="site-navigation" class="main-navigation">
            <?php
            wp_nav_menu(
              array(
                'theme_location' => 'category',
                'menu_id'        => 'category',
              )
            );
            ?>
          </nav>
        </div>
      </div>
    </header><!-- #masthead -->