<?php

/**
 * Template part for displaying the footer content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Nth_Degree_Search
 */


function nds_has_menu_items($theme_location)
{
  if (!has_nav_menu($theme_location)) {
    return false;
  }

  $locations = get_nav_menu_locations();
  $menu_id = $locations[$theme_location] ?? false;

  if (!$menu_id) {
    return false;
  }

  $menu_items = wp_get_nav_menu_items($menu_id);

  return !empty($menu_items);
}


$acf_footer_settings = get_field('acf_footer_settings', 'option');
$logo = $acf_footer_settings['footer_logo'] ?? '';
$social_media = $acf_footer_settings['social_media'] ?? '';
$footer_side = $acf_footer_settings['footer_side'] ?? '';
$copyright_side = $acf_footer_settings['footer_copyright_text'] ?? '';

?>
<footer id="colophon" class="site-footer bg-trinary overflow-x-hidden" role="contentinfo">
  <div class="container py-[50px]">
    <div class="flex justify-between flex-col lg:flex-row gap-y-8 gap-x-[76px]">
      <div class="relative max-w-[275px] w-full">
        <?php if ($logo) : ?>
          <figure>
            <img src="<?php echo esc_url($logo['url']) ?>" width="168" height="27" decoding="async" loading="lazy"
              alt="<?php echo get_bloginfo('name'); ?>">
          </figure>
        <?php endif; ?>

        <div class="mt-6 flex flex-col gap-y-3">
          <div class="text-white">
            <h2 class="text-white text-[18px] font-bold mb-4">For More Information</h2>
            <div class="text-[16px]">
              <a href="">info@protecsure.com.au</a>
              <address>1300 COVERIT (1300 268 374)</address>
            </div>
          </div>

          <div class="text-white">
            <h2 class="text-white text-[18px] font-bold mb-4">For Claims</h2>
            <div class="text-[16px]">
              <a href="">claims@protecsure.com.au</a>
              <address>1300 MYCLAIM (1300 692 524)</address>
            </div>
          </div>
        </div>
      </div>

      <div class="w-full self-end">
        <div class="flex gap-x-16">
          <div class="w-full mb-2.5">
            <?php if (nds_has_menu_items('footer')) : ?>
              <?php
              wp_nav_menu(
                array(
                  'container_id' => 'quick-link',
                  'container_class' => 'nds-quick-link-menu footer-menu',
                  'menu_class' => 'flex gap-y-7 justify-between',
                  'theme_location' => 'footer',
                  'li_class' => 'list-none! footer-menu--item',
                  'fallback_cb' => false,
                )
              );
              ?>
            <?php endif; ?>
          </div>

          <div class="max-w-[166px] w-full">

            <?php if ($footer_side['link']) : ?>
              <ul>
                <?php foreach ($footer_side['link'] as $footer_link) :
                  $link = $footer_link['link'];
                  $className = $footer_link['classname']
                ?>
                  <?php if ($link['url']) : ?>
                    <li class="list-none!">
                      <a href="<?php echo esc_url($link['url']); ?>" class="no-underline! <?php echo $className ?>" target=" <?php echo esc_attr($link['target']); ?>">
                        <?php echo esc_html($link['title']); ?>
                      </a>
                    </li>
                  <?php endif; ?>
                <?php endforeach; ?>
              </ul>
            <?php endif ?>

            <?php if ($social_media) : ?>
              <ul class="flex gap-4 items-center mt-8 justify-end">
                <?php foreach ($social_media as $social) :
                  $link = $social['link'] ?? '';
                ?>
                  <?php if ($link['url']) : ?>
                    <li class="list-none!">
                      <a href="<?php echo esc_url($link['url']) ?>" target="<?php echo esc_attr($link['target']) ?>">
                        <span class="size-6 bg-secondary hover:bg-trinary rounded-lg flex items-center justify-center">
                          <img
                            class="size-3 block object-center object-contain"
                            src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/<?php echo esc_html($social['icon']) ?>.svg"
                            width="12" height="12" decoding="async" loading="lazy"
                            alt="<?php echo esc_html($social['icon']) ?>">
                        </span>
                      </a>
                    </li>
                  <?php endif; ?>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </div>
        </div>

        <div class="text-white text-[14px] mt-3.5">
          <?php echo wp_kses_post($copyright_side); ?>
        </div>
      </div>
    </div>

    <div class="w-full pt-11">
      <?php if (nds_has_menu_items('footer-2')): ?>
        <?php
        wp_nav_menu(
          array(
            'container_id' => 'footer-more',
            'container_class' => 'nds-footer-more-menu footer-menu',
            'menu_class' => 'flex gap-y-7 justify-between',
            'theme_location' => 'footer-2',
            'li_class' => 'list-none! footer-menu--item text-[14px]',
            'fallback_cb' => false,
          )
        );
        ?>
      <?php endif; ?>
    </div>
  </div>





</footer>

<?php get_template_part('template-parts/layout/mobile-menu-content'); ?>