<?php
/** engp functions and definitions
 *
 * @package engp
 */

require_once 'mediaUploader.php';


/**
 * 定数
 */
// テーブル名
define('CUSTOM_TBL_SCHOOL_META', 'ex_school_meta');
define('CUSTOM_TBL_SCHOOL_COST', 'ex_school_cost');
define('CUSTOM_TBL_USERS', 'ex_users');
define('CUSTOM_TBL_FAVORITE', 'ex_favorite');
define('CUSTOM_TBL_SCHOOL_REVIEW', 'ex_school_review');
define('TBL_SCHOOL_POSTS', 'posts');

// 空文字チェック
define('MODE_EMPTY_CHECK_ON', 1);
// 評価星サイズ
define('STAR_SMALL', 0);
define('STAR_MIDDLE', 1);
// レビュー項目インデックス数
define('PAGE_INDEX', 5);
define('PAGE_INDEX_MAX', 9);
// メールアドレス
define('MASTER_MAIL_ADDRES', 'englishpedia@ryugaku-johokan.com');
// メールフッター
define('MASTER_MAIL_FOOTER', '
┏┏┏┏━━━━━━━━━━━━━━━━━━━━━━
┏╋┏　“English Pedia イングリッシュペディア”
┏┏■　 『手数料無料であなたの留学を応援します！』
┏　　　　http://www.englishpedia.jp　
┃
┃ 運営会社：株式会社留学情報館
┃ TEL：0120-070-050　FAX：03-5348-5095
┃ 新　宿：東京都新宿区西新宿7-2-12　松下産業ビル4階
┃ 大　阪：大阪府大阪市北区堂山町1-5 梅田三共ビル8F
┃ ロサンゼルス：10845 Lindbrook Dr,#202 Los Angeles CA.
┃ ニューヨーク：540 West 136 Street, Suite 2 NY, NY.
┗━━━━━━━━━━━━━━━━━━━━━━━━━　
');


// 管理画面学校項目インデックス数
define('ADMIN_REVIEW_SCHOOL_PAGE_INDEX', 10);
// 管理画面レビュー項目インデックス数
define('ADMIN_REVIEW_PAGE_INDEX', 5);
// 承認フラグ設定
define('UNAPPROVED_FLG', 0);
define('APPROVED_FLG', 1);
// 添付ファイル保存ディレクトリ(テーマまでは関数で取得)
define('PHOTO_DIR', get_stylesheet_directory().'/review_photo/');
define('PHOTO_URL', get_stylesheet_directory_uri().'/review_photo/');


/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

// ログ出力
if ( ! function_exists('_log') ) {
	function _log( $message ) {
		if ( WP_DEBUG === true ) {
			if ( is_array( $message ) || is_object( $message ) ) {
				error_log( print_r( $message, true ) );
			} else {
				error_log( $message );
			}
		}
	}
}

// ウィジェットを表示
if ( function_exists('register_sidebar') ){
	register_sidebars( 2,array(
	'name' => __( 'side-widget%d' ),
	'id' => 'side-widget',
	'before_widget' => '<li class="widget-container">',
	'after_widget' => '</li>',
	'before_title' => '<h2 class="widget-title">',
	'after_title' => '</h2>',
	) );
}

/*** Start：WordPressの管理画面メニュー設定 ********************/
/*
	権限一覧
	  ユーザーレベル 10：administrator（管理者）
	  ユーザーレベル  7：editor（編集者）
	  ユーザーレベル  2：author（投稿者）
	  ユーザーレベル  1：contributor（寄稿者）
	  ユーザーレベル  0：subscriber（購読者）
*/
/***************************************************************
 * バージョン更新
 ***************************************************************/
if ( ! current_user_can('administrator') ) {
	// バージョン更新を非表示にする
	add_filter( 'pre_site_transient_update_core', '__return_zero' );
	// APIによるバージョンチェックの通信をはずす
	remove_action( 'wp_version_check', 'wp_version_check' );
	remove_action( 'admin_init', '_maybe_update_core' );
}

/***************************************************************
 * フッター
 ***************************************************************/
function custom_admin_footer() {
	if ( ! current_user_can( 'administrator' ) ) {
		echo '&nbsp;';
	}
}
add_filter( 'admin_footer_text', 'custom_admin_footer' );

/***************************************************************
 * 管理バーメニュー
 ***************************************************************/
// 項目削除
function remove_admin_bar_menu( $wp_admin_bar ) {
	$wp_admin_bar->remove_menu( 'wp-logo' );		// WordPressロゴ
	$wp_admin_bar->remove_menu( 'new-content' );	// 新規
	$wp_admin_bar->remove_menu( 'comments' );		// コメント
	$wp_admin_bar->remove_menu( 'updates' );		// 更新
	$wp_admin_bar->remove_menu( 'my-account' );	// マイアカウント
}
add_action( 'admin_bar_menu', 'remove_admin_bar_menu', 200 );

// ログアウト追加
function add_new_item_in_admin_bar() {
	global $wp_admin_bar;
	$wp_admin_bar->add_menu(
			array(
				'id' => 'new-item-in-admin-bar',
				'title' => __('ログアウト'),
				'href' => wp_logout_url()
			)
		);
}
add_action( 'wp_before_admin_bar_render', 'add_new_item_in_admin_bar' );

/***************************************************************
 * ダッシュボードメニュー
 ***************************************************************/
// ようこそメニュー削除
remove_action( 'welcome_panel', 'wp_welcome_panel' );

// ヘッダー削除
function my_admin_head(){
	if( ! current_user_can( 'administrator' ) ) {
		echo '<style type="text/css">#contextual-help-link-wrap{display:none;}</style>' . PHP_EOL;	// ヘルプ
		echo '<style type="text/css">#screen-options-link-wrap{display:none;}</style>' . PHP_EOL;		// 表示オプション
	}
}
add_action( 'admin_head', 'my_admin_head' );

// ウィジェット非表示
function example_remove_dashboard_widgets() {
	if ( ! current_user_can( 'administrator' ) ) {
		global $wp_meta_boxes;
		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now'] ); 			// 現在の状況
		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments'] );	// 最近のコメント
		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links'] );		// 被リンク
		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins'] );			// プラグイン
		unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press'] );			// クイック投稿
		unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts'] );		// 最近の下書き
		unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_primary'] );				// WordPressブログ
		unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary'] );			// WordPressフォーラム
	}
}
add_action( 'wp_dashboard_setup', 'example_remove_dashboard_widgets' );

/***************************************************************
 * サイドバーメニュー
 ***************************************************************/
function remove_menus () {
	if ( ! current_user_can( 'administrator' ) ) {
		global $menu;
		unset( $menu[2] );	// ダッシュボード
		unset( $menu[4] );	// メニューの線1
		unset( $menu[5] );	// 投稿
		unset( $menu[10] );	// メディア
		unset( $menu[15] );	// リンク
		unset( $menu[20] );	// ページ
		unset( $menu[25] );	// コメント
		unset( $menu[59] );	// メニューの線2
		unset( $menu[60] );	// テーマ
		unset( $menu[65] );	// プラグイン
		unset( $menu[70] );	// プロフィール
		unset( $menu[75] );	// ツール
		unset( $menu[80] );	// 設定
		unset( $menu[90] );	// メニューの線3
	}
}
add_action( 'admin_menu', 'remove_menus' );

/*** End：WordPressの管理画面メニュー設定 **********************/

/***************************************************************/
// EnglishPedia管理画面用スタイルシートファイル指定
/***************************************************************/
add_action('admin_head', 'engp_admin_print_styles');
function engp_admin_print_styles() {
	echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('template_url') . '/css/admin-common.css" />' . PHP_EOL;
	echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('template_url') . '/css/jquery-ui-1.11.2.custom.min.css" />' . PHP_EOL;
	echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('template_url') . '/css/ui.jqgrid.css" />' . PHP_EOL;
}

/***************************************************************/
// EnglishPedia管理画面用javascriptファイル指定
/***************************************************************/
add_action('admin_head', 'engp_admin_print_scripts');
function engp_admin_print_scripts() {
	echo '<script type="text/javascript" src="' . get_bloginfo('template_url') . '/js/admin-common.js"></script>' . PHP_EOL;
	echo '<script type="text/javascript" src="' . get_bloginfo('template_url') . '/js/jquery-ui-1.11.2.custom.min.js"></script>' . PHP_EOL;
	echo '<script type="text/javascript" src="' . get_bloginfo('template_url') . '/js/jquery.jqGrid.min.js"></script>' . PHP_EOL;
	echo '<script type="text/javascript" src="' . get_bloginfo('template_url') . '/js/grid.locale-ja.js"></script>' . PHP_EOL;
}

/***************************************************************/
// 選択肢
//    投稿画面、学校詳細情報表示時に利用
/***************************************************************/
function engp_get_master(){
	$engp_master = array(
		'country'=>array(
			1=>'アメリカ',
			2=>'カナダ',
			3=>'オーストラリア',
			4=>'ニュージーランド',
			5=>'イギリス',
			6=>'アイルランド',
			7=>'マルタ',
			8=>'フィリピン'
		),
		'division'=>array(
			 1=>'ロサンゼルス',
			 2=>'ニューヨーク',
			 3=>'サンフランシスコ',
			 4=>'ボストン',
			 5=>'フロリダ',
			 6=>'ハワイ',
			 7=>'シアトル',
			 8=>'サンディエゴ',
			 9=>'シカゴ',
			10=>'その他'
		),
		'purpose'=>array(
			1=>'とにかく外国語を話せるようになりたい',
			2=>'資格取得/TOEICスコアアップなど留学を形に残したい',
			3=>'ダンス/ヨガ/ネイルなど語学＋αのスキルを身につけたい',
			4=>'とにかく海外で（を）生活・体験してみたい',
			5=>'将来は大学・大学院へ進学したい'
		),
		'week'=>array(
			 2=>'2週間',
			 4=>'4週間（およそ1ヶ月）',
			 8=>'8週間（およそ2ヶ月）',
			12=>'12週間（およそ3ヶ月）',
			16=>'16週間（およそ4ヶ月）',
			24=>'24週間（およそ6ヶ月）',
			36=>'36週間（およそ9ヶ月）',
			48=>'48週間（およそ12ヶ月）'
		),
		'lang'=>array(
			1=>'英語'
		),
		'location_type'=>array(
			1=>'○',
			2=>'×'
		),
		'location'=>array(
			1=>'都会',
			2=>'郊外',
			3=>'田舎'
		),
		'parking'=>array(
			1=>'あり',
			2=>'なし'
		),
		'how_to_go'=>array(
			1=>'バス',
			2=>'車',
			3=>'電車',
			4=>'バス、車',
			5=>'バス、電車',
			6=>'車、電車',
			7=>'バス、車、電車'
		),
		'security'=>array(
			1=>'よくない',
			2=>'あまりよくない',
			3=>'問題ない',
			4=>'よい',
			5=>'とてもよい'
		),
		'nationality'=>array(
			1=>'◎',
			2=>'○',
			3=>'△'
		),
		'local_staff'=>array(
			1=>'○'
		),
		'tuition'=>array(
// 			1=>'$500未満',
// 			2=>'$500以上～$1,000未満',
// 			3=>'$1,000以上'
			1=>'$700未満',
			2=>'$700以上～$1,200未満',
			3=>'$1,200以上'

		),
		'option'=>array(
			1=>'ホームスティ可',
			2=>'寮有り',
			3=>'空港出迎え可',
			4=>'プライベートレッスン有り',
			5=>'その他'
		),
		'equipment'=>array(
			1=>'コンピュータルーム利用可',
			2=>'ワイヤレスインターネット利用可',
			3=>'カウンセリングルーム利用可',
			4=>'ジム利用可',
			5=>'図書館利用可',
			6=>'その他利用可'
		),
		'course'=>array(
				1=>'ESL',
				2=>'TOEFL',
				3=>'TOEIC',
				4=>'大学進学',
				5=>'ビジネス',
				6=>'子供向け(U12、U15など)',
				7=>'アダルト(大人向け)',
				8=>'IELTS',
				9=>'その他'
		),
	);
	return $engp_master;
}

/***************************************************************/
// ここからテーマを有効化した時に実行される関数を定義します。
//     テーブルの作成もこの処理で行う
/***************************************************************/
function engp_theme_activated( $oldname, $oldtheme=false ) {
	_log( 'engp_theme_activated' );

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	global $wpdb;
	// 学校
	$table_name = $wpdb->prefix . CUSTOM_TBL_SCHOOL_META;
	$sql = "CREATE TABLE " . $table_name . " (
			meta_id         bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			post_id         bigint(20) UNSIGNED DEFAULT '0' NOT NULL,
			school_name     text comment '学校名',
			school_jp_name  text comment '学校名（和名）',
			address         text comment '住所',
			phone           text comment '電話番号',
			lang            tinyint(3) UNSIGNED DEFAULT NULL comment '言語',
			country         tinyint(3) UNSIGNED DEFAULT NULL comment '国',
			city            text comment '都市',
			area            text comment '地域',
			division        tinyint(3) UNSIGNED DEFAULT NULL comment '地区',
			outline         text comment '概要',
			staff_evaluation tinyint(3) UNSIGNED DEFAULT NULL comment 'スタッフ評価',			
			purpose1        tinyint(3) UNSIGNED DEFAULT NULL comment '検索項目1',
			purpose2        tinyint(3) UNSIGNED DEFAULT NULL comment '検索項目2',
			purpose3        tinyint(3) UNSIGNED DEFAULT NULL comment '検索項目3',
			purpose4        tinyint(3) UNSIGNED DEFAULT NULL comment '検索項目4',
			purpose5        tinyint(3) UNSIGNED DEFAULT NULL comment '検索項目5',
			quality         text comment '授業品質',
			location_type   tinyint(3) UNSIGNED DEFAULT NULL comment '所在',
			location        tinyint(3) UNSIGNED DEFAULT NULL comment 'ロケーション',
			parking         tinyint(3) UNSIGNED DEFAULT NULL comment '駐車場',
			how_to_go       tinyint(3) UNSIGNED DEFAULT NULL comment '通学手段',
			security        tinyint(3) UNSIGNED DEFAULT NULL comment '治安',
			nationality     tinyint(3) UNSIGNED DEFAULT NULL comment 'ナショナリティ（国際性）',
			target_ESL      text comment 'コース ESL',
			target_TOEFL    text comment 'コース TOEFL',
			target_TOEIC    text comment 'コース TOEIC',
			target_advance  text comment 'コース 進学',
			target_business text comment 'コース ビジネス',
			target_child    text comment 'コース 子供',
			target_adult    text comment 'コース 大人',
			target_ILETS    text comment 'コース IELTS',
			target_so 		text comment 'コース スペシャルオファー',			
			target_other    text comment 'コース その他',
			lesson_time     text comment 'レッスン時間',
			school_size     text comment 'スクールサイズ',
			levels          text comment 'レベル数',
			avg_classsize   text comment '平均クラスサイズ',
			enrollment      text comment '入学時期',
			options         text comment 'オプション',
			facilities      text comment '学校設備',
			other           text comment 'その他',
			youtube_url     text comment 'YouTube URL',
			local_staff     tinyint(3) UNSIGNED DEFAULT NULL comment '現地スタッフサポート可否',
			recommend       tinyint(3) UNSIGNED DEFAULT NULL comment 'お薦めフラグ',
			UNIQUE KEY meta_id (meta_id)
		)
		CHARACTER SET 'utf8';";
	dbDelta( $sql );

	// 学校費用
	$table_name = $wpdb->prefix . CUSTOM_TBL_SCHOOL_COST;
	$sql = "CREATE TABLE " . $table_name . " (
			cost_id                         bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			post_id                         bigint(20) UNSIGNED DEFAULT '0' NOT NULL,
			viewtype_yen                    tinyint(3) UNSIGNED DEFAULT '0' comment '円表示フラグ',
			admission_fee                   mediumint(8) UNSIGNED DEFAULT NULL comment '入学金',
			accommodation_placement_fee     mediumint(8) UNSIGNED DEFAULT NULL comment '滞在先手配料',
			homestay					    mediumint(8) UNSIGNED DEFAULT NULL comment 'ホームステイ',			
			dormitory_1					    mediumint(8) UNSIGNED DEFAULT NULL comment '学生寮(1人部屋)',			
			dormitory_2					    mediumint(8) UNSIGNED DEFAULT NULL comment '学生寮(2人部屋)',			
			dormitory_3					    mediumint(8) UNSIGNED DEFAULT NULL comment '学生寮(3人部屋)',
			dormitory_4					    mediumint(8) UNSIGNED DEFAULT NULL comment '学生寮(4人部屋)',												
			i20_issuance_postage            mediumint(8) UNSIGNED DEFAULT NULL comment 'I20発行・送料',
			airport_pickup_cost             mediumint(8) UNSIGNED DEFAULT NULL comment '空港出迎え費',
			bank_charge                     mediumint(8) UNSIGNED DEFAULT NULL comment 'バンクチャージ',
			tuition_2w_pt                   mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 パートタイム（2週間）',
			tuition_2w_ft                   mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 フルタイム（2週間）',
			homestay_cost_2w                mediumint(8) UNSIGNED DEFAULT NULL comment 'ホームステイ費（2週間）',
			textbooks_2w                    mediumint(8) UNSIGNED DEFAULT NULL comment 'テキスト代（2週間）',
			tuition_4w_pt                   mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 パートタイム（4週間）',
			tuition_4w_ft                   mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 フルタイム（4週間）',
			tuition_4w_cs3                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 コース3（4週間）',			
			tuition_4w_cs4                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 コース4（4週間）',
			tuition_4w_cs5                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 コース5（4週間）',
			tuition_4w_cs6                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 コース6（4週間）',
			tuition_4w_cs7                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 コース7（4週間）',																											
			homestay_cost_4w                mediumint(8) UNSIGNED DEFAULT NULL comment 'ホームステイ費（4週間）',
			textbooks_4w                    mediumint(8) UNSIGNED DEFAULT NULL comment 'テキスト代（4週間）',
			tuition_8w_pt                   mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 パートタイム（8週間）',
			tuition_8w_ft                   mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 フルタイム（8週間）',
			tuition_8w_cs3                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 コース3（8週間）',			
			tuition_8w_cs4                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 コース4（8週間）',
			tuition_8w_cs5                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 コース5（8週間）',
			tuition_8w_cs6                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 コース6（8週間）',
			tuition_8w_cs7                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 コース7（8週間）',																											
			homestay_cost_8w                mediumint(8) UNSIGNED DEFAULT NULL comment 'ホームステイ費（8週間）',
			textbooks_8w                    mediumint(8) UNSIGNED DEFAULT NULL comment 'テキスト代（8週間）',
			tuition_12w_pt                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 パートタイム（12週間）',
			tuition_12w_ft                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 フルタイム（12週間）',
			tuition_12w_cs3                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 コース3（12週間）',			
			tuition_12w_cs4                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 コース4（12週間）',
			tuition_12w_cs5                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 コース5（12週間）',
			tuition_12w_cs6                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 コース6（12週間）',
			tuition_12w_cs7                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 コース7（12週間）',																														
			homestay_cost_12w               mediumint(8) UNSIGNED DEFAULT NULL comment 'ホームステイ費（12週間）',
			textbooks_12w                   mediumint(8) UNSIGNED DEFAULT NULL comment 'テキスト代（12週間）',
			tuition_16w_pt                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 パートタイム（16週間）',
			tuition_16w_ft                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 フルタイム（16週間）',
			homestay_cost_16w               mediumint(8) UNSIGNED DEFAULT NULL comment 'ホームステイ費（16週間）',
			textbooks_16w                   mediumint(8) UNSIGNED DEFAULT NULL comment 'テキスト代（16週間）',
			tuition_24w_pt                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 パートタイム（24週間）',
			tuition_24w_ft                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 フルタイム（24週間）',
			tuition_24w_cs3                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 コース3（8週間）',			
			tuition_24w_cs4                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 コース4（24週間）',
			tuition_24w_cs5                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 コース5（24週間）',
			tuition_24w_cs6                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 コース6（24週間）',
			tuition_24w_cs7                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 コース7（24週間）',																														
			homestay_cost_24w               mediumint(8) UNSIGNED DEFAULT NULL comment 'ホームステイ費（24週間）',
			textbooks_24w                   mediumint(8) UNSIGNED DEFAULT NULL comment 'テキスト代（24週間）',
			tuition_36w_pt                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 パートタイム（36週間）',
			tuition_36w_ft                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 フルタイム（36週間）',
			tuition_36w_cs3                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 コース3（36週間）',			
			tuition_36w_cs4                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 コース4（36週間）',
			tuition_36w_cs5                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 コース5（36週間）',
			tuition_36w_cs6                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 コース6（36週間）',
			tuition_36w_cs7                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 コース7（36週間）',																														
			homestay_cost_36w               mediumint(8) UNSIGNED DEFAULT NULL comment 'ホームステイ費（36週間）',
			textbooks_36w                   mediumint(8) UNSIGNED DEFAULT NULL comment 'テキスト代（36週間）',
			tuition_48w_pt                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 パートタイム（48週間）',
			tuition_48w_ft                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 フルタイム（48週間）',
			tuition_48w_cs3                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 コース3（48週間）',			
			tuition_48w_cs4                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 コース4（48週間）',
			tuition_48w_cs5                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 コース5（48週間）',
			tuition_48w_cs6                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 コース6（48週間）',
			tuition_48w_cs7                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 コース7（48週間）',																														
			homestay_cost_48w               mediumint(8) UNSIGNED DEFAULT NULL comment 'ホームステイ費（48週間）',
			textbooks_48w                   mediumint(8) UNSIGNED DEFAULT NULL comment 'テキスト代（48週間）',
			tuition_so1_pt                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 パートタイム（スペシャルオファー1）',
			tuition_so1_ft                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 フルタイム（スペシャルオファー1）',
			homestay_cost_so1               mediumint(8) UNSIGNED DEFAULT NULL comment 'ホームステイ費（スペシャルオファー1）',
			textbooks_so1                   mediumint(8) UNSIGNED DEFAULT NULL comment 'テキスト代（スペシャルオファー1）',
			tuition_so2_pt                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 パートタイム（スペシャルオファー2）',
			tuition_so2_ft                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 フルタイム（スペシャルオファー2）',
			homestay_cost_so2               mediumint(8) UNSIGNED DEFAULT NULL comment 'ホームステイ費（スペシャルオファー2）',
			textbooks_so2                   mediumint(8) UNSIGNED DEFAULT NULL comment 'テキスト代（スペシャルオファー2）',
			tuition_so3_pt                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 パートタイム（スペシャルオファー3）',
			tuition_so3_ft                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 フルタイム（スペシャルオファー3）',
			homestay_cost_so3               mediumint(8) UNSIGNED DEFAULT NULL comment 'ホームステイ費（スペシャルオファー3）',
			textbooks_so3                   mediumint(8) UNSIGNED DEFAULT NULL comment 'テキスト代（スペシャルオファー3）',
			tuition_so4_pt                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 パートタイム（スペシャルオファー4）',
			tuition_so4_ft                  mediumint(8) UNSIGNED DEFAULT NULL comment '授業料 フルタイム（スペシャルオファー4）',
			homestay_cost_so4               mediumint(8) UNSIGNED DEFAULT NULL comment 'ホームステイ費（スペシャルオファー4）',
			textbooks_so4                   mediumint(8) UNSIGNED DEFAULT NULL comment 'テキスト代（スペシャルオファー4）',
			UNIQUE KEY cost_id (cost_id)
		)
		CHARACTER SET 'utf8';";
	dbDelta( $sql );

	//EnglishPediaユーザー
	$table_name = $wpdb->prefix . CUSTOM_TBL_USERS;
	$sql = "CREATE TABLE " . $table_name . " (
			user_id         bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			user_login      varchar(64) NOT NULL comment 'ユーザー名(メールアドレス)',
			password        varchar(64) NOT NULL comment 'パスワード',
			display_name    varchar(64) NOT NULL comment '公開名',
			email           varchar(64) NOT NULL comment 'メールアドレス',
			process_key     varchar(64) NOT NULL comment '内部処理キー',
			delete_flg      tinyint(3) UNSIGNED DEFAULT '0' NOT NULL comment '削除フラグ',
			regist_date     datetime NOT NULL comment '登録日',
			update_date     datetime DEFAULT NULL comment '更新日',
			UNIQUE KEY user_id (user_id)
		)
		CHARACTER SET 'utf8';";
	dbDelta( $sql );

	//お気に入り
	$table_name = $wpdb->prefix . CUSTOM_TBL_FAVORITE;
	$sql = "CREATE TABLE " . $table_name . " (
			favorite_id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			user_id     bigint(20) UNSIGNED NOT NULL comment 'ユーザーID',
			post_id     bigint(20) UNSIGNED NOT NULL comment '学校ID',
			UNIQUE KEY favorite_id (favorite_id)
		)
		CHARACTER SET 'utf8';";
	dbDelta( $sql );

	//レビュー
	$table_name = $wpdb->prefix . CUSTOM_TBL_SCHOOL_REVIEW;
	$sql = "CREATE TABLE " . $table_name . " (
			review_id       bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			user_id         bigint(20) UNSIGNED NOT NULL comment 'ユーザーID',
			post_id         bigint(20) UNSIGNED NOT NULL comment '学校ID',
			open_name       text comment '公開名',
			post_user_ip    varchar(32) DEFAULT NULL comment '投稿者IPアドレス',
			security_evaluation     tinyint(3) UNSIGNED DEFAULT NULL COMMENT '評価【学校周辺の治安】',
			traffic_evaluation      tinyint(3) UNSIGNED DEFAULT NULL COMMENT '評価【交通の便】',
			clean_evaluation        tinyint(3) UNSIGNED DEFAULT NULL COMMENT '評価【衛生面（綺麗さ）】',
			staff_evaluation        tinyint(3) UNSIGNED DEFAULT NULL COMMENT '評価【学校スタッフの対応】',
			lesson_evaluation       tinyint(3) UNSIGNED DEFAULT NULL COMMENT '評価【授業内容】',
			student_evaluation      tinyint(3) UNSIGNED DEFAULT NULL COMMENT '評価【周りの学生の真剣さ】',
			answer_1                text COMMENT '回答【国籍比率】',
			answer_2                text COMMENT '回答【気に入ってる先生、クラス】',
			answer_3                text COMMENT '回答【気に入ってる点】',
			answer_4                text COMMENT '回答【気に入らない点】',
			satisfaction_evaluation tinyint(3) UNSIGNED DEFAULT NULL COMMENT '評価【満足度】',
			comment                 text COMMENT 'コメント【通学の決め手】',
			selected_comment        text COMMENT '選択コメント【ご利用者の声】',
			repeat_discount_know    tinyint(3) UNSIGNED DEFAULT NULL COMMENT 'リピート割引認識有無',
			approval_flg    tinyint(3) UNSIGNED DEFAULT NULL comment '承認フラグ',
			delete_flg      tinyint(3) UNSIGNED DEFAULT NULL comment '削除フラグ',
			regist_date     datetime NOT NULL comment '登録日',
			update_date     datetime DEFAULT NULL comment '更新日',
			UNIQUE KEY review_id (review_id)
		)
		CHARACTER SET 'utf8';";
	dbDelta( $sql );
}
add_action( "after_switch_theme", "engp_theme_activated", 10 , 2 );

/***************************************************************/
// engp から テーマが変更されたタイミング
//   学校テーブルの削除
/***************************************************************/
function engp_switch_theme( $newname, $newtheme ) {
	_log( 'engp_switch_theme' );

	global $wpdb;
	$table_name = $wpdb->prefix . CUSTOM_TBL_SCHOOL_META;
	$wpdb->query("DROP TABLE {$table_name}");
	$table_name = $wpdb->prefix . CUSTOM_TBL_SCHOOL_COST;
	$wpdb->query("DROP TABLE {$table_name}");
}
add_action( "switch_theme", "engp_switch_theme", 10 , 2 );

if ( ! function_exists( 'engp_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function engp_setup() {
	_log( 'engp_setup' );

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on engp, use a find and replace
	 * to change 'engp' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'engp', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'engp' ),
		'icon' => __( 'Icon Menu', 'engp' ),
	) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'engp_custom_background_args', array(
		'default-color' => 'f8f8f8',
		'default-image' => '',
	) ) );

	// Enable support for HTML5 markup.
	add_theme_support( 'html5', array( 'comment-list', 'search-form', 'comment-form', ) );
}
endif; // engp_setup
add_action( 'after_setup_theme', 'engp_setup' );

/***************************************************************/
// カスタム投稿タイプ（学校）の追加
/***************************************************************/
function engp_school_post_type() {
	_log( 'engp_school_post_type' );

	$labels = array(
			'name'                  => '学校',
			'singular_name'         => '学校',
			'add_new'               => '新規追加',
			'add_new_item'          => '新しく学校を追加',
			'edit_item'             => '学校を編集',
			'new_item'              => '新規学校',
			'all_items'             => '学校一覧',
			'view_item'             => '学校を表示',
			'search_items'          => '学校を検索',
			'not_found'             => '登録された学校はありません',
			'not_found_in_trash'    => 'ゴミ箱に学校はありません。',
			'parent_item_colon'     => '',
	);
	$args = array(
			'labels'        => $labels,
			'public'        => true,
			'menu_position' => 5,
// 			'supports'=> array('title', 'thumbnail', 'excerpt', 'editor','custom-fields') ,
// 			'supports'=> array('custom-fields') ,
			'supports'      => array('editor','engp_ex_meta') ,
			'has_archive'   => true,
			'menu_icon'     => 'dashicons-welcome-learn-more',
	);
	register_post_type( 'school', $args );
}
add_action( 'init', 'engp_school_post_type' );

/***************************************************************/
// メニューに表示する項目追加
/***************************************************************/
add_action( 'admin_menu', 'engp_add_pages' );
function engp_add_pages() {
	add_menu_page( 'レビュー一覧', 'レビュー一覧', 7, 'review_list', 'engp_review_list', 'dashicons-welcome-write-blog', 7 );
// 	add_menu_page( '送信データ一覧', '送信データ一覧', 7, 'post_data_list', 'engp_salesforce_post_data_list', 'dashicons-list-view', 8 );
// 	add_submenu_page( 'post_data_list', '送信データ一覧 留学申し込み', '留学申し込み', 7, 'entry', 'engp_post_data_entry' );
// 	add_submenu_page( 'post_data_list', '送信データ一覧 お問い合わせ', 'お問い合わせ', 7, 'contact', 'engp_post_data_contact' );
// 	add_submenu_page( 'post_data_list', '送信データ一覧 学校新規登録申請', '学校新規登録申請', 7, 'school_regist', 'engp_post_data_school_regist' );
// 	add_submenu_page( 'post_data_list', '送信データ一覧 学校情報相違報告', '学校情報相違報告', 7, 'difference_report', 'engp_post_data_difference_report' );
	remove_submenu_page ('post_data_list', 'post_data_list' );
}

/***************************************************************/
// カスタムフィールドの登録
/***************************************************************/
add_action( 'admin_init', 'engp_ex_metabox' );
function engp_ex_metabox( ) {
	_log( 'engp_ex_metabox' );

	// 管理画面にカスタムフィールド追加
	add_meta_box( 'engp_ex_meta', '学校詳細情報', 'engp_ex_meta_html', 'school' );
	// カスタムフィールドの保存
	add_action ( 'save_post', 'engp_save_meta' );
	// カスタムフィールドの削除
	add_action ( 'delete_post', 'engp_dalete_meta' );
}
/***************************************************************/
// カスタムフィールド投稿画面 の 作成
/***************************************************************/
function engp_ex_meta_html () {
	_log( 'engp_ex_meta_html' );

	global $post;
	$engp_master = engp_get_master();

	wp_nonce_field( 'ex_school_meta', 'ex_school_meta' );

	// 既存データの取得
	$get_meta = engp_get_meta( $post->ID );
	
	// 学校
	$school_name		= engp_get_value( $get_meta->school_name );		// '学校名',
	$school_jp_name		= engp_get_value( $get_meta->school_jp_name );	// '学校名（和名）',
	$address			= engp_get_value( $get_meta->address );			// '住所',
	$phone				= engp_get_value( $get_meta->phone );			// '電話番号',
	$lang				= engp_get_value( $get_meta->lang );			// '言語',
	$country			= engp_get_value( $get_meta->country );			// '国',
	$city				= engp_get_value( $get_meta->city );			// '都市',
	$area				= engp_get_value( $get_meta->area );			// '地域',
	$division			= engp_get_value( $get_meta->division );		// '地区',
	$quality			= engp_get_value( $get_meta->quality );			// '授業品質',
	$outline			= engp_get_value( $get_meta->outline );			// '概要',
	$staff_evaluation	= engp_get_value( $get_meta->staff_evaluation ); // 'スタッフ評価',	
	$purpose1			= engp_get_value( $get_meta->purpose1 );		// '検索項目1',
	$purpose2			= engp_get_value( $get_meta->purpose2 );		// '検索項目2',
	$purpose3			= engp_get_value( $get_meta->purpose3 );		// '検索項目3',
	$purpose4			= engp_get_value( $get_meta->purpose4 );		// '検索項目4',
	$purpose5			= engp_get_value( $get_meta->purpose5 );		// '検索項目5',
	$location_type		= engp_get_value( $get_meta->location_type );	// '所在',
	$location			= engp_get_value( $get_meta->location );		// 'ロケーション',
	$parking			= engp_get_value( $get_meta->parking );			// '駐車場',
	$how_to_go			= engp_get_value( $get_meta->how_to_go );		// '通学手段',
	$security			= engp_get_value( $get_meta->security );		// '治安',
	$nationality		= engp_get_value( $get_meta->nationality );		// 'ナショナリティ（国際性）',
	$target_ESL			= engp_get_value( $get_meta->target_ESL );		// 'コース ESL',
	$target_TOEFL		= engp_get_value( $get_meta->target_TOEFL );	// 'コース TOEFL',
	$target_TOEIC		= engp_get_value( $get_meta->target_TOEIC );	// 'コース TOEIC',
	$target_advance		= engp_get_value( $get_meta->target_advance );	// 'コース 進学',
	$target_business	= engp_get_value( $get_meta->target_business );	// 'コース ビジネス',
	$target_child		= engp_get_value( $get_meta->target_child );	// 'コース 子供',
	$target_adult		= engp_get_value( $get_meta->target_adult );	// 'コース 大人',
	$target_ILETS		= engp_get_value( $get_meta->target_ILETS );	// 'コース IELTS',
	$target_so			= engp_get_value( $get_meta->target_so );		// 'コース スペシャルオファー',	
	$target_other		= engp_get_value( $get_meta->target_other );	// 'コース その他',
	$school_size		= engp_get_value( $get_meta->school_size );		// 'スクールサイズ',
	$levels				= engp_get_value( $get_meta->levels );			// 'レベル数',
	$avg_classsize		= engp_get_value( $get_meta->avg_classsize );	// '平均クラスサイズ',
	$enrollment			= engp_get_value( $get_meta->enrollment );		// '入学時期',
	$options			= engp_get_value( $get_meta->options );			// 'オプション',
	$local_staff		= engp_get_value( $get_meta->local_staff );		// '現地スタッフサポート可否',
	$facilities			= engp_get_value( $get_meta->facilities );		// '学校設備',
	$other				= engp_get_value( $get_meta->other );			// 'その他',
	$youtube_url		= engp_get_value( $get_meta->youtube_url );		// 'YouTube URL',
	$recommend			= engp_get_value( $get_meta->recommend );		// 'お薦めフラグ',
	// オプションの分割
	$options_Homestay		= strpos( $options, 'ホームスティ' ) !== false?true:false;			// 'オプション ホームスティ',
	$options_Dormitory		= strpos( $options, '寮' ) !== false?true:false;					// 'オプション 寮',
	$options_AirportPickUp	= strpos( $options, '空港出迎え' ) !== false?true:false;			// 'オプション 空港出迎え',
	$options_PrivateClass	= strpos( $options, 'プライベートレッスン' ) !== false?true:false;	// 'オプション プライベートレッスン',
	$options_Other			= strpos( $options, 'その他' ) !== false?true:false;				// 'オプション その他',
	// 学校設備の分割
	$facilities_Lounge			= strpos( $facilities, 'ラウンジ' ) !== false?true:false;						// '学校設備 ラウンジ',
	$facilities_ComputerRoom	= strpos( $facilities, 'コンピュータルーム' ) !== false?true:false;				// '学校設備 コンピュータルーム',
	$facilities_WIFI			= strpos( $facilities, 'ワイヤレスインターネット利用' ) !== false?true:false;	// '学校設備 ワイヤレスインターネット利用',
	$facilities_CounselingRoom	= strpos( $facilities, 'カウンセリングルーム' ) !== false?true:false;			// '学校設備 カウンセリングルーム',
	$facilities_Gym				= strpos( $facilities, 'ジム' ) !== false?true:false;							// '学校設備 ジム',
	$facilities_Library			= strpos( $facilities, '図書館' ) !== false?true:false;							// '学校設備 図書館',
	$facilities_Other			= strpos( $facilities, 'その他' ) !== false?true:false;							// '学校設備 その他',

	// 費用（ex_school_costテーブル）
	// 共通項目
	$viewtype_yen					= engp_get_value( $get_meta->viewtype_yen );				// '円表示フラグ',
	$admission_fee					= engp_get_value( $get_meta->admission_fee );				// '入学金',
	$accommodation_placement_fee	= engp_get_value( $get_meta->accommodation_placement_fee );	// '滞在先手配料',
	$homestay						= engp_get_value( $get_meta->homestay );					// 'ホームステイ',	
	$dormitory_1					= engp_get_value( $get_meta->dormitory_1 );					// '学生寮(1人部屋)',	
	$dormitory_2					= engp_get_value( $get_meta->dormitory_2 );					// '学生寮(2人部屋)',	
	$dormitory_3					= engp_get_value( $get_meta->dormitory_3 );					// '学生寮(3人部屋)',	
	$dormitory_4					= engp_get_value( $get_meta->dormitory_4 );					// '学生寮(4人部屋)',	
	$i20_issuance_postage			= engp_get_value( $get_meta->i20_issuance_postage );		// 'I20発行・送料',
	$airport_pickup_cost			= engp_get_value( $get_meta->airport_pickup_cost );			// '空港出迎え費',
	$bank_charge					= engp_get_value( $get_meta->bank_charge );					// 'バンクチャージ',
	$course_name_pt					= engp_get_value( $get_meta->course_name_pt );				// 'コース1:コース名',	
	$course_name_ft					= engp_get_value( $get_meta->course_name_ft );				// 'コース2:コース名',	
	$course_name_cs3				= engp_get_value( $get_meta->course_name_cs3 );				// 'コース3:コース名',	
	$course_name_cs4				= engp_get_value( $get_meta->course_name_cs4 );				// 'コース4:コース名',
	$course_name_cs5				= engp_get_value( $get_meta->course_name_cs5 );				// 'コース5:コース名',
	$course_name_cs6				= engp_get_value( $get_meta->course_name_cs6 );				// 'コース6:コース名',
	$course_name_cs7				= engp_get_value( $get_meta->course_name_cs7 );				// 'コース7:コース名',
	$course_detail_pt				= engp_get_value( $get_meta->course_detail_pt );			// 'コース1:コース詳細',
	$course_detail_ft				= engp_get_value( $get_meta->course_detail_ft );			// 'コース2:コース詳細',
	$course_detail_cs3				= engp_get_value( $get_meta->course_detail_cs3 );			// 'コース3:コース詳細',
	$course_detail_cs4				= engp_get_value( $get_meta->course_detail_cs4 );			// 'コース4:コース詳細',
	$course_detail_cs5				= engp_get_value( $get_meta->course_detail_cs5 );			// 'コース5:コース詳細',
	$course_detail_cs6				= engp_get_value( $get_meta->course_detail_cs6 );			// 'コース6:コース詳細',
	$course_detail_cs7				= engp_get_value( $get_meta->course_detail_cs7 );			// 'コース7:コース詳細',
	
	
	// 2週間
//	$tuition_2w_pt			= engp_get_value( $get_meta->tuition_2w_pt );						// '授業料 パートタイム（2週間）',
//	$tuition_2w_ft			= engp_get_value( $get_meta->tuition_2w_ft );						// '授業料 フルタイム（2週間）',
// 	$homestay_cost_2w		= engp_get_value( $get_meta->homestay_cost_2w );					// 'ホームステイ費（2週間）',
//	$textbooks_2w			= engp_get_value( $get_meta->textbooks_2w );						// 'テキスト代（2週間）',
	// 4週間
	$tuition_4w_pt			= engp_get_value( $get_meta->tuition_4w_pt );						// '授業料 パートタイム（4週間）',
	$tuition_4w_ft			= engp_get_value( $get_meta->tuition_4w_ft );						// '授業料 フルタイム（4週間）',
	$tuition_4w_cs3			= engp_get_value( $get_meta->tuition_4w_cs3 );						// '授業料 コース3（4週間）',
	$tuition_4w_cs4			= engp_get_value( $get_meta->tuition_4w_cs4 );						// '授業料 コース4（4週間）',
	$tuition_4w_cs5			= engp_get_value( $get_meta->tuition_4w_cs5 );						// '授業料 コース5（4週間）',
	$tuition_4w_cs6			= engp_get_value( $get_meta->tuition_4w_cs6 );						// '授業料 コース6（4週間）',
	$tuition_4w_cs7			= engp_get_value( $get_meta->tuition_4w_cs7 );						// '授業料 コース7（4週間）',			
//	$homestay_cost_4w		= engp_get_value( $get_meta->homestay_cost_4w );					// 'ホームステイ費（4週間）',
	$textbooks_4w			= engp_get_value( $get_meta->textbooks_4w );						// 'テキスト代（4週間）',
	// 8週間
	$tuition_8w_pt			= engp_get_value( $get_meta->tuition_8w_pt );						// '授業料 パートタイム（8週間）',
	$tuition_8w_ft			= engp_get_value( $get_meta->tuition_8w_ft );						// '授業料 フルタイム（8週間）',
	$tuition_8w_cs3			= engp_get_value( $get_meta->tuition_8w_cs3 );						// '授業料 コース3（8週間）',
	$tuition_8w_cs4			= engp_get_value( $get_meta->tuition_8w_cs4 );						// '授業料 コース4（8週間）',
	$tuition_8w_cs5			= engp_get_value( $get_meta->tuition_8w_cs5 );						// '授業料 コース5（8週間）',
	$tuition_8w_cs6			= engp_get_value( $get_meta->tuition_8w_cs6 );						// '授業料 コース6（8週間）',
	$tuition_8w_cs7			= engp_get_value( $get_meta->tuition_8w_cs7 );						// '授業料 コース7（8週間）',	
	$homestay_cost_8w		= engp_get_value( $get_meta->homestay_cost_8w );					// 'ホームステイ費（8週間）',
	$textbooks_8w			= engp_get_value( $get_meta->textbooks_8w );						// 'テキスト代（8週間）',
	// 12週間
	$tuition_12w_pt			= engp_get_value( $get_meta->tuition_12w_pt );						// '授業料 パートタイム（12週間）',
	$tuition_12w_ft			= engp_get_value( $get_meta->tuition_12w_ft );						// '授業料 フルタイム（12週間）',
	$tuition_12w_cs3		= engp_get_value( $get_meta->tuition_12w_cs3 );						// '授業料 コース3（12週間）',
	$tuition_12w_cs4		= engp_get_value( $get_meta->tuition_12w_cs4 );						// '授業料 コース4（12週間）',
	$tuition_12w_cs5		= engp_get_value( $get_meta->tuition_12w_cs5 );						// '授業料 コース5（12週間）',
	$tuition_12w_cs6		= engp_get_value( $get_meta->tuition_12w_cs6 );						// '授業料 コース6（12週間）',
	$tuition_12w_cs7		= engp_get_value( $get_meta->tuition_12w_cs7 );						// '授業料 コース7（12週間）',	
//	$homestay_cost_12w		= engp_get_value( $get_meta->homestay_cost_12w );					// 'ホームステイ費（12週間）',
	$textbooks_12w			= engp_get_value( $get_meta->textbooks_12w );						// 'テキスト代（12週間）',
	// 16週間
	$tuition_16w_pt			= engp_get_value( $get_meta->tuition_16w_pt );						// '授業料 パートタイム（16週間）',
	$tuition_16w_ft			= engp_get_value( $get_meta->tuition_16w_ft );						// '授業料 フルタイム（16週間）',
	$tuition_16w_cs3		= engp_get_value( $get_meta->tuition_16w_cs3 );						// '授業料 コース3（16週間）',
	$tuition_16w_cs4		= engp_get_value( $get_meta->tuition_16w_cs4 );						// '授業料 コース4（16週間）',
	$tuition_16w_cs5		= engp_get_value( $get_meta->tuition_16w_cs5 );						// '授業料 コース5（16週間）',
	$tuition_16w_cs6		= engp_get_value( $get_meta->tuition_16w_cs6 );						// '授業料 コース6（16週間）',
	$tuition_16w_cs7		= engp_get_value( $get_meta->tuition_16w_cs7 );						// '授業料 コース7（16週間）',
//	$homestay_cost_16w		= engp_get_value( $get_meta->homestay_cost_16w );					// 'ホームステイ費（16週間）',
	$textbooks_16w			= engp_get_value( $get_meta->textbooks_16w );						// 'テキスト代（16週間）',
	// 24週間
	$tuition_24w_pt			= engp_get_value( $get_meta->tuition_24w_pt );						// '授業料 パートタイム（24週間）',
	$tuition_24w_ft			= engp_get_value( $get_meta->tuition_24w_ft );						// '授業料 フルタイム（24週間）',
	$tuition_24w_cs3		= engp_get_value( $get_meta->tuition_24w_cs3 );						// '授業料 コース3（24週間）',
	$tuition_24w_cs4		= engp_get_value( $get_meta->tuition_24w_cs4 );						// '授業料 コース4（24週間）',
	$tuition_24w_cs5		= engp_get_value( $get_meta->tuition_24w_cs5 );						// '授業料 コース5（24週間）',
	$tuition_24w_cs6		= engp_get_value( $get_meta->tuition_24w_cs6 );						// '授業料 コース6（24週間）',
	$tuition_24w_cs7		= engp_get_value( $get_meta->tuition_24w_cs7 );						// '授業料 コース7（24週間）',	
//	$homestay_cost_24w		= engp_get_value( $get_meta->homestay_cost_24w );					// 'ホームステイ費（24週間）',
	$textbooks_24w			= engp_get_value( $get_meta->textbooks_24w );						// 'テキスト代（24週間）',
	// 36週間
	$tuition_36w_pt			= engp_get_value( $get_meta->tuition_36w_pt );						// '授業料 パートタイム（36週間）',
	$tuition_36w_ft			= engp_get_value( $get_meta->tuition_36w_ft );						// '授業料 フルタイム（36週間）',
	$tuition_36w_cs3		= engp_get_value( $get_meta->tuition_36w_cs3 );						// '授業料 コース3（36週間）',
	$tuition_36w_cs4		= engp_get_value( $get_meta->tuition_36w_cs4 );						// '授業料 コース4（36週間）',
	$tuition_36w_cs5		= engp_get_value( $get_meta->tuition_36w_cs5 );						// '授業料 コース5（36週間）',
	$tuition_36w_cs6		= engp_get_value( $get_meta->tuition_36w_cs6 );						// '授業料 コース6（36週間）',
	$tuition_36w_cs7		= engp_get_value( $get_meta->tuition_36w_cs7 );						// '授業料 コース7（36週間）',	
//	$homestay_cost_36w		= engp_get_value( $get_meta->homestay_cost_36w );					// 'ホームステイ費（36週間）',
	$textbooks_36w			= engp_get_value( $get_meta->textbooks_36w );						// 'テキスト代（36週間）',
	// 48週間
	$tuition_48w_pt			= engp_get_value( $get_meta->tuition_48w_pt );						// '授業料 パートタイム（48週間）',
	$tuition_48w_ft			= engp_get_value( $get_meta->tuition_48w_ft );						// '授業料 フルタイム（48週間）',
	$tuition_48w_cs3		= engp_get_value( $get_meta->tuition_48w_cs3 );						// '授業料 コース3（48週間）',
	$tuition_48w_cs4		= engp_get_value( $get_meta->tuition_48w_cs4 );						// '授業料 コース4（48週間）',
	$tuition_48w_cs5		= engp_get_value( $get_meta->tuition_48w_cs5 );						// '授業料 コース5（48週間）',
	$tuition_48w_cs6		= engp_get_value( $get_meta->tuition_48w_cs6 );						// '授業料 コース6（48週間）',
	$tuition_48w_cs7		= engp_get_value( $get_meta->tuition_48w_cs7 );						// '授業料 コース7（48週間）',	
//	$homestay_cost_48w		= engp_get_value( $get_meta->homestay_cost_48w );					// 'ホームステイ費（48週間）',
	$textbooks_48w			= engp_get_value( $get_meta->textbooks_48w );						// 'テキスト代（48週間）',
	// スペシャルオファー1
// 	$tuition_so1_pt			= engp_get_value( $get_meta->tuition_so1_pt );						// '授業料 パートタイム（スペシャルオファー1）',
// 	$tuition_so1_ft			= engp_get_value( $get_meta->tuition_so1_ft );						// '授業料 フルタイム（スペシャルオファー1）',
// 	$homestay_cost_so1		= engp_get_value( $get_meta->homestay_cost_so1 );					// 'ホームステイ費（スペシャルオファー1）',
// 	$textbooks_so1			= engp_get_value( $get_meta->textbooks_so1 );						// 'テキスト代（スペシャルオファー1）',
	// スペシャルオファー2
// 	$tuition_so2_pt			= engp_get_value( $get_meta->tuition_so2_pt );						// '授業料 パートタイム（スペシャルオファー2）',
// 	$tuition_so2_ft			= engp_get_value( $get_meta->tuition_so2_ft );						// '授業料 フルタイム（スペシャルオファー2）',
// 	$homestay_cost_so2		= engp_get_value( $get_meta->homestay_cost_so2 );					// 'ホームステイ費（スペシャルオファー2）',
// 	$textbooks_so2			= engp_get_value( $get_meta->textbooks_so2 );						// 'テキスト代（スペシャルオファー2）',
// 	// スペシャルオファー3
// 	$tuition_so3_pt			= engp_get_value( $get_meta->tuition_so3_pt );						// '授業料 パートタイム（スペシャルオファー3）',
// 	$tuition_so3_ft			= engp_get_value( $get_meta->tuition_so3_ft );						// '授業料 フルタイム（スペシャルオファー3）',
// 	$homestay_cost_so3		= engp_get_value( $get_meta->homestay_cost_so3 );					// 'ホームステイ費（スペシャルオファー3）',
// 	$textbooks_so3			= engp_get_value( $get_meta->textbooks_so3 );						// 'テキスト代（スペシャルオファー3）',
// 	// スペシャルオファー4
// 	$tuition_so4_pt			= engp_get_value( $get_meta->tuition_so4_pt );						// '授業料 パートタイム（スペシャルオファー4）',
// 	$tuition_so4_ft			= engp_get_value( $get_meta->tuition_so4_ft );						// '授業料 フルタイム（スペシャルオファー4）',
// 	$homestay_cost_so4		= engp_get_value( $get_meta->homestay_cost_so4 );					// 'ホームステイ費（スペシャルオファー4）',
// 	$textbooks_so4			= engp_get_value( $get_meta->textbooks_so4 );						// 'テキスト代（スペシャルオファー4）',

	/***********************/
	//	ここから投稿画面のHTML
	/***********************/
?>
<script type="text/javascript">
	document.getElementById("post-body-content").style.display = 'none';
</script>
<div id='engp_ex_meta'>
	<table style="border-collapse: collapse;">
		<tr>
			<th>学校名</th>
			<td style='width: 70%;'>
				<input type='text' name="school_name" id="school_name" value="<?php echo $school_name; ?>" />
			</td>
		</tr>
		<tr>
			<th>学校名（和名）</th>
			<td style='width: 70%;'>
				<input type='text' name="school_jp_name" id="school_jp_name" value="<?php echo $school_jp_name; ?>" />
			</td>
		</tr>
		<tr>
			<th>住所</th>
			<td><input type='text' name="address" id="address" value="<?php echo $address; ?>" /></td>
		</tr>
		<tr>
			<th>電話番号</th>
			<td><input type='text' name="phone" id="phone" value="<?php echo $phone; ?>" /></td>
		</tr>
		<tr>
			<th>言語</th>
			<td>
				<select name="lang" id="lang">
<?php
	foreach ($engp_master['lang'] as $key => &$val) {
		if ($key==$lang) {
			echo "<option value='".$key."' selected>".$val."</option>".PHP_EOL;
		}
		else{
			echo "<option value='".$key."'>".$val."</option>".PHP_EOL;
		}
	}
?>
				</select>
			</td>
		</tr>
		<tr>
			<th>国</th>
			<td>
				<select name="country" id="country">
<?php
	foreach ($engp_master['country'] as $key => &$val) {
		if ($key==$country) {
			echo "<option value='".$key."' selected>".$val."</option>".PHP_EOL;
		}
		else{
			echo "<option value='".$key."'>".$val."</option>".PHP_EOL;
		}
	}
?>
				</select>
			</td>
		</tr>
		<tr>
			<th>都市</th>
			<td><input type='text' name="city" id="city" value="<?php echo $city; ?>" /></td>
		</tr>
		<tr>
			<th>地区</th>
			<td>
				<select name="division" id="division">
<?php
	foreach ($engp_master['division'] as $key => &$val) {
		if ($key==$division) {
			echo "<option value='".$key."' selected>".$val."</option>".PHP_EOL;
		}
		else{
			echo "<option value='".$key."'>".$val."</option>".PHP_EOL;
		}
	}
?>
				</select>
			</td>
					</tr>
		<tr>
			<th>学校概要</th>
			<td><textarea name="outline" id="outline" rows="3"><?php echo $outline; ?></textarea></td>
		</tr>
		<tr>
			<th>EPスコア</th>
			<td>
				<select name="staff_evaluation">
					<?php if(!$staff_evaluation){$staff_evaluation = 6;}?>
					<?php for($i=1;$i<11;$i++):?>
						<option value="<?php echo $i;?>" <?php if($staff_evaluation == strval($i)){echo "selected";}?>><?php echo $i/2;?></option>
					<?php endfor;?>
				</select>
			</td>
		</tr>
		<tr>
			<th>お薦めフラグ</th>
			<td>
				<input type="checkbox" name="recommend" id="recommend" value="1" <?php echo ($recommend=="1"?"checked='checked'":"") ?>>
				<label for='recommend'>お薦めの場合にチェック</label>
			</td>
		</tr>
		</tr>
<!-- 		<tr>
			<th>検索項目</th>
			<td>
				<input type="checkbox" name="purpose1" id="purpose1" value="1" <?php // echo $purpose1?"checked='checked'":""; ?>>
				<label for='purpose1'><?php // echo $engp_master['purpose'][1] ?></label>
			</td>
		</tr> 
		<tr>
			<th></th>
			<td>
				<input type="checkbox" name="purpose2" id="purpose2" value="1" <?php // echo $purpose2?"checked='checked'":""; ?>>
				<label for='purpose2'><?php // echo $engp_master['purpose'][2] ?></label>
			</td>
		</tr>
		<tr>
			<th></th>
			<td>
				<input type="checkbox" name="purpose3" id="purpose3" value="1" <?php // echo $purpose3?"checked='checked'":""; ?>>
				<label for='purpose3'><?php // echo $engp_master['purpose'][3] ?></label>
			</td>
		</tr>
		<tr>
			<th></th>
			<td>
				<input type="checkbox" name="purpose4" id="purpose4" value="1" <?php // echo $purpose4?"checked='checked'":""; ?>>
				<label for='purpose4'><?php // echo $engp_master['purpose'][4] ?></label>
			</td>
		</tr>
		<tr>
			<th></th>
			<td>
				<input type="checkbox" name="purpose5" id="purpose5" value="1" <?php echo $purpose5?"checked='checked'":""; ?>>
				<label for='purpose5'><?php // echo $engp_master['purpose'][5] ?></label>
			</td>
		</tr>  -->
		<tr>
			<th>授業品質</th>
			<td><input type='text' name="quality" id=quality value="<?php echo $quality; ?>" /></td>
		</tr>
		<tr>
			<th>所在</th>
			<td>
				<select name="location_type" id="location_type">
<?php
	foreach ($engp_master['location_type'] as $key => &$val) {
		if ($key==$location_type) {
			echo "<option value='".$key."' selected>".$val."</option>".PHP_EOL;
		}
		else{
			echo "<option value='".$key."'>".$val."</option>".PHP_EOL;
		}
	}
?>
				</select>
			</td>
		</tr>
		<tr>
			<th>ロケーション</th>
			<td>
				<select name="location" id="location">
<?php
	foreach ($engp_master['location'] as $key => &$val) {
		if ($key==$location) {
			echo "<option value='".$key."' selected>".$val."</option>".PHP_EOL;
		}
		else{
			echo "<option value='".$key."'>".$val."</option>".PHP_EOL;
		}
	}
?>
				</select>
			</td>
		</tr>
		<tr>
			<th>駐車場</th>
			<td>
				<select name="parking" id="parking">
<?php
	foreach ($engp_master['parking'] as $key => &$val) {
		if ($key==$parking) {
			echo "<option value='".$key."' selected>".$val."</option>".PHP_EOL;
		}
		else{
			echo "<option value='".$key."'>".$val."</option>".PHP_EOL;
		}
	}
?>
				</select>
			</td>
		</tr>
		<tr>
			<th>通学手段</th>
			<td>
				<select name="how_to_go" id="how_to_go">
<?php
	foreach ($engp_master['how_to_go'] as $key => &$val) {
		if ($key==$how_to_go) {
			echo "<option value='".$key."' selected>".$val."</option>".PHP_EOL;
		}
		else{
			echo "<option value='".$key."'>".$val."</option>".PHP_EOL;
		}
	}
?>
				</select>
			</td>
		</tr>
		<tr>
			<th>治安</th>
			<td>
				<select name="security" id="security">
<?php
	foreach ($engp_master['security'] as $key => &$val) {
		if ($key==$security) {
			echo "<option value='".$key."' selected>".$val."</option>".PHP_EOL;
		}
		else{
			echo "<option value='".$key."'>".$val."</option>".PHP_EOL;
		}
	}
?>
				</select>
			</td>
		</tr>
		<tr>
			<th>国籍バランス</th>
			<td>
				<select name="nationality" id="nationality">
<?php
	foreach ($engp_master['nationality'] as $key => &$val) {
		if ($key==$nationality) {
			echo "<option value='".$key."' selected>".$val."</option>".PHP_EOL;
		}
		else{
			echo "<option value='".$key."'>".$val."</option>".PHP_EOL;
		}
	}
?>
				</select>
			</td>
		</tr>
		<!-- コース名 -->
		<tr>
			<th rowspan ="11">コースの有無</th>
			<td></td>
		</tr>
		
		<tr>
			<td><input type='checkbox' name="target_ESL" id="target_ESL" value="1" <?php if($target_ESL){ echo "checked";}; ?>/>ESL</td>
		</tr>
		<tr>
			<td><input type='checkbox' name="target_TOEFL" id="target_TOEFL" value="1" <?php if($target_TOEFL){echo "checked";};?>/>TOEFL</td>
		</tr>
		<tr>
			<td><input type='checkbox' name="target_TOEIC" id="target_TOEIC" value="1" <?php if($target_TOEIC){echo "checked";};?>/>TOEIC</td>
		</tr>
		<tr>
			<td><input type='checkbox' name="target_advance" id="target_advance" value="1" <?php if($target_advance){echo "checked";};?>/>進学</td>
		</tr>
		<tr>
			<td><input type='checkbox' name="target_business" id="target_business" value="1" <?php if($target_business){echo "checked";};?>/>ビジネス</td>
		</tr>
		<tr>
			<td><input type='checkbox' name="target_child" id="target_child" value="1" <?php if($target_child){echo "checked";};?>/>子供</td>
		</tr>
		<tr>
			<td><input type='checkbox' name="target_adult" id="target_adult" value="1" <?php if($target_adult){echo "checked";};?>/>大人</td>
		</tr>
		<tr>
			<td><input type='checkbox' name="target_ILETS" id="target_ILETS" value="1" <?php if($target_ILETS){echo "checked";};?>/>IELTS</td>
		</tr>
		<tr>
			<td><input type='checkbox' name="target_so" id="target_so" value="1" <?php if($target_so){echo "checked";};?>/>スペシャルオファー</td>
		</tr>		
		<tr>
	 			<td><input type='checkbox' name="target_other" id="target_other" value="1"  <?php  if($target_other){echo "checked";};?>/>その他</td> 
		</tr>
		<tr>
			<th>スクールサイズ</th>
			<td><input type='text' name="school_size" id="school_size" value="<?php echo $school_size; ?>" /></td>
		</tr>
		<tr>
			<th>レベル数</th>
			<td><input type='text' name="levels" id="levels" value="<?php echo $levels; ?>" /></td>
		</tr>
		<tr>
			<th>平均クラスサイズ</th>
			<td><input type='text' name="avg_classsize" id="avg_classsize" value="<?php echo $avg_classsize; ?>" /></td>
		</tr>
		<tr>
			<th>入学時期</th>
			<td><input type='text' name="enrollment" id="enrollment" value="<?php echo $enrollment; ?>" /></td>
		</tr>
		<tr>
			<th>オプション</th>
			<td>
				<input type="checkbox" name="options_Homestay" id="options_Homestay" value="1" <?php echo $options_Homestay?"checked='checked'":""; ?>>
				<label for='options_Homestay'>ホームスティ可</label>
			</td>
		</tr>
		<tr>
			<th></th>
			<td>
				<input type="checkbox" name="options_Dormitory" id="options_Dormitory" value="1" <?php echo $options_Dormitory?"checked='checked'":""; ?>>
				<label for='options_Dormitory'>寮有り</label>
			</td>
		</tr>
		<tr>
			<th></th>
			<td>
				<input type="checkbox" name="options_AirportPickUp" id="options_AirportPickUp" value="1" <?php echo $options_AirportPickUp?"checked='checked'":""; ?>>
				<label for='options_AirportPickUp'>空港出迎え可</label>
			</td>
		</tr>
		<tr>
			<th></th>
			<td>
				<input type="checkbox" name="options_PrivateClass" id="options_PrivateClass" value="1" <?php echo $options_PrivateClass?"checked='checked'":""; ?>>
				<label for='options_PrivateClass'>プライベートレッスン有り</label>
			</td>
		</tr>
		<tr>
			<th></th>
			<td>
				<input type="checkbox" name="options_Other" id="options_Other" value="1" <?php echo $options_Other?"checked='checked'":""; ?>>
				<label for='options_Other'>その他</label>
			</td>
		</tr>
		<tr>
			<th>学校設備</th>
			<td>
				<input type="checkbox" name="facilities_Lounge" id="facilities_Lounge" value="1" <?php echo $facilities_Lounge?"checked='checked'":""; ?>>
				<label for='facilities_Lounge'>ラウンジ利用可</label>
			</td>
		</tr>
		<tr>
			<th></th>
			<td>
				<input type="checkbox" name="facilities_ComputerRoom" id="facilities_ComputerRoom" value="1" <?php echo $facilities_ComputerRoom?"checked='checked'":""; ?>>
				<label for='facilities_ComputerRoom'>コンピュータルーム利用可</label>
			</td>
		</tr>
		<tr>
			<th></th>
			<td>
				<input type="checkbox" name="facilities_WIFI" id="facilities_WIFI" value="1" <?php echo $facilities_WIFI?"checked='checked'":""; ?>>
				<label for='facilities_WIFI'>ワイヤレスインターネット利用可</label>
			</td>
		</tr>
		<tr>
			<th></th>
			<td>
				<input type="checkbox" name="facilities_CounselingRoom" id="facilities_CounselingRoom" value="1" <?php echo $facilities_CounselingRoom?"checked='checked'":""; ?>>
				<label for='facilities_CounselingRoom'>カウンセリングルーム利用可</label>
			</td>
		</tr>
		<tr>
			<th></th>
			<td>
				<input type="checkbox" name="facilities_Gym" id="facilities_Gym" value="1" <?php echo $facilities_Gym?"checked='checked'":""; ?>>
				<label for='facilities_Gym'>ジム利用可</label>
			</td>
		</tr>
		<tr>
			<th></th>
			<td>
				<input type="checkbox" name="facilities_Library" id="facilities_Library" value="1" <?php echo $facilities_Library?"checked='checked'":""; ?>>
				<label for='facilities_Library'>図書館利用可</label>
			</td>
		</tr>
		<tr>
			<th></th>
			<td>
				<input type="checkbox" name="facilities_Other" id="facilities_Other" value="1" <?php echo $facilities_Other?"checked='checked'":""; ?>>
				<label for='facilities_Other'>その他利用可</label>
			</td>
		</tr>
		<tr>
			<th>その他</th>
			<td>
				<textarea name="other" id="other" rows="3"><?php echo $other; ?></textarea>
			</td>
		</tr>
		<tr>
			<th>YouTube URL</th>
			<td><input type='text' name="youtube_url" id="youtube_url" value="<?php echo $youtube_url; ?>" /></td>
		</tr>
		<tr>
			<th>現地スタッフサポート可否</th>
			<td>
				<input type="checkbox" name="local_staff" id="local_staff" value="1" <?php echo ($local_staff=="1"?"checked='checked'":"") ?>>
				<label for='local_staff'>サポート可の場合にチェック</label>
			</td>
		</tr>
		<tr id="actr">
			<th class="cost " title="クリックで切替">料金</th>
			<td></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>円表示</th>
			<td>
				<input type="checkbox" name="viewtype_yen" id="viewtype_yen" value="1" <?php echo ($viewtype_yen == "1" ? "checked='checked'" : "") ?>>
				<label for='viewtype_yen'>日本円で表示する場合にチェック</label>
			</td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>入学金</th>
			<td><input type='text' class='mini' name="admission_fee" id="admission_fee" value="<?php echo $admission_fee; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>滞在先手配料</th>
			<td><input type='text' class='mini' name="accommodation_placement_fee" id="accommodation_placement_fee" value="<?php echo $accommodation_placement_fee; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>ホームステイ(1人部屋)/4週間</th>
			<td><input type='text' class='mini' name="homestay" id="homestay" value="<?php echo $homestay; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>学生寮(1人部屋)/4週間</th>
			<td><input type='text' class='mini' name="dormitory_1" id="dormitory_1" value="<?php echo $dormitory_1; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>学生寮(2人部屋)/4週間</th>
			<td><input type='text' class='mini' name="dormitory_2" id="dormitory_2" value="<?php echo $dormitory_2; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>学生寮(3人部屋)/4週間</th>
			<td><input type='text' class='mini' name="dormitory_3" id="dormitory_3" value="<?php echo $dormitory_3; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>学生寮(4人部屋)/4週間</th>
			<td><input type='text' class='mini' name="dormitory_4" id="dormitory_4" value="<?php echo $dormitory_4; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		
		<tr style="display: none;"class="sltr">
			<th>I-20発行費</th>
			<td><input type='text' class='mini' name="i20_issuance_postage" id="i20_issuance_postage" value="<?php echo $i20_issuance_postage; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>空港出迎</th>
			<td><input type='text' class='mini' name="airport_pickup_cost" id="airport_pickup_cost" value="<?php echo $airport_pickup_cost; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>バンクチャージ</th>
			<td><input type='text' class='mini' name="bank_charge" id="bank_charge" value="<?php echo $bank_charge; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<!-- コース名 -->
		<tr style="display: none; border-top: 1px solid gray;" class="sltr">
			<th>コース名</th>
			<td></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース1</th>
			<td><input type='text' name="course_name_pt" id="course_name_pt" value="<?php echo $course_name_pt; ?>" maxlength="50"/></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース2</th>
			<td><input type='text' name="course_name_ft" id="course_name_ft" value="<?php echo $course_name_ft; ?>" maxlength="50"/></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース3</th>
			<td><input type='text' name="course_name_cs3" id="course_name_cs3" value="<?php echo $course_name_cs3; ?>" maxlength="50"/></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース4</th>
			<td><input type='text' name="course_name_cs4" id="course_name_cs4" value="<?php echo $course_name_cs4; ?>" maxlength="50"/></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース5</th>
			<td><input type='text' name="course_name_cs5" id="course_name_cs5" value="<?php echo $course_name_cs5; ?>" maxlength="50"/></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース6</th>
			<td><input type='text' name="course_name_cs6" id="course_name_cs6" value="<?php echo $course_name_cs6; ?>" maxlength="50"/></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース7</th>
			<td><input type='text' name="course_name_cs7" id="course_name_cs7" value="<?php echo $course_name_cs7; ?>" maxlength="50"/></td>
		</tr>
		<!-- コース名 -->		

		<!-- コース詳細 -->		
		<tr style="display: none; border-top: 1px solid gray;" class="sltr">
			<th>レッスン時期、入学条件、コースの特徴など</th>
			<td></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース1</th>
			<td><input type='text' name="course_detail_pt" id="course_detail_pt" value="<?php echo $course_detail_pt; ?>" maxlength="50"/></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース2</th>
			<td><input type='text' name="course_detail_ft" id="course_detail_ft" value="<?php echo $course_detail_ft; ?>" maxlength="50"/></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース3</th>
			<td><input type='text' name="course_detail_cs3" id="course_detail_cs3" value="<?php echo $course_detail_cs3; ?>" maxlength="50"/></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース4</th>
			<td><input type='text' name="course_detail_cs4" id="course_detail_cs4" value="<?php echo $course_detail_cs4; ?>" maxlength="50"/></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース5</th>
			<td><input type='text' name="course_detail_cs5" id="course_detail_cs5" value="<?php echo $course_detail_cs5; ?>" maxlength="50"/></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース6</th>
			<td><input type='text' name="course_detail_cs6" id="course_detail_cs6" value="<?php echo $course_detail_cs6; ?>" maxlength="50"/></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース7</th>
			<td><input type='text' name="course_detail_cs7" id="course_detail_cs7" value="<?php echo $course_detail_cs7; ?>" maxlength="50"/></td>
		</tr>
		<!-- コース詳細 -->				
		
		<!-- 2週間 -->				
		<tr style="display: none; border-top: 1px solid gray;" class="sltr">
<!-- 			<th>2週間</th> -->
<!-- 			<td></td> -->
<!-- 		</tr> -->
<!-- 	<tr style="display: none;" class="sltr"> -->
<!-- 			<th>コース1</th> -->
<!-- 			<td><input type='text' class='mini' name="tuition_2w_pt" id="tuition_2w_pt" value="<?php // echo $tuition_2w_pt; ?>" maxlength="8" pattern="^[0-9]+$" /></td> -->
<!-- 		</tr> -->
<!-- 		<tr style="display: none;" class="sltr"> -->
<!-- 			<th>コース2</th> -->
<!-- 			<td><input type='text' class='mini' name="tuition_2w_ft" id="tuition_2w_ft" value="<?php // echo $tuition_2w_ft; ?>" maxlength="8" pattern="^[0-9]+$" /></td> -->
<!-- 		</tr> -->
		
		
<!-- 		<tr style="display: none;" class="sltr">
			<th>滞在費</th>
			<td><input type='text' class='mini' name="homestay_cost_2w" id="homestay_cost_2w" value="<?php // echo $homestay_cost_2w; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>  -->
<!--		<tr style="display: none;" class="sltr"> -->
<!-- 			<th>テキスト代</th> -->
<!-- 			<td><input type='text' class='mini' name="textbooks_2w" id="textbooks_2w" value="<?php // echo $textbooks_2w; ?>" maxlength="8" pattern="^[0-9]+$" /></td> -->
<!-- 		</tr> -->
		<!-- 2週間 -->
		
		<!-- 4週間 -->
		<tr style="display: none; border-top: 1px solid gray;" class="sltr">
			<th>4週間</th>
			<td></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース1</th>
			<td><input type='text' class='mini' name="tuition_4w_pt" id="tuition_4w_pt" value="<?php echo $tuition_4w_pt; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース2</th>
			<td><input type='text' class='mini' name="tuition_4w_ft" id="tuition_4w_ft" value="<?php echo $tuition_4w_ft; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース3</th>
			<td><input type='text' class='mini' name="tuition_4w_cs3" id="tuition_4w_cs3" value="<?php echo $tuition_4w_cs3; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース4</th>
			<td><input type='text' class='mini' name="tuition_4w_cs4" id="tuition_4w_cs4" value="<?php echo $tuition_4w_cs4; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース5</th>
			<td><input type='text' class='mini' name="tuition_4w_cs5" id="tuition_4w_cs5" value="<?php echo $tuition_4w_cs5; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース6</th>
			<td><input type='text' class='mini' name="tuition_4w_cs6" id="tuition_4w_cs6" value="<?php echo $tuition_4w_cs6; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース7</th>
			<td><input type='text' class='mini' name="tuition_4w_cs7" id="tuition_4w_cs7" value="<?php echo $tuition_4w_cs7; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		
<!-- 		<tr style="display: none;" class="sltr"> -->
<!-- 		<th>滞在費</th>
			<td><input type='text' class='mini' name="homestay_cost_4w" id="homestay_cost_4w" value="<?php // echo $homestay_cost_4w; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
 -->
		<tr style="display: none;" class="sltr">
			<th>テキスト代</th>
			<td><input type='text' class='mini' name="textbooks_4w" id="textbooks_4w" value="<?php echo $textbooks_4w; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none; border-top: 1px solid gray;" class="sltr">
			<th>8週間</th>
			<td></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース1</th>
			<td><input type='text' class='mini' name="tuition_8w_pt" id="tuition_8w_pt" value="<?php echo $tuition_8w_pt; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース2</th>
			<td><input type='text' class='mini' name="tuition_8w_ft" id="tuition_8w_ft" value="<?php echo $tuition_8w_ft; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース3</th>
			<td><input type='text' class='mini' name="tuition_8w_cs3" id="tuition_8w_cs3" value="<?php echo $tuition_8w_cs3; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース4</th>
			<td><input type='text' class='mini' name="tuition_8w_cs4" id="tuition_8w_cs4" value="<?php echo $tuition_8w_cs4; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース5</th>
			<td><input type='text' class='mini' name="tuition_8w_cs5" id="tuition_8w_cs5" value="<?php echo $tuition_8w_cs5; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース6</th>
			<td><input type='text' class='mini' name="tuition_8w_cs6" id="tuition_8w_cs6" value="<?php echo $tuition_8w_cs6; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース7</th>
			<td><input type='text' class='mini' name="tuition_8w_cs7" id="tuition_8w_cs7" value="<?php echo $tuition_8w_cs7; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
<!-- 		<tr style="display: none;" class="sltr">
			<th>滞在費</th>
			<td><input type='text' class='mini' name="homestay_cost_8w" id="homestay_cost_8w" value="<?php // echo $homestay_cost_8w; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
-->
		<tr style="display: none;" class="sltr">
			<th>テキスト代</th>
			<td><input type='text' class='mini' name="textbooks_8w" id="textbooks_8w" value="<?php echo $textbooks_8w; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none; border-top: 1px solid gray;" class="sltr">
			<th>12週間</th>
			<td></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース1</th>
			<td><input type='text' class='mini' name="tuition_12w_pt" id="tuition_12w_pt" value="<?php echo $tuition_12w_pt; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース2</th>
			<td><input type='text' class='mini' name="tuition_12w_ft" id="tuition_12w_ft" value="<?php echo $tuition_12w_ft; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース3</th>
			<td><input type='text' class='mini' name="tuition_12w_cs3" id="tuition_12w_cs3" value="<?php echo $tuition_12w_cs3; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース4</th>
			<td><input type='text' class='mini' name="tuition_12w_cs4" id="tuition_12w_cs4" value="<?php echo $tuition_12w_cs4; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース5</th>
			<td><input type='text' class='mini' name="tuition_12w_cs5" id="tuition_12w_cs5" value="<?php echo $tuition_12w_cs5; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース6</th>
			<td><input type='text' class='mini' name="tuition_12w_cs6" id="tuition_12w_cs6" value="<?php echo $tuition_12w_cs6; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース7</th>
			<td><input type='text' class='mini' name="tuition_12w_cs7" id="tuition_12w_cs7" value="<?php echo $tuition_12w_cs7; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<!-- 		<tr style="display: none;" class="sltr">
			<th>滞在費</th>
			<td><input type='text' class='mini' name="homestay_cost_12w" id="homestay_cost_12w" value="<?php // echo $homestay_cost_12w; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
-->
		<tr style="display: none;" class="sltr">
			<th>テキスト代</th>
			<td><input type='text' class='mini' name="textbooks_12w" id="textbooks_12w" value="<?php echo $textbooks_12w; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none; border-top: 1px solid gray;" class="sltr">
			<th>16週間</th>
			<td></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース1</th>
			<td><input type='text' class='mini' name="tuition_16w_pt" id="tuition_16w_pt" value="<?php echo $tuition_16w_pt; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース2</th>
			<td><input type='text' class='mini' name="tuition_16w_ft" id="tuition_16w_ft" value="<?php echo $tuition_16w_ft; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース3</th>
			<td><input type='text' class='mini' name="tuition_16w_cs3" id="tuition_16w_cs3" value="<?php echo $tuition_16w_cs3; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース4</th>
			<td><input type='text' class='mini' name="tuition_16w_cs4" id="tuition_16w_cs4" value="<?php echo $tuition_16w_cs4; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース5</th>
			<td><input type='text' class='mini' name="tuition_16w_cs5" id="tuition_16w_cs5" value="<?php echo $tuition_16w_cs5; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース6</th>
			<td><input type='text' class='mini' name="tuition_16w_cs6" id="tuition_16w_cs6" value="<?php echo $tuition_16w_cs6; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース7</th>
			<td><input type='text' class='mini' name="tuition_16w_cs7" id="tuition_16w_cs7" value="<?php echo $tuition_16w_cs7; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
<!-- 	<tr style="display: none;" class="sltr"> -->
<!-- 			<th>滞在費</th>
			<td><input type='text' class='mini' name="homestay_cost_16w" id="homestay_cost_16w" value="<?php // echo $homestay_cost_16w; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
-->
		<tr style="display: none;" class="sltr">
			<th>テキスト代</th>
			<td><input type='text' class='mini' name="textbooks_16w" id="textbooks_16w" value="<?php echo $textbooks_16w; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none; border-top: 1px solid gray;" class="sltr">
			<th>24週間</th>
			<td></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース1</th>
			<td><input type='text' class='mini' name="tuition_24w_pt" id="tuition_24w_pt" value="<?php echo $tuition_24w_pt; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース2</th>
			<td><input type='text' class='mini' name="tuition_24w_ft" id="tuition_24w_ft" value="<?php echo $tuition_24w_ft; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース3</th>
			<td><input type='text' class='mini' name="tuition_24w_cs3" id="tuition_24w_cs3" value="<?php echo $tuition_24w_cs3; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース4</th>
			<td><input type='text' class='mini' name="tuition_24w_cs4" id="tuition_24w_cs4" value="<?php echo $tuition_24w_cs4; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース5</th>
			<td><input type='text' class='mini' name="tuition_24w_cs5" id="tuition_24w_cs5" value="<?php echo $tuition_24w_cs5; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース6</th>
			<td><input type='text' class='mini' name="tuition_24w_cs6" id="tuition_24w_cs6" value="<?php echo $tuition_24w_cs6; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース7</th>
			<td><input type='text' class='mini' name="tuition_24w_cs7" id="tuition_24w_cs7" value="<?php echo $tuition_24w_cs7; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr><!-- 		
		<tr style="display: none;" class="sltr">
			<th>滞在費</th>
			<td><input type='text' class='mini' name="homestay_cost_24w" id="homestay_cost_24w" value="<?php // echo $homestay_cost_24w; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
-->
		<tr style="display: none;" class="sltr">
			<th>テキスト代</th>
			<td><input type='text' class='mini' name="textbooks_24w" id="textbooks_24w" value="<?php echo $textbooks_24w; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none; border-top: 1px solid gray;" class="sltr">
			<th>36週間</th>
			<td></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース1</th>
			<td><input type='text' class='mini' name="tuition_36w_pt" id="tuition_36w_pt" value="<?php echo $tuition_36w_pt; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース2</th>
			<td><input type='text' class='mini' name="tuition_36w_ft" id="tuition_36w_ft" value="<?php echo $tuition_36w_ft; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース3</th>
			<td><input type='text' class='mini' name="tuition_36w_cs3" id="tuition_36w_cs3" value="<?php echo $tuition_36w_cs3; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース4</th>
			<td><input type='text' class='mini' name="tuition_36w_cs4" id="tuition_36w_cs4" value="<?php echo $tuition_36w_cs4; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース5</th>
			<td><input type='text' class='mini' name="tuition_36w_cs5" id="tuition_36w_cs5" value="<?php echo $tuition_36w_cs5; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース6</th>
			<td><input type='text' class='mini' name="tuition_36w_cs6" id="tuition_36w_cs6" value="<?php echo $tuition_36w_cs6; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース7</th>
			<td><input type='text' class='mini' name="tuition_36w_cs7" id="tuition_36w_cs7" value="<?php echo $tuition_36w_cs7; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<!-- 
		<tr style="display: none;" class="sltr">
			<th>滞在費</th>
			<td><input type='text' class='mini' name="homestay_cost_36w" id="homestay_cost_36w" value="<?php // echo $homestay_cost_36w; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
-->
		<tr style="display: none;" class="sltr">
			<th>テキスト代</th>
			<td><input type='text' class='mini' name="textbooks_36w" id="textbooks_36w" value="<?php echo $textbooks_36w; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none; border-top: 1px solid gray;" class="sltr">
			<th>48週間</th>
			<td></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース1</th>
			<td><input type='text' class='mini' name="tuition_48w_pt" id="tuition_48w_pt" value="<?php echo $tuition_48w_pt; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース2</th>
			<td><input type='text' class='mini' name="tuition_48w_ft" id="tuition_48w_ft" value="<?php echo $tuition_48w_ft; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース3</th>
			<td><input type='text' class='mini' name="tuition_48w_cs3" id="tuition_48w_cs3" value="<?php echo $tuition_48w_cs3; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース4</th>
			<td><input type='text' class='mini' name="tuition_48w_cs4" id="tuition_48w_cs4" value="<?php echo $tuition_48w_cs4; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース5</th>
			<td><input type='text' class='mini' name="tuition_48w_cs5" id="tuition_48w_cs5" value="<?php echo $tuition_48w_cs5; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース6</th>
			<td><input type='text' class='mini' name="tuition_48w_cs6" id="tuition_48w_cs6" value="<?php echo $tuition_48w_cs6; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>コース7</th>
			<td><input type='text' class='mini' name="tuition_48w_cs7" id="tuition_48w_cs7" value="<?php echo $tuition_48w_cs7; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
<!-- 
		<tr style="display: none;" class="sltr">
			<th>滞在費</th>
			<td><input type='text' class='mini' name="homestay_cost_48w" id="homestay_cost_48w" value="<?php echo $homestay_cost_48w; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
-->
		<tr style="display: none;" class="sltr">
			<th>テキスト代</th>
			<td><input type='text' class='mini' name="textbooks_48w" id="textbooks_48w" value="<?php echo $textbooks_48w; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
<!-- 		<tr style="display: none; border-top: 1px solid gray;" class="sltr">
			<th>スペシャルオファー1</th>
			<td></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>授業料（パートタイム）</th>
			<td><input type='text' class='mini' name="tuition_so1_pt" id="tuition_so1_pt" value="<?php // echo $tuition_so1_pt; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>授業料（フルタイム）</th>
			<td><input type='text' class='mini' name="tuition_so1_ft" id="tuition_so1_ft" value="<?php // echo $tuition_so1_ft; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
 -->
<!-- 
		<tr style="display: none;" class="sltr">
			<th>滞在費</th>
			<td><input type='text' class='mini' name="homestay_cost_so1" id="homestay_cost_so1" value="<?php // echo $homestay_cost_so1; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
-->
<!-- 		<tr style="display: none;" class="sltr">
			<th>テキスト代</th>
			<td><input type='text' class='mini' name="textbooks_so1" id="textbooks_so1" value="<?php // echo $textbooks_so1; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none; border-top: 1px solid gray;" class="sltr">
			<th>スペシャルオファー2</th>
			<td></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>授業料（パートタイム）</th>
			<td><input type='text' class='mini' name="tuition_so2_pt" id="tuition_so2_pt" value="<?php // echo $tuition_so2_pt; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>授業料（フルタイム）</th>
			<td><input type='text' class='mini' name="tuition_so2_ft" id="tuition_so2_ft" value="<?php // echo $tuition_so2_ft; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>  -->
<!-- 
		<tr style="display: none;" class="sltr">
			<th>滞在費</th>
			<td><input type='text' class='mini' name="homestay_cost_so2" id="homestay_cost_so2" value="<?php // echo $homestay_cost_so2; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
-->
<!-- 		<tr style="display: none;" class="sltr">
			<th>テキスト代</th>
			<td><input type='text' class='mini' name="textbooks_so2" id="textbooks_so2" value="<?php // echo $textbooks_so2; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none; border-top: 1px solid gray;" class="sltr">
			<th>スペシャルオファーオファー3</th>
			<td></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>授業料（パートタイム）</th>
			<td><input type='text' class='mini' name="tuition_so3_pt" id="tuition_so3_pt" value="<?php // echo $tuition_so3_pt; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>授業料（フルタイム）</th>
			<td><input type='text' class='mini' name="tuition_so3_ft" id="tuition_so3_ft" value="<?php // echo $tuition_so3_ft; ?>" maxlength="8" pattern="^[0-9]+$" pattern="^[0-9]+$" /></td>
		</tr>
 -->		
<!-- 
		<tr style="display: none;" class="sltr">
			<th>滞在費</th>
			<td><input type='text' class='mini' name="homestay_cost_so3" id="homestay_cost_so3" value="<?php // echo  $homestay_cost_so3; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
-->
<!-- 		
		<tr style="display: none;" class="sltr">
			<th>テキスト代</th>
			<td><input type='text' class='mini' name="textbooks_so3" id="textbooks_so3" value="<?php // echo $textbooks_so3; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none; border-top: 1px solid gray;" class="sltr">
			<th>スペシャルオファー4</th>
			<td></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>授業料（パートタイム）</th>
			<td><input type='text' class='mini' name="tuition_so4_pt" id="tuition_so4_pt" value="<?php // echo $tuition_so4_pt; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
		<tr style="display: none;" class="sltr">
			<th>授業料（フルタイム）</th>
			<td><input type='text' class='mini' name="tuition_so4_ft" id="tuition_so4_ft" value="<?php // echo $tuition_so4_ft; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
-->
<!-- 		
		<tr style="display: none;" class="sltr">
			<th>滞在費</th>
			<td><input type='text' class='mini' name="homestay_cost_so4" id="homestay_cost_so4" value="<?php // echo $homestay_cost_so4; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
-->
<!-- 		
		<tr style="display: none;" class="sltr">
			<th>テキスト代</th>
			<td><input type='text' class='mini' name="textbooks_so4" id="textbooks_so4" value="<?php // echo $textbooks_so4; ?>" maxlength="8" pattern="^[0-9]+$" /></td>
		</tr>
-->
	</table>

	<p class="return"><a href="#engp_ex_meta">TOPへ戻る</a></p>
</div>
<?php
}

