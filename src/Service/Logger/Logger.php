<?php

namespace App\Service\Logger;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;

class Logger
{

    const SEPARATOR = ',';
    const LOG_FILE = '/logs/meal.log';

    private string $projectDir;

    public function __construct(
        private readonly Filesystem $filesystem,
        private readonly KernelInterface $appKernel
    )
    {
        $this->projectDir = $this->appKernel->getProjectDir();
    }

    public function log(string $id): void
    {
        if (!$this->filesystem->exists($this->projectDir . self::LOG_FILE)) {
            $this->filesystem->dumpFile($this->projectDir . self::LOG_FILE, $id . self::SEPARATOR);
        }
        else {
            $this->filesystem->appendToFile($this->projectDir . self::LOG_FILE, $id . self::SEPARATOR);
        }
    }

    public function getLogAsArray(): array
    {
        return explode(',', $this->read());
    }

    private function read(): string
    {
        if ($this->filesystem->exists($this->projectDir . self::LOG_FILE)) {
            $file = file_get_contents($this->projectDir . self::LOG_FILE);
        }

        return $file ?? '';
    }

}