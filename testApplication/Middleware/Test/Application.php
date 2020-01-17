<?php
namespace Middleware\Test;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;


use TestApplication\Controller;

class Application implements MiddlewareInterface {

    /**
     *
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
/*
        ##################################################
        $environment = new Environment($_SERVER);
        $request = Request::createFromEnvironment($environment);
        $dataContainerDefinitions = [
            'elementId' => 'menu',
            'categoriesHierarchy' => function() {return (new MenuHierarchy())->getHierarchy('categories'); },
            'flatenedTree' => function($c) {return $c->get('categoriesHierarchy')->getFullTree(); },
            'menuStyles' => function() {return new MenuListStyles(); }

        ];
        $dataContainer = (new ContainerFactory())->create($dataContainerDefinitions);

        $this->router = new Router();
        $this->router->addRoute('GET', '/', function() use ($dataContainer) {return (new DisplayMenuController($dataContainer))->display(); });
        $this->router->addRoute('GET', 'nodes/:id/', function($id) use ($dataContainer) {
            return (new DisplayMenuController($dataContainer))->display($id); });   // detail
        $this->router->addRoute('POST', 'nodes/:id/', function($id) use ($dataContainer, $request) {
            return (new EditMenuController($dataContainer))->post($id, $request); });
        $this->router->addRoute('POST', 'nodes/:id/add/', function($id) use ($dataContainer) {return (new EditMenuController($dataContainer))->add($id); });
        $this->router->addRoute('POST', 'nodes/:id/addchild/', function($id) use ($dataContainer) {return (new EditMenuController($dataContainer))->addchild($id); });
        $this->router->addRoute('POST', 'nodes/:id/delete/', function($id) use ($dataContainer) {return (new EditMenuController($dataContainer))->delete($id); });
        $this->router->addRoute('POST', 'nodes/:id/move/:parentid/', function() {});

        $this->router->addRoute('GET', 'tree/', function() use ($dataContainer) {return (new DisplayMenuController($dataContainer))->display(); });
        $this->router->addRoute('GET', 'tree/:id/', function() {});   // subtree

        $this->router->route($request->getMethod(), $request->getUri()->getPath()) ;

##################################################
*/


        $response = (new Controller\NestedFilesUpload($request))->getResponse();
        return $response;
    }
}


