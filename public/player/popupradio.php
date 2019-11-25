<html>
 <head>
 
   <title>Écoute Stoned Radio</title>
   <meta charset="utf-8" />
   
   <style>
	body
	{
		background-color:#eee;
	    margin-left: auto;
        margin-right: auto;
	}
   </style>
		<link rel="stylesheet" type="text/css" href="player.css">
		<script type="text/javascript" src="jquery.min.js"></script>
		<script type="text/javascript" src="jquery.jplayer.min.js"></script>
		<script type="text/javascript" src="jquery.mmenu.min.js?"></script>
		<script type="text/javascript" src="slick.min.js"></script>
		<!-- PLAYER + GESTION DU VOLUME -->
		<script type="text/javascript" src="player.js"></script>
		<script type="text/javascript" src="player2.js"></script>
		<script type="text/javascript" src="action.js"></script>
		<script>
			var timer = setInterval(updateDirect2,2000);

			function updateDirect2() {
				$.post("direct2.php",{action:"verifUpdate2"},function(data) {
					$("#en_direct2").empty();
					$("#en_direct2").append(data);
				});
			}

		</script>
 </head>
 
  <body>
  <?php
  require_once('test2.php');
  ?>
 <center><h3> En ce moment : </h3></center>
  <span id="en_direct2"><center><?php
mysql_connect('mysql5-15.60gp', 'boido', 'pommeret06');
mysql_select_db('boido');
$selectemission = mysql_query('SELECT direct FROM direct_v3');
$dataemission = mysql_fetch_array($selectemission);

if($dataemission['direct']==1)
{
	echo "<center><strong>La libre antenne Le Stoned</center></strong><br />";
}
elseif($dataemission['direct']==2)
{
	echo "<center><strong>The Stoned Song</center></strong><br />";
}
elseif($dataemission['direct']==3)
{
	echo "<center><strong>Musicalement Historique</center></strong><br />";
}
elseif($dataemission['direct']==4)
{
	echo "<center><strong>Open Space</center></strong><br />";
}
elseif($dataemission['direct']==5)
{
	echo "<center><strong>Rediffusion Le Stoned</center></strong><br />";
}
else
{
	$jour = date("D");
	$heure = date("H");
	if($jour=="Mon")
	{
		if($heure>=06 && $heure<10)
		{
			echo "<center><strong>Stoned Morning</center></strong><br />";
		}
		elseif($heure>=17 && $heure<18)
		{
			echo "<center><strong>Playlist Année 2000</center></strong><br />";
		}
		else
		{
			require_once('test2.php');
			echo "<small><strong>";
			print $artist;
			echo "</strong>";
			echo " - ";
			print $title;
			echo "</small>";
		}
	}
	elseif($jour=="Tue")
	{
		if($heure>=06 && $heure<10)
		{
			echo "<center><strong>Stoned Morning</center></strong><br />";
		}
		elseif($heure>=17 && $heure<18)
		{
			echo "<center><strong>Playlist Titre US</center></strong><br />";
		}
		else
		{
			require_once('test2.php');
			echo "<small><strong>";
			print $artist;
			echo "</strong>";
			echo " - ";
			print $title;
			echo "</small>";
		}
	}
	elseif($jour=="Wed")
	{
		if($heure>=06 && $heure<10)
		{
			echo "<center><strong>Stoned Morning</center></strong><br />";
		}
		elseif($heure>=14 && $heure<18)
		{
			echo "<center><strong>Playlist Année 2000</center></strong><br />";
		}
		else
		{
			require_once('test2.php');
			echo "<small><strong>";
			print $artist;
			echo "</strong>";
			echo " - ";
			print $title;
			echo "</small>";
		}
	}
	elseif($jour=="Thu")
	{
		if($heure>=06 && $heure<10)
		{
			echo "<center><strong>Stoned Morning</center></strong><br />";
		}
		elseif($heure>=17 && $heure<19)
		{
			echo "<center><strong>Playlist Titres US</center></strong><br />";
		}
		elseif($heure>=21)
		{
			echo "<center><strong>Playlist Titres US</center></strong><br />";
		}
		else
		{
			require_once('test2.php');
			echo "<small><strong>";
			print $artist;
			echo "</strong>";
			echo " - ";
			print $title;
			echo "</small>";
		}
	}
	elseif($jour=="Fri")
	{
		if($heure<01)
		{
			echo "<center><strong>Playlist Titres US</center></strong><br />";
		}
		elseif($heure>=06 && $heure<10)
		{
			echo "<center><strong>Stoned Morning</center></strong><br />";
		}
		elseif($heure>=17 && $heure<18)
		{
			echo "<center><strong>Électro Time</center></strong><br />";
		}
		elseif($heure>=22)
		{
			echo "<center><strong>Électro Time</center></strong><br />";
		}
		else
		{
			require_once('test2.php');
			echo "<small><strong>";
			print $artist;
			echo "</strong>";
			echo " - ";
			print $title;
			echo "</small>";
		}
	}
	elseif($jour=="Sat")
	{
		if($heure<02)
		{
			echo "<center><strong>Électro Time</center></strong><br />";
		}
		elseif($heure>=06 && $heure<12)
		{
			echo "<center><strong>Stoned Morning</center></strong><br />";
		}
		elseif($heure>=14 && $heure<18)
		{
			echo "<center><strong>Playlist Année 2000</center></strong><br />";
		}
		elseif($heure>=18 && $heure<19)
		{
			echo "<center><strong>Hits Auditeurs</center></strong><br />";
		}
		elseif($heure>=18 && $heure<22)
		{
			echo "<center><strong>Playlist Titres US</center></strong><br />";
		}
		elseif($heure>=22)
		{
			echo "<center><strong>Électro Time</center></strong><br />";
		}
		else
		{
			require_once('test2.php');
			echo "<small><strong>";
			print $artist;
			echo "</strong>";
			echo " - ";
			print $title;
			echo "</small>";
		}
	}
	elseif($jour=="Sun")
	{
		if($heure<02)
		{
			echo "<center><strong>Électro Time</center></strong><br />";
		}
		elseif($heure>=06 && $heure<12)
		{
			echo "<center><strong>Stoned Morning</center></strong><br />";
		}
		elseif($heure>=15 && $heure<16)
		{
			echo "<center><strong>The Stoned Song</center></strong><br />";
		}
		elseif($heure>=18 && $heure<21)
		{
			echo "<center><strong>Playlist Titres US</center></strong><br />";
		}
		else
		{
			require_once('test2.php');
			echo "<small><strong>";
			print $artist;
			echo "</strong>";
			echo " - ";
			print $title;
			echo "</small>";
		}
	}
}
?>   </center></span>

<br /><center>
   <table>
							<tr><center>
								<td id="tdImg" style="border:1px solid black;width:195px;height:195px;background-image:url('<?php echo $cover; ?>'); background-size: 200px 200px;background-color:white;">
									<center>
										<div id="radioProfileTop">
											<div id="radioProfileInfo">
												<div class="radioPlay">
													<div class="radioPlayBtn" data-play-stream="{ &quot;mp3&quot;: &quot;http://listen.radionomy.com/radiostoned&quot;, &quot;radioID&quot;: 465890, &quot;title&quot;: &quot;RadioStoned&quot;, &quot;isFavorite&quot;: false, &quot;url&quot;: &quot;radiostoned&quot;, &quot;logo&quot;: &quot;https://i.radionomy.com/document/radios/f/fd41/fd413564-e531-41ae-b2b3-2118e1b62eb6.s400.png&quot;, &quot;song&quot;: &quot; - &quot; }">
													</div>
												</div>
											</div>
										</div>
									</center>
								</td></center>
							</tr>
						</table></center>
						<table>
						<tr>
								<td>
									<div id="player" class="">
										<div id="jquery_jplayer_1" class="jp-jplayer"></div>
										<div id="jp_container_1" class="jp-audio-stream">
										<div class="jp-type-single"></div>
											<div class="volumeWrap">
												<div class="jp-volume-bar">
													<img class="down" src="https://www.radionomy.com/images/player/playerVolumeDown.png" width="16" height="16">
													<div class="jp-volume-bar-value"></div>
													<img class="up" src="https://www.radionomy.com/images/player/playerVolumeUp.png" width="16" height="16">
												</div>
											</div>
										</div>
									</div>	
								
								</td>
							</tr>
						</table><br />
						<center><strong>Volume du player</strong></center>
						<script type="text/javascript">
							var scheme = 'http';

							var language = 'fr';
							var controller = 'radio';
							var action = 'index';

							var fullUrl = '%2ffr%2fradio%2fradiostoned';
							var currentUrl = controller + '/' + action;

							var isAuthenticated = false;

							var radioScrollEnabled = false;
						</script>
						
					</div>   </center>
  </body>

</html>