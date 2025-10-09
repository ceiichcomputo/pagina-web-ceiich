<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( ! class_exists( 'Onnat_Theme_Block_Editor' ) ) {

    /**
     * The Onnat Theme block editor setup class.
     */
    class Onnat_Theme_Block_Editor {

		/**
		 * A reference to an instance of this class.
		 */
		private static $instance = null;

		/**
		 * Returns the instance.
		 */

		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
            }

			return self::$instance;
        }

		/**
		 * Constructor
		 */
        public function __construct() {

            add_action( 'after_setup_theme', [ $this, 'add_theme_supports' ] );

            add_action('init', [ $this, 'block_style_and_pattern' ] );

            if( !is_admin() ){
                add_action( 'wp_enqueue_scripts', [ $this, 'dequeue_block_styles' ], 999 );
            }

            if ( class_exists( 'Classic_Editor' ) ) {
                add_filter( 'tiny_mce_before_init', [ $this, 'editor_dynamic_styles' ], 10, 2  );
            }

            add_action( 'enqueue_block_editor_assets', [ $this, 'block_editor_styles' ] );

            do_action( 'kinfw-action/theme/block-editor/loaded' );

        }

        /**
         * Registers block editor support or features.
         */
        public function add_theme_supports() {

            /**
             * Add block support for Wide Alignment.
             */
            add_theme_support( 'align-wide' );

            /**
             * Add support for editor style.
             */
            add_theme_support( 'editor-styles' );

            /**
             * Font URL Generation
             */
                $font_url = $this->fonts_url();
                if( !empty( $font_url ) ) {
                    add_editor_style( $font_url );
                }

            /**
             * Add custom editor style.
             */
            add_editor_style( 'assets/css/editor-style.css' );

            /**
             * Add support for default block style.
             */
            add_theme_support( 'wp-block-styles' );


            /**
             * Add support for responsive embedded content.
             */
            add_theme_support( 'responsive-embeds' );


            /**
             * Add support for editor font sizes.
             */
            add_theme_support( 'editor-font-sizes', [
                [
                    'name'      => _x( 'Small', 'Name of the small font size in the block editor', 'onnat' ),
                    'shortName' => _x( 'S', 'Short name of the small font size in the block editor.', 'onnat' ),
                    'size'      => 18,
                    'slug'      => 'small',
                ],
                [
                    'name'      => _x( 'Regular', 'Name of the regular font size in the block editor', 'onnat' ),
                    'shortName' => _x( 'M', 'Short name of the regular font size in the block editor.', 'onnat' ),
                    'size'      => 21,
                    'slug'      => 'normal',
                ],
                [
                    'name'      => _x( 'Large', 'Name of the large font size in the block editor', 'onnat' ),
                    'shortName' => _x( 'L', 'Short name of the large font size in the block editor.', 'onnat' ),
                    'size'      => 26.25,
                    'slug'      => 'large',
                ],
                [
                    'name'      => _x( 'Larger', 'Name of the larger font size in the block editor', 'onnat' ),
                    'shortName' => _x( 'XL', 'Short name of the larger font size in the block editor.', 'onnat' ),
                    'size'      => 32,
                    'slug'      => 'larger',
                ]
            ] );

            /**
             * Add support for editor color palette
             */
            add_theme_support( 'editor-color-palette', [
                [
					'name'  => esc_html__( 'Primary Color', 'onnat' ),
					'slug'  => 'primary',
					'color' => kinfw_onnat_theme_options()->kinfw_get_option( 'skin_primary_color' ),
                ],
                [
					'name'  => esc_html__( 'Secondary Color', 'onnat' ),
					'slug'  => 'secondary',
					'color' => kinfw_onnat_theme_options()->kinfw_get_option( 'skin_secondary_color' ),
                ],
                [
					'name'  => esc_html__( 'Secondary Opacity Color', 'onnat' ),
					'slug'  => 'secondary_opacity',
					'color' => kinfw_onnat_theme_options()->kinfw_get_option( 'skin_secondary_opacity_color' ),
                ],
                [
					'name'  => esc_html__( 'Accent Color', 'onnat' ),
					'slug'  => 'accent',
					'color' => kinfw_onnat_theme_options()->kinfw_get_option( 'skin_accent_color' ),
                ],
                [
					'name'  => esc_html__( 'Light Color', 'onnat' ),
					'slug'  => 'light',
					'color' => kinfw_onnat_theme_options()->kinfw_get_option( 'skin_light_color' ),
                ],
                [
					'name'  => esc_html__( 'White Color', 'onnat' ),
					'slug'  => 'white',
					'color' => kinfw_onnat_theme_options()->kinfw_get_option( 'skin_white_color' ),
                ],
                [
					'name'  => esc_html__( 'Background Light Color', 'onnat' ),
					'slug'  => 'light',
					'color' => kinfw_onnat_theme_options()->kinfw_get_option( 'skin_bg_light_color' ),
                ],
            ] );

        }

        /**
         * Block Style & Pattern
         * To clear Envato Theme Check
         */
        public function block_style_and_pattern() {
            if ( function_exists( 'register_block_style' ) ) {
                register_block_style( 'onnat/block', [
                    'name'  => 'onnat-paragraph',
                    'label' => esc_html__( 'Onnat Paragraph', 'onnat' ),
                ] );
            }

            if ( function_exists('register_block_pattern') ) {
                register_block_pattern( 'onnat/block-pattern', [
                    'title'   => esc_html__( 'Onnat Section', 'onnat' ),
                    'content' => '<!-- wp:heading {"align":"center","level":3} --> <h3 class="has-text-align-center">Thanks for Purchasing</h3> <!-- /wp:heading -->',
                ] );
            }
        }        

        /**
         * Remove block styles, if no blocks are on the page.
         */
        public function dequeue_block_styles() {

            if( function_exists( 'has_blocks' ) && ! has_blocks() ) {

                wp_dequeue_style( 'wp-block-library' );
                wp_dequeue_style( 'wp-block-library-theme' );

            }

        }

        public function editor_dynamic_styles( $mceInit ) {

            $css = $this->root_vars();
			if( !empty( $css ) ) {
				if ( isset( $mceInit['content_style'] ) ) {
					$mceInit['content_style'] .= ' ' . $css . ' ';
				} else {
					$mceInit['content_style'] = $css . ' ';
				}
			}

            return $mceInit;
        }

        public function block_editor_styles() {

            wp_enqueue_style( 'kinfw-onnat-block-editor-style', get_theme_file_uri( 'assets/css/editor-style-block.css' ), [], ONNAT_CONST_THEME_VERSION );

            wp_add_inline_style( 'kinfw-onnat-block-editor-style', $this->root_vars() );

            $font_url = $this->fonts_url();
            if( !empty( $font_url ) ) {

                wp_enqueue_style( 'kinfw-google-web-fonts', $font_url, ['kinfw-onnat-block-editor-style'], null );

            }
        }



        public function root_vars() {
            $css = '';
            $css .= ":root {";
                $css .= $this->skin_root_vars();
                $css .= $this->global_font_vars();
                $css .= $this->body_typo_vars();
                $css .= $this->h1_typo_vars();
                $css .= $this->h2_typo_vars();
                $css .= $this->h3_typo_vars();
                $css .= $this->h4_typo_vars();
                $css .= $this->h5_typo_vars();
                $css .= $this->h6_typo_vars();
            $css .= "}";

            return $css;
        }

        public function skin_root_vars() {
            $vars = '';

            $skin_primary_color = kinfw_onnat_theme_options()->kinfw_get_option( 'skin_primary_color' );
            $vars .= "--kinfw-primary-color:" . $skin_primary_color . ";";

            $skin_secondary_color = kinfw_onnat_theme_options()->kinfw_get_option( 'skin_secondary_color' );
            $vars .= "--kinfw-secondary-color:" . $skin_secondary_color . ";";

            $skin_secondary_opacity_color = kinfw_onnat_theme_options()->kinfw_get_option( 'skin_secondary_opacity_color' );
            $vars .= "--kinfw-secondary-opacity-color:" . $skin_secondary_opacity_color . ";";

            $skin_accent_color = kinfw_onnat_theme_options()->kinfw_get_option( 'skin_accent_color' );
            $vars .= "--kinfw-accent-color:" . $skin_accent_color . ";";

            $skin_light_color = kinfw_onnat_theme_options()->kinfw_get_option( 'skin_light_color' );
            $vars .= "--kinfw-text-light-color:" . $skin_light_color . ";";

            $skin_white_color = kinfw_onnat_theme_options()->kinfw_get_option( 'skin_white_color' );
            $vars .= "--kinfw-white-color:" . $skin_white_color . ";";

            $skin_bg_light_color = kinfw_onnat_theme_options()->kinfw_get_option( 'skin_bg_light_color' );
            $vars .= "--kinfw-bg-light-color:" . $skin_bg_light_color . ";";


            $body_link_color = kinfw_onnat_theme_options()->kinfw_get_option( 'body_link_color' );
            if( is_array( $body_link_color ) ) {
                if( isset( $body_link_color['color'] ) ) {
                    $vars .= "--kinfw-a-color:" . $body_link_color['color'] . ";";
                }

                if( isset( $body_link_color['hover'] ) ) {
                    $vars .= "--kinfw-a-hover-color:" . $body_link_color['hover'] . ";";
                }
            } else {
                $vars .= "--kinfw-a-color:var( --kinfw-primary-color );". ONNAT_CONST_THEME_NEW_LINE;
                $vars .= "--kinfw-a-hover-color:var( --kinfw-secondary-color );" . ONNAT_CONST_THEME_NEW_LINE;
            }

            return $vars;
        }

        public function global_font_vars() {
            $vars = '';

            /**
             * Primary Font Family
             */
            $primary = kinfw_onnat_theme_options()->kinfw_get_option( 'primary_typo' );

            if( is_array( $primary ) && 'google' === $primary['type'] ) {

                /**
                 * font family variable
                 */
                    $font_family   = ( ! empty( $primary['font-family'] ) ) ? $primary['font-family'] : '';
                    $backup_family = ( ! empty( $primary['backup-font-family'] ) ) ? ', '. $primary['backup-font-family'] : '';
                    if ( $font_family ) {
                        $vars .= "--kinfw-primary-font-family:'". $font_family ."'". $backup_family .";";
                    }

                /**
                 * font weight variable
                 */
                    $font_weight = ( ! empty( $primary['font-weight'] ) ) ? $primary['font-weight'] : '400';
                    $vars .= '--kinfw-primary-font-weight:'.$font_weight.';';

                /**
                 * font style variable
                 */
                    $font_style = ( ! empty( $primary['font-style'] ) ) ? $primary['font-style'] : 'normal';
                    $vars .= '--kinfw-primary-font-style:'.$font_style.';';
            }

            /**
             * Secondary Font Family
             */
            $secondary = kinfw_onnat_theme_options()->kinfw_get_option( 'secondary_typo' );
            if( is_array( $secondary ) && 'google' === $secondary['type'] ) {

                /**
                 * font family variable
                 */
                    $font_family   = ( ! empty( $secondary['font-family'] ) ) ? $secondary['font-family'] : '';
                    $backup_family = ( ! empty( $secondary['backup-font-family'] ) ) ? ', '. $secondary['backup-font-family'] : '';
                    if ( $font_family ) {
                        $vars .= "--kinfw-secondary-font-family:'". $font_family ."'". $backup_family .";";
                    }

                /**
                 * font weight variable
                 */
                    $font_weight = ( ! empty( $secondary['font-weight'] ) ) ? $secondary['font-weight'] : '400';
                    $vars .= '--kinfw-secondary-font-weight:'.$font_weight.';';

                /**
                 * font style variable
                 */
                    $font_style = ( ! empty( $secondary['font-style'] ) ) ? $secondary['font-style'] : 'normal';
                    $vars .= '--kinfw-secondary-font-style:'.$font_style.';';
            }

            return $vars;
        }

        public function body_typo_vars() {
            $vars = '';

            $body_typo_type = kinfw_onnat_theme_options()->kinfw_get_option( 'body_typo_type' );
            $body_typo      = kinfw_onnat_theme_options()->kinfw_get_option( 'body_typo' );

            if( $body_typo_type === 'primary' ) {
                $vars .= '--kinfw-body-font-family:var( --kinfw-primary-font-family );';
                $vars .= '--kinfw-body-font-weight:var( --kinfw-primary-font-weight );';
                $vars .= '--kinfw-body-font-style:var( --kinfw-primary-font-style );';
                $vars .= '--kinfw-body-font-color:var( --kinfw-text-light-color );';

            } else if( $body_typo_type === 'secondary' ) {
                $vars .= '--kinfw-body-font-family:var( --kinfw-secondary-font-family );';
                $vars .= '--kinfw-body-font-weight:var( --kinfw-secondary-font-weight );';
                $vars .= '--kinfw-body-font-style:var( --kinfw-secondary-font-style );';
                $vars .= '--kinfw-body-font-color:var( --kinfw-text-light-color );';

            } else if( $body_typo_type === 'custom' ) {
                if( is_array( $body_typo ) && 'google' === $body_typo['type'] ) {
                    /**
                     * font family variable
                     */
                    $font_family   = ( ! empty( $body_typo['font-family'] ) ) ? $body_typo['font-family'] : '';
                    $backup_family = ( ! empty( $body_typo['backup-font-family'] ) ) ? ', '. $body_typo['backup-font-family'] : '';

                    if ( $font_family ) {
                        $vars .= "--kinfw-body-font-family:'". $font_family ."'". $backup_family .";";
                    } else {
                        if( $body_typo_type === 'primary' ) {
                            $vars .= '--kinfw-body-font-family:var( --kinfw-primary-font-family );';
                        } else if( $body_typo_type === 'secondary' ) {
                            $vars .= '--kinfw-body-font-family:var( --kinfw-secondary-font-family );';
                        } else {
                            $vars .= '--kinfw-body-font-family:var( --kinfw-primary-font-family );';
                        }
                    }

                    /**
                     * font weight variable
                     */
                    if( ! empty( $body_typo['font-weight'] ) ) {
                        $vars .= '--kinfw-body-font-weight:'.$body_typo['font-weight'].';';
                    } else {
                        if( $body_typo_type === 'primary' ) {
                            $vars .= '--kinfw-body-font-weight:var( --kinfw-primary-font-weight );';
                        } else if( $body_typo_type === 'secondary' ) {
                            $vars .= '--kinfw-body-font-weight:var( --kinfw-secondary-font-weight );';
                        } else {
                            $vars .= '--kinfw-body-font-weight:var( --kinfw-primary-font-weight );';
                        }
                    }

                    /**
                     * font style variable
                     */
                    if( ! empty( $body_typo['font-style'] ) ) {
                        $vars .= '--kinfw-body-font-style:'.$body_typo['font-style'].';';
                    } else {
                        if( $body_typo_type === 'primary' ) {
                            $vars .= '--kinfw-body-font-style:var( --kinfw-primary-font-style );';
                        } else if( $body_typo_type === 'secondary' ) {
                            $vars .= '--kinfw-body-font-style:var( --kinfw-secondary-font-style );';
                        } else {
                            $vars .= '--kinfw-body-font-style:var( --kinfw-primary-font-style );';
                        }
                    }

                    /**
                     * Color
                     */
                    $font_color = ( ! empty( $body_typo['color'] ) ) ? $body_typo['color'] : '';
                    if( !empty( $font_color ) ) {
                        $vars .= '--kinfw-body-font-color:'.$font_color.';';
                    } else {
                        $vars .= '--kinfw-body-font-color:var( --kinfw-text-light-color );';
                    }
                }
            }

            return $vars;
        }

        public function h1_typo_vars() {
            $vars = '';

            $option_type = kinfw_onnat_theme_options()->kinfw_get_option( 'h1_tag_typo_type' );
            $option      = kinfw_onnat_theme_options()->kinfw_get_option( 'h1_tag_typo' );

            if( $option_type === 'primary' ) {
                $vars .= '--kinfw-h1-font-family:var( --kinfw-primary-font-family );';
                $vars .= '--kinfw-h1-font-weight:var( --kinfw-primary-font-weight );';
                $vars .= '--kinfw-h1-font-style:var( --kinfw-primary-font-style );';
                $vars .= '--kinfw-h1-font-color:var( --kinfw-primary-color );';

            } else if( $option_type === 'secondary' ) {
                $vars .= '--kinfw-h1-font-family:var( --kinfw-secondary-font-family );';
                $vars .= '--kinfw-h1-font-weight:var( --kinfw-secondary-font-weight );';
                $vars .= '--kinfw-h1-font-style:var( --kinfw-secondary-font-style );';
                $vars .= '--kinfw-h1-font-color:var( --kinfw-primary-color );';
            } else if( $option_type === 'custom' ) {
                if( is_array( $option ) && 'google' === $option['type'] ) {

                    /**
                     * font family variable
                     */
                    $font_family   = ( ! empty( $option['font-family'] ) ) ? $option['font-family'] : '';
                    $backup_family = ( ! empty( $option['backup-font-family'] ) ) ? ', '. $option['backup-font-family'] : '';
                    if ( $font_family ) {
                        $vars .= "--kinfw-h1-font-family:'". $font_family ."'". $backup_family .";";
                    } else {
                        if( $option_type === 'primary' ) {
                            $vars .= '--kinfw-h1-font-family:var( --kinfw-primary-font-family );';
                        } else if( $option_type === 'secondary' ) {
                            $vars .= '--kinfw-h1-font-family:var( --kinfw-secondary-font-family );';
                        } else {
                            $vars .= '--kinfw-h1-font-family:var( --kinfw-primary-font-family );';
                        }
                    }

                    /**
                     * font weight variable
                     */
                    if( ! empty( $option['font-weight'] ) ) {
                        $vars .= '--kinfw-h1-font-weight:'.$option['font-weight'].';';
                    } else {
                        if( $option_type === 'primary' ) {
                            $vars .= '--kinfw-h1-font-weight:var( --kinfw-primary-font-weight );';
                        } else if( $option_type === 'secondary' ) {
                            $vars .= '--kinfw-h1-font-weight:var( --kinfw-secondary-font-weight );';
                        } else {
                            $vars .= '--kinfw-h1-font-weight:var( --kinfw-primary-font-weight );';
                        }
                    }

                    /**
                     * font style variable
                     */
                    if( ! empty( $option['font-style'] ) ) {
                        $vars .= '--kinfw-h1-font-style:'.$option['font-style'].';';
                    } else {
                        if( $option_type === 'primary' ) {
                            $vars .= '--kinfw-h1-font-style:var( --kinfw-primary-font-style );';
                        } else if( $option_type === 'secondary' ) {
                            $vars .= '--kinfw-h1-font-style:var( --kinfw-secondary-font-style );';
                        } else {
                            $vars .= '--kinfw-h1-font-style:var( --kinfw-primary-font-style );';
                        }
                    }

                    /**
                     * Color
                     */
                    $font_color = ( ! empty( $option['color'] ) ) ? $option['color'] : '';
                    if( !empty( $font_color ) ) {
                        $vars .= '--kinfw-h1-font-color:'.$font_color.';';
                    } else {
                        $vars .= '--kinfw-h1-font-color:var( --kinfw-text-light-color );';
                    }
                }
            }

            return $vars;
        }

        public function h2_typo_vars() {
            $vars = '';

            $option_type = kinfw_onnat_theme_options()->kinfw_get_option( 'h2_tag_typo_type' );
            $option      = kinfw_onnat_theme_options()->kinfw_get_option( 'h2_tag_typo' );

            if( $option_type === 'primary' ) {
                $vars .= '--kinfw-h2-font-family:var( --kinfw-primary-font-family );';
                $vars .= '--kinfw-h2-font-weight:var( --kinfw-primary-font-weight );';
                $vars .= '--kinfw-h2-font-style:var( --kinfw-primary-font-style );';
                $vars .= '--kinfw-h2-font-color:var( --kinfw-primary-color );';
            } else if( $option_type === 'secondary' ) {
                $vars .= '--kinfw-h2-font-family:var( --kinfw-secondary-font-family );';
                $vars .= '--kinfw-h2-font-weight:var( --kinfw-secondary-font-weight );';
                $vars .= '--kinfw-h2-font-style:var( --kinfw-secondary-font-style );';
                $vars .= '--kinfw-h2-font-color:var( --kinfw-primary-color );';
            } else if( $option_type === 'custom' ) {
                if( is_array( $option ) && 'google' === $option['type'] ) {

                    /**
                     * font family variable
                     */
                    $font_family   = ( ! empty( $option['font-family'] ) ) ? $option['font-family'] : '';
                    $backup_family = ( ! empty( $option['backup-font-family'] ) ) ? ', '. $option['backup-font-family'] : '';
                    if ( $font_family ) {
                        $vars .= "--kinfw-h2-font-family:'". $font_family ."'". $backup_family .";";
                    } else {
                        if( $option_type === 'primary' ) {
                            $vars .= '--kinfw-h2-font-family:var( --kinfw-primary-font-family );';
                        } else if( $option_type === 'secondary' ) {
                            $vars .= '--kinfw-h2-font-family:var( --kinfw-secondary-font-family );';
                        } else {
                            $vars .= '--kinfw-h2-font-family:var( --kinfw-primary-font-family );';
                        }
                    }

                    /**
                     * font weight variable
                     */
                    if( ! empty( $option['font-weight'] ) ) {
                        $vars .= '--kinfw-h2-font-weight:'.$option['font-weight'].';';
                    } else {
                        if( $option_type === 'primary' ) {
                            $vars .= '--kinfw-h2-font-weight:var( --kinfw-primary-font-weight );';
                        } else if( $option_type === 'secondary' ) {
                            $vars .= '--kinfw-h2-font-weight:var( --kinfw-secondary-font-weight );';
                        } else {
                            $vars .= '--kinfw-h2-font-weight:var( --kinfw-primary-font-weight );';
                        }
                    }

                    /**
                     * font style variable
                     */
                    if( ! empty( $option['font-style'] ) ) {
                        $vars .= '--kinfw-h2-font-style:'.$option['font-style'].';';
                    } else {
                        if( $option_type === 'primary' ) {
                            $vars .= '--kinfw-h2-font-style:var( --kinfw-primary-font-style );';
                        } else if( $option_type === 'secondary' ) {
                            $vars .= '--kinfw-h2-font-style:var( --kinfw-secondary-font-style );';
                        } else {
                            $vars .= '--kinfw-h2-font-style:var( --kinfw-primary-font-style );';
                        }
                    }

                    /**
                     * Color
                     */
                    $font_color = ( ! empty( $option['color'] ) ) ? $option['color'] : '';
                    if( !empty( $font_color ) ) {
                        $vars .= '--kinfw-h2-font-color:'.$font_color.';';
                    } else {
                        $vars .= '--kinfw-h2-font-color:var( --kinfw-text-light-color );';
                    }
                }
            }

            return $vars;
        }

        public function h3_typo_vars() {
            $vars = '';

            $option_type = kinfw_onnat_theme_options()->kinfw_get_option( 'h3_tag_typo_type' );
            $option      = kinfw_onnat_theme_options()->kinfw_get_option( 'h3_tag_typo' );

            if( $option_type === 'primary' ) {
                $vars .= '--kinfw-h3-font-family:var( --kinfw-primary-font-family );';
                $vars .= '--kinfw-h3-font-weight:var( --kinfw-primary-font-weight );';
                $vars .= '--kinfw-h3-font-style:var( --kinfw-primary-font-style );';
                $vars .= '--kinfw-h3-font-color:var( --kinfw-primary-color );';
            } else if( $option_type === 'secondary' ) {
                $vars .= '--kinfw-h3-font-family:var( --kinfw-secondary-font-family );';
                $vars .= '--kinfw-h3-font-weight:var( --kinfw-secondary-font-weight );';
                $vars .= '--kinfw-h3-font-style:var( --kinfw-secondary-font-style );';
                $vars .= '--kinfw-h3-font-color:var( --kinfw-primary-color );';
            } else if( $option_type === 'custom' ) {
                if( is_array( $option ) && 'google' === $option['type'] ) {
                    /**
                     * font family variable
                     */
                    $font_family   = ( ! empty( $option['font-family'] ) ) ? $option['font-family'] : '';
                    $backup_family = ( ! empty( $option['backup-font-family'] ) ) ? ', '. $option['backup-font-family'] : '';
                    if ( $font_family ) {
                        $vars .= "--kinfw-h3-font-family:'". $font_family ."'". $backup_family .";";
                    } else {
                        if( $option_type === 'primary' ) {
                            $vars .= '--kinfw-h3-font-family:var( --kinfw-primary-font-family );';
                        } else if( $option_type === 'secondary' ) {
                            $vars .= '--kinfw-h3-font-family:var( --kinfw-secondary-font-family );';
                        } else {
                            $vars .= '--kinfw-h3-font-family:var( --kinfw-primary-font-family );';
                        }
                    }

                    /**
                     * font weight variable
                     */
                    if( ! empty( $option['font-weight'] ) ) {
                        $vars .= '--kinfw-h3-font-weight:'.$option['font-weight'].';';
                    } else {
                        if( $option_type === 'primary' ) {
                            $vars .= '--kinfw-h3-font-weight:var( --kinfw-primary-font-weight );';
                        } else if( $option_type === 'secondary' ) {
                            $vars .= '--kinfw-h3-font-weight:var( --kinfw-secondary-font-weight );';
                        } else {
                            $vars .= '--kinfw-h3-font-weight:var( --kinfw-primary-font-weight );';
                        }
                    }

                    /**
                     * font style variable
                     */
                    if( ! empty( $option['font-style'] ) ) {
                        $vars .= '--kinfw-h3-font-style:'.$option['font-style'].';';
                    } else {
                        if( $option_type === 'primary' ) {
                            $vars .= '--kinfw-h3-font-style:var( --kinfw-primary-font-style );';
                        } else if( $option_type === 'secondary' ) {
                            $vars .= '--kinfw-h3-font-style:var( --kinfw-secondary-font-style );';
                        } else {
                            $vars .= '--kinfw-h3-font-style:var( --kinfw-primary-font-style );';
                        }
                    }

                    /**
                     * Color
                     */
                    $font_color = ( ! empty( $option['color'] ) ) ? $option['color'] : '';
                    if( !empty( $font_color ) ) {
                        $vars .= '--kinfw-h3-font-color:'.$font_color.';';
                    } else {
                        $vars .= '--kinfw-h3-font-color:var( --kinfw-text-light-color );';
                    }
                }
            }

            return $vars;
        }

        public function h4_typo_vars() {
            $vars = '';

            $option_type = kinfw_onnat_theme_options()->kinfw_get_option( 'h4_tag_typo_type' );
            $option      = kinfw_onnat_theme_options()->kinfw_get_option( 'h4_tag_typo' );

            if( $option_type === 'primary' ) {

                $vars .= '--kinfw-h4-font-family:var( --kinfw-primary-font-family );';
                $vars .= '--kinfw-h4-font-weight:var( --kinfw-primary-font-weight );';
                $vars .= '--kinfw-h4-font-style:var( --kinfw-primary-font-style );';
                $vars .= '--kinfw-h4-font-color:var( --kinfw-primary-color );';

            } else if( $option_type === 'secondary' ) {

                $vars .= '--kinfw-h4-font-family:var( --kinfw-secondary-font-family );';
                $vars .= '--kinfw-h4-font-weight:var( --kinfw-secondary-font-weight );';
                $vars .= '--kinfw-h4-font-style:var( --kinfw-secondary-font-style );';
                $vars .= '--kinfw-h4-font-color:var( --kinfw-primary-color );';
            } else if( $option_type === 'custom' ) {

                if( is_array( $option ) && 'google' === $option['type'] ) {

                    /**
                     * font family variable
                     */
                    $font_family   = ( ! empty( $option['font-family'] ) ) ? $option['font-family'] : '';
                    $backup_family = ( ! empty( $option['backup-font-family'] ) ) ? ', '. $option['backup-font-family'] : '';
                    if ( $font_family ) {
                        $vars .= "--kinfw-h4-font-family:'". $font_family ."'". $backup_family .";";
                    } else {
                        if( $option_type === 'primary' ) {
                            $vars .= '--kinfw-h4-font-family:var( --kinfw-primary-font-family );';
                        } else if( $option_type === 'secondary' ) {
                            $vars .= '--kinfw-h4-font-family:var( --kinfw-secondary-font-family );';
                        } else {
                            $vars .= '--kinfw-h4-font-family:var( --kinfw-primary-font-family );';
                        }
                    }

                    /**
                     * font weight variable
                     */
                    if( ! empty( $option['font-weight'] ) ) {
                        $vars .= '--kinfw-h4-font-weight:'.$option['font-weight'].';';
                    } else {
                        if( $option_type === 'primary' ) {
                            $vars .= '--kinfw-h4-font-weight:var( --kinfw-primary-font-weight );';
                        } else if( $option_type === 'secondary' ) {
                            $vars .= '--kinfw-h4-font-weight:var( --kinfw-secondary-font-weight );';
                        } else {
                            $vars .= '--kinfw-h4-font-weight:var( --kinfw-primary-font-weight );';
                        }
                    }

                    /**
                     * font style variable
                     */
                    if( ! empty( $option['font-style'] ) ) {
                        $vars .= '--kinfw-h4-font-style:'.$option['font-style'].';';
                    } else {
                        if( $option_type === 'primary' ) {
                            $vars .= '--kinfw-h4-font-style:var( --kinfw-primary-font-style );';
                        } else if( $option_type === 'secondary' ) {
                            $vars .= '--kinfw-h4-font-style:var( --kinfw-secondary-font-style );';
                        } else {
                            $vars .= '--kinfw-h4-font-style:var( --kinfw-primary-font-style );';
                        }
                    }

                    /**
                     * Color
                     */
                    $font_color = ( ! empty( $option['color'] ) ) ? $option['color'] : '';
                    if( !empty( $font_color ) ) {
                        $vars .= '--kinfw-h4-font-color:'.$font_color.';';
                    } else {
                        $vars .= '--kinfw-h4-font-color:var( --kinfw-text-light-color );';
                    }
                }
            }

            return $vars;
        }

        public function h5_typo_vars() {

            $vars = '';

            $option_type = kinfw_onnat_theme_options()->kinfw_get_option( 'h5_tag_typo_type' );
            $option      = kinfw_onnat_theme_options()->kinfw_get_option( 'h5_tag_typo' );

            if( $option_type === 'primary' ) {
                
                $vars .= '--kinfw-h5-font-family:var( --kinfw-primary-font-family );';
                $vars .= '--kinfw-h5-font-weight:var( --kinfw-primary-font-weight );';
                $vars .= '--kinfw-h5-font-style:var( --kinfw-primary-font-style );';
                $vars .= '--kinfw-h5-font-color:var( --kinfw-primary-color );';

            } else if( $option_type === 'secondary' ) {

                $vars .= '--kinfw-h5-font-family:var( --kinfw-secondary-font-family );';
                $vars .= '--kinfw-h5-font-weight:var( --kinfw-secondary-font-weight );';
                $vars .= '--kinfw-h5-font-style:var( --kinfw-secondary-font-style );';
                $vars .= '--kinfw-h5-font-color:var( --kinfw-primary-color );';

            } else if( $option_type === 'custom' ) {

                if( is_array( $option ) && 'google' === $option['type'] ) {

                    /**
                     * font family variable
                     */
                    $font_family   = ( ! empty( $option['font-family'] ) ) ? $option['font-family'] : '';
                    $backup_family = ( ! empty( $option['backup-font-family'] ) ) ? ', '. $option['backup-font-family'] : '';

                    if ( $font_family ) {
                        $vars .= "--kinfw-h5-font-family:'". $font_family ."'". $backup_family .";";
                    } else {
                        if( $option_type === 'primary' ) {
                            $vars .= '--kinfw-h5-font-family:var( --kinfw-primary-font-family );';
                        } else if( $option_type === 'secondary' ) {
                            $vars .= '--kinfw-h5-font-family:var( --kinfw-secondary-font-family );';
                        } else {
                            $vars .= '--kinfw-h5-font-family:var( --kinfw-primary-font-family );';
                        }
                    }

                    /**
                     * font weight variable
                     */
                    if( ! empty( $option['font-weight'] ) ) {
                        $vars .= '--kinfw-h5-font-weight:'.$option['font-weight'].';';
                    } else {
                        if( $option_type === 'primary' ) {
                            $vars .= '--kinfw-h5-font-weight:var( --kinfw-primary-font-weight );';
                        } else if( $option_type === 'secondary' ) {
                            $vars .= '--kinfw-h5-font-weight:var( --kinfw-secondary-font-weight );';
                        } else {
                            $vars .= '--kinfw-h5-font-weight:var( --kinfw-primary-font-weight );';
                        }
                    }

                    /**
                     * font style variable
                     */
                    if( ! empty( $option['font-style'] ) ) {
                        $vars .= '--kinfw-h5-font-style:'.$option['font-style'].';';
                    } else {
                        if( $option_type === 'primary' ) {
                            $vars .= '--kinfw-h5-font-style:var( --kinfw-primary-font-style );';
                        } else if( $option_type === 'secondary' ) {
                            $vars .= '--kinfw-h5-font-style:var( --kinfw-secondary-font-style );';
                        } else {
                            $vars .= '--kinfw-h5-font-style:var( --kinfw-primary-font-style );';
                        }
                    }

                    /**
                     * Color
                     */
                    $font_color = ( ! empty( $option['color'] ) ) ? $option['color'] : '';
                    if( !empty( $font_color ) ) {
                        $vars .= '--kinfw-h5-font-color:'.$font_color.';';
                    } else {
                        $vars .= '--kinfw-h5-font-color:var( --kinfw-text-light-color );';
                    }
                }
            }

            return $vars;
        }

        public function h6_typo_vars() {

            $vars = '';

            $option_type = kinfw_onnat_theme_options()->kinfw_get_option( 'h6_tag_typo_type' );
            $option      = kinfw_onnat_theme_options()->kinfw_get_option( 'h6_tag_typo' );

            if( $option_type === 'primary' ) {

                $vars .= '--kinfw-h6-font-family:var( --kinfw-primary-font-family );';
                $vars .= '--kinfw-h6-font-weight:var( --kinfw-primary-font-weight );';
                $vars .= '--kinfw-h6-font-style:var( --kinfw-primary-font-style );';
                $vars .= '--kinfw-h6-font-color:var( --kinfw-primary-color );';

            } else if( $option_type === 'secondary' ) {

                $vars .= '--kinfw-h6-font-family:var( --kinfw-secondary-font-family );';
                $vars .= '--kinfw-h6-font-weight:var( --kinfw-secondary-font-weight );';
                $vars .= '--kinfw-h6-font-style:var( --kinfw-secondary-font-style );';
                $vars .= '--kinfw-h6-font-color:var( --kinfw-primary-color );';

            } else if( $option_type === 'custom' ) {

                if( is_array( $option ) && 'google' === $option['type'] ) {

                    /**
                     * font family variable
                     */
                    $font_family   = ( ! empty( $option['font-family'] ) ) ? $option['font-family'] : '';
                    $backup_family = ( ! empty( $option['backup-font-family'] ) ) ? ', '. $option['backup-font-family'] : '';
                    if ( $font_family ) {
                        $vars .= "--kinfw-h6-font-family:'". $font_family ."'". $backup_family .";";
                    } else {
                        if( $option_type === 'primary' ) {
                            $vars .= '--kinfw-h6-font-family:var( --kinfw-primary-font-family );';
                        } else if( $option_type === 'secondary' ) {
                            $vars .= '--kinfw-h6-font-family:var( --kinfw-secondary-font-family );';
                        } else {
                            $vars .= '--kinfw-h6-font-family:var( --kinfw-primary-font-family );';
                        }
                    }

                    /**
                     * font weight variable
                     */
                    if( ! empty( $option['font-weight'] ) ) {
                        $vars .= '--kinfw-h6-font-weight:'.$option['font-weight'].';';
                    } else {
                        if( $option_type === 'primary' ) {
                            $vars .= '--kinfw-h6-font-weight:var( --kinfw-primary-font-weight );';
                        } else if( $option_type === 'secondary' ) {
                            $vars .= '--kinfw-h6-font-weight:var( --kinfw-secondary-font-weight );';
                        } else {
                            $vars .= '--kinfw-h6-font-weight:var( --kinfw-primary-font-weight );';
                        }
                    }

                    /**
                     * font style variable
                     */
                    if( ! empty( $option['font-style'] ) ) {
                        $vars .= '--kinfw-h6-font-style:'.$option['font-style'].';';
                    } else {
                        if( $option_type === 'primary' ) {
                            $vars .= '--kinfw-h6-font-style:var( --kinfw-primary-font-style );';
                        } else if( $option_type === 'secondary' ) {
                            $vars .= '--kinfw-h6-font-style:var( --kinfw-secondary-font-style );';
                        } else {
                            $vars .= '--kinfw-h6-font-style:var( --kinfw-primary-font-style );';
                        }
                    }

                    /**
                     * Color
                     */
                    $font_color = ( ! empty( $option['color'] ) ) ? $option['color'] : '';
                    if( !empty( $font_color ) ) {
                        $vars .= '--kinfw-h6-font-color:'.$font_color.';';
                    } else {
                        $vars .= '--kinfw-h6-font-color:var( --kinfw-text-light-color );';
                    }
                }
            }

            return $vars;
        }

        public function fonts_url() {
            $kinfw_fonts   = [];
            $kinfw_subsets = [];

            /**
             * Primary Typo
             */
                $primary_typo = kinfw_onnat_theme_options()->kinfw_get_option( 'primary_typo' );

                if( is_array( $primary_typo ) && 'google' === $primary_typo['type'] ) {
                    $primary_typo_url_params = kinfw_typography_url_params( $primary_typo );
                    $kinfw_fonts[]   = $primary_typo_url_params['font'];
                    $kinfw_subsets[] = $primary_typo_url_params['subsets'];
                }

            /**
             * Secondary Typo
             */
                $secondary_typo = kinfw_onnat_theme_options()->kinfw_get_option( 'secondary_typo' );

                if( is_array( $secondary_typo ) && 'google' === $secondary_typo['type'] ) {
                    $secondary_typo_url_params = kinfw_typography_url_params( $secondary_typo );
                    $kinfw_fonts[]   = $secondary_typo_url_params['font'];
                    $kinfw_subsets[] = $secondary_typo_url_params['subsets'];
                }

            /**
             * Body Typo
             */
                $body_typo_type = kinfw_onnat_theme_options()->kinfw_get_option( 'body_typo_type' );
                $body_typo      = kinfw_onnat_theme_options()->kinfw_get_option( 'body_typo' );

                if( 'custom' === $body_typo_type && is_array( $body_typo ) ) {
                    if( 'google' === $body_typo['type'] && isset( $body_typo['type'] ) ) {
                        $body_typo_url_params = kinfw_typography_url_params( $body_typo );
                        $kinfw_fonts[]   = $body_typo_url_params['font'];
                        $kinfw_subsets[] = $body_typo_url_params['subsets'];
                    }
                }

            /**
             * H1 Typo
             */
                $h1_tag_typo_type = kinfw_onnat_theme_options()->kinfw_get_option( 'h1_tag_typo_type' );
                $h1_typo          = kinfw_onnat_theme_options()->kinfw_get_option( 'h1_tag_typo' );

                if( 'custom' === $h1_tag_typo_type && is_array( $h1_typo ) ) {
                    if( is_array( $h1_typo ) && 'google' === $h1_typo['type'] ) {

                        $h1_typo_url_params = kinfw_typography_url_params( $h1_typo );
                        $kinfw_fonts[]      = $h1_typo_url_params['font'];
                        $kinfw_subsets[]    = $h1_typo_url_params['subsets'];
                    }
                }

            /**
             * H2 Typo
             */
                $h2_tag_typo_type = kinfw_onnat_theme_options()->kinfw_get_option( 'h2_tag_typo_type' );
                $h2_typo          = kinfw_onnat_theme_options()->kinfw_get_option( 'h2_tag_typo' );

                if( 'custom' === $h2_tag_typo_type && is_array( $h2_typo ) ) {
                    if( is_array( $h2_typo ) && 'google' === $h2_typo['type'] ) {

                        $h2_typo_url_params = kinfw_typography_url_params( $h2_typo );
                        $kinfw_fonts[]      = $h2_typo_url_params['font'];
                        $kinfw_subsets[]    = $h2_typo_url_params['subsets'];
                    }
                }

            /**
             * H3 Typo
             */
                $h3_tag_typo_type = kinfw_onnat_theme_options()->kinfw_get_option( 'h3_tag_typo_type' );
                $h3_typo          = kinfw_onnat_theme_options()->kinfw_get_option( 'h3_tag_typo' );

                if( 'custom' === $h3_tag_typo_type && is_array( $h3_typo ) ) {
                    if( is_array( $h3_typo ) && 'google' === $h3_typo['type'] ) {

                        $h3_typo_url_params = kinfw_typography_url_params( $h3_typo );
                        $kinfw_fonts[]      = $h3_typo_url_params['font'];
                        $kinfw_subsets[]    = $h3_typo_url_params['subsets'];

                    }
                }

            /**
             * H4 Typo
             */
                $h4_tag_typo_type = kinfw_onnat_theme_options()->kinfw_get_option( 'h4_tag_typo_type' );
                $h4_typo          = kinfw_onnat_theme_options()->kinfw_get_option( 'h4_tag_typo' );

                if( 'custom' === $h4_tag_typo_type && is_array( $h4_typo ) ) {
                    if( is_array( $h4_typo ) && 'google' === $h4_typo['type'] ) {

                        $h4_typo_url_params = kinfw_typography_url_params( $h4_typo );
                        $kinfw_fonts[]      = $h4_typo_url_params['font'];
                        $kinfw_subsets[]    = $h4_typo_url_params['subsets'];

                    }
                }

            /**
             * H5 Typo
             */
                $h5_tag_typo_type = kinfw_onnat_theme_options()->kinfw_get_option( 'h5_tag_typo_type' );
                $h5_typo          = kinfw_onnat_theme_options()->kinfw_get_option( 'h5_tag_typo' );

                if( 'custom' === $h5_tag_typo_type && is_array( $h5_typo ) ) {
                    if( is_array( $h5_typo ) && 'google' === $h5_typo['type'] ) {

                        $h5_typo_url_params = kinfw_typography_url_params( $h5_typo );
                        $kinfw_fonts[]      = $h5_typo_url_params['font'];
                        $kinfw_subsets[]    = $h5_typo_url_params['subsets'];

                    }
                }

            /**
             * H6 Typo
             */
                $h6_tag_typo_type = kinfw_onnat_theme_options()->kinfw_get_option( 'h6_tag_typo_type' );
                $h6_typo          = kinfw_onnat_theme_options()->kinfw_get_option( 'h6_tag_typo' );

                if( 'custom' === $h6_tag_typo_type && is_array( $h6_typo ) ) {
                    if( is_array( $h6_typo ) && 'google' === $h6_typo['type'] ) {

                        $h6_typo_url_params = kinfw_typography_url_params( $h6_typo );
                        $kinfw_fonts[]      = $h6_typo_url_params['font'];
                        $kinfw_subsets[]    = $h6_typo_url_params['subsets'];
                    }
                }

            if( !empty( $kinfw_fonts ) ) {

                $kinfw_fonts_arr   = [];
                $kinfw_subsets_arr = [];

                foreach( $kinfw_fonts as $font ) {

                    $font_family = array_keys( $font )[0];
                    $font_weight = array_values( $font )[0];

                    if( isset( $kinfw_fonts_arr[ $font_family ]) ) {
                        $font_weight = $kinfw_fonts_arr[ $font_family ] + $font_weight;
                    }

                    $kinfw_fonts_arr[ $font_family ] = $font_weight;
                }

                $query   = [];
                $e_fonts = [];

                foreach( $kinfw_fonts_arr as $family => $styles ) {
                    $e_fonts[] = $family . ( ( ! empty( $styles ) ) ? ':'. implode( ',', $styles ) : '' );
                }

                if ( ! empty( $e_fonts ) ) {
                    $query['family'] = implode( '%7C', $e_fonts );
                }

                if ( ! empty( $kinfw_subsets_arr ) ) {
                    foreach( $kinfw_subsets_arr as $subset ) {

                        $kinfw_subsets_arr = array_filter( $subset );
                        if( !empty( $kinfw_subsets_arr ) ) {
                            foreach( $kinfw_subsets_arr as $s_a  ) {
                                $kinfw_subsets_arr[] = $s_a;
                            }
                        }
                    }

                    if( !empty( $kinfw_subsets_arr ) ) {
                        $query['subset'] = implode( ',', $kinfw_subsets_arr );
                    }
                }

                $query['display'] = 'swap';
                $font_url = esc_url( add_query_arg( $query, '//fonts.googleapis.com/css' ) );

                return $font_url;
            }

            return;
        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_block_editor' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_block_editor() {
        return  Onnat_Theme_Block_Editor::get_instance();
    }

}

kinfw_onnat_theme_block_editor();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */