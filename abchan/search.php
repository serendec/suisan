<?php get_header(); ?>
<main class="l-main p-main">
	<div class="p-page-header">
		<div>
			<h1 class="p-page-header__title">サイト内検索</h1>
			<div class="p-page-header__title-en">Search</div>
		</div>
	</div>

	<div class="container">

		<?php get_template_part('part', 'breadcrumb'); ?>

		<div class="l-inner">
			<h2 class="c-heading c-heading--logo">「<?php echo get_search_query(); ?>」の検索結果</h2>
			<?php if (have_posts()) : ?>

				<ul class="p-news-list p-news-list--2">
					<?php while (have_posts()) : the_post(); ?>


						<li class="p-news-item js-waves">
							<a href="<?php the_permalink(); ?>">
								<div class="p-news-item__title">
									<?php the_title(); ?>
								</div>
								<div class="c-sq-btn"></div>
							</a>
						</li>


					<?php endwhile; ?>
				</ul>
			<?php else : ?>
				<p>該当なし</p>
			<?php endif; ?>




			<div class="p-pagenation mb-0">
				<?php the_posts_pagination(
					array(
						// 'prev_next' => false,
						'prev_text' => '<span class="c-sq-btn"></span>',
						'next_text' => '<span class="c-sq-btn"></span>',
						'type'      => 'list',
					)
				); ?>
			</div>

		</div>
	</div>
</main>
<?php get_footer(); ?>