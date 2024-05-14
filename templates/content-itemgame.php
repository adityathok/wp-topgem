<?php
$DataGame = new WPTopGem\DataGame(get_the_ID());
$FormOrderGame = new WPTopGem\FormOrderGame(get_the_ID());
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

    <div class="row">
        <div class="col-md-4">

            <div class="d-flex align-items-center">
                <?php if ( has_post_thumbnail( get_the_ID() ) ) { ?>
                    <div class="ratio ratio-1x1 overflow-hidden rounded-3 me-3" style="max-width: 7rem;">
                        <?php echo get_the_post_thumbnail( get_the_ID(), 'medium', array( 'class' => 'object-fit-cover' ) ); ?>
                    </div>
                <?php } ?>
                <div>
                    <div>
                        <?php echo $DataGame->developer; ?>
                    </div>
                    <?php the_title( '<h1 class="entry-title fs-4">', '</h1>' ); ?>
                </div>
            </div>

            <div class="my-4">
                <?php echo get_the_content( get_the_ID() ); ?>
            </div>
        </div>
        <div class="col-md-8">
            <?php echo $FormOrderGame->form(); ?>
        </div>
    </div>

</article>