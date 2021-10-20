<?php

namespace App\Service\File;

use App\Entity\File;
use Intervention\Image\Constraint;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Intervention\Image\ImageManager as InterventionImageManager;

class ImageManager extends InterventionImageManager
{
    private array $encodeAbleExtensions = ['jpg', 'jpeg', 'png', 'webp'];

    public function __construct(private string $targetDirectory, private Filesystem $fileSystem)
    {
        parent::__construct();
    }

    /** @throws \Exception */
    public function resize(File $file, int|null $width = null, int|null $height = null, bool $aspectRatio = true, bool $upsize = false, string $extension = 'webp'): string
    {
        if (!$this->isEncodeAbleExtension($extension)) {
            throw new \Exception(sprintf('Extension %s is not allowed to encode. Encode able extensions are: %s', $extension, implode(', ', $this->encodeAbleExtensions)));
        }

        $filePath = $this->targetDirectory . '/' . $file->getPath();

        if (!$this->fileSystem->exists($filePath)) {
            throw new IOException(sprintf('File not exist "%s": ', $file->getOriginalName()));
        }

        $manipulatedFileSavePath = $this->targetDirectory . '/t/' . $file->getManipulatedFileSavePath($extension, $width, $height);

        if ($this->fileSystem->exists($manipulatedFileSavePath)) {
            return $manipulatedFileSavePath;
        }

        $this
            ->make($filePath)
            ->encode($extension)
            ->resize($width, $height, function (Constraint $constraint) use ($aspectRatio, $upsize) {
                if ($aspectRatio) $constraint->aspectRatio();
                if ($upsize) $constraint->upsize();
            })
            ->save($manipulatedFileSavePath);

        return $manipulatedFileSavePath;
    }

    private function isEncodeAbleExtension(string $extension): bool
    {
        return in_array($extension, $this->encodeAbleExtensions);
    }
}