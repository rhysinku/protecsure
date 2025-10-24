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
  'block_id'    => $block_id,
  'block_name'  => $block_name,
  'extra_class' => $additional_classes
);

echo $block_settings['block_data']['extra_class'];


$block_settings['custom_css'] = get_field('custom_css');

echo nds_accordion_render($block_id, $block_settings);