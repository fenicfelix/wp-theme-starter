<?php

function yehtu_main_header()
{
    echo `<script src="https://scripts.yehtu.com/scripts3/loader2.js" async
        data-inv="//ads.yehtu.com/"
        data-r="single"
        data-sender="yehtu"
        data-bundle="desktop"></script>`;
}

function yehtu_header_codes()
{
    if (is_front_page()) {
        if (wp_is_mobile()) {
            echo `<script type='text/javascript'>
                (window.globalAmlAds = window.globalAmlAds || []).push(function() {
                    globalAml.defineSlot({z: 'e314d78d-b201-42c1-ae55-84a129d91ac0', ph: 'yehtu_e314d78db20142c1ae5584a129d91ac0_zone_124394_sect_58841_site_52053', i: 'inv-nets', s:'4ce38f48-d786-4136-923c-ba513830c3c3', sender: 'yehtu'});
                    globalAml.defineSlot({z: '50125f60-2d18-4959-bbb5-1f3a8ba2a5b7', ph: 'yehtu_50125f602d184959bbb51f3a8ba2a5b7_zone_124396_sect_58841_site_52053', i: 'inv-nets', s:'4ce38f48-d786-4136-923c-ba513830c3c3', sender: 'yehtu'});
                    globalAml.defineSlot({z: 'aca2d153-5460-4a07-96ae-a79d7d027cc6', ph: 'yehtu_aca2d15354604a0796aea79d7d027cc6_zone_124398_sect_58841_site_52053', i: 'inv-nets', s:'4ce38f48-d786-4136-923c-ba513830c3c3', sender: 'yehtu'});
                    globalAml.singleRequest("yehtu");});
                </script>`;
        } else {
            echo `<script type='text/javascript'>
                (window.globalAmlAds = window.globalAmlAds || []).push(function() {
                    globalAml.defineSlot({z: '4a55ce47-9612-4647-a5f2-46a217463e4d', ph: 'yehtu_4a55ce4796124647a5f246a217463e4d_zone_124393_sect_58841_site_52053', i: 'inv-nets', s:'4ce38f48-d786-4136-923c-ba513830c3c3', sender: 'yehtu'});
                    globalAml.defineSlot({z: '35316909-e46a-4586-9525-22df657167ea', ph: 'yehtu_35316909e46a4586952522df657167ea_zone_124395_sect_58841_site_52053', i: 'inv-nets', s:'4ce38f48-d786-4136-923c-ba513830c3c3', sender: 'yehtu'});
                    globalAml.defineSlot({z: 'a9bf94b4-2c4e-4cb4-8c79-4d056c5506a3', ph: 'yehtu_a9bf94b42c4e4cb48c794d056c5506a3_zone_124397_sect_58841_site_52053', i: 'inv-nets', s:'4ce38f48-d786-4136-923c-ba513830c3c3', sender: 'yehtu'});
                    globalAml.defineSlot({z: 'ab2d2a0d-05eb-40cc-9cd5-c2cc6d04a0ac', ph: 'yehtu_ab2d2a0d05eb40cc9cd5c2cc6d04a0ac_zone_124399_sect_58841_site_52053', i: 'inv-nets', s:'4ce38f48-d786-4136-923c-ba513830c3c3', sender: 'yehtu'});
                    globalAml.singleRequest("yehtu");});
                </script>`;
        }
    } else if (is_single()) {
        if (wp_is_mobile()) {
            echo `<script type='text/javascript'>
            (window.globalAmlAds = window.globalAmlAds || []).push(function() {
                globalAml.defineSlot({z: '1ae16ce5-a3cc-428e-b827-2ce17bb01ea7', ph: 'yehtu_1ae16ce5a3cc428eb8272ce17bb01ea7_zone_124406_sect_58856_site_52053', i: 'inv-nets', s:'4ce38f48-d786-4136-923c-ba513830c3c3', sender: 'yehtu'});
                globalAml.defineSlot({z: 'c66ffb3c-61e9-4e51-9c73-f1194cba78c5', ph: 'yehtu_c66ffb3c61e94e519c73f1194cba78c5_zone_124408_sect_58856_site_52053', i: 'inv-nets', s:'4ce38f48-d786-4136-923c-ba513830c3c3', sender: 'yehtu'});
                globalAml.defineSlot({z: '68452b29-0355-4768-8b74-b56839cd4819', ph: 'yehtu_68452b29035547688b74b56839cd4819_zone_124410_sect_58856_site_52053', i: 'inv-nets', s:'4ce38f48-d786-4136-923c-ba513830c3c3', sender: 'yehtu'});
                globalAml.defineSlot({z: 'af2e7095-aa8f-4a57-8024-ab4171a57982', ph: 'yehtu_af2e7095aa8f4a578024ab4171a57982_zone_124412_sect_58856_site_52053', i: 'inv-nets', s:'4ce38f48-d786-4136-923c-ba513830c3c3', sender: 'yehtu'});
                globalAml.singleRequest("yehtu");});
            </script>`;
        } else {
            echo `<script type='text/javascript'>
            (window.globalAmlAds = window.globalAmlAds || []).push(function() {
                globalAml.defineSlot({z: 'ffbd5924-b8f7-48c0-9b67-3e2ccf452e08', ph: 'yehtu_ffbd5924b8f748c09b673e2ccf452e08_zone_124405_sect_58856_site_52053', i: 'inv-nets', s:'4ce38f48-d786-4136-923c-ba513830c3c3', sender: 'yehtu'});
                globalAml.defineSlot({z: '70409654-5b77-49b7-8197-b2383dabe389', ph: 'yehtu_704096545b7749b78197b2383dabe389_zone_124407_sect_58856_site_52053', i: 'inv-nets', s:'4ce38f48-d786-4136-923c-ba513830c3c3', sender: 'yehtu'});
                globalAml.defineSlot({z: '302935be-ce90-481f-aa39-03610f91947f', ph: 'yehtu_302935bece90481faa3903610f91947f_zone_124409_sect_58856_site_52053', i: 'inv-nets', s:'4ce38f48-d786-4136-923c-ba513830c3c3', sender: 'yehtu'});
                globalAml.defineSlot({z: 'c0d945e1-7f41-481c-9633-920e295bffc8', ph: 'yehtu_c0d945e17f41481c9633920e295bffc8_zone_124411_sect_58856_site_52053', i: 'inv-nets', s:'4ce38f48-d786-4136-923c-ba513830c3c3', sender: 'yehtu'});
                globalAml.defineSlot({z: 'd5a5adcd-2dca-4684-a133-5da5ac87c990', ph: 'yehtu_d5a5adcd2dca4684a1335da5ac87c990_zone_124413_sect_58856_site_52053', i: 'inv-nets', s:'4ce38f48-d786-4136-923c-ba513830c3c3', sender: 'yehtu'});
                globalAml.singleRequest("yehtu");});
            </script>`;
        }
    } else {
        if (wp_is_mobile()) {
            echo `<script type='text/javascript'>
                (window.globalAmlAds = window.globalAmlAds || []).push(function() {
                    globalAml.defineSlot({z: 'aedd32b6-5f06-4559-8f69-17d72276b26f', ph: 'yehtu_aedd32b65f0645598f6917d72276b26f_zone_124401_sect_58842_site_52053', i: 'inv-nets', s:'4ce38f48-d786-4136-923c-ba513830c3c3', sender: 'yehtu'});
                    globalAml.defineSlot({z: 'af7fdfb4-09ea-4728-a1f3-a20e86f308c1', ph: 'yehtu_af7fdfb409ea4728a1f3a20e86f308c1_zone_124403_sect_58842_site_52053', i: 'inv-nets', s:'4ce38f48-d786-4136-923c-ba513830c3c3', sender: 'yehtu'});
                    globalAml.singleRequest("yehtu");});
                </script>`;
        } else {
            echo `<script type='text/javascript'>
            (window.globalAmlAds = window.globalAmlAds || []).push(function() {
                globalAml.defineSlot({z: '2c8bb001-23bd-4bb4-8266-ce73acafad34', ph: 'yehtu_2c8bb00123bd4bb48266ce73acafad34_zone_124400_sect_58842_site_52053', i: 'inv-nets', s:'4ce38f48-d786-4136-923c-ba513830c3c3', sender: 'yehtu'});
                globalAml.defineSlot({z: 'f2247aef-b7fc-4ea3-baa6-f0da4131dc9c', ph: 'yehtu_f2247aefb7fc4ea3baa6f0da4131dc9c_zone_124402_sect_58842_site_52053', i: 'inv-nets', s:'4ce38f48-d786-4136-923c-ba513830c3c3', sender: 'yehtu'});
                globalAml.defineSlot({z: 'b79d1df3-2ea1-44ff-bbdb-920f359ca3a0', ph: 'yehtu_b79d1df32ea144ffbbdb920f359ca3a0_zone_124404_sect_58842_site_52053', i: 'inv-nets', s:'4ce38f48-d786-4136-923c-ba513830c3c3', sender: 'yehtu'});
                globalAml.singleRequest("yehtu");});
            </script>`;
        }
    }
}

