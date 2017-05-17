<?php
namespace Pes\Storage\Serializer;
/**
 *
 * @author pes2704
 */
interface SerializerInterface {
    public function serialize($value);
    public function unserialize($value);
}
