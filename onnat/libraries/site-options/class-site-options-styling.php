<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Options_Styling' ) ) {

	/**
	 * The Onnat theme styling options setup class.
	 */
    class Onnat_Theme_Options_Styling {

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

            $this->init_settings();
                $this->skin_settings();
                $this->typo_settings();
                $this->layout_settings();
                $this->body_settings();
                $this->cursor_settings();
                $this->loader_settings();
                $this->sidebar_settings();
                $this->heading_tag_settings();
                #$this->scroll_bar_settings();
                $this->scroll_to_top_settings();
                $this->menu_settings();

            do_action( 'kinfw-action/theme/site-options/styling/loaded' );

        }

        public function init_settings() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'id'    => 'theme_styling_section',
                'title' => esc_html__( 'Styling', 'onnat' ),
            ] );

        }

        public function skin_settings() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'parent' => 'theme_styling_section',
                'title'  => esc_html__( 'Skin', 'onnat' ),
                'fields' => [
                    [
                        'id'      => 'skin_primary_color',
                        'title'   => esc_html__( 'Primary Color', 'onnat' ),
                        'type'    => 'color',
                        'default' => $this->default['skin_primary_color']
                    ],
                    [
                        'id'      => 'skin_secondary_color',
                        'title'   => esc_html__( 'Secondary Color', 'onnat' ),
                        'type'    => 'color',
                        'default' => $this->default['skin_secondary_color']
                    ],
                    [
                        'id'      => 'skin_secondary_opacity_color',
                        'title'   => esc_html__( 'Secondary Opacity Color', 'onnat' ),
                        'type'    => 'color',
                        'default' => $this->default['skin_secondary_opacity_color']
                    ],
                    [
                        'id'      => 'skin_tertiary_color',
                        'title'   => esc_html__( 'Tertiary Color', 'onnat' ),
                        'type'    => 'color',
                        'default' => $this->default['skin_tertiary_color']
                    ],                    
                    [
                        'id'      => 'skin_accent_color',
                        'title'   => esc_html__( 'Accent Color', 'onnat' ),
                        'type'    => 'color',
                        'default' => $this->default['skin_accent_color']
                    ],
                    [
                        'id'      => 'skin_light_color',
                        'title'   => esc_html__( 'Text Light Color', 'onnat' ),
                        'type'    => 'color',
                        'default' => $this->default['skin_light_color']
                    ],
                    [
                        'id'      => 'skin_white_color',
                        'title'   => esc_html__( 'White Color', 'onnat' ),
                        'type'    => 'color',
                        'default' => $this->default['skin_white_color']
                    ],
                    [
                        'id'      => 'skin_bg_light_color',
                        'title'   => esc_html__( 'Background Light Color', 'onnat' ),
                        'type'    => 'color',
                        'default' => $this->default['skin_bg_light_color']
                    ],
                ]
            ] );

        }

        public function typo_settings() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'parent' => 'theme_styling_section',
                'title'  => esc_html__( 'Typography', 'onnat' ),
                'fields' => [
                    [
                        'type'    => 'subheading',
                        'content' => esc_html__( 'Global Typography', 'onnat' ),
                    ],
                    [
                        'type'    => 'submessage',
                        'style'   => 'info',
                        'content' => esc_html__( 'Configure your website\'s global typography preferences here.', 'onnat' ),
                    ],
                    [
                        'type'               => 'typography',
                        'id'                 => 'primary_typo',
                        'title'              => esc_html__( 'Primary Typography', 'onnat'),
                        'multi_subset'       => true,
                        'extra_styles'       => true,
                        'backup_font_family' => true,
                        'font_size'          => false,
                        'line_height'        => false,
                        'letter_spacing'     => false,
                        'text_align'         => false,
                        'text_transform'     => false,
                        'color'              => true,
                        'default'            => $this->default['primary_typo']
                    ],
                    [
                        'type'               => 'typography',
                        'id'                 => 'secondary_typo',
                        'title'              => esc_html__( 'Secondary Typography', 'onnat'),
                        'multi_subset'       => true,
                        'extra_styles'       => true,
                        'backup_font_family' => true,
                        'font_size'          => false,
                        'line_height'        => false,
                        'letter_spacing'     => false,
                        'text_align'         => false,
                        'text_transform'     => false,
                        'color'              => true,
                        'default'            => $this->default['secondary_typo']
                    ],
                ]
            ] );

        }

        public function layout_settings() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'parent' => 'theme_styling_section',
                'title'  => esc_html__( 'Layout', 'onnat' ),
                'fields' => [
                    [
                        'id'         => 'layout',
                        'title'      => esc_html__( 'Site Layout', 'onnat' ),
                        'type'       => 'button_set',
                        'desc'       => esc_html('Use this option to toggle the website layout.', 'onnat' ),
                        'attributes' => [ 'style' => 'width:25%' ],
                        'default'    => $this->default['layout'],
                        'options'    => [
                            'kinfw-boxed-layout' => esc_html__( 'Boxed','onnat' ),
                            'kinfw-wide-layout'  => esc_html__( 'Wide','onnat' ),
                        ],
                    ],
                    [
                        'id'         => 'boxed_bg_color',
                        'title'      => esc_html__( 'Boxed Background Color', 'onnat' ),
                        'type'       => 'color',
                        'dependency' => [ 'layout', '==', 'kinfw-boxed-layout' ]
                    ],
                    [
                        'id'                    => 'body_bg',
                        'title'                 => esc_html__( 'Body Background', 'onnat' ),
                        'type'                  => 'background',
                        'background_color'      => true,
                        'background_image'      => true,
                        'background-position'   => true,
                        'background_repeat'     => true,
                        'background_attachment' => true,
                        'background_size'       => true,
                        'background_origin'     => true,
                        'background_clip'       => true,
                    ]
                ]
            ] );

        }

        public function body_settings() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'parent' => 'theme_styling_section',
                'title'  => esc_html__( 'Body', 'onnat' ),
                'fields' => [
                    [
                        'type'    => 'button_set',
                        'id'      => 'body_typo_type',
                        'title'   => esc_html__('Body Content Typography?','onnat'),
                        'options' => [
                            'primary'   => esc_html__('Primary Font','onnat'),
                            'secondary' => esc_html__('Secondary Font','onnat'),
                            'custom'    => esc_html__('Custom Font','onnat'),
                        ],
                        'default' => $this->default['body_typo_type']
                    ],
                    [
                        'type'               => 'typography',
                        'id'                 => 'body_typo',
                        'title'              => esc_html__( 'Body Content Custom Typography', 'onnat'),
                        'multi_subset'       => true,
                        'extra_styles'       => true,
                        'backup_font_family' => true,
                        'font_size'          => false,
                        'line_height'        => false,
                        'letter_spacing'     => false,
                        'text_align'         => false,
                        'text_transform'     => false,
                        'default'            => $this->default['body_typo'],
                        'dependency'         => [ 'body_typo_type', '==', 'custom' ],
                    ],
                    [
                        'type'   => 'fieldset',
                        'id'     => 'body_typo_size',
                        'title'  => '&nbsp;',
                        'fields' => [
                            [
                                'type'    => 'subheading',
                                'content' => esc_html__( 'Body Content Font Style', 'onnat'),
                            ],
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
                        'id'      => 'body_link_color',
                        'title'   => esc_html__( 'Body Link Color', 'onnat' ),
                        'type'    => 'link_color',
                        'default' => $this->default['body_link_color'],
                    ]
                ]
            ] );

        }

        public function cursor_settings() {

            $cursor_colors_opt = [
                'kinfw-cursor-accent-color'    => esc_html__( 'Accent Color','onnat' ),
                'kinfw-cursor-secondary-color' => esc_html__( 'Secondary Color','onnat' ),
            ];

            $cursor_colors = kinfw_onnat_theme_options()->kinfw_get_option( 'cursor_colors' );
            foreach( $cursor_colors as $key => $cursor_color ) {
                $cursor_colors_opt['kinfw-cursor-custom-'.$key.'-color'] = $cursor_color['label'];
            }

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'parent' => 'theme_styling_section',
                'title'  => esc_html__( 'Cursor', 'onnat' ),
                'fields' => [
                    [
                        'id'      => 'cursor',
                        'title'   => esc_html__( 'Use Custom Cursor', 'onnat' ),
                        'type'    => 'switcher',
                        'desc'    => esc_html('Use this option to toggle the custom cursor for website.', 'onnat' ),
                        'default' => $this->default['cursor'],
                    ],
                    [
                        'id'          => 'cursor_style',
                        'title'       => esc_html__( 'Cursor Style', 'onnat' ),
                        'type'        => 'select',
                        'placeholder' => esc_html__( 'Select Cursor Style', 'onnat' ),
                        'attributes'  => [ 'style' => 'width:25%' ],
                        'options'     => [
                            'kinfw-cursor-dot' => esc_html__( 'Dot','onnat' ),
                        ],
                        'default'     => $this->default['cursor_style'],
                        'dependency'  => [ 'cursor', '==', 'true' ]
                    ],
                    [
                        'id'          => 'cursor_color',
                        'title'       => esc_html__( 'Default Cursor Color', 'onnat' ),
                        'type'        => 'select',
                        'attributes'  => [ 'style' => 'width:25%' ],
                        'options'     => $cursor_colors_opt,
                        'default'     => $this->default['cursor_color'],
                        'dependency'  => [ 'cursor', '==', 'true' ]
                    ],
                    [
                        'type'                   => 'group',
                        'id'                     => 'cursor_colors',
                        'title'                  => esc_html__( 'Cursor Colors', 'onnat'),
                        'accordion_title_prefix' => esc_html__( 'Cursor Color:', 'onnat'),
                        'accordion_title_number' => true,
                        'default'                => $this->default['cursor_colors'],
                        'dependency'             => [
                            ['cursor', '==', 'true'],
                            ['cursor_style', '!=', '' ],
                        ],
                        'fields'                 => [
                            [
                                'type'  => 'text',
                                'id'    => 'label',
                                'title' => esc_html__( 'Label', 'onnat'),
                            ],
                            [
                                'type'  => 'color',
                                'id'    => 'color',
                                'title' => esc_html__( 'Color', 'onnat'),
                            ]
                        ]
                    ],
                    [
                        'type'       => 'submessage',
                        'style'      => 'warning',
                        'title'      => '&nbsp;',
                        'content'    => esc_html__( 'The cursor color option is specifically designed to function with the Elementor plugin.', 'onnat' ),
                        'class'      => 'kinfw-margin-left',
                        'dependency' => [
                            ['cursor', '==', 'true'],
                            ['cursor_style', '!=', '' ],
                        ]
                    ],
                ]
            ] );

        }

        public function loader_settings() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'parent' => 'theme_styling_section',
                'title'  => esc_html__( 'Loader', 'onnat' ),
                'fields' => [
                    [
                        'id'      => 'loader',
                        'title'   => esc_html__( 'Use Page Loader', 'onnat' ),
                        'type'    => 'switcher',
                        'desc'    => esc_html('Use this option to toggle the page loader for website.', 'onnat' ),
                        'default' => $this->default['loader'],
                    ],
                    [
                        'id'          => 'loader_style',
                        'title'       => esc_html__( 'Loader Style', 'onnat' ),
                        'type'        => 'select',
                        'placeholder' => esc_html__( 'Select Spinner Style', 'onnat' ),
                        'attributes'  => [ 'style' => 'width:25%' ],
                        'options'     => [
                            'kinfw-pre-loader-circle kinfw-pre-loader-chasing-dots-1'       => esc_html__( 'Chasing Dot 1','onnat' ),
                            'kinfw-pre-loader-circle kinfw-pre-loader-chasing-dots-2'       => esc_html__( 'Chasing Dot 2','onnat' ),
                            'kinfw-pre-loader-circle kinfw-pre-loader-clock'                => esc_html__( 'Clock','onnat' ),
                            'kinfw-pre-loader-circle kinfw-pre-loader-fading-circle'        => esc_html__( 'Pulse','onnat' ),
                            'kinfw-pre-loader-circle kinfw-pre-loader-rotating-dots-circle' => esc_html__( 'Spinning Dots Inside Circle','onnat' ),
                            'kinfw-pre-loader-circle kinfw-pre-loader-spinning-circle-2'    => esc_html__( 'Spinning Circle Alt','onnat' ),
                            'kinfw-pre-loader-circle kinfw-pre-loader-spinning-circle'      => esc_html__( 'Spinning Circle','onnat' ),
                            'kinfw-pre-loader-circle kinfw-pre-loader-spinning-circles'     => esc_html__( 'Spinning Circles','onnat' ),
                            'kinfw-pre-loader-circle kinfw-pre-loader-spinning-line-1'      => esc_html__( 'Spinning Line','onnat' ),
                            'kinfw-pre-loader-circle kinfw-pre-loader-spinning-line-2'      => esc_html__( 'Spinning Line Duo','onnat' ),
                            'kinfw-pre-loader-spinning-dots'                                => esc_html__( 'Spinning Dots','onnat' ),
                            'kinfw-pre-loader-spinning-semi-circle'                         => esc_html__( 'Semi Circle','onnat' ),
                        ],
                        'default'     => $this->default['loader_style'],
                        'dependency'  => [ 'loader', '==', 'true' ]
                    ],
                    [
                        'type'       => 'submessage',
                        'style'      => 'warning',
                        'title'      => '&nbsp;',
                        'content'    => esc_html__( 'The border option is not applicable for this type.', 'onnat' ),
                        'class'      => 'kinfw-margin-left',
                        'dependency' => [
                            ['loader', '==', 'true'],
                            ['loader_style', '!=', '' ],
                            ['loader_style', 'any','kinfw-pre-loader-spinning-dots,kinfw-pre-loader-circle kinfw-pre-loader-fading-circle,kinfw-pre-loader-circle kinfw-pre-loader-chasing-dots-1,kinfw-pre-loader-circle kinfw-pre-loader-chasing-dots-2']
                        ]
                    ],
                    [
                        'id'         => 'loader_size',
                        'title'      => esc_html__( 'Loader Size', 'onnat' ),
                        'type'       => 'fieldset',
                        'dependency' => [
                            ['loader', '==', 'true'],
                            ['loader_style', '!=', '' ],

                        ],
                        'fields'     => [
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
                                                'id'      => 'lg_loader_size',
                                                'title'   => esc_html__('Loader','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'lg_border_size',
                                                'title'   => esc_html__('Border','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                        ]
                                    ],

                                    /**
                                     * Tabs
                                     */
                                    [
                                        'title'  => esc_html__('Tab','onnat'),
                                        'icon'   => 'fas fa-tablet-alt',
                                        'fields' => [
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'md_loader_size',
                                                'title'   => esc_html__('Loader','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'md_border_size',
                                                'title'   => esc_html__('Border','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
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
                                                'id'      => 'sm_loader_size',
                                                'title'   => esc_html__('Loader','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                            [
                                                'type'    => 'spinner',
                                                'id'      => 'sm_border_size',
                                                'title'   => esc_html__('Border','onnat'),
                                                'min'     => 10,
                                                'step'    => 1,
                                                'unit'    => 'px',
                                                'default' => '',
                                            ],
                                        ]
                                    ],

                                ]
                            ]
                        ],
                    ],
                    [
                        'id'         => 'loader_bg_color',
                        'title'      => esc_html__( 'Background Color', 'onnat' ),
                        'type'       => 'color',
                        'dependency' => [
                            ['loader', '==', 'true'],
                            ['loader_style', '!=', '' ],
                        ]
                    ],
                    [
                        'id'         => 'loader_primary_color',
                        'title'      => esc_html__( 'Primary Color', 'onnat' ),
                        'type'       => 'color',
                        'dependency' => [
                            ['loader', '==', 'true'],
                            ['loader_style', '!=', '' ],
                        ]
                    ],
                    [
                        'id'         => 'loader_secondary_color',
                        'title'      => esc_html__( 'Secondary Color', 'onnat' ),
                        'type'       => 'color',
                        'dependency' => [
                            ['loader', '==', 'true'],
                            ['loader_style', '!=', '' ],
                            ['loader_style', 'not-any', 'kinfw-pre-loader-spinning-dots,kinfw-pre-loader-circle kinfw-pre-loader-spinning-line-1,kinfw-pre-loader-circle kinfw-pre-loader-fading-circle,kinfw-pre-loader-spinning-semi-circle' ]
                        ],
                    ],
                    [
                        'id'         => 'loader_timeout',
                        'title'      => esc_html__( 'Timeout', 'onnat' ),
                        'type'       => 'slider',
                        'min'        => 100,
                        'step'       => 100,
                        'max'        => 3000,
                        'default'    => $this->default['loader_timeout'],
                        'dependency' => [
                            ['loader', '==', 'true'],
                            ['loader_style', '!=', '' ],
                        ]
                    ],
                ]
            ] );

        }

        public function sidebar_settings() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'parent' => 'theme_styling_section',
                'title'  => esc_html__( 'Sidebar', 'onnat' ),
                'fields' => [
                    [
                        'type'               => 'typography',
                        'id'                 => 'sidebar_title_typo',
                        'title'              => esc_html__( 'Title Typography', 'onnat'),
                        'multi_subset'       => true,
                        'extra_styles'       => true,
                        'preview'            => true,
                        'backup_font_family' => true,
                        'font_size'          => false,
                        'line_height'        => false,
                        'letter_spacing'     => false,
                        'output'             => apply_filters( 'kinfw-filter/theme/output/typo/sidebar/title', [ '.kinfw-sidebar-holder .widget .kinfw-widget-title' ] )
                    ],
                    [
                        'type'   => 'fieldset',
                        'id'     => 'sidebar_title_typo_size',
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
                        'id'                 => 'sidebar_content_typo',
                        'title'              => esc_html__( 'Content Typography', 'onnat'),
                        'multi_subset'       => true,
                        'extra_styles'       => true,
                        'preview'            => true,
                        'backup_font_family' => true,
                        'font_size'          => false,
                        'line_height'        => false,
                        'letter_spacing'     => false,
                        'output'             => apply_filters( 'kinfw-filter/theme/output/typo/sidebar/content', [ '.kinfw-sidebar-holder .widget .kinfw-widget-content' ] )
                    ],
                    [
                        'type'   => 'fieldset',
                        'id'     => 'sidebar_content_typo_size',
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
                        'id'    => 'sidebar_link_color',
                        'title' => esc_html__( 'Content Link Color', 'onnat' ),
                        'type'  => 'link_color',
                    ]
                ]
            ] );

        }

        public function heading_tag_settings() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'parent' => 'theme_styling_section',
                'title'  => esc_html__( 'Heading Tags', 'onnat' ),
                'fields' => [
                    [
                        'type'    => 'button_set',
                        'id'      => 'h1_tag_typo_type',
                        'title'   => esc_html__('H1 Tag Typography?','onnat'),
                        'options' => [
                            'primary'   => esc_html__('Primary Font','onnat'),
                            'secondary' => esc_html__('Secondary Font','onnat'),
                            'custom'    => esc_html__('Custom Font','onnat'),
                        ],
                        'default' => $this->default['h1_tag_typo_type']
                    ],

                    /**
                     * H1 Tag
                     */
                    [
                        'type'               => 'typography',
                        'id'                 => 'h1_tag_typo',
                        'title'              => esc_html__( 'H1 Tag Custom Typography', 'onnat'),
                        'multi_subset'       => true,
                        'extra_styles'       => true,
                        'preview'            => true,
                        'backup_font_family' => true,
                        'font_size'          => false,
                        'line_height'        => false,
                        'letter_spacing'     => false,
                        'text_align'         => false,
                        'text_transform'     => false,
                        'default'            => $this->default['h1_tag_typo'],
                        'dependency'         => [ 'h1_tag_typo_type', '==', 'custom' ],

                    ],
                    [
                        'type'   => 'fieldset',
                        'id'     => 'h1_tag_typo_size',
                        'title'  => '&nbsp;',
                        'fields' => [
                            [
                                'type'    => 'subheading',
                                'content' => esc_html__( 'H1 Tag Font Style', 'onnat'),
                            ],
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

                    /**
                     * H2 Tag
                     */
                    [
                        'type'    => 'button_set',
                        'id'      => 'h2_tag_typo_type',
                        'title'   => esc_html__('H2 Tag Typography?','onnat'),
                        'options' => [
                            'primary'   => esc_html__('Primary Font','onnat'),
                            'secondary' => esc_html__('Secondary Font','onnat'),
                            'custom'    => esc_html__('Custom Font','onnat'),
                        ],
                        'default' => $this->default['h2_tag_typo_type']
                    ],
                    [
                        'type'               => 'typography',
                        'id'                 => 'h2_tag_typo',
                        'title'              => esc_html__( 'H2 Tag Custom Typography', 'onnat'),
                        'multi_subset'       => true,
                        'extra_styles'       => true,
                        'preview'            => true,
                        'backup_font_family' => true,
                        'font_size'          => false,
                        'line_height'        => false,
                        'letter_spacing'     => false,
                        'text_align'         => false,
                        'text_transform'     => false,
                        'default'            => $this->default['h2_tag_typo'],
                        'dependency'         => [ 'h2_tag_typo_type', '==', 'custom' ],
                    ],
                    [
                        'type'   => 'fieldset',
                        'id'     => 'h2_tag_typo_size',
                        'title'  => '&nbsp;',
                        'fields' => [
                            [
                                'type'    => 'subheading',
                                'content' => esc_html__( 'H2 Tag Font Style', 'onnat'),
                            ],
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

                    /**
                     * H3 Tag
                     */
                    [
                        'type'    => 'button_set',
                        'id'      => 'h3_tag_typo_type',
                        'title'   => esc_html__('H3 Tag Typography?','onnat'),
                        'options' => [
                            'primary'   => esc_html__('Primary Font','onnat'),
                            'secondary' => esc_html__('Secondary Font','onnat'),
                            'custom'    => esc_html__('Custom Font','onnat'),
                        ],
                        'default' => $this->default['h3_tag_typo_type']
                    ],
                    [
                        'type'               => 'typography',
                        'id'                 => 'h3_tag_typo',
                        'title'              => esc_html__( 'H3 Tag Custom Typography', 'onnat'),
                        'multi_subset'       => true,
                        'extra_styles'       => true,
                        'preview'            => true,
                        'backup_font_family' => true,
                        'font_size'          => false,
                        'line_height'        => false,
                        'letter_spacing'     => false,
                        'text_align'         => false,
                        'text_transform'     => false,
                        'default'            => $this->default['h3_tag_typo'],
                        'dependency'         => [ 'h3_tag_typo_type', '==', 'custom' ],

                    ],
                    [
                        'type'   => 'fieldset',
                        'id'     => 'h3_tag_typo_size',
                        'title'  => '&nbsp;',
                        'fields' => [
                            [
                                'type'    => 'subheading',
                                'content' => esc_html__( 'H3 Tag Font Style', 'onnat'),
                            ],
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

                    /**
                     * H4 Tag
                     */
                    [
                        'type'    => 'button_set',
                        'id'      => 'h4_tag_typo_type',
                        'title'   => esc_html__('H4 Tag Typography?','onnat'),
                        'options' => [
                            'primary'   => esc_html__('Primary Font','onnat'),
                            'secondary' => esc_html__('Secondary Font','onnat'),
                            'custom'    => esc_html__('Custom Font','onnat'),
                        ],
                        'default' => $this->default['h4_tag_typo_type']
                    ],
                    [
                        'type'               => 'typography',
                        'id'                 => 'h4_tag_typo',
                        'title'              => esc_html__( 'H4 Tag Custom Typography', 'onnat'),
                        'multi_subset'       => true,
                        'extra_styles'       => true,
                        'preview'            => true,
                        'backup_font_family' => true,
                        'font_size'          => false,
                        'line_height'        => false,
                        'letter_spacing'     => false,
                        'text_align'         => false,
                        'text_transform'     => false,
                        'default'            => $this->default['h4_tag_typo'],
                        'dependency'         => [ 'h4_tag_typo_type', '==', 'custom' ],
                    ],
                    [
                        'type'   => 'fieldset',
                        'id'     => 'h4_tag_typo_size',
                        'title'  => '&nbsp;',
                        'fields' => [
                            [
                                'type'    => 'subheading',
                                'content' => esc_html__( 'H4 Tag Font Style', 'onnat'),
                            ],
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

                    /**
                     * H5 Tag
                     */
                    [
                        'type'    => 'button_set',
                        'id'      => 'h5_tag_typo_type',
                        'title'   => esc_html__('H5 Tag Typography?','onnat'),
                        'options' => [
                            'primary'   => esc_html__('Primary Font','onnat'),
                            'secondary' => esc_html__('Secondary Font','onnat'),
                            'custom'    => esc_html__('Custom Font','onnat'),
                        ],
                        'default' => $this->default['h5_tag_typo_type']
                    ],
                    [
                        'type'               => 'typography',
                        'title'              => esc_html__( 'H5 Tag Custom Typography', 'onnat'),
                        'id'                 => 'h5_tag_typo',
                        'multi_subset'       => true,
                        'extra_styles'       => true,
                        'preview'            => true,
                        'backup_font_family' => true,
                        'font_size'          => false,
                        'line_height'        => false,
                        'letter_spacing'     => false,
                        'text_align'         => false,
                        'text_transform'     => false,
                        'default'            => $this->default['h5_tag_typo'],
                        'dependency'         => [ 'h5_tag_typo_type', '==', 'custom' ],
                    ],
                    [
                        'type'   => 'fieldset',
                        'id'     => 'h5_tag_typo_size',
                        'title'  => '&nbsp;',
                        'fields' => [
                            [
                                'type'    => 'subheading',
                                'content' => esc_html__( 'H5 Tag Font Style', 'onnat'),
                            ],
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

                    /**
                     * H6 Tag
                     */
                    [
                        'type'    => 'button_set',
                        'id'      => 'h6_tag_typo_type',
                        'title'   => esc_html__('H6 Tag Typography?','onnat'),
                        'options' => [
                            'primary'   => esc_html__('Primary Font','onnat'),
                            'secondary' => esc_html__('Secondary Font','onnat'),
                            'custom'    => esc_html__('Custom Font','onnat'),
                        ],
                        'default' => $this->default['h6_tag_typo_type']
                    ],
                    [
                        'type'               => 'typography',
                        'id'                 => 'h6_tag_typo',
                        'title'              => esc_html__( 'H6 Tag Custom Typography', 'onnat'),
                        'multi_subset'       => true,
                        'extra_styles'       => true,
                        'preview'            => true,
                        'backup_font_family' => true,
                        'font_size'          => false,
                        'line_height'        => false,
                        'letter_spacing'     => false,
                        'text_align'         => false,
                        'text_transform'     => false,
                        'default'            => $this->default['h6_tag_typo'],
                        'dependency'         => [ 'h6_tag_typo_type', '==', 'custom' ],
                    ],
                    [
                        'type'   => 'fieldset',
                        'id'     => 'h6_tag_typo_size',
                        'title'  => '&nbsp;',
                        'fields' => [
                            [
                                'type'    => 'subheading',
                                'content' => esc_html__( 'H6 Tag Font Style', 'onnat'),
                            ],
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
                ]
            ] );

        }

        public function scroll_to_top_settings() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'parent' => 'theme_styling_section',
                'title'  => esc_html__( 'Scroll To Top', 'onnat' ),
                'fields' => [
                    [
                        'id'      => 'to_top',
                        'title'   => esc_html__( 'Use Scroll To Top', 'onnat' ),
                        'type'    => 'switcher',
                        'desc'    => esc_html('Use this option to toggle the scroll to top element for website.', 'onnat' ),
                        'default' => $this->default['to_top'],
                    ],
                    [
                        'id'         => 'to_top_icon',
                        'title'      => esc_html__( 'Icon', 'onnat' ),
                        'type'       => 'button_set',
                        'options'    => [
                            'onnat-line-arrow-long-right-cross kinfw-icon-rotate-320' => '<i class="fa fa-gear"></i>',
                            'misc-sort-up-solid'                                       => '<i class="fas fa-sort-up"></i>',
                            'arrows-corner-right-up'                                   => '<i class="fas fa-level-up-alt"></i>',
                            'chevron-simple-up'                                        => '<i class="fas fa-chevron-up"></i>',
                            'arrows-simple-up'                                         => '<i class="fas fa-arrow-up"></i>',
                            'hand-point-up-regular'                                    => '<i class="fas fa-hand-point-up"></i>',
                            'hand-point-up-solid'                                      => '<i class="far fa-hand-point-up"></i>',
                            'chevron-circle-solid-up'                                  => '<i class="fas fa-chevron-circle-up"></i>',
                            'arrows-circle-solid-up'                                   => '<i class="fas fa-arrow-circle-up"></i>',
                            'chevrons-up'                                              => '<i class="fas fa-angle-double-up"></i>',
                            'arrows-long-up'                                           => '<i class="fas fa-long-arrow-alt-up"></i>',
                            'arrows-circle-up'                                         => '<i class="far fa-arrow-alt-circle-up"></i>',
                        ],
                        'default'    => $this->default['to_top_icon'],
                        'dependency' => [ 'to_top', '==', 'true' ]
                    ],
                    [
                        'id'         => 'to_top_dir',
                        'title'      => esc_html__( 'Direction', 'onnat' ),
                        'type'       => 'button_set',
                        'options'    => [
                            'left'  => esc_html__( 'left','onnat' ),
                            'right' => esc_html__( 'right','onnat' ),
                        ],
                        'default'    => $this->default['to_top_dir'],
                        'dependency' => [ 'to_top', '==', 'true' ]
                    ],
                    [
                        'id'         => 'to_top_bg_color',
                        'title'      => esc_html__( 'Background Color', 'onnat' ),
                        'type'       => 'link_color',
                        'dependency' => [ 'to_top', '==', 'true' ],
                        'default'    => $this->default['to_top_bg_color'],
                    ],
                    [
                        'id'         => 'to_top_icon_color',
                        'title'      => esc_html__( 'Icon Color', 'onnat' ),
                        'type'       => 'link_color',
                        'dependency' => [ 'to_top', '==', 'true' ],
                        'default'    => $this->default['to_top_icon_color'],
                    ],
                    [
                        'id'         => 'to_top_speed',
                        'title'      => esc_html__( 'Speed', 'onnat' ),
                        'type'       => 'slider',
                        'min'        => 100,
                        'step'       => 100,
                        'max'        => 3000,
                        'default'    => $this->default['to_top_speed'],
                        'dependency' => [ 'to_top', '==', 'true' ]
                    ]
                ]
            ] );
        }

        public function scroll_bar_settings() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'parent' => 'theme_styling_section',
                'title'  => esc_html__( 'Scroll Bar', 'onnat' ),
                'fields' => [
                    [
                        'id'      => 'scroll_bar',
                        'title'   => esc_html__( 'Activate Custom Scroll Bar', 'onnat' ),
                        'type'    => 'switcher',
                        'default' => $this->default['scroll_bar'],
                        'desc'    => esc_html('Use this option to toggle the custom scroll bar element for website.', 'onnat' ),
                    ],
                    [
                        'id'         => 'scroll_bar_color',
                        'title'      => esc_html__( 'Scroll Bar Color', 'onnat' ),
                        'type'       => 'color',
                        'default'    => $this->default['scroll_bar_color'],
                        'dependency' => [ 'scroll_bar', '==', 'true' ]
                    ],
                    [
                        'id'         => 'scroll_bar_bg_color',
                        'title'      => esc_html__( 'Scroll Bar Background Color', 'onnat' ),
                        'type'       => 'link_color',
                        'default'    => $this->default['scroll_bar_bg_color'],
                        'dependency' => [ 'scroll_bar', '==', 'true' ]
                    ],
                    [
                        'id'         => 'scroll_auto_hide',
                        'title'      => esc_html__( 'Auto Hide Scroll Bar', 'onnat' ),
                        'type'       => 'switcher',
                        'default'    => $this->default['scroll_auto_hide'],
                        'desc'       => esc_html('Use this option to toggle the scroll bar visibility for website.', 'onnat' ),
                        'dependency' => [ 'scroll_bar', '==', 'true' ]
                    ],
                    [
                        'type'       => 'spinner',
                        'id'         => 'scroll_bar_width',
                        'title'      => esc_html__('Scroll Bar Width','onnat'),
                        'min'        => 5,
                        'max'        => 25,
                        'step'       => 1,
                        'unit'       => 'px',
                        'default'    => $this->default['scroll_bar_width'],
                        'dependency' => [ 'scroll_bar', '==', 'true' ]
                    ],
                    [
                        'type'       => 'spinner',
                        'id'         => 'scroll_bar_border_radius',
                        'title'      => esc_html__('Scroll Bar Border Radius','onnat'),
                        'min'        => 5,
                        'max'        => 25,
                        'step'       => 1,
                        'unit'       => 'px',
                        'default'    => $this->default['scroll_bar_border_radius'],
                        'dependency' => [ 'scroll_bar', '==', 'true' ]
                    ],
                ]
            ] );

        }

        public function menu_settings() {
            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'parent'      => 'theme_styling_section',
                'title'       => esc_html__( 'Menu Labels', 'onnat' ),
                'description' => sprintf( '<img src="%1$s" alt="%2$s" title="%2$s"/>',
                    ONNAT_CONST_THEME_DIR_URI . '/assets/image/admin/site-options/menu-labels.svg',
                    esc_attr__( 'Menu Labels', 'onnat')
                ),
                'fields'      => [
                    [
                        'type'                   => 'group',
                        'id'                     => 'menu_labels',
                        'title'                  => esc_html__( 'Menu Labels', 'onnat'),
                        'accordion_title_prefix' => esc_html__( 'Menu Label:', 'onnat'),
                        'accordion_title_number' => true,
                        'default'                => $this->default['menu_labels'],
                        'fields'                 => [
                            [
                                'type'  => 'text',
                                'id'    => 'label',
                                'title' => esc_html__( 'Label', 'onnat'),
                            ],
                            [
                                'type'    => 'color_group',
                                'id'      => 'colors',
                                'title'   => esc_html__( 'Colors', 'onnat'),
                                'options' => [
                                    'label' => esc_html__( 'Label', 'onnat' ),
                                    'bg'    => esc_html__( 'Background', 'onnat' ),
                                ]
                            ]
                        ]
                    ]
                ],
            ] );
        }

        public function defaults( $defaults = [] ) {

            /**
             * Skin
             */
                $defaults['skin_primary_color']           = '#111111';
                $defaults['skin_secondary_color']         = '#111111';
                $defaults['skin_secondary_opacity_color'] = 'rgba(17,17,17,0.2)';
                $defaults['skin_tertiary_color']          = '#e4e4e4';
                $defaults['skin_accent_color']            = '#ff292b';
                $defaults['skin_light_color']             = '#464946';
                $defaults['skin_white_color']             = '#ffffff';
                $defaults['skin_bg_light_color']          = '#f8f8f8';

            /**
             * Global Typography
             */
                $defaults['primary_typo'] = [
                    'type'               => 'google',
                    'font-family'        => 'Kanit',
                    'backup-font-family' => "'Arial Black', Gadget, sans-serif",
                    'font-weight'        => '600',
                    'color'              => '#111111',
                    'subset'             => [ 'latin-ext' ],
                    'extra-styles'       => []
                ];

                $defaults['secondary_typo']   = [
                    'type'               => 'google',
                    'font-family'        => 'DM Sans',
                    'backup-font-family' => "'Arial Black', Gadget, sans-serif",
                    'font-weight'        => 'normal',
                    'color'              => '#464946',
                    'subset'             => [ 'cyrillic', 'hebrew' ],
                    'extra-styles'       => [ '600' ]
                ];

            /**
             * Site Styling
             */
                $defaults['layout']                   = 'kinfw-wide-layout';
                $defaults['cursor']                   = true;
                $defaults['cursor_style']             = 'kinfw-cursor-dot';
                $defaults['loader']                   = true;
                $defaults['cursor_color']             = 'kinfw-cursor-accent-color';
                $defaults['cursor_colors']            = [
                    [
                        'label'  => esc_html__('Black', 'onnat' ),
                        'color' => '#000000'
                    ],
                    [
                        'label'  => esc_html__('White', 'onnat' ),
                        'color' => '#ffffff'
                    ],
                ];
                $defaults['loader_style']             = 'kinfw-pre-loader-circle kinfw-pre-loader-spinning-circle';
                $defaults['loader_timeout']           = 500;

                $defaults['to_top']                   = true;
                $defaults['to_top_icon']              = 'onnat-line-arrow-long-right-cross kinfw-icon-rotate-320';
                $defaults['to_top_dir']               = 'right';
                $defaults['to_top_speed']             = 700;
                $defaults['to_top_bg_color']          = [
                    'color' => '#ff292b',
                    'hover' => '#111111',
                ];
                $defaults['to_top_icon_color']        = [
                    'color' => '#ffffff',
                    'hover' => '#ffffff',
                ];
                $defaults['scroll_bar'] = false;
                $defaults['scroll_bar_bg_color']      = [ 'color' => '#fff4f4', 'hover' => '#000000' ];
                $defaults['scroll_bar_color']         = '#ffbc13';
                $defaults['scroll_auto_hide']         = true;
                $defaults['scroll_bar_width']         = 7;
                $defaults['scroll_bar_border_radius'] = 15;
                $defaults['menu_labels']              = [
                    [
                        'label'  => esc_html__('New', 'onnat' ),
                        'colors' => [
                            'label' => '#ffffff',
                            'bg'    => '#32d1c4'
                        ]
                    ]
                ];

                $defaults['body_typo_type']  = 'secondary';
                $defaults['body_typo']       = [];
                $defaults['body_link_color'] = [
                    'color' => '',
                    'hover' => ''
                ];

                $defaults['h1_tag_typo_type']  = 'primary';
                $defaults['h1_tag_typo'] = [];

                $defaults['h2_tag_typo_type']  = 'primary';
                $defaults['h2_tag_typo'] = [];

                $defaults['h3_tag_typo_type']  = 'primary';
                $defaults['h3_tag_typo'] = [];

                $defaults['h4_tag_typo_type']  = 'primary';
                $defaults['h4_tag_typo'] = [];

                $defaults['h5_tag_typo_type']  = 'primary';
                $defaults['h5_tag_typo'] = [];

                $defaults['h6_tag_typo_type']  = 'primary';
                $defaults['h6_tag_typo'] = [];

            return $defaults;
        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_options_styling' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_options_styling() {

        return Onnat_Theme_Options_Styling::get_instance();
    }
}

kinfw_onnat_theme_options_styling();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */