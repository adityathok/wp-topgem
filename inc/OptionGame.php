<?php
namespace WPTopGem;

class OptionGame extends ItemGame {

    public $game_option = 'itemgame_option';

    public function initialize() {
        add_action( 'cmb2_admin_init', array($this, 'register_cmb2') );
    }

    public function register_cmb2() {
        $main_options = new_cmb2_box( 
            array(
                'id'           => $this->game_option,
                'title'        => 'Pengaturan',
                'object_types' => array( 'options-page' ),
                'option_key'   => $this->game_option,
                'tab_group'    => $this->game_option,
                'tab_title'    => 'Umum',
                'parent_slug'  => 'edit.php?post_type='.$this->post_type,
            ) 
        );
        $main_options->add_field( array(
            'name'    => esc_html__( 'No Whatsapp Pemesanan', 'cmb2' ),
            'desc'    => esc_html__( '', 'cmb2' ),
            'id'      => 'nowhatsapp_order',
            'type'    => 'text',
        ) );

        //Pembayaran
	    $pembayaran_options = new_cmb2_box( 
            array(
                'id'           => $this->game_option.'_pembayaran',
                'title'        => 'Metode Bayar',
                'object_types' => array( 'options-page' ),
                'option_key'   => $this->game_option.'_pembayaran',
                'tab_group'    => $this->game_option,
                'tab_title'    => 'Metode Pembayaran',
                'parent_slug'  => $this->game_option,
            ) 
        );
        $pemb_field = $pembayaran_options->add_field( array(
            'id'          => 'opsi_bayar',
            'type'        => 'group',
            'description' => __( 'Opsi Metode Pembayaran untuk pembelian.', 'cmb2' ),
            'options'     => array(
                'group_title'       => __( 'Metode Bayar {#}', 'cmb2' ),
                'add_button'        => __( 'Tambah Metode', 'cmb2' ),
                'remove_button'     => __( 'Hapus Metode', 'cmb2' ),
                'sortable'          => true,
                'closed'            => true,
            ),
        ) );        
        $pembayaran_options->add_group_field( $pemb_field, array(
            'name' => 'Nama Pembayaran',
            'id'   => 'nama',
            'type' => 'text',
        ) );        
        $pembayaran_options->add_group_field( $pemb_field, array(
            'name' => 'Deskripsi',
            'id'   => 'deskripsi',
            'type' => 'textarea',
        ) );   

    }

    public function get($item){
        return get_option( $this->game_option.$item );
    }

}

// Inisialisasi class OptionGame
$OptionGame = new OptionGame();
$OptionGame->initialize();