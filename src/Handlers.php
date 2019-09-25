<?php
declare(strict_types=1);

namespace Ueef\Phigeon;

use Ueef\Phigeon\Interfaces\PartInterface;
use Ueef\Phigeon\Interfaces\HandlerInterface;
use Ueef\Phigeon\Interfaces\HandlersInterface;
use Ueef\Phigeon\Interfaces\HandledPartInterface;

class Handlers implements HandlersInterface
{
    private $handlers = [];

    /**
     * @param HandlerInterface[] $handlers
     */
    public function __construct(array $handlers)
    {
        $this->handlers = $handlers;
    }

    public function handle(HandledPartInterface $part): PartInterface
    {
        if (!isset($this->handlers[$part->getHandler()])) {
            throw new \Exception('Undefined handler ' . $part->getHandler());
        }

        return $this->handlers[$part->getHandler()]->handle($part->getArguments());
    }
}