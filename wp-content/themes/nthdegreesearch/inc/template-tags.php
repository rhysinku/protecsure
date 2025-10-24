<?php
/**
 * Section and Container block video background
 */
function nds_section_container_block_video_bg($bg_enable_video_background, $video) {

  ob_start();

  if ($bg_enable_video_background) :
    $video_src = $video['bg_video_source'] ?? false;
    $video_local_file = $video['bg_video_local'] ?? '';
    $video_youtube = $video['bg_youtube_url'] ?? '';

    $youtube_video_id = '';
    $youtube_valid = false;

    if ($video_src && $video_youtube) {
      // Match YouTube standard format
      if (preg_match('/^https:\/\/www\.youtube\.com\/watch\?v=([a-zA-Z0-9_-]{11})$/', $video_youtube, $matches)) {
        $youtube_video_id = $matches[1];
        $youtube_valid = true;
      }
    }
    ?>

    <div class="absolute inset-0 w-full h-full top-0 left-0 pointer-events-none overflow-hidden">

      <?php if ($video_src && $youtube_valid) { ?>

        <div
          class="youtube-wrapper absolute top-1/2 left-1/2 w-[177.78vh] h-[100vh] -translate-x-1/2 -translate-y-1/2 min-lg:w-full">
          <iframe
            class="nds-lazyvideo absolute top-0 left-0 w-full h-full object-cover"
            title="YouTube video"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen
            data-src="https://www.youtube.com/embed/<?php echo esc_attr($youtube_video_id); ?>?enablejsapi=1&autoplay=1&mute=1&controls=0&rel=0&playsinline=1&modestbranding=1&showinfo=0&loop=1&playlist=<?php echo esc_attr($youtube_video_id); ?>"


          ></iframe>
        </div>

      <?php } elseif ($video_src && !$youtube_valid) { ?>

        <div class="text-red-600 bg-white p-4 font-semibold">
          Invalid YouTube URL format. Please use: <br>
          <code>https://www.youtube.com/watch?v=VIDEO_ID</code>
        </div>

      <?php } elseif (!$video_src && $video_local_file) { ?>

        <video
          class="nds-lazyvideo w-full h-full object-cover"
          autoplay
          muted
          loop
          playsinline
          preload="none"
          data-src="<?php echo esc_url($video_local_file['url']); ?>"
          data-type="<?php echo $video_local_file['mime_type']; ?>"
        ></video>

      <?php } ?>

    </div>

  <?php
  endif;

  return ob_get_clean();
}


/**
 * Buttons render
 */
function nds_button_render($buttons, $buttons_arr) {

  ob_start();

  if (!empty($buttons)) :

    $anchor = '';

    if (isset($buttons['anchor']) && !empty($buttons['anchor'])) {
      $anchor = 'id="' . esc_attr($buttons['anchor']) . '" ';
    }

    $buttons_wrapper_classes = $buttons['className'] ?? '';
    $alignment = $buttons['align'] ? $buttons['align'] : 'start';
    $direction = $buttons_arr['direction'] ? 'col' : 'row';
    $gap = $buttons_arr['gap'] ?? 'gap-5';
    $buttons_items = $buttons_arr['buttons_items'] ?? '';

    if ($gap == '0') {
      $gap = 'gap-0';
    } elseif ($gap === 'sm') {
      $gap = 'gap-2.5';
    } elseif ($gap === 'lg') {
      $gap = 'gap-[1.875rem]';
    } else {
      $gap = 'gap-5';
    }

    $margin_top = $buttons['style']['spacing']['margin']['top'] ?? '0';
    $margin_top = str_replace('var:preset|spacing|', '', $margin_top);
    $margin_bottom = $buttons['style']['spacing']['margin']['bottom'] ?? '0';
    $margin_bottom = str_replace('var:preset|spacing|', '', $margin_bottom);

    $class_name = ' block-mt-' . $margin_top . ' block-mb-' . $margin_bottom;
    ?>

    <div <?php echo $anchor; ?>
      class="nds-buttons-wrapper flex flex-<?php echo $direction; ?> <?php echo $gap; ?> <?php if ($direction === 'row') { ?>justify-<?php echo $alignment; ?><?php } else { ?>items-<?php echo $alignment; ?><?php } ?><?php if ($buttons_wrapper_classes) echo ' ' . $buttons_wrapper_classes; ?> relative<?php echo $class_name; ?>"
      data-block-id="<?php echo $buttons_arr['block_data']['block_id']; ?>">

      <?php
      if ($buttons_items) {
        foreach ($buttons_items as $button) {
          $link = $button['link'] ?? '';
          $link_target = $link['target'] ?? '';
          $link_target = $link_target ? ' target="_blank"' : '';
          $style = $button['style'] ? $button['style'] : 'primary';
          $size = $button['size'] ? $button['size'] : '';
          $custom_class = $button['custom_class'] ?? '';

          if ($link['title'] && $link['url']) {
            ?>
            <a href="<?php echo esc_url($link['url']); ?>"<?php echo $link_target; ?>
               class="nds-btn nds-btn-<?php echo $style; ?> nds-btn-<?php echo $size; ?> w-fit<?php if ($custom_class) echo ' ' . $custom_class; ?>">
              <?php echo esc_html($link['title']); ?>
            </a>
            <?php
          }
        }
      }
      ?>

    </div>

  <?php

  endif;

  return ob_get_clean();
}

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
        $button_type = $button['button_type'];
        $button_link = $button['link'];
        ?>

        <?php if ($button_type === 'google') : ?>
        <a href="<?php echo esc_url($button_link['url']) ?>" target="<?php echo esc_attr($button_link['target']) ?>">
          <img
            class="block object-center object-contain max-w-[166px]"
            src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/<?php echo $button_type ?>.svg"
            width="166" height="58" decoding="async" loading="lazy"
            alt="">
        </a>
      <?php elseif ($button_type === 'apple') : ?>
        <a href="<?php echo esc_url($button_link['url']) ?>" target="<?php echo esc_attr($button_link['target']) ?>">
          <img
            class="block object-center object-contain max-w-[166px]"
            src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/<?php echo $button_type ?>.svg"
            width="166" height="58" decoding="async" loading="lazy"
            alt="">
        </a>
      <?php else :
        $button_style = $button['button_style'];
        ?>
        <a href="<?php echo esc_html($button_link['url']) ?? '' ?>" class="nds-btn nds-btn-<?php echo $button_style; ?>"
           target="<?php echo esc_html($button_link['target']) ?>"><?php echo esc_html($button_link['title']) ?></a>
      <?php endif; ?>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
  <?php
  return ob_get_clean();
}

//Container
function nds_container_block_render($block, $block_settings) {

  if (empty($block)) {
    return null;
  }

  $container_style = $block_settings['container_width'] === 'sm' ? 'container-sm' : '';
  $toggle_design = $block_settings['toggle_swirl'] ? 'nds-swirl--container' . ' ' . $block_settings['swirl_variant'] : '';

  $class_attr = nds_get_padding_classes($block_settings);

  $raw_css = isset($block_settings['custom_css']) ? (string)$block_settings['custom_css'] : '';

//  For Render CSS
  nds_render_css($raw_css);
  ob_start();
  ?>

  <section
    <?php echo nds_block_wrapper_attrs($block, $block_settings); ?>
    class="nds-container <?php echo 'bg-' . $block_settings['background_color']; ?> <?php echo $toggle_design ?> <?php echo esc_attr($class_attr); ?>  <?php echo esc_attr($block_settings['block_data']['extra_class']); ?>">
    <div class="container <?php echo esc_html($container_style) ?>">
      <InnerBlocks/>
    </div>
  </section>

  <?php
  return ob_get_clean();
}

