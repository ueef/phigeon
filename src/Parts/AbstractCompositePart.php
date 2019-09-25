<?php
declare(strict_types=1);

namespace Ueef\Phigeon\Parts;

use Ueef\Phigeon\Interfaces\PartInterface;
use Ueef\Phigeon\Interfaces\CompositePartInterface;

class AbstractCompositePart implements PartInterface, CompositePartInterface
{
    /** @var PartInterface[] */
    private $parts = [];

    /** @var string */
    private $content_after = '';

    /** @var string */
    private $content_before = '';


    /**
     * @return PartInterface[]
     */
    public function getParts(): array
    {
        return $this->parts;
    }

    public function getContentAfter(): string
    {
        return $this->content_after;
    }

    public function getContentBefore(): string
    {
        return $this->content_before;
    }

    /**
     * @param PartInterface[] $parts
     */
    public function setParts(array $parts): void
    {
        $this->parts = $parts;
    }

    public function setContentAfter(string $contentAfter): void
    {
        $this->content_after = $contentAfter;
    }

    public function setContentBefore(string $contentBefore): void
    {
        $this->content_before = $contentBefore;
    }
}