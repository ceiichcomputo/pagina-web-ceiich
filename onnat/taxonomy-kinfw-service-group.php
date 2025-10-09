<?php
/**
 * The template file for displaying category archive.
 *
 */

get_header();

$page_settings = kinfw_onnat_theme_blog_utils()->layout( 'cpt_kinfw_service_archive_template', 'cpt_kinfw_service_archive_sidebars' );
extract( $page_settings );
?>
<!-- #kinfw-main-content -->
<div id="kinfw-main-content" class="<?php echo esc_attr( $class ); ?>">

    <!-- #primary -->
    <div id="primary" class="kinfw-content-holder">
        <?php

            if( have_posts() ):

                $post_style = kinfw_onnat_theme_options()->kinfw_get_option( 'cpt_kinfw_service_archive_post_style' );
                $post_style = !empty( $post_style ) ? $post_style : 'grid-1';

                $classes    = '';

                if( in_array( $post_style, [ 'grid-1', 'grid-2' ] ) ) {

                    $column = kinfw_onnat_theme_options()->kinfw_get_option( 'cpt_kinfw_service_archive_item_per_row' );

                    kinfw_onnat_theme_blog_utils()->blog_grid_col_class( $column );
                    $classes = implode( " ", $column );

                }

                echo '<div class="kinfw-row">';

                // Start the loop.
                while( have_posts() ):

                    the_post();

                    get_template_part(
                        'template-parts/archive/kinfw-service/'. $post_style . '/content',
                        '',
                        [ 'classes' => $classes ]
                    );

                endwhile;
                // End the loop.

                echo '</div>';

                // Pagination
                $pagination = get_the_posts_pagination([
                    'end_size'  => 4,
                    'prev_text' => kinfw_icon( 'onnat-line-arrow-long-left-tiny' ),
                    'next_text' => kinfw_icon( 'onnat-line-arrow-long-right-tiny' ),
                ]);

                if( $pagination ) :
                    printf( '<div id="kinfw-blog-pagination">%1$s</div>', $pagination );
                endif;

            // If no content, include the "No posts found" template.
            else:
                get_template_part( 'content', 'none' );
            endif;

        ?>
    </div><!-- /#primary -->

    <?php

        /**
         * Loads a sidebar template part.
         */
        get_template_part( 'sidebar', '', [ 'sidebars' => $sidebars ] );

    ?>

</div><!-- /#kinfw-main-content -->
<?php
get_footer();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */