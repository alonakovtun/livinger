<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package hedo
 */

?>

<footer id="colophon" class="site-footer footer">
  <div class="footer__point">
    <div class="footer__point-container flex jc-space">
      <div class="footer__point-item flex jc-space al-center wow fadeIn" data-wow-delay="0.2s">
        <div class="footer__point-icon">
          <img src="<?php bloginfo('template_directory') ?>/assets/img/Wysylka-01.svg" alt=" item 1 " />
        </div>
        <p class="footer__point-txt txt-20 lh-27 txt-upper flex1">Darmowa
          dostawa od 299</p>
      </div>
      <div class="footer__point-item flex jc-space al-center wow fadeIn" data-wow-delay="0.4s">
        <div class="footer__point-icon">
          <img src="<?php bloginfo('template_directory') ?>/assets/img/Prezent-01.svg" alt=" item 1 " />
        </div>
        <p class="footer__point-txt txt-20 lh-27 txt-upper flex1">Kup prezent. Zapakujemy
          go dla Ciebie</p>
      </div>
      <div class="footer__point-item flex jc-space al-center wow fadeIn" data-wow-delay="0.6s">
        <div class="footer__point-icon">
          <img src="<?php bloginfo('template_directory') ?>/assets/img/Zwrot-01.svg" alt=" item 1 " />
        </div>
        <p class="footer__point-txt txt-20 lh-27 txt-upper flex1">30 dni na zwrot.
          Bez podania przyczyny</p>
      </div>
      <div class="footer__point-item flex jc-space al-center wow fadeIn" data-wow-delay="0.8s">
        <div class="footer__point-icon">
          <img src="<?php bloginfo('template_directory') ?>/assets/img/za_pobraniem-01.svg" alt=" item 1 " />
        </div>
        <p class="footer__point-txt txt-20 lh-27 txt-upper flex1">Latwe zakupy
          za pobraniem</p>
      </div>
    </div>
  </div>
  <div class="footer__menu flex jc-space al-start">
    <div class="footer__column wow fadeIn" data-wow-delay="0.1s">
      <div class="footer__column-child">

        <p class="txt-20 lh-27 mb-20 txt-upper sklep">Sklep</p>
        <?php
        wp_nav_menu(
          array(
            'theme_location' => 'footer-sklep',
            'menu_id'        => 'Footer sklep',
          )
        );
        ?>
      </div>
    </div>
    <div class="footer__column wow fadeIn" data-wow-delay="0.1s">
      <div class="footer__column-child">

        <p class="txt-20 lh-27 mb-20 txt-upper hidden_opacity">Sklep 2</p>
        <?php
        wp_nav_menu(
          array(
            'theme_location' => 'footer-sklep_2',
            'menu_id'        => 'Footer sklep 2',
          )
        );
        ?>
      </div>
    </div>
    <div class="footer__column wow fadeIn" data-wow-delay="0.3s">
      <div class="footer__column-child">
        <p id="home" class="txt-20 lh-27 mb-20 txt-upper">Hedonism home</p>
        <?php
        wp_nav_menu(
          array(
            'theme_location' => 'footer-hedo',
            'menu_id'        => 'Footer hedo',
          )
        );
        ?>
      </div>

    </div>
    <div class="footer__column  wow fadeIn" data-wow-delay="0.3s">
      <div class="footer__column-child">

        <p id="information" class="txt-20 lh-27 mb-20 txt-upper">informacje</p>
        <?php
        wp_nav_menu(
          array(
            'theme_location' => 'footer-info',
            'menu_id'        => 'Footer Info',
          )
        );
        ?>
      </div>
    </div>
  </div>
  <div class="footer__stick">
    <div class="footer__container">
      <div class="flex jc-space al-center">
        <div class="footer__contact flex jc-space al-center">
          <a href="tel:+48 543 129 643" class="contact-tel txt-16 c-white  lh-27">+48 543 129 643</a>
          <a href="mailto:kontakt@hedonismhome.pl" class="contact-tel txt-16 c-white  lh-27">kontakt@hedonismhome.pl</a>
          <div class="flex jc-end al-center">
            <a href="tel:+48 543 129 643" class="contact-social contact-tel txt-16 c-white  lh-27">Facebook</a>
            <a href="tel:+48 543 129 643" class="contact-social contact-tel txt-16 c-white  lh-27">Instagram</a>
          </div>
        </div>
        <div class="footer__copy flex jc-end al-center">
          <p class="txt-16 lh-27 c-white">All rights reserved. 2021 Hedonism</p>
          <p class="txt-16 lh-27 c-white">by PHS</p>
        </div>
      </div>
    </div>
  </div>
