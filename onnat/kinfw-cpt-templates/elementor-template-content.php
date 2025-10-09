<?php
/**
 * The template for kinfw custom post types elementor template content.
 */

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