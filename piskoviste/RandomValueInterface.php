<?php
/**
 *
 * Upraveno z Aura for PHP.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 *
 */
namespace Pes\Session;

/**
 *
 * Interface for generating cryptographically-secure random values.
 *
 */
interface RandomValueInterface
{
    /**
     *
     * Returns a cryptographically secure random value.
     *
     * @return string
     *
     */
    public function generate();
}
