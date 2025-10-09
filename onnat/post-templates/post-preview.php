<?php
/**
 * The template for displaying kinforce custom header.
 */
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

\Elementor\Plugin::$instance->frontend->add_body_class( 'elementor-template-canvas kinfw-single-blog-post-content' );
?>
<!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>
        <?php
            wp_body_open();

            /**
             * Before canvas page template content.
             */
            do_action( 'elementor/page_templates/canvas/before_content' );
            ?>
                    <!-- #kinfw-smooth-wrapper -->
                    <div id="kinfw-smooth-wrapper">
                        <!-- #kinfw-smooth-content -->
                        <div id="kinfw-smooth-content">
                            <?php
                                $template_id = isset( $_GET[ 'kfw-preview' ] ) ? $_GET[ 'kfw-preview' ] : 0;

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
                        </div>
                    </div>
            <?php
            /**
             * After canvas page template content.
             */
            do_action( 'elementor/page_templates/canvas/after_content' );
        ?>
        <?php wp_footer(); ?>
    </body>
</html>