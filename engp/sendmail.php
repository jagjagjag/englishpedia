<?php
/*
 Template Name: Send Mail
 Description: This template is used to send email to user from the estimate page.
 Created by: Odysseus Ambut
*/

get_header(); 

?>
	
<?php /*Get Details From Post*/
$admission_fee_usd = $_GET['adm_fee_usd'];
$admission_fee_jpy = $_GET['adm_fee_jpy'];
$tuition_usd = $_GET['t_usd'];
$tuition_jpy = $_GET['t_jpy'];
$i20_issuance_postage_usd = $_GET['issuance_usd'];
$i20_issuance_postage_jpy = $_GET['issuance_jpy'];
$totalcost_usd = $_GET['tcost_usd'];
$totalcost_jpy = $_GET['tcost_jpy'];
$table_title = $_GET['c_title'];
$school_name = $_GET['school_n'];
$email = $_GET['recEmail'];
$name = $_GET['recName'];
$back = $_SERVER['HTTP_REFERER'];
?>




<?php
$to = "$email, ody@web-mech.net";
$subject = "$school_name - Cost Estimates";

$message = "
<html>
<head>
<title>Cost Estimates</title>
</head>
<body>
<p>Hello $name. <br><br>以下、以前メールでリクエスト頂いたものの詳細になります。: <br><br></p>
<p>留学費用 【 $table_title 】 </p> <br>
<p>学校名: $school_name </p> <br>
<table border='1' style='text-align: center'>
<tr>
<th scope='row'>&nbsp;</th>
<td>ドル（米）</td>
<td>日本円換算</td>
</tr>
<tr>
<th scope='row'>入学金</th>
<td>$admission_fee_usd</td>
<td>$admission_fee_jpy</td>
</tr>
<tr>
<th scope='row'>授業料</th>
<td>$tuition_usd</td>
<td>$tuition_jpy</td>
</tr>
<tr>
<th scope='row'>I-20発行費</th>
<td>$i20_issuance_postage_usd</td>
<td>$i20_issuance_postage_jpy</td>
</tr>
<tr>
<th scope='row'>合計</th>
<td>$totalcost_usd</td>
<td>$totalcost_jpy</td>
</tr>
</table>
<h3>自動見積もり結果</h3>
<p style = 'color:red'>※この自動見積もりは概算です。</p>
<p>この見積りには空港出迎え費用や航空券などの費用は含まれていません。</p>
<p>オプションなども含めた詳細見積りが必要な場合は、お電話にてお申し出ください。</p>
<br><br>
<p>ご不明な点がございましたら、こちらの電話番号にお問い合わせ下さい。:</p>
<p>代表　(日本) : 03-5332-7432</p>
<p>フリーダイヤル: 0120-070-050</p>
<p>代表　(米国): 310-575-4636</p>
<p>www.englishpedia.jp</p>
</body>
</html>
";

//content-type
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

//headers
$headers .= "From: 大塚　庸平<englishpedia@ryugaku-johokan.com>" . "\r\n";

mail($to,$subject,$message,$headers);

?>

<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h4>メールは '<?php echo $email ?>' より送信されました。.</h4>
				<a href="<?php echo $back ?>">前のページ戻る...</a>
		</div>
	</div>

	
</div>
<script>
function goBack() {
    window.history.back();
}
</script>

