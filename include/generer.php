<?php
require "../config/secure.php";
require "../config/lambda.php";

use Picqer\Barcode\BarcodeGeneratorPNG;

$pdo = new PDO('mysql:host=127.0.0.1;dbname=InterLeak;', $bdd['utilisateur'], $bdd['mdp']);

do {
    $donnee = rand(00, 99);
    $jour = date('d') - rand(1, date('d') - 1);
    if (strlen($jour) == 1) {
        $jour = "0" . $jour;
    }
    $rq = $pdo->query("SELECT * FROM `utilise` WHERE `donnee` = $donnee AND `jour` = $jour;");
    $reponse = $rq->fetch();
} while ($reponse);

$code = '202301' . $jour . '13' . $donnee . '018500304629';
$date = date('U');
$rq = $pdo->prepare('INSERT INTO `utilise` (`ID`, `donnee`, `jour`, `code`, `date`, `IP`, `UA`) VALUES (null, :donnee, :jour, :code, :date, :IP, :UA);');
$rq->execute([
    ':donnee' => $donnee,
    ':code' => $code,
    ':date' => $date,
    ':IP' => $_SERVER['REMOTE_ADDR'],
    ':UA' => $_SERVER['HTTP_USER_AGENT'],
    ':jour' => $jour
]);

$generateur = new BarcodeGeneratorPNG();
?>

<div id="genere" class="fenetre-centre">
    <p id="premiere">Premiere étape !</p>
    <p id="remerciement">
        <?= $phrases[rand(0, count($phrases) - 1)] ?>
    </p>
    <img id="CB" src="data:image/png;base64,<?= base64_encode($generateur->getBarcode($code, $generateur::TYPE_CODE_128, foregroundColor: [226, 0, 26], height: 200)) ?>" alt="Premier code barre" />
    <a href="/bibliotheque" title="Aller au second code barre" class="lien-style">Étape 2 ! Let's GO !</a>
</div>