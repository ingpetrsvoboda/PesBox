<?php
$user=$_SESSION ['sess_user'];
use Middleware\Rs\AppContext;
$handler = AppContext::getDb();
$successDelete = $handler->exec("DELETE FROM activ_user WHERE user = '$user' LIMIT 1");

