<?php
/**
 * @author : Jegtheme
 */

namespace JNews\Module\Slider;

class Slider_2_View extends SliderViewAbstract {
	public function content( $results ) {
		$content = '';
		if ( $this->manager->get_current_width() > 8 ) {
			$size = $this->main_custom_image_size( 'jnews-1140x570' );
		} else {
			$size = $this->main_custom_image_size( 'jnews-750x375' );
		}

		foreach ( $results as $key => $post ) {
			$primary_category = $this->get_primary_category( $post->ID );
			$image            = get_the_post_thumbnail_url( $post->ID, $size );

			$image_mechanism = isset( $this->attribute['force_normal_image_load'] ) && ( 'true' === $this->attribute['force_normal_image_load'] || 'yes' === $this->attribute['force_normal_image_load'] );
			$hidden_image    = $image_mechanism && 0 <= $key ? "<img class=\"thumbnail-prioritize\" src=\"{$image}\" style=\"display: none\" >" : '';

			$content .=
				'<div ' . jnews_post_class( 'jeg_slide_item', $post->ID ) . ' style="background-image: url(' . esc_url( $image ) . ')">
					' . $hidden_image . '
                    ' . jnews_edit_post( $post->ID ) . "
                    <div class=\"jeg_slide_caption\">
                        <div class=\"jeg_caption_container\">
                            <div class=\"jeg_post_category\">
                                {$primary_category}
                            </div>
                            <h2 class=\"jeg_post_title\">
                                <a href=\"" . get_the_permalink( $post ) . '">' . get_the_title( $post ) . "</a>
                            </h2>
                            {$this->render_meta($post)}
                        </div>
                    </div>
                </div>";
		}

		return $content;
	}

	public function render_element( $result, $attr ) {
		if ( ! empty( $result ) ) {
			$content          = $this->content( $result );
			$autoplay_delay   = isset( $attr['autoplay_delay']['size'] ) ? $attr['autoplay_delay']['size'] : $attr['autoplay_delay'];
			$additional_class = $attr['overlay_option'] === 'none' ? 'no-overlay' : '';
			$style            = $this->gradient_style( $attr );

			$output =
				"<div {$this->element_id($attr)} class=\"jeg_slider_wrapper jeg_slider_type_2_wrapper {$this->unique_id} {$this->get_vc_class_name()} {$additional_class} {$attr['el_class']}\">
                    <div class=\"jeg_slider_type_2 jeg_slider\" data-autoplay=\"{$attr['enable_autoplay']}\" data-delay=\"{$autoplay_delay}\">
                        {$content}
                    </div>
                    <style>{$style}</style>
                </div>";

			return $output;
		} else {
			return $this->empty_content();
		}
	}
}
