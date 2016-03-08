<?php
/*
Template Name: 支払完了
*/

	// cookie廃棄処理
	setcookie('gu_id', "", time() - 3600, '/', null, 0);
	setcookie('se_id', "", time() - 3600, '/', null, 0);

	$errorMsg = "";
	// 正式な流れで来ているかチェック
	if (!$_POST['token']) {
		$errorMsg = '通信エラーです。<br>クレジットカード決済画面より再度正しく入力をお願いします。<br>';
	}else{
		$products = array();
		$products[] = array(
		  'id' => '00001',
		  'title' => 'テスト商品',
		  'description' => '商品説明',
		  'language' => 'JA',
		  'price' => 1000,
		  'currency' => 'JPY',
		  'count' => 1,
		  'stock' => 10,
		);
		$params = array(
				'amount' => 1000,
				'currency' => 'JPY',
				'card' => $_REQUEST['token'],
				'products' => json_encode($products),
		);

		$url = 'https://api.spike.cc/v1/charges';
		$basic_user = "sk_test_mAIDuPXpTYiEEvuzgETCQo8R:";

		$ch = curl_init($url);
		// HTTPヘッダを出力しない
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		// SSLバージョン3を利用する
		//curl_setopt($ch, CURLOPT_SSLVERSION, 3);
		// 返り値を文字列として受け取る
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		// サーバー証明書の検証をスキップ
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		// HTTPステータスコード400の以上の場合も何も処理しない
		curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);
		// ツイートするデータをセット
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		// Basic認証のユーザー名:パスワードをセット
		curl_setopt($ch, CURLOPT_USERPWD, $basic_user);

		// サイトへアクセス
		$result = curl_exec($ch);

		// HTTPステータスコードをチェックしエラーならエラー内容を出力
		if(curl_errno($ch)) {
		    $errorMsg = '決済に失敗しました。<br>使用できるカードであるか確認し再度入力をお願いします。<br>' . curl_error($ch);
		}
		// セッションをクローズ
		curl_close($ch);
		// リクエストの内容を出力
		//var_dump($result);
	}
?>
<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>EnglishPedia カード決済完了</title>
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
					<?php if(!$errorMsg){ ?>
						<h1 class="user_login">EnglishPedia クレジットカード決済完了</h1>
						<div class="form-group form-inline row mgnB0">
							<div class="col-md-offset-2 col-md-8 col-ms-offset-2 col-ms-8 col-xs-offset-2 col-xs-8">
								<p class="user_login_p">この度はありがとうございます。<br>お支払が完了致しました。<br>3営業日以内に弊社よりご連絡をさせていただきます。</p>
							</div>
						</div>
					<?php }else{ ?>
						<h1 class="user_login">EnglishPedia クレジットカード決済エラー</h1>
						<div class="form-group form-inline row mgnB0">
							<div class="col-md-offset-2 col-md-8 col-ms-offset-2 col-ms-8 col-xs-offset-2 col-xs-8">
								<p class="user_login_p"><?php echo "$errorMsg"; ?></p>
							</div>
						</div>
					<?php } ?>
					</div>
				</div>
			</div>
		</div>
<script src="https://checkout.spike.cc/v1/checkout.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

	</body>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

</html>
