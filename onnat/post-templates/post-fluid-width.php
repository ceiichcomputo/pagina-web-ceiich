<?php
/**
 * Template Name: Fluid Width Template
 * Template Post Type: post
 *
 * The template for post with container fluid layout.
 */
get_header( 'fluid' );

    $post_id    = get_the_ID();
    $meta       = get_post_meta( $post_id, ONNAT_CONST_THEME_POST_SETTINGS, true );
    $post_style = isset( $meta['post_style'] ) ? $meta['post_style'] : 'theme_post_style';

    if( 'theme_post_style' === $post_style ) {
        $post_style = kinfw_onnat_theme_options()->kinfw_get_option( 'single_post_style' );
    } else if ( 'custom_post_style' === $post_style ) {
        $post_style = isset( $meta['custom_post_style'] ) ? $meta['custom_post_style'] : 'style-1';
    }

    if( 'style-1' === $post_style ) {
        get_template_part( 'template-parts/single-post/style-1/content' );
    } else if ( 'style-2' === $post_style ) {
        get_template_part( 'template-parts/single-post/style-2/content' );
    } else {
        get_template_part( 'template-parts/single-post/elementor-template/content', '', [ 'template_id' => $post_style ]);
    }

get_footer();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */