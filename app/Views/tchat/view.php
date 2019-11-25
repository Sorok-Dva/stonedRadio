<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 12/08/2015
 * @Time    : 16:58
 * @File    : view.php
 * @Version : 1.0
 */
App::getInstance()->subtitle = "Tchat";

?>
<script type="text/javascript" src="/public/js/system.ajax.js"></script>
<script type="text/javascript" src="/public/js/utilitaire.js"></script>
<script>
    var paramScroll = 1800;
</script>
<div id="right_connexion_title">Le chat de Stoned-Radio</div>

    <div id="right_connexion">

        <div id="containerChat" style="color:black">
            <!-- Statut //////////////////////////////////////////////////////// -->
            <table class="status">
                <tr>
                    <td>
                        <span id="statusResponse"></span>
                        <select name="status" id="status" style="width:200px;" onchange="setStatus(this)">
                            <option value="0" selected>En ligne</option>
                            <option value="1">Absent</option>
                            <option value="2">Occupé</option>
                        </select>
                    </td>
                </tr>
            </table>

            <table class="chat">
                <tr>
                    <!-- zone des messages -->
                    <td valign="top" id="text-td">
                        <div id="text">
                            Règles du tchat<br>
                            - Pas de flood<br>
                            - Pas d'insultes, d'incitation à la violence, d'apologie de crime de guerre.<br>
                            - Tapez /help pour plus d'information
                            <hr>
                            <div id="chat">

                            </div>
                        </div>
                    </td>

                    <!-- colonne avec les membres connectés au chat -->
                    <td valign="top" class="users-td">
                        <div id="colonneDroite">Chargement...</div>
                    </td>
                </tr>
            </table>

            <!-- Zone de texte //////////////////////////////////////////////////////// -->
            <a name="post"></a>
            <table class="post_message">
                <tr>
                    <td>
                        <div id="postChat">
                            <form action='' autocomplete="off">
                                Dire <input autocomplete="off" type="text" name="contenu" style="width:70%; color:black" id="message"/> &nbsp; <input type="submit" class="btn btn-primary" value="Envoyer" onclick='sendChat(); return false;'/>
                            </form>
                        </div>
                        <div id="responsePost" style="display:none"></div>
                    </td>
                </tr>
            </table>
        </div>
    </div>