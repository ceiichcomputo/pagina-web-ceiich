<?php
/**
 * The header file.
 * This is the fluid container template @33
 * Used in Fluid Width Template
 * This is the template that displays all of the <head> section and everything up until #kfw-content-wrapper.
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <link rel="profile" href="http://gmpg.org/xfn/11">

        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?> <?php kinfw_schema_markup( 'html' );?>>

        <?php wp_body_open(); ?>

        <!-- #kinfw-wrap -->
        <div id="kinfw-wrap">

            <?php do_action( 'kinfw-action/theme/template/header' ); ?>

            <!-- #kinfw-smooth-wrapper -->
            <div id="kinfw-smooth-wrapper">

                <!-- #kinfw-smooth-content -->
                <div id="kinfw-smooth-content">

                    <!-- #kinfw-content-wrap -->
                    <div id="kinfw-content-wrap" <?php kinfw_schema_markup( 'main' );?>>

                        <?php do_action( 'kinfw-action/theme/template/page-title' ); ?>

                        <!-- .kinfw-container-fluid -->
                        <div class="kinfw-container-fluid">