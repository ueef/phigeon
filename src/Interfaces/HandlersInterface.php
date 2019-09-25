<?php
declare(strict_types=1);

namespace Ueef\Phigeon\Interfaces;

interface HandlersInterface
{
    public function handle(HandledPartInterface $part): PartInterface;
}