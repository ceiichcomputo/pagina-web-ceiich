<?php
/**
 * The template part for displaying kinfw-project in grid style 1.
 *
 */

$start = $end = '';

if( isset( $args['classes'] ) ) {
    $start = sprintf( '<div class="%1$s">', esc_attr( $args['classes'] ) );
    $end = '</div>';
}

echo apply_filters( 'kinfw-filter/theme/util/is-str', $start );
?>
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'kinfw-project-style-1 kinfw-project-item' ); ?>>
        <?php
            $media     = '';
            $post_id   = get_the_ID();
            $title     = get_the_title();
            $permalink = get_permalink();
            $meta      = get_post_meta( $post_id, '_kinfw_cpt_project_options', true );
            $meta      = apply_filters( 'kinfw-filter/theme/util/is-array', $meta );

            if( isset( $meta['masonry_layout_mode'] ) && isset( $meta['masonry_img'] ) && !empty( $meta['masonry_img']['url'] ) ) {
                $media = sprintf( '
                    <img src="%1$s" alt="%2$s" class="wp-post-image"/>',
                    esc_url( $meta['masonry_img']['url'] ),
                    esc_attr( $title )
                );
            } else if( has_post_thumbnail() ) {
                $media = get_the_post_thumbnail( $post_id, 'full' );
            } else {
                $media = sprintf( '
                    <img src="%1$s" alt="%2$s" class="kinfw-transparent-img"/>',
                    get_theme_file_uri( 'assets/image/public/transparent.jpg' ),
                    esc_attr( $title )
                );
            }

            printf( '<div class="kinfw-project-img">%1$s</div>', $media );

            printf( '<a href="%1$s" class="kinfw-project-icon">%2$s</a>',
                esc_url( $permalink ),
                kinfw_icon( 'arrows-simple-up-right' )
            );

            printf(
                '<div class="kinfw-project-content">
                    <h3>%1$s</h3>
                    <p>%2$s</p>
                </div>',
                esc_html( $title ),
                get_the_term_list( $post_id, 'kinfw-project-category', '', ', ', '' )
            );

        ?>
    </article>
<?php
echo apply_filters( 'kinfw-filter/theme/util/is-str', $end );