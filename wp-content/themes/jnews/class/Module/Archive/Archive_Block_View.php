<?php
/**
 * @author : Jegtheme
 */

namespace JNews\Module\Archive;

class Archive_Block_View extends ArchiveViewAbstract {

	public function render_module_back( $attr, $column_class ) {
		return $this->build_block_module( $attr );
	}

	public function render_module_front( $attr, $column_class ) {
		return $this->build_block_module( $attr );
	}

	public function build_block_module( $attr ) {

		if ( $attr['first_page'] && jnews_get_post_current_page() > 1 ) {
			return false;
		}
		$name     = apply_filters( 'jnews_get_content_layout', 'JNews_Block_' . $attr['block_type'], null );
		$name     = jnews_get_view_class_from_shortcode( $name );
		$instance = jnews_get_module_instance( $name );
		$result   = $this->get_result( $attr, $attr['number_post'] );

		if ( ! empty( $result['result'] ) ) {
			$attr['pagination_mode'] = 'disable';
			$attr['results']         = $result;
			if ( '14' !== $attr['block_type'] ) {
				unset( $attr['second_custom_image_size'] );
			}
			add_filter( 'jnews_block_script_attribute', array( $this, 'remove_result_attribute' ) );  //see ZKyevnHL

			return $instance->build_module( $attr );
		}
	}

	public function remove_result_attribute( $attr ) {
		//see ZKyevnHL
		$attr['results'] = array();
		return $attr;
	}
}
