<?php

use Pes\Database\Handler\ConnectionInfo;
use Pes\Database\Handler\AttributesProvider\AttributesProviderDefault;
use Pes\Database\Handler\DsnProvider\DsnProviderMysql;
use Pes\Database\Handler\OptionsProvider\OptionsProviderMysql;
use Pes\Database\Handler\Handler;

use Pes\Logger\FileLogger;

    $connectionInfoUtf8 = new ConnectionInfo
            ('pes', DbTypeEnum::MySQL, "localhost", "root", "spravce", "pes", 'utf8', 'utf8_czech_ci');
$dsnProvider = new DsnProviderMysql();
$optionsProvider = new OptionsProviderMysql();
//                    $logger = new NullLogger();
$logger = FileLogger::getInstance('Logs', 'DbLogger.log', FileLogger::REWRITE_LOG);
$attributesProviderDefault = new AttributesProviderDefault($logger);
$dbh = new Handler($connectionInfoUtf8, $dsnProvider, $optionsProvider, $attributesProviderDefault, $logger);



$res = mysql_query("SHOW TABLE STATUS LIKE 'MY_TABLE'");
$row = mysql_fetch_assoc($res);
mysql_free_result($res);
$commentArr = preg_split('/; */', $row['Comment']);

$foreignKeyArr = array(); //<-- We want to fill this.

foreach($commentArr as $comment) {
   //Only work on InnoDB foreign key info.
   if(preg_match(
         '/\(`(.*)`\) REFER `(.*)\/(.*)`\(`(.*)`\)/',
         $comment,
         $matchArr)) {
   $primaryKeyFieldArr = preg_split('/` `/', matchArr[1]);
   $foreignKeyDatabase = $matchArr[2];
   $foreignKeyTable = $matchArr[3];
   $foreignKeyFieldArr = preg_split('/` `/', $matchArr[4]);

   for($i = 0; $i < count($primaryKeyFieldArr); $i++) {
      $foreignKeyArr[ $primaryKeyFieldArr[$i] ] = array(
         'db' => $foreignKeyDatabase,
         'table' => $foreignKeyTable,
         'field' => $foreignKeyFieldArr[$i]);
   }
}
}
?>
