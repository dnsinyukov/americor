<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints\{NotBlank, Type};

class LoanDisbursementRequest extends BaseRequest
{
    #[NotBlank]
    #[Type(['int', 'string'])]
    public readonly string $clientId;

    #[NotBlank]
    #[Type(['float', 'string'])]
    public readonly string $income;
}