<?php

switch ($page) {
    case 'accueil':
        echo '<link rel="stylesheet" href="/css/accueil.css" />';
        break;
    case 'generer':
    case 'second':
        echo '<link rel="stylesheet" href="/css/generer.css" />';
        break;
    case 'bibliotheque':
        echo '<link rel="stylesheet" href="/css/bibliotheque.css" />';
        break;
}