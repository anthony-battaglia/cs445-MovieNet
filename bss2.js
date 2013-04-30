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