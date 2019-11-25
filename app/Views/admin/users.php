<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 03/10/2015
 * @Time    : 14:04
 * @File    : users.php
 * @Version : 1.0
 */
?>

<div class="row">
    <div class="col-md-12">
        <!--   Kitchen Sink -->
        <div class="panel panel-default">
            <div class="panel-heading">
                Gérer les membres
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pseudo</th>
                            <th>E-mail</th>
                            <th>Adresse IP</th>
                            <th>Date d'inscription</th>
                            <th>Dernière connexion</th>
                            <th>Banni</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach($users as $user): ?>
                            <tr>
                                <td><?= $user->id; ?></td>
                                <td><strong><?= $user->pseudo; ?></strong></td>
                                <td width="10%"><strong><?php echo stripslashes($user->mail); ?></strong></td>
                                <td><strong><?= $user->register_ip; ?></strong></td>
                                <td><?= date('d/m/Y à H:i:s', $user->date_inscription); ?></td>
                                <td><?= date('d/m/Y à H:i:s', $user->last_login); ?></td>
                                <td>X</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>