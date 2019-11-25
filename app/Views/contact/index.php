<?php
/**
 * @Author  : Created by Anthony POMMERET.
 * @Nick    : Antho06
 * @Date    : 12/09/2015
 * @Time    : 10:50
 * @File    : index.php
 * @Version : 1.0
 */

App::getInstance()->subtitle = "Nous contacter";
?>
<div id="right_contact_title">Contacte nous</div>
<div id="right_contact"> 
	<div class="alert alert-warning alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  Le formulaire de contact sert à faire part de vos <b>suggestions</b>, de vos <b>encouragements</b>, d'une demande de <b>partenariat</b> ou bien encore pour un <b>bug</b> rencontré sur le site. Il est donc utile de le préciser dans le sujet.
	</div>
<form class="form-horizontal" method="post">
	  <div class="form-group">
		<label class="control-label col-sm-3" for="email">Votre e-mail :</label>
		<div class="col-sm-8"> 
		  <input type="text" name="email" class="form-control" id="email" required>
		</div>
	  </div>
	  <div class="form-group">
		<label class="control-label col-sm-3" for="sujet">Sujet :</label>
		<div class="col-sm-8"> 
		  <input type="text" name="sujet" class="form-control" id="sujet" required>
		</div>
	  </div>
	  <div class="form-group">
		<label class="control-label col-sm-3" for="message">Message :</label>
		<div class="col-sm-8">
		  <textarea style="resize:none;" cols="50" rows="10" class="form-control" name="message" id="message"></textarea>
		</div>
	  </div>
	  <div class="form-group"> 
		<div class="col-sm-offset-5 col-sm-7">
		  <input type="submit" name="ok" value="Envoyer" class="btn btn-primary" />
		</div>
	  </div>
	
	</form>
</div>