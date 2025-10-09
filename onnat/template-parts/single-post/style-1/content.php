<?php
/**
 * The template for displaying post content in style-1.
 */
?>
<!-- .kinfw-content-fw-wrap -->
<div class="kinfw-content-fw-wrap">

    <?php
        /**
         * Include the post format-specific template for the header content.
         */
        get_template_part( 'template-parts/single-post/style-1/headers/entry-header', get_post_format() );

    ?>

</div><!-- /.kinfw-content-fw-wrap -->

<!-- #kinfw-main-content -->
<div id="kinfw-main-content" class="kinfw-single-post-style-1 kinfw-has-fw-section kinfw-has-no-sidebar">

    <!-- #primary -->
    <div id="primary" class="kinfw-content-holder">

        <?php
            // Start the loop.
            while( have_posts() ) :

                the_post();

                // Include the post format-specific template for the content.
                get_template_part( 'template-parts/single-post/style-1/content', 'post', [ 'related_posts_count' => 3 ] );


                // If comments are open or we have at least one comment, load up the comment template.
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;

            endwhile;
            // End the loop.
        ?>

    </div><!-- /#primary -->

</div><!-- /#kinfw-main-content -->