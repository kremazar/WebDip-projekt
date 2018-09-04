<?php
$naslov = "Blokiranje oglasa";
include_once './_header.php';
$poruka="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $zahtjev=$_POST['zahtjev_blokiraj'];
    $obrazlozenje=$_POST['obrazlozenje'];
    $korisnik=$_SESSION['kime'];
    $oglas=$_POST['blok_oglas'];
    
    $ID = "SELECT ID_korisnik FROM korisnik where userName='$korisnik'";
    $ID_korisnik = $baza->selectDB($ID);
    $dohvati_ID_korisnik=mysqli_fetch_array($ID_korisnik);
    $upit = "INSERT INTO zahtjevBlokiranja (blokirano,obrazlozenje,oglas,korisnik) VALUES ('0', '$obrazlozenje', '$oglas','$dohvati_ID_korisnik[0]')";
    $baza->updateDB($upit);
}
$ID = "SELECT * FROM oglas";
$ID_oglas = $baza->selectDB($ID);

?>
<div id="sadrzaj">
<form method="POST" name="oglas"  action="">
    <label for="blok_oglas">Oglas: </label>
    <select name="blok_oglas">
            <?php while($dohvati_naziv=mysqli_fetch_array($ID_oglas)):; ?>
            <option value="<?= $dohvati_naziv[0]?>"><?=  $dohvati_naziv[1]; ?></option>
            <?php endwhile; ?>
        </select>
    <br><br>
    <label for="obrazlozenje">Razlog Blokiranja: </label>
    <textarea type="text" id="obrazlozenje" name="obrazlozenje" rows="20" cols="50" maxlength="500" placeholder="Razlog blokiranja" ></textarea><br><br>

    <input type="submit" name="zahtjev_blokiraj" id="zahtjev_blokiraj"  value="Pošalji zahtjev" >
 </form>
 </div>
<?php
include_once './_footer.php';
?>