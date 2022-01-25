<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package egofilm
 */

?>

	</div><!-- #content -->

	<footer class="footer l-footer container-fluid site-footer" id="colophon">
    <div class="footer__container">
      <?
      $acf_footer = get_field( 'footer', 8 );
      ?>
      <div class="footer_left">
        EG<span>o</span>FILm &copy;2021
      </div>
      <div class="footer_animation">
        Animation studio
      </div>
      <ul class="footer_center b-nav a--flx-row-btv">
        <? wp_nav_menu( array(
          'theme_location'  => 'footer_social',
          'menu'            => 'Social',
          'container'       => false,
          'menu_class'      => 'menu',
          'menu_id'         => '',
          'echo'            => true,
          'fallback_cb'     => 'wp_page_menu',
          'before'          => '',
          'after'           => '',
          'link_before'     => '',
          'link_after'      => '',
          'items_wrap'      => '%3$s',
          'depth'           => 0,
          'walker'          => '',
        ) );
        ?>
      </ul>
    </div>
	</footer>
</div>
<?php wp_footer(); ?>
<script src='//http://egofilm.puzzlestudio.eu/wp-content/themes/egofilm/custom/js/app.js'></script>
</body>
</html>
