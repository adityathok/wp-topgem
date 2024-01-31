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
    
    return $template;
}
add_filter('template_include', 'wp_topgem_template');