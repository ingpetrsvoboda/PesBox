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

use Pes\View\Recorder\RecorderProviderInterface;
use Psr\Log\LoggerInterface;


/**
 * Description of RecordsLogger
 *
 * @author pes2704
 */
class RecordsLogger {
    
    /**
     * @var LoggerInterface Description
     */
    private $logger;
    
    /**
     * Konstruktor. Přijímá logger pro logování záznamů pořízených rekordérem užití proměnných v template.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger) {
        $this->logger = $logger;
    }
    
    /**
     * Zaznamená do logu informace o užití proměnných v průběhu renderování.  
     * Informace zapíše do logu pomocí loggeru předaného jako parametr konstruktoru.
     * 
     */
    public function logRecords(RecorderProviderInterface $recorderProvider) {
        foreach ($recorderProvider->getRecorders() as $recorder) {
            $time = date("Y-m-d H:i:s");
            $this->logger->debug(" [$time] Usage of variables for rendering: {$recorder->getRecordInfo()}"); 

            if ($recorder->getContextVars()) {            
                foreach ($recorder->getContextVars() as $index => $vars) {
                    if (count($vars)) {
                        $this->logger->info(" [$time] Context variables in $index:");            
                        foreach ($vars as $name) {
                            $this->logger->info(" --- Context variable $name.");                    
                        }
                    } else {
                        $this->logger->info(" --- Empty context.");                                            
                    }
                }
            }
            if ($recorder->getUndefinedVars()) {
                foreach ($recorder->getUndefinedVars() as $index => $vars) {
                    if (count($vars)) {
                        $this->logger->warning(" [$time] Undefined variables in $index:");
                        foreach ($vars as $info) {
                            $this->logger->warning(" --- Undefined variable {$info['name']} in line {$info['line']}.");                    
                        }
                    }
                }
            }
            if ($recorder->getUnusedVars()) {        
                foreach ($recorder->getUnusedVars() as $index => $vars) {
                    if (count($vars)) {
                        $this->logger->notice(" [$time] Unused variables in $index:");            
                        foreach ($vars as $name) {
                            $this->logger->notice(" --- Unused variable $name.");                    
                        }
                    }
                }
            }
        }
    }
}
