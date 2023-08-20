<?php declare(strict_types=1);

namespace App;

class Item
{
    private ?self $previousItem = null;
    private ?self $nextItem = null;

    public function __construct(
        public readonly mixed $value,
    ){}

    /**
     * Inserts new value to chain
     * Finds its right place
     */
    public function insert($newValue): void
    {
        $currentIsSmaller = self::isBiggerThan($newValue, $this);
        $previousIsSmaller = self::isBiggerThan($newValue, $this->previousItem);
        $nextIsSmaller = self::isBiggerThan($newValue, $this->nextItem);

        if ($currentIsSmaller && $nextIsSmaller) {
            $this->nextItem->insert($newValue);
        } elseif ($currentIsSmaller && !$nextIsSmaller) {
            self::insertAfter($this, $newValue);
        } elseif (!$currentIsSmaller && !$previousIsSmaller && $this->previousItem) {
            $this->previousItem->insert($newValue);
        } elseif (!$currentIsSmaller && $previousIsSmaller) {
            self::insertBefore($this, $newValue);
        }
    }

    private static function insertAfter(self $previousItem, mixed $value): void
    {
        $middleItem = new self($value);
        $middleItem->previousItem = $previousItem;
        $middleItem->nextItem = $previousItem->nextItem;

        if ($previousItem->nextItem) {
            $previousItem->nextItem->previousItem = $middleItem;
        }
        $previousItem->nextItem = $middleItem;
    }

    private static function insertBefore(self $nextItem, mixed $value): void
    {
        $middleItem = new self($value);
        $middleItem->previousItem = $nextItem->previousItem;
        $middleItem->nextItem = $nextItem;

        if ($nextItem->previousItem) {
            $nextItem->previousItem->nextItem = $middleItem;
        }
        $nextItem->previousItem = $middleItem;
    }

    public function trimOut(): void
    {
        $this->previousItem->nextItem = $this->nextItem;
        $this->nextItem->previousItem = $this->previousItem;
        $this->previousItem = null;
        $this->nextItem = null;
    }

    public function getNeighbour(int $neighbourDistance): ?self
    {
        if ($neighbourDistance === 0) {
            return $this;
        }

        if ($neighbourDistance > 0 && $this->nextItem) {
            $this->nextItem->getNeighbour( --$neighbourDistance);
        }

        if ($neighbourDistance < 0 && $this->previousItem) {
            $this->previousItem->getNeighbour(++$neighbourDistance);
        }

        return null;
    }

    public static function removeNeighbour(self $item, int $neighbourDistance): void
    {
        // suicide
        if ($neighbourDistance === 0) {
            $item->trimOut();
        }

        // send kill signal to neighbour

        if ($neighbourDistance > 0 && $item->nextItem) {
            self::removeNeighbour($item->nextItem, --$neighbourDistance);
        }

        if ($neighbourDistance < 0 && $item->previousItem) {
            self::removeNeighbour($item->previousItem, ++$neighbourDistance);
        }
    }

    private static function isBiggerThan($value, ?self $item): bool
    {
        if (!$item) return false;

        if (is_int($value)) {
            return ($value - $item->value) > 0;
        }

        if (is_string($value)) {
            return strcmp($value, $item->value) > 0;
        }

        return false;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function getPrevious(): ?self
    {
        return $this->previousItem;
    }

    public function getNext(): ?self
    {
        return $this->nextItem;
    }
}