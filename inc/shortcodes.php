<?php
//[wptopgem-formorder]
add_shortcode('wptopgem-formorder', function($atts){
    ob_start();
    global $post;
    $atribut = shortcode_atts( array(
        'id' => $post->ID,
    ), $atts );
    $post_id    = $atribut['id'];
    $OrderGame  = new WPTopGem\OrderGame($post_id);
    echo $OrderGame->form();
    return ob_get_clean();
});