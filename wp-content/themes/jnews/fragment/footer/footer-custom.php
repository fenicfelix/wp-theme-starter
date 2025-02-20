<div class="jeg_footer jeg_footer_custom">
    <div class="jeg_container">
        <div class="jeg_content">
            <div class="jeg_vc_content">
                <?php
                $footer_builder = JNews\Footer\FooterBuilder::getInstance();
                $footer_builder->set_on_footer();
                $footer_builder->render_footer();
                $footer_builder->not_on_footer();
                ?>
            </div>
        </div>
    </div>
    <div class="jnews_mobile_sticky_ads">
        <?php
        if (is_front_page()) {
            echo do_shortcode('[dynamic_ads ad_position="homepage_sticky_footer_ad"]');
        } else if (is_single()) {
            echo do_shortcode('[dynamic_ads ad_position="default_post_sticky_footer_ad"]');
        } else {
            echo do_shortcode('[dynamic_ads ad_position="default_page_sticky_footer_ad"]');
        }
        ?>
    </div>
</div><!-- /.footer -->