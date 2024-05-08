<?php
/**
 * @wordpress-plugin
 * Plugin Name:       WP TopGem
 * Plugin URI:        https://github.com/adityathok/wp-topgem
 * Description:       Plugin TopUp Game
 * Version:           0.0.1
 * Author:            Aditya Thok
 * Author URI:        https://github.com/adityathok/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-topgem
 * Domain Path:       /languages
 * 
 * 
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Define constants
 */
define('WPTOPGEM_VERSION', '0.0.1'); // Plugin version constant
define('WPTOPGEM_PLUGIN', trim(dirname(plugin_basename(__FILE__)), '/')); // Name of the plugin folder eg - 'wp-topgem'
define('WPTOPGEM_PLUGIN_DIR', plugin_dir_path(__FILE__)); // Plugin directory absolute path with the trailing slash. Useful for using with includes eg - /var/www/html/wp-content/plugins/wp-topgem/
define('WPTOPGEM_PLUGIN_URL', plugin_dir_url(__FILE__)); // URL to the plugin folder with the trailing slash. Useful for referencing src eg - http://localhost/wp/wp-content/plugins/wp-topgem/

// Load everything
$includes = [
	'inc/ItemGame.php',
	'inc/OptionGame.php',
	'inc/DataGame.php',
	'inc/OrderGame.php',
	'inc/shortcodes.php',
];

foreach ($includes as $include) {
	require_once(WPTOPGEM_PLUGIN_DIR . $include);
}

//Template
function wp_topgem_template($template) {
    if (is_singular('itemgame')) {
        $single_game = WPTOPGEM_PLUGIN_DIR . 'templates/single-itemgame.php';
        
        // Periksa keberadaan file template dalam tema yang aktif
        $theme_template = locate_template('single-game.php');
        
        if (!empty($theme_template)) {
            // Gunakan template dari tema yang aktif jika ada
            return $theme_template;
        } elseif (file_exists($single_game)) {
            // Gunakan template dari plugin jika tidak ada template dalam tema
            return $single_game;
        }
    }
    
    if ( is_post_type_archive('itemgame') || is_tax('kategori-itemgame') || is_tax('developer-itemgame') ) {
        $archive_game = WPTOPGEM_PLUGIN_DIR . 'templates/archive-itemgame.php'; 
        
        // Periksa keberadaan file template dalam tema yang aktif
        $theme_archive = locate_template('archive-itemgame.php');
        if (!empty($theme_archive)) {
            // Gunakan template dari tema yang aktif jika ada
            return $theme_archive;
        } elseif (file_exists($archive_game)) {
            // Gunakan template dari plugin jika tidak ada template dalam tema
            return $archive_game;
        }
    }
    
    return $template;
}
add_filter('template_include', 'wp_topgem_template');

//enqueque admin
function wp_topgem_admin_enqueue() {
    global $post_type;
    $page = isset($_GET['page']) ? $_GET['page'] : '';
    
    // Periksa apakah tipe posting yang sedang diedit adalah "itemgame"
    if ($post_type === 'itemgame' || $page === 'itemgame_option' || $page === 'itemgame_option_pembayaran') {
        wp_enqueue_style('wptopgem-cmb2', WPTOPGEM_PLUGIN_URL . 'assets/cmb2.css');
    }
}
add_action('admin_enqueue_scripts', 'wp_topgem_admin_enqueue', 25);

// enquqeue frontend
function wp_topgem_enqueue_scripts() {
    wp_enqueue_script( 'wptopgem', WPTOPGEM_PLUGIN_URL.'/assets/script.js', array('jquery'), WPTOPGEM_VERSION, true );
    wp_localize_script('wptopgem', 'wptopgem', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ajax-nonce')
    ));
}
add_action( 'wp_enqueue_scripts', 'wp_topgem_enqueue_scripts' );

//register AJAX
add_action('wp_ajax_nopriv_formordergame', 'ajax_formordergame');
add_action('wp_ajax_formordergame', 'ajax_formordergame');
function ajax_formordergame(){   

    // Check for nonce security      
    if ( ! wp_verify_nonce( $_POST['nonce'], 'ajax-nonce' ) ) {
        return false;
    }
    
    // Mengurai data yang di-serialize
    parse_str($_POST['form'], $data);

    $OrderGame = new WPTopGem\OrderGame();
    $OrderGame->save($data);
    
    wp_die();
}

function wptopgem_rupiah($angka){
    $angka = $angka?$angka:0;
    $angka = (int)$angka;
    $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
	return $hasil_rupiah;
}