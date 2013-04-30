$('#search').submit(function(e){
	if($('#myear').val().length > 0 || $('#min_mratings').val().length > 0){
		if(isNaN($('#myear').val() || isNaN($('#min_mratings').val()))){
			$('.error').fadeIn(500).delay(5000).fadeOut(1000);
			return false;
		}
	}
	var inputs = $('#search :input');
	for(var i = 0; i < inputs.length; i++){
		if(inputs[i].value === "")
			inputs[i].setAttribute('name', '');
	}
	return true;
});

$('#users_search').submit(function(e){
	if($('#age').val().length > 0){
		if(isNaN($('#age').val())){
			$('.error').fadeIn(500).delay(5000).fadeOut(1000);
			return false;
		}
	}
	if($('#uname').val().length > 0){
		$('#uname').val($('#uname').val().toUpperCase());
	}
	var inputs = $('#users_search :input');
	for(var i = 0; i < inputs.length; i++){
		if(inputs[i].value === "")
			inputs[i].setAttribute('name', '');
	}
	return true;
});

$('#actor_search').submit(function(e){
	var inputs = $('#actor_search :input');
	for(var i = 0; i < inputs.length; i++){
		if(inputs[i].value === "")
			inputs[i].setAttribute('name', '');
	}
	return true;
});

$('#director_search').submit(function(e){
	if($('#myear').val().length > 0){
		if(isNaN($('#myear').val())){
			$('.error').fadeIn(500).delay(5000).fadeOut(1000);
			return false;
		}
	}
	var inputs = $('#director_search :input');
	for(var i = 0; i < inputs.length; i++){
		if(inputs[i].value === "")
			inputs[i].setAttribute('name', '');
	}
	return true;
});