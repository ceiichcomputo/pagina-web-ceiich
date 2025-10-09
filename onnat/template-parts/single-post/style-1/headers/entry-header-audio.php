<?php
/**
 * The template part for displaying header section in single posts for audio format.
 *
 */

$post_id = get_the_ID();
$meta    = get_post_meta( $post_id, '_kinfw_audio_post', true );
$type    = ( isset( $meta['type'] ) && !empty( $meta['type'] ) ) ? $meta['type'] : '';

if( 
    !empty( $meta['oembed'] ) ||
    ( isset( $meta[ $type ] ) && is_array( $meta[ $type ] ) && !empty( array_filter( $meta[ $type ]  ) ) )
):

    $audio = '';
    $class = '';

    if( $type == 'embed' ) {

        $class = 'kinfw-blog-single-format-audio-embed';
        $audio = wp_audio_shortcode([
            'src'   => esc_url( $meta[$type]['url'] ),
            'style' => 'width: 100%; height:100%;',
            'class' => 'wp-audio-shortcode kinfw-wp-audio-shortcode'
        ]);

    } elseif( $type == 'oembed' ) {

        $class = 'kinfw-blog-single-format-audio-oembed';
        $audio = wp_oembed_get( $meta['oembed'] );
        $audio = preg_replace( '/(width|height)=("|\')\d*(|px)("|\')\s/', "", $audio );
        $audio = str_replace( 'iframe', 'iframe class="kinfw-audio-iframe" width="100%"', $audio );

    }
?>

<!-- .kinfw-blog-single-fw -->
<div class="kinfw-blog-single-fw">

    <header class="kinfw-entry-header">

        <?php
            printf('
                <div class="kinfw-entry-media-wrap kinfw-blog-single-format-audio %1$s">
                    <div class="kinfw-entry-format-audio-wrap">
                        %2$s
                    </div>
                </div>',
                $class,
                $audio
            );

            get_template_part( 'template-parts/single-post/style-1/headers/entry-header-overlay' );
        ?>

    </header>

</div><!-- /.kinfw-blog-single-fw -->
<?php
else:
    get_template_part( 'template-parts/single-post/style-1/headers/entry-header' );
endif;