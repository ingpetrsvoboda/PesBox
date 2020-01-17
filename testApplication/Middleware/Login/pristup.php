<?php
use Middleware\Rs\AppContext;
$handler = AppContext::getDb();

$statement = $handler->query("select * from opravneni where user='$user'");
$statement->execute();

$zaznam_opravneni = $statement->fetch(PDO::FETCH_ASSOC);

$pristup = Array ($zaznam_opravneni['user'] => $zaznam_opravneni['password']);
?>
