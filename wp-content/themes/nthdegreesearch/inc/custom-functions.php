<?php
/**
 * Slug
 */
function nds_create_slug($string) {

  $string = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);

  return strtolower($string);

}


/**
 * Generate responsive padding classes from block settings.
 *
 * @param array $block_settings
 * @return string Padding classes (e.g. "nds_pt-sm nds_pb-md md:nds_pt-lg")
 */
function nds_get_padding_classes(array $block_settings): string {
  $paddings = [
    'mobile' => [
      'top' => $block_settings['mobile_setting']['padding_top'] ?? '',
      'bottom' => $block_settings['mobile_setting']['padding_bottom'] ?? '',
      'prefix' => '',
    ],
    'tablet' => [
      'top' => $block_settings['table_setting']['padding_top'] ?? '',
      'bottom' => $block_settings['table_setting']['padding_bottom'] ?? '',
      'prefix' => 'md:',
    ],
    'desktop' => [
      'top' => $block_settings['desktop_setting']['padding_top'] ?? '',
      'bottom' => $block_settings['desktop_setting']['padding_bottom'] ?? '',
      'prefix' => 'lg:',
    ],
  ];

  $padding_classes = [];

  foreach ($paddings as $device) {
    if (!empty($device['top'])) {
      $padding_classes[] = $device['prefix'] . 'nds_pt-' . $device['top'];
    }
    if (!empty($device['bottom'])) {
      $padding_classes[] = $device['prefix'] . 'nds_pb-' . $device['bottom'];
    }
  }

  return implode(' ', $padding_classes);
}


// RENDER CSS Helper

/** Collector + printer (ensure this is loaded once) */
if (!function_exists('nds_collect_block_css')) {
  function nds_collect_block_css(string $css): void {
    $css = trim($css);
    if ($css === '') {
      return;
    }
    $GLOBALS['nds_collected_block_css'] ??= [];
    $GLOBALS['nds_collected_block_css'][] = $css;
  }
}


/** Print collected CSS after content (footer runs after the loop) */
add_action('wp_footer', static function () {
  if (is_admin()) {
    return;
  }
  if (empty($GLOBALS['nds_collected_block_css'])) {
    return;
  }

  $css = implode("\n", $GLOBALS['nds_collected_block_css']);
  // light minify
  $css = preg_replace('/\s+/', ' ', $css);
  echo "<style id='nds-block-custom-css'>$css</style>\n";
}, 1);


/**
 * Emit custom CSS inline in the editor, or collect it for a single print on the frontend.
 *
 * Usage in a block render:
 *   nds_block_css( $raw_css );
 *
 * Options:
 *   nds_block_css( $raw_css, ['context' => 'inline'] );   // always print <style> here
 *   nds_block_css( $raw_css, ['context' => 'collect'] );  // always collect for footer
 */

if (!function_exists('nds_render_css')) {

  function nds_render_css(string $css, array $opts = []): void {
    $css = trim($css);
    if ($css === '') return;

    $context = $opts['context'] ?? 'auto';     // 'auto' | 'inline' | 'collect'
    $attrs = $opts['inline_attrs'] ?? 'class="nds-inline-block-css"';

    $css = preg_replace('/\s+/', ' ', $css);

    if ($context === 'inline' || ($context === 'auto' && is_admin())) {
      echo "<style {$attrs}>{$css}</style>";
      return;
    }

    // Otherwise, collect for a single print (in footer) on the frontend
    if (function_exists('nds_collect_block_css')) {
      nds_collect_block_css($css);
    } else {
      echo "<style {$attrs}>{$css}</style>";
    }

  }


}


/**
 * Build wrapper attributes for an ACF block.
 *
 * @param array $block   The $block array passed into render callback.
 * @param array $settings Optional settings array that contains ['block_data']['block_id'].
 * @return string HTML attributes string, ready for echo in a tag.
 *
 * Usage:
 *   echo nds_block_wrapper_attrs( $block, $block_settings );
 */
if (!function_exists('nds_block_wrapper_attrs')) {
  function nds_block_wrapper_attrs($block, array $settings = []): string {
    $has_anchor = !empty($block['anchor']);
    $block_id   = $settings['block_data']['block_id'] ?? '';

    if ($has_anchor) {
      return sprintf(
        'id="%s" data-block-id="%s"',
        esc_attr($block['anchor']),
        esc_attr($block_id)
      );
    }

    return sprintf(
      'data-block-id="%s"',
      esc_attr($block_id)
    );
  }
}