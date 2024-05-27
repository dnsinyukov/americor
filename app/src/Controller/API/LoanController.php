<?php

namespace App\Controller\API;

use App\Entity\Client;
use App\Request\LoanDisbursementRequest;
use App\Services\Conditions\Age;
use App\Services\Conditions\CreditScore;
use App\Services\Conditions\Income;
use App\Services\Conditions\State;
use App\Services\LoanValidator;
use App\Services\Notification\Mail;
use App\Services\Notification\SendLoanApprove;
use App\Services\Notification\SMS;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/loan', name: 'loan-disbursement')]
class LoanController extends AbstractController
{
    #[Route(path: '/validate', methods: ['POST'])]
    public function validate(LoanDisbursementRequest $request, ManagerRegistry $doctrine): JsonResponse
    {
        $repository = $doctrine->getRepository(Client::class);
        $clientId = $request->clientId;

        /** @var Client|null $client */
        $client = $repository->find($request->clientId);

        if (! $client) {
            throw $this->createNotFoundException('No client found for id '. $clientId);
        }

        $handlers = [
            new CreditScore($client->getFico()),
            new Income($request->income ?? 0),
            new Age($client->getAge()),
            new State($client->getAddress())
        ];

        $resultValue = (new LoanValidator($handlers))->apply();

        return $this->json(['status' => $resultValue]);
    }

    #[Route(path: '', methods: ['POST'])]
    public function approveLoan(LoanDisbursementRequest $request, ManagerRegistry $doctrine, MailerInterface $mailer): JsonResponse
    {
        $repository = $doctrine->getRepository(Client::class);
        $clientId = $request->clientId;

        /** @var Client|null $client */
        $client = $repository->find($request->clientId);

        if (!$client) {
            throw $this->createNotFoundException('No client found for id ' . $clientId);
        }

        $subject = 'Loan has been approved';
        $message = 'Loan amount: ' . $request->income;

        (new SendLoanApprove())
            ->setNotifier(new Mail($client->getEmail(), $mailer))
            ->notify($subject, $message)
            ->setNotifier(new SMS($client->getPhone()))
            ->notify($subject, $message);

        return $this->json(['ok' => true]);
    }
}