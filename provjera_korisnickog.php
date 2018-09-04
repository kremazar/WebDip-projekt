<?php
require_once './_header.php';


if(!empty($_POST["kime"])){
    $kime = $_POST['kime'];
    $upit = "SELECT * FROM korisnik WHERE userName='$kime'";
    $rezultat = $baza->selectDB($upit);
    if($rezultat->num_rows > 0){
        echo "<span id='provjera'>Korisničko ime nije slobodno.</span>";
    }else{
        echo "<span id='provjera'>Korisničko ime je slobodno.</span>";
    }
  
}
