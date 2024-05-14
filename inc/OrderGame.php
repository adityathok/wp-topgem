<?php
namespace WPTopGem;

class OrderGame extends ItemGame {

    public $post_type = 'ordergame';

    public function initialize() {
        add_action('init', array($this, 'register_post_type'));
        add_action( 'cmb2_admin_init', array($this, 'register_cmb2') );
        add_action( 'wp_ajax_topupgame', array($this, 'topupgame') );
        add_action( 'wp_ajax_nopriv_topupgame', array($this, 'topupgame') );
    }

    public function register_post_type() {
        $args = array(
         'labels' => array(
             'name'              => 'Order Game',
             'singular_name'     => $this->post_type,
             'add_new'           => __( 'Tambah Orderan', 'velocity-gameol' ),
             'add_new_item'      => __( 'Tambah Orderan', 'velocity-gameol' ),
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
            'id'           => $this->post_type.'_cmb2_metabox',
            'title'        => 'Detail Pesanan',
            'priority'     => 'high',
            'object_types' => array( $this->post_type ),
        ));
        $cmb->add_field( array(
            'name'      => 'Nomor Invoice',
            'desc'      => '',
            'type'      => 'text',
            'id'        => 'invoice',
            'default'   => $this->generate_invoice(),
        ));
        $cmb->add_field( array(
            'name'      => 'Status',
            'desc'      => '',
            'type'      => 'select',
            'id'        => 'status',
            'column'    => true,
            'options'   => array(
                'baru'      => __( 'Pesanan Baru', 'cmb2' ),
                'lunas'     => __( 'Lunas', 'cmb2' ),
                'sukses'    => __( 'Sukses', 'cmb2' ),
                'gagal'     => __( 'Gagal', 'cmb2' ),
            ),
        ));
        $cmb->add_field( array(
            'name'          => 'Game',
            'desc'          => '',
            'type'          => 'text',
            'id'            => 'game',
            'column'        => true,
        ));
        $cmb->add_field( array(
            'name'          => 'ID Game',
            'desc'          => '',
            'type'          => 'text',
            'id'            => 'id_game',
        ));
        $cmb->add_field( array(
            'name'          => 'Data Player',
            'desc'          => '',
            'type'          => 'text',
            'id'            => 'player',
            'repeatable'    => true, 
        ));
        $cmb->add_field( array(
            'name'          => 'Nominal',
            'desc'          => '',
            'type'          => 'text',
            'id'            => 'nominal',
            'column'        => true,
        ));
        $cmb->add_field( array(
            'name'          => 'Kode Promo',
            'desc'          => '',
            'type'          => 'text',
            'id'            => 'kode_promo',
        ));
        $cmb->add_field( array(
            'name'          => 'Potongan',
            'desc'          => '',
            'type'          => 'text',
            'id'            => 'potongan',
        ));
        $cmb->add_field( array(
            'name'          => 'Total Bayar',
            'desc'          => '',
            'type'          => 'text',
            'id'            => 'total_bayar',
            'column'        => true,
        ));
        $cmb->add_field( array(
            'name'          => 'Metode Pembayaran',
            'desc'          => '',
            'type'          => 'text',
            'id'            => 'pembayaran',
        ));
        $cmb->add_field( array(
            'name'          => 'No. WhatsApp',
            'desc'          => '',
            'type'          => 'text',
            'id'            => 'nowa',
            'column'        => true,
        ));
        $cmb->add_field( array(
            'name'          => 'Email',
            'desc'          => '',
            'type'          => 'text',
            'id'            => 'email',
        ));
    }

    public function generate_invoice() {
        return strtoupper(bin2hex(random_bytes(6)));
    }
    
    public function topupgame() {
        
        parse_str($_POST['formdata'], $formData);

        // Check for nonce security      
        if ( ! wp_verify_nonce( $_POST['nonce'], 'ajax-nonce' ) || !wp_verify_nonce( $formData['ordergame-nonce'], 'ordergame-action' ) ) {
            return false;
        }

        $invoice = $this->generate_invoice();

        print_r($formData);

        // Create post object
        $new_post = array(
            'post_title'    => wp_strip_all_tags( $invoice ),
            'post_type'     => $this->post_type,
            'post_content'  => '',
            'post_status'   => 'publish',
            'meta_input'    => array(
                'status'        => 'baru',
                'invoice'       => $invoice,
            ),
        );

        foreach($formData as $key => $value):
            if ( $key == 'ordergame-nonce' ) { continue; }
            if ( $key == '_wp_http_referer' ) { continue; }
            if ( $key == 'dataplayer' ) { continue; }

            if($key == 'kode_promo' && $formData['potongan'] == 0){
                $value = '';
            }

            $new_post['meta_input'][$key] = $value;
        endforeach;

        //dataplayer 
        $dataplayer = [];           
        foreach($formData['dataplayer'] as $key => $value):
            $dataplayer[] = $key.' : '.$value;
        endforeach;
        $new_post['meta_input']['player']       = $dataplayer;
        $new_post['meta_input']['data_player']  = $formData['dataplayer'];

        //SAVE
        // $new_postid = wp_insert_post( $new_post );

        echo '<div class="my-2">';            
            echo '<div class="alert alert-success border-2 text-center w-100 mb-4" style="border-style: dashed;">';
                echo 'KODE INVOICE : <br>';
                echo '<div class="fs-2 fw-bold">'.$invoice.'</div>';
            echo '</div>';
        echo '</div>';

        wp_die();
    }

}

// Inisialisasi class OrderGame
$OrderGame = new OrderGame();
$OrderGame->initialize();