/***************************************************************/
// カスタムフィールドの保存
/***************************************************************/
function engp_save_meta( $post_id ) {
	_log( 'engp_save_meta' );

	global $wpdb;
	global $post;
	$table_name = $wpdb->prefix . CUSTOM_TBL_SCHOOL_META;
	if ( ! isset( $_POST['ex_school_meta'] ) ) return;

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )  return;
	if ( ! wp_verify_nonce( $_POST['ex_school_meta'], 'ex_school_meta' ) )  return;

	//リビジョンを残さない
	if ( $post->ID != $post_id ) return;

	$school_name		= engp_get_value( $_POST['school_name'] );							// '学校名',
	$school_jp_name		= engp_get_value( $_POST['school_jp_name'] );						// '学校名（和名）',
	$address			= engp_get_value( $_POST['address'] );								// '住所',
	$phone				= engp_get_value( $_POST['phone'] );								// '電話番号',
	$lang				= engp_get_value( $_POST['lang'], MODE_EMPTY_CHECK_ON );			// '言語',
	$country			= engp_get_value( $_POST['country'], MODE_EMPTY_CHECK_ON );			// '国',
	$city				= engp_get_value( $_POST['city'] );									// '都市',
	$area				= engp_get_value( $_POST['area'] );									// '地域',
	$division			= engp_get_value( $_POST['division'], MODE_EMPTY_CHECK_ON );		// '地区',
	$outline			= engp_get_value( $_POST['outline'] );								// '概要',
	$staff_evaluation	= engp_get_value( $_POST['staff_evaluation'] );						// 'スタッフ評価',	
	$purpose1			= engp_get_value( $_POST['purpose1'], MODE_EMPTY_CHECK_ON );		// '検索項目1',
	$purpose2			= engp_get_value( $_POST['purpose2'], MODE_EMPTY_CHECK_ON );		// '検索項目2',
	$purpose3			= engp_get_value( $_POST['purpose3'], MODE_EMPTY_CHECK_ON );		// '検索項目3',
	$purpose4			= engp_get_value( $_POST['purpose4'], MODE_EMPTY_CHECK_ON );		// '検索項目4',
	$purpose5			= engp_get_value( $_POST['purpose5'], MODE_EMPTY_CHECK_ON );		// '検索項目5',
	$quality			= engp_get_value( $_POST['quality'] );								// '授業品質',
	$location_type		= engp_get_value( $_POST['location_type'], MODE_EMPTY_CHECK_ON );	// '所在',
	$location			= engp_get_value( $_POST['location'], MODE_EMPTY_CHECK_ON );		// 'ロケーション',
	$parking			= engp_get_value( $_POST['parking'], MODE_EMPTY_CHECK_ON );			// '駐車場',
	$how_to_go			= engp_get_value( $_POST['how_to_go'], MODE_EMPTY_CHECK_ON );		// '通学手段',
	$security			= engp_get_value( $_POST['security'], MODE_EMPTY_CHECK_ON );		// '治安',
	$nationality		= engp_get_value( $_POST['nationality'], MODE_EMPTY_CHECK_ON );		// '国籍バランス',
	$target_ESL			= engp_get_value( $_POST['target_ESL'] );							// 'コース ESL',
	$target_TOEFL		= engp_get_value( $_POST['target_TOEFL'] );							// 'コース TOEFL',
	$target_TOEIC		= engp_get_value( $_POST['target_TOEIC'] );							// 'コース TOEIC',
	$target_advance		= engp_get_value( $_POST['target_advance'] );						// 'コース 進学',
	$target_business	= engp_get_value( $_POST['target_business'] );						// 'コース ビジネス',
	$target_child		= engp_get_value( $_POST['target_child'] );							// 'コース 子供',
	$target_adult		= engp_get_value( $_POST['target_adult'] );							// 'コース 大人',
	$target_ILETS		= engp_get_value( $_POST['target_ILETS'] );							// 'コース IELTS',
	$target_so			= engp_get_value( $_POST['target_so'] );							// 'コース スペシャルオファー',	
	$target_other		= engp_get_value( $_POST['target_other'] );							// 'コース  その他',
	$school_size		= engp_get_value( $_POST['school_size'] );							// 'スクールサイズ',
	$levels				= engp_get_value( $_POST['levels'] );	 							// 'レベル数',
	$avg_classsize		= engp_get_value( $_POST['avg_classsize'] );						// '平均クラスサイズ',
	$enrollment			= engp_get_value( $_POST['enrollment'] );							// '入学時期',
	$options			= engp_get_value( $_POST['options'] );								// 'オプション',
	$facilities			= engp_get_value( $_POST['facilities'] );							// '学校設備',
	$other				= engp_get_value( $_POST['other'] );								// 'その他',
	$youtube_url		= engp_get_value( $_POST['youtube_url'] );							// 'YouTube URL',
	$local_staff		= engp_get_value( $_POST['local_staff'], MODE_EMPTY_CHECK_ON );		// '現地スタッフサポート可否',
	$recommend			= engp_get_value( $_POST['recommend'], MODE_EMPTY_CHECK_ON );		// 'お薦めフラグ',

	// オプションの取得
	$options_array = array();
	if( isset( $_POST['options_Homestay'] ) )		$options_array[] = 'ホームスティ';
	if( isset( $_POST['options_Dormitory'] ) )		$options_array[] = '寮';
	if( isset( $_POST['options_AirportPickUp'] ) )	$options_array[] = '空港出迎え';
	if( isset( $_POST['options_PrivateClass'] ) )	$options_array[] = 'プライベートレッスン';
	if( isset( $_POST['options_Other'] ) )			$options_array[] = 'その他';
	$options = implode( ',', $options_array );

	// 学校設備の取得
	$facilities_array = array();
	if( isset( $_POST['facilities_Lounge'] ) )			$facilities_array[] = 'ラウンジ';
	if( isset( $_POST['facilities_ComputerRoom'] ) )	$facilities_array[] = 'コンピュータルーム';
	if( isset( $_POST['facilities_WIFI'] ) )			$facilities_array[] = 'ワイヤレスインターネット利用';
	if( isset( $_POST['facilities_CounselingRoom'] ) )	$facilities_array[] = 'カウンセリングルーム';
	if( isset( $_POST['facilities_Gym'] ) )				$facilities_array[] = 'ジム';
	if( isset( $_POST['facilities_Library'] ) )			$facilities_array[] = '図書館';
	if( isset( $_POST['facilities_Other'] ) )			$facilities_array[] = 'その他';
	$facilities = implode( ',', $facilities_array );

	//保存するために配列にする
	$set_arr = array(
		'school_name'		=> $school_name,
		'school_jp_name'	=> $school_jp_name,
		'address'			=> $address,
		'phone'				=> $phone,
		'lang'				=> $lang,
		'country'			=> $country,
		'division'			=> $division,
		'city'				=> $city,
		'area'				=> $area,
		'outline'			=> $outline,
		'staff_evaluation'	=> $staff_evaluation,			
		'purpose1'			=> $purpose1,
		'purpose2'			=> $purpose2,
		'purpose3'			=> $purpose3,
		'purpose4'			=> $purpose4,
		'purpose5'			=> $purpose5,
		'quality'			=> $quality,
		'location_type'		=> $location_type,
		'location'			=> $location,
		'parking'			=> $parking,
		'how_to_go'			=> $how_to_go,
		'security'			=> $security,
		'nationality'		=> $nationality,
		'target_ESL'		=> $target_ESL,
		'target_TOEFL'		=> $target_TOEFL,
		'target_TOEIC'		=> $target_TOEIC,
		'target_advance'	=> $target_advance,
		'target_business'	=> $target_business,
		'target_child'		=> $target_child,
		'target_adult'		=> $target_adult,
		'target_ILETS'		=> $target_ILETS,
		'target_so'			=> $target_so,
		'target_other'		=> $target_other,
		'school_size'		=> $school_size,
		'levels'			=> $levels,
		'avg_classsize'		=> $avg_classsize,
		'enrollment'		=> $enrollment,
		'options'			=> $options,
		'local_staff'		=> $local_staff,
		'facilities'		=> $facilities,
		'other'				=> $other,
		'youtube_url'		=> $youtube_url,
		'recommend'			=> $recommend,
	);

	// 学校費用
	$cost_table_name = $wpdb->prefix . CUSTOM_TBL_SCHOOL_COST;

	$viewtype_yen					= engp_get_value( $_POST['viewtype_yen'] );										// '円表示フラグ',
	if($viewtype_yen != '1'){
		$viewtype_yen = '0';
	}
	$admission_fee					= engp_get_value( $_POST['admission_fee'], MODE_EMPTY_CHECK_ON );				// '入学金',
	$accommodation_placement_fee	= engp_get_value( $_POST['accommodation_placement_fee'], MODE_EMPTY_CHECK_ON) ;	// '滞在先手配料',
	$homestay						= engp_get_value( $_POST['homestay'], MODE_EMPTY_CHECK_ON) ;	// '滞在先手配料',	
	$dormitory_1					= engp_get_value( $_POST['dormitory_1'], MODE_EMPTY_CHECK_ON) ;					// '学生寮(1人部屋)',	
	$dormitory_2					= engp_get_value( $_POST['dormitory_2'], MODE_EMPTY_CHECK_ON) ;					// '学生寮(2人部屋)',	
	$dormitory_3					= engp_get_value( $_POST['dormitory_3'], MODE_EMPTY_CHECK_ON) ;					// '学生寮(3人部屋)',	
	$dormitory_4					= engp_get_value( $_POST['dormitory_4'], MODE_EMPTY_CHECK_ON) ;					// '学生寮(4人部屋)',	
	$i20_issuance_postage			= engp_get_value( $_POST['i20_issuance_postage'], MODE_EMPTY_CHECK_ON );		// 'I20発行・送料',
	$airport_pickup_cost			= engp_get_value( $_POST['airport_pickup_cost'], MODE_EMPTY_CHECK_ON );			// '空港出迎え費',
	$bank_charge					= engp_get_value( $_POST['bank_charge'], MODE_EMPTY_CHECK_ON );					// 'バンクチャージ',
	//コース名
	$course_name_pt					= engp_get_value( $_POST['course_name_pt'], MODE_EMPTY_CHECK_ON );				// 'コース1:コース名',
	$course_name_ft					= engp_get_value( $_POST['course_name_ft'], MODE_EMPTY_CHECK_ON );				// 'コース2:コース名',	
	$course_name_cs3				= engp_get_value( $_POST['course_name_cs3'], MODE_EMPTY_CHECK_ON );				// 'コース3:コース名',	
	$course_name_cs4				= engp_get_value( $_POST['course_name_cs4'], MODE_EMPTY_CHECK_ON );				// 'コース4:コース名',
	$course_name_cs5				= engp_get_value( $_POST['course_name_cs5'], MODE_EMPTY_CHECK_ON );				// 'コース5:コース名',
	$course_name_cs6				= engp_get_value( $_POST['course_name_cs6'], MODE_EMPTY_CHECK_ON );				// 'コース6:コース名',
	$course_name_cs7				= engp_get_value( $_POST['course_name_cs7'], MODE_EMPTY_CHECK_ON );				// 'コース7:コース名',		
	//コース詳細
	$course_detail_pt				= engp_get_value( $_POST['course_detail_pt'], MODE_EMPTY_CHECK_ON );			// 'コース1:コース詳細',
	$course_detail_ft				= engp_get_value( $_POST['course_detail_ft'], MODE_EMPTY_CHECK_ON );			// 'コース2:コース詳細',
	$course_detail_cs3				= engp_get_value( $_POST['course_detail_cs3'], MODE_EMPTY_CHECK_ON );			// 'コース3:コース詳細',
	$course_detail_cs4				= engp_get_value( $_POST['course_detail_cs4'], MODE_EMPTY_CHECK_ON );			// 'コース4:コース詳細',
	$course_detail_cs5				= engp_get_value( $_POST['course_detail_cs5'], MODE_EMPTY_CHECK_ON );			// 'コース5:コース詳細',
	$course_detail_cs6				= engp_get_value( $_POST['course_detail_cs6'], MODE_EMPTY_CHECK_ON );			// 'コース6:コース詳細',
	$course_detail_cs7				= engp_get_value( $_POST['course_detail_cs7'], MODE_EMPTY_CHECK_ON );			// 'コース7:コース詳細',	
	//2週間
