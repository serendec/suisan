<?php
require_once __DIR__ . '/includes/class-app-search-manager.php';
require_once __DIR__ . '/includes/resource-assessment/class-app-resource-assessment-facets-factory.php';
require_once __DIR__ . '/includes/resource-assessment/class-app-resource-assessment-search-service.php';
require_once __DIR__ . '/includes/conditions-forecast/class-app-conditions-forecast-facets-factory.php';
require_once __DIR__ . '/includes/conditions-forecast/class-app-conditions-forecast-search-service.php';
require_once __DIR__ . '/includes/resource-document/class-app-resource-document-facets-factory.php';
require_once __DIR__ . '/includes/resource-document/class-app-resource-document-search-service.php';

App_Search_Manager::boot([
    'resource_assessment' => [
        'csv_field' => 'backnumber_fish_source_file',
        'csv_encode' => 'UTF-8',
        'facets_factory' => App_Resource_Assessment_Facets_Factory::class,
        'search_service' => App_Resource_Assessment_Search_Service::class,
    ],
    'conditions_forecast' => [
        'csv_field' => 'backnumber_gk_fish_source_file',
        'csv_encode' => 'UTF-8',
        'facets_factory' => App_Conditions_Forecast_Facets_Factory::class,
        'search_service' => App_Conditions_Forecast_Search_Service::class,
    ],
    'resource_document' => [
        'csv_field' => 'backnumber_resource_documents_csv',
        'csv_encode' => 'UTF-8',
        'facets_factory' => App_Resource_Document_Facets_Factory::class,
        'search_service' => App_Resource_Document_Search_Service::class,
    ],
]);

/**
 * @return App_Conditions_Forecast_Facets|null
 * @throws Exception
 */
function app_get_conditions_forecast_search_facets(): ?App_Conditions_Forecast_Facets
{
    if ($resource = App_Search_Manager::instance()->getResource('conditions_forecast')) {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $resource->getFacets();
    }

    return null;
}

/**
 * @return App_Resource_Assessment_Facets|null
 * @throws Exception
 */
function app_get_resource_assessment_search_facets(): ?App_Resource_Assessment_Facets
{
    if ($resource = App_Search_Manager::instance()->getResource('resource_assessment')) {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $resource->getFacets();
    }

    return null;
}

/**
 * @return App_Resource_Document_Facets|null
 * @throws Exception
 */
function app_get_resource_document_search_facets(): ?App_Resource_Document_Facets
{
    if ($resource = App_Search_Manager::instance()->getResource('resource_document')) {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $resource->getFacets();
    }

    return null;
}

/**
 * @return array [year => [type => [App_Resource_Assessment_Search_Result_Item, ...]], ...]
 * @throws Exception
 */
function app_handle_resource_assessment_search_request(): array
{
    if (!$resource = App_Search_Manager::instance()->getResource('resource_assessment'))
        return [];

    $conditions = $_GET['search'] ?? [];

    if (!is_array($conditions) || empty($conditions))
        return [];

    $conditions = array_map(function ($value) {
        return trim($value) ?: null;
    }, $conditions);

    $results = $resource->searchFromCsv($conditions);

    $results = array_reduce($results, function ($carry, App_Resource_Assessment_Search_Result_Item $item) {
        if (!isset($carry[$item->getYear()])) {
            $carry[$item->getYear()] = [];
        }

        if (!isset($carry[$item->getYear()][$item->getType()])) {
            $carry[$item->getYear()][$item->getType()] = [];
        }

        $carry[$item->getYear()][$item->getType()][] = $item;

        return $carry;
    }, []);

    krsort($results);

    return $results;
}

/**
 * @return array [year => [App_Conditions_Forecast_Search_Result_Item, ...], ...]
 * @throws Exception
 */
function app_handle_conditions_forecast_search_request(): array
{
    if (!$resource = App_Search_Manager::instance()->getResource('conditions_forecast'))
        return [];

    $conditions = $_GET['search'] ?? [];

    if (!is_array($conditions) || empty($conditions))
        return [];

    $conditions = array_map(function ($value) {
        return trim($value) ?: null;
    }, $conditions);

    $results = $resource->searchFromCsv($conditions);

    $results = array_reduce($results, function ($carry, App_Conditions_Forecast_Search_Result_Item $item) {
        if (!isset($carry[$item->getYear()])) {
            $carry[$item->getYear()] = [];
        }

        $carry[$item->getYear()][] = $item;

        return $carry;
    }, []);

    krsort($results);

    return $results;
}

/**
 * @return array
 * @throws Exception
 */
function app_handle_conditions_resource_document_search_request(): array
{
    if (!$resource = App_Search_Manager::instance()->getResource('resource_document'))
        return [];

    $conditions = $_GET['search'] ?? [];

    if (!is_array($conditions) || empty($conditions))
        return [];

    $conditions = array_map(function ($value) {
        return trim($value) ?: null;
    }, $conditions);

    $results = $resource->searchFromCsv($conditions);

    $results = array_reduce($results, function ($carry, App_Resource_Document_Search_Result_Item $item) {
        if (!isset($carry[$item->getYear()])) {
            $carry[$item->getYear()] = [];
        }

        $carry[$item->getYear()][] = $item;

        return $carry;
    }, []);

    krsort($results);

    return $results;
}

