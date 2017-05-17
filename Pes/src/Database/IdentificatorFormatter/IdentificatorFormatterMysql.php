<?php
namespace Pes\Database\IdentificatorFormatter;
/**
 * Description of MysqlIdentifierFormatter
 *
 * @author pes2704
 */
class IdentificatorFormatterMysql implements IdentificatorFormatterInterface {
    public function getFormatted($identificator) {
        return "`".  \str_replace("`","``",$identificator)."`";
    }
}
