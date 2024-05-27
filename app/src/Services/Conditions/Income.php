<?php

namespace App\Services\Conditions;

use App\Services\LoanConditionInterface;

class Income implements LoanConditionInterface
{
    protected float $income;

    /**
     * @param float $income
     */
    public function __construct(float $income = 0)
    {
        $this->income = $income;
    }

    /**
     * @return bool
     */
    public function __invoke(): bool
    {
        return $this->income >= 1000;
    }

    public function getName(): string
    {
        return 'income';
    }
}