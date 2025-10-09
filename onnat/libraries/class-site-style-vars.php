<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Style_Vars' ) ) {

	/**
	 * The Onnat Theme dynamic style setup class.
	 */
    class Onnat_Theme_Style_Vars {

		/**
		 * A reference to an instance of this class.
		 */
		private static $instance = null;

        public $fonts   = [];
        public $subsets = [];

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

            add_action( 'wp_enqueue_scripts', [ $this, 'skin_vars' ], 10  );
            add_action( 'wp_enqueue_scripts', [ $this, 'css_vars' ], 20  );
            add_action( 'wp_enqueue_scripts', [ $this, 'fonts_loader' ], 100  );
        }

        public function skin_vars() {
            $vars = '';

            $skin_primary_color = kinfw_onnat_theme_options()->kinfw_get_option( 'skin_primary_color' );
            $vars .= '--kinfw-primary-color:' .$skin_primary_color . ';' . ONNAT_CONST_THEME_NEW_LINE;

            $skin_secondary_color = kinfw_onnat_theme_options()->kinfw_get_option( 'skin_secondary_color' );
            $vars .= '--kinfw-secondary-color:' .$skin_secondary_color . ';' . ONNAT_CONST_THEME_NEW_LINE;

            $skin_secondary_opacity_color = kinfw_onnat_theme_options()->kinfw_get_option( 'skin_secondary_opacity_color' );
            $vars .= '--kinfw-secondary-opacity-color:' .$skin_secondary_opacity_color . ';' . ONNAT_CONST_THEME_NEW_LINE;

            $skin_tertiary_color = kinfw_onnat_theme_options()->kinfw_get_option( 'skin_tertiary_color' );
            $vars .= '--kinfw-tertiary-color:' .$skin_tertiary_color . ';' . ONNAT_CONST_THEME_NEW_LINE;

            $skin_accent_color = kinfw_onnat_theme_options()->kinfw_get_option( 'skin_accent_color' );
            $vars .= '--kinfw-accent-color:' .$skin_accent_color . ';' . ONNAT_CONST_THEME_NEW_LINE;

            $skin_light_color = kinfw_onnat_theme_options()->kinfw_get_option( 'skin_light_color' );
            $vars .= '--kinfw-text-light-color:' .$skin_light_color . ';' . ONNAT_CONST_THEME_NEW_LINE;

            $skin_white_color = kinfw_onnat_theme_options()->kinfw_get_option( 'skin_white_color' );
            $vars .= '--kinfw-white-color:' .$skin_white_color . ';' . ONNAT_CONST_THEME_NEW_LINE;

            $skin_bg_light_color = kinfw_onnat_theme_options()->kinfw_get_option( 'skin_bg_light_color' );
            $vars .= '--kinfw-bg-light-color:' .$skin_bg_light_color . ';' . ONNAT_CONST_THEME_NEW_LINE;

            $body_link_color = kinfw_onnat_theme_options()->kinfw_get_option( 'body_link_color' );
            if( !empty( $body_link_color ) ) {
                if( isset( $body_link_color['color'] ) ) {
                    $vars .= "--kinfw-a-color:" . $body_link_color['color'] . ';' . ONNAT_CONST_THEME_NEW_LINE;
                }

                if( isset( $body_link_color['hover'] ) ) {
                    $vars .= "--kinfw-a-hover-color:" . $body_link_color['hover'] . ';' . ONNAT_CONST_THEME_NEW_LINE;
                }
            } else {
                $vars .= "--kinfw-a-color:var( --kinfw-primary-color );". ONNAT_CONST_THEME_NEW_LINE;
                $vars .= "--kinfw-a-hover-color:var( --kinfw-secondary-color );" . ONNAT_CONST_THEME_NEW_LINE;
            }

            if( !empty( $vars ) ) {

                $css = ':root {'.ONNAT_CONST_THEME_NEW_LINE;
                    $css .= "/* Global Color Variables */". ONNAT_CONST_THEME_NEW_LINE;
                    $css .= $vars;
                $css .= '}'.ONNAT_CONST_THEME_NEW_LINE;

                wp_add_inline_style( 'kinfw-onnat-theme-style', $css );
            }

        }

        public function css_vars() {
            $css = '';
            $css .= ':root {'.ONNAT_CONST_THEME_NEW_LINE;

                /**
                 * Admin Panel: Styling
                 */
                    $css .= $this->global_font_vars();
                    $css .= $this->body_typo_vars();
                    $css .= $this->h1_typo_vars();
                    $css .= $this->h2_typo_vars();
                    $css .= $this->h3_typo_vars();
                    $css .= $this->h4_typo_vars();
                    $css .= $this->h5_typo_vars();
                    $css .= $this->h6_typo_vars();
                    $css .= $this->go_to_top_vars();
                    $css .= $this->pre_loader_vars();
                    $css .= $this->scroll_bar_vars();

            $css .= '}'.ONNAT_CONST_THEME_NEW_LINE;

            if( !empty( $css ) ) {
                wp_add_inline_style( 'kinfw-onnat-theme-style', $css );
            }
        }

        public function global_font_vars() {
            $vars = ONNAT_CONST_THEME_NEW_LINE . "/* Global Font Variables */". ONNAT_CONST_THEME_NEW_LINE;

            /**
             * Primary Font Family
             */
                $primary = kinfw_onnat_theme_options()->kinfw_get_option( 'primary_typo' );

                if( is_array( $primary ) ) {

                    if( 'google' === $primary['type'] && ( !function_exists( 'kf_onnat_extra_plugin' )) ) {
                        $typo_url_params = kinfw_typography_url_params( $primary );
                        if( is_array( $typo_url_params['font'] ) ) {
                            $this->fonts[]   = $typo_url_params['font'];
                            $this->subsets[] = $typo_url_params['subsets'];
                        }
                    }

                    /**
                     * font family variable
                     */
                        $font_family   = ( ! empty( $primary['font-family'] ) ) ? $primary['font-family'] : '';
                        $backup_family = ( ! empty( $primary['backup-font-family'] ) ) ? ', '. $primary['backup-font-family'] : '';
                        if ( $font_family ) {
                            $vars .= '--kinfw-primary-font-family:"'.$font_family.'"'.$backup_family.';'.ONNAT_CONST_THEME_NEW_LINE;
                        }

                    /**
                     * font weight variable
                     */
                        $font_weight = ( ! empty( $primary['font-weight'] ) ) ? $primary['font-weight'] : '400';
                        $vars .= '--kinfw-primary-font-weight:'.$font_weight.';'.ONNAT_CONST_THEME_NEW_LINE;

                    /**
                     * font style variable
                     */
                        $font_style = ( ! empty( $primary['font-style'] ) ) ? $primary['font-style'] : 'normal';
                        $vars .= '--kinfw-primary-font-style:'.$font_style.';'.ONNAT_CONST_THEME_NEW_LINE;

                }

            /**
             * Secondary Font Family
             */
                $secondary = kinfw_onnat_theme_options()->kinfw_get_option( 'secondary_typo' );

                if( is_array( $secondary ) ) {

                    if( 'google' === $secondary['type'] && ( !function_exists( 'kf_onnat_extra_plugin' )) ) {
                        $typo_url_params = kinfw_typography_url_params( $secondary );
                        if( is_array( $typo_url_params['font'] ) ) {
                            $this->fonts[]   = $typo_url_params['font'];
                            $this->subsets[] = $typo_url_params['subsets'];
                        }
                    }

                    /**
                     * font family variable
                     */
                        $font_family   = ( ! empty( $secondary['font-family'] ) ) ? $secondary['font-family'] : '';
                        $backup_family = ( ! empty( $secondary['backup-font-family'] ) ) ? ', '. $secondary['backup-font-family'] : '';
                        if ( $font_family ) {
                            $vars .= '--kinfw-secondary-font-family:"'.$font_family.'"'.$backup_family.';'.ONNAT_CONST_THEME_NEW_LINE;
                        }

                    /**
                     * font weight variable
                     */
                        $font_weight = ( ! empty( $secondary['font-weight'] ) ) ? $secondary['font-weight'] : '400';
                        $vars .= '--kinfw-secondary-font-weight:'.$font_weight.';'.ONNAT_CONST_THEME_NEW_LINE;

                    /**
                     * font style variable
                     */
                        $font_style = ( ! empty( $secondary['font-style'] ) ) ? $secondary['font-style'] : 'normal';
                        $vars .= '--kinfw-secondary-font-style:'.$font_style.';'.ONNAT_CONST_THEME_NEW_LINE;

                }

            return $vars;

        }

        public function body_typo_vars() {
            $vars           = ONNAT_CONST_THEME_NEW_LINE . "/* Body Font Variables */". ONNAT_CONST_THEME_NEW_LINE;
            $body_typo_type = kinfw_onnat_theme_options()->kinfw_get_option( 'body_typo_type' );
            $options        = kinfw_onnat_theme_options()->kinfw_get_option( 'body_typo' );

            if( $body_typo_type === 'primary' ) {
                $vars .= '--kinfw-body-font-family:var( --kinfw-primary-font-family );'.ONNAT_CONST_THEME_NEW_LINE;
                $vars .= '--kinfw-body-font-weight:var( --kinfw-primary-font-weight );'.ONNAT_CONST_THEME_NEW_LINE;
                $vars .= '--kinfw-body-font-style:var( --kinfw-primary-font-style );'.ONNAT_CONST_THEME_NEW_LINE;

                $vars .= '--kinfw-body-font-color:var( --kinfw-text-light-color );'.ONNAT_CONST_THEME_NEW_LINE;
            } else if( $body_typo_type === 'secondary' ) {
                $vars .= '--kinfw-body-font-family:var( --kinfw-secondary-font-family );'.ONNAT_CONST_THEME_NEW_LINE;
                $vars .= '--kinfw-body-font-weight:var( --kinfw-secondary-font-weight );'.ONNAT_CONST_THEME_NEW_LINE;
                $vars .= '--kinfw-body-font-style:var( --kinfw-secondary-font-style );'.ONNAT_CONST_THEME_NEW_LINE;

                $vars .= '--kinfw-body-font-color:var( --kinfw-text-light-color );'.ONNAT_CONST_THEME_NEW_LINE;
            } else if( $body_typo_type === 'custom' ) {

                if( is_array( $options ) ) {

                    if( 'google' === $options['type'] && ( !function_exists( 'kf_onnat_extra_plugin' )) ) {
                        $typo_url_params = kinfw_typography_url_params( $options );
                        if( is_array( $typo_url_params['font'] ) ) {
                            $this->fonts[]   = $typo_url_params['font'];
                            $this->subsets[] = $typo_url_params['subsets'];
                        }
                    }

                    /**
                     * font family variable
                     */
                        $font_family   = ( ! empty( $options['font-family'] ) ) ? $options['font-family'] : '';
                        $backup_family = ( ! empty( $options['backup-font-family'] ) ) ? ', '. $options['backup-font-family'] : '';
                        if ( $font_family ) {
                            $vars .= '--kinfw-body-font-family:"'.$font_family.'"'.$backup_family.';'.ONNAT_CONST_THEME_NEW_LINE;
                        } else {
                            if( $body_typo_type === 'primary' ) {
                                $vars .= '--kinfw-body-font-family:var( --kinfw-primary-font-family );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else if( $body_typo_type === 'secondary' ) {
                                $vars .= '--kinfw-body-font-family:var( --kinfw-secondary-font-family );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else {
                                $vars .= '--kinfw-body-font-family:var( --kinfw-primary-font-family );'.ONNAT_CONST_THEME_NEW_LINE;
                            }
                        }

                    /**
                     * font weight variable
                     */
                        if( ! empty( $options['font-weight'] ) ) {
                            $vars .= '--kinfw-body-font-weight:'.$options['font-weight'].';'.ONNAT_CONST_THEME_NEW_LINE;
                        } else {
                            if( $body_typo_type === 'primary' ) {
                                $vars .= '--kinfw-body-font-weight:var( --kinfw-primary-font-weight );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else if( $body_typo_type === 'secondary' ) {
                                $vars .= '--kinfw-body-font-weight:var( --kinfw-secondary-font-weight );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else {
                                $vars .= '--kinfw-body-font-weight:var( --kinfw-primary-font-weight );'.ONNAT_CONST_THEME_NEW_LINE;
                            }
                        }

                    /**
                     * font style variable
                     */
                        if( ! empty( $options['font-style'] ) ) {
                            $vars .= '--kinfw-body-font-style:'.$options['font-style'].';'.ONNAT_CONST_THEME_NEW_LINE;
                        } else {
                            if( $body_typo_type === 'primary' ) {
                                $vars .= '--kinfw-body-font-style:var( --kinfw-primary-font-style );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else if( $body_typo_type === 'secondary' ) {
                                $vars .= '--kinfw-body-font-style:var( --kinfw-secondary-font-style );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else {
                                $vars .= '--kinfw-body-font-style:var( --kinfw-primary-font-style );'.ONNAT_CONST_THEME_NEW_LINE;
                            }
                        }

                    /**
                     * Color
                     */
                        $font_color = ( ! empty( $options['color'] ) ) ? $options['color'] : '';
                        if( !empty( $font_color ) ) {
                            $vars .= '--kinfw-body-font-color:'.$font_color.';'.ONNAT_CONST_THEME_NEW_LINE;
                        } else {
                            $vars .= '--kinfw-body-font-color:var( --kinfw-text-light-color );'.ONNAT_CONST_THEME_NEW_LINE;
                        }

                }
            }

            return $vars;
        }

        public function h1_typo_vars() {
            $vars             = ONNAT_CONST_THEME_NEW_LINE . "/* H1 Font Variables */". ONNAT_CONST_THEME_NEW_LINE;
            $h1_tag_typo_type = kinfw_onnat_theme_options()->kinfw_get_option( 'h1_tag_typo_type' );
            $options          = kinfw_onnat_theme_options()->kinfw_get_option( 'h1_tag_typo' );

            if( $h1_tag_typo_type === 'primary' ) {
                $vars .= '--kinfw-h1-font-family:var( --kinfw-primary-font-family );'.ONNAT_CONST_THEME_NEW_LINE;
                $vars .= '--kinfw-h1-font-weight:var( --kinfw-primary-font-weight );'.ONNAT_CONST_THEME_NEW_LINE;
                $vars .= '--kinfw-h1-font-style:var( --kinfw-primary-font-style );'.ONNAT_CONST_THEME_NEW_LINE;

                $vars .= '--kinfw-h1-font-color:var( --kinfw-primary-color );'.ONNAT_CONST_THEME_NEW_LINE;
            } else if( $h1_tag_typo_type === 'secondary' ) {
                $vars .= '--kinfw-h1-font-family:var( --kinfw-secondary-font-family );'.ONNAT_CONST_THEME_NEW_LINE;
                $vars .= '--kinfw-h1-font-weight:var( --kinfw-secondary-font-weight );'.ONNAT_CONST_THEME_NEW_LINE;
                $vars .= '--kinfw-h1-font-style:var( --kinfw-secondary-font-style );'.ONNAT_CONST_THEME_NEW_LINE;

                $vars .= '--kinfw-h1-font-color:var( --kinfw-primary-color );'.ONNAT_CONST_THEME_NEW_LINE;
            } else if( $h1_tag_typo_type === 'custom' ) {
                if( is_array( $options ) ) {

                    if( 'google' === $options['type'] && ( !function_exists( 'kf_onnat_extra_plugin' )) ) {
                        $typo_url_params = kinfw_typography_url_params( $options );
                        if( is_array( $typo_url_params['font'] ) ) {
                            $this->fonts[]   = $typo_url_params['font'];
                            $this->subsets[] = $typo_url_params['subsets'];
                        }
                    }

                    /**
                     * font family variable
                     */
                        $font_family   = ( ! empty( $options['font-family'] ) ) ? $options['font-family'] : '';
                        $backup_family = ( ! empty( $options['backup-font-family'] ) ) ? ', '. $options['backup-font-family'] : '';
                        if ( $font_family ) {
                            $vars .= '--kinfw-h1-font-family:"'.$font_family.'"'.$backup_family.';'.ONNAT_CONST_THEME_NEW_LINE;
                        } else {
                            if( $h1_tag_typo_type === 'primary' ) {
                                $vars .= '--kinfw-h1-font-family:var( --kinfw-primary-font-family );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else if( $h1_tag_typo_type === 'secondary' ) {
                                $vars .= '--kinfw-h1-font-family:var( --kinfw-secondary-font-family );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else {
                                $vars .= '--kinfw-h1-font-family:var( --kinfw-primary-font-family );'.ONNAT_CONST_THEME_NEW_LINE;
                            }
                        }

                    /**
                     * font weight variable
                     */
                        if( ! empty( $options['font-weight'] ) ) {
                            $vars .= '--kinfw-h1-font-weight:'.$options['font-weight'].';'.ONNAT_CONST_THEME_NEW_LINE;
                        } else {
                            if( $h1_tag_typo_type === 'primary' ) {
                                $vars .= '--kinfw-h1-font-weight:var( --kinfw-primary-font-weight );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else if( $h1_tag_typo_type === 'secondary' ) {
                                $vars .= '--kinfw-h1-font-weight:var( --kinfw-secondary-font-weight );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else {
                                $vars .= '--kinfw-h1-font-weight:var( --kinfw-primary-font-weight );'.ONNAT_CONST_THEME_NEW_LINE;
                            }
                        }

                    /**
                     * font style variable
                     */
                        if( ! empty( $options['font-style'] ) ) {
                            $vars .= '--kinfw-h1-font-style:'.$options['font-style'].';'.ONNAT_CONST_THEME_NEW_LINE;
                            if( empty( $options['font-weight'] ) ) {
                                $vars .= '--kinfw-h1-font-weight:normal;'.ONNAT_CONST_THEME_NEW_LINE;
                            }
                        } else {
                            if( $h1_tag_typo_type === 'primary' ) {
                                $vars .= '--kinfw-h1-font-style:var( --kinfw-primary-font-style );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else if( $h1_tag_typo_type === 'secondary' ) {
                                $vars .= '--kinfw-h1-font-style:var( --kinfw-secondary-font-style );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else {
                                $vars .= '--kinfw-h1-font-style:var( --kinfw-primary-font-style );'.ONNAT_CONST_THEME_NEW_LINE;
                            }
                        }

                    /**
                     * Color
                     */
                        $font_color = ( ! empty( $options['color'] ) ) ? $options['color'] : '';
                        if( !empty( $font_color ) ) {
                            $vars .= '--kinfw-h1-font-color:'.$font_color.';'.ONNAT_CONST_THEME_NEW_LINE;
                        } else {
                            $vars .= '--kinfw-h1-font-color:var( --kinfw-primary-color );'.ONNAT_CONST_THEME_NEW_LINE;
                        }

                }
            }

            return $vars;
        }

        public function h2_typo_vars() {
            $vars             = ONNAT_CONST_THEME_NEW_LINE . "/* H2 Font Variables */". ONNAT_CONST_THEME_NEW_LINE;
            $h2_tag_typo_type = kinfw_onnat_theme_options()->kinfw_get_option( 'h2_tag_typo_type' );
            $options          = kinfw_onnat_theme_options()->kinfw_get_option( 'h2_tag_typo' );

            if( $h2_tag_typo_type === 'primary' ) {
                $vars .= '--kinfw-h2-font-family:var( --kinfw-primary-font-family );'.ONNAT_CONST_THEME_NEW_LINE;
                $vars .= '--kinfw-h2-font-weight:var( --kinfw-primary-font-weight );'.ONNAT_CONST_THEME_NEW_LINE;
                $vars .= '--kinfw-h2-font-style:var( --kinfw-primary-font-style );'.ONNAT_CONST_THEME_NEW_LINE;

                $vars .= '--kinfw-h2-font-color:var( --kinfw-primary-color );'.ONNAT_CONST_THEME_NEW_LINE;
            } else if( $h2_tag_typo_type === 'secondary' ) {
                $vars .= '--kinfw-h2-font-family:var( --kinfw-secondary-font-family );'.ONNAT_CONST_THEME_NEW_LINE;
                $vars .= '--kinfw-h2-font-weight:var( --kinfw-secondary-font-weight );'.ONNAT_CONST_THEME_NEW_LINE;
                $vars .= '--kinfw-h2-font-style:var( --kinfw-secondary-font-style );'.ONNAT_CONST_THEME_NEW_LINE;

                $vars .= '--kinfw-h2-font-color:var( --kinfw-primary-color );'.ONNAT_CONST_THEME_NEW_LINE;
            } else if( $h2_tag_typo_type === 'custom' ) {
                if( is_array( $options ) ) {

                    if( 'google' === $options['type'] && ( !function_exists( 'kf_onnat_extra_plugin' )) ) {
                        $typo_url_params = kinfw_typography_url_params( $options );
                        if( is_array( $typo_url_params['font'] ) ) {
                            $this->fonts[]   = $typo_url_params['font'];
                            $this->subsets[] = $typo_url_params['subsets'];
                        }
                    }

                    /**
                     * font family variable
                     */
                        $font_family   = ( ! empty( $options['font-family'] ) ) ? $options['font-family'] : '';
                        $backup_family = ( ! empty( $options['backup-font-family'] ) ) ? ', '. $options['backup-font-family'] : '';
                        if ( $font_family ) {
                            $vars .= '--kinfw-h2-font-family:"'.$font_family.'"'.$backup_family.';'.ONNAT_CONST_THEME_NEW_LINE;
                        } else {
                            if( $h2_tag_typo_type === 'primary' ) {
                                $vars .= '--kinfw-h2-font-family:var( --kinfw-primary-font-family );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else if( $h2_tag_typo_type === 'secondary' ) {
                                $vars .= '--kinfw-h2-font-family:var( --kinfw-secondary-font-family );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else {
                                $vars .= '--kinfw-h2-font-family:var( --kinfw-primary-font-family );'.ONNAT_CONST_THEME_NEW_LINE;
                            }
                        }

                    /**
                     * font weight variable
                     */
                        if( ! empty( $options['font-weight'] ) ) {
                            $vars .= '--kinfw-h2-font-weight:'.$options['font-weight'].';'.ONNAT_CONST_THEME_NEW_LINE;
                        } else {
                            if( $h2_tag_typo_type === 'primary' ) {
                                $vars .= '--kinfw-h2-font-weight:var( --kinfw-primary-font-weight );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else if( $h2_tag_typo_type === 'secondary' ) {
                                $vars .= '--kinfw-h2-font-weight:var( --kinfw-secondary-font-weight );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else {
                                $vars .= '--kinfw-h2-font-weight:var( --kinfw-primary-font-weight );'.ONNAT_CONST_THEME_NEW_LINE;
                            }
                        }

                    /**
                     * font style variable
                     */
                        if( ! empty( $options['font-style'] ) ) {
                            $vars .= '--kinfw-h2-font-style:'.$options['font-style'].';'.ONNAT_CONST_THEME_NEW_LINE;
                            if( empty( $options['font-weight'] ) ) {
                                $vars .= '--kinfw-h2-font-weight:normal;'.ONNAT_CONST_THEME_NEW_LINE;
                            }
                        } else {
                            if( $h2_tag_typo_type === 'primary' ) {
                                $vars .= '--kinfw-h2-font-style:var( --kinfw-primary-font-style );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else if( $h2_tag_typo_type === 'secondary' ) {
                                $vars .= '--kinfw-h2-font-style:var( --kinfw-secondary-font-style );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else {
                                $vars .= '--kinfw-h2-font-style:var( --kinfw-primary-font-style );'.ONNAT_CONST_THEME_NEW_LINE;
                            }
                        }

                    /**
                     * Color
                     */
                        $font_color = ( ! empty( $options['color'] ) ) ? $options['color'] : '';
                        if( !empty( $font_color ) ) {
                            $vars .= '--kinfw-h2-font-color:'.$font_color.';'.ONNAT_CONST_THEME_NEW_LINE;
                        } else {
                            $vars .= '--kinfw-h2-font-color:var( --kinfw-primary-color );'.ONNAT_CONST_THEME_NEW_LINE;
                        }

                }
            }

            return $vars;
        }

        public function h3_typo_vars() {
            $vars             = ONNAT_CONST_THEME_NEW_LINE . "/* H3 Font Variables */". ONNAT_CONST_THEME_NEW_LINE;
            $h3_tag_typo_type = kinfw_onnat_theme_options()->kinfw_get_option( 'h3_tag_typo_type' );
            $options          = kinfw_onnat_theme_options()->kinfw_get_option( 'h3_tag_typo' );

            if( $h3_tag_typo_type === 'primary' ) {
                $vars .= '--kinfw-h3-font-family:var( --kinfw-primary-font-family );'.ONNAT_CONST_THEME_NEW_LINE;
                $vars .= '--kinfw-h3-font-weight:var( --kinfw-primary-font-weight );'.ONNAT_CONST_THEME_NEW_LINE;
                $vars .= '--kinfw-h3-font-style:var( --kinfw-primary-font-style );'.ONNAT_CONST_THEME_NEW_LINE;

                $vars .= '--kinfw-h3-font-color:var( --kinfw-primary-color );'.ONNAT_CONST_THEME_NEW_LINE;
            } else if( $h3_tag_typo_type === 'secondary' ) {
                $vars .= '--kinfw-h3-font-family:var( --kinfw-secondary-font-family );'.ONNAT_CONST_THEME_NEW_LINE;
                $vars .= '--kinfw-h3-font-weight:var( --kinfw-secondary-font-weight );'.ONNAT_CONST_THEME_NEW_LINE;
                $vars .= '--kinfw-h3-font-style:var( --kinfw-secondary-font-style );'.ONNAT_CONST_THEME_NEW_LINE;

                $vars .= '--kinfw-h3-font-color:var( --kinfw-primary-color );'.ONNAT_CONST_THEME_NEW_LINE;
            } else if( $h3_tag_typo_type === 'custom' ) {
                if( is_array( $options ) ) {

                    if( 'google' === $options['type'] && ( !function_exists( 'kf_onnat_extra_plugin' )) ) {
                        $typo_url_params = kinfw_typography_url_params( $options );
                        if( is_array( $typo_url_params['font'] ) ) {
                            $this->fonts[]   = $typo_url_params['font'];
                            $this->subsets[] = $typo_url_params['subsets'];
                        }
                    }

                    /**
                     * font family variable
                     */
                        $font_family   = ( ! empty( $options['font-family'] ) ) ? $options['font-family'] : '';
                        $backup_family = ( ! empty( $options['backup-font-family'] ) ) ? ', '. $options['backup-font-family'] : '';
                        if ( $font_family ) {
                            $vars .= '--kinfw-h3-font-family:"'.$font_family.'"'.$backup_family.';'.ONNAT_CONST_THEME_NEW_LINE;
                        } else {
                            if( $h3_tag_typo_type === 'primary' ) {
                                $vars .= '--kinfw-h3-font-family:var( --kinfw-primary-font-family );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else if( $h3_tag_typo_type === 'secondary' ) {
                                $vars .= '--kinfw-h3-font-family:var( --kinfw-secondary-font-family );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else {
                                $vars .= '--kinfw-h3-font-family:var( --kinfw-primary-font-family );'.ONNAT_CONST_THEME_NEW_LINE;
                            }
                        }

                    /**
                     * font weight variable
                     */
                        if( ! empty( $options['font-weight'] ) ) {
                            $vars .= '--kinfw-h3-font-weight:'.$options['font-weight'].';'.ONNAT_CONST_THEME_NEW_LINE;
                        } else {
                            if( $h3_tag_typo_type === 'primary' ) {
                                $vars .= '--kinfw-h3-font-weight:var( --kinfw-primary-font-weight );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else if( $h3_tag_typo_type === 'secondary' ) {
                                $vars .= '--kinfw-h3-font-weight:var( --kinfw-secondary-font-weight );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else {
                                $vars .= '--kinfw-h3-font-weight:var( --kinfw-primary-font-weight );'.ONNAT_CONST_THEME_NEW_LINE;
                            }
                        }

                    /**
                     * font style variable
                     */
                        if( ! empty( $options['font-style'] ) ) {
                            $vars .= '--kinfw-h3-font-style:'.$options['font-style'].';'.ONNAT_CONST_THEME_NEW_LINE;
                            if( empty( $options['font-weight'] ) ) {
                                $vars .= '--kinfw-h3-font-weight:normal;'.ONNAT_CONST_THEME_NEW_LINE;
                            }
                        } else {
                            if( $h3_tag_typo_type === 'primary' ) {
                                $vars .= '--kinfw-h3-font-style:var( --kinfw-primary-font-style );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else if( $h3_tag_typo_type === 'secondary' ) {
                                $vars .= '--kinfw-h3-font-style:var( --kinfw-secondary-font-style );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else {
                                $vars .= '--kinfw-h3-font-style:var( --kinfw-primary-font-style );'.ONNAT_CONST_THEME_NEW_LINE;
                            }
                        }

                    /**
                     * Color
                     */
                        $font_color = ( ! empty( $options['color'] ) ) ? $options['color'] : '';
                        if( !empty( $font_color ) ) {
                            $vars .= '--kinfw-h3-font-color:'.$font_color.';'.ONNAT_CONST_THEME_NEW_LINE;
                        } else {
                            $vars .= '--kinfw-h3-font-color:var( --kinfw-primary-color );'.ONNAT_CONST_THEME_NEW_LINE;
                        }

                }
            }

            return $vars;
        }

        public function h4_typo_vars() {
            $vars             = ONNAT_CONST_THEME_NEW_LINE . "/* H4 Font Variables */". ONNAT_CONST_THEME_NEW_LINE;
            $h4_tag_typo_type = kinfw_onnat_theme_options()->kinfw_get_option( 'h4_tag_typo_type' );
            $options          = kinfw_onnat_theme_options()->kinfw_get_option( 'h4_tag_typo' );

            if( $h4_tag_typo_type === 'primary' ) {
                $vars .= '--kinfw-h4-font-family:var( --kinfw-primary-font-family );'.ONNAT_CONST_THEME_NEW_LINE;
                $vars .= '--kinfw-h4-font-weight:var( --kinfw-primary-font-weight );'.ONNAT_CONST_THEME_NEW_LINE;
                $vars .= '--kinfw-h4-font-style:var( --kinfw-primary-font-style );'.ONNAT_CONST_THEME_NEW_LINE;

                $vars .= '--kinfw-h4-font-color:var( --kinfw-primary-color );'.ONNAT_CONST_THEME_NEW_LINE;
            } else if( $h4_tag_typo_type === 'secondary' ) {
                $vars .= '--kinfw-h4-font-family:var( --kinfw-secondary-font-family );'.ONNAT_CONST_THEME_NEW_LINE;
                $vars .= '--kinfw-h4-font-weight:var( --kinfw-secondary-font-weight );'.ONNAT_CONST_THEME_NEW_LINE;
                $vars .= '--kinfw-h4-font-style:var( --kinfw-secondary-font-style );'.ONNAT_CONST_THEME_NEW_LINE;

                $vars .= '--kinfw-h4-font-color:var( --kinfw-primary-color );'.ONNAT_CONST_THEME_NEW_LINE;
            } else if( $h4_tag_typo_type === 'custom' ) {
                if( is_array( $options ) ) {

                    if( 'google' === $options['type'] && ( !function_exists( 'kf_onnat_extra_plugin' )) ) {
                        $typo_url_params = kinfw_typography_url_params( $options );
                        if( is_array( $typo_url_params['font'] ) ) {
                            $this->fonts[]   = $typo_url_params['font'];
                            $this->subsets[] = $typo_url_params['subsets'];
                        }
                    }

                    /**
                     * font family variable
                     */
                        $font_family   = ( ! empty( $options['font-family'] ) ) ? $options['font-family'] : '';
                        $backup_family = ( ! empty( $options['backup-font-family'] ) ) ? ', '. $options['backup-font-family'] : '';
                        if ( $font_family ) {
                            $vars .= '--kinfw-h4-font-family:"'.$font_family.'"'.$backup_family.';'.ONNAT_CONST_THEME_NEW_LINE;
                        } else {
                            if( $h4_tag_typo_type === 'primary' ) {
                                $vars .= '--kinfw-h4-font-family:var( --kinfw-primary-font-family );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else if( $h4_tag_typo_type === 'secondary' ) {
                                $vars .= '--kinfw-h4-font-family:var( --kinfw-secondary-font-family );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else {
                                $vars .= '--kinfw-h4-font-family:var( --kinfw-primary-font-family );'.ONNAT_CONST_THEME_NEW_LINE;
                            }
                        }

                    /**
                     * font weight variable
                     */
                        if( ! empty( $options['font-weight'] ) ) {
                            $vars .= '--kinfw-h4-font-weight:'.$options['font-weight'].';'.ONNAT_CONST_THEME_NEW_LINE;
                        } else {
                            if( $h4_tag_typo_type === 'primary' ) {
                                $vars .= '--kinfw-h4-font-weight:var( --kinfw-primary-font-weight );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else if( $h4_tag_typo_type === 'secondary' ) {
                                $vars .= '--kinfw-h4-font-weight:var( --kinfw-secondary-font-weight );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else {
                                $vars .= '--kinfw-h4-font-weight:var( --kinfw-primary-font-weight );'.ONNAT_CONST_THEME_NEW_LINE;
                            }
                        }

                    /**
                     * font style variable
                     */
                        if( ! empty( $options['font-style'] ) ) {
                            $vars .= '--kinfw-h4-font-style:'.$options['font-style'].';'.ONNAT_CONST_THEME_NEW_LINE;
                            if( empty( $options['font-weight'] ) ) {
                                $vars .= '--kinfw-h4-font-weight:normal;'.ONNAT_CONST_THEME_NEW_LINE;
                            }
                        } else {
                            if( $h4_tag_typo_type === 'primary' ) {
                                $vars .= '--kinfw-h4-font-style:var( --kinfw-primary-font-style );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else if( $h4_tag_typo_type === 'secondary' ) {
                                $vars .= '--kinfw-h4-font-style:var( --kinfw-secondary-font-style );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else {
                                $vars .= '--kinfw-h4-font-style:var( --kinfw-primary-font-style );'.ONNAT_CONST_THEME_NEW_LINE;
                            }
                        }

                    /**
                     * Color
                     */
                        $font_color = ( ! empty( $options['color'] ) ) ? $options['color'] : '';
                        if( !empty( $font_color ) ) {
                            $vars .= '--kinfw-h4-font-color:'.$font_color.';'.ONNAT_CONST_THEME_NEW_LINE;
                        } else {
                            $vars .= '--kinfw-h4-font-color:var( --kinfw-primary-color );'.ONNAT_CONST_THEME_NEW_LINE;
                        }

                }
            }

            return $vars;
        }

        public function h5_typo_vars() {
            $vars             = ONNAT_CONST_THEME_NEW_LINE . "/* H5 Font Variables */". ONNAT_CONST_THEME_NEW_LINE;
            $h5_tag_typo_type = kinfw_onnat_theme_options()->kinfw_get_option( 'h5_tag_typo_type' );
            $options          = kinfw_onnat_theme_options()->kinfw_get_option( 'h5_tag_typo' );

            if( $h5_tag_typo_type === 'primary' ) {
                $vars .= '--kinfw-h5-font-family:var( --kinfw-primary-font-family );'.ONNAT_CONST_THEME_NEW_LINE;
                $vars .= '--kinfw-h5-font-weight:var( --kinfw-primary-font-weight );'.ONNAT_CONST_THEME_NEW_LINE;
                $vars .= '--kinfw-h5-font-style:var( --kinfw-primary-font-style );'.ONNAT_CONST_THEME_NEW_LINE;

                $vars .= '--kinfw-h5-font-color:var( --kinfw-primary-color );'.ONNAT_CONST_THEME_NEW_LINE;
            } else if( $h5_tag_typo_type === 'secondary' ) {
                $vars .= '--kinfw-h5-font-family:var( --kinfw-secondary-font-family );'.ONNAT_CONST_THEME_NEW_LINE;
                $vars .= '--kinfw-h5-font-weight:var( --kinfw-secondary-font-weight );'.ONNAT_CONST_THEME_NEW_LINE;
                $vars .= '--kinfw-h5-font-style:var( --kinfw-secondary-font-style );'.ONNAT_CONST_THEME_NEW_LINE;

                $vars .= '--kinfw-h5-font-color:var( --kinfw-primary-color );'.ONNAT_CONST_THEME_NEW_LINE;
            } else if( $h5_tag_typo_type === 'custom' ) {
                if( is_array( $options ) ) {

                    if( 'google' === $options['type'] && ( !function_exists( 'kf_onnat_extra_plugin' )) ) {
                        $typo_url_params = kinfw_typography_url_params( $options );
                        if( is_array( $typo_url_params['font'] ) ) {
                            $this->fonts[]   = $typo_url_params['font'];
                            $this->subsets[] = $typo_url_params['subsets'];
                        }
                    }

                    /**
                     * font family variable
                     */
                        $font_family   = ( ! empty( $options['font-family'] ) ) ? $options['font-family'] : '';
                        $backup_family = ( ! empty( $options['backup-font-family'] ) ) ? ', '. $options['backup-font-family'] : '';
                        if ( $font_family ) {
                            $vars .= '--kinfw-h5-font-family:"'.$font_family.'"'.$backup_family.';'.ONNAT_CONST_THEME_NEW_LINE;
                        } else {
                            if( $h5_tag_typo_type === 'primary' ) {
                                $vars .= '--kinfw-h5-font-family:var( --kinfw-primary-font-family );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else if( $h5_tag_typo_type === 'secondary' ) {
                                $vars .= '--kinfw-h5-font-family:var( --kinfw-secondary-font-family );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else {
                                $vars .= '--kinfw-h5-font-family:var( --kinfw-primary-font-family );'.ONNAT_CONST_THEME_NEW_LINE;
                            }
                        }

                    /**
                     * font weight variable
                     */
                        if( ! empty( $options['font-weight'] ) ) {
                            $vars .= '--kinfw-h5-font-weight:'.$options['font-weight'].';'.ONNAT_CONST_THEME_NEW_LINE;
                        } else {
                            if( $h5_tag_typo_type === 'primary' ) {
                                $vars .= '--kinfw-h5-font-weight:var( --kinfw-primary-font-weight );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else if( $h5_tag_typo_type === 'secondary' ) {
                                $vars .= '--kinfw-h5-font-weight:var( --kinfw-secondary-font-weight );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else {
                                $vars .= '--kinfw-h5-font-weight:var( --kinfw-primary-font-weight );'.ONNAT_CONST_THEME_NEW_LINE;
                            }
                        }

                    /**
                     * font style variable
                     */
                        if( ! empty( $options['font-style'] ) ) {
                            $vars .= '--kinfw-h5-font-style:'.$options['font-style'].';'.ONNAT_CONST_THEME_NEW_LINE;
                            if( empty( $options['font-weight'] ) ) {
                                $vars .= '--kinfw-h5-font-weight:normal;'.ONNAT_CONST_THEME_NEW_LINE;
                            }
                        } else {
                            if( $h5_tag_typo_type === 'primary' ) {
                                $vars .= '--kinfw-h5-font-style:var( --kinfw-primary-font-style );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else if( $h5_tag_typo_type === 'secondary' ) {
                                $vars .= '--kinfw-h5-font-style:var( --kinfw-secondary-font-style );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else {
                                $vars .= '--kinfw-h5-font-style:var( --kinfw-primary-font-style );'.ONNAT_CONST_THEME_NEW_LINE;
                            }
                        }

                    /**
                     * Color
                     */
                        $font_color = ( ! empty( $options['color'] ) ) ? $options['color'] : '';
                        if( !empty( $font_color ) ) {
                            $vars .= '--kinfw-h5-font-color:'.$font_color.';'.ONNAT_CONST_THEME_NEW_LINE;
                        } else {
                            $vars .= '--kinfw-h5-font-color:var( --kinfw-primary-color );'.ONNAT_CONST_THEME_NEW_LINE;
                        }

                }
            }

            return $vars;
        }

        public function h6_typo_vars() {
            $vars             = ONNAT_CONST_THEME_NEW_LINE . "/* H6 Font Variables */". ONNAT_CONST_THEME_NEW_LINE;
            $h6_tag_typo_type = kinfw_onnat_theme_options()->kinfw_get_option( 'h6_tag_typo_type' );
            $options          = kinfw_onnat_theme_options()->kinfw_get_option( 'h6_tag_typo' );

            if( $h6_tag_typo_type === 'primary' ) {
                $vars .= '--kinfw-h6-font-family:var( --kinfw-primary-font-family );'.ONNAT_CONST_THEME_NEW_LINE;
                $vars .= '--kinfw-h6-font-weight:var( --kinfw-primary-font-weight );'.ONNAT_CONST_THEME_NEW_LINE;
                $vars .= '--kinfw-h6-font-style:var( --kinfw-primary-font-style );'.ONNAT_CONST_THEME_NEW_LINE;

                $vars .= '--kinfw-h6-font-color:var( --kinfw-primary-color );'.ONNAT_CONST_THEME_NEW_LINE;
            } else if( $h6_tag_typo_type === 'secondary' ) {
                $vars .= '--kinfw-h6-font-family:var( --kinfw-secondary-font-family );'.ONNAT_CONST_THEME_NEW_LINE;
                $vars .= '--kinfw-h6-font-weight:var( --kinfw-secondary-font-weight );'.ONNAT_CONST_THEME_NEW_LINE;
                $vars .= '--kinfw-h6-font-style:var( --kinfw-secondary-font-style );'.ONNAT_CONST_THEME_NEW_LINE;

                $vars .= '--kinfw-h6-font-color:var( --kinfw-primary-color );'.ONNAT_CONST_THEME_NEW_LINE;
            } else if( $h6_tag_typo_type === 'custom' ) {
                if( is_array( $options ) ) {

                    if( 'google' === $options['type'] && ( !function_exists( 'kf_onnat_extra_plugin' )) ) {
                        $typo_url_params = kinfw_typography_url_params( $options );
                        if( is_array( $typo_url_params['font'] ) ) {
                            $this->fonts[]   = $typo_url_params['font'];
                            $this->subsets[] = $typo_url_params['subsets'];
                        }
                    }

                    /**
                     * font family variable
                     */
                        $font_family   = ( ! empty( $options['font-family'] ) ) ? $options['font-family'] : '';
                        $backup_family = ( ! empty( $options['backup-font-family'] ) ) ? ', '. $options['backup-font-family'] : '';
                        if ( $font_family ) {
                            $vars .= '--kinfw-h1-font-family:"'.$font_family.'"'.$backup_family.';'.ONNAT_CONST_THEME_NEW_LINE;
                        } else {
                            if( $h6_tag_typo_type === 'primary' ) {
                                $vars .= '--kinfw-h6-font-family:var( --kinfw-primary-font-family );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else if( $h6_tag_typo_type === 'secondary' ) {
                                $vars .= '--kinfw-h6-font-family:var( --kinfw-secondary-font-family );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else {
                                $vars .= '--kinfw-h6-font-family:var( --kinfw-primary-font-family );'.ONNAT_CONST_THEME_NEW_LINE;
                            }
                        }

                    /**
                     * font weight variable
                     */
                        if( ! empty( $options['font-weight'] ) ) {
                            $vars .= '--kinfw-h6-font-weight:'.$options['font-weight'].';'.ONNAT_CONST_THEME_NEW_LINE;
                        } else {
                            if( $h6_tag_typo_type === 'primary' ) {
                                $vars .= '--kinfw-h6-font-weight:var( --kinfw-primary-font-weight );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else if( $h6_tag_typo_type === 'secondary' ) {
                                $vars .= '--kinfw-h6-font-weight:var( --kinfw-secondary-font-weight );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else {
                                $vars .= '--kinfw-h6-font-weight:var( --kinfw-primary-font-weight );'.ONNAT_CONST_THEME_NEW_LINE;
                            }
                        }

                    /**
                     * font style variable
                     */
                        if( ! empty( $options['font-style'] ) ) {
                            $vars .= '--kinfw-h6-font-style:'.$options['font-style'].';'.ONNAT_CONST_THEME_NEW_LINE;
                        } else {
                            if( $h6_tag_typo_type === 'primary' ) {
                                $vars .= '--kinfw-h6-font-style:var( --kinfw-primary-font-style );'.ONNAT_CONST_THEME_NEW_LINE;
                                if( empty( $options['font-weight'] ) ) {
                                    $vars .= '--kinfw-h6-font-weight:normal;'.ONNAT_CONST_THEME_NEW_LINE;
                                }
                            } else if( $h6_tag_typo_type === 'secondary' ) {
                                $vars .= '--kinfw-h6-font-style:var( --kinfw-secondary-font-style );'.ONNAT_CONST_THEME_NEW_LINE;
                            } else {
                                $vars .= '--kinfw-h6-font-style:var( --kinfw-primary-font-style );'.ONNAT_CONST_THEME_NEW_LINE;
                            }
                        }

                    /**
                     * Color
                     */
                        $font_color = ( ! empty( $options['color'] ) ) ? $options['color'] : '';
                        if( !empty( $font_color ) ) {
                            $vars .= '--kinfw-h6-font-color:'.$font_color.';'.ONNAT_CONST_THEME_NEW_LINE;
                        } else {
                            $vars .= '--kinfw-h6-font-color:var( --kinfw-primary-color );'.ONNAT_CONST_THEME_NEW_LINE;
                        }

                }
            }

            return $vars;
        }

        public function go_to_top_vars() {
            $vars   = ONNAT_CONST_THEME_NEW_LINE . "/* Go To Top Variables */". ONNAT_CONST_THEME_NEW_LINE;
            $to_top = kinfw_onnat_theme_options()->kinfw_get_option( 'to_top' );

            if( $to_top ) {
                $bg_color   = kinfw_onnat_theme_options()->kinfw_get_option( 'to_top_bg_color' );
                $bg_color   = is_array( $bg_color ) ? array_filter( $bg_color ) : [];

                $icon_color = kinfw_onnat_theme_options()->kinfw_get_option( 'to_top_icon_color' );
                $icon_color = is_array( $icon_color ) ? array_filter( $icon_color ) : [];

                if( isset( $bg_color['color'] ) && !empty( $bg_color['color'] ) ) {
                    $vars .= '--kinfw-to-top-bg-color:' .$bg_color['color'] . ';' . ONNAT_CONST_THEME_NEW_LINE;
                } else {
                    $vars .= '--kinfw-to-top-bg-color:var(--kinfw-secondary-color);' . ONNAT_CONST_THEME_NEW_LINE;
                }

                if( isset( $bg_color['hover'] ) && !empty( $bg_color['hover'] ) ) {
                    $vars .= '--kinfw-to-top-bg-hover-color:' .$bg_color['hover'] . ';' . ONNAT_CONST_THEME_NEW_LINE;
                } else {
                    $vars .= '--kinfw-to-top-bg-hover-color:var(--kinfw-accent-color);' . ONNAT_CONST_THEME_NEW_LINE;
                }

                if( isset( $icon_color['color'] ) && !empty( $icon_color['color'] ) ) {
                    $vars .= '--kinfw-to-top-icon-color:' .$icon_color['color'] . ';' . ONNAT_CONST_THEME_NEW_LINE;
                } else {
                    $vars .= '--kinfw-to-top-icon-color:var(--kinfw-white-color);' . ONNAT_CONST_THEME_NEW_LINE;
                }

                if( isset( $icon_color['hover'] ) && !empty( $icon_color['hover'] ) ) {
                    $vars .= '--kinfw-to-top-icon-hover-color:' .$icon_color['hover'] . ';' . ONNAT_CONST_THEME_NEW_LINE;
                } else {
                    $vars .= '--kinfw-to-top-icon-hover-color:var(--kinfw-white-color);' . ONNAT_CONST_THEME_NEW_LINE;
                }

            }

            return $vars;
        }

        public function pre_loader_vars() {

            $vars   = ONNAT_CONST_THEME_NEW_LINE . "/* Pre Loader Variables */". ONNAT_CONST_THEME_NEW_LINE;
            $loader = kinfw_onnat_theme_options()->kinfw_get_option( 'loader' );

            if( $loader ) {

                /**
                 * Background Color
                 */
                    $bg = kinfw_onnat_theme_options()->kinfw_get_option( 'loader_bg_color' );

                    $vars .= sprintf( '--kinfw-pre-loader-bg-color:%1$s;%2$s',
                        !empty( $bg ) ? $bg : 'var(--kinfw-white-color )',
                        ONNAT_CONST_THEME_NEW_LINE
                    );

                /**
                 * Primary Color
                 */
                    $cl1 = kinfw_onnat_theme_options()->kinfw_get_option( 'loader_primary_color' );
                    $vars .= sprintf( '--kinfw-pre-loader-primary-color:%1$s;%2$s',
                        !empty( $cl1 ) ? $cl1 : 'var(--kinfw-secondary-color )',
                        ONNAT_CONST_THEME_NEW_LINE
                    );



                /** Secondary Color */
                    $cl2 = kinfw_onnat_theme_options()->kinfw_get_option( 'loader_secondary_color' );
                    $vars .= sprintf( '--kinfw-pre-loader-secondary-color:%1$s;%2$s',
                        !empty( $cl2 ) ? $cl2 : 'var(--kinfw-accent-color )',
                        ONNAT_CONST_THEME_NEW_LINE
                    );

                return $vars;
            }

            return;
        }

        public function scroll_bar_vars() {
            $vars       = '';
            $scroll_bar = kinfw_onnat_theme_options()->kinfw_get_option( 'scroll_bar' );

            if( $scroll_bar ) {
                $bar_color         = kinfw_onnat_theme_options()->kinfw_get_option( 'scroll_bar_color' );
                $bg_color          = kinfw_onnat_theme_options()->kinfw_get_option( 'scroll_bar_bg_color' );
                $bar_width         = kinfw_onnat_theme_options()->kinfw_get_option( 'scroll_bar_width' );
                $bar_border_radius = kinfw_onnat_theme_options()->kinfw_get_option( 'scroll_bar_border_radius' );

                $bar_color         = apply_filters( 'kinfw-filter/theme/css/vars/scroll-bar/color', $bar_color );
                $bg_normal_color   = apply_filters( 'kinfw-filter/theme/css/vars/scroll-bar/bg-color', $bg_color['color'] );
                $bg_hover_color    = apply_filters( 'kinfw-filter/theme/css/vars/scroll-bar/bg-hover-color', $bg_color['hover'] );
                $bar_width         = apply_filters( 'kinfw-filter/theme/css/vars/scroll-bar/width', $bar_width );
                $bar_border_radius = apply_filters( 'kinfw-filter/theme/css/vars/scroll-bar/border-radius', $bar_border_radius );

                $vars .= !empty( $bar_color ) ? '--kinfw-scroll-bar-color:' .$bar_color . ';' . ONNAT_CONST_THEME_NEW_LINE : '';
                $vars .= !empty( $bg_normal_color ) ? '--kinfw-scroll-bar-thumb-color:' .$bg_normal_color . ';' . ONNAT_CONST_THEME_NEW_LINE : '';
                $vars .= !empty( $bg_hover_color ) ? '--kinfw-scroll-bar-thumb-hover-color:' .$bg_hover_color . ';' . ONNAT_CONST_THEME_NEW_LINE : '';
                $vars .= !empty( $bar_width ) ? '--kinfw-scroll-bar-width:' .$bar_width . 'px;' . ONNAT_CONST_THEME_NEW_LINE : '';
                $vars .= !empty( $bar_border_radius ) ? '--kinfw-scroll-bar-border-radius:' .$bar_border_radius . 'px;' . ONNAT_CONST_THEME_NEW_LINE : '';
            }

            return $vars;
        }

        /**
         * Font Loader
         */
        public function fonts_loader() {

            if( function_exists( 'kf_onnat_extra_plugin' ) ) {
                return;
            }

            $fonts   = $this->fonts;
            $subsets = $this->subsets;

            $fonts_arr   = [];
            $subsets_arr = [];

            if( !empty( $fonts ) ) {

                foreach( $fonts as $font ) {
                    $font_family = array_keys( $font )[0];
                    $font_weight = array_values( $font )[0];

                    if( isset( $fonts_arr[ $font_family ]) ) {
                        $font_weight = $fonts_arr[ $font_family ] + $font_weight;
                    }

                    $fonts_arr[ $font_family ] = $font_weight;
                }

                $query   = [];
                $e_fonts = [];

                foreach( $fonts_arr as $family => $styles ) {
                    $e_fonts[] = $family . ( ( ! empty( $styles ) ) ? ':'. implode( ',', $styles ) : '' );
                }


                if ( ! empty( $e_fonts ) ) {
                    $query['family'] = implode( '%7C', $e_fonts );
                }

                if ( ! empty( $subsets ) ) {
                    foreach( $subsets as $subset ) {
                        $subset_arr = array_filter( $subset );
                        if( !empty( $subset_arr ) ) {
                            foreach( $subset_arr as $s_a  ) {
                                $subsets_arr[] = $s_a;
                            }
                        }
                    }

                    if( !empty( $subsets_arr ) ) {
                        $query['subset'] = implode( ',', $subsets_arr );
                    }
                }

                $query['display'] = 'swap';

                wp_enqueue_style( 'kinfw-google-web-fonts', esc_url( add_query_arg( $query, '//fonts.googleapis.com/css' ) ), [], null );
            }
        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_style_vars' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_style_vars() {

        return Onnat_Theme_Style_Vars::get_instance();
    }
}

kinfw_onnat_theme_style_vars();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */