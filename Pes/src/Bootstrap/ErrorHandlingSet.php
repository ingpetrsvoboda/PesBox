<?php

use Pes\Logger\FileLogger;

######### ERROR REPORTING & PROFILING ########################
if (isset($GLOBALS['development'])) {
    error_reporting(E_ALL);
} else {
    error_reporting(E_ALL & ~E_NOTICE);
}

//ini_set('xdebug.show_exception_trace', '1');
//ini_set('xdebug.collect_params', '4');
//ini_set('xdebug.profiler_enable', '1');

######### DEFINICE EXCEPTION A ERROR HANDLERŮ ##############
function flushOutputBufferAndThrowException(\Throwable $e) {

    while (ob_get_level()) {
        ob_end_clean();   
    }
    throw $e;   
}

/**
 * Exception handler zachytává všechny výjimky a loguje je jako critical.
 * Následně:
 * - v development prostředí výjimku znovu vyhodí, pokud byla výjimka instance Throwable vyhodí ErrorException, jinak vyhodí původní výjimku
 * - mimo development prostředí vypíše omluvné hlášení
 * 
 * Předpokládá české texty v chybových hlášeních, proto před vyhozením výjimky vypíše html s hlavičkou Content-Language: cs, ta obvykle zajistí, že české texty jsou česky.
 */
function logExceptionHandler($e) {
    $development= isset($GLOBALS['development']) ? TRUE : FALSE;

    $exceptionsLogger = FileLogger::getInstance('Logs', 'ExceptionsLogger.log', FileLogger::APPEND_TO_LOG);
    $time = date("Y-m-d H:i:s");
    if (class_exists('\\Error') AND $e instanceof \Error) {
        $exceptionsLogger->critical(get_class($e)." [$time] {$e->getMessage()} on line {$e->getLine()} in file {$e->getFile()}");
    } else {
        $exceptionsLogger->critical(get_class($e)." exception [$time] {$e->getMessage()} on line {$e->getLine()} in file {$e->getFile()}");            
    }
        // české texty v exceptions (i v xdebug) - bez konce body a html si prohlížeč musí poradit
        echo
       '<html>
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="Content-Language" content="cs"> 
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
        </head>      
        <body>';
    if ($development) {
        if (class_exists('\\Error') AND $e instanceof \Error) {
            flushOutputBufferAndThrowException (new ErrorException(get_class($e).' '.$e->getMessage(), $e->getCode(), 1, $e->getFile(), $e->getLine(), $e->getPrevious()));
        } else {
            throw $e;
        }
    } else {
        echo '<h4>Tento web je mimo provoz. Velice se omlouváme.';
        echo '<p> V '.$time.' nastala nečekaná výjimka.</p>';
        echo '</body>
        </html>';
    }
}

/**
 * Pomocná funkce pro error handlery - překládá typ (číslo) chyby na kód chyby (např. typ 2 na řetězec E_WARNING).
 * Pro nerozpoznaný typ chyby vrací původní hodnotu.
 * 
 * @param integer $type
 * @return string
 */
function FriendlyErrorType($type)
{
    switch($type)
    {
        case E_ERROR: // 1 //
            return 'E_ERROR';
        case E_WARNING: // 2 //
            return 'E_WARNING';
        case E_PARSE: // 4 //
            return 'E_PARSE';
        case E_NOTICE: // 8 //
            return 'E_NOTICE';
        case E_CORE_ERROR: // 16 //
            return 'E_CORE_ERROR';
        case E_CORE_WARNING: // 32 //
            return 'E_CORE_WARNING';
        case E_COMPILE_ERROR: // 64 //
            return 'E_COMPILE_ERROR';
        case E_COMPILE_WARNING: // 128 //
            return 'E_COMPILE_WARNING';
        case E_USER_ERROR: // 256 //
            return 'E_USER_ERROR';
        case E_USER_WARNING: // 512 //
            return 'E_USER_WARNING';
        case E_USER_NOTICE: // 1024 //
            return 'E_USER_NOTICE';
        case E_STRICT: // 2048 //
            return 'E_STRICT';
        case E_RECOVERABLE_ERROR: // 4096 //
            return 'E_RECOVERABLE_ERROR';
        case E_DEPRECATED: // 8192 //
            return 'E_DEPRECATED';
        case E_USER_DEPRECATED: // 16384 //
            return 'E_USER_DEPRECATED';
    }
    return $type;
} 

