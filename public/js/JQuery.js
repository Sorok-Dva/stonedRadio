/**
 * 	@Author Created by Llyam Garcia (Liightman) on 19/07/2015.
 * 	@File JQuery.js
 * 	@version 2.9
 * 	@todo It become
 */

    /**
     *	@Desc Déclarations des variables
     */
    var urlInteragir = "/app/ajax/JQuery.php";

    function LaunchRadio(){
        $(".radioPlayBtn").unbind('click');
        jQuery(document).ready(function(){
            PlayStream({isFavorite: false,  isPlaying: true, logo: "https://i.radionomy.com/document/radios/f/fd41/fd413564-e531-41ae-b2b3-2118e1b62eb6.s400.png", mp3: "https://listen.radionomy.com/radiostoned", radioID: 465890, song: "", title: "RadioStoned", url: "radiostoned"});
        });

    }
/**
 *  Functions concernant la partie utilisateurs
 */
        /**
         * Ajouter un event handler sur les spans "player" (pour afficher les interactions)
         */
        function Handle_spans() {
            $("span.user").unbind('click');
            $("span.user").click(function() {
                var pseudo_selected = $(this).text();
                Profile(pseudo_selected);
            });
        }

        /**
         * Force à un utilisateur de changer son sexe
         */
        function updateSexe(){
            $.post(urlInteragir,{"action": "updateSexe"}, function(data) {
                if (data != "error"){
                    if (data.result === "haveToChange"){
                        new_dialog_content = "<center><h3>Information</h3></center>"+
                            "Suite au changement de version, vous n'avez pas pu spécifier votre sexe.<br /><br />"+
                            "<b>Merci</b> de bien nous l'indiquer via le formulaire ci-dessous!<br /><br />"+
                            "<label>Votre sexe</label>"+
                            "<select class=\"form-control\" id=\"sexe\" onchange=\"setSexe(this)\">"+
                            "<option selected=\"\" value=\"na\">Vous êtes?</option>"+
                            "<option value=\"H\">Un Homme</option>"+
                            "<option value=\"F\">Une Femme</option>"+
                            "</select><br>";

                        $( "#dialog" ).empty();
                        $( "#dialog" ).append( new_dialog_content );
                        $( "#dialog" ).dialog( "option", "position", "center" );
                        $( "#dialog" ).dialog( "open");
                    }
                }
            }, 'json');
        }
        function setSexe(status){
            var sexe = status.value;
            $.post(urlInteragir,{"action": "setSexe", "sexe": sexe}, function(data) {
                notif({
                    msg: "<b>Information:</b> Vos informations ont étaient mises à jour",
                    type: "success"
                });
                $( "#dialog" ).dialog( "close");
            });
        }
        /**
         * Function qui permet d'effectuer des recherches
         */
        function research(){
            var term = $("#search").val();
            if(term != "") {
                $.post(urlInteragir,{"action": "search", "term": term}, function(data) {
                    if (data != "error"){
                        if (data != ""){
                            $("#resultSearch").empty().append(data).show();
                        } else {
                            $("#resultSearch").empty().append('<li class="Typeahead">Désolé, aucun résultat ne correspond à votre recherche</li>').show();
                        }
                    }
                }, 'json');
            } else {
                $("#resultSearch").empty().hide();
            }

        }

        /**
         * Fonction pour afficher les formulaires afin de modifier les information de son compte
         */
        function updateProfile(action){
            $.post(urlInteragir,{"action": "getFormulaireToChangeProfile", "askFor": action}, function(data) {
                $("#" + action + "").empty().append(data);
            }, 'json');
        }
        /**
         * Fonction pour  modifier les information de son compte
         */
        function updateInfoProfile(action){
            if (action === "identite") {
                var newInfo = $(".NewPseudo").val();
            } else if (action === "password"){
                var oldInfo = $(".OldPass").val();
                var newInfo = $(".NewPass").val();
                var newInfo2 = $(".confNewPass").val();
            } else  if (action === "mail") {
                var oldInfo = $(".OldMail").val();
                var newInfo = $(".NewMail").val();
            }
            if (newInfo === "") {
                notif({
                    msg: "<b>Erreur:</b> Vous n'avez pas rempli tous les champs nécessaires.",
                    type: "error"
                 });
            } else {
                $.post(urlInteragir,{"action": "updateProfile", "askFor": action, "newInfo": newInfo, "newInfoOption": newInfo2, "oldInfo": oldInfo}, function(data) {
                    if(data!="error"){
                        if(data.erreur === "none"){
                            if(data.fait === "ok"){
                                $("#" + action + "").empty().append("Information mises à jour.");
                                notif({
                                    msg: "<b>Information:</b> Vos informations ont étaient mises à jour",
                                    type: "success"
                                });
                            }
                        } else {
                            notif({
                                msg: "<b>Erreur:</b> "+data.erreur+"",
                                type: "error"
                            });
                        }
                    }
                }, 'json');
            }

        }

        /**
         * Function qui permet à l'utilisateur de supprimer son compte
         * @constructor
         */
        function DeleteAccount() {
            if (confirm("ATTENTION : Cette action est définitive ! \n\n Vous ne pourrez NI vous réinscrire avec ce pseudo, NI avec l'adresse email qui y est liée. \n\n Êtes-vous sur de vouloir supprimer votre compte ? ")) {
                var delPassword = $('#delPassword').val();
                $.post(urlInteragir,
                    {"action": "delete_account", "delPassword": delPassword},
                    function(data) {
                        if (data != "error") {
                            if (data.fait == "ok") {
                                new_dialog_content = "Nous sommes si navré de vous voir partir :(<br />"+
                                    "<b>Merci</b> d'avoir fait partie des auditeurs de <b>Stoned-Radio</b> !"+
                                    "<br /><br />La suppression du compte sera effectuée lors de votre prochaine déconnexion du site."+
                                    "<br /><br /><span class=\"spanLink\" onclick=\"window.location='?page=users.logout'\"'><u>Cliquez ici si vous souhaitez vous déconnecter immédiatement.<u></a>";
                            }
                            else {
                                new_dialog_content = "Erreur : Le mot de passe que vous avez entré est incorrect.";
                            }
                            $( "#dialog" ).empty();
                            $( "#dialog" ).append( new_dialog_content );
                            $( "#dialog" ).dialog( "option", "position", "center" );
                            $( "#dialog" ).dialog( "open");
                    }
                }, 'json');
            }
        }

        /**
         * Permet d'afficher un profil après une recherche
         * @param futur_profil
         */
        function search(futur_profil) {
            if ($('#requete').length) {
                var futur_profil = $('#requete').val();
                Profile(futur_profil);
            }
        }

        /**
         * Permet d'afficher le profil d'un utilisateur via un dialog()
         * @param pseudo_selected Le pseudo dont on veut voir le profil
         * @constructor
         */
        function Profile(pseudo_selected) {

            $("#dialog_moderation").dialog('close');
            $( "#dialog" ).empty();
            $( "#dialog" ).append( "Chargement du profil en cours..." );
            $( "#dialog" ).dialog( "open");

            $.post(urlInteragir,
                {"action": "charger_profil", "joueur": pseudo_selected},
                function(data) {
                    if (data != "error") {
                        if (data.existing_account == "yes") {
                            afficher_profil = "";
                            affichage_interactions = "";
                            trophies = "";

                            // Mon Profil

                            if (data.profil == "mine") {
                                afficher_profil = '<tr>' +
                                    '<td colspan="2">' +
                                       '<div class="ui-state-error ui-corner-all" style="padding-left:15px;padding-right:15px;margin-top:15px;">'+
                                            '<p style="margin:5px;text-align: center;"><span class="ui-icon ui-icon-alert" style="float: left;"></span>'+
                                            '<span class="spanLink" class="spanLink" onclick="window.location=\'?page=users.manage\'" class="modif_compte">Cliquez ici pour modifier votre profil.</span></p>'+
                                      '</div>' +
                                    '</td>' +
                                    '</tr>';
                            }
                            else {
                                if (data.staff == "yes") {
                                    affichage_interactions += "<tr>" +
                                        "<td colspan=\"2\" align=\"center\" style=\"padding:5px;font-size: 12px;border: 1px solid #FF5C5C;\">"+
                                            "<div>" +
                                                "<input placeholder=\"Modération\" id=\"moderationFieldDialog\" />" +
                                                "<div style=\"display:none;border-left: 1px solid black;border-right: 1px solid black;width: 23%;  border-bottom: 1px solid black;\" id=\"actionMod\"></div>" +
                                        "</div>"+
                                        "</td></tr>";
                                }
                            }
                            trophies += "<tr style=\"background-color: #FFFFFF;\">" +
                                "<td colspan=\"2\" style=\"padding: 7px;border: 1px solid #557186;background-color: #FFFFFF; color: white;\"><div class=\"trophiesText center\"></div><br>"+data.trophies+"</td></tr>";

                            $( "#dialog" ).empty();
                            $( "#dialog" ).append("" +
                                "<table class=\"spacing\" style=\"width:100%;height:100%;color:#333;font-size: 14px;\">" +
                                    "<tr>" +
                                        "<td width=\"10%\" style='padding: 5px;border: 1px solid #557186; background-color: #45a7ff;'>"+
                                            data.img+
                                        "</td>"+
                                //<td valign="top" style="padding-left:10px;padding-top:20px;">
                                        "<td colspan=\"2\" align=\"center\" style=\"padding: 5px;border: 1px solid #557186; background-color: #45a7ff; color: white;\"><div style='margin-left: -12%;'>"+data.pseudo+", " +data.formatedPoints+" points, <br>"+
                                        "<b>"+data.role+"</b></div>"  +
                                     "</tr>"+trophies+afficher_profil+affichage_interactions+
                                "</table>");

                            if (data.staff == "yes") {
                                $( "#moderationFieldDialog" ).click(function() {
                                    $( "#actionMod" ).empty();
                                    $( "#actionMod" ).toggle(300);
                                    var select = $('#actionMod');
                                    $.each(data.available_choices, function (val, text) {
                                        select.append($('<span class="spanLink" id=\"spanAction'+val+'\"/> ').val(val).html(text));
                                        $.each(data.name_available_choices, function (val1, text1) {
                                            $("#spanAction"+val1+"").attr("onClick","Moderation_rapide('"+text1+"', '"+data.pseudo+"',  3);");

                                        });
                                        select.append('<br>');
                                    });
                                });
                            }
                            $( "#dialog" ).dialog( "option", "position", "center" );
                        }
                        else if (data.existing_account == "banned") {
                            $( "#dialog" ).empty();
                            $( "#dialog" ).append("<table class=\"spacing\" style=\"width:100%;height:100%;color:#333;font-size: 14px;\">"+
                                "<tr><td colspan=\"2\" align=\"center\" style=\"padding: 7px;\">Ce membre a été <b>banni définitivement</b>.</td></tr></table>");
                            $( "#dialog" ).dialog( "option", "position", "center" );

                        }
                        else if (data.existing_account == "removed") {
                            $( "#dialog" ).empty();
                            $( "#dialog" ).append("<table class=\"spacing\" style=\"width:100%;height:100%;color:#333;font-size: 14px;\">"+
                                "<tr><td colspan=\"2\" align=\"center\" style=\"padding: 7px;\">Ce compte <b>a été supprimé</b>.</td></tr></table>");
                            $( "#dialog" ).dialog( "option", "position", "center" );
                        }
                        else {
                            $( "#dialog" ).empty();
                            $( "#dialog" ).append("<table class=\"spacing\" style=\"width:100%;height:100%;color:#333;font-size: 14px;\">"+
                                "<tr><td colspan=\"2\" align=\"center\" style=\"padding: 7px;\">Ce membre n'existe <b>pas</b>.</td></tr></table>");
                            $( "#dialog" ).dialog( "option", "position", "center" );
                        }
                    }
                    else if (data === "error"){
                        $( "#dialog" ).empty();
                        $( "#dialog" ).append("<table class=\"spacing\" style=\"width:100%;height:100%;color:#333;font-size: 14px;\">"+
                            "<tr><td colspan=\"2\" align=\"center\" style=\"padding: 7px;\">Une erreur est survenue.</td></tr></table>");
                        $( "#dialog" ).dialog( "option", "position", "center" );
                    }
                }, 'json');

        }

