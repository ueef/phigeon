<?php
declare(strict_types=1);

namespace Ueef\Phigeon\Interfaces;

interface ParserInterface
{
    /**
     * @param string $path
     * @return PartInterface[]
     */
    public function parse(string $path): array;
}