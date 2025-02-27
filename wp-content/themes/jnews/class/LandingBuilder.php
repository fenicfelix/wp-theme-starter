<?php
/**
 * @author : Jegtheme
 */
namespace JNews;

use JNews\Module\Block\BlockViewAbstract;
use JNews\Module\ModuleManager;

/**
 * Class Theme Landing Builder
 */
class LandingBuilder {

	/**
	 * @var int
	 */
	private $post_id;

	/**
	 * @var BlockViewAbstract
	 */
	private $content_instance;


	public function __construct( $post_id = null ) {
		$this->post_id = ( $post_id === null ) ? get_the_ID() : $post_id;
	}

	public function render_loop() {
		$content_width = array( $this->column_width() );
		ModuleManager::getInstance()->set_width( $content_width );

		$attr = array(
			'first_title'            => $this->get_first_title_header(),
			'second_title'           => $this->get_second_title_header(),
			'header_type'            => $this->get_header_type(),
			'header_background'      => $this->get_header_background(),
			'header_text_color'      => $this->get_header_text_color(),

			'date_format'            => $this->get_content_date(),
			'date_format_custom'     => $this->get_content_date_custom(),
			'excerpt_length'         => $this->get_content_excerpt(),
			'pagination_number_post' => $this->get_posts_per_page(),
			'number_post'            => $this->get_posts_per_page(),
			'pagination_mode'        => $this->get_content_pagination(),
			'paged'                  => jnews_get_post_current_page(),
			'pagination_align'       => $this->get_content_pagination_align(),
			'pagination_navtext'     => $this->get_content_pagination_navtext(),
			'pagination_pageinfo'    => $this->get_content_pagination_pageinfo(),

			'post_offset'            => $this->get_post_offset(),
			'include_post'           => $this->get_include_post(),
			'exclude_post'           => $this->get_exclude_post(),
			'include_category'       => $this->get_include_category(),
			'exclude_category'       => $this->get_exclude_category(),
			'include_author'         => $this->get_include_author(),
			'include_tag'            => $this->get_include_tag(),
			'exclude_tag'            => $this->get_exclude_tag(),
			'sort_by'                => $this->get_sort_by(),
			'boxed'                  => $this->get_boxed(),
			'boxed_shadow'           => $this->get_boxed_shadow(),
			'box_shadow'             => $this->get_box_shadow(),
			'main_custom_image_size' => $this->get_main_custom_image(),
		);

		if ( 'default' !== $this->get_second_custom_image() ) {
			$attr['second_custom_image_size'] = $this->get_second_custom_image();
		}
		$name                   = jnews_get_view_class_from_shortcode( 'JNews_Block_' . $this->get_content_type() );
		$this->content_instance = jnews_get_module_instance( $name );
		return null !== $this->content_instance ? $this->content_instance->build_module( $attr ) : '';
	}

	public function can_render_builder() {
		return ( jnews_get_post_current_page() == 1 );
	}

	public function can_render_loop() {
		return jnews_get_metabox_value( 'jnews_page_loop.enable_page_loop', null, $this->post_id );
	}

	public function main_class() {
		$layout = jnews_get_metabox_value( 'jnews_page_loop.layout', 'right-sidebar', $this->post_id );

		switch ( $layout ) {
			case 'left-sidebar':
				echo 'jeg_sidebar_left';
				break;

			case 'left-sidebar-narrow':
				echo 'jeg_sidebar_left jeg_wide_content';
				break;

			case 'right-sidebar-narrow':
				echo 'jeg_wide_content';
				break;

			case 'double-sidebar':
				echo 'jeg_double_sidebar';
				break;

			case 'double-right-sidebar':
				echo 'jeg_double_right_sidebar';
				break;

			case 'no-sidebar':
				echo 'jeg_sidebar_none';
				break;

			default:
				break;
		}
	}


	// header

	public function get_first_title_header() {
		return jnews_get_metabox_value( 'jnews_page_loop.first_title', null, $this->post_id );
	}

