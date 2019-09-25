<?php
declare(strict_types=1);

namespace Ueef\Phigeon;

use Ueef\Phigeon\Interfaces\PartInterface;
use Ueef\Phigeon\Interfaces\ProcessorsInterface;

class Processors implements ProcessorsInterface
{
    /** @var ProcessorsInterface[] */
    private $processors;


    /**
     * @param ProcessorsInterface[] $processors
     */
    public function __construct(array $processors)
    {
        $this->processors = $processors;
    }

    /**
     * @param PartInterface[] $parts
     * @return PartInterface[]
     */
    public function process(array $parts): array
    {
        foreach ($this->processors as $processor) {
            $parts = $processor->process($parts);
        }

        return $parts;
    }
}