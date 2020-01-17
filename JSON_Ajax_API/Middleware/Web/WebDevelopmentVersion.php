<?php
namespace Liveblock\Middleware\Web;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use Pes\Http\Factory\ResponseFactory;

use Pes\Logger\FileLogger;

use Pes\Container\Container;
use Pes\View\View;
use Pes\View\Template\PhpFileTemplate;
use Pes\View\Renderer\RendererContainer;

use Pes\View\Recorder\RecorderProvider;
use Pes\View\Recorder\VariablesUsageRecorder;
use Pes\View\Recorder\RecordsLogger;

class WebDevelopmentVersion implements MiddlewareInterface {
    /**
     *
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return Response
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler=NULL): ResponseInterface {

        if ($handler) {
                $logger = FileLogger::getInstance('Logs', 'WebApplicationLogger.log', FileLogger::APPEND_TO_LOG);
                $logger->error(get_class().' - zadán RequestHandler, druhý parametr metody process(). Metoda není připravena na zpracování vnořeného middleware.');
        }

        #### template, renderer se záznamem, view a renderování výstupu ####
        // Příprava na logování
        //
        // Pro logování musí každý nový Renderer dostat jako parametr konstruktoru RecorderProvider.
        // RecorderProvider poskytuje Rekordery pro záznam užití proměnných při renderování a každý poskytnutý Recorder zaregistruje.
        // Prostřednictím RecorderProvideru jsou pak zpětně všechny poskytnuté Recordery dostupné.
        // V této aplikaci jsou všechny renderery vytváženy automaticky. Pro vytváření Rendererů použit RendererContainer.
        // RecorderProvider je nastaven RendereContaineru jako statická proměnná metodou setRecorderProvider a
        // poskytuje nový Rekorder vždy, když RendererContainer vytváří nový Renderer.
        // Po skončení renderování se RecorderProvider předá do RecordsLoggeru pro logování užití proměnných v šablonách. V RecordsLoggeru
        // jsou všechny RecorderProviderem poskytnuté a zaregistrované Rekordery přečteny a je pořízen log.
        $recorderProvider = new RecorderProvider(VariablesUsageRecorder::RECORD_LEVEL_FULL);
        RendererContainer::setRecorderProvider($recorderProvider);


        $template = (new PhpFileTemplate('templates/layout.php'));
        $contextContainer = (new ContainerConfigurator($request))->configure(new Container());

        $view = (new View())->setTemplate($template)->setData($contextContainer->get('layout'));
        $html = $view->render();
        //logování
        // Je třeba nastavit libovolný běžný logger jako parametr RecordsLoggeru.
        // Zde je jako běžný logger použit FileLogger a log tedy bude zapsán v příslušném souboru.
        // RecordsLogger získá data z recorderů a zapíše log.
        $logger = FileLogger::getInstance('Logs', 'ViewLogger.log', FileLogger::REWRITE_LOG);
        (new RecordsLogger($logger))->logRecords($recorderProvider);


        $response = (new ResponseFactory())->createResponse();
        $size = $response->getBody()->write($html);
        return $response;
    }

}