<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Options_Header' ) ) {

	/**
	 * The Onnat theme header options setup class.
	 */
    class Onnat_Theme_Options_Header {

		/**
		 * A reference to an instance of this class.
		 */
		private static $instance = null;

        /**
         * Contains default values of settings.
         */
        private $default = [];

        public $header_elements;

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

            $header_elements = apply_filters( 'kinfw-filter/site-options/header/elements', [
                'search'           => esc_html__('Search', 'onnat' ),
                'user_login'       => esc_html__('Login', 'onnat' ),
                'hamburger-button' => esc_html__( 'Hamburger Button','onnat' ),
            ]);
            asort( $header_elements );

            $this->header_elements = $header_elements;

            $this->init_settings();
                $this->standard_header();
                $this->standard_header_with_top_bar();
                $this->transparent_header();
                $this->transparent_header_with_top_bar();

                $this->cascade_header();

            do_action( 'kinfw-action/theme/site-options/header/loaded' );

        }

        public function init_settings() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'id'    => 'theme_headers_section',
                'title' => esc_html__( 'Headers', 'onnat' ),
            ] );

        }

        public function standard_header() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'parent'      => 'theme_headers_section',
                'title'       => esc_html__( 'Standard Header', 'onnat' ),
                'description' => sprintf(
                    '<img src="%1$s" alt="%2$s" title="%2$s"/>',
                    ONNAT_CONST_THEME_DIR_URI. '/assets/image/admin/site-options/standard-header.svg' ,
                    esc_attr__( 'Standard Header', 'onnat')
                ),
                'fields'      => [
                    [
                        'id'          => 'standard_header_menu',
                        'type'        => 'select',
                        'title'       => esc_html__( 'Menu', 'onnat' ),
                        'subtitle'    => esc_html__( 'Choose Menu.','onnat' ),
                        'placeholder' => esc_html__( 'Select a menu', 'onnat' ),
                        'attributes'  => [ 'style' => 'width:25%;' ],
                        'chosen'      => true,
                        'options'     => 'menus',
                        'default'     => $this->default['standard_header_menu'],
                    ],
                    [
                        'type'     => 'switcher',
                        'id'       => 'standard_header_full_width',
                        'title'    => esc_html__( 'Use Full Width', 'onnat'),
                        'subtitle' => esc_html__( 'Turn on to have the full width header area for your site.', 'onnat'),
                        'default'  => $this->default['standard_header_full_width'],
                    ],
                    [
                        'type'   => 'fieldset',
                        'id'     => 'standard_header_style',
                        'title'  => esc_html__( 'Style', 'onnat'),
                        'fields' => [
                            [
                                'type' => 'tabbed',
                                'id'   => 'style',
                                'tabs' => [
                                    [
                                        'title'  => esc_html__('Default Header','onnat'),
                                        'fields' => [
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'height',
                                                'title'   => esc_html__('Height','onnat'),
                                                'min'     => 100,
                                                'step'    => 10,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'id'    => 'bg_color',
                                                'title' => esc_html__( 'Background Color', 'onnat' ),
                                                'type'  => 'color',
                                            ],
                                            [
                                                'id'     => 'main_menu_link_color',
                                                'title'  => esc_html__( 'Main Menu Link Color', 'onnat' ),
                                                'type'   => 'link_color',
                                                'hover'  => true,
                                                'active' => true,
                                            ],
                                            [
                                                'id'       => 'sub_bg_color',
                                                'title'    => esc_html__( 'Sub Menu Background Color', 'onnat' ),
                                                'subtitle' => esc_html__( 'Background color sub menu area for your site.', 'onnat'),
                                                'type'     => 'color',
                                            ],
                                            [
                                                'id'     => 'sub_menu_link_color',
                                                'title'  => esc_html__( 'Sub Menu Link Color', 'onnat' ),
                                                'type'   => 'link_color',
                                                'hover'  => true,
                                                'active' => true,
                                                'focus'  => true,
                                            ],
                                        ]
                                    ],
                                    [
                                        'title'  => esc_html__('Sticky Header','onnat'),
                                        'fields' => [
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'sticky_height',
                                                'title'   => esc_html__('Height','onnat'),
                                                'min'     => 100,
                                                'step'    => 10,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'id'    => 'sticky_bg_color',
                                                'title' => esc_html__( 'Background Color', 'onnat' ),
                                                'type'  => 'color',
                                            ],
                                            [
                                                'id'     => 'sticky_main_menu_link_color',
                                                'title'  => esc_html__( 'Main Menu Link Color', 'onnat' ),
                                                'type'   => 'link_color',
                                                'hover'  => true,
                                                'active' => true,
                                            ],
                                            [
                                                'id'       => 'sticky_sub_bg_color',
                                                'title'    => esc_html__( 'Sub Menu Background Color', 'onnat' ),
                                                'subtitle' => esc_html__( 'Background color sub menu area for your site.', 'onnat'),
                                                'type'     => 'color',
                                            ],
                                            [
                                                'id'     => 'sticky_sub_menu_link_color',
                                                'title'  => esc_html__( 'Sub Menu Link Color', 'onnat' ),
                                                'type'   => 'link_color',
                                                'hover'  => true,
                                                'active' => true,
                                                'focus'  => true,
                                            ],
                                        ]
                                    ],
                                    [
                                        'title'  => esc_html__('Mobile Header', 'onnat' ),
                                        'fields' => [
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'mobile_height',
                                                'title'   => esc_html__('Height','onnat'),
                                                'min'     => 100,
                                                'step'    => 10,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'id'    => 'mobile_bg_color',
                                                'title' => esc_html__( 'Background Color', 'onnat' ),
                                                'type'  => 'color',
                                            ],
                                            [
                                                'id'    => 'mobile_menu_bg_color',
                                                'title' => esc_html__( 'Menu Background Color', 'onnat' ),
                                                'type'  => 'color',
                                            ],
                                            [
                                                'id'    => 'mobile_border_color',
                                                'title' => esc_html__( 'Menu Border Bottom Color', 'onnat' ),
                                                'type'  => 'color',
                                            ],
                                            [
                                                'id'     => 'mobile_menu_link_color',
                                                'title'  => esc_html__( 'Link Color', 'onnat' ),
                                                'type'   => 'link_color',
                                                'hover'  => true,
                                                'active' => true
                                            ],
                                        ]
                                    ]

                                ]
                            ]
                        ]
                    ],
                    [
                        'type'               => 'typography',
                        'id'                 => 'standard_header_main_menu_typo',
                        'title'              => esc_html__( 'Main Menu Typography', 'onnat'),
                        'backup_font_family' => true,
                        'text_align'         => false,
                        'font_size'          => false,
                        'line_height'        => false,
                        'letter_spacing'     => false,
                        'color'              => false,
                        'output'             => apply_filters( 'kinfw-filter/theme/output/typo/standard-header/main-menu', [ '.kinfw-std-header .kinfw-main-nav > ul > li > a', '.kinfw-std-header #kinfw-mobile-header ul.kinfw-mobile-menu li a' ] )
                    ],
                    [
                        'type'   => 'fieldset',
                        'id'     => 'standard_header_main_menu_typo_size',
                        'title'  => '&nbsp;',
                        'fields' => [
                            [
                                'type' => 'tabbed',
                                'id'   => 'size',
                                'tabs' => [
                                    /**
                                     * Desktop
                                     */
                                    [
                                        'title'  => esc_html__('Desktop','onnat'),
                                        'icon'   => 'fas fa-desktop',
                                        'fields' => [
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'lg_font_size',
                                                'title'   => esc_html__('Font Size','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'lg_line_height',
                                                'title'   => esc_html__('Line Height','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'lg_letter_space',
                                                'title'   => esc_html__('Letter Spacing','onnat'),
                                                'min'     => .1,
                                                'step'    => .1,
                                                'unit'    => 'px',
                                                'default' => '',
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
                                                'id'      => 'md_font_size',
                                                'title'   => esc_html__('Font Size','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'md_line_height',
                                                'title'   => esc_html__('Line Height','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'md_letter_space',
                                                'title'   => esc_html__('Letter Spacing','onnat'),
                                                'min'     => .1,
                                                'step'    => .1,
                                                'unit'    => 'px',
                                                'default' => '',
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
                                                'id'      => 'sm_font_size',
                                                'title'   => esc_html__('Font Size','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'sm_line_height',
                                                'title'   => esc_html__('Line Height','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'sm_letter_space',
                                                'title'   => esc_html__('Letter Spacing','onnat'),
                                                'min'     => .1,
                                                'step'    => .1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                        ]
                                    ],

                                ]
                            ],
                        ]
                    ],
                    [
                        'type'               => 'typography',
                        'id'                 => 'standard_header_sub_menu_typo',
                        'title'              => esc_html__( 'Sub Menu Typography', 'onnat'),
                        'backup_font_family' => true,
                        'text_align'         => false,
                        'font_size'          => false,
                        'line_height'        => false,
                        'letter_spacing'     => false,
                        'color'              => false,
                        'output'             => apply_filters( 'kinfw-filter/theme/output/typo/standard-header/sub-menu', [ '.kinfw-std-header .kinfw-main-nav ul li > ul.sub-menu li a' ] )
                    ],
                    [
                        'type'   => 'fieldset',
                        'id'     => 'standard_header_sub_menu_typo_size',
                        'title'  => '&nbsp;',
                        'fields' => [
                            [
                                'type' => 'tabbed',
                                'id'   => 'size',
                                'tabs' => [
                                    /**
                                     * Desktop
                                     */
                                    [
                                        'title'  => esc_html__('Desktop','onnat'),
                                        'icon'   => 'fas fa-desktop',
                                        'fields' => [
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'lg_font_size',
                                                'title'   => esc_html__('Font Size','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'lg_line_height',
                                                'title'   => esc_html__('Line Height','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'lg_letter_space',
                                                'title'   => esc_html__('Letter Spacing','onnat'),
                                                'min'     => .1,
                                                'step'    => .1,
                                                'unit'    => 'px',
                                                'default' => '',
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
                                                'id'      => 'md_font_size',
                                                'title'   => esc_html__('Font Size','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'md_line_height',
                                                'title'   => esc_html__('Line Height','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'md_letter_space',
                                                'title'   => esc_html__('Letter Spacing','onnat'),
                                                'min'     => .1,
                                                'step'    => .1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                        ]
                                    ],
                                ]
                            ],
                        ]
                    ],
                    [
                        'id'          => 'standard_header_icons',
                        'type'        => 'select',
                        'title'       => esc_html__( 'Header Icons','onnat' ),
                        'subtitle'    => esc_html__( 'Choose list of icons to show in header.','onnat' ),
                        'chosen'      => true,
                        'multiple'    => true,
                        'sortable'    => true,
                        'placeholder' => esc_attr__( 'Select Header Icon(s)', 'onnat' ),
                        'options'     => $this->header_elements,
                        'default'     => $this->default['standard_header_icons'],
                    ],
                    [
                        'id'          => 'standard_header_icon_hamburger_button',
                        'type'        => 'select',
                        'title'       => '&nbsp;',
                        'dependency'  => [ 'standard_header_icons', 'any', 'hamburger-button' ],
                        'before'      => sprintf( '<h4>%1$s</h4>', esc_html__('Hamburger Button Page', 'onnat' ) ),
                        'placeholder' => esc_html__('Select a Page', 'onnat' ),
                        'options'     => 'pages',
                        'chosen'      => true,
                        'ajax'        => true,
                        'query_args'  => [
                            'posts_per_page' => -1
                        ],
                    ],                    
                    [
                        'id'         => 'standard_header_icons_style',
                        'type'       => 'fieldset',
                        'title'      => esc_html__( 'Header Icons Style','onnat' ),
                        'dependency' => [ 'standard_header_icons', '!=', '' ],
                        'fields'     => [
                            [
                                'type' => 'tabbed',
                                'id'   => 'style',
                                'tabs' => [
                                    [
                                        'title'  => esc_html__('Default Header','onnat'),
                                        'fields' => [
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'size',
                                                'title'   => esc_html__('Icon Size','onnat'),
                                                'min'     => 100,
                                                'step'    => 10,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'id'    => 'color',
                                                'title' => esc_html__( 'Icon Color', 'onnat' ),
                                                'type'  => 'link_color',
                                                'hover' => true,
                                            ],
                                        ]
                                    ],
                                    [
                                        'title'  => esc_html__('Sticky Header','onnat'),
                                        'fields' => [
                                            [
                                                'id'      => 'sticky_size',
                                                'type'    => 'spinner',
                                                'title'   => esc_html__('Icon Size','onnat'),
                                                'min'     => 100,
                                                'step'    => 10,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'id'    => 'sticky_color',
                                                'type'  => 'link_color',
                                                'title' => esc_html__( 'Icon Color', 'onnat' ),
                                                'hover' => true,
                                            ],
                                        ]
                                    ],
                                    [
                                        'title'  => esc_html__('Mobile Header','onnat'),
                                        'fields' => [
                                            [
                                                'id'      => 'mobile_size',
                                                'type'    => 'spinner',
                                                'title'   => esc_html__('Icon Size','onnat'),
                                                'min'     => 100,
                                                'step'    => 10,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'id'    => 'mobile_color',
                                                'type'  => 'link_color',
                                                'title' => esc_html__( 'Icon Color', 'onnat' ),
                                                'hover' => true,
                                            ],
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]



                ]
            ]);

        }

        public function standard_header_with_top_bar() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'parent'      => 'theme_headers_section',
                'title'       => esc_html__( 'Standard Header + Top Bar', 'onnat' ),
                'description' => sprintf(
                    '<img src="%1$s" alt="%2$s" title="%2$s"/>',
                    ONNAT_CONST_THEME_DIR_URI. '/assets/image/admin/site-options/top-bar-standard-header.svg' ,
                    esc_attr__( 'Standard Header With Top Bar', 'onnat')
                ),
                'fields'      => [

                    [
                        'id'          => 'top_bar_standard_header_menu',
                        'type'        => 'select',
                        'title'       => esc_html__( 'Menu', 'onnat' ),
                        'subtitle'    => esc_html__( 'Choose Menu.','onnat' ),
                        'placeholder' => esc_attr__( 'Select a menu', 'onnat' ),
                        'attributes'  => [ 'style' => 'width:25%;' ],
                        'chosen'      => true,
                        'options'     => 'menus',
                        'default'     => $this->default['top_bar_standard_header_menu'],
                    ],
                    [
                        'type'     => 'switcher',
                        'id'       => 'top_bar_standard_header_full_width',
                        'title'    => esc_html__( 'Use Full Width', 'onnat'),
                        'subtitle' => esc_html__( 'Turn on to have the full width header area for your site.', 'onnat'),
                        'default'  => $this->default['top_bar_standard_header_full_width'],
                    ],
                    [
                        'type'   => 'fieldset',
                        'id'     => 'top_bar_standard_header_style',
                        'title'  => esc_html__( 'Style', 'onnat'),
                        'fields' => [
                            [
                                'type' => 'tabbed',
                                'id'   => 'style',
                                'tabs' => [
                                    [
                                        'title'  => esc_html__('Default Header','onnat'),
                                        'fields' => [
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'height',
                                                'title'   => esc_html__('Height','onnat'),
                                                'min'     => 100,
                                                'step'    => 10,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'id'    => 'bg_color',
                                                'title' => esc_html__( 'Background Color', 'onnat' ),
                                                'type'  => 'color',
                                            ],
                                            [
                                                'id'     => 'main_menu_link_color',
                                                'title'  => esc_html__( 'Main Menu Link Color', 'onnat' ),
                                                'type'   => 'link_color',
                                                'hover'  => true,
                                                'active' => true,
                                            ],
                                            [
                                                'id'       => 'sub_bg_color',
                                                'title'    => esc_html__( 'Sub Menu Background Color', 'onnat' ),
                                                'subtitle' => esc_html__( 'Background color sub menu area for your site.', 'onnat'),
                                                'type'     => 'color',
                                            ],
                                            [
                                                'id'     => 'sub_menu_link_color',
                                                'title'  => esc_html__( 'Sub Menu Link Color', 'onnat' ),
                                                'type'   => 'link_color',
                                                'hover'  => true,
                                                'active' => true,
                                                'focus'  => true,
                                            ],
                                        ]
                                    ],
                                    [
                                        'title'  => esc_html__('Sticky Header','onnat'),
                                        'fields' => [
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'sticky_height',
                                                'title'   => esc_html__('Height','onnat'),
                                                'min'     => 100,
                                                'step'    => 10,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'id'    => 'sticky_bg_color',
                                                'title' => esc_html__( 'Background Color', 'onnat' ),
                                                'type'  => 'color',
                                            ],
                                            [
                                                'id'     => 'sticky_main_menu_link_color',
                                                'title'  => esc_html__( 'Main Menu Link Color', 'onnat' ),
                                                'type'   => 'link_color',
                                                'hover'  => true,
                                                'active' => true,
                                            ],
                                            [
                                                'id'       => 'sticky_sub_bg_color',
                                                'title'    => esc_html__( 'Sub Menu Background Color', 'onnat' ),
                                                'subtitle' => esc_html__( 'Background color sub menu area for your site.', 'onnat'),
                                                'type'     => 'color',
                                            ],
                                            [
                                                'id'     => 'sticky_sub_menu_link_color',
                                                'title'  => esc_html__( 'Sub Menu Link Color', 'onnat' ),
                                                'type'   => 'link_color',
                                                'hover'  => true,
                                                'active' => true,
                                                'focus'  => true,
                                            ],
                                        ]
                                    ],
                                    [
                                        'title'  => esc_html__('Mobile Header', 'onnat' ),
                                        'fields' => [
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'mobile_height',
                                                'title'   => esc_html__('Height','onnat'),
                                                'min'     => 100,
                                                'step'    => 10,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'id'    => 'mobile_bg_color',
                                                'title' => esc_html__( 'Background Color', 'onnat' ),
                                                'type'  => 'color',
                                            ],
                                            [
                                                'id'    => 'mobile_menu_bg_color',
                                                'title' => esc_html__( 'Menu Background Color', 'onnat' ),
                                                'type'  => 'color',
                                            ],
                                            [
                                                'id'    => 'mobile_border_color',
                                                'title' => esc_html__( 'Menu Border Bottom Color', 'onnat' ),
                                                'type'  => 'color',
                                            ],
                                            [
                                                'id'     => 'mobile_menu_link_color',
                                                'title'  => esc_html__( 'Link Color', 'onnat' ),
                                                'type'   => 'link_color',
                                                'hover'  => true,
                                                'active' => true
                                            ],
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    [
                        'type'     => 'switcher',
                        'id'       => 'top_bar_standard_header',
                        'title'    => esc_html__( 'Use Top Bar', 'onnat'),
                        'subtitle' => esc_html__( 'Turn on to have the top bar in header area for your site.', 'onnat'),
                        'default'  => $this->default['top_bar_standard_header'],
                    ],
                    [
                        'type'       => 'fieldset',
                        'id'         => 'top_bar_standard_header_top',
                        'title'      => esc_html__( 'Top Bar', 'onnat'),
                        'dependency' => [ 'top_bar_standard_header', '==', 'true'],
                        'default'    => $this->default['top_bar_standard_header_top'],
                        'fields'     => [
                            [
                                'type'    => 'tabbed',
                                'id'      => 'bar',
                                'default' => $this->default['top_bar_standard_header_top']['bar'],
                                'tabs'    => [
                                    [
                                        'title'  => esc_html__('Data','onnat'),
                                        'fields' => [
                                            [
                                                'id'          => 'phone_no',
                                                'type'        => 'text',
                                                'title'       => esc_html__( 'Phone Number', 'onnat' ),
                                                'subtitle'    => esc_html__( 'Enter Phone number.','onnat' ),
                                                'placeholder' => '(+12) 3 45 6789',
                                            ],
                                            [
                                                'id'          => 'email_id',
                                                'type'        => 'text',
                                                'title'       => esc_html__( 'Email ID', 'onnat' ),
                                                'subtitle'    => esc_html__( 'Enter Email ID.','onnat' ),
                                                'placeholder' => get_option('admin_email'),
                                            ],
                                            [
                                                'id'          => 'social_menu',
                                                'type'        => 'select',
                                                'title'       => esc_html__( 'Social Navigation', 'onnat' ),
                                                'subtitle'    => esc_html__( 'Choose Social Navigation Menu.','onnat' ),
                                                'placeholder' => esc_attr__( 'Select a menu', 'onnat' ),
                                                'attributes'  => [ 'style' => 'width:46%;' ],
                                                'chosen'      => true,
                                                'options'     => 'menus',
                                            ],
                                        ]
                                    ],
                                    [
                                        'title'  => esc_html__('Style','onnat'),
                                        'fields' => [
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'height',
                                                'title'   => esc_html__('Default Header Height','onnat'),
                                                'min'     => 100,
                                                'step'    => 10,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'mobile_height',
                                                'title'   => esc_html__('Mobile Header Height','onnat'),
                                                'min'     => 100,
                                                'step'    => 10,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'id'    => 'bg_color',
                                                'title' => esc_html__( 'Background Color', 'onnat' ),
                                                'type'  => 'color',
                                            ],
                                            [
                                                'id'    => 'separator_color',
                                                'title' => esc_html__( 'Separator Color', 'onnat' ),
                                                'type'  => 'color',
                                            ],
                                            [
                                                'id'    => 'icon_color',
                                                'title' => esc_html__( 'Icon Color', 'onnat' ),
                                                'type'  => 'color',
                                            ],
                                            [
                                                'id'    => 'link_color',
                                                'title' => esc_html__( 'Link Color', 'onnat' ),
                                                'type'  => 'link_color',
                                                'hover' => true,
                                            ],
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    [
                        'type'               => 'typography',
                        'id'                 => 'top_bar_standard_header_main_menu_typo',
                        'title'              => esc_html__( 'Main Menu Typography', 'onnat'),
                        'backup_font_family' => true,
                        'text_align'         => false,
                        'font_size'          => false,
                        'line_height'        => false,
                        'letter_spacing'     => false,
                        'color'              => false,
                        'output'             => apply_filters( 'kinfw-filter/theme/output/typo/top-bar-standard-header/main-menu', [ '.kinfw-std-header.kinfw-std-header-with-top-bar .kinfw-main-nav > ul > li > a,.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-mobile-header ul.kinfw-mobile-menu li a' ] )
                    ],
                    [
                        'type'   => 'fieldset',
                        'id'     => 'top_bar_standard_header_main_menu_typo_size',
                        'title'  => '&nbsp;',
                        'fields' => [
                            [
                                'type' => 'tabbed',
                                'id'   => 'size',
                                'tabs' => [
                                    /**
                                     * Desktop
                                     */
                                    [
                                        'title'  => esc_html__('Desktop','onnat'),
                                        'icon'   => 'fas fa-desktop',
                                        'fields' => [
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'lg_font_size',
                                                'title'   => esc_html__('Font Size','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'lg_line_height',
                                                'title'   => esc_html__('Line Height','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'lg_letter_space',
                                                'title'   => esc_html__('Letter Spacing','onnat'),
                                                'min'     => .1,
                                                'step'    => .1,
                                                'unit'    => 'px',
                                                'default' => '',
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
                                                'id'      => 'md_font_size',
                                                'title'   => esc_html__('Font Size','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'md_line_height',
                                                'title'   => esc_html__('Line Height','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'md_letter_space',
                                                'title'   => esc_html__('Letter Spacing','onnat'),
                                                'min'     => .1,
                                                'step'    => .1,
                                                'unit'    => 'px',
                                                'default' => '',
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
                                                'id'      => 'sm_font_size',
                                                'title'   => esc_html__('Font Size','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'sm_line_height',
                                                'title'   => esc_html__('Line Height','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'sm_letter_space',
                                                'title'   => esc_html__('Letter Spacing','onnat'),
                                                'min'     => .1,
                                                'step'    => .1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                        ]
                                    ],

                                ]
                            ],
                        ]
                    ],
                    [
                        'type'               => 'typography',
                        'id'                 => 'top_bar_standard_header_sub_menu_typo',
                        'title'              => esc_html__( 'Sub Menu Typography', 'onnat'),
                        'backup_font_family' => true,
                        'text_align'         => false,
                        'font_size'          => false,
                        'line_height'        => false,
                        'letter_spacing'     => false,
                        'color'              => false,
                        'output'             => apply_filters( 'kinfw-filter/theme/output/typo/top-bar-standard-header/sub-menu', [ '.kinfw-std-header.kinfw-std-header-with-top-bar .kinfw-main-nav ul li > ul.sub-menu li a' ] ),
                    ],
                    [
                        'type'   => 'fieldset',
                        'id'     => 'top_bar_standard_header_sub_menu_typo_size',
                        'title'  => '&nbsp;',
                        'fields' => [
                            [
                                'type' => 'tabbed',
                                'id'   => 'size',
                                'tabs' => [
                                    /**
                                     * Desktop
                                     */
                                    [
                                        'title'  => esc_html__('Desktop','onnat'),
                                        'icon'   => 'fas fa-desktop',
                                        'fields' => [
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'lg_font_size',
                                                'title'   => esc_html__('Font Size','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'lg_line_height',
                                                'title'   => esc_html__('Line Height','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'lg_letter_space',
                                                'title'   => esc_html__('Letter Spacing','onnat'),
                                                'min'     => .1,
                                                'step'    => .1,
                                                'unit'    => 'px',
                                                'default' => '',
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
                                                'id'      => 'md_font_size',
                                                'title'   => esc_html__('Font Size','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'md_line_height',
                                                'title'   => esc_html__('Line Height','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'md_letter_space',
                                                'title'   => esc_html__('Letter Spacing','onnat'),
                                                'min'     => .1,
                                                'step'    => .1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                        ]
                                    ],
                                ]
                            ],
                        ]
                    ],
                    [
                        'id'          => 'top_bar_standard_header_icons',
                        'type'        => 'select',
                        'title'       => esc_html__( 'Header Icons','onnat' ),
                        'subtitle'    => esc_html__( 'Choose list of icons to show in header.','onnat' ),
                        'chosen'      => true,
                        'multiple'    => true,
                        'sortable'    => true,
                        'placeholder' => esc_attr__( 'Select Header Icon(s)', 'onnat' ),
                        'options'     => $this->header_elements,
                        'default'     => $this->default['top_bar_standard_header_icons'],
                    ],
                    [
                        'id'          => 'top_bar_standard_header_icon_hamburger_button',
                        'type'        => 'select',
                        'title'       => '&nbsp;',
                        'dependency'  => [ 'top_bar_standard_header_icons', 'any', 'hamburger-button' ],
                        'before'      => sprintf( '<h4>%1$s</h4>', esc_html__('Hamburger Button Page', 'onnat' ) ),
                        'placeholder' => esc_html__('Select a Page', 'onnat' ),
                        'options'     => 'pages',
                        'chosen'      => true,
                        'ajax'        => true,
                        'query_args'  => [
                            'posts_per_page' => -1
                        ],
                    ],                    
                    [
                        'id'         => 'top_bar_standard_header_icons_style',
                        'type'       => 'fieldset',
                        'title'      => esc_html__( 'Header Icons Style','onnat' ),
                        'dependency' => [ 'top_bar_standard_header_icons', '!=', '' ],
                        'fields'     => [
                            [
                                'type' => 'tabbed',
                                'id'   => 'style',
                                'tabs' => [
                                    [
                                        'title'  => esc_html__('Default Header','onnat'),
                                        'fields' => [
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'size',
                                                'title'   => esc_html__('Icon Size','onnat'),
                                                'min'     => 100,
                                                'step'    => 10,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'id'    => 'color',
                                                'title' => esc_html__( 'Icon Color', 'onnat' ),
                                                'type'  => 'link_color',
                                                'hover' => true,
                                            ],
                                        ]
                                    ],
                                    [
                                        'title'  => esc_html__('Sticky Header','onnat'),
                                        'fields' => [
                                            [
                                                'id'      => 'sticky_size',
                                                'type'    => 'spinner',
                                                'title'   => esc_html__('Icon Size','onnat'),
                                                'min'     => 100,
                                                'step'    => 10,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'id'    => 'sticky_color',
                                                'type'  => 'link_color',
                                                'title' => esc_html__( 'Icon Color', 'onnat' ),
                                                'hover' => true,
                                            ],
                                        ]
                                    ],
                                    [
                                        'title'  => esc_html__('Mobile Header','onnat'),
                                        'fields' => [
                                            [
                                                'id'      => 'mobile_size',
                                                'type'    => 'spinner',
                                                'title'   => esc_html__('Icon Size','onnat'),
                                                'min'     => 100,
                                                'step'    => 10,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'id'    => 'mobile_color',
                                                'type'  => 'link_color',
                                                'title' => esc_html__( 'Icon Color', 'onnat' ),
                                                'hover' => true,
                                            ],
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]);

        }

        public function transparent_header() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'parent'      => 'theme_headers_section',
                'title'       => esc_html__( 'Transparent Header', 'onnat' ),
                'description' => sprintf(
                    '<img src="%1$s" alt="%2$s" title="%2$s"/>',
                    ONNAT_CONST_THEME_DIR_URI. '/assets/image/admin/site-options/transparent-header.svg' ,
                    esc_attr__( 'Transparent Header', 'onnat')
                ),
                'fields'      => [
                    [
                        'id'          => 'transparent_header_menu',
                        'type'        => 'select',
                        'title'       => esc_html__( 'Menu', 'onnat' ),
                        'subtitle'    => esc_html__( 'Choose Menu.','onnat' ),
                        'placeholder' => esc_html__( 'Select a menu', 'onnat' ),
                        'attributes'  => [ 'style' => 'width:25%;' ],
                        'chosen'      => true,
                        'options'     => 'menus',
                        'default'     => $this->default['transparent_header_menu']
                    ],
                    [
                        'type'     => 'switcher',
                        'id'       => 'transparent_header_full_width',
                        'title'    => esc_html__( 'Use Full Width', 'onnat'),
                        'subtitle' => esc_html__( 'Turn on to have the full width header area for your site.', 'onnat'),
                        'default'     => $this->default['transparent_header_full_width'],
                    ],
                    [
                        'type'   => 'fieldset',
                        'id'     => 'transparent_header_style',
                        'title'  => esc_html__( 'Style', 'onnat'),
                        'fields' => [
                            [
                                'type' => 'tabbed',
                                'id'   => 'style',
                                'tabs' => [
                                    [
                                        'title'  => esc_html__('Default Header','onnat'),
                                        'fields' => [
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'height',
                                                'title'   => esc_html__('Height','onnat'),
                                                'min'     => 100,
                                                'step'    => 10,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'id'    => 'bg_color',
                                                'title' => esc_html__( 'Background Color', 'onnat' ),
                                                'type'  => 'color',
                                            ],
                                            [
                                                'id'     => 'main_menu_link_color',
                                                'title'  => esc_html__( 'Main Menu Link Color', 'onnat' ),
                                                'type'   => 'link_color',
                                                'hover'  => true,
                                                'active' => true,
                                            ],
                                            [
                                                'id'       => 'sub_bg_color',
                                                'title'    => esc_html__( 'Sub Menu Background Color', 'onnat' ),
                                                'subtitle' => esc_html__( 'Background color sub menu area for your site.', 'onnat'),
                                                'type'     => 'color',
                                            ],
                                            [
                                                'id'     => 'sub_menu_link_color',
                                                'title'  => esc_html__( 'Sub Menu Link Color', 'onnat' ),
                                                'type'   => 'link_color',
                                                'hover'  => true,
                                                'active' => true,
                                                'focus'  => true,
                                            ],
                                        ]
                                    ],
                                    [
                                        'title'  => esc_html__('Sticky Header','onnat'),
                                        'fields' => [
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'sticky_height',
                                                'title'   => esc_html__('Height','onnat'),
                                                'min'     => 100,
                                                'step'    => 10,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'id'    => 'sticky_bg_color',
                                                'title' => esc_html__( 'Background Color', 'onnat' ),
                                                'type'  => 'color',
                                            ],
                                            [
                                                'id'     => 'sticky_main_menu_link_color',
                                                'title'  => esc_html__( 'Main Menu Link Color', 'onnat' ),
                                                'type'   => 'link_color',
                                                'hover'  => true,
                                                'active' => true,
                                            ],
                                            [
                                                'id'       => 'sticky_sub_bg_color',
                                                'title'    => esc_html__( 'Sub Menu Background Color', 'onnat' ),
                                                'subtitle' => esc_html__( 'Background color sub menu area for your site.', 'onnat'),
                                                'type'     => 'color',
                                            ],
                                            [
                                                'id'     => 'sticky_sub_menu_link_color',
                                                'title'  => esc_html__( 'Sub Menu Link Color', 'onnat' ),
                                                'type'   => 'link_color',
                                                'hover'  => true,
                                                'active' => true,
                                                'focus'  => true,
                                            ],
                                        ]
                                    ],
                                    [
                                        'title'  => esc_html__('Mobile Header', 'onnat' ),
                                        'fields' => [
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'mobile_height',
                                                'title'   => esc_html__('Height','onnat'),
                                                'min'     => 100,
                                                'step'    => 10,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'id'    => 'mobile_menu_bg_color',
                                                'title' => esc_html__( 'Menu Background Color', 'onnat' ),
                                                'type'  => 'color',
                                            ],
                                            [
                                                'id'    => 'mobile_border_color',
                                                'title' => esc_html__( 'Menu Border Bottom Color', 'onnat' ),
                                                'type'  => 'color',
                                            ],
                                            [
                                                'id'     => 'mobile_menu_link_color',
                                                'title'  => esc_html__( 'Link Color', 'onnat' ),
                                                'type'   => 'link_color',
                                                'hover'  => true,
                                                'active' => true
                                            ],
                                        ]
                                    ]

                                ]
                            ]
                        ]
                    ],
                    [
                        'type'               => 'typography',
                        'id'                 => 'transparent_header_main_menu_typo',
                        'title'              => esc_html__( 'Main Menu Typography', 'onnat'),
                        'backup_font_family' => true,
                        'text_align'         => false,
                        'font_size'          => false,
                        'line_height'        => false,
                        'letter_spacing'     => false,
                        'color'              => false,
                        'output'             => apply_filters( 'kinfw-filter/theme/output/typo/transparent-header/main-menu', [ '.kinfw-transparent-header .kinfw-main-nav > ul > li > a', '.kinfw-transparent-header #kinfw-mobile-header ul#kinfw-mobile-menu li a' ] )
                    ],
                    [
                        'type'   => 'fieldset',
                        'id'     => 'transparent_header_main_menu_typo_size',
                        'title'  => '&nbsp;',
                        'fields' => [
                            [
                                'type' => 'tabbed',
                                'id'   => 'size',
                                'tabs' => [

                                    /**
                                     * Desktop
                                     */
                                    [
                                        'title'  => esc_html__('Desktop','onnat'),
                                        'icon'   => 'fas fa-desktop',
                                        'fields' => [
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'lg_font_size',
                                                'title'   => esc_html__('Font Size','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'lg_line_height',
                                                'title'   => esc_html__('Line Height','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'lg_letter_space',
                                                'title'   => esc_html__('Letter Spacing','onnat'),
                                                'min'     => .1,
                                                'step'    => .1,
                                                'unit'    => 'px',
                                                'default' => '',
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
                                                'id'      => 'md_font_size',
                                                'title'   => esc_html__('Font Size','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'md_line_height',
                                                'title'   => esc_html__('Line Height','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'md_letter_space',
                                                'title'   => esc_html__('Letter Spacing','onnat'),
                                                'min'     => .1,
                                                'step'    => .1,
                                                'unit'    => 'px',
                                                'default' => '',
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
                                                'id'      => 'sm_font_size',
                                                'title'   => esc_html__('Font Size','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'sm_line_height',
                                                'title'   => esc_html__('Line Height','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'sm_letter_space',
                                                'title'   => esc_html__('Letter Spacing','onnat'),
                                                'min'     => .1,
                                                'step'    => .1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                        ]
                                    ],

                                ]
                            ],
                        ]
                    ],
                    [
                        'type'               => 'typography',
                        'id'                 => 'transparent_header_sub_menu_typo',
                        'title'              => esc_html__( 'Sub Menu Typography', 'onnat'),
                        'backup_font_family' => true,
                        'text_align'         => false,
                        'font_size'          => false,
                        'line_height'        => false,
                        'letter_spacing'     => false,
                        'color'              => false,
                        'output'             => apply_filters( 'kinfw-filter/theme/output/typo/transparent-header/sub-menu', [ '.kinfw-transparent-header .kinfw-main-nav ul li > ul.sub-menu li a' ] )
                    ],
                    [
                        'type'   => 'fieldset',
                        'id'     => 'transparent_header_sub_menu_typo_size',
                        'title'  => '&nbsp;',
                        'fields' => [
                            [
                                'type' => 'tabbed',
                                'id'   => 'size',
                                'tabs' => [

                                    /**
                                     * Desktop
                                     */
                                    [
                                        'title'  => esc_html__('Desktop','onnat'),
                                        'icon'   => 'fas fa-desktop',
                                        'fields' => [
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'lg_font_size',
                                                'title'   => esc_html__('Font Size','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'lg_line_height',
                                                'title'   => esc_html__('Line Height','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'lg_letter_space',
                                                'title'   => esc_html__('Letter Spacing','onnat'),
                                                'min'     => .1,
                                                'step'    => .1,
                                                'unit'    => 'px',
                                                'default' => '',
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
                                                'id'      => 'md_font_size',
                                                'title'   => esc_html__('Font Size','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'md_line_height',
                                                'title'   => esc_html__('Line Height','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'md_letter_space',
                                                'title'   => esc_html__('Letter Spacing','onnat'),
                                                'min'     => .1,
                                                'step'    => .1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                        ]
                                    ],
                                ]
                            ],
                        ]
                    ],
                    [
                        'id'          => 'transparent_header_icons',
                        'type'        => 'select',
                        'title'       => esc_html__( 'Header Icons','onnat' ),
                        'subtitle'    => esc_html__( 'Choose list of icons to show in header.','onnat' ),
                        'chosen'      => true,
                        'multiple'    => true,
                        'sortable'    => true,
                        'placeholder' => esc_attr__( 'Select Header Icon(s)', 'onnat' ),
                        'options'     => $this->header_elements,
                        'default'     => $this->default['transparent_header_icons']
                    ],
                    [
                        'id'          => 'transparent_header_icon_hamburger_button',
                        'type'        => 'select',
                        'title'       => '&nbsp;',
                        'dependency'  => [ 'transparent_header_icons', 'any', 'hamburger-button' ],
                        'before'      => sprintf( '<h4>%1$s</h4>', esc_html__('Hamburger Button Page', 'onnat' ) ),
                        'placeholder' => esc_html__('Select a Page', 'onnat' ),
                        'options'     => 'pages',
                        'chosen'      => true,
                        'ajax'        => true,
                        'query_args'  => [
                            'posts_per_page' => -1
                        ],
                    ],
                    [
                        'id'     => 'transparent_header_icons_style',
                        'type'   => 'fieldset',
                        'title'  => esc_html__( 'Header Icons Style','onnat' ),
                        'fields' => [
                            [
                                'type' => 'tabbed',
                                'id'   => 'style',
                                'tabs' => [
                                    [
                                        'title'  => esc_html__('Default Header','onnat'),
                                        'fields' => [
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'size',
                                                'title'   => esc_html__('Icon Size','onnat'),
                                                'min'     => 100,
                                                'step'    => 10,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'id'    => 'color',
                                                'title' => esc_html__( 'Icon Color', 'onnat' ),
                                                'type'  => 'link_color',
                                                'hover' => true,
                                            ],
                                        ]
                                    ],
                                    [
                                        'title'  => esc_html__('Sticky Header','onnat'),
                                        'fields' => [
                                            [
                                                'id'      => 'sticky_size',
                                                'type'    => 'spinner',
                                                'title'   => esc_html__('Icon Size','onnat'),
                                                'min'     => 100,
                                                'step'    => 10,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'id'    => 'sticky_color',
                                                'type'  => 'link_color',
                                                'title' => esc_html__( 'Icon Color', 'onnat' ),
                                                'hover' => true,
                                            ],
                                        ]
                                    ],
                                    [
                                        'title'  => esc_html__('Mobile Header','onnat'),
                                        'fields' => [
                                            [
                                                'id'      => 'mobile_size',
                                                'type'    => 'spinner',
                                                'title'   => esc_html__('Icon Size','onnat'),
                                                'min'     => 100,
                                                'step'    => 10,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'id'    => 'mobile_color',
                                                'type'  => 'link_color',
                                                'title' => esc_html__( 'Icon Color', 'onnat' ),
                                                'hover' => true,
                                            ],
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]);

        }

        public function transparent_header_with_top_bar() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'parent'      => 'theme_headers_section',
                'title'       => esc_html__( 'Transparent Header + Top Bar', 'onnat' ),
                'description' => sprintf(
                    '<img src="%1$s" alt="%2$s" title="%2$s"/>',
                    ONNAT_CONST_THEME_DIR_URI. '/assets/image/admin/site-options/top-bar-transparent-header.svg' ,
                    esc_attr__( 'Transparent Header with Top Bar', 'onnat')
                ),
                'fields'      => [
                    [
                        'id'          => 'top_bar_transparent_header_menu',
                        'type'        => 'select',
                        'title'       => esc_html__( 'Menu', 'onnat' ),
                        'subtitle'    => esc_html__( 'Choose Menu.','onnat' ),
                        'placeholder' => esc_attr__( 'Select a menu', 'onnat' ),
                        'attributes'  => [ 'style' => 'width:25%;' ],
                        'chosen'      => true,
                        'options'     => 'menus',
                        'default'     => $this->default['top_bar_transparent_header_menu'],
                    ],
                    [
                        'type'     => 'switcher',
                        'id'       => 'top_bar_transparent_header_full_width',
                        'title'    => esc_html__( 'Use Full Width', 'onnat'),
                        'subtitle' => esc_html__( 'Turn on to have the full width header area for your site.', 'onnat'),
                        'default'  => $this->default['top_bar_transparent_header_full_width'],
                    ],
                    [
                        'type'   => 'fieldset',
                        'id'     => 'top_bar_transparent_header_style',
                        'title'  => esc_html__( 'Style', 'onnat'),
                        'fields' => [
                            [
                                'type' => 'tabbed',
                                'id'   => 'style',
                                'tabs' => [
                                    [
                                        'title'  => esc_html__('Default Header','onnat'),
                                        'fields' => [
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'height',
                                                'title'   => esc_html__('Height','onnat'),
                                                'min'     => 100,
                                                'step'    => 10,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'id'    => 'bg_color',
                                                'title' => esc_html__( 'Background Color', 'onnat' ),
                                                'type'  => 'color',
                                            ],
                                            [
                                                'id'     => 'main_menu_link_color',
                                                'title'  => esc_html__( 'Main Menu Link Color', 'onnat' ),
                                                'type'   => 'link_color',
                                                'hover'  => true,
                                                'active' => true,
                                            ],
                                            [
                                                'id'       => 'sub_bg_color',
                                                'title'    => esc_html__( 'Sub Menu Background Color', 'onnat' ),
                                                'subtitle' => esc_html__( 'Background color sub menu area for your site.', 'onnat'),
                                                'type'     => 'color',
                                            ],
                                            [
                                                'id'     => 'sub_menu_link_color',
                                                'title'  => esc_html__( 'Sub Menu Link Color', 'onnat' ),
                                                'type'   => 'link_color',
                                                'hover'  => true,
                                                'active' => true,
                                                'focus'  => true,
                                            ],
                                        ]
                                    ],
                                    [
                                        'title'  => esc_html__('Sticky Header','onnat'),
                                        'fields' => [
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'sticky_height',
                                                'title'   => esc_html__('Height','onnat'),
                                                'min'     => 100,
                                                'step'    => 10,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'id'    => 'sticky_bg_color',
                                                'title' => esc_html__( 'Background Color', 'onnat' ),
                                                'type'  => 'color',
                                            ],
                                            [
                                                'id'     => 'sticky_main_menu_link_color',
                                                'title'  => esc_html__( 'Main Menu Link Color', 'onnat' ),
                                                'type'   => 'link_color',
                                                'hover'  => true,
                                                'active' => true,
                                            ],
                                            [
                                                'id'       => 'sticky_sub_bg_color',
                                                'title'    => esc_html__( 'Sub Menu Background Color', 'onnat' ),
                                                'subtitle' => esc_html__( 'Background color sub menu area for your site.', 'onnat'),
                                                'type'     => 'color',
                                            ],
                                            [
                                                'id'     => 'sticky_sub_menu_link_color',
                                                'title'  => esc_html__( 'Sub Menu Link Color', 'onnat' ),
                                                'type'   => 'link_color',
                                                'hover'  => true,
                                                'active' => true,
                                                'focus'  => true,
                                            ],
                                        ]
                                    ],
                                    [
                                        'title'  => esc_html__('Mobile Header', 'onnat' ),
                                        'fields' => [
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'mobile_height',
                                                'title'   => esc_html__('Height','onnat'),
                                                'min'     => 100,
                                                'step'    => 10,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'id'    => 'mobile_bg_color',
                                                'title' => esc_html__( 'Menu Background Color', 'onnat' ),
                                                'type'  => 'color',
                                            ],
                                            [
                                                'id'    => 'mobile_border_color',
                                                'title' => esc_html__( 'Menu Border Bottom Color', 'onnat' ),
                                                'type'  => 'color',
                                            ],
                                            [
                                                'id'     => 'mobile_menu_link_color',
                                                'title'  => esc_html__( 'Link Color', 'onnat' ),
                                                'type'   => 'link_color',
                                                'hover'  => true,
                                                'active' => true,
                                                'focus'  => true,
                                            ],
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    [
                        'type'     => 'switcher',
                        'id'       => 'top_bar_transparent_header',
                        'title'    => esc_html__( 'Use Top Bar', 'onnat'),
                        'subtitle' => esc_html__( 'Turn on to have the top bar in header area for your site.', 'onnat'),
                        'default'  => $this->default['top_bar_transparent_header'],
                    ],
                    [
                        'type'       => 'fieldset',
                        'id'         => 'top_bar_transparent_header_top',
                        'title'      => esc_html__( 'Top Bar', 'onnat'),
                        'dependency' => [ 'top_bar_transparent_header', '==', 'true'],
                        'default'    => $this->default['top_bar_transparent_header_top'],
                        'fields'     => [
                            [
                                'type'    => 'tabbed',
                                'id'      => 'bar',
                                'default' => $this->default['top_bar_transparent_header_top']['bar'],
                                'tabs'    => [
                                    [
                                        'title'  => esc_html__('Data','onnat'),
                                        'fields' => [
                                            [
                                                'id'          => 'phone_no',
                                                'type'        => 'text',
                                                'title'       => esc_html__( 'Phone Number', 'onnat' ),
                                                'subtitle'    => esc_html__( 'Enter Phone number.','onnat' ),
                                                'placeholder' => '(+12) 3 45 6789',
                                            ],
                                            [
                                                'id'          => 'email_id',
                                                'type'        => 'text',
                                                'title'       => esc_html__( 'Email ID', 'onnat' ),
                                                'subtitle'    => esc_html__( 'Enter Email ID.','onnat' ),
                                                'placeholder' => get_option('admin_email'),
                                            ],
                                            [
                                                'id'          => 'social_menu',
                                                'type'        => 'select',
                                                'title'       => esc_html__( 'Social Navigation', 'onnat' ),
                                                'subtitle'    => esc_html__( 'Choose Social Navigation Menu.','onnat' ),
                                                'placeholder' => esc_attr__( 'Select a menu', 'onnat' ),
                                                'attributes'  => [ 'style' => 'width:46%;' ],
                                                'chosen'      => true,
                                                'options'     => 'menus',
                                            ],
                                        ]
                                    ],
                                    [
                                        'title'  => esc_html__('Style','onnat'),
                                        'fields' => [
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'height',
                                                'title'   => esc_html__('Default Header Height','onnat'),
                                                'min'     => 100,
                                                'step'    => 10,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'mobile_height',
                                                'title'   => esc_html__('Mobile Header Height','onnat'),
                                                'min'     => 100,
                                                'step'    => 10,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'id'    => 'bg_color',
                                                'title' => esc_html__( 'Background Color', 'onnat' ),
                                                'type'  => 'color',
                                            ],
                                            [
                                                'id'    => 'separator_color',
                                                'title' => esc_html__( 'Separator Color', 'onnat' ),
                                                'type'  => 'color',
                                            ],
                                            [
                                                'id'    => 'icon_color',
                                                'title' => esc_html__( 'Icon Color', 'onnat' ),
                                                'type'  => 'color',
                                            ],
                                            [
                                                'id'    => 'link_color',
                                                'title' => esc_html__( 'Link Color', 'onnat' ),
                                                'type'  => 'link_color',
                                                'hover' => true,
                                            ],
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    [
                        'type'               => 'typography',
                        'id'                 => 'top_bar_transparent_header_main_menu_typo',
                        'title'              => esc_html__( 'Main Menu Typography', 'onnat'),
                        'backup_font_family' => true,
                        'text_align'         => false,
                        'font_size'          => false,
                        'line_height'        => false,
                        'letter_spacing'     => false,
                        'color'              => false,
                        'output'             => apply_filters( 'kinfw-filter/theme/output/typo/top-bar-transparent-header/main-menu', [ '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar .kinfw-main-nav > ul > li > a', '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-mobile-header ul.kinfw-mobile-menu li a' ] )
                    ],
                    [
                        'type'   => 'fieldset',
                        'id'     => 'top_bar_transparent_header_main_menu_typo_size',
                        'title'  => '&nbsp;',
                        'fields' => [
                            [
                                'type' => 'tabbed',
                                'id'   => 'size',
                                'tabs' => [

                                    /**
                                     * Desktop
                                     */
                                    [
                                        'title'  => esc_html__('Desktop','onnat'),
                                        'icon'   => 'fas fa-desktop',
                                        'fields' => [
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'lg_font_size',
                                                'title'   => esc_html__('Font Size','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'lg_line_height',
                                                'title'   => esc_html__('Line Height','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'lg_letter_space',
                                                'title'   => esc_html__('Letter Spacing','onnat'),
                                                'min'     => .1,
                                                'step'    => .1,
                                                'unit'    => 'px',
                                                'default' => '',
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
                                                'id'      => 'md_font_size',
                                                'title'   => esc_html__('Font Size','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'md_line_height',
                                                'title'   => esc_html__('Line Height','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'md_letter_space',
                                                'title'   => esc_html__('Letter Spacing','onnat'),
                                                'min'     => .1,
                                                'step'    => .1,
                                                'unit'    => 'px',
                                                'default' => '',
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
                                                'id'      => 'sm_font_size',
                                                'title'   => esc_html__('Font Size','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'sm_line_height',
                                                'title'   => esc_html__('Line Height','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'sm_letter_space',
                                                'title'   => esc_html__('Letter Spacing','onnat'),
                                                'min'     => .1,
                                                'step'    => .1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                        ]
                                    ],

                                ]
                            ],
                        ]
                    ],
                    [
                        'type'               => 'typography',
                        'id'                 => 'top_bar_transparent_header_sub_menu_typo',
                        'title'              => esc_html__( 'Sub Menu Typography', 'onnat'),
                        'backup_font_family' => true,
                        'text_align'         => false,
                        'font_size'          => false,
                        'line_height'        => false,
                        'letter_spacing'     => false,
                        'color'              => false,
                        'output'             => apply_filters( 'kinfw-filter/theme/output/typo/top-bar-transparent-header/sub-menu', [ '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar .kinfw-main-nav ul li > ul.sub-menu li a' ] )
                    ],
                    [
                        'type'   => 'fieldset',
                        'id'     => 'top_bar_transparent_header_sub_menu_typo_size',
                        'title'  => '&nbsp;',
                        'fields' => [
                            [
                                'type' => 'tabbed',
                                'id'   => 'size',
                                'tabs' => [

                                    /**
                                     * Desktop
                                     */
                                    [
                                        'title'  => esc_html__('Desktop','onnat'),
                                        'icon'   => 'fas fa-desktop',
                                        'fields' => [
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'lg_font_size',
                                                'title'   => esc_html__('Font Size','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'lg_line_height',
                                                'title'   => esc_html__('Line Height','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'lg_letter_space',
                                                'title'   => esc_html__('Letter Spacing','onnat'),
                                                'min'     => .1,
                                                'step'    => .1,
                                                'unit'    => 'px',
                                                'default' => '',
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
                                                'id'      => 'md_font_size',
                                                'title'   => esc_html__('Font Size','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'md_line_height',
                                                'title'   => esc_html__('Line Height','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'md_letter_space',
                                                'title'   => esc_html__('Letter Spacing','onnat'),
                                                'min'     => .1,
                                                'step'    => .1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                        ]
                                    ],
                                ]
                            ],
                        ]
                    ],
                    [
                        'id'          => 'top_bar_transparent_header_icons',
                        'type'        => 'select',
                        'title'       => esc_html__( 'Header Icons','onnat' ),
                        'subtitle'    => esc_html__( 'Choose list of icons to show in header.','onnat' ),
                        'chosen'      => true,
                        'multiple'    => true,
                        'sortable'    => true,
                        'placeholder' => esc_attr__( 'Select Header Icon(s)', 'onnat' ),
                        'options'     => $this->header_elements,
                        'default'     => $this->default['top_bar_transparent_header_icons']
                    ],
                    [
                        'id'          => 'top_bar_transparent_header_icon_hamburger_button',
                        'type'        => 'select',
                        'title'       => '&nbsp;',
                        'dependency'  => [ 'top_bar_transparent_header_icons', 'any', 'hamburger-button' ],
                        'before'      => sprintf( '<h4>%1$s</h4>', esc_html__('Hamburger Button Page', 'onnat' ) ),
                        'placeholder' => esc_html__('Select a Page', 'onnat' ),
                        'options'     => 'pages',
                        'chosen'      => true,
                        'ajax'        => true,
                        'query_args'  => [
                            'posts_per_page' => -1
                        ],
                    ],                    
                    [
                        'id'     => 'top_bar_transparent_header_icons_style',
                        'type'   => 'fieldset',
                        'title'  => esc_html__( 'Header Icons Style','onnat' ),
                        'fields' => [
                            [
                                'type' => 'tabbed',
                                'id'   => 'style',
                                'tabs' => [
                                    [
                                        'title'  => esc_html__('Default Header','onnat'),
                                        'fields' => [
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'size',
                                                'title'   => esc_html__('Icon Size','onnat'),
                                                'min'     => 100,
                                                'step'    => 10,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'id'    => 'color',
                                                'title' => esc_html__( 'Icon Color', 'onnat' ),
                                                'type'  => 'link_color',
                                                'hover' => true,
                                            ],
                                        ]
                                    ],
                                    [
                                        'title'  => esc_html__('Sticky Header','onnat'),
                                        'fields' => [
                                            [
                                                'id'      => 'sticky_size',
                                                'type'    => 'spinner',
                                                'title'   => esc_html__('Icon Size','onnat'),
                                                'min'     => 100,
                                                'step'    => 10,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'id'    => 'sticky_color',
                                                'type'  => 'link_color',
                                                'title' => esc_html__( 'Icon Color', 'onnat' ),
                                                'hover' => true,

                                            ],
                                        ]
                                    ],
                                    [
                                        'title'  => esc_html__('Mobile Header','onnat'),
                                        'fields' => [
                                            [
                                                'id'      => 'mobile_size',
                                                'type'    => 'spinner',
                                                'title'   => esc_html__('Icon Size','onnat'),
                                                'min'     => 100,
                                                'step'    => 10,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'id'    => 'mobile_color',
                                                'type'  => 'link_color',
                                                'title' => esc_html__( 'Icon Color', 'onnat' ),
                                                'hover' => true,
                                            ],
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]);

        }

        public function cascade_header() {
            $cascade_header_icons = array_merge( $this->header_elements, [
                'button' => esc_html__( 'Button','onnat' ),
            ] );
            asort( $cascade_header_icons );

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'parent'      => 'theme_headers_section',
                'title'       => esc_html__( 'Cascade Header', 'onnat' ),
                'description' => sprintf(
                    '<img src="%1$s" alt="%2$s" title="%2$s"/>',
                    ONNAT_CONST_THEME_DIR_URI. '/assets/image/admin/site-options/cascade-header.svg' ,
                    esc_attr__( 'Cascade Header', 'onnat')
                ),
                'fields'      => [
                    [
                        'id'          => 'cascade_header_menu',
                        'type'        => 'select',
                        'title'       => esc_html__( 'Menu', 'onnat' ),
                        'subtitle'    => esc_html__( 'Choose Menu.','onnat' ),
                        'placeholder' => esc_attr__( 'Select a menu', 'onnat' ),
                        'attributes'  => [ 'style' => 'width:25%;' ],
                        'chosen'      => true,
                        'options'     => 'menus',
                        'default'     => $this->default['cascade_header_menu'],
                    ],
                    [
                        'type'     => 'switcher',
                        'id'       => 'cascade_header_full_width',
                        'title'    => esc_html__( 'Use Full Width', 'onnat'),
                        'subtitle' => esc_html__( 'Turn on to have the full width header area for your site.', 'onnat'),
                        'default'  => $this->default['cascade_header_full_width'],
                    ],
                    [
                        'type'   => 'fieldset',
                        'id'     => 'cascade_header_style',
                        'title'  => esc_html__( 'Style', 'onnat'),
                        'fields' => [
                            [
                                'type' => 'tabbed',
                                'id'   => 'style',
                                'tabs' => [
                                    [
                                        'title'  => esc_html__('Default Header','onnat'),
                                        'fields' => [
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'height',
                                                'title'   => esc_html__('Height','onnat'),
                                                'min'     => 100,
                                                'step'    => 10,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'id'    => 'bg_color',
                                                'title' => esc_html__( 'Background Color', 'onnat' ),
                                                'type'  => 'color',
                                            ],
                                            [
                                                'id'     => 'main_menu_link_color',
                                                'title'  => esc_html__( 'Main Menu Link Color', 'onnat' ),
                                                'type'   => 'link_color',
                                                'hover'  => true,
                                                'active' => true,
                                            ],
                                            [
                                                'id'       => 'sub_bg_color',
                                                'title'    => esc_html__( 'Sub Menu Background Color', 'onnat' ),
                                                'subtitle' => esc_html__( 'Background color sub menu area for your site.', 'onnat'),
                                                'type'     => 'color',
                                            ],
                                            [
                                                'id'     => 'sub_menu_link_color',
                                                'title'  => esc_html__( 'Sub Menu Link Color', 'onnat' ),
                                                'type'   => 'link_color',
                                                'hover'  => true,
                                                'active' => true,
                                                'focus'  => true,
                                            ],
                                        ]
                                    ],
                                    [
                                        'title'  => esc_html__('Sticky Header','onnat'),
                                        'fields' => [
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'sticky_height',
                                                'title'   => esc_html__('Height','onnat'),
                                                'min'     => 100,
                                                'step'    => 10,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'id'    => 'sticky_bg_color',
                                                'title' => esc_html__( 'Background Color', 'onnat' ),
                                                'type'  => 'color',
                                            ],
                                            [
                                                'id'     => 'sticky_main_menu_link_color',
                                                'title'  => esc_html__( 'Main Menu Link Color', 'onnat' ),
                                                'type'   => 'link_color',
                                                'hover'  => true,
                                                'active' => true,
                                            ],
                                            [
                                                'id'       => 'sticky_sub_bg_color',
                                                'title'    => esc_html__( 'Sub Menu Background Color', 'onnat' ),
                                                'subtitle' => esc_html__( 'Background color sub menu area for your site.', 'onnat'),
                                                'type'     => 'color',
                                            ],
                                            [
                                                'id'     => 'sticky_sub_menu_link_color',
                                                'title'  => esc_html__( 'Sub Menu Link Color', 'onnat' ),
                                                'type'   => 'link_color',
                                                'hover'  => true,
                                                'active' => true,
                                                'focus'  => true,
                                            ],
                                        ]
                                    ],
                                    [
                                        'title'  => esc_html__('Mobile Header', 'onnat' ),
                                        'fields' => [
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'mobile_height',
                                                'title'   => esc_html__('Height','onnat'),
                                                'min'     => 100,
                                                'step'    => 10,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'id'    => 'mobile_bg_color',
                                                'title' => esc_html__( 'Background Color', 'onnat' ),
                                                'type'  => 'color',
                                            ],
                                            [
                                                'id'    => 'mobile_menu_bg_color',
                                                'title' => esc_html__( 'Menu Background Color', 'onnat' ),
                                                'type'  => 'color',
                                            ],
                                            [
                                                'id'    => 'mobile_border_color',
                                                'title' => esc_html__( 'Menu Border Bottom Color', 'onnat' ),
                                                'type'  => 'color',
                                            ],
                                            [
                                                'id'     => 'mobile_menu_link_color',
                                                'title'  => esc_html__( 'Link Color', 'onnat' ),
                                                'type'   => 'link_color',
                                                'hover'  => true,
                                                'active' => true
                                            ],
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    [
                        'type'     => 'switcher',
                        'id'       => 'top_bar_cascade_header',
                        'title'    => esc_html__( 'Use Top Bar', 'onnat'),
                        'subtitle' => esc_html__( 'Turn on to have the top bar in header area for your site.', 'onnat'),
                        'default'  => $this->default['top_bar_cascade_header'],
                    ],
                    [
                        'type'       => 'fieldset',
                        'id'         => 'top_bar_cascade_header_top',
                        'title'      => esc_html__( 'Top Bar', 'onnat'),
                        'dependency' => [ 'top_bar_cascade_header', '==', 'true'],
                        'default'    => $this->default['top_bar_cascade_header_top'],
                        'fields'     => [
                            [
                                'type'    => 'tabbed',
                                'id'      => 'bar',
                                'default' => $this->default['top_bar_cascade_header_top']['bar'],
                                'tabs'    => [
                                    [
                                        'title'  => esc_html__('Data','onnat'),
                                        'fields' => [
                                            [
                                                'id'          => 'phone_no',
                                                'type'        => 'text',
                                                'title'       => esc_html__( 'Phone Number', 'onnat' ),
                                                'subtitle'    => esc_html__( 'Enter Phone number.','onnat' ),
                                                'placeholder' => '(+12) 3 45 6789',
                                            ],
                                            [
                                                'id'          => 'email_id',
                                                'type'        => 'text',
                                                'title'       => esc_html__( 'Email ID', 'onnat' ),
                                                'subtitle'    => esc_html__( 'Enter Email ID.','onnat' ),
                                                'placeholder' => get_option('admin_email'),
                                            ],
                                            [
                                                'id'          => 'inline_address',
                                                'type'        => 'text',
                                                'title'       => esc_html__( 'Address', 'onnat' ),
                                                'subtitle'    => esc_html__( 'Enter Address.','onnat' ),
                                                'placeholder' => '1432 Pkgs Sr, Vadiv, 41653',
                                            ],
                                            [
                                                'id'          => 'social_menu_title',
                                                'type'        => 'text',
                                                'title'       => esc_html__( 'Social Nav Title', 'onnat' ),
                                                'subtitle'    => esc_html__( 'Enter Social Nav Title','onnat' ),
                                                'placeholder' => esc_html__( 'Follow On','onnat' ),
                                                'dependency'  => [ 'social_menu', '!=', '' ],
                                            ],
                                            [
                                                'id'          => 'social_menu',
                                                'type'        => 'select',
                                                'title'       => esc_html__( 'Social Navigation', 'onnat' ),
                                                'subtitle'    => esc_html__( 'Choose Social Navigation Menu.','onnat' ),
                                                'placeholder' => esc_attr__( 'Select a menu', 'onnat' ),
                                                'attributes'  => [ 'style' => 'width:46%;' ],
                                                'chosen'      => true,
                                                'options'     => 'menus',
                                            ],
                                        ]
                                    ],
                                    [
                                        'title'  => esc_html__('Style','onnat'),
                                        'fields' => [
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'height',
                                                'title'   => esc_html__('Default Header Height','onnat'),
                                                'min'     => 100,
                                                'step'    => 10,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'mobile_height',
                                                'title'   => esc_html__('Mobile Header Height','onnat'),
                                                'min'     => 100,
                                                'step'    => 10,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'id'    => 'bg_color',
                                                'title' => esc_html__( 'Background Color', 'onnat' ),
                                                'type'  => 'color',
                                            ],
                                            [
                                                'id'    => 'separator_color',
                                                'title' => esc_html__( 'Separator Color', 'onnat' ),
                                                'type'  => 'color',
                                            ],
                                            [
                                                'id'    => 'icon_color',
                                                'title' => esc_html__( 'Icon Color', 'onnat' ),
                                                'type'  => 'color',
                                            ],
                                            [
                                                'id'    => 'link_color',
                                                'title' => esc_html__( 'Link Color', 'onnat' ),
                                                'type'  => 'link_color',
                                                'hover' => true,
                                            ],
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    [
                        'type'               => 'typography',
                        'id'                 => 'cascade_header_main_menu_typo',
                        'title'              => esc_html__( 'Main Menu Typography', 'onnat'),
                        'backup_font_family' => true,
                        'text_align'         => false,
                        'font_size'          => false,
                        'line_height'        => false,
                        'letter_spacing'     => false,
                        'color'              => false,
                        'output'             => apply_filters( 'kinfw-filter/theme/output/typo/cascade-header/main-menu', [ '.kinfw-cascade-header.kinfw-cascade-header-with-top-bar .kinfw-main-nav > ul > li > a,.kinfw-cascade-header.kinfw-cascade-header-with-top-bar #kinfw-mobile-header ul.kinfw-mobile-menu li a' ] )
                    ],
                    [
                        'type'   => 'fieldset',
                        'id'     => 'cascade_header_main_menu_typo_size',
                        'title'  => '&nbsp;',
                        'fields' => [
                            [
                                'type' => 'tabbed',
                                'id'   => 'size',
                                'tabs' => [
                                    /**
                                     * Desktop
                                     */
                                    [
                                        'title'  => esc_html__('Desktop','onnat'),
                                        'icon'   => 'fas fa-desktop',
                                        'fields' => [
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'lg_font_size',
                                                'title'   => esc_html__('Font Size','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'lg_line_height',
                                                'title'   => esc_html__('Line Height','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'lg_letter_space',
                                                'title'   => esc_html__('Letter Spacing','onnat'),
                                                'min'     => .1,
                                                'step'    => .1,
                                                'unit'    => 'px',
                                                'default' => '',
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
                                                'id'      => 'md_font_size',
                                                'title'   => esc_html__('Font Size','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'md_line_height',
                                                'title'   => esc_html__('Line Height','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'md_letter_space',
                                                'title'   => esc_html__('Letter Spacing','onnat'),
                                                'min'     => .1,
                                                'step'    => .1,
                                                'unit'    => 'px',
                                                'default' => '',
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
                                                'id'      => 'sm_font_size',
                                                'title'   => esc_html__('Font Size','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'sm_line_height',
                                                'title'   => esc_html__('Line Height','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'sm_letter_space',
                                                'title'   => esc_html__('Letter Spacing','onnat'),
                                                'min'     => .1,
                                                'step'    => .1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                        ]
                                    ],

                                ]
                            ],
                        ]
                    ],
                    [
                        'type'               => 'typography',
                        'id'                 => 'cascade_header_sub_menu_typo',
                        'title'              => esc_html__( 'Sub Menu Typography', 'onnat'),
                        'backup_font_family' => true,
                        'text_align'         => false,
                        'font_size'          => false,
                        'line_height'        => false,
                        'letter_spacing'     => false,
                        'color'              => false,
                        'output'             => apply_filters( 'kinfw-filter/theme/output/typo/cascade-header/sub-menu', [ '.kinfw-cascade-header.kinfw-cascade-header-with-top-bar .kinfw-main-nav ul li > ul.sub-menu li a' ] ),
                    ],
                    [
                        'type'   => 'fieldset',
                        'id'     => 'cascade_header_sub_menu_typo_size',
                        'title'  => '&nbsp;',
                        'fields' => [
                            [
                                'type' => 'tabbed',
                                'id'   => 'size',
                                'tabs' => [
                                    /**
                                     * Desktop
                                     */
                                    [
                                        'title'  => esc_html__('Desktop','onnat'),
                                        'icon'   => 'fas fa-desktop',
                                        'fields' => [
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'lg_font_size',
                                                'title'   => esc_html__('Font Size','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'lg_line_height',
                                                'title'   => esc_html__('Line Height','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'lg_letter_space',
                                                'title'   => esc_html__('Letter Spacing','onnat'),
                                                'min'     => .1,
                                                'step'    => .1,
                                                'unit'    => 'px',
                                                'default' => '',
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
                                                'id'      => 'md_font_size',
                                                'title'   => esc_html__('Font Size','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'md_line_height',
                                                'title'   => esc_html__('Line Height','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'md_letter_space',
                                                'title'   => esc_html__('Letter Spacing','onnat'),
                                                'min'     => .1,
                                                'step'    => .1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                        ]
                                    ],
                                ]
                            ],
                        ]
                    ],
                    [
                        'id'          => 'cascade_header_icons',
                        'type'        => 'select',
                        'title'       => esc_html__( 'Header Icons','onnat' ),
                        'subtitle'    => esc_html__( 'Choose list of icons to show in header.','onnat' ),
                        'chosen'      => true,
                        'multiple'    => true,
                        'sortable'    => true,
                        'placeholder' => esc_attr__( 'Select Header Icon(s)', 'onnat' ),
                        'options'     => $cascade_header_icons,
                        'default'     => '',
                    ],
                    [
                        'id'         => 'cascade_header_icon_button',
                        'type'       => 'link',
                        'title'      => '&nbsp;',
                        'before'     => sprintf( '<h4>%1$s</h4>', esc_html__('Button', 'onnat' ) ),
                        'dependency' => [ 'cascade_header_icons', 'any', 'button' ],
                        'default'    => [
                            'url' => 'https://kinforce.net',
                            'text'   => esc_html__( 'Get A Quato','onnat' ),
                            'target' => '_blank',
                        ],
                    ],
                    [
                        'id'          => 'cascade_header_icon_hamburger_button',
                        'type'        => 'select',
                        'title'       => '&nbsp;',
                        'dependency'  => [ 'cascade_header_icons', 'any', 'hamburger-button' ],
                        'before'      => sprintf( '<h4>%1$s</h4>', esc_html__('Hamburger Button Page', 'onnat' ) ),
                        'placeholder' => esc_html__('Select a Page', 'onnat' ),
                        'options'     => 'pages',
                        'chosen'      => true,
                        'ajax'        => true,
                        'query_args'  => [
                            'posts_per_page' => -1
                        ],
                    ],
                    [
                        'id'         => 'cascade_header_icons_style',
                        'type'       => 'fieldset',
                        'title'      => esc_html__( 'Header Icons Style','onnat' ),
                        'dependency' => [ 'cascade_header_icons', '!=', '' ],
                        'fields'     => [
                            [
                                'type' => 'tabbed',
                                'id'   => 'style',
                                'tabs' => [
                                    [
                                        'title'  => esc_html__('Default Header','onnat'),
                                        'fields' => [
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'size',
                                                'title'   => esc_html__('Icon Size','onnat'),
                                                'min'     => 100,
                                                'step'    => 10,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'id'    => 'color',
                                                'title' => esc_html__( 'Icon Color', 'onnat' ),
                                                'type'  => 'link_color',
                                                'hover' => true,
                                            ],
                                        ]
                                    ],
                                    [
                                        'title'  => esc_html__('Sticky Header','onnat'),
                                        'fields' => [
                                            [
                                                'id'      => 'sticky_size',
                                                'type'    => 'spinner',
                                                'title'   => esc_html__('Icon Size','onnat'),
                                                'min'     => 100,
                                                'step'    => 10,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'id'    => 'sticky_color',
                                                'type'  => 'link_color',
                                                'title' => esc_html__( 'Icon Color', 'onnat' ),
                                                'hover' => true,
                                            ],
                                        ]
                                    ],
                                    [
                                        'title'  => esc_html__('Mobile Header','onnat'),
                                        'fields' => [
                                            [
                                                'id'      => 'mobile_size',
                                                'type'    => 'spinner',
                                                'title'   => esc_html__('Icon Size','onnat'),
                                                'min'     => 100,
                                                'step'    => 10,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'id'    => 'mobile_color',
                                                'type'  => 'link_color',
                                                'title' => esc_html__( 'Icon Color', 'onnat' ),
                                                'hover' => true,
                                            ],
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]);
        }

        public function defaults( $defaults = [] ) {

            /**
             * Standard Header
             */
                $defaults['standard_header_menu']       = '';
                $defaults['standard_header_full_width'] = true;
                $defaults['standard_header_icons']      = [ 'search' ];

            /**
             * Standard Header + Top Bar
             */
                $defaults['top_bar_standard_header_menu']       = '';
                $defaults['top_bar_standard_header_full_width'] = false;
                $defaults['top_bar_standard_header']            = true;
                $defaults['top_bar_standard_header_top']        = [
                    'bar' => [
                        'phone_no'    => '+123 (45) 6789',
                        'email_id'    => get_option('admin_email'),
                        'social_menu' => ''
                    ]
                ];
                $defaults['top_bar_standard_header_icons']      = [ 'search' ];

            /**
             * Transparent Header
             */
                $defaults['transparent_header_menu']       = '';
                $defaults['transparent_header_full_width'] = false;
                $defaults['transparent_header_icons']      = [ 'search' ];

            /**
             * Transparent Header + Top Bar
             */
                $defaults['top_bar_transparent_header_menu']       = '';
                $defaults['top_bar_transparent_header_full_width'] = false;
                $defaults['top_bar_transparent_header']            = true;
                $defaults['top_bar_transparent_header_top']        = [
                    'bar' => [
                        'phone_no'    => '+123 (45) 6789',
                        'email_id'    => get_option('admin_email'),
                        'social_menu' => ''
                    ]
                ];
                $defaults['top_bar_transparent_header_icons']      = [ 'search' ];

            /**
             * Cascade Header
             */
                $defaults['cascade_header_menu']        = '';
                $defaults['cascade_header_full_width']  = true;
                $defaults['top_bar_cascade_header']     = true;
                $defaults['top_bar_cascade_header_top'] = [
                    'bar' => [
                        'phone_no'    => '+123 (45) 6789',
                        'email_id'    => get_option('admin_email'),
                    ]
                ];

            return $defaults;
        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_options_header' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_options_header() {

        return Onnat_Theme_Options_Header::get_instance();
    }
}

kinfw_onnat_theme_options_header();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */