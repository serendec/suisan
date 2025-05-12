<?php
/*
Template Name: 水産資源評価結果（年度毎の固定ページ）
*/
?>
<?php get_header(); ?>

<?php
global $wpdb;

preg_match("/(\d{4})/", $post->post_name, $m);
$fiscal_year = $m[1];

//全ての当該年度の行名をDBより直接取得
$sql_select = "SELECT postmeta.post_id, postmeta.meta_key FROM {$wpdb->postmeta} AS postmeta";
$sql_where = "WHERE postmeta.meta_key LIKE %s AND postmeta.meta_value=%d";

if (isset($_GET['key'])) {
	$sql = $sql_select . " INNER JOIN {$wpdb->posts} AS posts ON postmeta.post_id = posts.ID " . $sql_where . " AND posts.post_title LIKE '%{$_GET['key']}%' AND posts.post_type IN ('hyouka-type1', 'hyouka-type2', 'hyouka-type3')";
	$sql = $wpdb->prepare($sql, '魚種データ_%_年度', $fiscal_year);
} else {
	$sql = $wpdb->prepare($sql_select . ' ' . $sql_where, '魚種データ_%_年度', $fiscal_year);
}

$results = $wpdb->get_results($sql);
$post_keys = array();
$post_ids = array();

//ステータスが公開かチェックしつつ取り出しやすいように加工
foreach ($results as $pdata) {
	if (get_post_status($pdata->post_id) == 'publish') {
		$post_keys[$pdata->post_id] = str_replace('_年度', '', $pdata->meta_key);
		$post_ids[] = $pdata->post_id;
	}
}

$has_fish = false;
if(empty($post_ids)){
	$post_ids = array(0);
}else{
	$has_fish = true;
}
//var_dump(get_post($post_ids[0]));
?>
<div class="p-fish-name-search-bar">
	<form method="get" action="<?php the_permalink(); ?>">
		<div class="p-fish-name-search">
			<input type="text" name="key" value="<?php echo isset($_GET['key']) ? $_GET['key'] : ''; ?>" placeholder="魚種名から検索する">
			<button type="submit"><span class="p-icon-search"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon_search_white.svg" alt="検索"></span></button>
		</div>
	</form>
