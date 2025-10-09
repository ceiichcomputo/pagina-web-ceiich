<?php
/**
 * The template part for displaying posts in Blog Post List Elementor Widget
 *
 */
$post_classes = [
    'kinfw-post-item',
    'kinfw-post-list-item'
];

if( isset( $args['classes'] ) ) {
    $post_classes = array_merge( $post_classes, $args['classes'] );
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( implode(" ", $post_classes ) ); ?>>

    <?php

        $post_id = get_the_ID();
        $meta    = get_post_meta( $post_id, '_kinfw_gallery_post', true );
        $gallery = ( isset( $meta['gallery'] ) && !empty( $meta['gallery'] ) ) ? $meta['gallery'] : '';

        if( !empty( $gallery ) ) {

            $images = explode( ',', $gallery );

            if( has_post_thumbnail() && $meta['use_featured_image'] ) {

                $img_id   = get_post_thumbnail_id();
                $location = $meta['featured_image_pos'];

                if( 'kinfw-prepend' == $location ) {
                    array_unshift( $images, $img_id );
                } else {
                    array_push( $images, $img_id );
                }
            }

            $images     = array_filter( $images );
            $slider     = '';
            $pagination = '';

            foreach( $images as $img ) {

                $title = esc_attr( get_the_title( $img ) );
                $src   = wp_get_attachment_image( $img, 'full', false, [
                    'title' => esc_attr( $title ),
                    'alt'   => esc_attr( $title ),
                    'class' => 'attachment-full size-full swiper-slide'
                ] );

                if( !$src ) {
                    continue;
                }

                $slider .= sprintf( '<div class="swiper-slide"> %1$s </div> ', $src );
            }

            if( 1 < count( $images ) ) {

                $pagination = sprintf('<div data-id="kinfw-swiper-nav-%1$s" class="kinfw-swiper-nav">
                        <a href="javascript:void(0);" class="kinfw-swiper-nav-prev"> %2$s </a>
                        <a href="javascript:void(0)" class="kinfw-swiper-nav-next"> %3$s </a>
                    </div>',
                    $post_id,
                    kinfw_icon( 'onnat-line-arrow-long-left-tiny' ),
                    kinfw_icon( 'onnat-line-arrow-long-right-tiny' ),
                );

            }

            if( $slider ) {

                printf(
                    '<div class="kinfw-entry-media-wrap kinfw-blog-format-gallery">
                        <div data-id="kinfw-swiper-%1$s" class="kinfw-entry-gallery-slider kinfw-swiper swiper">
                            <div class="swiper-wrapper">%2$s</div>
                            %3$s
                        </div>
                    </div>',
                    $post_id,
                    $slider,
                    $pagination
                );

            }

        } else {

            get_template_part( 'template-parts/archive/kfw-blog-list-widget/content', 'header' );

        }

        get_template_part( 'template-parts/archive/kfw-blog-list-widget/content', 'footer', [ 'meta' => $args['meta'] ] );
    ?>

</article>