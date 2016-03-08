<?php
/*
 Template Name: お問い合わせ_送信完了
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
<h1 class="regist_entry_title hidden-xs">お問い合わせ</h1>
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
		$last_name = $_POST["last_name"];
		$first_name = $_POST["first_name"];
		$prefectures = $_POST["prefectures"];
		$email = $_POST["email"];
		$phone = $_POST["phone"];
		$purpose = $_POST["purpose"];
		$image = $_POST["image"];
		$period = $_POST["period"];
		$consultation = $_POST["consultation"];
		$fb = $_POST["fb"];
		$yahoo = $_POST["yahoo"];
		$google = $_POST["google"];
		$twitter = $_POST["twitter"];
		$friend = $_POST["friend"];
		$other = $_POST["other"];
		
		$fb				= $_POST["fb"];
		$yahoo			= $_POST["yahoo"];
		$google			= $_POST["google"];
		$twitter		= $_POST["twitter"];
		$friend			= $_POST["friend"];
		$other			= $_POST["other"];
		
		if(!empty($fb)){
			$media = '「留学」Facebookページ/';
		}
		if(!empty($yahoo)){
			$media .= 'Yahoo検索/';
		}
		if(!empty($google)){
			$media .= 'Google検索/';
		}
		if(!empty($twitter)){
			$media .= 'Twitter/';
		}
		if(!empty($friend)){
			$media .= '友人の紹介/';
		}
		if(!empty($other)){
			$media .= 'その他';
		}
		
		$from_addr = MASTER_MAIL_ADDRES;
		$to_addr = $email;
		$header = "From: ".$from_addr;
		$footer = MASTER_MAIL_FOOTER;
		
	
		$subject = "【EnglishPedia】お問い合わせありがとうございました";
	
		$body_content = <<<BODY
$last_name $first_name 様
	
この度はEnglishPediaにお問い合わせ頂きありがとうございました。
下記の内容にてお問い合わせを承りました。
担当者よりご連絡させて頂きますので、
今しばらくお待ち頂けますようよろしくお願いいたします。
	
--------------------------------- 
	
■お名前：
$last_name $first_name 様

■都道府県：
$prefectures

■メールアドレス：
$email
	
■携帯電話：
$phone
	
■希望都市イメージ：
$image
	
■渡航時期：
$period
	
■相談したい内容：
$consultation
	
■EnglishPediaを知った媒体
$media
	
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
			<div id="regist_results_line"><h2>お問い合わせありがとうございました。</h2><br />EnglishPediaサポートセンターよりご連絡させていただきます。<br />今しばらくお待ち頂けますようよろしくお願いいたします。</div>
			<a href="<?php echo esc_url(home_url());?>"><img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/btn_regist_top.png" width="230" height="50" alt="EnglishPediaトップページへ戻る" class="btn_regist_top"/></a>
		</div>
	</div>
</div>
			<!-- salesforce用 -->
			<?php if($send_flg==1):?>
				<form name="inquiry">
					<div class="clear"></div>				
					<input type=hidden name="oid" value="00D10000000KUjS">
					<input type=hidden name="retURL" value="<?php echo esc_url(home_url());?>/inquiry_result">
					<input type="hidden" id="first_name" name="first_name" value="<?php echo $first_name ?>"/>
					<input type="hidden" id="last_name" name ="last_name"value="<?php echo $last_name ?>"/>
					<input type="hidden" id="00N10000002bLGW" name="00N10000002bLGW" value="<?php echo $prefectures ?>"/>
					<input type="hidden" id="email" name="email" value="<?php echo $email ?>"/>
					<input type="hidden" id="00N10000001Ze8Y" name="00N10000001Ze8Y" value="<?php echo $phone ?>"/>
					<input type="hidden" id="00N10000002bHB3" name="00N10000002bHB3" value="<?php echo $purpose ?>"/>
					<input type="hidden" id="00N10000002bMx2" name="00N10000002bMx2" value="<?php echo $image ?>"/>
					<input type="hidden" id="00N10000001Ze8n" name="00N10000001Ze8n" value="<?php echo $period ?>"/>
					<input type="hidden" id="00N10000001ZgGk" name="00N10000001ZgGk" value="<?php echo $consultation ?>"/>

					<?php
						if(!empty($fb)){$hidden_html .= '<input type="hidden" id="00N10000001ZgHd" name="00N10000001ZgHd" value="1" />';}
						if(!empty($yahoo)){$hidden_html .= '<input type="hidden" id="00N10000001ZgGz" name="00N10000001ZgGz" type="checkbox" value="1" />';}
						if(!empty($google)){$hidden_html .= '<input type="hidden" id="00N10000001ZgH4" name="00N10000001ZgH4" type="checkbox" value="1" />';}
						if(!empty($twitter)){$hidden_html .= '<input type="hidden" id="00N10000001ZgFi" name="00N10000001ZgFi" type="checkbox" value="1" />';}
						if(!empty($friend)){$hidden_html .= '<input type="hidden" id="00N10000001ZgHO" name="00N10000001ZgHO" type="checkbox" value="1" />';}
						if(!empty($other)){$hidden_html .= '<input type="hidden" id="00N10000001ZgFY" name="00N10000001ZgFY" type="checkbox" value="1" />';}
						echo $hidden_html;
					?>
				</form>
		  <?php endif;?>

<!-- End:コンテンツ -->

<?php get_footer(); ?>
<?php if($send_flg == 1):?>
	<script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/inquiry.js" type="text/javascript"></script>
<?php endif;?>
<?php include(get_theme_root() . '/' . get_template() . "/inc/common-htmlclose.php");?>
