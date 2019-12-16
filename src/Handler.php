<?php

namespace Jc9\PhpLibHttpLayer;

use Jc9\PhpLibHttpLayer\Exceptions\HttpResolvableExceptionInterface;
use Jc9\PhpLibHttpLayer\Responses\ErrorHttpResponse;
use Jc9\PhpLibHttpLayer\Serializer\HttpLayerLibSerializerInterface;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    private $responseFactory;
    
    private $serializer;

    public function __construct(
        Container $container,
        ResponseFactory $responseFactory,
        HttpLayerLibSerializerInterface $serializer
    ) {
        $this->responseFactory = $responseFactory;
        $this->serializer      = $serializer;

        parent::__construct($container);
    }

    public function render($request, Exception $exception)
    {
        switch (true) {
            case $exception instanceof HttpResolvableExceptionInterface:
                $errorHttpResponse = ErrorHttpResponse::makeFromException($exception);
                break;
            case $exception instanceof HttpException:
                $errorHttpResponse = new ErrorHttpResponse(
                    $exception->getStatusCode(),
                    Response::$statusTexts[$exception->getStatusCode()] ?? null
                );
                break;
            case $exception instanceof AuthorizationException:
                $errorHttpResponse = new ErrorHttpResponse(
                    Response::HTTP_UNAUTHORIZED,
                    Response::$statusTexts[Response::HTTP_UNAUTHORIZED] ?? null
                );
                break;
            case $exception instanceof ValidationException:
                $errorHttpResponse = new ErrorHttpResponse(
                    Response::HTTP_BAD_REQUEST,
                    Response::$statusTexts[Response::HTTP_BAD_REQUEST] ?? null,
                    $exception->errors()

                );
                break;
            default:
                $errorHttpResponse = new ErrorHttpResponse(
                    Response::HTTP_INTERNAL_SERVER_ERROR,
                    Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR] ?? null
                );
                break;
        }

        return $this->buildErrorResponse($errorHttpResponse);
    }

    private function buildErrorResponse(
        ErrorHttpResponse $errorHttpResponse
    ): JsonResponse {
        return $this->responseFactory->json(
            $this->serializer->toArray($errorHttpResponse),
            $errorHttpResponse->getErrorCode()
        );
    }
}
