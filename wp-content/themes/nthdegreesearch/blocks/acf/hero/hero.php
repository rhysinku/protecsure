<?php

$block_name = str_replace('.php', '', $block['render_template']);

if (is_admin()) {
  $block_id = $block['id'];
} else {
  $block_id = isset($block['anchor']) ? esc_attr($block['anchor']) : str_replace('block_', '', $block['id']);
}

$block_settings = array();
$block_settings['block_data'] = array(
  'block_id' => $block_id,
  'block_name' => $block_name
);
$block_settings['hero_image'] = get_field('hero_image');
$block_settings['background'] = get_field('background');

$block_settings['mobile_setting'] = get_field('mobile');
$block_settings['table_setting'] = get_field('table');
$block_settings['desktop_setting'] = get_field('desktop');

$block_settings['image_mobile_position'] = get_field('image_mobile_position');
$block_settings['image_object_position'] = get_field('image_object_position');
$block_settings['custom_css'] = get_field('custom_css');



echo nds_hero_render($block, $block_settings);