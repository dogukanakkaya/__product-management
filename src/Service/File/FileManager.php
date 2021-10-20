<?php

namespace App\Service\File;

use App\Entity\File;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileManager
{
    private array $allowedExtensions = ['jpg', 'jpeg', 'png', 'svg', 'gif', 'webp', 'txt', 'csv', 'xlsx', 'docx', 'pdf'];
    private array $thumbnailSizes = [
        'small' => ['width' => 400],
        'medium' => ['width' => 900],
        'large' => ['width' => 1400]
    ]; // todo: create this size thumbs on upload later

    public function __construct(private string $targetDirectory, private EntityManagerInterface $entityManager, private Filesystem $fileSystem) { }

    /** @throws \Exception */
    public function upload(UploadedFile $file, string $subDirectory = null): void
    {
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);

        if (!$this->isExtensionAllowed($extension)) {
            throw new \Exception(sprintf('Extension %s is not allowed. Allowed extensions are: %s', $extension, implode(', ', $this->allowedExtensions)));
        }

        $uniqueName = md5($originalName . uniqid());

        $newFile = (new File())
            ->setOriginalName($originalName)
            ->setUniqueName($uniqueName)
            ->setExtension($extension)
            ->setSize($file->getSize())
            ->setDirectory($subDirectory);

        $this->entityManager->persist($newFile);
        $this->entityManager->flush();

        $file->move($this->targetDirectory . '/' . $subDirectory, $uniqueName . '.' . $extension);
    }

    public function remove(File $file)
    {
        $filePath = $this->targetDirectory . '/' . $file->getPath();

        if (!$this->fileSystem->exists($filePath)) {
            throw new IOException(sprintf('File not exist: "%s": ', $file->getOriginalName()));
        }

        // TODO: also remove all thumbs
        $this->fileSystem->remove($filePath);
    }

    private function isExtensionAllowed(string $extension): bool
    {
        return in_array($extension, $this->allowedExtensions);
    }
}