<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_WP_Footer' ) ) {

	/**
	 * The Onnat Theme basic wp_footer hook setup class.
	 */
    class Onnat_Theme_WP_Footer {

		/**
		 * A reference to an instance of this class.
		 */
		private static $instance = null;

		/**
		 * Returns the instance.
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
            }

			return self::$instance;

		}

		/**
		 * Constructor
		 */
        public function __construct() {

            add_action( 'wp_footer', [ $this, 'preloader' ], -1 );
            add_action( 'wp_footer', [ $this, 'go_to_top' ], -1 );

            do_action( 'kinfw-action/theme/wp-footer/loaded' );

        }

        /**
         * Element : Preloader
         */
        public function preloader() {

            $loader = kinfw_onnat_theme_options()->kinfw_get_option( 'loader' );
            $args   = [];

            if( $loader ) {

                $loader_style = kinfw_onnat_theme_options()->kinfw_get_option( 'loader_style' );
                $template     = '';

                switch( $loader_style ) {

                    default:
                    case 'kinfw-pre-loader-circle kinfw-pre-loader-circle-spinner':
                        $args['name'] = $loader_style;
                        $template     = 'template-parts/pre-loader';
                    break;

                }

                $template = apply_filters( 'kinfw-filter/theme/preloader/template-part', $template );

                if( !empty( $template ) ) {

                    get_template_part( $template, '', $args );

                }

            }

        }

        /**
         * Element : Go To Top
         */
        public function go_to_top() {

            $to_top = kinfw_onnat_theme_options()->kinfw_get_option( 'to_top' );

            if( $to_top ) {

                $template = apply_filters( 'kinfw-filter/theme/go-to-top/template-part', 'template-parts/go-to-top' );
                $args     = array_filter( [
                    'dir'   => kinfw_onnat_theme_options()->kinfw_get_option( 'to_top_dir' ),
                    'speed' => kinfw_onnat_theme_options()->kinfw_get_option( 'to_top_speed' ),
                    'icon'  => kinfw_onnat_theme_options()->kinfw_get_option( 'to_top_icon' )
                ] );

                if( !empty( $template ) ) {

                    get_template_part( $template, '', $args );

                }

            }
        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_wp_footer' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_wp_footer() {

        return Onnat_Theme_WP_Footer::get_instance();
    }
}

kinfw_onnat_theme_wp_footer();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */