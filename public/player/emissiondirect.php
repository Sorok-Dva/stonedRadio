<?php
try {
	$dbname = 'boido';
	$user = 'boido';
	$server = 'mysql5-15.60gp';
	$pass = 'pommeret06';
	$bdd = new PDO ('mysql:host=' . $server . ';dbname=' .$dbname, $user, $pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

}
catch (PDOException $e) {
	die();
}
$selectemission = $bdd->query('SELECT direct FROM direct_v3');
$dataemission = $selectemission->fetch();

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
			require_once('radioLogs.php');
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
			require_once('radioLogs.php');
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
			require_once('radioLogs.php');
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
			require_once('radioLogs.php');
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
			require_once('radioLogs.php');
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
			require_once('radioLogs.php');
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
			require_once('radioLogs.php');
		}
	}
}
?>