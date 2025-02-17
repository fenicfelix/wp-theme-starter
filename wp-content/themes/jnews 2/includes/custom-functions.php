<?php

// register a new widget, default-category-sidebar
register_sidebar(
    array(
        'name'          => esc_html__('Default Category Sidebar', 'jnews'),
        'id'            => 'default-category-sidebar',
        'description'   => esc_html__('Add widgets here to appear in your category sidebar.', 'jnews'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    )
);