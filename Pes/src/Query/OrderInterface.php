<?php
namespace Pes\Query;

use Pes\Type\OrderingEnum;
/**
 *
 * @author pes2704
 */
interface OrderInterface extends \IteratorAggregate {
    public function addOrdering($attribute, $orderingTypeValue);
    public function getSqlString();
}
