<?php
/*
Template Name: 支払
*/

	// cookie廃棄処理
	setcookie('gu_id', "", time() - 3600, '/', null, 0);
	setcookie('se_id', "", time() - 3600, '/', null, 0);

?>
<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>EnglishPedia クレジットカード決済</title>
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
						<h1 class="user_login">EnglishPedia クレジットカード決済</h1>
						<form id="paymentForm" name="paymentForm"  class="form-horizontal" action="payment_result" method="POST">
							<div class="form-group form-inline row mgnB0">
								<div class="col-md-offset-2 col-md-8 col-ms-offset-2 col-ms-8 col-xs-offset-2 col-xs-8">
									<p class="user_login_p"><label class="control-label" for="name"><span class="regist_chk_notes">*</span>氏名 </label>
								</div>
								<div class="col-md-offset-2 col-md-8 col-ms-offset-2 col-ms-8 col-xs-offset-1 col-xs-10">
									<input type="text" id="name" name="name" class="form-control" style="width:100%;"value=""></p>
								</div>
								<div class="col-md-offset-2 col-md-8 col-ms-offset-2 col-ms-8 col-xs-offset-2 col-xs-8">
									<p class="user_login_p"><label class="control-label" for="userid"><span class="regist_chk_notes">*</span>メールアドレス </label>
								</div>
								<div class="col-md-offset-2 col-md-8 col-ms-offset-2 col-ms-8 col-xs-offset-1 col-xs-10">
									<input type="text" id="userid" name="userid" class="form-control" style="width:100%;"value=""></p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-offset-4 col-md-4 col-ms-offset-4 col-ms-4  col-xs-offset-3 col-xs-6">
									<button name="purchase" id="purchase_button" class="search_btn_login mgnT8">カード決済</button>
								</div>
							</div>
							<input type="hidden" id="token" name="token" value="">
						</form>
						<div class="important"><strong style="color:#cc0000;font-size:1.2em;">クレジットカードでお支払い</strong><br>
    <ul align="left">
      <li>間違えてご入金された場合は<a href="<?php echo home_url().'/inquiry'; ?>">お問い合わせフォーム</a>よりご連絡ください。</li>
      <li>返金処理はお客様の銀行口座宛てにお振込みいたします。</li>
      <li>ご返金の際、振込手数料は差し引かせていただきます。</li>
      <li>クレジットカード明細書上の請求名は、お使い頂くカード種類によっては、先頭にSPIKEと表示される場合やSPIKE.CCまたはSPKCCのみ表示される場合がございます。</li>
      <li>明細に表示される日付は、決済の処理日の影響により、注文日と異なる場合があります。</li>
      <li>お支払い回数：一括払いのみとなります。</li>
    </ul>
  </div>
	<a href="<?php echo home_url(); ?>"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/img_login_logo.png" alt="イングリッシュペディア　クレジットカード決済" class="login_img_logo img-responsive"></a>
    <a href="https://support.spike.cc/hc/ja/articles/203039884"><img width="90" height="36" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/spike_s2.png"></a>
					</div>
				</div>
			</div>
		</div>
<script src="https://checkout.spike.cc/v1/checkout.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
var handler = SpikeCheckout.configure({
  key: "pk_test_0WtYiBhihxJ7r4md6cLGwkCy",
  token: function(token, args) {
//    alert(token.id);
    $("#customButton").attr('disabled', 'disabled');
    $(':input[type="hidden"][name="token"]').val(token.id);
    $('form#paymentForm').submit();
  },
  opened: function(e) {
    // Event: Overlay opened
  },
  closed: function(e) {
    // Event: Overlay closed
  }
});
$('#purchase_button').click(function(e) {
	if(document.forms.paymentForm.name.value == ""){
		alert('氏名を入力してください。');
		return false;
	}
	if(document.forms.paymentForm.userid.value == ""){
		alert('メールアドレスを入力してください。');
		return false;
	}
	mailchk = document.forms.paymentForm.userid.value.match(/^\S+@\S+\.\S+$/);
	if (!mailchk) {
		alert('メールアドレスが正しくありません。');
		return false;
	}
//	alert(document.forms.paymentForm.userid.value);
    handler.open({
      name: "EnglishPedia CreditCardPayment",
      amount: 1000,
      currency: "JPY",
      email: document.forms.paymentForm.userid.value,
      guest: true
    });
  e.preventDefault();
});

</script>
	</body>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

</html>
