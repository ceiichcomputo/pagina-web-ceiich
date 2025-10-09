<?php
/**
 * The template for displaying post content in via elementor template with right sidebar layout.
 */

$sidebars = [];
$slug     = get_page_template_slug();
$meta     = get_post_meta( get_the_ID(), '_kinfw_post_template', true );
$meta     = apply_filters( 'kinfw-filter/theme/util/is-array', $meta );

if( $slug == 'theme_global_template' ) {

    $meta['sidebars'] = kinfw_onnat_theme_options()->kinfw_get_option( 'single_post_sidebars' );
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

$class = count( $sidebars ) ? 'kinfw-single-post-elementor-layout kinfw-has-sidebar kinfw-sidebar-right' : 'kinfw-single-post-elementor-layout kinfw-has-no-sidebar';
?>
<!-- #kinfw-main-content -->
<div id="kinfw-main-content" class="<?php echo esc_attr( $class ); ?>">

    <!-- #primary -->
    <div id="primary" class="kinfw-content-holder">
        <?php
            $template_id = isset( $args[ 'template_id' ] ) ? $args[ 'template_id' ] : 0;

            if( $template_id ) {

                $check_elementor = kinfw_is_elementor_callable();

                if( $check_elementor ) {

                    $elementor        = \Elementor\Plugin::instance();
                    $is_elementor_doc = $elementor->documents->get( $template_id )->is_built_with_elementor();

                    if( $is_elementor_doc ) {

                        echo apply_filters( 'kinfw-filter/theme/util/elementor/content', $elementor->frontend->get_builder_content_for_display( $template_id, false ) );
                    }

                }
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