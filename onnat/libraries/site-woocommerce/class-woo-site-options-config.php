<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Woo_Options' ) ) {

	/**
	 * Configure theme woocommerce option tabs.
	 */
    class Onnat_Theme_Woo_Options {

		/**
		 * A reference to an instance of this class.
		 */
		private static $instance = null;

        /**
         * Contains default values of settings.
         */
        private $default = [];

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

            add_filter( 'kinfw-filter/theme/site-options/default', [ $this, 'defaults' ] );

            if( !function_exists( 'kf_onnat_extra_plugin' ) ) {

                return;
            }

            $this->default = $this->defaults();

            add_action( 'kinfw-action/theme/site-options/template-hierarchy/loaded', [ $this, 'load_woo_options' ] );

        }

        public function load_woo_options() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'id'    => 'theme_woo_section',
                'title' => esc_html__( 'WooCommerce', 'onnat' ),
            ] );
                $this->shop_settings();
                $this->archive_settings();
                $this->single_product_settings();

        }

        public function shop_settings() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'parent'      => 'theme_woo_section',
                'title'       => esc_html__( 'Shop', 'onnat' ),
                'description' => esc_html__( 'Default Settings for the wooCommerce Shop page of the website.','onnat' ),
                'fields'      => [
                    [
                        'id'       => 'shop_template',
                        'title'    => esc_html__( 'Shop Page Template', 'onnat' ),
                        'subtitle' => esc_html__( 'Select Shop Page Template.','onnat' ),
                        'type'     => 'select',
                        'default'  => $this->default['shop_template'],
                        'options'  => [
                            'no-sidebar'    => esc_html__( 'Full Width Template','onnat' ),
                            'left-sidebar'  => esc_html__( 'Left Sidebar Template','onnat' ),
                            'right-sidebar' => esc_html__( 'Right Sidebar Template','onnat' ),
                        ]
                    ],
                    [
                        'id'          => 'shop_sidebars',
                        'type'        => 'select',
                        'title'       => esc_html__( 'Widget Area(s)', 'onnat' ),
                        'subtitle'    => esc_html__( 'Choose default widget area(s) for Shop page.','onnat' ),
                        'placeholder' => esc_html__( 'Select an option', 'onnat' ),
                        'attributes'  => [ 'style' => 'width:25%' ],
                        'multiple'    => true,
                        'chosen'      => true,
                        'sortable'    => true,
                        'options'     => 'sidebars',
                        'default'     => $this->default['shop_sidebars'],
                        'dependency'  => [ 'shop_template', '!=', 'no-sidebar' ]
                    ],
                    [
                        'id'      => 'shop_products_per_page',
                        'type'    => 'spinner',
                        'title'   => esc_html__('Items Per Page','onnat'),
                        'min'     => 1,
                        'max'     => 99,
                        'step'    => 1,
                        'default' => $this->default['shop_products_per_page'],
                        'unit'    => '',
                    ],
                    [
                        'type'    => 'tabbed',
                        'id'      => 'shop_products_per_row',
                        'title'   => esc_html__('Products Per Row','onnat'),
                        'default' => $this->default['shop_products_per_row'],
                        'tabs'    => [

                            /**
                             * Desktop
                             */
                            [
                                'title'  => esc_html__('Desktop','onnat'),
                                'icon'   => 'fas fa-desktop',
                                'fields' => [
                                    [
                                        'type'    => 'spinner',
                                        'id'      => 'lg',
                                        'title'   => esc_html__('Items Per Row','onnat'),
                                        'min'     => 1,
                                        'max'     => 4,
                                        'step'    => 1,
                                        'unit'    => '',
                                    ],
                                ]
                            ],

                            /**
                             * Tabs
                             */
                            [
                                'title'  => esc_html__('Tablet','onnat'),
                                'icon'   => 'fas fa-tablet-alt',
                                'fields' => [
                                    [
                                        'type'    => 'spinner',
                                        'id'      => 'md_portrait',
                                        'title'   => esc_html__('Portrait Items Per Row','onnat'),
                                        'min'     => 1,
                                        'max'     => 3,
                                        'step'    => 1,
                                        'unit'    => '',
                                    ],
                                    [
                                        'type'    => 'spinner',
                                        'id'      => 'md_landscape',
                                        'title'   => esc_html__('Landscape Items Per Row','onnat'),
                                        'min'     => 1,
                                        'max'     => 3,
                                        'step'    => 1,
                                        'unit'    => '',
                                    ],
                                ]
                            ],

                            /**
                             * Mobile
                             */
                            [
                                'title'  => esc_html__('Mobile','onnat'),
                                'icon'   => 'fas fa-mobile-alt',
                                'fields' => [
                                    [
                                        'type'    => 'spinner',
                                        'id'      => 'sm_portrait',
                                        'title'   => esc_html__('Portrait Items Per Row','onnat'),
                                        'min'     => 1,
                                        'max'     => 2,
                                        'step'    => 1,
                                        'unit'    => '',
                                    ],
                                    [
                                        'type'    => 'spinner',
                                        'id'      => 'sm_landscape',
                                        'title'   => esc_html__('Landscape Items Per Row','onnat'),
                                        'min'     => 1,
                                        'max'     => 3,
                                        'step'    => 1,
                                        'unit'    => '',
                                    ],
                                ]
                            ],
                        ]
                    ],
                    [
                        'id'       => 'shop_pagination',
                        'title'    => esc_html__( 'Pagination', 'onnat' ),
                        'subtitle' => esc_html__( 'Select Shop Page pagination style.','onnat' ),
                        'type'     => 'select',
                        'default'  => $this->default['shop_pagination'],
                        'options'  => [
                            'default'  => esc_html__( 'Default','onnat' ),
                            #'loadmore' => esc_html__( 'Load More','onnat' ),
                            #'infinity' => esc_html__( 'Infinity','onnat' ),
                        ]
                    ],
                ],
            ] );

        }

        public function archive_settings() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'parent'      => 'theme_woo_section',
                'title'       => esc_html__( 'Archives', 'onnat' ),
                'description' => esc_html__( 'Default Settings for the wooCommerce archive pages ( product category, and product tag ) of the website.','onnat' ),
                'fields'      => [
                    [
                        'id'       => 'woo_archive_template',
                        'title'    => esc_html__( 'Product Archive Page Template', 'onnat' ),
                        'subtitle' => esc_html__( 'Select the Product Archive Page Template.','onnat' ),
                        'type'     => 'select',
                        'default'  => $this->default['woo_archive_template'],
                        'options'  => [
                            'no-sidebar'    => esc_html__( 'Full Width Template','onnat' ),
                            'left-sidebar'  => esc_html__( 'Left Sidebar Template','onnat' ),
                            'right-sidebar' => esc_html__( 'Right Sidebar Template','onnat' ),
                        ]
                    ],
                    [
                        'id'          => 'woo_archive_sidebars',
                        'type'        => 'select',
                        'title'       => esc_html__( 'Widget Area(s)', 'onnat' ),
                        'subtitle'    => esc_html__( 'Choose default widget area(s) for wooCommerce product archive page.','onnat' ),
                        'placeholder' => esc_html__( 'Select an option', 'onnat' ),
                        'attributes'  => [ 'style' => 'width:25%' ],
                        'multiple'    => true,
                        'chosen'      => true,
                        'sortable'    => true,
                        'options'     => 'sidebars',
                        'default'     => $this->default['woo_archive_sidebars'],
                        'dependency'  => [ 'woo_archive_template', '!=', 'no-sidebar' ]
                    ],
                    [
                        'id'      => 'woo_archive_template_products_per_page',
                        'type'    => 'spinner',
                        'title'   => esc_html__('Items Per Page','onnat'),
                        'min'     => 1,
                        'max'     => 99,
                        'step'    => 1,
                        'default' => $this->default['woo_archive_template_products_per_page'],
                        'unit'    => '',
                    ],
                    [
                        'type'    => 'tabbed',
                        'id'      => 'woo_archive_template_products_per_row',
                        'title'   => esc_html__('Products Per Row','onnat'),
                        'default' => $this->default['woo_archive_template_products_per_row'],
                        'tabs'    => [

                            /**
                             * Desktop
                             */
                            [
                                'title'  => esc_html__('Desktop','onnat'),
                                'icon'   => 'fas fa-desktop',
                                'fields' => [
                                    [
                                        'type'    => 'spinner',
                                        'id'      => 'lg',
                                        'title'   => esc_html__('Items Per Row','onnat'),
                                        'min'     => 1,
                                        'max'     => 4,
                                        'step'    => 1,
                                        'unit'    => '',
                                    ],
                                ]
                            ],

                            /**
                             * Tabs
                             */
                            [
                                'title'  => esc_html__('Tablet','onnat'),
                                'icon'   => 'fas fa-tablet-alt',
                                'fields' => [
                                    [
                                        'type'    => 'spinner',
                                        'id'      => 'md_portrait',
                                        'title'   => esc_html__('Portrait Items Per Row','onnat'),
                                        'min'     => 1,
                                        'max'     => 3,
                                        'step'    => 1,
                                        'unit'    => '',
                                    ],
                                    [
                                        'type'    => 'spinner',
                                        'id'      => 'md_landscape',
                                        'title'   => esc_html__('Landscape Items Per Row','onnat'),
                                        'min'     => 1,
                                        'max'     => 3,
                                        'step'    => 1,
                                        'unit'    => '',
                                    ],
                                ]
                            ],

                            /**
                             * Mobile
                             */
                            [
                                'title'  => esc_html__('Mobile','onnat'),
                                'icon'   => 'fas fa-mobile-alt',
                                'fields' => [
                                    [
                                        'type'    => 'spinner',
                                        'id'      => 'sm_portrait',
                                        'title'   => esc_html__('Portrait Items Per Row','onnat'),
                                        'min'     => 1,
                                        'max'     => 2,
                                        'step'    => 1,
                                        'unit'    => '',
                                    ],
                                    [
                                        'type'    => 'spinner',
                                        'id'      => 'sm_landscape',
                                        'title'   => esc_html__('Landscape Items Per Row','onnat'),
                                        'min'     => 1,
                                        'max'     => 3,
                                        'step'    => 1,
                                        'unit'    => '',
                                    ],
                                ]
                            ],
                        ]
                    ],
                    [
                        'id'       => 'woo_archive_template_pagination',
                        'title'    => esc_html__( 'Pagination', 'onnat' ),
                        'subtitle' => esc_html__( 'Select the Product Archive Page pagination style.','onnat' ),
                        'type'     => 'select',
                        'default'  => $this->default['woo_archive_template_pagination'],
                        'options'  => [
                            'default'  => esc_html__( 'Default','onnat' ),
                            #'loadmore' => esc_html__( 'Load More','onnat' ),
                            #'infinity' => esc_html__( 'Infinity','onnat' ),
                        ]
                    ],
                ],
            ] );

        }

        public function single_product_settings() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'parent'      => 'theme_woo_section',
                'title'       => esc_html__( 'Product', 'onnat' ),
                'description' => esc_html__( 'Default Settings for the wooCommerce product single of the website.','onnat' ),
                'fields'      => [
                    [
                        'id'         => 'single_product_template',
                        'title'      => esc_html__( 'Single Product Template', 'onnat' ),
                        'subtitle'   => esc_html__( 'Select default Single Product Layout style. You can change the layout of each individual product when editing it.','onnat' ),
                        'type'       => 'select',
                        'attributes' => [ 'style' => 'width:25%' ],
                        'default'    => $this->default['single_product_template'],
                        'options'    => [
                            'product-templates/product-no-sidebar.php'    => esc_html__( 'Full Width Template','onnat' ),
                            'product-templates/product-left-sidebar.php'  => esc_html__( 'Left Sidebar Template','onnat' ),
                            'product-templates/product-right-sidebar.php' => esc_html__( 'Right Sidebar Template','onnat' ),
                        ]
                    ],
                    [
                        'id'          => 'single_product_sidebars',
                        'type'        => 'select',
                        'title'       => esc_html__( 'Widget Area(s)', 'onnat' ),
                        'subtitle'    => esc_html__( 'Choose default widget area(s). You can change widget area(s) of each individual product when editing it.','onnat' ),
                        'placeholder' => esc_html__( 'Select an option', 'onnat' ),
                        'attributes'  => [ 'style' => 'width:25%' ],
                        'multiple'    => true,
                        'chosen'      => true,
                        'sortable'    => true,
                        'options'     => 'sidebars',
                        'default'     => $this->default['single_product_sidebars'],
                        'dependency'  => [ 'single_product_template', '!=', 'product-templates/product-no-sidebar.php' ]
                    ],
                    [
                        'id'       => 'single_product_social_share',
                        'type'     => 'sorter',
                        'title'    => esc_html__( 'Social Shares', 'onnat' ),
                        'subtitle' => esc_html__( 'Display social sharing buttons on your single product.', 'onnat' ),
                        'default'  => $this->default[ 'single_product_social_share' ]
                    ],
                ],
            ] );

        }

        public function defaults( $defaults = [] ) {
            /**
             * WooCommerce Shop
             */
                $defaults['shop_template']          = 'right-sidebar';
                $defaults['shop_sidebars']          = [ 'woo-default' ];
                $defaults['shop_products_per_page'] = 9;
                $defaults['shop_products_per_row']  = [
                    'lg' => 3,
                    'md_portrait'  => 2,
                    'md_landscape' => 2,
                    'sm_portrait'  => 1,
                    'sm_landscape' => 1
                ];
                $defaults['shop_pagination']       = 'default';


            /**
             * WooCommerce Shop Archive
             */
                $defaults['woo_archive_template']                   = 'right-sidebar';
                $defaults['woo_archive_sidebars']                   = [ 'woo-default' ];
                $defaults['woo_archive_template_products_per_page'] = 9;
                $defaults['woo_archive_template_products_per_row']  = [
                    'lg' => 3,
                    'md_portrait'  => 2,
                    'md_landscape' => 2,
                    'sm_portrait'  => 1,
                    'sm_landscape' => 1
                ];
                $defaults['woo_archive_template_pagination']       = 'default';


            /**
             * WooCommerce Product Single
             */
                $defaults['single_product_template']     = 'product-templates/product-no-sidebar.php';
                $defaults['single_product_sidebars']     = [ 'woo-default' ];
                $defaults['single_product_social_share'] = [
                    'enabled'  => [
                        'facebook'  => esc_html__( 'Facebook', 'onnat' ),
                        'linkedin'  => esc_html__( 'LinkedIn', 'onnat' ),
                        'twitter'   => esc_html__( 'Twitter', 'onnat' ),
                    ],
                    'disabled' => [
                        'googlep'   => esc_html__( 'Google+', 'onnat' ),
                        'pinterest' => esc_html__( 'Pinterest', 'onnat' ),
                        'reddit'    => esc_html__( 'Reddit', 'onnat' ),
                        'tumblr'    => esc_html__( 'Tumblr', 'onnat' ),
                        'viadeo'    => esc_html__( 'Viadeo', 'onnat' ),
                        'viber'     => esc_html__( 'Viber', 'onnat' ),
                        'vk'        => esc_html__( 'VK', 'onnat' ),
                    ],
                ];


            return $defaults;

        }
    }

}

if( !function_exists( 'kinfw_onnat_theme_woo_options' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_woo_options() {

        return Onnat_Theme_Woo_Options::get_instance();
    }
}

kinfw_onnat_theme_woo_options();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */