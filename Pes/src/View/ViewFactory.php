<?php

/*
 * Copyright (C) 2017 pes2704
 *
 * This is no software. This is quirky text and you may do anything with it, if you like doing
 * anything with quirky texts. This text is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

namespace Pes\View;

//tyto deklarace jsou použity pro definování typu nově vytvářených view, rendereru a template
use Pes\View\View as View;
use Pes\View\StringableView as StringableView;
use Pes\View\Renderer\RendererPhp as Renderer;
use Pes\View\Template\TemplatePhp as Template;

//standartně užité deklarace
use Pes\View\Recorder\VariablesUsageRecorder;
use Pes\View\Renderer\RecordableRendererInterface;

/**
 * Description of ViewFactory
 * 
 * Vytvoří nový view, nastaví mu nově vytvořený renderer a template. 
 * Typ view, rendereru a template je dán zadanými deklaracemi use uvedenými ve třídě ViewFactory. Zde jsou deklarována čtyři jména: 
 * View pro standartní view objekt
 * StringableView pro view objekt, který je typem StringableViewInterface a je tedy převoditený na string
 * Renderer pro renderer 
 * Template pro template objekt 
 * 
 * @author pes2704
 */
class ViewFactory {
    
    /**
     * Vytvoří nový view, nastaví mu nově vytvořený renderer a template. 
     * Typ view je View::class.
     * 
     * @param type $templateFilename
     * @return View
     */
    public static function viewForTemplate($templateFilename, VariablesUsageRecorder $recorder=NULL) {
        $viewClass = View::class;
        $rendererClass = Renderer::class;
        $templateClass = Template::class;
        
        $renderer = new $rendererClass(new $templateClass($templateFilename));
        if (isset($recorder) AND $renderer instanceof RecordableRendererInterface) {
            $renderer->setVariablesUsageRecorder($recorder);
        }
        return new $viewClass($renderer);
    }
    
    /**
     * Vytvoří nový view, přímo přetypovatelný na text. Pokud jsou zadána data, nastaví tomuto view i data, to třeba, pokud zadaná čablona obsahuje proměnné. 
     * Vytvořený objekt view je vhodný jako proměnná do šablony nebo jako view pro node typu TextView.
     * 
     * Podrobně:
     * Vytvoří nový objekt view typu StringableViewInterface, nastaví mu nově vytvořený renderer a template. 
     * Typy view, rendereru a template jsou dány deklaracemi use uvedenými ve třídě ViewFactory. Metoda vytvořenému view nastaví 
     * data potřebná pro renderování a případně i zaznamový objekt pro záznam o užití dat při renderování.
     * Výsledný view obsahuje vše potřebné pro renderování a lze ho kdykoli přetypovat na text. 
     * 
     * @param type $templateFilename
     * @param type $data
     * @param VariablesUsageRecorder $recorder
     * @return StringableView
     */
    public static function stringableViewForTemplate($templateFilename, $data=[], VariablesUsageRecorder $recorder=NULL) {
        $viewClass = StringableView::class;
        $rendererClass = Renderer::class;
        $templateClass = Template::class;
        
        $renderer = new $rendererClass(new $templateClass($templateFilename));
        if (isset($recorder) AND $renderer instanceof RecordableRendererInterface) {
            $renderer->setVariablesUsageRecorder($recorder);
        }
        
        $view = new $viewClass($renderer);
        $view->setData($data);

        return $view;
    }    
}
