<?php
namespace Pes\Collection;

use Pes\Criteria\CriteriaInterface;
/**
 *
 * @author pes2704
 */
interface FindableCollectionInterface {
    function find(CriteriaInterface $criteria);
}
