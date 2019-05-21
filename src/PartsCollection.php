<?php
declare(strict_types=1);

namespace Ueef\Phigeon\Parts;

use Ueef\Phigeon\Interfaces\PartInterface;
use Ueef\Phigeon\Interfaces\PartsCollectionInterface;

class PartsCollection implements PartsCollectionInterface
{
    /** @var PartInterface[] */
    private $parts = [];


    public function add(PartInterface ...$parts): void
    {
        // TODO: Implement add() method.
    }

    public function push(PartInterface ...$parts): void
    {
        // TODO: Implement push() method.
    }

    public function shift(PartInterface ...$parts): void
    {
        // TODO: Implement shift() method.
    }

    public function current(): PartInterface
    {
        // TODO: Implement current() method.
    }

    public function key()
    {
        // TODO: Implement key() method.
    }

    public function next()
    {
        // TODO: Implement next() method.
    }

    public function rewind()
    {
        // TODO: Implement rewind() method.
    }

    public function valid()
    {
        // TODO: Implement valid() method.
    }
}