<?php
declare(strict_types=1);

namespace Ueef\Phigeon\Php\Parts;

use Ueef\Phigeon\Interfaces\PartInterface;
use Ueef\Phigeon\Parts\AbstractCompositePart;

class FuncDefinitionPart extends AbstractCompositePart
{
    /**
     * @param string $name
     * @param PartInterface[] $parts
     */
    public function __construct(string $name, array $parts = [])
    {
        $this->setParts($parts);
        $this->setContentAfter($this->makeContentAfter());
        $this->setContentBefore($this->makeContentBefore($name));
    }

    private function makeContentAfter(): string
    {
        return "<?php return ob_get_clean();}?>\n";
    }

    private function makeContentBefore(string $name): string
    {
        return "<?php function {$name}(array \$args = []): string {extract(\$args, EXTR_OVERWRITE | EXTR_REFS); ob_start(null, 0, PHP_OUTPUT_HANDLER_CLEANABLE);?>\n";
    }


}