<?php

if (!defined('_S_VERSION')) {
  define('_S_VERSION', '1.0.0');
}

if (!function_exists('hedo_setup')) :
  function hedo_setup()
  {
    load_theme_textdomain('hedo', get_template_directory() . '/languages');

    add_theme_support('automatic-feed-links');

    add_theme_support('title-tag');

    add_theme_support('woocommerce');

    add_theme_support('post-thumbnails');

    register_nav_menus(
      array(
        'menu-1' => esc_html__('Primary', 'hedo'),
        'category' => esc_html__('Category', 'hedo'),
        'footer-sklep' => esc_html__('Footer Sklep', 'hedo'),
        'footer-sklep_2' => esc_html__('Footer Sklep 2', 'hedo'),
        'footer-hedo' => esc_html__('Footer Hedo', 'hedo'),
        'footer-info' => esc_html__('Footer Info', 'hedo'),
        'information-menu' => esc_html__('Information Menu', 'hedo'),
        'mobile' => esc_html__('Mobile', 'hedo'),
      )
    );

    add_theme_support(
      'html5',
      array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
      )
    );

    add_theme_support(
      'custom-background',
      apply_filters(
        'hedo_custom_background_args',
        array(
          'default-color' => 'ffffff',
          'default-image' => '',
        )
      )
    );

    add_theme_support('customize-selective-refresh-widgets');

    add_theme_support(
      'custom-logo',
      array(
        'height' => 250,
        'width' => 250,
        'flex-width' => true,
        'flex-height' => true,
      )
    );
  }
endif;
add_action('after_setup_theme', 'hedo_setup');


require get_template_directory() . '/inc/custom-header.php';

require get_template_directory() . '/inc/template-tags.php';

require get_template_directory() . '/inc/template-functions.php';

require get_template_directory() . '/inc/customizer.php';

require get_template_directory() . '/inc/custom-function.php';

require get_template_directory() . '/inc/woocommerce.php';

require get_template_directory() . '/inc/custom-widgets.php';

require get_template_directory() . '/inc/single-product-function.php';

require get_template_directory() . '/inc/ajax-cart-qty.php';

require get_template_directory() . '/inc/checkout-function.php';



//function hedo_widgets_init() {
//	register_sidebar(
//		array(
//			'name'          => esc_html__( 'Sidebar', 'hedo' ),
//			'id'            => 'sidebar-1',
//			'description'   => esc_html__( 'Add widgets here.', 'hedo' ),
//			'before_widget' => '<section id="%1$s" class="widget %2$s">',
//			'after_widget'  => '</section>',
//			'before_title'  => '<h2 class="widget-title">',
//			'after_title'   => '</h2>',
//		)
//	);
//}
//add_action( 'widgets_init', 'hedo_widgets_init' );
