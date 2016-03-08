<?php
/*
Template Name: ログイン
*/

	global $wpdb;
	$tableName = $wpdb->prefix . 'ex_users';
	$errMes = "";

	if(empty($_COOKIE['gu_id']) && !empty($_COOKIE['se_id'])){
		$errMes = "セッションが切れました<br>再度、ログインをしてください";
	}

	// cookie廃棄処理
	setcookie('gu_id', "", time() - 3600, '/', null, 0);
	setcookie('se_id', "", time() - 3600, '/', null, 0);

	// 戻りURLセット
	if(isset($_POST["ret_url"])){
		$ret_url = $_POST["ret_url"];
	}else{
		if( isset( $_SERVER['HTTP_REFERER']) && is_numeric( strpos($_SERVER['HTTP_REFERER'], esc_url(home_url()) ) ) ){
			$ret_url = $_SERVER['HTTP_REFERER'];
		}else{
			$ret_url = esc_url(home_url());
		}
	}

	if(isset($_POST["login"])){
		if(empty($_POST["userid"]) && !empty($_POST["password"])) {
			$errMes = "メールアドレスを入力してください";
		}elseif(!empty($_POST["userid"]) && empty($_POST["password"])){
			$errMes = "パスワードを入力してください";
		}else{
			$errMes = "メールアドレス・パスワードを入力してください";
		}
	}

	if(!empty($_POST["userid"]) && !empty($_POST["password"])){
		session_name('ENGP');
		session_start();

		$id = $_POST["userid"];
		$pass = hash('md5', $_POST["password"]);

		$sql = "
			SELECT
				eu.user_id,
				eu.user_login,
				eu.process_key
			FROM {$tableName} AS eu
			WHERE eu.delete_flg = 0
			AND eu.user_login = %s
			AND eu.password = %s
		";

		$resultData = $wpdb->get_row($wpdb->prepare($sql, $id, $pass));

		if(empty($resultData)){
			$errMes = "ユーザーIDあるいはパスワードに誤りがあります";
		}else{
			// cookieセット処理
			// 内部処理キー取得
			$processID = $resultData->process_key;
			// 現在時刻取得
			$szDate = date("YmdHis");
			// ログインID取得
			$szMemberid = $resultData->user_login;
			// MD5による暗号化
			$szHash = md5($szMemberid . $_SERVER[ 'REMOTE_ADDR' ] . $szDate);

			// 内部処理用
			setcookie('gu_id', $processID, time() + 21600, '/', null, 0);
			// 接続認証用
			setcookie('se_id', $szHash, time() + 86400, '/', null, 0);

			// 前に表示されていた画面へ遷移
			$startUrl = $ret_url;
			header("Location: {$startUrl}");

			exit;
		}
	}
?>
<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>EnglishPedia ログイン</title>
		<link rel="shortcut icon" href="<?php echo esc_url( get_template_directory_uri() . '/favicon.ico' ); ?>" type="image/vnd.microsoft.ico"/>
		<link rel="profile" href="//gmpg.org/xfn/11">
		<!-- Bootstrap -->
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/css/regist-style.css' ); ?>"/>
	</head>

	<body style="background-color:#eef3f7;">
		<div class="container">
			<div class="row">
				<div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8 col-xs-12 mgnT16 ">
					<div class ="login_content_box">
						<h1 class="user_login">ユーザー ログイン</h1>
						<form id="loginForm" name="loginForm"  class="form-horizontal" action="" method="POST">
							<div class="mgnB8 mgnT8" style="color:red;"><?php echo $errMes ?></div>
							<div class="form-group form-inline row mgnB0">
								<div class="col-md-offset-2 col-md-8 col-ms-offset-2 col-ms-8 col-xs-offset-2 col-xs-8">
									<p class="user_login_p"><label class="control-label" for="userid">メールアドレス </label>
								</div>
								<div class="col-md-offset-2 col-md-8 col-ms-offset-2 col-ms-8 col-xs-offset-1 col-xs-10">
									<input type="text" id="userid" name="userid" class="form-control" style="width:100%;"value="<?php echo htmlspecialchars($_POST["userid"], ENT_QUOTES); ?>"></p>
								</div>
							</div>
							<div class="form-group form-inline row mgnB0">
								<div class="col-md-offset-2 col-md-8 col-ms-offset-1 col-ms-10 col-xs-offset-1 col-xs-10">
									<p class="user_login_p"><label  class="control-label" for="password">パスワード </label>
								</div>
								<div class="col-md-offset-2 col-md-8 col-ms-offset-2 col-ms-8 col-xs-offset-1 col-xs-10">
									<input type="password" id="password" class="form-control" style="width:100%;" name="password" value=""></p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-offset-4 col-md-4 col-ms-offset-4 col-ms-4  col-xs-offset-3 col-xs-6">
									<input type="submit" id="login" name="login" value="ログイン" class="search_btn_login mgnT8">
								</div>
							</div>
							<input type="hidden" name="ret_url" value="<?php echo $ret_url; ?>">
						</form>
						<p class="search_totop"><a href="<?php echo home_url(); ?>/reminder">パスワードを忘れた方はこちら</a></p>
						<p class="search_totop"><a href="<?php echo home_url(); ?>">TOPへもどる</a></p>
						<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/img_login_logo.png" alt="イングリッシュペディア　ユーザーログイン" class="login_img_logo img-responsive">
					</div>
				</div>
			</div>
		</div>
	</body>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

</html>
