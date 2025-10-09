<?php
/**
 * The template part for displaying posts in grid style 1.
 *
 */
$start = $end = '';

if( isset( $args['classes'] ) ) {
    $start = sprintf( '<div class="%1$s">', esc_attr( $args['classes'] ) );
    $end = '</div>';
}

echo apply_filters( 'kinfw-filter/theme/util/is-str', $start );
?>
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'kinfw-blog-grid-style-1 kinfw-post-item' ); ?>>
        <?php
            $media = '';

            if( has_post_thumbnail() ) {

                $media = get_the_post_thumbnail( get_the_ID(), 'full' );
            } else {

                $media = sprintf( '
                    <img src="%1$s" alt="%2$s" class="kinfw-transparent-img"/>',
                    get_theme_file_uri( 'assets/image/public/transparent.jpg' ),
                    get_the_title()
                );

            }

            printf( '<div class="kinfw-entry-media-wrap">
                    <div class="kinfw-entry-media">%1$s</div>
                    <div class="kinfw-meta-date">
                        <time datetime="%2$s"> %3$s </time>
                    </div>
                </div>',
                $media,
                esc_attr( get_the_date( 'c' ) ),
                get_the_date ('M j, Y')
            );
        ?>

        <div class="kinfw-entry-content-wrap">
            <div class="kinfw-entry-meta-wrap">
                <?php
                    /**
                     * Author
                     */
                    $author_id        = get_post_field( 'post_author', get_the_ID() );
                    $author_name      = get_the_author_meta( 'display_name', $author_id );
                    $author_posts_url = get_author_posts_url( $author_id );

                    printf('
                        <div class="kinfw-meta-author">
                            <a href="%1$s" title="%2$s"> %3$s <span> %4$s </span> </a>
                        </div>',
                        esc_url( $author_posts_url ),
                        sprintf( esc_html__( 'Posted by %1$s', 'onnat' ), $author_name ),
                        kinfw_icon( 'user-single' ),
                        sprintf( esc_html__( 'by %1$s', 'onnat' ), $author_name ),
                    );

                    /**
                     * Comment
                     */
                    if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {

                        $zero = sprintf( '%1$s 0 %2$s', kinfw_icon( 'comment-single' ), esc_html__( 'Comment', 'onnat' ) );
                        $one  = sprintf( '%1$s 1 %2$s', kinfw_icon( 'comment-single' ), esc_html__( 'Comment', 'onnat' ) );
                        $more = sprintf( '%1$s %2$s', kinfw_icon( 'comment-multiple' ), esc_html__( '% Comments', 'onnat' ) );
                        $none = sprintf( '%1$s %2$s', kinfw_icon( 'comment-off' ), esc_html__( 'Comments Off', 'onnat' ) );

                        printf( '<div class="kinfw-meta-comments">' );
                            comments_popup_link( $zero, $one, $more, '', $none );
                        printf( '</div>' );

                    }

                ?>
            </div>

            <header class="kinfw-entry-header">
                <?php
                    /**
                     * Title
                     */
                    the_title( '<h4 class="kinfw-entry-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h4>' );
                ?>
            </header>

            <footer class="kinfw-entry-footer">
                <div class="kinfw-entry-readmore">
                    <?php
                        printf(
                            '<a href="%1$s"> %2$s %3$s </a>',
                            esc_url( get_permalink() ),
                            esc_html__( 'Read More', 'onnat' ),
                            kinfw_icon( 'chevron-simple-right' ),
                        );
                    ?>
                </div>
            </footer>
        </div>
    </article>
<?php
echo apply_filters( 'kinfw-filter/theme/util/is-str', $end );