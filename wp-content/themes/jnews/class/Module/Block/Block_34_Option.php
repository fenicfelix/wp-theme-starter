<?php
/**
 * @author : Jegtheme
 */

namespace JNews\Module\Block;

Class Block_34_Option extends BlockOptionAbstract {
	protected $default_number_post = 6;
	protected $show_excerpt = false;
	protected $default_ajax_post = 4;

	public function get_module_name() {
		return esc_html__( 'JNews - Module 34', 'jnews' );
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

	public function set_content_setting_option( $show_excerpt = false ) {
		$this->options[] = array(
			'type'        => 'dropdown',
			'param_name'  => 'date_format',
			'heading'     => esc_html__( 'Content Date Format', 'jnews' ),
			'description' => esc_html__( 'Choose which date format you want to use.', 'jnews' ),
			'std'         => 'default',
			'group'       => esc_html__( 'Content Setting', 'jnews' ),
			'value'       => array(
				esc_html__( 'Relative Date/Time Format (ago)', 'jnews' ) => 'ago',
				esc_html__( 'WordPress Default Format', 'jnews' )        => 'default',
				esc_html__( 'Custom Format', 'jnews' )                   => 'custom',
			)
		);

		$this->options[] = array(
			'type'        => 'textfield',
			'param_name'  => 'date_format_custom',
			'heading'     => esc_html__( 'Custom Date Format', 'jnews' ),
			'description' => wp_kses( sprintf( __( 'Please write custom date format for your module, for more detail about how to write date format, you can refer to this <a href="%s" target="_blank">link</a>.', 'jnews' ), 'https://codex.wordpress.org/Formatting_Date_and_Time' ), wp_kses_allowed_html() ),
			'group'       => esc_html__( 'Content Setting', 'jnews' ),
			'std'         => 'Y/m/d',
			'dependency'  => array( 'element' => 'date_format', 'value' => array( 'custom' ) )
		);

		if ( $show_excerpt ) {
			$this->options[] = array(
				'type'        => 'slider',
				'param_name'  => 'excerpt_length',
				'heading'     => esc_html__( 'Excerpt Length', 'jnews' ),
				'description' => esc_html__( 'Set word length of excerpt on post block.', 'jnews' ),
				'group'       => esc_html__( 'Content Setting', 'jnews' ),
				'min'         => 0,
				'max'         => 200,
				'step'        => 1,
				'std'         => 20,
			);

			$this->options[] = array(
				'type'        => 'textfield',
				'param_name'  => 'excerpt_ellipsis',
				'heading'     => esc_html__( 'Excerpt Ellipsis', 'jnews' ),
				'description' => esc_html__( 'Define excerpt ellipsis', 'jnews' ),
				'group'       => esc_html__( 'Content Setting', 'jnews' ),
				'std'         => '...'
			);
		}

		$this->options[] = array(
			'type'        => 'dropdown',
			'param_name'  => 'main_custom_image_size',
			'std'         => 'default',
			'heading'     => esc_html__( 'Rendered Image Size', 'jnews' ),
			'description' => esc_html__( 'Choose the image size that you want to rendered in this module.', 'jnews' ),
			'group'       => esc_html__( 'Content Setting', 'jnews' ),
			'value'       => $this->get_image_size(),
		);
	}
}
