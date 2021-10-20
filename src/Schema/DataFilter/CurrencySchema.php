<?php

namespace App\Schema\DataFilter;

class CurrencySchema
{
    private string $search = '';
    private int $perPage = 10;
    private string $orderByField = 'createdAt';
    private string $orderByDirection = 'DESC';
    private int $page = 1;

    public function getSearch(): string
    {
        return $this->search;
    }

    public function setSearch(string $search): self
    {
        $this->search = $search;

        return $this;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function setPerPage(int $perPage): self
    {
        $this->perPage = $perPage;

        return $this;
    }

    public function getOrderByField(): string
    {
        return $this->orderByField;
    }

    public function setOrderByField(string $orderByField): self
    {
        $this->orderByField = $orderByField;

        return $this;
    }

    public function getOrderByDirection(): string
    {
        return $this->orderByDirection;
    }

    public function setOrderByDirection(string $orderByDirection): self
    {
        if (!in_array($orderByDirection, ['DESC', 'ASC'])) {
            $orderByDirection = 'DESC';
        }

        $this->orderByDirection = $orderByDirection;

        return $this;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function setPage(int $page, $lastPage): self
    {
        // Check if page is greater than max available page
        if ($page > $lastPage) {
            $page = $lastPage;
        }

        // Check if page is less or equal to 0
        if ($page <= 0) {
            $page = 1;
        }

        $this->page = $page;

        return $this;
    }

}