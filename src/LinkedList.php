<?php declare(strict_types=1);

namespace App;

/**
 * basic bidirectional linked list
 * It is sorted all time, every insert keeps sorted list
 *
 * Insert complexity: O(N^2) - variation on Bubble sort
 * Remove complexity: O(N) - caused by item search by index
 */
class LinkedList implements SortedList
{
    protected ?ItemValidator $itemValidator = null;
    protected ?Item $firstItem = null;
    protected ?Item $currentItem = null;
    protected ?int $currentKey = null;
    protected int $count = 0;

    public function add(int|string $value): void
    {
        if (!$this->itemValidator) {
            $this->itemValidator = ItemValidator::guessType($value);
        }
        $this->itemValidator->validate($value);

        if (!$this->currentItem) {
            $onlyItem = new Item($value);
            $this->firstItem = $onlyItem;
            $this->currentItem = $onlyItem;
        } else {
            $this->firstItem->insert($value);
        }
        $this->count++;
    }

    public function remove(int $index): void
    {
        Item::removeNeighbour($this->firstItem, $index);
        $this->count--;
    }

    public function current(): string|int
    {
        return $this->currentItem?->getValue();
    }

    public function next(): void
    {
        $this->currentItem = $this->currentItem->getNext();
        $this->currentKey++;
    }

    public function key(): ?int
    {
        return $this->currentKey;
    }

    public function valid(): bool
    {
        return $this->currentItem !== null;
    }

    public function rewind(): void
    {
        $this->currentItem = $this->firstItem;
        $this->currentKey = 0;
    }

    public function count(): int
    {
        return $this->count;
    }

    public function get(int $index): int|string|null
    {
        return $this->getItemByIndex($index)->value;
    }

    private function getItemByIndex(int $index): ?Item
    {
        return $this->firstItem->getNeighbour($index);
    }
}