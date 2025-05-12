<?php
/*
Template Name: 水産資源評価関連資料
*/
get_header(); ?>

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

			<h2 class="c-heading c-heading--logo mb-5">水産資源評価関連資料</h2>

			<form method="get" class="p-search-backnumber p-search-backnumber--related-document c-panel c-panel--icegray">
				<?php $facets = app_get_resource_document_search_facets(); ?>
				<div class="p-search-backnumber--related-document__wrap">

					<div>
						<div class="p-prefix">FRA-SA</div>
						<div class="p-search-backnumber__item">

							<div class="p-search-backnumber__title">年（西暦）</div>
							<div class="c-select c-input--m">
								<select name="search[year]">
									<option value="">- 選択 -</option>
                                    <?php foreach ($facets->getYears() as $year): ?>
										<option value="<?php echo $year; ?>" <?php selected($_GET['search']['year'] ?? null, $year); ?>><?php echo $year; ?></option>
                                    <?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="p-hyphen">ー</div>
						<div class="p-search-backnumber__item">
							<div class="p-search-backnumber__title">
								<div class="p-tooltip-wrap">
									分類 <div class="p-tooltip">
										<span class="p-tooltip__icon">?</span>
										<div class="p-tooltip__description">
											<dl>
												<dt>BRP</dt>
												<dd>研究機関会議資料</dd>
											</dl>
											<dl>
												<dt>AC</dt>
												<dd>資源評価報告書</dd>
											</dl>
											<dl>
												<dt>RE</dt>
												<dd>資源評価調査報告書</dd>
											</dl>
											<dl>
												<dt>SC、RC</dt>
												<dd>資源評価会議資料</dd>
											</dl>
											<dl>
												<dt>SSC、SRC</dt>
												<dd>資源評価担当者会議資料</dd>
											</dl>
											<dl>
												<dt>ABCWG</dt>
												<dd>資源評価の基礎資料</dd>
											</dl>
											<dl>
												<dt>PIWG</dt>
												<dd>資料の読み方に関する資料</dd>
											</dl>
										</div>
									</div>

								</div>
							</div>
							<div class="c-select c-input--m">
								<select name="search[type]">
									<option value="">- 選択 -</option>
                                    <?php foreach ($facets->getTypes() as $type): ?>
										<option value="<?php echo $type; ?>" <?php selected($_GET['search']['type'] ?? null, $type); ?>><?php echo $type; ?></option>
                                    <?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>

					<div class="p-search-backnumber__wrap2">
						<div>
							<div class="p-search-backnumber__item">
								<div class="p-search-backnumber__title">番号<span>*</span></div>
								<input name="search[number]" value="<?php echo esc_attr($_GET['search']['number'] ?? null); ?>" type="text" class="c-input">
							</div>

							<div class="p-hyphen">ー</div>

							<div class="p-search-backnumber__item">
								<div class="p-search-backnumber__title">枝番号<span>*</span></div>
								<input name="search[sub_number]" value="<?php echo esc_attr($_GET['search']['sub_number'] ?? null); ?>" type="text" class="c-input">
							</div>


						</div>
						<p><span>*</span>番号と枝番号は冒頭の0を除いて入力</p>
					</div>

				</div>

				<div class="p-search-backnumber__item p-search-backnumber__item--keyword">
					<div class="p-search-backnumber__title">文書タイトル<br><small>（部分検索可）</small></div>
					<input name="search[keyword]" value="<?php echo esc_attr($_GET['search']['keyword'] ?? null); ?>" type="text" class="c-input">
				</div>

				<div class="p-search-backnumber__button">
					<button type="submit"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon_search_white.svg" alt="検索"> 検索</button>
					<a href="<?php the_permalink(); ?>" class="p-reset"><i class="fas fa-undo-alt"></i> リセット</a>
				</div>
			</form>
			<!-- .p-search-backnumber -->

			<?php if ($results = app_handle_conditions_resource_document_search_request()): ?>
    			<?php foreach ($results as $year => $items): ?>
				<div class="p-search-backnumber-result__item">
					<h3 class="c-h3 mb-3"><?php echo $year; ?>年度</h3>
					<div class="js-scrollable p-table-list-wrap">
						<table class="p-table-list">
							<thead>
								<tr>
									<th>年（西暦）</th>
									<th>文書管理番号</th>
									<th>資料タイトル</th>
									<th>資料</th>
								</tr>
							</thead>
                            <?php
                            /**
                             * @var App_Resource_Document_Search_Result_Item $item
                             */
                            foreach ($items as $item): ?>
								<tbody>
									<tr>
										<td><?php echo $year ?>年</td>
										<td><?php echo $item->getDocumentManageId(); ?></td>
										<td><?php echo $item->getTitle() ?></td>
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