<?php
/* 為替レート取得用 */

//define("FILE_DIR", "/var/www/html/wordpress/wp-content/themes/engp/batch");
define("FILE_DIR", "/var/www/engp/html/wordpress/wp-content/themes/engp/batch");
define("FILE_NAME", "rate.json");
//define("API_URL", "http://rate-exchange.appspot.com/currency?from=usd&to=jpy");
define("API_URL", "http://query.yahooapis.com/v1/public/yql?q=select%20Rate%20from%20yahoo.finance.xchange%20where%20pair%20in%20%28%22USDJPY%22%29&format=json&env=store://datatables.org/alltableswithkeys");

$filePath = FILE_DIR . "/" . FILE_NAME;

// APIからjsonデータ取得（エラーは表示しない）
$jsonData = @file_get_contents(API_URL);

// 取得失敗は空データ
if(empty($jsonData)){
	// 取得失敗のログを出す?
}else{
	// YahooのJsonデータを分解
	$objData = json_decode($jsonData);
	$writeData = '{"to": "jpy", "rate": '. $objData->query->results->rate->Rate .', "from": "usd"}';

	$file = fopen($filePath ,"w");

	if($file){
		// 共有でファイルをロック
		flock($file, LOCK_SH | LOCK_NB);
//		fwrite($file, $jsonData);
		fwrite($file, $writeData);
		flock($file, LOCK_UN);
		fclose($file);
	} else {
		// ファイルオープン失敗のログを出す?
	}
}
