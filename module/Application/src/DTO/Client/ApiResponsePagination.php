<?php

declare(strict_types=1);

namespace Application\DTO\Client;

use Application\DTO\Pagination;
use Ds\Vector;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Client response with pagination"
 * )
 *
 * Class ApiResponse
 */
class ApiResponsePagination
{
    /**
     * @OA\Property(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Client")
     * )
     *
     * @var array
     */
    public $collection = [];

    /**
     * @OA\Property()
     *
     * @var Pagination
     */
    public $pagination;

    /**
     * ApiResponsePagination constructor.
     *
     * @param array      $collection
     * @param Pagination $pagination
     */
    public function __construct(array $collection, Pagination $pagination)
    {
        $this->collection = $collection;
        $this->pagination = $pagination;
    }

    /**
     * @param Vector $collection
     * @param int    $page
     * @param int    $perPage
     * @param int    $total
     *
     * @return ApiResponsePagination
     */
    public static function buildFromCollection(Vector $collection, int $page, int $perPage, int $total): self
    {
        $clients = [];

        $collection->map(function ($item) use (&$clients) {
            $clients[] = Client::buildFromClient($item);
        });

        return new self($clients, new Pagination($page, $perPage, $total));
    }
}
