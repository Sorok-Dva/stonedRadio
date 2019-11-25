var favoriteImage = '/images/icons/icon-radioActionsFav.png';
var unfavoriteImage = '/images/icons/icon-radioActionsUnfav.png';

var previousController;

var loaderTimeout = null;

var radioScrollOffset = 0;
var requestid = 0;

$(function () {
	$('body').delegate('a[rel="internal"]', 'click', function (event) {
		var url = $(this).attr('href');

		NavigateTo(url);

		event.stopPropagation();
		event.preventDefault();
	});

	$('body').delegate('div.radioPlayBtn', 'click', function (event) {
		ToggleStream($(this).data('play-stream'));
		event.stopPropagation();
		event.preventDefault();
	});

	$('body').delegate('div.browseRadioWrap', 'click', function (event) {
		var link = $(this).find('a[rel=internal]');

		NavigateTo(link.attr('href'));

		event.stopPropagation();
		event.preventDefault();
	});

	$('body').delegate('select.mainGenre, select.subGenre', 'change', function (event) {
		NavigateTo($(this).find(':selected').attr('href'));

		event.stopPropagation();
		event.preventDefault();
	});

	var loadingRadios = false;
	$(window).scroll(function () {
		if ($(window).scrollTop() > 25) {
			$('#notifications').css('top', '20px');
		} else {
			$('#notifications').css('top', '55px');
		}

		if (radioScrollEnabled) {
			var lastTile = $('.browseRadioWrap:last');
			if ($(window).scrollTop() + $(window).height() - lastTile.height() > lastTile.offset().top && loadingRadios == false) {
				loadingRadios = true;

				ShowLoader();
				$.post(DecodeUrl(fullUrl),
					{ scrollOffset: radioScrollOffset },
					function (result) {
						HideLoader();

						$('#loader').before(result);

						radioScrollOffset++;
						loadingRadios = false;
					});
			}
		}
	});

	$(window).bind('popstate', function (e) {
		var state = e.originalEvent.state;

		if (state) {
			// Make sure that we don't push the state again when
			// going back (this is done by passing false as last
			// parameter to the goTo function)
			if (state.data) {
				NavigateTo(state.page, false, state.data);
			}
			else {
				NavigateTo(state.page, false, null);
			}
		}
	});

	$(document).ajaxComplete(function (a, b, c) {
		var silentLoginUrl = b.getResponseHeader('SILENT_LOGIN');
		if (silentLoginUrl != null) {
			$.ajax({
				type: 'GET',
				dataType: 'jsonp',
				jsonp: 'callback',
				url: silentLoginUrl,
				success: function (status) {
					if (status.Authorized) {
						NavigateTo(status.RedirectUrl, true);
					}
				}
			});
		}
	});

	InitPage();
	InitializePlayer();
});

function InitPage() {
	HideMobileMenu();
	HideLoader();

	try {
		twttr.widgets.load();
		FB.XFBML.parse();
	} catch (ex) { }

	$('.navAccountMenu').mouseover(function () {
		$('.dropdown, .dropdownHome').fadeIn("fast");
	});

	$('#navAccount').mouseleave(function () {
		setTimeout(function () {
			if ($('#navAccount:hover').length == 0) {
				$('.dropdown, .dropdownHome').fadeOut("fast");
			}
		}, 200);
	});

	radioScrollOffset = 0;
}

function ShowMobileMenu() {
	$('#menu').mmenu().trigger('open.mm');
}

function HideMobileMenu() {
	$('#menu').mmenu().trigger('close.mm');
}

function RefreshMobileMenu(result) {
	if ($('#headerMobile:visible').length > 0) {
		var menu = $(result);

		$('[data-translation-id]').each(function () {
			$(this).text(menu.find('[data-translation-id=' + $(this).data('translation-id') + ']').text());
		});

		$('.mm-subclose[href=#mm-0]').text(menu.find('[data-translation-id=languages]').text());
		$('input.mobileSearch').attr('placeholder', menu.find('input.mobileSearch').attr('placeholder'));
		$('#mm-1').find('li.toRemove').remove();
		$('#mm-1').append(menu.find('li.toRemove'));
		$('#mobileSearch .mobileSearch').val('');
	}
}

function InitializeMarketingSlider() {
	$('#marketingSlider').slick({
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: false,
		autoplay: true,
		autoplaySpeed: 10000,
		pauseOnHover: false,
		fade: true,
		speed: 650
	});

	$('.previous').click(function (event) {
		$('#marketingSlider').slickPrev();
		event.preventDefault();
	});
	$('.next').click(function (event) {
		$('#marketingSlider').slickNext();
		event.preventDefault();
	});
}

function BlurHomeBanner() {
	//if (!IsMobile()) {
	//	$('#featuredBackground').blurjs({
	//		source: '#site',
	//		radius: 12,
	//		cache: true,
	//		overlay: 'rgba(255,255,255,0.1)'
	//	});
	//}
}

function AddToHistory(url) {
	history.pushState({
		page: url
	}, null, url);
}

function NavigateTo(url, addToHistory) {
	var urlList = (url.indexOf('/') == 0 ? url.substring(1) : url).split('/');
	previousController = controller;

	if (urlList.length >= 2) {
		language = urlList[0].toLowerCase();
		controller = urlList[1].toLowerCase();

		if (urlList.length >= 3) {
			action = urlList[2].toLowerCase();
		}
	}

	fullUrl = url;
	currentUrl = controller + '/' + action;

	var toReplace = BeforeNavigate();

	if (addToHistory || typeof addToHistory === 'undefined') {
		AddToHistory(url);
	}

	var rid = ++requestid;
	$.get(url, function (result) {
		if (rid == requestid) {
			RefreshMobileMenu(result);

			for (var tri = 0; tri < toReplace.length; tri++)
				RefreshHTML(toReplace[tri], result);

			InitPage();

			if (currentStream && currentStream.isPlaying) $('#site').removeClass('withPlayer').addClass('withPlayer');

			HideLanguages();
			$('#navLogin a.signin').attr('href', '/' + language + '/account/login?returnUrl=' + fullUrl);
			if (controller == 'home') {
				$('#site').addClass('homeBackground');
				$('#footer').removeClass('footer').addClass('footerHome');
				if (!$('#player').hasClass('playerHome')) $('#player').addClass('playerHome');
			}
			else {
				$('#site').removeClass('homeBackground');
				$('#footer').removeClass('footerHome').addClass('footer');
				$('#player').removeClass('playerHome');
			}

			$(result).find('.init script').each(function () {
				eval($(this).html());
			});

			AfterNavigate();
		}
	});
}

function BeforeNavigate() {
	switch (controller) {
		case 'home':
			if (action == 'featured' || action == 'nearyou' || action == 'favorites') {
				var link = $('#featuredRadio .category a').filter(function () {
					return $(this).attr('href').toLowerCase().indexOf(action) >= 0;
				});

				ToggleHomeCategory(link);
			}

			if (previousController == 'home') {
				return ['#featuredRadio', '#headerHome'];
			}
			break;
		case 'style':
			var qs = ParseQueryString(decodeURIComponent(fullUrl));

			if (controller == previousController) {
				ShowLoader(function () {
					$('.browseRadioWrap').hide();
				});

				// Find the link that was clicked to update its state
				var styles = GetStylesFromUrl(), isSubStyle = styles.substyle.length > 0;
				var link = $((isSubStyle ? '#browseSubGenre' : '#browseMainGenre') + ' li a').filter(function () {
					return $(this).text().toLowerCase() == (isSubStyle ? styles.substyle : styles.mainstyle);
				});

				/*
					Update menu selected style(s)
				*/
				if (link.is('[data-style-id]')) SetSelectedStyle(link.attr('data-style-id'));
				if (qs.sortBy) {
					$('.browseFilters a').removeClass('active').each(function () {
						if ($(this).text() == qs.sortBy) {
							$(this).addClass('active');
							return false;
						}
					});
				}
			}
			break;
	}

	return ['#site'];
}

function AfterNavigate() {
	$("#menu").mmenu({
		"classes": "mm-slide"
	});

	switch (controller) {
		case 'home':
			if (previousController != 'home') {
				BlurHomeBanner();
			}
			break;
	}
}

function GetStylesFromUrl() {
	var styles = { mainstyle: '', substyle: '' };
	if (controller != 'style') {
		return styles;
	}

	var url = decodeURIComponent(fullUrl).replace('+', ' ');
	if (url.indexOf('/') == 0) url = url.substr(1);

	var urlSplit = url.split('/');
	if (urlSplit.length >= 3) {
		if (urlSplit.length >= 4) {
			styles.substyle = urlSplit[3];
		}
		styles.mainstyle = urlSplit[2];
	}

	return styles;
}

function GetCurrentSong() {
	if (currentSongTimeout) clearTimeout(currentSongTimeout);
	if (!currentStream || !currentStream.radioUID) return;

	$.post('/' + language + '/OnAir/GetCurrentSong',
		{ radioUID: currentStream.radioUID, f: 's' },
		function (result) {
			if (result) {
				var currentSongData = JSON.parse(result);
				var radioTile = $('#tile-' + currentStream.radioUID);
				var artist = currentSongData.Artist;
				var title = currentSongData.Title;

				if (artist != null && artist.length > 0) {
					radioTile.find('.nowPlaying').show();

					var ad = artist.match(/targetspot/i) || title.match(/targetspot/i);
					radioTile.find('.artist').text(ad ? adText : artist);
					radioTile.find('.title').text(ad ? '' : title);

					if (ad) {
						radioTile.find('.separator').hide();
					}
					else {
						radioTile.find('.separator').show();
					}

					currentStream.song = ad ? adText : (artist + ' - ' + title);

					$('.rad-tracks li').text(currentStream.song);
				}

				currentSongTimeout = setTimeout(GetCurrentSong, currentSongData.Callback);
			}
		});
}

function UpdateOnAir() {
	$.post('/' + language + '/OnAir/Update', function (result) {
		if (result) {
			for (var i = 0; i < result.length; i++) {
				var radioTile = $('#tile-' + result[i].RadioUID);
				if (radioTile) {
					radioTile.find('.nowPlaying').show();

					var ad = result[i].Artist.match(/targetspot/i) || result[i].Title.match(/targetspot/i);
					radioTile.find('.artist').text(ad ? adText : result[i].Artist);
					radioTile.find('.title').text(ad ? '' : result[i].Title);

					if (ad) {
						radioTile.find('.separator').hide();
					}
					else {
						radioTile.find('.separator').show();
					}
				}
			}
		}
	});
}

function GetLastTrackPlayed() {
	if (lastTracksPlayedTimeout) clearTimeout(lastTracksPlayedTimeout);
	if (controller != 'radio') return;

	$.post('/' + language + '/OnAir/GetLastTracksPlayed',
		{ radioUID: radioUID },
		function (result) {
			if (result) {
				$('#radioProfileTracklist .tracklist, #radioProfileTracklist script').remove();

				$('#radioProfileTracklist h3').after(result);
			}
		});
}

function SetSelectedStyle(styleid) {
	$('#browseMainGenre li, #browseSubGenre li').removeClass('active');
	var link = $('a[data-style-id=' + styleid + ']');

	// if style has a parent
	if (link.is('[data-style-parentid]')) {
		var parentid = link.data('style-parentid');
		$('a[data-style-id=' + parentid + ']').parent().addClass('passive');

		$('span.titleMainGenre').parent().contents().eq(1)[0].data = ' / ' + link.text();
	}
	else {
		$('span.titleMainGenre').text(link.text()).parents().contents().eq(1)[0].data = '';
	}

	link.parent().addClass('active');
}

function ToggleFavorites() {
	if ($('#player:visible').length > 0 && $('#player div.rad-favlist:visible').length > 0) {
		HideQuickFavorites();
	}
	else {
		GetQuickFavorites();
	}
}

function ShowQuickFavorites() {
	if (!isAuthenticated) {
		ToggleNotification('#notifications');
		return;
	}
	HideShareOptions();

	$('#player div.rad-favlist').slideDown();
}

function HideQuickFavorites() {
	$('#player div.rad-favlist').slideUp();
}

function GetQuickFavorites() {
	if (!isAuthenticated) {
		ToggleNotification('#notifications');
		return;
	}

	$.post('/' + language + '/Favorites/Get', function (result) {
		if (result) {
			RefreshHTML('#player div.rad-favlist', result);

			ShowQuickFavorites();
		}
	});
}

function OnAddFavorite(success, radioUID) {
	if (success) {
		var playBtn = $('#tile-' + radioUID + ' .radioPlayBtn, #radioProfileInfo .radioPlayBtn');
		var streamData = playBtn.data('play-stream');

		if (streamData) {
			streamData.isFavorite = true;
			playBtn.data('play-stream', streamData);
		}

		$('#tile-' + radioUID + ' .fav-icon img').attr('src', favoriteImage);
		$('#tile-' + radioUID + ' .fav-icon, #radioProfileActions a.fav').attr('onclick', 'RemoveFavorite(\'' + radioUID + '\', event)');

		if (controller == 'radio') $('#radioProfileActions a.fav').text(removeFromFavoriteText);

		if (controller == 'home' && action == 'favorites') {
			$.post('/' + language + '/Home/Favorites', function (result) {
				RefreshHTML('#featuredRadio', result);
			});
		}

		if (currentStream.radioUID == radioUID) {
			currentStream.isFavorite = true;
			UpdatePlayer();
		}

		// Refresh quick favorites
		if ($('#player div.rad-favlist:visible').length > 0) {
			GetQuickFavorites();
		}
	}
	else {
		isAuthenticated = false;
		$('#navAccount').hide();
		$('#navLogin').show();
		ToggleNotification('#notifications');
	}
}

function OnRemoveFavorite(success, radioUID) {
	if (success) {
		var playBtn = $('#tile-' + radioUID + ' .radioPlayBtn, #radioProfileInfo .radioPlayBtn');
		var streamData = playBtn.data('play-stream');

		if (streamData) {
			streamData.isFavorite = false;
			playBtn.data('play-stream', streamData);
		}

		$('#tile-' + radioUID + ' .fav-icon img').attr('src', unfavoriteImage);
		$('#tile-' + radioUID + ' .fav-icon, #radioProfileActions a.fav').attr('onclick', 'AddFavorite(\'' + radioUID + '\', event)');

		if (controller == 'radio') $('#radioProfileActions a.fav').text(addToFavoriteText);

		if (controller == 'home' && action == 'favorites') {
			$.post('/' + language + '/Home/Favorites', function (result) {
				RefreshHTML('#featuredRadio', result);
			});
		}

		if (currentStream.radioUID == radioUID) {
			currentStream.isFavorite = false;
			UpdatePlayer();
		}
		// Refresh quick favorites
		if ($('#player div.rad-favlist:visible').length > 0) {
			GetQuickFavorites();
		}
	}
	else {
		isAuthenticated = false;
		$('#navAccount').hide();
		$('#navLogin').show();
		ToggleNotification('#notifications');
	}
}

function ToggleLanguages() {
	if ($('#footer ul.first, #footerHome ul.first').hasClass('hide')) {
		HideLanguages();
	}
	else {
		ShowLanguages();
	}
}

function ShowLanguages() {
	$('#footer ul.first, #footerHome ul.first').removeClass('show').addClass('hide');
}

function HideLanguages() {
	$('#footer ul.first, #footerHome ul.first').removeClass('hide').addClass('show');
}

