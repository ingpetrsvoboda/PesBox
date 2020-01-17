<?php
namespace Middleware\Login;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class Application implements MiddlewareInterface {
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
        $loggedUser = $this->loginLogout($request);
        $request = $request->withAttribute('logged_user', $loggedUser);
        $response = $handler->handle($request);
        return $response;
    }

    private function loginLogout($request) {
        include 'Middleware/Login/index.php';
        return $loggedUser;
    }

}


