<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 03/10/2015
 * @Time    : 18:13
 * @File    : list.php
 * @Version : 1.0
 */
?>
<div id="right_liste_title">Membres de Stoned-Radio</div>
<div id="right_liste">

    <div class="form-group">
        <label class="control-label col-sm-3" for="requete">Rechercher un membre :</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" id="requete" name="requete">
        </div>
        <div class="col-sm-2">
            <input type="submit" name="ok" value="Rechercher" onclick="search()" class="btn btn-primary" />
        </div>
    </div>

    <table width="95%" class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>Pseudo</th>
            <th>Grade</th>
            <th>Inscrit depuis le</th>
            <th>Dernière connexion</th>
        </tr>
        </thead>
        <tbody>
            <?php
            foreach($resultat as $user) {
                ?>
                <tr>
                    <td><span class="user"><?= $user->pseudo ?></span></td>
                    <td><?= $user->grade ?></td>
                    <td><?=  date('d\/m\/Y', $user->date_inscription ) ?></td>
                    <td><?=  date('d\/m\/Y', $user->last_login ) ?></td>
                </tr>
                <?php
            }
            ?>
            <nav>
                <ul class="pagination">
                    <?php
                    for($i=1; $i<=$nombreDePages; $i++){
                        if($i==$pageActuelle){
                            echo ' <li class="active">';
                        }
                        else{
                            echo '<li>';
                        }
                        echo '<a href="?page=users.liste&p='.$i.'">'.$i.'</a></li> ';
                    }
                    echo '</p>';
                    ?>
                </ul>
            </nav>
        </tbody>
    </table>
</div>
