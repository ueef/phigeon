<?php
declare(strict_types=1);

namespace Ueef\Phigeon\Php\Handlers;

use Ueef\Phigeon\Php\Parts\FuncCallPart;
use Ueef\Phigeon\Php\Parts\FuncDefinitionPart;
use Ueef\Phigeon\Interfaces\ParserInterface;
use Ueef\Phigeon\Interfaces\HandlerInterface;

class CallHandler implements HandlerInterface
{
    /** @var string[] */
    private $defined = [];


    public function handle(ParserInterface $parser, array $parameters = []): array
    {
        return $this->parse($parser, ...$parameters);
    }

    private function parse(ParserInterface $parser, string $path, array $args = [], array $uses = [])
    {
        $name = $this->makeFunctionName($path);

        $parts = [];
        if (!in_array($name, $this->defined)) {
            $this->defined[] = $name;
            $parts[] = new FuncDefinitionPart($name, ...$parser->parse($path));
        }
        $parts[] = new FuncCallPart($name, $args, $uses);

        return $parts;
    }

    private function makeFunctionName(string $path): string
    {
        return 'php_func_' . md5($path);
    }
}