/**
 * Funkce zaregistrovaná jako error handler převede všechny chyby na výjimku typu ErrorException.
 * Funkci lze zaregistrovat jako error handler voláním set_error_handler("exception_error_handler");
 * 
 * @param type $errno
 * @param type $errstr
 * @param type $errfile
 * @param type $errline
 * @return boolean
 * @throws ErrorException
 */
function exceptionErrorHandler($errno, $errstr, $errfile, $errline) {
    if (!(error_reporting() & $errno)) {
        // This error code is not included in error_reporting, so let it fall
        // through to the standard PHP error handler
        return FALSE;
    }
    flushOutputBufferAndThrowException( new ErrorException($errstr, 0, $errno, $errfile, $errline));
}

// varianta pro produkci:
// log_error_handler obsluhuje chyby, které nejsou potlačené podle úrovně nastavené v error_reporting
// Rozlišuje chyby s číslem E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE.
// Pro (chyby s jiným číslem než E_USER_...) vyhazuje výjimku ErrorException.
/**
 * Funkce zaregistrovaná jako error handler všechny chyby loguje, rozpoznává chyby typu E_USER a zachází s nimi podle závažnosti.
 * V development prostředí následně chybu předá zpět ke zpracování systému PHP, mimo development prostředí zpracování chyby končí.
 * Funkci lze zaregistrovat jako error handler voláním set_error_handler("logErrorHandler");
 * 
 * 
 * 
 * @param type $errno
 * @param type $errstr
 * @param type $errfile
 * @param type $errline
 * @return boolean
 * @throws ErrorException
 */
function logErrorHandler($errno, $errstr, $errfile, $errline) {
    
    $development= isset($GLOBALS['development']) ? TRUE : FALSE;
    
    if (!(error_reporting() & $errno)) {
        // This error code is not included in error_reporting, so let it fall
        // through to the standard PHP error handler
        return FALSE;
    }

    $errorLogger = FileLogger::getInstance('Logs', 'ErrorsLogger.log', FileLogger::APPEND_TO_LOG);
    $time = date("Y-m-d H:i:s");
    if (function_exists('FriendlyErrorType')) {
        $errType = FriendlyErrorType($errno);
    }
    
    switch ($errno) {
        case E_USER_ERROR:
            $errorLogger->error("E_USER_ERROR [$errno] [$time] $errstr on line $errline in file $errfile");
            $errorLogger->error("Aborting...<br />\n");
            flushOutputBufferAndThrowException(new ErrorException($errstr, 0, $errno, $errfile, $errline));  //chyby převádím na výjimky
    //        break;
        case E_USER_WARNING:
            $errorLogger->warning("E_USER_WARNING [$errno] [$time] $errstr on line $errline in file $errfile");
            break;
        case E_USER_NOTICE:
            $errorLogger->notice("E_USER_NOTICE [$errno] [$time] $errstr on line $errline in file $errfile");
            break;
        default:
            $errorLogger->debug("PHP error or unknown user error type: $errType [$errno] [$time] $errstr on line $errline in file $errfile");
            break;
    }    
    if ($development) {
    /* Execute PHP internal error handler - here in any error case */
        return FALSE;
    }
    /* Don't execute PHP internal error handler */
    return TRUE;    
}


######### SPUŠŤĚNÍ EXCEPTION A ERROR HANDLERŮ ##################
set_exception_handler('logExceptionHandler');

set_error_handler("logErrorHandler");
//set_error_handler("exceptionErrorHandler");
