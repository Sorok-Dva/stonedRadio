<?php
// Votre RadioUID
$radiouid = "fd413564-e531-41ae-b2b3-2118e1b62eb6";
// Votre APIKey
$apikey = "44057a76-2014-4264-bec2-f20db09719c5";
// Récupération des pochettes
$cover = "yes"; // "yes" ou "no"
$cache = 'cache.txt'; ### Fichier de cache local ###
$cache_c = 'cache_call.txt'; ### Fichier de cache_call local ###

##################################
####### NE PAS MODIFIER ! #######
##################################
$date = '-1';
if($lines = file($cache_c)){$date = (isset($lines[1]) ? $lines[1] : '-1'); $time = $lines[0]; $expire = time() - $time;} else {$expire = time() - 1;}
if(@file_exists($cache) && $date > $expire && file_get_contents($cache) != ''){
    $xml = @simplexml_load_file($cache);
    $artist = trim($xml->track->artists);
    $title = trim($xml->track->title);
    $current = trim($xml->track->current);
    $current_peak = trim($xml->track->current_peak);
    if(trim($xml->track->cover)=="")
    {
        $cover = "http://radionomy.letoptop.fr/images/none.jpg";
    }
    else
    {
        $cover = trim($xml->track->cover);
    }
} else {
    @file_put_contents($cache_c, '200'."\n".time());
    $context = stream_context_create(array('http' => array('timeout' => 3)));
    touch($cache);
    $xml = @file_get_contents('http://api.radionomy.com/currentsong.cfm?radiouid='.$radiouid.'&callmeback=yes&type=xml'.(!empty($apikey) ? '&apikey='.$apikey : '').''.(!empty($cover) ? '&cover='.$cover : '').'',0, $context);
    if(!$xml){
        $xml = @simplexml_load_file($cache);
    } else {
        @file_put_contents($cache, $xml);
        $xml = @simplexml_load_file($cache);
        $expire_n = ($xml->track->callmeback / 1000);
        if($expire_n < 10) $expire_n = 30;
        @file_put_contents($cache_c, $expire_n."\n".time());
    }
    $artist = trim($xml->track->artists);
    $title = trim($xml->track->title);
    $current = trim($xml->track->current);
    $current_peak = trim($xml->track->current_peak);
    if(empty($xml->track->cover))
    {
        $cover = "http://radionomy.letoptop.fr/images/none.jpg";
    }
    else
    {
        $cover = trim($xml->track->cover);
    }
}

print $artist; ?> - <?php  print $title;  ?>