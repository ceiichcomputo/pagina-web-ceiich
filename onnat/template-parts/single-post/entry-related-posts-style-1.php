<?php
/**
 * The template part for displaying related posts in single posts.
 *
 */

$query = new WP_Query( [
    'category__in'        => wp_get_post_categories( $args['post_id'] ),
    'ignore_sticky_posts' => 1,
    'no_found_rows'       => true,
    'post__not_in'        => [ $args['post_id'] ],
    'posts_per_page'      => $args['posts_per_page'],
    'post_status'         => 'publish'
] );

/**
 * Post Wrap Column Class
 */
    $post_col_class = 'kinfw-col-xl-6 kinfw-col-md-6 kinfw-col-sm-12';

    switch ( $args['posts_per_page'] ) {
        case 2:
        case '2':
            $post_col_class = 'kinfw-col-xl-6 kinfw-col-md-6 kinfw-col-sm-12';
        break;

        case 3:
        case '3':
            $post_col_class = 'kinfw-col-xl-4 kinfw-col-lg-6 kinfw-col-md-6 kinfw-col-sm-12';
        break;

        case 4:
        case '4':
            $post_col_class = 'kinfw-col-xl-3 kinfw-col-lg-6 kinfw-col-sm-12';
        break;
    }

// Start the loop.
if( $query->have_posts() ) :
    ?>

    <!-- .kinfw-related-articles -->
    <div class="kinfw-related-articles">

        <h3 class="kinfw-related-title"><?php esc_html_e( 'Related Posts', 'onnat' ); ?></h3>

        <div class="margin-10"> </div>

        <!-- .kinfw-row -->
        <div class="kinfw-row">
            <?php

                // Start the loop.
                while( $query->have_posts() ) :

                    $query->the_post();

                    // post ID
                    $id = get_the_ID();

                    // post classes
                    $class = get_post_class( 'kinfw-related-posts kinfw-blog-grid-style-1', $id );

                    $media = '';

                    if( has_post_thumbnail() ) {
                        $media = get_the_post_thumbnail( $id, 'full' );
                    } else {
                        $media = sprintf( '
                            <img src="%1$s" alt="%2$s" class="kinfw-transparent-img"/>',
                            get_theme_file_uri( 'assets/image/public/transparent.jpg' ),
                            get_the_title()
                        );
                    }

                    printf( '
                        <div class="%1$s">
                            <article id="post-%2$s" class="%3$s">
                                <div class="kinfw-entry-media-wrap">
                                    <a href="%4$s" class="kinfw-entry-media"> %5$s </a>
                                    <div class="kinfw-meta-date"> <time datetime="%10$s"> %6$s </time> </div>
                                </div>
                                <div class="kinfw-entry-content-wrap">
                                    <header class="kinfw-entry-header">
                                        <h4 class="kinfw-entry-title">
                                            <a href="%4$s"> %7$s </a>
                                        </h4>
                                    </header>
                                    <footer class="kinfw-entry-footer">
                                        <div class="kinfw-entry-readmore">
                                            <a href="%4$s">
                                                %8$s %9$s
                                            </a>
                                        </div>
                                    </footer>
                                </div>
                            </article>
                        </div>',
                        $post_col_class,
                        $id,
                        implode( ' ', $class ),
                        esc_url( get_permalink( $id ) ),
                        $media,
                        get_the_date ( get_option('date_format'), $id ),
                        esc_html( get_the_title( $id ) ),
                        esc_html__('Read More', 'onnat' ),
                        kinfw_icon( 'chevron-simple-right' ),
                        esc_attr( get_the_date( 'c' ) )
                    );

                endwhile;
                // End the loop.

            ?>
        </div><!-- /.kinfw-row -->

    </div><!-- /.kinfw-related-articles -->

    <?php
endif;
// End the loop

wp_reset_postdata();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */