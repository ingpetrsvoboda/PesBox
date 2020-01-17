<?php

use Middleware\Login\AppContext;

$loggedUser = $_SESSION ["sess_user"] ?? FALSE;
/* @var $request Pes\Http\Request */
if ($request->getMethod() == 'POST') {
    $parsedBody = $request->getParsedBody();
    $logout = $parsedBody['logout'] ?? FALSE;
    $login = $parsedBody['login'] ?? FALSE;

    if ($login) {
        $user = $parsedBody['user'] ?? FALSE;
        $heslo = $parsedBody['heslo'] ?? FALSE;
        if ($user AND $heslo) {
            include Middleware\Login\AppContext::getScriptsDirectory()."pristup.php";  //precte z tab. opravneni pro $user ,$zaznam_opravneni
            if (isset($zaznam_opravneni['password']) AND $zaznam_opravneni['password'] == $heslo) {
                session_regenerate_id();   // je vhpdné regenerovat id vždy před uloženém autentifikovaného uživatele do session
                $_SESSION ["sess_user"] = $user;
                include 'activ_user_login.php';
                $loggedUser = $user;
            }
        }
    } elseif($logout) {
        if ($loggedUser) {
            include_once 'activ_user_logout.php';
            $_SESSION = array();
            session_destroy();
            $loggedUser = NULL;
        }
    }
}
