<?php

namespace App\Services\Notification;

class SendLoanApproveEmail extends Notification
{
    protected string $subject = 'Loan has been approved';
}