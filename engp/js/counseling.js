$(document).ready(function(){

		var tmpForm = document.forms["counseling"];

		tmpForm.action = "https://www.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8";
		tmpForm.method = "post";
		tmpForm.submit();
		
});
