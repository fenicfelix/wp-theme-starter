<?php

function add_ads_custom_js_to_head()
{
?>
    <script async src="https://securepubads.g.doubleclick.net/tag/js/gpt.js"></script>

    <?php
    if (is_front_page()) {
    ?>
        <script>
            window.googletag = window.googletag || {
                cmd: []
            };
            googletag.cmd.push(function() {
                var largeLeaderboard = googletag.sizeMapping().addSize([1050, 200], [970, 90]).addSize([1024, 768], [970, 90]).addSize([980, 690], [728, 90]).addSize([500, 500], [468, 60]).addSize([0, 0], [320, 50]).build();
                var leaderboard = googletag.sizeMapping().addSize([980, 690], [728, 90]).addSize([500, 500], [468, 60]).addSize([0, 0], [320, 50]).build();
                var leaderboard = googletag.sizeMapping().addSize([1050, 200], [728, 90]).addSize([1024, 768], [728, 90]).addSize([500, 500], [468, 60]).addSize([320, 700], [320, 50]).addSize([0, 0], [320, 50]).build();

                googletag.defineSlot('/23198293506/homepage_top_banner', [
                    [320, 50],
                    [468, 60],
                    [728, 90]
                ], 'div-gpt-ad-1739164061679-0').defineSizeMapping(leaderboard).addService(googletag.pubads());
                googletag.defineSlot('/23198293506/homepage_top_section_separator', [
                    [320, 50],
                    [468, 60],
                    [970, 90],
                    [728, 90]
                ], 'div-gpt-ad-1739164094543-0').defineSizeMapping(largeLeaderboard).addService(googletag.pubads());
                googletag.defineSlot('/23198293506/homepage_sidebar_1', [
                    [300, 250],
                    [336, 280]
                ], 'div-gpt-ad-1739164133742-0').addService(googletag.pubads());
                googletag.defineSlot('/23198293506/homepage_sidebar_2', [
                    [336, 280],
                    [300, 250]
                ], 'div-gpt-ad-1739164163416-0').addService(googletag.pubads());
                googletag.defineSlot('/23198293506/homepage_sidebar_3', [
                    [300, 250],
                    [336, 280]
                ], 'div-gpt-ad-1739164194823-0').addService(googletag.pubads());
                googletag.defineSlot('/23198293506/homepage_sports_separator_ad', [
                    [728, 90],
                    [320, 50],
                    [468, 60]
                ], 'div-gpt-ad-1739164249312-0').defineSizeMapping(leaderboard).addService(googletag.pubads());
                googletag.defineSlot('/23198293506/homepage_entertainment_separator_ad', [
                    [320, 50],
                    [468, 60],
                    [728, 90]
                ], 'div-gpt-ad-1739164280819-0').defineSizeMapping(leaderboard).addService(googletag.pubads());
                googletag.defineSlot('/23198293506/homepage_latest_news_separator_ad', [
                    [728, 90],
                    [320, 50],
                    [468, 60]
                ], 'div-gpt-ad-1739164313805-0').defineSizeMapping(leaderboard).addService(googletag.pubads());
                googletag.defineSlot('/23198293506/homepage_sticky_footer_ad', [
                    [320, 50],
                    [468, 60],
                    [970, 90],
                    [728, 90]
                ], 'div-gpt-ad-1739164436386-0').defineSizeMapping(largeLeaderboard).addService(googletag.pubads());
                googletag.pubads().enableSingleRequest();
                googletag.pubads().collapseEmptyDivs();
                googletag.enableServices();
            });
        </script>
    <?php
    } else if (is_page()) {
        $category_slug = get_the_category()[0]->slug;
    ?>
        <script>
            window.googletag = window.googletag || {
                cmd: []
            };
            googletag.cmd.push(function() {
                var largeLeaderboard = googletag.sizeMapping().addSize([1050, 200], [970, 90]).addSize([1024, 768], [970, 90]).addSize([980, 690], [728, 90]).addSize([500, 500], [468, 60]).addSize([0, 0], [320, 50]).build();
                var leaderboard = googletag.sizeMapping().addSize([980, 690], [728, 90]).addSize([500, 500], [468, 60]).addSize([0, 0], [320, 50]).build();
                var leaderboard = googletag.sizeMapping().addSize([1050, 200], [728, 90]).addSize([1024, 768], [728, 90]).addSize([500, 500], [468, 60]).addSize([320, 700], [320, 50]).addSize([0, 0], [320, 50]).build();

                googletag.defineSlot('/23198293506/default_top_banner', [
                    [320, 50],
                    [468, 60],
                    [728, 90]
                ], 'div-gpt-ad-1739198221685-0').defineSizeMapping(leaderboard).addService(googletag.pubads());
                googletag.defineSlot('/23198293506/default_post_listing_ad', [
                    [320, 50],
                    [468, 60],
                    [728, 90]
                ], 'div-gpt-ad-1739198573433-0').defineSizeMapping(leaderboard).addService(googletag.pubads());
                googletag.defineSlot('/23198293506/default_sidebar_1', [
                    [336, 280],
                    [300, 250]
                ], 'div-gpt-ad-1739198612724-0').addService(googletag.pubads());
                googletag.defineSlot('/23198293506/default_sidebar_2', [
                    [300, 250],
                    [336, 280]
                ], 'div-gpt-ad-1739198636261-0').addService(googletag.pubads());
                googletag.defineSlot('/23198293506/default_sticky_footer_ad', [
                    [468, 60],
                    [970, 90],
                    [728, 90],
                    [320, 50]
                ], 'div-gpt-ad-1739198671801-0').defineSizeMapping(largeLeaderboard).addService(googletag.pubads());
                googletag.pubads().enableSingleRequest();
                googletag.pubads().collapseEmptyDivs();
                googletag.enableServices();
            });
        </script>
    <?php
    } else if (is_single()) {
        $category_slug = get_the_category()[0]->slug;
    ?>
        <script>
            window.googletag = window.googletag || {
                cmd: []
            };
            googletag.cmd.push(function() {
                var largeLeaderboard = googletag.sizeMapping().addSize([1050, 200], [970, 90]).addSize([1024, 768], [970, 90]).addSize([980, 690], [728, 90]).addSize([500, 500], [468, 60]).addSize([0, 0], [320, 50]).build();
                var leaderboard = googletag.sizeMapping().addSize([980, 690], [728, 90]).addSize([500, 500], [468, 60]).addSize([0, 0], [320, 50]).build();
                var leaderboard = googletag.sizeMapping().addSize([1050, 200], [728, 90]).addSize([1024, 768], [728, 90]).addSize([500, 500], [468, 60]).addSize([320, 700], [320, 50]).addSize([0, 0], [320, 50]).build();

                googletag.defineSlot('/23198293506/default_post_top_banner', [
                    [320, 50],
                    [468, 60],
                    [728, 90]
                ], 'div-gpt-ad-1739199547528-0').defineSizeMapping(leaderboard).addService(googletag.pubads());
                googletag.defineSlot('/23198293506/default_post_social_section_ad', [
                    [468, 60],
                    [728, 90],
                    [320, 50]
                ], 'div-gpt-ad-1739199420610-0').defineSizeMapping(leaderboard).addService(googletag.pubads());
                googletag.defineSlot('/23198293506/default_post_midcontent_1', [336, 280], 'div-gpt-ad-1739199346313-0').addService(googletag.pubads());
                googletag.defineSlot('/23198293506/default_post_midcontent_2', [336, 280], 'div-gpt-ad-1739199369101-0').addService(googletag.pubads());
                googletag.defineSlot('/23198293506/default_post_midcontent_3', [336, 280], 'div-gpt-ad-1739199393073-0').addService(googletag.pubads());
                googletag.defineSlot('/23198293506/default_section_comment_section_ad', [
                    [320, 50],
                    [468, 60],
                    [728, 90]
                ], 'div-gpt-ad-1739199327470-0').defineSizeMapping(leaderboard).addService(googletag.pubads());
                googletag.defineSlot('/23198293506/default_post_tag_section_ad', [
                    [320, 50],
                    [468, 60],
                    [728, 90]
                ], 'div-gpt-ad-1739199500613-0').defineSizeMapping(leaderboard).addService(googletag.pubads());
                googletag.defineSlot('/23198293506/default_post_sticky_footer_ad', [
                    [970, 90],
                    [728, 90],
                    [320, 50],
                    [468, 60]
                ], 'div-gpt-ad-1739199468836-0').defineSizeMapping(largeLeaderboard).addService(googletag.pubads());

                googletag.pubads().enableSingleRequest();
                googletag.pubads().collapseEmptyDivs();
                googletag.enableServices();
            });
        </script>
    <?php
    } else {
    ?>
        <script>
            window.googletag = window.googletag || {
                cmd: []
            };
            googletag.cmd.push(function() {
                var largeLeaderboard = googletag.sizeMapping().addSize([1050, 200], [970, 90]).addSize([1024, 768], [970, 90]).addSize([980, 690], [728, 90]).addSize([500, 500], [468, 60]).addSize([0, 0], [320, 50]).build();
                var leaderboard = googletag.sizeMapping().addSize([980, 690], [728, 90]).addSize([500, 500], [468, 60]).addSize([0, 0], [320, 50]).build();
                var leaderboard = googletag.sizeMapping().addSize([1050, 200], [728, 90]).addSize([1024, 768], [728, 90]).addSize([500, 500], [468, 60]).addSize([320, 700], [320, 50]).addSize([0, 0], [320, 50]).build();

                googletag.defineSlot('/23198293506/default_top_banner', [
                    [320, 50],
                    [468, 60],
                    [728, 90]
                ], 'div-gpt-ad-1739198221685-0').defineSizeMapping(leaderboard).addService(googletag.pubads());
                googletag.defineSlot('/23198293506/default_post_listing_ad', [
                    [320, 50],
                    [468, 60],
                    [728, 90]
                ], 'div-gpt-ad-1739198573433-0').defineSizeMapping(leaderboard).addService(googletag.pubads());
                googletag.defineSlot('/23198293506/default_sidebar_1', [
                    [336, 280],
                    [300, 250]
                ], 'div-gpt-ad-1739198612724-0').addService(googletag.pubads());
                googletag.defineSlot('/23198293506/default_sidebar_2', [
                    [300, 250],
                    [336, 280]
                ], 'div-gpt-ad-1739198636261-0').addService(googletag.pubads());
                googletag.defineSlot('/23198293506/default_sticky_footer_ad', [
                    [468, 60],
                    [970, 90],
                    [728, 90],
                    [320, 50]
                ], 'div-gpt-ad-1739198671801-0').defineSizeMapping(largeLeaderboard).addService(googletag.pubads());
                googletag.pubads().enableSingleRequest();
                googletag.pubads().collapseEmptyDivs();
                googletag.enableServices();
            });
        </script>
    <?php
    }
}
add_action('wp_head', 'add_ads_custom_js_to_head');

