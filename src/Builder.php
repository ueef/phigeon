<?php
declare(strict_types=1);

namespace Ueef\Phigeon;

use Ueef\Phigeon\Interfaces\PartInterface;
use Ueef\Phigeon\Interfaces\ParserInterface;
use Ueef\Phigeon\Interfaces\HandlersInterface;
use Ueef\Phigeon\Interfaces\ProcessorsInterface;
use Ueef\Phigeon\Interfaces\ContentPartInterface;
use Ueef\Phigeon\Interfaces\HandledPartInterface;
use Ueef\Phigeon\Interfaces\CompositePartInterface;

class Builder
{
    /** @var ParserInterface */
    private $parser;

    /** @var HandlersInterface */
    private $handlers;

    /** @var ProcessorsInterface */
    private $processors;


    public function __construct(ParserInterface $parser, HandlersInterface $handlers, ProcessorsInterface $processors)
    {
        $this->parser = $parser;
        $this->handlers = $handlers;
        $this->processors = $processors;
    }

    public function build(string $content): string
    {
        $parts = $this->parser->parse($content);
        $parts = $this->handleParts($parts);
        $parts = $this->processors->process($parts);

        return $this->assembleParts($parts);
    }

    /**
     * @param PartInterface[] $parts
     * @return PartInterface[]
     */
    private function handleParts(array $parts): array
    {
        foreach ($parts as &$part) {
            if ($part instanceof HandledPartInterface) {
                $part = $this->handlers->handle($part);
            }

            if ($part instanceof CompositePartInterface) {
                $part->setParts($this->handleParts($part->getParts()));
            }
        }

        return $parts;
    }

    /**
     * @param PartInterface[] $parts
     * @return string
     */
    private function assembleParts(array $parts): string
    {
        $content = '';
        foreach ($parts as $part) {
            if ($part instanceof ContentPartInterface) {
                $content .= $part->getContent();
            } elseif ($part instanceof CompositePartInterface) {
                $content .= $part->getContentBefore() . $this->assembleParts($part->getParts()) . $part->getContentAfter();
            }
        }

        return $content;
    }
}