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

use Pes\View\Recorder\VariablesUsageRecorderInterface;

/**
 *
 * @author pes2704
 */
trait RecordableRendererTrait {
    
    /**
     * @var VariablesUsageRecorderInterface ;
     */
    private $variablesUsageRecorder;
    
    /**
     * Metoda nastaví rekorder pro zaznamenávání informací u užití zadaných dat v šabloně v průbšhu renderování.
     * Záznam se provádí do zadaného rekorderu, který je možné po renderování získat metodou template objekt getVariablesUsageRecorder().
     *  
     * @param VariablesUsageRecorderInterface $recorder
     * @return $this
     */
    public function setVariablesUsageRecorder(VariablesUsageRecorderInterface $recorder) {
        $this->variablesUsageRecorder = $recorder;
        return $this;
    }

    /**
     * Vrací objekt se záznamem o užití proměnných šablony. Tento objekt vznikne a je naplněn informacemi v průběhu renderování, 
     * pokud byla před renderováním zavolána metoda setRecordVariableUsageInfo(TRUE).
     * 
     * @return VariablesUsageRecorderInterface
     */
    public function getVariablesUsageRecorder(): VariablesUsageRecorderInterface {
        return $this->variablesUsageRecorder;
    }
    
}