	public function get_second_title_header() {
		return jnews_get_metabox_value( 'jnews_page_loop.second_title', null, $this->post_id );
	}

	public function get_header_type() {
		return jnews_get_metabox_value( 'jnews_page_loop.header_type', null, $this->post_id );
	}

	public function get_header_background() {
		return jnews_get_metabox_value( 'jnews_page_loop.header_background', null, $this->post_id );
	}

	public function get_header_text_color() {
		return jnews_get_metabox_value( 'jnews_page_loop.header_text_color', null, $this->post_id );
	}

	// content

	public function get_post_offset() {
		return jnews_get_metabox_value( 'jnews_page_loop.post_offset', null, $this->post_id );
	}

	public function get_posts_per_page() {
		$posts_per_page = jnews_get_metabox_value( 'jnews_page_loop.posts_per_page', 5, $this->post_id );

		return $posts_per_page ? $posts_per_page : get_option( 'posts_per_page' );
	}

	public function get_include_post() {
		if ( jnews_get_metabox_value( 'jnews_page_loop.post_sticky', false, $this->post_id ) ) {
			$sticky_post = get_option( 'sticky_posts' );
			if ( ! empty( $sticky_post ) ) {
				$sticky_post = implode( ',', $sticky_post );
				return empty( jnews_get_metabox_value( 'jnews_page_loop.include_post', null, $this->post_id ) ) ? $sticky_post : $sticky_post . ',' . jnews_get_metabox_value( 'jnews_page_loop.include_post', null, $this->post_id );
			}
		}
		return jnews_get_metabox_value( 'jnews_page_loop.include_post', null, $this->post_id );
	}

	public function get_exclude_post() {
		return jnews_get_metabox_value( 'jnews_page_loop.exclude_post', null, $this->post_id );
	}

	public function get_include_category() {
		return jnews_get_metabox_value( 'jnews_page_loop.include_category', null, $this->post_id );
	}

	public function get_exclude_category() {
		return jnews_get_metabox_value( 'jnews_page_loop.exclude_category', null, $this->post_id );
	}

	public function get_include_author() {
		return jnews_get_metabox_value( 'jnews_page_loop.include_author', null, $this->post_id );
	}

	public function get_include_tag() {
		return jnews_get_metabox_value( 'jnews_page_loop.include_tag', null, $this->post_id );
	}

	public function get_exclude_tag() {
		return jnews_get_metabox_value( 'jnews_page_loop.exclude_tag', null, $this->post_id );
	}

	public function get_sort_by() {
		return jnews_get_metabox_value( 'jnews_page_loop.sort_by', 'latest', $this->post_id );
	}


	// layout

	public function get_sidebar() {
		return jnews_get_metabox_value( 'jnews_page_loop.sidebar', null, $this->post_id );
	}

	public function get_second_sidebar() {
		return jnews_get_metabox_value( 'jnews_page_loop.second_sidebar', null, $this->post_id );
	}

	public function get_sticky_sidebar() {
		if ( jnews_get_metabox_value( 'jnews_page_loop.sticky_sidebar', true, $this->post_id ) ) {
			return 'jeg_sticky_sidebar';
		}

		return false;
	}

	public function get_page_layout() {
		return jnews_get_metabox_value( 'jnews_page_loop.layout', 'right-sidebar' );
	}

	public function column_width() {
		$layout = $this->get_page_layout();

		switch ( $layout ) {
			case 'right-sidebar':
			case 'left-sidebar':
				return 8;
				break;

			case 'right-sidebar-narrow':
			case 'left-sidebar-narrow':
				return 9;
				break;

			case 'double-sidebar':
			case 'double-right-sidebar':
				return 6;
				break;
		}

		return 12;
	}

