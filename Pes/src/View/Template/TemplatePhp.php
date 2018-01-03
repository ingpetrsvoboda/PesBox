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
     * Poměnná nastavována v protectedIncludeScope k užití pro metody insert() a další
     * @var VariablesUsageRecorderInterface 
     */
    private $actualRecorder;
    
    /**
     * Poměnná nastavována v protectedIncludeScope k užití pro metody insert() a další
     * @var string 
     */
    private $actualTemplateFileName;
        
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
     * {@inheritdoc}
     * <p>Vložené soubory jsou vložené použitím php příkazu <code><?php include vlozeny.php; ?></code> nebo voláním metody insert template objektu 
     * <code><?= $this->insert("contents/main/$content.php", $data) ?></code>. Kód souboru se vykonává uvnitř metody teplate objektu, proto jsou pro něj dostupné 
     * všechny metody template objektu, například metoda insert() nebo repeat(). Takové metody se pak volají voláním $this->insert(...) apod.</p>
     * 
     * @throws \Throwable <p>Znovu vyhodí Error nebo Exception, pokud vznikla někde při vykonávání kódu template. Před vyhozením takové chyby nebo výjimky
     * nejprve odešle na výstup obsah výstupního bufferu (všech úrovní bufferu), který do něj byl zapsán předtím, než chyba nebo výjimka vznikla.</p>
     */
    public function render (array $data, VariablesUsageRecorderInterface $recorder = NULL) {
        $this->actualTemplateFileName = $this->templateFileName; 
        if (isset($recorder)) {
            $this->actualRecorder = $recorder;
            $this->actualRecorder->setRecordInfo("Record for template file {$this->actualTemplateFileName}.")
                                ->setContextVars($this->actualTemplateFileName, array_keys($data));                
        }
        $oldErrorHandler = set_error_handler(array($this, 'templateErrorHandler'));    
        $result = $this->includeToProtectedScope($data);
        set_error_handler($oldErrorHandler);           

        $this->actualTemplateFileName = $this->templateFileName;              
        
        return $result;        
    }
    
    private function includeToProtectedScope(array $data) {
        ob_start();

        $obLevel = ob_get_level();
        $numberOfVarsBefore = count(get_defined_vars())+1;  // +1 -> počet včetně $numberOfVarsBefore

//  if(is_array($data)) {
//        extract($data);    
//  //} elseif (is_object($data) && $data instanceof ArrayAccess && $data instanceof Traversable && $data instanceof Serializable && $data instanceof Countable) {  to vše dohromady je pak jako array
//  } elseif (is_object($data) && $data instanceof Traversable) {
//      foreach ($data as $key=>$value) {
//          $$key = $value;
//      }
//  } else {
//        throw new \InvalidArgumentException('Metoda přijímá ');
//    }
        extract($data);
            
        // Ošeření výjimek a chyb vzniklých při vykonávání template tak, abych nezahodil nějaký obsah, který byl zapsán do výstupního bufferu před vznikem chyby nebo výjimky
        // podle Plates aktualizovaný příklad z http://php.net/manual/en/function.ob-get-level.php
        try {
            include $this->actualTemplateFileName;            
        } catch (\Throwable $e) {
            while (ob_get_level() > $obLevel) {
                ob_end_clean();   
            }
            throw $e;
        } catch (\Exception $e) {
            while (ob_get_level() > $obLevel) {
                ob_end_clean();
            }
            throw $e;
        }
                    
        if (isset($this->actualRecorder)) {
            $unused = $this->unusedVars(get_defined_vars(), $numberOfVarsBefore);
            if ($unused) {
                $this->actualRecorder->setUnusedVars($this->actualTemplateFileName, $unused);      
            }
        }
        return ob_get_clean();
    }
    
    public function insert($templateFilename, $data=[]) {
        $oldRecordIndex = $this->actualTemplateFileName;
        $this->actualTemplateFileName = $templateFilename;
        $result = $this->includeToProtectedScope($data);
//        extract($data);
//            if (isset($this->actualRecorder)) {
//                $this->actualRecordIndex = $templateFilename;  // pro záznam undefined vars v error handleru
//                $this->actualRecorder->setContextVars("Inserted template ".$templateFilename, array_keys($data));                 
//                $numberOfVarsBefore = count(get_defined_vars())+1;
//            }        
//        include $templateFilename;
//            if (isset($this->actualRecorder)) {
//            $unused = $this->unusedVars(get_defined_vars(), $numberOfVarsBefore);
//                $this->actualRecorder->setUnusedVars("Inserted template ".$templateFilename, $unused);      
//            }        
        $this->actualTemplateFileName = $oldRecordIndex;
        return $result;
    }
    
    public function repeat($data, $templateFilename) {
        if (is_array($data) OR $data instanceof \ArrayAccess) {
            foreach ($data as $var) {
                $pieces[] = $this->insert($templateFilename, $var);
            }
            $ret =  implode(PHP_EOL, $pieces);
        } else {
            $ret = '';
        }
        return $ret;
    }
    
    private function unusedVars($definedVarsArray, $numberOfVarsBefore) {
        return array_keys(array_slice($definedVarsArray, $numberOfVarsBefore));
    }
    
    #################################################
    
    /**
     * Zaznamenává nedefinované proměnné. Tato metoda musí být po dobu vykonávání template nastavena jako error_handler 
     * funkcí set_error_handler(array($this, 'viewErrorHandler')). Pak je volána při vzniku jakékoli chyby. Rozpoznává chyby
     * typu E_NOTICE a zjišťuje zda chybové hlášení začíná textem 'Undefined variable: '. Pokud ano, zaznamená výskyt nedefinované proměnné 
     * do rekorderu. 
     * 
     * @param type $errno
     * @param type $errstr
     * @param type $errfile
     * @param type $errline
     * @return boolean
     */
    function templateErrorHandler($errno, $errstr, $errfile, $errline) {
        if (!(error_reporting() & $errno)) {
            // This error code is not included in error_reporting, so let it fall through to the standard PHP error handler
            return FALSE;
        }
        if ($errno == E_NOTICE) {
            //text error message - příklad: Undefined variable: header
            $pos = strpos($errstr, 'Undefined variable: ');
            if ($pos===0) {
                $name = substr($errstr, 20);
                if (isset($this->actualRecorder)) {
                    $this->actualRecorder->addUndefinedVar($this->actualTemplateFileName, $name, $errfile, $errline);
                }
            }
        }    
        $development= isset($GLOBALS['development']) ? TRUE : FALSE;
        if ($development) {
        /* Execute PHP internal error handler - here in any error case */
            return FALSE;
        }
        /* Don't execute PHP internal error handler */
        return TRUE; 
    }        
}
