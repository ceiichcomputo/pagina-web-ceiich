<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( ! class_exists( 'Onnat_Theme_Header_Search_Form' ) ) {

    /**
     * The Onnat header search form class.
     */
    class Onnat_Theme_Header_Search_Form {

		/**
		 * A reference to an instance of this class.
		 */
		private static $instance = null;

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

            printf( '<!-- #kinfw-header-search-form-modal -->
                <div id="kinfw-header-search-form-modal">
                    <div class="kinfw-header-search-form-modal-overlay"></div>
                    <div id="kinfw-header-search-form-modal-content">
                        <a class="kinfw-header-search-form-close" href="javascript:void(0);">%1$s</a>
                        <!-- .kinfw-header-search-form -->
                        <div class="kinfw-header-search-form">
                            <form method="get" action="%2$s">
                                <input name="s" type="search" placeholder="%3$s" value="%4$s"/>
                                <button type="submit" class="kinfw-search-submit">
                                    %5$s
                                </button>
                            </form>
                        </div><!-- /.kinfw-header-search-form -->
                    </div>
                </div><!-- /#kinfw-header-search-form-modal -->',
                kinfw_icon( 'onnat-cross' ),
                esc_url( home_url( '/' ) ),
                esc_attr__( 'Search...', 'onnat' ),
                get_search_query(),
                kinfw_icon( 'misc-search' )
            );

        }
    }

    Onnat_Theme_Header_Search_Form::get_instance();

}
/* Omit closing PHP tag to avoid "Headers already sent" issues. */