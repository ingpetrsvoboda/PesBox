<?php
namespace Pes\Database\IdentificatorFormatter;
/**
 *
 * @author pes2704
 */
interface IdentificatorFormatterInterface {
    
    /**
     * Metoda formátuje identifikátory pro použití v SQL dotazu podle typu konkrétní databáze. 
     * Např. přidá před a za identifikátor "databázové" uvozovky v případě MySQL databáze.
     * @param string $identificator
     */
    public function getFormatted($identificator);
}
