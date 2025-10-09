<?php
/**
 * Login form
 * The template part for displaying woocommerce login form
 * @version 9.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( is_user_logged_in() ) {
	return;
}

/**
 * Envato Theme Check Fixes
 */
$hidden_style = $hidden ? 'display:none;': '';
?>
<!-- #kinfw-woo-form-login-wrap -->
<div id="kinfw-woo-form-login-wrap">

    <!-- #kinfw-woo-login-form-wrap -->
    <div id="kinfw-woo-login-form-wrap">

        <form class="woocommerce-form woocommerce-form-login login" method="post" style="<?php echo apply_filters( 'kinfw-filter/theme/unit-test', $hidden_style ); ?>">

			<!-- #kinfw-woo-login-form-header -->
			<div id="kinfw-woo-login-form-header">
				<?php
					printf( '%1$s
						<h2> %2$s </h2>
						<p> %3$s </p>
						',
						kinfw_icon( 'user-single' ),
						esc_html__( 'Welcome Back!', 'onnat' ),
						sprintf( esc_html__('Use Your %1$s Account', 'onnat' ), get_bloginfo ('name') )
					);
				?>
			</div><!-- #kinfw-woo-login-form-header -->		

            <?php do_action( 'woocommerce_login_form_start' ); ?>

            <?php
				if( $message ) {
					sprintf( '<div class="kinfw-woo-global-form-login-msg"> %1$s </div>',  wpautop( wptexturize( $message ) ) );
				}
			?>

			<div class="kinfw-field-wrapper">
				<input type="text" name="username" id="username" autocomplete="username"/>
				<div class="kinfw-field-placeholder">
					<span><?php esc_html_e('Username or email address', 'onnat'); ?></span>
				</div>
			</div>

			<div class="kinfw-field-wrapper">
				<input type="password" name="password" id="password" autocomplete="current-password"/>
				<div class="kinfw-field-placeholder">
					<span><?php esc_html_e('Password', 'onnat'); ?></span>
				</div>
			</div>

			<?php do_action( 'woocommerce_login_form' ); ?>

			<div class="kinfw-field-wrapper">
				<div class="kinfw-field-login-remember-me">
					<input name="rememberme" type="checkbox" id="rememberme" value="forever"/>
					<span><?php esc_html_e( 'Remember me', 'onnat' ); ?></span>
				</div>
				<div class="kinfw-field-lost-pwd">
					<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'onnat' ); ?></a>
				</div>
			</div>

			<div class="kinfw-field-wrapper">
				<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                <input type="hidden" name="redirect" value="<?php echo esc_url( $redirect ); ?>" />
				<button type="submit" name="login" value="<?php esc_attr_e( 'Log in', 'onnat' ); ?>"><?php esc_html_e( 'Log in', 'onnat' ); ?></button>
            </div>

            <?php do_action( 'woocommerce_login_form_end' ); ?>

        </form>

    </div>

</div>