<?php
namespace WPTopGem;

use \WP_Query;

class PromoGame {

    public $post_type = 'promogame';

    public function initialize() {
        add_action('init', array($this, 'register_post_type'));
        add_action( 'cmb2_admin_init', array($this, 'register_cmb2') );
        add_action( 'wp_ajax_submitkodepromogame', array($this, 'submitkodepromogame') );
        add_action( 'wp_ajax_nopriv_submitkodepromogame', array($this, 'submitkodepromogame') );
    }
    
    public function register_post_type() {
       $args = array(
        'labels' => array(
            'name'              => 'Kode Promo Game',
            'singular_name'     => $this->post_type,
            'add_new'           => __( 'Tambah Promo', 'velocity-gameol' ),
            'add_new_item'      => __( 'Tambah Promo', 'velocity-gameol' ),
        ),
        'public'                => true,
        'has_archive'           => false,
        'show_in_rest'          => false,
        'publicly_queryable'    => false,
        'show_in_menu'          => 'edit.php?post_type=itemgame',
        'supports'              => array('title'),
        'menu_icon'             => 'dashicons-games',
       );
       register_post_type($this->post_type, $args);
    }

    public function register_cmb2() {
        $cmb = new_cmb2_box( array(
            'id'           => 'promogame_cmb2_metabox',
            'title'        => 'Detail Promo',
            'priority'     => 'high',
            'object_types' => array( $this->post_type ),
        ) );
            
        $cmb->add_field( array(
            'name' => 'Potongan',
            'desc' => 'angka tanpa Rp dan titik contoh : 5000',
            'type' => 'text',
            'id'   => 'potongan',
        ) );
        $cmb->add_field( array(
            'name' => 'Minimal Pembelian',
            'desc' => 'angka tanpa Rp dan titik contoh : 5000',
            'type' => 'text',
            'id'   => 'minimal',
        ) );
    }

    public function submitkodepromogame() {
        $kode       = $_POST['kode'];
        $nominal    = $_POST['nominal'];
        $nominal    = isset($nominal)&!empty($nominal)?explode("|",$nominal):'';
        $nominal    = $nominal?str_replace(".", "", $nominal[1]):0;

        $result     = [
            'success'   => 0,
            'message'   => 'Data promo tidak ditemukan',
            'potongan'  => 0
        ];

        if($kode):
            // The Query.
            $the_query = new WP_Query( array(
                'post_type' => 'promogame',
                'title'     => $kode 
            ) );

            // The Loop.
            if ( $the_query->have_posts() ) {
                while ( $the_query->have_posts() ) {
                    $the_query->the_post();
                    $minimal    = get_post_meta(get_the_ID(),'minimal',true);
                    $potongan   = get_post_meta(get_the_ID(),'potongan',true);
                    $result     = [
                        'success'   => 1,
                        'message'   => 'Promo berhasil digunakan',
                        'potongan'  => $potongan,
                        'nominal'   => (int)$nominal
                    ];

                    if($minimal && $minimal >= $nominal):
                        $result = [
                            'success'   => 0,
                            'message'   => 'Kurang dari minimal <strong>('.number_format($minimal, 0, ",", ".").')</strong> pembelian',
                            'potongan'  => 0,
                            'nominal'  => (int)$nominal,
                            'minimal'  => $minimal
                        ];
                    endif;

                } 
            }

            // Restore original Post Data.
            wp_reset_postdata();
        endif;

        wp_send_json($result);
        wp_die();
    }

}

// Inisialisasi class PromoGame
$promo_game = new PromoGame();
$promo_game->initialize();