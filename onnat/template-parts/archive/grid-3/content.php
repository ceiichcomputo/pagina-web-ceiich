<?php
/**
 * The template part for displaying posts in grid style 3.
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
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'kinfw-blog-grid-style-3 kinfw-post-item' ); ?>>
        <?php
            $media = '';

            if( has_post_thumbnail() ) {

                $media = get_the_post_thumbnail( $post_id, 'full' );
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
                     * Category
                     */
                    $categories = get_the_category( $post_id );
                    if( !empty( $categories ) ) {
                        $category = $categories[0];

                        printf('
                            <div class="kinfw-meta-cat">
                                <a href="%1$s" title="%2$s">%2$s</a>
                            </div>',
                            esc_url( get_category_link( $category->term_id ) ),
                            esc_html( $category->name )
                        );                        
                    }

                    /**
                     * Date
                     */
                    printf( '
                        <div class="kinfw-meta-date">
                            <time datetime="%1$s"> %2$s </time>
                        </div>',
                        esc_attr( get_the_date( 'c' ) ),
                        get_the_date ('M d, Y')
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
                            kinfw_icon( 'onnat-line-arrow-long-right-cross' ),
                        );
                    ?>
                </div>
            </footer>
        </div>
    </article>
<?php
echo apply_filters( 'kinfw-filter/theme/util/is-str', $end );