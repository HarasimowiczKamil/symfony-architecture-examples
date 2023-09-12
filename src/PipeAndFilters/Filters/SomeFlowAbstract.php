<?php

namespace App\PipeAndFilters\Filters;

abstract class SomeFlowAbstract implements SomeFlowInterface
{
    public function __construct(
        private string $flow,
        private array $data = [],
    ) {
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getFlow(): string
    {
        return $this->flow;
    }
}
