<?php

/*
 * Copyright (C) 2017 pes2704
 *
 * This is no software. This is quirky text and you may do anything with it, if you like doing
 * anything with quirky texts. This text is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

namespace Pes\View\Recorder;

/**
 * Description of VariablesUsageRecorder
 *
 * @author pes2704
 */
class VariablesUsageRecorder implements VariablesUsageRecorderInterface {
    
    private $templateInfo;
    private $undefinedVars;
    private $unusedVars;
    private $contextVars;
    
    public function getTemplateInfo() {
        return $this->templateInfo;
    }

    public function setTemplateInfo($templateInfo) {
        $this->templateInfo = $templateInfo;
        return $this;
    }

        
    public function addUndefinedVar($index, $name, $file='?', $line='?') {
        $this->undefinedVars[$index][] = ['name'=>$name, 'file'=>$file, 'line'=>$line];        
    }

    public function getUndefinedVars() {
        return $this->undefinedVars;
    }

    public function getUnusedVars() {
        return $this->unusedVars;
    }

    public function getContextVars() {
        return $this->contextVars;
    }

    public function setUnusedVars($index, $unusedVars) {
        $this->unusedVars[$index] = $unusedVars;
        return $this;
    }

    public function setContextVars($index, $contextVars) {
        $this->contextVars[$index] = $contextVars;
        return $this;
    }
}
