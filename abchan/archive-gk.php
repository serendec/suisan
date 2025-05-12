<?php get_header(); ?>
<main class="l-main p-main">
	<div class="p-page-header">
		<div>
			<h1 class="p-page-header__title">
				漁海況予報
			</h1>
			<div class="p-page-header__title-en">fishing and ocean conditions forecast</div>
		</div>
	</div>

	<div class="container">

		<?php get_template_part('part', 'breadcrumb'); ?>

		<div class="l-inner">
			<h2 class="c-h3 mb-4">漁海況予報</h2>
			<ul class="p-link-bar-list mb-5">
				<?php
				$taxonomy = 'fiscal-year';
				$args = array(
					'hide_empty' => false,
					'parent' => 0,
					'number' => 2,
				);
				$terms = get_terms($taxonomy, $args);
				foreach ($terms as $term) :
					$term_link = get_term_link($term, $taxonomy);
				?>
					<li><a href="<?php echo $term_link; ?>" class="js-waves"><?php echo $term->name; ?>の漁海況予報<span class="c-sq-btn"></span></a></li>
				<?php endforeach; ?>

				<li>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>gk/backnumber/" class="js-waves">
					過去の漁海況予報<span class="c-sq-btn"></span>
					</a>
				</li>
			</ul>



		</div>
		<!-- .l-inner -->


	</div>

	<?php get_template_part('part', 'related-link'); ?>
</main>

<?php get_template_part('part', 'aside'); ?>
<?php get_template_part('part', 'banners'); ?>
<?php get_footer(); ?>