<?php
$naslov = "Prijevozno sredstvo";
include_once './_header.php';
$poruka= "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
    $prijevozno=$_POST['prijevozno_sredstvo'];
    $broj=$_POST['broj'];
    if($prijevozno == "" || $broj == "" ){
        $poruka = "Popuni sve praznine";
    }
    if(empty($poruka)){
    $upit = "INSERT INTO prijevoznoSredstvo (ID_prijevoznoSredstvo,naziv,brojMjesta,datumIzmjene) VALUES (DEFAULT,'$prijevozno', '$broj', now());";
    $baza->updateDB($upit);
    }
}


$upit = "SELECT * FROM prijevoznoSredstvo ";
$rezultat = $baza->selectDB($upit);	
$upit2 = "SELECT * FROM korisnik where tipKorisnika='2'";
$rezultat2 = $baza->selectDB($upit2);	
$prijevozno_sredstvo=mysqli_fetch_array($rezultat);
$upit3 = "SELECT userName FROM korisnik where tipKorisnika='2'";
$rezultat3 = $baza->selectDB($upit3);	

?>

<div id="sadrzaj">
<p>Kreiraj prijevozno sredstvo: </p>
<form action="" method="post">
  <label for="prijevozno_sredstvo">Prijevozno sredstvo:</label>
  <input type="text" name="prijevozno_sredstvo" id="prijevozno_sredstvo"><br>
  <label for="prijevozno_sredstvo">Broj mjesta:</label>
  <input type="text" name="broj" id="broj"><br>
  <?php if ($poruka != "") echo $poruka . "<br><br>"?>
  <input type="submit" value="Dodaj">
</form>
<form action="" method="get">
    <button type="submit" name="sve">Prikaži sve</button><br>
    <button type="submit" name="dodaj">Dodaj moderatora</button>
</form>

<?php if(isset($_GET['sve']))
    { 
?>
<table>
  <thead>
    <tr>
      <th>Prijevozno sredstvo</th>
      <th>Broj mjesta</th>
      <th>Moderator</th>
    </tr>
  </thead>
  <tbody>
   
    <?php while($sve=mysqli_fetch_array($rezultat)):; ?>
    <tr>
    <td><?= $sve[1]?></td>      
    <td><?= $sve[2];?></td>
      <?php endwhile; ?>
    <?php while($sve2=mysqli_fetch_array($rezultat3)):; ?>
    <td><?= $sve2[0];?></td>
        <?php endwhile; ?>
    </tr>  
  </tbody>
</table>
<?php 
    } 
?>

<?php if(isset($_GET['dodaj']))
    { 
?>
<p>Dodaj moderatora: </p>
<form action="" method="post">
        <label for="prijevozno_sredstvo">Prijevozno sredstvo: </label>
        <select name="prijevozno_sredstvo">
            <?php while($prijevozno_sredstvo=mysqli_fetch_array($rezultat)):; ?>
                    <option value="<?php echo $prijevozno_sredstvo[0]; ?>"><?php echo $prijevozno_sredstvo[1]; ?></option>
            <?php endwhile; ?>
        </select>
        <br>
        <label for="moderatori">Moderator:</label>
        <select name="moderatori">
            <?php while($moderatori=mysqli_fetch_array($rezultat2)):; ?>
                    <option value="<?php echo $moderatori[0]; ?>"><?php echo $moderatori[3]; ?></option>
            <?php endwhile; ?>
        </select>
      <input type="submit" value="Dodaj" name="dodaj">
    </form>
<?php 
    } 
?>
<?php
if (isset($_POST['dodaj'])){
$prijevozno=$_POST['prijevozno_sredstvo'];
$moderatori=$_POST['moderatori'];
$moderatori_dodaj = "INSERT INTO moderiranje (prijevoznoSredstvo,moderator,vrijeme) VALUES ('$prijevozno','$moderatori', now());";
$baza->updateDB($moderatori_dodaj);
}
?>

</div>
<?php
include_once './_footer.php';
?>