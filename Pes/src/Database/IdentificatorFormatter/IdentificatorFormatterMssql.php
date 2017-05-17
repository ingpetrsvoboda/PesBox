<?php
namespace Pes\Database\IdentificatorFormatter;
/**
 * Description of MysqlIdentifierFormatter
 *
 * @author pes2704
 */
class IdentificatorFormatterMssql implements IdentificatorFormatterInterface {
    public function getFormatted($identificator) {        
        return "[".  \str_replace("[","[[",\str_replace("]","]]",$identificator))."]";
    }
}
