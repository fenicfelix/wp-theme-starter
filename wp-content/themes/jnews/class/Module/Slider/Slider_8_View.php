<?php
/**
 * @author : Jegtheme
 */
namespace JNews\Module\Slider;

class Slider_8_View extends SliderViewAbstract {

	public function content( $results ) {
		$content = '';
		foreach ( $results as $key => $post ) {
			$primary_category  = $this->get_primary_category( $post->ID );
			$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
			$image_mechanism   = isset( $this->attribute['force_normal_image_load'] ) && ( 'true' === $this->attribute['force_normal_image_load'] || 'yes' === $this->attribute['force_normal_image_load'] ) ? 'jnews_single_image_owl' : 'jnews_single_image_lazy_owl';
			if ( 'jnews_single_image_owl' === $image_mechanism ) {
				$image = \JNews\Image\ImageNormalLoad::getInstance()->owl_single_image( $post_thumbnail_id, 'jnews-350x250' );
			} else {
				$image = apply_filters( $image_mechanism, $post_thumbnail_id, 'jnews-350x250' );
			}

			$content .=
				'<div class="jeg_slide_item_wrapper"><div ' . jnews_post_class( 'jeg_slide_item', $post->ID ) . '>
                    ' . jnews_edit_post( $post->ID ) . '
                    <a href="' . get_the_permalink( $post ) . '" aria-label="' . esc_html__( 'Read article: ', 'jnews' ) . get_the_title( $post ) . "\" >
                        {$image}
                    </a>
                    <div class=\"jeg_item_caption\">
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
                </div></div>";
		}

		return $content;
	}

	public function render_element( $result, $attr ) {
		if ( ! empty( $result ) ) {
			add_filter( 'jnews_use_custom_image', array( $this, 'main_custom_image_size' ) );

			$content = $this->content( $result );
			remove_filter( 'jnews_use_custom_image', array( $this, 'main_custom_image_size' ) );

			$column_class   = $this->get_module_column_class( $attr );
			$autoplay_delay = isset( $attr['autoplay_delay']['size'] ) ? $attr['autoplay_delay']['size'] : $attr['autoplay_delay'];
			$number_item    = isset( $attr['number_item']['size'] ) ? $attr['number_item']['size'] : $attr['number_item'];

			$output =
				"<div {$this->element_id($attr)} class=\"jeg_slider_wrapper jeg_slider_type_8_wrapper {$column_class} {$this->unique_id} {$this->get_vc_class_name()} {$attr['el_class']}\">
                    <div class=\"jeg_slider_type_8 jeg_slider\" data-items=\"{$number_item}\" data-autoplay=\"{$attr['enable_autoplay']}\" data-delay=\"{$autoplay_delay}\">
                        {$content}
                    </div>
                </div>";
			return $output;
		} else {
			return $this->empty_content();
		}
	}

	public function render_meta( $post ) {
		$output = '';

		if ( get_theme_mod( 'jnews_show_block_meta', true ) && get_theme_mod( 'jnews_show_block_meta_date', true ) ) {
			$time     = $this->format_date( $post );
			$trending = ( jnews_get_metabox_value( 'jnews_single_post.trending_post', null, $post->ID ) ) ? '<div class="jeg_meta_trending"><a href="' . get_the_permalink( $post ) . '" aria-label="' . esc_html__( 'View this Trending Post', 'jnews' ) . '"><i class="fa fa-bolt"></i></a></div>' : '';
			$output   =
				"<div class=\"jeg_post_meta\">
					{$trending}
                    <span class=\"jeg_meta_date\">{$time}</span>
                </div>";
		}

		return $output;
	}
}
