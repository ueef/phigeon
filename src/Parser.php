<?php
declare(strict_types=1);

namespace Ueef\Phigeon;

use Ueef\Phigeon\Parts\ContentPart;
use Ueef\Phigeon\Parts\HandledPart;
use Ueef\Phigeon\Interfaces\PartInterface;
use Ueef\Phigeon\Interfaces\LoaderInterface;
use Ueef\Phigeon\Interfaces\ParserInterface;
use Ueef\Phigeon\Exceptions\UnexpectedEndOfStringParserException;

class Parser implements ParserInterface
{
    /** @var string */
    private $open_tag;

    /** @var string */
    private $close_tag;


    public function __construct(string $openTag, string $closeTag)
    {
        $this->open_tag = $openTag;
        $this->close_tag = $closeTag;
    }

    /**
     * @param string $content
     * @return PartInterface[]
     * @throws UnexpectedEndOfStringParserException
     */
    public function parse(string $content): array
    {
        $parts = [];
        $shift = 0;
        $endShift = strlen($this->close_tag);
        $startShift = strlen($this->open_tag);
        $contentLength = strlen($content);
        while ($shift < $contentLength) {
            $start = strpos($content, $this->open_tag, $shift);
            if (false === $start) {
                $parts[] = new ContentPart(substr($content, $shift));
                break;
            }

            $end = strpos($content, $this->close_tag, $shift);
            if (false === $end) {
                throw new UnexpectedEndOfStringParserException(["unexpected end of string, expected \"%s\"", $this->close_tag]);
            }

            if ($start > $shift) {
                $parts[] = new ContentPart(substr($content, $shift, $start-$shift));
            }

            $handler = substr($content, $start+$startShift, $end-$start-$endShift);
            $handler = explode(' ', $handler, 2);
            if (count($handler) > 1) {
                $parts[] = new HandledPart($handler[0], $this->decodeArguments($handler[1]));
            } else {
                $parts[] = new HandledPart($handler[0], []);
            }

            $shift = $end + $endShift;
        }

        return $parts;
    }

    private function decodeArguments(string $arguments): array
    {
        $arguments = json_decode($arguments, true);
        if (!is_array($arguments)) {
            $arguments = [$arguments];
        }

        return $arguments;
    }
}