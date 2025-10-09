<?php
/**
 * The template part for displaying header section in single posts for standard format.
 *
 */
$has_post_thumbnail = has_post_thumbnail() ? true : false;
?>

<!-- .kinfw-blog-single-fw -->
<div class="kinfw-blog-single-fw <?php echo ( !$has_post_thumbnail ) ? 'has-no-media-wrap' : ''; ?>">

    <header class="kinfw-entry-header">

        <?php
            if( $has_post_thumbnail ) :
        ?>

            <div class="kinfw-entry-media-wrap">
                <?php
                    the_post_thumbnail( 'full' );
                ?>
            </div>

        <?php
            endif;

            get_template_part( 'template-parts/single-post/style-1/headers/entry-header-overlay' );
        ?>

    </header>

</div><!-- /.kinfw-blog-single-fw -->