// 	$tuition_2w_pt					= engp_get_value( $_POST['tuition_2w_pt'], MODE_EMPTY_CHECK_ON );				// '授業料 パートタイム（2週間）',
// 	$tuition_2w_ft					= engp_get_value( $_POST['tuition_2w_ft'], MODE_EMPTY_CHECK_ON );				// '授業料 フルタイム（2週間）',
// 	$tuition_2w_cs3					= engp_get_value( $_POST['tuition_2w_cs3'], MODE_EMPTY_CHECK_ON );				// '授業料 コース3（2週間）',	
// 	$tuition_2w_cs4					= engp_get_value( $_POST['tuition_2w_cs4'], MODE_EMPTY_CHECK_ON );				// '授業料 コース4（2週間）',	
// 	$tuition_2w_cs5					= engp_get_value( $_POST['tuition_2w_cs5'], MODE_EMPTY_CHECK_ON );				// '授業料 コース5（2週間）',	
// 	$tuition_2w_cs6					= engp_get_value( $_POST['tuition_2w_cs6'], MODE_EMPTY_CHECK_ON );				// '授業料 コース6（2週間）',	
// 	$tuition_2w_cs7					= engp_get_value( $_POST['tuition_2w_cs7'], MODE_EMPTY_CHECK_ON );				// '授業料 コース7（2週間）',
// 	$homestay_cost_2w				= engp_get_value( $_POST['homestay_cost_2w'], MODE_EMPTY_CHECK_ON );			// 'ホームステイ費（2週間）',	
// 	$textbooks_2w					= engp_get_value( $_POST['textbooks_2w'], MODE_EMPTY_CHECK_ON );				// 'テキスト代（2週間）',
	//4週間	
	$tuition_4w_pt					= engp_get_value( $_POST['tuition_4w_pt'], MODE_EMPTY_CHECK_ON );				// '授業料 パートタイム（4週間）',
	$tuition_4w_ft					= engp_get_value( $_POST['tuition_4w_ft'], MODE_EMPTY_CHECK_ON );				// '授業料 フルタイム（4週間）',
	$tuition_4w_cs3					= engp_get_value( $_POST['tuition_4w_cs3'], MODE_EMPTY_CHECK_ON );				// '授業料 コース3（4週間）',
	$tuition_4w_cs4					= engp_get_value( $_POST['tuition_4w_cs4'], MODE_EMPTY_CHECK_ON );				// '授業料 コース4（4週間）',
	$tuition_4w_cs5					= engp_get_value( $_POST['tuition_4w_cs5'], MODE_EMPTY_CHECK_ON );				// '授業料 コース5（4週間）',
	$tuition_4w_cs6					= engp_get_value( $_POST['tuition_4w_cs6'], MODE_EMPTY_CHECK_ON );				// '授業料 コース6（4週間）',
	$tuition_4w_cs7					= engp_get_value( $_POST['tuition_4w_cs7'], MODE_EMPTY_CHECK_ON );				// '授業料 コース7（4週間）',	
// 	$homestay_cost_4w				= engp_get_value( $_POST['homestay_cost_4w'], MODE_EMPTY_CHECK_ON );			// 'ホームステイ費（4週間）',
	$textbooks_4w					= engp_get_value( $_POST['textbooks_4w'], MODE_EMPTY_CHECK_ON );				// 'テキスト代（4週間）',
	//8週間	
	$tuition_8w_pt					= engp_get_value( $_POST['tuition_8w_pt'], MODE_EMPTY_CHECK_ON );				// '授業料 パートタイム（8週間）',
	$tuition_8w_ft					= engp_get_value( $_POST['tuition_8w_ft'], MODE_EMPTY_CHECK_ON );				// '授業料 フルタイム（8週間）',
	$tuition_8w_cs3					= engp_get_value( $_POST['tuition_8w_cs3'], MODE_EMPTY_CHECK_ON );				// '授業料 コース3（8週間）',
	$tuition_8w_cs4					= engp_get_value( $_POST['tuition_8w_cs4'], MODE_EMPTY_CHECK_ON );				// '授業料 コース4（8週間）',
	$tuition_8w_cs5					= engp_get_value( $_POST['tuition_8w_cs5'], MODE_EMPTY_CHECK_ON );				// '授業料 コース5（8週間）',
	$tuition_8w_cs6					= engp_get_value( $_POST['tuition_8w_cs6'], MODE_EMPTY_CHECK_ON );				// '授業料 コース6（8週間）',
	$tuition_8w_cs7					= engp_get_value( $_POST['tuition_8w_cs7'], MODE_EMPTY_CHECK_ON );				// '授業料 コース7（8週間）',
// 	$homestay_cost_8w				= engp_get_value( $_POST['homestay_cost_8w'], MODE_EMPTY_CHECK_ON );			// 'ホームステイ費（8週間）',
	$textbooks_8w					= engp_get_value( $_POST['textbooks_8w'], MODE_EMPTY_CHECK_ON );				// 'テキスト代（8週間）',
	//12週間	
	$tuition_12w_pt					= engp_get_value( $_POST['tuition_12w_pt'], MODE_EMPTY_CHECK_ON );				// '授業料 パートタイム（12週間）',
	$tuition_12w_ft					= engp_get_value( $_POST['tuition_12w_ft'], MODE_EMPTY_CHECK_ON );				// '授業料 フルタイム（12週間）',
	$tuition_12w_cs3					= engp_get_value( $_POST['tuition_12w_cs3'], MODE_EMPTY_CHECK_ON );			// '授業料 コース3（12週間）',
	$tuition_12w_cs4					= engp_get_value( $_POST['tuition_12w_cs4'], MODE_EMPTY_CHECK_ON );			// '授業料 コース4（12週間）',
	$tuition_12w_cs5					= engp_get_value( $_POST['tuition_12w_cs5'], MODE_EMPTY_CHECK_ON );			// '授業料 コース5（12週間）',
	$tuition_12w_cs6					= engp_get_value( $_POST['tuition_12w_cs6'], MODE_EMPTY_CHECK_ON );			// '授業料 コース6（12週間）',
	$tuition_12w_cs7					= engp_get_value( $_POST['tuition_12w_cs7'], MODE_EMPTY_CHECK_ON );			// '授業料 コース7（12週間）',	
//	$homestay_cost_12w				= engp_get_value( $_POST['homestay_cost_12w'], MODE_EMPTY_CHECK_ON );			// 'ホームステイ費（12週間）',
	$textbooks_12w					= engp_get_value( $_POST['textbooks_12w'], MODE_EMPTY_CHECK_ON );				// 'テキスト代（12週間）',
	//16週間	
	$tuition_16w_pt					= engp_get_value( $_POST['tuition_16w_pt'], MODE_EMPTY_CHECK_ON );				// '授業料 パートタイム（16週間）',
	$tuition_16w_ft					= engp_get_value( $_POST['tuition_16w_ft'], MODE_EMPTY_CHECK_ON );				// '授業料 フルタイム（16週間）',
	$tuition_16w_cs3					= engp_get_value( $_POST['tuition_16w_cs3'], MODE_EMPTY_CHECK_ON );			// '授業料 コース3（16週間）',
	$tuition_16w_cs4					= engp_get_value( $_POST['tuition_16w_cs4'], MODE_EMPTY_CHECK_ON );			// '授業料 コース4（16週間）',
	$tuition_16w_cs5					= engp_get_value( $_POST['tuition_16w_cs5'], MODE_EMPTY_CHECK_ON );			// '授業料 コース5（16週間）',
	$tuition_16w_cs6					= engp_get_value( $_POST['tuition_16w_cs6'], MODE_EMPTY_CHECK_ON );			// '授業料 コース6（16週間）',
	$tuition_16w_cs7					= engp_get_value( $_POST['tuition_16w_cs7'], MODE_EMPTY_CHECK_ON );			// '授業料 コース7（16週間）',
//	$homestay_cost_16w				= engp_get_value( $_POST['homestay_cost_16w'], MODE_EMPTY_CHECK_ON );			// 'ホームステイ費（16週間）',
	$textbooks_16w					= engp_get_value( $_POST['textbooks_16w'], MODE_EMPTY_CHECK_ON );				// 'テキスト代（16週間）',
	//24週間	
	$tuition_24w_pt					= engp_get_value( $_POST['tuition_24w_pt'], MODE_EMPTY_CHECK_ON );				// '授業料 パートタイム（24週間）',
	$tuition_24w_ft					= engp_get_value( $_POST['tuition_24w_ft'], MODE_EMPTY_CHECK_ON );				// '授業料 フルタイム（24週間）',
	$tuition_24w_cs3					= engp_get_value( $_POST['tuition_24w_cs3'], MODE_EMPTY_CHECK_ON );			// '授業料 コース3（24週間）',
	$tuition_24w_cs4					= engp_get_value( $_POST['tuition_24w_cs4'], MODE_EMPTY_CHECK_ON );			// '授業料 コース4（24週間）',
	$tuition_24w_cs5					= engp_get_value( $_POST['tuition_24w_cs5'], MODE_EMPTY_CHECK_ON );			// '授業料 コース5（24週間）',
	$tuition_24w_cs6					= engp_get_value( $_POST['tuition_24w_cs6'], MODE_EMPTY_CHECK_ON );			// '授業料 コース6（24週間）',
	$tuition_24w_cs7					= engp_get_value( $_POST['tuition_24w_cs7'], MODE_EMPTY_CHECK_ON );			// '授業料 コース7（24週間）',
//	$homestay_cost_24w				= engp_get_value( $_POST['homestay_cost_24w'], MODE_EMPTY_CHECK_ON );			// 'ホームステイ費（24週間）',
	$textbooks_24w					= engp_get_value( $_POST['textbooks_24w'], MODE_EMPTY_CHECK_ON );				// 'テキスト代（24週間）',
	//36週間	
	$tuition_36w_pt					= engp_get_value( $_POST['tuition_36w_pt'], MODE_EMPTY_CHECK_ON );				// '授業料 パートタイム（36週間）',
	$tuition_36w_ft					= engp_get_value( $_POST['tuition_36w_ft'], MODE_EMPTY_CHECK_ON );				// '授業料 フルタイム（36週間）',
	$tuition_36w_cs3					= engp_get_value( $_POST['tuition_36w_cs3'], MODE_EMPTY_CHECK_ON );			// '授業料 コース3（36週間）',
	$tuition_36w_cs4					= engp_get_value( $_POST['tuition_36w_cs4'], MODE_EMPTY_CHECK_ON );			// '授業料 コース4（36週間）',
	$tuition_36w_cs5					= engp_get_value( $_POST['tuition_36w_cs5'], MODE_EMPTY_CHECK_ON );			// '授業料 コース5（36週間）',
	$tuition_36w_cs6					= engp_get_value( $_POST['tuition_36w_cs6'], MODE_EMPTY_CHECK_ON );			// '授業料 コース6（36週間）',
	$tuition_36w_cs7					= engp_get_value( $_POST['tuition_36w_cs7'], MODE_EMPTY_CHECK_ON );			// '授業料 コース7（36週間）',
//	$homestay_cost_36w				= engp_get_value( $_POST['homestay_cost_36w'], MODE_EMPTY_CHECK_ON );			// 'ホームステイ費（36週間）',
	$textbooks_36w					= engp_get_value( $_POST['textbooks_36w'], MODE_EMPTY_CHECK_ON );				// 'テキスト代（36週間）',
	//48週間	
	$tuition_48w_pt					= engp_get_value( $_POST['tuition_48w_pt'], MODE_EMPTY_CHECK_ON );				// '授業料 パートタイム（48週間）',
	$tuition_48w_ft					= engp_get_value( $_POST['tuition_48w_ft'], MODE_EMPTY_CHECK_ON );				// '授業料 フルタイム（48週間）',
	$tuition_48w_cs3					= engp_get_value( $_POST['tuition_48w_cs3'], MODE_EMPTY_CHECK_ON );			// '授業料 コース3（48週間）',
	$tuition_48w_cs4					= engp_get_value( $_POST['tuition_48w_cs4'], MODE_EMPTY_CHECK_ON );			// '授業料 コース4（48週間）',
	$tuition_48w_cs5					= engp_get_value( $_POST['tuition_48w_cs5'], MODE_EMPTY_CHECK_ON );			// '授業料 コース5（48週間）',
	$tuition_48w_cs6					= engp_get_value( $_POST['tuition_48w_cs6'], MODE_EMPTY_CHECK_ON );			// '授業料 コース6（48週間）',
	$tuition_48w_cs7					= engp_get_value( $_POST['tuition_48w_cs7'], MODE_EMPTY_CHECK_ON );			// '授業料 コース7（48週間）',	
	$homestay_cost_48w				= engp_get_value( $_POST['homestay_cost_48w'], MODE_EMPTY_CHECK_ON );			// 'ホームステイ費（48週間）',
	$textbooks_48w					= engp_get_value( $_POST['textbooks_48w'], MODE_EMPTY_CHECK_ON );				// 'テキスト代（48週間）',
	//スペシャルオファー
// 	$tuition_so1_pt					= engp_get_value( $_POST['tuition_so1_pt'], MODE_EMPTY_CHECK_ON );				// '授業料 パートタイム（スペシャルオファー1）',
// 	$tuition_so1_ft					= engp_get_value( $_POST['tuition_so1_ft'], MODE_EMPTY_CHECK_ON );				// '授業料 フルタイム（スペシャルオファー1）',
// 	$homestay_cost_so1				= engp_get_value( $_POST['homestay_cost_so1'], MODE_EMPTY_CHECK_ON );			// 'ホームステイ費（スペシャルオファー1）',
// 	$textbooks_so1					= engp_get_value( $_POST['textbooks_so1'], MODE_EMPTY_CHECK_ON );				// 'テキスト代（スペシャルオファー1）',
// 	$tuition_so2_pt					= engp_get_value( $_POST['tuition_so2_pt'], MODE_EMPTY_CHECK_ON );				// '授業料 パートタイム（スペシャルオファー2）',
// 	$tuition_so2_ft					= engp_get_value( $_POST['tuition_so2_ft'], MODE_EMPTY_CHECK_ON );				// '授業料 フルタイム（スペシャルオファー2）',
// 	$homestay_cost_so2				= engp_get_value( $_POST['homestay_cost_so2'], MODE_EMPTY_CHECK_ON );			// 'ホームステイ費（スペシャルオファー2）',
// 	$textbooks_so2					= engp_get_value( $_POST['textbooks_so2'], MODE_EMPTY_CHECK_ON );				// 'テキスト代（スペシャルオファー2）',
// 	$tuition_so3_pt					= engp_get_value( $_POST['tuition_so3_pt'], MODE_EMPTY_CHECK_ON );				// '授業料 パートタイム（スペシャルオファー3）',
// 	$tuition_so3_ft					= engp_get_value( $_POST['tuition_so3_ft'], MODE_EMPTY_CHECK_ON );				// '授業料 フルタイム（スペシャルオファー3）',
// 	$homestay_cost_so3				= engp_get_value( $_POST['homestay_cost_so3'], MODE_EMPTY_CHECK_ON );			// 'ホームステイ費（スペシャルオファー3）',
// 	$textbooks_so3					= engp_get_value( $_POST['textbooks_so3'], MODE_EMPTY_CHECK_ON );				// 'テキスト代（スペシャルオファー3）',
// 	$tuition_so4_pt					= engp_get_value( $_POST['tuition_so4_pt'], MODE_EMPTY_CHECK_ON );				// '授業料 パートタイム（スペシャルオファー4）',
// 	$tuition_so4_ft					= engp_get_value( $_POST['tuition_so4_ft'], MODE_EMPTY_CHECK_ON );				// '授業料 フルタイム（スペシャルオファー4）',
// 	$homestay_cost_so4				= engp_get_value( $_POST['homestay_cost_so4'], MODE_EMPTY_CHECK_ON );			// 'ホームステイ費（スペシャルオファー4）',
// 	$textbooks_so4					= engp_get_value( $_POST['textbooks_so4'], MODE_EMPTY_CHECK_ON );				// 'テキスト代（スペシャルオファー4）',

	//保存するために配列にする
	$set_cost_arr = array(
			'viewtype_yen'					=> $viewtype_yen,
			'admission_fee'					=> $admission_fee,
			'accommodation_placement_fee'	=> $accommodation_placement_fee,
			'homestay'						=> $homestay,			
			'dormitory_1'					=> $dormitory_1,			
			'dormitory_2'					=> $dormitory_2,
			'dormitory_3'					=> $dormitory_3,
			'dormitory_4'					=> $dormitory_4,			
			'i20_issuance_postage'			=> $i20_issuance_postage,
			'airport_pickup_cost'			=> $airport_pickup_cost,
			'bank_charge'					=> $bank_charge,
			'course_name_pt'				=> $course_name_pt,			
			'course_name_ft'				=> $course_name_ft,			
			'course_name_cs3'				=> $course_name_cs3,			
			'course_name_cs4'				=> $course_name_cs4,
			'course_name_cs5'				=> $course_name_cs5,
			'course_name_cs6'				=> $course_name_cs6,
			'course_name_cs7'				=> $course_name_cs7,						
			'course_detail_pt'				=> $course_detail_pt,
			'course_detail_ft'				=> $course_detail_ft,
			'course_detail_cs3'				=> $course_detail_cs3,
			'course_detail_cs4'				=> $course_detail_cs4,
			'course_detail_cs5'				=> $course_detail_cs5,
			'course_detail_cs6'				=> $course_detail_cs6,
			'course_detail_cs7'				=> $course_detail_cs7,				
// 			'tuition_2w_pt'					=> $tuition_2w_pt,
// 			'tuition_2w_ft'					=> $tuition_2w_ft,
// 			'tuition_2w_cs3'				=> $tuition_2w_cs3,			
// 			'tuition_2w_cs4'				=> $tuition_2w_cs4,			
// 			'tuition_2w_cs5'				=> $tuition_2w_cs5,
// 			'tuition_2w_cs6'				=> $tuition_2w_cs6,
// 			'tuition_2w_cs7'				=> $tuition_2w_cs7,			
// 			'homestay_cost_2w'				=> $homestay_cost_2w,
//			'textbooks_2w'					=> $textbooks_2w,
			'tuition_4w_pt'					=> $tuition_4w_pt,
			'tuition_4w_ft'					=> $tuition_4w_ft,
			'tuition_4w_cs3'				=> $tuition_4w_cs3,
			'tuition_4w_cs4'				=> $tuition_4w_cs4,
			'tuition_4w_cs5'				=> $tuition_4w_cs5,
			'tuition_4w_cs6'				=> $tuition_4w_cs6,
			'tuition_4w_cs7'				=> $tuition_4w_cs7,				
//			'homestay_cost_4w'				=> $homestay_cost_4w,
			'textbooks_4w'					=> $textbooks_4w,
			'tuition_8w_pt'					=> $tuition_8w_pt,
			'tuition_8w_ft'					=> $tuition_8w_ft,
			'tuition_8w_cs3'				=> $tuition_8w_cs3,
			'tuition_8w_cs4'				=> $tuition_8w_cs4,
			'tuition_8w_cs5'				=> $tuition_8w_cs5,
			'tuition_8w_cs6'				=> $tuition_8w_cs6,
			'tuition_8w_cs7'				=> $tuition_8w_cs7,				
//			'homestay_cost_8w'				=> $homestay_cost_8w,
			'textbooks_8w'					=> $textbooks_8w,
			'tuition_12w_pt'				=> $tuition_12w_pt,
			'tuition_12w_ft'				=> $tuition_12w_ft,
			'tuition_12w_cs3'				=> $tuition_12w_cs3,
			'tuition_12w_cs4'				=> $tuition_12w_cs4,
			'tuition_12w_cs5'				=> $tuition_12w_cs5,
			'tuition_12w_cs6'				=> $tuition_12w_cs6,
			'tuition_12w_cs7'				=> $tuition_12w_cs7,				
//			'homestay_cost_12w'				=> $homestay_cost_12w,
			'textbooks_12w'					=> $textbooks_12w,
			'tuition_16w_pt'				=> $tuition_16w_pt,
			'tuition_16w_ft'				=> $tuition_16w_ft,
			'tuition_16w_cs3'				=> $tuition_16w_cs3,
			'tuition_16w_cs4'				=> $tuition_16w_cs4,
			'tuition_16w_cs5'				=> $tuition_16w_cs5,
			'tuition_16w_cs6'				=> $tuition_16w_cs6,
			'tuition_16w_cs7'				=> $tuition_16w_cs7,				
//			'homestay_cost_16w'				=> $homestay_cost_16w,
			'textbooks_16w'					=> $textbooks_16w,
			'tuition_24w_pt'				=> $tuition_24w_pt,
			'tuition_24w_ft'				=> $tuition_24w_ft,
			'tuition_24w_cs3'				=> $tuition_24w_cs3,
			'tuition_24w_cs4'				=> $tuition_24w_cs4,
			'tuition_24w_cs5'				=> $tuition_24w_cs5,
			'tuition_24w_cs6'				=> $tuition_24w_cs6,
			'tuition_24w_cs7'				=> $tuition_24w_cs7,				
//			'homestay_cost_24w'				=> $homestay_cost_24w,
			'textbooks_24w'					=> $textbooks_24w,
			'tuition_36w_pt'				=> $tuition_36w_pt,
			'tuition_36w_ft'				=> $tuition_36w_ft,
			'tuition_36w_cs3'				=> $tuition_36w_cs3,
			'tuition_36w_cs4'				=> $tuition_36w_cs4,
			'tuition_36w_cs5'				=> $tuition_36w_cs5,
			'tuition_36w_cs6'				=> $tuition_36w_cs6,
			'tuition_36w_cs7'				=> $tuition_36w_cs7,
//			'homestay_cost_36w'				=> $homestay_cost_36w,
			'textbooks_36w'					=> $textbooks_36w,
			'tuition_48w_pt'				=> $tuition_48w_pt,
			'tuition_48w_ft'				=> $tuition_48w_ft,
			'tuition_48w_cs3'				=> $tuition_48w_cs3,
			'tuition_48w_cs4'				=> $tuition_48w_cs4,
			'tuition_48w_cs5'				=> $tuition_48w_cs5,
			'tuition_48w_cs6'				=> $tuition_48w_cs6,
			'tuition_48w_cs7'				=> $tuition_48w_cs7,
//			'homestay_cost_48w'				=> $homestay_cost_48w,
			'textbooks_48w'					=> $textbooks_48w,
// 			'tuition_so1_pt'				=> $tuition_so1_pt,
// 			'tuition_so1_ft'				=> $tuition_so1_ft,
// 			'homestay_cost_so1'				=> $homestay_cost_so1,
// 			'textbooks_so1'					=> $textbooks_so1,
// 			'tuition_so2_pt'				=> $tuition_so2_pt,
// 			'tuition_so2_ft'				=> $tuition_so2_ft,
// 			'homestay_cost_so2'				=> $homestay_cost_so2,
// 			'textbooks_so2'					=> $textbooks_so2,
// 			'tuition_so3_pt'				=> $tuition_so3_pt,
// 			'tuition_so3_ft'				=> $tuition_so3_ft,
// 			'homestay_cost_so3'				=> $homestay_cost_so3,
// 			'textbooks_so3'					=> $textbooks_so3,
// 			'tuition_so4_pt'				=> $tuition_so4_pt,
// 			'tuition_so4_ft'				=> $tuition_so4_ft,
// 			'homestay_cost_so4'				=> $homestay_cost_so4,
// 			'textbooks_so4'					=> $textbooks_so4,
	);

	// 登録処理
	$get_id = $wpdb->get_var(
		$wpdb->prepare( "SELECT post_id FROM ". $table_name ." WHERE post_id = %d", $post_id )
	);
	//レコードがなかったら新規追加あったら更新
	if ( $get_id ) {
		$wpdb->update( $table_name, $set_arr, array( 'post_id' => $post_id ) );
		$wpdb->update( $cost_table_name, $set_cost_arr, array( 'post_id' => $post_id ) );
	} else {
		$set_arr['post_id'] = $post_id;
		$wpdb->insert( $table_name, $set_arr );
		$set_cost_arr['post_id'] = $post_id;
		$wpdb->insert( $cost_table_name,$set_cost_arr);
		// post_nameにPOST IDをセット（新規登録のみ）
		$custom_post = array();
		$custom_post['ID'] = $post_id;
		$custom_post['post_name'] = $post_id;
		wp_update_post( $custom_post );
	}
	$wpdb->show_errors();
}

/***************************************************************/
// カスタムフィールドの削除
/***************************************************************/
function engp_dalete_meta( $post_id ) {
	_log( 'engp_dalete_meta' );

	global $wpdb;
	$table_name = $wpdb->prefix . CUSTOM_TBL_SCHOOL_META;
	$wpdb->query( $wpdb->prepare( "DELETE FROM ".$table_name. " WHERE post_id = %d", $post_id) );
	$table_name = $wpdb->prefix . CUSTOM_TBL_SCHOOL_COST;
	$wpdb->query( $wpdb->prepare( "DELETE FROM ".$table_name. " WHERE post_id = %d", $post_id) );
	$table_name = $wpdb->prefix . CUSTOM_TBL_FAVORITE;
	$wpdb->query( $wpdb->prepare( "DELETE FROM ".$table_name. " WHERE post_id = %d", $post_id) );
	$table_name = $wpdb->prefix . CUSTOM_TBL_SCHOOL_REVIEW;
	$wpdb->query( $wpdb->prepare( "DELETE FROM ".$table_name. " WHERE post_id = %d", $post_id) );
}

/***************************************************************/
// カスタムフィールドの取得（投稿ステータス判定無し）
/***************************************************************/
function engp_get_meta( $post_id ) {
	_log( 'engp_get_meta' );

	if ( ! is_numeric( $post_id ) ) return;
	global $wpdb;
	$table_name = $wpdb->prefix . CUSTOM_TBL_SCHOOL_META;
	$cost_table_name = $wpdb->prefix . CUSTOM_TBL_SCHOOL_COST;
	$post_table_name = $wpdb->prefix . TBL_SCHOOL_POSTS;

	$sql = "
		SELECT
			esm.*,
			esc.viewtype_yen,
			esc.admission_fee, esc.accommodation_placement_fee, esc.homestay, esc.dormitory_1, esc.dormitory_2, esc.dormitory_3, esc.dormitory_4, 
			esc.i20_issuance_postage, esc.airport_pickup_cost, esc.bank_charge,
			esc.course_name_pt,esc.course_name_ft,esc.course_name_cs3,esc.course_name_cs4,esc.course_name_cs5,esc.course_name_cs6,esc.course_name_cs7,
			esc.course_detail_pt,esc.course_detail_ft,esc.course_detail_cs3,esc.course_detail_cs4,esc.course_detail_cs5,esc.course_detail_cs6,esc.course_detail_cs7,			
			esc.tuition_4w_pt, esc.tuition_4w_ft, esc.tuition_4w_cs3, esc.tuition_4w_cs4, esc.tuition_4w_cs5, esc.tuition_4w_cs6, esc.tuition_4w_cs7, esc.textbooks_4w,
			esc.tuition_8w_pt, esc.tuition_8w_ft, esc.tuition_8w_cs3, esc.tuition_8w_cs4, esc.tuition_8w_cs5, esc.tuition_8w_cs6, esc.tuition_8w_cs7, esc.textbooks_8w,
			esc.tuition_12w_pt, esc.tuition_12w_ft, esc.tuition_12w_cs3, esc.tuition_12w_cs4, esc.tuition_12w_cs5, esc.tuition_12w_cs6, esc.tuition_12w_cs7, esc.textbooks_12w,
			esc.tuition_16w_pt, esc.tuition_16w_ft, esc.tuition_16w_cs3, esc.tuition_16w_cs4, esc.tuition_16w_cs5, esc.tuition_16w_cs6, esc.tuition_16w_cs7, esc.textbooks_16w,
			esc.tuition_24w_pt, esc.tuition_24w_ft, esc.tuition_24w_cs3, esc.tuition_24w_cs4, esc.tuition_24w_cs5, esc.tuition_24w_cs6, esc.tuition_24w_cs7, esc.textbooks_24w,
			esc.tuition_36w_pt, esc.tuition_36w_ft, esc.tuition_36w_cs3, esc.tuition_36w_cs4, esc.tuition_36w_cs5, esc.tuition_36w_cs6, esc.tuition_36w_cs7, esc.textbooks_36w,
			esc.tuition_48w_pt, esc.tuition_48w_ft, esc.tuition_48w_cs3, esc.tuition_48w_cs4, esc.tuition_48w_cs5, esc.tuition_48w_cs6, esc.tuition_48w_cs7, esc.textbooks_48w
		FROM {$table_name} AS esm
		INNER JOIN {$cost_table_name} AS esc ON esm.post_id = esc.post_id
	";
	$get_meta = $wpdb->get_results(
			$wpdb->prepare( $sql . " WHERE esm.post_id = %d", $post_id )
	);
	return isset( $get_meta[0] ) ? $get_meta[0] : null;
}

/***************************************************************/
/*                                                             */
// 記事タイトルに対する保存時の処理
/*                                                             */
/***************************************************************/
function replace_post_title( $title ) {
	global $post;
	if( $post && $post->post_type == 'school' ){
		$school_name	= isset( $_POST['school_name'] ) ? $_POST['school_name'] : null;	// '学校名',
		if( ! empty( $school_name ) ){
			return $school_name;
		}
	}
	return $title;
}
add_filter( 'title_save_pre', 'replace_post_title' );

/***************************************************************/
/*                                                             */
// 一覧に対する処理
/*                                                             */
/***************************************************************/
// カラムの追加
function engp_manage_events_columns( $columns ) {
	global $post_type;
	if( 'school' == $post_type ) {
		$new = array();
		foreach( $columns as $key => $val ) {
			$new[$key] = $val;
			if ( $key == 'title' ){
				$new['address'] = __('住所');
				$new['thumbnail'] = '';
			}
		}
		return $new;
	}
	return $columns;
}

// 追加カラムデータの表示
function engp_add_column( $column_name, $post_id ) {
	// サムネイル
	if ( 'thumbnail' == $column_name ) {
		$image_post_id = get_post_meta( $post_id, 'my_upload_images', true );
		if( ! empty( $image_post_id[0] ) ){
			$school_image = wp_get_attachment_image_src( $image_post_id[0], array( 64, 64 ) );
			$school_image_file = $school_image[0];
		}else{
			$school_image_file = esc_url( get_template_directory_uri() ) . "/images/nophoto_64x64.jpg";
		}
		echo '<img style="width:64px; height:64px;" src="' . $school_image_file . '" alt="Photo">';
		return;
	}
	// 学校名
	if ( 'school_name' == $column_name ) {
		$get_meta = engp_get_meta( $post_id );
		$school_name	= isset( $get_meta->school_name ) ? $get_meta->school_name : null;	// '学校名',
		echo $school_name;
	}
	// 住所
	if ( 'address' == $column_name ) {
		$get_meta = engp_get_meta( $post_id );
		$address = isset( $get_meta->address ) ? $get_meta->address : null;	// '住所'
		echo $address;
	}
}
add_filter( 'manage_posts_columns', 'engp_manage_events_columns' );
add_action( 'manage_posts_custom_column', 'engp_add_column', 10, 2 );

/***************************************************************/
/*                                                             */
// ユーザープロフィールの項目のカスタマイズ
/*                                                             */
/***************************************************************/
function engp_user_meta( $x )
{
	//項目の削除
	unset( $x['aim'] );
	unset( $x['jabber'] );
	unset( $x['yim'] );

	//項目の追加
	$x['last_name_kana']	= '姓（ふりがな）';
	$x['first_name_kana']	= '名（ふりがな）';
	$x['postal_code']		= '郵便番号';
	$x['prefectures']		= '都道府県';
	$x['address1']			= '住所';
	$x['address2']			= '住所（建物）';
	$x['phone_number']		= '電話番号';

	// お気に入り学校
	$x['favorite_school']	= 'お気に入り学校';

	// 申込情報
	$x['request_date ']		= '申込日時';
	$x['purpose']			= '留学目的';
	$x['plan_country']		= '希望国';
	$x['plan_city']			= '希望都市';
	$x['plan_school']		= '希望学校';
	$x['plan_start_date']	= '留学開始年月';
	$x['plan_period']		= '留学期間';
	$x['time_zone']			= '授業の時間帯';
	$x['accommodation']		= '滞在先手配';

	return $x;
}
add_filter( 'user_contactmethods', 'engp_user_meta', 10, 1 );

/*****************************************************
 ユーザー一覧に表示フィールドを追加する
*****************************************************/
add_action( 'manage_users_columns', 'manage_users_columns' );
add_action( 'manage_users_custom_column', 'custom_manage_users_custom_column', 10, 3 );
function manage_users_columns( $column_headers ) {
	$column_headers['address1'] = '住所';
	$column_headers['address2'] = '住所（建物）';
	return $column_headers;
}
function custom_manage_users_custom_column( $custom_column, $column_name, $user_id ) {

	$user_info = get_userdata( $user_id );

	${$column_name} = $user_info->$column_name;
	$custom_column = "\t".${$column_name}."\n";

	return $custom_column;
}

/***************************************************************/
// カスタムフィールドのお勧め検索(TOP画面)
/***************************************************************/
function engp_school_recommend() {
	_log( 'engp_school_recommend' );

	global $wpdb;
	$table_name      = $wpdb->prefix . CUSTOM_TBL_SCHOOL_META;
	$cost_table_name = $wpdb->prefix . CUSTOM_TBL_SCHOOL_COST;
	$post_table_name = $wpdb->prefix . TBL_SCHOOL_POSTS;
	$review_table_name = $wpdb->prefix . CUSTOM_TBL_SCHOOL_REVIEW;	

	$sql = "
		SELECT
			esm.*,
			CASE WHEN esc.tuition_so1_pt IS NULL THEN 0 WHEN esc.tuition_so1_pt = 0 THEN 0 ELSE 1 END AS so1_pt_offer,
			CASE WHEN esc.tuition_so1_ft IS NULL THEN 0 WHEN esc.tuition_so1_ft = 0 THEN 0 ELSE 1 END AS so1_ft_offer,
			CASE WHEN esc.tuition_so2_pt IS NULL THEN 0 WHEN esc.tuition_so2_pt = 0 THEN 0 ELSE 1 END AS so2_pt_offer,
			CASE WHEN esc.tuition_so2_ft IS NULL THEN 0 WHEN esc.tuition_so2_ft = 0 THEN 0 ELSE 1 END AS so2_ft_offer,
			CASE WHEN esc.tuition_so3_pt IS NULL THEN 0 WHEN esc.tuition_so3_pt = 0 THEN 0 ELSE 1 END AS so3_pt_offer,
			CASE WHEN esc.tuition_so3_ft IS NULL THEN 0 WHEN esc.tuition_so3_ft = 0 THEN 0 ELSE 1 END AS so3_ft_offer,
			CASE WHEN esc.tuition_so4_pt IS NULL THEN 0 WHEN esc.tuition_so4_pt = 0 THEN 0 ELSE 1 END AS so4_pt_offer,
			CASE WHEN esc.tuition_so4_ft IS NULL THEN 0 WHEN esc.tuition_so4_ft = 0 THEN 0 ELSE 1 END AS so4_ft_offer
		FROM {$table_name} AS esm
		INNER JOIN {$cost_table_name} AS esc ON esm.post_id = esc.post_id
		INNER JOIN {$post_table_name} AS wp ON esm.post_id = wp.id AND wp.post_status = 'publish'
		LEFT JOIN (SELECT post_id,COUNT(*) AS cnt FROM {$review_table_name} WHERE delete_flg != 1 AND approval_flg = 1 GROUP BY post_id) AS review 
		ON review.post_id = esm.post_id 
		LEFT JOIN (SELECT post_id,AVG(satisfaction_evaluation) AS avg FROM {$review_table_name} WHERE delete_flg != 1 AND approval_flg = 1 GROUP BY post_id) AS review_avg
		ON review_avg.post_id = esm.post_id
		WHERE review.cnt >= 5 
		ORDER BY review_avg.avg DESC,review.cnt DESC LIMIT 10
	";

	$get_meta = $wpdb->get_results( $sql );

	return isset( $get_meta ) ? $get_meta : null;
}

/***************************************************************/
// カスタムフィールドのお勧め検索(TOP画面/EPスコアランキング用)
/***************************************************************/
function engp_school_epscore() {
	_log( 'engp_school_epscore' );

	global $wpdb;
	$table_name      = $wpdb->prefix . CUSTOM_TBL_SCHOOL_META;
	$post_table_name = $wpdb->prefix . TBL_SCHOOL_POSTS;
	$review_table_name = $wpdb->prefix . CUSTOM_TBL_SCHOOL_REVIEW;
	
	$sql = "
	SELECT esm.*
	FROM {$table_name} AS esm
	INNER JOIN {$post_table_name} AS wp ON esm.post_id = wp.id AND wp.post_status = 'publish' 
	LEFT JOIN (SELECT post_id,COUNT(*) AS cnt FROM {$review_table_name} WHERE delete_flg != 1 AND approval_flg = 1 GROUP BY post_id) AS review 
	ON review.post_id = esm.post_id 
	WHERE esm.recommend = 1 
	ORDER BY esm.staff_evaluation DESC,review.cnt DESC LIMIT 10
	";
	
	$get_meta = $wpdb->get_results( $sql );
	
	return isset( $get_meta ) ? $get_meta : null;
	
	
}

/***************************************************************/
// カスタムフィールドの検索(検索結果画面)
/***************************************************************/
function engp_school_search( $search_columns, $ID ) {
	_log( 'engp_school_search' );

	global $wpdb;
	$table_name        = $wpdb->prefix . CUSTOM_TBL_SCHOOL_META;
	$cost_table_name   = $wpdb->prefix . CUSTOM_TBL_SCHOOL_COST;
	$post_table_name   = $wpdb->prefix . TBL_SCHOOL_POSTS;
	$fav_table_name    = $wpdb->prefix . CUSTOM_TBL_FAVORITE;
	$review_table_name = $wpdb->prefix . CUSTOM_TBL_SCHOOL_REVIEW;

	//検索結果件数取得用SQL
	$count_sql = "
		SELECT COUNT(*) AS CNT
		FROM {$table_name} AS esm
		INNER JOIN {$cost_table_name} AS esc ON esm.post_id = esc.post_id
		INNER JOIN {$post_table_name} AS wp ON esm.post_id = wp.id AND wp.post_status = 'publish'
	";

	//検索結果データ取得用SQL(10件)
	$sql = "
		SELECT
			esm.*,
			esc.viewtype_yen,
			esc.tuition_4w_pt, esc.tuition_4w_ft,
			CASE WHEN esc.tuition_so1_pt IS NULL THEN 0 WHEN esc.tuition_so1_pt = 0 THEN 0 ELSE 1 END AS so1_pt_offer,
			CASE WHEN esc.tuition_so1_ft IS NULL THEN 0 WHEN esc.tuition_so1_ft = 0 THEN 0 ELSE 1 END AS so1_ft_offer,
			CASE WHEN esc.tuition_so2_pt IS NULL THEN 0 WHEN esc.tuition_so2_pt = 0 THEN 0 ELSE 1 END AS so2_pt_offer,
			CASE WHEN esc.tuition_so2_ft IS NULL THEN 0 WHEN esc.tuition_so2_ft = 0 THEN 0 ELSE 1 END AS so2_ft_offer,
			CASE WHEN esc.tuition_so3_pt IS NULL THEN 0 WHEN esc.tuition_so3_pt = 0 THEN 0 ELSE 1 END AS so3_pt_offer,
			CASE WHEN esc.tuition_so3_ft IS NULL THEN 0 WHEN esc.tuition_so3_ft = 0 THEN 0 ELSE 1 END AS so3_ft_offer,
			CASE WHEN esc.tuition_so4_pt IS NULL THEN 0 WHEN esc.tuition_so4_pt = 0 THEN 0 ELSE 1 END AS so4_pt_offer,
			CASE WHEN esc.tuition_so4_ft IS NULL THEN 0 WHEN esc.tuition_so4_ft = 0 THEN 0 ELSE 1 END AS so4_ft_offer,
			CASE WHEN fav.post_id IS NULL THEN 0 ELSE 1 END AS favorite,
			(SELECT COUNT(*) FROM {$review_table_name} WHERE post_id = esm.post_id AND approval_flg = 1 AND delete_flg != 1 ) AS review_count,
			(SELECT AVG(satisfaction_evaluation) FROM {$review_table_name} WHERE post_id = esm.post_id AND approval_flg = 1 AND delete_flg != 1 ) AS satisfaction
		FROM {$table_name} AS esm
		INNER JOIN {$cost_table_name} AS esc ON esm.post_id = esc.post_id
		INNER JOIN {$post_table_name} AS wp ON esm.post_id = wp.id AND wp.post_status = 'publish'
		LEFT JOIN {$fav_table_name} AS fav ON esm.post_id = fav.post_id AND fav.user_id = {$ID}
	";

	// 検索条件句生成
	$search_sql = engp_create_search_sql( $search_columns );
	$start      = ( $search_columns['page'] - 1 ) * 10;

	// ソート条件生成
	$order_sql = "";
	if($search_columns['sort'] == null){
//		$order_sql       .= " ORDER BY esm.recommend DESC, ";
		$order_sql       .= " ORDER BY review_count DESC, ";
	}else if($search_columns['sort'] == "cost"){
		$order_sql       .= " ORDER BY ";
	}else if($search_columns['sort'] == "review"){
		$order_sql       .= " ORDER BY review_count DESC, ";
	}else if($search_columns['sort'] == "satisfaction"){
		$order_sql       .= " ORDER BY satisfaction DESC, ";
	}
	$order_sql       .= " esc.tuition_4w_pt IS NULL ASC, esc.tuition_4w_pt, esc.tuition_4w_ft IS NULL ASC,esc.tuition_4w_ft ";

	// 各SQL生成
	$count_sql .= $search_sql;
	$sql       .= $search_sql . $order_sql. " LIMIT 10 OFFSET " . $start;


	//件数取得
	$get_count = $wpdb->get_results( $count_sql );
	//表示用データ10件取得
	$get_meta = $wpdb->get_results( $sql );

	$count_data        = $get_count[0];
	$get_meta['count'] = $count_data->CNT;

	return isset( $get_meta ) ? $get_meta : null;
}

/***************************************************************/
// 検索結果画面用Where句生成
/***************************************************************/
function engp_create_search_sql( $params ) {
	_log( 'engp_create_search_sql' );

	$strWhere = "";

	//検索条件作成
	if ( $params ) {
		// 国
		if ( $params['country'] ){
			$search_datas[] = "esm.country = " . $params['country'];
		}
		// 地図地域
		if ( $params['division'] ){
			$search_datas[] = "esm.division = " . $params['division'];
		}
		// 目的
		if ( $params['purpose'] ){
			$search_datas[] = "esm.purpose" . $params['purpose']." = 1";
		}
		// 学校名
		if ( $params['school_name'] ){
			if(strstr($params['school_name'],'　') || strstr($params['school_name'],' ')){
				$school_name = mb_convert_kana($params['school_name'],'s');
				$school_name = preg_split('/[\s]+/', $school_name, -1, PREG_SPLIT_NO_EMPTY);
				foreach ($school_name as $key){
					$search_datas[] = "(esm.school_name LIKE '%" . $key . "%' OR esm.school_jp_name LIKE '%" . $key . "%')";
				}
			}else{
				$search_datas[] = "(esm.school_name LIKE '%" . $params['school_name'] . "%' OR esm.school_jp_name LIKE '%" . $params['school_name'] . "%')";
			}
		}
		// 学費
		if ( $params['fee'] ) {
			switch ( $params['fee'] ) {
				case 1:
// 					// $500未満
// 					$search_datas[] = "(esc.tuition_4w_ft < 500 AND esc.viewtype_yen = 0)";
					// $700未満
					$search_datas[] = "(esc.tuition_4w_pt < 700 AND esc.viewtype_yen = 0)";

					break;
				case 2:
// 					// $500以上～$1,000未満
// 					$search_datas[] = "((esc.tuition_4w_ft >= 500 AND esc.tuition_4w_ft < 1000) AND esc.viewtype_yen = 0)";
					// $700以上～$1,200未満
					$search_datas[] = "((esc.tuition_4w_pt >= 700 AND esc.tuition_4w_pt < 1200) AND esc.viewtype_yen = 0)";

					break;
				case 3:
					// $1,000以上
// 					$search_datas[] = "(esc.tuition_4w_ft >= 1000 AND esc.viewtype_yen = 0)";
					// $1,200以上
					$search_datas[] = "(esc.tuition_4w_pt >= 1200 AND esc.viewtype_yen = 0)";

					break;
			}
		}
		// コース（スペシャルオファー含む）
		if ( $params['course'] || $params['sp_offer'] ) {
			foreach ( $params['course'] as $val ) {
				$search_course[] = "esm.target_" . $val . ' != ""';
			}
			if ( $params['sp_offer'] ) {
				$search_course[] = "
									(esc.tuition_so1_pt >= 1 OR esc.tuition_so2_pt >= 1 OR esc.tuition_so3_pt >= 1 OR esc.tuition_so4_pt >= 1 OR
									esc.tuition_so1_ft >= 1 OR esc.tuition_so2_ft >= 1 OR esc.tuition_so3_ft >= 1 OR esc.tuition_so4_ft >= 1)
				";
			}
			foreach ( $search_course as $val ) {
				if ( ! $course_sql ) {
					$course_sql = $val;
				} else {
					$course_sql .= " OR " . $val;
				}
			}
			$search_datas[] = "(" . $course_sql . ")";
		}
		// 場所
		if ( $params['location'] ) {
			foreach ( $params['location'] as $val ) {
				if(!$location_sql){
					$location_sql = $val;
				}else{
					$location_sql .= "," . $val;
				}
			}
			$search_datas[] = "esm.location IN (" . $location_sql . ")";
		}
		// 交通手段
		if ( $params['how_to_go'] ) {
			$how_to_go_sql_temp = array();
			foreach ( $params['how_to_go'] as $val ) {
				if( $val == 1 ){
					// 交通手段：バスを含む
					array_push( $how_to_go_sql_temp, 1, 4, 5, 7 );
				} elseif( $val == 2 ){
					// 交通手段：車を含む
					array_push( $how_to_go_sql_temp, 2, 4, 6, 7 );
				} elseif( $val == 3 ){
					// 交通手段：電車を含む
					array_push( $how_to_go_sql_temp, 3, 5, 6, 7 );
				}
			}

			foreach ( array_unique( $how_to_go_sql_temp, SORT_NUMERIC ) as $val ) {
				if ( ! $how_to_go_sql ) {
					$how_to_go_sql = $val;
				} else {
					$how_to_go_sql .= ",".$val;
				}
			}
			$search_datas[] = "esm.how_to_go IN (" . $how_to_go_sql . ")";
		}
		// オンキャンパス
		if ( $params['location_type'] ) {
			$search_datas[] = "esm.location_type = 1";
		}
		// 治安
		if ( $params['security'] ) {
			$search_datas[] = "esm.security IN (4,5) ";
		}
		// 国籍バランス
		if ( $params[nationality] ) {
			$search_datas[] = "esm.nationality = 1";
		}
		// 現地スタッフ
		if ( $params['local_staff'] ) {
			$search_datas[] = "esm.local_staff = 1";
		}
		// 設備
		if ( $params['facilities'] ) {
			foreach ( $params['facilities'] as $val ) {
				$search_facilities[] = 'esm.facilities LIKE "%%' . $val . '%%"';
			}
			foreach ( $search_facilities as $val ) {
				if ( ! $facilities_sql ) {
					$facilities_sql = $val;
				} else {
					$facilities_sql .= " AND " . $val;
				}
			}
			$search_datas[] = "(" . $facilities_sql . ")";
		}
	}

	if ( $search_datas ) {
		$strWhere .= " WHERE " . $search_datas[0];
		unset( $search_datas[0] );
		foreach ( $search_datas as $val ) {
			$strWhere .= " AND " . $val;
		}
	}

	return $strWhere;

}

/***************************************************************/
// カスタムフィールドの検索(学校詳細画面)
/***************************************************************/
function engp_school_detail( $post_id ) {
	_log('engp_school_detail');

	global $wpdb;
	$table_name      = $wpdb->prefix . CUSTOM_TBL_SCHOOL_META;
	$cost_table_name = $wpdb->prefix . CUSTOM_TBL_SCHOOL_COST;
	$post_table_name = $wpdb->prefix . TBL_SCHOOL_POSTS;

// 	$sql = "
// 	SELECT
// 	esm.*,
// 	esc.viewtype_yen,
// 	esc.admission_fee, esc.accommodation_placement_fee, esc.homestay, esc.dormitory_1, esc.dormitory_2, esc.dormitory_3, esc.dormitory_4,
// 	esc.i20_issuance_postage, esc.airport_pickup_cost, esc.bank_charge,
// 	esc.tuition_2w_pt, esc.tuition_2w_ft, esc.homestay_cost_2w, esc.textbooks_2w,
// 	esc.tuition_4w_pt, esc.tuition_4w_ft, esc.homestay_cost_4w, esc.textbooks_4w,
// 	esc.tuition_8w_pt, esc.tuition_8w_ft, esc.homestay_cost_8w, esc.textbooks_8w,
// 	esc.tuition_12w_pt, esc.tuition_12w_ft, esc.homestay_cost_12w, esc.textbooks_12w,
// 	esc.tuition_16w_pt, esc.tuition_16w_ft, esc.homestay_cost_16w, esc.textbooks_16w,
// 	esc.tuition_24w_pt, esc.tuition_24w_ft, esc.homestay_cost_24w, esc.textbooks_24w,
// 	esc.tuition_36w_pt, esc.tuition_36w_ft, esc.homestay_cost_36w, esc.textbooks_36w,
// 	esc.tuition_48w_pt, esc.tuition_48w_ft, esc.homestay_cost_48w, esc.textbooks_48w,
// 	esc.tuition_so1_pt, esc.tuition_so1_ft, esc.homestay_cost_so1, esc.textbooks_so1,
// 	esc.tuition_so2_pt, esc.tuition_so2_ft, esc.homestay_cost_so2, esc.textbooks_so2,
// 	esc.tuition_so3_pt, esc.tuition_so3_ft, esc.homestay_cost_so3, esc.textbooks_so3,
// 	esc.tuition_so4_pt, esc.tuition_so4_ft, esc.homestay_cost_so4, esc.textbooks_so4,
// 	CASE WHEN esc.tuition_so1_pt IS NULL THEN 0 WHEN esc.tuition_so1_pt = 0 THEN 0 ELSE 1 END AS so1_pt_offer,
// 	CASE WHEN esc.tuition_so1_ft IS NULL THEN 0 WHEN esc.tuition_so1_ft = 0 THEN 0 ELSE 1 END AS so1_ft_offer,
// 	CASE WHEN esc.tuition_so2_pt IS NULL THEN 0 WHEN esc.tuition_so2_pt = 0 THEN 0 ELSE 1 END AS so2_pt_offer,
// 	CASE WHEN esc.tuition_so2_ft IS NULL THEN 0 WHEN esc.tuition_so2_ft = 0 THEN 0 ELSE 1 END AS so2_ft_offer,
// 	CASE WHEN esc.tuition_so3_pt IS NULL THEN 0 WHEN esc.tuition_so3_pt = 0 THEN 0 ELSE 1 END AS so3_pt_offer,
// 	CASE WHEN esc.tuition_so3_ft IS NULL THEN 0 WHEN esc.tuition_so3_ft = 0 THEN 0 ELSE 1 END AS so3_ft_offer,
// 	CASE WHEN esc.tuition_so4_pt IS NULL THEN 0 WHEN esc.tuition_so4_pt = 0 THEN 0 ELSE 1 END AS so4_pt_offer,
// 	CASE WHEN esc.tuition_so4_ft IS NULL THEN 0 WHEN esc.tuition_so4_ft = 0 THEN 0 ELSE 1 END AS so4_ft_offer
// 	FROM {$table_name} AS esm
// 	INNER JOIN {$cost_table_name} AS esc ON esm.post_id = esc.post_id
// 	INNER JOIN {$post_table_name} AS wp ON esm.post_id = wp.id AND wp.post_status = 'publish'
// 	WHERE esm.post_id = %d
// 	";	
	
	$sql = "
		SELECT
			esm.*,
			esc.viewtype_yen,
			esc.admission_fee, esc.accommodation_placement_fee, esc.homestay, esc.dormitory_1, esc.dormitory_2, esc.dormitory_3, esc.dormitory_4,  
			esc.i20_issuance_postage, esc.airport_pickup_cost, esc.bank_charge,
			esc.course_name_pt,esc.course_name_ft,esc.course_name_cs3, esc.course_name_cs4, esc.course_name_cs5, esc.course_name_cs6, esc.course_name_cs7,
			esc.course_detail_pt,esc.course_detail_ft,esc.course_detail_cs3, esc.course_detail_cs4, esc.course_detail_cs5, esc.course_detail_cs6, esc.course_detail_cs7,			
			esc.tuition_4w_pt, esc.tuition_4w_ft, esc.tuition_4w_cs3, esc.tuition_4w_cs4, esc.tuition_4w_cs5, esc.tuition_4w_cs6, esc.tuition_4w_cs7, esc.textbooks_4w,
			esc.tuition_8w_pt, esc.tuition_8w_ft, esc.tuition_8w_cs3, esc.tuition_8w_cs4, esc.tuition_8w_cs5, esc.tuition_8w_cs6, esc.tuition_8w_cs7, esc.textbooks_8w,
			esc.tuition_12w_pt, esc.tuition_12w_ft, esc.tuition_12w_cs3, esc.tuition_12w_cs4, esc.tuition_12w_cs5, esc.tuition_12w_cs6, esc.tuition_12w_cs7, esc.textbooks_12w,			
			esc.tuition_16w_pt, esc.tuition_16w_ft, esc.tuition_16w_cs3, esc.tuition_16w_cs4, esc.tuition_16w_cs5, esc.tuition_16w_cs6, esc.tuition_16w_cs7, esc.textbooks_16w,						
			esc.tuition_24w_pt, esc.tuition_24w_ft, esc.tuition_24w_cs3, esc.tuition_24w_cs4, esc.tuition_24w_cs5, esc.tuition_24w_cs6, esc.tuition_24w_cs7, esc.textbooks_24w,						
			esc.tuition_36w_pt, esc.tuition_36w_ft, esc.tuition_36w_cs3, esc.tuition_36w_cs4, esc.tuition_36w_cs5, esc.tuition_36w_cs6, esc.tuition_36w_cs7, esc.textbooks_36w,						
			esc.tuition_48w_pt, esc.tuition_48w_ft, esc.tuition_48w_cs3, esc.tuition_48w_cs4, esc.tuition_48w_cs5, esc.tuition_48w_cs6, esc.tuition_48w_cs7, esc.textbooks_48w			
		FROM {$table_name} AS esm
		INNER JOIN {$cost_table_name} AS esc ON esm.post_id = esc.post_id
		INNER JOIN {$post_table_name} AS wp ON esm.post_id = wp.id AND wp.post_status = 'publish'
		WHERE esm.post_id = %d
	";

	$get_meta = $wpdb->get_results(
			$wpdb->prepare( $sql, $post_id )
	);

	return isset( $get_meta[0] ) ? $get_meta[0] : null;

}

/***************************************************************/
// カスタムフィールドの検索(比較結果画面)
/***************************************************************/
function engp_school_compare( $param,$ID ) {
	_log( 'engp_school_compare' );

	global $wpdb;
	$table_name      = $wpdb->prefix . CUSTOM_TBL_SCHOOL_META;
	$cost_table_name = $wpdb->prefix . CUSTOM_TBL_SCHOOL_COST;
	$post_table_name = $wpdb->prefix . TBL_SCHOOL_POSTS;
	$fav_table_name = $wpdb->prefix . CUSTOM_TBL_FAVORITE;

	// パラメータを分解
	$cmp_id    = $param['compareId'];
	$sort_week = $param['week'];
	$sort_dir  = $param['dir'];

	// ソート基準設定
	$order = " ORDER BY esm.post_id ASC ";
	// ソート用追加SQL設定
	$sqladd = "";
	if ( ! empty( $sort_week ) && ! empty( $sort_dir ) ) {
		if ( $sort_dir == "desc" ){
// 			$sqladd = ",CASE WHEN IFNULL(esc.tuition_{$sort_week}_ft, -99999999) >= IFNULL(esc.tuition_{$sort_week}_pt, -99999999)
// 					    THEN IFNULL(esc.tuition_{$sort_week}_ft, -99999999)
// 					    ELSE IFNULL(esc.tuition_{$sort_week}_pt, -99999999) END AS order_tuition ";
			$sqladd = ",IFNULL(esc.tuition_{$sort_week}_pt, -99999999) AS order_tuition ";

			$order  = " ORDER BY order_tuition DESC ";
		} else {
// 			$sqladd = ",CASE WHEN IFNULL(esc.tuition_{$sort_week}_pt, 99999999) <= IFNULL(esc.tuition_{$sort_week}_ft, 99999999)
// 					    THEN IFNULL(esc.tuition_{$sort_week}_pt, 99999999)
// 					    ELSE IFNULL(esc.tuition_{$sort_week}_ft, 99999999) END AS order_tuition ";
			$sqladd = ",IFNULL(esc.tuition_{$sort_week}_pt, 99999999) AS order_tuition ";
			
			$order  = " ORDER BY order_tuition ASC ";
		}
	}

	// SQL設定
	$sql = "
		SELECT
			esm.*,
			esc.viewtype_yen,
			esc.admission_fee, esc.accommodation_placement_fee, esc.i20_issuance_postage, esc.airport_pickup_cost, esc.bank_charge,esc.course_name_pt,
			esc.tuition_4w_pt, esc.tuition_4w_ft, esc.homestay_cost_4w, esc.textbooks_4w,
			esc.tuition_12w_pt, esc.tuition_12w_ft, esc.homestay_cost_12w, esc.textbooks_12w,
			esc.tuition_24w_pt, esc.tuition_24w_ft, esc.homestay_cost_24w, esc.textbooks_24w,
			esc.tuition_48w_pt, esc.tuition_48w_ft, esc.homestay_cost_48w, esc.textbooks_48w,
			CASE WHEN fav.post_id IS NULL THEN 0 ELSE 1 END AS favorite
			{$sqladd}
		FROM {$table_name} AS esm
		INNER JOIN {$cost_table_name} AS esc ON esm.post_id = esc.post_id
		INNER JOIN {$post_table_name} AS wp ON esm.post_id = wp.id AND wp.post_status = 'publish'
		LEFT JOIN {$fav_table_name} AS fav ON esm.post_id = fav.post_id AND fav.user_id = {$ID}
	";
			
// 			$sql = "
// 			SELECT
// 			esm.*,
// 			esc.viewtype_yen,
// 			esc.admission_fee, esc.accommodation_placement_fee, esc.i20_issuance_postage, esc.airport_pickup_cost, esc.bank_charge,
// 			esc.tuition_4w_pt, esc.tuition_4w_ft, esc.homestay_cost_4w, esc.textbooks_4w,
// 			esc.tuition_12w_pt, esc.tuition_12w_ft, esc.homestay_cost_12w, esc.textbooks_12w,
// 			esc.tuition_24w_pt, esc.tuition_24w_ft, esc.homestay_cost_24w, esc.textbooks_24w,
// 			esc.tuition_48w_pt, esc.tuition_48w_ft, esc.homestay_cost_48w, esc.textbooks_48w,
// 			CASE WHEN esc.tuition_so1_pt IS NULL THEN 0 WHEN esc.tuition_so1_pt = 0 THEN 0 ELSE 1 END AS so1_pt_offer,
// 			CASE WHEN esc.tuition_so1_ft IS NULL THEN 0 WHEN esc.tuition_so1_ft = 0 THEN 0 ELSE 1 END AS so1_ft_offer,
// 			CASE WHEN esc.tuition_so2_pt IS NULL THEN 0 WHEN esc.tuition_so2_pt = 0 THEN 0 ELSE 1 END AS so2_pt_offer,
// 			CASE WHEN esc.tuition_so2_ft IS NULL THEN 0 WHEN esc.tuition_so2_ft = 0 THEN 0 ELSE 1 END AS so2_ft_offer,
// 			CASE WHEN esc.tuition_so3_pt IS NULL THEN 0 WHEN esc.tuition_so3_pt = 0 THEN 0 ELSE 1 END AS so3_pt_offer,
// 			CASE WHEN esc.tuition_so3_ft IS NULL THEN 0 WHEN esc.tuition_so3_ft = 0 THEN 0 ELSE 1 END AS so3_ft_offer,
// 			CASE WHEN esc.tuition_so4_pt IS NULL THEN 0 WHEN esc.tuition_so4_pt = 0 THEN 0 ELSE 1 END AS so4_pt_offer,
// 			CASE WHEN esc.tuition_so4_ft IS NULL THEN 0 WHEN esc.tuition_so4_ft = 0 THEN 0 ELSE 1 END AS so4_ft_offer,
// 			CASE WHEN fav.post_id IS NULL THEN 0 ELSE 1 END AS favorite
// 			{$sqladd}
// 			FROM {$table_name} AS esm
// 			INNER JOIN {$cost_table_name} AS esc ON esm.post_id = esc.post_id
// 			INNER JOIN {$post_table_name} AS wp ON esm.post_id = wp.id AND wp.post_status = 'publish'
// 			LEFT JOIN {$fav_table_name} AS fav ON esm.post_id = fav.post_id AND fav.user_id = {$ID}
// 			";				

	$post_ids = explode( "_", $cmp_id );
	foreach ( $post_ids as $key => $value ) {
		$search_ids .= " %d,";
	}
	$search_ids = substr( $search_ids, 0, -1 );

	if($search_ids){
		$sql .= " WHERE";
		$sql .= " esm.post_id IN (" . $search_ids . ")";
	}

	$sql .= $order;

	$get_meta = $wpdb->get_results(
			$wpdb->prepare( $sql, $post_ids )
	);
	return isset( $get_meta ) ? $get_meta : null;
}

