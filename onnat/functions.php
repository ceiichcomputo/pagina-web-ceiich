<?php
/**
 * Theme functions and definitions.
 *
 * Sets up the theme and provides few helper and util functions.
 */
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Core' ) ) {

	/**
	 * The Onnat theme core setup class.
	 */
    class Onnat_Theme_Core {

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

            $this->define_constants();

            $this->load_before_modules();
            $this->load_dependencies();
            $this->load_after_modules();

            do_action( 'kinfw-action/theme/core/loaded' );

        }

		/**
		 * Define plugin required constants
		 */
		private function define_constants() {

			$template  = get_template();
			$theme_obj = wp_get_theme( $template );

            $this->define( 'ONNAT_CONST_THEME', $theme_obj->get( 'Name' ) );
            $this->define( 'ONNAT_CONST_SAN_THEME', sanitize_title( $theme_obj->get( 'Name' ) ) );
            $this->define( 'ONNAT_CONST_THEME_VERSION', $theme_obj->get( 'Version' ) );

            $this->define( 'ONNAT_CONST_THEME_AUTHOR', $theme_obj->get( 'Author' ) );
            $this->define( 'ONNAT_CONST_THEME_AUTHOR_URL', $theme_obj->get( 'AuthorURI' ) );
            $this->define( 'ONNAT_CONST_THEME_AUTHOR_MAIL', sanitize_email( 'wekinforce@gmail.com' ) );
            $this->define( 'ONNAT_CONST_THEME_DOC_URL', sprintf( esc_url('https://docs.kinforce.net/%s/'), ONNAT_CONST_SAN_THEME ) );

            $this->define( 'ONNAT_CONST_THEME_DEBUG_SUFFIX', ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min' ) );
            $this->define( 'ONNAT_CONST_THEME_DIR_URI', get_template_directory_uri() );

            $this->define( 'ONNAT_CONST_THEME_OPTION_PREFIX', '_kinfw_onnat_fw_options' );
            $this->define( 'ONNAT_CONST_THEME_NAV_MENU_PREFIX', '_kinfw_onnat_nav_menu_options' );
            $this->define( 'ONNAT_CONST_THEME_WIDGET_PREFIX', '_kinfw_onnat_widgets' );

            $this->define( 'ONNAT_CONST_THEME_PAGE_SETTINGS', '_kinfw_page_options' );
            $this->define( 'ONNAT_CONST_THEME_POST_SETTINGS', '_kinfw_post_options' );
            $this->define( 'ONNAT_CONST_THEME_PRODUCT_SETTINGS', '_kinfw_product_options' );


            $this->define( 'ONNAT_CONST_THEME_NEW_LINE', "\n" );

            $this->define( 'ONNAT_CONST_THEME_DUMMY_IMAGE', "data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" );

        }

		/**
		 * Define constant if not already set.
		 */
		private function define( $name, $value ) {

			if( !defined( $name ) ) {

				define( $name, $value );

            }

        }

        /**
		 * Load the required dependencies.
		 */
		private function load_dependencies() {

            $files = [

                'libraries/class-site-comment-walker.php',
                'libraries/class-site-avatar.php',

                'libraries/class-site-tgm-plugin-activation.php',
                'libraries/class-site-tgm-plugins.php',

                'libraries/class-site-options-config.php',
                'libraries/class-site-page-metaboxes-config.php',
                'libraries/class-site-post-metaboxes-config.php',
                'libraries/class-site-nav-menu-config.php',
                'libraries/class-site-widgets-config.php',

                'libraries/class-site-setup.php',
                'libraries/class-site-i18n.php',
                'libraries/class-site-nav-menus.php',
                'libraries/class-site-block-editor.php',
                'libraries/class-site-widget-areas.php',
                'libraries/class-site-custom-templates.php',
                'libraries/class-site-blog.php',

                'libraries/class-site-wp-head.php',
                'libraries/class-site-styles.php',
                'libraries/class-site-scripts.php',
                'libraries/class-site-wp-footer.php',

                'libraries/class-site-skin.php',
                'libraries/class-site-header.php',
                'libraries/class-site-page-title.php',
                'libraries/class-site-footer.php',

                'libraries/class-site-search-result.php',

                'libraries/class-site-style-vars.php',
                'libraries/class-site-styles-dynamic.php',
                'libraries/class-site-styles-options.php',
                'libraries/class-site-inline-styles.php',

                'libraries/class-site-ajax-calls.php',
            ];

            if( is_admin() ) {

                $files[] = 'libraries/admin/class-site-admin.php';

            }

            $files = apply_filters( 'kinfw-filter/theme/core/dependencies', $files );

            foreach( $files as $file ) {

                require_once get_theme_file_path( $file );
            }

        }

        /**
         * Load third party plugins compatibility
         */
        private function load_before_modules() {

            /**
             * Main Helper
             */
            require_once get_theme_file_path( 'libraries/site-helpers.php' );

            if( class_exists( 'WooCommerce' ) ) {
                require_once get_theme_file_path( 'libraries/class-site-woocommerce.php' );
            }

            require_once get_theme_file_path( 'libraries/class-site-our-cpts.php' );

        }

        /**
         * Load third party plugins compatibility
         */
        private function load_after_modules() {

            if( function_exists( 'kf_onnat_extra_plugin' ) ) {

                require_once get_theme_file_path( 'libraries/class-site-kf-extra-plugin.php' );

            }

        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_core' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_core() {

        return Onnat_Theme_Core::get_instance();
    }
}

kinfw_onnat_theme_core();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */