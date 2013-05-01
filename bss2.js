function adClicked(link, ccnum){
	var request = new XMLHttpRequest();
	request.open('GET', 'incrementAd.php?ccnum=' + ccnum, true);
	request.onreadystatechange = function(){
		if (request.readyState == 4){
			// alert(request.status + " " + request.responseText);
			window.location.href=link;
		}
	};
	request.send();
	// window.location.href=link;
};

function submitRating (title, myear){
	var rating = $("#user_rating").val();
	var review = $("#user_review").val();
	var email = $.cookie('email');
	var postData = { title : title, myear : myear, email : email, rating : rating };
	if (review !== undefined && review !== null && review !== "")
		postData.review = review;

	$.ajax({
			type : 'POST',
			url  : 'submitRating.php',
			data : postData,
			dataType : 'json'
		}).done(ratingCallback);
};

function ratingCallback (response){
	$("#user_rating").val("--");
	$("#user_review").val("");
	console.log(response);
	// alert(response);
};

function favorite (title, myear){
	var email = $.cookie('email');
	var postData = { title : title, myear : myear, email : email};

	$.ajax({
			type : 'POST',
			url  : 'favorite.php',
			data : postData,
			dataType : 'json'
		}).done(favoriteCB);
};

function watchList (title, myear){
	var email = $.cookie('email');
	var postData = { title : title, myear : myear, email : email};

	$.ajax({
			type : 'POST',
			url  : 'watch_list.php',
			data : postData,
			dataType : 'json'
		}).done(favoriteCB);
};

function favoriteCB (response){
	console.log(response);
};