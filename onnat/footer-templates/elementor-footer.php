<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Elementor_Footer' ) ) {

	/**
	 * The Onnat Theme Elementor Footer setup class.
	 */
    class Onnat_Theme_Elementor_Footer {

		/**
		 * A reference to an instance of this class.
		 */
		private static $instance = null;

		/**
		 * Returns the instance.
		 */
		public static function get_instance( $args ) {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self( $args );
            }

			return self::$instance;

		}

		/**
		 * Constructor
		 */
        public function __construct( $args ) {
            $this->build( $args );
        }

        public function build( $args ) {

			if( isset( $args['footer_id'] ) && isset( $args['footer_type'] ) && $args['footer_type'] === 'elementor' ) {

				$check_elementor = kinfw_is_elementor_callable();

				if( $check_elementor ) {

                    $elementor        = \Elementor\Plugin::instance();
                    $is_elementor_doc = $elementor->documents->get( $args['footer_id'] )->is_built_with_elementor();

                    $template = $is_elementor_doc
                        ? $elementor->frontend->get_builder_content_for_display( $args['footer_id'] )
                        : get_the_content(null,false, $args['footer_id']);

                    printf( '<!-- #kinfw-footer -->
                        <footer id="kinfw-footer" class="kinfw-elementor-footer">
                            %1$s
                        </footer> <!-- /#kinfw-footer -->',
                        $template
                    );
                }
            }
        }
    }
}

if( !function_exists( 'kinfw_onnat_theme_elementor_footer' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_elementor_footer( $args ) {

        return Onnat_Theme_Elementor_Footer::get_instance( $args );
    }
}

kinfw_onnat_theme_elementor_footer( $args );

/* Omit closing PHP tag to avoid "Headers already sent" issues. */