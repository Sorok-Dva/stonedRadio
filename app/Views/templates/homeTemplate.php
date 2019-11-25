<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 10/09/2015
 * @Time    : 20:55
 * @File    : homeTemplate.php
 * @Version : 3.7
 */

?>
<div class="container">
    <div class="row">
        <div class="col col-sm-12">
            <div style="height:1px;"> </div>
        </div>
    </div>

    <!-- GAUCHE -->
    <div id="left_wrapper">
        <div class="hits_title">
            <div style="height:6px;"></div>
            Top 5 hits &nbsp;<span class="glyphicon glyphicon-equalizer" aria-hidden="true"></span>
        </div><br />
        <div class="well well-sm"><?php getTop5() ?></div>
		
        <center><a href="?page=top.hits">Voir tout le classement</a></center><br />
		
        <div class="membre_title">
            <div style="height:6px;"> </div>
            Derniers membres inscrits &nbsp;<span class="glyphicon glyphicon-stats" aria-hidden="true"></span>
        </div><br />
             <?php getLastRegisters(); ?>
        <center><a href="?page=users.liste">Voir tous les membres</a></center><br />

        <div class="partenaire_title">
            <div style="height:6px;"> </div>
            Partenaires &nbsp;<span class="glyphicon glyphicon-star" aria-hidden="true"></span>
        </div><br />

        <div style="text-align:center;" class="well well-sm">	
			<a target="_blank" href="http://www.gtactu.fr/" class="a2">GTActu</a><br />
			<a target="_blank" href="https://www.radionomy.com/fr" class="a2">Radionomy</a><br /> 
			<a target="_blank" href="http://www.refgratuit.fr/" class="a2">Refgratuit</a><br />
			<a target="_blank" href="http://fanzouzes.e-monsite.com/" class="a2">Fanzouzes</a><br />
			<a href="http://www.cronjobonline.com" target="_blank" title="Cron Job Service">Cron Service</a>
			<br /><br />
			Envie de devenir partenaire? Envoyez votre demande <a href="?page=contact.index">ici</a>.
		</div>
    </div>

    <?php if (empty($_GET['page'])) { ?>
        <div class="news">
            <div style="float:left;width:12%;">
                <strong><span class="glyphicon glyphicon-tag" aria-hidden="true"></span> Annonce :</strong>
            </div>

            <div style="float:right;width:87%;text-align:center;">
                L'open space de lundi et mardi est annulé !
            </div>
        </div>
	<div id="right_wrapper">
		<div class="row">
			<div class="col col-sm-12">
				<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
								
					<!-- Indicateurs --> 
					<ol class="carousel-indicators">
						<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
						<li data-target="#carousel-example-generic" data-slide-to="1"></li>
						<li data-target="#carousel-example-generic" data-slide-to="2"></li>
					</ol>

					<!-- Images -->
					<div class="carousel-inner" role="listbox">
									
						<div class="item active">
							<img src="http://stoned-radio.fr/public/css/Images/enligne.jpg" />
											
							<div class="carousel-caption">
							</div>
						</div>	
						<div class="item">
							<img src="http://stoned-radio.fr/public/css/Images/animateurs.jpg" />
											
							<div class="carousel-caption">
								De nouveaux animateurs débarquent sur Stoned Radio
							</div>
						</div>	
						<div class="item">
							<img src="http://stoned-radio.fr/public/css/Images/rentree.jpg" />
											
							<div class="carousel-caption">
								Rentrée de Stoned-Radio
							</div>
						</div>						
					</div>

					<!-- Controles -->
					<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
						<span class="sr-only">Précédent</span>
					</a>
					<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
						<span class="sr-only">Suivant</span>
					</a>
								  
				</div>
			</div>
		</div>
	</div>

	<div id="right_presentation">
		Tu peux écouter la radio en cliquant sur le bouton situé <a href="#direct">en haut de la page</a>.<br />
		Tu peux également envoyer ta <a data-toggle="modal" data-target="#myModal" href="#">dédicace</a> (<b>seuls les animateurs y ont accès</b>) qui sera lue lors d'une émission. <i><a href="?page=planning.index">Voir planning des émissions.</a></i>
		<br /><br />
		Grâce aux boutons de vote en haut de la page, tu peux voter pour tes titres préférés ou au contraire, si le titre diffusé te déplaît voter contre. La musique ayant recueilli le plus de vote pour, sera en tête du classement sur la partie gauche de la page index "Le top 5 hits" ou sur le <a href="?page=top.hits">classement complet</a>.
		<br /><br />
		Ci-dessous, tu as les actualités de Stoned Radio, régulièrement mis à jour, ce sont des infos sur tout ce qui concerne la radio en général.
		Tu peux également nous retrouver sur twitter et facebook, pour ça rends-toi en bas de la page.
		<br /><br />
		Pour pouvoir participer aux émissions et envoyer des dédicaces, vous devez vous créer un compte, rendez-vous en haut à droite de la page, et inscrivez-vous, une fois inscrit, vous avez accès à votre espace auditeurs.
		<br /><br />
		Le site est adapté au navigateur Google Chrome et pour les écrans 22 pouces.
	</div>	
	<div id="right_title_news">
	Actualité(s) de Stoned-Radio :
	</div>
	<div id="right_news">
	<div class="alert alert-warning alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  Cliquez sur le titre de votre choix pour lire la news.
	</div>
		<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
		  <div class="panel panel-default">
			<div class="panel-heading" role="tab" id="headingOne">
			  <h4 class="panel-title">
				<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
				  <strong><span class="a">Ouverture de la v3</span></strong>
				</a>
			  </h4>
			</div>
			<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
			  <div class="panel-body">
				Voilà, nous sommes de retour pour ce début d'année scolaire ! Avec énormément de nouveautés, la version 3 du site est enfin arrivée, je vous laisse la découvrir par vous-même en naviguant sur les différentes pages via la bannière située en haut du site.<br /><br />

				Cette nouvelle version du site est beaucoup plus complète et agréable, le design a complétement été refait. Si vous avez des suggestions ou que vous remarquez un bug tel qu'il soit, contactez-nous <a href="index.php?page=contact">ici</a>.<br />

				Sur ce, profitez-bien de ce nouveau site et des nouveautés de la radio ! 
			  </div>
			</div>
		  </div>
		</div>
	</div>

	<div id="social">
		<div class="fb">
			<div class="fb_title">Suis nous sur Facebook</div>
			<div style="height:8px;"> </div>
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.4&appId=482555718471418";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
			<div class="fb-page" data-href="https://www.facebook.com/pages/Stoned-Radio/1495217574104487" data-tabs="timeline" data-width="500" data-height="70" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/pages/Stoned-Radio/1495217574104487"><a href="https://www.facebook.com/pages/Stoned-Radio/1495217574104487">Stoned Radio</a></blockquote></div></div>
		</div>
		
		<div class="twitter">
			<div class="twitter_title">Derniers tweets</div>
			<div style="height:8px;"> </div>
			<a class="twitter-timeline" href="https://twitter.com/Radio_Stoned" data-widget-id="615483593540935680">Tweets de @Radio_Stoned</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		</div>
		
		
		<div class="yt">
			<div class="yt_title">Retrouve nous sur Youtube</div>
			<div style="height:17px;"> </div>
			<center><div class="g-ytsubscribe" data-channelid="UCpK2kQfv5tLVJ-T8RTkzHAw" data-layout="full" data-count="default"></div></center>
		</div>
    </div>

    <?php } else { ?>
        <div>
            <section>
                <?= $content ?>
            </section>
        </div>
 <?php   } ?>
