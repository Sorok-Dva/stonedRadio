<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 27/07/2015
 * @Time    : 12:25
 * @File    : profile.php
 * @Version : 1.0
 * @Todo    : � completer!
 */
App::getInstance()->subtitle = "Profile";
?>
<style>
    .well {
        margin-top:-20px;
        background-color:#007FBD;
        border:2px solid #0077B2;
        text-align:center;
        cursor:pointer;
        font-size: 25px;
        padding: 15px;
        border-radius: 0px !important;
    }

    .well:hover {
        margin-top:-20px;
        background-color:#0077B2;
        border:2px solid #0077B2;
        text-align:center;
        cursor:pointer;
        font-size: 25px;
        padding: 15px;
        border-radius: 0px !important;
        border-bottom : 2px solid rgba(97, 203, 255, 0.65);
    }

    .bg_blur {
        background-image:url('http://data2.whicdn.com/images/139218968/large.jpg');
        height: 300px;
        background-size: cover;
    }

    .follow_btn {
        text-decoration: none;
        position: absolute;
        left: 35%;
        top: 42.5%;
        width: 35%;
        height: 15%;
        background-color: #007FBE;
        padding: 10px;
        padding-top: 6px;
        color: #fff;
        text-align: center;
        font-size: 20px;
        border: 4px solid #007FBE;
    }

    .follow_btn:hover {
        text-decoration: none;
        position: absolute;
        left: 35%;
        top: 42.5%;
        width: 35%;
        height: 15%;
        background-color: #007FBE;
        padding: 10px;
        padding-top: 6px;
        color: #fff;
        text-align: center;
        font-size: 20px;
        border: 4px solid rgba(255, 255, 255, 0.8);
    }

    .header{
        color : #808080;
        margin-left:10%;
        margin-top:70px;
    }

    .picture{
        height:150px;
        width:150px;
        position:absolute;
        top: 75px;
        left:-75px;
    }

    .picture_mob{
        position: absolute;
        width: 35%;
        left: 35%;
        bottom: 70%;
    }

    .btn-style{
        color: #fff;
        background-color: #007FBE;
        border-color: #adadad;
        width: 33.3%;
    }

    .btn-style:hover {
        color: #333;
        background-color: #3D5DE0;
        border-color: #adadad;
        width: 33.3%;

    }


    @media (max-width: 767px) {
        .header{
            text-align : center;
        }



        .nav{
            margin-top : 30px;
        }
    }
</style>


<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

<?php if($own == true){ ?>
    <div class="container" style="margin-top: 20px; margin-bottom: 20px;">
        <div class="row panel">
            <div class="col-md-4 bg_blur ">
                <a href="#" class="follow_btn hidden-xs">Modifier</a>
            </div>
            <div class="col-md-8  col-xs-12">
                <img src="http://lorempixel.com/output/people-q-c-100-100-1.jpg" class="img-thumbnail picture hidden-xs" />
                <img src="http://lorempixel.com/output/people-q-c-100-100-1.jpg" class="img-thumbnail visible-xs picture_mob" />
                <div class="header">
                    <h1><?= $profile->pseudo ?></h1>
                    <h4><?= $profile->metier ?><button><span></span>Modifier</button></h4>
                    <span><?= $profile->presentation ?><button><span></span>Modifier</button></span>
                </div>
            </div>
        </div>

        <div class="row nav">
            <div class="col-md-4"></div>
            <div class="col-md-8 col-xs-12" style="margin: 0px;padding: 0px; color:white">
                <div class="col-md-4 col-xs-4 well"><i class="fa fa-weixin fa-lg"></i> 16</div>
                <div class="col-md-4 col-xs-4 well"><i class="fa fa-heart-o fa-lg"></i> 14</div>
                <div class="col-md-4 col-xs-4 well"><i class="fa fa-thumbs-o-up fa-lg"></i> 26</div>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="container" style="margin-top: 20px; margin-bottom: 20px;">
        <div class="row panel">
            <div class="col-md-4 bg_blur ">
                <a href="#" class="follow_btn hidden-xs">S'abonner</a>
            </div>
            <div class="col-md-8  col-xs-12">
                <img src="http://lorempixel.com/output/people-q-c-100-100-1.jpg" class="img-thumbnail picture hidden-xs" />
                <img src="http://lorempixel.com/output/people-q-c-100-100-1.jpg" class="img-thumbnail visible-xs picture_mob" />
                <div class="header">
                    <h1><?= $profile->pseudo ?></h1>
                    <h4><?= $profile->metier ?></h4>
                    <span><?= $profile->presentation ?></span>
                </div>
            </div>
        </div>

        <div class="row nav">
            <div class="col-md-4"></div>
            <div class="col-md-8 col-xs-12" style="margin: 0px;padding: 0px; color:white">
                <div class="col-md-4 col-xs-4 well"><i class="fa fa-weixin fa-lg"></i> 16</div>
                <div class="col-md-4 col-xs-4 well"><i class="fa fa-heart-o fa-lg"></i> 14</div>
                <div class="col-md-4 col-xs-4 well"><i class="fa fa-thumbs-o-up fa-lg"></i> 26</div>
            </div>
        </div>
    </div>
<?php } ?>

