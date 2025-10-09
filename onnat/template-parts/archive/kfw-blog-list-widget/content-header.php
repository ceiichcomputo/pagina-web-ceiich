<?php
/**
 * The template for displaying posts header section in Blog Post List Elementor Widget.
 *
 */

if( has_post_thumbnail() ) {
    echo '<div class="kinfw-entry-media-wrap">';
        the_post_thumbnail( 'full' );
    echo '</div>';
}