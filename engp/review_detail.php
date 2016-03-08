<?php
require_once( dirname( __FILE__ ) . '/admin.php' );
//データ取得
$rev_detail= engp_get_review_detail($_GET['revid']);


/***************************************************************/
// レビュー承認/未承認/削除
/***************************************************************/
function engp_review_detail_status_update($rev_detail) {
	_log( 'engp_review_detail_status_update' );

	global $wpdb;
	$table_name = $wpdb->prefix . CUSTOM_TBL_SCHOOL_REVIEW;

	$review_id		= $_POST["review_id"];
	$process		= $_POST["process"];

	switch ( $process ) {
		case "unapprove":
			$set_arr = array(
				'approval_flg'			=> UNAPPROVED_FLG,
				'update_date'			=> date_i18n( "Y-m-d H:i:s" ),
			);
			break;
		case "approve":
			$set_arr = array(
				'approval_flg'			=> APPROVED_FLG,
				'update_date'			=> date_i18n( "Y-m-d H:i:s" ),
			);
			if ( $_POST["approve"] && $_POST["select_comment"]):
				$select_comment	= $_POST["select_comment"];
				$set_arr['selected_comment'] = $rev_detail -> $select_comment;
			endif;
			break;
		case "delete":
			$set_arr = array(
				'delete_flg'			=> 1,
				'update_date'			=> date_i18n( "Y-m-d H:i:s" ),
			);
			break;
		case "photo_delete":
			;
			$new_files = str_replace($rev_detail -> delete_file.',','',$rev_detail -> photo_name);
			$set_arr = array(
				'photo_name'			=> $new_files,
				'update_date'			=> date_i18n( "Y-m-d H:i:s" ),
			);
			break;
	}

	$wpdb->update( $table_name, $set_arr, array( 'review_id' => $review_id, 'delete_flg' => 0 ) );

}



//画像ファイル有りの場合
$origin = null;
if($rev_detail -> photo_name){
	//画像ファイル取得
	$files = $rev_detail -> photo_name;
	$file_list = explode(',',$files);
	array_pop($file_list);
	//画像ファイルのフォルダ定義
	$unapproved_dir = PHOTO_DIR.$rev_detail -> post_id.'/unapproved/';
	$approved_dir = PHOTO_DIR.$rev_detail -> post_id.'/approved/';
	$disp_unapproved = PHOTO_URL.$rev_detail -> post_id.'/unapproved/';
	$disp_approved = PHOTO_URL.$rev_detail -> post_id.'/approved/';
	$delete_dir = PHOTO_DIR.'delete/';
	//遷移元定義
	if ( $rev_detail->approval_flg == UNAPPROVED_FLG):
		$origin = $unapproved_dir;
		$disp_origin = $disp_unapproved;
	else:
		$origin = $approved_dir;
		$disp_origin = $disp_approved;
	endif;
}

//ボタン押下時の処理(ファイル遷移、DB更新)
//承認
if ( $_POST["approve"] ):
	$_POST["process"]="approve";
	foreach($file_list as $photo_file){
		rename($origin.$photo_file, $approved_dir.$photo_file);
	}
	$disp_origin = $disp_approved;
	engp_review_detail_status_update($rev_detail);
//未承認
elseif ( $_POST["unapprove"] ):
	$_POST["process"]="unapprove";
	foreach($file_list as $photo_file){
		rename($origin.$photo_file, $unapproved_dir.$photo_file);
	}
	$disp_origin = $disp_unapproved;
	engp_review_detail_status_update($rev_detail);
//削除
elseif ( $_POST["delete"] ):
	$_POST["process"]="delete";
	foreach($file_list as $photo_file){
		rename($origin.$photo_file, $delete_dir.$photo_file);
	}
	engp_review_detail_status_update($rev_detail);
//画像削除
elseif ( $_POST["photo_delete0"] ):
	$_POST["process"]="photo_delete";
	$rev_detail -> delete_file = $file_list[0];
	rename($origin.$file_list[0], $delete_dir.$file_list[0]);
	engp_review_detail_status_update($rev_detail);
elseif ( $_POST["photo_delete1"] ):
	$_POST["process"]="photo_delete";
	$rev_detail -> delete_file = $file_list[1];
	rename($origin.$file_list[1], $delete_dir.$file_list[1]);
	engp_review_detail_status_update($rev_detail);
elseif ( $_POST["photo_delete2"] ):
	$_POST["process"]="photo_delete";
	$rev_detail -> delete_file = $file_list[2];
	rename($origin.$file_list[2], $delete_dir.$file_list[2]);
	engp_review_detail_status_update($rev_detail);
elseif ( $_POST["photo_delete3"] ):
	$_POST["process"]="photo_delete";
	$rev_detail -> delete_file = $file_list[3];
	rename($origin.$file_list[3], $delete_dir.$file_list[3]);
	engp_review_detail_status_update($rev_detail);
endif;

//最新データ取得(表示用)
$rev_detail= engp_get_review_detail($_GET['revid']);
//添付ファイル(表示用)
$file_list = array();
if($rev_detail -> photo_name){
	$files = $rev_detail -> photo_name;
	$file_list = explode(',',$files);
	array_pop($file_list);
}

