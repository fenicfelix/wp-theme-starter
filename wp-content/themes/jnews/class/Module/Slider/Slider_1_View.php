<?php
/**
 * @author : Jegtheme
 */
namespace JNews\Module\Slider;

class Slider_1_View extends SliderViewAbstract {

	public function content( $results ) {
		$content = '';
		add_filter( 'jnews_use_custom_image', array( $this, 'main_custom_image_size' ) );
		foreach ( $results as $key => $post ) {
			$primary_category  = $this->get_primary_category( $post->ID );
			$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
			$image_mechanism   = isset( $this->attribute['force_normal_image_load'] ) && ( 'true' === $this->attribute['force_normal_image_load'] || 'yes' === $this->attribute['force_normal_image_load'] ) ? 'jnews_single_image_owl' : 'jnews_single_image_lazy_owl';
			if ( 'jnews_single_image_owl' === $image_mechanism && 0 >= $key ) {
				if ( $this->manager->get_current_width() > 8 ) {
					$image = \JNews\Image\ImageNormalLoad::getInstance()->owl_single_image( $post_thumbnail_id, 'jnews-1140x570' );
				} else {
					$image = \JNews\Image\ImageNormalLoad::getInstance()->owl_single_image( $post_thumbnail_id, 'jnews-750x375' );
				}
			} else {
				if ( $this->manager->get_current_width() > 8 ) {
					$image = apply_filters( $image_mechanism, $post_thumbnail_id, 'jnews-1140x570' );
				} else {
					$image = apply_filters( $image_mechanism, $post_thumbnail_id, 'jnews-750x375' );
				}
			}

			$content .=
				'<div class="jeg_slide_item">
                    ' . jnews_edit_post( $post->ID ) . '
                    <a href="' . get_permalink( $post ) . '" aria-label="' . esc_html__( 'Read article: ', 'jnews' ) . get_the_title( $post ) . "\" class=\"jeg_slide_img\">{$image}</a>
                    <div class=\"jeg_slide_caption\">
                        <div class=\"jeg_caption_container\">
                            <div class=\"jeg_post_category\">
                                {$primary_category}
                            </div>
                            <h2 class=\"jeg_post_title\">
                                <a href=\"" . get_the_permalink( $post ) . '" >' . get_the_title( $post ) . "</a>
                            </h2>
                            {$this->render_meta($post)}
                        </div>
                    </div>
                </div>";
		}

		remove_filter( 'jnews_use_custom_image', array( $this, 'main_custom_image_size' ) );
		return $content;
	}

	public function carousel( $results ) {
		$content = '';
		add_filter( 'jnews_use_custom_image', array( $this, 'second_custom_image_size' ) );
		foreach ( $results as $key => $post ) {
			$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
			if ( $this->manager->get_current_width() > 8 ) {
				$image = apply_filters( 'jnews_single_image_lazy_owl', $post_thumbnail_id, 'jnews-350x250' );
			} else {
				$image = apply_filters( 'jnews_single_image_lazy_owl', $post_thumbnail_id, 'jnews-120x86' );
			}

			$content .= '<div class="jeg_slide_thumbnail_item_wrapper" ><div  ' . jnews_post_class( 'jeg_slide_thumbnail_item', $post->ID ) . '><a href="' . get_permalink( $post ) . '" aria-label="' . esc_html__( 'Show article: ', 'jnews' ) . get_the_title( $post ) . "\">{$image}</a></div></div>";
		}
		remove_filter( 'jnews_use_custom_image', array( $this, 'second_custom_image_size' ) );
		return $content;
	}

	public function render_element( $result, $attr ) {
		if ( ! empty( $result ) ) {
			$content        = $this->content( $result );
			$slider         = $this->carousel( $result );
			$autoplay_delay = isset( $attr['autoplay_delay']['size'] ) ? $attr['autoplay_delay']['size'] : $attr['autoplay_delay'];

			$output =
				"<div {$this->element_id($attr)} class=\"jeg_slider_wrapper jeg_slider_type_1_wrapper {$this->unique_id} {$this->get_vc_class_name()} {$attr['el_class']}\">
                    <div class=\"jeg_slider_type_1 jeg_slider\" data-autoplay=\"{$attr['enable_autoplay']}\" data-delay=\"{$autoplay_delay}\" data-hover-action=\"{$attr['enable_hover_action']}\">
                        {$content}
                    </div>
                    <div class=\"jeg_slider_thumbnail_wrapper\">
                        <div class=\"jeg_slider_thumbnail\">
                            {$slider}
                        </div>
                    </div>
                </div>";
			return $output;
		} else {
			return $this->empty_content();
		}
	}
}
