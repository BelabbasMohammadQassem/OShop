<?php

// on démarre la session
session_start();

// pour éviter les erreurs si la variable de session n'existe pas, n'est pas définie, on utilise ... isset() !
if(isset($_SESSION['utilisateurConnecte'])) {
    print "l'utilisateur connecté est : " . $_SESSION['utilisateurConnecte'];
} else {
    print "l'utilisateur n'est pas connecté.";
}

