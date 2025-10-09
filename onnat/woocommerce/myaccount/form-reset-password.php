<?php
/**
 * Lost password reset form.
 * The template part for displaying woocommerce lost password reset form.
 * @version 9.2.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_reset_password_form' );
?>

<!-- #kinfw-woo-lost-reset-password-form-wrap -->
<div id="kinfw-woo-lost-reset-password-form-wrap">

    <!-- #kinfw-woo-lost-reset-password-header -->
    <div id="kinfw-woo-lost-reset-password-form-header">
        <?php
            printf( '%1$s
                <h2> %2$s </h2>
                <p> %3$s </p>
                ',
                kinfw_icon( 'user-single' ),
                esc_html__( 'Reset Password', 'onnat' ),
                apply_filters( 'woocommerce_reset_password_message', esc_html__( 'Enter a new password below.', 'onnat' ) )
            );
        ?>
    </div><!-- /#kinfw-woo-lost-reset-password-header -->

    <form method="post" class="lost_reset_password">
        <div class="kinfw-field-wrapper">
            <div class="woocommerce-password-strength"></div>
            <div class="woocommerce-password-hint"></div>
        </div>

        <div class="kinfw-field-wrapper">
            <input type="password" name="password_1" id="password_1" autocomplete="new-password"/>
            <div class="kinfw-field-placeholder">
                <span><?php esc_html_e('New password', 'onnat'); ?></span>
			</div>
        </div>

        <div class="kinfw-field-wrapper">
            <input type="password" name="password_2" id="password_2" autocomplete="new-password"/>
            <div class="kinfw-field-placeholder">
                <span><?php esc_html_e('Re-enter new password', 'onnat'); ?></span>
			</div>
        </div>

        <?php do_action( 'woocommerce_resetpassword_form' ); ?>

        <input type="hidden" name="reset_key" value="<?php echo esc_attr( $args['key'] ); ?>"/>
        <input type="hidden" name="reset_login" value="<?php echo esc_attr( $args['login'] ); ?>"/>

		<div class="kinfw-field-wrapper">
            <?php wp_nonce_field( 'reset_password', 'woocommerce-reset-password-nonce' ); ?>
            <input type="hidden" name="wc_reset_password" value="true"/>
            <button type="submit" value="<?php esc_attr_e( 'Save', 'onnat' ); ?>"><?php esc_html_e( 'Save', 'onnat' ); ?></button>
        </div>

    </form>

</div><!-- /#kinfw-woo-lost-reset-password-form-wrap -->

<?php
do_action( 'woocommerce_after_reset_password_form' );
/* Omit closing PHP tag to avoid "Headers already sent" issues. */