<?php

namespace App\PipeAndFilters\Filters;

interface SomeFlowInterface
{
    public function __construct(string $flow, array $data);

    public function getData(): array;

    public function getFlow(): string;
}
