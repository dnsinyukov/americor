<?php

namespace App\Controller\API;

use App\Entity\Client;
use App\Repository\ClientRepository;
use App\Request\CreateClientRequest;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: "/clients", name: "clients_")]
class ClientController extends AbstractController
{
    protected ClientRepository $repository;
    protected EntityManagerInterface $entityManager;

    /**
     * @param ManagerRegistry $doctrine
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(ManagerRegistry $doctrine, EntityManagerInterface $entityManager)
    {
        $this->repository = $doctrine->getRepository(Client::class);
        $this->entityManager = $entityManager;
    }

    #[Route(path: '', name: 'all', methods: ['GET'])]
    public function index(): Response
    {
        $clients = $this->repository->findAll();

        return $this->json(compact('clients'));
    }

    #[Route(path: '', name: 'store', methods: ['POST'])]
    public function store(CreateClientRequest $request): JsonResponse
    {
        $client = $this->clientRequestResolve($request);

        $clientId = $client->getId();

        return $this->json(['clientId' => $clientId]);
    }

    #[Route(path: '/{id}', name: 'update', methods: ['PUT'])]
    public function update(int $id,  CreateClientRequest $request): JsonResponse
    {
        $client = $this->repository->find($id);

        if (! $client) {
            throw $this->createNotFoundException(
                'No client found for id '. $id
            );
        }

        $this->clientRequestResolve($request, $client);

        return $this->json(['ok' => true]);
    }

    /**
     * @param CreateClientRequest $request
     * @param Client|null $client
     * @return Client
     */
    protected function clientRequestResolve(CreateClientRequest $request, Client $client = null): Client
    {
        $client = ($client ?? (new Client()))
            ->setFirstName($request->firstName)
            ->setLastName($request->lastName)
            ->setEmail($request->email)
            ->setFico($request->fico ?? null)
            ->setAddress($request->address ?? null)
            ->setPhone($request->phone ?? null)
            ->setSsn($request->snn ?? null)
            ->setAge($request->age ?? 0);

        try {
            $this->entityManager->persist($client);
            $this->entityManager->flush();
        } catch (\Exception $exception) {
            throw new BadRequestException('Bad Request');
        }

        return $client;
    }
}
