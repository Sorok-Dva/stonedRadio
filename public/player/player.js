var playerFavoriteImage = '/images/player/playerFav.png';
var playerUnfavoriteImage = '/images/player/playerUnfav.png';

var lastTracksPlayedTimeout = null;
var volumeTimeout = null;
var detachedPlayer = null;

var currentSongTimeout = null;

var player = null;
var currentStream = {};

function UpdateLanguage(lang) {
	HideLanguages();
	$.post('/' + lang + '/base/updatelanguage?lang=', function (result) {
		if (result) {
			var url = DecodeUrl(fullUrl).replace(language, lang);
			language = lang;
			controller = 'base';
			NavigateTo(url, true);
			$('html, body').animate({ scrollTop: 0 }, 'fast');
		}
	});
}

function ToggleStream(stream) {
	if (GetContext().currentStream.radioUID == stream.radioUID && GetContext().currentStream.isPlaying) {
		StopStream();
	}
	else {
		stream.prevRadioUID = GetContext().currentStream.radioUID;
		stream.isPlaying = false;

		PlayStream(stream);
	}
}

function PlayStream(stream) {
	ForEachContext(function (context) {
		context.currentStream = stream;
		context.currentStream.isPlaying = true;

		if (context.currentStream.mp3.indexOf('https') < 0) {
			context.currentStream.mp3 = context.currentStream.mp3.replace('http', scheme);
		}

		
		if (context == GetContext()) {
			var qs = '';
			var streamUrl = context.currentStream.mp3;
			if (/^(http|https)\:\/\/listen.*(.radionomy.com|.shoutcast.com)/i.test(streamUrl)) {
				qs += context.IsExportablePlayer() ? '?ad=adiono5' : '?ad=adionoweb';
			}

			context.player.jPlayer('setMedia', { mp3: context.currentStream.mp3 + qs } );
			context.player.jPlayer('play');
		}

		if (typeof context.OnStreamPlay === 'function') context.OnStreamPlay();
	});
}

function StopStream() {
	ForEachContext(function (context) {
		if (context == GetContext()) {
			context.player.jPlayer('stop');
			context.player.jPlayer('clearMedia');
		}

		if (context.currentStream) {
			context.currentStream.isPlaying = false;
		}

		if(typeof context.OnStreamStop === 'function') context.OnStreamStop();
	});
}

function DetachPlayer(url, playerOptions) {
	playerOptions = playerOptions || { type: 'medium' };
	playerOptions.autoplay = playerOptions.autoplay || currentStream == null ? false : currentStream.isPlaying;

	var listenUrl = BuildListenUrl(url, playerOptions);
	StopStream();

	detachedPlayer = GetContext().open(listenUrl, 'radionomyplayer', 'height=' + GetExportablePlayerProperties(playerOptions.type).height + ', width=' + GetExportablePlayerProperties(playerOptions.type).width + ', modal=yes, alwaysRaised=yes, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no');
	detachedPlayer.focus();
	detachedPlayer.parentWindow = window;

	ForEachContext(function (context) {
		if (typeof context.OnPlayerDetached === 'function') context.OnPlayerDetached();
	});
}

function BuildListenUrl(radiourl, playerOptions) {
	return hostUrl + '/' + language + '/radio/' + radiourl + '/listen/?' + $.param(playerOptions || {});
}

function AddFavorite(radioUID, event) {
	$.post(
		'/' + language + '/Favorites/Add',
		{ radioUID: radioUID },
		function (result) {
			if (result) {
				ForEachContext(function (context) {
					if(typeof context.OnAddFavorite === 'function') context.OnAddFavorite(result.Success, radioUID);
				});
			}
		}
	);

	if (event) {
		event.stopPropagation();
		event.preventDefault();
	}
}

function RemoveFavorite(radioUID, event) {
	$.post(
		'/' + language + '/Favorites/Remove',
		{ radioUID: radioUID },
		function (result) {
			if (result) {
				ForEachContext(function (context) {
					if (typeof context.OnRemoveFavorite === 'function') context.OnRemoveFavorite(result.Success, radioUID);
				});
			}
		}
	);

	if (event) {
		event.stopPropagation();
		event.preventDefault();
	}
}


function HidePreroll() {
	$('#player .rad-adsBanner').hide();
	$('#player .rad-adsBanner iframe').remove();
}

function ToggleShareOptions() {
	if ($('#player:visible').length > 0 && $('#player div.rad-shareOptions:visible').length > 0) {
		HideShareOptions();
	}
	else {
		ShowShareOptions();
	}
}

function ShowShareOptions() {
	HideQuickFavorites();
	$('#player div.rad-shareOptions').slideDown();
}

function HideShareOptions() {
	$('#player div.rad-shareOptions').slideUp();
}

function UpdateShareLinks() {
	$('#player div.rad-shareOptions a.fb').attr('href', '/' + language + '/radio/' + currentStream.url + '/facebook');
	$('#player div.rad-shareOptions a.tw').attr('href', '/' + language + '/radio/' + currentStream.url + '/twitter');
	$('#player div.rad-shareOptions a.export').attr('href', '/' + language + '/radio/' + currentStream.url + '/share');
}

function ShowPlayer(slide) {
	if (IsPlayerDetached()) return;

	if (slide) {
		$('#player').slideDown();
	}
	else {
		$('#player').show();
	}
	$('#site').removeClass('withPlayer').addClass('withPlayer');
}

function HidePlayer() {
	$('#player').hide();

	HideQuickFavorites();
	HideShareOptions();
	HidePreroll();
}

function ParseQueryString(qs) {
	var qs = qs.substr(qs.indexOf('?') + 1).split('&');
	if (qs == "") return {};
	var b = {};
	for (var i = 0; i < qs.length; ++i) {
		var p = qs[i].split('=', 2);
		if (p.length == 1)
			b[p[0]] = "";
		else
			b[p[0]] = decodeURIComponent(p[1].replace(/\+/g, ' '));
	}
	return b;
}

function ToggleVolume() {
		HideVolume();
}
function HideVolume() {
	$('#player .volumeWrap').hide();
}

function ForEachContext(callback) {
	callback(window);
	if (window.parentWindow) callback(window.parentWindow);
	if (IsPlayerDetached()) callback(detachedPlayer);
}

function GetContext() {
	return IsPlayerDetached() ? detachedPlayer : window;
}

function IsPlayerDetached() {
	return detachedPlayer != null && detachedPlayer.window != null;
}

function IsIE() {
	var tmp = document.documentMode, e, isIE;

	try { document.documentMode = ""; }
	catch (e) { };

	isIE = typeof document.documentMode == "number" || eval("/*@cc_on!@*/!1");

	try { document.documentMode = tmp; }
	catch (e) { };

	return isIE;
}

