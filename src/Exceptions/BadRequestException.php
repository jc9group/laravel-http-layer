<?php

declare(strict_types = 1);

namespace Jc9\PhpLibHttpLayer\Exceptions;

use Illuminate\Http\Response;
use Throwable;

class BadRequestException extends AbstractHttpException
{
    public function __construct(
        ?string $httpMessage = null,
        ?array $httpErrorDetails = null,
        ?Throwable $previous = null
    ) {
        parent::__construct(Response::HTTP_BAD_REQUEST, $httpMessage, $httpErrorDetails, $previous);
    }
}
