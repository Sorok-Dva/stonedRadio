<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 04/10/2015
 * @Time    : 14:12
 * @File    : hits.php
 * @Version : 1.0
 */ ?>

<div id="right_hits_title">
    Top 15 hits
</div>
<div id="right_hits">
    <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        Les flèches servent à déterminer le dernier vote du hit.
    </div>
    <table class="table table-striped table-bordered table-hover">
        <?php
        $i=1;
        foreach($hits as $hit):
            ?>
            <tr>
                <td align="center" style="padding-top:37px;">
                    <?= $i; ?>
                </td>
                <td width="10%">
                    <img src="<?= $hit->cover ?>" width="80" height="80" />
                </td>
                <td valign="top" style="padding-left:10px;padding-top:20px;">
                    <font color="#444444"><strong><?= $hit->artiste ?></strong></font>
                    <br />
                    <div style="height:3px;"> </div>
                    <?= $hit->titre ?>
                </td>
                <td align="center">
                    <?php
                    if($hit->lastVote=="POUR")
                    {
                        ?>
                        <img src="http://image.noelshack.com/fichiers/2015/38/1442423246-flechebleu.png" />
                        <?php
                    }
                    else
                    {
                        ?>
                        <img src="http://image.noelshack.com/fichiers/2015/38/1442423248-flecherouge.png" />
                        <?php
                    }
                    ?>
                </td>
            </tr>
            <?php
            $i++;
        endforeach;
        ?>
    </table>
</div>
