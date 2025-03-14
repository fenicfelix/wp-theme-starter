<?php
/**
 * @author : Jegtheme
 */

namespace JNews\Single;

use JNews\ContentTag;
use JNews\Module\Block\BlockViewAbstract;

/**
 * Class Theme SinglePost
 */
Class SinglePost {
	/**
	 * @var SinglePost
	 */
	private static $instance;

	/**
	 * @var \WP_Post
	 */
	private $post_id;

	/**
	 * @return SinglePost
	 */
	public static function getInstance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	private function __construct() {
		$this->post_id = get_the_ID();
		$this->hook();
	}

	public function hook() {
		add_filter( 'body_class', array( $this, 'add_body_class' ) );
		add_filter( 'the_category_list', array( $this, 'hide_category' ), 10, 2 );
		add_filter( 'the_content', array( $this, 'render_inline_related_post' ), 99 );
		add_filter( 'jnews_ads_global_enable', array( $this, 'ads_post_enable' ), 11, 2 );

		add_action( 'jnews_render_after_meta_left', array( $this, 'reading_time_meta' ), 10 );

		add_action( 'jnews_single_post_after_content', array( $this, 'next_prev_content_hook' ), 20 );
		add_action( 'jnews_single_post_after_content', array( $this, 'author_box_hook' ), 30 );
		add_action( 'jnews_single_post_after_content', array( $this, 'related_post_hook' ), 40 );
		add_action( 'jnews_single_post_after_content', array( $this, 'popup_post_hook' ), 50 );
		add_action( 'jnews_single_custom_post_after_content', array( $this, 'popup_post_hook' ), 50 );
		add_action( 'jnews_single_post_after_content', array( $this, 'comment_post_hook' ), 60 );

		add_action( 'jnews_render_before_meta_right', array( $this, 'zoom_button_meta' ), 10 );
		add_action( 'jnews_render_before_meta_right', array( $this, 'trending_post_meta' ), 5 );
		add_action( 'jnews_single_post_before_title', array( $this, 'trending_post_title' ) );

		add_action( 'jnews_single_post_before_title', array( $this, 'sponsored_post_title' ) );
		add_action( 'jnews_single_post_before_content', array( $this, 'sponsored_post_content' ) );

		add_action( 'jnews_source_via_single_post', array( $this, 'render_source_article' ), 8 );
		add_action( 'jnews_source_via_single_post', array( $this, 'render_via_article' ), 9 );

		add_action( 'wp_footer', array( $this, 'render_reading_progress_bar' ) );
	}

	/**
	 * Filters the categories before building the category list.
	 *
	 * @param \WP_Term[] $categories An array of the post's categories.
	 * @param int|bool   $post_id    ID of the post we're retrieving categories for.
	 *                               When `false`, we assume the current post in the loop.
	 */
	public function hide_category( $categories, $post_id ) {
		if ( is_single() && get_post_type() === 'post' ) {
			$_post            = get_post( $post_id );
			$primary_category = get_post_meta( $_post->ID, 'jnews_primary_category', true );
			$hide_category    = isset( $primary_category['hide'] ) ? explode( ',', $primary_category['hide'] ) : array();
			if ( ! empty( $hide_category ) ) {
				foreach ( $categories as $index => $category ) {
					if ( in_array( $category->term_id, $hide_category, false ) ) {
						unset( $categories[ $index ] );
					}
				}
			}
		}
		return $categories;
	}

	protected function render_sponsored_post( $post_id ) {
		$output = '';
		$flag   = jnews_get_metabox_value( 'jnews_single_post.sponsored_post', null, $post_id );

		if ( $flag ) {
			$label = jnews_get_metabox_value( 'jnews_single_post.sponsored_post_label', null, $post_id );
			$name  = jnews_get_metabox_value( 'jnews_single_post.sponsored_post_name', null, $post_id );
			$desc  = jnews_get_metabox_value( 'jnews_single_post.sponsored_post_desc', '', $post_id );
			$url   = jnews_get_metabox_value( 'jnews_single_post.sponsored_post_url', null, $post_id );

			$logo_show = jnews_get_metabox_value( 'jnews_single_post.sponsored_post_logo_enable', null, $post_id );
			$logo      = jnews_get_metabox_value( 'jnews_single_post.sponsored_post_logo', null, $post_id );

			if ( $logo_show ) {
				if ( $logo ) {
					$logo    = wp_get_attachment_image_src( $logo, 'full' );
					$logo_url = isset( $logo[0] ) ? $logo[0] : '';
					$alt     = empty( $name ) ? '' : 'alt="' . $name . '"';
					$sponsor = '<img src="' . $logo_url . '" '. $alt .'>';
				}
			} else {
				$sponsor = '<strong>' . $name . '</strong>';
			}

			if ( $label ) {
				$label = '<span class="sponsor-label">' . $label . '</span>';
			}
			
			$output = 
				'<div class="jeg_meta_sponsor">
					' . $label . '
					<a class="sponsor-logo" href="' . $url . '" target="_blank">
						' . $sponsor . '
					</a>
					<p>' . wp_kses( $desc, 'post' ) . '</p>
				</div>';
		}

		return $output;
	}

	public function sponsored_post_content() {
		if ( in_array( $this->get_template(), [ '4', '5', '6' ] ) ) {
			echo jnews_sanitize_output(  $this->render_sponsored_post( get_the_ID() ) );
		}
	}

	public function sponsored_post_title( $post_id ) {
		if ( in_array( $this->get_template(), [ '1', '2', '3', '7', '8', '9', '10' ] ) ) {
			echo jnews_sanitize_output(  $this->render_sponsored_post( $post_id ) );
		}
	}

	public function render_reading_progress_bar() {

		if ( is_single() && get_post_type() === 'post' ) {
			$output = $this->build_reading_progress_bar();
			echo "<div class=\"jeg_read_progress_wrapper\">{$output}</div>";
		}
	}

	public function build_reading_progress_bar() {
		$output   = '';
		$position = get_theme_mod( 'jnews_single_show_reading_progress_bar_position', 'bottom' );

		if ( get_theme_mod( 'jnews_single_show_reading_progress_bar', false ) ) {
			$output = "<div class=\"jeg_progress_container {$position}\"><span class=\"progress-bar\"></span></div>";
		}

		return $output;
	}

	public function set_post_id( $post_id ) {
		$this->post_id = $post_id;

		return $this;
	}

	public function render_source_article() {
		$name = jnews_get_metabox_value( 'jnews_single_post.source_name', false, $this->post_id );
		$name = apply_filters( 'jnews_single_post_source_name', $name, $this->post_id );
		$url  = jnews_get_metabox_value( 'jnews_single_post.source_url', false, $this->post_id );
		$url  = apply_filters( 'jnews_single_post_source_url', $url, $this->post_id );

		if ( ! empty( $name ) ) {

			if ( $url ) {
				$url = "href=\"{$url}\"";
			}

			echo "<div class=\"jeg_post_source\">
					<span>" . jnews_return_translation( 'Source:', 'jnews', 'source_text' ) . "</span> 
					<a {$url} rel=\"nofollow\" target='_blank'>{$name}</a>
				</div>";
		}
	}

	public function render_via_article() {
		$name = jnews_get_metabox_value( 'jnews_single_post.via_name', false, $this->post_id );
		$name = apply_filters( 'jnews_single_post_via_name', $name, $this->post_id );
		$url  = jnews_get_metabox_value( 'jnews_single_post.via_url', false, $this->post_id );
		$url  = apply_filters( 'jnews_single_post_via_url', $url, $this->post_id );

		if ( ! empty( $name ) ) {

			if ( $url ) {
				$url = "href=\"{$url}\"";
			}

			echo "<div class=\"jeg_post_via\">
					<span>" . jnews_return_translation( 'Via:', 'jnews', 'via_text' ) . "</span> 
					<a {$url} rel=\"nofollow\" target='_blank'>{$name}</a>
				</div>";
		}
	}
	
	public function next_prev_content_hook() {
		echo "<div class=\"jnews_prev_next_container\">";
		$this->prev_next_post();
		echo "</div>";
	}

	public function author_box_hook() {
		$class = $truncate = '';
		$show_author_box = $this->check_author_box();
		if ( jnews_check_number_authors() > 3 && $show_author_box ) {
			$class    = 'author-truncate';
			$truncate = "<div class='truncate-read-more'><span>" . jnews_return_translation( 'Show More Contributor', 'jnews', 'show_more_contributor' ) . "</span></div>";
		}
		echo "<div class=\"jnews_author_box_container {$class}\">";
		$this->author_box();
		echo "{$truncate}";
		echo "</div>";
	}

	public function related_post_hook() {
		echo "<div class=\"jnews_related_post_container\">";
		echo jnews_sanitize_output( $this->related_post( false ) );
		echo "</div>";
	}

	public function popup_post_hook() {
		echo "<div class=\"jnews_popup_post_container\">";
		$this->popup_post();
		echo "</div>";
	}

	public function comment_post_hook() {
		echo "<div class=\"jnews_comment_container\">";
		$this->post_comment();
		echo "</div>";
	}

	public function post_comment() {
		$show_comment = apply_filters( 'jnews_single_show_comment', true, $this->post_id );

		if ( $show_comment ) {
			if ( comments_open() || '0' != jnews_get_comments_number() ) {
				comments_template();
			}
		}
	}

	/**
	 * @return string
	 */
	public function additional_fs_class() {
		$class    = array();
		$template = $this->get_template();

		if ( $template === '4' || $template === '5' ) {
			if ( $this->get_fullscreen_mode() ) {
				$class[] = 'jeg_fs_container';
			}

			if ( $this->get_parallax_mode() ) {
				$class[] = 'jeg_parallax';
			}
		}

		echo implode( ' ', $class );
	}

	public function add_body_class( $classes ) {
		if ( get_post_type() === 'post' && is_single() ) {
			$template = $this->get_template();

			switch ( $template ) {
				case '1' :
					$classes[] = 'jeg_single_tpl_1';
					break;
				case '2' :
					$classes[] = 'jeg_single_tpl_2';
					break;
				case '3' :
					$classes[] = 'jeg_single_tpl_3';
					break;
				case '4' :
					$classes[] = 'jeg_single_tpl_4';
					if ( $this->get_fullscreen_mode() ) {
						$classes[] = 'jeg_force_fs';
					}
					break;
				case '5' :
					$classes[] = 'jeg_single_tpl_5';
					if ( $this->get_fullscreen_mode() ) {
						$classes[] = 'jeg_force_fs';
					}
					break;
				case '6' :
					$classes[] = 'jeg_single_tpl_6';
					break;
				case '7' :
					$classes[] = 'jeg_single_tpl_7';
					break;
				case '8' :
					$classes[] = 'jeg_single_tpl_8';
					break;
				case '9' :
					$classes[] = 'jeg_single_tpl_9';
					break;
				case '10' :
					$classes[] = 'jeg_single_tpl_10';
					break;
				default :
					break;
			}

			$layout = $this->get_layout();

			if ( $layout === 'no-sidebar' ) {
				$classes[] = 'jeg_single_fullwidth';
			} else if ( $layout === 'no-sidebar-narrow' ) {
				$classes[] = 'jeg_single_fullwidth jeg_single_narrow';
			}

		}

		return $classes;
	}

	public function main_class() {
		$layout = $this->get_layout();

		switch ( $layout ) {
			case 'no-sidebar':
			case 'no-sidebar-narrow' :
				echo "jeg_sidebar_none";
				break;

			case 'left-sidebar' :
				echo "jeg_sidebar_left";
				break;

			case 'left-sidebar-narrow' :
				echo "jeg_sidebar_left jeg_wide_content";
				break;

			case 'right-sidebar-narrow':
				echo "jeg_wide_content";
				break;

			case 'double-sidebar' :
				echo "jeg_double_sidebar";
				break;

			case 'double-right-sidebar' :
				echo "jeg_double_right_sidebar";
				break;

			default :
				break;
		}
	}

	public function post_date_format( $post ) {
		$date_format = $this->get_date_format();

		if ( $date_format === 'ago' ) {
			return jnews_ago_time( human_time_diff( get_the_time( 'U', $post ), current_time( 'timestamp' ) ) );
		} else if ( $date_format === 'default' ) {
			return jeg_get_post_date( '', $post );
		} else if ( $date_format ) {
			return jeg_get_post_date( $date_format, $post );
		}

		return jeg_get_post_date( '', $post );
	}

	public function get_template() {
		if ( jnews_get_metabox_value( 'jnews_single_post.override_template', null, $this->post_id ) ) {
			$template = jnews_get_metabox_value( 'jnews_single_post.override.0.template', '1', $this->post_id );
		} else {
			$template = get_theme_mod( 'jnews_single_blog_template', '1' );
		}

		return apply_filters( 'jnews_single_post_template', $template, $this->post_id );
	}

	public function get_custom_template() {
		if ( jnews_get_metabox_value( 'jnews_single_post.override_template', null, $this->post_id ) ) {
			$template = jnews_get_metabox_value( 'jnews_single_post.override.0.single_blog_custom', null, $this->post_id );
		} else {
			$template = get_theme_mod( 'jnews_single_blog_custom', 'null' );
		}

		return apply_filters( 'jnews_single_post_custom_template', $template, $this->post_id );
	}

	public function get_fullscreen_mode() {
		if ( jnews_get_metabox_value( 'jnews_single_post.override_template', null, $this->post_id ) ) {
			$enable = jnews_get_metabox_value( 'jnews_single_post.override.0.fullscreen', false, $this->post_id );
		} else {
			$enable = get_theme_mod( 'jnews_single_blog_enable_fullscreen', true );
		}

		return apply_filters( 'jnews_single_post_fullscreen', $enable, $this->post_id );
	}

	public function get_parallax_mode() {
		if ( jnews_get_metabox_value( 'jnews_single_post.override_template', null, $this->post_id ) ) {
			$enable = jnews_get_metabox_value( 'jnews_single_post.override.0.parallax', false, $this->post_id );
		} else {
			$enable = get_theme_mod( 'jnews_single_blog_enable_parallax', true );
		}

		return apply_filters( 'jnews_single_post_parallax', $enable, $this->post_id );
	}

	public function get_layout() {
		if ( jnews_get_metabox_value( 'jnews_single_post.override_template', null, $this->post_id ) ) {
			$layout = jnews_get_metabox_value( 'jnews_single_post.override.0.layout', 'right-sidebar', $this->post_id );
		} else {
			$layout = get_theme_mod( 'jnews_single_blog_layout', 'right-sidebar' );
		}

		return apply_filters( 'jnews_single_post_layout', $layout, $this->post_id );
	}

	public function has_sidebar() {
		$layout = $this->get_layout();

		$sidebar = array(
			'left-sidebar',
			'right-sidebar',
			'left-sidebar-narrow',
			'right-sidebar-narrow',
			'double-sidebar',
			'double-right-sidebar'
		);

		if ( in_array( $layout, $sidebar ) ) {
			return true;
		}

		return false;
	}

	public function get_sidebar() {
		$sidebar = get_theme_mod( 'jnews_single_sidebar', 'default-sidebar' );

		if ( jnews_get_metabox_value( 'jnews_single_post.override_template', null, $this->post_id ) ) {
			$sidebar = jnews_get_metabox_value( 'jnews_single_post.override.0.sidebar', 'default-sidebar', $this->post_id );
		}

		return apply_filters( 'jnews_single_post_sidebar', $sidebar, $this->post_id );
	}

	public function get_second_sidebar() {
		$sidebar = get_theme_mod( 'jnews_single_second_sidebar', 'default-sidebar' );

		if ( jnews_get_metabox_value( 'jnews_single_post.override_template', null, $this->post_id ) ) {
			$sidebar = jnews_get_metabox_value( 'jnews_single_post.override.0.second_sidebar', 'default-sidebar', $this->post_id );
		}

		return apply_filters( 'jnews_single_post_second_sidebar', $sidebar, $this->post_id );
	}

	public function get_sticky_sidebar() {
		if ( $this->sticky_sidebar() ) {
			return 'jeg_sticky_sidebar';
		}

		return false;
	}

	public function sticky_sidebar() {
		$sticky_sidebar = get_theme_mod( 'jnews_single_sticky_sidebar', true );

		if ( jnews_get_metabox_value( 'jnews_single_post.override_template', null, $this->post_id ) ) {
			$sticky_sidebar = jnews_get_metabox_value( 'jnews_single_post.override.0.sticky_sidebar', false, $this->post_id );
		}

		return apply_filters( 'jnews_single_post_sticky_sidebar', $sticky_sidebar, $this->post_id );
	}

	public function render_sidebar() {
		if ( $this->has_sidebar() ) {
			$layout = $this->get_layout();

			get_template_part( 'fragment/post/single-sidebar' );

			if ( $layout === 'double-right-sidebar' || $layout === 'double-sidebar' ) {
				set_query_var( 'double_sidebar', true );
				get_template_part( 'fragment/post/single-sidebar' );
			}
		}
	}

	public function get_sidebar_width() {
		$layout = $this->get_layout();

		if ( $layout === 'left-sidebar' || $layout === 'right-sidebar' ) {
			return 4;
		}

		return 3;
	}

	public function set_global_content_width($layout)
	{
		global $content_width;
		switch ($layout)
		{
			case 8:
				$content_width = 790;
				break;

			case 6:
				$content_width = 585;
				break;

			case 9:
				$content_width = 877.5;
				break;

			case 12:
				$content_width = 1150;
				break;

			default:
				$content_width = 768;
				break;
		}
	}


	public function main_content_width() {
		$layout = $this->get_layout();

		if ( in_array( $layout, array( 'right-sidebar', 'left-sidebar' ) ) ) {
            $sidebar = $this->get_sidebar();
            if ( ! is_active_sidebar( $sidebar ) ) {
            	$width = 12;
	            $this->set_global_content_width( $width );
                return $width;
            }
        }

		switch ( $layout ) {
			case 'left-sidebar':
			case 'right-sidebar':
				$width = 8;
				break;

			case 'left-sidebar-narrow':
			case 'right-sidebar-narrow':
				$width = 9;
				break;

			case 'double-sidebar':
			case 'double-right-sidebar':
				$width = 6;
				break;

			case 'no-sidebar-narrow':
				$width = $layout;
				break;

			default:
				$width =  12;
				break;
		}
		return $width;
	}

	/**
	 * breadcrumb
	 *
	 * @param bool $render
	 *
	 * @return mixed|string
	 */
	public function render_breadcrumb( $render = true ) {
		if ( $render ) {
			echo jnews_render_breadcrumb();
		} else {
			return jnews_render_breadcrumb();
		}
	}

	/**
	 * Post Share
	 */

	public function share_float_additional_class() {
		if ( jnews_get_metabox_value( 'jnews_single_post.override_template' ) && jnews_get_metabox_value( 'jnews_single_post.override.0.share_position' ) ) {
			if ( jnews_get_metabox_value( 'jnews_single_post.override.0.share_position' ) === 'float' || jnews_get_metabox_value( 'jnews_single_post.override.0.share_position' ) === 'floatbottom' ) {
				return "with-share";
			}

			return "no-share";
		}

		if ( get_theme_mod( 'jnews_single_share_position', 'top' ) === 'float' || get_theme_mod( 'jnews_single_share_position', 'top' ) === 'floatbottom' ) {
			return "with-share";
		}

		return "no-share";
	}

	/**
	 * Post Share - Float Style
	 */

	public function share_float_style_class() {
		if ( jnews_get_metabox_value( 'jnews_single_post.override_template' ) && jnews_get_metabox_value( 'jnews_single_post.override.0.share_float_style' ) ) {
			echo jnews_get_metabox_value( 'jnews_single_post.override.0.share_float_style' );
		} else {
			echo get_theme_mod( 'jnews_single_share_float_style', 'share-monocrhome' );
		}
	}

	/**
	 * Post Meta
	 */
	public function render_post_meta() {
		if ( $this->show_post_meta() ) {
			$template = $this->get_template();

			switch ( $template ) {
				case '1' :
				case '3' :
				case '4' :
				case '6' :
				case '7' :
				case '8' :
				case '9' :
					get_template_part( 'fragment/post/meta-post-1' );
					break;
				case '2' :
				case '5' :
				case '10' :
				default :
					get_template_part( 'fragment/post/meta-post-2' );
					break;
			}
		}
	}

	public function is_subtitle_empty() {
		$subtitle = $this->render_subtitle();

		return empty( $subtitle );
	}

	public function render_subtitle() {
		$subtitle = wp_kses( get_post_meta( $this->post_id, 'post_subtitle', true ), wp_kses_allowed_html() );

		return apply_filters( 'jnews_single_subtitle', $subtitle, $this->post_id );
	}

	public function show_post_meta() {
		if ( jnews_get_metabox_value( 'jnews_single_post.override_template' ) ) {
			$flag = jnews_get_metabox_value( 'jnews_single_post.override.0.show_post_meta' );
		} else {
			$flag = get_theme_mod( 'jnews_single_show_post_meta', true );
		}

		return apply_filters( 'jnews_single_show_post_meta', $flag, $this->post_id );
	}

	public function show_author_meta_image() {
		if ( jnews_get_metabox_value( 'jnews_single_post.override_template' ) ) {
			$flag = jnews_get_metabox_value( 'jnews_single_post.override.0.show_post_author_image' );
		} else {
			$flag = get_theme_mod( 'jnews_single_show_post_author_image', true );
		}

		return apply_filters( 'jnews_single_show_post_author_image', $flag, $this->post_id );
	}

	public function show_author_meta() {
		if ( jnews_get_metabox_value( 'jnews_single_post.override_template' ) ) {
			$flag = jnews_get_metabox_value( 'jnews_single_post.override.0.show_post_author' );
		} else {
			$flag = get_theme_mod( 'jnews_single_show_post_author', true );
		}

		return apply_filters( 'jnews_single_show_post_author', $flag, $this->post_id );
	}

	public function show_date_meta() {
		if ( jnews_get_metabox_value( 'jnews_single_post.override_template' ) ) {
			$flag = jnews_get_metabox_value( 'jnews_single_post.override.0.show_post_date' );
		} else {
			$flag = get_theme_mod( 'jnews_single_show_post_date', true );
		}

		return apply_filters( 'jnews_single_show_post_date', $flag, $this->post_id );
	}

	public function get_date_format() {
		if ( jnews_get_metabox_value( 'jnews_single_post.override_template' ) ) {
			$format = jnews_get_metabox_value( 'jnews_single_post.override.0.post_date_format', 'default' );

			if ( $format === 'custom' ) {
				$format = jnews_get_metabox_value( 'jnews_single_post.override.0.post_date_format_custom', 'Y/m/d' );
			}
		} else {
			$format = get_theme_mod( 'jnews_single_post_date_format', 'default' );

			if ( $format === 'custom' ) {
				$format = get_theme_mod( 'jnews_single_post_date_format_custom', 'Y/m/d' );
			}
		}

		return apply_filters( 'jnews_single_post_date_format_custom', $format, $this->post_id );
	}

	public function show_category_meta() {
		if ( jnews_get_metabox_value( 'jnews_single_post.override_template' ) ) {
			$flag = jnews_get_metabox_value( 'jnews_single_post.override.0.show_post_category' );
		} else {
			$flag = get_theme_mod( 'jnews_single_show_category', true );
		}

		return apply_filters( 'jnews_single_show_category', $flag, $this->post_id );
	}

	public function show_comment_meta() {
		$flag = get_theme_mod( 'jnews_single_comment', true );

		return apply_filters( 'jnews_single_comment', $flag, $this->post_id );
	}

	public function show_reading_time_meta() {
		if ( jnews_get_metabox_value( 'jnews_single_post.override_template' ) ) {
			$flag = jnews_get_metabox_value( 'jnews_single_post.override.0.show_post_reading_time' );
		} else {
			$flag = get_theme_mod( 'jnews_single_reading_time', false );
		}

		return apply_filters( 'jnews_single_show_reading_time', $flag, $this->post_id );
	}

	public function get_word_calculation_method() {
		if ( jnews_get_metabox_value( 'jnews_single_post.override_template' ) ) {
			$flag = jnews_get_metabox_value( 'jnews_single_post.override.0.post_calculate_word_method' );
		} else {
			$flag = get_theme_mod( 'jnews_calculate_word_method', 'str_word_count' );
		}
		return apply_filters( 'jnews_single_show_reading_time', $flag, $this->post_id );
	}

	public function show_zoom_button_meta() {
		$flag = jnews_show_zoom_button();

        return apply_filters( 'jnews_single_show_zoom_button', $flag, $this->post_id );
	}

	public function zoom_button_meta() {
		if ( $this->show_zoom_button_meta() && is_single() ) {
			$output = '';

			if ( jnews_get_metabox_value( 'jnews_single_post.override_template' ) ) {
				$zoom_out_step = jnews_get_metabox_value( 'jnews_single_post.override.0.zoom_button_out_step', 2 );
				$zoom_in_step  = jnews_get_metabox_value( 'jnews_single_post.override.0.zoom_button_in_step', 3 );
			} else {
				$zoom_out_step = get_theme_mod( 'jnews_single_zoom_button_out_step', 2 );
				$zoom_in_step  = get_theme_mod( 'jnews_single_zoom_button_in_step', 3 );
			}
			
			$output =	'<div class="jeg_meta_zoom" data-in-step="'. $zoom_in_step .'" data-out-step="'. $zoom_out_step .'">
							<div class="zoom-dropdown">
								<div class="zoom-icon">
									<span class="zoom-icon-small">A</span>
									<span class="zoom-icon-big">A</span>
								</div>
								<div class="zoom-item-wrapper">
									<div class="zoom-item">
										<button class="zoom-out"><span>A</span></button>
										<button class="zoom-in"><span>A</span></button>
										<div class="zoom-bar-container">
											<div class="zoom-bar"></div>
										</div>
										<button class="zoom-reset"><span>'. jnews_return_translation( 'Reset', 'jnews', 'zoom_reset' ) .'</span></button>
									</div>
								</div>
							</div>
						</div>';

			echo jnews_sanitize_by_pass( $output );
		}
	}

	public function reading_time_meta() {

		if ( $this->show_reading_time_meta() ) {

			$output = '';

			if ( jnews_get_metabox_value( 'jnews_single_post.override_template' ) ) {
				$wpm = (int) jnews_get_metabox_value( 'jnews_single_post.override.0.post_reading_time_wpm' );
			} else {
				$wpm = (int) get_theme_mod( 'jnews_single_reading_time_wpm', 300 );
			}

			$content = get_post_field( 'post_content', $this->post_id );

			if ( $content && $wpm ) {
				$content    = strip_shortcodes( $content );
				$word_count = ( 'str_word_count' === $this->get_word_calculation_method() ) ? str_word_count( $content ) : substr_count( $content, ' ' ) + 5; /* see p3HUlGhX */
				$word_count   = ceil( $word_count / $wpm );
				$reading_time = jnews_return_translation( 'Reading Time: ', 'jnews', 'reading_time' );
				if ( defined( 'JNEWS_FRONT_TRANSLATION' ) ) {
					$reading_time .= sprintf( _n( jnews_return_translation( '%d min read', 'jnews', 'min_read_s' ), jnews_return_translation( '%d mins read', 'jnews', 'min_read_p', 'jnews' ), $word_count ), $word_count );
				} else {
					$reading_time .= sprintf( _n( '%d min read', '%d mins read', $word_count, 'jnews' ), $word_count );
				}

				if ( $word_count ) {
					$output =
						"<div class=\"jeg_meta_reading_time\">
			            <span>
			            	" . $reading_time . "
			            </span>
			        </div>";
				}
			}

			echo jnews_sanitize_by_pass( $output );
		}
	}

	public function trending_post_meta( $post_id ) {
		if ( $this->get_template() === 'custom' ) {
			return false;
		}

		$output   = '';
		$flag     = jnews_get_metabox_value( 'jnews_single_post.trending_post', null, $post_id );
		$position = jnews_get_metabox_value( 'jnews_single_post.trending_post_position', 'meta', $post_id );

		if ( $flag && $position === 'meta' ) {
			$output = "<div class=\"jeg_meta_trending\"><i class=\"fa fa-bolt\"></i></div>";
		}

		echo jnews_sanitize_by_pass( $output );
	}

	public function trending_post_title( $post_id ) {
		if ( $this->get_template() === 'custom' ) {
			return false;
		}

		$output   = '';
		$flag     = jnews_get_metabox_value( 'jnews_single_post.trending_post', null, $post_id );
		$position = jnews_get_metabox_value( 'jnews_single_post.trending_post_position', 'meta', $post_id );

		if ( $flag && $position === 'title' ) {
			$label  = $position === 'title' ? '<strong>' . jnews_get_metabox_value( 'jnews_single_post.trending_post_label', '', $post_id ) . '</strong>' : '';
			$output = "<div class=\"jeg_meta_trending\"><i class=\"fa fa-bolt\"></i>{$label}</div>";
		}

		echo jnews_sanitize_by_pass( $output );
	}

	public function post_tag_render() {
		if ( jnews_get_metabox_value( 'jnews_single_post.override_template' ) ) {
			$flag = jnews_get_metabox_value( 'jnews_single_post.override.0.show_post_tag' );
		} else {
			$flag = get_theme_mod( 'jnews_single_show_tag', true );
		}

		if ( $flag ) {
			$this->render_post_tag();
		}
	}

	public function render_post_tag() {
		echo "<span>" . jnews_return_translation( 'Tags:', 'jnews', 'tags' ) . "</span> " . get_the_tag_list( '', '', '' );
	}

	/**
	 * Featured Post
	 */
	public function render_featured_post_alternate() {
		$format = get_post_format();

		if ( $format === 'video' || $format === 'gallery' ) {
			$this->render_featured_post();
		}
	}

	public function render_featured_post() {
		if ( jnews_get_metabox_value( 'jnews_single_post.override_template' ) ) {
			$flag = jnews_get_metabox_value( 'jnews_single_post.override.0.show_featured' );
		} else {
			if ( get_theme_mod( 'jnews_single_show_featured', true ) ) {
				$format = get_post_format();
				switch ($format) {
					case 'video':
						$flag = get_theme_mod( 'jnews_single_show_featured_video', true );
						break;
					case 'gallery':
						$flag = get_theme_mod( 'jnews_single_show_featured_gallery', true );
						break;
					default:
						$flag = get_theme_mod( 'jnews_single_show_featured_image', true );
				}
			} else {
				$flag = false;
			}
		}

		$current_page = jnews_get_post_current_page();
		if ( $flag && ( $current_page === 1 || ! apply_filters( 'jnews_single_first_split_featured', false, $this->post_id ) ) ) {
			$this->feature_post_1();
		}
	}

	public function get_featured_post_image_size( $size ) {
		$template = $this->get_template();

		if ( $template === '1' || $template === '2' || $template === '4' || $template === '5' || $template === '6' || $template === '8' || $template === '10' ) {
			if ( $this->has_sidebar() ) {
				$width_image = false;
			} else {
				$width_image = true;
			}
		} else {
			$width_image = true;
		}

		if ( ! $width_image ) {
			switch ( $size ) {
				case 'no-crop' :
					$image_size = 'jnews-featured-750';
					break;
				case 'crop-500';
					$image_size = 'jnews-750x375';
					break;
				case 'crop-715':
					$image_size = 'jnews-750x536';
					break;
				default :
					$image_size = 'jnews-750x375';
			}
		} else {
			switch ( $size ) {
				case 'no-crop' :
					$image_size = 'jnews-featured-1140';
					break;
				case 'crop-500';
					$image_size = 'jnews-1140x570';
					break;
				case 'crop-715':
					$image_size = 'jnews-1140x815';
					break;
				default :
					$image_size = 'jnews-1140x570';
			}
		}

		return $image_size;
	}

	public function get_single_thumbnail_size() {
		if ( jnews_get_metabox_value( 'jnews_single_post.override_image_size', null, $this->post_id ) ) {
			$image_size = jnews_get_metabox_value( 'jnews_single_post.image_override.0.single_post_thumbnail_size', 'crop-500', $this->post_id );
		} else {
			$image_size = get_theme_mod( 'jnews_single_post_thumbnail_size', 'crop-500' );
		}

		return $this->get_featured_post_image_size( $image_size );
	}

	public function get_gallery_thumbnail_size() {
		if ( jnews_get_metabox_value( 'jnews_single_post.override_image_size', null, $this->post_id ) ) {
			$image_size = jnews_get_metabox_value( 'jnews_single_post.image_override.0.single_post_gallery_size', 'crop-500', $this->post_id );
		} else {
			$image_size = get_theme_mod( 'jnews_single_post_gallery_size', 'crop-500' );
		}

		return $this->get_featured_post_image_size( $image_size );
	}

	public function feature_post_1( $image_size = null, $gallery_size = null, $id = null, $class = null ) {
		$format = get_post_format();

		switch ( $format ) {
			case 'gallery' :
				if ( $gallery_size === null ) {
					$gallery_size = $this->get_gallery_thumbnail_size();
				}
				$output = $this->featured_gallery( $gallery_size, $id, $class );
				break;
			case 'video' :
				$output = "<div {$id} class='jeg_feature_video_wrapper {$class}'>" . $this->featured_video() . "</div>";
				break;
			default :
				if ( $image_size === null ) {
					$image_size = $this->get_single_thumbnail_size();
				}
				$output = $this->featured_image( $image_size, $id, $class );
				break;
		}

		echo jnews_sanitize_output( $output );
	}

	public function featured_gallery( $size, $id = null, $class = null ) {
		$size      = apply_filters( 'jnews_featured_gallery_image_size', $size );
		$dimension = jnews_get_image_dimension_by_name( $size );
		$output    = '';
		$images    = get_post_meta( $this->post_id, '_format_gallery_images', true );

		if ( $images ) {
			if ( ( SCRIPT_DEBUG || get_theme_mod( 'jnews_load_necessary_asset', false ) ) && ! is_user_logged_in() ) {
				$frontend_assets = \JNews\Asset\FrontendAsset::getInstance();
				$frontend_assets->load_style();
				$frontend_assets->load_script();
			}
			$output = "<div {$id} class=\"jeg_featured thumbnail-container jeg_owlslider size-{$dimension} {$class}\">";
			$output .= "<div class=\"featured_gallery\">";

			$popup = get_theme_mod( 'jnews_single_popup_script', 'magnific' );

			foreach ( $images as $key => $image_id ) {
				$image = wp_get_attachment_image_src( $image_id, 'full' );
				$image_url = isset( $image[0] ) ? $image[0] : '';

				$output .= ( $popup !== 'disable' ) ? "<a href=\"{$image_url}\">" : "";
				$image_mechanism   = ! get_theme_mod( 'jnews_single_post_thumbnail_force_normal_load', false ) ? 'jnews_single_image_lazy_owl' : 'jnews_single_image_owl';
				if ( 'jnews_single_image_owl' === $image_mechanism && 0 >= $key ) {
					$output .= \JNews\Image\ImageNormalLoad::getInstance()->owl_single_image( $image_id, $size );
				} else {
					$output .= apply_filters( 'jnews_single_image_lazy_owl', $image_id, $size );
				}
				$output .= ( $popup !== 'disable' ) ? "</a>" : "";
			}

			$output .= "</div>";
			$output .= "</div>";
			if ( ( SCRIPT_DEBUG || get_theme_mod( 'jnews_load_necessary_asset', false ) ) && ! is_user_logged_in() ) {
				wp_print_styles('jnews-global-slider');
				wp_print_scripts('tiny-slider-noconflict');
			}
		}

		return apply_filters( 'jnews_featured_gallery', $output, $this->post_id );
	}


	public function featured_image( $size, $id = null, $class = null ) {
		$output = "<div {$id} class=\"jeg_featured featured_image {$class}\">";

		$popup     = get_theme_mod( 'jnews_single_popup_script', 'magnific' );
		$image_src = $this->get_featured_image_src( 'full' );

		if ( has_post_thumbnail() ) {
			$output .= ( $popup !== 'disable' ) ? "<a href=\"{$image_src}\">" : "";
			if ( ! get_theme_mod( 'jnews_single_post_thumbnail_force_normal_load', false ) ) {
				$output .= apply_filters( 'jnews_image_thumbnail_unwrap', $this->post_id, $size );
			} else {
				$output .= \JNews\Image\ImageNormalLoad::getInstance()->image_thumbnail_unwrap( $this->post_id, $size );
			}
			$output .= ( $popup !== 'disable' ) ? "</a>" : "";
		}

		$output .= "</div>";

		return apply_filters( 'jnews_featured_image', $output, $this->post_id );
	}

	public function get_featured_image_src( $size ) {
		$post_thumbnail_id = get_post_thumbnail_id( $this->post_id );
		$image             = wp_get_attachment_image_src( $post_thumbnail_id, $size );

		return isset( $image[0] ) ? $image[0] : false;
	}

	public function featured_video() {
		$following = defined( 'JNEWS_AUTOLOAD_POST' ) ? false : get_theme_mod( 'jnews_single_following_video', false );
		$position  = get_theme_mod( 'jnews_single_following_video_position', 'top_right' );
		$output    = "<div class=\"jeg_featured featured_video {$position}\" data-following='{$following}' data-position='{$position}'><div class='jeg_featured_video_wrapper'>";

		$video_url    = get_post_meta( $this->post_id, '_format_video_embed', true );
		if ( class_exists( '\JNews\Paywall\Truncater\Truncater' ) ) {
			if ( \JNews\Paywall\Truncater\Truncater::instance()->check_status() ) {
				if ( jeg_metabox( 'jnews_paywall_metabox.enable_preview_video', false, $this->post_id ) ) {
					$video_url = jeg_metabox( 'jnews_paywall_metabox.video_preview_url', '', $this->post_id );
				}
			}
		}
		$video_format = strtolower( pathinfo( $video_url, PATHINFO_EXTENSION ) );
		$featured_img = jnews_get_image_src( get_post_thumbnail_id( $this->post_id ), 'jnews-featured-750' );

		if ( $video_url=== '' ) {
			$output .= "<div class=\"jeg_video_container\" style=\"display: none;\"></div>";
		} else if ( jnews_check_video_type( $video_url ) === 'youtube' ) {
			$output .=
				"<div data-src=\"" . esc_url( $video_url ) . "\" data-type=\"youtube\" data-repeat=\"false\" data-autoplay=\"false\" class=\"youtube-class clearfix\">
                    <div class=\"jeg_video_container\"></div>
                </div>";
		} else if ( jnews_check_video_type( $video_url ) === 'vimeo' ) {
			$output .=
				"<div data-src=\"" . esc_url( $video_url ) . "\" data-repeat=\"false\" data-autoplay=\"false\" data-type=\"vimeo\" class=\"vimeo-class clearfix\">
                    <div class=\"jeg_video_container\"></div>
                </div>";
		} else if ( jnews_check_video_type( $video_url ) === 'dailymotion' ) {
			$output .=
				"<div data-src=\"" . esc_url( $video_url ) . "\" data-repeat=\"false\" data-autoplay=\"false\" data-type=\"dailymotion\" class=\"dailymotion-class clearfix\">
                    <div class=\"jeg_video_container\"></div>
                </div>";
		} else if ( $video_format == 'mp4' ) {
			$output .=
				"<div class=\"jeg_video_container\">
					<video width=\"640\" height=\"360\" style=\"width: 100%; height: 100%;\" poster=\"" . esc_attr( $featured_img ) . "\" controls preload=\"none\" >
	                    <source type=\"video/mp4\" src=\"" . esc_url( $video_url ) . "\">
	                </video>
                </div>";
		} else if ( wp_oembed_get( $video_url ) ) {
			$output .= "<div class=\"jeg_video_container\">" . wp_oembed_get( $video_url ) . "</div>";
		} else {
			$output .= "<div class=\"jeg_video_container\">" . $video_url . "</div>";
		}

		$output .= "<div class='floating_close'></div></div></div>";

		return apply_filters( 'jnews_featured_video', $output, $this->post_id );
	}

	/**
	 * Next Prev Post
	 */
	public function prev_next_post() {
		if ( jnews_get_metabox_value( 'jnews_single_post.override_template' ) ) {
			$flag = jnews_get_metabox_value( 'jnews_single_post.override.0.show_prev_next_post' );
		} else {
			$flag = get_theme_mod( 'jnews_single_show_prev_next_post', true );
		}

		$show_prev_next = apply_filters( 'jnews_single_show_prev_next_post', $flag, $this->post_id );

		if ( $show_prev_next ) {
			get_template_part( 'fragment/post/prev-next-post' );
		}
	}

	/**
	 * Popup Post
	 */
	public function popup_post() {
		if ( jnews_get_metabox_value( 'jnews_single_post.override_template' ) ) {
			$flag   = jnews_get_metabox_value( 'jnews_single_post.override.0.show_popup_post' );
			$number = jnews_get_metabox_value( 'jnews_single_post.override.0.number_popup_post' );
		} else {
			$flag   = get_theme_mod( 'jnews_single_show_popup_post', true );
			$number = get_theme_mod( 'jnews_single_number_popup_post', 1 );
		}

		$show_popup_post = apply_filters( 'jnews_single_show_popup_post', $flag, $this->post_id );

		if ( $show_popup_post ) {
			set_query_var( 'number_popup_post', $number );
			get_template_part( 'fragment/post/popup-post' );
		}
	}

	/**
	 * Check author box option
	 *
	 * @return bool|mixed|void
	 */
	public function check_author_box() {
		if ( jnews_get_metabox_value( 'jnews_single_post.override_template' ) ) {
			$flag = jnews_get_metabox_value( 'jnews_single_post.override.0.show_author_box' );
		} else {
			$flag = get_theme_mod( 'jnews_single_show_author_box', false );
		}

		return apply_filters( 'jnews_single_show_author_box', $flag, $this->post_id );
	}

	/**
	 * Author Box
	 */
	public function author_box() {
		$show_author_box = $this->check_author_box();

		if ( $show_author_box ) {
			get_template_part( 'fragment/post/author-box' );
		}
	}

	public function recursive_category( $categories, &$result ) {
		foreach ( $categories as $category ) {
			$result[] = $category;
			$children = get_categories( array( 'parent' => $category->term_id ) );

			if ( ! empty( $children ) ) {
				$this->recursive_category( $children, $result );
			}
		}
	}

	/**
	 * Check if we can render related post
	 *
	 * @return boolean
	 */
	public function can_render_related_post() {
		if ( apply_filters( 'jnews_force_disable_related_post', true ) ) {
			return false;
		}

		if ( jnews_get_metabox_value( 'jnews_single_post.override_template' ) ) {
			$flag = jnews_get_metabox_value( 'jnews_single_post.override.0.show_post_related' );
		} else {
			$flag = get_theme_mod( 'jnews_single_show_post_related', false );
		}

		return $flag;
	}

	/**
	 * Check if we can render inline related post
	 *
	 * @return boolean
	 */
	public function can_render_inline_related_post() {
		if ( apply_filters( 'jnews_force_disable_inline_related_post', false ) ) {
			return false;
		}

		if ( function_exists( 'is_amp_endpoint' ) ) {
			if ( is_amp_endpoint() ) {
				return false;
			}
		}

		if ( jnews_get_metabox_value( 'jnews_single_post.override_template' ) ) {
			$flag = jnews_get_metabox_value( 'jnews_single_post.override.0.show_inline_post_related' );
		} else {
			$flag = get_theme_mod( 'jnews_single_post_show_inline_related', false );
		}

		return $flag;
	}

	/**
	 * @param bool|true $echo
	 *
	 * @return array|string
	 */
	public function related_post( $echo = true ) {
		if ( $this->can_render_related_post() ) {
			$content_width = is_numeric( $this->main_content_width() ) ? $this->main_content_width() : 8;

			do_action( 'jnews_module_set_width', $content_width );
			$post_per_page = get_theme_mod( 'jnews_single_number_post_related', 6 );

			$match    = get_theme_mod( 'jnews_single_post_related_match', 'category' );
			$category = $tag = $result = array();
			if ( $match === 'category' ) {
				$this->recursive_category( get_the_category(), $result );

				if ( $result ) {
					foreach ( $result as $cat ) {
						$category[] = $cat->term_id;
					}
				}
			} else if ( $match === 'tag' ) {
				$tags = get_the_tags();
				if ( $tags ) {
					foreach ( $tags as $cat ) {
						$tag[] = $cat->term_id;
					}
				}
			}

			$attr = array(
				'first_title'             => get_theme_mod( 'jnews_single_post_related_override_title', false ) ? get_theme_mod( 'jnews_single_post_related_ftitle', 'Related' ) : jnews_return_translation( 'Related', 'jnews', 'related' ),
				'second_title'            => get_theme_mod( 'jnews_single_post_related_override_title', false ) ? get_theme_mod( 'jnews_single_post_related_stitle', 'Posts' ) : jnews_return_translation( ' Posts', 'jnews', 'posts' ),
				'header_type'             => get_theme_mod( 'jnews_single_post_related_header', 'heading_6' ),
				'date_format'             => get_theme_mod( 'jnews_single_post_related_date', 'default' ),
				'date_format_custom'      => get_theme_mod( 'jnews_single_post_related_date_custom', 'Y/m/d' ),
				'excerpt_length'          => get_theme_mod( 'jnews_single_post_related_excerpt', 20 ),
				'pagination_number_post'  => $post_per_page,
				'number_post'             => $post_per_page,
				'unique_content'          => get_theme_mod( 'jnews_single_post_related_unique_content', 'disable' ),
				'include_category'        => implode( ',', $category ),
				'include_tag'             => implode( ',', $tag ),
				'exclude_post'            => $this->post_id,
				'sort_by'                 => get_theme_mod( 'jnews_single_post_related_sort_by', 'latest' ),
				'pagination_mode'         => get_theme_mod( 'jnews_single_post_pagination_related', 'disable' ),
				'pagination_scroll_limit' => get_theme_mod( 'jnews_single_post_auto_load_related', 3 ),
				'paged'                   => 1,
				'main_custom_image_size'  => get_theme_mod( 'jnews_single_post_related_main_thumbnail', 'default' ),
			);

			if ( 'default' !== get_theme_mod( 'jnews_single_post_related_second_thumbnail', 'default' ) ) {
				$attr['second_custom_image_size'] = get_theme_mod( 'jnews_single_post_related_second_thumbnail', 'default' );
			}

			$name = 'JNews_Block_' . get_theme_mod( 'jnews_single_post_related_template', '22' );
			$name = jnews_get_view_class_from_shortcode( $name );

			/** @var $content_instance BlockViewAbstract */
			$content_instance = jnews_get_module_instance( $name );
			$result           = $content_instance->build_module( $attr );

			if ( $echo ) {
				echo jnews_sanitize_output( $result );
			} else {
				return $result;
			}
		}
	}

	public function render_inline_related_post( $content ) {
		if ( get_post_type() === 'post' && is_single() && ! is_admin() ) {
			if ( $this->can_render_inline_related_post() ) {
				$tag     = new ContentTag( $content );
				$pnumber = $tag->total( 'p' );

				$paragraph = get_theme_mod( 'jnews_single_post_inline_related_paragraph', 2 );
				$random    = get_theme_mod( 'jnews_single_post_inline_related_random', false );
				$class     = get_theme_mod( 'jnews_single_post_inline_related_float', 'left' );
				$fullwidth = get_theme_mod( 'jnews_single_post_inline_related_fullwidth', false );

				if ( $random && is_array( $pnumber ) ) {
					$maxparagraph = count( $pnumber ) - 2;
					$paragraph    = rand( $paragraph, $maxparagraph );
				}

				if ( ! $fullwidth ) {
					$class .= ' half';
				}

				$related_content =
					"<div class='jnews_inline_related_post_wrapper {$class}'>
                        " . $this->build_inline_related_post() . "
                    </div>";

				$content = $this->prefix_insert_after_paragraph( $related_content, $paragraph, $tag );
			}
		}

		return $content;
	}

	public function build_inline_related_post() {
		$match         = get_theme_mod( 'jnews_single_post_inline_related_match', 'category' );
		$related_width = get_theme_mod( 'jnews_single_post_inline_related_fullwidth', false ) ? 8 : 4;
		$post_per_page = get_theme_mod( 'jnews_single_post_inline_related_number', 3 );
		$tag           = $category = $result = array();

		do_action( 'jnews_module_set_width', $related_width );

		if ( $match === 'category' ) {
			$this->recursive_category( get_the_category(), $result );

			if ( $result ) {
				foreach ( $result as $cat ) {
					$category[] = $cat->term_id;
				}
			}
		} else if ( $match === 'tag' ) {
			$tags = get_the_tags();
			if ( $tags ) {
				foreach ( $tags as $cat ) {
					$tag[] = $cat->term_id;
				}
			}
		}

		$attr = array(
			'first_title'            => get_theme_mod( 'jnews_single_post_inline_related_ftitle', 'Related' ),
			'second_title'           => get_theme_mod( 'jnews_single_post_inline_related_stitle', 'Posts' ),
			'header_type'            => get_theme_mod( 'jnews_single_post_inline_related_header', 'heading_6' ),
			'date_format'            => get_theme_mod( 'jnews_single_post_inline_related_date', 'default' ),
			'date_format_custom'     => get_theme_mod( 'jnews_single_post_inline_related_date_custom', 'Y/m/d' ),
			'pagination_number_post' => $post_per_page,
			'number_post'            => $post_per_page,
			'unique_content'         => get_theme_mod( 'jnews_single_post_inline_related_unique_content', 'disable' ),
			'include_category'       => implode( ',', $category ),
			'include_tag'            => implode( ',', $tag ),
			'exclude_post'           => $this->post_id,
			'sort_by'                 => get_theme_mod( 'jnews_single_post_inline_related_sort_by', 'latest' ),
			'pagination_mode'        => get_theme_mod( 'jnews_single_post_inline_related_pagination', 'nextprev' ),
			'paged'                  => 1,
		);

		$name = 'JNews_Block_' . get_theme_mod( 'jnews_single_post_inline_related_template', '29' );
		$name = jnews_get_view_class_from_shortcode( $name );

		/** @var $content_instance BlockViewAbstract */
		$content_instance = jnews_get_module_instance( $name );
		$result           = $content_instance->build_module( $attr );

		$output =
			"<div class='jnews_inline_related_post'>
                {$result}
            </div>";

		return $output;
	}

	/**
	 * Filter jnews_ads_global_enable
	 *
	 * @param boolean $flag Flag of ads.
	 * @param int|false $post_id The ID of the current item in the WordPress Loop. False if $post is not set.
	 * 
	 * @return boolean
	 */
	public function ads_post_enable( $flag, $post_id ) {
		if ( get_post_type() === 'post' && is_single() && $flag ) {
			return ! jnews_get_metabox_value( 'jnews_single_post.disable_ad', false, $post_id );
		}
		return $flag;
	}

	/**
	 * @param $insertion
	 * @param $paragraph_id
	 * @param $tag ContentTag
	 *
	 * @return string
	 */
	protected function prefix_insert_after_paragraph( $insertion, $paragraph_id, $tag ) {
		$end = get_theme_mod( 'jnews_single_post_inline_related_overflow', 'top' ) === 'top' ? false : true;
		$line = $tag->find( 'p', $paragraph_id, $end );

		return jeg_string_insert( $tag->get_content(), $insertion, $line );
	}
}
