<?php

namespace Pes\View\Renderer;

use PHPTAL;

/**
 * Framework_View_Template_TemplatePHPTAL je rendere využívající PHPTAL template objekt.
 *
 * @author pes2704
 */
class PHPTALRenderer implements TemplateRendererInterface {
    /**
     * @var PHPTAL 
     */
    protected $templateObject;
    
    /**
     * Konstruktor. Přijímá parametr typu PHPTAL.
     * @param PHPTAL $templateSystemObject
     */
    public function __construct(PHPTAL $templateSystemObject) {
        $this->templateObject = $templateSystemObject;
    }
    
    public function loadTemplate($templateFileName) {
        $this->templateObject->setTemplate($templateFileName);
        return $this;
    }

    /**
     * Metoda implementuje metodu rozhranní render(). Volá metodu execute() PHPTAL objektu.
     * @param array $context
     * @return null
     */
    public function render() {
        if ($this->context) {
            foreach($this->context as $klic => $hodnota) $this->templateObject->$klic = $hodnota;
            $content = $this->templateObject->execute();
            return $content;
        } else {
            return NULL;
        }
    }
}
