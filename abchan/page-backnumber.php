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

		<div class="l-inner">

			<div class="c-panel c-panel--attention my-5">
				<div class="p-attention"><i class="fas fa-exclamation-triangle me-2"></i>注意事項</div>
				<p>当ホームページ及びホームページ掲載情報は、日本国の著作権法及び国際条約による著作権保護の対象です。
					引用の際は必ず<a href="<?php echo esc_url(home_url('/')); ?>hyouka/citation-guide/">【引用に関する注意事項 / Citation guide】</a>をお読みいただいて、正しく引用していただくようお願いいたします。</p>
			</div>

			<h2 class="c-heading c-heading--logo mb-5">過去の魚種別資源評価</h2>

			<form method="get" class="p-search-backnumber c-panel c-panel--icegray">
				<?php $facets = app_get_resource_assessment_search_facets(); ?>

				<div class="p-search-backnumber__item">
					<div class="p-search-backnumber__title">魚種</div>
					<div class="c-select c-input--l">
						<select name="search[type]">
							<option value="">- 選択 -</option>
                            <?php foreach ($facets->getTypes() as $type): ?>
								<option value="<?php echo $type; ?>" <?php selected($_GET['search']['type'] ?? null, $type); ?>><?php echo $type; ?></option>
                            <?php endforeach; ?>
						</select>
					</div>
				</div>

				<div class="p-search-backnumber__item">
					<div class="p-search-backnumber__title">年度</div>

					<div class="p-search-backnumber__row">
						<div class="c-select c-input--ml">
							<select name="search[year_start]" id="" class="js-year--start">
								<option value="">- 選択 -</option>
                                <?php foreach ($facets->getYears() as $year): ?>
									<option value="<?php echo $year; ?>" <?php selected($_GET['search']['year_start'] ?? null, $year); ?>><?php echo $year; ?></option>
                                <?php endforeach; ?>
							</select>
						</div>
						<span class="mx-2">〜</span>
						<div class="c-select c-input--ml">
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

			<?php if ($results = app_handle_resource_assessment_search_request()): ?>
				<div class="p-search-backnumber-result">
    				<?php foreach ($results as $year => $group): ?>
						<div class="p-search-backnumber-result__item">
							<h3 class="c-h3 mb-3"><?php echo $year ?>年度</h3>
							<div class="js-scrollable p-table-list-wrap">
								<table class="p-table-list">
									<thead>
										<tr>
											<th>魚種</th>
											<th>系群／ブロック</th>
											<th>資料</th>
											<th>動向</th>
											<th>水準</th>
										</tr>
									</thead>

        							<?php foreach ($group as $type => $items): ?>
										<tbody>
											<?php
											/**
											 * @var App_Resource_Assessment_Search_Result_Item $item
											 */
											foreach ($items as $index => $item): ?>
											<tr>
												<?php if ($index === 0): ?>
													<td <?php if (count($items) > 1): ?>rowspan="<?php echo count($items); ?>"<?php endif; ?>>
														<div class="p-fish-species">
															<div class="p-name"><?php echo $type; ?></div>
															<div class="p-image" style="background-image: url('<?php echo $item->getImageUrl(); ?>')"></div>
														</div>
													</td>
												<?php endif; ?>

												<td><?php echo $item->getCategory(); ?></td>
												<td>
													<ul class="p-dl-btn-list p-dl-btn-list--column">
														<?php if ($url = $item->getLightDocumentUrl()): ?>
															<li>
																<a href="<?php echo $url; ?>" class="p-dl-btn" target="_blank">
																	<i class="fal fa-file-pdf"></i>
																	簡易版
																	<span><?php $filesize = $item->getLightDocumentSize() / (1024 * 1024); echo number_format($filesize, 1); ?>MB</span>
																</a>
															</li>
														<?php endif; ?>

                                                        <?php if ($url = $item->getSummaryDocumentUrl()): ?>
															<li>
																<a href="<?php echo $url; ?>" class="p-dl-btn" target="_blank">
																	<i class="fal fa-file-pdf"></i>
																	ダイジェスト版
																	<span><?php $filesize = $item->getSummaryDocumentSize() / (1024 * 1024); echo number_format($filesize, 1); ?>MB</span>
																</a>
															</li>
                                                        <?php endif; ?>

                                                        <?php if ($url = $item->getDetailedDocumentUrl()): ?>
															<li>
																<a href="<?php echo $url; ?>" class="p-dl-btn" target="_blank">
																	<i class="fal fa-file-pdf"></i>
																	評価（調査）報告書
																	<span><?php $filesize = $item->getDetailedDocumentSize() / (1024 * 1024); echo number_format($filesize, 1); ?>MB</span>
																</a>
															</li>
                                                        <?php endif; ?>
													</ul>
												</td>

												<td>
													<!-- 動向 -->
													<?php if($item->getTrendsLabelClasses()): ?>
														<div class="c-label c-label--sts <?php echo $item->getTrendsLabelClasses() ?>
														<?php
															if($item->getLevel() === '低位') {
																echo ' c-label--pink';
															} elseif($item->getLevel() === '中位') {
																echo ' c-label--org';
															} elseif($item->getLevel() === '高位') {
																echo ' c-label--grn';
															}
														?>
														"><i class="far fa-long-arrow-right"></i></div>
													<?php endif; ?>

												</td>
												<td>
													<!-- 水準 -->
													<?php if($item->getLevelLabelClasses()): ?>
														<div class="c-label c-label--sts <?php echo $item->getLevelLabelClasses(); ?>"><?php echo $item->getLevel() ?></div>
													<?php endif; ?>
												</td>
											</tr>
											<?php endforeach; ?>
										</tbody>
                                    <?php endforeach; ?>
								</table>
							</div>
						</div>
						<!-- .p-search-backnumber-result__item -->
					<?php endforeach; ?>
				</div>
				<!-- .p-search-backnumber-result -->
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