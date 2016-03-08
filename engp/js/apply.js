//================= コース選択 =======================
//$("#postID").change(function() {
//	var ID		= $("#postID").val();
//	
//	var data = {'action' : 'engp_school_apply_course','ID' : ID};
//	
//	if(ID){
//		$.ajax({
//			url: ajaxurl,
//			data: data,
//			type: 'post',
//			async: false,
//			success: function(response) {
//				if(response){
//					//選択肢を全て消去してから追加
//					$("#course option[value='ESL']").remove();	
//					$("#course option[value='TOEFL']").remove();	
//					$("#course option[value='TOEIC']").remove();	
//					$("#course option[value='大学進学']").remove();	
//					$("#course option[value='ビジネス']").remove();	
//					$("#course option[value='子供向け(U12、U15など)']").remove();	
//					$("#course option[value='アダルト(大人向け)']").remove();	
//					$("#course option[value='IELTS']").remove();						
//					$("#course option[value='スペシャルオファー").remove();					
//					var str = response.split(",");
//					 if(str[0] == 1) {$("#course").append('<option value="ESL">ESL</option>');}
//					 if(str[1] == 1) {$("#course").append('<option value="TOEFL">TOEFL</option>');}					 
//					 if(str[2] == 1) {$("#course").append('<option value="TOEIC">TOEIC</option>');}					 
//					 if(str[3] == 1) {$("#course").append('<option value="大学進学">大学進学</option>');}					 
//					 if(str[4] == 1) {$("#course").append('<option value="ビジネス">ビジネス</option>');}					 
//					 if(str[5] == 1) {$("#course").append('<option value="子供向け(U12、U15など)">子供向け(U12、U15など)</option>');}					 
//					 if(str[6] == 1) {$("#course").append('<option value="アダルト(大人向け)">アダルト(大人向け)</option>');}					 
//					 if(str[7] == 1) {$("#course").append('<option value="IELTS">IELTS</option>');}					 
//					 if(str[8] == 1) {$("#course").append('<option value="スペシャルオファー">スペシャルオファー</option>');}					 					 					
//				}
//			}
//		});
//	}else{
//		$("#course option[value='ESL']").remove();	
//		$("#course option[value='TOEFL']").remove();	
//		$("#course option[value='TOEIC']").remove();	
//		$("#course option[value='大学進学']").remove();	
//		$("#course option[value='ビジネス']").remove();	
//		$("#course option[value='子供向け(U12、U15など)']").remove();	
//		$("#course option[value='アダルト(大人向け)']").remove();	
//		$("#course option[value='IELTS']").remove();						
//		$("#course option[value='スペシャルオファー").remove();					
//		$("#course").append($("<option>").val("ESL").text("ESL"));
//		$("#course").append($("<option>").val("TOEFL").text("TOEFL"));		
//		$("#course").append($("<option>").val("TOEIC").text("TOEIC"));
//		$("#course").append($("<option>").val("大学進学").text("大学進学"));
//		$("#course").append($("<option>").val("ビジネス").text("ビジネス"));
//		$("#course").append($("<option>").val("子供向け(U12、U15など)").text("子供向け(U12、U15など)"));		 
//		$("#course").append($("<option>").val("アダルト(大人向け)").text("アダルト(大人向け)"));		
//		$("#course").append($("<option>").val("IELTS").text("IELTS"));				
//		$("#course").append($("<option>").val("スペシャルオファー").text("スペシャルオファー"));		 
//	}
//});

//================= 滞在先 =======================
$("#stay_type").change(function() {
	var type = $("#stay_type").val();
	if(type == "自分で手配する"){
		$("#arrange_period").val("");		
		$("#arrange_period").addClass("select_invalid");						
		$("#arrange_period").attr("disabled", "disabled");
	}else{
		$("#arrange_period").removeAttr("disabled");
		$("#arrange_period").removeClass("select_invalid");						
	}
});

//================= 留学期間 =======================
$("#period").change(function() {
	var time = $("#period").val();
	var period 	= $("#arrange_period").val();
	
	//1ヶ月なら、""、"最初の2ヶ月間のみ"を削除
	if(time == "4週間（およそ1ヶ月）") {
		if(period == "最初の8週間のみ手配を依頼"){
			$("#arrange_period").val("最初の4週間のみ手配を依頼");	
		}
		$("#arrange_period option[value='最初の8週間のみ手配を依頼']").remove();
	}else{
		if($("#arrange_period option[value='最初の8週間のみ手配を依頼']").size() == 0) {
			$("#arrange_period option[value='最初の4週間のみ手配を依頼']").after($("<option>").val("最初の8週間のみ手配を依頼").text("最初の8週間のみ手配を依頼"));
	    }		
	}		
});