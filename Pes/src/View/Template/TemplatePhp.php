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
 * PhpTemplate.
 *
 * @author pes2704
 */
class TemplatePhp implements TemplatePhpInterface {
    
    use TemplatePhpTrait;
    
    const FILTER_DELIMITER = '|';
    
    /**
     * @var string 
     */
    private $templateFileName;
    
    /**
     * @var VariablesUsageRecorderInterface 
     */
    private $actualRecorder;
    
    private $actualTemplateFilename;
        
    /**
     * Konstruktor - název souboru s template - název souboru včetně přípony.
     * @param type $templateFileName
     */
    public function __construct($templateFileName) {
        $this->templateFileName = $templateFileName;
    }
    
    /**
     * Vrací název souboru s template.
     * @return string Název souboru s template
     */
    public function getTemplateFilename() {
        return $this->templateFileName;
    }

    
    /**
     * @param string $template cesta k souboru s template
     * @param array $data asociativní pole
     * @param boolean $collectDebugInfo TRUE pro záznam info o užití proměnných v šabloně
     * @return string Výstup z output bufferu
     * @throws \Pes\View\Renderer\Throwable Znovu vyhodí Error nebo Exception, pokud vznikla někde při vykonávání kódu template
     */
    public function protectedIncludeScope (array $data, VariablesUsageRecorderInterface $recorder = NULL) {
        extract($data);

        // Ošeření výjimek a chyb vzniklých při vykonávání template tak, abych nezahodil nějaký obsah, 
        // který byl zapsán do výstupního bufferu před vznikem chyby nebo výjimky
        // podle Plates - aktualizovaný příklad z http://php.net/manual/en/function.ob-get-level.php
        try {
            
            $level = ob_get_level();
            if (isset($recorder)) {
                $this->actualRecorder = $recorder;
                $this->actualTemplateFilename = $this->templateFileName;                
                $numberOfVarsBefore = count(get_defined_vars());
            }

            ob_start();
            include $this->templateFileName;
            
            if (isset($this->actualRecorder)) {
                $unused = array_keys(array_slice(get_defined_vars(), $numberOfVarsBefore));
                $this->actualRecorder->setUnusedVars($this->templateFileName, $unused);                
            }
            $result = ob_get_clean();
            
        } catch (Throwable $e) {
            while (ob_get_level() > $level) {
                ob_end_clean();   
            }
            throw $e;
        } catch (Exception $e) {
            while (ob_get_level() > $level) {
                ob_end_clean();
            }
            throw $e;
        }           
        
        return $result;        
    }    
    
    public function insert($templateFilename, $data=[]) {
        extract($data);
            if (isset($this->actualRecorder)) {
                $this->actualTemplateFilename = $templateFilename;                                
                $numberOfVarsBefore = count(get_defined_vars());
            }        
        include $templateFilename;
            if (isset($this->actualRecorder)) {
                $this->actualRecorder->setUnusedVars($templateFilename, array_keys(array_slice(get_defined_vars(), $numberOfVarsBefore+1)) );
            }        
        return;
    }
    
    public function repeat($data, $templateFilename) {
        foreach ($data as $var) {
            $this->insert($templateFilename, $var);
        }
    }
    
    public function getActualTemplateFilename() {
        return $this->actualTemplateFilename;
    }
}