function ToggleHomeCategory(link) {
	$('#featuredRadio p.category a').removeClass('active');
	$('#featuredRadio .card').remove();
	$('.featuredPrev, .featuredNext').hide();
	link.addClass('active');
	ShowLoader();
}

function SlideHomeRadios(link) {
	ShowLoader(function () {
		$('#featuredRadio .card').remove();
		$('.featuredPrev, .featuredNext').hide();
	});

	$.post($(link).attr('href'), function (result) {
		RefreshHTML('#featuredRadio', result);
		RefreshRadioTiles();
		HideLoader();
	});
}

function ShowLoader(callback) {
	loaderTimeout = setTimeout(function () {
		$('#loader').show();
		if (callback)
			callback();
	}, 100);
}

function HideLoader() {
	if (loaderTimeout) {
		clearTimeout(loaderTimeout);
	}

	$('#loader').hide();
}

function RefreshHTML(selector, htmlData) {
	var content = $(htmlData).closest(selector).html();
	if (content == null) {
		content = $(htmlData).find(selector).html();
		if (content == null) {
			$(selector).html(htmlData);
		}
	}
	$(selector).html(content);
}

function ToggleNotification(selector) {
	var notification = $(selector);
	notification.show();
	setTimeout(function () {
		notification.fadeOut(2000);
	}, 5000);
}

function AcceptCookies() {
	$.post('/' + language + '/base/acceptcookies');
	$('#cookieDough p').fadeOut('fast');
	$('#cookieDough').slideUp();
}

function RefreshRadioTiles() {
	if (currentStream) {
		if (currentStream.prevRadioUID) {
			$('#tile-' + currentStream.prevRadioUID).find('div.radioPlayBtn').removeClass('StopBtn');
		}

		var playBtn = $('#radioProfileInfo div.radioPlayBtn');
		if (currentStream.isPlaying) {
			$('#tile-' + currentStream.radioUID).find('div.radioPlayBtn').addClass('StopBtn');

			if (playBtn.length && controller == 'radio' && playBtn.data('play-stream').radioUID == currentStream.radioUID) {
				playBtn.addClass('StopBtn');
			}
		}
		else {
			$('#tile-' + currentStream.radioUID).find('div.radioPlayBtn').removeClass('StopBtn');

			if (playBtn.length && controller == 'radio' && playBtn.data('play-stream').radioUID == currentStream.radioUID) {
				playBtn.removeClass('StopBtn');
			}
		}
	}
}

function OnStreamPlay() {
	RefreshRadioTiles();
	GetCurrentSong();
	UpdatePlayer();

	if (IsPlayerDetached() && SupportsHistoryApi()) {
		detachedPlayer.history.replaceState({}, '', BuildListenUrl(currentStream.url));
	}
	else {
	}

	if ($('#player:visible').length == 0) {
		ShowPlayer(true);
	}
}

function OnStreamStop() {
	if (currentStream) {
		currentStream.isPlaying = false;
		$('#tile-' + currentStream.radioUID).find('div.radioPlayBtn').removeClass('StopBtn');
	}

	if (currentSongTimeout) {
		clearTimeout(currentSongTimeout);
	}

	RefreshRadioTiles();
}

function UpdatePlayer() {
	if (currentStream.logo) {
		$('#player .jp-details img').attr('src', currentStream.logo);
	}
	if (currentStream.song) {
		if (currentStream.song.trim() == '-') {
			currentStream.song = '';
		}
		$('#player .rad-tracks li').text(currentStream.song);
	}

	$('#player div.jp-details a').attr('href', '/' + language + '/radio/' + currentStream.url + '/index').text(currentStream.title);
	$('#player .rad-actions .fav img').attr('src', currentStream.isFavorite ? playerFavoriteImage : playerUnfavoriteImage);

	UpdateShareLinks();
}

