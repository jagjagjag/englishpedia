// ====== アコーディオン ===============
$(function(){
	$("#actr th").on("click", function() {
		$(".sltr").slideToggle(0);
		$("#actr th").toggleClass("active");
	});
	return false;
});

$(function(){
	$("#actr2 th").on("click", function() {
		$(".sltr2").slideToggle(0);
		$("#actr2 th").toggleClass("active");
	});
	return false;
});

$(function(){
	$("#actr3 th").on("click", function() {
		$(".sltr3").slideToggle(0);
		$("#actr3 th").toggleClass("active");
	});
	return false;
});

// ================= 表示処理 =======================
function sortTuition(postid, week, dir){
	var url = location.href;
	url = url.replace(location.search, '');

	if(week == '' || dir == ''){
		location.href = url + '?cmpid=' + postid;
	}else{
		location.href = url + '?cmpid=' + postid + '&week=' + week + '&dir=' + dir;
	}
}
