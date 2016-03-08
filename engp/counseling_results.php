<?php
/*
 Template Name: カウンセリング申し込み_送信完了
 */
get_header('nologin');
if($_POST["last_name"]){
	$send_flg = 1;
}else{
	$send_flg = 0;
}
?>

<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/css/regist-style.css' ); ?>"/>

<!-- Start: タイトル、hr -->
<h1 class="regist_entry_title hidden-xs">カウンセリングのお申し込み</h1>
<hr class="hidden-xs">
<!-- End: タイトル、hr -->

<!-- Start: コンテンツ -->
<div class="container">
	<div class="regist_main">
		<div class="regist_content_box2">
			<div id="form2">
				<div id="mailform_area">
<?php
	mb_language("japanese");
	mb_internal_encoding("UTF-8");

	if($send_flg == 1){
	
		$last_name				= $_POST["last_name"];
		$first_name				= $_POST["first_name"];
		$prefectures 			= $_POST["prefectures"];
		$email					= $_POST["email"];
		$phone					= $_POST["phone"];
		$image					= $_POST["image"];
		$consultation			= $_POST["consultation"];
		$travel_plan			= $_POST["travel_plan"];
		$preferred_date			= $_POST["preferred_date"];
		$preferred_location		= $_POST["preferred_location"];
			
		$from_addr = MASTER_MAIL_ADDRES;
		$to_addr = $email;
		$header = "From: ".$from_addr;
		$footer = MASTER_MAIL_FOOTER;
		
	
		$subject = "【EnglishPedia】カウンセリングのお申し込みありがとうございました";

		$body_content = <<<BODY
$last_name $first_name 様

この度はEnglishPediaにカウンセリングののお申し込みを頂きありがとうございました。
下記の内容にてお申し込みを承りました。
担当者よりご連絡させて頂きますので、
今しばらくお待ち頂けますようよろしくお願いいたします。
	
--------------------------------- 
	
■お名前
$last_name $first_name 様
	
■都道府県
$prefectures
	
■メールアドレス
$email
	
■携帯電話番号
$phone
	
■希望都市
$image
	
■聞きたい内容
$consultation
	
■留学予定時期
$travel_plan
	
■カウンセリング希望日時
$preferred_date
		
■カウンセリング場所・方法
$preferred_location
		
---------------------------------
	
お急ぎの場合は下記の連絡先まで
お電話にてご連絡下さいますようよろしくお願い申し上げます。
この度はお問い合わせ頂きありがとうございました。

また、このメールに心当たりの無い場合は、
お手数ですが下記連絡先までお問い合わせください。

$footer
	
BODY;

		//送信
		$rslts = mb_send_mail($to_addr, $subject, $body_content, $header);
		$master_rslts = mb_send_mail($from_addr, $subject, $body_content, $header);	
	}
?>
				</div>			
			</div>
			
			<div id="regist_results_line"><h2>カウンセリングのお申し込みありがとうございました。</h2><br />EnglishPediaサポートセンターよりご連絡させていただきます。<br />今しばらくお待ち頂けますようよろしくお願いいたします。</div>
			<a href="<?php echo esc_url(home_url());?>"><img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/btn_regist_top.png" width="230" height="50" alt="EnglishPediaトップページへ戻る" class="btn_regist_top"/></a>
		</div>
	</div>
</div>
			<!-- salesforce送信用 -->
			<?php if($send_flg == 1):?>			
				<form name="counseling" action="">
					<input type=hidden name="oid" value="00D10000000KUjS">
					<input type=hidden name="retURL" value="<?php echo esc_url(home_url());?>/counseling_result">
					<input type="hidden" id="first_name" name="first_name" value="<?php echo $first_name ?>"/>
					<input type="hidden" id="last_name" name ="last_name"value="<?php echo $last_name ?>"/>
					<input type="hidden" id="state" name="state" value="<?php echo $prefectures ?>"/>
					<input type="hidden" id="00N10000001Ze8Y" name="00N10000001Ze8Y" value="<?php echo $email ?>"/>
					<input type="hidden" id="phone" name="phone" value="<?php echo $phone ?>"/>
					<input type="hidden" id="00N10000002bMx2" name="00N10000002bMx2" value="<?php echo $image ?>"/>
					<input type="hidden" id="00N10000001ZgGk" name="00N10000001ZgGk" value="<?php echo $consultation ?>"/>				
					<input type="hidden" id="00N10000001ZgGL" name="00N10000001ZgGL" value="<?php echo $travel_plan ?>"/>
					<input type="hidden" id="00N100000058efW" name="00N100000058efW" value="<?php echo $preferred_date ?>"/>
					<input type="hidden" id="00N100000058efl" name="00N100000058efl" value="<?php echo $preferred_location ?>"/>																
			  </form>
		<?php endif;?>
<!-- End:コンテンツ -->

<?php get_footer(); ?>
<?php if($send_flg == 1):?>
<script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/counseling.js" type="text/javascript"></script>
<?php endif;?>
<?php include(get_theme_root() . '/' . get_template() . "/inc/common-htmlclose.php");?>
