<?php
$naslov = "Registracija";
include_once './_header.php';
$poruka= "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
{
	
	$ime=$_POST['ime'];
	$prezime=$_POST['prezime'];
	$kime=$_POST['kime'];
	$email=$_POST['email'];
    $lozinka=$_POST['lozinka'];
    $salt="ihfjifhdjihdfij1256565";
    $hashlozinka=$_POST['lozinka'].$salt;
    $hashlozinka=sha1($hashlozinka);
    $ponlozinku=$_POST['ponlozinku'];
    
    $password1 = $_POST['lozinka'];
    $password2 = $_POST['ponlozinku'];
    
    $siteKey="6LenRmgUAAAAAHbNWv-Bc1bzSiAR96d-B9Zya2s8";
    $secret= "6LenRmgUAAAAAOi-BzEoK8LvEooy7A-QMCrCcvnR";
    $responseKey= $_POST['g-recaptcha-response'];
    $userIP=$_SERVER['REMOTE_ADDR'];
    $url="https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$responseKey&remoteip=$userIP";
    $response= file_get_contents($url);
    $response=json_decode($response);
    if ($response->success){
        $poruka= "";
    }else{
        $poruka = "reCAPTCHA nije dobra";
    }

    if (!preg_match("/^[a-zA-Z0-9]+\.*[a-zA-Z0-9]*@[[a-zA-Z0-9]*\.[[a-zA-Z0-9]{2,}$/",$email)) {
        $poruka= "Neispravan email format"; 
    }
    if ($password1 != $password2){
	    $poruka= "Nije ista lozinka";
    }
    if($ime == "" || $prezime == "" || $kime == "" || $email == "" || $lozinka == "" || $ponlozinku == ""  ){
		$poruka = "Popuni sve praznine";
    }
    if ((strlen($_POST["lozinka"]) < 8 ) ) {
        $poruka = "Lozinka mora imati barem 8 znakova";
    }
    if((strlen($_POST["kime"]) < 6 )){
        $poruka="korisničko ime mora imati barem 6 znakova";
    }
    $upit2 = "SELECT * FROM korisnik WHERE userName='$kime'";
    $rezultat = $baza->selectDB($upit2);
    if($rezultat->num_rows > 0){
        $poruka="Korisničko ime nije slobodno";
    }
    if(empty($poruka)){
        $hash = md5( rand(0,1000) );
        $upit = "INSERT INTO korisnik (ID_korisnik,ime, prezime, userName, lozinka,hash,hashlozinka, email,tipKorisnika,datum) VALUES (DEFAULT,'$ime', '$prezime', '$kime', '$lozinka','$hash','$hashlozinka','$email',1,now());";
        $baza->updateDB($upit);

        $to=$email;
        $subject='verifikacija';
        $aktporuka = "Poštovani, molimo Vas da aktivirate korisnički račun pomoću slijedeće <a href=\"http://barka.foi.hr/WebDiP/2017_projekti/WebDiP2017x103/aktivacija.php?email=$email&hash=$hash\">poveznice</a>.";
        mail($to,$subject,$aktporuka);
    }   
}	
}
?>

<div id="sadrzaj">
<?php if ($poruka != "") echo $poruka . "<br><br>"?>
<form action="" method="post">
  <label for="ime">Ime:</label>
  <input type="text" name="ime" id="ime">
  <br>
  <label for="prezime">Prezime:</label>
  <input type="text" name="prezime" id="prezime" >
  <br>
  <label for="kime">Korisničko ime: :</label>
  <input type="text" name="kime" id="kime">
  <br>
  <label for="email">E-mail:</label> 
  <input type="text" name="email" id="email">
  <br>
  <label for="lozinka">Lozinka:</label>
  <input type="text" name="lozinka" id="lozinka" >
  <br>
  <label for="ponlozinku">Ponovi lozinku:</label>
  <input type="text" name="ponlozinku" id="ponlozinku">
  <br><br>
  <input type="submit" value="Dodaj">
  <br><br>
  <div class="g-recaptcha" data-sitekey="6LenRmgUAAAAAHbNWv-Bc1bzSiAR96d-B9Zya2s8"></div>
</form> 
</div>
<?php
include_once './_footer.php';
?>