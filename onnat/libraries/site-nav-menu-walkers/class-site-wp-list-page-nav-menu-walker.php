<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_WP_List_Pages_Nav_Menu_Walker' ) ) {

    class Onnat_Theme_WP_List_Pages_Nav_Menu_Walker extends Walker_Page {

        public function start_lvl( &$output, $depth = 0, $args = [] ) {
            if ( isset( $args['item_spacing'] ) && 'preserve' === $args['item_spacing'] ) {
                $t = "\t";
                $n = "\n";
            } else {
                $t = '';
                $n = '';
            }
            $indent  = str_repeat( $t, $depth );
            $output .= "{$n}{$indent}<ul class='sub-menu children'>{$n}";
        }

        public function start_el( &$output, $data_object, $depth = 0, $args = [], $current_object_id = 0 ) {

            // Restores the more descriptive, specific name for use within this method.
            $page            = $data_object;
            $current_page_id = $current_object_id;

            if ( isset( $args['item_spacing'] ) && 'preserve' === $args['item_spacing'] ) {
                $t = "\t";
                $n = "\n";
            } else {
                $t = '';
                $n = '';
            }
            if ( $depth ) {
                $indent = str_repeat( $t, $depth );
            } else {
                $indent = '';
            }

            $css_class = [ 'menu-item', 'page_item', 'page-item-' . $page->ID ];

            if ( isset( $args['pages_with_children'][ $page->ID ] ) ) {
                $css_class[] = 'menu-item-has-children page_item_has_children';
            }

            if ( ! empty( $current_page_id ) ) {
                $_current_page = get_post( $current_page_id );

                if ( $_current_page && in_array( $page->ID, $_current_page->ancestors, true ) ) {
                    $css_class[] = 'current_page_ancestor';
                }

                if ( $page->ID === (int) $current_page_id ) {
                    $css_class[] = 'current_page_item';
                } elseif ( $_current_page && $page->ID === $_current_page->post_parent ) {
                    $css_class[] = 'current_page_parent';
                }
            } elseif ( (int) get_option( 'page_for_posts' ) === $page->ID ) {
                $css_class[] = 'current_page_parent';
            }

            /**
             * Filters the list of CSS classes to include with each page item in the list.
             *
             * @since 2.8.0
             *
             * @see wp_list_pages()
             *
             * @param string[] $css_class       An array of CSS classes to be applied to each list item.
             * @param WP_Post  $page            Page data object.
             * @param int      $depth           Depth of page, used for padding.
             * @param array    $args            An array of arguments.
             * @param int      $current_page_id ID of the current page.
             */
            $css_classes = implode( ' ', apply_filters( 'page_css_class', $css_class, $page, $depth, $args, $current_page_id ) );
            $css_classes = $css_classes ? ' class="' . esc_attr( $css_classes ) . '"' : '';

            if ( '' === $page->post_title ) {
                /* translators: %d: ID of a post. */
                $page->post_title = sprintf( esc_html__( '#%d (no title)', 'onnat' ), $page->ID );
            }

            $args['link_before'] = empty( $args['link_before'] ) ? '' : $args['link_before'];
            $args['link_after']  = empty( $args['link_after'] ) ? '' : $args['link_after'];

            $atts                 = [];
            $atts['href']         = get_permalink( $page->ID );
            $atts['aria-current'] = ( $page->ID === (int) $current_page_id ) ? 'page' : '';

            /**
             * Filters the HTML attributes applied to a page menu item's anchor element.
             *
             * @since 4.8.0
             *
             * @param array $atts {
             *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
             *
             *     @type string $href         The href attribute.
             *     @type string $aria-current The aria-current attribute.
             * }
             * @param WP_Post $page            Page data object.
             * @param int     $depth           Depth of page, used for padding.
             * @param array   $args            An array of arguments.
             * @param int     $current_page_id ID of the current page.
             */
            $atts = apply_filters( 'page_menu_link_attributes', $atts, $page, $depth, $args, $current_page_id );

            $attributes = '';
            foreach ( $atts as $attr => $value ) {
                if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
                    $value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }

            $output .= $indent . sprintf(
                '<li%s><a%s>%s%s%s</a>',
                $css_classes,
                $attributes,
                $args['link_before'],
                /** This filter is documented in wp-includes/post-template.php */
                apply_filters( 'the_title', $page->post_title, $page->ID ),
                $args['link_after']
            );

            if ( ! empty( $args['show_date'] ) ) {
                if ( 'modified' === $args['show_date'] ) {
                    $time = $page->post_modified;
                } else {
                    $time = $page->post_date;
                }

                $date_format = empty( $args['date_format'] ) ? '' : $args['date_format'];
                $output     .= ' ' . mysql2date( $date_format, $time );
            }
        }
    }
}
/* Omit closing PHP tag to avoid "Headers already sent" issues. */