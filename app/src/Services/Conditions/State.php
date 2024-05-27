<?php

namespace App\Services\Conditions;

use App\Entity\Client;
use App\Services\LoanConditionInterface;

class State implements LoanConditionInterface
{
    /**
     * @param Client $client
     * @return bool
     */
    public function __invoke(Client $client): bool
    {
        return $client->getAge() >= 18 && $client->getFico() <= 60;
    }

    public function getName(): string
    {
        return 'credit-score';
    }
}