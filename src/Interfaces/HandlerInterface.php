<?php
declare(strict_types=1);

namespace Ueef\Phigeon\Interfaces;

interface HandlerInterface
{
    /**
     * @param array $parameters
     * @return PartInterface[]
     */
    public function handle(ParserInterface $parser, array $parameters = []): array;
}