/***************************************************************/
// カスタムフィールドの検索(見積もり画面)
/***************************************************************/
function engp_school_estimate( $param ) {
	_log( 'engp_school_estimate' );

	global $wpdb;
	$table_name      = $wpdb->prefix . CUSTOM_TBL_SCHOOL_META;
	$cost_table_name = $wpdb->prefix . CUSTOM_TBL_SCHOOL_COST;
	$post_table_name = $wpdb->prefix . TBL_SCHOOL_POSTS;

	if ( empty( $param['period'] ) ) {
		// パラメータがない場合は最初に存在する期間を取得
		$colum_param = engp_get_default_param( $param['estId'] );
// 	} elseif ( strstr( $param['period'], "so" ) ) {
// 		$colum_param = $param['period'];
	} else {
		$colum_param = $param['period'] . "w";
	}
	
	if ( empty( $param['course'] ) ) {
		// パラメータがない場合はpt(コース1)
		$course = "pt";
	} else {
		$course = $param['course'];
	}	

	$sql = "
		SELECT
			esm.post_id,
			esm.school_name,
			esm.school_jp_name,
			esc.viewtype_yen,
			esc.admission_fee,
			esc.accommodation_placement_fee,
			esc.homestay, 
			esc.dormitory_1,
			esc.dormitory_2, 
			esc.dormitory_3, 
			esc.dormitory_4,  
			esc.i20_issuance_postage,
			esc.airport_pickup_cost,
			esc.bank_charge,
			esc.course_name_{$course} AS course_name,			
			esc.course_name_pt AS name_pt,
			esc.course_name_ft AS name_ft,
			esc.course_name_cs3 AS name_cs3,	
			esc.course_name_cs4 AS name_cs4,
			esc.course_name_cs5 AS name_cs5,	
			esc.course_name_cs6 AS name_cs6,	
			esc.course_name_cs7 AS name_cs7,																						
			esc.tuition_{$colum_param}_{$course} AS tuition,
			esc.homestay_cost_{$colum_param} AS homestay_cost,
			esc.textbooks_{$colum_param} AS textbooks,
			CASE WHEN esc.tuition_4w_pt IS NULL THEN 0 WHEN esc.tuition_4w_pt = 0 THEN 0 ELSE 1 END AS 4w_pt,
			CASE WHEN esc.tuition_4w_ft IS NULL THEN 0 WHEN esc.tuition_4w_ft = 0 THEN 0 ELSE 1 END AS 4w_ft,
			CASE WHEN esc.tuition_4w_cs3 IS NULL THEN 0 WHEN esc.tuition_4w_cs3 = 0 THEN 0 ELSE 1 END AS 4w_cs3,
			CASE WHEN esc.tuition_4w_cs4 IS NULL THEN 0 WHEN esc.tuition_4w_cs4 = 0 THEN 0 ELSE 1 END AS 4w_cs4,			
			CASE WHEN esc.tuition_4w_cs5 IS NULL THEN 0 WHEN esc.tuition_4w_cs5 = 0 THEN 0 ELSE 1 END AS 4w_cs5,
			CASE WHEN esc.tuition_4w_cs6 IS NULL THEN 0 WHEN esc.tuition_4w_cs6 = 0 THEN 0 ELSE 1 END AS 4w_cs6,
			CASE WHEN esc.tuition_4w_cs7 IS NULL THEN 0 WHEN esc.tuition_4w_cs7 = 0 THEN 0 ELSE 1 END AS 4w_cs7,
			CASE WHEN esc.tuition_8w_pt IS NULL THEN 0 WHEN esc.tuition_8w_pt = 0 THEN 0 ELSE 1 END AS 8w_pt,
			CASE WHEN esc.tuition_8w_ft IS NULL THEN 0 WHEN esc.tuition_8w_ft = 0 THEN 0 ELSE 1 END AS 8w_ft,
			CASE WHEN esc.tuition_8w_cs3 IS NULL THEN 0 WHEN esc.tuition_8w_cs3 = 0 THEN 0 ELSE 1 END AS 8w_cs3,
			CASE WHEN esc.tuition_8w_cs4 IS NULL THEN 0 WHEN esc.tuition_8w_cs4 = 0 THEN 0 ELSE 1 END AS 8w_cs4,			
			CASE WHEN esc.tuition_8w_cs5 IS NULL THEN 0 WHEN esc.tuition_8w_cs5 = 0 THEN 0 ELSE 1 END AS 8w_cs5,
			CASE WHEN esc.tuition_8w_cs6 IS NULL THEN 0 WHEN esc.tuition_8w_cs6 = 0 THEN 0 ELSE 1 END AS 8w_cs6,
			CASE WHEN esc.tuition_8w_cs7 IS NULL THEN 0 WHEN esc.tuition_8w_cs7 = 0 THEN 0 ELSE 1 END AS 8w_cs7,
			CASE WHEN esc.tuition_12w_pt IS NULL THEN 0 WHEN esc.tuition_12w_pt = 0 THEN 0 ELSE 1 END AS 12w_pt,
			CASE WHEN esc.tuition_12w_ft IS NULL THEN 0 WHEN esc.tuition_12w_ft = 0 THEN 0 ELSE 1 END AS 12w_ft,
			CASE WHEN esc.tuition_12w_cs3 IS NULL THEN 0 WHEN esc.tuition_12w_cs3 = 0 THEN 0 ELSE 1 END AS 12w_cs3,
			CASE WHEN esc.tuition_12w_cs4 IS NULL THEN 0 WHEN esc.tuition_12w_cs4 = 0 THEN 0 ELSE 1 END AS 12w_cs4,			
			CASE WHEN esc.tuition_12w_cs5 IS NULL THEN 0 WHEN esc.tuition_12w_cs5 = 0 THEN 0 ELSE 1 END AS 12w_cs5,
			CASE WHEN esc.tuition_12w_cs6 IS NULL THEN 0 WHEN esc.tuition_12w_cs6 = 0 THEN 0 ELSE 1 END AS 12w_cs6,
			CASE WHEN esc.tuition_12w_cs7 IS NULL THEN 0 WHEN esc.tuition_12w_cs7 = 0 THEN 0 ELSE 1 END AS 12w_cs7,
			CASE WHEN esc.tuition_16w_pt IS NULL THEN 0 WHEN esc.tuition_16w_pt = 0 THEN 0 ELSE 1 END AS 16w_pt,
			CASE WHEN esc.tuition_16w_ft IS NULL THEN 0 WHEN esc.tuition_16w_ft = 0 THEN 0 ELSE 1 END AS 16w_ft,
			CASE WHEN esc.tuition_16w_cs3 IS NULL THEN 0 WHEN esc.tuition_16w_cs3 = 0 THEN 0 ELSE 1 END AS 16w_cs3,
			CASE WHEN esc.tuition_16w_cs4 IS NULL THEN 0 WHEN esc.tuition_16w_cs4 = 0 THEN 0 ELSE 1 END AS 16w_cs4,			
			CASE WHEN esc.tuition_16w_cs5 IS NULL THEN 0 WHEN esc.tuition_16w_cs5 = 0 THEN 0 ELSE 1 END AS 16w_cs5,
			CASE WHEN esc.tuition_16w_cs6 IS NULL THEN 0 WHEN esc.tuition_16w_cs6 = 0 THEN 0 ELSE 1 END AS 16w_cs6,
			CASE WHEN esc.tuition_16w_cs7 IS NULL THEN 0 WHEN esc.tuition_16w_cs7 = 0 THEN 0 ELSE 1 END AS 16w_cs7,
			CASE WHEN esc.tuition_24w_pt IS NULL THEN 0 WHEN esc.tuition_24w_pt = 0 THEN 0 ELSE 1 END AS 24w_pt,
			CASE WHEN esc.tuition_24w_ft IS NULL THEN 0 WHEN esc.tuition_24w_ft = 0 THEN 0 ELSE 1 END AS 24w_ft,
			CASE WHEN esc.tuition_24w_cs3 IS NULL THEN 0 WHEN esc.tuition_24w_cs3 = 0 THEN 0 ELSE 1 END AS 24w_cs3,
			CASE WHEN esc.tuition_24w_cs4 IS NULL THEN 0 WHEN esc.tuition_24w_cs4 = 0 THEN 0 ELSE 1 END AS 24w_cs4,			
			CASE WHEN esc.tuition_24w_cs5 IS NULL THEN 0 WHEN esc.tuition_24w_cs5 = 0 THEN 0 ELSE 1 END AS 24w_cs5,
			CASE WHEN esc.tuition_24w_cs6 IS NULL THEN 0 WHEN esc.tuition_24w_cs6 = 0 THEN 0 ELSE 1 END AS 24w_cs6,
			CASE WHEN esc.tuition_24w_cs7 IS NULL THEN 0 WHEN esc.tuition_24w_cs7 = 0 THEN 0 ELSE 1 END AS 24w_cs7,
			CASE WHEN esc.tuition_36w_pt IS NULL THEN 0 WHEN esc.tuition_36w_pt = 0 THEN 0 ELSE 1 END AS 36w_pt,
			CASE WHEN esc.tuition_36w_ft IS NULL THEN 0 WHEN esc.tuition_36w_ft = 0 THEN 0 ELSE 1 END AS 36w_ft,
			CASE WHEN esc.tuition_36w_cs3 IS NULL THEN 0 WHEN esc.tuition_36w_cs3 = 0 THEN 0 ELSE 1 END AS 36w_cs3,
			CASE WHEN esc.tuition_36w_cs4 IS NULL THEN 0 WHEN esc.tuition_36w_cs4 = 0 THEN 0 ELSE 1 END AS 36w_cs4,			
			CASE WHEN esc.tuition_36w_cs5 IS NULL THEN 0 WHEN esc.tuition_36w_cs5 = 0 THEN 0 ELSE 1 END AS 36w_cs5,
			CASE WHEN esc.tuition_36w_cs6 IS NULL THEN 0 WHEN esc.tuition_36w_cs6 = 0 THEN 0 ELSE 1 END AS 36w_cs6,
			CASE WHEN esc.tuition_36w_cs7 IS NULL THEN 0 WHEN esc.tuition_36w_cs7 = 0 THEN 0 ELSE 1 END AS 36w_cs7,
			CASE WHEN esc.tuition_48w_pt IS NULL THEN 0 WHEN esc.tuition_48w_pt = 0 THEN 0 ELSE 1 END AS 48w_pt,
			CASE WHEN esc.tuition_48w_ft IS NULL THEN 0 WHEN esc.tuition_48w_ft = 0 THEN 0 ELSE 1 END AS 48w_ft,
			CASE WHEN esc.tuition_48w_cs3 IS NULL THEN 0 WHEN esc.tuition_48w_cs3 = 0 THEN 0 ELSE 1 END AS 48w_cs3,
			CASE WHEN esc.tuition_48w_cs4 IS NULL THEN 0 WHEN esc.tuition_48w_cs4 = 0 THEN 0 ELSE 1 END AS 48w_cs4,			
			CASE WHEN esc.tuition_48w_cs5 IS NULL THEN 0 WHEN esc.tuition_48w_cs5 = 0 THEN 0 ELSE 1 END AS 48w_cs5,
			CASE WHEN esc.tuition_48w_cs6 IS NULL THEN 0 WHEN esc.tuition_48w_cs6 = 0 THEN 0 ELSE 1 END AS 48w_cs6,
			CASE WHEN esc.tuition_48w_cs7 IS NULL THEN 0 WHEN esc.tuition_48w_cs7 = 0 THEN 0 ELSE 1 END AS 48w_cs7
		FROM {$table_name} AS esm
		INNER JOIN {$cost_table_name} AS esc ON esm.post_id = esc.post_id
		INNER JOIN {$post_table_name} AS wp ON esm.post_id = wp.id AND wp.post_status = 'publish'
		WHERE
			esm.post_id = %d
	";
	

// 	$sql = "
// 	SELECT
// 	esm.post_id,
// 	esm.school_name,
// 	esm.school_jp_name,
// 	esc.viewtype_yen,
// 	esc.admission_fee,
// 	esc.accommodation_placement_fee,
// 	esc.homestay,
// 	esc.dormitory_1,
// 	esc.dormitory_2,
// 	esc.dormitory_3,
// 	esc.dormitory_4,
// 	esc.i20_issuance_postage,
// 	esc.airport_pickup_cost,
// 	esc.bank_charge,
// 	esc.tuition_{$colum_param}_pt AS tuition_pt,
// 	esc.tuition_{$colum_param}_ft AS tuition_ft,
// 	esc.homestay_cost_{$colum_param} AS homestay_cost,
// 	esc.textbooks_{$colum_param} AS textbooks,
// 	CASE WHEN esc.tuition_2w_pt IS NULL THEN 0 WHEN esc.tuition_2w_pt = 0 THEN 0 ELSE 1 END AS 2w_pt,
// 	CASE WHEN esc.tuition_2w_ft IS NULL THEN 0 WHEN esc.tuition_2w_ft = 0 THEN 0 ELSE 1 END AS 2w_ft,
// 	CASE WHEN esc.tuition_4w_pt IS NULL THEN 0 WHEN esc.tuition_4w_pt = 0 THEN 0 ELSE 1 END AS 4w_pt,
// 	CASE WHEN esc.tuition_4w_ft IS NULL THEN 0 WHEN esc.tuition_4w_ft = 0 THEN 0 ELSE 1 END AS 4w_ft,
// 	CASE WHEN esc.tuition_8w_pt IS NULL THEN 0 WHEN esc.tuition_8w_pt = 0 THEN 0 ELSE 1 END AS 8w_pt,
// 	CASE WHEN esc.tuition_8w_ft IS NULL THEN 0 WHEN esc.tuition_8w_ft = 0 THEN 0 ELSE 1 END AS 8w_ft,
// 	CASE WHEN esc.tuition_12w_pt IS NULL THEN 0 WHEN esc.tuition_12w_pt = 0 THEN 0 ELSE 1 END AS 12w_pt,
// 	CASE WHEN esc.tuition_12w_ft IS NULL THEN 0 WHEN esc.tuition_12w_ft = 0 THEN 0 ELSE 1 END AS 12w_ft,
// 	CASE WHEN esc.tuition_16w_pt IS NULL THEN 0 WHEN esc.tuition_16w_pt = 0 THEN 0 ELSE 1 END AS 16w_pt,
// 	CASE WHEN esc.tuition_16w_ft IS NULL THEN 0 WHEN esc.tuition_16w_ft = 0 THEN 0 ELSE 1 END AS 16w_ft,
// 	CASE WHEN esc.tuition_24w_pt IS NULL THEN 0 WHEN esc.tuition_24w_pt = 0 THEN 0 ELSE 1 END AS 24w_pt,
// 	CASE WHEN esc.tuition_24w_ft IS NULL THEN 0 WHEN esc.tuition_24w_ft = 0 THEN 0 ELSE 1 END AS 24w_ft,
// 	CASE WHEN esc.tuition_36w_pt IS NULL THEN 0 WHEN esc.tuition_36w_pt = 0 THEN 0 ELSE 1 END AS 36w_pt,
// 	CASE WHEN esc.tuition_36w_ft IS NULL THEN 0 WHEN esc.tuition_36w_ft = 0 THEN 0 ELSE 1 END AS 36w_ft,
// 	CASE WHEN esc.tuition_48w_pt IS NULL THEN 0 WHEN esc.tuition_48w_pt = 0 THEN 0 ELSE 1 END AS 48w_pt,
// 	CASE WHEN esc.tuition_48w_ft IS NULL THEN 0 WHEN esc.tuition_48w_ft = 0 THEN 0 ELSE 1 END AS 48w_ft,
// 	CASE WHEN esc.tuition_so1_pt IS NULL THEN 0 WHEN esc.tuition_so1_pt = 0 THEN 0 ELSE 1 END AS so1_pt_offer,
// 	CASE WHEN esc.tuition_so1_ft IS NULL THEN 0 WHEN esc.tuition_so1_ft = 0 THEN 0 ELSE 1 END AS so1_ft_offer,
// 	CASE WHEN esc.tuition_so2_pt IS NULL THEN 0 WHEN esc.tuition_so2_pt = 0 THEN 0 ELSE 1 END AS so2_pt_offer,
// 	CASE WHEN esc.tuition_so2_ft IS NULL THEN 0 WHEN esc.tuition_so2_ft = 0 THEN 0 ELSE 1 END AS so2_ft_offer,
// 	CASE WHEN esc.tuition_so3_pt IS NULL THEN 0 WHEN esc.tuition_so3_pt = 0 THEN 0 ELSE 1 END AS so3_pt_offer,
// 	CASE WHEN esc.tuition_so3_ft IS NULL THEN 0 WHEN esc.tuition_so3_ft = 0 THEN 0 ELSE 1 END AS so3_ft_offer,
// 	CASE WHEN esc.tuition_so4_pt IS NULL THEN 0 WHEN esc.tuition_so4_pt = 0 THEN 0 ELSE 1 END AS so4_pt_offer,
// 	CASE WHEN esc.tuition_so4_ft IS NULL THEN 0 WHEN esc.tuition_so4_ft = 0 THEN 0 ELSE 1 END AS so4_ft_offer
// 	FROM {$table_name} AS esm
// 	INNER JOIN {$cost_table_name} AS esc ON esm.post_id = esc.post_id
// 	INNER JOIN {$post_table_name} AS wp ON esm.post_id = wp.id AND wp.post_status = 'publish'
// 	WHERE
// 	esm.post_id = %d
// 	";	
	
	$get_meta = $wpdb->get_results(
			$wpdb->prepare( $sql, $param['estId'] )
	);

	return isset( $get_meta[0] ) ? $get_meta[0] : null;
}

/***************************************************************/
// 見積もり画面用基本期日取得処理
/***************************************************************/
function engp_get_default_param( $post_id ) {
	_log( 'engp_get_default_param' );

	global $wpdb;
	$table_name      = $wpdb->prefix . CUSTOM_TBL_SCHOOL_META;
	$cost_table_name = $wpdb->prefix . CUSTOM_TBL_SCHOOL_COST;
	$post_table_name = $wpdb->prefix . TBL_SCHOOL_POSTS;
	// 初期値は2週間に設定する
	$ret_data = "2w";

	$sql = "
		SELECT
			CASE WHEN esc.tuition_2w_pt IS NULL THEN 0 WHEN esc.tuition_2w_pt = 0 THEN 0 ELSE 1 END AS 2w_pt,
			CASE WHEN esc.tuition_2w_ft IS NULL THEN 0 WHEN esc.tuition_2w_ft = 0 THEN 0 ELSE 1 END AS 2w_ft,
			CASE WHEN esc.tuition_4w_pt IS NULL THEN 0 WHEN esc.tuition_4w_pt = 0 THEN 0 ELSE 1 END AS 4w_pt,
			CASE WHEN esc.tuition_4w_ft IS NULL THEN 0 WHEN esc.tuition_4w_ft = 0 THEN 0 ELSE 1 END AS 4w_ft,
			CASE WHEN esc.tuition_8w_pt IS NULL THEN 0 WHEN esc.tuition_8w_pt = 0 THEN 0 ELSE 1 END AS 8w_pt,
			CASE WHEN esc.tuition_8w_ft IS NULL THEN 0 WHEN esc.tuition_8w_ft = 0 THEN 0 ELSE 1 END AS 8w_ft,
			CASE WHEN esc.tuition_12w_pt IS NULL THEN 0 WHEN esc.tuition_12w_pt = 0 THEN 0 ELSE 1 END AS 12w_pt,
			CASE WHEN esc.tuition_12w_ft IS NULL THEN 0 WHEN esc.tuition_12w_ft = 0 THEN 0 ELSE 1 END AS 12w_ft,
			CASE WHEN esc.tuition_16w_pt IS NULL THEN 0 WHEN esc.tuition_16w_pt = 0 THEN 0 ELSE 1 END AS 16w_pt,
			CASE WHEN esc.tuition_16w_ft IS NULL THEN 0 WHEN esc.tuition_16w_ft = 0 THEN 0 ELSE 1 END AS 16w_ft,
			CASE WHEN esc.tuition_24w_pt IS NULL THEN 0 WHEN esc.tuition_24w_pt = 0 THEN 0 ELSE 1 END AS 24w_pt,
			CASE WHEN esc.tuition_24w_ft IS NULL THEN 0 WHEN esc.tuition_24w_ft = 0 THEN 0 ELSE 1 END AS 24w_ft,
			CASE WHEN esc.tuition_36w_pt IS NULL THEN 0 WHEN esc.tuition_36w_pt = 0 THEN 0 ELSE 1 END AS 36w_pt,
			CASE WHEN esc.tuition_36w_ft IS NULL THEN 0 WHEN esc.tuition_36w_ft = 0 THEN 0 ELSE 1 END AS 36w_ft,
			CASE WHEN esc.tuition_48w_pt IS NULL THEN 0 WHEN esc.tuition_48w_pt = 0 THEN 0 ELSE 1 END AS 48w_pt,
			CASE WHEN esc.tuition_48w_ft IS NULL THEN 0 WHEN esc.tuition_48w_ft = 0 THEN 0 ELSE 1 END AS 48w_ft,
			CASE WHEN esc.tuition_so1_pt IS NULL THEN 0 WHEN esc.tuition_so1_pt = 0 THEN 0 ELSE 1 END AS so1_pt,
			CASE WHEN esc.tuition_so1_ft IS NULL THEN 0 WHEN esc.tuition_so1_ft = 0 THEN 0 ELSE 1 END AS so1_ft,
			CASE WHEN esc.tuition_so2_pt IS NULL THEN 0 WHEN esc.tuition_so2_pt = 0 THEN 0 ELSE 1 END AS so2_pt,
			CASE WHEN esc.tuition_so2_ft IS NULL THEN 0 WHEN esc.tuition_so2_ft = 0 THEN 0 ELSE 1 END AS so2_ft,
			CASE WHEN esc.tuition_so3_pt IS NULL THEN 0 WHEN esc.tuition_so3_pt = 0 THEN 0 ELSE 1 END AS so3_pt,
			CASE WHEN esc.tuition_so3_ft IS NULL THEN 0 WHEN esc.tuition_so3_ft = 0 THEN 0 ELSE 1 END AS so3_ft,
			CASE WHEN esc.tuition_so4_pt IS NULL THEN 0 WHEN esc.tuition_so4_pt = 0 THEN 0 ELSE 1 END AS so4_pt,
			CASE WHEN esc.tuition_so4_ft IS NULL THEN 0 WHEN esc.tuition_so4_ft = 0 THEN 0 ELSE 1 END AS so4_ft
		FROM {$table_name} AS esm
		INNER JOIN {$cost_table_name} AS esc ON esm.post_id = esc.post_id
		INNER JOIN {$post_table_name} AS wp ON esm.post_id = wp.id AND wp.post_status = 'publish'
		WHERE
			esm.post_id = %d
	";

	$get_meta = $wpdb->get_results(
			$wpdb->prepare( $sql, $post_id )
	);

	// データは1レコードしか存在しない（他の画面で取得できてるので空振りは考慮しない）
	$meta_data = get_object_vars( $get_meta[0] );
	// 最初に金額が存在する期間を取得する
	foreach ( $meta_data as $key => $value ) {
		if ( $value == 1 ) {
			$ret_data = $key;
			break;
		}
	}
	// 置換処理
	$ret_data = str_replace( '_pt', '', $ret_data );
	$ret_data = str_replace( '_ft', '', $ret_data );

	return $ret_data;
}

/***************************************************************/
// カスタムフィールドの検索(見積もり画面)
/***************************************************************/
add_action( 'wp_ajax_nopriv_engp_school_estimate_course', 'engp_school_estimate_course' );
add_action( 'wp_ajax_engp_school_estimate_course', 'engp_school_estimate_course' );
function engp_school_estimate_course() {
	_log( 'engp_school_estimate_course' );

	$post_id 	= $_POST['ID'];
	$course = $_POST['course'];

	global $wpdb;
	$table_name      = $wpdb->prefix . CUSTOM_TBL_SCHOOL_COST;
	$post_table_name = $wpdb->prefix . TBL_SCHOOL_POSTS;
	
	$sql = "
	SELECT
		CASE WHEN esc.tuition_4w_{$course} IS NULL THEN 0 WHEN esc.tuition_4w_{$course} = 0 THEN 0 ELSE 1 END AS tui_4w,
		CASE WHEN esc.tuition_8w_{$course} IS NULL THEN 0 WHEN esc.tuition_8w_{$course} = 0 THEN 0 ELSE 1 END AS tui_8w,	
		CASE WHEN esc.tuition_12w_{$course} IS NULL THEN 0 WHEN esc.tuition_12w_{$course} = 0 THEN 0 ELSE 1 END AS tui_12w,		
		CASE WHEN esc.tuition_16w_{$course} IS NULL THEN 0 WHEN esc.tuition_16w_{$course} = 0 THEN 0 ELSE 1 END AS tui_16w,				
		CASE WHEN esc.tuition_24w_{$course} IS NULL THEN 0 WHEN esc.tuition_24w_{$course} = 0 THEN 0 ELSE 1 END AS tui_24w,		
		CASE WHEN esc.tuition_36w_{$course} IS NULL THEN 0 WHEN esc.tuition_36w_{$course} = 0 THEN 0 ELSE 1 END AS tui_36w,		
		CASE WHEN esc.tuition_48w_{$course} IS NULL THEN 0 WHEN esc.tuition_48w_{$course} = 0 THEN 0 ELSE 1 END AS tui_48w						
	FROM {$table_name} AS esc
	INNER JOIN {$post_table_name} AS wp ON esc.post_id = wp.id AND wp.post_status = 'publish'
	WHERE
	esc.post_id = %d
	";	
	
	$get_meta = $wpdb->get_row(
			$wpdb->prepare( $sql, $post_id )
	);	
	
	echo $get_meta->tui_4w.",";
	echo $get_meta->tui_8w.",";
	echo $get_meta->tui_12w.",";
	echo $get_meta->tui_16w.",";	
	echo $get_meta->tui_24w.",";
	echo $get_meta->tui_36w.",";
	echo $get_meta->tui_48w;	
	
	die();
	
}

/***************************************************************/
// 申込画面、コース抽出
/***************************************************************/
add_action( 'wp_ajax_nopriv_engp_school_apply_course', 'engp_school_apply_course' );
add_action( 'wp_ajax_engp_school_apply_course', 'engp_school_apply_course' );
function engp_school_apply_course() {
	_log( 'engp_school_apply_course' );

	$post_id 	= $_POST['ID'];

	global $wpdb;
	$table_name      = $wpdb->prefix . CUSTOM_TBL_SCHOOL_META;
	$post_table_name = $wpdb->prefix . TBL_SCHOOL_POSTS;

	$sql = "
	SELECT
		CASE WHEN esm.target_ESL IS NULL THEN 0 WHEN esm.target_ESL = 0 THEN 0 ELSE 1 END AS ESL,
		CASE WHEN esm.target_TOEFL IS NULL THEN 0 WHEN esm.target_TOEFL = 0 THEN 0 ELSE 1 END AS TOEFL,
		CASE WHEN esm.target_TOEIC IS NULL THEN 0 WHEN esm.target_TOEIC = 0 THEN 0 ELSE 1 END AS TOEIC,		
		CASE WHEN esm.target_advance IS NULL THEN 0 WHEN esm.target_advance = 0 THEN 0 ELSE 1 END AS advance,				
		CASE WHEN esm.target_business IS NULL THEN 0 WHEN esm.target_business = 0 THEN 0 ELSE 1 END AS business,						
		CASE WHEN esm.target_child IS NULL THEN 0 WHEN esm.target_child = 0 THEN 0 ELSE 1 END AS child,								
		CASE WHEN esm.target_adult IS NULL THEN 0 WHEN esm.target_adult = 0 THEN 0 ELSE 1 END AS adult,										
		CASE WHEN esm.target_ILETS IS NULL THEN 0 WHEN esm.target_ILETS = 0 THEN 0 ELSE 1 END AS ILETS,												
		CASE WHEN esm.target_so IS NULL THEN 0 WHEN esm.target_so = 0 THEN 0 ELSE 1 END AS so
		FROM {$table_name} AS esm
	INNER JOIN {$post_table_name} AS wp ON esm.post_id = wp.id AND wp.post_status = 'publish'
	WHERE
	esm.post_id = %d
	";

	$get_meta = $wpdb->get_row(
	$wpdb->prepare( $sql, $post_id )
	);

	echo $get_meta->ESL.",";
	echo $get_meta->TOEFL.",";
	echo $get_meta->TOEIC.",";
	echo $get_meta->advance.",";
	echo $get_meta->business.",";
	echo $get_meta->child.",";
	echo $get_meta->adult.",";	
	echo $get_meta->ILETS.",";
	echo $get_meta->so;
	
	die();

}

/***************************************************************/
// 為替レートファイル更新日取得
/***************************************************************/
function engp_get_rate_time() {
	_log( 'engp_get_rate_time' );

	$last_modify = "";

	// 為替レートファイル
//	$file_name = "/var/www/html/wordpress/wp-content/themes/engp/batch/rate.json";			// 開発
	$file_name = "/var/www/engp/html/wordpress/wp-content/themes/engp/batch/rate.json";		// 本番
	// キャッシュクリア
	clearstatcache();
	// ファイル有無確認
	if ( file_exists( $file_name ) ) {
		// キャッシュクリア
		clearstatcache();
		// 最終更新日取得
		$last_modify = date( "m/d　G", filemtime( $file_name ) + 32400 );
	}

	return $last_modify;

}

/***************************************************************/
// 値取得関数
// 変数のセットを確認し、変数がない場合はnullを返す
// パラメータにより空白チェックも行い、空白の場合はnullを返す
// （$mode 0:空白チェック無 1:空白チェック有）
/***************************************************************/
function engp_get_value( $value, $mode = 0 ) {
	_log( 'engp_get_value' );

	$ret_value = isset( $value ) ? $value : null;

	if ( $mode == MODE_EMPTY_CHECK_ON ) {
		if ( strlen( $value ) == 0 ) {
			$ret_value = null;
		}
	}

	return $ret_value;
}

/***************************************************************/
// 会員登録_情報更新_退会
/***************************************************************/
function engp_user_regist() {
	_log( 'engp_user_regist' );

	global $wpdb;
	$table_name = $wpdb->prefix . CUSTOM_TBL_USERS;

	$ID				= $_POST['ID'];
	$email			= $_POST['email'];
	$password		= $_POST['password'];
	$display_name 	= $_POST['display_name'];
	$delete			= $_POST['delete'];

	// 内部処理キー・パスワードは暗号化
	$process_key = hash( 'md5', $email );
	if( ! empty( $password ) ) {
		$regist_password = hash ( 'md5', $password );
	}

	if ( ! $ID ) {
		//新規登録
		$set_arr = array(
			'user_login'			=> $email,
			'password'				=> $regist_password,
			'display_name'			=> $display_name,
			'email'					=> $email,
			'process_key'			=> $process_key,
			'delete_flg' 			=> 0,
			'regist_date'			=> date_i18n( "Y-m-d H:i:s" ),
		);
		$wpdb->insert( $table_name, $set_arr );
	} elseif ( $delete ) {
		//削除
		$set_arr = array(
			'delete_flg'			=> $delete,
			'update_date'			=> date_i18n( "Y-m-d H:i:s" ),
		);
		$wpdb->update( $table_name, $set_arr, array( 'user_id' => $ID, 'delete_flg' => 0 ) );
	} else {
		//情報更新
		$set_arr = array(
			'user_login'			=> $email,
			'display_name'			=> $display_name,
			'email'					=> $email,
			'update_date'			=> date_i18n( "Y-m-d H:i:s" ),
		);

		if( ! empty( $password ) ){
			$set_arr['password'] = $regist_password;
		}
		$wpdb->update( $table_name, $set_arr, array( 'user_id' => $ID, 'delete_flg' => 0 ) );
	}
}

