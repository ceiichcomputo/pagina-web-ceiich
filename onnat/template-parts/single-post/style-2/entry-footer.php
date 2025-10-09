<?php
/**
 * The template part for displaying footer section in single post.
 *
 */
?>
<?php

    /**
     * Share List
     */
        $share_list   = '';
        $social_share = kinfw_onnat_theme_options()->kinfw_get_option( 'single_post_social_share' );

        if( isset( $social_share['enabled'] ) ) {

            $post_id    = get_the_ID();
            $post_title = get_the_title();
            $post_title = wp_strip_all_tags( $post_title );
            $post_url   = get_permalink( $post_id );
            $post_url   = rawurlencode( esc_url( $post_url ) );
            $post_desc  = urlencode( wp_trim_words( strip_shortcodes( get_the_content( $post_id ) ), 50 ) );
            $post_media = wp_get_attachment_url( get_post_thumbnail_id( $post_id ) );

            foreach( $social_share['enabled'] as $key => $share ) {

                if( $key === 'facebook' ) {

                    $share_list .= sprintf('
                        <li>
                            <a title="%1$s" href="%2$s"></a>
                        </li>',
                        esc_html__( 'Share on Facebook', 'onnat' ),
                        add_query_arg( [
                            'u' => $post_url,
                        ], 'https://www.facebook.com/sharer.php' ),
                    );

                }  else if( $key === 'linkedin' ) {

                    $share_list .= sprintf('
                        <li>
                            <a title="%1$s" href="%2$s"></a>
                        </li>',
                        esc_html__( 'Share on Linkedin', 'onnat' ),
                        add_query_arg( [
                            'mini'    => true,
                            'url'     => $post_url,
                            'title'   => urlencode( $post_title ),
                            'source'  => esc_url( home_url('/') ),
                            'summary' => $post_desc,
                        ], 'https://www.linkedin.com/shareArticle' ),
                    );

                }  else if( $key === 'twitter' ) {

                    $share_list .= sprintf('
                        <li>
                            <a title="%1$s" href="%2$s"></a>
                        </li>',
                        esc_html__( 'Share on Twitter', 'onnat' ),
                        add_query_arg( [
                            'text' => urlencode( $post_title ),
                            'url'  => $post_url,
                        ], 'https://twitter.com/share' ),
                    );

                }  else if( $key === 'googlep' ) {

                    $share_list .= sprintf('
                        <li>
                            <a title="%1$s" href="%2$s"></a>
                        </li>',
                        esc_html__( 'Share on Google Plus', 'onnat' ),
                        add_query_arg( [
                            'url' => $post_url,
                        ], 'https://plus.google.com/share' ),
                    );

                }  else if( $key === 'pinterest' ) {

                    $share_list .= sprintf('
                        <li>
                            <a title="%1$s" href="%2$s"></a>
                        </li>',
                        esc_html__( 'Share on Pinterest', 'onnat' ),
                        add_query_arg( [
                            'url'         => $post_url,
                            'media'       => $post_media,
                            'description' => $post_desc,
                        ], 'https://www.pinterest.com/pin/create/button/' ),
                    );

                }  else if( $key === 'reddit' ) {

                    $share_list .= sprintf('
                        <li>
                            <a title="%1$s" href="%2$s"></a>
                        </li>',
                        esc_html__( 'Share on Reddit', 'onnat' ),
                        add_query_arg( [
                            'url'   => $post_url,
                            'title' => urlencode( $post_title ),
                        ], 'https://www.reddit.com/submit' ),
                    );

                }  else if( $key === 'tumblr' ) {

                    $share_list .= sprintf('
                        <li>
                            <a title="%1$s" href="%2$s"></a>
                        </li>',
                        esc_html__( 'Share on Tumblr', 'onnat' ),
                        add_query_arg( [
                            'canonicalUrl' => $post_url,
                        ], 'https://www.tumblr.com/widgets/share/tool' ),
                    );

                }  else if( $key === 'viadeo' ) {

                    $share_list .= sprintf('
                        <li>
                            <a title="%1$s" href="%2$s"></a>
                        </li>',
                        esc_html__( 'Share on Viadeo', 'onnat' ),
                        add_query_arg( [
                            'url' => $post_url
                        ], 'https://partners.viadeo.com/share' ),
                    );

                }  else if( $key === 'viber' ) {

                    $share_list .= sprintf('
                        <li>
                            <a title="%1$s" href="%2$s"></a>
                        </li>',
                        esc_html__( 'Share on Viber', 'onnat' ),
                        add_query_arg( [
                            'text' => $post_url,
                        ], 'viber://forward' ),
                    );

                }  else if( $key === 'vk' ) {

                    $share_list .= sprintf('
                        <li>
                            <a title="%1$s" href="%2$s"></a>
                        </li>',
                        esc_html__( 'Share on VK', 'onnat' ),
                        add_query_arg( [
                            'url' => $post_url,
                        ], 'https://vk.com/share.php' ),
                    );

                }
            }

            if(!empty( $share_list ) ) {

                $share_list = sprintf( '
                    <div class="kinfw-entry-post-social-share">
                        <p> %1$s </p>
                        <ul class="kinfw-social-links"> %2$s </ul>
                    </div>',
                    esc_html__( 'Share this', 'onnat' ),
                    $share_list,
                );

            }
        }

    /**
     * Tags List
     */
        $tags_list = get_the_tag_list(
            sprintf( '<p> %s:</p> <ul class="kinfw-post-tags-list"><li>', esc_html__( 'Posted In', 'onnat' ) ),
            _x( ', </li> <li>', 'Used between list items, there is a space after the comma.', 'onnat' ),
            '</li></ul>'
        );

        if( $tags_list ) {

            $tags_list = sprintf( '
                <div class="kinfw-entry-post-tag-list">
                    %1$s %2$s
                </div>',
                kinfw_icon( 'tag-multiple' ),
                $tags_list
            );
        }


if( $share_list || $tags_list ) {
    printf( '
        <footer class="kinfw-entry-footer">
            %1$s  %2$s
        </footer>',

        $share_list,
        $tags_list
    );
}