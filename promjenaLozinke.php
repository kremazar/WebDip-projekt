<?php
$naslov = "Promjena lozinke";
include_once './_header.php';
$poruka="";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $novaLozinka = $_POST['novaLozinka'];
    $kime = $_POST['kime'];

    $baza = new Baza();
    $upit = "SELECT * FROM korisnik WHERE email='$email'";
    $rezultat = $baza->selectDB($upit);
    if ($rezultat->num_rows == 0) {
        echo 'email ne postoji';
        echo '<a href="login.php">Login</a>';
    } else {
        $upit = "UPDATE korisnik SET lozinka ='$novaLozinka' WHERE email='$email' AND userName='$kime'";
        $baza->updateDB($upit);
        mail($email, 'Promjena Lozinke', 'Nova lozinka: ' . $novaLozinka);
        echo 'nova lozinka je poslana';
        echo '<a href="login.php">Login</a>';
    }
    exit();
}
$skripta = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<h2>Promjena Lozinke</h2>
<form action="<?php echo $skripta ?>" method="post">
Korisničko ime:
  <input type="text" name="kime" >
  <br>
  E-mail:
  <input type="text" name="email" >
  <br>
  Nova Lozinka:
  <input type="text" name="novaLozinka" >
   <br><br>
  <?php if ($poruka != "") echo $poruka . "<br><br>"?>
  <input type="submit" value="Pošalji">
</form> 
<?php
include_once './_footer.php';
?>