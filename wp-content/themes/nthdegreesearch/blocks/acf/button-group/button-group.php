<?php

$block_name = str_replace('.php', '', $block['render_template']);

$buttons = get_field('buttons');
$gap = get_field('gap');
$alignment = get_field('alignment');


if (is_admin()) {
  $block_id = $block['id'];
} else {
  $block_id = isset($block['anchor']) ? esc_attr($block['anchor']) : str_replace('block_', '', $block['id']);
}

// Get core block attributes from block context
$block_id = $block['id'] ?? '';
$block_classes = $block['classes'] ?? '';
$block_anchor = $block['anchor'] ?? '';
$block_id_attr = $block_anchor ? 'id="' . esc_attr($block_anchor) . '"' : '';

$settings = array();
$settings['gap'] = $gap;
$settings['alignment'] = $alignment;
echo nds_button_group_render($buttons, $settings, $block_id_attr);