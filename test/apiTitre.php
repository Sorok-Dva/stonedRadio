<?php
 
/************************************/
/*       Script Last Title          */
/*           By Max                 */
/*		Modified by FleuryK			*/
/************************************/
 
// @author Max
// @modified FleuryK
// @version 2.2
// @description Affichage des derniers titres diffusés
 
// Titre de la page
$title = "Votre Webradio - C'était quoi ce titre";
// Fichier call_api.php du tracklist
$fichier_php_call_api_tracklist="./cache_api.php";
// Affichage des pochettes : 1 = Oui, 0 = Non
$affichagePochette = 1;
// Longeur de l'image pour les pochettes (en px)
$longeurImageImg = "70px";
// Largeur de l'image pour les pochettes (en px)
$largeurImageImg = "70px";
// Fichier (URL) de l'image "Pas de pochette"
$paspochette="http://www.monsite.fr/images/pas_pochette.png";
// Fichier de l'image Rafraîchissement
$refresh="http://www.monsite.fr/tracklist/refresh.png";
// Fichier de l'image d'info
$info="http://www.monsite.fr/tracklist/information_32.png";
// Hauteur de l'image de Rafraîchissement (en px)
$heightrefresh="16px";
// Hauteur de l'image d'info (en px)
$heightinfo="16px";
// Temps de rafraîchissement (en secondes. ATTENTION ! Pas en dessous de 3 minutes = 150 secondes ! En dessous,
// risque de blacklistage de votre clé API !)
$metarefresh=150;
// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! //
// Ne pas modifier la suite du script ! //
// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! //
echo '<!DOCTYPE html>
<html>
<head>
<title>'.$title.'</title>
<meta charset="UTF-8" />
<meta http-equiv="refresh" content="'.$metarefresh.'" />
<link rel="stylesheet" type="text/css" href="tracklist/style.css">
</head>
	<body>
		<div id="images">
			<a href="#" onclick="javascript:window.location.reload();"><img src="'.$refresh.'" alt="Refresh" style="height: '.$heightrefresh.'; border: 0px;" /></a><br />
			<a href="apiTitreInfo.php" onclick="window.open(\'apiTitreInfo.php\',\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=0, resizable=0, copyhistory=0, menuBar=0, width=581, height=300\');return(false)"><img src="'.$info.'" alt="Info" style="height: '.$heightinfo.'; border: 0px;" /></a>
		</div>';
$confirmPochette = ($affichagePochette) ? 'yes' : 'no';	
$xml = file_get_contents("$fichier_php_call_api_tracklist");
$sxml = simplexml_load_string($xml);
$i = 0;
if($affichagePochette)
	echo "		<input type=\"hidden\" value=\"Affichage de la pochette\" />\n\n";
else
	echo "		<input type=\"hidden\" value=\"Pas d'affichage de la pochette\" />\n\n";
foreach ($sxml->track as $radionomy) {
	if ($i==0) {
		$date = '<table style="width: 100%;">
			<tr>
				<td style="border-bottom: 1px solid #FFFFFF; text-transform: uppercase; font-size: 1em; color: #26C4EC;">Diffusé en ce moment</td>
			</tr>';
	}
	else {
		$date = '<table style="width: 100%;">
			<tr>
				<td style="border-bottom: 1px solid #FFFFFF; text-transform: uppercase; font-size: 1em; color: #26C4EC;">Diffusé à '.date('H:i', strtotime($radionomy->dateofdiff)).'</td>
			</tr>';
	}
	if($affichagePochette) {
		if(isset($radionomy->cover) && !empty($radionomy->cover))
			echo "		<div class=\"pochette\">
			<img src=\"$radionomy->cover\" style=\"width: $longeurImageImg; height: $largeurImageImg;\" alt=\"$radionomy->artists - $radionomy->title\" />
		</div>\n";
		else
			echo "		<div class=\"pochette\">
			<img src=\"$paspochette\" style=\"width: $longeurImageImg; height: $largeurImageImg;\" alt=\"Pas de pochette\" />
		</div>\n";
	}
	echo "		<div class=\"diffusion\">$date\n";
	echo "		<tr>
					<td><span style=\"font-weight: bold;\">$radionomy->artists</span><br />$radionomy->title</td>
				</tr>
			</table>
		</div>\n\n";
	$i++;
}
echo "
</body>
</html>";
?>