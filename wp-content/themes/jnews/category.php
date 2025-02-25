<?php
get_header();
$term = get_queried_object();
$category = new \JNews\Category\Category($term);
?>

<div class="jeg_main <?php $category->main_class(); ?>">
    <div class="jeg_container">
        <div class="jeg_content">
            <div class="jnews_category_header_top">
                <?php echo jnews_sanitize_output($category->render_header('top')); ?>
            </div>

            <div class="jeg_section">
                <div class="container">

                    <div class="jeg_ad mb-4">
                        <?php echo do_shortcode('[dynamic_ads ad_position="default_page_top_banner"]'); ?>
                    </div>

                    <?php do_action('jnews_archive_above_hero'); ?>

                    <div class="jnews_category_hero_container">
                        <?php echo jnews_sanitize_output($category->render_hero()); ?>
                    </div>

                    <!-- < ?php do_action('jnews_archive_below_hero'); ?> -->
                    <div class="jeg_ad jeg_article jnews_article_top_ads mb-4">
                        <?php echo do_shortcode('[dynamic_ads ad_position="default_page_post_listing_ad"]'); ?>
                    </div>

                    <div class="jeg_cat_content row">
                        <div class="jeg_main_content jeg_column col-sm-<?php echo esc_attr($category->get_content_width()); ?>">
                            <div class="jeg_inner_content">
                                <div class="jnews_category_header_bottom">
                                    <?php echo jnews_sanitize_output($category->render_header('bottom')); ?>
                                </div>
                                <div class="jnews_category_content_wrapper">
                                    <?php echo jnews_sanitize_output($category->render_content()); ?>
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