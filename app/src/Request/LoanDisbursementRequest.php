<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints\{Email, NotBlank, Type};

class LoanDisbursementRequest extends BaseRequest
{
    #[NotBlank]
    #[Type('string')]
    public readonly string $firstName;

    #[NotBlank]
    #[Type('string')]
    public readonly string $lastName;

    #[Email]
    #[NotBlank]
    public readonly string $email;

    #[Type('string')]
    public readonly ?string $address;

    #[Type('string')]
    public readonly ?string $snn;

    #[Type('int')]
    public readonly int $age;

    #[Type('int')]
    public readonly ?int $fico;

    #[Type('string')]
    public readonly ?string $phone;
}