<?php
namespace Middleware\Session;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

// všechny varianty session save handleru
use Pes\Session\SaveHandler\PhpSaveHandler;
use Pes\Session\SaveHandler\PhpEncryptedSaveHandler;
use Pes\Session\SaveHandler\PhpLoggingSaveHandler;
use Pes\Session\SaveHandler\PhpEncryptedLoggingSaveHandler;
use Pes\Session\SaveHandler\FileSaveHandler;
use Pes\Session\SaveHandler\FileEncryptedSaveHandler;
use Pes\Session\SaveHandler\FileLoggingSaveHandler;
use Pes\Session\SaveHandler\FileEmcryptedLoggingSaveHandler;

use Pes\Session\SessionHandler;

use Pes\Security\Cryptor\CryptorOpenSSLBase;
use Pes\Debug\Inspector;


class Application implements MiddlewareInterface {

    /**
     *
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
        // Varianty session handleru:
        // Všechny varianty volají: session_set_save_handler($saveHandler, true); druhý parametr=TRUE -> registruje session_write_close() jako a register_shutdown_function() funkci.
        // při ukončování skriptu je tak zavolána funkce session_write_close() vyvolá: write() a close() - teprve v této chvíli dojde k zápisu dat do úložiště session
        $logger = FileLogger::getInstance('Logs', 'SessionLogger.log', FileLogger::REWRITE_LOG);
        $cryptor = new CryptorOpenSSLBase('klic');
        ## základní varianta s SessionHandler
        //$saveHandler = new PhpSaveHandler();
        //$sessionHandler = new SessionHandler($saveHandler, 'Test_Pes_Session');
        ## varianta s EncryptedHandler
        //$saveHandler = new PhpEncryptedSaveHandler($cryptor);
        //$sessionHandler = new SessionHandler($saveHandler, 'Test_Pes_EncrytedSession');
        ## varianta s LoggingHandler
        $saveHandler = new PhpLoggingSaveHandler($logger);
        $sessionHandler = new SessionHandler($saveHandler, 'Test_Pes_LoggedSession');
        ## varianta s LoggingEncryptedHandler
        //$sessionHandler = new PhpEncryptedLoggingSaveHandler($cryptor, $logger);
        //$sessionHandler = new SessionHandler($saveHandler, 'Test_Pes_EncryptedLoggedSession');

        $lastTime = $sessionHandler->get('test.time');
        $countOld = $sessionHandler->get('test.count');
        $hasFingerprint = $sessionHandler->hasFingerprint();

        $response = $handler->handle($request);


        $sessionHandler->set('test.count', $countOld ? ++$countOld : 1);
        $sessionHandler->set('test.time', date('H:i:s d.m.Y'));
        $response->getBody()->write(Inspector::inspect($sessionHandler->getArrayCopy()));

        return $response;
    }
}


