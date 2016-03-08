jQuery(function(){
	jQuery("#actr th").on("click", function() {
		jQuery(".sltr").slideToggle(0);
		jQuery("#actr th").toggleClass("active");
	});

	jQuery(document).on('click', '.vim', function(){
		var review_id = jQuery(this).data('review-id');
		var process = jQuery(this).data('process');
		var data = {'action' : 'engp_ajax_set_review_status', 'review_id' : review_id, 'process' : process };

		jQuery.ajax({
			type: 'post',
			url: ajaxurl,
			data: data,
			async: false,
			success: function(response) {
				var post_id = jQuery('#current-inspection-no').val();
				var page = jQuery('#current-page-no').val();
				loadData( post_id, page );
			}
		});
	});

	jQuery(document).on('click', '.delete', function(){
		if (!confirm('このレビューを削除しますか？')) {
			return false;
		}

		var review_id = jQuery(this).data('review-id');
		var process = jQuery(this).data('process');
		var data = {'action' : 'engp_ajax_set_review_status', 'review_id' : review_id, 'process' : process };

		jQuery.ajax({
			type: 'post',
			url: ajaxurl,
			data: data,
			async: false,
			success: function(response) {
				var post_id = jQuery('#current-inspection-no').val();
				var page = jQuery('#current-page-no').val();
				loadData( post_id, page );
			}
		});
	});

	jQuery(document).on('click', '.details', function(){
		var review_id = jQuery(this).data('review-id');
		window.open('review_detail.php?revid=' + review_id, 'レビュー詳細', 'width=640, height=500, menubar=no, toolbar=no, scrollbars=yes');
		return false;
	});

});

function loadData( post_id, page ){
	var data = {'action' : 'engp_ajax_get_school_review_list', 'post_id' : post_id, 'page' : page };

	jQuery.ajax({
		type: 'post',
		url: ajaxurl,
		data: data,
		async: false,
		success: function(response) {
			jQuery("#the-comment-list").html(response);
		}
	});
}
