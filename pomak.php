<?php
class virtualnoVrijeme {
    
    private static $datoteka;
    private static $citac;
    
    function __construct() {
        self::$datoteka = 'http://barka.foi.hr/WebDiP/pomak_vremena/pomak.php?format=xml';
        self::$citac = new XMLReader();
    }
    
    function vratiVrijeme(){
        self::$citac->open(self::$datoteka);
        
        while(self::$citac->read() ) {
          if( 'pomak' === self::$citac->name ) {
                    $pomak = self::$citac->getAttribute('brojSati');
                }
        }        
        return $pomak;
    }
}
?>