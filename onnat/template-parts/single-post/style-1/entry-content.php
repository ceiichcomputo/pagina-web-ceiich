<?php
/**
 * The template part for displaying content in single post.
 *
 */
?>
<div class="kinfw-entry-content">
    <?php
        the_content();

        wp_link_pages( [
            'before'      => '<div class="kinfw-page-links"> <span class="kinfw-page-links-title">'.  esc_html__( 'Pages:', 'onnat' ) .'</span>',
            'after'       => '</div>',
            'link_before' => '<span class="kinfw-page-number">',
            'link_after'  => '</span>'
        ] );

        edit_post_link( esc_html__( 'Edit', 'onnat' ), '<div class="kinfw-edit-link">', '</div>' );
    ?>
</div>