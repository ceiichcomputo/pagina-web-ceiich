<?php
/**
 * The template for displaying quote fromat posts in standard style.
 *
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'kinfw-blog-standard-style kinfw-post-item' ); ?>>

    <?php

        $post_id      = get_the_ID();
        $meta         = get_post_meta( $post_id, '_kinfw_quote_post', true );
        $quote        = ( isset( $meta['quote'] ) && !empty( $meta['quote'] ) ) ? $meta['quote'] : '';
        $quote_author = ( isset( $meta['author'] ) && !empty( $meta['author'] ) ) ? $meta['author'] : '';

        if( !empty( $quote ) ) {

            $inline_style = '';
            if( has_post_thumbnail() ) {
                $bg           = wp_get_attachment_url ( get_post_thumbnail_id() );
                $inline_style = 'style="background:url('. esc_url( $bg ) .') center center no-repeat"';
            }

            printf(
                '<div class="kinfw-entry-media-wrap kinfw-entry-format-quote-wrap" %1$s>
                    <div class="kinfw-blog-format-quote">
                        <blockquote>
                            <q>%2$s</q>
                            %3$s
                        </blockquote>
                    </div>
                </div>',
                $inline_style,
                esc_html( $quote ),
                !empty( $quote_author ) ? sprintf( '<cite>%1$s</cite>', esc_html( $quote_author ) ) : '',
            );

            get_template_part( 'template-parts/archive/standard/content-footer', 'alternate', [ 'show-date' => true ] );

        } else {

            get_template_part( 'template-parts/archive/standard/content-header' );

            get_template_part( 'template-parts/archive/standard/content-footer' );

        }

    ?>

</article>