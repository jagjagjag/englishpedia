
function val_check(){

	res = true;
	// 留学情報
	if (document.form.postID.value=='') {
		alert('希望学校を選択してください。');
		return false;
	}
	if (document.form.course.value=='') {
		alert('コースを選択してください。');
		return false;}
//	if (document.form.school_hours.value=='') {
//		alert('授業時間を選択してください。');
//		return false;}
	
	if (document.form.start_year.value=='') {
		alert('留学開始年を選択してください');
		return false;}
	if (document.form.start_month.value=='') {
		alert('留学開始月を選択してください');
		return false;}
	if (document.form.period.value=='') {
		alert('留学期間を選択してください');
		return false;}
	if (document.form.stay_type.value=='') {
		alert('滞在先を選択してください');
		return false;}
	if (document.form.arrange_period.value=='' && document.form.stay_type.value !='自分で手配する') {
		alert('滞在先の手配期間を選択してください');
		return false;}


	// ご本人様情報
	if (document.form.last_name.value=='') {
	alert('姓を入力してください。');
	return false;}
	if (document.form.first_name.value=='') {
	alert('名を入力してください。');
	return false;}
	if (document.form.last_name_kana.value=='') {
	alert('姓(ふりがな)を入力してください。');
	return false;}
	if (document.form.first_name_kana.value=='') {
	alert('名(ふりがな)を入力してください。');
	return false;}
	if (document.form.email.value=='') {
	alert('メールアドレスを入力してください。');
	return false;}
	mailchk = document.form.email.value.match(/^\S+@\S+\.\S+$/);
	if (!mailchk) {
	alert('メールアドレスが正しくありません。');
	return false;}
	if (document.form.tel.value=='') {
	alert('電話番号を入力してください。');
	return false;}
	if (document.form.postal.value=='') {
		alert('郵便番号を入力してください。');
		return false;}
	if (document.form.postal.value.length != 7) {
		alert('郵便番号を正しく入力してください。');
		return false;}

	if (document.form.prefecture.value=='') {
		alert('都道府県を選択してください。');
		return false;}
	if (document.form.address.value=='') {
		alert('ご住所を入力してください。');
		return false;}
	
	if(document.form.clause.checked==false){
		alert('約款に同意してください。');
		return false;}
		
	if (res == false){
	return false;
	}
	return true;
}
function regist_val_check($mode){

	res = true;

	if(document.regist_form.email.value=='') {
		alert('メールアドレスを入力してください。');
		return false;
	}

	mailchk = document.regist_form.email.value.match(/^\S+@\S+\.\S+$/);
	if (!mailchk) {
		alert('メールアドレスが正しくありません。');
		return false;
	}

	if ($mode == 0){
		if(document.regist_form.password.value.length < 6 || document.regist_form.password.value.length > 20) {
			alert('パスワードは6文字以上20文字以内で入力してください');
			return false;
		}
	}else{
		if(document.regist_form.password.value.length != 0 && (document.regist_form.password.value.length < 6 || document.regist_form.password.value.length > 20)) {
			alert('パスワードは6文字以上20文字以内で入力してください');
			return false;
		}
	}

	passwordchk = document.regist_form.password.value.match(/^[a-zA-Z0-9]+$/);
	if ($mode == 0 && !passwordchk) {
		alert('パスワードは半角英数字で入力してください');
		return false;
	}

	if(document.regist_form.password.value != document.regist_form.password_confirm.value){
		alert('パスワードとパスワード（確認用）が異なります');
		return false;
	}

	if (document.regist_form.display_name.value=='') {
		alert('お名前を入力してください。');
		return false;
	}

	if(document.regist_form.agree.checked==false) {
		alert('約款及び個人情報の取扱について同意してください。');
		return false;
	}


	var email_add = document.regist_form.email.value;
	var id_add = document.regist_form.ID.value;

	var data = {'action' : 'engp_check_regist', 'email' : email_add, 'ID' : id_add};

	jQuery.ajax({
		url: ajaxurl,
		data: data,
		type: 'post',
		async: false,
		success: function(response) {
			if(response.length > 0){
				alert (response);
				res = false;
			}
		}
	});

	if (res == false){
		return false;
	}

	return true;
}


function remind_val_check(){

	res = true;

		if (document.remind_form.email.value=='') {
			alert('メールアドレスを入力してください。');
		return false;}

		mailchk = document.remind_form.email.value.match(/^\S+@\S+\.\S+$/);
		if (!mailchk) {
			alert('メールアドレスが正しくありません。');
			return false;}

		var email_add = document.remind_form.email.value;
		var remind_add = document.remind_form.remind.value;
		var data = {'action' : 'engp_check_regist','email' : email_add,'remind' : remind_add};

		jQuery.ajax({
			url: ajaxurl,
			data: data,
			type: 'post',
			async: false,
			success: function(response) {
				if(response.length > 0){
					alert (response);
					res = false;
				}
			}
		});

		if (res == false){
			return false;
		}

		return true;
	}

function review_val_check(){

	res = true;

	if (document.review_form.display_name.value=='') {
		alert('名前を入力してください。');
		return false;
	}

	if (document.review_form.voice_text.value=='') {
		alert('ご利用者の声を入力してください。');
		return false;}


	if (document.review_form.satisfaction_evaluation.value=='') {
		alert('満足度を選択してください。');
		return false;
	}

	if (document.review_form.security_evaluation.value=='') {
		alert('学校周辺の治安を選択してください。');
		return false;
	}

	if (document.review_form.traffic_evaluation.value=='') {
		alert('交通の便を選択してください。');
		return false;
	}

	if (document.review_form.clean_evaluation.value=='') {
		alert('衛生面(綺麗さ)を選択してください。');
		return false;
	}

	if (document.review_form.staff_evaluation.value=='') {
		alert('学校スタッフの対応を選択してください。');
		return false;
	}

	if (document.review_form.lesson_evaluation.value=='') {
		alert('授業内容を選択してください。');
		return false;
	}

	if (document.review_form.student_evaluation.value=='') {
		alert('周りの学生の真剣さを選択してください。');
		return false;
	}

//	if (document.review_form.answer_2.value=='') {
//		alert('あなたの学校で気に入ってる先生やクラスを入力してくださいa。');
//		return false;
//	}

	var fileList = document.getElementById("files").files;
	if (fileList.length > 0) {
		if (fileList.length > 3) {
			alert('1度に投稿できるファイルは3ファイルまでです');
			return false;
		}else{
			var file_size = 0;
			for(var i=0; i<fileList.length; i++){
				file_size += fileList[i].size;
			}
			if(file_size > 4194304){
				alert('ファイル容量が4MBを超えています');
				return false;
			}
		}
	}
//		if (document.review_form.review_text.value.length > 500) {
//			alert('レビュー内容が500文字を超えています。');
//			return false;}

		if (res == false){
			return false;
		}

		return true;
	}

function guest_review_val_check(){

	res = true;

		if (document.review_form.display_name.value=='') {
				alert('名前を入力してください。');
				return false;}

		if (document.review_form.postID.value=='') {
			alert('学校を選択してください。');
			return false;}

		if (document.review_form.review_text.value=='') {
			alert('入学の決め手を入力してください。');
			return false;
		}

		if (document.review_form.satisfaction_evaluation.value=='') {
			alert('満足度を選択してください。');
			return false;
		}

		if (document.review_form.security_evaluation.value=='') {
			alert('学校周辺の治安を選択してください。');
			return false;
		}

		if (document.review_form.traffic_evaluation.value=='') {
			alert('交通の便を選択してください。');
			return false;
		}

		if (document.review_form.clean_evaluation.value=='') {
			alert('衛生面(綺麗さ)を選択してください。');
			return false;
		}

		if (document.review_form.staff_evaluation.value=='') {
			alert('学校スタッフの対応を選択してください。');
			return false;
		}

		if (document.review_form.lesson_evaluation.value=='') {
			alert('授業内容を選択してください。');
			return false;
		}

		if (document.review_form.student_evaluation.value=='') {
			alert('周りの学生の真剣さを選択してください。');
			return false;
		}

		if (document.review_form.answer_2.value=='') {
			alert('あなたの学校で気に入ってる先生やクラスを入力してください。');
			return false;
		}

		if (res == false){
			return false;
		}

//			if (document.review_form.review_text.value.length > 500) {
//				alert('レビュー内容が500文字を超えています。');
//				return false;}
		return true;
	}

