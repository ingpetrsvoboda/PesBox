<?php
namespace Tester\Model\File\Repository;

use Tester\Model\File\Entity\Uloha;
use Tester\Model\File\Entity\Navigace\Navigace;
use Tester\Model\File\Entity\Otazka\Otazka;
use Tester\Model\File\Entity\Otazka\Zadani\Zadani;
use Tester\Model\File\Entity\Otazka\Zadani\Obsah\Obsah;
use Tester\Model\File\Entity\Otazka\Zadani\Odpoved\Odpoved;
use Tester\Model\File\Entity\Otazka\Zadani\Odpoved\Data\Data;

//use Tester\Model\File\Repository;

/**
 * Description of Otazky
 *
 * @author vlse2610
 */
class Ulohy implements RepositoryInterface  {
    
    private $cesta;

    public function __construct( $cestaKSadamOtazekASpravnychOdpovedi = '' ) {
        $this->cesta = $cestaKSadamOtazekASpravnychOdpovedi;
    }
    
    public function get($id, $nazevSady) {
        return $this->create($this->getArrayUlohy($nazevSady)[$id]);
    }
    
    /**
     * 
     * @param string $nazevSady
     * @return Uloha array of
     */
    public function find($nazevSady) {
        $arrayUlohy = $this->getArrayUlohy($nazevSady);
        
        foreach ($arrayUlohy as $id => $uloha) {
            $ulohy[$id] = $this->create($uloha);   
        }
        return  isset($ulohy) ? $ulohy : NULL  ; 
    }

    /**
     * 
     * @param  $uloha
     * @return Uloha
     */
    private function create( $uloha ) {
        return (new Uloha())
            ->setNavigace( (new Navigace())->setNapis($uloha['navigace']['napis']))
            ->setOtazka((new Otazka())
                    ->setLegend( $uloha['otazka']['legend'])
                    ->setZadani((new Zadani())
                            ->setType( $uloha['otazka']['zadani']['type']) 
                            ->setObsah((new Obsah())
                                    ->setImgFileName( $uloha['otazka']['zadani']['obsah']['img_file_name'])
                                    ->setLabel( $uloha['otazka']['zadani']['obsah']['label'])
                                    ->setText ( $uloha['otazka']['zadani']['obsah']['text'])
                            )
                            ->setOdpoved( (new Odpoved())                                        
                                    ->setType ($uloha['otazka']['zadani']['odpoved']['type'] )
                                    ->setData( ( new Data())
                                            ->setLabel($uloha['otazka']['zadani']['odpoved']['data']['label'] )
                                            ->setContent($uloha['otazka']['zadani']['odpoved']['data']['content'])  //...nyni1-4
                                            ->setOk($uloha['otazka']['zadani']['odpoved']['data']['ok'])                                                
                                    )                                        
                            )                               
                    )        
            );
                
    }
    
    /**
     * 
     * @param string $nazevSady
     * @return array
     * @throws \UnexpectedValueException
     * @throws \LogicException
     */
    private function getArrayUlohy($nazevSady) {
        $fuileOtazky   = $this->cesta . $nazevSady . ".json";                  
        $readedJson = file_get_contents($fuileOtazky);
        if ($readedJson === FALSE) {
            throw new \UnexpectedValueException("Požadovaný soubor '$fuileOtazky' bohužel neexistuje!");
        }          
        $arrayUlohy = json_decode($readedJson, TRUE);
        if  ( !isset($arrayUlohy) OR !is_array($arrayUlohy) ) {
            throw new \LogicException("Soubor $fuileOtazky neobsahuje správná data. Soubory musí obsahovat platná data ve formátu json.");
        }
        return $arrayUlohy;
    }
}
