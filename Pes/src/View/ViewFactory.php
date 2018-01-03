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
use Pes\View\View;
use Pes\View\StringableView;
use Pes\View\Renderer\RendererPhp;
use Pes\View\Renderer\TagRenderer;
use Pes\View\Template\TemplatePhp;

//standartně užité deklarace
use Psr\Log\LoggerInterface;
use Pes\View\Recorder\RecorderProviderInterface;

use Pes\View\Tag\TagInterface;
use Pes\View\Renderer\RecordableRendererInterface;

/**
 * Description of ViewFactory
 * 
 * Vytvoří nový view, nastaví mu nově vytvořený renderer a template. 
 * Typ view, rendereru a template je dán zadanými deklaracemi use uvedenými ve třídě ViewFactory. Zde jsou deklarována čtyři jména: <br/>
 * - View pro standartní view objekt<br/>
 * - StringableView pro view objekt, který je typem StringableViewInterface a je tedy převoditený na string<br/>
 * - Renderer pro renderer <br/>
 * - Template pro template objekt <br/>
 * 
 * @author pes2704
 */
class ViewFactory {
    
    /**
     * Vytvoří nový view, nastaví mu nově vytvořený renderer a template. 
     * Typ view je View::class.
     * 
     * @param type $templateFilename
     * @param RecordLoggerInterface $recordLogger <p>Nastaví objekt pro logování informací o užití 
     *      proměnných v šabloně. Pokud je nastaven a zde vytvářený template renderer je typu RecordableRendererInterface
     *      poskytne tento RocordLogger rekorder a renderer zaznamená užití dat při renderování šablon.</p>
     * @return View
     */
    public static function viewWithTemplate($templateFilename, RecorderProviderInterface $recordLogger=NULL) {
        $viewClass = View::class;
        $rendererClass = RendererPhp::class;
        $templateClass = TemplatePhp::class;
        
        $renderer = new $rendererClass(new $templateClass($templateFilename));
        if (isset($recordLogger) AND $renderer instanceof RecordableRendererInterface) {
            $renderer->setVariablesUsageRecorder($recordLogger->provideRecorder());
        }
        return new $viewClass($renderer);
    }
    
    /**
     * Vytvoří nový view, přímo přetypovatelný na text. Pokud jsou zadána data, nastaví tomuto view i data, to je třeba, pokud zadaná šablona obsahuje proměnné. 
     * Vytvořený objekt view je vhodný jako proměnná do šablony nebo jako view pro node typu TextView.
     * 
     * Podrobně:
     * Vytvoří nový objekt view typu StringableViewInterface, nastaví mu nově vytvořený renderer a template. 
     * Typy view, rendereru a template jsou dány deklaracemi use uvedenými ve třídě ViewFactory. Metoda vytvořenému view nastaví 
     * data potřebná pro renderování a případně i záznamový objekt pro záznam o užití dat při renderování.
     * Výsledný view obsahuje vše potřebné pro renderování a lze ho kdykoli přetypovat na text. 
     * 
     * @param type $templateFilename
     * @param type $data
     * @param RecordLoggerInterface $recordLogger <p>Nastaví objekt pro logování informací o užití 
     *      proměnných v šabloně. Pokud je nastaven a zde vytvářený template renderer je typu RecordableRendererInterface
     *      poskytne tento RocordLogger rekorder a renderer zaznamená užití dat při renderování šablon.</p>
     * @return StringableView
     */
    public static function stringableViewWithTemplate($templateFilename, $data=[], RecorderProviderInterface $recordLogger=NULL) {
        $viewClass = StringableView::class;
        $rendererClass = RendererPhp::class;
        $templateClass = TemplatePhp::class;
        
        $renderer = new $rendererClass(new $templateClass($templateFilename));
        if (isset($recordLogger) AND $renderer instanceof RecordableRendererInterface) {
            $renderer->setVariablesUsageRecorder($recordLogger->provideRecorder());
        }
        
        $view = new $viewClass($renderer);
        $view->setData($data);

        return $view;
    }    
    
    /**
     * Vytvoří nový view a nastaví mu rendererer a zadaný tag.
     * @param TagInterface $tag
     * @return View
     */
    public static function viewWithTag(TagInterface $tag, RecorderProviderInterface $recorderProvider=NULL) {
        $renderer = new TagRenderer($tag, $recorderProvider);
        return new View($renderer);        
    }
}
