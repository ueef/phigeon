<?php
declare(strict_types=1);

namespace Ueef\Phigeon\Php\Parts;

use Ueef\Phigeon\Parts\AbstractContentPart;
use Ueef\Phigeon\Php\Exceptions\UnsupportedTypeOfArgumentException;

class FuncCallPart extends AbstractContentPart
{
    public function __construct(string $name, array $args = [], array $uses = [])
    {
        $this->setContent($this->makeContent($name, $args, $uses));
    }

    private function makeContent(string $name, array $args, array $uses): string
    {
        return '<?=' . $name . '(' . $this->makeArgs($args, $uses) . ')?>' . "\n";
    }

    private function makeArgs(array $args = [], array $uses = [])
    {
        foreach ($args as $key => &$arg) {
            $arg = sprintf("'%s' => %s", $key, $this->makeArg($arg));
        }

        foreach ($uses as $key => $use) {
            if (isset($args[$key])) {
                continue;
            }
            $args[$key] = sprintf("'%s' => \$%s", $key, $use);
        }

        return '[' . implode(',', $args) . ']';
    }

    private function makeArg($arg)
    {
        switch (gettype($arg)) {
            case 'array':
                return $this->makeArgs($arg);
                break;

            case 'string':
                return sprintf("'%s'", str_replace("'", "\'", $arg));
                break;

            case 'double':
            case 'integer':
                return $arg;
                break;

            case 'boolean':
                return $arg ? 'true' : 'false';
            default:
                throw new UnsupportedTypeOfArgumentException('unsupported type of argument');
        }
    }
}