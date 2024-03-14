<?php

namespace SpipRemix\Component\Sdk\Fake;

use Psr\Clock\ClockInterface;
use Spip\Component\Filesystem\FilesystemInterface;
use Symfony\Component\Lock\LockFactory;
use Symfony\Component\Lock\Store\FlockStore;

/**
 * Undocumented class.
 * 
 * @todo fork to spip-remix/filesystem
 */
class FakeFileSystem implements FilesystemInterface
{
    private ?ClockInterface $clock;

    /**
     * @param list<array{filename:string,?content:string,?time:int,?atime:int,?writeable:bool}> $files Liste de fichiers simulés.
     * 
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
        private array $files = [],
        ?ClockInterface $clock = null,
    ) {
        $this->clock = $clock ?? new class implements ClockInterface {
            public function now(): \DateTimeImmutable
            {
                return new \DateTimeImmutable('now');
            }
        };
        $this->files = \array_map(fn ($file) => $this->newFile($file), $files);
    }

    /**
     * @return list<array{filename:string,content:?string,time:int,atime:int}>
     */
    public function getFiles(): array
    {
        return $this->files;
    }

    public function newFile(array $file): array
    {
        if (!isset($file['time'])) {
            $file['time'] = $this->clock->now()->format('U');
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

        $this->files = \array_filter($this->files, function (array $file) use ($files) {
            return !\in_array($file['filename'], $files);
        });
    }

    public function rename(string $origin, string $target, bool $overwrite = false): void
    {
        $origin = $this->findByFilename($origin);
        if (\is_array($origin)) {
            $this->files = \array_map(function (array $file) use($origin, $target) {
                if ($file['filename'] == $origin['filename']) {
                    $file['filename'] = $target;
                }

                return $file;
            }, $this->files);
        }
    }

    public function mkdir(string|iterable $dirs, int $mode = 0777): void
    {
        if (is_string($dirs)) {
            $dirs = [$dirs];
        }

        $fsdirs = \array_unique(\array_map(function (array $file) {
            return \dirname($file['filename']);;
        }, $this->files));
        $this->files = \array_merge($this->files, \array_map(function (string $dir) {
            $time = (int) $this->clock->now()->format('U');
            return ['filename' => $dir, 'content' => null, 'time' => $time, 'atime' => $time];
        }, \array_diff($dirs, $fsdirs)));
    }

    public function size(string $file): int
    {
        $file = $this->findByFilename($file);

        return \is_null($file) || $file['content'] === null ? 0 : strlen($file['content']);
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
                $file['time'] = $time ?? $file['time'];
                $file['atime'] = $atime ?? $file['atime'];
                $changed[] = $file;
            }
        }
        $this->files = \array_merge($this->files, $changed);
    }

    public function read(string $file): string
    {
        $fsfile = $this->findByFilename($file);
        return $this->exists($file) ? $fsfile['content'] : '';
    }

    public function write(string $file, string $content): bool
    {
        $file = $this->findByFilename($file);
        if ($file && $file['writeable'] == false) {
            return false;
        }

        $file['content'] = $content;
        $file['time'] = $file['atime'] = (int) $this->clock->now()->format('U');
        $this->files = \array_map(function (array $fsfile) use ($file) {
            if ($fsfile['filename'] == $file['filename']) {
                $fsfile['content'] = $file['content'];
                $fsfile['time'] = $file['time'];
                $fsfile['atime'] = $file['atime'];
            }

            return $fsfile;
        }, $this->files);

        return true;
    }

    public function getLockFactory(): LockFactory
    {
        return new LockFactory(new FlockStore());
    }

    public function mtime(string $file): ?int
    {
        if ($file = $this->findByFilename($file)) {
            return $file['time'];
        }

        return null;
    }

    /**
     * @return array{filename:string,content:?string,time:int,atime:int,wrtieable:bool}|null
     */
    protected function findByFilename(string $filename): ?array
    {
        $fs = \array_filter($this->files, function ($file) use ($filename) {
            return $filename == $file['filename'];
        });

        return \array_shift($fs);
    }
}
