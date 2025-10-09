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

        get_template_part( 'template-parts/archive/kfw-blog-list-widget/content', 'header' );

        get_template_part( 'template-parts/archive/kfw-blog-list-widget/content', 'footer', [ 'meta' => $args['meta'] ] );

    ?>

</article>