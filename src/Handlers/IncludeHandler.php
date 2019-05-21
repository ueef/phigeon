<?php
declare(strict_types=1);

namespace Ueef\Phigeon\Handlers;

use Ueef\Phigeon\Interfaces\ParserInterface;
use Ueef\Phigeon\Interfaces\HandlerInterface;

class IncludeHandler implements HandlerInterface
{
    public function handle(ParserInterface $parser, array $parameters = []): array
    {
        $parts = [];
        foreach ($parameters as $parameter) {
            $parts = array_merge($parts, $parser->parse($parameter));
        }

        return $parts;
    }
}