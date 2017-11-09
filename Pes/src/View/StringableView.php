<?php

namespace Pes\View;

/**
 * Description of Framework_View_Abstract
 *
 * @author pes2704
 */
class StringableView extends View implements StringableViewInterface {    
    
    private $data = [];
    

    public function render() {
        return parent::render($this->data);
    }    
    
    public function setData($data) {
        $this->data = $data;
        return $this;
    }

    public function getData() {
        return $this->data;
    }
         
    /**
     * Metoda umožňuje použít objekt view přímo jako proměnnou (prvek contextu) pro další view
     * @return string
     */
    public function __toString() {       
        //varianta pro produkci - bez použití error handleru vyhazujícího výjimky
        $str = $this->render();

        // varianta pro ladění - tuto variantu je třeba použít, pokud používáš error handler vyhazující výjimky (např. v bootsstrapu).
            // Problém je v tom, že php neumožňuje vyhazovat výjimky uvnitř metody __toString. Samozřejmě není možné vyloučit 
            // vyhození nějaké výjimky v metodách render(). Proto je nutné zde, uvnitř metody __toString přepnout error handler na handler 
            // nevyhazující výjimky a po renderu handler vrátit.
//            set_error_handler(array($this, 'tostringErrorHandler'));
//            $str =$this->getString();
//            restore_error_handler(); 

        return $str;
    }

    /**
     * Handler pro použití v metodě _toString ve variantě pro ladění - jen příklad, tento handler vypisuje na výstup!!
     * @param type $errno
     * @param type $errstr
     * @param type $errfile
     * @param type $errline
     */
    public function tostringErrorHandler($errno, $errstr, $errfile, $errline ) {
        // Vypisuje do výstupu (echo) a tedy jsou tyto texty odeslány před odesláním <head> z response objektu. Neumí tedy česky 
        // a zkazí češtinu (všechna nastavení v head) i zbytku stránky. Řešením by bylo posílat tyto výpisy do response objektu.
        echo '<p>Chyba pri vykonavani metody __toString: '.$errstr.' in: '.$errfile.' on line: '.$errline.'.</p>'.PHP_EOL;
    }
    
}

