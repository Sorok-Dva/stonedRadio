<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 17/07/2015
 * @Time    : 12:09
 * @File    : index.php
 * @Version : 1.0
 * @Todo    : À completer!
 */

App::getInstance()->menuActive = "1";
?>

<h1 class="page-header">Administration des articles/news</h1>

<p>
    <a href="?page=admin.news.add" class="btn btn-success">Ajouter un article/une news</a>
</p>
<table class="table">
    <thead>
        <tr>
            <td>ID</td>
            <td>Titre</td>
            <td>Auteur</td>
            <td>Actions</td>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($news as $post): ?>
         <tr>
            <td><?= $post->id ?></td>
            <td><?= $post->titre ?></td>
            <td><?= $post->auteur ?></td>
            <td>

                <a href="?page=admin.news.edit&id=<?= $post->id ?>" class="btn btn-primary">Editer</a>
                <form action="?page=admin.news.delete" method="post" style="display:inline">
                    <input type="hidden" name="id" value="<?= $post->id ?>" />
                    <button href="?page=admin.news.delete&id=<?= $post->id ?>" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button>
                </form>
            </td>
         </tr>
        <?php   endforeach; ?>
    </tbody>
</table>