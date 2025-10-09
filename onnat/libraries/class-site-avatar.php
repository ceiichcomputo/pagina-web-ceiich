<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Avatar' ) ) {

	/**
	 * The Onnat Theme user avatar setup class.
	 */
    class Onnat_Theme_Avatar {

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

            add_filter( 'default_avatar_select', [ $this, 'avatars_list' ] );
            add_filter('get_avatar', [ $this, 'get_avatar' ], 10, 6);

            #add_action( 'after_switch_theme', [ $this, 'update_avatar' ] );
            #add_action( 'switch_theme', [ $this, 'update_avatar' ] );

            do_action( 'kinfw-action/theme/user-avatar/loaded' );

        }

        public function avatars_list() {

            $avatars = '';

            $default = get_option('avatar_default');
            $default = empty( $default ) ? 'kinfw_onnat_user_avatar' : $default;

            $avatars_list = [
                'mystery'                 => esc_html__( 'Mystery Person', 'onnat' ),
                'blank'                   => esc_html__( 'Blank', 'onnat' ),
                'gravatar_default'        => esc_html__( 'Gravatar Logo', 'onnat' ),
                'identicon'               => esc_html__( 'Identicon (Generated)', 'onnat' ),
                'wavatar'                 => esc_html__( 'Wavatar (Generated)', 'onnat' ),
                'monsterid'               => esc_html__( 'MonsterID (Generated)', 'onnat' ),
                'retro'                   => esc_html__( 'Retro (Generated)', 'onnat' ),
                'kinfw_onnat_user_avatar' => esc_html__( 'Custom Avatar','onnat'),
            ];

            foreach ( $avatars_list as $avatar_key => $avatar_name ) {

                $selected = ( $default == $avatar_key ) ? 'checked="checked" ' : "";

                if( 'kinfw_onnat_user_avatar' == $avatar_key ) {

                    $avatar = sprintf( '<img src="%1$s" class="avatar avatar-32 photo" width="32" height="32"/>', esc_url( get_theme_file_uri( 'assets/image/public/avatar.png' ) ) );
                } else {

                    $avatar = get_avatar('unknown@gravatar.com', 32, $avatar_key);
                }

                $avatars .= "\n\t<label><input type='radio' name='avatar_default' id='avatar_{$avatar_key}' value='".esc_attr($avatar_key)."' {$selected}/>";
                $avatars .= preg_replace("/src='(.+?)'/", "src='\$1&amp;forcedefault=1'", $avatar);
                $avatars .= ' '.$avatar_name.'</label>';
                $avatars .= '<br />';
            }

            return sprintf( '<div id="wp-avatars">%1$s</div>', $avatars );
        }

        public function get_avatar( $avatar, $id_or_email="", $size="", $default="", $alt="", $args = [] ) {

            $avatar_url   = get_avatar_url( $id_or_email );
            $avatar_host  = parse_url($avatar_url, PHP_URL_HOST);
            $dummy_avatar = false;

            /**
             * $avatar url starts with ://0.gravatar.com/avatar/
             * we use our own custom avatar
             */
            if (strpos($avatar_host, "0") === 0) {
                $dummy_avatar = true;
            }

            if( 'kinfw_onnat_user_avatar' == $default && $dummy_avatar ) {

                $avatar = sprintf('<img src="%1$s" alt="%2$s" class="photo avatar avatar-%3$s kinfw-default-avatar" height="%3$s" width="%3$s"/>',
                    esc_url( get_theme_file_uri( 'assets/image/public/avatar.png' ) ),
                    esc_attr( $alt ),
                    esc_attr( $size )
                );

                return $avatar;
            }

            return $avatar;
        }

        public function update_avatar() {

            $action = current_action();

            if( 'after_switch_theme' == $action ) {

                update_option('avatar_default', 'kinfw_onnat_user_avatar');

            } elseif('switch_theme' == $action ) {

                update_option('avatar_default', 'mystery');
            }

        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_avatar' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_avatar() {

        return;
        return Onnat_Theme_Avatar::get_instance();
    }
}

kinfw_onnat_theme_avatar();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */