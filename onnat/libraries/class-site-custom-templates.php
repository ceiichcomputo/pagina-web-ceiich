<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Custom_Templates' ) ) {

	/**
	 * The Onnat Theme basic custom template filter/hooks setup class.
	 */
    class Onnat_Theme_Custom_Templates {

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

            if( !function_exists( 'kf_onnat_extra_plugin' ) ) {
                return;
            }

            add_filter( 'theme_page_templates', [ $this, 'page_templates' ] );
            add_filter( 'theme_post_templates', [ $this, 'page_templates' ] );

            add_filter( 'template_include', [ $this, 'custom_template' ], 100 );

            do_action( 'kinfw-action/theme/custom-templates/loaded' );

        }

        public function page_templates( $post_templates ) {

            $post_templates['theme_global_template']  = esc_html__('- Global Theme Option -','onnat');

            return $post_templates;
        }

        /**
         * Filters the path of the current template before including it.
         */
        public function custom_template( $template ) {

            if( is_singular() ) {

                $post_type = get_post_type();
                $slug      = get_page_template_slug();

                /**
                 * Post Type : page
                 */
                if( $post_type == 'page' && $slug == 'theme_global_template' ) {

                    $setting = kinfw_onnat_theme_options()->kinfw_get_option( 'single_page_template' );

                    if( !empty( $setting ) ) {
                        $template = get_query_template( "page", [ $setting ] );
                    }

                }

                /**
                 * Post Type : post
                 */
                if( $post_type == 'post' && $slug == 'theme_global_template' ) {

                    $setting = kinfw_onnat_theme_options()->kinfw_get_option( 'single_post_template' );

                    if( !empty( $setting ) ) {
                        $template = get_query_template( "single", [ $setting ] );
                    }

                }

                if( $post_type == 'post' && isset( $_GET['kfw-preview'] ) ) {
                    $template = get_query_template( "single", [ 'post-templates/post-preview.php' ] );
                }

            }

            return $template;

        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_custom_templates' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_custom_templates() {

        return Onnat_Theme_Custom_Templates::get_instance();
    }
}

kinfw_onnat_theme_custom_templates();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */