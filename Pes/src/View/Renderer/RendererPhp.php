<?php

namespace Pes\View\Renderer;

use Pes\View\Template\TemplatePhpInterface;

/**
 * Renderer - vstupem je html/php šablona, což je spustitelný soubor PHP, výstupem je text.
 * Renderer generuje textový výstup tak, že vykonává PHP kód uložený v souboru html/php ne obecně text/php šablony. Soubor šablony je 
 * standartní PHP soubor, tedy může obsahovat text a PHP kód v segmentech uzavřených do PHP tagů. Text v šabloné může být HTML nebo libovolný text. 
 * 
 * Objekt pro vytvoření obsahu s pomocí šablony příjímá data ve formě asociativního pole. Toto pole je pomocí PHP funkce extract() interně převedeno 
 * na jednotlivé proměnné se jmény odpovídajícími indexům v asociativním poli dat. 
 * V souborech šablon se pak využívají takto získané jednotlivé proměnné. Se soubory šablon se 
 * pracuje tak, že jednotlivé proměnné jsou vždy v lokálním rozsahu proměnných PHP (local scope) a nikdy se neovlivňují proměnné v různých šablonách 
 * nebo jinde v kódu. Je tak možné v různých šablonách používat stejně pojmenované proměnné. 
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
    
    private $data;
    
    /**
     * Nastaví template objekt.
     * @param TemplatePhpInterface $templateObject
     * @return $this
     */
    public function __construct(TemplatePhpInterface $templateObject, array $data=[]) {
        $this->template = $templateObject;
        $this->data = $data;
    }
    
    /**
     * Vrací nastavený template objekt.
     * @return TemplatePhpInterface
     */
    public function getTemplate() {
        return $this->template;
    }
    
    /**
     * 
     * @param array $data
     * @return string
     */
    public function render(array $data=[]) {
        // záznam o užití proměnných - 

        if (isset($this->recorderProvider)) {
            $recorder = $this->recorderProvider->provideRecorder();
            $result = $this->template->render($data, $recorder);
        } else {
            $result = $this->template->render($data);
        }
        return $result;        
    }
}
