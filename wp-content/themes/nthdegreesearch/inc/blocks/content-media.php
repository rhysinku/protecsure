<?php

//Content Media
function nds_content_media_render($block, $block_settings) {

  $innerblock_template = [
    ['core/heading', ['placeholder' => 'Add a heading...']],
    ['core/paragraph', ['placeholder' => 'Add your text here...']],
  ];

  if (!$block) {
    return;
  }

  $class_attr = nds_get_padding_classes($block_settings);
  $image = $block_settings['image'];
  $image_x = $block_settings['image_x'];
  $image_position_in_mobile = $block_settings['image_position_in_mobile'];

  $raw_css = isset($block_settings['custom_css']) ? (string)$block_settings['custom_css'] : '';

  //  For Render CSS
  nds_render_css($raw_css);

  ob_start();
?>

  <section <?php echo nds_block_wrapper_attrs($block, $block_settings); ?>
    class="prt-content-media relative <?php echo 'bg-' . $block_settings['background_color']; ?>  <?php echo esc_attr($class_attr) ?>">
    <div class="container container-sm">
      <div class="flex flex-col items-center">
        <div class="<?php  $image_position_in_mobile === 'top' ? 'order-1' : 'order-2'  ?>">
          <figure class="nds-figure-media lg:absolute top-0 bottom-0 <?php echo $image_x == 'left' ? 'left-0' : 'right-0' ?>  max-w-[707px] lg:w-2/4 w-full h-full">
            <?php if (!empty($image)) : ?>
              <img src="<?php echo esc_url($image['url']); ?>"
                class="lg:absolute top-0 w-full h-full! object-cover!"
                decoding="async"
                loading="lazy"
                width="<?php echo esc_attr($image['width']); ?>"
                height="<?php echo esc_attr($image['height']); ?>"
                alt="<?php echo esc_attr($image['alt'] ?? ''); ?>">
            <?php elseif (is_admin()) : ?>
              <!-- Show only in editor -->
              <img src="https://placehold.co/707x426?text=Add+an+Image"
                class="lg:absolute top-0 w-full h-full! object-cover!"
                alt="Placeholder image for editor only">
            <?php endif; ?>
          </figure>
        </div>
        <div class="lg:max-w-[464px] w-full <?php echo $image_x == 'left' ? 'lg:ml-auto' : 'lg:mr-auto' ?> py-16">
          <InnerBlocks
            template='<?php echo esc_attr(wp_json_encode($innerblock_template)); ?>'
            templateLock="false" />
        </div>
      </div>
    </div>
  </section>


<?php
  return ob_get_clean();
}
