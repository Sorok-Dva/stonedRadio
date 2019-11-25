var timer2 = setInterval(refreshPlayer,2000);

function refreshPlayer() {
	$.post("test2.php",{action:"reloadCover"},function(data) {
		$("#tdImg").css("background-image", "url("+data.cover+")");
	}, 'json');
}
