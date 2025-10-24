<?php
$acf_header_settings = get_field('acf_header_settings', 'option');
$header_cta = $acf_header_settings['header_cta'] ?? '';
$header_cta_buttons = $header_cta['buttons'] ?? '';
$header_2_nav = $acf_header_settings['header_2_menu'] ?? '';


?>

<?php if ($header_2_nav) : ?>
  <div class="nds-mobile-primary-menu-2">
    <ul class="flex flex-col gap-5">
      <?php foreach ($header_2_nav as $item) :
        $title = $item['page_link']['title'] ?? '';
        $url = $item['page_link']['url'] ?? '#';
        $target = $item['page_link']['target'] ?: '_self';
        ?>
        <li>
          <a href="<?php echo esc_url($url); ?>" target="<?php echo esc_attr($target); ?>">
            <?php echo esc_html($title); ?>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>
<?php if ($header_cta_buttons) : ?>
  <div class="nds-header-ctas items-center gap-[1.625rem] flex mt-3">
    <?php
    foreach ($header_cta_buttons as $button) :
      $link = $button['link'];
      $custom_class = $button['custom_class']; ?>

      <a href="<?php echo esc_url($link['url']); ?>" class="nds-btn nds-btn-primary"
         target="<?php echo esc_attr($link['target']); ?>">
        <?php echo esc_html($link['title']); ?>
      </a>

    <?php endforeach; ?>

  </div>
<?php endif; ?>