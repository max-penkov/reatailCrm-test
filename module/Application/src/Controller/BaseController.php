<?php

declare(strict_types=1);

namespace Application\Controller;

use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @OA\Info(
 *     description="This service provide simple api to store and edit json documents",
 *     version="1.0.0",
 *     title="RetailCrmTest",
 *     @OA\Contact(
 *         email="loco@list.ru"
 *     )
 * )
 * @OA\Server(
 *     url=APPLICATION_EXTERNAL_URL,
 *     description="api",
 * )
 *
 * Class BaseController
 * @package Application\Controller
 */
class BaseController extends AbstractController
{
}
