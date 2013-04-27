$('#search').submit(function(e){
	var inputs = $('#search :input');
	for(var i = 0; i < inputs.length; i++){
		if(inputs[i].value === "")
			inputs[i].setAttribute('name', '');
	}
	return true;
});