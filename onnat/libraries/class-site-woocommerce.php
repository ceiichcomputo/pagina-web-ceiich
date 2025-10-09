<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( ! class_exists( 'Onnat_Theme_Woo' ) ) {

    /**
     * The Onnat basic woocommerce compatibility class.
     */
    class Onnat_Theme_Woo {

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

            /**
             * Single Product Options
             */
                add_filter( 'woocommerce_register_post_type_product', [ $this, 'post_type_args' ]);
                add_filter( 'theme_product_templates', [ $this, 'page_templates' ] );
                add_filter( 'template_include', [ $this, 'custom_template' ], 100 );

            add_action( 'before_woocommerce_init', [ $this, 'init' ] );
            add_action( 'kinfw-action/theme/styles/loaded', [ $this, 'init_assets' ] );
            add_filter( 'kinfw-filter/theme/widget-areas/register', [ $this, 'register_sidebars' ] );

            add_filter( 'kinfw-filter/theme/search-result-post-types',[ $this, 'add_search_result_support' ] );

            $this->load_modules();

            do_action( 'kinfw-action/theme/woo/loaded' );

        }

        public function post_type_args( $args ) {

            $args['labels']['attributes'] = esc_html__('Product Attributes', 'onnat' );

            return $args;
        }

        public function page_templates( $post_templates ) {

            $post_templates['theme_global_template']  = esc_html__('- Global Theme Option -','onnat');

            return $post_templates;
        }

        public function custom_template( $template ) {

            /**
             * Post Type : product
             */
            if( is_singular( 'product' ) ) {

                $slug = get_page_template_slug();

                if( $slug == 'product-templates/product-left-sidebar.php' ) {

                    $template = get_query_template( 'product', [ 'product-templates/product-left-sidebar.php' ] );
                } else if( $slug == 'product-templates/product-right-sidebar.php' ) {

                    $template = get_query_template( 'product', [ 'product-templates/product-right-sidebar.php' ] );
                } else if( $slug == 'product-templates/product-fluid-width.php' ) {

                    $template = get_query_template( 'product', [ 'product-templates/product-fluid-width.php' ] );
                } else if( $slug == 'theme_global_template' ) {

                    $template = kinfw_onnat_theme_options()->kinfw_get_option( 'single_product_template' );
                    $template = get_query_template( 'product', [ $template ] );
                } else {
                    $template = locate_template( [ 'product-templates/product-no-sidebar.php' ] );
                }

            }

            return $template;
        }

        public function init() {

            $this->update_settings();

            add_theme_support( 'wc-product-gallery-zoom' );
            add_theme_support( 'wc-product-gallery-lightbox' );
            add_theme_support( 'wc-product-gallery-slider' );

            add_theme_support( 'woocommerce', [
                'product_grid'          => [
                    'default_rows'    => 3,
                    'min_rows'        => 1,
                    'max_rows'        => 10,
                    'default_columns' => 4,
                    'min_columns'     => 1,
                    'max_columns'     => 6
                ],
                'thumbnail_image_width' => 100,
                'single_image_width'    => 1000,
            ] );

            add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
            add_filter( 'woocommerce_show_page_title', '__return_false' );
            add_filter( 'loop_shop_per_page', [ $this, 'products_per_page' ]);

            remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
            remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

            add_filter( 'woocommerce_get_image_size_thumbnail', [ $this, 'thumbnail_size' ] );
            add_filter( 'woocommerce_get_image_size_single', [ $this, 'single_image_size' ] );
            add_filter( 'woocommerce_get_image_size_gallery_thumbnail', [ $this, 'gallery_thumbnail_size' ] );

            /**
             * My Account
             */
            add_filter( 'kinfw-filter/theme/woo/my-account/navigation/nav-icons', [ $this, 'myaccount_nav_icons' ] );
        }

        public function update_settings() {

            update_option( 'woocommerce_registration_generate_username', 'no' );
            update_option( 'woocommerce_registration_generate_password', 'no' );
            update_option( 'woocommerce_enable_myaccount_registration', 'yes' );

        }

        public function init_assets() {
            add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );
        }

        public function enqueue_styles() {
            wp_enqueue_style( 'kinfw-onnat-woo-style',
                get_theme_file_uri(  'assets/css/woocommerce.css' ),
                [],
                ONNAT_CONST_THEME_VERSION
            );

        }

        public function register_sidebars( $sidebars ) {

            $sidebars['woo-default'] = esc_html__( 'Woo Default Sidebar', 'onnat' );

            return $sidebars;
        }

        /**
         * filter to modify the number of products per page
         */
        public function products_per_page() {
            if( is_shop() ) {
                return kinfw_onnat_theme_options()->kinfw_get_option( 'shop_products_per_page' );
            } elseif( is_product_category() || is_product_tag() ) {
                return kinfw_onnat_theme_options()->kinfw_get_option( 'woo_archive_template_products_per_page' );
            }

            return get_option( 'posts_per_page' );
        }

        public function thumbnail_size() {
            return [ 'width' => 700, 'height' => 778, 'crop' => 1 ];
        }

        public function single_image_size() {
            return [ 'width' => 900, 'height' => 1000, 'crop' => 0 ];
        }

        public function gallery_thumbnail_size() {
            return [ 'width' => 100, 'height' => 100, 'crop' => 0 ];
        }

        public function myaccount_nav_icons( $icons ) {

            $new_icons = [
                'dashboard'       => 'misc-home',
                'orders'          => 'misc-file-text',
                'downloads'       => 'misc-download',
                'edit-address'    => 'misc-map-pin',
                'edit-account'    => 'user-single',
                'customer-logout' => 'misc-power',
            ];

            $icons     = array_merge( $new_icons, $icons );

            return $icons;

        }

        public function add_search_result_support( $post_types ) {

            $post_types['product'] = esc_html__( 'WooCommerce Products', 'onnat' );

            return $post_types;
        }

        public function load_modules() {

            $files = [
                'libraries/site-woocommerce/class-woo-site-options-config.php',
                'libraries/site-woocommerce/class-woo-product-meta-boxes-config.php',

                'libraries/site-woocommerce/class-woo-mini-cart.php',
                'libraries/site-woocommerce/class-woo-cart.php',
                'libraries/site-woocommerce/class-woo-checkout.php',


                'libraries/site-woocommerce/class-woo-header.php',
                'libraries/site-woocommerce/class-woo-shop.php',
                'libraries/site-woocommerce/class-woo-single-product.php',
                'libraries/site-woocommerce/class-woo-footer.php',
            ];

            if( defined( 'YITH_WCWL' ) ) {
                $files[] = 'libraries/site-woocommerce/class-woo-yith-wishlist.php';

            }

            if( defined( 'YITH_WCQV_VERSION' ) ) {
                $files[] = 'libraries/site-woocommerce/class-woo-yith-quick-view.php';
            }

            $files = apply_filters( 'kinfw-filter/theme/woo/dependencies', $files );

            foreach( $files as $file ) {

                $file = get_theme_file_path( $file );

                if( file_exists( $file ) ) {
                    require_once $file;
                }

            }

        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_woo' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_woo() {

        return Onnat_Theme_Woo::get_instance();
    }

}

kinfw_onnat_theme_woo();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */