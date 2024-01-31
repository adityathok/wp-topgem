<?php
/**
 * Template Name: Single Itemgame
 * Description: The template for displaying the Post Itemgame.
 *
 * @package wp-topgem
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
?>

    <main class="site-main" id="main">

        <?php
        while ( have_posts() ) {
            the_post();           

            require_once(WPTOPGEM_PLUGIN_DIR . 'templates/content-itemgame.php');

        }
        ?>

    </main><!-- #main -->

<?php
get_footer();