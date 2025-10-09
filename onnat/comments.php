<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

echo '<div class="margin"> </div>';

echo '<!-- .kinfw-comment-area -->';
echo '<div class="kinfw-comment-area">';

    if( have_comments() ) {

        $comments_number = number_format_i18n( get_comments_number() );

        if ( '1' === $comments_number ) {
            /* translators: %s: post title */
            $comments_title = sprintf(
                _x( '1 thought on &ldquo;%s&rdquo;', 'comments title', 'onnat' ),
                esc_html( get_the_title() )
            );
        } else {
            /* translators: 1: number of comments, 2: post title */
            $comments_title = sprintf( _nx(
                    '%1$s thought on &ldquo;%2$s&rdquo;',
                    '%1$s thoughts on &ldquo;%2$s&rdquo;',
                    $comments_number,
                    'comments title',
                    'onnat'
                ),
                $comments_number,
                esc_html( get_the_title() )
            );
        }

        echo '<!-- .kinfw-comment -->';
        echo '<div id="comments" class="kinfw-comment">';

            $comments_title = apply_filters( 'kinfw-filter/theme/comments/title', $comments_title );
            printf( '<h5 class="kinfw-comments-title"> %s </h5>', $comments_title );

            echo '<!-- .kinfw-comments-list-wrap -->';
            echo '<div class="kinfw-comments-list-wrap">';

                echo '<ol class="kinfw-comment-list">';
                    wp_list_comments([
                        'style'       => 'ol',
                        'format'      => 'html5',
                        'avatar_size' => 80,
                        'short_ping'  => true,
                        'walker'      => new Onnat_Theme_Comments_Walker()
                    ]);
                echo '</ol>';

                $comment_pagination = paginate_comments_links([
                    'echo'      => false,
                    'end_size'  => 0,
                    'mid_size'  => 0,
                    'next_text' => esc_html__( 'Newer Comments', 'onnat' ),
                    'prev_text' => esc_html__( 'Older Comments', 'onnat' ),
                ]);

                if ( $comment_pagination ) {
                    $pagination_classes = '';

                    // If we're only showing the "Next" link, add a class indicating so.
                    if ( false === strpos( $comment_pagination, 'prev page-numbers' ) ) {
                        $pagination_classes = 'only-next';
                    }

                    echo '<nav class="kinfw-comments-pagination pagination '.esc_attr( $pagination_classes ).'">';
                        echo wp_kses_post( $comment_pagination );
                    echo '</nav>';
                }

            echo '</div> <!-- /.kinfw-comments-list-wrap -->';

        echo '</div> <!-- /.kinfw-comment -->';

    }

    if ( comments_open() || pings_open() ) {

        $req       = get_option( 'require_name_email' );
        $html_req  = ( $req ? " required='required'" : '' );
        $commenter = wp_get_current_commenter();

        $fields    = [
            'author' => sprintf('<!-- .kinfw-row -->
                <div class="kinfw-row">
                    <div class="kinfw-col-12 kinfw-col-md-4">
                        <input id="author" name="author" type="text" value="%s" size="30" maxlength="245" placeholder="%s" autocomplete="name" %s/>
                    </div>',
                    esc_attr( $commenter['comment_author'] ),
                    esc_attr__('Name *', 'onnat' ),
                    $html_req
            ),
            'email'  => sprintf('
                <div class="kinfw-col-12 kinfw-col-md-4">
                    <input id="email" name="email" type="email" value="%s" size="30" maxlength="100" placeholder="%s" autocomplete="email" %s/>
                </div>',
                esc_attr( $commenter['comment_author_email'] ),
                esc_attr__('Email *', 'onnat' ),
                $html_req
            ),
            'url'    => sprintf('
                    <div class="kinfw-col-12 kinfw-col-md-4">
                    <input id="url" name="url" type="url" value="%s" size="30" maxlength="200" placeholder="%s" autocomplete="url"/>
                    </div>
                </div> <!-- /.kinfw-row -->',
                esc_attr( $commenter['comment_author_url'] ),
                esc_attr__('Website', 'onnat' ),
            ),
        ];

        comment_form([
            'id_form'            => 'kinfw-commentform',
            'title_reply'        => esc_html__( 'Leave a Comment', 'onnat'),
            'title_reply_before' => '<h5 id="kinfw-reply-title" class="kinfw-comment-reply-title">',
            'title_reply_after'  => '</h5>',
            'fields'             => apply_filters( 'comment_form_default_fields', $fields ),
            'comment_field'      => sprintf('
                <div class="kinfw-row">
                    <div class="kinfw-col-12">
                        <textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" placeholder="%s" required="required"></textarea>
                    </div>
                </div>', esc_attr__('Comment *', 'onnat' )
            ),
            'submit_field'       => '<p class="kinfw-form-submit-button kinfw-comment-form-submit-button">%1$s %2$s</p>',
        ]);

    } elseif ( is_single() ) {

        echo '<!-- #respond -->';
        echo '<div class="comment-respond" id="respond">';
            printf( '<p class="kinfw-comments-closed"> %s </p>', esc_html( 'Comments are closed.', 'onnat' ) );
        echo '</div>';
        echo '<!-- /#respond -->';

    }

echo '</div>';
echo '<!-- /.kinfw-comment-area -->';
/* Omit closing PHP tag to avoid "Headers already sent" issues. */