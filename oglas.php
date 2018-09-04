<?php
$naslov = "Oglas";
include_once './_header.php';
$poruka="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naziv=$_POST['naziv'];
    $opis=$_POST['opis']; 
    $slika=$_POST['slika'];
    $url=$_POST['url']; 
    $vrsta=$_POST['vrsta'];
    
    $upit = "INSERT INTO oglas (ID_oglas,naziv,opis,url,datumAktivacije,vrstaOglasa) VALUES (DEFAULT,'$naziv', '$opis', '$url', now(),'$vrsta');";
    $baza->updateDB($upit);
    

}
?>
<div id="sadrzaj">
<form method="POST" name="oglas" id="kreiraj_oglas" action="">
    <label for="naziv"> Naziv oglasa: </label>
    <input type="text" id="naziv" name="naziv" ><br><br>

    <label for="opis">Opis oglasa: </label>
    <textarea type="text" id="opis" name="opis" rows="20" cols="50" maxlength="500" placeholder="Opis oglasa" ></textarea><br><br>

    <label for="slika">Slika oglasa: </label>
    <input type="file" id="slika" name="slika"><br><br>

    <label for="url">URL oglasa: </label>
    <input type="text" id="url_" name="url" <br><br>

    <label for="vrsta"> Vrsta oglasa: </label>
    <input type="text" id="vrsta" name="vrsta"><br><br>

    <input type="submit" name="zahtjevOglas" id="zahtjevOglas"  value="Pošalji zahtjev" >
 </form>
 </div>
<?php
include_once './_footer.php';
?>