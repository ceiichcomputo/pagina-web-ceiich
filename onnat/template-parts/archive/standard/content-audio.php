<?php
/**
 * The template for displaying audio fromat posts in standard style.
 *
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'kinfw-blog-standard-style kinfw-post-item' ); ?>>

    <?php

        $post_id = get_the_ID();
        $meta    = get_post_meta( $post_id, '_kinfw_audio_post', true );
        $type    = ( isset( $meta['type'] ) && !empty( $meta['type'] ) ) ? $meta['type'] : '';

        if( !empty( $meta['oembed'] ) || ( !empty( $type ) && is_array( $meta[ $type ] ) && !empty( array_filter( $meta[ $type ] ) ) ) ) {

            $audio = '';
            $class = '';

            if( $type == 'embed' ) {

                $class = 'kinfw-blog-format-audio-embed';
                $audio = wp_audio_shortcode([
                    'src'   => esc_url( $meta[$type]['url'] ),
                    'style' => 'width: 100%; height:100%;',
                    'class' => 'wp-audio-shortcode kinfw-wp-audio-shortcode'
                ]);

            } elseif( $type == 'oembed' ) {

                $class = 'kinfw-blog-format-audio-oembed';
                $audio = wp_oembed_get( $meta['oembed'] );
                $audio = preg_replace( '/(width|height)=("|\')\d*(|px)("|\')\s/', "", $audio );
                $audio = str_replace( 'iframe', 'iframe class="kinfw-audio-iframe" width="100%"', $audio );

            }

            printf(
                '<div class="kinfw-entry-media-wrap kinfw-entry-format-audio-wrap">
                    <div class="kinfw-blog-format-audio %1$s">
                        %2$s
                    </div>
                </div>',
                $class,
                $audio
            );

            get_template_part( 'template-parts/archive/standard/content-footer', 'alternate', [ 'show-date' => true ] );

        } else {

            get_template_part( 'template-parts/archive/standard/content-header' );

            get_template_part( 'template-parts/archive/standard/content-footer' );

        }

    ?>

</article>