<?php
namespace Tester\Model\Db\Entity;


/**
 * Description of OdpovedOtazka
 *
 * @author vlse2610
 */
class OdpovedNaOtazku  extends EntityAbstract {
    
    public $idOdpovedNaOtazku;
    public $idPrubehTestuFk ;    //idOdpovedFk;--stare
    public $identifikatorOdpovedi;
    public $hodnota;
    
}
