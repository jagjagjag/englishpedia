<?php
	session_name('ENGP');
	session_start();

	if ( empty( $_COOKIE['gu_id'] ) && ! empty( $_COOKIE['se_id'] ) ) {
		$startUrl = esc_url(home_url()) ."/login";
		header("Location: {$startUrl}");
		exit;
	}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
	<link rel="shortcut icon" href="<?php echo esc_url( get_template_directory_uri() . '/favicon.ico' ); ?>" type="image/vnd.microsoft.ico"/>
	<link rel="profile" href="//gmpg.org/xfn/11">
	<!-- Bootstrap -->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" />

	<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1/themes/ui-lightness/jquery-ui.css" />
	<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/css/common.css' ); ?>"/>
	<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/style.css' ); ?>"/>
	<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/css/dropmenu.css' ); ?>"/>
	<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/css/jquery.bxslider.css' ); ?>"/>
</head>

<body <?php body_class(); ?>>
	<!-- Start: page -->
	<header id="masthead" class="navbar site-header" role="banner">
		<div class="container">
			<div class="navbar-header" id="totop">
				<button class="navbar-toggle mob_menu" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
				</button>
				<a href="<?php echo home_url(); ?>" class="navbar-brand">
					<img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/logo.png" alt="engpロゴ" width="189px" class="img-responsive">
				</a>
			</div>
			<h1 class="navbar-text mob_none" style='color: #d9e6f3; font-size:85%; padding-top:1px;'>語学留学のための学校情報比較サイト<br>イングリッシュペディア</h1>
			<div id="header_contact" class="f_right">
<!-- 				<p class="headercon_con_p f_left"><img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/mail.png" alt="お問い合わせアイコン">お問い合わせ</p>  -->
				<div id="telbox" class="f_right">
						<img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/img_tel_number.png" alt="お電話でのお問い合わせはこちら" class="mob_none" style="width:150px; height:36px;">
						<a href="apply" class="btn btn-info btndeco mob_none tab_none">留学のお申し込み</a>
						<a href="<?php echo home_url(); ?>/counseling/" class="btn btn-info btndeco2 mob_none tab_none">カウンセリングのお申し込み</a>
				</div>
			</div>

			<div class="clear"></div>
			<nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
				<div id="menutest">
					<ul class="nav navbar-nav" style="margin-top:-6px;">
						<li class="navi_firstone"><a href="<?php echo home_url(); ?>">ホーム</a></li>
						<li class="mob_none">
								<a href="<?php echo home_url(); ?>/?s=&page=1&fee=1">格安の学校</a>
						</li>
						<li class="mob_none">
								<a href="<?php echo home_url(); ?>/?s=&page=1&nationality=1">国籍バランスのいい学校</a>
						</li>
						<li class="mob_none">
								<a href="<?php echo home_url(); ?>/?s=&page=1&location[]=1">都会にある学校</a>
						</li>
<!-- 						<li class="mob_none">
								<a href="<?php // echo home_url(); ?>/?s=&page=1&location[]=2">郊外にある学校</a>
	 						</li> -->
					</ul>
				<ul class="nav navbar-nav navbar-right" style="margin-top:-6px;"></ul>
				</div>
			</nav>
		</div>
	</header>
