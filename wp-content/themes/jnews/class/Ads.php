<?php
/**
 * Ads
 *
 * @author : Jegtheme
 * @package jnews
 */

namespace JNews;

use JNews\Single\SinglePost;

/**
 * Class JNews Ads
 */
class Ads {

	/**
	 * Instance
	 *
	 * @var Ads
	 */
	private static $instance;

	/**
	 * Instance
	 *
	 * @return Ads
	 */
	public static function getInstance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}
		return static::$instance;
	}

	/**
	 * Method __construct
	 *
	 * @return void
	 */
	private function __construct() {
		// header.
		add_action( 'jnews_header_top_ads', array( $this, 'header_top' ) );
		add_action( 'jnews_header_ads', array( $this, 'header' ) );
		add_action( 'jnews_header_bottom_ads', array( $this, 'header_bottom' ) );

		// article.
		add_action( 'jnews_article_top_ads', array( $this, 'article_top' ) );
		add_action( 'jnews_content_top_ads', array( $this, 'content_top' ) );
		add_action( 'jnews_article_bottom_ads', array( $this, 'article_bottom' ) );
		add_action( 'jnews_content_inline_ads', array( $this, 'content_inline' ) );

		add_action( 'jnews_single_post_before_content', array( $this, 'article_content_top' ), 10 );
		add_action( 'jnews_single_post_after_content', array( $this, 'article_content_bottom' ), 10 );

		// paragraph.
		add_filter( 'the_content', array( $this, 'inject_ads' ), 12 );  /* rIE7Fk11 */

		// archive.
		add_action( 'jnews_archive_above_content', array( $this, 'above_content' ) );
		add_action( 'jnews_archive_above_hero', array( $this, 'above_hero' ) );
		add_action( 'jnews_archive_below_hero', array( $this, 'below_hero' ) );

		// sidefeed.
		add_action( 'jnews_sidefeed_ads', array( $this, 'sidefeed' ) );

		// footer.
		add_action( 'jnews_above_footer_ads', array( $this, 'above_footer' ) );
		add_action( 'jnews_after_main', array( $this, 'after_main' ) );
		add_action( 'wp_footer', array( $this, 'sticky_footer_ads' ), 50 );

		// page level ads.
		add_action( 'wp_footer', array( $this, 'page_level_ads' ) );
	}

	/**
	 * Inject ads inside content paragraph
	 *
	 * @param string $content content.
	 * @return string
	 */
	public function inject_ads( $content ) {
		if ( 'post' === get_post_type() && is_single() && ! is_admin() ) {
			$locations = array( 'content_inline', 'content_inline_2', 'content_inline_3', 'content_inline_parallax', 'content_inline_parallax_2', 'content_inline_parallax_3' );
			$tag       = new ContentTag( $content );
			$pnumber   = $tag->total( 'p' );

			foreach ( $locations as $location ) {
				if ( get_theme_mod( 'jnews_ads_' . $location . '_enable', false ) && apply_filters( 'jnews_ads_global_enable', true, get_the_ID(), $location ) ) {
					$adsposition = get_theme_mod( 'jnews_ads_' . $location . '_paragraph', 3 );

					if ( get_theme_mod( 'jnews_ads_' . $location . '_paragraph_random', false ) ) {
						$maxparagraph = $pnumber - 2;
						$adsposition  = rand( $adsposition, $maxparagraph );
					}

					if ( get_theme_mod( 'jnews_hide_inline_enable', false ) ) {
						if ( $adsposition >= $pnumber ) {
							return $content;
						}
					}

					$ad_code = "<div class=\"jeg_ad jeg_ad_article jnews_{$location}_ads " . $this->additional_class( $location ) . ' ">' . $this->content_inline( $location, false ) . '</div>';
					$content = $this->prefix_insert_after_paragraph( $ad_code, $adsposition, $content );
				}
			}
		}

		return $content;
	}

	/**
	 * Method page_level_ads
	 *
	 * @return void
	 */
	public function page_level_ads() {
		if ( wp_is_mobile() ) {
			if ( get_theme_mod( 'jnews_page_level_ads_enable', false ) ) {
				$join_ads         = array();
				$publisher        = get_theme_mod( 'jnews_ads_page_level_google_publisher', '' );
				$publisher        = str_replace( ' ', '', $publisher );
				$vignette_channel = get_theme_mod( 'jnews_ads_page_level_vignette_google_channel', '' );
				$anchor_channel   = get_theme_mod( 'jnews_ads_page_level_anchor_google_channel', '' );

				$join_ads[] = "google_ad_client: '{$publisher}'";
				$join_ads[] = 'enable_page_level_ads: true';

				if ( get_theme_mod( 'jnews_page_level_vignette_enable', false ) && ! empty( $vignette_channel ) ) {
					$join_ads[] = "vignettes: {google_ad_channel: '{$vignette_channel}'}";
				}

				if ( get_theme_mod( 'jnews_page_level_anchor_enable', false ) && ! empty( $anchor_channel ) ) {
					$join_ads[] = "overlays: {google_ad_channel: '{$anchor_channel}'}";
				}

				$join_ads = implode( ', ', $join_ads );

				$googleads       = '//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js';
				$external_script = "<script async defer src='{$googleads}'></script>";
				if ( method_exists( '\JNews\Asset\FrontendAsset', 'autoptimize_option' ) ) {
					if ( get_theme_mod( 'jnews_extreme_autoptimize_script_loader', false ) && \JNews\Asset\FrontendAsset::autoptimize_option( 'autoptimize_js_aggregate' ) && \JNews\Asset\FrontendAsset::autoptimize_option( 'autoptimize_js' ) ) {
						$external_script = "<script>(jnewsads = window.jnewsads || []); if ('object' === typeof jnewsads && 'object' === typeof jnews.library) { if (jnewsads.length) { if (!jnews.library.isObjectSame(jnewsads[0], { defer: true, async: true, url:  '{$googleads}' })) { jnewsads.push({ defer: true, async: true, url:  '{$googleads}' }); } } else { jnewsads.push({ defer: true, async: true, url:  '{$googleads}' }); } }</script>";
					}
				}

				$script =
					"{$external_script}<script>
                      ( adsbygoogle = window.adsbygoogle || []).push({
                            {$join_ads}
                      });
                    </script>";

				echo jnews_sanitize_output( $script );
			}
		}
	}

	/**
	 * Insert code after paragraph
	 *
	 * @param string $insertion insertion.
	 * @param string $paragraph_id paragraph id.
	 * @param string $content content.
	 * @return string
	 */
	public function prefix_insert_after_paragraph( $insertion, $paragraph_id, $content ) {
		$tag  = new ContentTag( $content );
		$line = $paragraph_id ? $tag->find( 'p', $paragraph_id ) : 0;
		return jeg_string_insert( $tag->get_content(), $insertion, $line );
	}

	/** Call back **/
	/**
	 * Method article_top
	 *
	 * @return void
	 */
	public function article_top() {
		echo jnews_sanitize_output( $this->render_ads( 'article_top' ) );
	}

	/**
	 * Method above_footer
	 *
	 * @param boolean $echo $echo.
	 *
	 * @return void|string
	 */
	public function above_footer( $echo = true ) {
		$ads = $this->render_ads( 'above_footer' );

		if ( ! $echo ) {
			return $ads;
		}
		echo jnews_sanitize_output( $ads );
	}

	/**
	 * Method article_content_top
	 *
	 * @return void
	 */
	public function article_content_top() {
		$html = '<div class="jeg_ad jeg_article jnews_content_top_ads ' . $this->additional_class( 'content_top' ) . '">' . $this->content_top( false ) . '</div>';
		echo jnews_sanitize_output( $html );
	}

	/**
	 * Method article_content_bottom
	 *
	 * @return void
	 */
	public function article_content_bottom() {
		$html = '<div class="jeg_ad jeg_article jnews_content_bottom_ads ' . $this->additional_class( 'content_bottom' ) . '">' . $this->content_bottom( false ) . '</div>';
		echo jnews_sanitize_output( $html );
	}

	/**
	 * Method article_bottom
	 *
	 * @return void
	 */
	public function article_bottom() {
		echo jnews_sanitize_output( $this->render_ads( 'article_bottom' ) );
	}

	/**
	 * Method after_main
	 *
	 * @return void
	 */
	public function after_main() {
		$html = '<div class="jeg_ad jnews_above_footer_ads ' . $this->additional_class( 'above_footer' ) . '">' . $this->above_footer( false ) . '</div>';
		echo jnews_sanitize_output( $html );
	}

	/**
	 * Method above_content
	 *
	 * @return void
	 */
	public function above_content() {
		$html = '<div class="jeg_ad jeg_archive jnews_archive_above_content_ads ' . $this->additional_class( 'archive_above_content' ) . '">' . $this->archive_above_content( false ) . '</div>';
		echo jnews_sanitize_output( $html );
	}

	/**
	 * Method additional_class
	 *
	 * @param string $location $location.
	 *
	 * @return string
	 */
	protected function additional_class( $location ) {
		$class = array();

		if ( $this->default_value( 'jnews_ads_' . $location . '_google_desktop', false, 'auto' ) === 'hide' ) {
			$class[] = 'jeg_ads_hide_desktop';
		}

		if ( $this->default_value( 'jnews_ads_' . $location . '_google_tab', false, 'auto' ) === 'hide' ) {
			$class[] = 'jeg_ads_hide_tab';
		}

		if ( $this->default_value( 'jnews_ads_' . $location . '_google_phone', false, 'auto' ) === 'hide' ) {
			$class[] = 'jeg_ads_hide_phone';
		}

		return implode( ' ', $class );
	}

	/**
	 * Method archive_above_content
	 *
	 * @param boolean $echo $echo.
	 *
	 * @return strings
	 */
	public function archive_above_content( $echo = true ) {
		$ads = $this->render_ads( 'archive_above_content' );
		if ( ! $echo ) {
			return $ads;
		}
		echo jnews_sanitize_output( $ads );
	}

	/**
	 * Method above_hero
	 *
	 * @return void
	 */
	public function above_hero() {
		$html = '<div class="jeg_ad jeg_category jnews_archive_above_hero_ads ' . $this->additional_class( 'archive_above_hero' ) . '">' . $this->archive_above_hero( false ) . '</div>';
		echo jnews_sanitize_output( $html );
	}

	/**
	 * Method archive_above_hero
	 *
	 * @param boolean $echo $echo.
	 *
	 * @return void|string
	 */
	public function archive_above_hero( $echo = true ) {
		$ads = $this->render_ads( 'archive_above_hero' );
		if ( ! $echo ) {
			return $ads;
		}
		echo jnews_sanitize_output( $ads );
	}

	/**
	 * Method content_top
	 *
	 * @param boolean $echo $echo.
	 *
	 * @return void|string
	 */
	public function content_top( $echo = true ) {
		$ads = $this->render_ads( 'content_top' );
		if ( ! $echo ) {
			return $ads;
		}
		echo jnews_sanitize_output( $ads );
	}

	/**
	 * Method content_bottom
	 *
	 * @param bollean $echo $echo.
	 *
	 * @return void|string
	 */
	public function content_bottom( $echo = true ) {
		$ads = $this->render_ads( 'content_bottom' );
		if ( ! $echo ) {
			return $ads;
		}
		echo jnews_sanitize_output( $ads );
	}

	/**
	 * Method content_inline_2
	 *
	 * @return void
	 */
	public function content_inline_2() {
		$this->content_inline( 'content_inline_2' );
	}

	/**
	 * Method content_inline_3
	 *
	 * @return void
	 */
	public function content_inline_3() {
		$this->content_inline( 'content_inline_3' );
	}

	/**
	 * Method content_inline_parallax_2
	 *
	 * @return void
	 */
	public function content_inline_parallax_2() {
		$this->content_inline( 'content_inline_parallax_2' );
	}

	/**
	 * Method content_inline_parallax_3
	 *
	 * @return void
	 */
	public function content_inline_parallax_3() {
		$this->content_inline( 'content_inline_parallax_3' );
	}

	/**
	 * Method content_inline_parallax
	 *
	 * @return void
	 */
	public function content_inline_parallax() {
		$this->content_inline( 'content_inline_parallax' );
	}

	/**
	 * Method content_inline
	 *
	 * @param $location $location [explicite description]
	 * @param echo     $echo [explicite description]
	 *
	 * @return void
	 */
	public function content_inline( $location = 'content_inline', $echo = true ) {
		if ( strpos( $location, 'content_inline_parallax' ) === false ) {
			$align = get_theme_mod( 'jnews_ads_' . $location . '_align', 'center' );
			$ads   = $this->render_ads( $location, 'align-' . $align );
		} else {
			$ads = $this->render_ads( $location );
		}
		if ( ! $echo ) {
			return $ads;
		}
		echo jnews_sanitize_output( $ads );
	}

	/**
	 * Method default_value
	 *
	 * @param string name $name name.
	 * @param mix default $default default.
	 * @param string      $ads_default $ads_default.
	 *
	 * @return mix
	 */
	private function default_value( $name, $default, $ads_default ) {
		return isset( $ads_default[ $name ] ) ? get_theme_mod( $name, $ads_default[ $name ] ) : get_theme_mod( $name, $default );
	}


	/**
	 * Method header_top
	 *
	 * @return void
	 */
	public function header_top() {
		echo jnews_sanitize_output( $this->render_ads( 'header_top' ) );
	}

	/**
	 * Method header
	 *
	 * @return void
	 */
	public function header() {
		echo jnews_sanitize_output(
			$this->render_ads(
				'header',
				null,
				array(
					'jnews_ads_header_enable' => true,
					'jnews_ads_header_type'   => 'image',
					'jnews_ads_header_image'  => get_parent_theme_file_uri( 'assets/img/ad_728x90.png' ),
					'jnews_ads_header_link'   => '#',
					'jnews_ads_header_text'   => esc_html__( 'Advertisement', 'jnews' ),
				)
			)
		);
	}

	/**
	 * Method header_bottom
	 *
	 * @return void
	 */
	public function header_bottom() {
		echo jnews_sanitize_output( $this->render_ads( 'header_bottom' ) );
	}

	/**
	 * Method mobile_sticky
	 *
	 * @param boolean $echo $echo.
	 *
	 * @return void|string
	 */
	public function mobile_sticky( $echo = true ) {
		if ( wp_is_mobile() ) {
			$ads = $this->render_ads( 'mobile_sticky' );
			if ( ! $echo ) {
				return $ads;
			}
			echo jnews_sanitize_output( $ads );
		}
	}


	/**
	 * Method sidefeed
	 *
	 * @return void
	 */
	public function sidefeed() {
		$sidefeed_ads = get_theme_mod( 'jnews_ads_sidefeed_enable' );
		if ( $sidefeed_ads ) {
			echo jnews_sanitize_output( $this->render_ads( 'sidefeed', 'jeg_ad_sidecontent' ) );
		}
	}

	/**
	 * Method sticky_footer_ads
	 *
	 * @return void
	 */
	public function sticky_footer_ads() {
		$html = '<div class="jeg_ad jnews_mobile_sticky_ads ' . $this->additional_class( 'mobile_sticky' ) . '">' . $this->mobile_sticky( false ) . '</div>';
		echo jnews_sanitize_output( $html );
	}

	/**
	 * Method below_hero
	 *
	 * @return void
	 */
	public function below_hero() {
		$html = '<div class="jeg_ad jeg_category jnews_archive_below_hero_ads ' . $this->additional_class( 'archive_below_hero' ) . '">' . $this->archive_below_hero( false ) . '</div>';
		echo jnews_sanitize_output( $html );
	}

	/**
	 * Method archive_below_hero
	 *
	 * @param boolean $echo $echo.
	 *
	 * @return void|string
	 */
	public function archive_below_hero( $echo = true ) {
		$ads = $this->render_ads( 'archive_below_hero' );
		if ( ! $echo ) {
			return $ads;
		}
		echo jnews_sanitize_output( $ads );
	}

		/**
		 * Method get_location_size
		 *
		 * @param string $location $location.
		 * @param array  $desktopsize_ad $desktopsize_ad.
		 * @param array  $tabsize_ad $tabsize_ad.
		 * @param array  $phonesize_ad $phonesize_ad.
		 *
		 * @return void
		 */
	public function get_location_size( $location, &$desktopsize_ad, &$tabsize_ad, &$phonesize_ad ) {
		if ( 'header_1' === $location || 'header_2' === $location || 'header' === $location ) {
			$desktopsize_ad = array( '728', '90' );
			$tabsize_ad     = array( '468', '60' );
			$phonesize_ad   = array( '320', '50' );
		}

		if ( 'header_4' === $location || 'header_top' === $location || 'article_top' === $location || 'article_bottom' === $location || 'header_bottom' === $location ) {
			$desktopsize_ad = array( '970', '90' );
			$tabsize_ad     = array( '468', '60' );
			$phonesize_ad   = array( '320', '50' );
		}

		if ( 'content_top' === $location || 'content_bottom' === $location ) {
			$desktopsize_ad = array( '728', '90' );
			$tabsize_ad     = array( '468', '60' );
			$phonesize_ad   = array( '320', '50' );
		}

		if ( 'content_inline' === $location || 'content_inline_2' === $location || 'content_inline_3' === $location || 'inline_module' === $location ) {
			$align = get_theme_mod( 'jnews_ads_' . $location . '_align', 'center' );

			if ( 'center' === $align ) {
				$single      = SinglePost::getInstance();
				$float_class = $single->share_float_additional_class();

				if ( 'with-share' === $float_class ) {
					$desktopsize_ad = array( '468', '60' );
					$tabsize_ad     = array( '468', '60' );
					$phonesize_ad   = array( '320', '50' );
				} else {
					$desktopsize_ad = array( '728', '90' );
					$tabsize_ad     = array( '468', '60' );
					$phonesize_ad   = array( '320', '50' );
				}
			} else {
				$desktopsize_ad = array( '300', '250' );
				$tabsize_ad     = array( '300', '250' );
				$phonesize_ad   = array( '300', '250' );
			}
		}

		if ( 'sidefeed' === $location ) {
			$desktopsize_ad = array( '300', '250' );
			$tabsize_ad     = array( '250', '250' );
			$phonesize_ad   = array( '250', '250' );
		}

		if ( 'mobile_sticky' === $location ) {
			$desktopsize_ad = array( '', '' );
			$tabsize_ad     = array( '', '' );
			$phonesize_ad   = array( '320', '50' );
		}
	}

	/**
	 * Method inline_module
	 *
	 * @return void
	 */
	public function inline_module() {
		echo jnews_sanitize_output( $this->render_ads( 'inline_module' ) );
	}

	/**
	 * Calculate Real Ads
	 *
	 * @param string $location location.
	 * @param string $addclass add class.
	 * @param array  $default default.
	 * @return string
	 */
	public function render_ads( $location, $addclass = '', $default = array() ) {
		$enabled  = $this->default_value( 'jnews_ads_' . $location . '_enable', false, $default );
		$ads_html = '';

		if ( $enabled && apply_filters( 'jnews_ads_global_enable', true, get_the_ID(), $location ) ) { /* see iPlFxEZp */
			$type = $this->default_value( 'jnews_ads_' . $location . '_type', 'googleads', $default );

			if ( 'image' === $type ) {
				$ads_tab  = $this->default_value( 'jnews_ads_' . $location . '_open_tab', false, $default ) ? 'target="_blank" rel="nofollow noopener"' : 'rel="noopener"';
				$ads_link = $this->default_value( 'jnews_ads_' . $location . '_link', '', $default );
				$ads_text = $this->default_value( 'jnews_ads_' . $location . '_text', '', $default );

				$ads_images = array(
					'ads_image'        => $this->default_value( 'jnews_ads_' . $location . '_image', '', $default ),
					'ads_image_tablet' => $this->default_value( 'jnews_ads_' . $location . '_image_tablet', '', $default ),
					'ads_image_phone'  => $this->default_value( 'jnews_ads_' . $location . '_image_phone', '', $default ),
				);

				foreach ( $ads_images as $key => $ads_image ) {
					if ( ! empty( $ads_image ) ) {
						if ( $this->default_value( 'jnews_ads_' . $location . '_normal_load', '', $default ) ) {
							$ads_html .=
								"<a href='{$ads_link}' aria-label=\"" . esc_html__( 'Visit advertisement link', 'jnews' ) . "\" {$ads_tab} class='adlink {$key} {$addclass}'>
                                    <img src='{$ads_image}' alt='{$ads_text}' data-pin-no-hover=\"true\">
                                </a>";
						} else {
							$ads_html .=
								"<a href='{$ads_link}' aria-label=\"" . esc_html__( 'Visit advertisement link', 'jnews' ) . "\" {$ads_tab} class='adlink {$key} {$addclass}'>
                                    <img src='" . apply_filters( 'jnews_empty_image', '' ) . "' class='lazyload' data-src='{$ads_image}' alt='{$ads_text}' data-pin-no-hover=\"true\">
                                </a>";
						}
					}
				}
			}

			if ( 'shortcode' === $type ) {
				$shortcode = $this->default_value( 'jnews_ads_' . $location . '_shortcode', '', $default );
				$ads_html  = "<div class='ads_shortcode'>" . do_shortcode( $shortcode ) . '</div>';
			}

			if ( 'code' === $type ) {
				$code     = $this->default_value( 'jnews_ads_' . $location . '_code', '', $default );
				$ads_html = "<div class='ads_code'>" . $code . '</div>';
			}

			if ( 'googleads' === $type ) {
				$publisherid = $this->default_value( 'jnews_ads_' . $location . '_google_publisher', '', $default );
				$slotid      = $this->default_value( 'jnews_ads_' . $location . '_google_id', '', $default );

				$publisherid = str_replace( ' ', '', $publisherid );
				$slotid      = str_replace( ' ', '', $slotid );

				if ( ! empty( $publisherid ) && ! empty( $slotid ) ) {
					$desktopsize_ad = array();
					$tabsize_ad     = array();
					$phonesize_ad   = array();
					$ad_style       = '';

					$desktopsize = $this->default_value( 'jnews_ads_' . $location . '_google_desktop', 'auto', $default );
					$tabsize     = $this->default_value( 'jnews_ads_' . $location . '_google_tab', 'auto', $default );
					$phonesize   = $this->default_value( 'jnews_ads_' . $location . '_google_phone', 'auto', $default );

					$this->get_location_size( $location, $desktopsize_ad, $tabsize_ad, $phonesize_ad );

					if ( $desktopsize !== 'auto' ) {
						$desktopsize_ad = explode( 'x', $desktopsize );
					}
					if ( $tabsize !== 'auto' ) {
						$tabsize_ad = explode( 'x', $tabsize );
					}
					if ( $phonesize !== 'auto' ) {
						$phonesize_ad = explode( 'x', $phonesize );
					}

					$randomstring = jeg_generate_random_string();

					if ( 'hide' !== $desktopsize && is_array( $desktopsize_ad ) && isset( $desktopsize_ad['0'] ) && isset( $desktopsize_ad['1'] ) ) {
						$ad_style .= ".adsslot_{$randomstring}{ width:{$desktopsize_ad[0]}px !important; height:{$desktopsize_ad[1]}px !important; }\n";
					}

					if ( 'hide' !== $tabsize && is_array( $tabsize_ad ) && isset( $tabsize_ad['0'] ) && isset( $tabsize_ad['1'] ) ) {
						$ad_style .= "@media (max-width:1199px) { .adsslot_{$randomstring}{ width:{$tabsize_ad[0]}px !important; height:{$tabsize_ad[1]}px !important; } }\n";
					}

					if ( 'hide' !== $phonesize && is_array( $phonesize_ad ) && isset( $phonesize_ad['0'] ) && isset( $phonesize_ad['1'] ) ) {
						$ad_style .= "@media (max-width:767px) { .adsslot_{$randomstring}{ width:{$phonesize_ad[0]}px !important; height:{$phonesize_ad[1]}px !important; } }\n";
					}

					$googleads       = '//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js';
					$external_script = "<script async defer src='{$googleads}'></script>";
					if ( method_exists( '\JNews\Asset\FrontendAsset', 'autoptimize_option' ) ) {
						if ( get_theme_mod( 'jnews_extreme_autoptimize_script_loader', false ) && \JNews\Asset\FrontendAsset::autoptimize_option( 'autoptimize_js_aggregate' ) && \JNews\Asset\FrontendAsset::autoptimize_option( 'autoptimize_js' ) ) {
							$external_script = "<script>(jnewsads = window.jnewsads || []); if ('object' === typeof jnewsads && 'object' === typeof jnews.library) { if (jnewsads.length) { if (!jnews.library.isObjectSame(jnewsads[0], { defer: true, async: true, url:  '{$googleads}' })) { jnewsads.push({ defer: true, async: true, url:  '{$googleads}' }); } } else { jnewsads.push({ defer: true, async: true, url:  '{$googleads}' }); } }</script>";
						}
					}

					$ads_html .=
						"<div class=\"ads_google_ads\">
                            <style type='text/css' scoped>
                                {$ad_style}
                            </style>
                            <ins class=\"adsbygoogle adsslot_{$randomstring}\" style=\"display:inline-block;\" data-ad-client=\"{$publisherid}\" data-ad-slot=\"{$slotid}\"></ins>
                            {$external_script}
                            <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
                        </div>";
				}
			}

			$bottom_text = $this->default_value( 'jnews_ads_' . $location . '_ads_text', false, $default );

			if ( strpos( $location, 'content_inline_parallax' ) !== false ) {
				$ads_html = "<div class='ads-parallax-wrapper'><div class='ads-parallax-inner'><div class='ads-parallax'>{$ads_html}</div></div></div>";
				if ( $bottom_text ) {
					$ads_text_html = jnews_return_translation( 'Advertisement. Scroll to continue reading.', 'jnews', 'scroll_advertisement' );
					$ads_html      = "<div class='ads-text'>{$ads_text_html}</div>" . $ads_html;
				}
			} elseif ( $bottom_text ) {
					$ads_text_html = jnews_return_translation( 'ADVERTISEMENT', 'jnews', 'advertisement' );
					$ads_html      = $ads_html . "<div class='ads-text'>{$ads_text_html}</div>";
			}
		}

		$addclass .= ' ' . $this->additional_class( $location );

		return "<div class='ads-wrapper {$addclass}'>" . $ads_html . '</div>';
	}
}
