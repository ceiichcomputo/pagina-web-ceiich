<?php
/**
 * The template part for displaying header section in single posts for video format.
 *
 */

$post_id = get_the_ID();
$meta    = get_post_meta( $post_id, '_kinfw_video_post', true );
$meta    = is_array( $meta ) ? $meta : [];
$type    = ( isset( $meta['type'] ) && !empty( $meta['type'] ) ) ? $meta['type'] : '';

if( 
    !empty( $meta['oembed'] ) ||
    ( isset( $meta[ $type ] ) && is_array( $meta[ $type ] ) && !empty( array_filter( $meta[ $type ]  ) ) )
) {

    $video = '';
    $class = '';

    if( $type == 'embed' ) {

        $class = 'kinfw-blog-single-format-video-oembed';
        $video = wp_video_shortcode([
            'src'   => esc_url( $meta[$type]['url'] ),
            'class' => 'wp-video-shortcode kinfw-wp-video-shortcode',
            'width' => $GLOBALS['content_width']
        ]);

        $video = str_replace( 'width: '.$GLOBALS['content_width'].'px;', 'width: 100%;', $video );

    } elseif( $type == 'oembed' ) {

        $class = 'kinfw-blog-single-format-video-oembed';
        $video = wp_oembed_get( $meta['oembed'] );

        /**
         * To Avoid Console Warning
         * Allow attribute will take precedence over 'allowfullscreen'.
         */
        $video = str_replace( 'allowfullscreen', '', $video );

    }

    printf(
        '<div class="kinfw-entry-media-wrap kinfw-entry-format-video-wrap">
            <div class="kinfw-blog-format-video %1$s">
                %2$s
            </div>
        </div>',
        $class,
        $video
    );

} else {
    get_template_part( 'template-parts/single-post/style-2/headers/entry-header' );
}