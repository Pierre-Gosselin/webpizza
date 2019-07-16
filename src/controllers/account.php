<?php

/**
 * Fichier qui fère la page du profil client
 * 
 */

 /**
  * index
 */

 function account_index(){
     if (!isset($_SESSION['user']) || empty($_SESSION['user']))
     {
        redirect(url('login'));
     }
 }