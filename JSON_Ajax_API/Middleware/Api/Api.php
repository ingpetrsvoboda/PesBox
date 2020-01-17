<?php
namespace Middleware\Api;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use Pes\Http\Response;

use Pes\Container\Container;
use Pes\View\View;
use Pes\View\Template\PhpFileTemplate;


class Api implements MiddlewareInterface {
    /**
     *
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return Response
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler=NULL): ResponseInterface {
        $template = (new PhpFileTemplate('contents/layout.php'));
        // kontext je Container
        $contextContainer = (new ContainerConfigurator($request))->configure(new Container());
        $view = (new View())->setTemplate($template)->setData($contextContainer->get('layout'));

        $response = new Response(200);
        $size = $response->getBody()->write($view->getString());
        return $response;
    }

}