<?php
/**
 * @author : Jegtheme
 */
namespace JNews\Module\Slider;

use JNews\Module\ModuleViewAbstract;

abstract Class SliderViewAbstract extends ModuleViewAbstract
{
    public function render_module($attr, $column_class)
    {
        if ( ( SCRIPT_DEBUG || get_theme_mod( 'jnews_load_necessary_asset', false ) ) && ! is_user_logged_in() ) {
            wp_dequeue_style( 'jnews-scheme' );
            wp_enqueue_style( 'jnews-slider' );
            wp_enqueue_script( 'jnews-slider' );
            wp_enqueue_style( 'jnews-scheme' );
        }

        $attr['pagination_number_post'] = 1;
        $results = $this->build_query($attr);
        return $this->render_element($results['result'], $attr);
    }

    public function render_meta($post)
    {
        $output = '';

        if(get_theme_mod('jnews_show_block_meta', true))
        {
            $author = $post->post_author;
            $author_url = get_author_posts_url($author);
            $author_name = get_the_author_meta('display_name', $author);
            $author_text = jnews_check_coauthor_plus() ? "<span class=\"jeg_meta_author coauthor\">" . jnews_get_author_coauthor($post->ID, false, null, 1) . "</span>" : "<span class=\"jeg_meta_author\">" . jnews_return_translation('by', 'jnews', 'by') . " <a href=\"{$author_url}\">{$author_name}</a></span>";
            $time = $this->format_date($post);

            $output .= "<div class=\"jeg_post_meta\">";
			$output .= ( vp_metabox( 'jnews_single_post.trending_post', null, $post->ID ) ) ? '<div class="jeg_meta_trending"><a href="' . get_the_permalink( $post ) . '" aria-label="' . esc_html__( 'View this Trending Post', 'jnews' ) . '"><i class="fa fa-bolt"></i></a></div>' : '';
            $output .= get_theme_mod('jnews_show_block_meta_author', true) ? $author_text : "";
            $output .= get_theme_mod('jnews_show_block_meta_date', true) ? "<span class=\"jeg_meta_date\">{$time}</span>" : "";
            $output .= "</div>";
        }

        return $output;
    }

    public function set_slider_option()
    {
        $this->options['enable_autoplay'] = '';
        $this->options['autoplay_delay'] = '3000';
        $this->options['date_format'] = 'default';
        $this->options['date_format_custom'] = 'Y/m/d';
    }

	public function gradient_style($attr)
	{
		$style = '';
		$slider_type = '.jeg_slider_type_' . str_replace('jnews_slider_', '', $this->class_name);

		if( isset($attr['overlay_option']) && $attr['overlay_option'] === 'normal' && !empty($attr['normal_overlay'])) {
			$style = ".{$this->unique_id} {$slider_type} .jeg_slide_item:before { background: {$attr['normal_overlay']} }";
		}

		if( isset($attr['overlay_option']) && $attr['overlay_option'] === 'gradient' && $attr['gradient_overlay_enable'])
		{
			$gradient_overlay_degree = isset($attr['gradient_overlay_degree']['size']) ? $attr['gradient_overlay_degree']['size'] : $attr['gradient_overlay_degree'];
			$style .=
				".{$this->unique_id} {$slider_type} .jeg_slide_item:before {
                            background: -moz-linear-gradient({$gradient_overlay_degree}deg, {$attr['gradient_overlay_start_color']} 0%, {$attr['gradient_overlay_end_color']} 100%);
                            background: -webkit-linear-gradient({$gradient_overlay_degree}deg, {$attr['gradient_overlay_start_color']} 0%, {$attr['gradient_overlay_end_color']} 100%);
                            background: linear-gradient({$gradient_overlay_degree}deg, {$attr['gradient_overlay_start_color']} 0%, {$attr['gradient_overlay_end_color']} 100%);
                        }";
		}

		return $style;
	}

    public function remove_unit($string)
    {
        return str_replace(array('px', 'em', '%', 'rem'), '', strtolower($string));
    }

    public function generate_style($attr)
    {
        $style = '';

        if(!empty($attr['slider_height_desktop']))
        {
            $height = $this->remove_unit($attr['slider_height_desktop']);
            $style .= "@media only screen and (min-width: 1025px) { .jeg_slider_wrapper.{$this->unique_id} .jeg_slide_item{ height: {$height}px !important; } }";
        }

        if(!empty($attr['slider_height_1024']))
        {
            $height = $this->remove_unit($attr['slider_height_1024']);
            $style .= "@media only screen and (max-width: 1024px) and (min-width: 769px) { .jeg_slider_wrapper.{$this->unique_id} .jeg_slide_item{ height: {$height}px !important; } }";
        }

        if(!empty($attr['slider_height_768']))
        {
            $height = $this->remove_unit($attr['slider_height_768']);
            $style .= "@media only screen and (max-width: 768px) and (min-width: 668px) { .jeg_slider_wrapper.{$this->unique_id} .jeg_slide_item{ height: {$height}px !important; } }";
        }

        if(!empty($attr['slider_height_667']))
        {
            $height = $this->remove_unit($attr['slider_height_667']);
            $style .= "@media only screen and (max-width: 667px) and (min-width: 569px) { .jeg_slider_wrapper.{$this->unique_id} .jeg_slide_item{ height: {$height}px !important; } }";
        }

        if(!empty($attr['slider_height_568']))
        {
            $height = $this->remove_unit($attr['slider_height_568']);
            $style .= "@media only screen and (max-width: 568px) and (min-width: 481px) { .jeg_slider_wrapper.{$this->unique_id} .jeg_slide_item{ height: {$height}px !important; } }";
        }

        if(!empty($attr['slider_height_480']))
        {
            $height = $this->remove_unit($attr['slider_height_480']);
            $style .= "@media only screen and (max-width: 480px) { .jeg_slider_wrapper.{$this->unique_id} .jeg_slide_item{ height: {$height}px !important; } }";
        }

        // Gradient Background Overlay
        $style .= $this->gradient_style($attr);

        if(!empty($style))
        {
            $style = "<style scoped>{$style}</style>";
        }

        return $style;
    }

    public function main_custom_image_size( $size ) {
		$size = ! empty( $this->attribute['main_custom_image_size'] ) && 'default' !== $this->attribute['main_custom_image_size'] ? $this->attribute['main_custom_image_size'] : $size;
		return $size;
	}

    public function second_custom_image_size( $size ) {
		$size = ! empty( $this->attribute['second_custom_image_size'] ) && 'default' !== $this->attribute['second_custom_image_size'] ? $this->attribute['second_custom_image_size'] : $size;
		return $size;
	}

    abstract public function render_element($result, $attr);
}
