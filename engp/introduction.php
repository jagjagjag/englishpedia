<?php
/*
Template Name: EnglishPediaについて
*/
get_header();
?>

<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/css/other.css' ); ?>"/>

<!-- Start: コンテンツ -->
	<!-- Start: タイトル、hr -->
	<h1 class="int_h">EnglishPediaについて</h1>    
	<hr> 
	<!-- End: タイトル、hr -->

	<!-- Start: コンテンツ -->
	<div class="container">
		<div class="int_main_small">

			<!-- Start: キャッチコピー -->
			<div class="int_catch">
				<img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/int_loupe.png"  alt="EnglishPedia" class="loupe mob_none">
				<h2 class="mob_none">EnglishPediaは、<br>アメリカ留学のための学校情報比較サイトです。</h2>
				<h2 class="pc_none tab_none" style="text-align:center;">EnglishPediaは<br>アメリカ留学のための<br>学校情報比較サイトです。</h2>				
			</div>
			<!-- End: キャッチコピー -->

			<!-- Start: フキダシ１?3 -->
			<div class="row hidden-xs hidden-sm">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="text-align:center">
				<img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/int_img_01.png" alt="留学先の学校を探せる" class="int_img01">
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="text-align:center">
				<img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/int_img_02.png" alt="学校情報も充実" class="int_img01">
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="text-align:center">
				<img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/int_img_03.png" alt="学校を比較できる" class="int_img01">
				</div>
			</div>
			<!-- End: フキダシ１?3 -->
			<!-- Start: フキダシ モバイル -->
			<div class="hidden-md hidden-lg"> 
				
				<img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/int_img_mob01.png" alt="イングリッシュペディアの使い方" class="int_img01">
			
			</div>
			<!-- End: フキダシ モバイル-->

            
		<div class="row com_mission3">
		<div class="col-sm-6">
			<a href="#howtouse">
			<div class="int_button3"><img class="int_icon01" src="<?php echo esc_url( get_template_directory_uri()); ?>/images/int_hatena.png">Englishpediaの使い方</div></a>
		</div>
		<div class="col-sm-6">
			<a href="#support">
            <div class="int_button3"><img class="int_icon01" src="<?php echo esc_url( get_template_directory_uri()); ?>/images/int_surpport.png">Englishpediaのサポート</div></a>
		</div>
        </div>
        
        <div class="com_title2" id="howtouse">EnglishPediaの使い方</div>
        
			<!-- Start: ステップ1-->
			<div class="int_title">
				<div class="circle">1</div>
				<h2>学校検索をしよう</h2>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<p class="int_letter1">エリア、目的、学費、立地条件など気になる条件で検索してみよう！検索結果を更に詳細な条件で絞り込むことも可能です。</p>
					<div class="int_space"></div>
					<a href="<?php echo esc_url(home_url());?>">
					<div class="int_button"><img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/int_tri.png" alt="学校を検索する" class="int_tri">学校を検索する
					</div></a>
				</div>
				<div class="col-sm-6" align="center">
					<img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/int_img_04.png" alt="TOPページ検索と検索結果画面" class="int_img04"><p class="int_annot">TOPページ検索と検索結果画面</p>
				</div>
			</div>
			<!-- End: ステップ1-->

			<!-- Start: 動画部分
			<div class="int_box1">
				<div class="row">
					<div class="col-sm-6">
						<p class="int_letter2">何を基準に学校を選べばいいの?<br>どういう学校がいい学校なの？</p>
						<p class="int_letter3">そんな悩みを解決するために、EnglishPediaでは学校選びのコツをまとめた動画を作成しました。ぜひ見てみてください。</p>
					</div>
					<div class="col-sm-6" text align="center">
						<iframe width="300" height="169" src="//www.youtube.com/embed/oUoa6jGbQwk" frameborder="0" allowfullscreen></iframe>
						<a href="index.html">
						<div class="int_button"><img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/int_tri.png" alt="動画を観る" class="int_tri">動画を観る
						</div></a>
					</div>
				</div>
			</div>
			<!-- End: 動画部分-->

			<!-- Start: ステップ２-->
			<div class="int_title">
				<div class="circle">2</div>
				<h2>学校情報を見てみよう</h2>
			</div>
			<div class="row">
				<div class="col-sm-4" align="center">
				<img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/int_img_05.png" alt="学校詳細画面" class="int_img05"><p class="int_annot">学校詳細画面</p>
				</div>
				<div class="col-sm-8">
					<p class="int_letter1">学校紹介ページには、現地の学校の写真から実際に留学した人のレビューまで情報が盛りだくさん！じっくり目を通して学校選びの参考にしてみてください。</p>
					<div class="int_box2">
					<h2>お気に入り登録もできる！</h2><p class="int_letter3">お気に入りボタンを押すと、気に入った学校を『お気に入り』に登録できます。<br />登録された学校は、一覧で確認する事ができます。</p>
