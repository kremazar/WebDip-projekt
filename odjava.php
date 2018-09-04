<?php
include_once './_header.php';

$kime=$_COOKIE['kime'];

$ID = "SELECT ID_korisnik FROM korisnik WHERE userName='$kime'";
$rezultat = $baza->selectDB($ID);
$dnevnik = mysqli_fetch_array($rezultat);

$dnevnjak = "INSERT INTO log (ID_log,akcija,vrijeme,ID_korisnik)  VALUES (DEFAULT, 'Odjava', now(), '$dnevnik[0]')";
$baza->updateDB($dnevnjak);
session_destroy();
header('Location:index.php');
?>