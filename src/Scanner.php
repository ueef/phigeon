<?php
declare(strict_types=1);

namespace Ueef\Phigeon;

class Scanner
{
    /** @var string[] */
    private $dirs = [];


    public function __construct(array $dirs)
    {
        $this->dirs = $dirs;

        foreach ($this->dirs as &$dir) {
            $dir = $this->correctPath($dir);
        }
    }

    public function scan(): array
    {
        $files = [];
        foreach ($this->dirs as $dir) {
            $dir = $this->correctPath($dir);

            $prefixLength = strlen($dir);
            foreach ($this->scanDir($dir) as $path) {
                $files[substr($path, $prefixLength)] = $path;
            }
        }

        return $files;
    }

    private function scanDir(string $dir, array &$files = []): array
    {
        foreach (array_diff(scandir($dir), ['.', '..']) as $filename) {
            $path = $dir . '/' . $filename;

            if (is_dir($path)) {
                $this->scanDir($path, $files);
            } else {
                $files[] = $path;
            }
        }

        return $files;
    }

    private function correctPath($path)
    {
        return rtrim($path, '/');
    }
}