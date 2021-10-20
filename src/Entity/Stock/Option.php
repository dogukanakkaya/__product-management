<?php

namespace App\Entity\Stock;

use App\Repository\Stock\OptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OptionRepository::class)]
class Option
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\OneToMany(mappedBy: 'option', targetEntity: OptionValue::class, cascade: ['persist'])]
    private Collection|array $values;

    public function __construct()
    {
        $this->values = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getValues(): Collection|array
    {
        return $this->values;
    }

    public function addValue(OptionValue $optionValue): self
    {
        if (!$this->values->contains($optionValue)) {
            $this->values[] = $optionValue;
            $optionValue->setOption($this);
        }

        return $this;
    }

    public function removeValue(OptionValue $optionValue): self
    {
        if ($this->values->removeElement($optionValue)) {
            // set the owning side to null (unless already changed)
            if ($optionValue->getOption() === $this) {
                $optionValue->setOption(null);
            }
        }

        return $this;
    }
}
