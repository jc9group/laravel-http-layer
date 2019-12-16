<?php

declare(strict_types=1);

namespace Jc9\PhpLibHttpLayer\Serializer;

use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\SerializerInterface;

interface HttpLayerLibSerializerInterface extends SerializerInterface, ArrayTransformerInterface
{
}
