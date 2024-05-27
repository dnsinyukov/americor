<?php

namespace App\Services\Conditions;

use App\Entity\Client;
use App\Services\LoanConditionInterface;

class Age implements LoanConditionInterface
{
    protected int $age;

    /**
     * @param int $age
     */
    public function __construct(int $age = 0)
    {
        $this->age = $age;
    }

    /**
     * @param Client $client
     * @return bool
     */
    public function __invoke(): bool
    {
        return $this->age >= 18 && $this->age <= 60;
    }

    public function getName(): string
    {
        return 'age';
    }
}