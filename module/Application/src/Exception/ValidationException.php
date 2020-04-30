<?php

declare(strict_types=1);

namespace Apllication\Exception;

use Application\Services\Validator\Errors;

/**
 * Class ValidationException
 * @package Project\Exception
 */
class ValidationException extends \LogicException
{
    /**
     * @var Errors
     */
    private $errors;

    /**
     * ValidationException constructor.
     *
     * @param Errors $errors
     */
    public function __construct(Errors $errors)
    {
        parent::__construct('Validation errors.');
        $this->errors = $errors;
    }

    /**
     * @return Errors
     */
    public function getErrors(): Errors
    {
        return $this->errors;
    }
}
