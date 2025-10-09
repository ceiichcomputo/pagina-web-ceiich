<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Post_Meta_Boxes' ) ) {

	/**
	 * The Onnat theme default post post type meta boxes setup class.
	 */
    class Onnat_Theme_Post_Meta_Boxes {

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

            $this->post_options_meta_box();
            $this->post_template_meta_box();
            $this->post_format_meta_box();

            do_action( 'kinfw-action/theme/meta-boxes/post/loaded' );

        }

        /**
         * Metabox : Page Options
         */
        public function post_options_meta_box() {

            CSF::createMetabox( ONNAT_CONST_THEME_POST_SETTINGS, [
                'title'     => esc_html__( 'Post Options', 'onnat' ),
                'post_type' => 'post',
                'context'   => 'normal',
                'priority'  => 'default'
            ] );

                $this->header_settings();
                $this->title_settings();
                $this->style_settings();
                $this->footer_settings();
                $this->skin_settings();

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

            CSF::createSection( ONNAT_CONST_THEME_POST_SETTINGS, [
                'title'  => esc_html__( 'Header', 'onnat' ),
                'fields' => $fields
            ] );

        }

        public function title_settings() {

            CSF::createSection( ONNAT_CONST_THEME_POST_SETTINGS, [
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
                        'id'         => 'single_post_page_title_type',
                        'title'      => esc_html__( 'Single Post Title Type?', 'onnat'),
                        'default'    => 'theme_post_title',
                        'options'    => [
                            'theme_post_title'  => esc_html__('Theme Option','onnat'),
                            'post_title'        => esc_html__('Post Title','onnat'),
                            'custom_post_title' => esc_html__('Custom Text','onnat'),
                        ],
                        'dependency' => [ 'post_title', '==', 'custom_post_title'],
                    ],
                    [
                        'type'       => 'text',
                        'id'         => 'single_post_page_title',
                        'title'      => esc_html__( 'Single Post Custom Title', 'onnat'),
                        'default'    => kinfw_onnat_theme_options()->kinfw_get_option( 'single_post_page_title' ),
                        'dependency' => [ 'single_post_page_title_type', '==', 'custom_post_title' ],
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
                        'id'         => 'use_post_title_full_width',
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

        public function style_settings() {

            $options = [
                'style-1' => esc_html__('Style 1','onnat'),
                'style-2' => esc_html__('Style 2','onnat'),
            ];

            if( kinfw_is_elementor_callable() ) {

                $posts = get_posts([
                    'post_type'      => 'kinfw-blog-post-look',
                    'post_status'    => 'publish',
                    'posts_per_page' => -1,
                    'orderby'        => 'title',
                    'order'          => 'ASC',
                ]);

                if( count( $posts  ) > 0 ) {
                    $post_styles = [];

                    foreach ( $posts as $post ) {
                        $post_styles[ $post->ID ] = $post->post_title;
                    }

                    $options = [
                        esc_html__('Presets','onnat') => $options
                    ];

                    if( count( $post_styles ) > 0 ) {
                        $options [ esc_html__('Elementor Templates','onnat') ] = $post_styles;
                    }
                }
            }            

            CSF::createSection( ONNAT_CONST_THEME_POST_SETTINGS, [
                'title'  => esc_html__( 'Post Style', 'onnat' ),
                'fields' => [
                    [
                        'type'    => 'subheading',
                        'content' => esc_html__( 'Post Style Setting', 'onnat'),
                    ],
                    [
                        'id'      => 'post_style',
                        'type'    => 'button_set',
                        'title'   => esc_html__('Post Style','onnat'),
                        'default' => 'theme_post_style',
                        'options' => [
                            'theme_post_style'  => esc_html__('Theme Option','onnat'),
                            'custom_post_style' => esc_html__('Customize','onnat'),
                        ],
                    ],
                    [
                        'id'         => 'custom_post_style',
                        'type'       => 'select',
                        'title'      => esc_html__('Custom Post Style','onnat'),
                        'default'    => 'style-1',
                        'attributes' => [ 'style' => 'width:25%' ],
                        'dependency' => [ 'post_style', '==', 'custom_post_style' ],
                        'options'    => $options,
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
                        'default'    => 'footer_custom_built',
                        'options'    => [
                            'standard_footer'   => ONNAT_CONST_THEME_DIR_URI . '/assets/image/admin/site-options/standard-footer.svg',
                            'footer_preset_two' => ONNAT_CONST_THEME_DIR_URI . '/assets/image/admin/site-options/footer-preset-two.svg',
                        ]
                    ]
                ];
            }

            CSF::createSection( ONNAT_CONST_THEME_POST_SETTINGS, [
                'title'  => esc_html__( 'Footer', 'onnat' ),
                'fields' => $footer_fields
            ] );
        }

        public function skin_settings() {
            CSF::createSection( ONNAT_CONST_THEME_POST_SETTINGS, [
                'title'  => esc_html__( 'Skin', 'onnat' ),
                'fields' => [
                    [
                        'id'      => 'skin',
                        'title'   => esc_html__( 'Use Custom Skin', 'onnat' ),
                        'type'    => 'switcher',
                        'desc'    => esc_html('Use this option to define a personalized theme or skin for this specific post.', 'onnat' ),
                        'default' => false,
                    ],
                    [
                        'id'         => 'skin_primary_color',
                        'title'      => esc_html__( 'Primary Color', 'onnat' ),
                        'type'       => 'color',
                        'default'    => '',
                        'dependency' => [ 'skin', '==', 'true' ]
                    ],
                    [
                        'id'         => 'skin_secondary_color',
                        'title'      => esc_html__( 'Secondary Color', 'onnat' ),
                        'type'       => 'color',
                        'default'    => '',
                        'dependency' => [ 'skin', '==', 'true' ]
                    ],
                    [
                        'id'         => 'skin_secondary_opacity_color',
                        'title'      => esc_html__( 'Secondary Opacity Color', 'onnat' ),
                        'type'       => 'color',
                        'default'    => '',
                        'dependency' => [ 'skin', '==', 'true' ]
                    ],
                    [
                        'id'         => 'skin_accent_color',
                        'title'      => esc_html__( 'Accent Color', 'onnat' ),
                        'type'       => 'color',
                        'default'    => '',
                        'dependency' => [ 'skin', '==', 'true' ]
                    ],
                    [
                        'id'         => 'skin_light_color',
                        'title'      => esc_html__( 'Text Light Color', 'onnat' ),
                        'type'       => 'color',
                        'default'    => '',
                        'dependency' => [ 'skin', '==', 'true' ]
                    ],
                    [
                        'id'         => 'skin_white_color',
                        'title'      => esc_html__( 'White Color', 'onnat' ),
                        'type'       => 'color',
                        'default'    => '',
                        'dependency' => [ 'skin', '==', 'true' ]
                    ],
                    [
                        'id'         => 'skin_bg_light_color',
                        'title'      => esc_html__( 'Background Light Color', 'onnat' ),
                        'type'       => 'color',
                        'default'    => '',
                        'dependency' => [ 'skin', '==', 'true' ]
                    ],
                ]
            ] );
        }

        /**
         * Metabox : Post Template
         */
        public function post_template_meta_box() {

            CSF::createMetabox( '_kinfw_post_template', [
                'title'          => esc_html__( 'Post Template Layout Option', 'onnat' ),
                'post_type'      => 'post',
                'context'        => 'side',
                'page_templates' => [ 'post-templates/post-left-sidebar.php', 'post-templates/post-right-sidebar.php' ],
            ] );

                CSF::createSection( '_kinfw_post_template', [
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
         * Metabox : Post Format
         */
        public function post_format_meta_box() {

            $this->audio_post_format_meta_box();
            $this->gallery_post_format_meta_box();
            $this->link_post_format_meta_box();
            $this->quote_post_format_meta_box();
            $this->video_post_format_meta_box();

        }

        /**
         * Post Format : Audio
         */
        public function audio_post_format_meta_box() {

            CSF::createMetabox( '_kinfw_audio_post', [
                'title'        => esc_html__( 'Audio Post Options', 'onnat' ),
                'post_type'    => 'post',
                'post_formats' => 'audio'
            ] );

                CSF::createSection( '_kinfw_audio_post', [
                    'fields' => [
                        [
                            'id'         => 'type',
                            'type'       => 'select',
                            'title'      => esc_html__( 'Audio type', 'onnat' ),
                            'default'    => 'embed',
                            'attributes' => [ 'style' => 'width:25%' ],
                            'options'    => [
                                'embed'  => esc_html__('Embed ( MP3, M4A, OGG, WAV )', 'onnat'),
                                'oembed' => esc_html__('OEmbed ( soundcloud )', 'onnat'),
                            ],
                        ],
                        [
                            'id'         => 'embed',
                            'type'       => 'media',
                            'title'      => esc_html__('Embed Audio', 'onnat' ),
                            'library'    => 'audio',
                            'dependency' => [ 'type', '==', 'embed' ]
                        ],
                        [
                            'id'         => 'oembed',
                            'type'       => 'text',
                            'title'      => esc_html__('OEmbed ( soundcloud ) Audio', 'onnat' ),
                            'dependency' => [ 'type', '==', 'oembed' ]
                        ]
                    ]
                ] );

        }

        /**
         * Post Format : Gallery
         */
        public function gallery_post_format_meta_box() {

            CSF::createMetabox( '_kinfw_gallery_post', [
                'title'        => esc_html__( 'Gallery Post Options', 'onnat' ),
                'post_type'    => 'post',
                'post_formats' => 'gallery'
            ] );

                CSF::createSection( '_kinfw_gallery_post', [
                    'fields' => [
                        [
                            'id'          => 'gallery',
                            'type'        => 'gallery',
                            'title'       => esc_html__( 'Gallery Image(s)', 'onnat' ),
                            'add_title'   => esc_html__( 'Add Image(s)', 'onnat' ),
                            'edit_title'  => esc_html__( 'Edit Image(s)', 'onnat' ),
                            'clear_title' => esc_html__( 'Remove Image(s)', 'onnat' ),
                        ],
                        [
                            'id'         => 'use_featured_image',
                            'type'       => 'switcher',
                            'title'      => esc_html__( 'Use Featured Image', 'onnat'),
                            'subtitle'   => esc_html__( 'Turn on to have the featured image in gallery.', 'onnat'),
                            'dependency' => [ 'gallery', '!=', ''],
                            'default'    => false,
                        ],
                        [
                            'type'       => 'button_set',
                            'id'         => 'featured_image_pos',
                            'title'      => esc_html__('Feature Image Position','onnat'),
                            'options'    => [
                                'kinfw-prepend' => esc_html__('Prepend','onnat'),
                                'kinfw-append'  => esc_html__('Append','onnat'),
                            ],
                            'dependency' => [ 'use_featured_image', '==', 'true'],
                            'default'    => 'kinfw-prepend',
                            'subtitle'   => esc_html__( 'The position of featured image in gallery.', 'onnat'),
                        ],
                    ]
                ] );

        }

        /**
         * Post Format : Link
         */
        public function link_post_format_meta_box() {

            CSF::createMetabox( '_kinfw_link_post', [
                'title'        => esc_html__( 'Link Post Options', 'onnat' ),
                'post_type'    => 'post',
                'post_formats' => 'link'
            ] );

                CSF::createSection( '_kinfw_link_post', [
                    'fields' => [
                        [
                            'id'    => 'url',
                            'type'  => 'text',
                            'title' => esc_html__('URL', 'onnat' ),
                        ]
                    ]
                ] );

        }

        /**
         * Post Format : Quote
         */
        public function quote_post_format_meta_box() {

            CSF::createMetabox( '_kinfw_quote_post', [
                'title'        => esc_html__( 'Quote Post Options', 'onnat' ),
                'post_type'    => 'post',
                'post_formats' => 'quote'
            ] );

                CSF::createSection( '_kinfw_quote_post', [
                    'fields' => [
                        [
                            'id'    => 'quote',
                            'type'  => 'textarea',
                            'title' => esc_html__('Quote', 'onnat' ),
                        ],
                        [
                            'id'    => 'author',
                            'type'  => 'text',
                            'title' => esc_html__('Author', 'onnat' ),
                        ]
                    ]
                ] );

        }

        /**
         * Post Format : Video
         */
        public function video_post_format_meta_box() {

            CSF::createMetabox( '_kinfw_video_post', [
                'title'        => esc_html__( 'Video Post Options', 'onnat' ),
                'post_type'    => 'post',
                'post_formats' => 'video'
            ] );

                CSF::createSection( '_kinfw_video_post', [
                    'fields' => [
                        [
                            'id'         => 'type',
                            'type'       => 'select',
                            'title'      => esc_html__( 'Video type', 'onnat' ),
                            'attributes' => [ 'style' => 'width:25%' ],
                            'default'    => 'embed',
                            'options'    => [
                                'embed'  => esc_html__('Embed ( MP4, M4V, WEBM, OGV )', 'onnat'),
                                'oembed' => esc_html__('OEmbed ( Youtube, Vimeo )', 'onnat'),
                            ],
                        ],
                        [
                            'id'         => 'embed',
                            'type'       => 'media',
                            'title'      => esc_html__('Embed Video', 'onnat' ),
                            'library'    => 'video',
                            'dependency' => [ 'type', '==', 'embed' ]
                        ],
                        [
                            'id'         => 'oembed',
                            'type'       => 'text',
                            'title'      => esc_html__('OEmbed (  Youtube, Vimeo  )', 'onnat' ),
                            'dependency' => [ 'type', '==', 'oembed' ]
                        ]
                    ]
                ] );

        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_post_meta_boxes' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_post_meta_boxes() {

        return Onnat_Theme_Post_Meta_Boxes::get_instance();
    }
}

kinfw_onnat_theme_post_meta_boxes();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */