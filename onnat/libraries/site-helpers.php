<?php
/**
 * Theme helper functions used all over the theme.
 *
 */

if ( !function_exists( 'kinfw_debug' ) ) {

    /**
     * Debug function
     *
     * @param mixed $input Item to debug.
     */
    function kinfw_debug( $input ) {
        echo '<pre>';
            var_dump( $input );
        echo '</pre>';
    }
}

if( !function_exists( 'kinfw_schema_markup' ) ) {

    /**
     * HTML schema markup
     *
     * @param string $location Microdata location
     */
    function kinfw_schema_markup( $location ) {

        $schema = '';

        switch ( $location ) {

            case 'html':

                if ( is_home() || is_front_page() ) {
                    $schema = 'itemscope itemtype="https://schema.org/WebPage"';
                } elseif ( is_category() || is_tag() ) {
                    $schema = 'itemscope itemtype="https://schema.org/Blog"';
                } elseif ( is_singular( 'post' ) ) {
                    $schema = 'itemscope itemtype="https://schema.org/Article"';
                } elseif ( is_page() ) {
                    $schema = 'itemscope itemtype="https://schema.org/WebPage"';
                } else {
                    $schema = 'itemscope itemtype="https://schema.org/WebPage"';
                }
            break;

            case 'header':
                $schema = 'itemscope itemtype="https://schema.org/WPHeader"';
            break;

            case 'main':
                $schema = 'itemscope itemtype="https://schema.org/WebPageElement"';
            break;

            case 'nav':
                $schema = 'itemscope itemtype="https://schema.org/SiteNavigationElement"';
            break;

            case 'sidebar':
                $schema = 'itemscope itemtype="https://schema.org/WPSideBar"';
            break;

            case 'footer':
                $schema = 'itemscope itemtype="https://schema.org/WPFooter"';
            break;

        }

        if( !empty( $schema ) ) {
            echo apply_filters( 'kinfw-filter/theme/schema-markup/microdata', $schema );
        }
    }
}

if ( !function_exists( 'kinfw_is_elementor_callable' ) ) {

    /**
     *  Check Elementor Plugin is callable
     *
     * @return bool The Elementor Plugin is activated or not.
     */
    function kinfw_is_elementor_callable() {
        return ( defined( 'ELEMENTOR_VERSION' ) && is_callable( 'Elementor\Plugin::instance' ) ) ? true : false;
    }
}

if ( !function_exists( 'kinfw_is_elements_style_exists' ) ) {
    /**
     * kinfw-onnat-elements.css - exists in a active theme.
     */
    function kinfw_is_elements_style_exists() {
        $stylesheet = get_stylesheet_directory() . '/kinfw-onnat-elements.css';

        if( file_exists( $stylesheet ) ) {
            return get_theme_file_uri(  'kinfw-onnat-elements.css' );
        }

        return;
    }
}

if ( !function_exists( 'kinfw_is_woo_active' ) ) {
    /**
     * Check WooCommerce Plugin is active
     */
    function kinfw_is_woo_active() {

        return class_exists('WooCommerce') ? true : false;
    }
}


if( !function_exists( 'kinfw_action_search_trigger' ) ) {
    function kinfw_action_search_trigger() {

        return sprintf('<!-- .kinfw-header-search-trigger -->
            <div class="kinfw-header-search-trigger">
                %1$s
            </div><!-- /.kinfw-header-search-trigger -->',
            kinfw_icon( 'misc-search', 'kinfw-header-element' ),
        );

    }
}

if( !function_exists( 'kinfw_action_search_form' ) ) {
    function kinfw_action_search_form() {

        get_template_part( 'header-templates/search-form/search-form' );

    }
}

if( !function_exists( 'kinfw_action_user_login_trigger' ) ) {
    function kinfw_action_user_login_trigger() {
        global $wp;

        $return = '';

        $return .= '<!-- .kinfw-header-login-trigger -->';
            $return .= '<div class="kinfw-header-login-trigger">';
            if ( is_user_logged_in() ) {
                $current_user    = wp_get_current_user();
                $current_user_id = $current_user->ID;
                $user_image      = get_avatar( $current_user_id, 28 );

                if( $user_image ) {
                    $return .= sprintf( '<span class="kinfw-header-element kinfw-user-avatar">%1$s</span>', $user_image );
                } else {
                    $return .= kinfw_icon( 'user-single', 'kinfw-header-element' );
                }

                /**
                 * User Nav Menu
                 */
                    $nav_menu_items = apply_filters( 'kinfw-filter/theme/header/action/user-nav-items',[
                        'logout' => [
                            'url'  => wp_logout_url( home_url( add_query_arg( [], $wp->request ) ) ),
                            'text' => esc_html__( 'Log Out', 'onnat' )
                        ]
                    ] );

                    $return .= '<ul class="kinfw-header-user-nav">';
                    foreach( $nav_menu_items as $menu_items ) {
                        $return .= sprintf( '<li><a href="%1$s">%2$s</a></li>',
                            esc_url( $menu_items['url'] ),
                            esc_html( $menu_items['text'] )
                        );
                    }
                    $return .= '</ul>';

            } else {
                $return .= kinfw_icon( 'user-single', 'kinfw-header-element kinfw-header-login-user-trigger' );
            }
            $return .= '</div>';
        $return .= '<!-- .kinfw-header-login-trigger -->';

        return $return;
    }
}

if( !function_exists( 'kinfw_action_user_login_form' ) ) {
    function kinfw_action_user_login_form() {
        get_template_part( 'header-templates/login-form/login-form' );
    }
}

if( !function_exists( 'kinfw_action_hamburger_trigger' ) ) {
    function kinfw_action_hamburger_trigger() {

        return sprintf('<!-- .kinfw-header-hamburger-btn-trigger -->
            <div class="kinfw-header-hamburger-btn-trigger">
                %1$s
            </div><!-- /.kinfw-header-hamburger-btn-trigger -->',
            kinfw_icon( 'onnat-humburger', 'kinfw-header-element' ),
        );
    }
}

if( !function_exists( 'kinfw_action_woo_min_cart_trigger' ) ) {
    function kinfw_action_woo_min_cart_trigger() {

        $is_woo_active = kinfw_is_woo_active();

        if( $is_woo_active ) {

            $cart       = WC()->cart;
            $count      = !is_null( $cart ) ? esc_html( $cart->get_cart_contents_count() ) : '';
            $count_html = sprintf( '<span class="kinfw-header-cart-count %1$s">%2$s</span>',
                $count ? 'kinfw-show': 'kinfw-hidden',
                $count
            );

            $cart_link       = 'javascript:void(0);';
            $cart_link_class = 'kinfw-header-mini-cart-a-trigger';


            if( apply_filters('woocommerce_widget_cart_is_hidden', is_cart() || is_checkout()) ) {
                $cart_link       = esc_url( wc_get_cart_url() );
                $cart_link_class = '';
            }

            return sprintf('<!-- .kinfw-header-mini-cart-trigger -->
                <div class="kinfw-header-mini-cart-trigger">
                    <a href="%1$s" class="%2$s"> %3$s %4$s </a>
                </div> <!-- .kinfw-header-mini-cart-trigger -->',
                $cart_link,
                $cart_link_class,
                kinfw_icon( 'shopping-bag', 'kinfw-header-element' ),
                $count_html
            );
        }

    }
}

if( !function_exists( 'kinfw_action_header_mini_cart' ) ) {
    function kinfw_action_header_mini_cart() {
        if (!apply_filters('woocommerce_widget_cart_is_hidden', is_cart() || is_checkout())) {
            get_template_part( 'header-templates/mini-cart/mini-cart' );
        }
    }
}

if( !function_exists( 'kinfw_action_woo_yith_wishlist_trigger' ) ) {
    function kinfw_action_woo_yith_wishlist_trigger() {

        $return     = '';
        $count_html = '';

        if( function_exists( 'yith_wcwl_count_all_products' ) ) {
            $count      = yith_wcwl_count_all_products();
            $count_html = sprintf( '<span class="kinfw-header-wishlist-count %1$s">%2$s</span>',
                $count ? 'kinfw-show': 'kinfw-hidden',
                $count
            );

            $return = sprintf( '<!-- .kinfw-header-wishlist-trigger -->
                <div class="kinfw-header-wishlist-trigger">
                    <a href="%1$s" class="kinfw-header-wishlist-a-trigger"> %2$s %3$s </a>
                </div> <!-- / .kinfw-header-wishlist-trigger -->',
                esc_url( get_permalink( get_option( 'yith_wcwl_wishlist_page_id' ) ) ),
                kinfw_icon( 'heart-regular', 'kinfw-header-element' ),
                $count_html
            );
        }

        return $return;

    }
}

if( !function_exists( 'kinfw_elementor_doc_content' ) ) {
    function kinfw_elementor_doc_content( $doc_id ) {
        $check_elementor = kinfw_is_elementor_callable();

        if( !empty( $doc_id ) ) {
            if( $check_elementor ) {
                $elementor        = \Elementor\Plugin::instance();
                $is_elementor_doc = $elementor->documents->get( $doc_id )->is_built_with_elementor();

                $template = $is_elementor_doc
                    ? $elementor->frontend->get_builder_content_for_display( $doc_id )
                    : get_the_content(null,false, $doc_id );

                return $template;
            } else {
                $template = get_the_content(null,false, $doc_id );
                return $template;
            }
        }

        return;
    }
}

if( !function_exists( 'kinfw_is_user_exists' ) ) {
    function kinfw_is_user_exists( $data = '', $key = 'email' ) {
        if( empty( $data ) ) {
            return false;
        }

        $user = get_user_by( $key, $data );
        if( $user ) {
            return $user->ID;
        } else {
            return false;
        }
    }
}

if( !function_exists( 'kinfw_bg_opt_css' ) ) {

    /**
     * To genereate background css
     * @param string $css inline css for background settings
     */
    function kinfw_bg_opt_css( $option = [] ) {
        $css        = '';
        $properties = [ 'color', 'image', 'position', 'repeat', 'attachment', 'size'];

        foreach( $properties as $property ) {

            $property = 'background-'. $property;

            if( isset( $option[ $property ] ) && !empty( $option[ $property ] ) ) {

                if( 'background-image' == $property && isset( $option[ $property ]['url'] ) ) {

                    if( !empty( $option['background-image']['url']) ) {
                        $css .= $property .':url('. $option[ $property ]['url'] .');';
                    }
                } else {

                    $css .= $property .':'. $option[ $property ] .';';
                }

            }

        }

        return $css;
    }
}

if( !function_exists( 'kinfw_padding_opt_css' ) ) {

    /**
     * To genereate padding css
     * @param string $css inline css for padding settings
     */
    function kinfw_padding_opt_css( $option = [] ) {
        $css        = '';
        $properties = [ 'top', 'right', 'bottom', 'left'];

        foreach( $properties as $property ) {
            if( isset( $option[ $property ] ) && !empty( $option[ $property ] ) ) {
                $css .= 'padding-'. $property . ':'. $option[ $property ] .'px;';
            }
        }

        return $css;
    }

}

if( !function_exists( 'kinfw_margin_opt_css' ) ) {

    /**
     * To genereate margin css
     * @param string $css inline css for margin settings
     */
    function kinfw_margin_opt_css( $option = [] ) {
        $css        = '';
        $properties = [ 'top', 'right', 'bottom', 'left'];

        foreach( $properties as $property ) {
            if( isset( $option[ $property ] ) && !empty( $option[ $property ] ) ) {
                $css .= 'margin-'. $property . ':'. $option[ $property ] .'px;';
            }
        }

        return $css;
    }

}

if( !function_exists( 'kinfw_typo_opt_css' ) ) {

    /**
     * To genereate typo css
     * @param string $css inline css for typo settings
     */
    function kinfw_typo_opt_css( $option = [] ) {
        $css = [
            'css'    => '',
            'md_css' => '',
            'sm_css' => ''
        ];

        $typo_css    = '';
        $typo_md_css = '';
        $typo_sm_css = '';

        $typo_css .= ( !empty( $option['lg_font_size'] ) ) ? "font-size:{$option['lg_font_size']}px;" : "";
        $typo_css .= ( !empty( $option['lg_line_height'] ) ) ? "line-height:{$option['lg_line_height']}px;" : "";
        $typo_css .= ( !empty( $option['lg_letter_space'] ) ) ? "letter-spacing:{$option['lg_letter_space']}px;" : "";

        $typo_md_css .= ( !empty( $option['md_font_size'] ) ) ? "font-size:{$option['md_font_size']}px;" : "";
        $typo_md_css .= ( !empty( $option['md_line_height'] ) ) ? "line-height:{$option['md_line_height']}px;" : "";
        $typo_md_css .= ( !empty( $option['md_letter_space'] ) ) ? "letter-spacing:{$option['md_letter_space']}px;" : "";

        $typo_sm_css .= ( !empty( $option['sm_font_size'] ) ) ? "font-size:{$option['sm_font_size']}px;" : "";
        $typo_sm_css .= ( !empty( $option['sm_line_height'] ) ) ? "line-height:{$option['sm_line_height']}px;" : "";
        $typo_sm_css .= ( !empty( $option['sm_letter_space'] ) ) ? "letter-spacing:{$option['sm_letter_space']}px;" : "";

        $css[ 'css' ]    = $typo_css;
        $css[ 'md_css' ] = $typo_md_css;
        $css[ 'sm_css' ] = $typo_sm_css;

        return array_filter( $css );
    }

}

