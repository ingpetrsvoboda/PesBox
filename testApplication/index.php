<?php

namespace TestApplication;

/**
 * definováním konstanty PRODUCTION_MACHINE_HOST_NAME se docílí automatického nastavení prostředí jako produkčního ($GLOBALS['production'] = 'production set by hostname')
 */
define('PRODUCTION_MACHINE_HOST_NAME', 'xxxxx');

include '../Pes/src/Bootstrap/Bootstrap.php';

use Pes\Http\Factory\EnvironmentFactory;
use Pes\Http\Factory\ServerRequestFactory;
use Pes\Http\ResponseSender;

// všechny varianty session save handleru
use Pes\Session\SaveHandler\PhpSaveHandler;
use Pes\Session\SaveHandler\PhpEncryptedSaveHandler;
use Pes\Session\SaveHandler\PhpLoggingSaveHandler;
use Pes\Session\SaveHandler\PhpEncryptedLoggingSaveHandler;
use Pes\Session\SaveHandler\FileSaveHandler;
use Pes\Session\SaveHandler\FileEncryptedSaveHandler;
use Pes\Session\SaveHandler\FileLoggingSaveHandler;
use Pes\Session\SaveHandler\FileEmcryptedLoggingSaveHandler;

use Pes\Session\SessionStatusHandler;

use Pes\Security\Cryptor\CryptorOpenSSLBase;

//cookies
use Pes\Http\Cookies;

use Pes\Logger\FileLogger;
use Pes\Http\Helper\RequestDumper;
use Pes\Debug\Inspector;

ini_set('upload_max_filesize', '200M');

$environment = (new EnvironmentFactory())->createFromGlobals();
$request = (new ServerRequestFactory())->createFromEnvironment($environment);

if (PES_DEVELOPMENT) {
    $requestsLogger = FileLogger::getInstance('Logs', 'RequestLogger.log', FileLogger::REWRITE_LOG);
    $requestsLogger->info(RequestDumper::dump($request));
}

// Varianty session handleru:
// Všechny varianty volají: session_set_save_handler($saveHandler, true); druhý parametr=TRUE -> registruje session_write_close() jako a register_shutdown_function() funkci.
// při ukončování skriptu je tak zavolána funkce session_write_close() vyvolá: write() a close() - teprve v této chvíli dojde k zápisu dat do úložiště session
$logger = FileLogger::getInstance('Logs', 'SessionLogger.log', FileLogger::REWRITE_LOG);
$cryptor = new CryptorOpenSSLBase('klic');

## základní varianta s PhpSaveHandler
//$saveHandler = new PhpSaveHandler();
## varianta s PhpEncryptedSaveHandler
//$saveHandler = new PhpEncryptedSaveHandler($cryptor);
## varianta s PhpLoggingSaveHandler
$saveHandler = new PhpLoggingSaveHandler($logger);
## varianta s PhpEncryptedLoggingSaveHandler
//$saveHandler = new PhpEncryptedLoggingSaveHandler($cryptor, $logger);

$sessionHandler = new SessionStatusHandler('Test_Pes_Session', $saveHandler);
$cookies = new Cookies\RequestCookies($request);


$response = (new Controller\NestedFilesUpload($request))->getResponse();
$response->getBody()->write('<img src="public/image/cze.gif" />');
$response->getBody()->write(Inspector::inspect($cookies));
$response->getBody()->write(Inspector::inspect($sessionHandler->getArrayReference()));
$response->getBody()->write(Inspector::inspect($sessionHandler->getFragmentArrayReference('test')));
$lastTime = $sessionHandler->get('test.time');
$countOld = $sessionHandler->get('test.count');
$hasFingerprint = $sessionHandler->hasFingerprint();

//echo Inspector::inspect($lastTime);
//echo Inspector::inspect($countOld);
//echo Inspector::inspect($hasFingerprint);

$responseCookies = new Cookies\ResponseCookies();
$responseCookies->setResponseCookie((new Cookies\ResponseCookie)->setName('testSessionCookie')->setValue('session value')->setAttributes());
$responseCookies->setResponseCookie((new Cookies\ResponseCookie)->setName('testMaxAgeCookie')->setValue('Max-Age value')->setAttributes(['Max-Age'=>100]));
$responseCookies->setResponseCookie((new Cookies\ResponseCookie)->setName('testExpiresCookie')->setValue('Expires value')->setAttributes(['Expires'=>'next hour']));
$responseCookies->setResponseCookie((new Cookies\ResponseCookie)->setName('testPathCookie')->setValue('path for public')->setAttributes(['Path'=>'/PesBox/testApplication/public']));
$responseCookies->setResponseCookie((new Cookies\ResponseCookie)->setName('testDomainCookie')->setValue('domain for testApplication')->setAttributes(['Domain'=>'localhost/PesBox/testApplication']));
$response = $responseCookies->setDefaults([])->hydrateResponseRHeaders($response);

(new ResponseSender())->send($response);

$sessionHandler->set('test.count', $countOld ? ++$countOld : 1);
$sessionHandler->set('test.time', date('H:i:s d.m.Y'));