//Content Media
function nds_content_media_render($block, $block_settings) {

  $innerblock_template = [
    ['core/heading', ['placeholder' => 'Add a heading...']],
    ['core/paragraph', ['placeholder' => 'Add your text here...']],
  ];

  if (!$block) {
    return;
  }

  $content_media_style = $block_settings['content_media_style'];


  $image = $block_settings['image'];
  $image_x = $block_settings['image_x'];
  $image_position_in_mobile = $block_settings['image_position_in_mobile'];
  $display_icon_under = $block_settings['display_icon_under'];

  $mobile_position_left = $image_position_in_mobile === 'top' ? 'order-none' : 'order-2';
  $mobile_position_right = $image_position_in_mobile === 'top' ? '-order-1' : 'order-none';

//Valid X and Y
  $valid_x = ['left', 'right'];
  $valid_y = ['top', 'bottom'];

// Combine for File Name
  if (in_array($image_x, $valid_x, true) && in_array($image_position_in_mobile, $valid_y, true)) {
    $position_class = "swirl--{$image_position_in_mobile}_$image_x";
  } else {
    $position_class = 'swirl--bottom_left';
  }

  $class_attr = nds_get_padding_classes($block_settings);

  $raw_css = isset($block_settings['custom_css']) ? (string)$block_settings['custom_css'] : '';

//  For Render CSS
  nds_render_css($raw_css);

  ob_start();
  ?>


  <?php if ($content_media_style === "decor") : ?>
    <section
      <?php echo nds_block_wrapper_attrs($block, $block_settings); ?>
      class="nds-content-media overflow-hidden bg-secondary relative nds-dark-theme <?php echo esc_attr($class_attr) ?> nds-content-media--swirl isolate <?php echo esc_html($position_class) ?> <?php echo $display_icon_under ? 'decor-under' : 'decor-above' ?>">
      <div class="container container-sm">
        <div class="nds-content-media-flex nds-content-media--decor justify-between">
          <?php if ($image_x === 'left') : ?>
            <div class="lg:order-none w-full nds-content-figure <?php echo esc_html($mobile_position_left) ?>">
              <div class="nds-figure-media lg:max-w-[637px] w-full lg:ml-0 ml-auto">
                <?php if (!empty($image)) : ?>
                  <img src="<?php echo esc_url($image['url']); ?>"
                       decoding="async"
                       class="lg:w-full w-10/12"
                       loading="lazy"
                       width="<?php echo esc_attr($image['width']); ?>"
                       height="<?php echo esc_attr($image['height']); ?>"
                       alt="<?php echo esc_attr($image['alt'] ?? ''); ?>">
                <?php elseif (is_admin()) : ?>
                  <!-- Show only in editor -->
                  <img src="https://placehold.co/600x400?text=Add+an+Image"
                       alt="Placeholder image for editor only">
                <?php endif; ?>
              </div>
            </div>
          <?php endif; ?>

          <div class="nds-content-content">
            <InnerBlocks
              template='<?php echo esc_attr(wp_json_encode($innerblock_template)); ?>'
              templateLock="false"
            />
          </div>


          <?php if ($image_x === 'right') : ?>
            <div class="lg:order-none w-full nds-content-figure <?php echo esc_html($mobile_position_right) ?>">
              <div class="nds-figure-media lg:max-w-[637px] w-full lg:mr-0 lg:ml-auto ml-0 mr-auto">
                  <?php if (!empty($image)) : ?>
                    <img src="<?php echo esc_url($image['url']); ?>"
                         decoding="async"
                         loading="lazy"
                         class="lg:w-full w-10/12"
                         width="<?php echo esc_attr($image['width']); ?>"
                         height="<?php echo esc_attr($image['height']); ?>"
                         alt="<?php echo esc_attr($image['alt'] ?? ''); ?>">
                  <?php elseif (is_admin()) : ?>
                  <!-- Show only in editor -->
                  <img src="https://placehold.co/600x400?text=Add+an+Image"
                       alt="Placeholder image for editor only">
                <?php endif; ?>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </section>
  <?php else : ?>
    <section
      <?php echo nds_block_wrapper_attrs($block, $block_settings); ?>
      class="nds-content-media overflow-hidden bg-system-white relative <?php echo esc_attr($class_attr) ?>">
      <div class="container container-sm">
        <div class="nds-content-media-flex nds-content-media--default justify-between">
          <?php if ($image_x === 'left') : ?>
            <div class="lg:order-none w-full nds-content-figure <?php echo esc_html($mobile_position_left) ?>">
              <figure class="nds-figure-media lg:max-w-[637px] w-full">
                <?php if (!empty($image)) : ?>
                  <img src="<?php echo esc_url($image['url']); ?>"
                       decoding="async"
                       loading="lazy"
                       width="<?php echo esc_attr($image['width']); ?>"
                       height="<?php echo esc_attr($image['height']); ?>"
                       alt="<?php echo esc_attr($image['alt'] ?? ''); ?>">
                <?php elseif (is_admin()) : ?>
                  <!-- Show only in editor -->
                  <img src="https://placehold.co/460x571?text=Add+an+Image"
                       alt="Placeholder image for editor only">
                <?php endif; ?>
              </figure>
            </div>
          <?php endif; ?>

          <div class="nds-content-content">
            <InnerBlocks
              template='<?php echo esc_attr(wp_json_encode($innerblock_template)); ?>'
              templateLock="false"
            />
          </div>


          <?php if ($image_x === 'right') : ?>
            <div class="lg:order-none w-full nds-content-figure <?php echo esc_html($mobile_position_right) ?>">
              <figure class="nds-figure-media lg:max-w-[637px] w-full">
                <?php if (!empty($image)) : ?>
                  <img src="<?php echo esc_url($image['url']); ?>"
                       decoding="async"
                       loading="lazy"
                       width="<?php echo esc_attr($image['width']); ?>"
                       height="<?php echo esc_attr($image['height']); ?>"
                       alt="<?php echo esc_attr($image['alt'] ?? ''); ?>">
                <?php elseif (is_admin()) : ?>
                  <!-- Show only in editor -->
                  <img src="https://placehold.co/460x571?text=Add+an+Image"
                       alt="Placeholder image for editor only">
                <?php endif; ?>
              </figure>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </section>
  <?php endif; ?>


  <?php
  return ob_get_clean();
}


