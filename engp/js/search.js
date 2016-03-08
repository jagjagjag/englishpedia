$(function(){
	$('#search_param_del').on('click', function(){
		$('[name="course[]"]:checked').each(function(){
			  $(this).prop('checked', false);
		});
		$('[name="location[]"]:checked').each(function(){
			  $(this).prop('checked', false);
		});
		$('[name="how_to_go[]"]:checked').each(function(){
			  $(this).prop('checked', false);
		});
		$('[name="location_type"]').attr('checked', false);
		$('[name="nationality"]').attr('checked', false);
		$('[name="security"]').attr('checked', false);
		$('[name="local_staff"]').attr('checked', false);
		$('[name="facilities[]"]:checked').each(function(){
			  $(this).prop('checked', false);
		});
	});

});
