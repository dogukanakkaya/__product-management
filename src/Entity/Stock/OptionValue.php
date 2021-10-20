<?php

namespace App\Entity\Stock;

use App\Repository\Stock\OptionValueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OptionValueRepository::class)]
class OptionValue
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: 'integer')]
    private int $id;

    #[
        ORM\ManyToOne(targetEntity: Option::class, inversedBy: 'optionValues'),
        ORM\JoinColumn(nullable: false)
    ]
    private Option $option;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    public function getId(): int
    {
        return $this->id;
    }

    public function getOption(): Option
    {
        return $this->option;
    }

    public function setOption(Option $option): self
    {
        $this->option = $option;

        return $this;
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
}
