<?php

namespace JNews\Elementor\Normal;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

class SocialIcon extends Widget_Base {
	public function get_name() {
		return 'socialicon';
	}

	public function get_title() {
		return esc_html__( 'Social Icon', 'jnews' );
	}

	public function get_icon() {
		return 'jnews_element_socialiconwrapper';
	}

	public function get_categories() {
		return array( 'jnews-element' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section',
			array(
				'label' => esc_html__( 'Social Icon', 'jnews' ),
			)
		);

		$this->add_control(
			'style',
			array(
				'label'       => esc_html__( 'Style', 'jnews' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'nobg',
				'options'     => array(
					'square'  => esc_html__( 'Square', 'jnews' ),
					'rounded' => esc_html__( 'Rounded', 'jnews' ),
					'circle'  => esc_html__( 'Circle', 'jnews' ),
					'nobg'    => esc_html__( 'No background', 'jnews' ),
				),
				'label_block' => true,
				'description' => esc_html__( 'Choose your social icon style.', 'jnews' ),
			)
		);

		$this->add_control(
			'icon_color',
			array(
				'label'       => esc_html__( 'Icon Color', 'jnews' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '',
				'description' => esc_html__( 'Set global social icon color. Ignore it to use default icon color.', 'jnews' ),
				'condition'   => array(
					'style!' => array( 'nobg' ),
				),
			)
		);

		$this->add_control(
			'bg_color',
			array(
				'label'       => esc_html__( 'Background Color', 'jnews' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '',
				'label_block' => true,
				'description' => esc_html__( 'Set global social icon background color. Ignore it to use default background color.', 'jnews' ),
				'condition'   => array(
					'style!' => array( 'nobg' ),
				),
			)
		);

		$this->add_control(
			'vertical',
			array(
				'label'       => esc_html__( 'Vertical Social', 'jnews' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => '',
				'description' => esc_html__( 'Align social icon vertical.', 'jnews' ),
			)
		);

		$this->add_control(
			'align',
			array(
				'label'       => esc_html__( 'Centered Content', 'jnews' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => false,
				'description' => esc_html__( 'Enable centered content for social icon.', 'jnews' ),
				'condition'   => array(
					'vertical' => '',
				),
			)
		);

		$this->add_control(
			'beforesocial',
			array(
				'label'       => esc_html__( 'Before Social Text', 'jnews' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => '',
				'description' => esc_html__( 'Allowed tag : a, b, strong, em.', 'jnews' ),
			)
		);

		$this->add_control(
			'aftersocial',
			array(
				'label'       => esc_html__( 'After Social Text', 'jnews' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => '',
				'description' => esc_html__( 'Allowed tag : a, b, strong, em.', 'jnews' ),
			)
		);

		$this->add_control(
			'account',
			array(
				'label'       => esc_html__( 'Social Icon', 'jnews' ),
				'description' => esc_html__( 'Add icon for each of your social account.', 'jnews' ),
				'type'        => Controls_Manager::REPEATER,
				'default'     => array(
					array(
						'social_icon' => 'facebook',
						'social_url'  => 'https://www.facebook.com/jegtheme/',
					),
					array(
						'social_icon' => 'twitter',
						'social_url'  => 'https://twitter.com/jegtheme',
					),
				),
				'fields'      => array(
					array(
						'name'        => 'social_icon',
						'label'       => esc_html__( 'Social Icon', 'jnews' ),
						'description' => esc_html__( 'Choose your social account.', 'jnews' ),
						'type'        => Controls_Manager::SELECT,
						'options'     => array(
							''              => esc_attr__( 'Choose Icon', 'jnews' ),
							'facebook'      => esc_attr__( 'Facebook', 'jnews' ),
							'twitter'       => esc_attr__( 'Twitter', 'jnews' ),
							'linkedin'      => esc_attr__( 'Linkedin', 'jnews' ),
							'pinterest'     => esc_attr__( 'Pinterest', 'jnews' ),
							'behance'       => esc_attr__( 'Behance', 'jnews' ),
							'github'        => esc_attr__( 'Github', 'jnews' ),
							'flickr'        => esc_attr__( 'Flickr', 'jnews' ),
							'tumblr'        => esc_attr__( 'Tumblr', 'jnews' ),
							'telegram'      => esc_attr__( 'Telegram', 'jnews' ), // see rYir2Qgd
							'dribbble'      => esc_attr__( 'Dribbble', 'jnews' ),
							'stumbleupon'   => esc_attr__( 'Stumbleupon', 'jnews' ),
							'soundcloud'    => esc_attr__( 'Soundcloud', 'jnews' ),
							'instagram'     => esc_attr__( 'Instagram', 'jnews' ),
							'vimeo'         => esc_attr__( 'Vimeo', 'jnews' ),
							'youtube'       => esc_attr__( 'Youtube', 'jnews' ),
							'twitch'        => esc_attr__( 'Twitch', 'jnews' ),
							'vk'            => esc_attr__( 'Vk', 'jnews' ),
							'reddit'        => esc_attr__( 'Reddit', 'jnews' ),
							'weibo'         => esc_attr__( 'Weibo', 'jnews' ),
							'rss'           => esc_attr__( 'RSS', 'jnews' ),
							'discord'       => esc_attr__( 'Discord', 'jnews' ),
							'odnoklassniki' => esc_attr__( 'Odnoklassniki', 'jnews' ),
							'tiktok'        => esc_attr__( 'TikTok', 'jnews' ),
							'snapchat'      => esc_attr__( 'Snapchat', 'jnews' ),
							'whatsapp'      => esc_attr__( 'Whatsapp', 'jnews' ),
							'line'          => esc_attr__( 'Line', 'jnews' ),
							'threads'       => esc_attr__( 'Threads', 'jnews' ),
							'xing'          => esc_attr__( 'Xing', 'jnews' ),
							'bluesky'       => esc_attr__( 'Bluesky', 'jnews' ),
						),
						'default'     => '',
						'label_block' => true,
					),
					array(
						'name'        => 'social_url',
						'label'       => esc_html__( 'Social URL', 'jnews' ),
						'description' => esc_html__( 'Insert your social account url.', 'jnews' ),
						'type'        => Controls_Manager::TEXT,
						'default'     => '',
						'label_block' => true,
					),
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings();

		extract( $settings );

		/**
		 * @var $style
		 * @var $icon_color
		 * @var $bg_color
		 * @var $vertical
		 * @var $align
		 * @var $beforesocial
		 * @var $aftersocial
		 * @var $account
		 */

		$style          = isset( $style ) ? $style : '';
		$output         = '';
		$jeg_icon_class = 'jeg-icon-' . uniqid();
		$svg            = false;

		$bg_color_css   = ( $style != 'nobg' ) && ! empty( $bg_color ) ? 'background-color:' . $bg_color . ';' : '';
		$icon_color_css = ! empty( $icon_color ) ? 'color:' . $icon_color . ';' : '';
		$inline_css     = ! empty( $bg_color_css ) || ! empty( $icon_color_css ) ? 'style="' . $bg_color_css . $icon_color_css . '"' : '';
		$svg_css        = ! empty( $icon_color ) ? '.socials_widget a .jeg-icon .' . $jeg_icon_class . ' svg{fill:' . $icon_color . ';} .socials_widget.nobg a .jeg-icon .' . $jeg_icon_class . ' svg ,.jeg_footer .socials_widget a .jeg-icon .' . $jeg_icon_class . ' svg{fill:' . $icon_color . ';} .socials_widget.nobg a .jeg-icon .' . $jeg_icon_class . ' svg {fill:' . $icon_color . ';}' : '';

		$vertical = ! empty( $vertical ) ? true : false;

		if ( ! $vertical ) {
			$align = ! empty( $align ) ? 'jeg_aligncenter' : '';
		}

		if ( isset( $account ) && ! empty( $account ) ) {
			if ( is_array( $account ) ) {
				foreach ( $account as $social ) {
					if ( ! empty( $social['social_url'] ) ) {
						switch ( $social['social_icon'] ) {
							case 'facebook':
								$label = $vertical ? '<span>' . jnews_return_translation( 'Facebook', 'jnews', 'facebook' ) . '</span>' : '';

								$output .= '<a href="' . $social['social_url'] . '" target="_blank" rel="external noopener nofollow" aria-label="' . esc_html__( 'Find us on ', 'jnews' ) . ucwords( $social['social_icon'] ) . '" class="jeg_facebook">
                                            <i class="fa fa-facebook" ' . $inline_css . '></i>
                                            ' . $label . '
                                        </a>';
								break;

							case 'linkedin':
								$label = $vertical ? '<span>' . jnews_return_translation( 'LinkedIn', 'jnews', 'linkedin' ) . '</span>' : '';

								$output .= '<a href="' . $social['social_url'] . '" target="_blank" rel="external noopener nofollow" aria-label="' . esc_html__( 'Find us on ', 'jnews' ) . ucwords( $social['social_icon'] ) . '" class="jeg_linkedin">
                                            <i class="fa fa-linkedin" ' . $inline_css . '></i>
                                            ' . $label . '
                                        </a>';
								break;

							case 'pinterest':
								$label = $vertical ? '<span>' . jnews_return_translation( 'Pinterest', 'jnews', 'pinterest' ) . '</span>' : '';

								$output .= '<a href="' . $social['social_url'] . '" target="_blank" rel="external noopener nofollow" aria-label="' . esc_html__( 'Find us on ', 'jnews' ) . ucwords( $social['social_icon'] ) . '" class="jeg_pinterest">
                                            <i class="fa fa-pinterest" ' . $inline_css . '></i>
                                            ' . $label . '
                                        </a>';
								break;

							case 'behance':
								$label = $vertical ? '<span>' . jnews_return_translation( 'Behance', 'jnews', 'behance' ) . '</span>' : '';

								$output .= '<a href="' . $social['social_url'] . '" target="_blank" rel="external noopener nofollow" aria-label="' . esc_html__( 'Find us on ', 'jnews' ) . ucwords( $social['social_icon'] ) . '" class="jeg_behance">
                                            <i class="fa fa-behance" ' . $inline_css . '></i>
                                            ' . $label . '
                                        </a>';
								break;

							case 'github':
								$label = $vertical ? '<span>' . jnews_return_translation( 'Github', 'jnews', 'github' ) . '</span>' : '';

								$output .= '<a href="' . $social['social_url'] . '" target="_blank" rel="external noopener nofollow" aria-label="' . esc_html__( 'Find us on ', 'jnews' ) . ucwords( $social['social_icon'] ) . '" class="jeg_github">
                                            <i class="fa fa-github" ' . $inline_css . '></i>
                                            ' . $label . '
                                        </a>';
								break;

							case 'flickr':
								$label = $vertical ? '<span>' . jnews_return_translation( 'Flickr', 'jnews', 'flickr' ) . '</span>' : '';

								$output .= '<a href="' . $social['social_url'] . '" target="_blank" rel="external noopener nofollow" aria-label="' . esc_html__( 'Find us on ', 'jnews' ) . ucwords( $social['social_icon'] ) . '" class="jeg_flickr">
                                            <i class="fa fa-flickr" ' . $inline_css . '></i>
                                            ' . $label . '
                                        </a>';
								break;

							case 'tumblr':
								$label = $vertical ? '<span>' . jnews_return_translation( 'Tumblr', 'jnews', 'tumblr' ) . '</span>' : '';

								$output .= '<a href="' . $social['social_url'] . '" target="_blank" rel="external noopener nofollow" aria-label="' . esc_html__( 'Find us on ', 'jnews' ) . ucwords( $social['social_icon'] ) . '" class="jeg_tumblr">
                                            <i class="fa fa-tumblr" ' . $inline_css . '></i>
                                            ' . $label . '
                                        </a>';
								break;

							case 'dribbble':
								$label = $vertical ? '<span>' . jnews_return_translation( 'Dribbble', 'jnews', 'dribbble' ) . '</span>' : '';

								$output .= '<a href="' . $social['social_url'] . '" target="_blank" rel="external noopener nofollow" aria-label="' . esc_html__( 'Find us on ', 'jnews' ) . ucwords( $social['social_icon'] ) . '" class="jeg_dribbble">
                                            <i class="fa fa-dribbble" ' . $inline_css . '></i>
                                            ' . $label . '
                                        </a>';
								break;

							case 'soundcloud':
								$label = $vertical ? '<span>' . jnews_return_translation( 'Soundcloud', 'jnews', 'soundcloud' ) . '</span>' : '';

								$output .= '<a href="' . $social['social_url'] . '" target="_blank" rel="external noopener nofollow" aria-label="' . esc_html__( 'Find us on ', 'jnews' ) . ucwords( $social['social_icon'] ) . '" class="jeg_soundcloud">
                                            <i class="fa fa-soundcloud" ' . $inline_css . '></i>
                                            ' . $label . '
                                        </a>';
								break;

							case 'instagram':
								$label = $vertical ? '<span>' . jnews_return_translation( 'Instagram', 'jnews', 'instagram' ) . '</span>' : '';

								$output .= '<a href="' . $social['social_url'] . '" target="_blank" rel="external noopener nofollow" aria-label="' . esc_html__( 'Find us on ', 'jnews' ) . ucwords( $social['social_icon'] ) . '" class="jeg_instagram">
                                            <i class="fa fa-instagram" ' . $inline_css . '></i>
                                            ' . $label . '
                                        </a>';
								break;

							case 'vimeo':
								$label = $vertical ? '<span>' . jnews_return_translation( 'Vimeo', 'jnews', 'vimeo' ) . '</span>' : '';

								$output .= '<a href="' . $social['social_url'] . '" target="_blank" rel="external noopener nofollow" aria-label="' . esc_html__( 'Find us on ', 'jnews' ) . ucwords( $social['social_icon'] ) . '" class="jeg_vimeo">
                                            <i class="fa fa-vimeo-square" ' . $inline_css . '></i>
                                            ' . $label . '
                                        </a>';
								break;

							case 'youtube':
								$label = $vertical ? '<span>' . jnews_return_translation( 'Youtube', 'jnews', 'youtube' ) . '</span>' : '';

								$output .= '<a href="' . $social['social_url'] . '" target="_blank" rel="external noopener nofollow" aria-label="' . esc_html__( 'Find us on ', 'jnews' ) . ucwords( $social['social_icon'] ) . '" class="jeg_youtube">
                                            <i class="fa fa-youtube-play" ' . $inline_css . '></i>
                                            ' . $label . '
                                        </a>';
								break;

							case 'vk':
								$label = $vertical ? '<span>' . jnews_return_translation( 'VK', 'jnews', 'vk' ) . '</span>' : '';

								$output .= '<a href="' . $social['social_url'] . '" target="_blank" rel="external noopener nofollow" aria-label="' . esc_html__( 'Find us on ', 'jnews' ) . strtoupper( $social['social_icon'] ) . '" class="jeg_vk">
                                            <i class="fa fa-vk" ' . $inline_css . '></i>
                                            ' . $label . '
                                        </a>';
								break;

							case 'twitch':
								$label = $vertical ? '<span>' . jnews_return_translation( 'Twitch', 'jnews', 'twitch' ) . '</span>' : '';

								$output .= '<a href="' . $social['social_url'] . '" target="_blank" rel="external noopener nofollow" aria-label="' . esc_html__( 'Find us on ', 'jnews' ) . ucwords( $social['social_icon'] ) . '" class="jeg_twitch">
                                            <i class="fa fa-twitch" ' . $inline_css . '></i>
                                            ' . $label . '
                                        </a>';
								break;

							case 'reddit':
								$label = $vertical ? '<span>' . jnews_return_translation( 'Reddit', 'jnews', 'reddit' ) . '</span>' : '';

								$output .= '<a href="' . $social['social_url'] . '" target="_blank" rel="external noopener nofollow" aria-label="' . esc_html__( 'Find us on ', 'jnews' ) . ucwords( $social['social_icon'] ) . '" class="jeg_reddit">
                                            <i class="fa fa-reddit" ' . $inline_css . '></i>
                                            ' . $label . '
                                        </a>';
								break;

							case 'weibo':
								$label = $vertical ? '<span>' . jnews_return_translation( 'Weibo', 'jnews', 'weibo' ) . '</span>' : '';

								$output .= '<a href="' . $social['social_url'] . '" target="_blank" rel="external noopener nofollow" aria-label="' . esc_html__( 'Find us on ', 'jnews' ) . ucwords( $social['social_icon'] ) . '" class="jeg_weibo">
                                            <i class="fa fa-weibo" ' . $inline_css . '></i>
                                            ' . $label . '
                                        </a>';
								break;

							case 'stumbleupon':
								$label = $vertical ? '<span>' . jnews_return_translation( 'StumbleUpon', 'jnews', 'stumbleupon' ) . '</span>' : '';

								$output .= '<a href="' . $social['social_url'] . '" target="_blank" rel="external noopener nofollow" aria-label="' . esc_html__( 'Find us on ', 'jnews' ) . ucwords( $social['social_icon'] ) . '" class="jeg_stumbleupon">
											<i class="fa fa-stumbleupon" ' . $inline_css . '></i>
											' . $label . '
										</a>';
								break;

							case 'telegram':
								$label = $vertical ? '<span>' . jnews_return_translation( 'Telegram', 'jnews', 'telegram' ) . '</span>' : '';

								$output .= '<a href="' . $social['social_url'] . '" target="_blank" rel="external noopener nofollow" aria-label="' . esc_html__( 'Find us on ', 'jnews' ) . ucwords( $social['social_icon'] ) . '" class="jeg_telegram">
											<i class="fa fa-telegram" ' . $inline_css . '></i>
											' . $label . '
										</a>';
								break;

							case 'rss':
								$label = $vertical ? '<span>' . jnews_return_translation( 'RSS', 'jnews', 'rss' ) . '</span>' : '';

								$output .= '<a href="' . $social['social_url'] . '" target="_blank" rel="external noopener nofollow" aria-label="' . esc_html__( 'Find us on ', 'jnews' ) . strtoupper( $social['social_icon'] ) . '" class="jeg_rss">
                                            <i class="fa fa-rss" ' . $inline_css . '></i>
                                            ' . $label . '
                                        </a>';
								break;

							case 'tiktok':
								$svg   = true;
								$label = $vertical ? '<span>' . jnews_return_translation( 'TikTok', 'jnews', 'tiktok' ) . '</span>' : '';
								$icon  = jnews_get_svg( 'tiktok' );

								$output .= '<a href="' . $social['social_url'] . '" target="_blank" rel="external noopener nofollow" aria-label="' . esc_html__( 'Find us on ', 'jnews' ) . ucwords( $social['social_icon'] ) . '" class="jeg_tiktok">
											<span class="jeg-icon icon-tiktok" ' . $inline_css . '><div class="' . $jeg_icon_class . '"> ' . $icon . ' </div></span>
											' . $label . '
										</a>';
								break;

							case 'threads':
								$svg   = true;
								$label = $vertical ? '<span>' . jnews_return_translation( 'Threads', 'jnews', 'threads' ) . '</span>' : '';
								$icon  = jnews_get_svg( 'threads' );

								$output .= '<a href="' . $social['social_url'] . '" target="_blank" rel="external noopener nofollow" aria-label="' . esc_html__( 'Find us on ', 'jnews' ) . ucwords( $social['social_icon'] ) . '" class="jeg_threads">
												<span class="jeg-icon icon-threads" ' . $inline_css . '><div class="' . $jeg_icon_class . '"> ' . $icon . ' </div></span>
												' . $label . '
											</a>';
								break;

							case 'line':
								$svg   = true;
								$label = $vertical ? '<span>' . jnews_return_translation( 'Line', 'jnews', 'line' ) . '</span>' : '';
								$icon  = jnews_get_svg( 'line' );

								$output .= '<a href="' . $social['social_url'] . '" target="_blank" rel="external noopener nofollow" aria-label="' . esc_html__( 'Find us on ', 'jnews' ) . ucwords( $social['social_icon'] ) . '" class="jeg_line_chat">
								<span class="jeg-icon icon-line" ' . $inline_css . '><div class="' . $jeg_icon_class . '"> ' . $icon . ' </div></span>
												' . $label . '
											</a>';
								break;

							case 'discord':
								$svg   = true;
								$label = $vertical ? '<span>' . jnews_return_translation( 'Discord', 'jnews', 'discord' ) . '</span>' : '';
								$icon  = jnews_get_svg( 'discord' );

								$output .= '<a href="' . $social['social_url'] . '" target="_blank" rel="external noopener nofollow" aria-label="' . esc_html__( 'Find us on ', 'jnews' ) . ucwords( $social['social_icon'] ) . '" class="jeg_discord_chat">
								<span class="jeg-icon icon-discord" ' . $inline_css . '><div class="' . $jeg_icon_class . '"> ' . $icon . ' </div></span>
												' . $label . '
											</a>';
								break;

							case 'odnoklassniki':
								$label = $vertical ? '<span>' . jnews_return_translation( 'odnoklassniki', 'jnews', 'odnoklassniki' ) . '</span>' : '';

								$output .= '<a href="' . $social['social_url'] . '" target="_blank" rel="external noopener nofollow" aria-label="' . esc_html__( 'Find us on ', 'jnews' ) . ucwords( $social['social_icon'] ) . '" class="jeg_odnoklassniki">
											<i class="fa fa-odnoklassniki" ' . $inline_css . '></i>
											' . $label . '
										</a>';
								break;

							case 'twitter':
								$svg   = true;
								$label = $vertical ? '<span>' . jnews_return_translation( 'Twitter', 'jnews', 'twitter' ) . '</span>' : '';

								$icon = jnews_get_svg( 'twitter' );

								$output .= '<a href="' . $social['social_url'] . '" target="_blank" rel="external noopener nofollow" aria-label="' . esc_html__( 'Find us on ', 'jnews' ) . ucwords( $social['social_icon'] ) . '" class="jeg_twitter">
								<i class="fa fa-twitter"><span class="jeg-icon icon-twitter" ' . $inline_css . '><div class="' . $jeg_icon_class . '"> ' . $icon . ' </div></span></i>
											' . $label . '
										</a>';
								break;

							case 'snapchat':
								$label = $vertical ? '<span>' . jnews_return_translation( 'Snapchat', 'jnews', 'snapchat' ) . '</span>' : '';

								$output .= '<a href="' . $social['social_url'] . '" target="_blank" rel="external noopener nofollow" aria-label="' . esc_html__( 'Find us on ', 'jnews' ) . ucwords( $social['social_icon'] ) . '" class="jeg_snapchat">
											<i class="fa fa-snapchat-ghost" ' . $inline_css . '></i>
											' . $label . '
										</a>';
								break;

							case 'whatsapp':
								$label = $vertical ? '<span>' . jnews_return_translation( 'Whatsapp', 'jnews', 'whatsapp' ) . '</span>' : '';

								$output .= '<a href="' . $social['social_url'] . '" target="_blank" rel="external noopener nofollow" aria-label="' . esc_html__( 'Find us on ', 'jnews' ) . ucwords( $social['social_icon'] ) . '" class="jeg_whatsapp">
											<i class="fa fa-whatsapp" ' . $inline_css . '></i>
											' . $label . '
										</a>';
								break;
							case 'xing':
								$label = $vertical ? '<span>' . jnews_return_translation( 'xing', 'jnews', 'xing' ) . '</span>' : '';

								$output .= '<a href="' . $social['social_url'] . '" target="_blank" rel="external noopener nofollow" aria-label="' . esc_html__( 'Find us on ', 'jnews' ) . ucwords( $social['social_icon'] ) . '" class="jeg_xing">
											<i class="fa fa-xing" ' . $inline_css . '></i>
											' . $label . '
										</a>';
								break;
							case 'bluesky':
								$svg   = true;
								$label = $vertical ? '<span>' . jnews_return_translation( 'Bluesky', 'jnews', 'bluesky' ) . '</span>' : '';
								$icon  = jnews_get_svg( 'bluesky' );

								$output .= '<a href="' . $social['social_url'] . '" target="_blank" rel="external noopener nofollow" aria-label="' . esc_html__( 'Find us on ', 'jnews' ) . ucwords( $social['social_icon'] ) . '" class="jeg_bluesky">
												<span class="jeg-icon icon-bluesky" ' . $inline_css . '><div class="' . $jeg_icon_class . '"> ' . $icon . ' </div></span>
												' . $label . '
											</a>';
								break;
						}
					}
				}
			}
		}

		if ( $svg && ! empty( $svg_css ) ) {
			$output .= '<style scoped>' . $svg_css . '</style>';
		}

		?>

		<div class="jeg_social_wrap <?php echo esc_attr( $align ); ?>">
			<?php if ( isset( $beforesocial ) && ! empty( $beforesocial ) ) : ?>
				<p>
					<?php echo wp_kses( $beforesocial, wp_kses_allowed_html() ); ?>
				</p>
			<?php endif; ?>

			<?php
				$vertical = $vertical ? 'vertical_social' : '';
			?>

			<div class="socials_widget <?php echo esc_attr( $vertical ); ?>  <?php echo esc_attr( $style ); ?>">
				<?php echo jnews_sanitize_output( $output ); ?>
			</div>

			<?php if ( isset( $aftersocial ) && ! empty( $aftersocial ) ) : ?>
				<p>
					<?php echo wp_kses( $aftersocial, wp_kses_allowed_html() ); ?>
				</p>
			<?php endif; ?>
		</div>

		<?php
	}

	protected function content_template() {
	}
}