function homepage_billboard_ad()
{
    if (wp_is_mobile()) {
        echo `<div id='yehtu_e314d78db20142c1ae5584a129d91ac0_zone_124394_sect_58841_site_52053' data-sender='yehtu'></div>
            <script type='text/javascript'>
                (window.globalAmlAds = window.globalAmlAds || []).push(function() {
                    globalAml.display('yehtu_e314d78db20142c1ae5584a129d91ac0_zone_124394_sect_58841_site_52053');
                });
            </script>`;
    } else {
        echo `<div id='yehtu_4a55ce4796124647a5f246a217463e4d_zone_124393_sect_58841_site_52053' data-sender='yehtu'></div>
            <script type='text/javascript'>
                (window.globalAmlAds = window.globalAmlAds || []).push(function() {
                    globalAml.display('yehtu_4a55ce4796124647a5f246a217463e4d_zone_124393_sect_58841_site_52053');
                });
            </script>`;
    }
}

function homepage_floating_ad()
{
    if (wp_is_mobile()) {
        echo `<div id='yehtu_aca2d15354604a0796aea79d7d027cc6_zone_124398_sect_58841_site_52053' data-sender='yehtu'></div>
            <script type='text/javascript'>
                (window.globalAmlAds = window.globalAmlAds || []).push(function() {
                    globalAml.display('yehtu_aca2d15354604a0796aea79d7d027cc6_zone_124398_sect_58841_site_52053');
                });
            </script>`;
    } else {
        echo `<div id='yehtu_a9bf94b42c4e4cb48c794d056c5506a3_zone_124397_sect_58841_site_52053' data-sender='yehtu'></div>
            <script type='text/javascript'>
                (window.globalAmlAds = window.globalAmlAds || []).push(function() {
                    globalAml.display('yehtu_a9bf94b42c4e4cb48c794d056c5506a3_zone_124397_sect_58841_site_52053');
                });
            </script>`;
    }
}

