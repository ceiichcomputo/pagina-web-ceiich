<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Search_Result' ) ) {

	/**
	 * The Onnat Theme search result page hook setup class.
	 */
    class Onnat_Theme_Search_Result {

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

            /**
             * Customize search result with specific post types
             */
            add_filter( 'pre_get_posts', [ $this, 'search_query' ] );
        }

        public function search_query( $query ) {

            if ($query->is_search && !is_admin() && !empty( $query->query['s'] ) ) {
                $post_types = kinfw_onnat_theme_options()->kinfw_get_option( 'search_filter_results' );
                $post_types = apply_filters( 'kinfw-filter/theme/util/is-array', $post_types );
                $query->set( 'post_type', $post_types );
            }

            return $query;
        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_search_result' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_search_result() {

        return Onnat_Theme_Search_Result::get_instance();
    }
}

kinfw_onnat_theme_search_result();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */