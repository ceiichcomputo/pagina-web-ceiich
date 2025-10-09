<?php
/**
 * The template part for displaying header section in single posts for standard format.
 *
 */

$has_post_thumbnail = has_post_thumbnail() ? true : false;

?>

<div class="kinfw-entry-media-wrap <?php echo ( !$has_post_thumbnail ) ? 'has-no-media-wrap' : ''; ?>">

    <?php

        if( $has_post_thumbnail ) :

            the_post_thumbnail( 'full' );

        endif;
    ?>

</div>