<?php
/**
 * Emuluje enum typ DbType.
 * 
 * @author pes2704
 */
namespace Pes\Type;

class DbTypeEnum extends Enum {    
    const MySQL = 'mysql';
    const MSSQL = 'sqlsrv';
}
