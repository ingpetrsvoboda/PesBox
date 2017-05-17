<?php

namespace Pes\Collection;

/**
 *
 * @author pes2704
 */
interface CollectionInterface extends \Countable, \IteratorAggregate {
    public function sort(callable $callback);
    public  function getArrayCopy();
    public function mergeArrayContent(array $newArray=NULL);
}
//interface Collection extends Countable, IteratorAggregate, ArrayAccess
//{
//    function add($element);
//
//    function get($key);
//
//    function contains($element);
//
//    function remove($element);
//
//    function clear();
//
//    function toArray();
//
//    function count();
//
//    function filter(Expr $predicate);
//
//    function sort($field, $direction = 'ASC');
//
//    function slice($offset, $length = null);
//
//    function map(Closure $function);
//}