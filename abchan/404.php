<?php get_header(); ?>
<main class="l-main p-main">
	<div class="p-page-header">
		<div>
			<h1 class="p-page-header__title">
				ページが見つかりません
			</h1>
			<div class="p-page-header__title-en">Error - Page Not Found</div>
		</div>
	</div>

	<div class="container" style="min-height: 500px;">

		<?php get_template_part('part', 'breadcrumb'); ?>

		<div class="l-inner">
		<p class="text">ご指定のURLが間違っているか、ページが削除された可能性があります。<br>
		ブラウザの「戻る」ボタンで前のページにお戻りいただくか、<br>
		<a href="/">トップページ</a>より目的のページをお探しください。</p>


		<p style="text-align: center; padding-top: 5em; padding-bottom: 3em;"><a href="/">トップページへ戻る</a></p>
		</div>
		<!-- .l-inner -->


	</div>

</main>

<?php get_template_part('part', 'aside'); ?>
<?php get_template_part('part', 'banners'); ?>
<?php get_footer(); ?>
