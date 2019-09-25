<?php
declare(strict_types=1);

namespace Ueef\Phigeon\Parts;

use Ueef\Phigeon\Interfaces\PartInterface;
use Ueef\Phigeon\Interfaces\HandledPartInterface;

class HandledPart implements PartInterface, HandledPartInterface
{
    /** @var string */
    private $handler;

    /** @var array */
    private $arguments;


    public function __construct(string $handler, array $arguments)
    {
        $this->handler = $handler;
        $this->arguments = $arguments;
    }

    public function getHandler(): string
    {
        return $this->handler;
    }

    public function getArguments(): array
    {
        return $this->arguments;
    }
}