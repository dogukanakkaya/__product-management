<?php

namespace App\Schema\DataFilter;

class FileSchema
{
    private string $search = '';
    private int $start = 0;
    private int $maxResult = 20;

    public function getSearch(): string
    {
        return $this->search;
    }

    public function setSearch(string $search): self
    {
        $this->search = $search;

        return $this;
    }

    public function getStart(): int
    {
        return $this->start;
    }

    public function setStart(int $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getMaxResult(): int
    {
        return $this->maxResult;
    }
}