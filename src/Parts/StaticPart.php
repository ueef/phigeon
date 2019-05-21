<?php
declare(strict_types=1);

namespace Ueef\Phigeon\Parts;

use Ueef\Phigeon\Interfaces\PartInterface;

class StaticPart extends AbstractPart
{
    public function __construct(string $contentBefore = '', string $contentAfter = '', PartInterface ...$parts)
    {
        $this->setParts($parts);
        $this->setContentAfter($contentAfter);
        $this->setContentBefore($contentBefore);
    }
}