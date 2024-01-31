<?php
namespace WPTopGem;

class DataGame extends ItemGame {

    public $id;
    public $name;
    public $developer;

    public function __construct($post_id) {
        $this->id           = $post_id;
        $this->name         = get_the_title($this->id);
        $this->developer    = $this->developer();
    }
    
    public function developer() {
        $terms = get_the_terms( $this->id, $this->tax_developer );
        if ( $terms && ! is_wp_error( $terms ) ) {
           return $terms[0]->name;
        } else {
            return false;
        }
    }

}