<!-- 					<div class="int_btn_img1"><img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/int_btn01.png" alt="検索結果画面お気に入りボタン"><br>検索結果画面 お気に入りボタン -->
<!-- 					</div> -->
<!-- 					<div class="int_btn_img2"><img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/int_btn02.png" alt="学校詳細画面お気に入りボタン"><br>学校詳細画面 お気に入りボタン -->
<!-- 					</div> -->
					</div>
				</div>
			</div>
			<!-- End: ステップ2-->

			<!-- Start: ステップ3-->
			<div class="int_title">
				<div class="circle">3</div>
				<h2>学校情報を比較してみよう</h2>
			</div>
			<div class="row">
				<div class="col-sm-4" align="center">
				<img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/int_img_06.png" alt="学校比較画面" class="int_img05"><p class="int_annot">学校比較画面</p>
				</div>
				<div class="col-sm-8">
					<p class="int_letter1">検索結果に表示された学校やお気に入り登録した学校を、一覧で比較することが出来ます。<br>項目別に学校の情報を見比べると、自分が行きたい学校がより明確になってきます。</p>
				</div>
			</div>
			<!-- End: ステップ3-->

			<!-- Start: ステップ4-->
			<div class="int_title">
				<div class="circle">4</div>
				<h2>留学費用の見積もりをしよう</h2>
			</div>
			<p class="int_letter1">どんな学校に行きたいか具体的に候補が出てきたら、留学費用の自動見積もりをしてみましょう。留学期間とコースの選択をすると、具体的な留学費用の見積もりを確認できます。</p>
			<!-- End: ステップ4-->

			<!-- Start: ステップ5-->
			<div class="int_title">
				<div class="circle">5</div>
				<h2>留学のお申し込みをしよう！</h2>
			</div>
			<p class="int_letter1">学校とコースを決めたら、最後はお申し込みです。留学予定時期の半年程前から準備をしておくのがベストです！</p>
			<div class="int_box3">
			無料ユーザー登録
			</div>
			<div class="int_box4">
<!-- 				<p class="int_letter2">留学のお申し込みをするには、ユーザー登録が必要です。</p> -->
<!-- 				<p>ユーザー登録をすると…<br>学校のお気に入りリスト機能、説明会のお申込み、学校留学申込が出来るようになります。</p> -->
				<p class="int_letter2">ユーザー登録をすると…</p>
				<p>検索結果や学校詳細画面から学校をお気に入りリストに登録して、一覧画面で確認することができます！</p>
<!--				<p class="int_letter5">ユーザー登録方法</p> -->
<!--				<div class="int_entry1-2">簡易登録 -->
<!--				</div> -->
<!--				<div class="int_entry1"> -->
<!--				お名前とメールアドレスを入力すると、学校のお気に入りリスト機能が使用できます。 -->
<!--				</div> -->
<!--				<div class="int_entry3-2">本登録 -->
<!--				</div> -->
<!--				<div class="int_entry3"> -->
<!--				簡易登録＋追加の情報を登録すると、説明会へのお申込み、留学申込が可能です。 -->
<!--				</div> -->
				<a href="<?php echo esc_url(home_url());?>/regist"><div class="int_button2"><img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/int_tri.png" alt="ユーザー登録をする（無料）" class="int_tri">ユーザー登録をする（無料）</div></a>
			</div>
			<!-- End: ステップ5-->
		

		<!-- Start: 困った時は…-->
		<div class="int_title">
			<div class="circle">?</div>
			<h2>困った時は…</h2>
		</div>
		<div class="int_li">
			<ul class="int_prob">
				<li>○○のことが気になるけどサイトには掲載されていない</li>
				<li>自分に適した学校がハッキリわからない、悩んでいる</li>
				<li>直接カウンセラーと話をしたい</li>
			</ul>
			<p class="int_letter5">お気軽にご連絡ください！<br />経験豊富なカウンセラーが親身になってお答えします！</p>
		</div>
        
		<div class="row com_mission2">
		<div class="col-sm-6">
			<a href="tel:0120070050" class="button-contact"><div class="int_button3"><img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/int_tel.png"> 0120-070-050</div></a>
		</div>
		<div class="col-sm-6">
			<a href="<?php echo esc_url(home_url());?>/inquiry" class="button-contact"><div class="int_button3"><img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/int_mail.png"> メールでのお問い合わせ</div></a>
		</div>
        </div>
		<!-- End: 困った時は…-->
     
        
 	
    		<div class="com_mission" id="support">
            <div class="com_title2">Englishpediaのサポート</div>
				<div class="com_mission_letters">
                <h1>イングリッシュペディアはお申込み頂いた方が、スムーズに留学出来るよう、また、現地で留学トラブルに巻き込まれないようにサポートいたします。</h1>
