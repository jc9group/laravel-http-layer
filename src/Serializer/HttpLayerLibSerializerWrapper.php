<?php

declare(strict_types=1);

namespace Jc9\PhpLibHttpLayer\Serializer;

use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\DeserializationContext;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;

final class HttpLayerLibSerializerWrapper implements HttpLayerLibSerializerInterface
{
    /**
     * @var SerializerInterface|ArrayTransformerInterface
     */
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function toArray($data, SerializationContext $context = null, ?string $type = null): array
    {
        return $this->serializer->toArray($data, $context, $type);
    }

    public function fromArray(array $data, string $type, DeserializationContext $context = null)
    {
        return $this->serializer->fromArray($data, $type, $context);
    }

    public function serialize($data, string $format, SerializationContext $context = null, ?string $type = null): string
    {
        return $this->serializer->serialize($data, $format, $context, $type);
    }

    public function deserialize(string $data, string $type, string $format, DeserializationContext $context = null)
    {
        return $this->serializer->deserialize($data, $type, $format, $context);
    }
}
