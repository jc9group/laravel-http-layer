<?php

declare(strict_types = 1);

namespace Jc9\PhpLibHttpLayer\Exceptions;

interface HttpResolvableExceptionInterface
{
    /**
     * @return int
     */
    public function getHttpCode(): int;

    /**
     * @return null|string
     */
    public function getHttpMessage(): ?string;

    /**
     * @return array|null
     */
    public function getHttpErrorDetails(): ?array;
}
