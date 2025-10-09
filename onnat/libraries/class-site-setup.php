<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Setup' ) ) {

	/**
	 * The Onnat Theme basic setup class.
	 */
    class Onnat_Theme_Setup {

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

            add_action( 'after_setup_theme', [ $this, 'add_theme_supports' ] );
            add_action( 'after_setup_theme', [ $this, 'add_image_size' ] );
            add_action( 'after_setup_theme', [ $this, 'content_width' ], 0 );

            add_filter( 'body_class', [ $this, 'body_classes' ] );
            add_filter( 'post_class', [ $this, 'post_classes' ], 10, 3 );

            /**
             * Gutenberg plugin
             * disables the block editor from managing widgets
             */
            add_filter( 'gutenberg_use_widgets_block_editor', '__return_false', 100 );
            add_filter( 'use_widgets_block_editor', '__return_false' );

            /**
             * A custom filter used to get the current page / post template slug
             * used in site header and footer types file.
             * eg: header-templates/standard-header.php
             */
            add_filter( 'kinfw-filter/theme/template/post-type/slugs', [ $this, 'add_theme_support_template_slugs' ] );

            /**
             * A custom filter used to check the input is array or not
             */
            add_filter( 'kinfw-filter/theme/util/is-array', [ $this, 'is_array' ] );

            /**
             * Elementor Kit Style setup
             */
            add_action( 'wp', [ $this, '_elementor_color_setup' ] );

            do_action( 'kinfw-action/theme/setup/loaded' );

        }

        /**
         * Registers support for various WordPress features.
         */
        public function add_theme_supports() {

            // Add default posts and comments RSS feed links to head.
            add_theme_support( 'automatic-feed-links' );

            /**
             * Let WordPress manage the document title.
             * By adding theme support, we declare that this theme does not use a
             * hard-coded <title> tag in the document head, and expect WordPress to
             * provide it for us.
             */
            add_theme_support( 'title-tag' );

            /**
             * Enable support for Post Thumbnails on posts and pages.
             */
            add_theme_support( 'post-thumbnails' );

            /**
             * Custom Logo
             */
            add_theme_support('custom-logo', [
                'width'       => 300,
                'height'      => 200,
                'flex-width'  => true,
                'flex-height' => true,
            ] );

            /**
             * Switch default core markup for search form, comment form, and comments
             * to output valid HTML5.
             */
            add_theme_support( 'html5', [
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'widgets',
                'script',
                'style'
            ] );

            /**
             * Add support for post formats.
             */
            add_theme_support( 'post-formats', [
                'audio',
                'gallery',
                'image',
                'link',
                'quote',
                'standard',
                'video',
            ] );

            /**
             * Add theme support for selective refresh for widgets.
             */
            add_theme_support( 'customize-selective-refresh-widgets' );

            /**
             * Add theme ssupport for custom header
             */
            add_theme_support( 'custom-header' );

            /**
             * Add theme ssupport for custom background
             */
            add_theme_support( 'custom-background' );            

            add_editor_style();

        }

        public function add_image_size() {

            add_image_size( '66x66-true', 66, 66, true );
            add_image_size( '300x170-left-top', 300, 170, [ 'left', 'top' ] );
        }

        /**
         * Set the content width in pixels, based on the theme's design and stylesheet.
         */
        public function content_width() {

            $GLOBALS['content_width'] = apply_filters( 'kinfw-filter/theme/content-width', 1170 );

        }

        /**
         * Displays the classes for the body tag
         */
        public function body_classes( $classes ) {

            $classes[] = "kinfw-theme";

            $classes[] = sprintf( 'kinfw-%1$s-theme kinfw-%1$s-theme-version-%2$s', ONNAT_CONST_SAN_THEME, ONNAT_CONST_THEME_VERSION );

            if( is_child_theme() ){
                $classes[] = "kinfw-child-theme";
                $classes[] = sprintf( 'kinfw-%1$s-child-theme', ONNAT_CONST_SAN_THEME );
            }

            $kinfw = kinfw_onnat_theme_options();

            $cursor = $kinfw->kinfw_get_option( 'cursor' );
            if( $cursor ) {

                $classes[] = "kinfw-has-site-custom-cursor";
                $classes[] = $kinfw->kinfw_get_option( 'cursor_style' );
            }

            $loader = $kinfw->kinfw_get_option( 'loader' );
            if( $loader ) {

                $classes[] = "kinfw-has-site-loader";
            }

            $layout = $kinfw->kinfw_get_option( 'layout' );
            if( !empty( $layout ) ) {

                $classes[] = $layout;
            }

            $to_top = $kinfw->kinfw_get_option( 'to_top' );
            if( $to_top ) {

                $classes[] = "kinfw-has-site-scroll-to-top";
            }

            $scroll_bar = $kinfw->kinfw_get_option( 'scroll_bar' );
            if( $scroll_bar ) {

                $classes[] = "kinfw-has-site-scroll-bar";
            }

            $widget_style = $kinfw->kinfw_get_option( 'widget_style' );
            if( $widget_style ) {

                $classes[] = $widget_style;
            }

            /**
             * Simple browser detection.
             */
            global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

            if( $is_lynx ) {

                $classes[] = 'lynx';

            } elseif( $is_gecko ) {

                $classes[] = 'gecko';

            } elseif( $is_opera ) {

                $classes[] = 'opera';

            } elseif( $is_NS4 ) {

                $classes[] = 'ns4';

            } elseif( $is_safari ) {

                $classes[] = 'safari';

            } elseif( $is_chrome ) {

                $classes[] = 'chrome';

            } elseif( $is_IE ) {

                $classes[] = 'ie';
            }

            if( $is_iphone ) {
                $classes[] = 'iphone';
            }

            return $classes;

        }

        /**
         *  Displays the classes for the post container element.
         */
        public function post_classes( $classes, $class, $post_id ) {

            if( !has_post_thumbnail( $post_id ) ) {
                $classes[] = 'kinfw-has-no-post-thumbnail';
            }

            if( is_singular('post') ) {
                $classes[] = 'kinfw-post-item';
            }

            return $classes;
        }

        public function add_theme_support_template_slugs( $slugs ) {
            array_push( $slugs,
                'post-templates/post-fluid-width.php',
                'page-templates/page-fluid-width.php',
                'kinfw-cpt-templates/fluid-width.php',
                'product-templates/product-fluid-width.php',
            );
            return array_unique( $slugs );
        }

        /**
         * Check the given input is array, if not return dummy array.
         */
        public function is_array( $opt ) {
            return  is_array( $opt ) ? $opt : [];
        }

        public function _elementor_color_setup() {

            $set_ele_sys_skin = get_option( '_kinfw_set_elementor_system_color', false );

            if( !$set_ele_sys_skin ) {

                $active_plugins = get_option('active_plugins');

                if (in_array('elementor/elementor.php', $active_plugins)) {

                    $active_kit_id = \Elementor\Plugin::$instance->kits_manager->get_active_id();
                    $settings = get_post_meta($active_kit_id, '_elementor_page_settings', true);

                    $primary   = kinfw_onnat_theme_options()->kinfw_get_option( 'skin_primary_color' );
                    $secondary = kinfw_onnat_theme_options()->kinfw_get_option( 'skin_secondary_color' );
                    $text      = kinfw_onnat_theme_options()->kinfw_get_option( 'skin_light_color' );
                    $accent    = kinfw_onnat_theme_options()->kinfw_get_option( 'skin_accent_color' );

                    if( is_array( $settings ) ) {
                        $settings['system_colors'][0]['color'] = $primary;
                        $settings['system_colors'][1]['color'] = $secondary;
                        $settings['system_colors'][2]['color'] = $text;
                        $settings['system_colors'][3]['color'] = $accent;
                    } else {
                        $settings = [];
                        $settings['system_colors'][0] = [
                            "id"    => 'primary',
                            "title" => 'Primary',
                            "color" => $primary,
                        ];
                        $settings['system_colors'][1] = [
                            "id"    => 'secondary',
                            "title" => 'Secondary',
                            "color" => $secondary,
                        ];
                        $settings['system_colors'][2] = [
                            "id"    => 'text',
                            "title" => 'Text',
                            "color" => $text,
                        ];
                        $settings['system_colors'][3] = [
                            "id"    => 'accent',
                            "title" => 'Accent',
                            "color" => $accent
                        ];
                    }

                    update_post_meta( $active_kit_id, '_elementor_page_settings', $settings );
                    update_option( '_kinfw_set_elementor_system_color', true );

                }
            }
        }       

    }

}

if( !function_exists( 'kinfw_onnat_theme_setup' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_setup() {

        return Onnat_Theme_Setup::get_instance();
    }
}

kinfw_onnat_theme_setup();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */