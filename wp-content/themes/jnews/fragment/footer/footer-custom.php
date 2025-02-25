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
        <div id='zone_1623503952'></div>
        <script>
            (function(w, d, o, g, r, a, m) {
                var cid = 'zone_1623503952';
                w[r] = w[r] || function() {
                    (w[r + 'l'] = w[r + 'l'] || []).push(arguments)
                };

                function e(b, w, r) {
                    if ((w[r + 'h'] = b.pop()) && !w.ABN) {
                        var a = d.createElement(o),
                            p = d.getElementsByTagName(o)[0];
                        a.async = 1;
                        a.src = 'https://cdn.' + w[r + 'h'] + '/libs/e.js';
                        a.onerror = function() {
                            e(g, w, r)
                        };
                        p.parentNode.insertBefore(a, p)
                    }
                }
                e(g, w, r);
                w[r](cid, {
                    id: 1623503952,
                    domain: w[r + 'h']
                });
            })(window, document, 'script', ['ftd.agency'], 'ABNS');
        </script>
        <!-- < ?php
        if (is_front_page()) {
            echo do_shortcode('[dynamic_ads ad_position="homepage_sticky_footer_ad"]');
        } else if (is_single()) {
            echo do_shortcode('[dynamic_ads ad_position="default_post_sticky_footer_ad"]');
        } else {
            echo do_shortcode('[dynamic_ads ad_position="default_page_sticky_footer_ad"]');
        }
        ?> -->
    </div>
</div><!-- /.footer -->