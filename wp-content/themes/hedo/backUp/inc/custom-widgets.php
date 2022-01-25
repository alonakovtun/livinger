<?php

/**
 * Custom widgets
 *
 * @package Hedonizm
 */

/**
 * Register widget area.
 */
function hedonizm_widgets_init()
{
    register_sidebar(array(
        'name'          => 'Filters Widget',
        'id'            => 'filters-column',
        'description'   => 'Add widgets here.',
        'before_widget' => '<div id="%1$s" class="wow fadeInUp filters__element %2$s" data-wow-delay="1.1s">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="filters__head"><p class="txt-18 c-gold txt-light">',
        'after_title'   => '<span class="filters__head-plus">+</span></p></div>',
    ));
}
add_action('widgets_init', 'hedonizm_widgets_init');
