<?php
require_once get_template_directory() . '/inc/theme-setup.php';
require_once get_template_directory() . '/inc/enqueue-scripts.php';
require_once get_template_directory() . '/inc/acf-functions.php';
require_once get_template_directory() . '/inc/template-tags.php';
require_once get_template_directory() . '/inc/custom-functions.php';

add_filter('wpcf7_autop_or_not', '__return_false');