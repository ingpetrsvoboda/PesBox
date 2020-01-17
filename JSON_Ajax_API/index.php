<?php

//$GLOBALS['force_development'] = 'force_development';
// nebo
//$GLOBALS['force_production'] = 'force_production';

include '../Pes/src/Bootstrap/Bootstrap.php';

use Pes\Http\Factory\EnvironmentFactory;
use Pes\Http\Factory\ServerRequestFactory;
use Pes\Http\ResponseSender;

use Liveblock\Middleware\Web\WebDevelopmentVersion;


ini_set ('session.use_cookies',1);  //všude default v php.ini

$environment = (new EnvironmentFactory())->createFromGlobals();
$request = (new ServerRequestFactory())->createFromEnvironment($environment);

$path = $request->getUri()->getPath();
//  "/PesBox/JSON_Ajax_API/api/v1/pribeh/data.json/"

if ($production OR !$development) {
    $response = (new Application())->process($request);
} else {
    $response = (new WebDevelopmentVersion())->process($request);
}

(new ResponseSender())->send($response);