<?php
/**
 *
 * @author pes2704
 */
namespace Pes\Collection;

use Pes\Entity\Persistable\PersistableEntityInterface;
use Pes\Entity\Persistable\IdentityInterface;

interface EntityCollectionInterface extends CollectionInterface {    
    public function getByIdentity(IdentityInterface $identity);
    public function set(PersistableEntityInterface $entity);
    public function removeByIdentity(IdentityInterface $identity);
}
