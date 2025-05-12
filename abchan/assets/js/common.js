/**
 * common.js
 */

(function ($) {
	$(document).ready(function () {

		/**
		 * Waves設定
		 */
		Waves.init();
		Waves.attach('.js-waves');
		Waves.attach('.js-waves-light', ['waves-light']);
		Waves.attach('.p-button', ['waves']);


		/**
		 * テーブルスクロールヒント
		 */
		new ScrollHint('.js-scrollable ', {
			// suggestiveShadow: true,
			remainingTime: 5000,
			i18n: {
				scrollable: 'スクロールできます'
			}
		});


		/**
		 * ヘッダー固定
		 */
		// $(window).scroll(function () {
		// 	if ($(this).scrollTop() > 200) {
		// 		$('.p-header').addClass('is-fixed');
		// 		$('.p-header').removeClass('is-transparent');
		// 	} else {
		// 		if (!$('html').hasClass('js-sp-bg-fixed')) {
		// 			$('.p-header').removeClass('is-fixed');
		// 			if ($('body').hasClass('home')) {
		// 				$('.p-header').addClass('is-transparent');
		// 			}
		// 		}
		// 	}
		// });


		/**
		* スマホメニュー展開
		*/
		//ウィンドウサイズを取得しておく
		var sp_flag = false;
		$(window).on('load resize', function () {
			sp_flag = (window.matchMedia('(max-width:1199.99px)').matches); // IE10+
		});

		$('#js-menu-button').on('click', function () {
			$('.p-hamburger,#js-menu').toggleClass('is-active');
			// $('#js-menu').fadeToggle();

			//メニュー展開時にbody固定
			if ($('.p-hamburger').hasClass('is-active')) {
				if (!$('html').hasClass('js-sp-bg-fixed')) {
					scrollPos = $(window).scrollTop();
					$('html').addClass('js-sp-bg-fixed').css('top', -scrollPos + 'px');
				}
			} else {
				if ($('html').hasClass('js-sp-bg-fixed')) {
					$("html").removeClass("js-sp-bg-fixed").css('top', 0 + 'px');
					window.scrollTo(0, scrollPos);
				}
			}
		});
		//ウィンドウがPC幅だったらSPメニュー展開時に背景固定を解除
		$(window).resize(function () {
			if (!sp_flag) {
				if ($('html').hasClass('js-sp-bg-fixed')) {
					$("html").removeClass("js-sp-bg-fixed").css('top', 0 + 'px');
				}
			}
		});


		/**
		* スマホメニュー閉じるボタン
		*/
		// $('.p-menu .p-close').on('click', function () {
		// 	$('.p-hamburger,#js-menu').toggleClass('is-active');
		// 	$('#js-menu').fadeToggle();

		// 	if ($('.p-hamburger').hasClass('is-active')) {
		// 		if (!$('html').hasClass('js-sp-bg-fixed')) {
		// 			scrollPos = $(window).scrollTop();
		// 			$('html').addClass('js-sp-bg-fixed').css('top', -scrollPos + 'px');
		// 		}
		// 	} else {
		// 		if ($('html').hasClass('js-sp-bg-fixed')) {
		// 			$("html").removeClass("js-sp-bg-fixed").css('top', 0 + 'px');
		// 			window.scrollTo(0, scrollPos);
		// 		}
		// 	}
		// });




		/**
		 * 汎用アコーディオン開閉
		 */
		$(".js-more").on("click", function () {
			$(this).next().slideToggle();
			$(this).toggleClass('is-open');
		});


		/**
		 * ページトップボタン 画面スクロールで表示/非表示
		 */
		var show_flug = false;
		var top_btn = $('#pagetop');
		// top_btn.css('bottom', '-120px');
		var show_flug = false;
		$(window).scroll(function () {
			if ($(this).scrollTop() > 800) {
				if (show_flug == false) {
					show_flug = true;
					top_btn.fadeIn();
				}
			} else {
				if (show_flug) {
					show_flug = false;
					top_btn.fadeOut();
				}
			}
		});
		// スムーススクロール
		$('#pagetop').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 500);
			return false;
		});

		/**
		 * ページ内リンク
		 */
		var headerHeight = $('body>.p-header').outerHeight();
		var speed = 550;
		var urlHash = location.hash;
		if (urlHash) {
			$('body,html').stop().scrollTop(0);
			setTimeout(function () {
				var target = $(urlHash);
				var position = target.offset().top - headerHeight;
				$('body,html').stop().animate({ scrollTop: position }, speed);
			}, 100);
		}

		var documentUrl = location.origin + location.pathname + location.search;
		jQuery(document).on('click', 'a[href*="#"]', function (event) {
			var anchor = event.currentTarget;
			var anchorUrl = anchor.protocol + '//' + anchor.host + anchor.pathname + anchor.search;
			if (documentUrl !== anchorUrl) {
				return true;
			}
			var position = $(anchor.hash).offset().top - headerHeight;
			jQuery('body,html').stop().animate({ scrollTop: position }, speed, 'swing');
			event.preventDefault();
			return false;
		});

		/**
		 * ホーム更新情報タブ切り替え
		 */
		$(function () {
			$('.js-tab').on('click', function () {
				$('.js-tab, .js-panel').removeClass('is-active');

				$(this).addClass('is-active');

				var index = $('.js-tab').index(this);
				$('.js-panel').eq(index).addClass('is-active');
			});
		});


	});


})(jQuery);