function get_sticky_footer_ad()
{
    if (is_front_page()) {
    ?>
        <!-- /23198293506/homepage_sticky_footer_ad -->
        <div id='div-gpt-ad-1739164436386-0' style='min-width: 320px; min-height: 50px;'>
            <script>
                googletag.cmd.push(function() {
                    googletag.display('div-gpt-ad-1739164436386-0');
                });
            </script>
        </div>
    <?php
    } else if (is_page()) {
        $category_slug = get_the_category()[0]->slug;
    ?>
        <!-- /23198293506/default_sticky_footer_ad -->
        <div id='div-gpt-ad-1739198671801-0' style='min-width: 320px; min-height: 50px;'>
            <script>
                googletag.cmd.push(function() {
                    googletag.display('div-gpt-ad-1739198671801-0');
                });
            </script>
        </div>
    <?php
    } else if (is_single()) {
        $category_slug = get_the_category()[0]->slug;
    ?>
        <!-- /23198293506/default_post_sticky_footer_ad -->
        <div id='div-gpt-ad-1739199468836-0' style='min-width: 320px; min-height: 50px;'>
            <script>
                googletag.cmd.push(function() {
                    googletag.display('div-gpt-ad-1739199468836-0');
                });
            </script>
        </div>
<?php
    }
}
