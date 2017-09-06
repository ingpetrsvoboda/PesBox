<?php

namespace Pes\View\Renderer;

use ??Twig_Environment;

/**
 * Framework_View_Template_TemplateTwig je decorator pro Twig_Environment template objekt
 *
 * @author pes2704
 */
class TwigRenderer implements TemplateRendererInterface {
    /**
     * @var Twig_Environment 
     */
    protected $templateObject;
    
    /**
     * Konstruktor. Přijímá parametr typu Twig_Environment.
     * @param Twig_Environment $templateSystemObject
     */
    public function __construct(Twig_Environment $templateSystemObject) {
        $this->templateObject = $templateSystemObject;
    }
    
    public function loadTemplate($templateFileName) {
        $this->templateObject = $this->templateObject->loadTemplate($templateFileName);
        return $this;
    }

    public function render() {
        $content = $this->templateObject->render($this->context);
        return $content;
    }
}