//the_posts_paginationのマークアップ変更
function custom_the_posts_pagination($template)
{
    $template = '<div class="page-numbers">%3$s</div>';
    return $template;
}
add_filter('navigation_markup_template', 'custom_the_posts_pagination');




//YouTubeのURLにclassを付与
function custom_youtube_oembed($code)
{
    if (strpos($code, 'youtu.be') !== false || strpos($code, 'youtube.com') !== false) {
        $html = preg_replace("@src=(['\"])?([^'\">\s]*)@", "src=$1$2&showinfo=0&rel=0", $code);
        $html = preg_replace('/ width="\d+"/', '', $html);
        $html = preg_replace('/ height="\d+"/', '', $html);
        $html = '<div class="wp-block-embed-youtube"><div class="wp-block-embed__wrapper">' . $html . '</div></div>';

        return $html;
    }
    return $code;
}
add_filter('embed_handler_html', 'custom_youtube_oembed');
add_filter('embed_oembed_html', 'custom_youtube_oembed');


//pre_get_postsのカスタマイズ
function custom_pre_get_posts($query)
{
    if (is_admin() || !$query->is_main_query())
        return;
    // フロントページの表示件数を変更
    // if ( $query-> is_front_page() ) {
    //     $query->set( 'posts_per_page', '5' );
    // }

    if ( $query-> is_tax('fiscal-year') ) {
        $query->set( 'posts_per_page', '-1' );
    }
    // if ($query->is_tax('study_type')) {
    //     $query->set('orderby', 'menu_order');
    //     $query->set('order', 'ASC');
    // }
    // if ($query->is_tax('course')) {
    //     $query->set('orderby', 'menu_order');
    //     $query->set('order', 'ASC');
    // }
}
add_action('pre_get_posts', 'custom_pre_get_posts');





/**
 *
 * ACFオプションページ
 *
 */

if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => 'オプション設定',
        'menu_title' => 'オプション設定',
        'menu_slug' => 'option_setting',
        'capability' => 'edit_posts',
        'redirect' => false
    ));
}

/*【管理画面】投稿メニューを非表示 */
function remove_menus()
{
	global $menu;
	remove_menu_page('edit.php'); // 投稿を非表示
}
add_action('admin_menu', 'remove_menus');

/**
 *
 * カスタム投稿タイプ
 *
 */
function create_post_type() {
	// 更新情報 -------------- //
	register_post_type(
		'update',
		array(
			'label' => '更新情報',
			'public' => true,
			'has_archive' => true,
			'menu_position' => 5,
			// 'menu_icon' => 'dashicons-hammer',
			'supports' => array(
				'title',
				'editor',
				'thumbnail',
				'revisions'
			)
		)
	);
	register_taxonomy(
		'update-cat',
		'update',
		array(
			'label' => 'カテゴリー',
			'labels' => array(
				'all_items' => 'カテゴリー一覧',
				'add_new_item' => 'カテゴリーを追加'
			),
			'hierarchical' => true,
			// 'rewrite'  => array(
			// 	'slug' => 'gk/year'
			// )
		)
	);
	// 資源管理目標案等を提示した資源評価の対象魚種系群 -------------- //
	register_post_type(
		'hyouka-type1',
		array(
			'label' => '資源管理目標案等を提示した資源評価の対象魚種系群',
			'public' => true,
			'has_archive' => true,
			'menu_position' => 5,
			// 'menu_icon' => 'dashicons-hammer',
			'supports' => array(
				'title',
				'editor',
				'thumbnail',
				'revisions'
			)
		)
	);

	// 資源管理目標案等を提示していない資源評価の対象魚種系群 -------------- //
	register_post_type(
		'hyouka-type2',
		array(
			'label' => '資源管理目標案等を提示していない資源評価の対象魚種系群',
			'public' => true,
			'has_archive' => true,
			'menu_position' => 5,
			// 'menu_icon' => 'dashicons-hammer',
			'supports' => array(
				'title',
				'editor',
				'thumbnail',
				'revisions'
			)
		)
	);

	// 令和元年度より対象となった魚種、海域 -------------- //
	register_post_type(
		'hyouka-type3',
		array(
			'label' => '令和元年度より対象となった魚種、海域',
			'public' => true,
			'has_archive' => true,
			'menu_position' => 5,
			// 'menu_icon' => 'dashicons-hammer',
			'supports' => array(
				'title',
				'editor',
				'thumbnail',
				'revisions'
			)
		)
	);



	// 漁海況予報 -------------- //
	register_post_type(
		'gk',
		array(
			'label' => '漁海況予報',
			'public' => true,
			'has_archive' => true,
			'menu_position' => 5,
			// 'menu_icon' => 'dashicons-hammer',
			'supports' => array(
				'title',
				'editor',
				'thumbnail',
				'revisions'
			)
		)
	);
	register_taxonomy(
		'fiscal-year',
		'gk',
		array(
			'label' => '年度',
			'labels' => array(
				'all_items' => '年度一覧',
				'add_new_item' => '年度を追加'
			),
			'hierarchical' => true,
			'rewrite'  => array(
			  'slug' => 'gk/year'
			)
		)
	);
}
add_action( 'init', 'create_post_type' );