function archive_billboard_ad()
{
    if (wp_is_mobile()) {
        echo `<div id='yehtu_aedd32b65f0645598f6917d72276b26f_zone_124401_sect_58842_site_52053' data-sender='yehtu'></div>
            <script type='text/javascript'>
                (window.globalAmlAds = window.globalAmlAds || []).push(function() {
                    globalAml.display('yehtu_aedd32b65f0645598f6917d72276b26f_zone_124401_sect_58842_site_52053');
                });
            </script>`;
    } else {
        echo `<div id='yehtu_2c8bb00123bd4bb48266ce73acafad34_zone_124400_sect_58842_site_52053' data-sender='yehtu'></div>
            <script type='text/javascript'>
                (window.globalAmlAds = window.globalAmlAds || []).push(function() {
                    globalAml.display('yehtu_2c8bb00123bd4bb48266ce73acafad34_zone_124400_sect_58842_site_52053');
                });
            </script>`;
    }
}

function archive_floating_ad()
{
    if (wp_is_mobile()) {
        echo `<div id='yehtu_af7fdfb409ea4728a1f3a20e86f308c1_zone_124403_sect_58842_site_52053' data-sender='yehtu'></div>
            <script type='text/javascript'>
                (window.globalAmlAds = window.globalAmlAds || []).push(function() {
                    globalAml.display('yehtu_af7fdfb409ea4728a1f3a20e86f308c1_zone_124403_sect_58842_site_52053');
                });
            </script>`;
    } else {
        echo `<div id='yehtu_f2247aefb7fc4ea3baa6f0da4131dc9c_zone_124402_sect_58842_site_52053' data-sender='yehtu'></div>
            <script type='text/javascript'>
                (window.globalAmlAds = window.globalAmlAds || []).push(function() {
                    globalAml.display('yehtu_f2247aefb7fc4ea3baa6f0da4131dc9c_zone_124402_sect_58842_site_52053');
                });
            </script>`;
    }
}

