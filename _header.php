<?php
ini_set('default_charset', 'UTF-8');
include_once './baza.class.php';
include './pomak.php';
$baza=new baza();
session_start();
if (isset($_SESSION['tip'])){
    if ($_SESSION['tip']=='3' ){
        echo $naslov="Dobrodošao administrator";
    }else if ($_SESSION['tip']=='2' ){
        echo $naslov="Dobrodošao moderator";
    }else  if ($_SESSION['tip']=='1' ){
        echo $naslov="Dobrodošao registrirani";
    }
}
?>
<!DOCTYPE html>
<html>
    <title><?= $naslov ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/troskoviprijevoza.css">
<head>
<script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
<div id="header">
<?php if (isset($_SESSION['kime'])){ echo '<a href="odjava.php">odjava</a>';} ?>
<?php if (!isset($_SESSION['kime'])){ echo '<a href="registracija.php">Registracija</a><br>';} ?>
<?php if (!isset($_SESSION['kime'])){ echo '<a href="login.php">Prijava</a><br>';} ?>
    <p><?= $naslov ?></p>
</div>
<div id="nav">
    <a href="index.php">Početna stranica</a><br>
    <a href="o_autoru.html">o_autoru</a><br>
    <a href="dokumentacija.html">Dokumentacija</a><br>
    <?php if (isset($_SESSION['tip'])){ if ($_SESSION['tip']=='3' ){ echo '<a href="prijevozno_sredstvo.php">Prijevozno sredstvo</a><br>';}} ?>
    <?php if (isset($_SESSION['tip'])){ if ($_SESSION['tip']=='2' ){ echo '<a href="blokiranje.php">Blokiraj oglas</a><br>';}} ?>
    <?php if (isset($_SESSION['tip'])){ if ($_SESSION['tip']=='2' ){ echo '<a href="oglas.php">Oglasi</a><br>';}} ?>
    <?php if (isset($_SESSION['tip'])){ if ($_SESSION['tip']=='2' ){ echo '<a href="upitnik.php">Upitnik</a><br>';}} ?>
</div>
