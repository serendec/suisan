<footer class="l-footer p-footer">
	<div id="pagetop" class="p-pagetop js-waves"><img src="<?php _e_asset_url('img/img_pagetop.png'); ?>" alt="pagetop"></div>
	<div class="container">
		<p class="p-footer__title">わが国周辺の水産資源の評価</p>

		<div class="row">
			<div class="col-md-6">
				<div class="p-footer__panel">
					<p>水産庁増殖推進部漁場資源課　沿岸資源班<br>
						〒100-8907　東京都千代田区霞ヶ関1-2-1</p>
				</div>
			</div>
			<div class="col-md-6">
				<div class="p-footer__panel">
					<p>国立研究開発法人水産研究・教育機構　水産資源研究所<br>
						〒236-8648　神奈川県横浜市金沢区福浦2-12-4</p>
				</div>
			</div>
		</div>


		<nav class="p-footer__nav">
			<div class="row">
				<div class="col-md-4">
					<ul>
						<li>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>about/">水産資源評価とは</a>
							<ul>
								<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>about/taisei/">水産資源評価の実施体制と進め方</a></li>
								<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>about/references_list/">資源評価のための基礎資料</a></li>
								<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>about/yougo/">用語集</a></li>
							</ul>
						</li>
					</ul>
				</div>
				<div class="col-md-4">
					<ul>
						<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>hyouka/">水産資源評価結果</a></li>
						<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>gk/">漁海況予報</a></li>
						<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>kouseidoka/">高精度化事業</a></li>
					</ul>
				</div>
				<div class="col-md-4">
					<ul>
						<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>contact/">お問い合わせ</a></li>
						<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>sitemap/">サイトマップ</a></li>
						<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>update/">更新情報</a></li>
						<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>reference/">関連リンク・パンフレット等</a></li>
					</ul>
				</div>
			</div>
		</nav>

		<nav class="p-footer__nav-privacy">
			<ul>
				<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>copyright/">著作権・免責事項</a></li>
				<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>privacy/">プライバシーポリシー</a></li>
			</ul>
		</nav>

		<p class="p-copy">Copyright © Fisheries Agency of Japan and Japan Fisheries Research and Education Agency All Rights Reserved.</p>
	</div>
</footer>

<!-- Javascript -->
<script src="<?php _e_asset_url('js/waves.js'); ?>"></script>
<script src="<?php _e_asset_url('js/common.js'); ?>"></script>

<?php wp_footer(); ?>

</body>

</html>