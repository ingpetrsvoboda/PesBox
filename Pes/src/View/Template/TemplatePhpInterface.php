<?php

/*
 * Copyright (C) 2017 pes2704
 *
 * This is no software. This is quirky text and you may do anything with it, if you like doing
 * anything with quirky texts. This text is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

namespace Pes\View\Template;

use Pes\View\Recorder\VariablesUsageRecorderInterface;

/**
 *
 * @author pes2704
 */
interface TemplatePhpInterface {
    public function getTemplateFilename();  
    public function protectedIncludeScope (array $data, VariablesUsageRecorderInterface $variablesUsageRecorder = NULL);
    public function getActualTemplateFilename();
    
    public function insert($templateFilename, $data=[]);
    public function repeat($data, $templateFilename);   
    // trait:
    public function filter($filters, $text);
    public function e($text);
    public function esc($text);
    public function mono($text);
    public function p($text);
    public function nl2br($text);
    public function attribute($type, $value);
}
