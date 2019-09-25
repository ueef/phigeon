<?php
declare(strict_types=1);

namespace Ueef\Phigeon\Interfaces;

interface HandlerInterface
{
    public function handle(array $arguments = []): PartInterface;
}