<?php

declare(strict_types=1);

namespace Application\Controller;

use Apllication\Exception\ValidationException;
use Application\DTO\Client\ApiResponsePagination;
use Application\DTO\Client\Client;
use Application\Services\HistoryService;
use Application\Services\Item;
use Application\Services\Validator\Validator;
use Client\Entity\Address;
use Client\Entity\Client as ClientEntity;
use Client\Service\ClientService;
use Ds\Map;
use OpenApi\Annotations as OA;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class ClientController
 * @package Application\Controller
 */
class ClientController extends BaseController
{
    /**
     * @var ClientService
     */
    private $service;
    /**
     * @var SerializerInterface
     */
    private $serializer;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var Validator
     */
    private $validator;

    /**
     * ClientController constructor.
     *
     * @param ClientService       $service
     * @param SerializerInterface $serializer
     * @param LoggerInterface     $logger
     * @param Validator  $validator
     */
    public function __construct(
        ClientService $service,
        SerializerInterface $serializer,
        LoggerInterface $logger,
        Validator $validator
    ) {
        $this->service    = $service;
        $this->serializer = $serializer;
        $this->logger     = $logger;
        $this->validator  = $validator;
    }

    /**
     * @OA\Get(
     *     path="/clients",
     *     summary="List of clients",
     *     tags={"Clients"},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number for display results",
     *         required=false,
     *         allowEmptyValue=true,
     *         @OA\Schema(
     *            type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="perPage",
     *         in="query",
     *         description="Per page clients count",
     *         required=false,
     *         allowEmptyValue=true,
     *         @OA\Schema(
     *            type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success response",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/ApiResponsePagination")
     *         )
     *     ),
     * )
     * @Route("/clients", name="clients.list", methods={"GET"})
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $page    = $request->query->getInt('page', 1);
        $perPage = $request->query->getInt('perPage', 20);

        /* @var Map $clientsMap */
        $clientsMap = $this->service->fetchAll($page, $perPage);

        return $this->json(ApiResponsePagination::buildFromCollection(
            $clientsMap->get('collection'),
            $page,
            $perPage,
            $clientsMap->get('total')
        ));
    }

    /**
     * @OA\POST(
     *     path="/clients/create",
     *     summary="Create a new client",
     *     tags={"Clients"},
     *     @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/Client")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success response",
     *        @OA\JsonContent(ref="#/components/schemas/Client")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Errors",
     *         @OA\JsonContent(ref="#/components/schemas/Error")
     *     ),
     * )
     * @Route("/clients/create", name="clients.create", methods={"POST"})
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        // Deserialize to DTO client
        /** @var Client $client */
        $client = $this->serializer->deserialize(
            $request->getContent(),
            Client::class,
            JsonEncoder::FORMAT,
            [
                'ignored_attributes' => ['id'],
            ]
        );

        // Validation check
        if ($errors = $this->validator->validate($client)) {
            throw new ValidationException($errors);
        }

        try {
            $client = $this->service->create($client->name, $client->email, $client->phone);
        } catch (\DomainException $e) {
        }
        $clientDTO = Client::buildFromClient($client);

        return $this->json($clientDTO, Response::HTTP_OK);
    }

    /**
     * @OA\Put(
     *     path="/clients/{id}/update",
     *     summary="Updating the current client",
     *     tags={"Clients"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/Client")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success response",
     *         @OA\JsonContent(ref="#/components/schemas/Client")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Errors",
     *         @OA\JsonContent(ref="#/components/schemas/Error")
     *     ),
     * )
     * @Route("/clients/{id}/update", name="clients.edit", methods={"PUT"})
     * @param Request      $request
     * @param ClientEntity $client
     *
     * @return JsonResponse
     */
    public function update(Request $request, ClientEntity $client)
    {
        /** @var Client $clientDTO */
        $clientDTO = $this->serializer->deserialize($request->getContent(), Client::class, JsonEncoder::FORMAT);

        // Validation check
        if ($errors = $this->validator->validate($client)) {
            throw new ValidationException($errors);
        }

        $client = $this->service->update($client->getId(), $clientDTO->name, $clientDTO->email, $clientDTO->phone);

        $clientDTO = Client::buildFromClient($client);

        return $this->json($clientDTO, Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *     path="/clients/show/{id}",
     *     summary="Show client",
     *     tags={"Clients"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success response"
     *     ),
     * )
     *
     * @Route("/clients/show/{id}", name="clients.show", methods={"GET"})
     * @param ClientEntity   $client
     *
     * @param HistoryService $historyService
     *
     * @return JsonResponse
     */
    public function show(ClientEntity $client, HistoryService $historyService)
    {
        $histories = array_merge(
            $client->getHistories()->toArray(),
            call_user_func_array(
                'array_merge',
                array_map(function (Address $address) {
                    return $address->getHistories()->toArray();
                }, $client->getAddress()->toArray())
            )
        );

        $feed = $historyService->getAll(...$histories);

        return $this->json([
            'client'  => Client::buildFromClient($client),
            'history' => array_map(function (Item $item) {
                $history = $item->getHistory();

                return [
                    'date' => $item->getDate(),
                    'name' => $history->getPropertyName(),
                    'old'  => $history->getOldValue(),
                    'new'  => $history->getNewValue(),
                    'type' => $history->getType(),
                ];
            }, $feed),
        ]);
    }
}
