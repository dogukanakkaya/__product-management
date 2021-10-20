<?php

namespace App\Entity;

use App\Entity\Interface\SingleFieldUpdatableInterface;
use App\Repository\FileRepository;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use Knp\DoctrineBehaviors\Contract\Entity\TimestampableInterface;
use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableTrait;

#[ORM\Entity(repositoryClass: FileRepository::class)]
class File implements \JsonSerializable, TimestampableInterface, SingleFieldUpdatableInterface
{
    use TimestampableTrait;

    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $originalName;

    #[ORM\Column(type: 'string', length: 255)]
    private string $uniqueName;

    #[ORM\Column(type: 'string', length: 25)]
    private string $extension;

    #[ORM\Column(type: 'bigint')]
    private int $size;

    #[ORM\Column(type: 'string', length: 25, nullable: true)]
    private ?string $directory;

    public function getId(): int
    {
        return $this->id;
    }

    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    public function setOriginalName(string $originalName): self
    {
        $this->originalName = $originalName;

        return $this;
    }

    public function getUniqueName(): string
    {
        return $this->uniqueName;
    }

    public function setUniqueName(string $uniqueName): self
    {
        $this->uniqueName = $uniqueName;

        return $this;
    }

    public function getExtension(): string
    {
        return $this->extension;
    }

    public function setExtension(string $extension): self
    {
        $this->extension = $extension;

        return $this;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function setSize(int $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getDirectory(): ?string
    {
        return $this->directory;
    }

    public function setDirectory(?string $directory): self
    {
        $this->directory = $directory;

        return $this;
    }

    #[Pure]
    private function getPathWithoutExtension(): string
    {
        return $this->getDirectory() ? $this->getDirectory() . '/' . $this->getUniqueName() : $this->getUniqueName();
    }

    #[Pure]
    public function getPath(): string
    {
        return ($this->getDirectory() ? $this->getDirectory() . '/' . $this->getUniqueName() : $this->getUniqueName()) . '.' . $this->getExtension();
    }

    #[Pure]
    public function getManipulatedFileSavePath(string $extension, int|null $width = null, int|null $height = null): string
    {
        return $this->getPathWithoutExtension() . "-{$width}x{$height}.{$extension}";
    }

    #[ArrayShape(['id' => "int", 'originalName' => "string", 'path' => "string", 'size' => "int", 'extension' => "string", 'createdAt' => "string"])]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'originalName' => $this->getOriginalName(),
            'path' => $this->getPathWithoutExtension(),
            'size' => $this->getSize(),
            'extension' => $this->getExtension(),
            'createdAt' => $this->getCreatedAt()->format('Y-m-d H:i:s')
        ];
    }

    #[ArrayShape(['originalName' => "array"])]
    public function getUpdatableFields(): array
    {
        return [
            'originalName' => [$this, 'setOriginalName']
        ];
    }
}