<h2>1）学校選びのサポート</h2><br />
イングリッシュペディアは学校選びに、重要となる立地や国際性、都市の特徴などを数字などの客観的なデータにより公表しています。
<br /><br />
これらの評価は私たちが実際に通った人から集めた「生の声」です。<br />
こちらを参考に自分が行きたい大学を、自分自身の手で選択することが出来ます。<br /><br />

また、数字だけでなく実際にアメリカを良く知る留学生の先輩方の声や<br />
ビザや予算など総合的に相談したい方はチャットや電話などでお気軽にご相談下さい。<br /><br /><br />

<h2>2）ビザ申請に関するサポート</h2><br />
90日間以上アメリカに滞在する方は何かしらのビザを取得する必要があります。<br />
一般的に留学生が取得するビザはF（学生）ビザになり、取得には定められた書類の提出と、米国大使館・領事館での面接を受ける必要があります。<br /><br />

この手続に失敗すると申請を却下されてしまったり、滞在期間を短くされてしまったりすることがあります。<br /><br />

イングリッシュペディアは手続きに失敗しない完全マニュアルを提供し、<br />
ご自身でも簡単にビザ手続きをして頂くことが出来るようにサポート。<br /><br />

また、面倒な作業をする時間がない！少しでも取得確率を上げたい！<br />
という方には、手続きを代行するオプションを用意しています。<br />
お気軽にご相談下さい。<br /><br /><br />


<h2>3）留学準備のサポート</h2><br />
イングリッシュペディアでは渡米前の準備も万端！<br />
動画によるオリエンテーションにより、出発前にしておくべき事項を随時確認して頂けます。<br /><br />

飛行機の手配、保険の手配、お金の持ち込み方、持ち物リストなど、不安な要素は解消しておきましょう！<br /><br /><br />


<h2>4）留学中のサポート</h2><br />
イングリッシュペディアのお客様はグループ会社のLos Angeles Info, Inc.がアメリカ現地にて万全のサポートをさせて頂きます。<br /><br />

滞在先や学校のキャンセルや延長手続き、学校とのトラブルなどお気軽にご相談下さい。<br />
（営業時間：米ロサンゼルス現地時間の午前10時～19時）
<br />310-575-4636（米国）<br /><br />

<img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/img_com01.jpg" alt="株式会社留学情報館" class="com_img01">
</div>
            </div>
			<!-- Start: バナー -->
			<div class="other_bn">
            <a href="//nes-ryugaku.com/event_seminar2_all.php"><img class="hidden-xs" src="<?php echo esc_url( get_template_directory_uri()); ?>/images/bn_seminar_long.png" alt="アメリカ現地留学説明会"></a>
			<a href="//nes-ryugaku.com/event_seminar2_all.php"><img class="hidden-md hidden-sm hidden-lg" src="<?php echo esc_url( get_template_directory_uri()); ?>/images/bn_seminar_mob.png" alt="アメリカ現地留学説明会"></a>
			</div>
			<!-- End: バナー -->

			<!-- Start: お問い合わせください -->
			<div class="row" id="contact_box">
				<strong><p style="font-size: 20px; color:#114D9C; text-align:center; line-height: 1.3em">イングリッシュペディアは語学学校の専門サイト<br>
				情報収集・料金の自動見積り・申込みが出来ます！</p></strong>			
							
				<div class="col-md-6 col-sm-6 col-xs-12" id="contact_box_fff" style="margin:0px; padding:10px;">

				<p>「留学はしたいが具体的なプランが決まっていない」「留学に行きたい気持ちはあるが…」まだ留学のプランがおぼろげでも、お気軽にお問い合わせください。<br> 経験豊富なカウンセラーが親身になってお答えいたします。</p>
				<strong><p style="font-size: 18px;">まずはお気軽にお問い合わせください！</p></strong>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12">
				<img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/contact_byphone02.png" alt="お電話でのお問い合わせはこちらから" class="bud_margintop"/>
				<div class="btndeco3"><a href="<?php echo esc_url(home_url());?>/counseling/">無料留学カウンセリングに申し込む</a></div>
				<div>
				</div>
				</div>
            </div>
			<!-- End: お問い合わせください -->

    </div>
</div>
<!-- End:コンテンツ -->
<?php get_footer(); ?>
<?php include(get_theme_root() . '/' . get_template() . "/inc/common-htmlclose.php");?>