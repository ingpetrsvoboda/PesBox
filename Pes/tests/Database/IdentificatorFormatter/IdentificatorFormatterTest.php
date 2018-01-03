<?php
use PHPUnit\Framework\TestCase;



use Pes\Database\IdentificatorFormatter\IdentificatorFormatterMysql;

/**
 * Description of IdentificatorFormatterTest
 *
 * @author pes2704
 */
class IdentificatorFormatterTest extends TestCase {
    
    public function testMysqlIdentificatorFormatter() {
        $formatter = new IdentificatorFormatterMysql();
        $this->assertEquals("`nazdar`", $formatter->getFormatted('nazdar'), 'Handler nevrací správně zformátovaný identifikátor.'); 
        $this->assertEquals("`kvok``kvak`", $formatter->getFormatted("kvok`kvak"), 'Handler nevrací správně zformátovaný identifikátor.');        
    }    
}
