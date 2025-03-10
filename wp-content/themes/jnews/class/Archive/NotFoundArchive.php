<?php
/**
 * @author : Jegtheme
 */

namespace JNews\Archive;

use JNews\Module\ModuleManager;

/**
 * Class NotFoundArchive
 * @package JNews\Archive
 */
Class NotFoundArchive extends ArchiveAbstract {
	public function render_content() {
		$content_width = [ $this->get_content_width() ];
		ModuleManager::getInstance()->set_width( $content_width );

		$post_per_page = get_option( 'posts_per_page' );

		$attr = array(
			'first_title'            => jnews_return_translation( 'Latest Articles', 'jnews', 'latest_articles' ),
			'date_format'            => $this->get_content_date(),
			'date_format_custom'     => $this->get_content_date_custom(),
			'excerpt_length'         => $this->get_content_excerpt(),
			'pagination_number_post' => $post_per_page,
			'number_post'            => $post_per_page,
			'post_offset'            => 0,
			'sort_by'                => 'latest',
			'pagination_mode'        => 'disable',
			'boxed'                  => $this->get_boxed(),
			'boxed_shadow'           => $this->get_boxed_shadow(),
			'box_shadow'             => $this->get_box_shadow(),
			'main_custom_image_size' => $this->get_content_main_image(),
		);

		if ( 'default' !== $this->get_content_second_image() && '14' === $this->get_content_type() ) {
			$attr['second_custom_image_size'] = $this->get_content_second_image();
		}

		$attr                   = apply_filters( 'jnews_get_content_attr', $attr, 'jnews_404_', null );
		$name                   = apply_filters( 'jnews_get_content_layout', 'JNews_Block_' . $this->get_content_type(), 'jnews_404_' );
		$name                   = jnews_get_view_class_from_shortcode( $name );
		$this->content_instance = jnews_get_module_instance( $name );

		return null !== $this->content_instance ? $this->content_instance->build_module( $attr ) : '';
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

	// content
	public function get_content_type() {
		return apply_filters( 'jnews_404_content', get_theme_mod( 'jnews_404_content', '3' ) );
	}

	public function get_content_excerpt() {
		return apply_filters( 'jnews_404_content_excerpt', get_theme_mod( 'jnews_404_content_excerpt', 20 ) );
	}

	public function get_content_date() {
		return apply_filters( 'jnews_404_content_date', get_theme_mod( 'jnews_404_content_date', 'default' ) );
	}

	public function get_content_date_custom() {
		return apply_filters( 'jnews_404_content_date_custom', get_theme_mod( 'jnews_404_content_date_custom', 'Y/m/d' ) );
	}

	public function get_page_layout() {
		return apply_filters( 'jnews_404_page_layout', get_theme_mod( 'jnews_404_page_layout', 'right-sidebar' ) );
	}

	public function get_content_sidebar() {
		return apply_filters( 'jnews_404_sidebar', get_theme_mod( 'jnews_404_sidebar', 'default-sidebar' ) );
	}

	public function get_second_sidebar() {
		return apply_filters( 'jnews_404_second_sidebar', get_theme_mod( 'jnews_404_second_sidebar', 'default-sidebar' ) );
	}

	public function sticky_sidebar() {
		return apply_filters( 'jnews_404_sticky_sidebar', get_theme_mod( 'jnews_404_sticky_sidebar', true ) );
	}

	public function get_header_title() {
		$content = get_search_query();

		return $content;
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

		return apply_filters( 'jnews_404_boxed', get_theme_mod( 'jnews_404_boxed', false ) );
	}

	public function get_boxed_shadow() {
		if ( ! $this->get_boxed() ) {
			return false;
		}

		return apply_filters( 'jnews_404_boxed_shadow', get_theme_mod( 'jnews_404_boxed_shadow', false ) );
	}

	public function get_box_shadow() {
		if ( ! in_array( $this->get_content_type(), [ '37', '35', '33', '36', '32', '38' ] ) ) {
			return false;
		}

		return apply_filters( 'jnews_404_box_shadow', get_theme_mod( 'jnews_404_box_shadow', false ) );
	}

	public function get_header_description() {
	}

	public function get_content_pagination() {
	}

	public function get_content_pagination_limit() {
	}

	public function get_content_pagination_align() {
	}

	public function get_content_pagination_navtext() {
	}

	public function get_content_pagination_pageinfo() {
	}

	public function get_content_main_image() {
		return apply_filters( 'jnews_search_content_main_image', get_theme_mod( 'jnews_search_content_main_image', 'default' ) );
	}

	public function get_content_second_image() {
		return apply_filters( 'jnews_search_content_second_image', get_theme_mod( 'jnews_search_content_second_image', 'default' ) );
	}
}
