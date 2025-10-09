<?php
/**
 * The template part for displaying next and previous post navigation in single posts.
 *
 */

$next_post = get_next_post();
$prev_post = get_previous_post();

if ( $next_post || $prev_post ) {

    $pagination_classes = '';

	if ( ! $next_post ) {

        $pagination_classes = 'kinfw-only-one-post-nav kinfw-has-prev-post-only';
	} elseif ( ! $prev_post ) {

        $pagination_classes = 'kinfw-only-one-post-nav kinfw-has-next-post-only';
    }

    printf( '<div class="kinfw-post-nav %1$s">', $pagination_classes );

        if ( $prev_post ) {

            printf( ' <!-- .kinfw-post-nav-prev -->
                <div class="kinfw-post-nav-prev">
                    <a href="%1$s">
                        <span class="kinfw-post-nav-txt"> %2$s </span>
                        <span class="kinfw-post-nav-title"> %3$s </span>
                    </a>
                </div> <!-- /.kinfw-post-nav-prev -->',
                esc_url( get_permalink( $prev_post->ID ) ),
                esc_html__( 'Prev Post', 'onnat' ),
                wp_kses_post( get_the_title( $prev_post->ID ) ),
            );

        }

        if ( $next_post ) {

            printf( ' <!-- .kinfw-post-nav-next -->
                <div class="kinfw-post-nav-next">
                    <a href="%1$s">
                        <span class="kinfw-post-nav-txt"> %2$s </span>
                        <span class="kinfw-post-nav-title"> %3$s </span>
                    </a>
                </div> <!-- /.kinfw-post-nav-next -->',
                esc_url( get_permalink( $next_post->ID ) ),
                esc_html__( 'Next Post', 'onnat' ),
                wp_kses_post( get_the_title( $next_post->ID ) ),
            );

        }

    printf( '</div>' );


}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */