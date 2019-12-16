<?php

declare(strict_types=1);

namespace Jc9\PhpLibHttpLayer\Providers;

use Jc9\PhpLibHttpLayer\Serializer\HttpLayerLibSerializerInterface;
use Jc9\PhpLibHttpLayer\Serializer\HttpLayerLibSerializerWrapper;
use Doctrine\Common\Annotations\SimpleAnnotationReader;
use Illuminate\Support\ServiceProvider;
use JMS\Serializer\Handler\DateHandler;
use JMS\Serializer\Handler\HandlerRegistry;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;

final class HttpLayerLibProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerConfigs();
        $this->registerSerializer();
    }

    private function registerConfigs(): void
    {
        $this->mergeConfigFrom(\dirname(__DIR__, 2) . '/config/http_layer_lib.php', 'http_layer_lib');
    }

    private function registerSerializer(): void
    {
        $this->app->singleton(
            HttpLayerLibSerializerInterface::class,
            function () {
                $serializerBuilder = SerializerBuilder::create();

                if ($this->app->environment() === 'production') {
                    $serializerBuilder->setCacheDir((string)config('http_layer_lib.serializer.cache_dir.path'));
                }

                $serializerBuilder->configureHandlers(
                    static function (HandlerRegistry $registry) {
                        $registry->registerSubscribingHandler(
                            new DateHandler(
                                \DateTime::ATOM, (string)config('app.timezone', 'Europe/Moscow')
                            )
                        );
                    }
                );

                $serializerBuilder->addMetadataDir((string)config('http_layer_lib.serializer.definition.path'))
                                  ->setAnnotationReader(new SimpleAnnotationReader())
                                  ->setSerializationContextFactory(
                                      static function () {
                                          return SerializationContext::create()->setSerializeNull(
                                              (bool)config(
                                                  'http_layer_lib.serializer.context.serialize_nulls',
                                                  false
                                              )
                                          );
                                      }
                                  )
                                  ->setDebug((bool)config('app.debug', false))
                                  ->setAnnotationReader(new SimpleAnnotationReader());

                return new HttpLayerLibSerializerWrapper($serializerBuilder->build());
            }
        );
    }
}
