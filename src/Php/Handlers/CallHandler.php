<?php
declare(strict_types=1);

namespace Ueef\Phigeon\Php\Handlers;

use Ueef\Phigeon\Interfaces\LoaderInterface;
use Ueef\Phigeon\Parts\CompositePart;
use Ueef\Phigeon\Php\Parts\FuncCallPart;
use Ueef\Phigeon\Php\Parts\FuncDefinitionPart;
use Ueef\Phigeon\Interfaces\PartInterface;
use Ueef\Phigeon\Interfaces\ParserInterface;
use Ueef\Phigeon\Interfaces\HandlerInterface;

class CallHandler implements HandlerInterface
{
    /** @var LoaderInterface */
    private $loader;

    /** @var ParserInterface */
    private $parser;

    /** @var string[] */
    private $defined = [];


    public function __construct(LoaderInterface $loader, ParserInterface $parser)
    {
        $this->loader = $loader;
        $this->parser = $parser;
    }

    public function handle(array $arguments = []): PartInterface
    {
        return $this->parse(...$arguments);
    }

    private function parse(string $path, array $args = [], array $uses = [])
    {
        $name = 'php' . md5($path);

        $part = new FuncCallPart($name, $args, $uses);
        if (!in_array($name, $this->defined)) {
            $this->defined[] = $name;
            $part = new CompositePart([
                new FuncDefinitionPart($name, $this->parser->parse($this->loader->load($path))),
                $part
            ]);
        }

        return $part;
    }
}