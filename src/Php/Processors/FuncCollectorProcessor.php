<?php
declare(strict_types=1);

namespace Ueef\Phigeon\Php\Processors;

use Ueef\Phigeon\Interfaces\PartInterface;
use Ueef\Phigeon\Interfaces\ProcessorInterface;
use Ueef\Phigeon\Php\Parts\FuncDefinitionPart;

class FuncCollectorProcessor implements ProcessorInterface
{
    public function process(array $parts): array
    {
        $definitions = [];
        $parts = $this->collectRecursive($parts, $definitions);

        return array_merge($definitions, $parts);
    }

    /**
     * @param PartInterface[] $parts
     * @param PartInterface[] $definitions
     * @return PartInterface[]
     */
    public function collectRecursive(array $parts, array &$definitions): array
    {
        $_parts = [];
        foreach ($parts as $part) {
            if ($part instanceof FuncDefinitionPart) {
                $definitions[] = $part;
            } else {
                $_parts[] = $part;
            }

            $part->setParts($this->collectRecursive($part->getParts(), $definitions));
        }

        return $_parts;
    }
}