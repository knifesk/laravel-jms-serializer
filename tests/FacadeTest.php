<?php

namespace KnF\LaravelJmsSerializer\Tests;

use KnF\LaravelJmsSerializer\Facades\Serializer;
use KnF\LaravelJmsSerializer\Providers\JMSSerializerServiceProvider;
use Orchestra\Testbench\TestCase;

class FacadeTest extends TestCase
{
    /** @test */
    public function basicJsonSerialize()
    {
        /*Serializer::shouldReceive('serialize')
            ->once()
            ->andReturn('{"stauts" => "ok"}');*/

        $result = Serializer::serialize(['status' => 'ok'], 'json');

        $this->assertEquals('{"status":"ok"}', $result);
    }

    /** @test */
    public function isServiceProviderRegistered()
    {
        $serializer = app('serializer');
        $this->assertInstanceOf(\JMS\Serializer\Serializer::class, $serializer);

        $serializer = app(\JMS\Serializer\Serializer::class);
        $this->assertInstanceOf(\JMS\Serializer\Serializer::class, $serializer);
    }

    protected function getPackageProviders($app)
    {
        return [JMSSerializerServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Serializer' => Serializer::class,
        ];
    }

}
