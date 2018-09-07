<?php
$naslov = "Početna stranica";
include_once './_header.php';
$upit = "SELECT * FROM prijevoznoSredstvo";
$rezultat = $baza->selectDB($upit);

if(isset($_GET['prijevoz']))
    $_POST['prijevoz'] = $_GET['prijevoz'];
if(isset($_POST['prijevoz']))
{
    $odabir=$_POST['prijevoz'];

    $upit2 = "SELECT * FROM upitnik where prijevoznoSredstvo='$odabir'";
    if(isset($_POST['filterOdrediste']))
        $upit2=$upit2." AND odrediste LIKE '".$_POST["filterOdrediste"]."'";
    if(isset($_POST['filterPolaziste']))
        $upit2=$upit2." AND polaziste LIKE '".$_POST["filterPolaziste"]."'";
    $rezultat2 = $baza->selectDB($upit2);
}

if(isset($_POST['trosak']))
{
    $upitOdgovor = "INSERT INTO odgovor VALUES (DEFAULT, NOW(), ".$_POST['trosak'].", ".$_POST['prijevoz'].");";
    $baza->updateDB($upitOdgovor);
}
?>
<div id="sadrzaj">
<?php
 $oglas = "SELECT * FROM oglas";
 $tablica_oglasi = $baza->selectDB($oglas);
 $redovi = mysqli_fetch_array($tablica_oglasi);
    if (isset($_GET['klikovi'])){
        $brojac = "UPDATE oglas SET brojKlikova=brojKlikova+1 WHERE ID_oglas='1'";
        $baza->updateDB($brojac);
    }
?>
    <p>Odaberite prijevozno sredstvo: </p>

    <form action="" method="POST">
        <select name="prijevoz">
            <?php while($naziv=mysqli_fetch_array($rezultat)):; ?>
                    <option value="<?= $naziv[0]?>"><?php echo $naziv[1]; ?></option>
            <?php endwhile; ?>
        </select>
      <input type="submit" value="Prikaži">
    </form>
    <?php
    if(isset($_POST['prijevoz']))
    {
        $polazista = array();
        $odredista = array();
    ?>
        <table>
            <thead>
                <th>Polazište</th>
                <th>Odredište</th>
                <th>Odabir</th>
            </thead>
            <tbody>
                <?php while($upitnik=mysqli_fetch_array($rezultat2)):; 
                    if(!in_array($upitnik[1], $polazista))
                        $polazista[$upitnik[0]] = $upitnik[1];
                    if(!in_array($upitnik[2], $polazista))
                        $odredista[$upitnik[0]] = $upitnik[2];
                ?>
                <tr>
                    <td><?php echo $upitnik[1]; ?></td> 
                    <td><?php echo $upitnik[2]; ?></td>
                    <td><a href="?id=<?= $upitnik[0]?>&prijevoz=<?= $odabir?>">Odaberi!</a></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <h3>Filtriranje</h3>
        <form method="POST">
            <label for="filterPolaziste">Odaberite polazište: </label>
            <select name="filterPolaziste">
                <?php 
                    foreach ($polazista as $polaziste) {
                        echo "<option>$polaziste</option>";
                    }
                ?>
            </select>
            <input type="hidden" name="prijevoz" value="<?= $_POST['prijevoz']?>">
            <button type="submit">Filtriraj!</button>
        </form>
        <form method="POST">
            <label for="filterOdrediste">Odaberite odredište: </label>
            <select name="filterOdrediste">
                <?php
                    foreach ($odredista as $odrediste) {
                        echo "<option>$odrediste</option>";
                    }
                ?>
            </select>
            <input type="hidden" name="prijevoz" value="<?= $_POST['prijevoz']?>">
            <button type="submit">Filtriraj!</button>
        </form>
    <?php
    }
    if(isset($_GET['id']))
    {
    ?>
        <br/>
        <form action="" method="POST">
            <label for="trosak">Unesite trošak puta: </label>
            <input type="number" name="trosak">
            <input type="hidden" name="prijevoz" value="<?= $odabir?>">
            <button type="submit">Pošalji!</button>
        </form>   
    <?php
    }
    ?>
    <?php
    $polazista2 = "SELECT * FROM upitnik";
    $odaberi_polazista = $baza->selectDB($polazista2);
    ?>
    <h3>Prosječni troškovi: </h3>
    <form action="" method="POST">
        <select name="trosak">
            <?php while($redovi=mysqli_fetch_array($odaberi_polazista)):; ?>
                    <option value="<?= $redovi[0]?>"><?php echo $redovi[1]; ?></option>
            <?php endwhile; ?>
        </select>
      <input type="submit" value="Prikaži">
    </form>
    <?php
     $troskovi = "SELECT avg(trosak) FROM odgovor join upitnik on upitnik.ID_upitnik=odgovor.upitnik where upitnik.javno='1'";
     $odaberi_troskove = $baza->selectDB($troskovi);
     $polje_troskova=mysqli_fetch_array($odaberi_troskove);
    if(isset($_GET['trosak']))
    {
    ?> 
        <form action="" method="POST">
        <input type="hidden" name="prijevoz" value="<?= $polje_troskova[0]?>"> 
        </form>
    <?php
    }
    ?> 
    <div class="oglas"><a href='index.php?klikovi=true'>klikni ovdje</a></div>
    <div class="oglas"><a href='index.php?klikovi=true'>zašto ne radiš</a></div>  
    <div class="oglas"><a href='index.php?klikovi=true'>klikni ovdje</a></div>    
    </div>
    <?php
include_once './_footer.php';
?>
    