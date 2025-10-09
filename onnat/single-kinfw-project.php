<?php
/**
 * The template for kinfw project custom post type with no sidebar layout.
 */
get_header();

$post_id    = get_the_ID();
$meta       = get_post_meta( $post_id, '_kinfw_cpt_options', true );
$post_style = isset( $meta['post_style'] ) ? $meta['post_style'] : '';

if( 'theme_post_style' === $post_style ) {
    $post_style = kinfw_onnat_theme_options()->kinfw_get_option( 'single_kinfw_project_style' );
    
} else if ( 'custom_post_style' === $post_style ) {
    $post_style = isset( $meta['custom_post_style'] ) ? $meta['custom_post_style'] : '';
}
?>
<!-- #kinfw-main-content -->
<div id="kinfw-main-content" class="kinfw-has-no-sidebar">

    <!-- #primary -->
    <div id="primary" class="kinfw-content-holder">
        <?php
            if( !empty( $post_style ) ) {
                get_template_part( 'kinfw-cpt-templates/elementor-template-content', '', [ 'template_id' => $post_style ]  );
            } else {
                get_template_part( 'kinfw-cpt-templates/content' );
            }
        ?>
    </div><!-- /#primary -->

</div><!-- /#kinfw-main-content -->
<?php
get_footer();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */