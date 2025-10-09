<?php
/**
 * The template for displaying standard fromat posts in standard style.
 *
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'kinfw-blog-standard-style kinfw-post-item' ); ?>>

    <?php

        get_template_part( 'template-parts/archive/standard/content-header' );

        get_template_part( 'template-parts/archive/standard/content-footer' );

    ?>

</article>