<?php
//[wptopgem-formorder]
add_shortcode('wptopgem-formorder', function($atts){
    ob_start();
    global $post;
    $atribut = shortcode_atts( array(
        'id' => $post->ID,
    ), $atts );
    $post_id    = $atribut['id'];
    $FormOrderGame  = new WPTopGem\FormOrderGame($post_id);
    echo $FormOrderGame->form();
    return ob_get_clean();
});

//[wptopgem data=developer]
add_shortcode('wptopgem', function($atts){
    ob_start();
    global $post;
    $atribut = shortcode_atts( array(
        'id'        => $post->ID,
        'data'      => '',
        'display'   => '',
    ), $atts );
    $post_id    = $atribut['id'];
    $data       = $atribut['data'];
    $display    = $atribut['display'];

    $DataGame   = new WPTopGem\DataGame($post_id);
    
    if($data == 'developer') {
        echo $DataGame->developer();
    }

    if($data == 'banner') {
        echo $DataGame->developer();
    }

    return ob_get_clean();
});

//[wptopgem-tabelharga]
add_shortcode('wptopgem-tabelharga', function($atts){
    ob_start();
    $atribut = shortcode_atts( array(
        'id' => '',
    ), $atts );
    $post_id    = $atribut['id'];
    
    echo '<div class="wptopgem-tabelharga">';
        // The Query.
        $args = array(
            'post_type'         => 'itemgame',
            'posts_per_page'    =>-1
        );
        $the_query = new WP_Query( $args );

        // The Loop.
        if ( $the_query->have_posts() ) {
            echo '<div class="table-responsive">';
                echo '<table class="table bg-transparent">';
                    echo '<thead>';
                        echo '<tr><th class="bg-transparent">Game</th><th class="bg-transparent">Nominal</th><th class="bg-transparent">Harga</th></tr>';
                    echo '</thead>';
                    echo '<tbody>';
                    while ( $the_query->have_posts() ) {
                        $the_query->the_post();
                        $data_nominal = get_post_meta(get_the_ID(),'data_nominal',true);
                        if($data_nominal) {
                            foreach($data_nominal as $n => $data):
                                $title = $data['title'];
                                $price = $data['harga'];
                                echo '<tr>';
                                    echo '<td class="bg-transparent">' . esc_html( get_the_title() ) . '</td>';
                                    echo '<td class="bg-transparent">' . esc_html( $title ) . '</td>';
                                    echo '<td class="bg-transparent">' . esc_html( wptopgem_rupiah($price) ) . '</td>';
                                echo '</tr>';
                            endforeach;
                        }
                    }
                    echo '</tbody>';
                echo '</table>';
            echo '</div>';
        } else {
            esc_html_e( 'Sorry, no games matched your criteria.' );
        }
        // Restore original Post Data.
        wp_reset_postdata();
    echo '</div>';
    
    return ob_get_clean();
});