?>

<html>
	<head>
		<script type="text/javascript" src="<?php echo  get_bloginfo('template_url') ?>/js/jquery-ui-1.11.2.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo  get_bloginfo('template_url') ?>/js/jquery.jqGrid.min.js"></script>
		<script type="text/javascript" src="<?php echo  get_bloginfo('template_url') ?>/js/grid.locale-ja.js"></script>
		<script type="text/javascript" src="<?php echo  get_bloginfo('template_url') ?>/js/admin-common.js"></script>
		<style type="text/css">
			body{
				background-color:#F7F7F7;
			}
			table{
				border: 1px solid #ccc;
				background-color:#fff;
				padding:25px;
			}

			table,td{
				padding-bottom:10px;
			}
			hr{
				border:1px solid #cdcdcd;
				border-top-width:0px;
			}

			.title{
				font-weight:800;
			}


		</style>
	</head>
	<body>
		<div align="right"><input type="button" value="閉じる" onclick="window.opener.location.reload(),window.close()"></div>
		<table width="100%">
			<tbody>
				<tr>
					<td class="title">名前</td>
					<td colspan="2"><?php echo esc_html($rev_detail -> open_name); ?></td>
				</tr>
				<tr>
					<td colspan="2"><hr></td>
				</tr>
				<tr>
					<td class="title">学校周辺の治安</td>
					<td>
						<?php
							switch ( $rev_detail ->security_evaluation ) {
								case "5":
									echo "5:良かった";
									break;
								case "4":
									echo "4:まあまあ";
									break;
								case "3":
									echo "3:ふつう";
									break;
								case "2":
									echo "2:あまり良くなかった";
									break;
								case "1":
									echo "1:悪かった";
									break;
							}
						?>
					</td>
				</tr>
				<tr>
					<td class="title">交通の便</td>
					<td>
						<?php
							switch ( $rev_detail ->traffic_evaluation ) {
								case "5":
									echo "5:良かった";
									break;
								case "4":
									echo "4:まあまあ";
									break;
								case "3":
									echo "3:ふつう";
									break;
								case "2":
									echo "2:あまり良くなかった";
									break;
								case "1":
									echo "1:悪かった";
									break;
							}
						?>
					</td>
				</tr>
				<tr>
					<td class="title">衛生面(綺麗さ)</td>
					<td>
						<?php
							switch ( $rev_detail ->clean_evaluation ) {
								case "5":
									echo "5:良かった";
									break;
								case "4":
									echo "4:まあまあ";
									break;
								case "3":
									echo "3:ふつう";
									break;
								case "2":
									echo "2:あまり良くなかった";
									break;
								case "1":
									echo "1:悪かった";
									break;
							}
						?>
					</td>
				</tr>
				<tr>
					<td class="title">学校スタッフの対応</td>
					<td>
						<?php
							switch ( $rev_detail ->staff_evaluation ) {
								case "5":
									echo "5:良かった";
									break;
								case "4":
									echo "4:まあまあ";
									break;
								case "3":
									echo "3:ふつう";
									break;
								case "2":
									echo "2:あまり良くなかった";
									break;
								case "1":
									echo "1:悪かった";
									break;
							}
						?>
					</td>
				</tr>
				<tr>
					<td class="title">授業内容</td>
					<td>
						<?php
							switch ( $rev_detail ->lesson_evaluation ) {
								case "5":
									echo "5:良かった";
									break;
								case "4":
									echo "4:まあまあ";
									break;
								case "3":
									echo "3:ふつう";
									break;
								case "2":
									echo "2:あまり良くなかった";
									break;
								case "1":
									echo "1:悪かった";
									break;
							}
						?>
					</td>
				</tr>
				<tr>
					<td class="title">周りの学生の真剣さ</td>
					<td>
						<?php
							switch ( $rev_detail ->student_evaluation ) {
								case "5":
									echo "5:良かった";
									break;
								case "4":
									echo "4:まあまあ";
									break;
								case "3":
									echo "3:ふつう";
									break;
								case "2":
									echo "2:あまり良くなかった";
									break;
								case "1":
									echo "1:悪かった";
									break;
							}
						?>
					</td>
				</tr>

				<tr>
					<td colspan="2"><hr></td>
				</tr>
<?php
if ( $rev_detail->comment ):
?>
				<tr>
					<td colspan="2" class="title">あなたの学校の大体の国籍比率を教えて下さい</td>
				</tr>
				<tr>
					<td colspan="2"><?php echo $rev_detail -> answer_1 ?></td>
				</tr>

				<tr>
					<td colspan="2"><hr></td>
				</tr>

				<tr>
					<td colspan="2" class="title">あなたの学校で気に入ってる先生やクラスを教えて下さい</td>
				</tr>
				<tr>
					<td colspan="2"><?php echo $rev_detail -> answer_2 ?></td>
				</tr>

				<tr>
					<td colspan="2"><hr></td>
				</tr>

				<tr>
					<td colspan="2" class="title">その他、あなたの学校で気に入ってる点について教えてください</td>
				</tr>
				<tr>
					<td colspan="2"><?php echo $rev_detail -> answer_3 ?></td>
				</tr>

				<tr>
					<td colspan="2"><hr></td>
				</tr>

				<tr>
					<td colspan="2" class="title">その他、あなたの通っている学校について気に入らない点について教えて下さい</td>
				</tr>
				<tr>
					<td colspan="2"><?php echo $rev_detail -> answer_4 ?></td>
				</tr>

				<tr>
					<td colspan="2"><hr></td>
				</tr>

				<tr>
					<td colspan="2" class="title">入学の決め手</td>
				</tr>
				<tr>
					<td colspan="2">
					<?php
					$change_comment = preg_replace('/<br[[:space:]]*\/?[[:space:]]*>/i', "", $rev_detail->comment);
					echo nl2br(esc_html($change_comment));
					?></td>
				</tr>

				<tr>
					<td colspan="2"><hr></td>
				</tr>

<?php
else:
?>
				<tr>
					<td colspan="2" class="title">ご利用者の声</td>
				</tr>
				<tr>
					<td colspan="2">
					<?php
					$change_selected_comment = preg_replace('/<br[[:space:]]*\/?[[:space:]]*>/i', "", $rev_detail->selected_comment);
					echo nl2br(esc_html($change_selected_comment));
					?></td>
				</tr>

				<tr>
					<td colspan="2"><hr></td>
				</tr>
<?php
endif;
?>
				<tr>
					<td class="title">満足度</td>
					<td>
					<?php
						switch ( $rev_detail -> satisfaction_evaluation ) {
							case "1":
								echo "★☆☆☆☆";
								break;
							case "2":
								echo "★★☆☆☆";
								break;
							case "3":
								echo "★★★☆☆";
								break;
							case "4":
								echo "★★★★☆";
								break;
							case "5":
								echo "★★★★★";
								break;
						}
					?>

					</td>
				</tr>
				<tr>
					<td colspan="2"><hr></td>
				</tr>
				<tr>
					<td colspan="2" class="title">投稿写真</td>
				</tr>
				<tr>
					<td colspan="2">
						<?php
						foreach($file_list as $photo_file){
							echo '<a href='.$origin.$photo_file.' >';
							echo '<img border="0" src='.$disp_origin.$photo_file.' width="128" height="128">';
							echo '</a>';
						}
						?>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<form action="" name="form" method="post">
							<input type="hidden" name="review_id" value=<?php echo $rev_detail -> review_id; ?> >
						<?php
						$i = 0;
						foreach($file_list as $photo_file){
						?>
							<input align="right" type="submit" name="<?php echo "photo_delete".$i; ?>" value="削除" style="width: 124px;" onclick='return confirm("削除すると、戻せませんがよろしいですか？");'>
						<?php
							$i++;
						}
						?>
						</form>
					</td>
				</tr>
				<tr>
					<td colspan="2"><hr></td>
				</tr>
				<tr>
					<td colspan="2" class="title">リピート割引</td>
				</tr>
				<tr>
					<td colspan="2">
						<?php
						if ($rev_detail -> repeat_discount_know ='1'){
							echo "知ってはいた";
						}else{
							echo "知らなかった";
						}
						?>
					</td>
				</tr>
				<tr>
					<td colspan="2"><hr></td>
				</tr>
				<form action="" name="form" method="post">
					<input type="hidden" name="review_id" value=<?php echo $rev_detail -> review_id; ?> >
<?php if ( $rev_detail->approval_flg == UNAPPROVED_FLG && $rev_detail->comment): ?>
				<tr>
					<td colspan="2" class="title">表示するコメントを選んでください</td>
				</tr>
				<tr>
					<td colspan="2">
<SELECT name="select_comment">
	<OPTION value="comment">入学の決め手</OPTION>
	<OPTION value="answer_1">あなたの学校の大体の国籍比率を教えて下さい</OPTION>
	<OPTION value="answer_2">あなたの学校で気に入ってる先生やクラスを教えて下さい</OPTION>
	<OPTION value="answer_3">その他、あなたの学校で気に入ってる点について教えてください</OPTION>
	<OPTION value="answer_4">その他、あなたの通っている学校について気に入らない点について教えて下さい</OPTION>
</SELECT>
				</tr>
				<tr>
					<td colspan="2"><hr></td>
				</tr>
<?php endif; ?>
				<tr>
					<td colspan="2" align="right">
<?php  if ( $rev_detail->approval_flg == UNAPPROVED_FLG ): ?>
						<input align="right" type="submit" name="approve" value="承認する" onclick='return confirm("承認しますがよろしいですか？");'>
<?php else: ?>
						<input align="right" type="submit" name="unapprove" value="未承認にする" onclick='return confirm("未承認しますがよろしいですか？");'>
<?php endif; ?>
						<input align="right" type="submit" name="delete" value="削除" onclick='return confirm("削除すると、戻せませんがよろしいですか？");'>
					</form>
					<input type="button" value="閉じる" onclick="window.opener.location.reload(),window.close()">
					</td>
				</tr>
			</tbody>
		</table>
	</body>
</html>