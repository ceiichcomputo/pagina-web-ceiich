<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Elementor_Header' ) ) {

	/**
	 * The Onnat Theme Elementor header setup class.
	 */
    class Onnat_Theme_Elementor_Header {

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

			if( isset( $args['header_id'] ) && isset( $args['header_type'] ) && $args['header_type'] === 'elementor' ) {

				$check_elementor = kinfw_is_elementor_callable();

				if( $check_elementor ) {

                    $elementor        = \Elementor\Plugin::instance();
                    $is_elementor_doc = $elementor->documents->get( $args['header_id'] )->is_built_with_elementor();

                    $template = $is_elementor_doc
                        ? $elementor->frontend->get_builder_content_for_display( $args['header_id'] )
                        : get_the_content(null,false, $args['header_id']);

                    printf( '<!-- #kinfw-masthead -->
                        <header id="kinfw-masthead" class="kinfw-elementor-header">
                            %1$s
                        </header> <!-- /#kinfw-masthead -->',
                        $template
                    );
                }
            }
        }
    }
}

if( !function_exists( 'kinfw_onnat_theme_elementor_header' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_elementor_header( $args ) {

        return Onnat_Theme_Elementor_Header::get_instance( $args );
    }
}

kinfw_onnat_theme_elementor_header( $args );

/* Omit closing PHP tag to avoid "Headers already sent" issues. */