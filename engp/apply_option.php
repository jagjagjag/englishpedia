<?php
/*
 Template Name: 留学申し込み_オプション
 */

session_cache_limiter('private_no_expire');

//希望学校
$postID		= $_POST["postID"];

//コース
$get_course = $_POST["course"];
//開始年月　年
$get_start_year = $_POST["start_year"];
//開始年月　月
$get_start_month = $_POST["start_month"];
//留学期間
$get_period = $_POST["period"];
//滞在先
$get_stay_type = $_POST["stay_type"];
//滞在先の手配期間
$get_arrange_period = $_POST["arrange_period"];
if($get_arrange_period == ""){
	$get_arrange_period = "手配を依頼しない";
}

//姓
$get_last_name = $_POST["last_name"];
//名
$get_first_name = $_POST["first_name"];
//セイ
$get_last_name_kana = $_POST["last_name_kana"];
//メイ
$get_first_name_kana = $_POST["first_name_kana"];
//電話 1
$get_tel = $_POST["tel"];
//メール
$get_email = $_POST["email"];
//郵便番号
$get_postal = $_POST["postal"];
//都道府県
$get_prefecture = $_POST["prefecture"];
//ご住所
$get_address = $_POST["address"];
//建物名
$get_build = $_POST["build"];

//レビュー投稿キャンペーン
$get_campaign = $_POST["campaign"];

if(!$get_campaign){
	$get_campaign = "参加しない";
}

get_header('nologin');
?>

<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/css/apply-style.css' ); ?>"/>

<!-- Start: タイトル、hr -->
<h1 class="apply_entry_title">オプションのご確認</h1>
<hr>
<!-- End: タイトル、hr -->

