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

$block_settings['content_media_style'] = get_field('content_media_style');
$block_settings['image'] = get_field('image');
$block_settings['display_icon_under'] = get_field('display_icon_under');
$block_settings['image_x'] = get_field('image_position_x');
$block_settings['image_position_in_mobile'] = get_field('image_position_in_mobile');

$block_settings['mobile_setting'] = get_field('mobile');
$block_settings['table_setting'] = get_field('table');
$block_settings['desktop_setting'] = get_field('desktop');
$block_settings['custom_css'] = get_field('custom_css');


echo nds_content_media_render($block, $block_settings);