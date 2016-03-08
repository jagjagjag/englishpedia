$(function(){
	// レートの取得
	var usd2jpy_rate = getRate();
	$('#exchange_rate').html('$1　　=　　\¥' + usd2jpy_rate);
});
