<?php
/**
 * The template part for displaying woocommerce customer edit ccount form
 * @version 9.7.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_edit_account_form' );
?>
<div id="kinfw-woo-edit-account-form">

    <form action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?>>
        <?php do_action( 'woocommerce_edit_account_form_start' ); ?>

        <div class="kinfw-row">
            <div class="kinfw-col-lg-6 kinfw-col-12">
                <div class="kinfw-field-wrapper">
                    <input type="text" name="account_first_name" id="account_first_name" value="<?php echo esc_attr( $user->first_name ); ?>"/>
                    <div class="kinfw-field-placeholder">
                        <span><?php esc_html_e('First Name', 'onnat'); ?> <span class="required">*</span> </span>
                    </div>
                </div>
            </div>
            <div class="kinfw-col-lg-6 kinfw-col-12">
                <div class="kinfw-field-wrapper">
                    <input type="text" name="account_last_name" id="account_last_name" value="<?php echo esc_attr( $user->last_name ); ?>"/>
                    <div class="kinfw-field-placeholder">
                        <span><?php esc_html_e('Last Name', 'onnat'); ?> <span class="required">*</span> </span>
                    </div>
                </div>
            </div>
        </div>

		<div class="kinfw-field-wrapper">
            <input type="text" name="account_display_name" id="account_display_name" value="<?php echo esc_attr( $user->display_name ); ?>"/>
            <div class="kinfw-field-placeholder">
                <span><?php esc_html_e('Display Name', 'onnat'); ?> <span class="required">*</span> </span>
            </div>
        </div>

        <span class="kinfw-form-notice"><em><?php esc_html_e( 'This will be how your name will be displayed in the account section and in reviews', 'onnat' ); ?></em></span>

		<div class="kinfw-field-wrapper">
            <input type="email" name="account_email" id="account_email" value="<?php echo esc_attr( $user->user_email ); ?>"/>
            <div class="kinfw-field-placeholder">
                <span><?php esc_html_e('Email address', 'onnat'); ?> <span class="required">*</span> </span>
            </div>
        </div>

        <fieldset>
            <legend><?php esc_html_e( 'Password change', 'onnat' ); ?></legend>

            <div class="kinfw-field-wrapper">
                <input type="password" name="password_current" id="password_current" autocomplete="off"/>
                <div class="kinfw-field-placeholder">
                    <span><?php esc_html_e('Current password', 'onnat'); ?></span>
                </div>
            </div>
            <span class="kinfw-form-notice"><em><?php esc_html_e( 'Leave blank to leave unchanged.', 'onnat' ); ?></em></span>

            <div class="kinfw-field-wrapper">
                <input type="password" name="password_1" id="password_1" autocomplete="off"/>
                <div class="kinfw-field-placeholder">
                    <span><?php esc_html_e('New password', 'onnat'); ?></span>
                </div>
            </div>
            <span class="kinfw-form-notice"><em><?php esc_html_e( 'Leave blank to leave unchanged.', 'onnat' ); ?></em></span>

            <div class="kinfw-field-wrapper">
                <input type="password" name="password_2" id="password_2" autocomplete="off"/>
                <div class="kinfw-field-placeholder">
                    <span><?php esc_html_e('Confirm new password', 'onnat'); ?></span>
                </div>
            </div>

        </fieldset>

        <?php do_action( 'woocommerce_edit_account_form' ); ?>

		<div class="kinfw-field-wrapper">
            <?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
            <input type="hidden" name="action" value="save_account_details" />
            <button type="submit" class="woocommerce-Button button" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'onnat' ); ?>"><?php esc_html_e( 'Save changes', 'onnat' ); ?></button>
        </div>

        <?php do_action( 'woocommerce_edit_account_form_end' ); ?>
    </form>
</div>
<?php
do_action( 'woocommerce_after_edit_account_form' );
/* Omit closing PHP tag to avoid "Headers already sent" issues. */