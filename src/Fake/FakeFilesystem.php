<?php

namespace SpipRemix\Component\Sdk\Fake;

use Psr\Clock\ClockInterface;
use Spip\Component\Filesystem\FilesystemInterface;
use Symfony\Component\Lock\LockFactory;
use Symfony\Component\Lock\Store\FlockStore;

/**
 * Simulateur de Filesystem.
 *
 * Pour faire des Tests Unitaires avec un système de fichiers virtuel
 */
class FakeFileSystem implements FilesystemInterface
{
    private ?ClockInterface $clock;

    /**
     * Exemple:
     *
     * [
     *      [
     *          'filename' => 'IMG/txt/doc.txt',
     *          'content' => 'contenu',
     *      ],
     *      [
     *          'filename' => 'local/css',
     *          'content' => null,
     *      ],
     *      [
     *          'filename' => 'config/connect.php',
     *          'content' => '...',
     *          'writeable' => false,
     *      ],
     *      ...
     * ]
     */
    public function __construct(
        /** @var FakeArrayFile[] $files */
        private array $files = [['filename' => '/']],
        ?ClockInterface $clock = null,
    ) {
        $this->clock = $clock ?? new class () implements ClockInterface {
            public function now(): \DateTimeImmutable
            {
                return new \DateTimeImmutable('now');
            }
        };
        $this->files = \array_map(fn($file) => $this->newFile($file), $files);
    }

    /**
     * @return FakeArrayFile[]
     */
    public function getFiles(): array
    {
        return $this->files;
    }

    /**
     * @param FakeArrayFile $file
     *
     * @return FakeArrayFile
     */
    private function newFile(array $file): array
    {
        if (!isset($file['time'])) {
            $file['time'] = $this->clock?->now()->format('U') ?? 1;
        }
        if (!isset($file['atime'])) {
            $file['atime'] = $file['time'];
        }

        return [
            'filename' => $file['filename'],
            'content' => $file['content'] ?? null,
            'time' => (int) $file['time'],
            'atime' => (int) $file['atime'],
            'writeable' => $file['writeable'] ?? true,
        ];
    }

    public function remove(string|iterable $files): void
    {
        if (\is_string($files)) {
            $files = [$files];
        }

        /** @var FakeArrayFile[] $files */
        $this->files = \array_filter($this->files, function (array $file) use ($files) {
            return !\in_array($file['filename'], $files);
        });
    }

    public function rename(string $origin, string $target, bool $overwrite = false): void
    {
        if (!empty($target)) {
            $origin = $this->findByFilename($origin);
            if (\is_array($origin)) {
                $this->files = \array_map(function (array $file) use ($origin, $target) {
                    if ($file['filename'] == $origin['filename']) {
                        $file['filename'] = $target;
                    }

                    return $file;
                }, $this->files);
            }
        }
    }

    public function mkdir(string|iterable $dirs, int $mode = 0777): void
    {
        if (is_string($dirs)) {
            $dirs = [$dirs];
        }

        /** @var non-empty-string[] $fsdirs */
        $fsdirs = \array_unique(\array_map(function (array $file) {
            return \dirname($file['filename']);
        }, $this->files));
        $this->files = \array_merge($this->files, \array_map(function (string $dir) {
            if (!empty($dir)) {
                $time = (int) ($this->clock?->now()->format('U') ?? 1);
                return ['filename' => $dir, 'content' => null, 'time' => $time, 'atime' => $time];
            }
        }, \array_diff($dirs, $fsdirs)));
    }

    public function size(string $file): int
    {
        $fsfile = $this->findByFilename($file);

        return (\is_null($fsfile) || !isset($fsfile['content'])) ? 0 : strlen($fsfile['content']);
    }

    public function exists(string|iterable $files): bool
    {
        if (\is_string($files)) {
            $files = [$files];
        }

        $exists = true;
        foreach ($files as $filename) {
            $file = $this->findByFilename($filename);
            $exists = $exists && !is_null($file);
        }

        return $exists;
    }

    public function touch(string|iterable $files, ?int $time = null, ?int $atime = null): void
    {
        if (\is_string($files)) {
            $files = [$files];
        }

        $changed = [];
        foreach ($files as $file) {
            if ($file = $this->findByFilename($file)) {
                $file['time'] = $time ?? $file['time'] ?? (int) ($this->clock?->now()->format('U') ?? 1);
                $file['atime'] = $atime ?? $file['atime'] ?? $file['time'];
                $changed[] = $file;
            }
        }
        $this->files = \array_merge($this->files, $changed);
    }

    public function read(string $file): string
    {
        $fsfile = $this->findByFilename($file);

        return $fsfile ? $fsfile['content'] ?? '' : '';
    }

    public function write(string $file, string $content): bool
    {
        $fsfile = $this->findByFilename($file);
        if (\is_null($fsfile) || (isset($fsfile['writeable']) && $fsfile['writeable'] == false)) {
            return false;
        }

        $fsfile['content'] = $content;
        $fsfile['time'] = $fsfile['atime'] = (int) ($this->clock?->now()->format('U') ?? 1);
        $this->files = \array_map(function ($file) use ($fsfile) {
            if ($file['filename'] == $fsfile['filename']) {
                $file['content'] = $fsfile['content'];
                $file['time'] = $fsfile['time'];
                $file['atime'] = $fsfile['atime'];
            }

            return $file;
        }, $this->files);

        return true;
    }

    public function getLockFactory(): LockFactory
    {
        return new LockFactory(new FlockStore());
    }

    public function mtime(string $file): ?int
    {
        $fsfile = $this->findByFilename($file);
        if ($fsfile) {
            return $fsfile['time'] ?? (int) ($this->clock?->now()->format('U') ?? 1);
        }

        return null;
    }

    /**
     * @return FakeArrayFile|null
     */
    protected function findByFilename(string $filename): ?array
    {
        $fs = \array_filter($this->files, function ($file) use ($filename) {
            return $filename == $file['filename'];
        });

        return \array_shift($fs);
    }
}

class FakeFile
{
    public function __construct(
        /** @var non-empty-string */
        private string $filename,
        private ?string $content = null,
        private int $time = 1,
        private int $atime = 1,
        private bool $writeable = true,
    ) {}

    public function __serialize(): array
    {
        return [
            'filename' => $this->filename,
            'content' => $this->content,
            'time' => $this->time,
            'atime' => $this->atime,
            'writeable' => $this->writeable,
        ];
    }

    /** @param FakeArrayFile $data */
    public function __unserialize(array $data): void
    {
        $this->filename = $data['filename'];
        $this->content = $data['content'] ?? null;
        $this->time = $data['time'] ?? 1;
        $this->atime = $data['atime'] ?? 1;
        $this->writeable = $data['writeable'] ?? true;
    }
}
