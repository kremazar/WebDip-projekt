<?php
class Baza{
    const server = "localhost";
    const korisnik = "WebDiP2017x103";
    const lozinka = "admin_1h9Q";
    const baza = "WebDiP2017x103";
    
   private function spojiDB() {
        $mysqli = new mysqli(self::server, self::korisnik, self::lozinka, self::baza);
        mysqli_set_charset($mysqli,"utf8");
        if ($mysqli->connect_errno) {
            echo "Neuspjesno spajanje s bazom: " . $mysqli->connect_errno . ", " . $mysqli->connect_error;
            die();
        }
        return $mysqli;
    }

    function selectDB($upit) {
        $veza = self::spojiDB();

        $rezultat = $veza->query($upit);
        $veza->close();
        return $rezultat;
    }

    function updateDB($upit) {
        $veza = self::spojiDB();
        
        $veza->query($upit);
    }

    function closeDB($veza) {
        $veza->close();
    }
}
	
?>