/***************************************************************/
// 会員登録 メールアドレスが既に登録されているか確認
/***************************************************************/
add_action( 'wp_ajax_nopriv_engp_check_regist', 'engp_check_regist' );
add_action( 'wp_ajax_engp_check_regist', 'engp_check_regist' );
function engp_check_regist(){
	_log( 'engp_checkr_regist' );

	global $wpdb;
	$table_name = $wpdb->prefix . CUSTOM_TBL_USERS;

	$email  = $_POST['email'];
	$ID     = $_POST['ID'];
	$remind = $_POST['remind'];

	//リマインダーかどうか
	if ( $remind == 1 ) {
		//登録されているメールアドレスかどうか
		$chk_email = $wpdb->get_var(
			$wpdb->prepare( "SELECT COUNT(*) FROM ". $table_name ." WHERE delete_flg = 0 and user_login = %s", $email )
		);
		if ( $chk_email == 0 ){
			$alert = 'このメールアドレスはEnglishPediaに登録されていないか、退会済みです。';
		}
	} else {
		//更新か新規登録時のチェックかどうか
		if ( ! $ID ) {
			$chk_email = $wpdb->get_var(
				$wpdb->prepare( "SELECT COUNT(*) FROM ". $table_name ." WHERE delete_flg = 0 and user_login = %s", $email )
			);
		} else {
			$chk_email = $wpdb->get_var(
				$wpdb->prepare( "SELECT COUNT(*) FROM ". $table_name ." WHERE delete_flg = 0 and ID != %d and user_login = %s",$ID, $email )
			);
		}

		if ( $chk_email > 0 ) {
			$alert = 'このメールアドレスは既に登録されています';
		}
	}

	echo $alert;
	die();
}

/***************************************************************/
// 会員情報取得
/***************************************************************/
function engp_get_user( $ID, $email ) {
	_log( 'engp_get_user' );

	global $wpdb;
	$table_name = $wpdb->prefix . CUSTOM_TBL_USERS;

	if ( $email ) {
		$user_data = $wpdb->get_row(
			$wpdb->prepare( "SELECT * FROM ". $table_name ." WHERE delete_flg = 0 and user_login = %s", $email )
		);
	} else {
		$user_data = $wpdb->get_row(
			$wpdb->prepare( "SELECT * FROM ". $table_name ." WHERE delete_flg = 0 and user_id = %s", $ID )
		);
	}

	return $user_data;
}

/***************************************************************/
// レビュー検索・取得(サイドバー用)
/***************************************************************/
function engp_school_review_sidebar($post_id) {
	_log( 'engp_school_review_sidebar' );

	global $wpdb;
	$table_name        = $wpdb->prefix . CUSTOM_TBL_SCHOOL_META;
	$review_table_name = $wpdb->prefix . CUSTOM_TBL_SCHOOL_REVIEW;
	$post_table_name   = $wpdb->prefix . TBL_SCHOOL_POSTS;

		//検索結果データ取得用SQL(5件)
		$sql = "
			SELECT
				esr.*
			FROM {$table_name} AS esm
			INNER JOIN {$review_table_name} AS esr ON esm.post_id = esr.post_id AND esr.delete_flg = 0 AND esr.approval_flg = 1
			INNER JOIN {$post_table_name} AS wp ON esm.post_id = wp.id AND wp.post_status = 'publish'
			WHERE esm.post_id = {$post_id}
			ORDER BY esr.regist_date DESC
			LIMIT 5;
		";
		$get_review = $wpdb->get_results( $sql );

		return $get_review;
}

/***************************************************************/
// レビュー検索・取得(学校詳細画面)
/***************************************************************/
add_action( 'wp_ajax_nopriv_engp_school_review', 'engp_school_review' );
add_action( 'wp_ajax_engp_school_review', 'engp_school_review' );
function engp_school_review() {
	_log( 'engp_school_review' );

	global $wpdb;
	$table_name        = $wpdb->prefix . CUSTOM_TBL_SCHOOL_META;
	$review_table_name = $wpdb->prefix . CUSTOM_TBL_SCHOOL_REVIEW;
	$post_table_name   = $wpdb->prefix . TBL_SCHOOL_POSTS;

	$post_id		= $_POST['post_id'];
	$page			= $_POST['page'];
	$view_cols		= $_POST['cols'];
	$result         = "";
	$view_page      = 1;

	// 検索結果件数取得用SQL
	$count_sql = "
		SELECT
			COUNT(*) AS CNT
		FROM {$table_name} AS esm
		INNER JOIN {$review_table_name} AS esr ON esm.post_id = esr.post_id AND esr.delete_flg = 0 AND esr.approval_flg = 1
		INNER JOIN {$post_table_name} AS wp ON esm.post_id = wp.id AND wp.post_status = 'publish'
		WHERE esm.post_id = {$post_id}
	";

	//件数取得
	$get_count = $wpdb->get_results( $count_sql );

	if ( $get_count[0]->CNT == 0 ) {
		$result = "<p>まだレビューはありません</p>" . PHP_EOL;
	} else {
		// 現在のページから次の上限数を取得
		if ( empty( $page ) ) {
			$page = 1;
			$limit = 0;
		} else {
			$limit = ( $page - 1 ) * $view_cols;
		}

		// 閲覧Noを取得
		$start_no = $limit + 1;
		$end_no = $start_no + $view_cols - 1;
		if ( $end_no > $get_count[0]->CNT ) {
			$end_no = $get_count[0]->CNT;
		}

		// 総ページ数を取得
		$page_mod = ( $get_count[0]->CNT % $view_cols);
		if($page_mod == 0){
			$last_page = ( $get_count[0]->CNT / $view_cols );
		}else{
			$last_page = ( ( $get_count[0]->CNT - $page_mod ) / $view_cols ) + 1;
		}

		//検索結果データ取得用SQL(10件)
		$sql = "
			SELECT
				esr.*
			FROM {$table_name} AS esm
			INNER JOIN {$review_table_name} AS esr ON esm.post_id = esr.post_id AND esr.delete_flg = 0 AND esr.approval_flg = 1
			INNER JOIN {$post_table_name} AS wp ON esm.post_id = wp.id AND wp.post_status = 'publish'
			WHERE esm.post_id = {$post_id}
			ORDER BY esr.regist_date DESC
		";
		$sql .= " LIMIT ". $view_cols . " OFFSET " . $limit;

		//件数取得
		$get_count = $wpdb->get_results( $count_sql );
		//表示用データ10件取得
		$get_meta = $wpdb->get_results( $sql );

		// 表示項目生成
		$result .= '<div id="tablesbox">' .PHP_EOL;
		foreach($get_meta as $key => $value){
			$result .= '<div id="table_box">' . PHP_EOL;
			$result .= '<div id="name_box" class="d_tablecell vtaln_top">' . PHP_EOL;
			$result .= '<img src="' . esc_url( get_template_directory_uri() ) . '/images/star_m' . $value->satisfaction_evaluation . '0.png">' . PHP_EOL;
			$result .= '<p class="mgnT8"><b>'. esc_html($value->open_name) . '</b>さん</p>' . PHP_EOL;
			$result .= '<p class="review_date">' . date( "Y年m月d日", strtotime( $value->regist_date ) ) . '</p>' . PHP_EOL;
			$result .= '</div>' . PHP_EOL;
			$result .= '<div id="coment_box" class="d_tablecell_top">' . PHP_EOL;
			if($value->selected_comment == null){
				$change_comment = preg_replace('/<br[[:space:]]*\/?[[:space:]]*>/i', "", $value->comment);
				$result .= '<p>' . nl2br(esc_html($change_comment)) . '</p>' . PHP_EOL;
			}else{
				$change_selected_comment = preg_replace('/<br[[:space:]]*\/?[[:space:]]*>/i', "", $value->selected_comment);
				$result .= '<p>' . nl2br(esc_html($change_selected_comment)) . '</p>' . PHP_EOL;
			}
			if($value->photo_name !== null){
				$files = $value -> photo_name;
				$file_list = explode(',',$files);
				array_pop($file_list);
				$approved_dir = PHOTO_URL.$value -> post_id.'/approved/';
				foreach($file_list as $photo_file){
					$result .= '<a href='.$approved_dir.$photo_file.' onClick="window.open(this.href,\'pop\',\'location=no,width=800,height=600\');return false;">' . PHP_EOL;
					$result .= '<img border="0" src='.$approved_dir.$photo_file.' width="96" height="96" align="left">' . PHP_EOL;
					$result .= '</a>' . PHP_EOL;
				}
			}
			$result .= '</div>' . PHP_EOL;
			$result .= '</div>' . PHP_EOL;
		}
		$result .= '</div>' .PHP_EOL;

		// ページ項目生成
		$result .= '<p class="p_ccc">（全' . $get_count[0]->CNT . '件中 ' . $start_no . ' ～ ' . $end_no .'件を表示中）</p>' . PHP_EOL;
		$result .= '<div id="pager" class="f_left mgnT32">' . PHP_EOL;
		$result .= '<p class="f_left page_count">' . $page . '<span class="p_ccc">/</span>' . $last_page . 'ページ</p>' . PHP_EOL;
		$result .= '<div id="pager_navi" class="f_right">' . PHP_EOL;
		$result .= '<ul>' . PHP_EOL;
		// 先頭は前へを表示しない
		if ( $page == 1 ) {
			$result .= '<li></li>' . PHP_EOL;
		} else {
			$result .= '<li data-page="1" class="paginate pager_text mob_none"><a href="javascript:void(0);"> < 最初へ</a></li>' . PHP_EOL;
			$result .= '<li data-page="' . intval( $page - 1 ) . '" class="paginate pager_text"><a href="javascript:void(0);"> < 前へ</a></li>' . PHP_EOL;
		}

		if ( $last_page < PAGE_INDEX_MAX ) {
			// 総ページ数がページインデックス以下の場合
			$idx_no = 0;
			for ( $i=0; $i < PAGE_INDEX_MAX; $i++ ) {
				$idx_no++;
				if ( $idx_no < $last_page + 1 ) {
					$result .= engp_set_paginate_index($idx_no, $page);
				}
			}
		} else {
			if ( $page < PAGE_INDEX + 1 ) {
				// 5ページ目まではインデックスを動かさない
				$idx_no = 0;
				for ( $i=0; $i < PAGE_INDEX_MAX; $i++ ) {
					$idx_no++;
					if ( $idx_no < $last_page + 1 ) {
						$result .= engp_set_paginate_index($idx_no, $page);
					}
				}
			} else {
				// 6ページ目以降

				// 表示位置設定
				$idx_no = $page - PAGE_INDEX;
				// 最終ページから4ページ前はインデックスを動かす
				if ( $page + 4 > $last_page ) {
					$idx_no = $idx_no - (4 - ($last_page - $page));
				}
				for ( $i=0; $i < PAGE_INDEX_MAX; $i++ ) {
					$idx_no++;
					$result .= engp_set_paginate_index($idx_no, $page);
				}
			}
		}

		// 終端は次へを表示しない
		if ( $page == $last_page ) {
			$result .= '<li></li>' . PHP_EOL;
		} else {
			$result .= '<li data-page="' . intval( $page + 1 ) . '" class="paginate pager_text"><a href="javascript:void(0);">次へ > </a></li>' . PHP_EOL;
			$result .= '<li data-page="' . intval( $last_page ) . '" class="paginate pager_text mob_none"><a href="javascript:void(0);">最後へ > </a></li>' . PHP_EOL;
		}
		$result .= '</ul>' . PHP_EOL;
		$result .= '</div>' . PHP_EOL;
		$result .= '</div>' . PHP_EOL;
	}

	echo $result;
	die();

}

/***************************************************************/
// レビュー星取得
/***************************************************************/
function engp_get_review_star( $post_id, $star_type = STAR_SMALL ) {
	_log( 'engp_get_review_star' );

	$ret_count = 0;
	$file_name = "";

	global $wpdb;
	$table_name        = $wpdb->prefix . CUSTOM_TBL_SCHOOL_META;
	$review_table_name = $wpdb->prefix . CUSTOM_TBL_SCHOOL_REVIEW;
	$post_table_name   = $wpdb->prefix . TBL_SCHOOL_POSTS;

	// 総件数取得用SQL
	$count_sql = "
		SELECT
			COUNT(*) AS CNT
		FROM {$table_name} AS esm
		INNER JOIN {$review_table_name} AS esr ON esm.post_id = esr.post_id AND esr.delete_flg = 0 AND approval_flg = 1
		INNER JOIN {$post_table_name} AS wp ON esm.post_id = wp.id AND wp.post_status = 'publish'
		WHERE esm.post_id = {$post_id}
	";

	$get_count = $wpdb->get_results( $count_sql );

	// 総評価数取得
	$sql = "
		SELECT
			SUM(esr.satisfaction_evaluation) AS star_cnt
		FROM {$table_name} AS esm
		INNER JOIN {$review_table_name} AS esr ON esm.post_id = esr.post_id AND esr.delete_flg = 0 AND approval_flg = 1
		INNER JOIN {$post_table_name} AS wp ON esm.post_id = wp.id AND wp.post_status = 'publish'
		WHERE esm.post_id = {$post_id}
	";

	$get_meta = $wpdb->get_results( $sql );

	// 平均算出
	$base_cnt = empty( $get_count[0]->CNT ) ? 0 : intval( $get_count[0]->CNT );
	$star_cnt = empty( $get_meta[0]->star_cnt ) ? 0 : intval( $get_meta[0]->star_cnt );

	if ( $base_cnt != 0 ) {
		// 小数第３位四捨五入
		$ret_count = round( ( $star_cnt / $base_cnt ), 2 );
		// 画像ファイル名生成
		$file_number = floor( $ret_count * 10 ) - ( $ret_count * 10 % 5 );
		if ( $star_type == STAR_SMALL ) {
			$file_name = "star_s" . $file_number . ".png";
		} elseif ( $star_type == STAR_MIDDLE ) {
			$file_name = "star_m" . $file_number . ".png";
		}
	} else {
		if ( $star_type == STAR_SMALL ) {
			$file_name = "star_s_none.png";
		} elseif ( $star_type == STAR_MIDDLE ) {
			$file_name = "star_m_none.png";
		}
	}

	return array( 'review_sum' => $base_cnt, 'review_ave' => $ret_count, 'img_file' => $file_name );
}

/***************************************************************/
// レビュー平均取得
/***************************************************************/
function engp_get_review_average( $post_id ) {
	_log( 'engp_get_review_average' );

	$secuirty_ave 	= 0;
	$traffic_ave 	= 0;
	$clean_ave		= 0;
	$staff_ave		= 0;
	$lesson_ave		= 0;
	$student_ave	= 0;

	global $wpdb;
	$table_name        = $wpdb->prefix . CUSTOM_TBL_SCHOOL_REVIEW;

	$sql = "
		SELECT
			SUM(security_evaluation) as secuirty,
			SUM(traffic_evaluation) as traffic,
			SUM(clean_evaluation) as clean,
			SUM(staff_evaluation) as staff,
			SUM(lesson_evaluation) as lesson,
			SUM(student_evaluation) as student,
			count(post_id) as post_cnt
			FROM {$table_name}
			WHERE post_id = {$post_id} AND approval_flg = 1 AND delete_flg = 0
			GROUP BY post_id";

	$get_meta = $wpdb->get_row( $wpdb->prepare( $sql, $post_id ) );
	if ( empty( $get_meta ) ) {
	// 要素がない場合はnullを返す
	return null;
	}

	// 評価部処理
	$post_cnt	 = empty( $get_meta->post_cnt ) ? 0 : intval( $get_meta->post_cnt );
	$secuirty	 = empty( $get_meta->secuirty ) ? 0 : intval( $get_meta->secuirty );
	$traffic	 = empty( $get_meta->traffic ) ? 0 : intval( $get_meta->traffic );
	$clean  	 = empty( $get_meta->clean ) ? 0 : intval( $get_meta->clean );
	$staff		 = empty( $get_meta->staff ) ? 0 : intval( $get_meta->staff );
	$lesson		 = empty( $get_meta->lesson ) ? 0 : intval( $get_meta->lesson );
	$student	 = empty( $get_meta->student ) ? 0 : intval( $get_meta->student );

	if ( $post_cnt >= 5 ) {
		// 小数第３位四捨五入
		$secuirty_ave 	= round( ( $secuirty / $post_cnt ), 1 );
		$traffic_ave 	= round( ( $traffic / $post_cnt ), 1 );
		$clean_ave 		= round( ( $clean / $post_cnt ), 1 );
		$staff_ave 		= round( ( $staff / $post_cnt ), 1 );
		$lesson_ave	 	= round( ( $lesson / $post_cnt ), 1 );
		$student_ave 	= round( ( $student / $post_cnt ), 1 );
		$evaluation_flg = 1;
	}else{
		$evaluation_flg = 0;
	}

	$return_data = array(
		'evaluation_flg' => $evaluation_flg,
		'secuirty'		 => $secuirty_ave,
		'traffic' 		 => $traffic_ave,
		'clean' 		 => $clean_ave,
		'staff'			 => $staff_ave,
		'lesson'		 => $lesson_ave,
		'student' 		 => $student_ave
		);

	return $return_data;
	}


/***************************************************************/
// お気に入り追加 / 解除
/***************************************************************/
add_action( 'wp_ajax_nopriv_engp_favorite', 'engp_favorite' );
add_action( 'wp_ajax_engp_favorite', 'engp_favorite' );
function engp_favorite(){
	_log( 'engp_favorite' );

	global $wpdb;
	$table_name = $wpdb->prefix . CUSTOM_TBL_FAVORITE;
	$ID      = $_POST['ID'];
	$post_id = $_POST['post_id'];
	$mode    = $_POST['mode'];
	$shape   = $_POST['shape'];

	if( $mode == '1' ) {
		//追加
		$cnt_favorite = $wpdb->get_var(
			$wpdb->prepare( "SELECT COUNT(*) FROM ". $table_name ." WHERE user_id = %d", $ID )
		);
		if( $cnt_favorite <= 20 ){
			$set_arr = array(
				'user_id' => $ID,
				'post_id' => $post_id,
			);
			$wpdb->insert( $table_name,$set_arr );
			$result .= "<a href='javascript:void(0)' onclick='javaScript:favorite(2,{$post_id})'>";
			$result .= "<img class='fav_btn' src='" . esc_url( get_template_directory_uri() ) . "/images/favorite_remove_{$shape}.png' alt='お気に入り解除'></a>";
		}
	} else if ( $mode == '2' ) {
		//削除
		$wpdb->query(
			$wpdb->prepare( "DELETE FROM ". $table_name ." WHERE user_id = %d and post_id = %d", $ID, $post_id )
		);
		$result .= "<a href='javascript:void(0)' onclick='javaScript:favorite(1,{$post_id})'>";
		$result .= "<img class='fav_btn' src='" . esc_url( get_template_directory_uri() ) . "/images/favorite_add_{$shape}.png' alt='お気に入り追加'></a>";
	} else {
		//表示
		$cnt_favorite = $wpdb->get_var(
			$wpdb->prepare( "SELECT COUNT(*) FROM ". $table_name ." WHERE user_id = %d and post_id = %d", $ID, $post_id )
		);
		if ( $cnt_favorite == 0 ) {
			$result .= "<a href='javascript:void(0)' onclick='javaScript:favorite(1,{$post_id})'>";
			$result .= "<img class='fav_btn' src='" . esc_url(get_template_directory_uri()) . "/images/favorite_add_{$shape}.png' alt='お気に入り追加'></a>";
		} else {
			$result .= "<a href='javascript:void(0)' onclick='javaScript:favorite(2,{$post_id})'>";
			$result .= "<img class='fav_btn' src='" . esc_url(get_template_directory_uri()) . "/images/favorite_remove_{$shape}.png' alt='お気に入り解除'></a>";
		}
	}
	echo $result;
	die();

}

/***************************************************************/
// 閲覧履歴学校取得
/***************************************************************/
function engp_get_history_school( $post_id ) {
	_log( 'engp_get_history_school' );

	$ret_count         = 0;
	$star_file         = "";
	$school_image_file = "";

	global $wpdb;
	$table_name        = $wpdb->prefix . CUSTOM_TBL_SCHOOL_META;
	$review_table_name = $wpdb->prefix . CUSTOM_TBL_SCHOOL_REVIEW;
	$post_table_name   = $wpdb->prefix . TBL_SCHOOL_POSTS;

	$sql = "
		SELECT
			esm.school_name,
			esm.city,
			SUM(esr.satisfaction_evaluation) AS evaluation,
			esrc.post_cnt
		FROM {$table_name} esm
		LEFT JOIN {$review_table_name} esr on esm.post_id = esr.post_id AND esr.delete_flg = 0 AND esr.approval_flg = 1
		LEFT JOIN (
			SELECT post_id, COUNT(post_id) AS post_cnt FROM {$review_table_name}
			WHERE delete_flg = 0 AND approval_flg = 1
			GROUP BY post_id) AS esrc
		ON esm.post_id = esrc.post_id
		INNER JOIN {$post_table_name} AS wp ON esm.post_id = wp.id AND wp.post_status = 'publish'
		WHERE esm.post_id = %d
	";

	$get_meta = $wpdb->get_row( $wpdb->prepare( $sql, $post_id ) );
	if ( empty( $get_meta ) ) {
		// 要素がない場合はnullを返す
		return null;
	}

	// 学校画像取得
	$image_post_id = get_post_meta( $post_id, 'my_upload_images', true );

	if ( ! empty( $image_post_id[0] ) ) {
		$school_image = wp_get_attachment_image_src( $image_post_id[0], array( 90, 90 ) );
		$school_image_file = $school_image[0];
	} else {
		$school_image_file = esc_url( get_template_directory_uri() ) . "/images/nophoto_90x90.jpg";
	}

	// 評価部処理
	$post_cnt = empty( $get_meta->post_cnt ) ? 0 : intval( $get_meta->post_cnt );
	$evaluation_cnt = empty( $get_meta->evaluation ) ? 0 : intval( $get_meta->evaluation );

	if ( $post_cnt != 0 ) {
		// 小数第３位四捨五入
		$ret_count = round( ( $evaluation_cnt / $post_cnt ), 2 );
		// 画像ファイル名生成
		$file_number = floor( $ret_count * 10 ) - ( $ret_count * 10 % 5 );
		$star_file   = esc_url( get_template_directory_uri() ) . "/images/" . "star_s" . $file_number . ".png";
	}else{
		$star_file = esc_url( get_template_directory_uri() ) . "/images/" . "star_s_none.png";
	}

	$return_data = array(
		'sch_name' => $get_meta->school_name,
		'sch_city' => $get_meta->city,
		'sch_img'  => $school_image_file,
		'star_img' => $star_file,
	);

	return $return_data;
}

/***************************************************************/
// お気に入りリスト
/***************************************************************/
function engp_get_favlist( $ID ) {
	_log( 'engp_get_favlist' );

	global $wpdb;
	$table_name        = $wpdb->prefix . CUSTOM_TBL_FAVORITE;
	$school_table_name = $wpdb->prefix . CUSTOM_TBL_SCHOOL_META;

	$sql = "
		SELECT
			esm.post_id,
			esm.school_name,
			esm.school_jp_name
		FROM {$table_name} AS fav
		INNER JOIN {$school_table_name} AS esm ON fav.post_id = esm.post_id
		WHERE fav.user_id = {$ID}
		ORDER BY fav.favorite_id
	";

	$favlist = $wpdb->get_results( $sql );

	return $favlist;
}

/***************************************************************/
// 内部処理キーからユーザーIDを取得
/***************************************************************/
function engp_get_id( $process_key ){
	_log('engp_get_id');

	global $wpdb;
	$table_name = $wpdb->prefix . CUSTOM_TBL_USERS;

	$sql = "
		SELECT
			user_id
		FROM {$table_name}
		WHERE process_key = %s
		AND delete_flg = 0
	";

	$result_id = $wpdb->get_row( $wpdb->prepare( $sql, $process_key ) );

	if ( empty($result_id->user_id ) ) {
		return 0;
	} else {
		return $result_id->user_id;
	}
}

/***************************************************************/
// 学校名取得
/***************************************************************/
function engp_get_school( $post_id ) {
	_log( 'engp_get_school' );

	global $wpdb;
	$table_name = $wpdb->prefix . CUSTOM_TBL_SCHOOL_META;
	$post_table_name   = $wpdb->prefix . TBL_SCHOOL_POSTS;

	if($post_id == 0){

	$sql = "
		SELECT
		esm.post_id,
		esm.school_name,
		esm.school_jp_name,
		esm.division
		FROM {$table_name} esm
		INNER JOIN {$post_table_name} AS wp ON esm.post_id = wp.id AND wp.post_status = 'publish' 	
		ORDER BY esm.division,esm.school_name
	";
	$school_data = $wpdb->get_results( $sql );
	}
	else{
	$sql = "
		SELECT
			school_name,
			school_jp_name
		FROM {$table_name}
		WHERE post_id = {$post_id}
	";
	$school_data = $wpdb->get_row( $sql );
	}



	return $school_data;
}

/***************************************************************/
// レビュー投稿
/***************************************************************/
function engp_review_post() {
	_log( 'engp_review_post' );

	global $wpdb;
	$table_name = $wpdb->prefix . CUSTOM_TBL_SCHOOL_REVIEW;

	$display_name			 = $_POST["display_name"];
	$security_evaluation	 = substr($_POST["security_evaluation"],0,1);
	$traffic_evaluation		 = substr($_POST["traffic_evaluation"],0,1);
	$clean_evaluation		 = substr($_POST["clean_evaluation"],0,1);
	$staff_evaluation		 = substr($_POST["staff_evaluation"],0,1);
	$lesson_evaluation		 = substr($_POST["lesson_evaluation"],0,1);
	$student_evaluation		 = substr($_POST["student_evaluation"],0,1);
	$answer_1				 = $_POST["answer_1"];
	$answer_2				 = $_POST["answer_2"];
	$answer_3				 = $_POST["answer_3"];
	$answer_4				 = $_POST["answer_4"];
	$review_text			 = $_POST["review_text"];
	$satisfaction_evaluation = $_POST["satisfaction_evaluation"];
	$repeat_discount_know	 = $_POST["repeat_discount_know"];

	$voice_text			 	 = $_POST["voice_text"];

	//ファイル名を一つの項目へ
	$file_name			 	 = $_POST["file_name"];
	if($file_name){
		foreach ($file_name as $name) {
			$moved_file_name .= $name.",";
		}
	}

	$ID						 = $_POST["ID"];
	$post_id				 = $_POST["post_id"];
	$user_ip				 = $_SERVER["REMOTE_ADDR"];

	switch ( $satisfaction_evaluation ) {
		case "★☆☆☆☆":
			$satisfaction_evaluation = "1";
			break;
		case "★★☆☆☆":
			$satisfaction_evaluation = "2";
			break;
		case "★★★☆☆":
			$satisfaction_evaluation = "3";
			break;
		case "★★★★☆":
			$satisfaction_evaluation = "4";
			break;
		case "★★★★★":
			$satisfaction_evaluation = "5";
			break;
	}

	if ($repeat_discount_know ='知ってはいた'){
		$repeat_discount_know = '1';
	}else{
		$repeat_discount_know = '0';
	}

	$set_arr = array(
		'user_id'					=> $ID,
		'post_id'					=> $post_id,
		'open_name'					=> $display_name,
		'post_user_ip'				=> $user_ip,

		'security_evaluation'		=> $security_evaluation,
		'traffic_evaluation'		=> $traffic_evaluation,
		'clean_evaluation'			=> $clean_evaluation,
		'staff_evaluation'			=> $staff_evaluation,
		'lesson_evaluation'			=> $lesson_evaluation,
		'student_evaluation'		=> $student_evaluation,
		'answer_1'					=> $answer_1,
		'answer_2'					=> $answer_2,
		'answer_3'					=> $answer_3,
		'answer_4'					=> $answer_4,
		'satisfaction_evaluation'	=> $satisfaction_evaluation,
		'comment'					=> $review_text,
		'selected_comment'			=> $voice_text,
		'photo_name'				=> $moved_file_name,
		'repeat_discount_know'		=> $repeat_discount_know,
		'approval_flg'				=> UNAPPROVED_FLG,
		'delete_flg' 				=> 0,
		'regist_date'				=> date_i18n( "Y-m-d H:i:s" ),
	);

	$wpdb->insert( $table_name, $set_arr );

}

/***************************************************************/
// パスワードリマインダー
/***************************************************************/
function engp_pass_reminder( $email ) {
	_log( 'engp_pass_reminder' );

	global $wpdb;
	$table_name = $wpdb->prefix . CUSTOM_TBL_USERS;

	//ユーザーデータ取得
	$user_data = $wpdb->get_row(
		$wpdb->prepare( "SELECT * FROM ". $table_name ." WHERE delete_flg = 0 and user_login = %s", $email )
	);

	// 仮パスワードを生成
	$temporary_password = hash( 'crc32b', rand() );
	// 仮パスワードを登録
	$regist_password = hash( 'md5', $temporary_password );

	// 情報更新
	$set_arr['password']    = $regist_password;
	$set_arr['update_date'] = date_i18n( "Y-m-d H:i:s" );

	$wpdb->update( $table_name, $set_arr, array( 'user_id' => $user_data->user_id, 'delete_flg' => 0 ) );

	return array( 'mailAddress' => $user_data->email, 'displayName' => $user_data->display_name, 'tempPassword' => $temporary_password );

}

