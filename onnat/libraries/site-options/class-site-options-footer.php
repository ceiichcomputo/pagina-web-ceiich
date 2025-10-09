<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Options_Footer' ) ) {

	/**
	 * The Onnat theme footer options setup class.
	 */
    class Onnat_Theme_Options_Footer {

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
                $this->standard();
                $this->preset_two();

            do_action( 'kinfw-action/theme/site-options/footer/loaded' );

        }

        public function init_settings() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'id'    => 'theme_footers_section',
                'title' => esc_html__( 'Footers', 'onnat' ),
            ] );

        }

        public function standard() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'parent'      => 'theme_footers_section',
                'title'       => esc_html__( 'Standard Footer', 'onnat' ),
                'description' => sprintf(
                    '<img src="%1$s" alt="%2$s" title="%2$s"/>',
                    ONNAT_CONST_THEME_DIR_URI. '/assets/image/admin/site-options/standard-footer.svg' ,
                    esc_attr__( 'Standard Footer', 'onnat')
                ),
                'fields'      => [
                    /**
                     * Widgets Area Block
                     */
                        [
                            'type'    => 'subheading',
                            'content' => esc_html__( 'Footer Column Settings', 'onnat'),
                        ],
                        [
                            'type'        => 'select',
                            'id'          => 'standard_footer_column',
                            'title'       => esc_html__( 'Footer Layout', 'onnat' ),
                            'subtitle'    => esc_html__( 'Select footer column layout for standard design.', 'onnat' ),
                            'placeholder' => esc_attr__( 'Select Layout', 'onnat' ),
                            'chosen'      => true,
                            'default'     => $this->default['standard_footer_column'],
                            'attributes'  => [ 'style' => 'width:250px;' ],
                            'options'     => [
                                'kinfw-col-12'                                                                                                                                                                                                                                                                              => '1',
                                'kinfw-col-12 kinfw-col-sm-6#kinfw-col-12 kinfw-col-sm-6'                                                                                                                                                                                                                                      => '1/2 + 1/2',
                                'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-4#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-4#kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-4'                                                                                                                                                                 => '1/3 + 1/3 + 1/3',
                                'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-4#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-8'                                                                                                                                                                                                          => '1/3 + 2/3',
                                'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-8#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-4'                                                                                                                                                                                                          => '2/3 + 1/3',
                                'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3'                                                                                                                          => '1/4 + 1/4 + 1/4 + 1/4',
                                'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-6'                                                                                                                                                                 => '1/4 + 1/4 + 1/2',
                                'kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-6#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3'                                                                                                                                                                 => '1/2 + 1/4 + 1/4',
                                'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-6#kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-3'                                                                                                                                                                 => '1/4 + 1/2 + 1/4',
                                'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-9'                                                                                                                                                                                                          => '1/4 + 3/4',
                                'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-9#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3'                                                                                                                                                                                                          => '3/4 + 1/4',
                                'kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-4 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-4 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-4 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-12 kinfw-col-md-6 kinfw-col-lg-1-5' => '1/5 + 1/5 + 1/5 + 1/5 + 1/5',
                                'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5'                                                                                                                  => '1/5 + 1/5 + 1/5 + 2/5',
                                'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5'                                                                                                                  => '1/5 + 1/5 + 2/5 + 1/5',
                                'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5'                                                                                                                  => '1/5 + 2/5 + 1/5 + 1/5',
                                'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5'                                                                                                                  => '2/5 + 1/5 + 1/5 + 1/5',
                                'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-3-5'                                                                                                                                                           => '1/5 + 1/5 + 3/5',
                                'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3-5#kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-1-5'                                                                                                                                                           => '1/5 + 3/5 + 1/5',
                                'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-1-5'                                                                                                                                                           => '3/5 + 1/5 + 1/5',
                                'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3-5'                                                                                                                                                                                                      => '2/5 + 3/5',
                                'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5'                                                                                                                                                                                                      => '3/5 + 2/5',
                                'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-4-5'                                                                                                                                                                                                      => '1/5 + 4/5',
                                'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-4-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5'                                                                                                                                                                                                      => '4/5 + 1/5',
                            ]
                        ],
                        [
                            'type'        => 'select',
                            'id'          => 'standard_footer_section_0',
                            'title'       => esc_html__( 'Footer Section 1', 'onnat' ),
                            'subtitle'    => esc_html__( 'Select footer section 1 widget area for standard design.', 'onnat' ),
                            'chosen'      => true,
                            'multiple'    => true,
                            'sortable'    => true,
                            'placeholder' => esc_attr__( 'Select Widget Area(s)', 'onnat' ),
                            'options'     => 'sidebars',
                            'default'     => $this->default['standard_footer_section_0'],
                            'dependency'  => [ 'standard_footer_column', '!=', '' ]
                        ],
                        [
                            'type'        => 'select',
                            'id'          => 'standard_footer_section_1',
                            'title'       => esc_html__( 'Footer Section 2', 'onnat' ),
                            'subtitle'    => esc_html__( 'Select footer section 2 widget area for standard design.', 'onnat' ),
                            'chosen'      => true,
                            'multiple'    => true,
                            'sortable'    => true,
                            'placeholder' => esc_attr__( 'Select Widget Area(s)', 'onnat' ),
                            'options'     => 'sidebars',
                            'default'     => $this->default['standard_footer_section_1'],
                            'dependency'  => [ 'standard_footer_column', 'any', 'kinfw-col-12 kinfw-col-sm-6#kinfw-col-12 kinfw-col-sm-6,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-4#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-4#kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-4,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-4#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-8,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-8#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-4,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-6,kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-6#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-6#kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-3,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-9,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-9#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3,kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-4 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-4 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-4 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-12 kinfw-col-md-6 kinfw-col-lg-1-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-3-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3-5#kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-1-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-1-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-4-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-4-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5' ]
                        ],
                        [
                            'type'        => 'select',
                            'id'          => 'standard_footer_section_2',
                            'title'       => esc_html__( 'Footer Section 3', 'onnat' ),
                            'subtitle'    => esc_html__( 'Select footer section 3 widget area for standard design.', 'onnat' ),
                            'chosen'      => true,
                            'multiple'    => true,
                            'sortable'    => true,
                            'placeholder' => esc_attr__( 'Select Widget Area(s)', 'onnat' ),
                            'options'     => 'sidebars',
                            'default'     => $this->default['standard_footer_section_2'],
                            'dependency'  => [ 'standard_footer_column', 'any','kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-4#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-4#kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-4,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-6,kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-6#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-6#kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-3,kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-4 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-4 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-4 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-12 kinfw-col-md-6 kinfw-col-lg-1-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-3-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3-5#kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-1-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-1-5']
                        ],
                        [
                            'type'        => 'select',
                            'id'          => 'standard_footer_section_3',
                            'title'       => esc_html__( 'Footer Section 4', 'onnat' ),
                            'subtitle'    => esc_html__( 'Select footer section 4 widget area for standard design.', 'onnat' ),
                            'chosen'      => true,
                            'multiple'    => true,
                            'sortable'    => true,
                            'placeholder' => esc_attr__( 'Select Widget Area(s)', 'onnat' ),
                            'options'     => 'sidebars',
                            'default'     => $this->default['standard_footer_section_3'],
                            'dependency'  => [ 'standard_footer_column', 'any','kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3,kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-4 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-4 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-4 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-12 kinfw-col-md-6 kinfw-col-lg-1-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5' ]
                        ],
                        [
                            'type'        => 'select',
                            'id'          => 'standard_footer_section_4',
                            'title'       => esc_html__( 'Footer Section 5', 'onnat' ),
                            'subtitle'    => esc_html__( 'Select footer section 5 widget area for standard design.', 'onnat' ),
                            'chosen'      => true,
                            'multiple'    => true,
                            'sortable'    => true,
                            'placeholder' => esc_attr__( 'Select Widget Area(s)', 'onnat' ),
                            'options'     => 'sidebars',
                            'default'     => $this->default['standard_footer_section_4'],
                            'dependency'  => [ 'standard_footer_column', '==', 'kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-4 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-4 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-4 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-12 kinfw-col-md-6 kinfw-col-lg-1-5' ]
                        ],
                        [
                            'type'       => 'switcher',
                            'id'         => 'standard_footer_full_width',
                            'title'      => esc_html__( 'Use Full Width', 'onnat'),
                            'subtitle'   => esc_html__( 'Turn on to have the full width footer area for your site.', 'onnat'),
                            'dependency' => [ 'standard_footer_column', '!=', ''],
                            'default'    => $this->default['standard_footer_full_width'],
                        ],
                        [
                            'type'       => 'switcher',
                            'id'         => 'use_standard_footer_background',
                            'title'      => esc_html__( 'Use Background', 'onnat'),
                            'subtitle'   => esc_html__( 'Turn on to have the background settings of the footer area for your site.', 'onnat'),
                            'dependency' => [ 'standard_footer_column', '!=', ''],
                            'default'    => $this->default['use_standard_footer_background'],
                        ],
                        [
                            'type'       => 'background',
                            'id'         => 'standard_footer_background',
                            'title'      => esc_html__( 'Background', 'onnat'),
                            'dependency' => [ 'standard_footer_column|use_standard_footer_background', '!=|==', '|true'],
                            'default'    => $this->default['standard_footer_background'],
                        ],
                        [
                            'type'       => 'tabbed',
                            'id'         => 'standard_footer_padding',
                            'title'      => esc_html__( 'Padding', 'onnat'),
                            'dependency' => [ 'standard_footer_column', '!=', ''],
                            'tabs'       => [
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
                                            'units' => [ 'px' ]
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
                                            'id'    => 'md_padding',
                                            'type'  => 'spacing',
                                            'title' => esc_html('Padding', 'onnat' ),
                                            'units' => [ 'px' ]
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
                                            'id'    => 'sm_padding',
                                            'type'  => 'spacing',
                                            'title' => esc_html('Padding', 'onnat' ),
                                            'units' => [ 'px' ]
                                        ],
                                    ]
                                ],
                            ]
                        ],

                        /**
                         * Footer Section Title
                         */
                        [
                            'type'               => 'typography',
                            'id'                 => 'standard_footer_section_title_typo',
                            'title'              => esc_html__( 'Footer Section Title Typography', 'onnat'),
                            'backup_font_family' => true,
                            'font_size'          => false,
                            'line_height'        => false,
                            'letter_spacing'     => false,
                            'dependency'         => [ 'standard_footer_column', '!=', ''],
                            'output'             => apply_filters( 'kinfw-filter/theme/output/typo/standard-footer/title', ['.kinfw-std-footer #kinfw-footer-widgets .kinfw-widget-title'])
                        ],
                        [
                            'type'       => 'fieldset',
                            'id'         => 'standard_footer_section_title_typo_size',
                            'title'      => '&nbsp;',
                            'dependency' => [ 'standard_footer_column', '!=', ''],
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
                         * Footer Section Content
                         */
                        [
                            'type'               => 'typography',
                            'id'                 => 'standard_footer_section_content_typo',
                            'title'              => esc_html__( 'Footer Section Content Typography', 'onnat'),
                            'backup_font_family' => true,
                            'font_size'          => false,
                            'line_height'        => false,
                            'letter_spacing'     => false,
                            'dependency'         => [ 'standard_footer_column', '!=', ''],
                            'output'             => apply_filters( 'kinfw-filter/theme/output/typo/standard-footer/content', ['.kinfw-std-footer #kinfw-footer-widgets .kinfw-widget-content' ] )
                        ],
                        [
                            'type'       => 'fieldset',
                            'id'         => 'standard_footer_section_content_typo_opt',
                            'title'      => '&nbsp;',
                            'dependency' => [ 'standard_footer_column', '!=', ''],
                            'fields'     => [
                                [
                                    'id'     => 'link_color',
                                    'title'  => esc_html__( 'Link Color', 'onnat' ),
                                    'type'   => 'link_color',
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
                     * Bottom Block
                     */
                        [
                            'type'    => 'subheading',
                            'content' => esc_html__( 'Footer Bottom Block Settings', 'onnat'),
                        ],
                        [
                            'type'     => 'switcher',
                            'id'       => 'use_standard_footer_bottom_block',
                            'title'    => esc_html__( 'Bottom Block', 'onnat'),
                            'subtitle' => esc_html__( 'Turn on to have the bottom block of the footer area for your site.', 'onnat' ),
                            'default'  => $this->default['use_standard_footer_bottom_block'],
                        ],
                        [
                            'type'        => 'select',
                            'id'          => 'standard_footer_bottom_block',
                            'title'       => esc_html__( 'Bottom Block Layout', 'onnat' ),
                            'subtitle'    => esc_html__( 'Select footer bottom block layout for standard footer design.', 'onnat' ),
                            'chosen'      => true,
                            'placeholder' => esc_attr__( 'Select Layout', 'onnat' ),
                            'attributes'  => [ 'style' => 'width:250px;'],
                            'dependency'  => [ 'use_standard_footer_bottom_block', '==', 'true'],
                            'default'     => $this->default['standard_footer_bottom_block'],
                            'options'     => [
                                'copyright'      => esc_html__('Copyright Text','onnat'),
                                'menu'           => esc_html__('Menu','onnat'),
                                'copyright+menu' => esc_html__('Copyright Text + Menu','onnat'),
                                'menu+copyright' => esc_html__('Menu+Copyright Text ','onnat'),
                            ]
                        ],
                        [
                            'type'       => 'text',
                            'id'         => 'standard_footer_copyright',
                            'title'      => esc_html__( 'Copyright Text', 'onnat' ),
                            'subtitle'   => esc_html__('Enter Copyright Text.','onnat'),
                            'dependency' => [ 'use_standard_footer_bottom_block|standard_footer_bottom_block', '==|any', 'true|copyright,copyright+menu,menu+copyright'],
                            'attributes' => [ 'style' => 'width:100%;' ],
                            'default'    => $this->default['standard_footer_copyright'],
                        ],
                        [
                            'id'          => 'standard_footer_bottom_menu',
                            'type'        => 'select',
                            'title'       => esc_html__( 'Menu', 'onnat' ),
                            'subtitle'    => esc_html__( 'Choose Menu.','onnat' ),
                            'placeholder' => esc_html__( 'Select a menu', 'onnat' ),
                            'attributes'  => [ 'style' => 'width:250px;'],
                            'dependency'  => [ 'use_standard_footer_bottom_block|standard_footer_bottom_block', '==|any', 'true|menu,copyright+menu,menu+copyright'],
                            'options'     => 'menus',
                            'chosen'      => true,
                            'default'     => $this->default['standard_footer_bottom_menu'],
                        ],
                        [
                            'type'       => 'button_set',
                            'id'         => 'standard_footer_bottom_alignment',
                            'title'      => esc_html__('Alignment','onnat'),
                            'options'    => [
                                'kinfw-footer-socket-align-left'   => esc_html__('Left','onnat'),
                                'kinfw-footer-socket-align-center' => esc_html__('Center','onnat'),
                                'kinfw-footer-socket-align-right'  => esc_html__('Right','onnat'),
                            ],
                            'dependency' => [ 'use_standard_footer_bottom_block|standard_footer_bottom_block', '==|any', 'true|copyright,menu'],
                            'default'    => $this->default['standard_footer_bottom_alignment'],
                        ],
                        [
                            'type'       => 'button_set',
                            'id'         => 'standard_footer_bottom_alignment_alt',
                            'title'      => esc_html__('Alignment','onnat'),
                            'subtitle'   => esc_html__('Split option only works if both copyright and menu fields has value.', 'onnat' ),
                            'options'    => [
                                'align-left'   => esc_html__('Left','onnat'),
                                'align-center' => esc_html__('Center','onnat'),
                                'align-right'  => esc_html__('Right','onnat'),
                                'align-split'  => esc_html__('Split','onnat'),
                            ],
                            'dependency' => [ 'use_standard_footer_bottom_block|standard_footer_bottom_block', '==|any', 'true|copyright+menu,menu+copyright'],
                            'default'    => $this->default['standard_footer_bottom_alignment_alt'],
                        ],
                        [
                            'type'       => 'switcher',
                            'id'         => 'standard_footer_bottom_full_width',
                            'title'      => esc_html__( 'Use Full Width', 'onnat'),
                            'subtitle'   => esc_html__( 'Turn on to have the full width footer area for your site.', 'onnat'),
                            'dependency' => [ 'use_standard_footer_bottom_block|standard_footer_bottom_block', '==|!=', 'true|'],
                            'default'    => $this->default['standard_footer_bottom_full_width'],
                        ],
                        [
                            'type'       => 'switcher',
                            'id'         => 'use_standard_footer_bottom_background',
                            'title'      => esc_html__( 'Use Background', 'onnat'),
                            'subtitle'   => esc_html__( 'Turn on to have the background settings of the footer bottom area for your site.', 'onnat'),
                            'dependency' => [ 'use_standard_footer_bottom_block|standard_footer_bottom_block', '==|!=', 'true|'],
                            'default'    => $this->default['use_standard_footer_bottom_background'],
                        ],
                        [
                            'type'       => 'tabbed',
                            'id'         => 'standard_footer_bottom_padding',
                            'title'      => esc_html__( 'Padding', 'onnat'),
                            'dependency' => [ 'use_standard_footer_bottom_block|standard_footer_bottom_block', '==|!=', 'true|'],
                            'tabs'       => [
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
                                            'units' => [ 'px' ]
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
                                            'id'    => 'md_padding',
                                            'type'  => 'spacing',
                                            'title' => esc_html('Padding', 'onnat' ),
                                            'units' => [ 'px' ]
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
                                            'id'    => 'sm_padding',
                                            'type'  => 'spacing',
                                            'title' => esc_html('Padding', 'onnat' ),
                                            'units' => [ 'px' ]
                                        ],
                                    ]
                                ],
                            ]
                        ],
                        [
                            'type'       => 'background',
                            'id'         => 'standard_footer_bottom_background',
                            'title'      => esc_html__( 'Background', 'onnat'),
                            'dependency' => [ 'use_standard_footer_bottom_block|standard_footer_bottom_block|use_standard_footer_bottom_background', '==|!=|==', 'true||true'],
                            'default'    => $this->default['standard_footer_bottom_background'],
                        ],

                        /**
                         * Copyright Typography
                         */
                        [
                            'type'               => 'typography',
                            'id'                 => 'standard_footer_copyright_typo',
                            'title'              => esc_html__( 'Copyright Typography', 'onnat'),
                            'backup_font_family' => true,
                            'font_size'          => false,
                            'line_height'        => false,
                            'letter_spacing'     => false,
                            'dependency'         => [ 'use_standard_footer_bottom_block|standard_footer_bottom_block|standard_footer_copyright', '==|any|!=', 'true|copyright,copyright+menu,menu+copyright|'],
                            'output'             => apply_filters( 'kinfw-filter/theme/output/typo/standard-footer/copyright', [ '.kinfw-std-footer #kinfw-copyright' ] )
                        ],
                        [
                            'type'       => 'fieldset',
                            'id'         => 'standard_footer_copyright_typo_opt',
                            'title'      => '&nbsp;',
                            'dependency' => [ 'use_standard_footer_bottom_block|standard_footer_bottom_block|standard_footer_copyright', '==|any|!=', 'true|copyright,copyright+menu,menu+copyright|'],
                            'fields'     => [
                                [
                                    'id'     => 'link_color',
                                    'title'  => esc_html__( 'Link Color', 'onnat' ),
                                    'type'   => 'link_color',
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
                         * Menu Typography
                         */
                        [
                            'type'               => 'typography',
                            'id'                 => 'standard_footer_bottom_block_menu_typo',
                            'title'              => esc_html__( 'Menu Typography', 'onnat'),
                            'backup_font_family' => true,
                            'font_size'          => false,
                            'line_height'        => false,
                            'letter_spacing'     => false,
                            'color'              => false,
                            'dependency'         => [ 'use_standard_footer_bottom_block|standard_footer_bottom_block|standard_footer_bottom_menu', '==|any|!=', 'true|menu,copyright+menu,menu+copyright|'],
                            'output'             => apply_filters( 'kinfw-filter/theme/output/typo/custom-built-footer/menu', [ '.kinfw-std-footer #sthemes-footer-menu' ] )
                        ],
                        [
                            'type'       => 'fieldset',
                            'id'         => 'standard_footer_bottom_block_menu_typo_opt',
                            'title'      => '&nbsp;',
                            'dependency' => [ 'use_standard_footer_bottom_block|standard_footer_bottom_block|standard_footer_bottom_menu', '==|any|!=', 'true|menu,copyright+menu,menu+copyright|'],
                            'fields'     => [
                                [
                                    'id'    => 'link_color',
                                    'title' => esc_html__( 'Link Color', 'onnat' ),
                                    'type'  => 'link_color',
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


        public function preset_two() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'parent'      => 'theme_footers_section',
                'title'       => esc_html__( 'Footer Preset One', 'onnat' ),
                'description' => sprintf(
                    '<img src="%1$s" alt="%2$s" title="%2$s"/>',
                    ONNAT_CONST_THEME_DIR_URI. '/assets/image/admin/site-options/footer-preset-two.svg' ,
                    esc_attr__( 'Footer Preset One', 'onnat')
                ),
                'fields'      => [
                    [
                        'type'    => 'subheading',
                        'content' => esc_html__( 'Footer Column Settings', 'onnat'),
                    ],
                    [
                        'type'        => 'select',
                        'id'          => 'footer_2_column',
                        'title'       => esc_html__( 'Footer Layout', 'onnat' ),
                        'subtitle'    => esc_html__( 'Select footer column layout for custom built design.', 'onnat' ),
                        'placeholder' => esc_attr__( 'Select Layout', 'onnat' ),
                        'chosen'      => true,
                        'attributes'  => [ 'style' => 'width:250px;' ],
                        'default'     => $this->default['footer_2_column'],
                        'options'     => [
                            'kinfw-col-12'                                                                                                                                                                                                                                                                              => '1',
                            'kinfw-col-12 kinfw-col-sm-6#kinfw-col-12 kinfw-col-sm-6'                                                                                                                                                                                                                                      => '1/2 + 1/2',
                            'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-4#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-4#kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-4'                                                                                                                                                                 => '1/3 + 1/3 + 1/3',
                            'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-4#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-8'                                                                                                                                                                                                          => '1/3 + 2/3',
                            'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-8#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-4'                                                                                                                                                                                                          => '2/3 + 1/3',
                            'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3'                                                                                                                          => '1/4 + 1/4 + 1/4 + 1/4',
                            'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-6'                                                                                                                                                                 => '1/4 + 1/4 + 1/2',
                            'kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-6#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3'                                                                                                                                                                 => '1/2 + 1/4 + 1/4',
                            'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-6#kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-3'                                                                                                                                                                 => '1/4 + 1/2 + 1/4',
                            'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-9'                                                                                                                                                                                                          => '1/4 + 3/4',
                            'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-9#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3'                                                                                                                                                                                                          => '3/4 + 1/4',
                            'kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-4 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-4 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-4 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-12 kinfw-col-md-6 kinfw-col-lg-1-5' => '1/5 + 1/5 + 1/5 + 1/5 + 1/5',
                            'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5'                                                                                                                  => '1/5 + 1/5 + 1/5 + 2/5',
                            'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5'                                                                                                                  => '1/5 + 1/5 + 2/5 + 1/5',
                            'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5'                                                                                                                  => '1/5 + 2/5 + 1/5 + 1/5',
                            'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5'                                                                                                                  => '2/5 + 1/5 + 1/5 + 1/5',
                            'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-3-5'                                                                                                                                                           => '1/5 + 1/5 + 3/5',
                            'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3-5#kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-1-5'                                                                                                                                                           => '1/5 + 3/5 + 1/5',
                            'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-1-5'                                                                                                                                                           => '3/5 + 1/5 + 1/5',
                            'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3-5'                                                                                                                                                                                                      => '2/5 + 3/5',
                            'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5'                                                                                                                                                                                                      => '3/5 + 2/5',
                            'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-4-5'                                                                                                                                                                                                      => '1/5 + 4/5',
                            'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-4-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5'                                                                                                                                                                                                      => '4/5 + 1/5',
                        ]
                    ],
                    [
                        'type'        => 'select',
                        'id'          => 'footer_2_section_0',
                        'title'       => esc_html__( 'Footer Section 1', 'onnat' ),
                        'subtitle'    => esc_html__( 'Select footer section 1 widget area for footer design.', 'onnat' ),
                        'chosen'      => true,
                        'multiple'    => true,
                        'sortable'    => true,
                        'placeholder' => esc_attr__( 'Select Widget Area(s)', 'onnat' ),
                        'options'     => 'sidebars',
                        'dependency'  => [ 'footer_2_column', '!=', '' ]
                    ],
                    [
                        'type'        => 'select',
                        'id'          => 'footer_2_section_1',
                        'title'       => esc_html__( 'Footer Section 2', 'onnat' ),
                        'subtitle'    => esc_html__( 'Select footer section 2 widget area for footer design.', 'onnat' ),
                        'chosen'      => true,
                        'multiple'    => true,
                        'sortable'    => true,
                        'placeholder' => esc_attr__( 'Select Widget Area(s)', 'onnat' ),
                        'options'     => 'sidebars',
                        'dependency'  => [ 'footer_2_column', 'any', 'kinfw-col-12 kinfw-col-sm-6#kinfw-col-12 kinfw-col-sm-6,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-4#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-4#kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-4,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-4#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-8,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-8#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-4,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-6,kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-6#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-6#kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-3,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-9,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-9#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3,kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-4 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-4 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-4 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-12 kinfw-col-md-6 kinfw-col-lg-1-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-3-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3-5#kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-1-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-1-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-4-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-4-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5' ]
                    ],
                    [
                        'type'        => 'select',
                        'id'          => 'footer_2_section_2',
                        'title'       => esc_html__( 'Footer Section 3', 'onnat' ),
                        'subtitle'    => esc_html__( 'Select footer section 3 widget area for footer design.', 'onnat' ),
                        'chosen'      => true,
                        'multiple'    => true,
                        'sortable'    => true,
                        'placeholder' => esc_attr__( 'Select Widget Area(s)', 'onnat' ),
                        'options'     => 'sidebars',
                        'dependency'  => [ 'footer_2_column', 'any', 'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-4#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-4#kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-4,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-6,kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-6#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-6#kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-3,kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-4 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-4 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-4 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-12 kinfw-col-md-6 kinfw-col-lg-1-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-3-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3-5#kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-1-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-12 kinfw-col-lg-1-5']
                    ],
                    [
                        'type'        => 'select',
                        'id'          => 'footer_2_section_3',
                        'title'       => esc_html__( 'Footer Section 4', 'onnat' ),
                        'subtitle'    => esc_html__( 'Select footer section 4 widget area for footer design.', 'onnat' ),
                        'chosen'      => true,
                        'multiple'    => true,
                        'sortable'    => true,
                        'placeholder' => esc_attr__( 'Select Widget Area(s)', 'onnat' ),
                        'options'     => 'sidebars',
                        'dependency'  => [ 'footer_2_column', 'any', 'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3,kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-4 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-4 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-4 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-12 kinfw-col-md-6 kinfw-col-lg-1-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5,kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-2-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-1-5' ]
                    ],
                    [
                        'type'        => 'select',
                        'id'          => 'footer_2_section_4',
                        'title'       => esc_html__( 'Footer Section 5', 'onnat' ),
                        'subtitle'    => esc_html__( 'Select footer section 5 widget area for footer design.', 'onnat' ),
                        'chosen'      => true,
                        'multiple'    => true,
                        'sortable'    => true,
                        'placeholder' => esc_attr__( 'Select Widget Area(s)', 'onnat' ),
                        'options'     => 'sidebars',
                        'dependency'  => [ 'footer_2_column', '==', 'kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-4 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-4 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-4 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-6 kinfw-col-md-6 kinfw-col-lg-1-5#kinfw-col-12 kinfw-col-sm-12 kinfw-col-md-6 kinfw-col-lg-1-5' ]
                    ],
                    [
                        'type'       => 'switcher',
                        'id'         => 'footer_2_full_width',
                        'title'      => esc_html__( 'Use Full Width', 'onnat'),
                        'subtitle'   => esc_html__( 'Turn on to have the full width footer area for your site.', 'onnat'),
                        'dependency' => [ 'footer_2_column', '!=', ''],
                        'default'    => $this->default['footer_2_full_width'],
                    ],
                    [
                        'type'       => 'switcher',
                        'id'         => 'use_footer_2_background',
                        'title'      => esc_html__( 'Use Background', 'onnat'),
                        'subtitle'   => esc_html__( 'Turn on to have the background settings of the footer area for your site.', 'onnat'),
                        'dependency' => [ 'footer_2_column', '!=', ''],
                        'default'    => $this->default['use_footer_2_background'],
                    ],
                    [
                        'type'       => 'background',
                        'id'         => 'footer_2_background',
                        'title'      => esc_html__( 'Background', 'onnat'),
                        'dependency' => [ 'footer_2_column|use_footer_2_background', '!=|==', '|true'],
                    ],
                    [
                        'type'       => 'tabbed',
                        'id'         => 'footer_2_padding',
                        'title'      => esc_html__( 'Padding', 'onnat'),
                        'dependency' => [ 'footer_2_column', '!=', ''],
                        'tabs'       => [
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
                                        'units' => [ 'px' ]
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
                                        'id'    => 'md_padding',
                                        'type'  => 'spacing',
                                        'title' => esc_html('Padding', 'onnat' ),
                                        'units' => [ 'px' ]
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
                                        'id'    => 'sm_padding',
                                        'type'  => 'spacing',
                                        'title' => esc_html('Padding', 'onnat' ),
                                        'units' => [ 'px' ]
                                    ],
                                ]
                            ],
                        ]
                    ],

                    /**
                     * Footer Section Title Typo
                     */
                    [
                        'type'               => 'typography',
                        'id'                 => 'footer_2_title_typo',
                        'title'              => esc_html__( 'Footer Section Title Typography', 'onnat'),
                        'backup_font_family' => true,
                        'font_size'          => false,
                        'line_height'        => false,
                        'letter_spacing'     => false,
                        'dependency'         => [ 'footer_2_column', '!=', ''],
                        'output'             => apply_filters( 'kinfw-filter/theme/output/typo/footer-preset-two/title', ['.kinfw-footer-preset-two #kinfw-footer-widgets .kinfw-widget-title'] )
                    ],
                    [
                        'type'       => 'fieldset',
                        'id'         => 'footer_2_title_typo_size',
                        'title'      => '&nbsp;',
                        'dependency' => [ 'footer_2_column', '!=', ''],
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
                     * Footer Section Content Typo
                     */
                    [
                        'type'               => 'typography',
                        'id'                 => 'footer_2_content_typo',
                        'title'              => esc_html__( 'Footer Section Content Typography', 'onnat'),
                        'backup_font_family' => true,
                        'font_size'          => false,
                        'line_height'        => false,
                        'letter_spacing'     => false,
                        'dependency'         => [ 'footer_2_column', '!=', ''],
                        'output'             => apply_filters( 'kinfw-filter/theme/output/typo/footer-preset-two/content', ['.kinfw-footer-preset-two #kinfw-footer-widgets .kinfw-widget-content'] )
                    ],
                    [
                        'type'       => 'fieldset',
                        'id'         => 'footer_2_content_typo_opt',
                        'title'      => '&nbsp;',
                        'dependency' => [ 'footer_2_column', '!=', ''],
                        'fields'     => [
                            [
                                'id'     => 'link_color',
                                'title'  => esc_html__( 'Link Color', 'onnat' ),
                                'type'   => 'link_color',
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
                        'id'          => 'footer_2_social_menu',
                        'type'        => 'select',
                        'title'       => esc_html__( 'Social Menu', 'onnat' ),
                        'subtitle'    => esc_html__( 'Choose a social links menu.','onnat' ),
                        'placeholder' => esc_html__( 'Select a menu', 'onnat' ),
                        'attributes'  => [ 'style' => 'width:250px;'],
                        'options'     => 'menus',
                        'chosen'      => true,
                        'default'     => $this->default['footer_2_social_menu'],
                    ],
                    [
                        'id'         => 'footer_2_social_menu_icon_color',
                        'title'      => esc_html__( 'Social Icon Color', 'onnat' ),
                        'type'       => 'color',
                        'dependency' => [ 'footer_2_social_menu', '!=', ''],
                    ],
                    [
                        'type'    => 'subheading',
                        'content' => esc_html__( 'Footer Bottom Block Settings', 'onnat'),
                    ],
                    [
                        'type'     => 'switcher',
                        'id'       => 'use_footer_2_bottom_block',
                        'title'    => esc_html__( 'Bottom Block', 'onnat'),
                        'subtitle' => esc_html__( 'Turn on to have the bottom block of the footer area for your site.', 'onnat' ),
                        'default'  => $this->default['use_footer_2_bottom_block'],
                    ],
                    [
                        'type'        => 'select',
                        'id'          => 'footer_2_bottom_block',
                        'title'       => esc_html__( 'Bottom Block Layout', 'onnat' ),
                        'subtitle'    => esc_html__( 'Select footer bottom block layout for footer design.', 'onnat' ),
                        'chosen'      => true,
                        'placeholder' => esc_attr__( 'Select Layout', 'onnat' ),
                        'attributes'  => [ 'style' => 'width:250px;'],
                        'dependency'  => [ 'use_footer_2_bottom_block', '==', 'true'],
                        'default'     => $this->default['footer_2_bottom_block'],
                        'options'     => [
                            'copyright'      => esc_html__('Copyright Text','onnat'),
                            'menu'           => esc_html__('Menu','onnat'),
                            'copyright+menu' => esc_html__('Copyright Text + Menu','onnat'),
                            'menu+copyright' => esc_html__('Menu + Copyright Text','onnat'),
                        ]
                    ],
                    [
                        'type'       => 'text',
                        'id'         => 'footer_2_copyright',
                        'title'      => esc_html__( 'Copyright Text', 'onnat' ),
                        'subtitle'   => esc_html__('Enter Copyright Text.','onnat'),
                        'dependency' => [ 'use_footer_2_bottom_block|footer_2_bottom_block', '==|any', 'true|copyright,copyright+menu,menu+copyright'],
                        'attributes' => [ 'style' => 'width:100%;' ],
                        'default'    => $this->default['footer_2_copyright'],
                    ],
                    [
                        'id'          => 'footer_2_bottom_menu',
                        'type'        => 'select',
                        'title'       => esc_html__( 'Menu', 'onnat' ),
                        'subtitle'    => esc_html__( 'Choose Menu.','onnat' ),
                        'placeholder' => esc_html__( 'Select a menu', 'onnat' ),
                        'attributes'  => [ 'style' => 'width:250px;'],
                        'dependency'  => [ 'use_footer_2_bottom_block|footer_2_bottom_block', '==|any', 'true|menu,copyright+menu,menu+copyright'],
                        'options'     => 'menus',
                        'chosen'      => true,
                        'default'     => $this->default['footer_2_bottom_menu'],
                    ],
                    [
                        'type'       => 'switcher',
                        'id'         => 'footer_2_bottom_full_width',
                        'title'      => esc_html__( 'Use Full Width', 'onnat'),
                        'subtitle'   => esc_html__( 'Turn on to have the full width footer area for your site.', 'onnat'),
                        'dependency' => [ 'use_footer_2_bottom_block|footer_2_bottom_block', '==|!=', 'true|'],
                        'default'    => $this->default['footer_2_bottom_full_width'],
                    ],
                    [
                        'type'       => 'switcher',
                        'id'         => 'use_footer_2_bottom_background',
                        'title'      => esc_html__( 'Use Background', 'onnat'),
                        'subtitle'   => esc_html__( 'Turn on to have the background settings of the footer bottom area for your site.', 'onnat'),
                        'dependency' => [ 'use_footer_2_bottom_block|footer_2_bottom_block', '==|!=', 'true|'],
                        'default'    => $this->default['use_footer_2_bottom_background'],
                    ],
                    [
                        'type'       => 'background',
                        'id'         => 'footer_2_bottom_background',
                        'title'      => esc_html__( 'Background', 'onnat'),
                        'dependency' => [ 'footer_2_bottom_block|use_footer_2_bottom_block|use_footer_2_bottom_background', '!=|==|==', '|true|true'],
                    ],
                    [
                        'type'       => 'tabbed',
                        'id'         => 'footer_2_bottom_padding',
                        'title'      => esc_html__( 'Padding', 'onnat'),
                        'dependency' => [ 'use_footer_2_bottom_block|footer_2_bottom_block', '==|!=', 'true|'],
                        'tabs'       => [
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
                                        'units' => [ 'px' ]
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
                                        'id'    => 'md_padding',
                                        'type'  => 'spacing',
                                        'title' => esc_html('Padding', 'onnat' ),
                                        'units' => [ 'px' ]
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
                                        'id'    => 'sm_padding',
                                        'type'  => 'spacing',
                                        'title' => esc_html('Padding', 'onnat' ),
                                        'units' => [ 'px' ]
                                    ],
                                ]
                            ],
                        ]
                    ],
                    /**
                     * Footer Section Copyright Typo
                     */
                    [
                        'type'               => 'typography',
                        'id'                 => 'footer_2_copyright_typo',
                        'title'              => esc_html__( 'Copyright Typography', 'onnat'),
                        'backup_font_family' => true,
                        'font_size'          => false,
                        'line_height'        => false,
                        'letter_spacing'     => false,
                        'dependency'         => [ 'use_footer_2_bottom_block|footer_2_bottom_block|footer_2_copyright', '==|any|!=', 'true|copyright,copyright+menu|'],
                        'output'             => apply_filters( 'kinfw-filter/theme/output/typo/footer-preset-two/copyright', ['.kinfw-footer-preset-two #kinfw-copyright'] )
                    ],
                    [
                        'type'       => 'fieldset',
                        'id'         => 'footer_2_copyright_typo_opt',
                        'title'      => '&nbsp;',
                        'dependency' => [ 'use_footer_2_bottom_block|footer_2_bottom_block|footer_2_copyright', '==|any|!=', 'true|copyright,copyright+menu|'],
                        'fields'     => [
                            [
                                'id'     => 'link_color',
                                'title'  => esc_html__( 'Link Color', 'onnat' ),
                                'type'   => 'link_color',
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
                     * Footer Section Menu Typo
                     */
                    [
                        'type'               => 'typography',
                        'id'                 => 'footer_2_bottom_block_menu_typo',
                        'title'              => esc_html__( 'Menu Typography', 'onnat'),
                        'backup_font_family' => true,
                        'font_size'          => false,
                        'line_height'        => false,
                        'letter_spacing'     => false,
                        'color'              => false,
                        'dependency'         => [ 'use_footer_2_bottom_block|footer_2_bottom_block|footer_2_bottom_menu', '==|any|!=', 'true|menu,copyright+menu|'],
                        'output'             => apply_filters( 'kinfw-filter/theme/output/typo/footer-preset-two/menu', [ '.kinfw-footer-preset-two #kinfw-footer-menu' ] )
                    ],
                    [
                        'type'       => 'fieldset',
                        'id'         => 'footer_2_bottom_block_menu_typo_opt',
                        'title'      => '&nbsp;',
                        'dependency' => [ 'use_footer_2_bottom_block|footer_2_bottom_block|footer_2_bottom_menu', '==|any|!=', 'true|menu,copyright+menu|'],
                        'fields'     => [
                            [
                                'id'    => 'link_color',
                                'title' => esc_html__( 'Link Color', 'onnat' ),
                                'type'  => 'link_color',
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

        public function defaults( $defaults = [] ) {

            $copyright = sprintf( '&copy; %1$s <a href="%3$s">%2$s</a>. %4$s',
                date('Y'),
                'KinForce',
                esc_url('https://themeforest.net/user/kinforce/portfolio'),
                esc_html__( 'All Rights Reserved.', 'onnat' )
            );

            $bottom_image = [
                'url'       => esc_url( get_theme_file_uri( 'assets/image/public/footer/payment.jpg' ) ),
                'thumbnail' => esc_url( get_theme_file_uri( 'assets/image/public/footer/payment.jpg' ) ),
                'id'        => '',
                'alt'       => esc_html__('payment', 'onnat' ),
                'title'     => esc_html__('payment', 'onnat' )
            ];


            /**
             * Standard Footer
             */
                $defaults['standard_footer_column']                = 'kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3#kinfw-col-12 kinfw-col-sm-6 kinfw-col-lg-3';
                $defaults['standard_footer_section_0']             = [];
                $defaults['standard_footer_section_1']             = [];
                $defaults['standard_footer_section_2']             = [];
                $defaults['standard_footer_section_3']             = [];
                $defaults['standard_footer_section_4']             = [];
                $defaults['standard_footer_full_width']            = false;
                $defaults['use_standard_footer_background']        = false;
                $defaults['standard_footer_background']            = [];
                $defaults['use_standard_footer_bottom_block']      = true;
                $defaults['standard_footer_bottom_block']          = 'copyright';
                $defaults['standard_footer_copyright']             = $copyright;
                $defaults['standard_footer_bottom_menu']           = '';
                $defaults['standard_footer_bottom_alignment']      = 'kinfw-footer-socket-align-center';
                $defaults['standard_footer_bottom_alignment_alt']  = 'align-center';
                $defaults['standard_footer_bottom_full_width']     = false;
                $defaults['use_standard_footer_bottom_background'] = false;
                $defaults['standard_footer_bottom_background']     = [];

            /**
             * Footer Preset 2
             */
                $defaults['footer_2_column']                = [];
                $defaults['footer_2_full_width']            = false;
                $defaults['use_footer_2_background']        = false;
                $defaults['footer_2_social_menu']           = '';
                $defaults['use_footer_2_bottom_block']      = true;
                $defaults['footer_2_bottom_block']          = 'copyright';
                $defaults['footer_2_copyright']             = $copyright;
                $defaults['footer_2_bottom_menu']           = '';
                $defaults['footer_2_bottom_full_width']     = false;
                $defaults['use_footer_2_bottom_background'] = false;

            return $defaults;
        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_options_footer' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_options_footer() {

        return Onnat_Theme_Options_Footer::get_instance();
    }
}

kinfw_onnat_theme_options_footer();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */