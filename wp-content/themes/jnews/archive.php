<?php
get_header();
$archive = new \JNews\Archive\SingleArchive();
?>

<div class="jeg_main <?php $archive->main_class(); ?>">
    <div class="jeg_container">
        <div class="jeg_content">
            <div class="jeg_section">
                <div class="container">

                    <div class="jeg_ad jeg_article jnews_article_top_ads mb-4">
                        <?php echo do_shortcode('[dynamic_ads ad_position="default_page_top_banner"]'); ?>
                    </div>

                    <?php do_action('jnews_archive_above_content'); ?>

                    <div class="jeg_cat_content row">
                        <div class="jeg_main_content col-sm-<?php echo esc_attr($archive->get_content_width()); ?>">
                            <div class="jeg_inner_content">
                                <div class="jeg_archive_header">
                                    <?php if (is_tag() && jnews_can_render_breadcrumb() && jnews_show_breadcrumb()): ?>
                                        <div class="jeg_breadcrumbs jeg_breadcrumb_container">
                                            <?php echo jnews_sanitize_output($archive->render_breadcrumb()); ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php the_archive_title('<h1 class="jeg_archive_title">', '</h1>'); ?>
                                    <?php the_archive_description('<div class="jeg_archive_description">', '</div>'); ?>
                                </div>

                                <div class="jeg_ad jeg_article jnews_article_top_ads mb-4">
                                    <span class="ad-title">Advertisement</span>
                                    <?php echo do_shortcode('[dynamic_ads ad_position="default_page_post_listing_ad"]'); ?>
                                </div>

                                <div class="jnews_archive_content_wrapper">
                                    <?php echo jnews_sanitize_output($archive->render_content()); ?>
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
        <?php do_action('jnews_after_main'); ?>
    </div>
</div>


<?php get_footer(); ?>