<?php
/**
 * The template for displaying link fromat posts in standard style.
 *
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'kinfw-blog-standard-style kinfw-post-item' ); ?>>

    <?php

        $post_id   = get_the_ID();
        $meta      = get_post_meta( $post_id, '_kinfw_link_post', true );
        $post_link = ( isset( $meta['url'] ) && !empty( $meta['url'] ) ) ? $meta['url'] : '';

        if( !empty( $post_link ) ) {

            $inline_style = '';
            if( has_post_thumbnail() ) {
                $bg           = wp_get_attachment_url ( get_post_thumbnail_id() );
                $inline_style = 'style="background:url('. esc_url( $bg ) .') center center no-repeat"';
            }

            printf(
                '<div class="kinfw-entry-media-wrap kinfw-entry-format-link-wrap" %1$s>
                    <div class="kinfw-blog-format-link">
                        <a href="%2$s">%3$s</a>
                    </div>
                </div>',
                $inline_style,
                esc_url ( trim( $post_link ) ),
                esc_html( trim( $post_link ) ),
            );


            get_template_part( 'template-parts/archive/standard/content-footer', 'alternate', [ 'show-date' => true ] );


        } else {

            get_template_part( 'template-parts/archive/standard/content-header' );

            get_template_part( 'template-parts/archive/standard/content-footer' );
        }

    ?>

</article>