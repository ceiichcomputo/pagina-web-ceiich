<?php
/**
 * The template part for displaying posts in grid style 4.
 *
 */
$post_id = get_the_ID();
$start   = $end = '';

if( isset( $args['classes'] ) ) {
    $start = sprintf( '<div class="%1$s">', esc_attr( $args['classes'] ) );
    $end = '</div>';
}

echo apply_filters( 'kinfw-filter/theme/util/is-str', $start );
?>
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'kinfw-blog-grid-style-4 kinfw-post-item' ); ?>>
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

            printf( '<div class="kinfw-entry-media-wrap"> <div class="kinfw-entry-media">%1$s</div> </div>', $media );
        ?>

        <div class="kinfw-entry-content-wrap">
            <div class="kinfw-entry-meta-wrap">
                <?php
                    /**
                     * Date
                     */
                    printf( '
                        <div class="kinfw-meta-date">
                            <time datetime="%1$s">
                                <span class="kinfw-meta-day">%2$s</span><span class="kinfw-meta-month">%3$s</span>
                            </time>
                        </div>',
                        esc_attr( get_the_date( 'c' ) ),
                        get_the_date ('d', $post_id ),
                        get_the_date ('/M', $post_id )
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
        </div>
    </article>
<?php
echo apply_filters( 'kinfw-filter/theme/util/is-str', $end );