<?php
declare(strict_types=1);

namespace Ueef\Phigeon\Parts;

class ContentPart extends AbstractContentPart
{
    public function __construct(string $content)
    {
        $this->setContent($content);
    }
}