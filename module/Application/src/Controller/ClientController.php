<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\DTO\Client\ApiResponsePagination;
use Client\Service\ClientService;
use Ds\Map;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
     * ClientController constructor.
     *
     * @param ClientService $service
     */
    public function __construct(ClientService $service)
    {
        $this->service = $service;
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
     * @Route("clients", name="clients.list", methods={"GET"})
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
}
