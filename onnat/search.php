<?php
/**
 * The template file for search results.
 *
 */

get_header();

$search_query = get_search_query();

$page_settings = kinfw_onnat_theme_blog_utils()->layout( 'search_template', 'search_sidebars' );
extract( $page_settings );
?>
<!-- #kinfw-main-content -->
<div id="kinfw-main-content" class="<?php echo esc_attr( $class ); ?>">

    <!-- #primary -->
    <div id="primary" class="kinfw-content-holder">

        <div class="kinfw-search-info">
            <?php

                if( 0 !== strlen( trim( $search_query ) ) ) {

                    global $wp_query;

                    if( !empty($wp_query->found_posts) ) {

                        if( $wp_query->found_posts > 1 ) {

                            printf( esc_html__( '%1$s search results for: %2$s', 'onnat' ),
                                $wp_query->found_posts,
                                esc_attr( $search_query )
                            );

                        } else {

                            printf( esc_html__( '%1$s search result for: %2$s', 'onnat' ),
                                $wp_query->found_posts,
                                esc_attr( $search_query )
                            );

                        }
                    }

                }

                ?>
        </div>

        <?php

            if( have_posts() && 0 !== strlen( trim( $search_query ) ) ):

                $post_loop_count = 1;
                $page            = (get_query_var('paged')) ? get_query_var('paged') : 1;

                if($page > 1) {
                    $post_loop_count = ((int) ($page - 1) * (int) get_query_var('posts_per_page'))+1;
                }

                // Start the loop.
                while( have_posts() ):

                    the_post();

                    get_template_part(
                        'template-parts/archive/search/content',
                        '',
                        [ 'count' => $post_loop_count ]
                    );

                    $post_loop_count++;
                endwhile;
                // End the loop.

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