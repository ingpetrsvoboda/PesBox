<?php

namespace Pes\View\Renderer;

use Pes\View\Template\TemplatePhpInterface;

/**
 * Renderer - vstupem spustitelný soubor PHP, výstupem je text.
 * Renderer generuje textový výstup tak, že vykonává PHP kód uložený v souboru html/php ne obecně text/php šablony. Soubor šablony je 
 * standartní PHP soubor, tedy může obsahovat text a PHP kód v segmentech uzavřených do PHP tagů. Text v šabloné může být HTML nebo libovolný text. 
 * 
 * Objekt pro vytvoření obsahu s pomocí šablony příjímá data ve formě asociativního pole. Toto pole je pomocí PHP funkce extract() interně převedeno na jednotlivé proměnné se jmény 
 * odpovídajícími indexům v asociativním poli dat. V souborech šablon se pak využívají takto získané jednotlivé proměnné. Se soubory šablon se 
 * pracuje tak, že jednotlivé proměěné jsou vždy v lokálním rozsahu proměnných PHP (local scope) a nikdy se tak neovlivňují proměnné v jednotlivých šablonách 
 * nebo jinde v kódu. Je tak možné v různých souborech šablon používat stejně pojmenované proměnné. 
 * 
 * Objekt je schopen zaznamenat užití zadaných dat při renderování šablony. Zaznamenává informace o proměnných předaných jako data, 
 * nedefinovaných proměnných použitých v šabloně a o proměnných předaných v datech, ale v šabloně nepoužitých. 
 * Tyto informace je následně možné použít pro ladění nebo logování. Záznam je zaznamenán v specializovaném záznamovém objektu, 
 * který lze získat voláním příslušné metody.
 *
 * @author pes2704
 */
class RendererPhp implements TemplateRendererInterface, RecordableRendererInterface {
    
    use RecordableRendererTrait;
    
    /**
     * @var TemplatePhpInterface 
     */
    private $template;
    
    /**
     * Nastaví template objekt.
     * @param TemplatePhpInterface $templateObject
     * @return $this
     */
    public function __construct(TemplatePhpInterface $templateObject) {
        $this->template = $templateObject;
    }
    
    /**
     * Vrací nastavený template objekt.
     * @return TemplatePhpInterface
     */
    public function getTemplate() {
        return $this->template;
    }
    
    
    /**
     * Vykoná zadanou šablonu template objektu s použitím zadaných dat a vzniklý výstup vrací jako string.
     * 
     * Pokud je nastaven záznam informací o užití dat v template, zaznamenává informace o proměnných předaných jako data, 
     * nedefinovaných proměnných použitých v šabloně a o proměnných předaných, ale v šabloně nepoužitých. 
     * Tyto informace je následně možné použít pro ladění nebo logování. Záznam je zaznamenán v specializovaném záznamovém objektu, 
     * který lze z template objektu získat voláním příslušné metody.
     * 
     * @param array $data
     * @return string
     */ 
    public function render(array $data=[]) {
        // záznam o užití proměnných - kontext vars zde před voláním protectedInsludeScope(), unused vars po renderování v protectedInsludeScope(),
        // případné undefined vars v templateErrorHandler()
        if ($this instanceof RecordableRendererInterface AND isset($this->variablesUsageRecorder)) {
            $this->variablesUsageRecorder->setTemplateInfo("Template file {$this->gettemplate()->getTemplateFilename()} rendered by ".get_called_class().".");
            $this->variablesUsageRecorder->setContextVars($this->gettemplate()->getTemplateFilename(), array_keys($data));
            $oldErrorHandler = set_error_handler(array($this, 'templateErrorHandler'));
                $result = $this->template->protectedIncludeScope($data, $this->variablesUsageRecorder);
            set_error_handler($oldErrorHandler);
        } else {
            $result = $this->template->protectedIncludeScope($data);
        }
        return $result;        
    }

    #################################################
    
    /**
     * Zaznamenává nedefinované proměnné. Tato metoda musí být po dobu vykonávání template nastavena jako error_handler 
     * funkcí set_error_handler(array($this, 'viewErrorHandler')). Pak je volána při vzniku jakékoli chyby. Rozpoznává chyby
     * typu E_NOTICE a zjišťuje zda chybové hlášení začíná textem 'Undefined variable: '. Pokud ano, zaznamená výskyt nedefinované proměnné 
     * do rekorderu. 
     * 
     * @param type $errno
     * @param type $errstr
     * @param type $errfile
     * @param type $errline
     * @return boolean
     */
    function templateErrorHandler($errno, $errstr, $errfile, $errline) {
        if (!(error_reporting() & $errno)) {
            // This error code is not included in error_reporting, so let it fall through to the standard PHP error handler
            return FALSE;
        }
        if ($errno == E_NOTICE) {
            //Undefined variable: header
            $pos = strpos($errstr, 'Undefined variable: ');
            if ($pos===0) {
                $name = substr($errstr, 20);
                if (isset($this->variablesUsageRecorder)) {
                    $this->variablesUsageRecorder->addUndefinedVar($this->template->getActualTemplateFilename(), $name, $errfile, $errline);
                }
            }
        }    
        $development= isset($GLOBALS['development']) ? TRUE : FALSE;
        if ($development) {
        /* Execute PHP internal error handler - here in any error case */
            return FALSE;
        }
        /* Don't execute PHP internal error handler */
        return TRUE; 
    }    
}