// Hero
function nds_hero_render($block, $block_settings) {
  $innerblock_template = [
    ['core/heading', ['placeholder' => 'Add a heading...']],
    ['core/paragraph', ['placeholder' => 'Add your text here...']],
  ];

  if (!$block) {
    return;
  }


  $class_attr = nds_get_padding_classes($block_settings);

  $hero_image = $block_settings['hero_image'];
  $background = $block_settings['background'];
  $image_mobile_position = $block_settings['image_mobile_position'];
  $image_object_position = $block_settings['image_object_position'];
  $theme = $background === 'secondary' ? 'nds-dark-theme' : '';


  $raw_css = isset($block_settings['custom_css']) ? (string)$block_settings['custom_css'] : '';

//  For Render CSS
  nds_render_css($raw_css);

  ob_start();

  ?>
  <div
    <?php echo nds_block_wrapper_attrs($block, $block_settings); ?>
    class="nds_hero bg-<?php echo esc_html($background) ?> relative <?php echo esc_attr($class_attr) ?> <?php echo esc_html($theme) ?> ">
    <?php if ($image_mobile_position === "top") : ?>
      <figure class="lg:absolute top-0 right-0 bottom-0 max-w-[1035px] lg:w-1/2 w-full pointer-events-none mb-0!">
        <?php if (!empty($hero_image)) : ?>
          <img src="<?php echo esc_url($hero_image['url']); ?>"
               decoding="async"
               loading="lazy"
               class="<?php echo esc_attr($image_object_position['object_fit']) ?> <?php echo esc_attr($image_object_position['object_position']) ?> h-full!"
               width="<?php echo esc_attr($hero_image['width']); ?>"
               height="<?php echo esc_attr($hero_image['height']); ?>"
               alt="<?php echo esc_attr($hero_image['alt'] ?? ''); ?>">
        <?php elseif (is_admin()) : ?>
          <img src="https://placehold.co/1035x663?text=Add+an+Image"
               alt="Placeholder image for editor only">
        <?php endif; ?>

      </figure>
    <?php endif; ?>

    <div class="container">
      <section class="lg:max-w-[709px] py-8 lg:w-[50%] w-full">
        <InnerBlocks template='<?php echo esc_attr(wp_json_encode($innerblock_template)); ?>'/>
      </section>
    </div>

    <?php if ($image_mobile_position === "bottom") : ?>
      <figure class="lg:absolute top-0 right-0 bottom-0 max-w-[1035px] lg:w-1/2 w-full pointer-events-none mb-0!">
        <?php if (!empty($hero_image)) : ?>
          <img src="<?php echo esc_url($hero_image['url']); ?>"
               decoding="async"
               loading="lazy"
               class="<?php echo esc_attr($image_object_position['object_fit']) ?> <?php echo esc_attr($image_object_position['object_position']) ?> h-full!"
               width="<?php echo esc_attr($hero_image['width']); ?>"
               height="<?php echo esc_attr($hero_image['height']); ?>"
               alt="<?php echo esc_attr($hero_image['alt'] ?? ''); ?>">
        <?php elseif (is_admin()) : ?>
          <img src="https://placehold.co/1035x663?text=Add+an+Image"
               alt="Placeholder image for editor only">
        <?php endif; ?>

      </figure>
    <?php endif; ?>
  </div>
  <?php
  return ob_get_clean();
}


// Section Block
function nds_section_render($block, $block_settings) {

  if (empty($block)) {
    return;
  }

  $content_width = $block_settings['content_width'] ?? 'w-full';
  $class_attr = nds_get_padding_classes($block_settings);

  $raw_css = isset($block_settings['custom_css']) ? (string)$block_settings['custom_css'] : '';

//  For Render CSS
  nds_render_css($raw_css);
  ob_start();
  ?>
  <div
    <?php echo nds_block_wrapper_attrs($block, $block_settings); ?>
    class="nds-section <?php echo $content_width ?> <?php echo is_admin() ? '' : 'w-full'; ?>  mx-auto  <?php echo esc_attr($class_attr); ?> <?php echo esc_attr($block_settings['block_data']['extra_class']); ?> ">
    <InnerBlocks/>
  </div>

  <?php

  return ob_get_clean();
}


function nds_accordion_render($block, $block_settings) {

  $allowed_blocks = ['nds/accordion-item',];
  $innerblock_template = [
    ['nds/accordion-item'],
  ];

  if (empty($block)) {
    return null;
  }

  $raw_css = isset($block_settings['custom_css']) ? (string)$block_settings['custom_css'] : '';

//  For Render CSS
  nds_render_css($raw_css);
  ob_start();
  ?>
  <div
    <?php echo nds_block_wrapper_attrs($block, $block_settings); ?>
    class="nds_accordion-container <?php echo esc_attr($block_settings['block_data']['extra_class']); ?>">
    <div
      class="<?php echo !is_admin() ? 'nds_js-accordion' : ''; ?> nds_accordion-container--list flex flex-col gap-y-6">
      <InnerBlocks
        allowedBlocks='<?php echo esc_attr(wp_json_encode($allowed_blocks)); ?>'
        template='<?php echo esc_attr(wp_json_encode($innerblock_template)); ?>'
      />
    </div>
  </div>
  <?php

  return ob_get_clean();
}


function nds_accordion_item_render($block, $block_settings) {


  $innerblock_template = [
    ['core/paragraph', ['placeholder' => 'Add your text here...']],
  ];

  if (empty($block)) {
    return null;
  }


  $heading = $block_settings['heading'];

  ob_start();
  ?>
  <div
    <?php echo nds_block_wrapper_attrs($block, $block_settings); ?>
    class="nds_accordion-item rounded-lg bg-white p-8  <?php echo esc_attr($block_settings['block_data']['extra_class']); ?> ">
    <button class="nds_accordion-item--btn flex justify-between items-center w-full relative" aria-expanded="false">
      <span class="font-bold text-[18px] font-secondary text-left"><?php echo esc_html($heading) ?></span>
      <span class="nds_accordion-item--icon size-8 rounded-full flex items-center justify-center"></span>
    </button>

    <div class="nds_accordion-item--content overflow-hidden">
      <div class="mt-4">
        <InnerBlocks
          template='<?php echo esc_attr(wp_json_encode($innerblock_template)); ?>'
        />
      </div>
    </div>
  </div>
  <?php

  return ob_get_clean();
}

function nds_testimonial_carousel_render($block, $block_settings) {

  if (empty($block)) return null;


  $reviews = $block_settings['reviews'] ?? [];
  $raw_css = isset($block_settings['custom_css']) ? (string)$block_settings['custom_css'] : '';

//  For Render CSS
  nds_render_css($raw_css);

  ob_start();
  ?>

  <?php if (is_admin()) : ?>
    <?php if ($reviews) : ?>
      <div
        <?php echo nds_block_wrapper_attrs($block, $block_settings); ?>
        class="testimonial-carousel-list--editor flex  <?php echo esc_attr($block_settings['block_data']['extra_class']); ?>">
        <?php foreach ($reviews as $review): ?>
          <!--      Check if there is Message -->
          <?php if (!empty($review['message'])): ?>
            <section class="testimonial-carousel-card--editor">
              <div class="flex gap-10 flex-col bg-white rounded-[30px] p-12 h-full">
                <!--  Check Rating    -->
                <?php if (!empty($review['rating'])):
                  $rating = (int)$review['rating']; // 3
                  ?>
                  <ul class="nds_testimonial_carousel--star  flex gap-4">
                    <?php for ($i = 0; $i < $rating; $i++) : ?>
                      <li class="list-none!">
                        <img src="<?php echo get_template_directory_uri() ?>/assets/images/icons/star.svg" alt="star"
                             decoding="async"
                             loading="lazy"
                             width="30"
                             height="30"
                             class="size-7 block"
                        >
                      </li>
                    <?php endfor; ?>
                  </ul>

                <?php endif ?>

                <blockquote
                  class="nds_testimonial_carousel--message font-secondary font-[18px] m-0! relative">
                  <?php echo esc_html($review['message']) ?>
                </blockquote>
                <?php if (!empty($review['author'])): ?>
                  <span class="font-bold text-[18px]"> <?php echo esc_html($review['author']) ?> </span>
                <?php endif ?>

              </div>
            </section>
          <?php endif; ?>

        <?php endforeach; ?>
      </div>

    <?php else: ?>
      <h2>No Review Available</h2>
    <?php endif ?>
    <!--  FRONT END-->
  <?php else: ?>
    <?php if ($reviews) : ?>
      <div
        <?php echo nds_block_wrapper_attrs($block, $block_settings); ?>
        class="splide nds_testimonial_carousel  <?php echo esc_attr($block_settings['block_data']['extra_class']); ?>" role="group">
        <div class="splide__track">
          <div class="splide__list">

            <?php foreach ($reviews as $review): ?>
              <!--      Check if there is Message -->
              <?php if (!empty($review['message'])): ?>
                <section class="splide__slide">
                  <div class="flex gap-10 flex-col bg-white rounded-[30px] p-12 h-full">
                    <!--  Check Rating    -->
                    <?php if (!empty($review['rating'])):
                      $rating = (int)$review['rating']; // 3
                      ?>
                      <ul class="nds_testimonial_carousel--star  flex gap-4">
                        <?php for ($i = 0; $i < $rating; $i++) : ?>
                          <li class="list-none!">
                            <img src="<?php echo get_template_directory_uri() ?>/assets/images/icons/star.svg"
                                 alt="star"
                                 decoding="async"
                                 loading="lazy"
                                 width="30"
                                 height="30"
                                 class="size-7 block"
                            >
                          </li>
                        <?php endfor; ?>
                      </ul>

                    <?php endif ?>

                    <blockquote
                      class="nds_testimonial_carousel--message font-secondary font-[18px] relative">
                      <?php echo esc_html($review['message']) ?>
                    </blockquote>
                    <?php if (!empty($review['author'])): ?>
                      <span class="font-bold text-[18px]"> <?php echo esc_html($review['author']) ?> </span>
                    <?php endif ?>

                  </div>
                </section>
              <?php endif; ?>

            <?php endforeach; ?>


          </div>
        </div>
        <div class="splide__arrows">
          <button class="splide__arrow splide__arrow--prev">
            <img src="<?php echo get_template_directory_uri() ?>/assets/images/icons/arrow-right.svg" alt="arrow"
                 decoding="async"
                 loading="lazy"
                 width="20"
                 height="20"
                 class="size-5 block"
            >
          </button>
          <button class="splide__arrow splide__arrow--next">
            <img src="<?php echo get_template_directory_uri() ?>/assets/images/icons/arrow-right.svg" alt="arrow"
                 decoding="async"
                 loading="lazy"
                 width="20"
                 height="20"
                 class="size-5 block"
            >
          </button>
        </div>


      </div>
    <?php else: ?>
      <h2>No Review Available</h2>
    <?php endif ?>
  <?php endif; ?>


  <?php

  return ob_get_clean();
}

function nds_table_of_content($block, $block_settings) {

  if (empty($block)) {
    return null;
  }


  ob_start();
  ?>

  <div
    <?php echo nds_block_wrapper_attrs($block, $block_settings); ?>
    class="nds_tob_container flex lg:flex-row flex-col gap-x-20 gap-y-5 <?php echo esc_attr($block_settings['block_data']['extra_class']); ?>"
  >
    <div class="nds_tob_aside max-w-[295px] w-full relative">
      <div class="bg-primary-tint p-10 rounded-xl sticky top-0">
        <h5 class="font-secondary text-[18px] font-bold pb-8">Table of Contents</h5>
        <ul class="nds_tob_aside--list flex flex-col gap-8">
        </ul>
      </div>
    </div>
    <div class="nds_tob_main lg:max-w-[952px] w-full">
      <InnerBlocks/>
    </div>
  </div>

  <?php
  return ob_get_clean();
}


function nds_call_to_action_render($block, $block_settings) {

  if (empty($block)) {
    return null;
  }
  $image = $block_settings['image'];
  $class_attr = nds_get_padding_classes($block_settings);
  $image_position_mobile = $block_settings['image_position_in_mobile'];
  $image_position = $block_settings['image_position'];

  if ($image_position === 'right') {
    $figureStyle = 'right-0';
    $sectionStyle = '';
    $imageStyle = 'object-left';
  } else {
    $figureStyle = 'left-0';
    $sectionStyle = 'lg:ml-auto';
    $imageStyle = 'object-right';
  }

  $raw_css = isset($block_settings['custom_css']) ? (string)$block_settings['custom_css'] : '';

//  For Render CSS
  nds_render_css($raw_css);

  ob_start();
  ?>

  <section
    <?php echo nds_block_wrapper_attrs($block, $block_settings); ?>
    class="nds-container bg-secondary relative <?php echo esc_attr($class_attr) ?> <?php echo esc_attr($block_settings['block_data']['extra_class']); ?>">
    <div class="container">
      <?php if ($image_position_mobile === 'top'): ?>
        <figure
          class="lg:absolute top-0 bottom-0 !mb-0 <?php echo esc_attr($figureStyle) ?> h-full overflow-hidden lg:max-w-[1000px] lg:w-1/2 w-full">
          <?php if (!empty($image)) : ?>
            <img src="<?php echo esc_url($image['url']); ?>"
                 decoding="async"
                 class="h-full! object-cover <?php echo esc_attr($imageStyle) ?>"
                 loading="lazy"
                 width="<?php echo esc_attr($image['width']); ?>"
                 height="<?php echo esc_attr($image['height']); ?>"
                 alt="<?php echo esc_attr($image['alt'] ?? ''); ?>">
          <?php elseif (is_admin()) : ?>
            <!-- Show only in editor -->
            <img src="https://placehold.co/1017x534?text=Add+an+Image"
                 alt="Placeholder image for editor only">
          <?php endif; ?>
        </figure>
      <?php endif; ?>
      <section class="lg:max-w-[543px] w-full lg:my-0 my-5 <?php echo esc_attr($sectionStyle) ?>">
        <InnerBlocks/>
      </section>
      <?php if ($image_position_mobile === 'bottom'): ?>
        <figure
          class="lg:absolute top-0 bottom-0 !mb-0  <?php echo esc_attr($figureStyle) ?> h-full overflow-hidden lg:max-w-[1000px] lg:w-1/2 w-full">
          <?php if (!empty($image)) : ?>
            <img src="<?php echo esc_url($image['url']); ?>"
                 decoding="async"
                 class="h-full! object-cover <?php echo esc_attr($imageStyle) ?>"
                 loading="lazy"
                 width="<?php echo esc_attr($image['width']); ?>"
                 height="<?php echo esc_attr($image['height']); ?>"
                 alt="<?php echo esc_attr($image['alt'] ?? ''); ?>">
          <?php elseif (is_admin()) : ?>
            <!-- Show only in editor -->
            <img src="https://placehold.co/1017x534?text=Add+an+Image"
                 alt="Placeholder image for editor only">
          <?php endif; ?>
        </figure>
      <?php endif; ?>
    </div>

  </section>


  <?php
  return ob_get_clean();
}