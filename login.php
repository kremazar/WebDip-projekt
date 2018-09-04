<?php
$naslov = "Prijava";
include_once './_header.php';

$poruka="";
$vrijeme_obj = new virtualnoVrijeme();
$pomak = $vrijeme_obj->vratiVrijeme();
$novo_vrijeme = date("Y-m-d H:i:s", strtotime("+$pomak hours"));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kime=$_POST['kime'];
    $lozinka=$_POST['lozinka']; 

    if (isset($_POST['zapamti'])) {
        setcookie("kime", $kime, time() + 60 * 60);
    } else {
        setcookie("kime", $kime, time() - 60);
    }
    $ID = "SELECT ID_korisnik FROM korisnik WHERE userName='$kime'";
    $rezultat = $baza->selectDB($ID);
    $dnevnik = mysqli_fetch_array($rezultat);
   
    $dnevnjak = "INSERT INTO log (ID_log,akcija,vrijeme,ID_korisnik)  VALUES (DEFAULT, 'Prijava', now(), '$dnevnik[0]')";
    $baza->updateDB($dnevnjak);
       
        
  
    $upit = "SELECT * FROM korisnik WHERE userName='$kime'";
    $rezultat = $baza->selectDB($upit);
    $korisnik = mysqli_fetch_array($rezultat);
    
    if ($rezultat->num_rows == 0) {
        $poruka="nije dobro korisničko ime";
    }else 
    {
        if ($korisnik['aktivan'] == 2) {
            $poruka="korisničko ime je blokirano";
        } else if ($korisnik['aktivan'] == 0) {
            $poruka="korisničko ime nije aktivirano";
        } else {
           
            if ($korisnik['lozinka'] != $lozinka) {
                $poruka="nije dobra lozinka";
                $brojPrijava = $korisnik['broj_prijava'];
                $brojPrijava++;
                
                if ($brojPrijava == 3) {
                    $upit = "UPDATE korisnik SET aktivan=2 WHERE userName='$kime'";
                    $baza->updateDB($upit);
                }
               
                else {
                    $upit = "UPDATE korisnik SET broj_prijava=broj_prijava+1 WHERE userName='$kime'";
                    $baza->updateDB($upit);
                }
            }
          
            else {
                
                $upit = "UPDATE korisnik SET broj_prijava=0 WHERE userName='$kime'";
                $baza->updateDB($upit);
                session_start();
                $_SESSION['tip'] = $korisnik['tipKorisnika'];
                $_SESSION['kime'] = $korisnik['userName'];
                header('Location:index.php');
                exit();
            }
        }
    }
}
$cookie_kime = "";
if (isset($_COOKIE['kime'])) {
    $cookie_kime = $_COOKIE['kime'];
}
$skripta = basename($_SERVER['PHP_SELF']);
?>
<div id="sadrzaj">
<form action="<?php echo $skripta ?>" method="post">
  <label for="kime">Korisničko ime: :</label>
  <input type="text" name="kime" id="kime">
  <br>
  <label for="lozinka">Lozinka:</label>
  <input type="text" name="lozinka" id="lozinka" >
  <br><br>
  <label  for="zapamti">Zapamti me:</label>
  <input type="checkbox" name="zapamti" id="zapamti" >da
  <br><br>
  <?php if ($poruka != "") echo $poruka . "<br><br>"?>
  <input type="submit" value="Prijava">
  <br><br>
  <?php echo '<a href="promjenaLozinke.php">Promjena Lozinke</a>'?>
  <p>perica 123456789-registrirani</p>
  <p>kobe24 123456789-moderator</p>
  <p>kremazar 123456789-admin</p>
</form> 
</div>
<?php
include_once './_footer.php';
?>