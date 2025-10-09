<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( ! class_exists( 'Onnat_Theme_Our_CPTS' ) ) {

    /**
     * The Onnat our own custom post type compatibility class.
     */
    class Onnat_Theme_Our_CPTS {

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

            $this->load_modules();

            /**
             * Filters the path of the current template before including it.
             */
            #add_filter( 'template_include', [ $this, 'custom_template' ], 100 );

            add_filter( 'kinfw-filter/theme/search-result-post-types',[ $this, 'add_search_result_support' ] );

            do_action( 'kinfw-action/theme/our/cpts/loaded' );
        }

        public function load_modules() {

            $files = [
                'libraries/site-cpts/class-cpts-site-options-config.php',
                'libraries/site-cpts/class-cpts-meta-boxes-config.php',

                'libraries/site-cpts/class-cpts-skin.php',
                'libraries/site-cpts/class-cpts-header.php',
                'libraries/site-cpts/class-cpts-footer.php',
            ];

            $files = apply_filters( 'kinfw-filter/theme/our/cpts/dependencies', $files );

            foreach( $files as $file ) {

                $file = get_theme_file_path( $file );

                if( file_exists( $file ) ) {
                    require_once $file;
                }

            }

        }

        /**
         * Filters the path of the current template before including it.
         */
        public function custom_template( $template ) {

            $post_types = apply_filters( 'kinfw-filter/theme/metabox/template/post-type', [] );

            if( !empty( $post_types ) && is_singular( $post_types ) ) {

                $slug      = get_page_template_slug();
                $post_type = get_post_type( get_queried_object_id() );

                if( empty( $slug ) ) {
                    if( is_child_theme() ){
                        $template = get_template_directory() . '/kinfw-cpt-templates/no-sidebar.php';
                    } else {
                        $template = get_stylesheet_directory() . '/kinfw-cpt-templates/no-sidebar.php';
                    }

                } elseif( 'theme_global_template' === $slug ) {
                    $id      = sprintf('single_cpt_%s_template', str_replace("-", "_", $post_type ) );
                    $setting = kinfw_onnat_theme_options()->kinfw_get_option( $id );
                    $setting = !empty( $setting ) ? $setting : 'kinfw-cpt-templates/no-sidebar.php';

                    if( is_child_theme() ){
                        $template = get_template_directory() . '/' . $setting;
                    } else {
                        $template = get_stylesheet_directory() . '/' . $setting;
                    }
                }

            }

            return $template;
        }

        public function add_search_result_support( $post_types ) {
            $post_types['kinfw-service']     = esc_html__( 'KinForce Services CPT', 'onnat' );
            $post_types['kinfw-team-member'] = esc_html__( 'KinForce Team Member CPT', 'onnat' );

            return $post_types;
        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_our_cpts' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_our_cpts() {

        return Onnat_Theme_Our_CPTS::get_instance();
    }

}

kinfw_onnat_theme_our_cpts();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */