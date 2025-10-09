<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Options_Backup' ) ) {

	/**
	 *  The Onnat theme back options setup class.
	 */
    class Onnat_Theme_Options_Backup {

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

            if( !function_exists( 'kf_onnat_extra_plugin' ) ) {

                return;
            }

            $this->settings();

            do_action( 'kinfw-action/theme/site-options/backup/loaded' );

        }

        public function settings() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'id'     => 'theme_options_backup_section',
                'title'  => esc_html__( 'Import / Export', 'onnat' ),
                'fields' => [
                    [
                        'type'    => 'subheading',
                        'content' => esc_html__( 'Import & Export', 'onnat' ),
                    ],
                    [ 'type' => 'backup', ]
                ]
            ] );

        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_options_backup' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_options_backup() {

        return Onnat_Theme_Options_Backup::get_instance();
    }
}

kinfw_onnat_theme_options_backup();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */