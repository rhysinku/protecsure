<?php
/**
 * Theme setup.
 */
add_action('after_setup_theme', 'nds_setup');
function nds_setup() {

  add_theme_support('title-tag');

  register_nav_menus(
    array(
      'primary' => __('Primary Menu', 'nds'),
      'footer' => __('Quick Link', 'nds'),
      'footer-2' => __('More ', 'nds'),
    )
  );

  add_theme_support(
    'html5',
    array(
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
    )
  );

  add_theme_support('custom-logo');
  add_theme_support('post-thumbnails');

  add_theme_support('align-wide');
  add_theme_support('wp-block-styles');

  add_theme_support('responsive-embeds');

  add_theme_support('editor-styles');
  add_editor_style('assets/css/editor-style.css');

}


add_action('init', function () {
  if (post_type_exists('wp_block')) {
    $post_type_object = get_post_type_object('wp_block');
    $post_type_object->show_in_menu = true;
  }
}, 20);


/**
 * SVG support
 */
add_filter('upload_mimes', 'nds_mime_types');
function nds_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}


/**
 * Add css page slug to body
 */
add_filter('body_class', 'nds_add_slug_body_class');
function nds_add_slug_body_class($classes) {

  global $post;

  if (isset($post)) {
    $classes[] = $post->post_type . '-' . $post->post_name;
  }

  return $classes;
}


/**
 * Add parent slug to child body class
 */
add_filter('body_class', 'nds_add_parent_class');
function nds_add_parent_class($classes) {

  global $wpdb, $post;

  if (is_page()) {

    if ($post->post_parent) {
      $parent = end(get_post_ancestors($current_page_id));
    } else {
      $parent = $post->ID;
    }

    $post_data = get_post($parent, ARRAY_A);
    $classes[] = 'parent-' . $post_data['post_name'];

  }

  return $classes;

}

/**
 * Set custom width and height for the logo
 */
add_filter('get_custom_logo', 'nds_custom_logo_size');
function nds_custom_logo_size($html) {
  $acf_general_settings = get_field('acf_general_settings', 'option');

  if ($acf_general_settings) {
    $logo_width = !empty($acf_general_settings['logo_width']) ? esc_attr($acf_general_settings['logo_width']) : '';
    $logo_height = !empty($acf_general_settings['logo_height']) ? esc_attr($acf_general_settings['logo_height']) : '';

    $attr = '';
    if ($logo_width) {
      $attr .= ' width="' . $logo_width . '"';
    }
    if ($logo_height) {
      $attr .= ' height="' . $logo_height . '"';
    }

    if ($attr) {
      $html = preg_replace('/<img(.*?)>/', '<img$1' . $attr . '>', $html);
    }
  }

  return $html;
}


/**
 * Adds option 'li_class' to 'wp_nav_menu'.
 *
 * @param string $classes String of classes.
 * @param mixed $item The current item.
 * @param WP_Term $args Holds the nav menu arguments.
 *
 * @return array
 */
add_filter('nav_menu_css_class', 'nds_nav_menu_add_li_class', 10, 4);
function nds_nav_menu_add_li_class($classes, $item, $args, $depth) {
  if (isset($args->li_class)) {
    $classes[] = $args->li_class;
  }

  if (isset($args->{"li_class_$depth"})) {
    $classes[] = $args->{"li_class_$depth"};
  }

  return $classes;
}


/**
 * Adds option 'submenu_class' to 'wp_nav_menu'.
 *
 * @param string $classes String of classes.
 * @param mixed $item The current item.
 * @param WP_Term $args Holds the nav menu arguments.
 *
 * @return array
 */
add_filter('nav_menu_submenu_css_class', 'nds_nav_menu_add_submenu_class', 10, 3);
function nds_nav_menu_add_submenu_class($classes, $args, $depth) {
  if (isset($args->submenu_class)) {
    $classes[] = $args->submenu_class;
  }

  if (isset($args->{"submenu_class_$depth"})) {
    $classes[] = $args->{"submenu_class_$depth"};
  }

  return $classes;
}


/**
 * Add span to menu if with children or mega menu
 */
add_filter('wp_nav_menu_objects', 'nds_add_span_to_menu_item', 10, 2);
function nds_add_span_to_menu_item($items, $args) {

  foreach ($items as $item) {
    if (in_array('menu-item-has-children', $item->classes) || in_array('nds-mega-menu', $item->classes)) {
      $item->title = $item->title . '<span class="arrow transition-all duration-200 bg-center bg-no-repeat bg-contain w-[.6875rem] h-1.5"></span>';
    }

  }

  return $items;

}


/**
 * Register custom category for block patterns.
 */
add_action('init', function () {
  if (function_exists('register_block_pattern_category')) {
    register_block_pattern_category(
      'nds-patterns',
      array(
        'label' => __('NDS Patterns', 'nds'),
        'description' => __('Custom patterns for the NDS theme.', 'nds'),
      )
    );
  }
});