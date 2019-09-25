<?php
declare(strict_types=1);

namespace Ueef\Phigeon\Interfaces;

interface LoaderInterface
{
    public function load(string $path): string;
}