if( !function_exists( 'kinfw_typography_opt_css' ) ) {
    function kinfw_typography_opt_css( $options = [] ) {
        $css = '';

        $font_family   = ( ! empty( $options['font-family'] ) ) ? $options['font-family'] : '';
        $backup_family = ( ! empty( $options['backup-font-family'] ) ) ? ', '. $options['backup-font-family'] : '';

        if ( $font_family ) {
            $css .= 'font-family:"'. $font_family .'"'. $backup_family . ';';
        }

        $properties = [
            'color',
            'font-weight',
            'font-style',
            'font-variant',
            'text-align',
            'text-transform',
            'text-decoration',
        ];

        foreach ( $properties as $property ) {
            if ( isset( $options[$property] ) && $options[$property] !== '' ) {
                $css .= $property .':'. $options[$property] . ';';
            }
        }

        $properties = [
            'font-size',
            'line-height',
            'letter-spacing',
            'word-spacing',
        ];

        $unit             = ( ! empty( $options['unit'] ) ) ? $options['unit'] : 'px';
        $line_height_unit = ( ! empty( $options['line_height_unit'] ) ) ? $options['line_height_unit'] : $unit;

        foreach ( $properties as $property ) {
            if ( isset( $options[$property] ) && $options[$property] !== '' ) {
                $unit = ( $property === 'line-height' ) ? $line_height_unit : $unit;
                $css .= $property .':'. $options[$property] . $unit .';';
            }
        }

        return $css;
    }
}

if( !function_exists( 'kinfw_typography_url_params' ) ) {
    function kinfw_typography_url_params( $options = [] ) {
        $fonts   = [];
        $subsets = [];

        if( 'google' === $options['type']) {
            $font_family = ( ! empty( $options['font-family'] ) ) ? $options['font-family'] : '';
            $font_weight = ( ! empty( $options['font-weight'] ) ) ? $options['font-weight'] : '';
            $font_style  = ( ! empty( $options['font-style'] ) ) ? $options['font-style'] : '';

            if ( $font_weight || $font_style ) {
                $style = $font_weight . $font_style;
                if ( ! empty( $style ) ) {
                    $style = ( $style === 'normal' ) ? '400' : $style;
                    $fonts[ $font_family ] [ $style ] = $style;
                }
            } else {
                $fonts[ $font_family ] = [];
            }

            // set extra styles
            if ( ! empty( $options['extra-styles'] ) ) {
                foreach ( $options['extra-styles'] as $extra_style ) {
                    if ( ! empty( $extra_style ) ) {
                        $extra_style = ( $extra_style === 'normal' ) ? '400' : $extra_style;
                        $fonts[ $font_family ] [ $extra_style ] = $extra_style;
                    }
                }
            }

            // set subsets
            if ( ! empty( $options['subset'] ) && is_array( $options['subset'] ) ) {
                $opt_subsets = array_filter( $options['subset'] );
                foreach( $opt_subsets as $opt_subset ) {
                    $subsets[$opt_subset] = $opt_subset;
                }
            }
        }

        return [
            'font'    => $fonts,
            'subsets' => $subsets
        ];
    }
}

if( !function_exists( 'kinfw_icon' ) ) {

    /**
     * To genereate icon html
     * @param string $icon icon name to genenate icon html
     * @param string $class additional class to icon html
     * @param string $wrap icon html holder
     */
    function kinfw_icon( $icon = '', $class = '', $wrap = 'span' ) {

        if( !empty( $icon ) ) {

            $classes = [
                'kinfw-icon',
                'kinfw-icon-'.$icon,
                $class
            ];

            return sprintf( '<%1$s class="%2$s"></%1$s>', $wrap, implode( " ",array_filter( $classes ) ), $icon );

        }
        return;
    }
}

if( !function_exists( 'kinfw_is_svg' ) ) {
    function kinfw_is_svg( $url ) {

        // Get the file extension from the URL
        $file_extension = pathinfo( $url, PATHINFO_EXTENSION );

        // Convert the extension to lowercase for consistency
        $file_extension = strtolower( $file_extension );

        if( 'svg' === $file_extension ) {
            return true;
        }

        return false;
    }
}