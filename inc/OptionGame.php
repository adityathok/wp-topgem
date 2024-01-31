<?php
namespace WPTopGem;

class OptionGame extends ItemGame {

    public $game_option = 'itemgame_option';

    public function initialize() {
        add_action( 'cmb2_admin_init', array($this, 'register_cmb2') );
    }

    public function register_cmb2() {
        $cmb = new_cmb2_box( array(
            'id'          		=> $this->game_option,
            'title'        		=> esc_html__( 'Pengaturan', 'cmb2' ),
            'object_types' 		=> array( 'options-page' ),
            'option_key'		=> $this->game_option,
            'parent_slug'     	=> 'edit.php?post_type='.$this->post_type,
        ) );
        $cmb->add_field( array(
            'name'    => esc_html__( 'No Whatsapp Pemesanan', 'cmb2' ),
            'desc'    => esc_html__( '', 'cmb2' ),
            'id'      => 'nowhatsapp_order',
            'type'    => 'text',
        ) );
    }

}

// Inisialisasi class OptionGame
$OptionGame = new OptionGame();
$OptionGame->initialize();