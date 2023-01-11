<?php
require "../include/dependances.php";

use interleak\routeur\routeur;

$routeur = new routeur($_SERVER['REQUEST_URI']);

$routeur->listen('accueil', ['/', '', '/accueil'], 'GET|POST', function () {
    $routeur = $GLOBALS['routeur'];
    ob_start();
    require_once '../include/accueil.php';
    afficher('accueil', ob_get_clean());
});

$routeur->listen('generer', ['/generer'], 'GET|POST', function () {
    $routeur = $GLOBALS['routeur'];
    ob_start();
    require_once '../include/generer.php';
    afficher('generer', ob_get_clean());
});

$routeur->listen('bibliotheque', ['/biblio', 'bibliotheque'], 'GET|POST', function () {
    $routeur = $GLOBALS['routeur'];
    ob_start();
    require_once '../include/bibliotheque.php';
    afficher('bibliotheque', ob_get_clean());
});

$routeur->listen('second', ['/second', '/second-EAN'], 'GET|POST', function () {
    $routeur = $GLOBALS['routeur'];
    ob_start();
    require_once '../include/second.php';
    afficher('second', ob_get_clean());
});

$routeur->match();

function afficher (string $page, string $corps) {
    include '../config/corps.php';
}