/**
 * Autres fonctions :
 */

        function Vote(vote,artist,music, cover){
            $.post(urlInteragir,{"action": "vote", "vote": vote, "artist": artist, "music": music, "cover": cover}, function(data) {
                if (data != "error"){
                    if(data.fait === "OK"){
                        notif({
                            msg: "<b>Information:</b> Votre vote a bien été pris en compte!",
                            type: "success"
                        });
                    }else if (data.fait === "NO"){
                        if(data.because === "ALREADY_VOTE"){
                            notif({
                                msg: "<b>Erreur:</b> Vous avez déjà voté pour cette musique!",
                                type: "error"
                            });
                        }else if(data.because === "NOT_LOGGED"){
                            notif({
                                msg: "<b>Erreur:</b> Vous devez être connecté pour voter!<br> (Ce afin d'évitez les spams vote)",
                                type: "error"
                            });
                        }
                    }
                }
            }, 'json');
        }

        function postDedi() {
            $("#loader").show();

            var message = $('#dedicace').val();
            $.post("/app/ajax/oldDedi.php", {com: message},function(data){
                $("#loader").hide();
                if(data!="ok"){
                    notif({
                        msg: "<b>Erreur:</b> Une erreur est survenue "+data,
                        type: "error"
                    });
                }
                else
                {
                    $('#dedicace').val('');
                    $("#restant").empty().append('500');
                    notif({
                        msg: "<b>Information:</b> Votre dédicace a été envoyée !",
                        type: "success"
                    });
                    setTimeout("autoTimeout();", 100);
                }
            });
        }

        /**
         *	Système antiflood by Liightman
         **/
        function TimeoutDedi(time) {
            var string;
            if(time > 1) var s = "s";
            else var s = "";
            string = '<br/><center><b>Vous devez attendre <span id="timeout"><u>'+time+' seconde'+s+'</u></span> avant d\'envoyer de nouveau une dédicace</b></center>';

            $('#boutton').remove();
            $("#dom").empty();
            $("#dom").append(string);

            if(time == 0 ) {
                $("#dom").empty();
                $("#dom").append('<center><input class="btn btn-primary" type="submit" value="Envoyer" id="boutton" onclick="postDedi()" /></center>');
            }
        }

        function autoTimeout() { //Moche mais simple
            TimeoutDedi(7);
            setTimeout("TimeoutDedi(6);",1000);
            setTimeout("TimeoutDedi(5);",2000);
            setTimeout("TimeoutDedi(4);",3000);
            setTimeout("TimeoutDedi(3);",4000);
            setTimeout("TimeoutDedi(2);",5000);
            setTimeout("TimeoutDedi(1);",6000);
            setTimeout("TimeoutDedi(0);",7000);
        }
        function GetId(id) {
            return document.getElementById(id);
        }

        var i=false;
        function move(e) {
            if (i) {
                if (navigator.appName!="Microsoft Internet Explorer") {
                    GetId("curseur").style.left=e.pageX + 5+"px";
                    GetId("curseur").style.top=e.pageY + 10+"px";
                }
                else {
                    if(document.documentElement.clientWidth>0) {
                        GetId("curseur").style.left=20+event.x+document.documentElement.scrollLeft+"px";
                        GetId("curseur").style.top=10+event.y+document.documentElement.scrollTop+"px";
                    }
                    else {
                        GetId("curseur").style.left=20+event.x+document.body.scrollLeft+"px";
                        GetId("curseur").style.top=10+event.y+document.body.scrollTop+"px";
                    }
                }
            }
        }
        function showTrophies(text, progressBar) {
            if (i==false) {
                GetId("curseur").style.visibility="visible";
                GetId("curseur").innerHTML = text;

                if (progressBar !== false && progressBar != undefined) {
                    $("#curseur").append("<div class='achievementBar'><div class='achievementProgress' style='width: "+progressBar+"px'></div></div>");
                }

                i=true;
            }
        }
        function hideTrophies() {
            if (i==true) {
                GetId("curseur").style.visibility="hidden";
                i=false;
            }
        }
        document.onmousemove=move;

        function openRadio(){
            $("#listenRadio").stop().animate({
                right: "-10px"
            }, 'fast', function() {
                // Animation complete.
            });
        }
        $(function() {
            $("#listenRadio").hover(
                function () {

                    $(this).stop().animate({
                        right: "-10px"
                    }, 'fast', function() {
                        // Animation complete.
                    });

                },
                function () {
                    $(this).stop().animate({
                        right: "-230px"
                    }, 'fast', function() {
                        // Animation complete.
                    });
                }
            )
        });

/**
 *	Préparation de la page avec Document.ready
 */
$(document).ready(function() {
    Handle_spans();
    updateSexe();
    //LaunchRadio();

    $('body').prepend("<div id=\"dialog\" title=\"Dialogue\"></div>");

    $( "#dialog" ).dialog({
        autoOpen: false,
        show: { effect: 'fade' },
        hide: { effect: 'fade' },
        modal: true,
        width: 650,
        close: function(event, ui) { $('#wrap').show(); },
        open: function(event, ui) { $('.ui-widget-overlay').bind('click', function(){ $("#dialog").dialog('close'); }); }
    });

});
/**
*PERMET DE RAFFRAICHIR TOUTE LES 3 SECONDE EN CE MOMENT A L ANTENNE
*/
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


function refreshDirect()
{
var xhr = getXMLHttpRequest();
xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
                document.getElementById('en_direct').innerHTML = xhr.responseText; // DonnÃ©es textuelles rÃ©cupÃ©rÃ©es
        }
};

xhr.open("GET", "/public/player/emissiondirect.php", true);
xhr.send(null);
}
var TimerRefresh = setInterval("refreshDirect()", 3000); // rÃ©pÃ¨te toutes les 3s