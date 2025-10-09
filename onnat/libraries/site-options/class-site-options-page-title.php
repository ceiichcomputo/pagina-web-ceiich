<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Options_Page_Title' ) ) {

	/**
	 * The Onnat theme page title ( breadcrumb ) options setup class.
	 */
    class Onnat_Theme_Options_Page_Title {

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
                $this->title_settings();
                $this->breadcrumb_settings();

            do_action( 'kinfw-action/theme/site-options/page-title/loaded' );

        }

        public function init_settings() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'id'    => 'theme_page_title_section',
                'title' => esc_html__( 'Page Title', 'onnat' ),
            ] );

        }

        public function title_settings() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'parent' => 'theme_page_title_section',
                'title'  => esc_html__( 'Page Title', 'onnat' ),
                'fields' => [
                    [
                        'type'    => 'switcher',
                        'id'      => 'page_title',
                        'title'   => esc_html__( 'Page Title', 'onnat'),
                        'desc'    => esc_html__( 'Default page title for your site.', 'onnat' ),
                        'default' => $this->default['page_title'],
                    ],
                    [
                        'type'       => 'button_set',
                        'id'         => 'page_title_tag',
                        'title'      => esc_html__('HTML Tag?','onnat'),
                        'options'    => [
                            'h1' => 'H1',
                            'h2' => 'H2',
                            'h3' => 'H3',
                            'h4' => 'H4',
                            'h5' => 'H5',
                            'h6' => 'H6',
                            'div' => 'div',
                        ],
                        'default'    => $this->default['page_title_tag'],
                    ],
                    [
                        'type'       => 'button_set',
                        'id'         => 'page_title_alignment',
                        'title'      => esc_html__('Alignment','onnat'),
                        'options'    => [
                            'kinfw-page-title-align-left'   => esc_html__('Left','onnat'),
                            'kinfw-page-title-align-center' => esc_html__('Center','onnat'),
                            'kinfw-page-title-align-right'  => esc_html__('Right','onnat'),
                            'kinfw-page-title-align-inline' => esc_html__('Inline','onnat'),
                        ],
                        'default'    => $this->default['page_title_alignment'],
                    ],
                    [
                        'type'     => 'switcher',
                        'id'       => 'use_page_title_full_width',
                        'title'    => esc_html__( 'Use Full Width', 'onnat'),
                        'subtitle' => esc_html__( 'Turn on to have the full width page title for your site.', 'onnat'),
                        'default'  => $this->default['use_page_title_full_width'],
                    ],
                    [
                        'type'       => 'switcher',
                        'id'         => 'use_page_title_background',
                        'title'      => esc_html__( 'Use Background', 'onnat'),
                        'default'    => $this->default['use_page_title_background'],
                    ],
                    [
                        'type'       => 'background',
                        'id'         => 'page_title_background',
                        'title'      => esc_html__( 'Background', 'onnat'),
                        'dependency' => [ 'use_page_title_background', '==', 'true' ],
                        'default'    => $this->default['page_title_background'],
                    ],
                    [
                        'type'       => 'color',
                        'id'         => 'page_title_overlay',
                        'title'      => esc_html__( 'Background Overlay', 'onnat'),
                        'dependency' => [ 'use_page_title_background', '==', 'true' ],
                        'default'    => $this->default['page_title_overlay'],
                    ],
                    [
                        'type'  => 'tabbed',
                        'id'    => 'page_title_spacing',
                        'title' => esc_html__( 'Spacing', 'onnat'),
                        'tabs'  => [
                            /**
                             * Desktop
                             */
                            [
                                'title'  => esc_html__('Desktop','onnat'),
                                'icon'   => 'fas fa-desktop',
                                'fields' => [
                                    [
                                        'id'    => 'lg_padding',
                                        'type'  => 'spacing',
                                        'title' => esc_html('Padding', 'onnat' ),
                                        'left'  => false,
                                        'right' => false,
                                        'units' => [ 'px' ]
                                    ],
                                    [
                                        'id'    => 'lg_margin',
                                        'type'  => 'spacing',
                                        'title' => esc_html('Margin', 'onnat' ),
                                        'top'   => false,
                                        'left'  => false,
                                        'right' => false,
                                        'units' => [ 'px' ]
                                    ]
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
                                        'id'    => 'md_height',
                                        'type'  => 'dimensions',
                                        'title' => esc_html('Height', 'onnat' ),
                                        'width' => false,
                                        'units' => [ 'px' ]
                                    ],
                                    [
                                        'id'    => 'md_padding',
                                        'type'  => 'spacing',
                                        'title' => esc_html('Padding', 'onnat' ),
                                        'left'  => false,
                                        'right' => false,
                                        'units' => [ 'px' ]
                                    ],
                                    [
                                        'id'    => 'md_margin',
                                        'type'  => 'spacing',
                                        'title' => esc_html('Margin', 'onnat' ),
                                        'top'   => false,
                                        'left'  => false,
                                        'right' => false,
                                        'units' => [ 'px' ]
                                    ]
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
                                        'id'    => 'sm_height',
                                        'type'  => 'dimensions',
                                        'title' => esc_html('Height', 'onnat' ),
                                        'width' => false,
                                        'units' => [ 'px' ]
                                    ],
                                    [
                                        'id'    => 'sm_padding',
                                        'type'  => 'spacing',
                                        'title' => esc_html('Padding', 'onnat' ),
                                        'left'  => false,
                                        'right' => false,
                                        'units' => [ 'px' ]
                                    ],
                                    [
                                        'id'    => 'sm_margin',
                                        'type'  => 'spacing',
                                        'title' => esc_html('Margin', 'onnat' ),
                                        'top'   => false,
                                        'left'  => false,
                                        'right' => false,
                                        'units' => [ 'px' ]
                                    ]
                                ]
                            ],
                        ]
                    ],
                    [
                        'type'               => 'typography',
                        'id'                 => 'page_title_typo',
                        'title'              => esc_html__( 'Typography', 'onnat'),
                        'backup_font_family' => true,
                        'font_size'          => false,
                        'line_height'        => false,
                        'letter_spacing'     => false,
                        'text_align'         => false,
                        'output'             => apply_filters( 'kinfw-filter/theme/output/typo/page-title', [ '#kinfw-title-wrap > *' ]  )
                    ],
                    [
                        'type'   => 'fieldset',
                        'id'     => 'page_title_typo_size',
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
                ]
            ] );

        }

        public function breadcrumb_settings() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'parent' => 'theme_page_title_section',
                'title'  => esc_html__( 'Breadcrumb', 'onnat' ),
                'fields' => [
                    [
                        'type'    => 'switcher',
                        'id'      => 'breadcrumb',
                        'title'   => esc_html__( 'Breadcrumbs Block', 'onnat'),
                        'desc'    => esc_html__( 'Default breadcrumbs block for your site.', 'onnat' ),
                        'default' => $this->default['breadcrumb'],
                    ],
                    [
                        'type'    => 'text',
                        'id'      => 'breadcrumb_separator',
                        'title'   => esc_html__( 'Breadcrumbs Separator', 'onnat'),
                        'desc'    => esc_html__( 'Default breadcrumbs separator for your site.', 'onnat' ),
                        'default' => $this->default['breadcrumb_separator'],
                    ],
                    [
                        'type'       => 'button_set',
                        'id'         => 'breadcrumb_alignment',
                        'title'      => esc_html__('Alignment','onnat'),
                        'dependency' => [ 'page_title_alignment', '!=', 'kinfw-page-title-align-inline', true ],
                        'options'    => [
                            'kinfw-breadcrumb-align-left' => esc_html__('Left','onnat'),
                            'kinfw-breadcrumb-align-center' => esc_html__('Center','onnat'),
                            'kinfw-breadcrumb-align-right'  => esc_html__('Right','onnat'),
                        ],
                        'default'    => $this->default['breadcrumb_alignment'],
                    ],
                    [
                        'type'               => 'typography',
                        'id'                 => 'breadcrumb_typo',
                        'title'              => esc_html__( 'Typography', 'onnat'),
                        'backup_font_family' => true,
                        'font_size'          => false,
                        'line_height'        => false,
                        'letter_spacing'     => false,
                        'text_align'         => false,
                        'output'             => apply_filters( 'kinfw-filter/theme/output/typo/breadcrumb', [ '#kinfw-title-holder #kinfw-breadcrumb-wrap' ] )
                    ],
                    [
                        'id'     => 'breadcrumb_link_color',
                        'title'  => esc_html__( 'Link Color', 'onnat' ),
                        'type'   => 'link_color',
                    ],
                    [
                        'type'   => 'fieldset',
                        'id'     => 'breadcrumb_typo_size',
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
                                ],
                            ],
                        ]
                    ],
                ]
            ] );

        }

        public function defaults( $defaults = [] ) {

            /**
             * Page Title
             */
                $defaults['page_title']                = true;
                $defaults['page_title_tag']            = 'h1';
                $defaults['page_title_alignment']      = 'kinfw-page-title-align-left';
                $defaults['use_page_title_full_width'] = false;
                $defaults['use_page_title_background'] = false;
                $defaults['page_title_background']     = [];
                $defaults['page_title_overlay']        = '';

            /**
             * Breadcrumb
             */
                $defaults['breadcrumb']           = true;
                $defaults['breadcrumb_separator'] =  '/';
                $defaults['breadcrumb_alignment'] =  'kinfw-breadcrumb-align-left';

            return $defaults;
        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_options_page_title' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_options_page_title() {

        return Onnat_Theme_Options_Page_Title::get_instance();
    }
}

kinfw_onnat_theme_options_page_title();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */