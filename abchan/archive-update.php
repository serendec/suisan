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

			<ul class="p-category-link mb-5">
				<li class="is-active"><a href="<?php echo esc_url( home_url( '/' ) ); ?>update/">すべて</a></li>
			<?php
			$taxonomy = 'update-cat';
			$args = array(
				'hide_empty' => false,
				'parent' => 0
			);
			$terms = get_terms( $taxonomy , $args );
			foreach ( $terms as $term ):
				$term_link = get_term_link( $term, $taxonomy );
				?>
				<li class="<?php if( $term->name === '漁海況予報'){ echo ' is-cat2';} elseif($term->name === '水産資源評価結果') { echo ' is-cat1';} ?>">
					<a href="<?php echo $term_link ; ?>"><?php echo $term->name ; ?></a>
				</li>
			<?php endforeach; ?>
			</ul>

			<?php if(have_posts()):?>
				<ul class="p-news-list">
					<?php while(have_posts()): the_post();?>
						<li class="p-news-item js-waves">
							<a href="<?php if(get_field('リンク')):?><?php the_field('リンク'); ?><?php else : ?><?php the_permalink(); ?><?php endif;?>" <?php if(get_field('別ウィンドウで開く')):?> target="_blank"<?php endif;?>>

								<div class="p-news-item__meta">
									<div class="p-news-item__date"><?php the_time('Y.m.d') ?></div>

									<?php if ($terms = get_the_terms($post->ID, 'update-cat')): ?>
									<ul class="c-label-list">
										<?php foreach ( $terms as $term ): ?>
										<li class="c-label<?php if( $term->name === '漁海況予報'){ echo ' c-label--theme-light';} ?>"><span class="main"><?php echo $term->name; ?></span></li>
										<?php endforeach; ?>
									</ul>
									<?php endif; ?>
								</div>
								<div class="p-news-item__title">
									<?php the_title(); ?>

									<?php if(get_field('別ウィンドウで開く')):?><i class="far fa-external-link-alt"></i><?php endif; ?>

								</div>
							</a>
						</li>
					<?php endwhile;?>
				</ul>
			<?php endif;?>

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
		<!-- .l-inner -->


	</div>

	<?php get_template_part('part', 'related-link'); ?>
</main>

<?php get_template_part('part', 'aside'); ?>
<?php get_template_part('part', 'banners'); ?>
<?php get_footer(); ?>