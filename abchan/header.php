<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0">
	<meta name="description" content="<?php bloginfo('description'); ?>">
	<meta name="keywords" content="">
	<meta name="format-detection" content="telephone=no">

	<title><?php wp_title('&nbsp;|&nbsp;', true, 'right'); ?><?php bloginfo('name'); ?></title>

	<?php
	if (is_front_page() && is_home()) {
		$pagetype = "website";
		$url_og = esc_url(home_url('/'));
	} else {
		$pagetype = "article";
		$url_og = get_the_permalink();
	}
	?>
	<?php /* SNS:OG Setting */ ?>
	<meta property="og:title" content="<?php bloginfo('name'); ?>" />
	<meta property="og:type" content="<?php echo $pagetype; ?>" />
	<meta property="og:description" content="<?php bloginfo('description'); ?>" />
	<meta property="og:url" content="<?php echo $url_og; ?>" />
	<meta property="og:image" content="<?php _e_asset_url('img/og-image.jpg'); ?>" />
	<meta property="og:site_name" content="<?php bloginfo('name'); ?>" />
	<meta property="og:locale" content="ja_JP" />

	<?php /* CSS */ ?>
	<link rel="stylesheet" href="<?php _e_asset_url('css/waves.css'); ?>">
	<link rel="stylesheet" href="<?php _e_asset_url('css/all.css'); ?>">
	<link rel="stylesheet" href="<?php _e_asset_url('css/bootstrap/bootstrap.css'); ?>">
	<link rel="stylesheet" href="<?php _e_asset_url('css/common.css'); ?>">

    <link rel="stylesheet" href="https://unpkg.com/scroll-hint@latest/css/scroll-hint.css">
    <script src="https://unpkg.com/scroll-hint@latest/js/scroll-hint.min.js"></script>

	<?php wp_deregister_script('jquery'); ?>
	<?php wp_head(); ?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body <?php body_class(); ?>>
	<header class="l-header p-header">
		<div class="p-header__top">
			<<?php $html_tag = (is_home() || is_front_page()) ? 'h1' : 'div';
				echo $html_tag; ?> class="p-header__site-brand">
				<a href="<?php echo home_url('/'); ?>">
					<span class="c-fish-icon"></span>
					わが国周辺の水産資源の評価
				</a>
			</<?php $html_tag = (is_home() || is_front_page()) ? 'h1' : 'div';
				echo $html_tag; ?>>

			<div class="p-header__utility">
				<form method="get" action="<?php echo esc_url(home_url('/')); ?>">
					<div class="p-header__search">
						<input type="text" name="s" value="<?php echo get_search_query(); ?>" placeholder="サイト内検索">
						<button type="submit"><span class="p-icon-search"><img src="<?php _e_asset_url('img/icon_search.svg'); ?>" alt="サイト内検索"></span></button>
					</div>
				</form>

				<a href="<?php echo esc_url(home_url('/')); ?>sitemap/" class="p-sitemap-link">サイトマップ</a>

				<a href="<?php echo esc_url(home_url('/')); ?>contact/" class="p-button">お問い合わせ</a>

			</div>
		</div>
		<nav class="p-global-nav">
			<div class="container">
				<ul>
					<li><a href="<?php echo esc_url(home_url('/')); ?>about/" class="js-waves">水産資源評価とは</a></li>
					<li><a href="<?php echo esc_url(home_url('/')); ?>hyouka/" class="js-waves">水産資源評価結果</a></li>
					<li><a href="<?php echo esc_url(home_url('/')); ?>gk/" class="js-waves">漁海況予報</a></li>
					<li><a href="<?php echo esc_url(home_url('/')); ?>kouseidoka/" class="js-waves">高精度化事業 </a></li>
				</ul>
			</div>
		</nav>


		<!-- スマホ用メニュー -->
		<div id="js-menu" class="p-menu">
			<div class="container">
				<form method="get" action="<?php echo esc_url(home_url('/')); ?>">
					<div class="p-header__search">
						<input type="text" name="s" value="" placeholder="サイト内検索">
						<button type="submit"><span class="p-icon-search"><img src="<?php _e_asset_url('img/icon_search.svg'); ?>" alt="サイト内検索"></span></button>
					</div>
				</form>
				<nav class="p-sp-nav">
					<ul class="p-sp-nav__main">
						<li><a href="<?php echo esc_url(home_url('/')); ?>about/" class="js-waves">水産資源評価とは</a></li>
						<li><a href="<?php echo esc_url(home_url('/')); ?>hyouka/" class="js-waves">水産資源評価結果</a></li>
						<li><a href="<?php echo esc_url(home_url('/')); ?>gk/" class="js-waves">漁海況予報</a></li>
						<li><a href="<?php echo esc_url(home_url('/')); ?>kouseidoka/" class="js-waves">高精度化事業</a></li>
						<li><a href="<?php echo esc_url(home_url('/')); ?>contact/" class="js-waves">お問い合わせ</a></li>
						<li><a href="<?php echo esc_url(home_url('/')); ?>sitemap/" class="js-waves">サイトマップ</a></li>
						<li><a href="<?php echo esc_url(home_url('/')); ?>update/" class="js-waves">更新情報</a></li>
						<li><a href="<?php echo esc_url(home_url('/')); ?>reference/" class="js-waves">関連リンク・パンフレット等</a></li>
					</ul>

					<ul class="p-sp-nav__privacy">
						<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>copyright/">著作権・免責事項</a></li>
						<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>privacy/">プライバシーポリシー</a></li>
					</ul>
				</nav>
			</div>

		</div>
		<!-- スマホ用メニュー -->

		<!-- スマホ用メニュー展開ボタン -->
		<div class="p-menu-button">
			<a id="js-menu-button" href="javascript:void(0)">
				<div class="p-hamburger">
					<span></span>
					<span></span>
					<span></span>
				</div>
			</a>
		</div>
		<!-- スマホ用メニュー展開ボタン -->


	</header>