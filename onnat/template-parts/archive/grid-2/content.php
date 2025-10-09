<?php
/**
 * The template part for displaying posts in grid style 2.
 *
 */
$start = $end = '';

if( isset( $args['classes'] ) ) {
    $start = sprintf( '<div class="%1$s">', esc_attr( $args['classes'] ) );
    $end = '</div>';
}

echo apply_filters( 'kinfw-filter/theme/util/is-str', $start );
?>
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'kinfw-blog-grid-style-2 kinfw-post-item' ); ?>>
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
                        $author_name,
                    );

                    /**
                     * Date
                     */
                    printf( '
                        <div class="kinfw-meta-date">
                            %1$s
                            <time datetime="%2$s"> %3$s </time>
                        </div>',
                        kinfw_icon( 'misc-calendar' ),
                        esc_attr( get_the_date( 'c' ) ),
                        get_the_date ('M j, Y')
                    );
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
                            '<a href="%1$s"> %2$s </a>',
                            esc_url( get_permalink() ),
                            kinfw_icon( 'chevron-simple-right' ),
                        );
                    ?>
                </div>
            </footer>
        </div>
    </article>
<?php
echo apply_filters( 'kinfw-filter/theme/util/is-str', $end );