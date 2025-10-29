<!DOCTYPE html>
<html <?php language_attributes(); ?> class="overflow-x-hidden">

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width">
  <link rel="profile" href="http://gmpg.org/xfn/11">
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

  <?php wp_head(); ?>
</head>

<body <?php body_class('bg-white text-gray-900 antialiased overflow-x-hidden max-w-[1920px] mx-auto! w-full'); ?>

  <?php do_action('nds_site_before'); ?>

  <div id="page" class="min-h-screen flex flex-col">

  <?php do_action('nds_header'); ?>

  <?php get_template_part('template-parts/layout/header', 'content'); ?>

  <div id="content" class="site-content grow lg:mt-16">

    <?php do_action('nds_content_start'); ?>

    <main>