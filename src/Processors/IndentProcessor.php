<?php
declare(strict_types=1);

namespace Ueef\Phigeon\Processors;

use Ueef\Phigeon\Interfaces\ContentPartInterface;
use Ueef\Phigeon\Interfaces\PartInterface;
use Ueef\Phigeon\Interfaces\ProcessorInterface;
use Ueef\Phigeon\Interfaces\CompositePartInterface;

class IndentProcessor implements ProcessorInterface
{
    /**
     * @param PartInterface[] $parts
     * @return PartInterface[]
     */
    public function process(array $parts): array
    {
        return $this->processRecursive($parts);
    }

    /**
     * @param PartInterface[] $parts
     * @return PartInterface[]
     */
    public function processRecursive(array $parts, string $indent = ''): array
    {
        $_indent = '';
        $prev = null;
        foreach ($parts as $part) {
            $this->prependIndentToPart($part, $indent);
            if ($part instanceof CompositePartInterface) {
                $this->processRecursive($part->getParts(), $_indent);
            }

            $_indent = $this->cutIndent($part, $indent);
        }
        return $parts;
    }

    public function cutIndent(PartInterface $part, string $indent): string
    {
        if ($part instanceof ContentPartInterface && preg_match('/([\ \t]+)$/', $part->getContent(), $matches)) {
            $part->setContent(substr($part->getContent(), 0, -strlen($matches[1])));
            return $indent . $matches[1];
        }

        return $indent;
    }

    public function prependIndentToPart(PartInterface $part, string $indent): void
    {
        if ($part instanceof ContentPartInterface) {
            $part->setContent($this->prependIndentToContent($part->getContent(), $indent));
        } elseif ($part instanceof CompositePartInterface) {
            $part->setContentAfter($this->prependIndentToContent($part->getContentAfter(), $indent));
            $part->setContentBefore($this->prependIndentToContent($part->getContentBefore(), $indent));
        }
    }

    public function prependIndentToContent(string $content, string $indent): string
    {
        $content = explode("\n", $content);
        foreach ($content as &$line) {
            if ($line) {
                $line = $indent . $line;
            }
        }

        return implode("\n", $content);
    }
}