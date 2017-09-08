<?php

namespace Pes\View;

use Psr\Log\LoggerInterface;
use Pes\View\Renderer\RendererInterface;

/**
 * Description of Framework_View_Abstract
 *
 * @author pes2704
 */
class View implements ViewInterface {    

    /**
     *
     * @var RendererInterface 
     */
    private $renderer;
    
    protected $parts = array();
    
    /**
     * 
     * @param RendererInterface $renderer
     */
    public function __construct(RendererInterface $renderer) {
        $this->renderer = $renderer;
    }
    
    /**
     * 
     * @param type $contextData data přijímaná zadaným rendererem
     */
    public function render($contextData) {
        return $this->renderer->render($contextData);
    }
    
    /**
     * Metoda umožňuje použít objekt view přímo jako proměnnou (prvek contextu) pro další view
     * @return string
     */
    public function __toString() {       
        //varianta pro produkci - bez použití error handleru vyhazujícího výjimky
        $str = $this->getString();

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
     * Handler pro použití v metodě _toString ve variantě pro ladění
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
    
    /**
     * Metoda __toString a tedy i toString se volá v okamžiku pokusu o převod toho, co zapsal kontroler do response body a to je vždy view.
     * 
     * Při použití objektu typu Framework_Type_ContextDataInterface pro data kontextu ve view tato metoda zapíše log o použití dat kontextu.
     * @return type
     */
    public function getString() {
        // loguje to co bylo potřeba pro již proběhlé renderování
        if ($this->context instanceof Framework_Type_ContextDataInterface) {
            (new Framework_Logger_ContextDataStatus())->logStatus(str_replace('\\', ' ', get_called_class()).'.log', $this->context);
        }
        
        if ($this->parts) {
            $str = $this->convertToString($this->parts);
        } else {
            $render = $this->render();
            if ($render instanceof Framework_View_ViewInterface) {   // metoda render vrací view (return $this;) ($render === $this)
                $str =  $this->convertToString($this->parts);
            } elseif (is_array($render)) {
                $str =  $this->convertToString($this->parts).$this->convertToString($render);  // render vytvoří $this->parts (nebo ne) a vrací pole
            } elseif (is_scalar($render)) {
                $str = $this->convertToString($this->parts).$render;  // render vytvoří $this->parts (nebo ne) a vrací skalár
            } else {
                $str =  $this->convertToString($this->parts);  // metoda render nevrací nic - asi chybí return $this; - mohla vytvořit $this->part a nevracet nic
            }
        }
        return $str ? $str : '';
    }
    
    /**
     * Převede pole na html. Všechny prvky pole se přetypují na string. Prvky pole mohou být proměnné libovolného typu,
     * umožňující převod na string. Pro skalární proměnné se použije výchozí typecasting php, pro prvky ostatních typů musí přetypovábí zajistit uživatel.
     * Například pro typ objekt je možno použít magickou metodu __toString().
     * Takto přetypované pole se následně převede na řetězec tak, že jednotlivé prvky jsou odděleny znakem (znaky) PHP_EOL.
     * @param array $htmlArray
     * @return string
     */
    private function convertToString(array $htmlArray) {
        if ($htmlArray) {
            foreach ($htmlArray as $value) {
                if ($value) {
                    $html[] = (string) $value;
                }
            }
            $string =  implode(PHP_EOL, $html);
        } else {
            $string = '';
        }
        return $string;
    }    
}