function report_val_check(){

	res = true;

		if (document.report_form.reporttxt.value=='') {
			alert('内容を入力してください。');
			return false;}

		if (res == false){
			return false;
		}

		return true;
	}

function inquiry_val_check(){

	res = true;

	if (document.inquiry_form.last_name.value=='') {
	alert('姓を入力してください。');
	return false;}
	if (document.inquiry_form.first_name.value=='') {
	alert('名を入力してください。');
	return false;}
	if (document.inquiry_form.email.value=='') {
	alert('メールアドレスを入力してください。');
	return false;}
	mailchk = document.inquiry_form.email.value.match(/^\S+@\S+\.\S+$/);
	if (!mailchk) {
		alert('メールアドレスが正しくありません。');
		return false;
	}
	if (document.inquiry_form.phone.value=='') {
		alert('携帯電話番号を入力してください。');
		return false;}	
	if(document.inquiry_form.phone.value.match(/[^0-9]+/)){
		alert('携帯電話番号を正しく入力してください。');
		return false;}	
	if(document.inquiry_form.phone.value.length != 11){
		alert('携帯電話番号を正しく入力してください。');
		return false;}	
	
	if (document.inquiry_form.consultation.value=='') {
	alert('相談したい内容を入力してください。');
	return false;}

	if (res == false){
	return false;
	}
	return true;
}

function counseling_val_check(){

	res = true;

	if (document.inquiry_form.last_name.value=='') {
	alert('姓を入力してください。');
	return false;}
	if (document.inquiry_form.first_name.value=='') {
	alert('名を入力してください。');
	return false;}
	if (document.inquiry_form.email.value=='') {
	alert('メールアドレスを入力してください。');
	return false;}
	mailchk = document.inquiry_form.email.value.match(/^\S+@\S+\.\S+$/);
	if (!mailchk) {
	alert('メールアドレスが正しくありません。');
	return false;}
	if (document.inquiry_form.phone.value=='') {
	alert('電話番号を入力してください。');
	return false;}

	if (res == false){
	return false;
	}
	return true;
}


function schoolregist_val_check(){

	res = true;

	if (document.schoolregist_form.staff_name.value=='') {
		alert('ご担当者様名を入力してください。');
		return false;
	}

	if (document.schoolregist_form.staff_email.value=='') {
		alert('ご担当者様のメールアドレスを入力してください。');
		return false;}
		mailchk = document.schoolregist_form.staff_email.value.match(/^\S+@\S+\.\S+$/);
		if (!mailchk) {
		alert('ご担当者様のメールアドレスが正しくありません。');
		return false;
	}

	if (document.schoolregist_form.school_name.value=='') {
		alert('学校名を入力してください。');
		return false;
	}

	if (document.schoolregist_form.school_address.value=='') {
		alert('住所を入力してください。');
		return false;
	}

	if (document.schoolregist_form.school_division.value=='') {
		alert('エリアを選択してください。');
		return false;
	}

	if (document.schoolregist_form.school_about.value=='') {
		alert('概要(学校紹介文)を入力してください。');
		return false;
	}
	if (res == false){
		return false;
	}
	return true;
}


