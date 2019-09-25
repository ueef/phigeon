<?php
declare(strict_types=1);

namespace Ueef\Phigeon\Handlers;

use Ueef\Phigeon\Interfaces\LoaderInterface;
use Ueef\Phigeon\Parts\CompositePart;
use Ueef\Phigeon\Interfaces\PartInterface;
use Ueef\Phigeon\Interfaces\ParserInterface;
use Ueef\Phigeon\Interfaces\HandlerInterface;

class IncludeHandler implements HandlerInterface
{
    /** @var LoaderInterface */
    private $loader;

    /** @var ParserInterface */
    private $parser;


    public function __construct(LoaderInterface $loader, ParserInterface $parser)
    {
        $this->loader = $loader;
        $this->parser = $parser;
    }

    public function handle(array $arguments = []): PartInterface
    {
        $parts = [];
        foreach ($arguments as $path) {
            $parts = array_merge($parts, $this->parser->parse($this->loader->load($path)));
        }

        return new CompositePart($parts);
    }
}