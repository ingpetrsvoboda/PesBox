<?php

namespace Tester\Model;
use Pes\Database\Handler\HandlerInterface;

/**
 * 
 * Description of ParametryTestuZKampane
 *
 * @author vlse2610
 */
class ViewKampane2 implements DbViewInterface {
     
    /**
     * @var HandlerInterface 
     */
    private $dbh;
    
    /**
     * 
     * @param HandlerInterface $dbh
     */
    public function __construct( HandlerInterface $dbh) {
        $this->dbh = $dbh;        
    }
    
    /**
     * Vrací řádek view_kampane_2 z db kampani
     * @param int $id je v pohledu view_kampane_2 ( id_vzb_osoba_kampan ) a je to vlastne id tabulky kampane_2.vzb_osoba_kampan
     * @return array Pole s dat nebo NULL
     */
    public function get($id) {
       $query = "SELECT id_vzb_osoba_kampan ,test_jmeno_souboru, test_nazev, zakaznik_nazev
                        FROM view_kampane_2
                        WHERE 
                        id_vzb_osoba_kampan = :id";               

        $statt = $this->dbh->prepare($query);
        $st = $statt->bindParam(':id', $id);
        $succ = $statt->execute();
        $data = $statt->fetch(\PDO::FETCH_ASSOC);
        return $data ? $data : NULL;
    }
    
    public function find($param) {;
        assert(FALSE, 'Metoda find() není dosud implementována.');
    }
}
