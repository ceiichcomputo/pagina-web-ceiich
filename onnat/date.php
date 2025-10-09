<?php
/**
 * The template file for displaying date ( year, month and date ) archive.
 *
 */

get_header();

$page_settings = kinfw_onnat_theme_blog_utils()->layout( 'date_archive_template', 'date_archive_sidebars' );
extract( $page_settings );
?>
<!-- #kinfw-main-content -->
<div id="kinfw-main-content" class="<?php echo esc_attr( $class ); ?>">

    <!-- #primary -->
    <div id="primary" class="kinfw-content-holder">
        <?php

            if( have_posts() ):

                $post_style = kinfw_onnat_theme_options()->kinfw_get_option( 'date_archive_post_style' );
                $classes    = '';

                if( in_array( $post_style, [ 'grid-1', 'grid-2', 'grid-3', 'grid-4' ] ) ) {

                    $column = kinfw_onnat_theme_options()->kinfw_get_option( 'date_archive_posts_grid' );
                    $size   = $column['size'];

                    kinfw_onnat_theme_blog_utils()->blog_grid_col_class( $size );
                    $classes = implode( " ", $size );

                }

                if( 'date' === $post_style ) {

                    if( is_day() ) {
                        $post_style = 'date';
                    } else if( is_month() ) {
                        $post_style = 'month';
                    } else if( is_year() ) {
                        $post_style = 'year';
                    }
                }

                echo '<div class="kinfw-row">';

                // Start the loop.
                while( have_posts() ):

                    the_post();

                    get_template_part(
                        'template-parts/archive/'. $post_style . '/content',
                        get_post_format(),
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