</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.6.1/gsap.min.js"></script>
<script>
  jQuery(document).ready(function() {
    jQuery('.js-example-basic-single').select2();
  });

  ($window = jQuery(window)),
  ($document = jQuery(document)),
  ($body = jQuery('body'));

  (function($) {
    // Mini Cart
    var $qtyControls = jQuery('.b-cart-item_qty_controls'),
      $btnDecr = jQuery('.minus'),
      $btnIncr = jQuery('.plus');

    // | Increase
    // |----------
    $document.on('click', '.plus', function() {
      var $ths = jQuery(this),
        $qty = $ths.closest('.b-cart-item_qty'),
        $inputQty = jQuery(this).prev().children(),
        $intClick = jQuery(this).parent().parent().parent().parent().parent();
      $preloader = jQuery(this).parent().parent().parent().parent().parent().children('.preloader');
      $total = jQuery('.mini-cart__total-price bdi'),
        qty = $qty.data('qty'),
        id = $qty.data('key'),
        data = {
          action: 'cart_incr',
          id: id,
        };




      $preloader.addClass('_active');
      jQuery('.preloader2').addClass('_active');

      request = $.ajax({
        url: pzl.url.ajax,
        type: 'post',
        data: data,

        success: function(res) {
          if (res.fragments) {
            if ($body.hasClass('woocommerce-checkout')) {
              // Update Fragments
              // -----
              if (res.fragments) {
                console.log(res.fragments);
                $document.trigger('added_to_cart', [
                  res.fragments,
                  res.cart_hash,
                ]);

                // Refresh Checkout
                $body.trigger('update_checkout');
                jQuery('.preloader').removeClass('_active');
              }
            } else {
              $.each(res.fragments, function(key, value) {
                const fake_div = document.createElement('div');
                fake_div.innerHTML = value;
                console.log(fake_div);

                const new_qty = fake_div.querySelectorAll('.quantity');
                let current_qty = '';
                new_qty.forEach((item, i) => {
                  if (i === jQuery('.mini-cart__item').index($intClick)) {
                    const child = item.childNodes[0];
                    current_qty = child.textContent.replace(/[^+\d]/g, '');
                  }
                })


                const new_price = fake_div.querySelector('.total bdi').innerText;
                $total.text(new_price);

                $inputQty.text(current_qty);
                fake_div.remove();
                jQuery(key).replaceWith(value);
                jQuery(key).stop(true).css('opacity', '1').unblock();
                $preloader.removeClass('_active');
                jQuery('.preloader2').removeClass('_active');

              });

              $body.trigger('wc_fragments_loaded');
              $body.trigger('cart_totals_refreshed');
              $body.trigger('cart_page_refreshed');
            }
          }
        },

        error: function(err) {},
      });
    });

    // | Decrease
    // |----------
    $document.on('click', '.minus', function() {
      var $ths = jQuery(this),
        $qty = $ths.closest('.b-cart-item_qty'),
        $inputQty = jQuery(this).next().children(),
        $intClick = jQuery(this).parent().parent().parent().parent().parent(),
        $preloader = jQuery(this).parent().parent().parent().parent().parent().children('.preloader'),
        $total = jQuery('.mini-cart__total-price bdi'),
        qty = $qty.data('qty'),
        id = $qty.data('key'),
        data = {
          action: 'cart_decr',
          id: id,
        };
      $preloader.addClass('_active');
      jQuery('.preloader2').addClass('_active');

      if (qty < 2) return;

      request = $.ajax({
        url: pzl.url.ajax,
        type: 'post',
        data: data,

        success: function(res) {
          if (res.fragments) {
            if ($body.hasClass('woocommerce-checkout')) {
              // Update Fragments
              // -----
              if (res.fragments) {
                $document.trigger('removed_from_cart', [
                  res.fragments,
                  res.cart_hash,
                ]);

                // Refresh Checkout
                $body.trigger('update_checkout');

                jQuery('.preloader').removeClass('_active');

              }
            } else {
              $.each(res.fragments, function(key, value) {
                const fake_div = document.createElement('div');
                fake_div.innerHTML = value;

                const new_qty = fake_div.querySelectorAll('.quantity');
                let current_qty = '';
                new_qty.forEach((item, i) => {
                  if (i === jQuery('.mini-cart__item').index($intClick)) {
                    const child = item.childNodes[0];
                    current_qty = child.textContent.replace(/[^+\d]/g, '');
                  }
                })

                const new_price = fake_div.querySelector('.total bdi').innerText;
                $total.text(new_price);



                $inputQty.text(current_qty);
                fake_div.remove();

                jQuery(key).replaceWith(value);
                jQuery(key).stop(true).css('opacity', '1').unblock();
                $preloader.removeClass('_active');
                jQuery('.preloader2').removeClass('_active');
              });

              $body.trigger('wc_fragments_loaded');
              $body.trigger('cart_totals_refreshed');
              $body.trigger('cart_page_refreshed');
            }
          }
        },

        error: function(err) {
          console.log('--| decr error');
          console.log(err);
        },
      });
    });

    jQuery(document).on('change', "#billing_country, #shipping_country, .country_to_state", function(event) {
      jQuery(document.body).trigger('update_checkout');
    });
  })(jQuery);
</script>
</body>

</html>