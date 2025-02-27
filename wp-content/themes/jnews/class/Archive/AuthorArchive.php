<?php
/**
 * @author : Jegtheme
 */

namespace JNews\Archive;

use JNews\Module\ModuleManager;

/**
 * Class AuthorArchive
 * @package JNews\Archive
 */
Class AuthorArchive extends ArchiveAbstract {
	/**
	 * @var \WP_Term
	 */
	protected $author;

	/**
	 * @var String
	 */
	protected $section;

	public function __construct() {
		$this->author  = get_queried_object()->ID;
		$this->section = isset( $_REQUEST['section'] ) ? sanitize_text_field( $_REQUEST['section'] ) : '';
	}

	public function render_content() {
		$content_width = [ $this->get_content_width() ];
		ModuleManager::getInstance()->set_width( $content_width );

		$post_per_page = get_option( 'posts_per_page' );

		$attr = array(
			'content_type'            => $this->section,
			'date_format'             => $this->get_content_date(),
			'date_format_custom'      => $this->get_content_date_custom(),
			'excerpt_length'          => $this->get_content_excerpt(),
			'pagination_number_post'  => $post_per_page,
			'number_post'             => $post_per_page,
			'post_offset'             => $this->offset,
			'include_author'          => $this->author,
			'sort_by'                 => 'latest',
			'pagination_mode'         => $this->get_content_pagination(),
			'pagination_scroll_limit' => $this->get_content_pagination_limit(),
			'paged'                   => jnews_get_post_current_page(),
			'pagination_align'        => $this->get_content_pagination_align(),
			'pagination_navtext'      => $this->get_content_pagination_navtext(),
			'pagination_pageinfo'     => $this->get_content_pagination_pageinfo(),
			'boxed'                   => $this->get_boxed(),
			'boxed_shadow'            => $this->get_boxed_shadow(),
			'box_shadow'              => $this->get_box_shadow(),
			'push_archive'            => true,
			'main_custom_image_size'  => $this->get_content_main_image(),
		);
		
		$attr                   = apply_filters( 'jnews_get_content_attr', $attr, 'jnews_author_', '_' . $this->author );
		if ( 'default' !== $this->get_content_second_image() && '14' === $this->get_content_type() ) {
			$attr['second_custom_image_size'] = $this->get_content_second_image();
		}
		$cpt_archive            = get_theme_mod( 'jnews_cpt_author_archive', array() ); 
		$attr['post_type']      = empty( $cpt_archive ) ? 'post' : array_merge( array( 'post' ), $cpt_archive ); //see ZKyevnHL
		$name                   = apply_filters( 'jnews_get_content_layout', 'JNews_Block_' . $this->get_content_type(), 'jnews_author_' );
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
		return apply_filters( 'jnews_author_content', get_theme_mod( 'jnews_author_content', '3' ), $this->author );
	}

	public function get_content_excerpt() {
		return apply_filters( 'jnews_author_content_excerpt', get_theme_mod( 'jnews_author_content_excerpt', 20 ), $this->author );
	}

	public function get_content_date() {
		return apply_filters( 'jnews_author_content_date', get_theme_mod( 'jnews_author_content_date', 'default' ), $this->author );
	}

	public function get_content_date_custom() {
		return apply_filters( 'jnews_author_content_date_custom', get_theme_mod( 'jnews_author_content_date_custom', 'Y/m/d' ), $this->author );
	}

	public function get_content_pagination() {
		return apply_filters( 'jnews_author_content_pagination', get_theme_mod( 'jnews_author_content_pagination', 'nav_1' ), $this->author );
	}

	public function get_content_pagination_limit() {
		return apply_filters( 'jnews_author_content_pagination_limit', get_theme_mod( 'jnews_author_content_pagination_limit' ), $this->author );
	}

	public function get_content_pagination_align() {
		return apply_filters( 'jnews_author_content_pagination_align', get_theme_mod( 'jnews_author_content_pagination_align', 'center' ), $this->author );
	}

	public function get_content_pagination_navtext() {
		return apply_filters( 'jnews_author_content_pagination_show_navtext', get_theme_mod( 'jnews_author_content_pagination_show_navtext', false ), $this->author );
	}

	public function get_content_pagination_pageinfo() {
		return apply_filters( 'jnews_author_content_pagination_show_pageinfo', get_theme_mod( 'jnews_author_content_pagination_show_pageinfo', false ), $this->author );
	}

	public function get_page_layout() {
		return apply_filters( 'jnews_author_page_layout', get_theme_mod( 'jnews_author_page_layout', 'right-sidebar' ), $this->author );
	}

	public function get_content_sidebar() {
		return apply_filters( 'jnews_author_sidebar', get_theme_mod( 'jnews_author_sidebar', 'default-sidebar' ), $this->author );
	}

	public function get_second_sidebar() {
		return apply_filters( 'jnews_author_second_sidebar', get_theme_mod( 'jnews_author_second_sidebar', 'default-sidebar' ), $this->author );
	}

	public function sticky_sidebar() {
		return apply_filters( 'jnews_author_sticky_sidebar', get_theme_mod( 'jnews_author_sticky_sidebar', true ), $this->author );
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

		return apply_filters( 'jnews_author_boxed', get_theme_mod( 'jnews_author_boxed', false ), $this->author );
	}

	public function get_boxed_shadow() {
		if ( ! $this->get_boxed() ) {
			return false;
		}

		return apply_filters( 'jnews_author_boxed_shadow', get_theme_mod( 'jnews_author_boxed_shadow', false ), $this->author );
	}

	public function get_box_shadow() {
		if ( ! in_array( $this->get_content_type(), array( '37', '35', '33', '36', '32', '38' ) ) ) {
			return false;
		}

		return apply_filters( 'jnews_author_box_shadow', get_theme_mod( 'jnews_author_box_shadow', false ), $this->author );
	}

	public function get_header_title() {
	}

	public function get_header_description() {
	}

	public function get_content_main_image() {
		return apply_filters( 'jnews_author_content_main_image', get_theme_mod( 'jnews_author_content_main_image', 'default' ), $this->author );
	}

	public function get_content_second_image() {
		return apply_filters( 'jnews_author_content_second_image', get_theme_mod( 'jnews_author_content_second_image', 'default' ), $this->author );
	}
}
