<?php
/**
 * The template part for displaying kinfw-team-member in grid style 2.
 *
 */

$post_id           = get_the_ID();
$post_title        = get_the_title( $post_id );
$post_link         = get_permalink( $post_id );
$terms_list        = get_the_term_list( $post_id, 'kinfw-team-group', '', ', ', '' );
$terms_list_return = '';
?>
<div class="<?php echo esc_attr( $args['classes'] );?>">
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'kinfw-team-member-grid-style-5 kinfw-team-member-item' ); ?>>
    <?php

        /**
         * Media
         */
            $media = '';

            if( has_post_thumbnail( $post_id ) ) {
                $media = get_the_post_thumbnail( $post_id, 'full' );
            } else {
                $media = sprintf( '
                    <img src="%1$s" alt="%2$s" class="kinfw-transparent-img"/>',
                    get_theme_file_uri( 'assets/image/public/transparent.jpg' ),
                    $post_title
                );
            }

            printf( '<div class="kinfw-team-member-image-wrap">%s</div>', $media );

        /**
         * Social Links
         */
            $social_order        = kinfw_onnat_theme_options()->kinfw_get_option( 'single_team_member_social_share' );
            $active_social_share = isset( $social_order['enabled'] ) ? apply_filters( 'kinfw-filter/theme/util/is-array', $social_order['enabled'] ) : [];

            $meta  = get_post_meta( $post_id, '_kinfw_cpt_team_member_options', true );
            $meta  = apply_filters( 'kinfw-filter/theme/util/is-array', $meta );

            $links = [];
            foreach( $active_social_share as $social_id => $social_name ) {
                if( isset( $meta[ $social_id ] ) && !empty( $meta[ $social_id ] ) ) {
                    $links[ $social_id ] = $meta[ $social_id ];
                }
            }

            if( count( $links ) ) {
                echo '<ul class="kinfw-social-links">';
                    foreach( $links as $social_id => $social_link ) {
                        printf( '<li> <a href="%s"></a> </li>', $social_link );
                    }
                echo '</ul>';
            }

        /**
         * Content Wrap
         */
            printf( '
                <div class="kinfw-team-member-content-wrap">
                    <h6><a href="%s">%s</a></h6>
                    %s
                </div>',
                esc_url( $post_link ),
                esc_html( $post_title ),
                $terms_list ? sprintf( '<p>%s</p>', $terms_list ) : ''
            );
    ?>
    </article>
</div>