<?php
add_action('wp_ajax_cart_incr', 'ajax_cart_incr');
add_action('wp_ajax_nopriv_cart_incr', 'ajax_cart_incr');

function ajax_cart_incr()
{
    $item_id  = $_POST['id'];
    $cart     = WC()->cart;
    $items    = $cart->get_cart();
    $item     = $items[$item_id];
    $quantity = $item['quantity'];

    $cart->set_quantity($item_id, ++$quantity);

    $fragments = WC_Ajax::get_refreshed_fragments();

    // print_r($fragments);

    die();
}


add_action('wp_ajax_cart_decr', 'ajax_cart_decr');
add_action('wp_ajax_nopriv_cart_decr', 'ajax_cart_decr');
function ajax_cart_decr()
{
    $item_id  = $_POST['id'];
    $cart     = WC()->cart;
    $items    = $cart->get_cart();
    $item     = $items[$item_id];
    $quantity = $item['quantity'];

    $cart->set_quantity($item_id, --$quantity);

    $fragments = WC_Ajax::get_refreshed_fragments();

    // print_r($fragments);

    die();
}
