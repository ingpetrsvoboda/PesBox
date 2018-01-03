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
 *
 * @author pes2704
 */
interface VariablesUsageRecorderInterface {
    public function getRecordInfo();
    public function setRecordInfo($nfo):self;    
    public function addUndefinedVar($index, $name, $file, $line):self;
    public function getUndefinedVars();
    public function getUnusedVars();
    public function getContextVars();
    public function setUnusedVars($index, $unusedVars):self;
    public function setContextVars($index, $contextVars): self;    
}
