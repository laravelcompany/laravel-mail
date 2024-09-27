<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Support\Str;
use LaravelCompany\Mail\Services\Messages\RelayMessage;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use LaravelMailTestSupportTrait;

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            SendportalBaseServiceProvider::class,
            LaravelMailTestServiceProvider::class,
        ];
    }

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMix();
        $this->withExceptionHandling();
        $this->mockRelayMessageService();

        $this->artisan('migrate')->run();
    }

    /**
     * @return void
     */
    protected function mockRelayMessageService(): void
    {
        $service = $this->getMockBuilder(RelayMessage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $service->method('handle')->willReturn(Str::random());

        app()->instance(RelayMessage::class, $service);
    }
}
