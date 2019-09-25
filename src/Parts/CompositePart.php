<?php
declare(strict_types=1);

namespace Ueef\Phigeon\Parts;

use Ueef\Phigeon\Interfaces\PartInterface;

class CompositePart extends AbstractCompositePart
{
    /**
     * @param PartInterface[] $parts
     * @param string $contentAfter
     * @param string $contentBefore
     */
    public function __construct(array $parts, string $contentAfter = '', string $contentBefore = '')
    {
        $this->setParts($parts);
        $this->setContentAfter($contentAfter);
        $this->setContentBefore($contentBefore);
    }
}