/***************************************************************/
// レビュー一覧ページ
/***************************************************************/
function engp_review_list(){
	_log( 'engp_review_list' );

	if ( empty($_GET['inspection'] ) ):
		$view_page = $_GET['viewPage'];
		$page_idx = engp_get_review_all_list_index( $view_page );
		$get_meta_list = engp_get_review_all_list( $page_idx['nowPage'] );
?>
<div class="wrap">
	<h2>学校レビュー一覧</h2>
	<div class="tablenav top">
		<div class="tablenav-pages">
			<form id="review-list-form" action="" method="get">
				<span class="displaying-num"><?php echo "全".$page_idx['totalCount']."件"; ?></span>
				<span class="pagination-links">
					<a class="first-page <?php echo $page_idx['viewPrev']; ?>" title="最初のページへ" href="<?php echo get_admin_url(); ?>admin.php?page=review_list&viewPage=1">«</a>
					<a class="prev-page <?php echo $page_idx['viewPrev']; ?>" title="前のページへ" href="<?php echo get_admin_url(); ?>admin.php?page=review_list&viewPage=<?php echo $page_idx['prevPage']; ?>">‹</a>
					<span class="paging-input">
						<label for="current-page-selector" class="screen-reader-text">ページを選択</label>
						<input type="hidden" name="page" value="review_list">
						<input class="current-page" id="current-page-selector" title="現在のページ" name="viewPage" value="<?php echo $page_idx['nowPage']; ?>" size="1" type="text"> / <span class="total-pages"><?php echo $page_idx['lastPage']; ?></span>
					</span>
					<a class="next-page <?php echo $page_idx['viewNext']; ?>" title="次のページへ" href="<?php echo get_admin_url(); ?>admin.php?page=review_list&viewPage=<?php echo $page_idx['nextPage']; ?>">›</a>
					<a class="last-page <?php echo $page_idx['viewNext']; ?>" title="最後のページへ" href="<?php echo get_admin_url(); ?>admin.php?page=review_list&viewPage=<?php echo $page_idx['lastPage']; ?>">»</a>
				</span>
			</form>
		</div>
		<br class="clear">
	</div>
	<table class="wp-list-table widefat fixed posts">
		<thead>
			<tr>
				<th scope='col' id='title' class='manage-column column-title' style=""><span>学校</span></th>
				<th scope='col' id='review-num' class='manage-column column-review-num' style=""></th>
				<th scope='col' id='approval-num' class='manage-column column-approval-num' style=""></th>
			</tr>
		</thead>
		<tbody id="the-list">
<?php
	$count = 0;
	foreach ( $get_meta_list AS $data ):
		$count++;
		if($count % 2 != 0):
?>
		<tr id="post-<?php echo $data->post_id; ?>" class="post-<?php echo $data->post_id; ?> type-school status-publish hentry alternate iedit author-self level-0">
<?php else: ?>
		<tr id="post-<?php echo $data->post_id; ?>" class="post-<?php echo $data->post_id; ?> type-school status-publish hentry iedit author-self level-0">
<?php endif; ?>
			<td class="post-title page-title column-title">
				<strong><a class="row-title" href="<?php echo get_admin_url(); ?>admin.php?page=review_list&inspection=<?php echo $data->post_id; ?>"><?php echo $data->school_name; ?></a></strong>
			</td>
			<td class="reviewl-num column-reviewl-num"><strong>レビュー投稿数：<?php echo $data->review_cnt; ?></strong></td>
			<td class="approval-num column-approval-num"><strong>未承認レビュー数：<?php echo $data->approval_cnt; ?></strong></td>
		</tr>
<?php endforeach; ?>
		</tbody>
	</table>
</div>
<?php
	else:
		$post_id = $_GET['inspection'];
		$view_page = $_GET['viewPage'];
		$get_school_data = engp_get_meta($post_id);
		$page_idx = engp_get_school_review_all_list_index($post_id, $view_page);
		$get_meta_list = engp_get_school_review_list( $post_id, $page_idx['nowPage'] );
?>
<div class="wrap">
	<h3><?php echo $get_school_data->school_name; ?>　レビュー一覧</h3>
	<div class="tablenav top">
		<div class="tablenav-pages">
			<form id="review-list-form" action="" method="get">
				<span class="displaying-num"><?php echo "全".$page_idx['totalCount']."件"; ?></span>
				<span class="pagination-links">
					<a class="first-page <?php echo $page_idx['viewPrev']; ?>" title="最初のページへ" href="<?php echo get_admin_url(); ?>admin.php?page=review_list&viewPage=1&inspection=<?php echo $post_id; ?>">«</a>
					<a class="prev-page <?php echo $page_idx['viewPrev']; ?>" title="前のページへ" href="<?php echo get_admin_url(); ?>admin.php?page=review_list&viewPage=<?php echo $page_idx['prevPage']; ?>&inspection=<?php echo $post_id; ?>">‹</a>
					<span class="paging-input">
						<label for="current-page-selector" class="screen-reader-text">ページを選択</label>
						<input type="hidden" name="page" value="review_list">
						<input type="hidden" name="inspection" value="<?php echo $post_id; ?>">
						<input class="current-page" id="current-page-selector" title="現在のページ" name="viewPage" value="<?php echo $page_idx['nowPage']; ?>" size="1" type="text"> / <span class="total-pages"><?php echo $page_idx['lastPage']; ?></span>
					</span>
					<a class="next-page <?php echo $page_idx['viewNext']; ?>" title="次のページへ" href="<?php echo get_admin_url(); ?>admin.php?page=review_list&viewPage=<?php echo $page_idx['nextPage']; ?>&inspection=<?php echo $post_id; ?>">›</a>
					<a class="last-page <?php echo $page_idx['viewNext']; ?>" title="最後のページへ" href="<?php echo get_admin_url(); ?>admin.php?page=review_list&viewPage=<?php echo $page_idx['lastPage']; ?>&inspection=<?php echo $post_id; ?>">»</a>
				</span>
			</form>
		</div>
		<br class="clear">
	</div>
	<table class="widefat fixed comments">
		<thead>
			<tr>
				<th scope='col' id='title' class='manage-column column-title' style=""><span>投稿者 ／ 投稿日時</span></th>
				<th scope='col' id='review' class='manage-column column-review-num' style=""><span>レビュー</span></th>
				<th scope='col' id='dummy1' class='manage-column column-dummy1' style=""><span></span></th>
				<th scope='col' id='photo' class='manage-column column-photo' style=""><span>投稿写真</span></th>
			</tr>
		</thead>
		<tbody id="the-comment-list">
<?php
	$count = 0;
	foreach($get_meta_list AS $data):
		$count++;
		$approve = "";
		if ($data->approval_flg == UNAPPROVED_FLG ) {
			$approve = "unapproved";
		}
		if($count % 2 != 0):
?>
			<tr id="comment-<?php echo $data->review_id; ?>" class="comment byuser comment-author bypostauthor even thread-even depth-1 <?php echo $approve; ?>">
<?php else: ?>
			<tr id="comment-<?php echo $data->review_id; ?>" class="comment byuser comment-author bypostauthor odd alt thread-even depth-1 <?php echo $approve; ?>">
<?php endif; ?>
				<td class="author column-author <?php echo $approve; ?>">
<?php
				if ($data->approval_flg == UNAPPROVED_FLG ) {
?>
					<strong style="color: red;">未承認</strong><br>
<?php } ?>
					<strong><?php echo esc_html($data->open_name); ?></strong><br>
				<?php echo date( "Y/m/d H:i", strtotime( $data->regist_date ) ); ?>に投稿<br>
					<div class="row-actions">
						<span><a href="javascript:void(0);" class="details vim-d vim-destructive" data-review-id="<?php echo $data->review_id; ?>" title="このレビューの詳細を見る">詳細</a></span>
						<span class="trash"> |
<?php if ( $data->approval_flg == UNAPPROVED_FLG ): ?>
							<a href="javascript:void(0);" class="vim" data-review-id="<?php echo $data->review_id; ?>" data-process="approve" title="このレビューを承認">承認する</a>
<?php else: ?>
							<a href="javascript:void(0);" class="vim" data-review-id="<?php echo $data->review_id; ?>" data-process="unapprove" title="このレビューを承認しない">承認しない</a>
<?php endif; ?>
						</span>
						<span class="trash"> | <a href="javascript:void(0);" class="delete vim-d vim-destructive" data-review-id="<?php echo $data->review_id; ?>" data-process="delete" title="レビューを削除する">削除</a></span>
					</div>
				</td>
<?php if ( $data->selected_comment): ?>
				<td colspan="2" class="comment column-comment"><p>
				<?php
				$change_selected_comment = preg_replace('/<br[[:space:]]*\/?[[:space:]]*>/i', "", $data->selected_comment);
				echo nl2br(esc_html($change_selected_comment));
				?><p></td>
<?php else: ?>
				<td colspan="2" class="comment column-comment"><p>
				<?php
				$change_comment = preg_replace('/<br[[:space:]]*\/?[[:space:]]*>/i', "", $data->comment);
				echo nl2br(esc_html($change_comment));
				?><p></td>
<?php endif; ?>
				<td colspan="1" class="comment column-comment"><p>
				<?php
				//画像ファイル取得
				$files = $data -> photo_name;
				$file_list = explode(',',$files);
				array_pop($file_list);
				//画像ファイルのフォルダ定義
				if ( $data->approval_flg == UNAPPROVED_FLG):
					$origin = PHOTO_URL.$data -> post_id.'/unapproved/';
				else:
					$origin = PHOTO_URL.$data -> post_id.'/approved/';
				endif;
				foreach($file_list as $photo_file){
					echo '<img border="0" src='.$origin.$photo_file.' width="64" height="64">';
				}
				?><p></td>
			</tr>
<?php endforeach; ?>
		</tbody>
	</table>
	<input type="hidden" id="current-inspection-no" value="<?php echo $post_id; ?>">
	<input type="hidden" id="current-page-no" value="<?php echo $page_idx['nowPage']; ?>">
</div>
<?php
	endif;
}

/***************************************************************/
// レビュー一覧インデックス取得
/***************************************************************/
function engp_get_review_all_list_index( $page ) {
	_log( 'engp_get_review_all_list_index' );

	global $wpdb;
	$table_name = $wpdb->prefix . CUSTOM_TBL_SCHOOL_META;
	// 1ページの区切り数
	$view_cols = ADMIN_REVIEW_SCHOOL_PAGE_INDEX;

	// 登録学校件数取得
	$count_sql = "
		SELECT
			COUNT(*) AS CNT
		FROM {$table_name} AS esm
	";
	$get_count = $wpdb->get_results( $count_sql );

	// 総ページ数を取得
	$page_mod = ( $get_count[0]->CNT % $view_cols );
	if ( $page_mod == 0 ) {
		$last_page = ( $get_count[0]->CNT / $view_cols );
	} else {
		$last_page = ( ( $get_count[0]->CNT - $page_mod ) / $view_cols ) + 1;
	}

	// ページのインデックスをセット
	if( empty( $page ) ) {
		$now_page  = 1;
		$prev_page = 1;
		$next_page = $now_page + 1;
	} else {
		// 最大ページ以上の指定は最大ページにする
		if ( $page > $last_page ) {
			$page = $last_page;
		}

		$now_page  = $page;
		$prev_page = $page - 1;
		if ( $page >= $last_page ) {
			$next_page = $last_page;
		} else {
			$next_page = $now_page + 1;
		}
	}

	// アイコンの状態フラグをセット
	// 前へ
	if($now_page == 1){
		$view_prev = "disabled";
	}else{
		$view_prev = "";
	}
	// 次へ
	if($now_page == $last_page){
		$view_next = "disabled";
	}else{
		$view_next = "";
	}

	// 戻り値セット
	$result = array();
	$result['totalCount'] = $getCount[0]->CNT;
	$result['lastPage']   = $last_page;
	$result['nowPage']    = $now_page;
	$result['prevPage']   = $prev_page;
	$result['viewPrev']   = $view_prev;
	$result['nextPage']   = $next_page;
	$result['viewNext']   = $view_next;

	return $result;
}

/***************************************************************/
// レビュー一覧取得
/***************************************************************/
function engp_get_review_all_list( $page ) {
	_log( 'engp_get_review_all_list' );

	global $wpdb;
	$table_name        = $wpdb->prefix . CUSTOM_TBL_SCHOOL_META;
	$review_table_name = $wpdb->prefix . CUSTOM_TBL_SCHOOL_REVIEW;
	// 1ページの区切り数
	$view_cols = ADMIN_REVIEW_SCHOOL_PAGE_INDEX;

	// 登録学校件数取得
	$count_sql = "
		SELECT
			COUNT(*) AS CNT
		FROM {$table_name} AS esm
	";

	$get_count = $wpdb->get_results( $count_sql );

	// 現在のページから次の上限数を取得
	if ( empty( $page ) ) {
		$page = 1;
		$limit = 0;
	} else {
		$limit = ( $page - 1 ) * $view_cols;
	}

	$sql = "
		SELECT
			esm.post_id,
			esm.school_name,
			IFNULL(a.review_item, 0) AS review_cnt,
			IFNULL(b.approval_item, 0) AS approval_cnt
		FROM {$table_name} esm
		LEFT JOIN (
			SELECT post_id, SUM(CASE WHEN delete_flg = 0 THEN 1 ELSE 0 END) AS review_item FROM {$review_table_name}
			WHERE delete_flg = 0
			GROUP BY post_id
		) AS a
		ON esm.post_id = a.post_id
		LEFT JOIN (
			SELECT post_id, SUM(CASE WHEN approval_flg = 0 THEN 1 ELSE 0 END) AS approval_item FROM {$review_table_name}
			WHERE approval_flg = 0 AND delete_flg = 0
			GROUP BY post_id
		) AS b
		ON esm.post_id = b.post_id
		GROUP BY esm.post_id
		ORDER BY approval_cnt DESC
	";
	$sql .= " LIMIT ". $view_cols . " OFFSET " . $limit;

	$get_meta = $wpdb->get_results( $sql );

	return $get_meta;
}

/***************************************************************/
// レビュー詳細取得
/***************************************************************/
function engp_get_review_detail( $rev_id ) {
	_log( 'engp_get_review_detail' );

	global $wpdb;
	$table_name        = $wpdb->prefix . CUSTOM_TBL_SCHOOL_REVIEW;

	$sql = "
		SELECT * FROM {$table_name} AS rev
		WHERE rev.review_id = {$rev_id}
	";

	$rev_detail = $wpdb->get_row( $sql );
	return $rev_detail;
}

/***************************************************************/
// 学校別レビュー一覧インデックス取得
/***************************************************************/
function engp_get_school_review_all_list_index( $post_id, $page ) {
	_log( 'engp_get_school_review_all_list_index' );

	global $wpdb;
	$table_name = $wpdb->prefix . CUSTOM_TBL_SCHOOL_REVIEW;
	// 1ページの区切り数
	$view_cols = ADMIN_REVIEW_PAGE_INDEX;

	// 登録学校件数取得
	$count_sql = "
		SELECT
			COUNT(*) AS CNT
		FROM {$table_name} AS esr
		WHERE esr.delete_flg = 0 AND esr.post_id = %d
	";
	$get_count = $wpdb->get_results( $wpdb->prepare( $count_sql, $post_id ) );

	// 総ページ数を取得
	$page_mod = ( $get_count[0]->CNT % $view_cols );
	if ( $page_mod == 0 ) {
		$last_page = ( $get_count[0]->CNT / $view_cols );
	} else {
		$last_page = ( ( $get_count[0]->CNT - $page_mod ) / $view_cols ) + 1;
	}

	// ページのインデックスをセット
	if( empty( $page ) ) {
		$now_page  = 1;
		$prev_page = 1;
		$next_page = $now_page + 1;
	} else {
		// 最大ページ以上の指定は最大ページにする
		if ( $page > $last_page ) {
			$page = $last_page;
		}

		$now_page  = $page;
		$prev_page = $page - 1;
		if ( $page >= $last_page ) {
			$next_page = $last_page;
		} else {
			$next_page = $now_page + 1;
		}
	}

	// アイコンの状態フラグをセット
	// 前へ
	if($now_page == 1){
		$view_prev = "disabled";
	}else{
		$view_prev = "";
	}
	// 次へ
	if($now_page == $last_page){
		$view_next = "disabled";
	}else{
		$view_next = "";
	}

	// 戻り値セット
	$result = array();
	$result['totalCount'] = $getCount[0]->CNT;
	$result['lastPage']   = $last_page;
	$result['nowPage']    = $now_page;
	$result['prevPage']   = $prev_page;
	$result['viewPrev']   = $view_prev;
	$result['nextPage']   = $next_page;
	$result['viewNext']   = $view_next;

	return $result;
}
/*
/***************************************************************/
// 学校別レビュー一覧取得
/***************************************************************/
function engp_get_school_review_list( $post_id, $page ) {
	_log( 'engp_get_school_review_list');

	global $wpdb;
	$table_name = $wpdb->prefix . CUSTOM_TBL_SCHOOL_REVIEW;
	$view_cols  = ADMIN_REVIEW_PAGE_INDEX;

	// 登録学校件数取得
	$count_sql = "
		SELECT
			COUNT(*) AS CNT
		FROM {$table_name} AS esr
		WHERE esr.delete_flg = 0 AND esr.post_id = %d
	";
	$get_count = $wpdb->get_results( $wpdb->prepare( $count_sql, $post_id ) );

	// 現在のページから次の上限数を取得
	if ( empty($page) ) {
		$page  = 1;
		$limit = 0;
	} else {
		$limit = ( $page - 1 ) * $view_cols;
	}

	$sql = "
		SELECT
			esr.review_id,
			esr.post_id,
			esr.open_name,
			esr.comment,
			esr.selected_comment,
			esr.photo_name,
			esr.approval_flg,
			esr.regist_date
		FROM {$table_name} esr
		WHERE esr.delete_flg = 0 AND esr.post_id = %d
		ORDER BY esr.regist_date DESC
	";
	$sql .= " LIMIT ". $view_cols . " OFFSET " . $limit;

	$get_meta = $wpdb->get_results( $wpdb->prepare( $sql, $post_id ) );

	return $get_meta;
}

/***************************************************************/
// 学校別レビュー一覧取得（ajax）
/***************************************************************/
add_action( 'wp_ajax_engp_ajax_get_school_review_list', 'engp_ajax_get_school_review_list' );
function engp_ajax_get_school_review_list() {
	_log( 'engp_ajax_get_school_review_list' );

	$post_id	 = $_POST["post_id"];
	$page		 = $_POST["page"];

	$get_meta_list = engp_get_school_review_list( $post_id, $page );

	$count = 0;
	$result = "";
	foreach($get_meta_list AS $data){
		$approve = "";
		if ($data->approval_flg == UNAPPROVED_FLG ) {
			$approve = "unapproved";
		}
		$count++;
		if ( $count % 2 != 0 ) {
			$result .= "<tr id='comment-{$data->review_id}' class='comment byuser comment-author bypostauthor even thread-even depth-1 {$approve}'>" . PHP_EOL;
		} else {
			$result .= "<tr id='comment-{$data->review_id}' class='comment byuser comment-author bypostauthor odd alt thread-even depth-1 {$approve}'>" . PHP_EOL;
		}
		$result .= "<td class='author column-author'>" . PHP_EOL;
		if ($data->approval_flg == UNAPPROVED_FLG ) {
			$result .= '<strong style="color: red;">未承認</strong><br>' . PHP_EOL;
		}
		$result .= "<strong>".esc_html($data->open_name)."</strong><br>" . PHP_EOL;
		$result .= date( "Y/m/d H:i", strtotime( $data->regist_date ) ) . "に投稿<br>" . PHP_EOL;
		$result .= "<div class='row-actions'>" . PHP_EOL;

		$result .= "<span>" . PHP_EOL;
		$result .= "<a href='javascript:void(0);' class='details vim-d vim-destructive' data-review-id='{$data->review_id}' title='このレビューの詳細を見る'>詳細</a>" . PHP_EOL;
		$result .= "</span>" . PHP_EOL;
		$result .= "<span class='trash'> | " . PHP_EOL;
		if ( $data->approval_flg == UNAPPROVED_FLG ) {
			$result .= "<a href='javascript:void(0);' class='vim' data-review-id='{$data->review_id}' data-process='approve' title='このレビューを承認'>承認する</a>" . PHP_EOL;
		} else {
			$result .= "<a href='javascript:void(0);' class='vim' data-review-id='{$data->review_id}' data-process='unapprove' title='このレビューを承認しない'>承認しない</a>" . PHP_EOL;
		}
		$result .= "</span>" . PHP_EOL;
		$result .= "<span class='trash'> | <a href='javascript:void(0);' class='delete vim-d vim-destructive' data-review-id='{$data->review_id}' data-process='delete' title='レビューを削除する'>削除</a></span>" . PHP_EOL;
		$result .= "</div>" . PHP_EOL;
		$result .= "</td>" . PHP_EOL;
		if ($data->selected_comment) {
			$change_selected_comment = preg_replace('/<br[[:space:]]*\/?[[:space:]]*>/i', "", $data->selected_comment);
			$result .= "<td colspan='2' class='comment column-comment'><p>".nl2br(esc_html($change_selected_comment))."<p></td>" . PHP_EOL;
		}else{
			$change_comment = preg_replace('/<br[[:space:]]*\/?[[:space:]]*>/i', "", $data->comment);
			$result .= "<td colspan='2' class='comment column-comment'><p>".nl2br(esc_html($change_comment))."<p></td>" . PHP_EOL;
		}
		$result .= "<td colspan='1' class='comment column-comment'><p>" . PHP_EOL;
		//画像ファイル取得
		$files = $data -> photo_name;
		$file_list = explode(',',$files);
		array_pop($file_list);
		//画像ファイルのフォルダ定義
		if ( $data->approval_flg == UNAPPROVED_FLG):
			$origin = PHOTO_URL.$data -> post_id.'/unapproved/';
		else:
			$origin = PHOTO_URL.$data -> post_id.'/approved/';
		endif;
		foreach($file_list as $photo_file){
			$result .= "<img border='0' src=".$origin.$photo_file." width='64' height='64'>" . PHP_EOL;
		}
		$result .= "<p></td>" . PHP_EOL;

		$result .= "</tr>" . PHP_EOL;
	}

	echo $result;
	die();
}

/***************************************************************/
// レビュー承認/未承認/削除
/***************************************************************/
add_action( 'wp_ajax_engp_ajax_set_review_status', 'engp_ajax_set_review_status' );
function engp_ajax_set_review_status() {
	_log( 'engp_ajax_set_review_status' );

	global $wpdb;
	$table_name = $wpdb->prefix . CUSTOM_TBL_SCHOOL_REVIEW;

	$review_id	 = $_POST["review_id"];
	$process	 = $_POST["process"];
	$review_data = engp_get_review_detail($review_id);
	//画像ファイル有りの場合
	if($review_data -> photo_name):
		//画像ファイル取得
		$files = $review_data -> photo_name;
		$file_list = explode(',',$files);
		array_pop($file_list);
		//画像ファイルのフォルダ定義
		$unapproved_dir = PHOTO_DIR.$review_data -> post_id.'/unapproved/';
		$approved_dir = PHOTO_DIR.$review_data -> post_id.'/approved/';
		$delete_dir = PHOTO_DIR.'delete/';
		//遷移元定義
		if ( $review_data->approval_flg == UNAPPROVED_FLG):
			$origin = $unapproved_dir;
		else:
			$origin = $approved_dir;
		endif;
	endif;

	switch ( $process ) {
		case "unapprove":
			foreach($file_list as $photo_file){
				rename($origin.$photo_file, $unapproved_dir.$photo_file);
			}
			$set_arr = array(
				'approval_flg'			=> UNAPPROVED_FLG,
				'update_date'			=> date_i18n( "Y-m-d H:i:s" ),
			);
			break;
		case "approve":
			foreach($file_list as $photo_file){
				rename($origin.$photo_file, $approved_dir.$photo_file);
			}
			$set_arr = array(
				'approval_flg'			=> APPROVED_FLG,
				'update_date'			=> date_i18n( "Y-m-d H:i:s" ),
			);
			break;
		case "delete":
			foreach($file_list as $photo_file){
				rename($origin.$photo_file, $delete_dir.$photo_file);
			}
			$set_arr = array(
				'delete_flg'			=> 1,
				'update_date'			=> date_i18n( "Y-m-d H:i:s" ),
			);
			break;
	}

	$wpdb->update( $table_name, $set_arr, array( 'review_id' => $review_id, 'delete_flg' => 0 ) );

	exit();
}

/***************************************************************/
// 戻り検索用パラメータ設定
/***************************************************************/
function engp_set_return_search_param() {
	_log( 'engp_set_return_search_param' );

	$return_param = "";

	// ページ
	if ( isset ( $_SESSION['page'] ) ) $return_param .= '&page=' . $_SESSION['page'];
// 	// 目的
// 	if ( isset ( $_SESSION['purpose'] ) ) $return_param .= '&purpose=' . $_SESSION['purpose'];
	// 	学校名
		if ( isset ( $_SESSION['school_name'] ) ) $return_param .= '&school_name=' . $_SESSION['school_name'];

	// エリア
	if ( isset ( $_SESSION['division'] ) ) $return_param .= '&division=' . $_SESSION['division'];
	// 学費
	if ( isset ( $_SESSION['fee'] ) ) $return_param .= '&fee=' . $_SESSION['fee'];
	// コース
	if ( isset ( $_SESSION['course'] ) ) {
		foreach ( $_SESSION['course'] as $value ) {
			$return_param .= '&course[]=' . $value;
		}
	}
	// スペシャルオファー
	if ( isset ( $_SESSION['sp_offer'] ) ) $return_param .= '&sp_offer=' . $_SESSION['sp_offer'];
	// 場所
	if ( isset ( $_SESSION['location'] ) ) {
		foreach ( $_SESSION['location'] as $value ) {
			$return_param .= '&location[]=' . $value;
		}
	}
	// 交通手段
	if ( isset ( $_SESSION['how_to_go'] ) ) {
		foreach ( $_SESSION['how_to_go'] as $value ) {
			$return_param .= '&how_to_go[]=' . $value;
		}
	}
	// 所在（オンキャンパス）
	if ( isset ( $_SESSION['location_type'] ) ) $return_param .= '&location_type=' . $_SESSION['location_type'];
	// 国籍バランス
	if ( isset ( $_SESSION['nationality'] ) ) $return_param .= '&nationality=' . $_SESSION['nationality'];
	// 治安
	if ( isset ( $_SESSION['security'] ) ) $return_param .= '&security=' . $_SESSION['security'];
	// 現地スタッフ
	if ( isset ( $_SESSION['local_staff'] ) ) $return_param .= '&local_staff=' . $_SESSION['local_staff'];
	// 設備
	if ( isset ( $_SESSION['facilities'] ) ) {
		foreach ( $_SESSION['facilities'] as $value ) {
			$return_param .= '&facilities[]=' . $value;
		}
	}
	// ソート順
	if ( isset ( $_SESSION['sort'] ) ) $return_param .= '&sort=' . $_SESSION['sort'];

	return $return_param;

}

/***************************************************************/
// ページネート用インデックス設定
/***************************************************************/
function engp_set_paginate_index($idx_no, $page) {
	_log( 'engp_set_paginate_index' );

	if ( $idx_no == $page ) {
		// 現在のページは強調
		$return_html = '<li class="pager_number mob_none"><span class="p_ccc">' . $idx_no . '</span></li>' . PHP_EOL;
	} else {
		$return_html .= '<li data-page="' . $idx_no . '" class="paginate pager_number"><a href="javascript:void(0);">' . $idx_no . '</a></li>' . PHP_EOL;
	}

	return $return_html;

}

/***************************************************************/
// salesforceへの送信データ一覧ページ【留学申し込み】
/***************************************************************/
function engp_post_data_entry(){
	_log( 'engp_post_data_entry' );

	$get_record = engp_get_post_data_record( 'ex_school_meta' );
?>
<div class="wrap">
	<h2>送信データ一覧　留学申し込み</h2>
		<br class="clear">
	</div>
	<table id="list" class="wp-list-table widefat fixed posts"></table>
	<div id ="pager1"></div>
</div>
<script type="text/javascript">
	jQuery(function(){
		var result_data = <?php echo $get_record; ?>;
		var column_names = ["meta_id", "post_id", "school_name", "school_jp_name", "address", "phone"];
		var column_settings= [
			{name:"meta_id", index:"meta_id", width:50, align:"left", classes:"no_class"},
			{name:"post_id", index:"post_id", width:70, align:"left", classes:"no_class"},
			{name:"school_name", index:"school_name", width:200, align:"left", classes:"no_class"},
			{name:"school_jp_name", index:"school_jp_name", width:200, align:"left", classes:"no_class"},
			{name:"address", index:"address", width:200, align:"left", classes:"no_class"},
			{name:"phone", index:"phone", width:200, align:"left", classes:"no_class"}
		];

		jQuery("#list").jqGrid({
			data: result_data,
			datatype: "local",
			colNames: column_names,
			colModel: column_settings,
			height: 'auto',
			sortname: 'meta_id',
			sortorder: "DESC",
			multiselect: false,
			caption: '留学申し込み一覧',
			pager: 'pager1',
			rowNum: 20,
			viewrecords: true,
		});
	});
</script>
<?php
}

/***************************************************************/
// salesforceへの送信データ一覧ページ【お問い合わせ】
/***************************************************************/
function engp_post_data_contact(){
	_log( 'engp_post_data_contact' );

	$get_record = engp_get_post_data_record( 'ex_school_meta' );
	?>
<div class="wrap">
	<h2>送信データ一覧　お問い合わせ</h2>
		<br class="clear">
	</div>
	<table id="list" class="wp-list-table widefat fixed posts"></table>
	<div id ="pager1"></div>
</div>
<script type="text/javascript">
	jQuery(function(){
		var result_data = <?php echo $get_record; ?>;
		var column_names = ["meta_id", "post_id", "school_name", "school_jp_name", "address", "phone"];
		var column_settings= [
			{name:"meta_id", index:"meta_id", width:50, align:"left", classes:"no_class"},
			{name:"post_id", index:"post_id", width:70, align:"left", classes:"no_class"},
			{name:"school_name", index:"school_name", width:200, align:"left", classes:"no_class"},
			{name:"school_jp_name", index:"school_jp_name", width:200, align:"left", classes:"no_class"},
			{name:"address", index:"address", width:200, align:"left", classes:"no_class"},
			{name:"phone", index:"phone", width:200, align:"left", classes:"no_class"}
		];

		jQuery("#list").jqGrid({
			data: result_data,
			datatype: "local",
			colNames: column_names,
			colModel: column_settings,
			height: 'auto',
			sortname: 'meta_id',
			sortorder: "DESC",
			multiselect: false,
			caption: '留学申し込み一覧',
			pager: 'pager1',
			rowNum: 20,
			viewrecords: true,
		});
	});
</script>
<?php
}

/***************************************************************/
// salesforceへの送信データ一覧ページ【学校新規登録申請】
/***************************************************************/
function engp_post_data_school_regist(){
	_log( 'engp_post_data_school_regist' );

	$get_record = engp_get_post_data_record( 'ex_school_meta' );
	?>
<div class="wrap">
	<h2>送信データ一覧　学校新規登録申請</h2>
		<br class="clear">
	</div>
	<table id="list" class="wp-list-table widefat fixed posts"></table>
	<div id ="pager1"></div>
</div>
<script type="text/javascript">
	jQuery(function(){
		var result_data = <?php echo $get_record; ?>;
		var column_names = ["meta_id", "post_id", "school_name", "school_jp_name", "address", "phone"];
		var column_settings= [
			{name:"meta_id", index:"meta_id", width:50, align:"left", classes:"no_class"},
			{name:"post_id", index:"post_id", width:70, align:"left", classes:"no_class"},
			{name:"school_name", index:"school_name", width:200, align:"left", classes:"no_class"},
			{name:"school_jp_name", index:"school_jp_name", width:200, align:"left", classes:"no_class"},
			{name:"address", index:"address", width:200, align:"left", classes:"no_class"},
			{name:"phone", index:"phone", width:200, align:"left", classes:"no_class"}
		];

		jQuery("#list").jqGrid({
			data: result_data,
			datatype: "local",
			colNames: column_names,
			colModel: column_settings,
			height: 'auto',
			sortname: 'meta_id',
			sortorder: "DESC",
			multiselect: false,
			caption: '留学申し込み一覧',
			pager: 'pager1',
			rowNum: 20,
			viewrecords: true,
		});
	});
</script>
<?php
}

/***************************************************************/
// salesforceへの送信データ一覧ページ【学校情報相違報告】
/***************************************************************/
function engp_post_data_difference_report(){
	_log( 'engp_post_data_difference_report' );

	$get_record = engp_get_post_data_record( 'ex_school_meta' );
	?>
<div class="wrap">
	<h2>送信データ一覧　学校情報相違報告</h2>
		<br class="clear">
	</div>
	<table id="list" class="wp-list-table widefat fixed posts"></table>
	<div id ="pager1"></div>
</div>
<script type="text/javascript">
	jQuery(function(){
		var result_data = <?php echo $get_record; ?>;
		var column_names = ["meta_id", "post_id", "school_name", "school_jp_name", "address", "phone"];
		var column_settings= [
			{name:"meta_id", index:"meta_id", width:50, align:"left", classes:"no_class"},
			{name:"post_id", index:"post_id", width:70, align:"left", classes:"no_class"},
			{name:"school_name", index:"school_name", width:200, align:"left", classes:"no_class"},
			{name:"school_jp_name", index:"school_jp_name", width:200, align:"left", classes:"no_class"},
			{name:"address", index:"address", width:200, align:"left", classes:"no_class"},
			{name:"phone", index:"phone", width:200, align:"left", classes:"no_class"}
		];

		jQuery("#list").jqGrid({
			data: result_data,
			datatype: "local",
			colNames: column_names,
			colModel: column_settings,
			height: 'auto',
			sortname: 'meta_id',
			sortorder: "DESC",
			multiselect: false,
			caption: '留学申し込み一覧',
			pager: 'pager1',
			rowNum: 20,
			viewrecords: true,
		});
	});
</script>
<?php
}

/***************************************************************/
// salesforce送信レコード取得
/***************************************************************/
function engp_get_post_data_record( $db_name ) {
	_log( 'engp_get_post_data_record' );

	global $wpdb;
	$table_name = $wpdb->prefix . $db_name;

	$sql = "
		SELECT
			*
		FROM $table_name
	";

	$get_meta = $wpdb->get_results( $sql );

	return json_encode($get_meta);
}

/***************************************************************/
// 記事抜粋 文字数、末尾変更
/***************************************************************/
function change_excerpt_mblength($length) {
	return 110;
}
add_filter('excerpt_mblength', 'change_excerpt_mblength');

function new_excerpt_more($post) {
	return '…';
}
add_filter('excerpt_more', 'new_excerpt_more');

/***************************************************************/
// 最新レビュー取得(TOPページ用)
/***************************************************************/
function engp_school_review_top() {
	_log( 'engp_school_review_top' );

	global $wpdb;
	$table_name        = $wpdb->prefix . CUSTOM_TBL_SCHOOL_META;
	$review_table_name = $wpdb->prefix . CUSTOM_TBL_SCHOOL_REVIEW;
	$post_table_name   = $wpdb->prefix . TBL_SCHOOL_POSTS;

	//検索結果データ取得用SQL(5件)
	$sql = "
	SELECT
	esr.*,esm.school_name
	FROM {$table_name} AS esm
	INNER JOIN {$review_table_name} AS esr ON esm.post_id = esr.post_id AND esr.delete_flg = 0 AND esr.approval_flg = 1
	INNER JOIN {$post_table_name} AS wp ON esm.post_id = wp.id AND wp.post_status = 'publish'
	ORDER BY esr.regist_date DESC
	LIMIT 10;
	";
	$get_review = $wpdb->get_results( $sql );

	return $get_review;
}
