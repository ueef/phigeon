<?php
declare(strict_types=1);

namespace Ueef\Phigeon;

use Ueef\Encoder\Interfaces\EncoderInterface;
use Ueef\Phigeon\Interfaces\PartInterface;
use Ueef\Phigeon\Parts\CompositePart;
use Ueef\Phigeon\Parts\StaticPart;
use Ueef\Phigeon\Parser\Exceptions\UndefinedHandlerParserException;
use Ueef\Phigeon\Parser\Exceptions\UnexpectedEndOfStringParserException;
use Ueef\Phigeon\Interfaces\ParserInterface;
use Ueef\Phigeon\Interfaces\LoaderInterface;
use Ueef\Phigeon\Interfaces\HandlerInterface;

class Parser implements ParserInterface
{
    /** @var LoaderInterface */
    private $loader;

    /** @var EncoderInterface */
    private $encoder;

    /** @var HandlerInterface[] */
    private $handlers;

    /** @var string */
    private $open_tag;

    /** @var string */
    private $close_tag;


    public function __construct(string $openTag, string $closeTag, LoaderInterface $loader, EncoderInterface $encoder, array $handlers)
    {
        $this->loader = $loader;
        $this->encoder = $encoder;
        $this->handlers = $handlers;
        $this->open_tag = $openTag;
        $this->close_tag = $closeTag;
    }

    /**
     * @param string $path
     * @return PartInterface[]
     * @throws UndefinedHandlerParserException
     * @throws UnexpectedEndOfStringParserException
     */
    public function parse(string $path): array
    {
        $content = $this->loader->load($path);

        $parts = [];
        $shift = 0;
        $endShift = strlen($this->close_tag);
        $startShift = strlen($this->open_tag);
        $contentLength = strlen($content);
        while ($shift < $contentLength) {
            $start = strpos($content, $this->open_tag, $shift);
            if (false === $start) {
                $parts[] = new StaticPart(substr($content, $shift));
                break;
            }

            $end = strpos($content, $this->close_tag, $shift);
            if (false === $end) {
                throw new UnexpectedEndOfStringParserException(["unexpected end of string, expected \"%s\"", $this->close_tag]);
            }

            $partContent = '';
            if ($start > $shift) {
                $partContent = substr($content, $shift, $start-$shift);
            }

            $parts[] = new StaticPart($partContent, '', ...$this->handleEntry(substr($content, $start+$startShift, $end-$start-$endShift)));
            $shift = $end + $endShift;
        }

        return $parts;
    }

    /**
     * @param string $entry
     * @return PartInterface[]
     * @throws UndefinedHandlerParserException
     */
    private function handleEntry(string $entry): array
    {
        [$handler, $args] = explode(' ', $entry, 2) + ['', ''];

        if ($args) {
            $args = $this->encoder->decode($args);
        }

        if (!is_array($args)) {
            $args = [];
        }

        if (isset($this->handlers[$handler])) {
            return $this->handlers[$handler]->handle($this, $args);
        }

        throw new UndefinedHandlerParserException(["undefined handler \"%s\"", $handler]);
    }
}