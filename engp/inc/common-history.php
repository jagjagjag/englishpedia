<?php
/**
 * 共通部品：閲覧履歴
 * （検索結果・学校詳細で利用）
 */
?>
				<!-- Start: history_window -->
				<div id="history_window">
					<!-- Start: history_window_title -->
					<div id="history_window_title">
						<h1 class="f_left">閲覧履歴</h1>
						<h2 class="f_right"><a href="javascript:void(0)" id="history_del">リセット</a></h2>
						<div class="clear"></div>
					</div>
					<!-- End: history_window_title -->
<?php
	$history = $_COOKIE['ep-history'];
	if(!empty($history)):
		$history_id = explode("_", $history);
		foreach($history_id as $value):
			$historyData = engp_get_history_school($value);
?>
					<!-- Start: history -->
					<div class="history" id="history<?php echo $value; ?>">
						<!-- Start: historybox -->
						<div class="historybox" id="historybox<?php echo $value; ?>">
							<img class="f_left ranking_photo" style="width:90px; height:90px;" src="<?php echo $historyData['sch_img']; ?>" alt="Photo">
							<!-- Start: historybox_category -->
							<div class="historybox_category" id="historybox_category<?php echo $value; ?>">
								<p><a href="<?php echo home_url(); ?>?school=<?php echo $value; ?>"><?php echo $historyData['sch_name']; ?></a></p>
								<p><img class="lank" src="<?php echo $historyData['star_img']; ?>" ></p>
								<p><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/america_info.png" alt="サンフランシスコ"><?php echo $historyData['sch_city']; ?></p>
								<div class="clear"></div>
							</div>
							<!-- End: historybox_category -->
						</div>
						<!-- End: historybox -->

					 </div>
					 <!-- End: history -->
<?php 
		endforeach;
	endif;
?>
				</div>
				<!-- End: history_window -->
