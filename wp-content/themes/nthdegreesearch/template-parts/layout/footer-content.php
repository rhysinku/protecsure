<?php
/**
 * Template part for displaying the footer content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Nth_Degree_Search
 */


function nds_has_menu_items($theme_location) {
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
  <footer id="colophon" class="site-footer bg-white overflow-x-hidden" role="contentinfo">
    <div class="container py-16">
      <div class="flex justify-between flex-col lg:flex-row gap-y-8">
        <div class="relative max-w-[166px] w-full">
          <?php if ($logo) : ?>
            <figure>
              <img src="<?php echo esc_url($logo['url']) ?>" width="166" height="126" decoding="async" loading="lazy"
                   alt="<?php echo get_bloginfo('name'); ?>">
            </figure>
          <?php endif; ?>
          <?php if ($social_media) : ?>
            <ul class="flex gap-4 items-center mt-8">
              <?php foreach ($social_media as $social) :
                $link = $social['link'] ?? '';
                ?>
                <?php if ($link['url'])  : ?>
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
        <div class="flex lg:max-w-[812px] w-full justify-between flex-col md:flex-row gap-y-8">
          <div class="lg:max-w-[150px] w-full">
            <?php if (nds_has_menu_items('footer')) : ?>
              <h2 class="mb-8 text-secondary! font-bold text-[1.125rem]">Quick Links</h2>
              <?php
              wp_nav_menu(
                array(
                  'container_id' => 'quick-link',
                  'container_class' => 'nds-quick-link-menu footer-menu',
                  'menu_class' => 'flex gap-y-7 flex-col',
                  'theme_location' => 'footer',
                  'li_class' => 'list-none! footer-menu--item',
                  'fallback_cb' => false,
                )
              );
              ?>
            <?php endif; ?>
          </div>
          <div class="lg:max-w-[150px] w-full">
            <?php if (nds_has_menu_items('footer-2')): ?>
              <h2 class="mb-8 text-secondary! font-bold text-[1.125rem]">More</h2>
              <?php
              wp_nav_menu(
                array(
                  'container_id' => 'footer-more',
                  'container_class' => 'nds-footer-more-menu footer-menu',
                  'menu_class' => 'flex gap-y-7 flex-col',
                  'theme_location' => 'footer-2',
                  'li_class' => 'list-none! footer-menu--item',
                  'fallback_cb' => false,
                )
              );
              ?>
            <?php endif; ?>
          </div>
          <div class="lg:max-w-[175px] w-full">
            <?php if ($footer_side) : ?>
              <?php if ($footer_side['title']) : ?>
                <h2 class="mb-8 text-secondary! font-bold text-[1.125rem]">
                  <?php echo esc_html($footer_side['title']); ?>
                </h2>
              <?php endif; ?>
              <?php if ($footer_side['link']) : ?>
                <ul class="flex flex-wrap lg:flex-col gap-5">
                  <?php foreach ($footer_side['link'] as $item) :
                    $link = $item['link'];
                    ?>
                    <li class="list-none">
                      <a href="<?php echo esc_url($link['url']) ?>" target="<?php echo esc_attr($link['target']) ?>">
                        <img
                          class="block object-center object-contain max-w-[166px]"
                          src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/<?php echo $item['options'] ?>.svg"
                          width="166" height="58" decoding="async" loading="lazy"
                          alt="">
                      </a>
                    </li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>


            <?php endif ?>
          </div>

        </div>
      </div>
    </div>
    <div class="bg-secondary p-6 text-white text-center font-medium">
      <?php echo wp_kses_post($copyright_side); ?>
    </div>
  </footer>

<?php get_template_part('template-parts/layout/mobile-menu-content'); ?>