<?php
/**
 * The template part for displaying a message that posts cannot be found.
 **/
?>
<article class="kinfw-no-results kinfw-post-item kinfw-no-results-post-item">

    <div class="kinfw-entry-footer-wrap">
        <h4 class="kinfw-entry-title">
            <?php
                if( is_search() ) :
                    esc_html_e( 'No Results Found', 'onnat');

                else :
                    esc_html_e( 'No Posts Found', 'onnat');

                endif;
            ?>
        </h4>
    </div>

    <div class="kinfw-entry-excerpt">

        <?php
            if( is_home() && current_user_can( 'publish_posts' ) ) :

                printf( '<p> %1$s <a href="%2$s">%3$s</a>.</p>',
                    esc_html__( 'Ready to publish your first post?', 'onnat' ),
                    esc_url( admin_url( 'post-new.php' ) ),
                    esc_html__( 'Get started here', 'onnat' )
                );

            elseif( is_search() ) :

                $fallback_content = kinfw_onnat_theme_options()->kinfw_get_option( 'search_result_fallback_content' );
                $fallback_content = apply_filters( 'kinfw-filter/theme/output/search/fallback-content', $fallback_content );

                printf( '<p> %1$s </p>', $fallback_content );
                get_search_form();

                printf(
                    '<a href="%1$s" class="button kinfw-back-button">%2$s </a>',
                    esc_url( home_url() ),
                    esc_html__('Back To Home', 'onnat' )
                );

            else:

                printf( '<p> %1$s </p>', esc_html__( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'onnat' ) );
                get_search_form();
            endif;
        ?>
    </div>

</article>