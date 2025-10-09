<?php
/**
 * The template part for displaying posts in author archive.
 *
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'kinfw-author-archive kinfw-post-item' ); ?>>

    <div class="kinfw-entry-content-wrap">

        <div class="kinfw-entry-meta-wrap">
            <?php

                /**
                 * Category
                 */
                $categories_list = get_the_category_list(', ');
                if ( $categories_list ) {

                    printf( '
                        <div class="kinfw-meta-cat">
                            %1$s
                            <ul class="kinfw-post-cats-list">
                                <li>
                                    %2$s
                                </li>
                            </ul>
                        </div>',
                        kinfw_icon( 'misc-layers' ),
                        str_replace( ', ', ', </li> <li>', $categories_list )
                    );

                }

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
                    get_the_date ( get_option('date_format') )
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
                the_title( '<h4 class="kinfw-entry-title"> <a href="' . esc_url( get_permalink() ) . '">', '</a></h4>' );
            ?>
        </header>

        <div class="kfw-entry-content">
            <?php
                the_excerpt();
            ?>
        </div>

    </div>

</article>