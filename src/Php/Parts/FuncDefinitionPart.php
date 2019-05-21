<?php
declare(strict_types=1);

namespace Ueef\Phigeon\Php\Parts;

use Ueef\Phigeon\Interfaces\PartInterface;
use Ueef\Phigeon\Parts\AbstractPart;

class FuncDefinitionPart extends AbstractPart
{
    /** @var string */
    private $name = '';

    public function __construct(string $name, PartInterface ...$parts)
    {
        $this->setName($name);
        $this->setParts($parts);
        $this->setContentAfter($this->makeContentAfter());
        $this->setContentBefore($this->makeContentBefore());
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    private function makeContentAfter(): string
    {
        return '<?php return ob_get_clean();}?>' . "\n";
    }

    private function makeContentBefore(): string
    {
        return '<?php function ' . $this->name . '(array $args = []) {extract($args, EXTR_OVERWRITE | EXTR_REFS); ob_start(null, 0, PHP_OUTPUT_HANDLER_CLEANABLE)?>' . "\n";
    }


}