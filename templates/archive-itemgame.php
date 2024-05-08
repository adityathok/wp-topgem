<?php
/**
 * Template Name: Archive Itemgame
 * Description: The template for displaying the archive Itemgame.
 *
 * @package wp-topgem
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

do_action('karyawp_container_before');
?>

    <main class="site-main" id="main">

        <header class="page-header mb-5">
            <?php
            the_archive_title( '<h1 class="page-title">', '</h1>' );
            the_archive_description( '<div class="taxonomy-description">', '</div>' );
            ?>
        </header>
        
        <div class="row row-archive">

            <?php
            if ( have_posts() ) {
                // Start the Loop.
                while ( have_posts() ) {
                    the_post();
                    ?>
                    <div class="col-6 col-md-4 col-xl-3">
                        <div class="card rounded-3 overflow-hidden">
                            <div class="ratio ratio-1x1 bg-dark" style="--bs-aspect-ratio: 120%;">
                                <?php echo get_the_post_thumbnail( get_the_ID(), 'medium', array( 'class' => 'object-fit-cover' ) ); ?>
                            </div>
                            <div class="card-body text-center">
                                <?php the_title( '<h2 class="fs-6 fw-bold">', '</h2>' ); ?>
                            </div>
                        </div>
                    </div>
                    <?php                    
                }
            } else {
                echo '<p>No game found</p>';
            }
            ?>

        </div>

        <?php
        // Display the pagination.
        if (function_exists('karyawp_pagination')) {
            karyawp_pagination();
        }
        ?>

    </main><!-- #main -->

<?php
do_action('karyawp_container_after');

get_footer();