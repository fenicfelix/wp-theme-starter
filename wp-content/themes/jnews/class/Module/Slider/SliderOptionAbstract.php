<?php
/**
 * @author : Jegtheme
 */
namespace JNews\Module\Slider;

use JNews\Module\ModuleOptionAbstract;

abstract Class SliderOptionAbstract extends ModuleOptionAbstract
{
    protected $default_number = 4;

    protected $gradient_option = false;
    protected $design_option = false;
	protected $second_thumbnail    = false;

    public function compatible_column()
    {
        return array( 8, 12 );
    }

	public function get_category()
	{
		return esc_html__('JNews - Slider', 'jnews');
	}

	public function show_color_scheme()
    {
        return false;
    }

    public function set_options()
    {
        $this->set_slider_option();
        $this->set_show_post_sticky_option();
        $this->set_content_filter_option($this->default_number);

        if ($this->design_option) $this->set_slider_design_option();
        if ($this->gradient_option) $this->set_gradient_option();

        $this->set_style_option();
    }

    public function set_slider_option()
    {
        $this->options[] = array(
            'type'          => 'checkbox',
            'param_name'    => 'enable_autoplay',
            'heading'       => esc_html__('Enable Autoplay', 'jnews'),
            'description'   => esc_html__('Check this option to enable auto play.', 'jnews'),
        );
        $this->options[] = array(
            'type'          => 'slider',
            'param_name'    => 'autoplay_delay',
            'heading'       => esc_html__('Autoplay Delay', 'jnews'),
            'description'   => esc_html__('Set your autoplay delay (in millisecond).', 'jnews'),
            'min'           => 1000,
            'max'           => 10000,
            'step'          => 500,
            'std'           => 3000,
            'dependency'    => array('element' => 'enable_autoplay', 'value' => 'true')
        );
        $this->options[] = array(
            'type'          => 'dropdown',
            'param_name'    => 'date_format',
            'heading'       => esc_html__('Choose Date Format', 'jnews'),
            'description'   => esc_html__('Choose which date format you want to use.', 'jnews'),
            'std'           => 'default',
            'value'         => array(
                esc_html__('Relative Date/Time Format (ago)', 'jnews')  => 'ago',
                esc_html__('WordPress Default Format', 'jnews')         => 'default',
                esc_html__('Custom Format', 'jnews')                    => 'custom',
            )
        );
        $this->options[] = array(
            'type'          => 'textfield',
            'param_name'    => 'date_format_custom',
            'heading'       => esc_html__('Custom Date Format', 'jnews'),
            'description'   => wp_kses(sprintf(__('Please write custom date format for your module, for more detail about how to write date format, you can refer to this <a href="%s" target="_blank">link</a>.', 'jnews'), 'https://codex.wordpress.org/Formatting_Date_and_Time'), wp_kses_allowed_html()),
            'std'           => 'Y/m/d',
            'dependency'    => array('element' => 'date_format', 'value' => array('custom'))
        );
        $this->options[] = [
			'type'        => 'checkbox',
			'param_name'  => 'force_normal_image_load',
			'heading'     => esc_html__( 'Use Normal Image Load', 'jnews' ),
			'description' => esc_html__( 'Force it to use normal load image and optimize Largest Contentful Paint (LCP) when using this element at the top of your site', 'jnews' ),
        ];
		$this->options[] = array(
			'type'        => 'dropdown',
			'param_name'  => 'main_custom_image_size',
			'std'         => 'default',
			'heading'     => esc_html__( 'Rendered Image Size', 'jnews' ),
			'description' => esc_html__( 'Choose the image size that you want to rendered in this Slider.', 'jnews' ),
			'value'       => $this->get_image_size(),
		);
		if ( $this->second_thumbnail ) {
			$this->options[] = array(
				'type'        => 'dropdown',
				'param_name'  => 'second_custom_image_size',
				'std'         => 'default',
				'heading'     => esc_html__( 'Rendered Image Size in Slider Thumbnail', 'jnews' ),
				'description' => esc_html__( 'Choose the image size that you want to rendered in slider thumbnail in this module.', 'jnews' ),
				'value'       => $this->get_image_size(),
			);
		}
	}

    public function set_gradient_option()
    {
	    $this->options[] = array(
		    'type'          => 'dropdown',
		    'param_name'    => 'overlay_option',
		    'heading'       => esc_html__('Overlay Option', 'jnews'),
		    'description'   => esc_html__('Choose overlay type that you want to use for slider.', 'jnews'),
		    'std'           => 'gradient',
		    'value'         => array(
			    esc_html__('Gradient Overlay', 'jnews') => 'gradient',
			    esc_html__('Normal Overlay', 'jnews')   => 'normal',
			    esc_html__('No Overlay', 'jnews')       => 'none',
		    )
	    );
	    $this->options[] = array(
		    'type'          => 'colorpicker',
		    'param_name'    => 'normal_overlay',
		    'std'           => 'rgba(255,255,255,0.5)',
		    'heading'       => esc_html__('Normal Overlay Color', 'jnews'),
		    'description'   => esc_html__('Choose your normal overlay color for slider.', 'jnews'),
		    'dependency'    => array('element' => 'overlay_option', 'value' => array('normal'))
	    );
	    $this->options[] = array(
		    'type'          => 'checkbox',
		    'param_name'    => 'gradient_overlay_enable',
		    'heading'       => esc_html__('Override Gradient Overlay Color', 'jnews'),
		    'description'   => esc_html__('Override default gradient overlay color.', 'jnews'),
		    'dependency'    => array('element' => 'overlay_option', 'value' => array('gradient'))
	    );
	    $this->options[] = array(
		    'type'          => 'slider',
		    'param_name'    => 'gradient_overlay_degree',
		    'heading'       => esc_html__('Overlay Gradient Degree', 'jnews'),
		    'min'           => 0,
		    'max'           => 360,
		    'step'          => 1,
		    'std'           => 0,
		    'dependency'    => array('element' => 'gradient_overlay_enable', 'value' => 'true')
	    );
	    $this->options[] = array(
		    'type'          => 'colorpicker',
		    'std'           => 'rgba(255,255,255,0.5)',
		    'param_name'    => 'gradient_overlay_start_color',
		    'heading'       => esc_html__('Overlay Gradient Start Color', 'jnews'),
		    'dependency'    => array('element' => 'gradient_overlay_enable', 'value' => 'true')
	    );
	    $this->options[] = array(
		    'type'          => 'colorpicker',
		    'std'           => 'rgba(0,0,0,0.5)',
		    'param_name'    => 'gradient_overlay_end_color',
		    'heading'       => esc_html__('Overlay Gradient End Color', 'jnews'),
		    'dependency'    => array('element' => 'gradient_overlay_enable', 'value' => 'true')
	    );
    }

    public function set_slider_design_option()
    {
        $this->options[] = array(
            'type'          => 'textfield',
            'param_name'    => 'slider_height_desktop',
            'heading'       => esc_html__('Slider Height on Dekstop', 'jnews'),
            'description'   => esc_html__('Height on pixel / px, leave it empty to use the default number.', 'jnews'),
            'group'         => esc_html__('Slider Design', 'jnews'),
        );
        $this->options[] = array(
            'type'          => 'textfield',
            'param_name'    => 'slider_height_1024',
            'heading'       => esc_html__('Slider Height on 1024px Width Screen', 'jnews'),
            'description'   => esc_html__('Height on pixel / px, leave it empty to use the default number.', 'jnews'),
            'group'         => esc_html__('Slider Design', 'jnews'),
        );
        $this->options[] = array(
            'type'          => 'textfield',
            'param_name'    => 'slider_height_768',
            'heading'       => esc_html__('Slider Height on 768px Width Screen', 'jnews'),
            'description'   => esc_html__('Height on pixel / px, leave it empty to use the default number.', 'jnews'),
            'group'         => esc_html__('Slider Design', 'jnews'),
        );
        $this->options[] = array(
            'type'          => 'textfield',
            'param_name'    => 'slider_height_667',
            'heading'       => esc_html__('Slider Height on 667px Width Screen', 'jnews'),
            'description'   => esc_html__('Height on pixel / px, leave it empty to use the default number.', 'jnews'),
            'group'         => esc_html__('Slider Design', 'jnews'),
        );
        $this->options[] = array(
            'type'          => 'textfield',
            'param_name'    => 'slider_height_568',
            'heading'       => esc_html__('Slider Height on 568px Width Screen', 'jnews'),
            'description'   => esc_html__('Height on pixel / px, leave it empty to use the default number.', 'jnews'),
            'group'         => esc_html__('Slider Design', 'jnews'),
        );
        $this->options[] = array(
            'type'          => 'textfield',
            'param_name'    => 'slider_height_480',
            'heading'       => esc_html__('Slider Height on 480px Width Screen', 'jnews'),
            'description'   => esc_html__('Height on pixel / px, leave it empty to use the default number.', 'jnews'),
            'group'         => esc_html__('Slider Design', 'jnews'),
        );
    }

	public function set_typography_option( $instance ) {

		$instance->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'        => 'title_typography',
				'label'       => esc_html__( 'Title Typography', 'jnews' ),
				'description' => esc_html__( 'Set typography for post title', 'jnews' ),
				'selector'    => '{{WRAPPER}} .jeg_post_title > a',
			]
		);

		$instance->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'        => 'meta_typography',
				'label'       => esc_html__( 'Meta Typography', 'jnews' ),
				'description' => esc_html__( 'Set typography for post meta', 'jnews' ),
				'selector'    => '{{WRAPPER}} .jeg_post_meta, {{WRAPPER}} .jeg_post_meta .fa, {{WRAPPER}}.jeg_postblock .jeg_subcat_list > li > a:hover, {{WRAPPER}} .jeg_pl_md_card .jeg_post_category a, {{WRAPPER}}.jeg_postblock .jeg_subcat_list > li > a.current, {{WRAPPER}} .jeg_pl_md_5 .jeg_post_meta, {{WRAPPER}} .jeg_pl_md_5 .jeg_post_meta .fa, {{WRAPPER}} .jeg_post_category a',
			]
		);
	}

    public function set_show_post_sticky_option(){
		$this->options[] = array(
			'type'        => 'checkbox',
			'param_name'  => 'sticky_post',
			'heading'     => esc_html__( 'Show Sticky Post', 'jnews' ),
			'description' => esc_html__( 'Enabling this option will display the Sticky Post at the first place in this module', 'jnews' ),
			'group'       => esc_html__( 'Content Filter', 'jnews' ),
			'std'         => false,
			'dependency'  => array(
				'element' => 'post_type',
				'value'   => 'post',
			),
		);
	}

	public function get_image_size() {
		$size_lists = array(
			esc_attr__( 'Default', 'jnews' )        => 'default',
			esc_attr__( 'Original Image', 'jnews' ) => 'full',
		);
		foreach ( wp_get_registered_image_subsizes()  as $key => $image_size ) {
			$size_lists[ esc_attr__( $key, 'jnews' ) ] = $key;
		}
		return $size_lists;
	}
}
