<?php
// http://platesphp.com/
// používá krátký php tag <?=   tzv. echo short tags

class View {
    function e($text) {
        return $text;
    }
    
    function section($tag) {
        switch ($tag) {
            case 'content':
                return '<p>Odstavec textu Odstavec textu Odstavec textu Odstavec textu Odstavec textu Odstavec textu Odstavec textu Odstavec textu Odstavec textu Odstavec textu Odstavec textu Odstavec textu Odstavec textu Odstavec textu Odstavec textu Odstavec textu Odstavec textu Odstavec textu Odstavec textu Odstavec textu Odstavec textu Odstavec textu Odstavec textu Odstavec textu Odstavec textu Odstavec textu Odstavec textu </p>';
;
                break;

            default:
                break;
        }
    }
    function render() {
        $title = 'Tííítulek';
        include 'phpTemplatePlatesTemplate.php';
    }
}

$view = new View();
$view->render();