function post_billboard_ad()
{
    if (wp_is_mobile()) {
        echo `<div id='yehtu_1ae16ce5a3cc428eb8272ce17bb01ea7_zone_124406_sect_58856_site_52053' data-sender='yehtu'></div>
            <script type='text/javascript'>
                (window.globalAmlAds = window.globalAmlAds || []).push(function() {
                    globalAml.display('yehtu_1ae16ce5a3cc428eb8272ce17bb01ea7_zone_124406_sect_58856_site_52053');
                });
            </script>`;
    } else {
        echo `<div id='yehtu_ffbd5924b8f748c09b673e2ccf452e08_zone_124405_sect_58856_site_52053' data-sender='yehtu'></div>
            <script type='text/javascript'>
                (window.globalAmlAds = window.globalAmlAds || []).push(function() {
                    globalAml.display('yehtu_ffbd5924b8f748c09b673e2ccf452e08_zone_124405_sect_58856_site_52053');
                });
            </script>`;
    }
}

function post_floating_ad()
{
    if (wp_is_mobile()) {
        echo `<div id='yehtu_c0d945e17f41481c9633920e295bffc8_zone_124411_sect_58856_site_52053' data-sender='yehtu'></div>
            <script type='text/javascript'>
                (window.globalAmlAds = window.globalAmlAds || []).push(function() {
                    globalAml.display('yehtu_c0d945e17f41481c9633920e295bffc8_zone_124411_sect_58856_site_52053');
                });
            </script>`;
    } else {
        echo `<div id='yehtu_af2e7095aa8f4a578024ab4171a57982_zone_124412_sect_58856_site_52053' data-sender='yehtu'></div>
            <script type='text/javascript'>
                (window.globalAmlAds = window.globalAmlAds || []).push(function() {
                    globalAml.display('yehtu_af2e7095aa8f4a578024ab4171a57982_zone_124412_sect_58856_site_52053');
                });
            </script>`;
    }
}

function post_native_ad()
{
    if (wp_is_mobile()) {
        echo `<div id='yehtu_68452b29035547688b74b56839cd4819_zone_124410_sect_58856_site_52053' data-sender='yehtu'></div>
            <script type='text/javascript'>
                (window.globalAmlAds = window.globalAmlAds || []).push(function() {
                    globalAml.display('yehtu_68452b29035547688b74b56839cd4819_zone_124410_sect_58856_site_52053');
                });
            </script>`;
    } else {
        echo `<div id='yehtu_302935bece90481faa3903610f91947f_zone_124409_sect_58856_site_52053' data-sender='yehtu'></div>
            <script type='text/javascript'>
                (window.globalAmlAds = window.globalAmlAds || []).push(function() {
                    globalAml.display('yehtu_302935bece90481faa3903610f91947f_zone_124409_sect_58856_site_52053');
                });
            </script>`;
    }
}
