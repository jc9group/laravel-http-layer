<?php

declare(strict_types = 1);

namespace Jc9\PhpLibHttpLayer\Responses;

use Jc9\PhpLibHttpLayer\Exceptions\HttpResolvableExceptionInterface;
use Illuminate\Http\Response;

class ErrorHttpResponse extends AbstractHttpResponse
{
    /**
     * @var int
     */
    private $errorCode;

    /**
     * @var string
     */
    private $errorText;

    /**
     * @var array|null
     */
    private $details;

    public function __construct(int $errorCode, string $errorText, array $details = null)
    {
        $this->errorCode = $errorCode;
        $this->errorText = $errorText;
        $this->details   = $details;
    }

    public static function makeFromException(HttpResolvableExceptionInterface $exception): ErrorHttpResponse
    {
        return new self(
            $exception->getHttpCode(),
            $exception->getHttpMessage() ?? Response::$statusTexts[$exception->getHttpCode()] ?? null,
            $exception->getHttpErrorDetails()
        );
    }

    public function getErrorCode(): int
    {
        return $this->errorCode;
    }

    public function getErrorText(): string
    {
        return $this->errorText;
    }

    public function getDetails(): ?array
    {
        return $this->details;
    }
}
