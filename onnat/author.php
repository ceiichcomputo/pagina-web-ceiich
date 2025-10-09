<?php
/**
 * The template file for displaying author archive.
 */

get_header();

$page_settings = kinfw_onnat_theme_blog_utils()->layout( 'author_archive_template', 'author_archive_sidebars' );
extract( $page_settings );
?>
<!-- #kinfw-main-content -->
<div id="kinfw-main-content" class="<?php echo esc_attr( $class ); ?>">

    <!-- #primary -->
    <div id="primary" class="kinfw-content-holder">

        <div class="kinfw-entry-author-bio">
            <?php
                $author_id   = get_the_author_meta( 'ID' );
                $name        = get_the_author_meta( 'display_name', $author_id );
                $avatar      = get_avatar( $author_id, 160, '', $name );
                $description = get_the_author_meta( 'description' );

                $heading = sprintf( esc_html__('About %1$s', 'onnat' ), $name );

                if( empty( $description ) ) {

                    $description = esc_html__( "Stay tuned for the author's biographical information, which will be shared soon.", 'onnat' );
                }

                printf( '
                    <div class="kinfw-entry-author-thumb">%1$s</div>
                    <div class="kinfw-entry-author-details">
                        <h3>%2$s</h3>
                        <div class="kinfw-entry-author-desc">%3$s</div>
                    </div>',
                    $avatar,
                    $heading,
                    do_shortcode( $description )
                );
            ?>
        </div>

        <?php

            if( have_posts() ):

                printf( '
                    <div class="kinfw-entry-author-title">
                        <h3> %1$s <span>%2$s</span> </h3>
                    </div>',
                    esc_html__( 'Entries by', 'onnat' ),
                    $name
                );

                $post_style = kinfw_onnat_theme_options()->kinfw_get_option( 'author_archive_post_style' );
                $classes    = '';

                if( in_array( $post_style, [ 'grid-1', 'grid-2', 'grid-3', 'grid-4' ] ) ) {

                    $column = kinfw_onnat_theme_options()->kinfw_get_option( 'author_archive_posts_grid' );
                    $size   = $column['size'];

                    kinfw_onnat_theme_blog_utils()->blog_grid_col_class( $size );
                    $classes = implode( " ", $size );

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