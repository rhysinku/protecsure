<?php


/**
 * Button Group render
 */

function nds_button_group_render($buttons, $settings, $block_id_attr) {
  if (!$buttons) {
    return;
  }
  ob_start();

  $alignment = $settings['alignment'];
  $gap = $settings['gap'];

  if ($gap === '0') {
    $gap = 'gap-0';
  } elseif ($gap === 'sm') {
    $gap = 'gap-2.5';
  } elseif ($gap === 'lg') {
    $gap = 'gap-[1.875rem]';
  } else {
    $gap = 'gap-5';
  }

?>
  <div <?php echo $block_id_attr ?>
    class="nds-button-group flex items-center flex-wrap <?php echo 'justify-' . esc_html($alignment) ?> <?php echo esc_html($gap) ?>">
    <?php if ($buttons) : ?>
      <?php foreach ($buttons as $button) :
        $button_link = $button['link'];
        $button_style = $button['button_style'];
      ?>
        <a href="<?php echo esc_html($button_link['url']) ?? '' ?>" class="nds-btn nds-btn-<?php echo $button_style; ?>"
          target="<?php echo esc_html($button_link['target']) ?>"><?php echo esc_html($button_link['title']) ?></a>

      <?php endforeach; ?>
    <?php endif; ?>
  </div>
<?php
  return ob_get_clean();
}
