<?php
declare(strict_types=1);

namespace Ueef\Phigeon;

use Ueef\Phigeon\Interfaces\LoaderInterface;
use Ueef\Phigeon\Exceptions\CannotResolvePathLoaderException;
use Ueef\Phigeon\Exceptions\CannotReadFileLoaderException;

class Loader implements LoaderInterface
{
    /** @var string[] */
    private $dirs = [];

    /** @var string[] */
    private $suffixes = [];


    public function __construct(array $dirs, array $suffixes = [])
    {
        foreach ($dirs as $dir) {
            $this->dirs[] = $this->correctPath($dir);
        }

        $this->suffixes = $suffixes;
    }

    public function load(string $path): string
    {
        $realpath = $this->resolve($path);
        if (!$realpath){
            throw new CannotResolvePathLoaderException(["cannot resolve path \"%s\"", $path]);
        }

        $result = file_get_contents($realpath);
        if (false === $result) {
            throw new CannotReadFileLoaderException(["cannot read file \"%s\"", $realpath]);
        }

        return $result;
    }

    private function resolve(string $path): string
    {
        $path = $this->correctPath($path);

        foreach ($this->dirs as $dir) {
            foreach ($this->suffixes as $suffix) {
                $resolved = realpath($dir . $path . $suffix);
                if ($resolved) {
                    return $resolved;
                }
            }
        }

        return '';
    }

    private function correctPath(string $path): string
    {
        return preg_replace('/^\/?(.+)\/?$/', '/$1', $path);
    }
}