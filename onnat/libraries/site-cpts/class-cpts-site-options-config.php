<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( ! class_exists( 'Onnat_Theme_Our_CPT_Site_Options' ) ) {

    /**
     * The Onnat Our CPT Site Options setup class.
     */
    class Onnat_Theme_Our_CPT_Site_Options {

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

            add_action( 'kinfw-action/theme/site-options/template-hierarchy/loaded', [ $this, 'load_options' ], 5 );

        }

        public function load_options() {

            /**
             * Settings for Service Custom Post Type
             */
                CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                    'id'    => 'theme_cpt_service_section',
                    'title' => esc_html__( 'Service CPT', 'onnat' ),
                ] );
                    $this->cpt_service_archive_settings();
                    $this->cpt_single_service_settings();

            /**
             * Settings for Team Member Custom Post Type
             */
                CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                    'id'    => 'theme_cpt_team_member_section',
                    'title' => esc_html__( 'Team Member CPT', 'onnat' ),
                ] );
                    $this->cpt_team_member_archive_settings();
                    $this->cpt_single_team_member_settings();

            /**
             * Settings for Project Custom Post Type
             */
                CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                    'id'    => 'theme_cpt_project_section',
                    'title' => esc_html__( 'Project CPT', 'onnat' ),
                ] );
                    $this->cpt_project_archive_settings();
                    $this->cpt_single_project_settings();

        }

        public function cpt_service_archive_settings() {
            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'parent'      => 'theme_cpt_service_section',
                'title'       => esc_html__( 'Service Group Archives', 'onnat' ),
                'description' => esc_html__( 'Default Settings for the service custom post type archive page of the website.','onnat' ),
                'fields'      => [
                    [
                        'id'       => 'cpt_kinfw_service_archive_template',
                        'title'    => esc_html__( 'Service Group Archive Page Template', 'onnat' ),
                        'subtitle' => esc_html__( 'Select the Service Group Archive Page Template.','onnat' ),
                        'type'     => 'select',
                        'default'  => $this->default['cpt_kinfw_service_archive_template'],
                        'options'  => [
                            'no-sidebar'    => esc_html__( 'Full Width Template','onnat' ),
                            'left-sidebar'  => esc_html__( 'Left Sidebar Template','onnat' ),
                            'right-sidebar' => esc_html__( 'Right Sidebar Template','onnat' ),
                        ]
                    ],
                    [
                        'id'          => 'cpt_kinfw_service_archive_sidebars',
                        'type'        => 'select',
                        'title'       => esc_html__( 'Widget Area(s)', 'onnat' ),
                        'subtitle'    => esc_html__( 'Choose default widget area(s) for Service Group archive page.','onnat' ),
                        'placeholder' => esc_html__( 'Select an option', 'onnat' ),
                        'attributes'  => [ 'style' => 'width:25%' ],
                        'multiple'    => true,
                        'chosen'      => true,
                        'sortable'    => true,
                        'options'     => 'sidebars',
                        'default'     => $this->default['cpt_kinfw_service_archive_sidebars'],
                        'dependency'  => [ 'cpt_kinfw_service_archive_template', '!=', 'no-sidebar' ]
                    ],
                    [
                        'type'    => 'tabbed',
                        'id'      => 'cpt_kinfw_service_archive_item_per_row',
                        'title'   => esc_html__('Items Per Row','onnat'),
                        'default' => $this->default['cpt_kinfw_service_archive_item_per_row'],
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
                ]
            ] );
        }

        public function cpt_single_service_settings() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'parent'      => 'theme_cpt_service_section',
                'title'       => esc_html__( 'Service Single', 'onnat' ),
                'description' => esc_html__( 'Default Settings for the service custom post type single of the website.','onnat' ),
                'fields'      => [
                    [
                        'id'         => 'single_cpt_kinfw_service_template',
                        'title'      => esc_html__( 'Single Template', 'onnat' ),
                        'subtitle'   => esc_html__( 'Select default Single Service Custom Post Type Layout style. You can change the layout of each individual service when editing it.','onnat' ),
                        'type'       => 'select',
                        'attributes' => [ 'style' => 'width:25%' ],
                        'default'    => $this->default['single_cpt_kinfw_service_template'],
                        'options'    => [
                            #'kinfw-cpt-templates/no-sidebar.php'    => esc_html__( 'Full Width Template','onnat' ),
                            ''                                      => esc_html__( 'Full Width Template','onnat' ),
                            'kinfw-cpt-templates/left-sidebar.php'  => esc_html__( 'Left Sidebar Template','onnat' ),
                            'kinfw-cpt-templates/right-sidebar.php' => esc_html__( 'Right Sidebar Template','onnat' ),
                        ]
                    ],
                    [
                        'id'          => 'single_cpt_kinfw_service_sidebars',
                        'type'        => 'select',
                        'title'       => esc_html__( 'Widget Area(s)', 'onnat' ),
                        'subtitle'    => esc_html__( 'Choose default widget area(s). You can change widget area(s) of each individual service custom post type when editing it.','onnat' ),
                        'placeholder' => esc_html__( 'Select an option', 'onnat' ),
                        'attributes'  => [ 'style' => 'width:25%' ],
                        'multiple'    => true,
                        'chosen'      => true,
                        'sortable'    => true,
                        'options'     => 'sidebars',
                        'default'     => $this->default['single_cpt_kinfw_service_sidebars'],
                        'dependency'  => [ 'single_cpt_kinfw_service_template', '!=', '' ]
                    ],
                ],
            ] );

        }

        public function cpt_team_member_archive_settings() {
            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'parent'      => 'theme_cpt_team_member_section',
                'title'       => esc_html__( 'Team Group Archives', 'onnat' ),
                'description' => esc_html__( 'Default Settings for the team member custom post type archive page of the website.','onnat' ),
                'fields'      => [
                    [
                        'id'       => 'cpt_kinfw_team_member_archive_template',
                        'title'    => esc_html__( 'Team Group Archive Page Template', 'onnat' ),
                        'subtitle' => esc_html__( 'Select the Team Group Archive Page Template.','onnat' ),
                        'type'     => 'select',
                        'default'  => $this->default['cpt_kinfw_team_member_archive_template'],
                        'options'  => [
                            'no-sidebar'    => esc_html__( 'Full Width Template','onnat' ),
                            'left-sidebar'  => esc_html__( 'Left Sidebar Template','onnat' ),
                            'right-sidebar' => esc_html__( 'Right Sidebar Template','onnat' ),
                        ]
                    ],
                    [
                        'id'          => 'cpt_kinfw_team_member_archive_sidebars',
                        'type'        => 'select',
                        'title'       => esc_html__( 'Widget Area(s)', 'onnat' ),
                        'subtitle'    => esc_html__( 'Choose default widget area(s) for Team Group archive page.','onnat' ),
                        'placeholder' => esc_html__( 'Select an option', 'onnat' ),
                        'attributes'  => [ 'style' => 'width:25%' ],
                        'multiple'    => true,
                        'chosen'      => true,
                        'sortable'    => true,
                        'options'     => 'sidebars',
                        'default'     => $this->default['cpt_kinfw_team_member_archive_sidebars'],
                        'dependency'  => [ 'cpt_kinfw_team_member_archive_template', '!=', 'no-sidebar' ]
                    ],
                    [
                        'id'         => 'cpt_kinfw_team_member_archive_post_style',
                        'type'       => 'select',
                        'title'      => esc_html__( 'Post Style', 'onnat' ),
                        'subtitle'   => esc_html__( 'Choose post style.','onnat' ),
                        'attributes' => [ 'style' => 'width:25%;' ],
                        'default'    => $this->default['cpt_kinfw_team_member_archive_post_style'],
                        'options'    => [
                            'grid-1' => esc_html__('Grid 1', 'onnat' ),
                            'grid-2' => esc_html__('Grid 2', 'onnat' ),
                            'grid-3' => esc_html__('Grid 3', 'onnat' ),
                            'grid-4' => esc_html__('Grid 4', 'onnat' ),
                            'grid-5' => esc_html__('Grid 5', 'onnat' ),
                        ]
                    ],
                    [
                        'type'       => 'tabbed',
                        'id'         => 'cpt_kinfw_team_member_archive_item_per_row',
                        'title'      => esc_html__('Items Per Row','onnat'),
                        'default'    => $this->default['cpt_kinfw_team_member_archive_item_per_row'],
                        'dependency' => [ 'cpt_kinfw_team_member_archive_post_style', 'any', 'grid-1,grid-2,grid-3,grid-4,grid-5' ],
                        'tabs'       => [

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
                ]
            ] );

        }

        public function cpt_single_team_member_settings() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'parent'      => 'theme_cpt_team_member_section',
                'title'       => esc_html__( 'Team Member Single', 'onnat' ),
                'description' => esc_html__( 'Default Settings for the team member custom post type single of the website.','onnat' ),
                'fields'      => [
                    [
                        'id'         => 'single_cpt_kinfw_team_member_template',
                        'title'      => esc_html__( 'Single Template', 'onnat' ),
                        'subtitle'   => esc_html__( 'Select default Single Team Member Custom Post Type Layout style. You can change the layout of each individual team member when editing it.','onnat' ),
                        'type'       => 'select',
                        'attributes' => [ 'style' => 'width:25%' ],
                        'default'    => $this->default['single_cpt_kinfw_team_member_template'],
                        'options'    => [
                            #'kinfw-cpt-templates/no-sidebar.php'    => esc_html__( 'Full Width Template','onnat' ),
                            ''                                      => esc_html__( 'Full Width Template','onnat' ),
                            'kinfw-cpt-templates/left-sidebar.php'  => esc_html__( 'Left Sidebar Template','onnat' ),
                            'kinfw-cpt-templates/right-sidebar.php' => esc_html__( 'Right Sidebar Template','onnat' ),
                        ]
                    ],
                    [
                        'id'          => 'single_cpt_kinfw_team_member_sidebars',
                        'type'        => 'select',
                        'title'       => esc_html__( 'Widget Area(s)', 'onnat' ),
                        'subtitle'    => esc_html__( 'Choose default widget area(s). You can change widget area(s) of each individual team member custom post type when editing it.','onnat' ),
                        'placeholder' => esc_html__( 'Select an option', 'onnat' ),
                        'attributes'  => [ 'style' => 'width:25%' ],
                        'multiple'    => true,
                        'chosen'      => true,
                        'sortable'    => true,
                        'options'     => 'sidebars',
                        'default'     => $this->default['single_cpt_kinfw_team_member_sidebars'],
                        'dependency'  => [ 'single_cpt_kinfw_team_member_template', '!=', '' ]
                    ],
                    [
                        'id'       => 'single_team_member_social_share',
                        'type'     => 'sorter',
                        'title'    => esc_html__( 'Social Shares', 'onnat' ),
                        'subtitle' => esc_html__( 'Reorder social sharing links for a team member.', 'onnat' ),
                        'default'  => $this->default[ 'single_team_member_social_share' ]
                    ],
                ],
            ] );

        }

        public function cpt_project_archive_settings() {
            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'parent'      => 'theme_cpt_project_section',
                'title'       => esc_html__( 'Projects Archives', 'onnat' ),
                'description' => esc_html__( 'Default Settings for the project custom post type archive page of the website.','onnat' ),
                'fields'      => [
                    [
                        'id'       => 'cpt_kinfw_project_archive_template',
                        'title'    => esc_html__( 'Project Archive Page Template', 'onnat' ),
                        'subtitle' => esc_html__( 'Select the Project Archive Page Template.','onnat' ),
                        'type'     => 'select',
                        'default'  => $this->default['cpt_kinfw_project_archive_template'],
                        'options'  => [
                            'no-sidebar'    => esc_html__( 'Full Width Template','onnat' ),
                            'left-sidebar'  => esc_html__( 'Left Sidebar Template','onnat' ),
                            'right-sidebar' => esc_html__( 'Right Sidebar Template','onnat' ),
                        ]
                    ],
                    [
                        'id'          => 'cpt_kinfw_project_archive_sidebars',
                        'type'        => 'select',
                        'title'       => esc_html__( 'Widget Area(s)', 'onnat' ),
                        'subtitle'    => esc_html__( 'Choose default widget area(s) for Project archive page.','onnat' ),
                        'placeholder' => esc_html__( 'Select an option', 'onnat' ),
                        'attributes'  => [ 'style' => 'width:25%' ],
                        'multiple'    => true,
                        'chosen'      => true,
                        'sortable'    => true,
                        'options'     => 'sidebars',
                        'default'     => $this->default['cpt_kinfw_project_archive_sidebars'],
                        'dependency'  => [ 'cpt_kinfw_project_archive_template', '!=', 'no-sidebar' ]
                    ],
                    [
                        'id'         => 'cpt_kinfw_project_archive_post_style',
                        'type'       => 'select',
                        'title'      => esc_html__( 'Post Style', 'onnat' ),
                        'subtitle'   => esc_html__( 'Choose post style.','onnat' ),
                        'attributes' => [ 'style' => 'width:25%;' ],
                        'default'    => $this->default['cpt_kinfw_project_archive_post_style'],
                        'options'    => [
                            'grid-1' => esc_html__('Grid 1', 'onnat' ),
                            'grid-2' => esc_html__('Grid 2', 'onnat' ),
                            'grid-3' => esc_html__('Grid 3', 'onnat' ),
                            'grid-4' => esc_html__('Grid 4', 'onnat' ),
                        ]
                    ],
                    [
                        'type'       => 'tabbed',
                        'id'         => 'cpt_kinfw_project_archive_item_per_row',
                        'title'      => esc_html__('Items Per Row','onnat'),
                        'default'    => $this->default['cpt_kinfw_project_archive_item_per_row'],
                        'dependency' => [ 'cpt_kinfw_project_archive_post_style', 'any', 'grid-1,grid-2,grid-3,grid-4' ],
                        'tabs'       => [

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
                ],
            ] );
        }

        public function cpt_single_project_settings() {

            $post_styles = [
                '' => esc_html__('Default','onnat'),
            ];

            if( kinfw_is_elementor_callable() ) {
                $posts = get_posts([
                    'post_type'      => 'kinfw-project-look',
                    'post_status'    => 'publish',
                    'posts_per_page' => -1,
                ]);

                if( count( $posts  ) > 0 ) {
                    $template_styles = [];

                    foreach ( $posts as $post ) {
                        $template_styles[ $post->ID ] = $post->post_title;
                    }

                    $post_styles = [
                        esc_html__('Presets','onnat')             => $post_styles,
                        esc_html__('Elementor Templates','onnat') => $template_styles,
                    ];
                }
            }

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'parent'      => 'theme_cpt_project_section',
                'title'       => esc_html__( 'Project Single', 'onnat' ),
                'description' => esc_html__( 'Default Settings for the project custom post type single page of the website.','onnat' ),
                'fields'      => [
                    [
                        'id'         => 'single_cpt_kinfw_project_template',
                        'title'      => esc_html__( 'Single Template', 'onnat' ),
                        'subtitle'   => esc_html__( 'Select default Single Project Custom Post Type Layout style. You can change the layout of each individual project when editing it.','onnat' ),
                        'type'       => 'select',
                        'attributes' => [ 'style' => 'width:25%' ],
                        'default'    => $this->default['single_cpt_kinfw_project_template'],
                        'options'    => [
                            ''                                      => esc_html__( 'Full Width Template','onnat' ),
                            'kinfw-cpt-templates/left-sidebar.php'  => esc_html__( 'Left Sidebar Template','onnat' ),
                            'kinfw-cpt-templates/right-sidebar.php' => esc_html__( 'Right Sidebar Template','onnat' ),
                        ]
                    ],
                    [
                        'id'          => 'single_cpt_kinfw_project_sidebars',
                        'type'        => 'select',
                        'title'       => esc_html__( 'Widget Area(s)', 'onnat' ),
                        'subtitle'    => esc_html__( 'Choose default widget area(s). You can change widget area(s) of each individual project custom post type when editing it.','onnat' ),
                        'placeholder' => esc_html__( 'Select an option', 'onnat' ),
                        'attributes'  => [ 'style' => 'width:25%' ],
                        'multiple'    => true,
                        'chosen'      => true,
                        'sortable'    => true,
                        'options'     => 'sidebars',
                        'default'     => $this->default['single_cpt_kinfw_project_sidebars'],
                        'dependency'  => [ 'single_cpt_kinfw_project_template', '!=', '' ]
                    ],
                    [
                        'id'       => 'single_kinfw_project_social_share',
                        'type'     => 'sorter',
                        'title'    => esc_html__( 'Social Shares', 'onnat' ),
                        'subtitle' => esc_html__( 'Reorder social sharing links for a project.', 'onnat' ),
                        'default'  => $this->default[ 'single_kinfw_project_social_share' ]
                    ],
                    [
                        'id'         => 'single_kinfw_project_style',
                        'title'      => esc_html__( 'Posts Style', 'onnat' ),
                        'subtitle'   => esc_html__( 'Select posts style type.','onnat' ),
                        'type'       => 'select',
                        'attributes' => [ 'style' => 'width:25%' ],
                        'default'    => $this->default['single_kinfw_project_style'],
                        'options'    => $post_styles,
                    ],                    
                ],
            ] );
        }        

        public function defaults( $defaults = [] ) {

            /**
             * Service : Custom Post Type
             */
                $defaults['cpt_kinfw_service_archive_template']     = 'right-sidebar';
                $defaults['cpt_kinfw_service_archive_sidebars']     = [ 'default-widget-area' ];
                $defaults['cpt_kinfw_service_archive_post_style']   = 'grid-1';
                $defaults['cpt_kinfw_service_archive_item_per_row'] = [
                    'lg'           => 3,
                    'md_portrait'  => 2,
                    'md_landscape' => 2,
                    'sm_portrait'  => 1,
                    'sm_landscape' => 1
                ];

                $defaults['single_cpt_kinfw_service_template'] = '';
                $defaults['single_cpt_kinfw_service_sidebars'] = [ 'default-widget-area' ];

            /**
             * Team Member : Custom Post Type
             */
                $defaults['cpt_kinfw_team_member_archive_template']     = 'right-sidebar';
                $defaults['cpt_kinfw_team_member_archive_sidebars']     = [ 'default-widget-area' ];
                $defaults['cpt_kinfw_team_member_archive_post_style']   = 'grid-5';
                $defaults['cpt_kinfw_team_member_archive_item_per_row'] = [
                    'lg'           => 3,
                    'md_portrait'  => 2,
                    'md_landscape' => 2,
                    'sm_portrait'  => 1,
                    'sm_landscape' => 1
                ];

                $defaults['single_cpt_kinfw_team_member_template'] = '';
                $defaults['single_cpt_kinfw_team_member_sidebars'] = [ 'default-widget-area' ];
                $defaults['single_team_member_social_share']       = [
                    'enabled'  => [
                        'facebook' => esc_html__( 'Facebook', 'onnat' ),
                        'linkedin' => esc_html__( 'LinkedIn', 'onnat' ),
                        'twitter'  => esc_html__( 'Twitter', 'onnat' ),
                        'youtube'  => esc_html__( 'YouTube', 'onnat' ),
                    ],
                    'disabled' => [
                        'instagram' => esc_html__( 'Instagram', 'onnat' ),
                        'pinterest' => esc_html__( 'Pinterest', 'onnat' ),
                        'flickr'    => esc_html__( 'Flickr', 'onnat' ),
                        'xing'      => esc_html__( 'Xing', 'onnat' ),
                    ],
                ];

            /**
             * Project : Custom Post Type
             */
                $defaults['cpt_kinfw_project_archive_template']     = 'right-sidebar';
                $defaults['cpt_kinfw_project_archive_sidebars']     = [ 'default-widget-area' ];
                $defaults['cpt_kinfw_project_archive_post_style']   = 'grid-2';
                $defaults['cpt_kinfw_project_archive_item_per_row'] = [
                    'lg'           => 3,
                    'md_portrait'  => 2,
                    'md_landscape' => 2,
                    'sm_portrait'  => 1,
                    'sm_landscape' => 1
                ];

                $defaults['single_cpt_kinfw_project_template'] = '';
                $defaults['single_cpt_kinfw_project_sidebars'] = [ 'default-widget-area' ];
                $defaults['single_kinfw_project_social_share']       = [
                    'enabled'  => [
                        'facebook' => esc_html__( 'Facebook', 'onnat' ),
                        'linkedin' => esc_html__( 'LinkedIn', 'onnat' ),
                        'twitter'  => esc_html__( 'Twitter', 'onnat' ),
                        'youtube'  => esc_html__( 'YouTube', 'onnat' ),
                    ],
                    'disabled' => [
                        'instagram' => esc_html__( 'Instagram', 'onnat' ),
                        'pinterest' => esc_html__( 'Pinterest', 'onnat' ),
                        'flickr'    => esc_html__( 'Flickr', 'onnat' ),
                        'xing'      => esc_html__( 'Xing', 'onnat' ),
                    ],
                ];
                $defaults['single_kinfw_project_style']        = '';


            return $defaults;

        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_our_cpt_site_options' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_our_cpt_site_options() {

        return Onnat_Theme_Our_CPT_Site_Options::get_instance();
    }

}

kinfw_onnat_theme_our_cpt_site_options();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */