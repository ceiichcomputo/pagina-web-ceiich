<?php
/**
 * Template Name: Right Sidebar Template
 * Template Post Type: kinfw-service,kinfw-team-member,kinfw-project
 *
 * The template for kinfw custom post types with left sidebar layout.
 */
get_header();

$post_id  = get_the_ID();
$sidebars = [];
$slug     = get_page_template_slug();
$meta     = get_post_meta( $post_id, '_kinfw_cpt_template', true );
$meta     = apply_filters( 'kinfw-filter/theme/util/is-array', $meta );

if( $slug == 'theme_global_template' ) {

    $post_type        = get_post_type( get_queried_object_id() );
    $id               = sprintf('single_cpt_%s_sidebars', str_replace("-", "_", $post_type ) );
    $meta['sidebars'] = kinfw_onnat_theme_options()->kinfw_get_option( $id );

}

/**
 * Tweak to show default widget area, if our core plugin is not activated.
 */
if( !function_exists( 'kf_onnat_extra_plugin' ) ) {
    $meta['sidebars'] = ['default-widget-area'];
}

if( isset( $meta['sidebars'] ) && is_array( $meta['sidebars'] ) ) {

    $sidebars = kinfw_onnat_theme_widget_areas()->active_widget_areas( $meta['sidebars'] );
}


$class = count( $sidebars ) ? 'kinfw-has-sidebar kinfw-sidebar-right' : 'kinfw-has-no-sidebar';
?>

<!-- #kinfw-main-content -->
<div id="kinfw-main-content" class="<?php echo esc_attr( $class ); ?>">

    <!-- #primary -->
    <div id="primary" class="kinfw-content-holder">
        <?php
            $post_meta  = get_post_meta( $post_id, '_kinfw_cpt_options', true );
            $post_style = isset( $post_meta['post_style'] ) ? $post_meta['post_style'] : '';

            if( 'theme_post_style' === $post_style ) {
                $post_type  = get_post_type( get_queried_object_id() );
                $id         = sprintf('single_%s_style', str_replace("-", "_", $post_type ) );
                $post_style = kinfw_onnat_theme_options()->kinfw_get_option( $id );
            } else if ( 'custom_post_style' === $post_style ) {
                $post_style = isset( $post_meta['custom_post_style'] ) ? $post_meta['custom_post_style'] : '';
            }

            if( !empty( $post_style ) ) {
                get_template_part( 'kinfw-cpt-templates/elementor-template-content', '', [ 'template_id' => $post_style ]  );
            } else {
                get_template_part( 'kinfw-cpt-templates/content' );
            }
        ?>
    </div><!-- /#primary -->

    <?php

        /**
         * Loads a sidebar template part.
         */
        get_template_part( 'sidebar', '', [ 'sidebars' => $sidebars ] );

    ?>

</div><!-- /#kinfw-main-content -->

<?php
get_footer();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */