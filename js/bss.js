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