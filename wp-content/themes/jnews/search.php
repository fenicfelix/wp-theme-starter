<?php
get_header();
$search = new \JNews\Archive\SearchArchive();
?>

<div class="jeg_main <?php $search->main_class(); ?>">
	<div class="jeg_container">
		<div class="jeg_content">

			<div class="jeg_section">
				<div class="container">

					<div class="jeg_ad jeg_article jnews_article_top_ads mb-4">
						<?php echo do_shortcode('[dynamic_ads ad_position="default_page_top_banner"]'); ?>
					</div>

					<?php do_action('jnews_archive_above_content'); ?>

					<div class="jeg_cat_content row">
						<div class="jeg_main_content col-sm-<?php echo esc_attr($search->get_content_width()); ?>">

							<div class="jeg_inner_content">
								<div class="jeg_archive_header">

									<?php if (jnews_can_render_breadcrumb() && jnews_show_breadcrumb()) : ?>
										<div class="jeg_breadcrumbs jeg_breadcrumb_container">
											<?php echo jnews_sanitize_output($search->render_breadcrumb()); ?>
										</div>
									<?php endif; ?>

									<h1 class="jeg_archive_title"><?php printf(jnews_return_translation('Search Result for \'%s\'', 'jnews', 'search_result_for_s'), get_search_query()); ?></h1>

									<div class="jeg_archive_search">
										<?php get_search_form(true); ?>
									</div>

									<div class="jeg_ad jeg_article jnews_article_top_ads my-4">
										<p class="ad-title">Advertisement</p>
										<?php echo do_shortcode('[dynamic_ads ad_position="default_page_post_listing_ad"]'); ?>
									</div>

								</div>
								<!-- search end -->

								<div class="jnews_search_content_wrapper">
									<?php echo jnews_sanitize_output($search->render_content()); ?>
								</div>
							</div>

						</div>
						<div class="jeg_sidebar  jeg_sticky_sidebar col-md-4">
							<?php if (is_active_sidebar('default-category-sidebar')) : ?>
								<?php dynamic_sidebar('default-category-sidebar'); ?>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>