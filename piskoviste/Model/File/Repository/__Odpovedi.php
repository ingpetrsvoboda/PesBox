<?php
namespace Tester\Model\File\Repository;

use Tester\Model\File\Entity\Odpoved;

/**
 * Description of ky
 *
 * @author vlse2610
 */
class __Odpovedi implements RepositoryInterface {
    
    private $cesta;

    public function __construct( $cestaKSadamOdpovedi = '' ) {
        $this->cesta = $cestaKSadamOdpovedi;
    }
    
    public function find($nazevSady) {
        
        $fuile = $this->cesta . $nazevSady . "_ODPOVEDI.php";  
        if (!is_readable($fuile)) {
            throw new \UnexpectedValueException("Požadovaný soubor '$fuile' bohužel neexistuje!");
        }                
        include $fuile ; //$this->cesta . $nazevSady . "_ODPOVEDI.php";  //magic! (pole se jmenuje $spravne_odpovedi )  magic!
        
        if (isset($spravne_odpovedi) AND is_array($spravne_odpovedi)) {
            foreach ($spravne_odpovedi as $key=>$value) {
             
             }
        }     
         else {
            throw new \LogicException("Soubor $fuile neobsahuje správná data. Soubor musí být platný kód php a musí vytvářet pole s názvem $spravne_odpovedi.");
        }
        
        
        return isset($spravne_odpovedi) ? $spravne_odpovedi : NULL  ;      //$spravne_odpovedi;
        
//        $odpovedi = new Odpovedi();
//        $odpovedi->odpovedi = $spravne_odpovedi;
//        return $odpovedi;
    }
}
