<?php

namespace App\Services\Conditions;

use App\Entity\Client;
use App\Services\LoanConditionInterface;

class Age implements LoanConditionInterface
{
    public function __invoke(Client $client)
    {
        return $client->getFico() > 500;
    }

    public function getName(): string
    {
        return 'credit-score';
    }
}