<?php
/**
 * Template Name: Fluid Width Content Template
 * Template Post Type: page
 *
 */

get_header( 'fluid' );
?>
<!-- #kinfw-main-content -->
<div id="kinfw-main-content" class="kinfw-has-no-sidebar">

    <!-- #primary -->
    <div id="primary" class="kinfw-content-holder">

        <?php
            // Start the loop.
            while( have_posts() ) :

                the_post();

                // Include the page content template.
                get_template_part( 'content', 'page' );

                // If comments are open or we have at least one comment, load up the comment template.
                if ( comments_open() || get_comments_number() ) :

                    comments_template();
                endif;

            endwhile;
            // End the loop.
        ?>

    </div><!-- /#primary -->

</div><!-- /#kinfw-main-content -->
<?php
get_footer();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */