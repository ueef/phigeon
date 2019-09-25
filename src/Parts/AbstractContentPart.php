<?php
declare(strict_types=1);

namespace Ueef\Phigeon\Parts;

use Ueef\Phigeon\Interfaces\PartInterface;
use Ueef\Phigeon\Interfaces\ContentPartInterface;

abstract class AbstractContentPart implements PartInterface, ContentPartInterface
{
    /** @var string */
    private $content;


    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }
}