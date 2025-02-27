<?php
/**
 * @author : Jegtheme
 */

namespace JNews\Module\Block;

use JNews\Module\ModuleOptionAbstract;

abstract Class BlockOptionAbstract extends ModuleOptionAbstract {
	protected $default_number_post = 5;
	protected $show_excerpt = false;
	protected $show_ads = false;
	protected $default_ajax_post = 5;
	protected $second_thumbnail    = false;

	public function compatible_column() {
		return array( 4, 8, 12 );
	}

	public function set_options() {
		$this->set_header_option();
		$this->set_header_filter_option();
		$this->set_show_post_sticky_option();
		$this->set_content_filter_option( $this->default_number_post );
		$this->set_content_setting_option( $this->show_excerpt );
		$this->set_ajax_filter_option( $this->default_ajax_post );
		$this->set_ads_setting_option( $this->show_ads );
		$this->set_style_option();
	}

	protected function get_ad_size() {
		return array(
			esc_attr__( 'Auto', 'jnews' )      => 'auto',
			esc_attr__( 'Hide', 'jnews' )      => 'hide',
			esc_attr__( '120 x 90', 'jnews' )  => '120x90',
			esc_attr__( '120 x 240', 'jnews' ) => '120x240',
			esc_attr__( '120 x 600', 'jnews' ) => '120x600',
			esc_attr__( '125 x 125', 'jnews' ) => '125x125',
			esc_attr__( '160 x 90', 'jnews' )  => '160x90',
			esc_attr__( '160 x 600', 'jnews' ) => '160x600',
			esc_attr__( '180 x 90', 'jnews' )  => '180x90',
			esc_attr__( '180 x 150', 'jnews' ) => '180x150',
			esc_attr__( '200 x 90', 'jnews' )  => '200x90',
			esc_attr__( '200 x 200', 'jnews' ) => '200x200',
			esc_attr__( '234 x 60', 'jnews' )  => '234x60',
			esc_attr__( '250 x 250', 'jnews' ) => '250x250',
			esc_attr__( '320 x 100', 'jnews' ) => '320x100',
			esc_attr__( '300 x 250', 'jnews' ) => '300x250',
			esc_attr__( '300 x 600', 'jnews' ) => '300x600',
			esc_attr__( '320 x 50', 'jnews' )  => '320x50',
			esc_attr__( '336 x 280', 'jnews' ) => '336x280',
			esc_attr__( '468 x 15', 'jnews' )  => '468x15',
			esc_attr__( '468 x 60', 'jnews' )  => '468x60',
			esc_attr__( '728 x 15', 'jnews' )  => '728x15',
			esc_attr__( '728 x 90', 'jnews' )  => '728x90',
			esc_attr__( '970 x 90', 'jnews' )  => '970x90',
			esc_attr__( '970 x 250', 'jnews' ) => '970x250',
			esc_attr__( '240 x 400', 'jnews' ) => '240x400',
			esc_attr__( '250 x 360', 'jnews' ) => '250x360',
			esc_attr__( '580 x 400', 'jnews' ) => '580x400',
			esc_attr__( '750 x 100', 'jnews' ) => '750x100',
			esc_attr__( '750 x 200', 'jnews' ) => '750x200',
			esc_attr__( '750 x 300', 'jnews' ) => '750x300',
			esc_attr__( '980 x 120', 'jnews' ) => '980x120',
			esc_attr__( '930 x 180', 'jnews' ) => '930x180',
		);
	}

	public function additional_style() {
		$this->options[] = array(
			'type'        => 'colorpicker',
			'param_name'  => 'title_color',
			'group'       => esc_html__( 'Design', 'jnews' ),
			'heading'     => esc_html__( 'Title Color', 'jnews' ),
			'description' => esc_html__( 'This option will change your title color.', 'jnews' ),
		);

		$this->options[] = array(
			'type'        => 'colorpicker',
			'param_name'  => 'accent_color',
			'group'       => esc_html__( 'Design', 'jnews' ),
			'heading'     => esc_html__( 'Accent Color & Link Hover', 'jnews' ),
			'description' => esc_html__( 'This option will change your accent color.', 'jnews' ),
		);

		$this->options[] = array(
			'type'        => 'colorpicker',
			'param_name'  => 'alt_color',
			'group'       => esc_html__( 'Design', 'jnews' ),
			'heading'     => esc_html__( 'Meta Color', 'jnews' ),
			'description' => esc_html__( 'This option will change your meta color.', 'jnews' ),
		);

		$this->options[] = array(
			'type'        => 'colorpicker',
			'param_name'  => 'excerpt_color',
			'group'       => esc_html__( 'Design', 'jnews' ),
			'heading'     => esc_html__( 'Excerpt Color', 'jnews' ),
			'description' => esc_html__( 'This option will change your excerpt color.', 'jnews' ),
		);
	}

	/**
	 * @return array
	 */
	public function set_header_option() {
		$this->options[] = array(
			'type'        => 'iconpicker',
			'param_name'  => 'header_icon',
			'heading'     => esc_html__( 'Header Icon', 'jnews' ),
			'description' => esc_html__( 'Choose icon for this block icon.', 'jnews' ),
			'group'       => esc_html__( 'Header', 'jnews' ),
			'std'         => '',
			'settings'    => array(
				'emptyIcon'    => true,
				'iconsPerPage' => 100,
			)
		);
		$this->options[] = array(
			'type'        => 'textfield',
			'param_name'  => 'first_title',
			'holder'      => 'span',
			'heading'     => esc_html__( 'Title', 'jnews' ),
			'description' => esc_html__( 'Main title of Module Block.', 'jnews' ),
			'group'       => esc_html__( 'Header', 'jnews' ),
		);
		$this->options[] = array(
			'type'        => 'textfield',
			'param_name'  => 'second_title',
			'holder'      => 'span',
			'heading'     => esc_html__( 'Second Title', 'jnews' ),
			'description' => esc_html__( 'Secondary title of Module Block.', 'jnews' ),
			'group'       => esc_html__( 'Header', 'jnews' ),
		);
		$this->options[] = array(
			'type'        => 'textfield',
			'param_name'  => 'url',
			'heading'     => esc_html__( 'Title URL', 'jnews' ),
			'description' => esc_html__( 'Insert URL of heading title.', 'jnews' ),
			'group'       => esc_html__( 'Header', 'jnews' ),
		);
		$this->options[] = array(
			'type'        => 'radioimage',
			'param_name'  => 'header_type',
			'std'         => 'heading_6',
			'value'       => array(
				JNEWS_THEME_URL . '/assets/img/admin/heading-1.png' => 'heading_1',
				JNEWS_THEME_URL . '/assets/img/admin/heading-2.png' => 'heading_2',
				JNEWS_THEME_URL . '/assets/img/admin/heading-3.png' => 'heading_3',
				JNEWS_THEME_URL . '/assets/img/admin/heading-4.png' => 'heading_4',
				JNEWS_THEME_URL . '/assets/img/admin/heading-5.png' => 'heading_5',
				JNEWS_THEME_URL . '/assets/img/admin/heading-6.png' => 'heading_6',
				JNEWS_THEME_URL . '/assets/img/admin/heading-7.png' => 'heading_7',
				JNEWS_THEME_URL . '/assets/img/admin/heading-8.png' => 'heading_8',
				JNEWS_THEME_URL . '/assets/img/admin/heading-9.png' => 'heading_9',
			),
			'heading'     => esc_html__( 'Header Type', 'jnews' ),
			'description' => esc_html__( 'Choose which header type fit with your content design.', 'jnews' ),
			'group'       => esc_html__( 'Header', 'jnews' ),
		);
		$this->options[] = array(
			'type'        => 'colorpicker',
			'param_name'  => 'header_background',
			'heading'     => esc_html__( 'Header Background', 'jnews' ),
			'description' => esc_html__( 'This option may not work for all of heading type.', 'jnews' ),
			'group'       => esc_html__( 'Header', 'jnews' ),
			'dependency'  => array(
				'element' => "header_type",
				'value'   => array(
					'heading_1',
					'heading_2',
					'heading_3',
					'heading_4',
					'heading_5'
				)
			)
		);
		$this->options[] = array(
			'type'        => 'colorpicker',
			'param_name'  => 'header_secondary_background',
			'heading'     => esc_html__( 'Header Secondary Background', 'jnews' ),
			'description' => esc_html__( 'change secondary background', 'jnews' ),
			'group'       => esc_html__( 'Header', 'jnews' ),
			'dependency'  => array( 'element' => "header_type", 'value' => array( 'heading_2' ) )
		);
		$this->options[] = array(
			'type'        => 'colorpicker',
			'param_name'  => 'header_text_color',
			'heading'     => esc_html__( 'Header Text Color', 'jnews' ),
			'description' => esc_html__( 'Change color of your header text', 'jnews' ),
			'group'       => esc_html__( 'Header', 'jnews' ),
		);
		$this->options[] = array(
			'type'        => 'colorpicker',
			'param_name'  => 'header_line_color',
			'heading'     => esc_html__( 'Header line Color', 'jnews' ),
			'description' => esc_html__( 'Change line color of your header', 'jnews' ),
			'group'       => esc_html__( 'Header', 'jnews' ),
			'dependency'  => array(
				'element' => "header_type",
				'value'   => array( 'heading_1', 'heading_5', 'heading_6', 'heading_9' )
			)
		);
		$this->options[] = array(
			'type'        => 'colorpicker',
			'param_name'  => 'header_accent_color',
			'heading'     => esc_html__( 'Header Accent', 'jnews' ),
			'description' => esc_html__( 'Change Accent of your header', 'jnews' ),
			'group'       => esc_html__( 'Header', 'jnews' ),
			'dependency'  => array( 'element' => "header_type", 'value' => array( 'heading_6', 'heading_7' ) )
		);
	}

	/**
	 * @return array
	 */
	public function set_header_filter_option() {

		$this->options[] = array(
			'type'        => 'select',
			'multiple'    => PHP_INT_MAX,
			'ajax'        => 'jeg_find_category',
			'options'     => 'jeg_get_category_option',
			'nonce'       => wp_create_nonce( 'jeg_find_category' ),

			'param_name'  => 'header_filter_category',
			'heading'     => esc_html__( 'Category', 'jnews' ),
			'description' => esc_html__( 'Add category filter for heading module.', 'jnews' ),
			'group'       => esc_html__( 'Header Filter', 'jnews' ),
			'std'         => '',
			'dependency'  => array(
				'element' => 'post_type',
				'value'   => 'post',
			),
		);
		$this->options[] = array(
			'type'        => 'select',
			'multiple'    => PHP_INT_MAX,
			'ajax'        => 'jeg_find_author',
			'options'     => 'jeg_get_author_option',
			'nonce'       => wp_create_nonce( 'jeg_find_author' ),

			'param_name'  => 'header_filter_author',
			'heading'     => esc_html__( 'Author', 'jnews' ),
			'description' => esc_html__( 'Add author filter for heading module.', 'jnews' ),
			'group'       => esc_html__( 'Header Filter', 'jnews' ),
			'std'         => '',
		);
		$this->options[] = array(
			'type'        => 'select',
			'multiple'    => PHP_INT_MAX,
			'ajax'        => 'jeg_find_tag',
			'options'     => 'jeg_get_tag_option',
			'nonce'       => wp_create_nonce( 'jeg_find_tag' ),

			'param_name'  => 'header_filter_tag',
			'heading'     => esc_html__( 'Tags', 'jnews' ),
			'description' => esc_html__( 'Add tag filter for heading module.', 'jnews' ),
			'group'       => esc_html__( 'Header Filter', 'jnews' ),
			'std'         => '',
			'dependency'  => array(
				'element' => 'post_type',
				'value'   => 'post',
			),
		);

		$taxonomies = \JNews\Util\Cache::get_enable_custom_taxonomies();

		foreach ( $taxonomies as $key => $value ) {

			$this->options[] = array(
				'type'        => 'select',
				'multiple'    => PHP_INT_MAX,
				'ajax'        => 'jeg_find_taxonomy',
				'nonce'       => wp_create_nonce( 'jeg_find_taxonomy' ),
				'options'     => 'jeg_get_taxonomy_option',
				'ajax_param'  => $key,
				'param_name'  => 'header_filter_cpt_' . $key,
				'heading'     => $value['name'],
				'description' => esc_html__( 'Add ', 'jnews' ) . $value['name'] . esc_html__( ' filter for heading module.', 'jnews' ),
				'group'       => esc_html__( 'Header Filter', 'jnews' ),
				'std'         => '',
				'dependency'  => array(
					'element' => 'post_type',
					'value'   => array_values( array_filter( $value['post_types'], 'jnews_delete_default_post_type' ) ),
				),
			);
		}
		$this->options[] = array(
			'type'        => 'textfield',
			'param_name'  => 'header_filter_text',
			'heading'     => esc_html__( 'Default Text', 'jnews' ),
			'description' => esc_html__( 'First item text on heading filter.', 'jnews' ),
			'group'       => esc_html__( 'Header Filter', 'jnews' ),
			'std'         => 'All',
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
				esc_html__( 'WordPress Default Format', 'jnews' ) => 'default',
				esc_html__( 'Custom Format', 'jnews' ) => 'custom',
			),
		);

		$this->options[] = array(
			'type'        => 'textfield',
			'param_name'  => 'date_format_custom',
			'heading'     => esc_html__( 'Custom Date Format', 'jnews' ),
			'description' => wp_kses( sprintf( __( 'Please write custom date format for your module, for more detail about how to write date format, you can refer to this <a href="%s" target="_blank">link</a>.', 'jnews' ), 'https://codex.wordpress.org/Formatting_Date_and_Time' ), wp_kses_allowed_html() ),
			'group'       => esc_html__( 'Content Setting', 'jnews' ),
			'std'         => 'Y/m/d',
			'dependency'  => array(
				'element' => 'date_format',
				'value'   => array( 'custom' ),
			),
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
				'std'         => '...',
			);
		}

		$this->options[] = array(
			'type'        => 'checkbox',
			'param_name'  => 'force_normal_image_load',
			'heading'     => esc_html__( 'Use Normal Image Load', 'jnews' ),
			'description' => esc_html__( 'Force it to use normal load image and optimize Largest Contentful Paint (LCP) when using this element at the top of your site', 'jnews' ),
			'group'       => esc_html__( 'Content Setting', 'jnews' ),
		);
		$image_size_list = $this->get_image_size();
		if ( $this->second_thumbnail ) {
			$this->options[] = array(
				'type'        => 'dropdown',
				'param_name'  => 'main_custom_image_size',
				'std'         => 'default',
				'heading'     => esc_html__( 'Rendered Image Size in Main Thumbnail', 'jnews' ),
				'description' => esc_html__( 'Choose the image size that you want to rendered in main thumbnail in this module.', 'jnews' ),
				'group'       => esc_html__( 'Content Setting', 'jnews' ),
				'value'       => $image_size_list,
			);

			$this->options[] = array(
				'type'        => 'dropdown',
				'param_name'  => 'second_custom_image_size',
				'std'         => 'default',
				'heading'     => esc_html__( 'Rendered Image Size in Second Thumbnail', 'jnews' ),
				'description' => esc_html__( 'Choose the image size that you want to rendered in second thumbnail in this module.', 'jnews' ),
				'group'       => esc_html__( 'Content Setting', 'jnews' ),
				'value'       => $image_size_list,
			);
		} else {
			$this->options[] = array(
				'type'        => 'dropdown',
				'param_name'  => 'main_custom_image_size',
				'std'         => 'default',
				'heading'     => esc_html__( 'Rendered Image Size', 'jnews' ),
				'description' => esc_html__( 'Choose the image size that you want to rendered in this module.', 'jnews' ),
				'group'       => esc_html__( 'Content Setting', 'jnews' ),
				'value'       => $image_size_list,
			);
		}
	}

	public function set_ajax_filter_option( $number = 10 ) {
		$this->options[] = array(
			'type'        => 'dropdown',
			'param_name'  => 'pagination_mode',
			'heading'     => esc_html__( 'Choose Pagination Mode', 'jnews' ),
			'description' => esc_html__( 'Choose which pagination mode that fit with your block.', 'jnews' ),
			'group'       => esc_html__( 'Pagination', 'jnews' ),
			'std'         => 'disable',
			'value'       => array(
				esc_html__( 'No Pagination', 'jnews' ) => 'disable',
				esc_html__( 'Next Prev', 'jnews' )     => 'nextprev',
				esc_html__( 'Load More', 'jnews' )     => 'loadmore',
				esc_html__( 'Auto Load on Scroll', 'jnews' ) => 'scrollload',
			),
		);
		$this->options[] = array(
			'type'       => 'checkbox',
			'param_name' => 'pagination_nextprev_showtext',
			'heading'    => esc_html__( 'Show Navigation Text', 'jnews' ),
			'value'      => array( esc_html__( 'Show Next/Prev text in the navigation controls.', 'jnews' ) => 'no' ),
			'group'      => esc_html__( 'Pagination', 'jnews' ),
			'dependency' => array(
				'element' => 'pagination_mode',
				'value'   => array( 'nextprev' ),
			),
		);
		$this->options[] = array(
			'type'        => 'slider',
			'param_name'  => 'pagination_number_post',
			'heading'     => esc_html__( 'Pagination Post', 'jnews' ),
			'description' => esc_html__( 'Number of Post loaded during pagination request.', 'jnews' ),
			'group'       => esc_html__( 'Pagination', 'jnews' ),
			'min'         => 1,
			'max'         => 30,
			'step'        => 1,
			'std'         => $number,
			'dependency'  => array(
				'element' => 'pagination_mode',
				'value'   => array( 'nextprev', 'loadmore', 'scrollload' ),
			),
		);
		$this->options[] = array(
			'type'        => 'number',
			'param_name'  => 'pagination_scroll_limit',
			'heading'     => esc_html__( 'Auto Load Limit', 'jnews' ),
			'description' => esc_html__( 'Limit of auto load when scrolling, set to zero to always load until end of content.', 'jnews' ),
			'group'       => esc_html__( 'Pagination', 'jnews' ),
			'min'         => 0,
			'max'         => 9999,
			'step'        => 1,
			'std'         => 0,
			'dependency'  => array(
				'element' => 'pagination_mode',
				'value'   => array( 'scrollload' ),
			),
		);
	}

	public function set_ads_setting_option( $show_ads = false ) {
		if ( ! $show_ads ) {
			return false;
		}

		$this->options[] = array(
			'type'        => 'dropdown',
			'param_name'  => 'ads_type',
			'heading'     => esc_html__( 'Ads Type', 'jnews' ),
			'description' => esc_html__( 'Choose which ads type you want to use.', 'jnews' ),
			'group'       => esc_html__( 'Ads', 'jnews' ),
			'std'         => 'disable',
			'value'       => array(
				esc_html__( 'Disable Ads', 'jnews' ) => 'disable',
				esc_html__( 'Image Ads', 'jnews' )   => 'image',
				esc_html__( 'Google Ads', 'jnews' )  => 'googleads',
				esc_html__( 'Script Code', 'jnews' ) => 'code',
			),
		);
		$this->options[] = array(
			'type'        => 'slider',
			'param_name'  => 'ads_position',
			'heading'     => esc_html__( 'Ads Position', 'jnews' ),
			'description' => esc_html__( 'Set after certain number of post you want this advertisement to show.', 'jnews' ),
			'group'       => esc_html__( 'Ads', 'jnews' ),
			'dependency'  => array(
				'element' => 'ads_type',
				'value'   => array( 'image', 'code', 'googleads' ),
			),
			'min'         => 1,
			'max'         => 10,
			'step'        => 1,
			'std'         => 1,
		);
		$this->options[] = array(
			'type'       => 'checkbox',
			'param_name' => 'ads_random',
			'heading'    => esc_html__( 'Random Ads Position', 'jnews' ),
			'value'      => array( esc_html__( 'Set after random certain number of post you want this advertisement to show.', 'jnews' ) => 'true' ),
			'group'      => esc_html__( 'Ads', 'jnews' ),
			'dependency' => array(
				'element' => 'ads_type',
				'value'   => array( 'image', 'code', 'googleads' ),
			),
		);
		// IMAGE
		$this->options[] = array(
			'type'        => 'attach_image',
			'param_name'  => 'ads_image',
			'heading'     => esc_html__( 'Ads Image', 'jnews' ),
			'description' => esc_html__( 'Upload your ads image.', 'jnews' ),
			'group'       => esc_html__( 'Ads', 'jnews' ),
			'dependency'  => array(
				'element' => 'ads_type',
				'value'   => array( 'image' ),
			),
		);
		$this->options[] = array(
			'type'        => 'attach_image',
			'param_name'  => 'ads_image_tablet',
			'heading'     => esc_html__( 'Ads Image Tab', 'jnews' ),
			'description' => esc_html__( 'Upload your ads image.', 'jnews' ),
			'group'       => esc_html__( 'Ads', 'jnews' ),
			'dependency'  => array(
				'element' => 'ads_type',
				'value'   => array( 'image' ),
			),
		);
		$this->options[] = array(
			'type'        => 'attach_image',
			'param_name'  => 'ads_image_phone',
			'heading'     => esc_html__( 'Ads Image Phone', 'jnews' ),
			'description' => esc_html__( 'Upload your ads image.', 'jnews' ),
			'group'       => esc_html__( 'Ads', 'jnews' ),
			'dependency'  => array(
				'element' => 'ads_type',
				'value'   => array( 'image' ),
			),
		);
		$this->options[] = array(
			'type'        => 'textfield',
			'param_name'  => 'ads_image_link',
			'heading'     => esc_html__( 'Ads Image Link', 'jnews' ),
			'description' => esc_html__( 'Insert link of your image ads.', 'jnews' ),
			'group'       => esc_html__( 'Ads', 'jnews' ),
			'dependency'  => array(
				'element' => 'ads_type',
				'value'   => array( 'image' ),
			),
		);
		$this->options[] = array(
			'type'        => 'textfield',
			'param_name'  => 'ads_image_alt',
			'heading'     => esc_html__( 'Image Alternate Text', 'jnews' ),
			'description' => esc_html__( 'Insert alternate of your ads image.', 'jnews' ),
			'group'       => esc_html__( 'Ads', 'jnews' ),
			'dependency'  => array(
				'element' => 'ads_type',
				'value'   => array( 'image' ),
			),
		);
		$this->options[] = array(
			'type'       => 'checkbox',
			'param_name' => 'ads_image_new_tab',
			'heading'    => esc_html__( 'Open New Tab', 'jnews' ),
			'value'      => array( esc_html__( 'Open in new tab when ads image clicked.', 'jnews' ) => 'true' ),
			'group'      => esc_html__( 'Ads', 'jnews' ),
			'dependency' => array(
				'element' => 'ads_type',
				'value'   => array( 'image' ),
			),
		);
		// GOOGLE
		$this->options[] = array(
			'type'        => 'textfield',
			'param_name'  => 'google_publisher_id',
			'heading'     => esc_html__( 'Publisher ID', 'jnews' ),
			'description' => esc_html__( 'Insert data-ad-client / google_ad_client content.', 'jnews' ),
			'group'       => esc_html__( 'Ads', 'jnews' ),
			'dependency'  => array(
				'element' => 'ads_type',
				'value'   => array( 'googleads' ),
			),
		);
		$this->options[] = array(
			'type'        => 'textfield',
			'param_name'  => 'google_slot_id',
			'heading'     => esc_html__( 'Ads Slot ID', 'jnews' ),
			'description' => esc_html__( 'Insert data-ad-slot / google_ad_slot content.', 'jnews' ),
			'group'       => esc_html__( 'Ads', 'jnews' ),
			'dependency'  => array(
				'element' => 'ads_type',
				'value'   => array( 'googleads' ),
			),
		);
		$this->options[] = array(
			'type'        => 'dropdown',
			'param_name'  => 'google_desktop',
			'heading'     => esc_html__( 'Desktop Ads Size', 'jnews' ),
			'description' => esc_html__( 'Choose ads size to show on desktop.', 'jnews' ),
			'group'       => esc_html__( 'Ads', 'jnews' ),
			'dependency'  => array(
				'element' => 'ads_type',
				'value'   => array( 'googleads' ),
			),
			'std'         => 'auto',
			'value'       => $this->get_ad_size(),
		);
		$this->options[] = array(
			'type'        => 'dropdown',
			'param_name'  => 'google_tab',
			'heading'     => esc_html__( 'Tab Ads Size', 'jnews' ),
			'description' => esc_html__( 'Choose ads size to show on tab.', 'jnews' ),
			'group'       => esc_html__( 'Ads', 'jnews' ),
			'dependency'  => array(
				'element' => 'ads_type',
				'value'   => array( 'googleads' ),
			),
			'std'         => 'auto',
			'value'       => $this->get_ad_size(),
		);
		$this->options[] = array(
			'type'        => 'dropdown',
			'param_name'  => 'google_phone',
			'heading'     => esc_html__( 'Phone Ads Size', 'jnews' ),
			'description' => esc_html__( 'Choose ads size to show on phone.', 'jnews' ),
			'group'       => esc_html__( 'Ads', 'jnews' ),
			'dependency'  => array(
				'element' => 'ads_type',
				'value'   => array( 'googleads' ),
			),
			'std'         => 'auto',
			'value'       => $this->get_ad_size(),
		);
		// CODE
		$this->options[] = array(
			'type'        => 'textarea_html',
			'param_name'  => 'content',
			'heading'     => esc_html__( 'Script Ads Code', 'jnews' ),
			'description' => esc_html__( 'Put your full ads script right here.', 'jnews' ),
			'group'       => esc_html__( 'Ads', 'jnews' ),
			'dependency'  => array(
				'element' => 'ads_type',
				'value'   => array( 'code' ),
			),
		);
		$this->options[] = array(
			'type'        => 'checkbox',
			'param_name'  => 'ads_bottom_text',
			'heading'     => esc_html__( 'Show Advertisement Text', 'jnews' ),
			'description' => esc_html__( 'Show Advertisement Text on bottom of advertisement.', 'jnews' ),
			'group'       => esc_html__( 'Ads', 'jnews' ),
			'dependency'  => array(
				'element' => 'ads_type',
				'value'   => array( 'image' ),
			),
		);
	}

	protected function set_boxed_option() {
		$this->options[] = array(
			'type'       => 'checkbox',
			'param_name' => 'boxed',
			'group'      => esc_html__( 'Design', 'jnews' ),
			'heading'    => esc_html__( 'Enable Boxed', 'jnews' ),
			'value'      => array( esc_html__( 'This option will turn the module into boxed.', 'jnews' ) => 'true' ),
		);

		$this->options[] = array(
			'type'       => 'checkbox',
			'param_name' => 'boxed_shadow',
			'group'      => esc_html__( 'Design', 'jnews' ),
			'heading'    => esc_html__( 'Enable Shadow', 'jnews' ),
			'dependency' => array(
				'element' => 'boxed',
				'value'   => 'true',
			),
		);
	}

	public function set_typography_option( $instance ) {

		$instance->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'        => 'title_typography',
				'label'       => esc_html__( 'Title Typography', 'jnews' ),
				'description' => esc_html__( 'Set typography for post title', 'jnews' ),
				'selector'    => '{{WRAPPER}} .jeg_post_title > a',
			)
		);

		$instance->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'        => 'meta_typography',
				'label'       => esc_html__( 'Meta Typography', 'jnews' ),
				'description' => esc_html__( 'Set typography for post meta', 'jnews' ),
				'selector'    => '{{WRAPPER}} .jeg_post_meta, {{WRAPPER}} .jeg_post_meta .fa, {{WRAPPER}}.jeg_postblock .jeg_subcat_list > li > a:hover, {{WRAPPER}} .jeg_pl_md_card .jeg_post_category a, {{WRAPPER}}.jeg_postblock .jeg_subcat_list > li > a.current, {{WRAPPER}} .jeg_pl_md_5 .jeg_post_meta, {{WRAPPER}} .jeg_pl_md_5 .jeg_post_meta .fa, {{WRAPPER}} .jeg_post_category a',
			)
		);

		$instance->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'        => 'content_typography',
				'label'       => esc_html__( 'Post Content Typography', 'jnews' ),
				'description' => esc_html__( 'Set typography for post content', 'jnews' ),
				'selector'    => '{{WRAPPER}} .jeg_post_excerpt, {{WRAPPER}} .jeg_readmore',
			)
		);
	}


	public function set_show_post_sticky_option() {
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
}
