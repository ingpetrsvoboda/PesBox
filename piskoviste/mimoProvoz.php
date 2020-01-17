<?php
    $time = date("Y-m-d H:i:s");

        http_response_code(500);
        echo
       '<html>
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="Content-Language" content="cs">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
        </head>
        <body>';
        echo '<h4  style="border: 8px solid tomato; padding: 1em; background-color: lightyellow;">Tento web je mimo provoz. Velice se omlouváme.';
        echo '<p> V '.$time.' nastala nečekaná výjimka.</p>';
        echo '</body>
        </html>';