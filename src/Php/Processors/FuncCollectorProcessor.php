<?php
declare(strict_types=1);

namespace Ueef\Phigeon\Php\Processors;

use Ueef\Phigeon\Php\Parts\FuncDefinitionPart;
use Ueef\Phigeon\Interfaces\PartInterface;
use Ueef\Phigeon\Interfaces\ProcessorInterface;
use Ueef\Phigeon\Interfaces\CompositePartInterface;

class FuncCollectorProcessor implements ProcessorInterface
{
    /**
     * @param PartInterface[] $parts
     * @return PartInterface[]
     */
    public function process(array $parts): array
    {
        $defParts = [];
        $parts = $this->collectRecursive($parts, $defParts);

        return array_merge($defParts, $parts);
    }

    /**
     * @param PartInterface[] $parts
     * @param PartInterface[] $collected
     * @return PartInterface[]
     */
    public function collectRecursive(array $parts, ?array &$collected = null): array
    {
        if (null === $collected) {
            $collected = [];
        }

        $_parts = [];
        foreach ($parts as $part) {
            if ($part instanceof FuncDefinitionPart) {
                $collected[] = $part;
            } else {
                if ($part instanceof CompositePartInterface) {
                    $part->setParts($this->collectRecursive($part->getParts(), $collected));
                }
                $_parts[] = $part;
            }
        }

        return $_parts;
    }
}