<?php

/**
 * Header content template
 *
 * @package NDS
 */

$header_class = ' relative z-50 bg-white transition-all duration-200';

$acf_general_settings = get_field('acf_general_settings', 'option');
$acf_header_settings = get_field('acf_header_settings', 'option');
$header_cta = $acf_header_settings['header_cta'] ?? '';
$header_cta_buttons = $header_cta['buttons'] ?? '';
$header_2_nav = $acf_header_settings['header_2_menu'] ?? '';

?>
<header class="nds-header <?php echo $header_class; ?> py-[.9375rem] min-lg:py-0">
  <div class="container">
    <div class="lg:flex lg:justify-between lg:items-center">
      <div class="w-full flex justify-between items-center xl:gap-x-16 gap-x-2.5">
        <div class="relative max-w-[144px]">
          <?php if (has_custom_logo()) { ?>
            <?php the_custom_logo(); ?>
          <?php } else { ?>
            <a href="<?php echo get_bloginfo('url'); ?>" class="font-extrabold text-lg uppercase">
              <?php echo get_bloginfo('name'); ?>
            </a>

            <p class="text-sm font-light text-gray-600">
              <?php echo get_bloginfo('description'); ?>
            </p>

          <?php } ?>
        </div>

        <?php
        wp_nav_menu(
          array(
            'container_id' => 'primary-menu',
            'container_class' => 'nds-primary-menu hidden min-lg:block',
            'menu_class' => 'flex gap-x-7',
            'theme_location' => 'primary',
            'li_class' => '',
            'fallback_cb' => false,
          )
        );
        ?>

        <div class="min-lg:flex hidden items-center justify-center gap-4">
          <?php if ($header_2_nav) : ?>
            <ul>
              <?php foreach ($header_2_nav as $item) :
                $title = $item['page_link']['title'] ?? '';
                $url = $item['page_link']['url'] ?? '#';
                $target = $item['page_link']['target'] ?: '_self';
              ?>
                <li>
                  <a href="<?php echo esc_url($url); ?>" target="<?php echo esc_attr($target); ?>"
                    class="flex items-center gap-x-2.5 text-secondary font-bold !no-underline pt-9 pb-[2.125rem] relative transition-all duration-300 min-xl:text-[16px] text-base hover:text-trinary">
                    <?php echo esc_html($title); ?>
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
          <?php if ($header_cta_buttons) : ?>
            <div class="nds-header-ctas items-center gap-[1.625rem] flex">
              <?php
              foreach ($header_cta_buttons as $button) :
                $link = $button['link'];
                $custom_class = $button['custom_class']; ?>

                <a href="<?php echo esc_url($link['url']); ?>" class="nds-btn nds-btn-primary <?php echo $custom_class ?>"
                  target="<?php echo esc_attr($link['target']); ?>">
                  <?php echo esc_html($link['title']); ?>
                </a>

              <?php endforeach; ?>

            </div>
          <?php endif; ?>
        </div>

        <div class="lg:hidden">
          <button type="button" aria-label="Toggle navigation" class="primary-menu-toggle flex flex-col gap-[.4375rem]">
            <span class="line"></span>
            <span class="line"></span>
            <span class="line"></span>
          </button>
        </div>

      </div>

    </div>
  </div>
</header>