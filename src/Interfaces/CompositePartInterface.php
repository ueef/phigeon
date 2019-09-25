<?php
declare(strict_types=1);

namespace Ueef\Phigeon\Interfaces;

interface CompositePartInterface
{
    /**
     * @return PartInterface[]
     */
    public function getParts(): array;
    public function getContentAfter(): string;
    public function getContentBefore(): string;

    /**
     * @param PartInterface[] $parts
     */
    public function setParts(array $parts): void;
    public function setContentAfter(string $contentAfter): void;
    public function setContentBefore(string $contentBefore): void;
}