<?php
/**
 * @author : Jegtheme
 */

namespace JNews\Archive;

use JNews\Module\ModuleManager;

/**
 * Class SingleArchive
 * @package JNews\Archive
 */
Class SingleArchive extends ArchiveAbstract {
	private $result;

	private $archive_id;

	public function __construct() {
		// Single Archive
		$queried_object = get_queried_object();

		if ( ! empty( $queried_object ) ) {
			$this->archive_id = $queried_object->term_id;
		}

		$this->result = $archive = [];
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				do_action( 'jnews_json_archive_push', get_the_ID() );
				$this->result[] = get_post();
			}
		}

		if ( $this->can_render_top_content() ) {
			add_filter( 'jnews_vc_force_load_style', '__return_true' );
		}

		add_filter(
			'jnews_archive_content_pagination',
			function ( $nav ) {
				if ( is_tax() ) {
					return 'nav_1';
				}
				return $nav;
			}
		);
	}

	public function can_render_top_content() {
		return get_theme_mod( 'jnews_archive_top_content' ) && jnews_get_post_current_page() == 1;
	}

	public function render_navigation() {
		global $wp_query;
		$page                = isset( $wp_query->query['paged'] ) ? intval( $wp_query->query['paged'] ) : 1;
		$max_pages           = intval( $wp_query->max_num_pages );
		$pagination_mode     = $this->get_content_pagination();
		$pagination_navtext  = $this->get_content_pagination_navtext();
		$pagination_align    = $this->get_content_pagination_align();
		$pagination_pageinfo = $this->get_content_pagination_pageinfo();
		$additional_class    = ( $max_pages > $page ) || ( $page > 1 ) ? "" : "inactive";
		$output              = '';

		if ( $pagination_mode === 'nextprev' ) {
			$next = ( $max_pages > $page ) ? "" : "disabled";
			$prev = ( $page > 1 ) ? "" : "disabled";

			$prev_text = "<i class=\"fa fa-angle-left\"></i>";
			$next_text = "<i class=\"fa fa-angle-right\"></i>";

			if ( $pagination_navtext ) {
				$additional_class .= " showtext";
				$prev_text        = "<i class=\"fa fa-angle-left\"></i> " . jnews_return_translation( "Prev", 'jnews', 'prev' );
				$next_text        = jnews_return_translation( "Next", 'jnews', 'next' ) . "  <i class=\"fa fa-angle-right\"></i>";
			}

			$output =
				"<div class=\"jeg_block_nav jeg_block_navigation {$additional_class}\">
                    <a href=\"#\" class=\"prev {$prev}\" title=\"" . jnews_return_translation( "Previous", 'jnews', 'previous' ) . "\">{$prev_text}</a>
                    <a href=\"#\" class=\"next {$next}\" title=\"" . jnews_return_translation( "Next", 'jnews', 'next' ) . "\">{$next_text}</a>
                </div>";
		}



		if ( $pagination_mode === 'loadmore' || $pagination_mode === 'scrollload' ) {
			$next   = ( $max_pages > $page ) ? "" : "disabled";
			$output =
				"<div class=\"jeg_block_navigation\">
					<div class=\"jeg_block_loadmore {$additional_class}\">
						<a href=\"#\" class='{$next}' data-load='" . jnews_return_translation( 'Load More', 'jnews', 'load_more' ) . "' data-loading='" . jnews_return_translation( 'Loading...', 'jnews', 'loading' ) . "'> " . jnews_return_translation( 'Load More', 'jnews', 'load_more' ) . "</a>
					</div>
				</div>";
		}

		if ( $pagination_mode === 'nav_1' || $pagination_mode === 'nav_2' || $pagination_mode === 'nav_3' ) {
			$output = jnews_paging_navigation( [
				'pagination_mode'     => $pagination_mode,
				'pagination_align'    => $pagination_align,
				'pagination_navtext'  => $pagination_navtext,
				'pagination_pageinfo' => $pagination_pageinfo,
				'prev_text'           => esc_html__( 'Prev', 'jnews' ),
				'next_text'           => esc_html__( 'Next', 'jnews' ),
			] );
		}

		return $output;
	}

	public function get_content_pagination() {
		return apply_filters( 'jnews_archive_content_pagination', get_theme_mod( 'jnews_archive_content_pagination', 'nav_1' ), $this->archive_id );
	}

	public function get_content_pagination_navtext() {
		return apply_filters( 'jnews_archive_content_pagination_show_navtext', get_theme_mod( 'jnews_archive_content_pagination_show_navtext', false ), $this->archive_id );
	}

	// content

	public function get_content_pagination_align() {
		return apply_filters( 'jnews_archive_content_pagination_align', get_theme_mod( 'jnews_archive_content_pagination_align', 'center' ), $this->archive_id );
	}

	public function get_content_pagination_pageinfo() {
		return apply_filters( 'jnews_archive_content_pagination_show_pageinfo', get_theme_mod( 'jnews_archive_content_pagination_show_pageinfo', false ), $this->archive_id );
	}

	public function render_content() {
		ModuleManager::getInstance()->set_width( [ $this->get_content_width() ] );
		$this->column_class = ModuleManager::getInstance()->get_column_class();

		$attr = array(
			'date_format'            => $this->get_content_date(),
			'date_format_custom'     => $this->get_content_date_custom(),
			'excerpt_length'         => $this->get_content_excerpt(),
			'pagination_mode'        => $this->get_content_pagination(),
			'pagination_align'       => $this->get_content_pagination_align(),
			'pagination_navtext'     => $this->get_content_pagination_navtext(),
			'pagination_pageinfo'    => $this->get_content_pagination_pageinfo(),
			'boxed'                  => $this->get_boxed(),
			'boxed_shadow'           => $this->get_boxed_shadow(),
			'box_shadow'             => $this->get_box_shadow(),
			'main_custom_image_size' => $this->get_content_main_image(),

		);

		if ( 'default' !== $this->get_content_second_image() && '14' === $this->get_content_type() ) {
			$attr['second_custom_image_size'] = $this->get_content_second_image();
		}

		$attr                   = apply_filters( 'jnews_get_content_attr', $attr, 'jnews_archive_', '_' . $this->archive_id );
		$name                   = apply_filters( 'jnews_get_content_layout', 'JNews_Block_' . $this->get_content_type(), 'jnews_archive_' );
		$name                   = jnews_get_view_class_from_shortcode( $name );
		$this->content_instance = jnews_get_module_instance( $name );
		$this->content_instance->set_attribute( $attr );

		if ( $attr['boxed'] ) {
			$this->column_class .= ' jeg_pb_boxed';
		}
		if ( $attr['boxed_shadow'] ) {
			$this->column_class .= ' jeg_pb_boxed_shadow';
		}

		$content = $this->content_instance->render_module_out_call( $this->result, $this->column_class );
		$output  = "<div class=\"jeg_module_hook {$this->content_instance->get_unique_id()}\" data-unique=\"{$this->content_instance->get_unique_id()}\">
						{$content}
						{$this->render_navigation()}
						{$this->render_script()}
					</div>";

		return $output;
	}

	public function render_script() {
		$attr                            = [];
		$attr['paged']                   = 1;
		$attr['column_class']            = $this->column_class;
		$attr['class']                   = 'jnews_block_' . $this->get_content_type();
		$attr['date_format']             = $this->get_content_date();
		$attr['date_format_custom']      = $this->get_content_date_custom();
		$attr['excerpt_length']          = $this->get_content_excerpt();
		$attr['pagination_mode']         = $this->get_content_pagination();
		$attr['pagination_align']        = $this->get_content_pagination_align();
		$attr['pagination_navtext']      = $this->get_content_pagination_navtext();
		$attr['pagination_pageinfo']     = $this->get_content_pagination_pageinfo();
		$attr['pagination_scroll_limit'] = $this->get_content_pagination_limit();
		$attr['boxed']                   = $this->get_boxed();
		$attr['boxed_shadow']            = $this->get_boxed_shadow();
		$attr['box_shadow']              = $this->get_box_shadow();
		$attr['main_custom_image_size']  = $this->get_content_main_image();

		if ( 'default' !== $this->get_content_second_image() && '14' === $this->get_content_type() ) {
			$attr['second_custom_image_size'] = $this->get_content_second_image();
		}

		if ( is_tag() ) {
			$attr['include_tag']         = get_queried_object()->term_id;
		}
		if ( is_date() ) {
			$attr['date_query'] = [
				[
					'year'  => get_query_var( 'year' ) ? get_query_var( 'year' ) : null,
					'month' => get_query_var( 'monthnum' ) ? get_query_var( 'monthnum' ) : null,
					'day'   => get_query_var( 'day' ) ? get_query_var( 'day' ) : null,
				],
			];
		}

		$json_attr = wp_json_encode( $attr );

		$output = "<script>var {$this->content_instance->get_unique_id()} = {$json_attr};</script>";

		return $output;
	}

	public function get_content_width() {
		$width = parent::get_content_width();

		if ( in_array( $this->get_page_layout(), [ 'right-sidebar', 'left-sidebar' ] ) ) {
			$sidebar = $this->get_content_sidebar();
			if ( ! is_active_sidebar( $sidebar ) ) {
				return 12;
			}
		}

		return $width;
	}

	public function get_page_layout() {
		return apply_filters( 'jnews_archive_page_layout', get_theme_mod( 'jnews_archive_page_layout', 'right-sidebar' ), $this->archive_id );
	}

	public function get_content_sidebar() {
		return apply_filters( 'jnews_archive_sidebar', get_theme_mod( 'jnews_archive_sidebar', 'default-sidebar' ), $this->archive_id );
	}

	public function get_content_date() {
		return apply_filters( 'jnews_archive_content_date', get_theme_mod( 'jnews_archive_content_date', 'default' ), $this->archive_id );
	}

	public function get_content_date_custom() {
		return apply_filters( 'jnews_archive_content_date_custom', get_theme_mod( 'jnews_archive_content_date_custom', 'Y/m/d' ), $this->archive_id );
	}

	public function get_content_excerpt() {
		return apply_filters( 'jnews_archive_content_excerpt', get_theme_mod( 'jnews_archive_content_excerpt', 20 ), $this->archive_id );
	}

	public function get_boxed() {
		if ( ! in_array( $this->get_content_type(), [
			'3',
			'4',
			'5',
			'6',
			'7',
			'9',
			'10',
			'14',
			'18',
			'22',
			'23',
			'25',
			'26',
			'27',
			'39',
		] ) ) {
			return false;
		}

		return apply_filters( 'jnews_archive_boxed', get_theme_mod( 'jnews_archive_boxed', false ), $this->archive_id );
	}

	public function get_content_type() {
		return apply_filters( 'jnews_archive_content', get_theme_mod( 'jnews_archive_content', '3' ), $this->archive_id );
	}

	public function get_boxed_shadow() {
		if ( ! $this->get_boxed() ) {
			return false;
		}

		return apply_filters( 'jnews_archive_boxed_shadow', get_theme_mod( 'jnews_archive_boxed_shadow', false ), $this->archive_id );
	}

	public function get_box_shadow() {
		if ( ! in_array( $this->get_content_type(), [ '37', '35', '33', '36', '32', '38' ] ) ) {
			return false;
		}

		return apply_filters( 'jnews_archive_box_shadow', get_theme_mod( 'jnews_archive_box_shadow', false ), $this->archive_id );
	}

	public function get_content_pagination_limit() {
		return apply_filters( 'jnews_archive_content_pagination_limit', get_theme_mod( 'jnews_archive_content_pagination_limit' ), $this->archive_id );
	}

	public function get_second_sidebar() {
		return apply_filters( 'jnews_archive_second_sidebar', get_theme_mod( 'jnews_archive_second_sidebar', 'default-sidebar' ), $this->archive_id );
	}

	public function sticky_sidebar() {
		return apply_filters( 'jnews_archive_sticky_sidebar', get_theme_mod( 'jnews_archive_sticky_sidebar', true ), $this->archive_id );
	}

	public function get_content_main_image() {
		return apply_filters( 'jnews_archive_content_main_image', get_theme_mod( 'jnews_archive_content_main_image', 'default' ), $this->archive_id );
	}

	public function get_content_second_image() {
		return apply_filters( 'jnews_archive_content_second_image', get_theme_mod( 'jnews_archive_content_second_image', 'default' ), $this->archive_id );
	}
}
