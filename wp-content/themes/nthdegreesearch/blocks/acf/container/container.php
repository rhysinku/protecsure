<?php
$block_name = str_replace('.php', '', $block['render_template']);


if (is_admin()) {
  $block_id = $block['id'];
} else {
  $block_id = isset($block['anchor']) ? esc_attr($block['anchor']) : str_replace('block_', '', $block['id']);
}

$additional_classes = isset($block['className']) ? trim($block['className']) : '';
$block_settings = array();
$block_settings['block_data'] = array(
  'block_id' => $block_id,
  'block_name' => $block_name,
  'extra_class' => $additional_classes
);


$block_settings['background_color'] = get_field('background_color');
$block_settings['container_width'] = get_field('container_width');
$block_settings['toggle_swirl'] = get_field('toggle_design');
$block_settings['swirl_variant'] = get_field('swirl_variant');
$block_settings['mobile_setting'] = get_field('mobile');
$block_settings['table_setting'] = get_field('table');
$block_settings['desktop_setting'] = get_field('desktop');
$block_settings['custom_css'] = get_field('custom_css');

echo nds_container_block_render($block, $block_settings);