<?php get_header(); ?>

<main class="l-main p-main">
	<div class="p-page-header">
		<div>
			<h1 class="p-page-header__title"><?php the_title(); ?></h1>
			<div class="p-page-header__title-en"><?php echo get_post($wp_query->post->ID)->post_name; ?></div>
		</div>
	</div>
	<div class="container">

		<?php get_template_part('part', 'breadcrumb'); ?>

		<?php if (!is_page(array('yougo'))) : ?>
			<div class="l-inner">
			<?php endif; ?>

			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
					<?php remove_filter('the_content', 'wpautop'); ?>
					<?php the_content(); ?>
				<?php endwhile; ?>
			<?php endif; ?>

			<?php if (!is_page(array('yougo'))) : ?>
			</div>
		<?php endif; ?>


	</div>

<?php get_template_part('part', 'related-link'); ?>
</main>

<?php get_template_part('part', 'aside'); ?>
<?php get_template_part('part', 'banners'); ?>
<?php get_footer(); ?>