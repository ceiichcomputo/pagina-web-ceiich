<?php
/**
 * The template for displaying page content.
 */
?>
<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
    <?php
        the_content();

        wp_link_pages( [
            'before'      => '<div class="page-links"> <span class="page-links-title">'.  esc_html__( 'Pages:', 'onnat' ) .'</span>',
            'after'       => '</div>',
            'link_before' => '<span class="page-number">',
            'link_after'  => '</span>',
        ] );

        edit_post_link( esc_html__( 'Edit', 'onnat' ), '<span class="kinfw-edit-link">', '</span>' );
    ?>
</article>