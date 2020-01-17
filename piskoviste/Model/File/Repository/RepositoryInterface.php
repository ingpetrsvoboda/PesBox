<?php
namespace Tester\Model\File\Repository;

/**
 *
 * @author vlse2610
 */
interface RepositoryInterface {
    public function find($nazevSady);
    public function get($id, $nazevSady);
}
