$('#search').submit(function(e){
	var inputs = $('#search :input');
	for(var i = 0; i < inputs.length; i++){
		if(inputs[i].value === "")
			inputs[i].setAttribute('name', '');
	}
	return true;
// 	e.preventDefault();
// 	$.ajax({
// 		method: "GET",
// 		url: "/www/cs445_4_s13/findmovies.php",
// 		dataType: "json",
// 		data: "",
// 		success: function(data, textStatus, jqXHR){
// 			console.log("Query Results:");
// 			console.log($.parseJSON(data));
// 		},
// 		error: function(jqXHR, textStatus, errorThrown){
// 			console.log(jqXHR);
// 			console.log(errorThrown);
// 			console.log(textStatus);
// 		}
// 	});
});