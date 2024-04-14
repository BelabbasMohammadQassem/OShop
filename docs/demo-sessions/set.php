<?php

// si on veut utiliser les sessions PHP, on doit les démarrer !
session_start();

// si on veut stocker le nom de l'utilisateur connecté en session :
$_SESSION['utilisateurConnecte'] = "bob";

print "l'utilisateur connecté est : " . $_SESSION['utilisateurConnecte'];