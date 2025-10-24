<?php
$block_name = str_replace( '.php', '', $block['render_template'] );

if ( is_admin() ) {
    $block_id = $block['id'];
} else {
    $block_id = isset( $block['anchor'] ) ? esc_attr( $block['anchor'] ) : str_replace( 'block_', '', $block['id'] );
}

$buttons_arr = array();

$buttons_arr['block_data'] = array(
    'block_id' => $block_id,
    'block_name' => $block_name
);

$direction = get_field( 'direction' );
$buttons_arr['direction'] = $direction;

$gap = get_field( 'gap' );
$buttons_arr['gap'] = $gap;

$buttons_items = get_field( 'buttons_items' );
$buttons_arr['buttons_items'] = $buttons_items;

echo nds_button_render( $block, $buttons_arr );