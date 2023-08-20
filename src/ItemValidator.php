<?php

namespace App;

use PhpParser\Node\Expr\Closure;

class ItemValidator
{
    private \Closure $validatorCallback;

    private function __construct(\Closure $itemValidator)
    {
        $this->validatorCallback = $itemValidator;
    }

    public function validate($value): void
    {
        $this->validatorCallback->call($this, $value);
    }

    public static function guessType($value): self
    {
        if (is_string($value)) {
            return new self(function ($v): void {
                if (!is_string($v)) {
                    throw new \InvalidArgumentException("All items needs to be strings");
                }
            });
        } else {
            return new self(function ($v): void {
                if (!is_int($v)) {
                    throw new \InvalidArgumentException("All items needs to be integers");
                }
            });
        }
    }

}