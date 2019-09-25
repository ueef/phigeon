<?php
declare(strict_types=1);

namespace Ueef\Phigeon\Interfaces;

interface HandledPartInterface
{
    public function getHandler(): string;
    public function getArguments(): array;
}