</div>
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
			<?php if (strstr($_SERVER['REQUEST_URI'], '?key=')) : ?>
				<h2 class="c-heading c-heading--logo mb-5"><?php the_title(); ?><span>（<?php echo $has_fish ? count($post_ids) : 0; ?>魚種）</span></h2>
			<?php else : ?>
				<h2 class="c-heading c-heading--logo mb-5">
					<?php the_title(); ?>
					<?php
					$post_ids_custom = get_field('post_ids_custom');
					if ($post_ids_custom) {
						echo '<span>（' . $post_ids_custom . '魚種）</span>';
					} else {
						echo '<span>（' . count($results) . '魚種）</span>';
					}

					?>
				</h2>


				<?php /*<h2 class="c-heading c-heading--logo mb-5"><span>（<?php echo
			count($results); ?>魚種）</span></h2>*/ ?>
			<?php endif; ?>
			<form method="get" action="<?php the_permalink(); ?>" class="mb-5">
				<div class="p-fish-name-search">
					<input type="text" name="key" value="<?php echo isset($_GET['key']) ? $_GET['key'] : ''; ?>" placeholder="魚種名から検索">
					<button type="submit"><span class="p-icon-search"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon_search_white.svg" alt="検索"></span></button>
				</div>
			</form>

			<div class="c-panel c-panel--attention my-5">
				<div class="p-attention"><i class="fas fa-exclamation-triangle me-2"></i>注意事項</div>
				<p>当ホームページ及びホームページ掲載情報は、日本国の著作権法及び国際条約による著作権保護の対象です。
					引用の際は必ず<a href="<?php echo esc_url(home_url('/')); ?>hyouka/citation-guide/">【引用に関する注意事項 / Citation guide】</a>をお読みいただいて、正しく引用していただくようお願いいたします。</p>
			</div>


			<div class="c-frame c-frame--2 mb-5">
				<div class="c-frame__head"><i class="fas fa-list-ul me-2"></i>目次</div>
				<div class="c-frame__body">
					<ul class="p-list p-list--arrow">
						<li><a href="#s1">資源管理目標案等を提示した資源評価の対象魚種系群</a></li>
						<li><a href="#s2">資源管理目標案等を提示していない資源評価の対象魚種系群</a></li>
						<li><a href="#s3">令和元年度より対象となった魚種、海域</a></li>
					</ul>
				</div>
			</div>


			<?php
			$post_type = 'hyouka-type1';

			$query = new WP_Query(array(
				'post_type' => $post_type,
				'posts_per_page' => -1,
				'post__in' => $post_ids,
			));

			if ($query->have_posts()) :
			?>

				<h3 id="s1" class="c-h3 mb-3">資源管理目標案等を提示した資源評価の対象魚種系群</h3>
				<p class="mb-4">【資源管理目標案等を提示した資源評価の対象魚種系群】は、その他の資源と異なり、「資源管理方針に関する検討会」への提出に向けて、資料の公開を先行的に進めています。それら資料のうち、「簡易版」が評価内容の概要を示すものであることから、上記以外の資源のダイジェスト版に代わるものとして掲示しています。<br>
					なお、上記資源の内、広域漁業調整委員会での協議対象になっている資源については、当該委員会で使用するためダイジェスト版も作成しています。</p>

				<div class="c-frame c-frame--2 mb-5">
					<div class="c-frame__head"><i class="fas fa-info-circle text-primary me-2"></i>関連情報</div>
					<div class="c-frame__body">
						<ul class="p-list p-list--arrow">
							<li><a href="https://www.fra.go.jp/shigen/fisheries_resources/meeting/stok_assesment_meeting/index.html" target="_blank" rel="noopener noreferrer">資源評価関連会議情報<i class="far fa-external-link-alt ms-2"></i></a></li>
							<li><a href="<?php echo esc_url(home_url('/')); ?>about/references_list/#s1">漁業管理規則およびABC算定のための基本指針</a></li>
						</ul>
					</div>
				</div>

				<div class="js-scrollable p-table-list-wrap mb-5">
					<table class="p-table-list">
						<thead>
							<tr>
								<th>魚種</th>
								<th>系群</th>
								<th>資料</th>
							</tr>
						</thead>

						<?php
						while ($query->have_posts()) {
							$query->the_post();
							get_template_part('loop', $post_type, array($post_keys));
						}
						?>

					</table>
				</div>

			<?php endif; ?>


			<?php
			$post_type = 'hyouka-type2';

			$query = new WP_Query(array(
				'post_type' => $post_type,
				'posts_per_page' => -1,
				'post__in' => $post_ids,
			));

			if ($query->have_posts()) :
			?>

				<h3 id="s2" class="c-h3 mb-3">資源管理目標案等を提示していない資源評価の対象魚種系群</h3>
				<p class="mb-4">魚種の順番はＴＡＣ対象種とそれ以外の種に分けて、それぞれを分類順に示してある。<br>
					※マチ類、東シナ海底魚類はそれぞれ４魚種系群として扱う。</p>

				<div class="c-frame c-frame--2 mb-5">
					<div class="c-frame__head"><i class="fas fa-info-circle text-primary me-2"></i>関連情報</div>
					<div class="c-frame__body">
						<ul class="p-list p-list--arrow">
							<li><a href="<?php echo esc_url(home_url('/')); ?>about/references_list/#s1">漁業管理規則およびABC算定のための基本指針<i class="fal fa-file-pdf ms-2"></i></a></li>
						</ul>
					</div>
				</div>

				<div class="js-scrollable p-table-list-wrap mb-5">
					<table class="p-table-list">
						<thead>
							<tr>
								<th>魚種</th>
								<th>系群</th>
								<th>資料</th>
								<th>動向</th>
								<th>水準</th>
							</tr>
						</thead>
						<?php
						while ($query->have_posts()) {
							$query->the_post();
							get_template_part('loop', $post_type, array($post_keys));
						}
						?>
					</table>
				</div>
			<?php endif; ?>

			<?php
			$post_type = 'hyouka-type3';

			$query = new WP_Query(array(
				'post_type' => $post_type,
				'posts_per_page' => -1,
				'post__in' => $post_ids,
			));

			if ($query->have_posts()) :
			?>
				<h3 id="s3" class="c-h3 mb-3">令和元年度より対象となった魚種、海域</h3>

				<div class="js-scrollable p-table-list-wrap mb-5">
					<table class="p-table-list mb-5">
						<thead>
							<tr>
								<th>魚種</th>
								<th>ブロック</th>
								<th>資料</th>
							</tr>
						</thead>
						<?php
						while ($query->have_posts()) {
							$query->the_post();
							get_template_part('loop', $post_type, array($post_keys));
						}
						?>

					</table>
				</div>
			<?php endif;
			wp_reset_query(); ?>


			<?php if (isset($_GET['key'])) { //検索結果だった場合は戻るボタン表示
				echo '<a href="' . get_permalink() . '" class="mt-5 mx-auto p-button p-button--dark">戻る</a>';
			} ?>

		</div>
		<!-- .l-inner -->
	</div>
	<!-- .container -->


	<?php get_template_part('part', 'related-link'); ?>
</main>

<?php get_template_part('part', 'aside'); ?>
<?php get_template_part('part', 'banners'); ?>
<?php get_footer(); ?>