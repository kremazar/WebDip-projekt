<?php
$naslov = "Aktivacija";
include_once './_header.php';
if (isset($_GET['hash'])) {
    $hash = ($_GET['hash']);
    $email = ($_GET['email']);
    $upit = "SELECT hash FROM korisnik WHERE email='{$email}'";
    $rezultat = $baza->selectDB($upit);
    if ($rezultat->num_rows == 0) {
        echo 'Aktivacijski kod nije važeći';
        echo '<a href="registracija.php">Povratak</a>';
        exit();
    }else{
        echo '<div id="sadrzaj"><a href="login.php">Prijava</a></div>';
    }
    $upit = "UPDATE korisnik SET aktivan = 1 WHERE hash = '{$hash}'";
    $rezultat = $baza->updateDB($upit);
    echo '<div id="sadrzaj"><p>Uspjesna aktivacija</p></div>';
}
include_once './_footer.php';