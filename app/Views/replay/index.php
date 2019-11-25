<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 03/10/2015
 * @Time    : 12:22
 * @File    : index.php
 * @Version : 1.0
 */
App::getInstance()->subtitle = "Replay";
?>

<div id="right_replay_title">Replay des émissions</div>
<div id="right_replay">
    <?php
    foreach($resultat as $replay) // On lit les entrées une à une grâce à une boucle
    {
        ?>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <center><h1 class="panel-title">Émission du <?= htmlentities($replay->titre); ?></h1></center>
            </div>
            <div class="panel-body">
                <center><iframe width="700" height="420" src="https://www.youtube.com/embed/<?= $replay->id_yt; ?>" frameborder="0" allowfullscreen></iframe></center>
            </div>
        </div>
        <?php
    }
    ?>
    <div class="col-md-2"><div style="text-align:right;"><h2>Page :</h2></div></div>

    <div class="col-md-10">
        <div style="margin-top:1.5px;">
            <nav>
                <ul class="pagination">
                    <?php
                    for($i=1; $i<=$nombreDePages; $i++)
                    {
                        if($i==$pageActuelle)
                        {
                            echo ' <li class="active">';
                        }
                        else
                        {
                            echo '<li>';
                        }
                        echo '<a href="?page=replay.index&p='.$i.'">'.$i.'</a></li> ';
                    }
                    echo '</p>';
                    ?>
                </ul>
            </nav>
        </div>
    </div>
</div>