function InitializePlayer() {
	var playerInitializedTimeout = setTimeout(function () {
		$('#player').show();
		InitializePlayer();
	}, 1000);

	player = $('#player #jquery_jplayer_1').jPlayer({
		error: function () {
			if (currentStream) {
				currentStream.isPlaying = false;
				RefreshRadioTiles();
			}
		},
		ready: function () {
			clearTimeout(playerInitializedTimeout);
		},
		solution: 'html,flash',
		swfPath: '/js',
		supplied: 'mp3',
		preload: 'none',
		wmode: 'window',
		keyEnabled: true,
		volume: 0.5
	});

	$('#player .jp-play, #player .jp-pause').click(function (event) {
		ToggleStream(currentStream);
		event.preventDefault();
		event.stopPropagation();
	});

	$('#player .rad-actions .fav').click(function (event) {
		if (currentStream.isFavorite) {
			RemoveFavorite(currentStream.radioUID, event);
		}
		else {
			AddFavorite(currentStream.radioUID, event);
		}

		event.preventDefault();
	});

	$('#player .jp-controls .getVolume').click(function (event) {
		ToggleVolume();
		event.preventDefault();
	});

	$('#player .jp-volume-bar').click(function (event) {
		ShowVolume();
	});

	$('#player .rad-actions .favlist').click(function (event) {
		ToggleFavorites();
		event.preventDefault();
	});

	$('#player .rad-actions .share').click(function (event) {
		ToggleShareOptions();
		event.stopPropagation();
		event.preventDefault();
	});

	$('#player .rad-actions a.detach').click(function (event) {
		DetachPlayer(currentStream.url);
		event.preventDefault();
	});

	$('#player .jp-details').click(function (event) {
		var link = $(this).find('a');
		NavigateTo(link.attr('href'));
		event.stopPropagation();
		event.preventDefault();
	});
}

function InitShare(radUID, radName, language, radUrl, titleColor, backColor) {
	$(document).ready(function () {
		// Select content of code field on focus
		$("#share textarea").click(function (e) {
			$(this).select();
		});

		$('#colorBackPickerInput').ColorPicker({
			onChange: function (hsb, hex, rgb) {
				$('#colorBackPickerInput').val(hex);
				backColor = hex;
				LoadBannerCode(radUID, radName, language, radUrl, titleColor, backColor);
			}
		});

		$('#colorTextPickerInput').ColorPicker({
			onChange: function (hsb, hex, rgb) {
				$('#colorBackPickerInput').val(hex);
				titleColor = hex;
				LoadBannerCode(radUID, radName, language, radUrl, titleColor, backColor);
			}
		});

		$("input[name=playerSize]:radio").click(function () { LoadBannerCode(radUID, radName, language, radUrl, titleColor, backColor); });
		$("#autoPlay").click(function () { LoadBannerCode(radUID, radName, language, radUrl, titleColor, backColor); });
		LoadBannerCode(radUID, radName, language, radUrl, titleColor, backColor);
	});
}

function IsMobile() {
	return $(window).width() <= 1024;
}

function IsExportablePlayer() {
	return false;
}

function BuildListenUrl(radiourl) {
	return hostUrl + '/' + language + '/radio/' + radiourl + '/listen/?autoplay=' + currentStream.isPlaying;
}

function DecodeUrl(url) {
	return decodeURIComponent(url).replace(/\+/g, '%20');
}

function LoadBannerCode(radUID, radName, language, radUrl, titleColor, backColor) {
	var bannerType = $("input[name=playerSize]:checked").val();
	var autoPlay = $('#autoPlay').is(':checked');

	$.post('/' + language + '/Radio/' + radUrl + '/GetBannerCode',
		{ bannerType: bannerType, backColor: backColor, titleColor: titleColor, radUID: radUID, radName: radName, autoPlay: autoPlay, language: language },
		function (data) {
			$("#code").text(data.result); $("#embed").html(data.result);
		}
	);
}

function SupportsHistoryApi() {
	return !!(window.history && history.pushState);
}