<?php

declare(strict_types = 1);

namespace Jc9\PhpLibHttpLayer\Exceptions;

use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class AbstractHttpException extends HttpException implements HttpResolvableExceptionInterface
{
    private $httpCode;
    private $httpMessage;
    private $httpErrorDetails;

    public function __construct(
        ?int $httpCode,
        ?string $httpMessage = null,
        ?array $httpErrorDetails = null,
        \Throwable $previous = null
    ) {
        $this->httpCode         = $httpCode ?? Response::HTTP_INTERNAL_SERVER_ERROR;
        $this->httpMessage      = $httpMessage ?? Response::$statusTexts[$this->httpCode] ?? '';
        $this->httpErrorDetails = $httpErrorDetails;

        parent::__construct($this->httpCode, $this->httpMessage, $previous);
    }

    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    public function getHttpMessage(): ?string
    {
        return $this->httpMessage;
    }

    public function getHttpErrorDetails(): ?array
    {
        return $this->httpErrorDetails;
    }
}
