<?php
/**
 * The template part for displaying author bio in single posts
 *
 */

$post_id     = get_the_ID();
$author_id   = get_post_field( 'post_author', $post_id );
$author_desc = get_the_author_meta( 'description', $author_id );

if ( (bool) $author_desc ) {

    $author_img       = get_avatar( $author_id, 160 );
    $author_name      = get_the_author_meta( 'display_name', $author_id );
    $author_posts_url = get_author_posts_url( $author_id );

    printf( '
        <div class="kinfw-author-box">
            <div class="kinfw-author-img"> %1$s </div>
            <div class="kinfw-author-info">
                <span class="kinfw-author-name"> <a href="%2$s"> %3$s </a> </span>
                <div class="kinfo-author-desc"> %4$s </div>
            </div>
        </div>',
        $author_img,
        $author_posts_url,
        $author_name,
        wp_kses_post( wpautop( $author_desc ) )
    );

}
/* Omit closing PHP tag to avoid "Headers already sent" issues. */