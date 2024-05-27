<?php

namespace App\Services;

interface LoanConditionInterface
{
    public function __invoke();
    public function getName(): string;
}