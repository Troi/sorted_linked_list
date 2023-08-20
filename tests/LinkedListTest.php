<?php declare(strict_types=1);

namespace Test;

use App\LinkedList;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class LinkedListTest extends TestCase
{
    public function testAddIntegers(): void
    {
        $list = new LinkedList();

        foreach (range(100, 0, 1) as $value) {
            $list->add($value);
        }
        Assert::assertCount(101, $list);
    }

    public function testAddStrings(): void
    {
        $list = new LinkedList();

        foreach (range(100, 0, 1) as $value) {
            $list->add("prefix".$value);
        }
        Assert::assertCount(101, $list);
    }

    public function testTypeMixFail(): void
    {
        $list = new LinkedList();
        $list->add(1000);

        try {
            $list->add("string");
            Assert::fail("Type mixing isn't allowed");
        } catch (\Throwable $exception) {
            Assert::assertEquals(
                \InvalidArgumentException::class,
                get_class($exception),
                "Wrong Exception thrown"
            );
        }
    }

    public function testRemovingItems(): void
    {
        $list = new LinkedList();

        foreach (range(3, 0, 1) as $value) {
            $list->add($value);
        }
        Assert::assertCount(4, $list);

        $list->remove(1);

        Assert::assertCount(3, $list);
    }

    public function testSortIntegers(): void
    {
        $list = new LinkedList();

        foreach (range(1, 20, 1) as $value) {
            $list->add(random_int(0, 10));
        }

        Assert::assertCount(20, $list);

        $last = null;
        $atLeastOneLoop = false;
        foreach ($list as $value) {
            if (!$last) {
                $last = $value;
            }

            Assert::assertGreaterThanOrEqual($last, $value, "Values of array aren't sorted");

            $last = $value;
            $atLeastOneLoop = true;
        }

        Assert::assertTrue($atLeastOneLoop, "No iterated values");
    }

    public function testSortStrings(): void
    {
        $list = new LinkedList();

        foreach (range(1, 20, 1) as $value) {
            $list->add("prefix".random_int(0, 10));
        }

        Assert::assertCount(20, $list);

        $last = null;
        $atLeastOneLoop = false;
        foreach ($list as $value) {
            if (!$last) {
                $last = $value;
            }

            Assert::assertGreaterThanOrEqual($last, $value, "Values of array aren't sorted");

            $last = $value;
            $atLeastOneLoop = true;
        }

        Assert::assertTrue($atLeastOneLoop, "No iterated values");
    }
}
