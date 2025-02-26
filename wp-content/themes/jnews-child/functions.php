<?php

/**
 * Load parent theme style
 */
add_action('wp_enqueue_scripts', 'jnews_child_enqueue_parent_style');

function jnews_child_enqueue_parent_style()
{
    wp_enqueue_style('jnews-parent-style', get_parent_theme_file_uri('/style.css'));
}

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