	public function render_sidebar() {
		$layout = $this->get_page_layout();

		if ( $layout !== 'no-sidebar' ) {
			$get_sticky_sidebar = $this->get_sticky_sidebar();
			$sidebar            = array(
				'content-sidebar'  => $this->get_sidebar(),
				'is_sticky'        => $get_sticky_sidebar,
				'sticky-sidebar'   => $get_sticky_sidebar,
				'width-sidebar'    => $this->get_sidebar_width(),
				'position-sidebar' => 'left',
			);

			set_query_var( 'sidebar', $sidebar );
			get_template_part( 'fragment/archive-sidebar' );

			if ( $layout === 'double-right-sidebar' || $layout === 'double-sidebar' ) {
				$sidebar['content-sidebar']  = $this->get_second_sidebar();
				$sidebar['position-sidebar'] = 'right';
				set_query_var( 'sidebar', $sidebar );
				get_template_part( 'fragment/archive-sidebar' );
			}
		}
	}

	public function get_sidebar_width() {
		$layout = $this->get_page_layout();

		if ( $layout === 'left-sidebar' || $layout === 'right-sidebar' ) {
			return 4;
		}

		return 3;
	}

	public function render_second_sidebar() {
		if ( $this->get_page_layout() === 'double-sidebar' ) {
			$get_sticky_sidebar = $this->get_sticky_sidebar();
			$sidebar            = array(
				'content-sidebar' => $this->get_sidebar(),
				'is_sticky'       => $get_sticky_sidebar,
				'sticky-sidebar'  => $get_sticky_sidebar,
				'width-sidebar'   => $this->get_sidebar_width(),
			);

			set_query_var( 'sidebar', $sidebar );
			get_template_part( 'fragment/archive-sidebar' );
		}
	}

	public function get_content_type() {
		return jnews_get_metabox_value( 'jnews_page_loop.module', '3', $this->post_id );
	}
	public function get_main_custom_image() {
		return jnews_get_metabox_value( 'jnews_page_loop.main_custom_image_size', 'default', $this->post_id );
	}

	public function get_second_custom_image() {
		return ( '14' !== $this->get_content_type() ) ? 'default' : jnews_get_metabox_value( 'jnews_page_loop.second_custom_image_size', 'default', $this->post_id );
	}

	public function get_content_date() {
		return jnews_get_metabox_value( 'jnews_page_loop.content_date', 'default', $this->post_id );
	}

	public function get_content_date_custom() {
		return jnews_get_metabox_value( 'jnews_page_loop.date_custom', 'Y/m/d', $this->post_id );
	}

	public function get_content_excerpt() {
		return jnews_get_metabox_value( 'jnews_page_loop.excerpt_length', '20', $this->post_id );
	}

	public function get_content_pagination() {
		return jnews_get_metabox_value( 'jnews_page_loop.content_pagination', 'nav_1', $this->post_id );
	}

	public function get_content_pagination_align() {
		return jnews_get_metabox_value( 'jnews_page_loop.pagination_align', 'center', $this->post_id );
	}

	public function get_content_pagination_navtext() {
		return jnews_get_metabox_value( 'jnews_page_loop.show_navtext', null, $this->post_id );
	}

	public function get_content_pagination_pageinfo() {
		return jnews_get_metabox_value( 'jnews_page_loop.show_pageinfo', null, $this->post_id );
	}

	public function get_boxed() {
		if ( in_array( $this->get_content_type(), array( '3', '4', '5', '6', '7', '9', '10', '14', '18', '22', '23', '25', '26', '27', '39' ) ) ) {
			return (bool) jnews_get_metabox_value( 'jnews_page_loop.boxed', null, $this->post_id );
		}

		return false;
	}

	public function get_boxed_shadow() {
		if ( $this->get_boxed() ) {
			return (bool) jnews_get_metabox_value( 'jnews_page_loop.boxed_shadow', null, $this->post_id );
		}

		return false;
	}

	public function get_box_shadow() {
		if ( in_array( $this->get_content_type(), array( '37', '35', '33', '36', '32', '38' ) ) ) {
			return (bool) jnews_get_metabox_value( 'jnews_page_loop.box_shadow', null, $this->post_id );
		}

		return false;
	}
}
