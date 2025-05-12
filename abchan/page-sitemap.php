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

		<div class="l-inner">

			<ul class="p-link-bar-list">
				<li class="p-link-bar"><a href="<?php echo esc_url(home_url('/')); ?>">トップページ<span class="c-sq-btn"></span></a></li>

				<li class="p-link-bar"><a href="<?php echo esc_url(home_url('/')); ?>about/">水産資源評価とは<span class="c-sq-btn"></span></a></li>
				<ul class="p-list p-list--arrow p-3">
					<li><a href="<?php echo esc_url(home_url('/')); ?>about/taisei/">水産資源評価の実施体制と進め方</a></li>
					<li><a href="<?php echo esc_url(home_url('/')); ?>about/references_list/">水産資源評価のための基礎資料</a></li>
					<li><a href="<?php echo esc_url(home_url('/')); ?>about/yougo/">用語集</a></li>
				</ul>

				<li class="p-link-bar"><a href="/hyouka/">水産資源評価結果<span class="c-sq-btn"></span></a></li>


				<?php
				$page_parent = get_page_by_path('hyouka')->ID;
				$page_datatable = get_page_by_path('hyouka/datatable')->ID;
				$page_citation_guide = get_page_by_path('hyouka/citation-guide')->ID;
				$page_backnumber = get_page_by_path('hyouka/backnumber')->ID;
				$page_documents = get_page_by_path('hyouka/documents')->ID;
				$args = array(
					'posts_per_page' => -1,
					'post_parent' => $page_parent,
					'post_type' => 'page',
					'exclude' => array($page_datatable, $page_citation_guide, $page_backnumber, $page_documents)
					// 'order' => 'ASC'
				);
				$page_child = get_posts($args);
				?>
				<ul class="p-list p-list--arrow p-3">
					<?php
					foreach ($page_child as $child) :
						$child_id = $child->ID;
					?>
						<li>
							<a href="<?php echo get_the_permalink($child_id); ?>">
								<?php echo get_the_title($child_id); ?>
							</a>
						</li>
					<?php endforeach; ?>


					<li><a href="<?php echo esc_url(home_url('/')); ?>hyouka/backnumber/">過去の魚種別資源評価</a></li>
					<li><a href="<?php echo esc_url(home_url('/')); ?>hyouka/datatable/">資源評価報告書のデータ表</a></li>
				</ul>

				<li class="p-link-bar"><a href="<?php echo esc_url(home_url('/')); ?>gk/">漁海況予報<span class="c-sq-btn"></span></a></li>


				<ul class="p-list p-list--arrow p-3">
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
						<li><a href="<?php echo $term_link; ?>"><?php echo $term->name; ?>の漁海況予報</a></li>
					<?php endforeach; ?>

					<li>
						<a href="<?php echo esc_url(home_url('/')); ?>gk/backnumber/">
							過去の漁海況予報</span>
						</a>
					</li>
				</ul>

				<li class="p-link-bar"><a href="<?php echo esc_url(home_url('/')); ?>kouseidoka/">資源量推定等高精度化推進事業<span class="c-sq-btn"></span></a></li>

				<li class="p-link-bar"><a href="<?php echo esc_url(home_url('/')); ?>contact/">お問い合わせ<span class="c-sq-btn"></span></a></li>

				<li class="p-link-bar"><a href="<?php echo esc_url(home_url('/')); ?>update/">更新情報<span class="c-sq-btn"></span></a></li>

				<li class="p-link-bar"><a href="<?php echo esc_url(home_url('/')); ?>reference/">関連リンク・パンフレット等<span class="c-sq-btn"></span></a></li>

				<li class="p-link-bar"><a href="<?php echo esc_url(home_url('/')); ?>sitemap/">サイトマップ<span class="c-sq-btn"></span></a></li>

				<li class="p-link-bar"><a href="<?php echo esc_url(home_url('/')); ?>copyright/">著作権・免責事項<span class="c-sq-btn"></span></a></li>

				<li class="p-link-bar"><a href="<?php echo esc_url(home_url('/')); ?>privacy/">プライバシーポリシー<span class="c-sq-btn"></span></a></li>
			</ul>


		</div>

	</div>

	<?php get_template_part('part', 'related-link'); ?>
</main>

<?php get_template_part('part', 'aside'); ?>
<?php get_template_part('part', 'banners'); ?>
<?php get_footer(); ?>