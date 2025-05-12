<?php
/*
Template Name: 過去の漁海況予報
*/
get_header(); ?>

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

			<h2 class="c-heading c-heading--logo mb-5">過去の漁海況予報</h2>

			<form method="get" class="p-search-backnumber c-panel c-panel--icegray">
                <?php $facets = app_get_conditions_forecast_search_facets(); ?>
				<div class="p-search-backnumber__item">
					<div class="p-search-backnumber__title">カテゴリ</div>
					<div class="c-select c-input--ml">
						<select name="search[category]" required>
							<option value="" hidden>- 選択(必須) -</option>
                            <?php foreach ($facets->getCategories() as $category): ?>
								<option value="<?php echo $category; ?>" <?php selected($_GET['search']['category'] ?? null, $category); ?>><?php echo $category; ?></option>
                            <?php endforeach; ?>
						</select>
					</div>
				</div>

				<div class="p-search-backnumber__item">
					<div class="p-search-backnumber__title">海域</div>
					<div class="c-select c-input--ml">
						<select name="search[sea_area]">
							<option value="">- 選択 -</option>
                            <?php foreach ($facets->getSeaAreas() as $seaArea): ?>
								<option value="<?php echo $seaArea; ?>" <?php selected($_GET['search']['sea_area'] ?? null, $seaArea); ?>><?php echo $seaArea; ?></option>
                            <?php endforeach; ?>
						</select>
					</div>
				</div>

				<div class="p-search-backnumber__item">
					<div class="p-search-backnumber__title">年度</div>

					<div class="p-search-backnumber__row">
						<div class="c-select c-input--m">
							<select name="search[year_start]" id="" class="js-year--start">
								<option value="">- 選択 -</option>
                                <?php foreach ($facets->getYears() as $year): ?>
									<option value="<?php echo $year; ?>" <?php selected($_GET['search']['year_start'] ?? null, $year); ?>><?php echo $year; ?></option>
                                <?php endforeach; ?>
							</select>
						</div>
						<span class="mx-2">〜</span>
						<div class="c-select c-input--m">
							<select name="search[year_end]" id="" class="js-year--end">
								<option value="">- 選択 -</option>
                                <?php foreach ($facets->getYears() as $year): ?>
									<option value="<?php echo $year; ?>" <?php selected($_GET['search']['year_end'] ?? null, $year); ?>><?php echo $year; ?></option>
                                <?php endforeach; ?>
							</select>
						</div>
					</div>
				</div>

				<div class="p-search-backnumber__button">
					<button type="submit"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon_search_white.svg" alt="検索"> 検索</button>
					<a href="<?php the_permalink(); ?>" class="p-reset"><i class="fas fa-undo-alt"></i> リセット</a>
				</div>

				<script>
					(function ($) {
						const $yearStart = $('.js-year--start');
						const $yearEnd = $('.js-year--end');

						$yearStart.on('change', function () {
							const yearStart = $(this).val();

							$yearEnd.find('option').prop('disabled', false);

							if (!yearStart) return;

							$yearEnd.find('option').each(function () {
								const $option = $(this);
								const yearEnd = $option.val();

								if (!yearEnd) return;

								if (yearEnd < yearStart) {
									if ($option.is(':selected')) {
										$option.prop('selected', false);
									}

									$option.prop('disabled', true);
								} else {
									$option.prop('disabled', false);
								}
							});
						}).trigger('change');
					})(jQuery);
				</script>
			</form>
			<!-- .p-search-backnumber -->

			<?php if ($results = app_handle_conditions_forecast_search_request()): ?>
                <?php foreach ($results as $year => $items): ?>
					<div class="p-search-backnumber-result__item">
						<h3 class="c-h3 mb-3"><?php echo $year ?>年度</h3>
						<div class="js-scrollable p-table-list-wrap">
							<table class="p-table-list">
								<thead>
								<tr>
									<th>海域</th>
									<th>カテゴリ</th>
									<th>資料タイトル</th>
									<th>発表日</th>
									<th>資料</th>
								</tr>
								</thead>

								<?php
								/**
								 * @var App_Conditions_Forecast_Search_Result_Item $item
								 */
								foreach ($items as $item): ?>
									<tbody>
										<tr>
											<td><?php echo $item->getSeaArea() ?></td>
											<td><?php echo $item->getCategory() ?></td>
											<td><?php echo $item->getTitle() ?></td>
											<td><?php echo $item->getDate()->format('Y.m.d') ?></td>
											<td>
												<ul class="p-dl-btn-list p-dl-btn-list--column">
													<?php if ($url = $item->getDocumentUrl()): ?>
														<li>
															<a href="<?php echo $url; ?>" class="p-dl-btn" target="_blank">
																<i class="fal fa-file-pdf"></i>
																資料
																<span><?php $filesize = $item->getDocumentSize() / (1024 * 1024); echo number_format($filesize, 1); ?>MB</span>
															</a>
														</li>
													<?php endif; ?>
												</ul>
											</td>
										</tr>
									</tbody>
								<?php endforeach; ?>

							</table>
						</div>
					</div>
					<!-- .p-search-backnumber-result__item -->
                <?php endforeach; ?>
			<?php else: ?>
				<div class="c-panel c-panel--icegray text-center mb-5">検索結果なし</div>
			<?php endif; ?>
		</div>
		<!-- .l-inner -->
	</div>
	<!-- .container -->

	<?php get_template_part('part', 'related-link'); ?>
</main>

<?php get_template_part('part', 'aside'); ?>
<?php get_template_part('part', 'banners'); ?>
<?php get_footer(); ?>