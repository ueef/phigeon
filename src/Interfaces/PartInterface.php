<?php
declare(strict_types=1);

namespace Ueef\Phigeon\Interfaces;

interface PartInterface
{
    /**
     * @return PartInterface[]
     */
    public function getParts(): array;

    /**
     * @param PartInterface[] $parts
     */
    public function setParts(array $parts): void;

    public function getContent(): string;

    public function getContentAfter(): string;
    public function setContentAfter(string $content): void;

    public function getContentBefore(): string;
    public function setContentBefore(string $content): void;
}