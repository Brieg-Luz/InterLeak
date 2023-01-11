<?php
use Picqer\Barcode\BarcodeGeneratorPNG;
include '../config/lambda.php';

if (isset($_GET['marque']) && isset($EAN[$_GET['marque']])) {
    $generateur = new BarcodeGeneratorPNG();
    ?>
    <div id="genere" class="fenetre-centre">
        <p id="premiere">Et le code barre<br />toujours gagnant !</p>
        <p id="remerciement">
            <?= $phrases[rand(0, count($phrases) - 1)] ?>
        </p>
        <img id="CB" src="data:image/png;base64,<?= base64_encode($generateur->getBarcode($EAN[$_GET['marque']], $generateur::TYPE_CODE_128, foregroundColor: [226, 0, 26], height: 200)) ?>" alt="Code Barra de l'article" />
        <a href="/bibliotheque" title="Choisir un autre article" class="lien-style">Choisir un autre code barre</a>
        <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" title="Choisir un autre article" class="lien-style">J'ai fini ❤️!</a>
    </div>
<?php
} else {
    echo <<<HTML
    <div class="fenetre-centre">
        <h1 class="titre-style">Article introuvable...</h1>
        <p>Veuillez en choisir un autre.</p>
        <a href="/bibliotheque" title="Retourner à la bibliothèque des EAN" class="lien-style">Choisir un autre article</a>
    </div>
    HTML;
}