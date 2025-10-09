<?php
/**
 * The template for displaying post content in via elementor template.
 */
?>
<!-- #kinfw-main-content -->
<div id="kinfw-main-content" class="kinfw-has-no-sidebar kinfw-single-post-elementor-layout">

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

</div><!-- /#kinfw-main-content -->