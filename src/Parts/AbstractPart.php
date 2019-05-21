<?php
declare(strict_types=1);

namespace Ueef\Phigeon\Parts;

use Ueef\Phigeon\Interfaces\PartInterface;

class AbstractPart implements PartInterface
{
    /** @var PartInterface[] */
    private $parts = [];

    /** @var string */
    private $content_after = '';

    /** @var string */
    private $content_before = '';


    public function getContent(): string
    {
        $content = '';
        foreach ($this->parts as $part) {
            $content .= $part->getContent();
        }

        return $this->getContentBefore() . $content . $this->getContentAfter();
    }

    /**
     * @return PartInterface[]
     */
    public function getParts(): array
    {
        return $this->parts;
    }

    /**
     * @param PartInterface[] $parts
     */
    public function setParts(array $parts): void
    {
        $this->parts = $parts;
    }

    public function getContentAfter(): string
    {
        return $this->content_after;
    }

    public function setContentAfter(string $content): void
    {
        $this->content_after = $content;
    }

    public function getContentBefore(): string
    {
        return $this->content_before;
    }

    public function setContentBefore(string $content): void
    {
        $this->content_before = $content;
    }
}