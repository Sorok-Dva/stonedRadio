<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 17/07/2015
 * @Time    : 12:11
 * @File    : administration.php
 * @Version : 1.0
 * @Todo    : À completer!
 */

if(!empty($_SESSION) AND ($_SESSION['grade'] == "Adm") OR  ($_SESSION['grade'] == "Dev")){ ?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Administration || <?= App::getInstance()->title ?></title>


<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
<link href="http://stoned-radio.fr/admin/assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
<link href="http://stoned-radio.fr/admin/assets/css/custom.css" rel="stylesheet" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>

<body>

<div id="wrapper">
    <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                <span class="sr-only">Bascule navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Panel admin</a>
        </div>
        <div style="color: white;padding: 15px 50px 5px 50px;float: right;font-size: 16px;">
            <a href="http://stoned-radio.fr" class="btn btn-danger square-btn-adjust">Retour sur Stoned-Radio</a>
        </div>
    </nav>

    <nav class="navbar-default navbar-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav" id="main-menu">
                <li class="text-center"><img src="assets/img/find_user.png" class="user-image img-responsive"/></li>
                <li><a href="?page=admin.administration.index"><i class="fa fa-dashboard fa-3x"></i> Accueil</a></li>
                <li><a href="?page=admin.show.dedicasses"><i class="fa fa-desktop fa-3x"></i> Dédicasses</a></li>
                <li><a href="?page=admin.show.users"><i class="fa fa-qrcode fa-3x"></i> Gérer les membres</a></li>
                <li><a href="?page=admin.show.stats"><i class="fa fa-bar-chart-o fa-3x"></i> Stats du site</a></li>
                <li><a  href="replay.php"><i class="fa fa-table fa-3x"></i> Gérer les replays</a></li>
                <li><a  href="ban_g.php"><i class="fa fa-edit fa-3x"></i> Gestion des bans </a></li>
                <li><a  href="news.php"><i class="fa fa-square-o fa-3x"></i> Gérer les news</a></li>
            </ul>
        </div>
    </nav>

    <div id="page-wrapper" >
        <div id="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <h2>Administration</h2>
                    <h5>Bienvenue dans l'administration de Stoned-Radio <?= $_SESSION['pseudo'] ?>.</h5>
                </div>
            </div>
            <hr />
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="panel panel-back noti-box">
                            <span class="icon-box bg-color-red set-icon">
                                <i class="fa fa-envelope-o"></i>
                            </span>
                        <div class="text-box" >
                            <p class="main-text">254545242<br /><br /></p>
                            <p class="text-muted">dédicasses</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="panel panel-back noti-box">
                            <span class="icon-box bg-color-blue set-icon">
                                <i class="fa fa-bell-o"></i>
                            </span>
                        <div class="text-box" >
                            <p class="main-text">2564645<br /><br /></p>
                            <p class="text-muted">visites</p>
                        </div>
                    </div>

                </div>
            </div>

        <?= $content ?>
        </div>
    </div>

            <!-- Bootstrap core JavaScript
            ================================================== -->
            <!-- Placed at the end of the document so the pages load faster -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </body>
</html>
<?php
} else {
    header("Location: http://stoned-radio.fr/");
}
?>

