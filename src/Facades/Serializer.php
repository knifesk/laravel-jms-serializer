<?php
namespace KnF\LaravelJmsSerializer\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Serializer Facade
 *
 * @package Facades
 * @method static string serialize($data, string $format, ?\JMS\Serializer\SerializationContext $context = null, ?string $type = null): string;
 */
class Serializer extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'serializer';
    }
}
