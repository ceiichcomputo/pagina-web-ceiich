<?php
/**
 * The template for displaying posts header section in standard style.
 *
 */

if( has_post_thumbnail() ) {

    printf( '<div class="kinfw-entry-media-wrap">' );

        printf( '<div class="kinfw-entry-media">' );
            the_post_thumbnail( 'full' );
        printf( '</div>' );

        /**
         * Date
         */
        printf( '
            <div class="kinfw-meta-date">
                <time datetime="%1$s"> %2$s </time>
            </div>',
            esc_attr( get_the_date( 'c' ) ),
            get_the_date ( get_option('date_format') )
        );

    printf( '</div>' );

}