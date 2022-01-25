<?
/* Template Name: studio */

get_header(); ?>


<main class="studio">
  <div class="studio__container container">
    <div class="studio__description">
      <div class="studio__txt">
        <?php the_field('text_left_studio'); ?>
      </div>
      <ul class="studio__social b-nav a--flx-row-btv">
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
    <div class="studio__contact">
      <div class="studio__contact-txt">
        <?php the_field('contact_studio'); ?>
      </div>
    </div>
    <ul class="studio__social studio__social-mobile b-nav a--flx-row-btv">
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
</main>
<? get_footer();