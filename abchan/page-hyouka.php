<?php

/**
 * Template Name: 水産資源評価結果
 */ ?>

<?php get_header(); ?>
<main class="l-main p-main">
	<div class="p-page-header">
		<div>
			<h1 class="p-page-header__title">
				水産資源評価結果
			</h1>
			<div class="p-page-header__title-en">Fisheries resource assessment</div>
		</div>
	</div>

	<div class="container">

		<?php get_template_part('part', 'breadcrumb'); ?>

		<?php if (!is_page(array('hyouka'))) : ?>

			<div class="l-inner">
				<?php if (have_posts()) : ?>
					<?php while (have_posts()) : the_post(); ?>
						<?php remove_filter('the_content', 'wpautop'); ?>
						<?php the_content(); ?>
					<?php endwhile; ?>
				<?php endif; ?>
			</div>

		<?php else : ?>

			<div class="l-inner pb-0">
				<p>各魚種・系群毎の資源評価は毎年１回行っております。本ホームページはこの評価結果を公表しているものです。</p>
				<p>このため、次回（翌年）の資源評価までの間の海洋環境の変動などにより、資源状況が変化し、評価結果と実態が異なることもありますので、御利用にあたってはその点を御了解の上、御利用願います。</p>
				<p>なお、海洋環境の変動の影響を受けやすいマサバ、マイワシなどの浮魚類やスルメイカなどの重要資源については、水産研究所が漁期前や漁期中の適当な時期に直近の漁獲情報等を踏まえた長期漁海況予報も行っておりますので、これらの情報も御利用下さい。</p>

				<?php /*
				<div class="c-frame c-frame--2">
					<div class="c-frame__head"><i class="fas fa-info-circle text-primary me-2"></i>関連情報</div>
					<div class="c-frame__body">
						<ul class="p-list p-list--arrow">
							<li><a href="<?php echo esc_url(home_url('/')); ?>gk/">漁海況予報</a></li>
						</ul>
					</div>
				</div>
				 */ ?>
			</div>
			<!-- .l-inner -->

			<hr class="my-5">

			<div class="l-inner pt-0">

				<div class="c-panel c-panel--attention mb-5">
					<div class="p-attention"><i class="fas fa-exclamation-triangle me-2"></i>注意事項</div>
					<p>当ホームページ及びホームページ掲載情報は、日本国の著作権法及び国際条約による著作権保護の対象です。
						引用の際は必ず<a href="<?php echo esc_url(home_url('/')); ?>hyouka/citation-guide/">【引用に関する注意事項 / Citation guide】</a>をお読みいただいて、正しく引用していただくようお願いいたします。</p>
				</div>

				<h3 class="c-h3 mb-4">水産資源評価結果</h3>

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
				<ul class="p-link-bar-list mb-5">
					<?php

					foreach ($page_child as $child) :
						$child_id = $child->ID;
					?>
						<li>
							<a href="<?php echo get_the_permalink($child_id); ?>" class="js-waves">
								<?php echo get_the_title($child_id); ?><span class="c-sq-btn"></span>
							</a>
						</li>
					<?php endforeach; ?>

					<li>
						<a href="<?php echo esc_url(home_url('/')); ?>hyouka/backnumber/" class="js-waves">
							過去の魚種別資源評価<span class="c-sq-btn"></span>
						</a>
					</li>

					<li>
						<a href="<?php echo esc_url(home_url('/')); ?>hyouka/documents/" class="js-waves">
						水産資源評価関連資料<span class="c-sq-btn"></span>
						</a>
					</li>
				</ul>

				<h3 class="c-h3 mb-4">資源評価報告書のデータ表</h3>
				<ul class="p-link-bar-list mb-5">
					<li><a href="<?php echo esc_url(home_url('/')); ?>hyouka/datatable/" class="js-waves">資源評価報告書のデータ表<span class="c-sq-btn"></span></a></li>
				</ul>

			</div>
			<!-- .l-inner -->

			<div class="l-inner pt-0">
				<ul class="p-link-block-list">
					<li><a href="<?php echo esc_url(home_url('/')); ?>about/taisei/" class="js-waves">水産資源評価の進め方と実施体制<span class="c-sq-btn"></span></a></li>
					<li><a href="<?php echo esc_url(home_url('/')); ?>about/references_list/" class="js-waves">水産資源評価のための基礎資料<span class="c-sq-btn"></span></a></li>
					<li><a href="<?php echo esc_url(home_url('/')); ?>about/yougo/" class="js-waves">用語集<span class="c-sq-btn"></span></a></li>
				</ul>
			</div>
			<!-- .l-inner -->

		<?php endif; ?>


	</div>


	<?php get_template_part('part', 'related-link'); ?>
</main>

<?php get_template_part('part', 'aside'); ?>
<?php get_template_part('part', 'banners'); ?>
<?php get_footer(); ?>