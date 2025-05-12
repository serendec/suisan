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

			<h2 class="c-heading c-heading--logo"><?php single_term_title(); ?>の漁海況予報</h2>

			<p><?php single_term_title(); ?>4月以降に発表された漁況海況予報の一覧です。<br>
			なお、発表された予報につきましてはPDF形式でデータを公表していますので、データをダウンロードしてご覧ください。<br>
			※PDFファイルを読むためにはacrobat readerが必要です。</p>

			<p class="mb-5">漁況海況予報は<a href="https://www2.fra.go.jp/xq/" target="_blank" rel="noopener noreferrer">水産研究・教育機構web<i class="far fa-external-link-alt ms-2"></a></i>で公開しています。</p>


			<?php if (have_posts()) : ?>
			<div class="js-scrollable p-table-list-wrap mb-5">
				<table class="p-table-list p-table-list--2">
					<thead>
						<tr>
							<th>発表日</th>
							<th>担当機関</th>
							<th>漁況海況予報の種類</th>
						</tr>
					</thead>
					<?php while (have_posts()) : the_post(); ?>

						<tbody<?php if(get_field('無効化')):?> class="is-disabled"<?php endif;?>>
							<tr>
								<td>
									<?php if(get_field('発表日')):?>
										<?php the_field('発表日'); ?>
									<?php endif;?>
								</td>
								<td>
									<?php if(get_field('担当水産研究所')):?>
										<?php the_field('担当水産研究所'); ?>
									<?php endif;?>
								</td>
								<td><a href="<?php the_field('外部リンク'); ?>" target="_blank"><?php the_title(); ?><i class="far fa-external-link-alt ms-2"></i></a></td>
							</tr>
						</tbody>
					<?php endwhile; ?>
				</table>
			</div>
			<?php endif; ?>

			<?php
			$tax = 'fiscal-year';
			$current_term = get_queried_object();
			$terms = get_terms($tax);
			$prev = null;
			$next = null;
			for ($i = 0; $i < count($terms); $i++) {
				if ($terms[$i]->term_id == $current_term->term_id) {
					if (isset($terms[$i + 1])) {
						$next = $terms[$i + 1];
					}
					break;
				}
				$prev = $terms[$i];
			}
			?>
			<div class="p-pagenav-button">
				<div class="row">
					<div class="col-3 col-md-4">
						<?php if ($next) : ?>
							<a href="<?php echo get_term_link($next->term_id, $tax) ?>" class="p-button p-button--prev"><span><?php echo $next->name; ?></span></a>
						<?php endif; ?>
					</div>
					<div class="col-6 col-md-4">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>gk/" class="p-button p-button--dark">一覧へ戻る</a>
					</div>
					<div class="col-3 col-md-4">
						<?php if ($prev) : ?>
							<a href="<?php echo get_term_link($prev->term_id, $tax) ?>" class="p-button p-button--next"><span><?php echo $prev->name; ?></span></a>
						<?php endif; ?>
					</div>
				</div>

			</div>

		</div>
		<!-- .l-inner -->


	</div>

	<?php get_template_part('part', 'related-link'); ?>
</main>

<?php get_template_part('part', 'aside'); ?>
<?php get_template_part('part', 'banners'); ?>
<?php get_footer(); ?>