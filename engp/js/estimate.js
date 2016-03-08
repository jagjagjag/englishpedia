// ================= 表示処理 =======================
$(function(){
		costConv();
	
		$("#estimate_submit").click(function(){
			var type 	= $("#stay_type").val();
			var period 	= $("#arrange_period").val();
			if(type == "6"){
				document.estimate.submit();
				return false;				
			}
			else if(type != "" && period == ""){
				alert("滞在先の手配期間を選択して下さい");
				return false;
			}else if(type == "" && period != ""){
				alert("滞在先を選択して下さい");
				return false;
			}else{ 			
				document.estimate.submit();
				return false;
			}
		});
		
		//携帯用
		$("#estimate_submit_mob").click(function(){
			var type 	= $("#stay_type").val();
			var period 	= $("#arrange_period").val();
			if(type == "6"){
				document.estimate.submit();
				return false;				
			}
			else if(type != "" && period == ""){
				alert("滞在先の手配期間を選択して下さい");
				return false;
			}else if(type == "" && period != ""){
				alert("滞在先を選択して下さい");
				return false;
			}else{ 			
				document.estimate.submit();
				return false;
			}
		});
		
});

function costConv(){
	var usd2jpy_rate = getRate();

	if($('#admission_fee_usd')[0]){
		$('#admission_fee_jpy').html(usd2jpy(usd2jpy_rate, $('#admission_fee_usd').html()));
	}
	if($('#tuition_usd')[0]){
		$('#tuition_jpy').html(usd2jpy(usd2jpy_rate, $('#tuition_usd').html()));
	}
	if($('#accommodation_placement_fee_usd')[0]){
		$('#accommodation_placement_fee_jpy').html(usd2jpy(usd2jpy_rate, $('#accommodation_placement_fee_usd').html()));
	}
	if($('#i20_issuance_postage_usd')[0]){
		$('#i20_issuance_postage_jpy').html(usd2jpy(usd2jpy_rate, $('#i20_issuance_postage_usd').html()));
	}
//	if($('#airport_pickup_cost_usd')[0]){
//		$('#airport_pickup_cost_jpy').html(usd2jpy(usd2jpy_rate, $('#airport_pickup_cost_usd').html()));
//	}
	if($('#bank_charge_usd')[0]){
		$('#bank_charge_jpy').html(usd2jpy(usd2jpy_rate, $('#bank_charge_usd').html()));
	}
	if($('#homestay_cost_usd')[0]){
		$('#homestay_cost_jpy').html(usd2jpy(usd2jpy_rate, $('#homestay_cost_usd').html()));
	}
	if($('#textbooks_usd')[0]){
		$('#textbooks_jpy').html(usd2jpy(usd2jpy_rate, $('#textbooks_usd').html()));
	}
	if($('#totalcost_usd')[0]){
//		if($('#visa').text() != 0){
//			total_jpy = usd2jpy(usd2jpy_rate, $('#totalcost_usd').html(),$('#visa').text());
//		}else{
			total_jpy = usd2jpy(usd2jpy_rate, $('#totalcost_usd').html());
//		}
		$('#totalcost_jpy').html(total_jpy);
	}
}

//================= 滞在先 =======================
$("#stay_type").change(function() {
	var type = $("#stay_type").val();
	if(type == "6"){
		$("#arrange_period").val("");		
		$("#arrange_period").addClass("select_invalid");						
		$("#arrange_period").attr("disabled", "disabled");
	}else{
		$("#arrange_period").removeAttr("disabled");
		$("#arrange_period").removeClass("select_invalid");						
	}
});

//================= コース選択 =======================
$("#course").change(function() {
	var ID		= $("#estid").val();
	var course = $("#course").val();
	var time 	= $("#time").val();
	
	var data = {'action' : 'engp_school_estimate_course','ID' : ID,'course' : course};
	
	$.ajax({
		url: ajaxurl,
		data: data,
		type: 'post',
		async: false,
		success: function(response) {
			if(response){
				//選択肢を全て消去してから追加
				$("#time option[value='4']").remove();	
				$("#time option[value='8']").remove();	
				$("#time option[value='12']").remove();	
				$("#time option[value='16']").remove();	
				$("#time option[value='24']").remove();	
				$("#time option[value='36']").remove();	
				$("#time option[value='48']").remove();	
				var str = response.split(",");
				 if(str[0] == 1) {
					 $("#time").append($("<option>").val("4").text("4週間（およそ1ヶ月）"));
					 if(time == 4){$("#time").val("4");	}
				   }
				 if(str[1] == 1) {
					 $("#time").append($("<option>").val("8").text("8週間（およそ2ヶ月）"));
					 if(time == 8){$("#time").val("8");	}					 
				   }
				 if(str[2] == 1) {
					 $("#time").append($("<option>").val("12").text("12週間（およそ3ヶ月）"));
					 if(time == 12){$("#time").val("12");}					 
				   }
				 if(str[3] == 1) {
					 $("#time").append($("<option>").val("16").text("16週間（およそ4ヶ月）"));
					 if(time == 16){$("#time").val("16");	}					 
				   }
				 if(str[4] == 1) {
					 $("#time").append($("<option>").val("24").text("24週間（およそ6ヶ月）"));
					 if(time == 24){$("#time").val("24");}					 
				   }
				 if(str[5] == 1) {
					 $("#time").append($("<option>").val("36").text("36週間（およそ9ヶ月）"));
					 if(time == 36){$("#time").val("36");}					 
				   }
				 if(str[6] == 1) {
					 $("#time").append($("<option>").val("48").text("48週間（およそ12ヶ月）"));
					 if(time == 48){$("#time").val("48");	}					 
				   }
			}
		}
	});	
});

//================= 留学期間 =======================
$("#time").change(function() {
	var time = $("#time").val();
	var period 	= $("#arrange_period").val();
	
	//1ヶ月なら、""、"最初の2ヶ月間のみ"を削除
	if(time == "4") {
		if(period == 2){
			$("#arrange_period").val("1");	
		}
		$("#arrange_period option[value='2']").remove();
	}else{
		if($("#arrange_period option[value='2']").size() == 0) {
			$("#arrange_period option[value='1']").after($("<option>").val("2").text("最初の8週間のみ手配を依頼"));
	    }		
	}		
});
