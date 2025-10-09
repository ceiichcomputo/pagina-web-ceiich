<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Options_Template_Hierarchy' ) ) {

	/**
	 * The Onnat theme template hierarchy options setup class.
	 */
    class Onnat_Theme_Options_Template_Hierarchy {

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
                $this->archives_settings();
                $this->home_settings();
                $this->post_settings();
                $this->page_settings();
                $this->search_settings();
                $this->not_found_settings();


            do_action( 'kinfw-action/theme/site-options/template-hierarchy/loaded' );

        }

        public function init_settings() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'id'    => 'theme_default_templates_section',
                'title' => esc_html__( 'Template Hierarchy', 'onnat' ),
            ] );
        }

        public function archives_settings() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'parent' => 'theme_default_templates_section',
                'title'  => esc_html__( 'Archives', 'onnat' ),
                'fields' => [
                    /**
                     * Author Archive
                     */
                    [
                        'type'    => 'submessage',
                        'style'   => 'info',
                        'content' => sprintf(
                            /* translators: 1:H3 Opening Tag 2: H3 Closing Tag */
                            esc_html__('%1$sSettings for the Author Archives.%2$s', 'onnat' ),
                            '<h3>', '</h3>'
                        )
                    ],
                    [
                        'id'         => 'author_archive_template',
                        'title'      => esc_html__( 'Page Template', 'onnat' ),
                        'subtitle'   => esc_html__( 'Select the Author Archive Page Template.','onnat' ),
                        'type'       => 'select',
                        'attributes' => [ 'style' => 'width:25%' ],
                        'default'    => $this->default['author_archive_template'],
                        'options'    => [
                            'default'       => esc_html__( 'Full Width Template','onnat' ),
                            'left-sidebar'  => esc_html__( 'Left Sidebar Template','onnat' ),
                            'right-sidebar' => esc_html__( 'Right Sidebar Template','onnat' ),
                        ]
                    ],
                    [
                        'id'          => 'author_archive_sidebars',
                        'type'        => 'select',
                        'title'       => esc_html__( 'Widget Area(s)', 'onnat' ),
                        'subtitle'    => esc_html__( 'Choose widget area(s) for Author Archive Page.','onnat' ),
                        'placeholder' => esc_html__( 'Select an option', 'onnat' ),
                        'multiple'    => true,
                        'chosen'      => true,
                        'sortable'    => true,
                        'options'     => 'sidebars',
                        'attributes'  => [ 'style' => 'width:25%' ],
                        'default'     => $this->default['author_archive_sidebars'],
                        'dependency'  => [ 'author_archive_template', 'any', 'left-sidebar,right-sidebar' ]
                    ],
                    [
                        'id'         => 'author_archive_post_style',
                        'type'       => 'select',
                        'title'      => esc_html__( 'Post Style', 'onnat' ),
                        'subtitle'   => esc_html__( 'Choose post style for Author Posts Template.','onnat' ),
                        'attributes' => [ 'style' => 'width:25%;' ],
                        'default'    => $this->default['author_archive_post_style'],
                        'options'    => [
                            'standard' => esc_html__('Standard', 'onnat' ),
                            'author'   => esc_html__('Unique', 'onnat' ),
                            'grid-1'   => esc_html__('Grid 1', 'onnat' ),
                            'grid-2'   => esc_html__('Grid 2', 'onnat' ),
                            'grid-3'   => esc_html__('Grid 3', 'onnat' ),
                            'grid-4'   => esc_html__('Grid 4', 'onnat' ),
                        ]
                    ],
                    [
                        'type'       => 'fieldset',
                        'id'         => 'author_archive_posts_grid',
                        'title'      => esc_html__('Items Per Row','onnat'),
                        'dependency' => [ 'author_archive_post_style', 'any', 'grid-1,grid-2,grid-3,grid-4' ],
                        'fields'     => [
                            [
                                'type' => 'tabbed',
                                'id'   => 'size',
                                'default' => $this->default['author_archive_posts_grid'],
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
                                                'max'     => 3,
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
                            ]
                        ]
                    ],
                    /**
                     * Category Archive
                     */
                    [
                        'type'    => 'submessage',
                        'style'   => 'info',
                        'content' => sprintf(
                            /* translators: 1:H3 Opening Tag 2: H3 Closing Tag */
                            esc_html__('%1$sSettings for the Category Archives.%2$s', 'onnat' ),
                            '<h3>', '</h3>'
                        )
                    ],
                    [
                        'id'         => 'category_archive_template',
                        'title'      => esc_html__( 'Page Template', 'onnat' ),
                        'subtitle'   => esc_html__( 'Select the Category Archive Page Template.','onnat' ),
                        'type'       => 'select',
                        'attributes' => [ 'style' => 'width:25%' ],
                        'default'    => $this->default['category_archive_template'],
                        'options'    => [
                            'default'       => esc_html__( 'Full Width Template','onnat' ),
                            'left-sidebar'  => esc_html__( 'Left Sidebar Template','onnat' ),
                            'right-sidebar' => esc_html__( 'Right Sidebar Template','onnat' ),
                        ]
                    ],
                    [
                        'id'          => 'category_archive_sidebars',
                        'type'        => 'select',
                        'title'       => esc_html__( 'Widget Area(s)', 'onnat' ),
                        'subtitle'    => esc_html__( 'Choose widget area(s) for Category Archive Page.','onnat' ),
                        'placeholder' => esc_html__( 'Select an option', 'onnat' ),
                        'attributes'  => [ 'style' => 'width:25%' ],
                        'multiple'    => true,
                        'chosen'      => true,
                        'sortable'    => true,
                        'options'     => 'sidebars',
                        'default'     => $this->default['category_archive_sidebars'],
                        'dependency'  => [ 'category_archive_template', 'any', 'left-sidebar,right-sidebar' ]
                    ],
                    [
                        'id'         => 'category_archive_post_style',
                        'type'       => 'select',
                        'title'      => esc_html__( 'Post Style', 'onnat' ),
                        'subtitle'   => esc_html__( 'Choose post style for Category Posts Template.','onnat' ),
                        'attributes' => [ 'style' => 'width:25%;' ],
                        'default'    => $this->default['category_archive_post_style'],
                        'options'    => [
                            'standard' => esc_html__('Standard', 'onnat' ),
                            'category' => esc_html__('Unique', 'onnat' ),
                            'grid-1'   => esc_html__('Grid 1', 'onnat' ),
                            'grid-2'   => esc_html__('Grid 2', 'onnat' ),
                            'grid-3'   => esc_html__('Grid 3', 'onnat' ),
                            'grid-4'   => esc_html__('Grid 4', 'onnat' ),
                        ]
                    ],
                    [
                        'type'       => 'fieldset',
                        'id'         => 'category_archive_posts_grid',
                        'title'      => esc_html__('Items Per Row','onnat'),
                        'dependency' => [ 'category_archive_post_style', 'any', 'grid-1,grid-2,grid-3,grid-4' ],
                        'fields'     => [
                            [
                                'type'    => 'tabbed',
                                'id'      => 'size',
                                'default' => $this->default['category_archive_posts_grid'],
                                'tabs'    => [

                                    /**
                                     * Desktop
                                     */
                                    [
                                        'title'  => esc_html__('Desktop','onnat'),
                                        'icon'   => 'fas fa-desktop',
                                        'fields' => [
                                            [
                                                'type'  => 'spinner',
                                                'id'    => 'lg',
                                                'title' => esc_html__('Items Per Row','onnat'),
                                                'min'   => 1,
                                                'max'   => 4,
                                                'step'  => 1,
                                                'unit'  => '',
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
                                                'type'  => 'spinner',
                                                'id'    => 'md_portrait',
                                                'title' => esc_html__('Portrait Items Per Row','onnat'),
                                                'min'   => 1,
                                                'max'   => 3,
                                                'step'  => 1,
                                                'unit'  => '',
                                            ],
                                            [
                                                'type'  => 'spinner',
                                                'id'    => 'md_landscape',
                                                'title' => esc_html__('Landscape Items Per Row','onnat'),
                                                'min'   => 1,
                                                'max'   => 3,
                                                'step'  => 1,
                                                'unit'  => '',
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
                                                'type'  => 'spinner',
                                                'id'    => 'sm_portrait',
                                                'title' => esc_html__('Portrait Items Per Row','onnat'),
                                                'min'   => 1,
                                                'max'   => 3,
                                                'step'  => 1,
                                                'unit'  => '',
                                            ],
                                            [
                                                'type'  => 'spinner',
                                                'id'    => 'sm_landscape',
                                                'title' => esc_html__('Landscape Items Per Row','onnat'),
                                                'min'   => 1,
                                                'max'   => 3,
                                                'step'  => 1,
                                                'unit'  => '',
                                            ],
                                        ]
                                    ],
                                ]
                            ]
                        ]
                    ],

                    /**
                     * Date Archive
                     */
                    [
                        'type'    => 'submessage',
                        'style'   => 'info',
                        'content' => sprintf(
                            /* translators: 1:H3 Opening Tag 2: H3 Closing Tag */
                            esc_html__('%1$sSettings for the Date Archives.%2$s', 'onnat' ),
                            '<h3>', '</h3>'
                        )
                    ],
                    [
                        'id'         => 'date_archive_template',
                        'title'      => esc_html__( 'Page Template', 'onnat' ),
                        'subtitle'   => esc_html__( 'Select the Date Archive Page Template.','onnat' ),
                        'type'       => 'select',
                        'attributes' => [ 'style' => 'width:25%' ],
                        'default'    => $this->default['date_archive_template'],
                        'options'    => [
                            'default'       => esc_html__( 'Full Width Template','onnat' ),
                            'left-sidebar'  => esc_html__( 'Left Sidebar Template','onnat' ),
                            'right-sidebar' => esc_html__( 'Right Sidebar Template','onnat' ),
                        ]
                    ],
                    [
                        'id'          => 'date_archive_sidebars',
                        'type'        => 'select',
                        'title'       => esc_html__( 'Widget Area(s)', 'onnat' ),
                        'subtitle'    => esc_html__( 'Choose widget area(s) for Date Archive Page.','onnat' ),
                        'placeholder' => esc_html__( 'Select an option', 'onnat' ),
                        'multiple'    => true,
                        'chosen'      => true,
                        'sortable'    => true,
                        'options'     => 'sidebars',
                        'attributes'  => [ 'style' => 'width:25%' ],
                        'default'     => $this->default['date_archive_sidebars'],
                        'dependency'  => [ 'date_archive_template', 'any', 'left-sidebar,right-sidebar' ]
                    ],
                    [
                        'id'         => 'date_archive_post_style',
                        'type'       => 'select',
                        'title'      => esc_html__( 'Post Style', 'onnat' ),
                        'subtitle'   => esc_html__( 'Choose post style for Date Posts Template.','onnat' ),
                        'attributes' => [ 'style' => 'width:25%;' ],
                        'default'    => $this->default['date_archive_post_style'],
                        'options'    => [
                            'standard' => esc_html__('Standard', 'onnat' ),
                            'date'     => esc_html__('Unique', 'onnat' ),
                            'grid-1'   => esc_html__('Grid 1', 'onnat' ),
                            'grid-2'   => esc_html__('Grid 2', 'onnat' ),
                            'grid-3'   => esc_html__('Grid 3', 'onnat' ),
                            'grid-4'   => esc_html__('Grid 4', 'onnat' ),
                        ]
                    ],
                    [
                        'type'       => 'fieldset',
                        'id'         => 'date_archive_posts_grid',
                        'title'      => esc_html__('Items Per Row','onnat'),
                        'dependency' => [ 'date_archive_post_style', 'any', 'grid-1,grid-2,grid-3,grid-4' ],
                        'fields'     => [
                            [
                                'type'    => 'tabbed',
                                'id'      => 'size',
                                'default' => $this->default['author_archive_posts_grid'],
                                'tabs'    => [

                                    /**
                                     * Desktop
                                     */
                                    [
                                        'title'  => esc_html__('Desktop','onnat'),
                                        'icon'   => 'fas fa-desktop',
                                        'fields' => [
                                            [
                                                'type'  => 'spinner',
                                                'id'    => 'lg',
                                                'title' => esc_html__('Items Per Row','onnat'),
                                                'min'   => 1,
                                                'max'   => 4,
                                                'step'  => 1,
                                                'unit'  => '',
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
                                                'type'  => 'spinner',
                                                'id'    => 'md_portrait',
                                                'title' => esc_html__('Portrait Items Per Row','onnat'),
                                                'min'   => 1,
                                                'max'   => 3,
                                                'step'  => 1,
                                                'unit'  => '',
                                            ],
                                            [
                                                'type'  => 'spinner',
                                                'id'    => 'md_landscape',
                                                'title' => esc_html__('Landscape Items Per Row','onnat'),
                                                'min'   => 1,
                                                'max'   => 3,
                                                'step'  => 1,
                                                'unit'  => '',
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
                                                'type'  => 'spinner',
                                                'id'    => 'sm_portrait',
                                                'title' => esc_html__('Portrait Items Per Row','onnat'),
                                                'min'   => 1,
                                                'max'   => 3,
                                                'step'  => 1,
                                                'unit'  => '',
                                            ],
                                            [
                                                'type'  => 'spinner',
                                                'id'    => 'sm_landscape',
                                                'title' => esc_html__('Landscape Items Per Row','onnat'),
                                                'min'   => 1,
                                                'max'   => 3,
                                                'step'  => 1,
                                                'unit'  => '',
                                            ],
                                        ]
                                    ],
                                ]
                            ]
                        ]
                    ],
                    /**
                     * Tag Archive
                     */
                    [
                        'type'    => 'submessage',
                        'style'   => 'info',
                        'content' => sprintf(
                            /* translators: 1:H3 Opening Tag 2: H3 Closing Tag */
                            esc_html__('%1$sSettings for the Tag Archives.%2$s', 'onnat' ),
                            '<h3>', '</h3>'
                        )
                    ],
                    [
                        'id'         => 'tag_archive_template',
                        'title'      => esc_html__( 'Page Template', 'onnat' ),
                        'subtitle'   => esc_html__( 'Select the Tag Archive Page Template.','onnat' ),
                        'type'       => 'select',
                        'attributes' => [ 'style' => 'width:25%' ],
                        'default'    => $this->default['tag_archive_template'],
                        'options'    => [
                            'default'       => esc_html__( 'Full Width Template','onnat' ),
                            'left-sidebar'  => esc_html__( 'Left Sidebar Template','onnat' ),
                            'right-sidebar' => esc_html__( 'Right Sidebar Template','onnat' ),
                        ]
                    ],
                    [
                        'id'          => 'tag_archive_sidebars',
                        'type'        => 'select',
                        'title'       => esc_html__( 'Widget Area(s)', 'onnat' ),
                        'subtitle'    => esc_html__( 'Choose widget area(s) for Tag Archive Page.','onnat' ),
                        'placeholder' => esc_html__( 'Select an option', 'onnat' ),
                        'attributes'  => [ 'style' => 'width:25%' ],
                        'multiple'    => true,
                        'chosen'      => true,
                        'sortable'    => true,
                        'options'     => 'sidebars',
                        'default'     => $this->default['tag_archive_sidebars'],
                        'dependency'  => [ 'tag_archive_template', 'any', 'left-sidebar,right-sidebar' ]
                    ],
                    [
                        'id'         => 'tag_archive_post_style',
                        'type'       => 'select',
                        'title'      => esc_html__( 'Post Style', 'onnat' ),
                        'subtitle'   => esc_html__( 'Choose post style for Tag Posts Template.','onnat' ),
                        'attributes' => [ 'style' => 'width:25%;' ],
                        'default'    => $this->default['tag_archive_post_style'],
                        'options'    => [
                            'standard' => esc_html__('Standard', 'onnat' ),
                            'tag'      => esc_html__('Unique', 'onnat' ),
                            'grid-1'   => esc_html__('Grid 1', 'onnat' ),
                            'grid-2'   => esc_html__('Grid 2', 'onnat' ),
                            'grid-3'   => esc_html__('Grid 3', 'onnat' ),
                            'grid-4'   => esc_html__('Grid 4', 'onnat' ),
                        ]
                    ],
                    [
                        'type'       => 'fieldset',
                        'id'         => 'tag_archive_posts_grid',
                        'title'      => esc_html__('Items Per Row','onnat'),
                        'dependency' => [ 'tag_archive_post_style', 'any', 'grid-1,grid-2,grid-3,grid-4' ],
                        'fields'     => [
                            [
                                'type'    => 'tabbed',
                                'id'      => 'size',
                                'default' => $this->default['tag_archive_posts_grid'],
                                'tabs'    => [

                                    /**
                                     * Desktop
                                     */
                                    [
                                        'title'  => esc_html__('Desktop','onnat'),
                                        'icon'   => 'fas fa-desktop',
                                        'fields' => [
                                            [
                                                'type'  => 'spinner',
                                                'id'    => 'lg',
                                                'title' => esc_html__('Items Per Row','onnat'),
                                                'min'   => 1,
                                                'max'   => 4,
                                                'step'  => 1,
                                                'unit'  => '',
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
                                                'type'  => 'spinner',
                                                'id'    => 'md_portrait',
                                                'title' => esc_html__('Portrait Items Per Row','onnat'),
                                                'min'   => 1,
                                                'max'   => 3,
                                                'step'  => 1,
                                                'unit'  => '',
                                            ],
                                            [
                                                'type'  => 'spinner',
                                                'id'    => 'md_landscape',
                                                'title' => esc_html__('Landscape Items Per Row','onnat'),
                                                'min'   => 1,
                                                'max'   => 3,
                                                'step'  => 1,
                                                'unit'  => '',
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
                                                'type'  => 'spinner',
                                                'id'    => 'sm_portrait',
                                                'title' => esc_html__('Portrait Items Per Row','onnat'),
                                                'min'   => 1,
                                                'max'   => 3,
                                                'step'  => 1,
                                                'unit'  => '',
                                            ],
                                            [
                                                'type'  => 'spinner',
                                                'id'    => 'sm_landscape',
                                                'title' => esc_html__('Landscape Items Per Row','onnat'),
                                                'min'   => 1,
                                                'max'   => 3,
                                                'step'  => 1,
                                                'unit'  => '',
                                            ],
                                        ]
                                    ],
                                ]
                            ]
                        ]
                    ],
                ]
            ] );
        }

        public function home_settings() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'parent'      => 'theme_default_templates_section',
                'title'       => esc_html__( 'Home Page', 'onnat' ),
                'description' => esc_html__( 'Settings for the blog posts index page ( home page to display your latest blog posts ) of the website.','onnat' ),
                'fields'      => [
                    [
                        'type'    => 'text',
                        'id'      => 'front_post_page_title',
                        'title'   => esc_html__( 'Front Posts Page Title', 'onnat'),
                        'desc'    => esc_html__( 'Default front post page title for your site.', 'onnat' ),
                        'default' => $this->default['front_post_page_title'],
                    ],
                    [
                        'id'         => 'front_posts_page_template',
                        'title'      => esc_html__( 'Front Posts Page Template', 'onnat' ),
                        'subtitle'   => esc_html__( 'Select the Front Posts Page Template.','onnat' ),
                        'type'       => 'select',
                        'attributes' => [ 'style' => 'width:25%;' ],
                        'default'    => $this->default['front_posts_page_template'],
                        'options'    => [
                            'default'       => esc_html__( 'Full Width Template','onnat' ),
                            'left-sidebar'  => esc_html__( 'Left Sidebar Template','onnat' ),
                            'right-sidebar' => esc_html__( 'Right Sidebar Template','onnat' ),
                        ]
                    ],
                    [
                        'id'          => 'front_posts_page_sidebars',
                        'type'        => 'select',
                        'title'       => esc_html__( 'Widget Area(s)', 'onnat' ),
                        'subtitle'    => esc_html__( 'Choose widget area(s) for Front Posts Page Template.','onnat' ),
                        'placeholder' => esc_html__( 'Select an option', 'onnat' ),
                        'attributes'  => [ 'style' => 'width:25%' ],
                        'multiple'    => true,
                        'chosen'      => true,
                        'sortable'    => true,
                        'options'     => 'sidebars',
                        'default'     => $this->default['front_posts_page_sidebars'],
                        'dependency'  => [ 'front_posts_page_template', 'any', 'left-sidebar,right-sidebar' ]
                    ],
                    [
                        'id'         => 'front_posts_page_post_style',
                        'type'       => 'select',
                        'title'      => esc_html__( 'Post Style', 'onnat' ),
                        'subtitle'   => esc_html__( 'Choose post style for Front Posts Page Template.','onnat' ),
                        'attributes' => [ 'style' => 'width:25%;' ],
                        'default'    => $this->default['front_posts_page_post_style'],
                        'options'    => [
                            'standard' => esc_html__('Standard', 'onnat' ),
                            'grid-1'   => esc_html__('Grid 1', 'onnat' ),
                            'grid-2'   => esc_html__('Grid 2', 'onnat' ),
                            'grid-3'   => esc_html__('Grid 3', 'onnat' ),
                            'grid-4'   => esc_html__('Grid 4', 'onnat' ),
                        ]
                    ],
                    [
                        'type'       => 'fieldset',
                        'id'         => 'front_posts_grid',
                        'title'      => esc_html__('Items Per Row','onnat'),
                        'dependency' => [ 'front_posts_page_post_style', 'any', 'grid-1,grid-2,grid-3,grid-4' ],
                        'fields'     => [
                            [
                                'type'    => 'tabbed',
                                'id'      => 'size',
                                'default' => $this->default['front_posts_grid'],
                                'tabs'    => [

                                    /**
                                     * Desktop
                                     */
                                    [
                                        'title'  => esc_html__('Desktop','onnat'),
                                        'icon'   => 'fas fa-desktop',
                                        'fields' => [
                                            [
                                                'type'  => 'spinner',
                                                'id'    => 'lg',
                                                'title' => esc_html__('Items Per Row','onnat'),
                                                'min'   => 1,
                                                'max'   => 4,
                                                'step'  => 1,
                                                'unit'  => '',
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
                                                'type'  => 'spinner',
                                                'id'    => 'md_portrait',
                                                'title' => esc_html__('Portrait Items Per Row','onnat'),
                                                'min'   => 1,
                                                'max'   => 3,
                                                'step'  => 1,
                                                'unit'  => '',
                                            ],
                                            [
                                                'type'  => 'spinner',
                                                'id'    => 'md_landscape',
                                                'title' => esc_html__('Landscape Items Per Row','onnat'),
                                                'min'   => 1,
                                                'max'   => 3,
                                                'step'  => 1,
                                                'unit'  => '',
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
                                                'type'  => 'spinner',
                                                'id'    => 'sm_portrait',
                                                'title' => esc_html__('Portrait Items Per Row','onnat'),
                                                'min'   => 1,
                                                'max'   => 3,
                                                'step'  => 1,
                                                'unit'  => '',
                                            ],
                                            [
                                                'type'  => 'spinner',
                                                'id'    => 'sm_landscape',
                                                'title' => esc_html__('Landscape Items Per Row','onnat'),
                                                'min'   => 1,
                                                'max'   => 3,
                                                'step'  => 1,
                                                'unit'  => '',
                                            ],
                                        ]
                                    ],
                                ]
                            ]
                        ]
                    ]
                ]
            ] );
        }

        public function post_settings() {

            $post_styles = [
                'style-1' => esc_html__('Style 1','onnat'),
                'style-2' => esc_html__('Style 2','onnat'),
            ];

            if( kinfw_is_elementor_callable() ) {
                $posts = get_posts([
                    'post_type'      => 'kinfw-blog-post-look',
                    'post_status'    => 'publish',
                    'posts_per_page' => -1,
                ]);

                if( count( $posts  ) > 0 ) {
                    $post_styles = [
                        esc_html__('Presets','onnat') => $post_styles,
                    ];
                    $options     = [];

                    foreach ( $posts as $post ) {
                        $options[ $post->ID ] = $post->post_title;
                    }

                    if( count( $options ) > 0 ) {
                        $post_styles [ esc_html__('Elementor Templates','onnat') ] = $options;
                    }
                }
            }            

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'parent'      => 'theme_default_templates_section',
                'title'       => esc_html__( 'Single Post', 'onnat' ),
                'description' => esc_html__( 'Default Settings for the single posts of the website.','onnat' ),
                'fields'      => [
                    [
                        'id'         => 'single_post_page_title_type',
                        'title'      => esc_html__( 'Single Post Page Title', 'onnat' ),
                        'subtitle'   => esc_html__( 'Select default single post title type.','onnat' ),
                        'type'       => 'select',
                        'attributes' => [ 'style' => 'width:25%' ],
                        'default'    => $this->default['single_post_page_title_type'],
                        'options'    => [
                            'post_title' => esc_html__( 'Post Title','onnat' ),
                            'custom_txt' => esc_html__( 'Custom Text','onnat' ),
                        ]
                    ],
                    [
                        'type'       => 'text',
                        'id'         => 'single_post_page_title',
                        'title'      => esc_html__( 'Single Post Page Title', 'onnat'),
                        'desc'       => esc_html__( 'Default single post page title for your site. You can change the page title of each individual post when editing it.', 'onnat' ),
                        'default'    => $this->default['single_post_page_title'],
                        'dependency' => [ 'single_post_page_title_type', '==', 'custom_txt' ],
                    ],
                    [
                        'id'         => 'single_post_template',
                        'title'      => esc_html__( 'Single Post Template', 'onnat' ),
                        'subtitle'   => esc_html__( 'Select default single post layout style. You can change the layout of each individual post when editing it.','onnat' ),
                        'type'       => 'select',
                        'attributes' => [ 'style' => 'width:25%' ],
                        'default'    => $this->default['single_post_template'],
                        'options'    => [
                            ''                                      => esc_html__( 'Full Width Template','onnat' ),
                            'post-templates/post-left-sidebar.php'  => esc_html__( 'Left Sidebar Template','onnat' ),
                            'post-templates/post-right-sidebar.php' => esc_html__( 'Right Sidebar Template','onnat' ),
                        ]
                    ],
                    [
                        'id'         => 'single_post_style',
                        'title'      => esc_html__( 'Posts Style', 'onnat' ),
                        'subtitle'   => esc_html__( 'Select posts style type.','onnat' ),
                        'type'       => 'select',
                        'attributes' => [ 'style' => 'width:25%' ],
                        'default'    => $this->default['single_post_style'],
                        'options'    => $post_styles,
                    ],
                    [
                        'id'          => 'single_post_sidebars',
                        'type'        => 'select',
                        'title'       => esc_html__( 'Widget Area(s)', 'onnat' ),
                        'subtitle'    => esc_html__( 'Choose default widget area(s).You can change widget area(s) of each individual post when editing it.','onnat' ),
                        'placeholder' => esc_html__( 'Select an option', 'onnat' ),
                        'attributes'  => [ 'style' => 'width:25%' ],
                        'multiple'    => true,
                        'chosen'      => true,
                        'sortable'    => true,
                        'options'     => 'sidebars',
                        'default'     => $this->default['single_post_sidebars'],
                        'dependency'  => [ 'single_post_template', '!=', '' ]
                    ],
                    [
                        'id'       => 'single_post_social_share',
                        'type'     => 'sorter',
                        'title'    => esc_html__( 'Social Shares', 'onnat' ),
                        'subtitle' => esc_html__( 'Display social sharing buttons on your single post entry footer.', 'onnat' ),
                        'default'  => $this->default[ 'single_post_social_share' ]
                    ],
                    [
                        'id'       => 'show_author_bio',
                        'type'     => 'switcher',
                        'title'    => esc_html__( 'Show Author Bio Info?','onnat' ),
                        'subtitle' => esc_html__( 'Show biographical info on single blog post.','onnat' ),
                        'text_on'  => esc_html__( 'Yes','onnat' ),
                        'text_off' => esc_html__( 'No','onnat' ),
                        'default'  => $this->default['show_author_bio'],
                    ],
                    [
                        'id'       => 'show_related_posts',
                        'type'     => 'switcher',
                        'title'    => esc_html__( 'Show Releated Posts?','onnat' ),
                        'subtitle' => esc_html__( 'Show related posts on single blog post.','onnat' ),
                        'text_on'  => esc_html__( 'Yes','onnat' ),
                        'text_off' => esc_html__( 'No','onnat' ),
                        'default'  => $this->default['show_related_posts'],
                    ],
                    [
                        'id'         => 'related_posts_type',
                        'title'      => esc_html__( 'Related Posts Style', 'onnat' ),
                        'subtitle'   => esc_html__( 'Select related posts style type.','onnat' ),
                        'type'       => 'select',
                        'attributes' => [ 'style' => 'width:25%' ],
                        'default'    => $this->default['related_posts_type'],
                        'options'    => [
                            'style-1' => esc_html__( 'Style 1','onnat' ),
                            'style-2' => esc_html__( 'Style 2','onnat' ),
                        ],
                        'dependency' => [ 'show_related_posts', '==', 'true' ],
                    ],
                ]
            ] );

        }

        public function page_settings() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'parent'      => 'theme_default_templates_section',
                'title'       => esc_html__( 'Single Page', 'onnat' ),
                'description' => esc_html__( 'Default Settings for the single pages of the website.','onnat' ),
                'fields'      => [
                    [
                        'id'         => 'single_page_template',
                        'title'      => esc_html__( 'Single Page Template', 'onnat' ),
                        'subtitle'   => esc_html__( 'Select default Single Page Layout style. You can change the layout of each individual page when editing it.','onnat' ),
                        'type'       => 'select',
                        'attributes' => [ 'style' => 'width:25%' ],
                        'default'    => $this->default['single_page_template'],
                        'options'    => [
                            ''                                      => esc_html__( 'Full Width Template','onnat' ),
                            'page-templates/page-left-sidebar.php'  => esc_html__( 'Left Sidebar Template','onnat' ),
                            'page-templates/page-right-sidebar.php' => esc_html__( 'Right Sidebar Template','onnat' ),
                        ]
                    ],
                    [
                        'id'          => 'single_page_sidebars',
                        'type'        => 'select',
                        'title'       => esc_html__( 'Widget Area(s)', 'onnat' ),
                        'subtitle'    => esc_html__( 'Choose default widget area(s). You can change widget area(s) of each individual page when editing it.','onnat' ),
                        'placeholder' => esc_html__( 'Select an option', 'onnat' ),
                        'attributes'  => [ 'style' => 'width:25%' ],
                        'multiple'    => true,
                        'chosen'      => true,
                        'sortable'    => true,
                        'options'     => 'sidebars',
                        'default'     => $this->default['single_page_sidebars'],
                        'dependency'  => [ 'single_page_template', '!=', '' ]
                    ],
                ]
            ] );

        }

        public function search_settings() {

            $post_types = [
                'post' => esc_html__('Blog Posts', 'onnat'),
                'page' => esc_html__('Pages', 'onnat'),
            ];

            $post_types = apply_filters( 'kinfw-filter/theme/search-result-post-types', $post_types );

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'parent'      => 'theme_default_templates_section',
                'title'       => esc_html__( 'Search Result Page', 'onnat' ),
                'description' => esc_html__( 'Custom settings for the search results page of the website.','onnat' ),
                'fields'      => [
                    [
                        'id'         => 'search_template',
                        'title'      => esc_html__( 'Page Template', 'onnat' ),
                        'subtitle'   => esc_html__( 'Select the Search Results Page Template.','onnat' ),
                        'type'       => 'select',
                        'attributes' => [ 'style' => 'width:25%' ],
                        'default'    => $this->default['search_template'],
                        'options'    => [
                            'default'       => esc_html__( 'Full Width Template','onnat' ),
                            'left-sidebar'  => esc_html__( 'Left Sidebar Template','onnat' ),
                            'right-sidebar' => esc_html__( 'Right Sidebar Template','onnat' ),
                        ],
                    ],
                    [
                        'id'          => 'search_sidebars',
                        'type'        => 'select',
                        'title'       => esc_html__( 'Widget Area(s)', 'onnat' ),
                        'subtitle'    => esc_html__( 'Choose widget area(s) for Search Result Page Template.','onnat' ),
                        'placeholder' => esc_html__( 'Select an option', 'onnat' ),
                        'attributes'  => [ 'style' => 'width:25%' ],
                        'multiple'    => true,
                        'chosen'      => true,
                        'sortable'    => true,
                        'options'     => 'sidebars',
                        'default'     => $this->default['search_sidebars'],
                        'dependency'  => [ 'search_template', 'any', 'left-sidebar,right-sidebar' ],
                    ],
                    [
                        'id'       => 'search_title',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Page Title', 'onnat' ),
                        'subtitle' => esc_html__( 'Set the page title to be displayed in the breadcrumb area of the Search Results Page.','onnat' ),
                        'default'  => $this->default['search_title'],
                    ],
                    [
                        'id'       => 'search_filter_results',
                        'type'     => 'select',
                        'chosen'   => true,
                        'multiple' => true,
                        'title'    => esc_html__( 'Search Results Content', 'onnat' ),
                        'subtitle' => esc_html__('Customize your search by selecting specific post types to narrow down search results.', 'onnat'),
                        'options'  => $post_types,
                        'default'  => $this->default['search_filter_results'],
                    ],
                    [
                        'id'       => 'search_result_fallback_content',
                        'type'     => 'wp_editor',
                        'title'    => esc_html__( 'Search Result - Fallback Message Editor', 'onnat' ),
                        'subtitle' => esc_html__( 'Set the content to be displayed when a search comes with no results.', 'onnat' ),
                        'default'  => $this->default['search_result_fallback_content'],
                    ],

                ]
            ] );

        }

        public function not_found_settings() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'parent'      => 'theme_default_templates_section',
                'title'       => esc_html__( '404', 'onnat' ),
                'description' => esc_html__( 'Custom settings for the 404 page of the website.','onnat' ),
                'fields'      => [
                    [
                        'id'       => '404_title',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Page Title', 'onnat' ),
                        'subtitle' => esc_html__( 'Set the page title to be displayed in the breadcrumb area of the 404 Page.','onnat' ),
                        'default'  => $this->default['404_title'],
                    ],
                    [
                        'type'     => 'text',
                        'id'       => '404_main_text',
                        'title'    => esc_html__( 'Main Text', 'onnat' ),
                        'subtitle' => esc_html__('Enter Main Text.','onnat'),
                        'default'  => $this->default['404_main_text'],
                    ],
                    [
                        'type'     => 'text',
                        'id'       => '404_sub_text',
                        'title'    => esc_html__( 'Sub Text', 'onnat' ),
                        'subtitle' => esc_html__('Enter Sub Text.','onnat'),
                        'default'  => $this->default['404_sub_text'],
                    ],
                    [
                        'type'          => 'wp_editor',
                        'id'            => '404_content',
                        'media_buttons' => false,
                        'title'         => esc_html__( 'Content', 'onnat' ),
                        'subtitle'      => esc_html__('Enter Content.','onnat'),
                        'default'       => $this->default['404_content'],
                    ],
                    [
                        'type'     => 'switcher',
                        'id'       => 'use_go_home_btn',
                        'title'    => esc_html__( 'Use Go Home Button', 'onnat'),
                        'subtitle' => esc_html__( 'Turn on to have go to home button in 404 page of your site.', 'onnat'),
                        'default'  => $this->default['use_go_home_btn'],
                    ],
                    [
                        'type'       => 'text',
                        'id'         => 'go_home_btn_text',
                        'title'      => esc_html__( 'Button Text', 'onnat' ),
                        'subtitle'   => esc_html__('Enter Button Text.','onnat'),
                        'default'    => $this->default['go_home_btn_text'],
                        'dependency' => [ 'use_go_home_btn', '==', 'true'],
                    ],
                    [
                        'type'     => 'switcher',
                        'id'       => 'use_404_background',
                        'title'    => esc_html__( 'Use Background', 'onnat'),
                        'subtitle' => esc_html__( 'Turn on to have the background settings for 404 page of your site.', 'onnat'),
                        'default'  => false,
                    ],
                    [
                        'type'       => 'background',
                        'id'         => '404_background',
                        'title'      => esc_html__( 'Background Control', 'onnat'),
                        'dependency' => [ 'use_404_background', '==', 'true'],
                    ],

                    /** Main Text Typography */
                    [
                        'type'               => 'typography',
                        'id'                 => '404_main_text_typo',
                        'title'              => esc_html__( 'Main Text Typography', 'onnat'),
                        'backup_font_family' => true,
                        'font_size'          => false,
                        'line_height'        => false,
                        'letter_spacing'     => false,
                        'output'             => apply_filters( 'kinfw-filter/theme/output/typo/404/main_text', [ '.kinfw-error-404-main-text' ] )
                    ],
                    [
                        'type'   => 'fieldset',
                        'id'     => '404_main_text_typo_size',
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

                    /** Sub Text Typography */
                    [
                        'type'               => 'typography',
                        'id'                 => '404_sub_text_typo',
                        'title'              => esc_html__( 'Sub Text Typography', 'onnat'),
                        'backup_font_family' => true,
                        'font_size'          => false,
                        'line_height'        => false,
                        'letter_spacing'     => false,
                        'output'             => apply_filters( 'kinfw-filter/theme/output/typo/404/sub_text', [ '.kinfw-error-404-sub-text' ] )
                    ],
                    [
                        'type'   => 'fieldset',
                        'id'     => '404_sub_text_typo_size',
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

                    /** Content Typography */
                    [
                        'type'               => 'typography',
                        'id'                 => '404_content_typo',
                        'title'              => esc_html__( 'Content Typography', 'onnat'),
                        'backup_font_family' => true,
                        'font_size'          => false,
                        'line_height'        => false,
                        'letter_spacing'     => false,
                        'output'             => apply_filters( 'kinfw-filter/theme/output/typo/404/content', [ '.kinfw-error-404-content' ] )
                    ],
                    [
                        'type'   => 'fieldset',
                        'id'     => '404_content_typo_size',
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

        public function defaults( $defaults = [] ) {

            /**
             * Archive Pages
             */
                $defaults['author_archive_template']   = 'right-sidebar';
                $defaults['author_archive_sidebars']   = [ 'default-widget-area' ];
                $defaults['author_archive_post_style'] = 'author';
                $defaults['author_archive_posts_grid'] = [
                    'lg'           => 3,
                    'md_portrait'  => 2,
                    'md_landscape' => 2,
                    'sm_portrait'  => 1,
                    'sm_landscape' => 1
                ];

                $defaults['category_archive_template']   = 'right-sidebar';
                $defaults['category_archive_sidebars']   = [ 'default-widget-area' ];
                $defaults['category_archive_post_style'] = 'category';
                $defaults['category_archive_posts_grid'] = [
                    'lg'           => 3,
                    'md_portrait'  => 2,
                    'md_landscape' => 2,
                    'sm_portrait'  => 1,
                    'sm_landscape' => 1
                ];

                $defaults['date_archive_template']   = 'right-sidebar';
                $defaults['date_archive_sidebars']   = [ 'default-widget-area' ];
                $defaults['date_archive_post_style'] = 'date';
                $defaults['date_archive_posts_grid'] = [
                    'lg'           => 3,
                    'md_portrait'  => 2,
                    'md_landscape' => 2,
                    'sm_portrait'  => 1,
                    'sm_landscape' => 1
                ];

                $defaults['tag_archive_template']   = 'right-sidebar';
                $defaults['tag_archive_sidebars']   = [ 'default-widget-area' ];
                $defaults['tag_archive_post_style'] = 'tag';
                $defaults['tag_archive_posts_grid'] = [
                    'lg'           => 3,
                    'md_portrait'  => 2,
                    'md_landscape' => 2,
                    'sm_portrait'  => 1,
                    'sm_landscape' => 1
                ];

            /**
             * Home Page
             */
                $defaults['front_post_page_title']       = esc_html__('Digitial Agency', 'onnat' );
                $defaults['front_posts_page_template']   = 'right-sidebar';
                $defaults['front_posts_page_sidebars']   = [ 'default-widget-area' ];
                $defaults['front_posts_page_post_style'] = 'standard';
                $defaults['front_posts_grid']            = [
                    'lg'           => 3,
                    'md_portrait'  => 2,
                    'md_landscape' => 2,
                    'sm_portrait'  => 1,
                    'sm_landscape' => 1
                ];

            /**
             * Post
             */
                $defaults['single_post_page_title_type'] = 'custom_txt';
                $defaults['single_post_page_title']      = esc_html__( 'Blog', 'onnat' );
                $defaults['single_post_template']        = '';
                $defaults['single_post_style']           = 'style-2';
                $defaults['single_post_sidebars']        = [ 'default-widget-area' ];
                $defaults['single_post_social_share']    = [
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
                $defaults['show_author_bio']             = false;
                $defaults['show_related_posts']          = true;
                $defaults['related_posts_type']          = 'style-1';

            /**
             * Page
             */
                $defaults['single_page_template'] = '';
                $defaults['single_page_sidebars'] = [ 'default-widget-area' ];

            /**
             * Search Page
             */
                $defaults['search_template']                = 'default';
                $defaults['search_sidebars']                = [ 'default-widget-area' ];
                $defaults['search_title']                   = esc_html__( 'Search Results for:','onnat' );
                $defaults['search_filter_results']          = [ 'post', 'page' ];
                $defaults['search_result_fallback_content'] = esc_html__( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'onnat' );

            /**
             * Not Found Page
             */
                $defaults['404_title']          = esc_html__( '404 - Page not found', 'onnat' );
                $defaults['404_main_text']      = '404';
                $defaults['404_sub_text']       = esc_html__('OOPS!','onnat' );
                $defaults['404_content']        = esc_html__( 'We are sorry, the page you\'ve requested is not available', 'onnat' );
                $defaults['use_go_home_btn']    = true;
                $defaults['go_home_btn_text']   = esc_html__('Take Me Home','onnat');
                $defaults['use_404_background'] = false;

            return $defaults;
        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_options_template_hierarchy' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_options_template_hierarchy() {

        return Onnat_Theme_Options_Template_Hierarchy::get_instance();
    }
}

kinfw_onnat_theme_options_template_hierarchy();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */