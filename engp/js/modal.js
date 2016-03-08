//======= ユーザー登録モーダルオーバーレイ表示 =================
$(function(){
	$(".button-link").on('click', function(){
		$("body").append('<div id="modal-overlay"></div>');
		$("#modal-overlay").fadeIn("fast");
		$("#modal-content").fadeIn("fast");
		centeringModal();

		$("#modal-overlay, #modal-close").on('click', function(){
			$("#modal-content, #modal-overlay").fadeOut("fast",function(){
				$('#modal-overlay').remove();
			});
			$("#modal-overlay, #modal-close").off('click');
		});

	});
});

$(function(){
	$(window).resize(centeringModal);
});

$(function(){
	$(window).resize(centeringModalPhoto);
});

$(function(){
	$("img.ChangeModalPhoto").click(function(){
		var ImgSrc = $(this).data("src");
		var ImgAlt = $(this).attr("alt");
		$("img#ModalMainPhoto").attr({src:ImgSrc,alt:ImgAlt});
		$("img#ModalMainPhoto").hide();
		$("img#ModalMainPhoto").fadeIn("slow");
		return false;
	});
});

$(function(){
	$(".button-photo-link").on('click', function(){
		$("body").append('<div id="modal-photo-overlay"></div>');
		$("#modal-photo-overlay").fadeIn("fast");
		$("#modal-photo-content").fadeIn("fast",complete);
		centeringModalPhoto();
		$("#modal-photo-overlay, #modal-photo-close").on('click', function(){
			$("#modal-photo-content, #modal-photo-overlay").fadeOut("fast",function(){
				$('#modal-photo-overlay').remove();
			});
			$("#modal-photo-overlay, #modal-photo-close").off('click');
		});

	});

	function complete(){
//		setTimeout(function() {
			slider.reloadSlider();
//		},200);
	
	}
});

//======= ユーザー登録モーダルオーバーレイ_コンテンツセンタリング =================
function centeringModal(){
	var w = $(window).width();
	var h = $(window).height();
	var cw = $("#modal-content").outerWidth(true);
	var ch = $("#modal-content").outerHeight(true);
	$("#modal-content").css({"left": ((w - cw)/2) + "px", "top": ((h - ch)/2) + "px"})
}

function centeringModalPhoto(){
	var w = $(window).width();
	var h = $(window).height();
	var cw = $("#modal-photo-content").outerWidth(true);
	var ch = $("#modal-photo-content").outerHeight(true);
	$("#modal-photo-content").css({"left": ((w - cw)/2) + "px", "top": ((h - ch)/2) + "px", "height": "px"})
}
