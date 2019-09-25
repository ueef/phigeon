<?php
declare(strict_types=1);

namespace Ueef\Phigeon\Interfaces;

interface ContentPartInterface
{
    public function getContent(): string;
    public function setContent(string $content): void;
}