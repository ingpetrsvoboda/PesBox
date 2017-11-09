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
interface RecordableRendererInterface extends RendererInterface {
    public function setVariablesUsageRecorder(VariablesUsageRecorderInterface $recorder);    
    public function getVariablesUsageRecorder(): VariablesUsageRecorderInterface ; 
}