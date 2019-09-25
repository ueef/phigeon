<?php
declare(strict_types=1);

namespace Ueef\Phigeon\Interfaces;

interface ParserInterface
{
    /**
     * @param string $content
     * @return PartInterface[]
     */
    public function parse(string $content): array;
}