<!-- Start: コンテンツ -->
<div class="container">
	<div class="apply_main">
		<div class ="apply_content_box">
			<form name="form_conf" id="form_conf" method="post" action="<?php echo home_url(); ?>/apply_conf">
		
				<div class="apply_form">
					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<p class="option_first">お申込みありがとうございます。<br>続けてオプションサービスについてお伺いさせてください。</p>
						
							<h2 class="option">ビザ申請サポート</h2>
							<div class="option_box">
								<div class="row">
									<div class="col-xs-6">
										<img src="<?php echo esc_url(get_template_directory_uri());?>/images/visa_support2.png" class="img-responsive mgnB16">									
									</div>
									<div class="col-xs-6">
										<img src="<?php echo esc_url(get_template_directory_uri());?>/images/visa_support1.png" class="img-responsive mgnB16">									
									</div>
								</div>
							
								<div>
									<input type="radio" value="ビザを取得しない予定（短期留学）" name="option1" id="option1_yes">
									<label for="option1_yes">ビザを取得しない予定（短期留学）</label>
								</div>
								<div>
									<input type="radio" value="ビザ申請サポートに申込む" name="option1" id="option1_yes2">
									<label for="option1_yes2">ビザ申請サポートに申込む</label>
								</div>
								<div>
									<input checked type="radio" value="自分でビザの手続きをする（無料）" name="option1" id="option1_no">
									<label for="option1_no">自分でビザの手続きをする（無料）</label>
								</div>
								<p class="price">14,800円（税込み）</p>
								<p class="option_description">
									ビザ申請サポートとは面倒なビザ申請手続き書類の作成を代行するサービスです。ご依頼のない場合、手続きの方法についてご案内はさせて頂きますが実際のお手続きはご自身でご手配頂きます。
								</p> 
							</div>
						</div>
							
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<h2 class="option">飛行機チケットの手配</h2>							
							<div class="option_box">
								<div class="row">
									<div class="col-xs-6">
										<img src="<?php echo esc_url(get_template_directory_uri());?>/images/ticket1.png" class="img-responsive mgnB16">									
									</div>
									<div class="col-xs-6">
										<img src="<?php echo esc_url(get_template_directory_uri());?>/images/ticket2.png" class="img-responsive mgnB16">									
									</div>
								</div>
							
								<div>
									<input type="radio" value="依頼する" name="option2" id="option2_yes">
									<label for="option2_yes">依頼する</label>
								</div>
								<div>
									<input checked type="radio" value="依頼しない" name="option2" id="option2_no">
									<label for="option2_no">依頼しない</label>
								</div>
								<p class="price">無料</p>							
								<p class="option_description">
									渡航時の飛行機チケットの手配を希望される場合はご依頼下さい。
									<br>
									<br>
									<span>
										<u><b>ポイント！！</b></u><br>
										こちらのサービスは必ずしも最安値を保証するものではありません。
										1円でも安いチケットをお求めの場合はインターネット旅行サイトや複数の旅行代理店から見積りを取ることをオススメします。
										とにかく、全部丸投げしたい人向けのサービスです。
									</span>
								</p> 
							</div>							
						</div>
						
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<h2 class="option">海外留学保険の取得</h2>
							<div class="option_box">
								<div class="row">
									<div class="col-xs-6">
										<img src="<?php echo esc_url(get_template_directory_uri());?>/images/insurance2.png" class="img-responsive mgnB16">									
									</div>
									<div class="col-xs-6">
										<img src="<?php echo esc_url(get_template_directory_uri());?>/images/insurance1.png" class="img-responsive mgnB16">									
									</div>
								</div>
							
								<div>
									<input type="radio" value="加入する" name="option3" id="option3_yes">
									<label for="option3_yes">加入する</label>
								</div>
								<div class="mgnB16">
									<input checked type="radio" value="加入しない" name="option3" id="option3_no">
									<label for="option3_no">加入しない</label>
									<p>※学校によっては加入の証明が必要となります</p>
								</div>
								<p class="option_description">
									留学中の保険加入は必須です。
									現地での医療代や危害損壊、携行品の損害など、何かあった時に備え、安心した留学生活をお送り下さい。
									
									<br>
									<br>
									<span>
										<u><b>ポイント！！</b></u><br>
										アメリカの医療は想像以上にかかると思っていて下さい。
										1回の治療で10万円、1日入院して100万円を超える事もザラ。
										未加入で留学することのリスクは計り知れません。
										何かしらの保険には必ずご加入下さい。									
									</span>
								</p> 
							</div>							
						</div>

						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<h2 class="option">空港出迎え・現地留学サポート</h2>
							<div class="option_box">
								<div class="row">
									<div class="col-xs-6">
										<img src="<?php echo esc_url(get_template_directory_uri());?>/images/option_support1.jpg" class="img-responsive mgnB16">									
									</div>
									<div class="col-xs-6">
										<img src="<?php echo esc_url(get_template_directory_uri());?>/images/option_support2.jpg" class="img-responsive mgnB16">									
									</div>
								</div>
								<div>
									<input type="radio" value="空港出迎えのみ" name="option4" id="option4_yes">
									<label for="option4_yes">空港出迎えのみ</label>
								</div>
								<div>
									<input checked type="radio" value="はじめの1ヶ月だけ加入" name="option4" id="option4_month">
									<label for="option4_month">はじめの1ヶ月だけ加入</label>
								</div>
								<div>
									<input checked type="radio" value="念のために留学期間分加入" name="option4" id="option4_full">
									<label for="option4_full">念のために留学期間分加入</label>
								</div>
								<div>
									<input checked type="radio" value="何も加入しない" name="option4" id="option4_no">
									<label for="option4_no">何も加入しない</label>
								</div>
							
								<p class="price">
									・空港出迎えサポート<br>
									学校によって料金が異なります。（100ドル～200ドル程度）<br>
									<br>
									・現地留学サポート（税込み）<br>
									38,000円（1ヶ月間）<br>
									48,000円（3ヶ月間）<br>
									58,000円（6ヶ月間）<br>
									68,000円（1年間）<br>
									<span><br>
										※留学期間と同じ必要はございません。<br>
									</span>
								</p>														
								<p class="option_description">
									・空港出迎え<br>
									現地到着日当日、空港にお迎えに上がるサービスです。多くの場合学校のスタッフがお迎えに上がります。<br>
　　　　　　							<br>
									・現地留学サポート<br>
									現地の日本人スタッフがお出迎えにあがり、現地生活に関するオリエンテーションの実施ほか、現生活の立ち上げをサポートいたします。また、留学中の緊急時24時ホットラインなど、安心の留学生活が送れます。<br>
									※対応可能エリア：ロサンゼルス、ニューヨーク、サンフランシスコ、ハワイ<br>
									<br>
								</p> 
								
							</div>							
						</div>
						
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<h2 class="option">オンライン英会話レッスン</h2>
							<div class="option_box">
								<img src="<?php echo esc_url(get_template_directory_uri());?>/images/option_lesson.png" class="img-responsive mgnB16">
								<div>
									<input type="radio" value="受講する" name="option5" id="option5_yes">
									<label for="option5_yes">受講する</label>
								</div>
								<div>
									<input checked type="radio" value="受講しない" name="option5" id="option5_no">
									<label for="option5_no">受講しない</label>
								</div>
							
								<p class="price">無料</p>														
								<p class="option_description">
									イングリッシュペディアを通じてお申し込みを頂いた方には、もれなく出発前のオンライン英会話レッスンが無料でご受講いただけます。<br>
									SKYPEを通じてのマンツーマンレッスンなので、英語力に自信がない方でも安心して英会話をお楽しみいただけます。<br>
									※12週間以内のお客様：2レッスン<br>
									※12週間以上お客様：8レッスン
									<br>
								</p> 
								
							</div>							
						</div>
						
					</div>
	
	
					<div id="apply_conf_buttons">
						<input type="button" src="../images/return.png" alt="戻る" value="" onClick="history.go(-1)" id="btn_apply_return"/>
						<input type="submit" src="../images/send.png" alt="確認" name="btn02" value="" id="btn_apply_check"/>
					</div>
					<div class="clear"></div>
					<input type="hidden" name="purpose" value="<?php echo $get_purpose ?>" />
					<input type="hidden" name="postID" value="<?php echo $postID; ?>" />
					<input type="hidden" name="course" value="<?php echo $get_course ?>" />
					<input type="hidden" name="school_hours" value="<?php echo $get_hours ?>" />				
					<input type="hidden" name="start_year" value="<?php echo $get_start_year ?>" />
					<input type="hidden" name="start_month" value="<?php echo $get_start_month ?>" />
					<input type="hidden" name="period" value="<?php echo $get_period ?>" />
					<input type="hidden" name="stay_type" value="<?php echo $get_stay_type ?>" />				
					<input type="hidden" name="arrange_period" value="<?php echo $get_arrange_period ?>" />								
					<input type="hidden" name="last_name" value="<?php echo esc_attr($get_last_name) ?>" />
					<input type="hidden" name="first_name" value="<?php echo esc_attr($get_first_name) ?>" />
					<input type="hidden" name="last_name_kana" value="<?php echo esc_attr($get_last_name_kana) ?>" />
					<input type="hidden" name="first_name_kana" value="<?php echo esc_attr($get_first_name_kana) ?>" />
					<input type="hidden" name="tel" value="<?php echo esc_attr($get_tel) ?>" />
					<input type="hidden" name="email" value="<?php echo esc_attr($get_email) ?>" />
					<input type="hidden" name="postal" value="<?php echo esc_attr($get_postal) ?>" />
					<input type="hidden" name="prefecture" value="<?php echo $get_prefecture ?>" />
					<input type="hidden" name="address" value="<?php echo esc_attr($get_address) ?>" />
					<input type="hidden" name="build" value="<?php echo esc_attr($get_build) ?>" />
					<input type="hidden" name="campaign" value="<?php echo $get_campaign ?>" />
				</div>
			</form>
		</div>
	</div>
</div>
<!-- End:コンテンツ -->

<?php get_footer(); ?>
<?php include(get_theme_root() . '/' . get_template() . "/inc/common-htmlclose.php");?>
