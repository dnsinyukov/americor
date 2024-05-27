<?php

namespace App\Services\Conditions;

use App\Services\LoanConditionInterface;
use Random\RandomException;

class State implements LoanConditionInterface
{
    protected string $address;

    public function __construct(string $address = '')
    {
        $this->address = $address;
    }

    /**
     * @return bool
     * @throws RandomException
     */
    public function __invoke(): bool
    {
        preg_match('~(CA|NY|NV)~', $this->address, $match);

        if (count($match) === 0) {
            return false;
        }

        return !($match[1] === 'NY') || 1 === random_int(0, 1);
    }

    public function getName(): string
    {
        return 'state';
    }
}