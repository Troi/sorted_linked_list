<?php declare(strict_types=1);

namespace App;

interface SortedList extends \Iterator, \Countable
{
    public function add(int|string $value): void;
    public function remove(int $index): void;
    public function get(int $index): int|string|null;
}