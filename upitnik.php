<?php
$naslov = "Oglas";
include_once './_header.php';
$poruka="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prijevozno_sredstvo=$_POST['prijevozno_sredstvo'];
    $polaziste=$_POST['polaziste'];
    $odrediste=$_POST['odrediste'];
    $od=$_POST['od'];
    $do=$_POST['do'];

    $upitOdgovor = "INSERT INTO upitnik (ID_upitnik,polaziste,odrediste,od,do,javno,prijevoznoSredstvo) VALUES (DEFAULT, '$polaziste','$odrediste','$od','$do','0','$prijevozno_sredstvo');";
    $baza->updateDB($upitOdgovor);

}
$upit = "SELECT * FROM prijevoznoSredstvo";
$rezultat = $baza->selectDB($upit);
$upitnik = "SELECT * FROM upitnik";
$rezultat_upitnika = $baza->selectDB($upitnik);
$odgovor = "SELECT * FROM odgovor where";
$rezultat_odgovora = $baza->selectDB($odgovor);
?>
<div id="sadrzaj">
    <p>Definiraj upitnik:</p><br>
    <form action="" method="POST">
        <label for="polaziste">Polazište: </label>
        <input type="text" name="polaziste" id="polaziste">
        <br>
        <label for="odrediste">Odredište: </label>
        <input type="text" name="odrediste" id="odrediste">
        <br>
        <label for="od">Od: </label>
        <input type="datetime-local" name="od" id="od">
        <br>
        <label for="do">Do: </label>
        <input type="datetime-local" name="do" id="do">
        <br>
        <label for="prijevozno_sredstvo">Prijevozno_sredstvo: </label>
        <select name="prijevozno_sredstvo">
            <?php while($naziv=mysqli_fetch_array($rezultat)):; ?>
                    <option value="<?= $naziv[0]?>"><?php echo $naziv[1]; ?></option>
            <?php endwhile; ?>
        </select>
        <br>
        <input type="submit" value="Dodaj">
    </form>
    <br><br>
    <table>
            <thead>
                <th>Polazište</th>
                <th>Odredište</th>
                <th>Trošak</th>
              
            </thead>
            <tbody>
                <?php while($prikaz=mysqli_fetch_array($rezultat_upitnika)):; 
                
                ?>
                <tr>
                    <td><?php echo $prikaz[1]; ?></td> 
                    <td><?php echo $prikaz[2]; ?></td>
                    <?php endwhile; ?>
                </tr>
                
                
            </tbody>
        </table>
 </div>
<?php
include_once './_footer.php';
?>