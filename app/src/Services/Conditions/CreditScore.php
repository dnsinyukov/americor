<?php

namespace App\Services\Conditions;

use App\Services\LoanConditionInterface;

class CreditScore implements LoanConditionInterface
{
    protected int $fico;

    public function __construct(int $fico = 0)
    {
        $this->fico = $fico;
    }

    public function __invoke(): bool
    {
        return $this->fico > 500;
    }

    public function getName(): string
    {
        return 'credit-score';
    }
}