add_rewrite_rule('gk/year/([^/]+)/?$', 'index.php?fiscal-year=$matches[1]', 'top');


//固定ページや記事の任意の箇所でPHPファイルをincludeするショートコード
function Include_my_php($params = array()) {
    extract(shortcode_atts(array(
        'file' => 'default'
    ), $params));
    ob_start();
    include(get_theme_root() . '/' . get_template() . "/$file.php");
    return ob_get_clean();
}
add_shortcode('myphp', 'Include_my_php');


//body_class()にページスラッグを
function pagename_class($classes = '')
{
    if (is_page() && !is_page("ホーム")) {
        $page = get_page(get_the_ID());
        $classes[] = $page->post_name;
    }
    return $classes;
}
add_filter('body_class', 'pagename_class');

//カスタムメニュー
add_theme_support('menus');

//アイキャッチ画像を有効化
add_theme_support('post-thumbnails');

/* 作成するサムネイルのサイズ設定 */
add_image_size('thumb-600_400', 600, 400, true);
// add_image_size( 'thumb-240_320', 240, 320, true );
// add_image_size( 'thumb-200_100', 200, 100, true );

//テンプレートフォルダのパスをショートコードに登録
function shortcode_templateurl()
{
    return get_bloginfo('template_url');
}
add_shortcode('template_url', 'shortcode_templateurl');

//HOMEのURLをショートコードで表示
add_shortcode( 'homeurl', 'shortcode_homeurl' );
function shortcode_homeurl( $atts, $content = '' ) {
	return esc_url( home_url() ).$content;
}

//タイトル文字数制限して...を表示
function trim_str_by_chars($str, $len, $echo = true, $suffix = '…', $encoding = 'UTF-8')
{
    if (!function_exists('mb_substr') || !function_exists('mb_strlen')) {
        return $str;
    }
    $len = (int)$len;
    if (mb_strlen($str = wp_specialchars_decode(strip_tags($str), ENT_QUOTES, $encoding), $encoding) > $len) {
        $str = wp_specialchars(mb_substr($str, 0, $len, $encoding) . $suffix);
    }
    if ($echo) {
        echo $str;
    } else {
        return $str;
    }
}


// アセット用のURLを定義
define('WP_ASSET_URL', get_template_directory_uri().'/assets');

/**
* アセットURLの取得
*
* @param string $path   画像やJSまでのパス
* @return string
*/
function _asset_url($path = '') {
    $url = rtrim(WP_ASSET_URL, '/');
    if( strpos($path, '/') !== 0 ) {
        $url .= '/';
    }
    $url .= $path;
    if( preg_match('/\.(css|js|jpe?g|png|gif|svg)/', $url, $matches) ) {
        $version = wp_get_theme()->get('Version');
        $url = add_query_arg(['ver' => $version], $url);
    }
    return $url;
}

/**
* アセットURLの出力
*
* @param string $path   画像やJSまでのパス
* @return string
*/
function _e_asset_url($path = '') {
    echo _asset_url($path);
}

//WP検索からカスタム投稿を除外
function search_exclude_custom_post_type( $query ) {
	if ( $query->is_search() && $query->is_main_query() && ! is_admin() ) {
		$query->set( 'post_type', array( 'post', 'page' ) );
	}
}
add_filter( 'pre_get_posts', 'search_exclude_custom_post_type' );


// カテゴリーとタグのmeta descriptionからpタグを除去
remove_filter('term_description','wpautop');


//カスタム投稿'gk'のクエリ調整 （過去の漁海況予報の固定ページ（gk/backnumber）が404になるのを回避）
add_filter( 'pre_get_posts', function( WP_Query $query ) {
	global $wp;
	if ( is_admin() || ! $query->is_main_query() || is_post_type_archive('gk')) {
		return $query;
	}
	if ( get_page_by_path( $wp->request ) && 'gk' === $query->get( 'post_type' ) ) {
		$query->parse_query( "pagename={$wp->request}" );
	}
	return $query;
} );


/**
 * API関係脆弱性の対応
 */
// author情報でユーザー名を特定できないようにする
function theme_slug_redirect_author_archive() {
    if (is_author() ) {
        wp_redirect( home_url());
        exit;
    }
}
add_action( 'template_redirect', 'theme_slug_redirect_author_archive' );

// wp-json/wp/v2/usersリクエストへの対策
function my_filter_rest_endpoints( $endpoints ) {
    if ( isset( $endpoints['/wp/v2/users'] ) ) {
        unset( $endpoints['/wp/v2/users'] );
    }
    if ( isset( $endpoints['/wp/v2/users/(?P<id>\d+)'] ) ) {
        unset( $endpoints['/wp/v2/users/(?P<id>\d+)'] );
    }
    return $endpoints;
}
add_filter( 'rest_endpoints', 'my_filter_rest_endpoints', 10, 1 );