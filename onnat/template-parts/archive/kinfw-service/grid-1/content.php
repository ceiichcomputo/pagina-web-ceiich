<?php
/**
 * The template part for displaying kinfw-service in grid style 1.
 *
 */
?>
<div class="<?php echo esc_attr( $args['classes'] );?>">
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'kinfw-service-grid-style-1 kinfw-service-item' ); ?>>
        <?php
            $post_id    = get_the_ID();
            $post_title = get_the_title( $post_id );
            $post_link  = get_permalink( $post_id );

            /**
             * Media
             */
                $media = '';

                if( has_post_thumbnail( $post_id ) ) {
                    $media = get_the_post_thumbnail( $post_id, 'full' );
                } else {
                    $media = sprintf( '
                        <img src="%1$s" alt="%2$s" class="kinfw-transparent-img"/>',
                        get_theme_file_uri( 'assets/image/public/transparent.jpg' ),
                        $post_title
                    );
                }

                printf( '<div class="kinfw-service-image-wrap">%s</div>', $media );

            /**
             * Content Wrap
             */
                printf( '
                    <div class="kinfw-service-content-wrap">
                        <h6><a href="%s">%s</a></h6>
                    </div>',
                    esc_url( $post_link ),
                    esc_html( $post_title )
                );
        ?>
    </article>
</div>