</div>

<?php if(empty($_SESSION)) { ?>
    <div style="word-wrap: break-word;" class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <center><h4 class="modal-title">Lâche ta dédicace gratuitement</h4></center>
                </div>
                <div class="modal-body">
                    <table style="width:auto;">
                        Connectez-vous pour lâcher une dédicace !
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger square-btn-adjust" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div style="word-wrap: break-word;" class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <center><h4 class="modal-title">Lâche ta dédicace gratuitement</h4></center>
                </div>

                <div class="modal-body">
                    <p>
                    <table style="width:100%;">
                        <tr>
                            <td width="28%" valign="top">
                                <label for="pseudo">Pseudo / Pr&eacute;nom :</label>
                            </td>
                            <td width="72%" valign="top">
                                <?= $_SESSION['pseudo']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="dedic">Ta d&eacute;di :</label>
                            </td>
                            <td>
                                <div style="height:9px;"> </div>
								<textarea id="dedicace" class="form-control" style="resize:none;" rows="10" cols="45"></textarea><br>
								Il vous reste <span style="font-weight:bold;" id="restant"></span> caract&egrave;res.
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <br />
                                <center>
									<div id="dom">
										<input class="btn btn-primary" type="submit" value="Envoyer" id="boutton" onclick="postDedi()" />
									</div>
                                </center>

                            </td>
                        </tr>
                    </table>
                    </p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger square-btn-adjust" data-dismiss="modal">Fermer</button>
                </div>

            </div>

        </div>
    </div>
	<script type="text/javascript">
		function maxlength_textarea(id, crid, max)
		{
			var txtarea = document.getElementById(id);
			document.getElementById(crid).innerHTML=max-txtarea.value.length;
			txtarea.onkeypress=function(){eval('v_maxlength("'+id+'","'+crid+'",'+max+');')};
			txtarea.onblur=function(){eval('v_maxlength("'+id+'","'+crid+'",'+max+');')};
			txtarea.onkeyup=function(){eval('v_maxlength("'+id+'","'+crid+'",'+max+');')};
			txtarea.onkeydown=function(){eval('v_maxlength("'+id+'","'+crid+'",'+max+');')};
		}

		function v_maxlength(id, crid, max)
		{
			var txtarea = document.getElementById(id);
			var crreste = document.getElementById(crid);
			var len = txtarea.value.length;
			if(len>max)
			{
				txtarea.value=txtarea.value.substr(0,max);
			}
			len = txtarea.value.length;
			crreste.innerHTML=max-len;
		}
		maxlength_textarea('dedicace','restant',500);
	</script>
<?php } ?>