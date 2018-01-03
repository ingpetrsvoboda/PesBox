<?php

/*
 * Copyright (C) 2017 pes2704
 *
 * This is no software. This is quirky text and you may do anything with it, if you like doing
 * anything with quirky texts. This text is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

namespace Pes\View\Renderer;

use Pes\View\Recorder\RecorderProviderInterface;

/**
 *
 * @author pes2704
 */
trait RecordableRendererTrait {
    
    /**
     * @var RecorderProviderInterface ;
     */
    protected $recorderProvider;
    
    /**
     * Metoda nastaví rekorder pro zaznamenávání informací u užití zadaných dat v šabloně v průbšhu renderování.
     * Záznam se provádí do zadaného rekorderu, který je možné po renderování získat metodou template objekt getVariablesUsageRecorder().
     *  
     * @param RecorderProviderInterface $recorderProvider
     * @return $this
     */
    public function setRecorderProvider(RecorderProviderInterface $recorderProvider) {
        $this->recorderProvider = $recorderProvider;
        return $this;
    }

    /**
     * Vrací objekt se záznamem o užití proměnných šablony. Tento objekt vznikne a je naplněn informacemi v průběhu renderování, 
     * pokud byla před renderováním zavolána metoda setRecordVariableUsageInfo(TRUE).
     * 
     * @return RecorderProviderInterface || NULL
     */
    public function getRecorderProvider() {
        return $this->recorderProvider;
    }
    
}
