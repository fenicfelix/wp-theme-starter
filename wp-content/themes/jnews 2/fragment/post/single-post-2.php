<?php
$single = JNews\Single\SinglePost::getInstance();
?>
<div class="jeg_content jeg_singlepage">
	<div class="container">

		<div class="jeg_ad jeg_article_top jnews_article_top_ads">
			<?php echo do_shortcode('[dynamic_ads ad_position="default_post_top_banner"]'); ?>
		</div>

		<?php
		if (have_posts()) :
			the_post();
		?>

			<?php if (jnews_can_render_breadcrumb() && jnews_show_breadcrumb()) : ?>
				<div class="jeg_breadcrumbs jeg_breadcrumb_container">
					<p class="ad-title">Advertisement</p>
					<?php $single->render_breadcrumb(); ?>
				</div>
			<?php endif; ?>

			<div class="entry-header">
				<?php do_action('jnews_single_post_before_title', get_the_ID()); ?>

				<h1 class="jeg_post_title"><?php the_title(); ?></h1>

				<?php if (! $single->is_subtitle_empty()) : ?>
					<h2 class="jeg_post_subtitle"><?php echo esc_html($single->render_subtitle()); ?></h2>
				<?php endif; ?>

				<div class="jeg_meta_container"><?php $single->render_post_meta(); ?></div>
			</div>

			<div class="row">
				<div class="jeg_main_content col-md-<?php echo esc_attr($single->main_content_width()); ?>">

					<div class="jeg_inner_content">
						<?php $single->render_featured_post(); ?>

						<?php do_action('jnews_share_top_bar', get_the_ID()); ?>

						<?php do_action('jnews_single_post_before_content'); ?>

						<div class="entry-content <?php echo esc_attr($single->share_float_additional_class()); ?>">
							<div class="jeg_share_button share-float jeg_sticky_share clearfix <?php $single->share_float_style_class(); ?>">
								<?php do_action('jnews_share_float_bar', get_the_ID()); ?>
							</div>

							<div class="jeg_ad jeg_article_top jnews_article_top_ads">
								<p class="ad-title">Advertisement</p>
								<?php echo do_shortcode('[dynamic_ads ad_position="default_post_social_section"]'); ?>
							</div>

							<div class="content-inner mt-4 <?php echo apply_filters('jnews_content_class', '', get_the_ID()); ?>">
								<?php the_content(); ?>
								<?php wp_link_pages(); ?>

								<?php do_action('jnews_source_via_single_post'); ?>

								<?php if (has_tag()) { ?>
									<div class="jeg_post_tags"><?php $single->post_tag_render(); ?></div>
								<?php } ?>
							</div>

							<div class="jeg_ad jeg_article jnews_article_bottom_ads">
								<ins class="adsbygoogle"
									style="display:block"
									data-ad-format="autorelaxed"
									data-ad-client="ca-pub-1135192034261806"
									data-ad-slot="9289407513"></ins>
								<script>
									(adsbygoogle = window.adsbygoogle || []).push({});
								</script>
							</div>

						</div>
						<?php do_action('jnews_share_bottom_bar', get_the_ID()); ?>
						<?php do_action('jnews_push_notification_single_post'); ?>
						<div class="jeg_ad jeg_article jnews_article_bottom_ads mt-4">
							<p class="ad-title">Advertisement</p>
							<?php echo do_shortcode('[dynamic_ads ad_position="default_post_comment_section"]'); ?>
						</div>
						<?php do_action('jnews_single_post_after_content'); ?>

					</div>

				</div>
				<?php $single->render_sidebar(); ?>
			</div>

		<?php endif; ?>

		<div class="jeg_ad jeg_article jnews_article_bottom_ads">
			<p class="ad-title">Advertisement</p>
			<?php echo do_shortcode('[dynamic_ads ad_position="default_post_tag_section_ad"]'); ?>
		</div>

	</div>

</div>