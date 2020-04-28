<?php

declare(strict_types=1);

namespace Application\DTO;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     description="Api Error schema"
 * )
 *
 * Class Error
 * @package Application\DTO
 */
class Error
{
    /**
     * @OA\Property()
     *
     * @var string
     */
    public $type;

    /**
     * @OA\Property()
     *
     * @var string
     */
    public $title;

    /**
     * @OA\Property()
     *
     * @var int
     */
    public $status;

    /**
     * @OA\Property()
     *
     * @var string
     */
    public $detail;

    /**
     * @OA\Property(nullable=true)
     *
     * @var string
     */
    public $class;

    /**
     * @OA\Property(
     *     nullable=true,
     *     @OA\Items(type="object")
     * )
     *
     * @var array
     */
    public $trace;
}
