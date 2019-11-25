var firstLoading = true;
var lastMessageLoaded = 0;
var lastChatRefresh = 0;
var autoReplay = true;
var autoLangHelper = 1;
var actualisationMusique = 0;

function getLocalTimestamp() {
    var date = new Date;
    return Math.floor(date.getTime()/1000);
}

function getXMLHttpRequest() {
    var xhr = null;

    if (window.XMLHttpRequest || window.ActiveXObject) {
        if (window.ActiveXObject) {
            try {
                xhr = new ActiveXObject("Msxml2.XMLHTTP");
            } catch(e) {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }
        } else {
            xhr = new XMLHttpRequest();
        }
    } else {
        alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
        return null;
    }

    return xhr;
}

/**
 * Envoie une requete à getChat.php. Si il n'y a aucun nouveau message, alors getChat.php ne retourne rien et le script reste en pending
 * sinon on renvoi le nouveau message puis on relance la fonction
 */
function getChat() {

    //Anti-crash / Connexion loss system

    if (firstLoading) {
        var url = "/app/ajax/getChat.php?first=1";
        lastChatRefresh = getLocalTimestamp();
    }
    else {
        var url = "/app/ajax/getChat.php";
    }

    /**
     * On affiche dans le tchat utilisateur (pas dans la base de donnée) la musique en cours d'écoute
     */
        $.post("public/player/radioUpdateSimple.php",{action:"updateRadioLogs"},function(res) {
            var musique = res;

            $.post("public/player/radioUpdateSimple.php",{action:"updateRadioLogs"},function(resTwo) {
                var actualisation = resTwo;

                if(musique != actualisation){
                    $('#chat').append('<br><span style="color:green"><b>Lisa : Maintenant en écoute "' + resTwo +
                        '"</b></span>');
                    musique = res;
                }
            });
        });

    $.ajax({
        type: 'POST',
        url: url,
        data: {action:"getChat",lastM:lastMessageLoaded,langHelper: autoLangHelper},
        dataType: 'json',
        timeout: 10000,
        success: function(donnee){
            lastChatRefresh = getLocalTimestamp();

            var e = document.getElementById('chat');
            if (donnee.content != null && donnee.content != '') {
                if(donnee.clear == "Y"){
                    clearTchat();
                }


                $("#chat").append(donnee.content);
                updateGlobal()
            }

            lastMessageLoaded = donnee.lastM;
            autoScroll();


            setTimeout("getChat();", 800);
            $("#tchatError").fadeOut('fast');

        },
        error: function(object, string, status) {
            setTimeout("getChat();", 150);
            $("#tchatError").fadeIn('fast');
        }});

    firstLoading = false;

}

function autoScroll() {

    if (scroll == true)
    {
        $('#text').stop().animate({
            scrollTop: $("#text")[0].scrollHeight
        }, paramScroll);
        //console.log('It\'s Scroll');
    }

}

function clearTchat() {
    $("#chat").empty();
    $("#message").val('');
}

$(document).ready(function() {
    getChat();
    setInterval('autoScroll()', 5000);
});

function sendChat() {
    var data=$('#message').val().substring(0,500);
    $('#message').val('');
    $("#message").css('background-color','#CFB4B4');
    if (data.trim() == "") { $("#message").css('background-color','white'); return; }
    if (data.indexOf('est protégé de l\'attaque') != -1 || data.indexOf('vos subtiles potions') != -1 || data.indexOf('Félicitations ! G') != -1 || data.indexOf('Vous dévorez le loup') != -1 || data.indexOf('Vous ne dévorez aucun') != -1 || data.indexOf('Vous vous réveillez,') != -1 || data.indexOf('GrÃ¢ce à vos subtiles') != -1 || data.indexOf('Votre objectif est d') != -1 || data.indexOf('Bon jeu et... Bonne chance !') != -1) {
        $("#message").css('background-color','white');
        $('#chat').append('<br><b style="color:darkred">Vous n\'êtes pas autorisé à copier/coller des messages privés</b>');
        return;
    }
    if (data == "/clear") {
        clearTchat();
        $("#message").css('background-color','white');
        return;
    }
    if (data == "/help") {

        $('#chat').append('<br><hr><span style="color:green"><b>Lisa : Voici les commandes disponible dans le tchat :<br><br>' +
            '/free - Pour vous mettre en tant que présent dans le tchat <br>' +
            '/afk - Pour vous mettre absent dans le tchat <br>' +
            '/busy - Pour vous mettre en tant qu\'occupé dans le tchat <br>' +
            '/clear - Pour effacer le tchat <br>' +
            '/dedi - Pour envoyer une dédicace pendant une émission' +
            '</b></span><hr>');
        return;
    }
    $.post("app/ajax/postChat.php", {"msg":data}, function(res) {
        if (res == 'OK') {
            $('#message').css('background-color','white');
        } else if(res == "DEDI_OK"){
            $('#message').css('background-color','white');
            notif({
                msg: "<b>Info:</b> Votre dédicace a bien été envoyée!",
                width: 600,
                timeout: 5000,
                type: "info"
            });
        } else {
            $('#message').val(data);
            if (res == 'FLOOD') {
                $('#chat').append('<br><b style="color:darkred">N\'envoyez pas trop de messages, merci.</b>');
            } else if (res == 'FORBIDDDEN') {
                $('#chat').append('<br><b style="color:darkred">Vous n\'êtes pas autorisé à envoyer des messages actuellement.</b>');
            } else if (res == 'NOT_PERMITTED') {
                $('#message').val('');
            } else if (res == 'MAJ') {
                $('#chat').append('<br><b style="color:darkred">L\'usage des majuscules doit rester occasionnel.</b>');
            } else if (res == 'PRIVE') {
                $('#message').val('');
                $('#message').css('background-color','white');
                $('#chat').append('<br><b style="color:green">L\'utilisateur a correctement était avertit.</b>');
            } else {
                alert("Une erreur est intervenue\nErreur : \n"+res);
            }
        }
    }).fail(function() {
        $('#message').val(data);
    });
}

function checkChatActivity() {

    //Vérification du fonctionnement correct du tchat
    var timestamp = getLocalTimestamp();
    if ((timestamp - lastChatRefresh) > 60) { //tchat inactif depuis plus de 60s !
        console.log('La connexion semble interrompue entre le serveur et votre ordinateur.');
        lastChatRefresh = timestamp;
    }

}


function updateGlobal() {

    $.post("app/ajax/global.php",{
        action:"get",
    },function(donnee){
        if (donnee.erreur == '') {

            $("#colonneDroite").empty().append(donnee.droite);

            //var j = document.getElementById('premiumContent');
            //j.innerHTML = donnee.premium;

            //$('#viewerContent').html(donnee.specs);

            //Mise à jour infos joueurs
            if ('function' == typeof(Handle_spans)){ //Sécurité anticrash
                Handle_spans();
            }

            var g = document.getElementById('chat');

        } else {
            if (donnee.erreur == 'fatal') {
                window.location = "?page=tchat."+donnee.redir+"";
            }
        }
        /*On ajoute le contenu de la réponse dans le Dom du document*/
        /*g.innerHTML = g.innerHTML + "<br />(update)";
         $("#chat").animate({scrollTop: $("#chat").attr("scrollHeight")}, 1000);
        */
    },"json");

}

setInterval("updateGlobal();", 50000);
setInterval("checkChatActivity();", 5000);
