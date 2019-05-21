<?php
declare(strict_types=1);

namespace Ueef\Phigeon\Interfaces;

interface ProcessorInterface
{
    /**
     * @param PartInterface[] $parts
     * @return PartInterface[]
     */
    public function process(array $parts): array;
}