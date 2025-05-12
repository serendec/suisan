<?php get_header(); ?>
<main class="l-main p-main">
	<div class="p-page-header">
		<div>
			<h1 class="p-page-header__title">
				更新情報
			</h1>
			<div class="p-page-header__title-en">UPDATE</div>
		</div>
	</div>

	<div class="container">

		<?php get_template_part('part', 'breadcrumb'); ?>

		<div class="l-inner">

			<div class="p-single">
				<div class="p-single__header">
					<h1 class="p-single__title"><?php the_title(); ?></h1>
					<div class="p-single__meta">
						<div class="p-single__date"><?php the_time('Y.m.d') ?></div>

						<?php if ($terms = get_the_terms($post->ID, 'update-cat')): ?>
						<ul class="c-label-list">
							<?php foreach ( $terms as $term ): ?>
							<li class="c-label<?php if( $term->name === '漁海況予報'){ echo ' c-label--theme-light';} ?>"><span class="main"><?php echo $term->name; ?></span></li>
							<?php endforeach; ?>
						</ul>
						<?php endif; ?>
					</div>
				</div>


				<div class="p-single__body">
					<?php the_content(); ?>
				</div>


			</div>
			<!-- .p-single -->


			<a href="<?php echo esc_url( home_url( '/' ) ); ?>update/" class="mt-5 mx-auto p-button p-button--dark">一覧へ戻る</a>

		</div>
		<!-- .l-inner -->


	</div>

	<?php get_template_part('part', 'related-link'); ?>
</main>

<?php get_template_part('part', 'aside'); ?>
<?php get_template_part('part', 'banners'); ?>
<?php get_footer(); ?>