<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Comments_Walker' ) ) {

	/**
	 * The Onnat Theme Custom Comments Walker class.
     * Hint: used to create an HTML list of comments.
	 */
    class Onnat_Theme_Comments_Walker extends Walker_Comment {

        /**
         * Outputs a comment in the HTML5 format.
         */
        protected function html5_comment( $comment, $depth, $args ) {

            $comment_id = get_comment_ID();

            printf( '<!-- comment-## -->
                <li id="comment-%s" class="kinfw-comment %s">',
                $comment_id,
                implode( ' ',get_comment_class( $this->has_children ? 'parent' : '', $comment ) )
            );

            printf( '<article id="kinfw-comment-article-%s" class="kinfw-comment-article">', $comment_id  );

                $commenter          = wp_get_current_commenter();
                $show_pending_links = ! empty( $commenter['comment_author'] );
    
                $comment_author     = get_comment_author( $comment );
                $comment_author_url = get_comment_author_url( $comment );

                $avatar_default = get_option('avatar_default');

                /**
                 * Avatar
                 */
                if ( 0 != $args['avatar_size'] ) {

                    if( $avatar_default == 'kinfw_onnat_user_avatar' ) {

                        /**
                         * for WordPress unit test fix, we have added else condition.
                         */
                        if( !empty( $comment_author_url ) ) {
                            printf( '
                                <div class="kinfw-comment-avatar">
                                    <a href="%1$s"> %2$s </a>
                                </div>',
                                esc_url( $comment_author_url ),
                                get_avatar( $comment, $args['avatar_size'], '', $comment_author )
                            );

                        } elseif( empty( $comment_author_url ) ) {
                            printf( '
                                <div class="kinfw-comment-avatar">
                                    <a href="javascript:void(0);">
                                        <img src="%1$s" alt="%2$s" class="photo avatar avatar-%3$s" height="%3$s" width="%3$s"/>
                                    </a>
                                </div>',
                                esc_url( get_theme_file_uri( 'assets/image/public/avatar.png' ) ),
                                $comment_author,
                                $args['avatar_size']
                            );
                        }

                    } else {

                        printf( '
                            <div class="kinfw-comment-avatar">
                                <a href="%1$s"> %2$s </a>
                            </div>',
                            esc_url( $comment_author_url ),
                            get_avatar( $comment, $args['avatar_size'], '', $comment_author )
                        );

                    }

                }

                /**
                 * Comment
                 */
                print ( '<div class="kinfw-comment-wrap">' );

                    /**
                     * Comment Header
                     */
                        $header = get_comment_author_link( $comment );
                        if ( '0' == $comment->comment_approved && ! $show_pending_links ) {
                            $header = get_comment_author( $comment );
                        }

                        printf( '<header class="comment-author vcard">' );
                            printf( '<cite class="fn">%s</cite>', $header );

                            printf( '<div class="kinfw-comment-metadata">' );

                                printf(
                                    '<time datetime="%s">%s</time>',
                                    get_comment_time( 'c' ),
                                    sprintf(
                                        /* translators: 1: Comment date, 2: Comment time. */
                                        esc_html__( '%1$s at %2$s', 'onnat' ),
                                        get_comment_date( '', $comment ),
                                        get_comment_time()
                                    )
                                );

                                edit_comment_link( esc_html__( 'Edit', 'onnat' ) );

                                $this->kinfw_delete_comment_link( esc_html__( 'Delete', 'onnat' ) );


                            print ( '</div>' );

                        print ( '</header>' );

                    /**
                     * Comment Body
                     */
                        print ( '<div class="comment-body">' );
                            comment_text();

                            if ( '0' === $comment->comment_approved ) {
                                printf( '<p class="comment-awaiting-moderation">%1$s</p>', esc_html__( 'Your comment is awaiting moderation.', 'onnat' ) );
                            }                            
                        print ( '</div>' );

                    /**
                     * Reply Link
                     */
                    if ( '1' == $comment->comment_approved || $show_pending_links ) {
                        comment_reply_link(array_merge( $args, [
                            'add_below' => 'kinfw-comment-article',
                            'depth'     => $depth,
                            'max_depth' => $args['max_depth'],
                            'before'    => '<nav class="comment-reply-nav">',
                            'after'     => '</nav>',
                        ] ) );
                    }

                print ( '</div>' );

            print ( '</article>' );

        }

        /**
         * Displays the delete comment link with formatting.
         *
         * @param string $text   Optional. Anchor text. If null, default is 'Edit This'. Default null.
         * @param string $before Optional. Display before edit link. Default empty.
         * @param string $after  Optional. Display after edit link. Default empty.
         */
        public function kinfw_delete_comment_link( $text = null, $before = '', $after = '' ) {

            $comment    = get_comment();
            $comment_ID = $comment->comment_ID;

            if ( ! current_user_can( 'moderate_comments', $comment_ID ) ) {
                return;
            }

            if ( null === $text ) {
                $text = esc_html__( 'Delete This', 'onnat' );
            }

            $url  = add_query_arg( [
                'action'   => 'trashcomment',
                '_wpnonce' => wp_create_nonce( 'delete-comment_' . $comment_ID ),
                'c'        => $comment_ID,
                'p'        => $comment->comment_post_ID,
            ], admin_url( 'comment.php' ) );

            $link = '<a class="comment-delete-link" href="' . esc_url( $url ) . '">' . $text . '</a>';

            printf( 
                '%1$s %2$s %3$s',
                $before,
                apply_filters( 'kinfw-filter/theme/comments/delete/link', $link, $comment->comment_ID, $text ),
                $after
            );
        }

    }

}
/* Omit closing PHP tag to avoid "Headers already sent" issues. */