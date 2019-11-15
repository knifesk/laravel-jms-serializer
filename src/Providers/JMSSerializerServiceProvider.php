<?php

namespace KnF\LaravelJmsSerializer\Providers;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Illuminate\Support\ServiceProvider;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
use KnF\LaravelJmsSerializer\Console\Commands\ClearCacheCommand;

class JMSSerializerServiceProvider extends ServiceProvider
{
    /**
     * @inheritdoc
     */
    public function boot()
    {
        $this->registerCommands();

        $this->publishes(
            [__DIR__ . '/../../config/serializer.php' => base_path('config/serializer.php')],
            'config'
        );

    }

    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/serializer.php', 'serializer');

        $this->registerAnnotationLoader();
        $this->registerContainerBindings();
    }

    /**
     * Registers the bindings
     */
    protected function registerContainerBindings()
    {
        $this->app->singleton('serializer', function () {
            return $this->createSerializer();
        });

        $this->app->alias('serializer', Serializer::class);
    }

    /**
     * @return SerializerInterface
     */
    protected function createSerializer()
    {
        $builder = new SerializerBuilder();

        $cacheDir = config('serializer.cache_dir');
        if (!$cacheDir) {
            $builder->setCacheDir($cacheDir);
        }

        $defaultHandlers = config('serializer.default_handlers');
        if ($defaultHandlers) {
            $builder->addDefaultHandlers();
            $builder->addDefaultListeners();
        }

        $handlers = config('serializer.handlers');
        if ($handlers && is_array($handlers) && !empty($handlers)) {
            foreach ($handlers as $handler) {
                $builder->configureHandlers($handler);
            }
        }

        $eventListeners = config('serializer.event_listeners');
        if ($eventListeners && is_array($eventListeners) && !empty($eventListeners)) {
            foreach ($eventListeners as $listener) {
                $builder->configureListeners($listener);
            }
        }

        $paths = config('serializer.paths');
        if ($paths && is_array($paths)) {
            $builder->addMetadataDirs($paths);
        } else {
            $builder->addMetadataDirs([base_path('app')]);
        }

        $builder->setDebug(env('APP_DEBUG', true));

        return $builder->build();
    }

    /**
     *
     */
    protected function registerAnnotationLoader()
    {
        AnnotationRegistry::registerLoader('class_exists');
    }

    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([ClearCacheCommand::class]);
        }
    }
}
