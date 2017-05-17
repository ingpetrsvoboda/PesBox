<?php
/**
 *
 * @author pes2704
 */
namespace Pes\Repository;

interface MapRepositoryInterface extends \Countable, \IteratorAggregate
{
    function get($index);
    function set($index, $value);
    function remove($index);
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
