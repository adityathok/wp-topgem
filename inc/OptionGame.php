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
                'title'        => 'Pengaturan Game',
                'object_types' => array( 'options-page' ),
                'option_key'   => $this->game_option,
                'tab_group'    => $this->game_option,
                'tab_title'    => 'Umum',
                'position'     => 31,
                'icon_url'     => 'dashicons-games',
            ) 
        );
        $main_options->add_field( array(
            'name'    => esc_html__( 'Nama Toko', 'wp-topgem' ),
            'desc'    => esc_html__( 'Nama / Branding Toko', 'wp-topgem' ),
            'id'      => 'nama_toko',
            'type'    => 'text',
            'default' => get_bloginfo( 'name' )
        ) );
        $main_options->add_field( array(
            'name'    => esc_html__( 'Aktifkan Email Notifikasi Admin', 'wp-topgem' ),
            'desc'    => esc_html__( 'Aktifkan Email untuk menerima notif pembelian ke admin', 'wp-topgem' ),
            'id'      => 'email_admin_aktif',
            'type'    => 'checkbox',
        ) );
        $main_options->add_field( array(
            'name'    => esc_html__( 'Email Admin', 'wp-topgem' ),
            'desc'    => esc_html__( 'Email untuk menerima notif pembelian', 'wp-topgem' ),
            'id'      => 'email_admin',
            'type'    => 'text_email',
        ) );
        $main_options->add_field( array(
            'name'    => esc_html__( 'Template Email Admin', 'wp-topgem' ),
            'desc'    => esc_html__( '', 'wp-topgem' ),
            'id'      => 'email_admin_template',
            'type'    => 'wysiwyg',
            'default' => 'Pesanan Baru dengan kode Invoice : <strong>{{invoice}}</strong> <br> Rincian Pesanan : <br> <strong>{{tabel-pesanan}}</strong> <br>',
        ) );
        $main_options->add_field( array(
            'name'    => esc_html__( 'Aktifkan Email Notifikasi Pembeli', 'wp-topgem' ),
            'desc'    => esc_html__( 'Email untuk menerima butki pembelian ke Email Pembeli', 'wp-topgem' ),
            'id'      => 'email_pembeli_aktif',
            'type'    => 'checkbox',
        ) );
        $main_options->add_field( array(
            'name'    => esc_html__( 'Template Email Pembeli', 'wp-topgem' ),
            'desc'    => esc_html__( '', 'wp-topgem' ),
            'id'      => 'email_pembeli_template',
            'type'    => 'wysiwyg',
            'default' => 'Terima kasih telah membeli dengan kode Invoice : <strong>{{invoice}}</strong><br> Rincian Pesanan :<br> <strong>{{tabel-pesanan}}</strong><br> Silahkan hubungi admin jika telah membayar tagihan yang ada.'
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
            'description' => __( 'Opsi Metode Pembayaran untuk pembelian.', 'wp-topgem' ),
            'options'     => array(
                'group_title'       => __( 'Metode Bayar {#}', 'wp-topgem' ),
                'add_button'        => __( 'Tambah Metode', 'wp-topgem' ),
                'remove_button'     => __( 'Hapus Metode', 'wp-topgem' ),
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
            'name' => 'Biaya',
            'id'   => 'biaya',
            'type' => 'text',
            'default' => '0',
            'desc' => 'Biaya admin, Hanya angka tanpa titik koma dan Rp.',
        ) );      
        $pembayaran_options->add_group_field( $pemb_field, array(
            'name' => 'Deskripsi',
            'id'   => 'deskripsi',
            'type' => 'textarea',
        ) );         
        $pembayaran_options->add_group_field( $pemb_field, array(
            'name' => 'Logo',
            'id'   => 'logo',
            'type'    => 'file',
            'query_args' => array(
                'type' => array(
                  'image/gif',
                  'image/jpeg',
                  'image/png',
                  'image/webp',
                ),
            ),
        ) );    

    }

    public function get($item=null){

        $get = get_options([
            $this->game_option,
            $this->game_option.'_pembayaran',
        ]);
        $result = [];
        foreach ($get as $i => $v) {
            foreach ($v as $k => $value) {
                if ( $item && $k != $item ) { continue; }
                $result[$k] = $value;
            }
        }

        return $item?$result[$item]:$result;
    }

}

// Inisialisasi class OptionGame
$OptionGame = new OptionGame();
$OptionGame->initialize();