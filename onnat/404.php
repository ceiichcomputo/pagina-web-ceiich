<?php
/**
 * The template for displaying 404 pages (not found).
 */

get_header();

$main_txt   = kinfw_onnat_theme_options()->kinfw_get_option( '404_main_text' );
$sub_txt    = kinfw_onnat_theme_options()->kinfw_get_option( '404_sub_text' );
$content    = kinfw_onnat_theme_options()->kinfw_get_option( '404_content' );
$use_button = kinfw_onnat_theme_options()->kinfw_get_option( 'use_go_home_btn' );


?>
<!-- #kinfw-main-content -->
<div id="kinfw-main-content" class="kinfw-has-no-sidebar">

    <!-- #primary -->
    <div id="primary" class="kinfw-content-holder">
        <div class="kinfw-error-404">

            <h2 class="kinfw-error-404-main-text">
                <?php
                    echo esc_html( $main_txt );
                ?>
            </h2>

            <h3 class="kinfw-error-404-sub-text">
                <?php
                    echo esc_html( $sub_txt );
                ?>
            </h3>

            <div class="kinfw-error-404-content">
                <?php
                    echo wp_kses_post( $content );
                ?>
            </div>

            <?php

                if( $use_button ) {

                    $btn_text = kinfw_onnat_theme_options()->kinfw_get_option( 'go_home_btn_text' );

                    if( !empty( $btn_text ) ) {

                        printf( '<a href="%1$s" class="button kinfw-error-404-back-button">%2$s </a>',
                            esc_url( home_url() ),
                            $btn_text
                        );

                    }

                }

            ?>

        </div>
    </div><!-- /#primary -->

</div><!-- /#kinfw-main-content -->
<?php
get_footer();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */