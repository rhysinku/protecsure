<?php

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
                <blockquote
                  class="nds_testimonial_carousel--message font-secondary font-[18px] m-0! relative">
                  <?php echo esc_html($review['message']) ?>
                </blockquote>
                <div class="flex flex-col items-center">
                  <figure class="size-12 rounded-full overflow-hidden">
                    <?php if (!empty($review['avatar'])): ?>
                      <img src="<?php echo $review['avatar']['sizes']['thumbnail'] ?>" alt="<?php echo $review['avatar']['description'] ?>"
                        decoding="async"
                        loading="lazy"
                        width="48"
                        height="48">
                    <?php else: ?>
                      <img src="<?php echo get_template_directory_uri() ?>/assets/images/icons/avatar.svg" alt="avatar"
                        decoding="async"
                        loading="lazy"
                        width="48"
                        height="48">
                    <?php endif ?>

                  </figure>
                  <?php if (!empty($review['author'])): ?>
                    <span class="font-bold text-[18px]"> <?php echo esc_html($review['author']) ?> </span>
                    <?php if (!empty($review['status'])) : ?>
                      <span class="font-light text-system-accent block"> <?php echo esc_html($review['status']) ?> </span>
                    <?php endif; ?>
                  <?php endif ?>
                </div>

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
                  <div class="flex gap-10 flex-col bg-white rounded-[30px] p-12 h-full text-center">
                    <blockquote
                      class="nds_testimonial_carousel--message font-secondary font-[18px] relative">
                      <?php echo esc_html($review['message']) ?>
                    </blockquote>
                    <div class="flex flex-col items-center">
                      <figure class="size-12 rounded-full overflow-hidden">
                        <?php if (!empty($review['avatar'])): ?>
                          <img src="<?php echo $review['avatar']['sizes']['thumbnail'] ?>" alt="<?php echo $review['avatar']['description'] ?>"
                            decoding="async"
                            loading="lazy"
                            width="48"
                            height="48">
                        <?php else: ?>
                          <img src="<?php echo get_template_directory_uri() ?>/assets/images/icons/avatar.svg" alt="avatar"
                            decoding="async"
                            loading="lazy"
                            width="48"
                            height="48">
                        <?php endif ?>

                      </figure>
                      <?php if (!empty($review['author'])): ?>
                        <span class="font-bold text-[18px]"> <?php echo esc_html($review['author']) ?> </span>
                        <?php if (!empty($review['status'])) : ?>
                          <span class="font-light text-system-accent block"> <?php echo esc_html($review['status']) ?> </span>
                        <?php endif; ?>
                      <?php endif ?>
                    </div>
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
              class="size-5 block">
          </button>
          <button class="splide__arrow splide__arrow--next">
            <img src="<?php echo get_template_directory_uri() ?>/assets/images/icons/arrow-right.svg" alt="arrow"
              decoding="async"
              loading="lazy"
              width="20"
              height="20"
              class="size-5 block">
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
