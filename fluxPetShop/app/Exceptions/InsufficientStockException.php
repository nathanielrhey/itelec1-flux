<?php

namespace App\Exceptions;

use RuntimeException;

class InsufficientStockException extends RuntimeException
{
    public readonly string $productName;
    public readonly int $availableStock;

    /**
     * Create a new insufficient stock exception instance.
     */
    public function __construct(string $productName, int $availableStock)
    {
        $this->productName = $productName;
        $this->availableStock = $availableStock;

        $message = $availableStock <= 0
            ? "{$productName} is currently out of stock."
            : "Only {$availableStock} unit(s) of {$productName} available in stock.";

        parent::__construct($message);
    }
}
