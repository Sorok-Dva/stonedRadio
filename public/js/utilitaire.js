var bloque = false;
var scroll = true;
var flood = 0;
var alreadySentChrono = false;
var IAmPremium = true;

function tailleEcran() {

    if (document.body)
    {
        var larg = (document.body.clientWidth);
        var haut = (document.body.clientHeight);

    }
    else
    {
        var larg = (window.innerWidth);
        var haut = (window.innerHeight);
    }


    if (larg < 10 || haut < 10) {
        $('#jeu').fadeOut('fast');
        $('#bloque').fadeIn('slow');
        bloque = true;
    } else {
        if (bloque) {
            $('#jeu').fadeIn('fast');
            $('#bloque').fadeOut('slow');
            bloque = false;
        }
    }

    setTimeout("tailleEcran()", 500);

}

tailleEcran();

function setStatus(status){
    if (status.value == "0"){
        var send = "/free";
    } else if (status.value == "1"){
        var send = "/afk";
    } else if (status.value == "2"){
        var send = "/busy";
    }
    $.post("app/ajax/postChat.php", {"msg":send}).fail(function() {
        alert('Une erreur est survenue dans le changement de votre statut.');
    });
}

//Gestion des sons
function jouerSon(son, stop) {

    if (son == 'FORCE') {
        window.location = "index.php";
        return;
    }


    if (son != 'none' && paramSon == 0) {

        if (sonPret) {
	
            var exp = "http";
            if(!(son.match(exp)))
            { 
                soundManager.play(son,"assets/sons/"+son+".mp3");
            }
            else
            { 
                soundManager.play(son,son);
            }
		
            
        } else {
            setTimeout("jouerSon('"+son+"')", 100);
        }

    }

    if (!stop) updateGlobal();
}

function stopAllSound() {
    
    soundManager.stopAll();
    $("#musicPlayer").fadeOut();
    
}

$(function(){
    $("#chat").hover(
        function () {
            scroll = false;
        },
        function () {
            scroll = true;
        }
        )
    
    $("select").focusin(
            function () {
                scroll = false;
            })
        
            $("select").focusout(
            function () {
                scroll = true;
            })
});


function premiumopen() {
    $('#premiumPopup').animate({
                right: "-5px"
            }, 'fast', function() {
                // Animation complete.
                });
}

function premiumclose() {
    $('#premiumPopup').animate({
                right: "-390px"
            }, 'fast', function() {
                // Animation complete.
                });
}


$(document).ready(function() {
	if (roomIDS != 0) {
		var stateObj = { foo: "bar" };
		//window.history.pushState(stateObj, 'Loups-Garous En Ligne - Jeu', '/jeu/index.php?partie='+roomIDS);
	}
});

function showParams() {
    $('#blackout').fadeIn('slow');
    $('#params').fadeIn('slow');
}

function closeParams() {
    $('#blackout').fadeOut('fast');
    $('#params').fadeOut('fast');
}

function toogleAutoReplay() {
    autoReplay = false;
    $('#autoReplayDiv').fadeOut();
}