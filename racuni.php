<?php
$naslov = "Korisnički računi";
include_once './_header.php';
$poruka="";
$upit = "SELECT userName FROM korisnik where aktivan='1'";
$rezultat = $baza->selectDB($upit);
$upit2 = "SELECT userName FROM korisnik where aktivan='2'";
$rezultat2 = $baza->selectDB($upit2);
if (isset($_POST['blokiraj'])){
    $racun=$_POST['racun'];
    $blokiraj = "UPDATE korisnik SET aktivan='2' WHERE userName='$racun'";
    $baza->updateDB($blokiraj);
}
if (isset($_POST['odblokiraj'])){
    $racun=$_POST['racun2'];
    $odblokiraj = "UPDATE korisnik SET aktivan='1' WHERE userName='$racun'";
    $baza->updateDB($odblokiraj);
}
?>
<div id="sadrzaj">
    <p>Korisnički računi:</p><br>
    <form action="" method="POST">
        <select name="racun">
            <?php while($racun=mysqli_fetch_array($rezultat)):; ?>
                    <option value="<?= $racun[0]?>"><?php echo $racun[0]; ?></option>
            <?php endwhile; ?>
        </select>
      <input type="submit" value="Blokiraj" name="blokiraj">
    </form>
    <p>Blokirani računi:</p><br>
    <form action="" method="POST">
        <select name="racun2">
            <?php while($racun2=mysqli_fetch_array($rezultat2)):; ?>
                    <option value="<?= $racun2[0]?>"><?php echo $racun2[0]; ?></option>
            <?php endwhile; ?>
        </select>
      <input type="submit" value="Odblokiraj" name="odblokiraj">
    </form>
 </div>
<?php
include_once './_footer.php';
?>