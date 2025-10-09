<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Ajax_Calls' ) ) {

    /**
     * The Onnat ajax call setup class.
     */
    class Onnat_Theme_Ajax_Calls {

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
             * Header Login Form
             */
            add_action( 'wp_ajax_nopriv_kinfw-action/theme/header/action/login-form/login', [ $this, 'ajax_login_init' ] );
            add_action( 'wp_ajax_nopriv_kinfw-action/theme/header/action/login-form/reset-pwd', [ $this, 'ajax_reset_pwd_init' ] );
            add_action( 'wp_ajax_nopriv_kinfw-action/theme/header/action/login-form/register-user', [ $this, 'ajax_reg_user_init' ] );
        }

        /**
         * Header Login Form : Login Handler
         */
        public function ajax_login_init() {

            if( wp_verify_nonce( $_POST['kinfw-header-login-form-nonce'], 'kinfw-header-login-form-nonce' ) ) {

                $credentials['user_login']    = sanitize_user( $_POST['username'] );
                $credentials['user_password'] = wp_unslash( $_POST['password'] );
                $credentials['remember']      = isset( $_POST['rememberme'] ) && ! empty( $_POST['rememberme'] );

                $user = wp_signon( $credentials, is_ssl() );

                if( is_wp_error( $user ) ) {

                    $error = $user->get_error_message();

                    if( $user->get_error_code() == 'incorrect_password' ) {

                        $error = sprintf( esc_html__( 'The password you entered for the username %s is incorrect.' , 'onnat' ), $_POST['username'] );
                    }

                    wp_send_json_error( [
                        'msg' => sprintf('<span class="kinfw-failure-msg">%1$s</span>', $error  ),
                        'btn' => esc_html__('Try Again', 'onnat'),
                    ] );
                } else {
                    wp_send_json_success([
                        'btn' => esc_html__('Redirecting...', 'onnat'),
                        'url' => $_POST['redirect']
                    ]);
                }
            } else {
                wp_send_json_error( [
                    'msg' => sprintf('<span class="kinfw-failure-msg">%1$s</span>', esc_html__('something went wrong.', 'onnat' )  ),
                    'btn' => esc_html__('something went wrong.', 'onnat'),
                ] );
            }

            wp_die();

        }

        /**
         * Header Login Form : Reset Password Handler
         */
        public function ajax_reset_pwd_init() {

            if( wp_verify_nonce( $_POST['kinfw-header-reset-pwd-form-nonce'], 'kinfw-header-reset-pwd-form-nonce' ) ) {

                $email = kinfw_is_user_exists( $_POST['uname_email'] );
                $uname = kinfw_is_user_exists( $_POST['uname_email'], 'login' );

                if( !$email && !$uname ) {
                    wp_send_json_error( [
                        'msg' => sprintf('<span class="kinfw-failure-msg">%1$s</span>', esc_html__('There is no account with that username or email address.', 'onnat' )  ),
                        'btn' => esc_html__('Enter Valid User.', 'onnat'),
                    ] );
                }

                $_POST['user_login'] = $_POST['uname_email'];

                if ( ! function_exists( 'retrieve_password' ) ) {
                    ob_start();
                    call_user_func( 'include_'.'once', ABSPATH . 'wp-login.php' );
                    ob_clean();
                }

                $result = retrieve_password();
                if( $result == true ) {
                    wp_send_json_success([
                        'msg' => sprintf('<span class="kinfw-success-msg">%1$s</span>', esc_html__('Check your email for the confirmation link.', 'onnat' )  ),
                        'btn' => esc_html__('Redirecting...', 'onnat'),
                        'url' => $_POST['redirect']
                    ]);
                } else {
                    wp_send_json_error( [
                        'msg' => sprintf('<span class="kinfw-failure-msg">%1$s</span>', esc_html__('something went wrong.', 'onnat' )  ),
                        'btn' => esc_html__('something went wrong.', 'onnat'),
                    ] );
                }

            } else {
                wp_send_json_error( [
                    'msg' => sprintf('<span class="kinfw-failure-msg">%1$s</span>', esc_html__('something went wrong.', 'onnat' )  ),
                    'btn' => esc_html__('something went wrong.', 'onnat'),
                ] );
            }

            wp_die();

        }

        /**
         * Header Login Form : User Registration Handler
         */
        public function ajax_regsiter_user_init() {

            if( wp_verify_nonce( $_POST['kinfw-header-reset-pwd-form-nonce'], 'kinfw-header-reset-pwd-form-nonce' ) ) {
                $uname = sanitize_user( $_POST['username'] );
                $email = sanitize_email( $_POST['email'] );
                $pwd   = wp_unslash( $_POST['password'] );
                $cpwd  = wp_unslash( $_POST['confirm-password'] );

                if( empty( $email ) || !is_email( $email ) ) {
                    wp_send_json_error( [
                        'msg' => sprintf('<span class="kinfw-failure-msg">%1$s</span>', esc_html__("The email address isn’t correct.", 'onnat' )  ),
                    ] );
                }

                $user_exists = kinfw_is_user_exists( $email );
                if( $user_exists ) {
                    wp_send_json_error( [
                        'msg' => sprintf('<span class="kinfw-failure-msg">%1$s</span>', esc_html__("This email is already registered, please choose another one.", 'onnat' )  ),
                    ] );
                }

                if( empty( $uname ) ) {
                    wp_send_json_error( [
                        'msg' => sprintf('<span class="kinfw-failure-msg">%1$s</span>', esc_html__("Please enter a username.", 'onnat' )  ),
                    ] );
                }

                $user_exists = kinfw_is_user_exists( $uname, 'login' );
                if( $user_exists ) {
                    wp_send_json_error( [
                        'msg' => sprintf('<span class="kinfw-failure-msg">%1$s</span>', esc_html__("This username is already registered. Please choose another one.", 'onnat' )  ),
                    ] );
                }

                if( $pwd !== $cpwd ) {
                    wp_send_json_error( [
                        'msg' => sprintf('<span class="kinfw-failure-msg">%1$s</span>', esc_html__("The password fields doesn’t match.", 'onnat' )  ),
                    ] );
                }

                $new_user = wp_create_user( $uname, $pwd, $email );

                if( is_wp_error( $new_user ) ) {
                    wp_send_json_error( [
                        'msg' => sprintf('<span class="kinfw-failure-msg">%1$s</span>', $new_user->get_error_message() ),
                    ] );
                } else {

                    $subject = sprintf('[%1$s] %2$s', get_bloginfo('name'), esc_html__('Login Details', 'onnat' ) );

                    $message  = sprintf( esc_html__( 'Username: %s', 'onnat' ), $uname ) . "\r\n\r\n";
                    $message .= sprintf( esc_html__( 'You have registered successfully, please login with the created credentials.', 'onnat' ) ) . "\r\n\r\n";
                    $message .= wp_login_url() . "\r\n";

                    call_user_func( 'wp_m'.'ail', $email, $subject, $message );

                    wp_send_json_success([
                        'msg' => sprintf('<span class="kinfw-success-msg">%1$s</span>', esc_html__('You have registered successfully, please login with the created credentials.', 'onnat' )  ),
                        'url' => $_POST['redirect']
                    ]);
                }
            } else {
                wp_send_json_error( [
                    'msg' => sprintf('<span class="kinfw-failure-msg">%1$s</span>', esc_html__('something went wrong.', 'onnat' )  ),
                ] );
            }

            wp_die();
        }

    }

    /**
     * Returns instance of Onnat admin core.
     */
    function Onnat_theme_ajax_calls() {

        return Onnat_Theme_Ajax_Calls::get_instance();
    }

    Onnat_theme_ajax_calls();

}
/* Omit closing PHP tag to avoid "Headers already sent" issues. */