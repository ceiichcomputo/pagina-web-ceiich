<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Options_General' ) ) {

	/**
	 * The Onnat theme general options setup class.
	 */
    class Onnat_Theme_Options_General {

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
                $this->logo_settings();
                $this->favicon_settings();
                $this->header_settings();
                $this->footer_settings();

            do_action( 'kinfw-action/theme/site-options/general/loaded' );

        }

        public function init_settings() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'id'    => 'theme_general_section',
                'title' => esc_html__( 'General', 'onnat' ),
            ] );
        }

        public function logo_settings() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'parent' => 'theme_general_section',
                'title'  => esc_html__( 'Logo', 'onnat' ),
                'fields' => [
                    [
                        'id'      => 'logo',
                        'title'   => esc_html__( 'Logo', 'onnat' ),
                        'type'    => 'media',
                        'url'     => false,
                        'library' => 'image',
                        'desc'    => esc_html__( 'Default logo for your site.', 'onnat' ),
                        'default' => $this->default['logo'],
                    ],
                    [
                        'id'      => 'logo_alt',
                        'title'   => esc_html__( 'Alternate Logo', 'onnat' ),
                        'type'    => 'media',
                        'url'     => false,
                        'library' => 'image',
                        'desc'    => esc_html__( 'Default alternate logo for your site.', 'onnat' ),
                        'default' => $this->default['logo_alt'],
                    ],
                    [
                        'id'      => 'logo_sticky',
                        'title'   => esc_html__( 'Sticky Logo', 'onnat' ),
                        'type'    => 'media',
                        'url'     => false,
                        'library' => 'image',
                        'desc'    => esc_html__( 'Add sticky header logo for your site.', 'onnat' ),
                        'default' => $this->default['logo_sticky'],
                    ],
                    [
                        'id'      => 'logo_mobile',
                        'title'   => esc_html__( 'Mobile Logo', 'onnat' ),
                        'type'    => 'media',
                        'url'     => false,
                        'library' => 'image',
                        'desc'    => esc_html__( 'Add mobile logo for your site.', 'onnat' ),
                        'default' => $this->default['logo_mobile'],
                    ],
                ]
            ] );
        }

        public function favicon_settings() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'parent' => 'theme_general_section',
                'title'  => esc_html__( 'Favicon(s)', 'onnat' ),
                'fields' => [
                    [
                        'id'      => 'favicon_32',
                        'title'   => esc_html__( 'Favicon', 'onnat' ),
                        'type'    => 'media',
                        'url'     => false,
                        'library' => 'image',
                        'desc'    => esc_html__( 'Favicon for you site at 32px * 32px size.', 'onnat' ),
                        'default' => $this->default['favicon_32'],
                    ],
                    [
                        'id'      => 'favicon_192',
                        'title'   => esc_html__( 'Favicon', 'onnat' ),
                        'type'    => 'media',
                        'url'     => false,
                        'library' => 'image',
                        'desc'    => esc_html__( 'Favicon for you site at 192px * 192px size.', 'onnat' ),
                        'default' => $this->default['favicon_192'],
                    ],
                    [
                        'id'      => 'favicon_180',
                        'title'   => esc_html__( 'Apple Touch Icon', 'onnat' ),
                        'type'    => 'media',
                        'url'     => false,
                        'library' => 'image',
                        'desc'    => esc_html__( 'Apple Touch Icon for you site at 180px * 180px size.', 'onnat' ),
                        'default' => $this->default['favicon_180'],
                    ],
                    [
                        'id'      => 'favicon_270',
                        'title'   => esc_html__( 'MS Tile Image', 'onnat' ),
                        'type'    => 'media',
                        'url'     => false,
                        'library' => 'image',
                        'desc'    => esc_html__( 'Microsoft tile image for you site at 270px * 270px size.', 'onnat' ),
                        'default' => $this->default['favicon_270'],
                    ]
                ]
            ] );

        }

        public function header_settings() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'parent' => 'theme_general_section',
                'title'  => esc_html__( 'Header', 'onnat' ),
                'fields' => [
                    [
                        'type'    => 'subheading',
                        'content' => esc_html__( 'Default Header Style', 'onnat' ),
                    ],
                    [
                        'type'    => 'submessage',
                        'style'   => 'info',
                        'content' => esc_html__( 'Select default header layout style. You can change the layout of each page / post when editing it.', 'onnat' ),
                    ],
                    [
                        'id'      => 'default_header',
                        'type'    => 'image_select',
                        'attributes' => [
                            'style'    => 'float:left;clear:both;max-width:100%;'
                        ],
                        'options' => [
                            'standard_header'            => ONNAT_CONST_THEME_DIR_URI . '/assets/image/admin/site-options/standard-header.svg',
                            'transparent_header'         => ONNAT_CONST_THEME_DIR_URI . '/assets/image/admin/site-options/transparent-header.svg',
                            'top_bar_standard_header'    => ONNAT_CONST_THEME_DIR_URI . '/assets/image/admin/site-options/top-bar-standard-header.svg',
                            'top_bar_transparent_header' => ONNAT_CONST_THEME_DIR_URI . '/assets/image/admin/site-options/top-bar-transparent-header.svg',
                            'cascade_header'             => ONNAT_CONST_THEME_DIR_URI . '/assets/image/admin/site-options/cascade-header.svg',
                            'elementor_header'           => ONNAT_CONST_THEME_DIR_URI . '/assets/image/admin/site-options/elementor-header-template.svg',
                        ],
                        'default' => $this->default['default_header'],
                    ],
                    [
                        'id'          => 'elementor_header',
                        'type'        => 'select',
                        'title'       => esc_html__('Select Custom Header', 'onnat' ),
                        'dependency'  => [ 'default_header', '==', 'elementor_header' ],
                        'placeholder' => esc_html__('Choose Header', 'onnat' ),
                        'attributes'  => [
                            'style' => 'width:25%'
                        ],
                        'options'     => 'posts',
                        'query_args'  => [
                            'post_type'      => 'kinfw-header',
                            'posts_per_page' => -1,
                            'post_status'    => 'publish',
                            'order'          => 'ASC',
                            'orderby'        => 'title'
                        ],
                        'default'     => '',
                    ],
                ]
            ] );

        }

        public function footer_settings() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'parent' => 'theme_general_section',
                'title'  => esc_html__( 'Footer', 'onnat' ),
                'fields' => [
                    [
                        'type'    => 'subheading',
                        'content' => esc_html__( 'Default Footer Style', 'onnat'),
                    ],
                    [
                        'type'    => 'submessage',
                        'style'   => 'info',
                        'content' => esc_html__( 'Select default footer layout style. You can change the layout of each page / post when editing it.', 'onnat'),
                    ],
                    [
                        'id'      => 'default_footer',
                        'type'    => 'image_select',
                        'attributes' => [
                            'style'    => 'float:left;clear:both;max-width:100%;'
                        ],
                        'options' => [
                            'standard_footer'   => ONNAT_CONST_THEME_DIR_URI . '/assets/image/admin/site-options/standard-footer.svg',
                            'footer_preset_two' => ONNAT_CONST_THEME_DIR_URI . '/assets/image/admin/site-options/footer-preset-two.svg',
                            'elementor_footer'  => ONNAT_CONST_THEME_DIR_URI . '/assets/image/admin/site-options/elementor-footer-template.svg',
                        ],
                        'default' => $this->default['default_footer'],
                    ],
                    [
                        'id'          => 'elementor_footer',
                        'type'        => 'select',
                        'title'       => esc_html__('Select Custom Footer', 'onnat' ),
                        'dependency'  => [ 'default_footer', '==', 'elementor_footer' ],
                        'placeholder' => esc_html__('Choose Footer', 'onnat' ),
                        'attributes'  => [
                            'style' => 'width:25%'
                        ],
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

                ]
            ] );

        }

        public function defaults( $defaults = [] ) {

            /**
             * Logos
             */
                $defaults['logo']        = [
                    'url'       => esc_url( get_theme_file_uri( 'assets/image/public/logo.svg' ) ),
                    'thumbnail' => esc_url( get_theme_file_uri( 'assets/image/public/logo.svg' ) ),
                    'alt'       => get_bloginfo( 'name', 'display' ),
                    'title'     => get_bloginfo( 'name', 'display' ),
                ];
                $defaults['logo_alt']    = [
                    'url'       => esc_url( get_theme_file_uri( 'assets/image/public/logo-alternate.svg' ) ),
                    'thumbnail' => esc_url( get_theme_file_uri( 'assets/image/public/logo-alternate.svg' ) ),
                    'alt'       => get_bloginfo( 'name', 'display' ),
                    'title'     => get_bloginfo( 'name', 'display' ),
                ];
                $defaults['logo_mobile'] = [
                    'url'       => esc_url( get_theme_file_uri( 'assets/image/public/logo-mobile.svg' ) ),
                    'thumbnail' => esc_url( get_theme_file_uri( 'assets/image/public/logo-mobile.svg' ) ),
                    'alt'       => get_bloginfo( 'name', 'display' ),
                    'title'     => get_bloginfo( 'name', 'display' )
                ];
                $defaults['logo_sticky'] = [
                    'url'       => esc_url( get_theme_file_uri( 'assets/image/public/logo-sticky.svg' ) ),
                    'thumbnail' => esc_url( get_theme_file_uri( 'assets/image/public/logo-sticky.svg' ) ),
                    'alt'       => get_bloginfo( 'name', 'display' ),
                    'title'     => get_bloginfo( 'name', 'display' )
                ];

            /**
             * Favicon
             */
                $defaults['favicon_32']  = [
                    'url'       => esc_url( get_theme_file_uri( 'assets/image/public/site-icon-32x32.png' ) ),
                    'thumbnail' => esc_url( get_theme_file_uri( 'assets/image/public/site-icon-32x32.png' ) ),
                ];
                $defaults['favicon_192'] = [
                    'url'       => esc_url( get_theme_file_uri( 'assets/image/public/site-icon-192x192.png' ) ),
                    'thumbnail' => esc_url( get_theme_file_uri( 'assets/image/public/site-icon-192x192.png' ) ),
                ];
                $defaults['favicon_180'] = [
                    'url'       => esc_url( get_theme_file_uri( 'assets/image/public/site-icon-192x192.png' ) ),
                    'thumbnail' => esc_url( get_theme_file_uri( 'assets/image/public/site-icon-192x192.png' ) ),
                ];
                $defaults['favicon_270'] = [
                    'url'       => esc_url( get_theme_file_uri( 'assets/image/public/site-icon-270x270.png' ) ),
                    'thumbnail' => esc_url( get_theme_file_uri( 'assets/image/public/site-icon-270x270.png' ) ),
                ];

            $defaults['default_header'] = 'standard_header';
            $defaults['default_footer'] = 'standard_footer';

            return $defaults;
        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_options_general' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_options_general() {

        return Onnat_Theme_Options_General::get_instance();
    }
}

kinfw_onnat_theme_options_general();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */