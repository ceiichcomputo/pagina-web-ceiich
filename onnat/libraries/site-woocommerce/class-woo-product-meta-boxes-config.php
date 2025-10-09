<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Product_Meta_Boxes' ) ) {

	/**
	 * The Onnat theme product post type meta boxes setup class.
	 */
    class Onnat_Theme_Product_Meta_Boxes {

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

            if( !function_exists( 'kf_onnat_extra_plugin' ) ) {

                return;
            }

            $this->product_options_meta_box();
            $this->product_template_meta_box();
            $this->product_secondary_image_meta_box();

            do_action( 'kinfw-action/theme/meta-boxes/woo/product/loaded' );

        }

        /**
         * Product Options
         */
        public function product_options_meta_box() {

            CSF::createMetabox( ONNAT_CONST_THEME_PRODUCT_SETTINGS, [
                'title'     => esc_html__( 'Product Options', 'onnat' ),
                'post_type' => 'product',
                'context'   => 'normal',
                'priority'  => 'default'
            ] );

                $this->header_settings();
                $this->title_settings();
                $this->footer_settings();

        }

        public function header_settings() {
            $fields = [
                [
                    'id'      => 'header',
                    'type'    => 'button_set',
                    'title'   => esc_html__('Header Setting','onnat'),
                    'default' => 'theme_header',
                    'options' => [
                        'theme_header'  => esc_html__('Theme Header','onnat'),
                        'custom_header' => esc_html__('Custom Header','onnat'),
                        'no_header'     => esc_html__('Disable Header','onnat'),
                    ],
                ],
                [
                    'type'       => 'subheading',
                    'content'    => esc_html__( 'Custom Header Settings', 'onnat'),
                    'dependency' => [ 'header', '==', 'custom_header' ]
                ],
                [
                    'id'         => 'custom_header',
                    'type'       => 'image_select',
                    'attributes' => [ 'style' => 'float:left;clear:both;max-width:100%;' ],
                    'dependency' => [ 'header', '==', 'custom_header' ],
                    'default'    => 'standard_header',
                    'options'    => [
                        'standard_header'            => ONNAT_CONST_THEME_DIR_URI . '/assets/image/admin/site-options/standard-header.svg',
                        'top_bar_standard_header'    => ONNAT_CONST_THEME_DIR_URI . '/assets/image/admin/site-options/top-bar-standard-header.svg',
                        'transparent_header'         => ONNAT_CONST_THEME_DIR_URI . '/assets/image/admin/site-options/transparent-header.svg',
                        'top_bar_transparent_header' => ONNAT_CONST_THEME_DIR_URI . '/assets/image/admin/site-options/top-bar-transparent-header.svg',
                        'cascade_header'             => ONNAT_CONST_THEME_DIR_URI . '/assets/image/admin/site-options/cascade-header.svg',
                    ],
                ],
            ];

            if( kinfw_is_elementor_callable() ) {

                $fields = [
                    [
                        'id'      => 'header',
                        'type'    => 'button_set',
                        'title'   => esc_html__('Header Setting','onnat'),
                        'default' => 'theme_header',
                        'options' => [
                            'theme_header'     => esc_html__('Theme Header','onnat'),
                            'custom_header'    => esc_html__('Custom Header','onnat'),
                            'elementor_header' => esc_html__('Elementor Header','onnat'),
                            'no_header'        => esc_html__('Disable Header','onnat'),
                        ],
                    ],
                    [
                        'type'       => 'subheading',
                        'content'    => esc_html__( 'Custom Header Settings', 'onnat'),
                        'dependency' => [ 'header', '==', 'custom_header' ]
                    ],
                    [
                        'id'         => 'custom_header',
                        'type'       => 'image_select',
                        'attributes' => [ 'style' => 'float:left;clear:both;max-width:100%;' ],
                        'dependency' => [ 'header', '==', 'custom_header' ],
                        'default'    => 'standard_header',
                        'options'    => [
                            'standard_header'            => ONNAT_CONST_THEME_DIR_URI . '/assets/image/admin/site-options/standard-header.svg',
                            'top_bar_standard_header'    => ONNAT_CONST_THEME_DIR_URI . '/assets/image/admin/site-options/top-bar-standard-header.svg',
                            'transparent_header'         => ONNAT_CONST_THEME_DIR_URI . '/assets/image/admin/site-options/transparent-header.svg',
                            'top_bar_transparent_header' => ONNAT_CONST_THEME_DIR_URI . '/assets/image/admin/site-options/top-bar-transparent-header.svg',
                            'cascade_header'             => ONNAT_CONST_THEME_DIR_URI . '/assets/image/admin/site-options/cascade-header.svg',
                        ],
                    ],
                    [
                        'id'          => 'elementor_header',
                        'type'        => 'select',
                        'title'       => esc_html__('Select Custom Header', 'onnat' ),
                        'dependency'  => [ 'header', '==', 'elementor_header' ],
                        'placeholder' => esc_html__('Choose Header', 'onnat' ),
                        'attributes'  => [ 'style' => 'width:25%' ],
                        'options'     => 'posts',
                        'query_args'  => [
                            'post_type'      => 'kinfw-header',
                            'posts_per_page' => -1,
                            'post_status'    => 'publish',
                            'order'          => 'ASC',
                            'orderby'        => 'title'
                        ],
                        'default'     => '',
                    ]
                ];

            }

            CSF::createSection( ONNAT_CONST_THEME_PRODUCT_SETTINGS, [
                'title'  => esc_html__( 'Header', 'onnat' ),
                'fields' => $fields
            ] );

        }

        public function title_settings() {

            CSF::createSection( ONNAT_CONST_THEME_PRODUCT_SETTINGS, [
                'title'  => esc_html__( 'Post Title', 'onnat' ),
                'fields' => [
                    [
                        'type'    => 'subheading',
                        'content' => esc_html__( 'Post Title Setting', 'onnat'),
                    ],
                    [
                        'id'      => 'post_title',
                        'type'    => 'button_set',
                        'title'   => esc_html__('Page Title','onnat'),
                        'default' => 'theme_post_title',
                        'options' => [
                            'theme_post_title'  => esc_html__('Theme Option','onnat'),
                            'custom_post_title' => esc_html__('Customize','onnat'),
                            'no_post_title'     => esc_html__('Disable','onnat'),
                        ],
                    ],
                    [
                        'type'       => 'button_set',
                        'id'         => 'post_title_alignment',
                        'title'      => esc_html__('Alignment','onnat'),
                        'options'    => [
                            'kinfw-page-title-align-left'   => esc_html__('Left','onnat'),
                            'kinfw-page-title-align-center' => esc_html__('Center','onnat'),
                            'kinfw-page-title-align-right'  => esc_html__('Right','onnat'),
                        ],
                        'dependency' => [ 'post_title', '==', 'custom_post_title'],
                        'default'    => 'kinfw-page-title-align-center',
                    ],
                    [
                        'type'       => 'switcher',
                        'id'         => 'use_page_title_full_width',
                        'title'      => esc_html__( 'Use Full Width', 'onnat'),
                        'dependency' => [ 'post_title', '==', 'custom_post_title'],
                        'default'    => false,
                    ],
                    [
                        'type'       => 'switcher',
                        'id'         => 'use_post_title_background',
                        'title'      => esc_html__( 'Use Background', 'onnat'),
                        'dependency' => [ 'post_title', '==', 'custom_post_title'],
                        'default'    => false,
                    ],
                    [
                        'type'       => 'background',
                        'id'         => 'post_title_background',
                        'title'      => esc_html__( 'Background', 'onnat'),
                        'dependency' => [ 'use_post_title_background|post_title', '==|==', 'true|custom_post_title'],
                    ],
                    [
                        'type'       => 'color',
                        'id'         => 'post_title_overlay',
                        'title'      => esc_html__( 'Background Overlay', 'onnat'),
                        'dependency' => [ 'use_post_title_background|post_title', '==|==', 'true|custom_post_title'],
                    ],
                    [
                        'type'    => 'subheading',
                        'content' => esc_html__( 'Breadcrumbs Settings', 'onnat'),
                    ],
                    [
                        'type'    => 'button_set',
                        'id'      => 'breadcrumb',
                        'title'   => esc_html__( 'Breadcrumbs Block', 'onnat'),
                        'default' => 'theme_breadcrumb',
                        'options' => [
                            'theme_breadcrumb'  => esc_html__('Theme Option','onnat'),
                            'custom_breadcrumb' => esc_html__('Customize','onnat'),
                            'no_breadcrumb'     => esc_html__('Disable','onnat'),
                        ],

                    ],
                    [
                        'type'       => 'button_set',
                        'id'         => 'breadcrumb_alignment',
                        'title'      => esc_html__('Alignment','onnat'),
                        'options'    => [
                            'kinfw-breadcrumb-align-left'   => esc_html__('Left','onnat'),
                            'kinfw-breadcrumb-align-center' => esc_html__('Center','onnat'),
                            'kinfw-breadcrumb-align-right'  => esc_html__('Right','onnat'),
                        ],
                        'dependency' => [ 'breadcrumb', '==', 'custom_breadcrumb'],
                        'default'    => 'kinfw-breadcrumb-align-center',
                    ],
                ],
            ] );

        }

        public function footer_settings() {

            $footer_fields = [
                [
                    'id'      => 'footer',
                    'type'    => 'button_set',
                    'title'   => esc_html__('Footer Setting','onnat'),
                    'default' => 'theme_footer',
                    'options' => [
                        'theme_footer'  => esc_html__('Theme Footer','onnat'),
                        'custom_footer' => esc_html__('Custom Footer','onnat'),
                        'no_footer'     => esc_html__('Disable Footer','onnat'),
                    ]
                ],
                [
                    'type'       => 'subheading',
                    'content'    => esc_html__( 'Custom Footer Settings', 'onnat'),
                    'dependency' => [ 'footer', '==', 'custom_footer' ]
                ],
                [
                    'id'         => 'custom_footer',
                    'type'       => 'image_select',
                    'attributes' => [ 'style' => 'float:left;clear:both;max-width:100%;' ],
                    'dependency' => [ 'footer', '==', 'custom_footer' ],
                    'default'    => 'standard_footer',
                    'options'    => [
                        'standard_footer'   => ONNAT_CONST_THEME_DIR_URI . '/assets/image/admin/site-options/standard-footer.svg',
                        'footer_preset_two' => ONNAT_CONST_THEME_DIR_URI . '/assets/image/admin/site-options/footer-preset-two.svg',
                    ]
                ]
            ];


            if( kinfw_is_elementor_callable() ) {

                $footer_fields = [
                    [
                        'id'      => 'footer',
                        'type'    => 'button_set',
                        'title'   => esc_html__('Footer Setting','onnat'),
                        'default' => 'theme_footer',
                        'options' => [
                            'theme_footer'     => esc_html__('Theme Footer','onnat'),
                            'custom_footer'    => esc_html__('Custom Footer','onnat'),
                            'elementor_footer' =>  esc_html__('Elementor Footer','onnat'),
                            'no_footer'        => esc_html__('Disable Footer','onnat'),
                        ]
                    ],
                    [
                        'id'          => 'elementor_footer',
                        'type'        => 'select',
                        'title'       => esc_html__('Select Custom Footer', 'onnat' ),
                        'dependency'  => [ 'footer', '==', 'elementor_footer' ],
                        'placeholder' => esc_html__('Choose Footer', 'onnat' ),
                        'attributes'  => [ 'style' => 'width:25%' ],
                        'options'     => 'posts',
                        'query_args'  => [
                            'post_type'      => 'kinfw-footer',
                            'posts_per_page' => -1,
                            'post_status'    => 'publish',
                            'order'          => 'ASC',
                            'orderby'        => 'title'
                        ],
                        'default'     => '',
                    ],
                    [
                        'type'       => 'subheading',
                        'content'    => esc_html__( 'Custom Footer Settings', 'onnat'),
                        'dependency' => [ 'footer', '==', 'custom_footer' ]
                    ],
                    [
                        'id'         => 'custom_footer',
                        'type'       => 'image_select',
                        'attributes' => [ 'style' => 'float:left;clear:both;max-width:100%;' ],
                        'dependency' => [ 'footer', '==', 'custom_footer' ],
                        'default'    => 'standard_footer',
                        'options'    => [
                            'standard_footer'   => ONNAT_CONST_THEME_DIR_URI . '/assets/image/admin/site-options/standard-footer.svg',
                            'footer_preset_two' => ONNAT_CONST_THEME_DIR_URI . '/assets/image/admin/site-options/footer-preset-two.svg',
                        ]
                    ]
                ];
            }

            CSF::createSection( ONNAT_CONST_THEME_PRODUCT_SETTINGS, [
                'title'  => esc_html__( 'Footer', 'onnat' ),
                'fields' => $footer_fields
            ] );
        }

        public function product_template_meta_box() {

            CSF::createMetabox( '_kinfw_product_template', [
                'title'          => esc_html__( 'Product Template Layout Option', 'onnat' ),
                'post_type'      => 'product',
                'context'        => 'side',
                'page_templates' => [ 'product-templates/product-left-sidebar.php', 'product-templates/product-right-sidebar.php' ],
            ] );

                CSF::createSection( '_kinfw_product_template', [
                    'fields' => [
                        [
                            'id'          => 'sidebars',
                            'type'        => 'select',
                            'title'       => esc_html__( 'Sidebar(s)', 'onnat' ),
                            'placeholder' => esc_html__( 'Select an option', 'onnat' ),
                            'attributes'  => [ 'style' => 'width:25%' ],
                            'multiple'    => true,
                            'chosen'      => true,
                            'sortable'    => true,
                            'options'     => 'sidebars',
                            'default'     => []
                        ],
                    ]
                ] );
        }

        /**
         * Product Secondary Image
         */
        public function product_secondary_image_meta_box() {

            CSF::createMetabox( '_kinfw_product_secondary_image', [
                'title'     => esc_html__( 'Product secondary image', 'onnat' ),
                'post_type' => 'product',
                'context'   => 'side',
            ] );

                CSF::createSection( '_kinfw_product_secondary_image', [
                    'fields' => [
                        [
                            'id'           => 'image',
                            'type'         => 'media',
                            'url'          => false,
                            'library'      => 'image',
                            'button_title' => esc_html__( 'Set secondary image', 'onnat' ),
                            'remove_title' => esc_html__( 'Remove secondary image', 'onnat' ),
                        ],
                    ]
                ] );

        }


    }

}

if( !function_exists( 'kinfw_onnat_theme_product_meta_boxes' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_product_meta_boxes() {

        return Onnat_Theme_Product_Meta_Boxes::get_instance();
    }
}

kinfw_onnat_theme_product_meta_boxes();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */