<?php

namespace Tester\Model;

use Pes\Database\Handler\HandlerInterface; 


/**
 * Z přečtené věty z db  poskytuje informace o konfiguraci  testu - 
 * -  nazev_testu, sadu  se zadanim otazek , sadu spravnych odpovedi...
 *
 * @author vlse2610
 */
class KonfiguraceTestu implements KonfiguraceTestuInterface { 
    
    private $dbh;
    private $konfiguraceTestu;   
     
    
    public function __construct( HandlerInterface $dbh, $identifikatorKonfiguraceTestu ) {
        $this->dbh = $dbh; 
        
        $radekTab = $this->getKonfiguraceTestu($identifikatorKonfiguraceTestu);
        $this->konfiguraceTestu = $radekTab;
    }
    
    
    
    private function getKonfiguraceTestu( $identifikatorKonfiguraceTestu ) {                             
        $query = "SELECT id_konfigurace_testu, popis_testu, nazev_testu, nazev_sady, jmeno_souboru
                   FROM   konfigurace_testu 
                   LEFT JOIN sada_otazek ON konfigurace_testu.id_sada_otazek_fk = sada_otazek.id_sada_otazek
                   WHERE id_konfigurace_testu = :identifikator_kofigurace_testu 
                   and konfigurace_testu.valid = 1";
        $statSelect = $this->dbh->prepare($query);
        $statSelect->bindParam(':identifikator_kofigurace_testu', $identifikatorKonfiguraceTestu);
        $succ = $statSelect->execute();

        $pp = $statSelect->rowCount();  
        if (!($pp===1))  {            
             throw new \UnexpectedValueException('Nenalezen požadovaný test  v databázi.'. get_class() .  '.'. __CLASS__ ) ;
        }
        
        $prectenaVeta =  $statSelect->fetch(\PDO::FETCH_ASSOC);
        return    $prectenaVeta;  
    }
    
    
    
  
    /**
     * 
     * @return string název testu
     */
    public function getNazevTestu() {       
        return  isset($this->konfiguraceTestu['nazev_testu']) ? $this->konfiguraceTestu['nazev_testu'] : NULL  ;
    }
    
    
    /**
    * Vrací pole se zadanim otazek (pro používaný test). 
    * Jmeno souboru se zadanim se zjisti z db ($this->parametryTestu).
    * 
    * @return array $test
    */         
    public function getSadaOtazek() {
        if (isset($this->konfiguraceTestu['jmeno_souboru'])) { 
            $jmenoSouboruOtazky = $this->konfiguraceTestu['jmeno_souboru'] . '.php';        
            include $jmenoSouboruOtazky;  //magic! (pole se jmenuje $test )  magic!
        }
        return isset($test) ? $test : NULL  ; 
    }
    
    
    /**
    * Vrací pole správných odpovědí (pro používaný test). Př.: array [0] : array [uloha01] = '1' .
    * Správné odpovědi uloženy v souboru. Jmeno souboru se spravnymi odpovedmi  se zjisti z db ($this->parametryTestu).
    * 
    * @return array $test_spravne_odpovedi
    */        
    public function getPoleSpravnychOdpovedi() {
        if (isset($this->konfiguraceTestu['jmeno_souboru'])) {
            $jmenoSouboruOtazky = $this->konfiguraceTestu['jmeno_souboru'];
            $kusy = explode(".", $jmenoSouboruOtazky);
            array_pop($kusy);
            $jmenoSouboruOdpovedi = $kusy[0] .'_odpovedi.php' ;
            include $jmenoSouboruOdpovedi;  //magic! (pole se jmenuje $test_spravne_odpovedi )   magic! 
        }            
      
          return  isset($test_spravne_odpovedi) ? $test_spravne_odpovedi : NULL  ;    
    }
   
    /**
     * 
     * @return string název zákazníka
     */
//    public function getCustomer() {
//        return $this->prectenaVetaZKampane['zakaznik_nazev'];
//    }
    
    
    
    
}    