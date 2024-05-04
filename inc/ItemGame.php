<?php
namespace WPTopGem;

class ItemGame {

    public $post_type       = 'itemgame';
    public $tax_kategori    = 'kategori-itemgame';
    public $tax_developer   = 'developer-itemgame';

    public function initialize() {
        add_action('init', array($this, 'register_post_type'));
        add_action('init', array($this, 'register_taxonomy'));
        add_action( 'cmb2_admin_init', array($this, 'register_cmb2') );
    }

    public function register_post_type() {
        $labels = array(
            'name'               => 'Item Game',
            'singular_name'      => 'Item Game',
            'menu_name'          => 'Item Game',
            'name_admin_bar'     => 'Item Game',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Game',
            'new_item'           => 'New Game',
            'edit_item'          => 'Edit Game',
            'view_item'          => 'View Game',
            'all_items'          => 'All Games',
            'search_items'       => 'Search Game',
            'parent_item_colon'  => 'Parent Game:',
            'not_found'          => 'No Game found.',
            'not_found_in_trash' => 'No Game found in Trash.'
        );

        $args = array(
            'labels'              => $labels,
            'public'              => true,
            'publicly_queryable'  => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_rest'        => true,
            'query_var'           => true,
            'rewrite'             => array('slug' => $this->post_type),
            'capability_type'     => 'post',
            'has_archive'         => true,
            'hierarchical'        => false,
            'menu_position'       => 30,
            'supports'            => array('title', 'editor', 'thumbnail'),
            'menu_icon'           => 'dashicons-games'
        );

        register_post_type($this->post_type, $args);
    }

    public function register_taxonomy() {
        $args = array(
            'hierarchical'          => true,
            'labels'                => array(
                'name'              => 'Kategori Game',
                'singular_name'     => 'Kategori Game',
            ),
            'show_ui'               => true,
            'show_admin_column'     => true,
            'query_var'             => true,
            'rewrite'               => array('slug' => $this->tax_kategori),
        );
        register_taxonomy($this->tax_kategori, $this->post_type, $args);
        
        $args = array(
            'hierarchical'          => true,
            'labels'                => array(
                'name'              => 'Developer Game',
                'singular_name'     => 'Developer Game',
            ),
            'show_ui'               => true,
            'show_admin_column'     => true,
            'query_var'             => true,
            'rewrite'               => array('slug' => $this->tax_developer),
        );
        register_taxonomy($this->tax_developer, $this->post_type, $args);
    }
    
    public function register_cmb2() {

        $cmb = new_cmb2_box( array(
            'id'           => $this->post_type.'_metabox',
            'title'        => 'Detail Game',
            'priority'     => 'high',
            'object_types' => array( $this->post_type ),
        ) );  
        
        $cmb->add_field( array(
            'name'    => 'Data Player',
            'desc'    => 'Data-data pembeli / player yang diperlukan untuk pembelian, format : title|placeholder',
            'default' => '',
            'id'      => 'data_player',
            'type'    => 'text',
            'repeatable'    => true,
            'text'          => array(
                'add_row_text' => 'Tambah data',
            ),
        ) ); 
        $cmb->add_field( array(
            'name'    => 'Info Data Player',
            'desc'    => '',
            'default' => '',
            'id'      => 'info_data_player',
            'type'    => 'textarea',
        ) );
        $cmb->add_field( array(
            'name'    => 'Gambar Info Data Player',
            'desc'    => 'Upload gambar untuk Info Data Pengguna',
            'default' => '',
            'id'      => 'img_info_data_player',
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

        $nominal_field = $cmb->add_field( array(
            'id'          => 'data_nominal',
            'type'        => 'group',
            'description' => __( 'Data Item Nominal pembelian.', 'cmb2' ),
            'options'     => array(
                'group_title'       => __( 'Item {#}', 'cmb2' ),
                'add_button'        => __( 'Tambah Item', 'cmb2' ),
                'remove_button'     => __( 'Hapus Item', 'cmb2' ),
                'sortable'          => true,
                'closed'            => true,
            ),
        ) );
        $cmb->add_group_field( $nominal_field, array(
            'name' => 'Title',
            'id'   => 'title',
            'type' => 'text',
        ) );
        $cmb->add_group_field( $nominal_field, array(
            'name' => 'Harga',
            'id'   => 'harga',
            'type' => 'text',
        ) );
        
        $cmb->add_field( array(
            'name'    => 'Icon Nominal',
            'desc'    => 'Upload gambar Icon Nominal',
            'default' => '',
            'id'      => 'icon_nominal',
            'type'    => 'file',
            'query_args' => array(
                'type' => array(
                  'image/gif',
                  'image/jpeg',
                  'image/png',
                ),
            ),
        ) ); 

    }

}

// Inisialisasi class ItemGame
$item_game = new ItemGame();
$item_game->initialize();