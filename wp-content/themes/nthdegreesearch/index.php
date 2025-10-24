<?php 
get_header(); 

$post_format = get_post_format();
$template_slug = $post_format ? $post_format : ( is_page() ? 'page' : null );
?>

<?php if ( have_posts() ) : ?>
	<?php
	while ( have_posts() ) :
		the_post();
		?>

		<?php get_template_part( 'template-parts/content', $template_slug ); ?>

	<?php endwhile; ?>

<?php endif; ?>

<?php
get_footer();
