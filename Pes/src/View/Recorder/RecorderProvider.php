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

use Pes\View\Recorder\VariablesUsageRecorder;

/**
 * Description of RecorderProvider
 *
 * @author pes2704
 */
class RecorderProvider implements RecorderProviderInterface {

    
    private $recorders = array();
    
    /**
     * 
     * @return VariablesUsageRecorder array of
     */
    public function provideRecorder() {
        $recorder = new VariablesUsageRecorder();
        $this->recorders[] = $recorder;
        return $recorder;
    }
    
    /**
     * 
     * @return array
     */
    public function getRecorders() {
        return $this->recorders;
    }
}
