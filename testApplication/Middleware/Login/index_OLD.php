<?php

use Middleware\Login\AppContext;

ini_set ('session.use_cookies',1);
  
$logout = isset($_GET['logout']) ? $_GET['logout'] : 0;
    
$get = $_GET;
$post = $_POST;


//prijde-li z prihlasovaciho okenka
$user = isset($_POST['user'])? $post['user'] : '';
$heslo = isset($_POST['heslo'])? $post['heslo'] : '';
$log_pokus = isset($_POST['log_pokus'])? $post['log_pokus'] : '';

$pristupOK = 0;

session_name("sess" . substr(AppContext::getTextFirma(),0,6));

//ob_clean();
session_start();             //PRED START NEsmi BYT zadny vystup !!!!

//print_r($lang);

//echo "<br>po START* sess id: " . session_id() ;     /*SEL*/
//echo "<br>po START* sess name: " . session_name() ; /*SEL*/

//echo "<br>app po start: " . $app;    /*SEL*/
//echo "<br>list po start: " . $list;  /*SEL*/




//**************** je-li session otevrena a nechci pryc  - nastavi pristupOK =1 **********************
//if ((session_is_registered ("sess_user")) and ($logout == 0)) {$pristupOK = 1;}
if ((isset ($_SESSION['sess_user']) ) and ($logout == 0)) {
    $pristupOK = 1;
    $_SESSION ["sess_app"] = 'rs';       ///* SEL*/  pridano
}





if (($logout != 0) and ($pristupOK != 1)) {
    //*** chci konec - skoncit session

    include_once 'activ_user_logout.php';
    //session_unset($_SESSION ["sess_user"]);
    //session_unset($_SESSION ["sess_heslo"]);
    //session_unset($_SESSION ["sess_prava"]);
    $_SESSION = array();
    session_destroy();
} else {             // *** prihlasit se a zaregistrovat do session
    include Middleware\Login\AppContext::getScriptsDirectory()."pristup.php";  //precte z tab. opravneni pro $user , vyrobi $pristup, $zaznam_opravneni
 
    if (($heslo === @$pristup[$user])) {
        //session_start();

        //session_register("sess_user");
        // session_register("sess_prava");
        // session_register("sess_app");

        $_SESSION ["sess_user"] = $user;
        $_SESSION ["sess_prava"] = $zaznam_opravneni;
        $_SESSION ["sess_app"] = 'rs';  

        //session_register("sess_heslo");
        // $_SESSION ["sess_heslo"] = $heslo;
        // $sess_user = $user;
        // $sess_heslo = $heslo;
        // $sess_prava = $zaznam_opravneni;


        $pristupOK = 1;
        include 'activ_user_login.php';
    }
}



//--------------------------------------------------------------

//--------------------------------------------------------------

$sess_prava = @$_SESSION ['sess_prava'];

if ($pristupOK) {                      //****  pristup odepřen
    include 'templates/logout.php';
    
} else {
    include 'ModalLoginView.php';
    echo (new ModalLoginView())->getString();
    
}

