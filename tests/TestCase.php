<?php

namespace Tests;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Console\Application;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Queue\Queue;
use Illuminate\Support\Facades\ParallelTesting;
use Mockery;
use Mockery\Exception\InvalidCountException;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        return self::initialize();
    }

    private static $configurationApp = null;

    public static function initialize()
    {

        if (is_null(self::$configurationApp)) {
            $app = require __DIR__ . '/../bootstrap/app.php';

            $app->make(Kernel::class)->bootstrap();

            Artisan::call('migrate:fresh --seed');

            self::$configurationApp = $app;
            return $app;
        }

        return self::$configurationApp;
    }

    protected function tearDown(): void
    {
        if ($this->app) {
            // $this->callBeforeApplicationDestroyedCallbacks();
            // ParallelTesting::callTearDownTestCaseCallbacks($this);
            // $this->app->flush();
            // $this->app = null;
        }

        $this->setUpHasRun = false;

        if (property_exists(
            $this,
            'serverVariables'
        )) {
            $this->serverVariables = [];
        }

        if (property_exists(
            $this,
            'defaultHeaders'
        )) {
            $this->defaultHeaders = [];
        }

        if (class_exists('Mockery')) {
            if ($container = Mockery::getContainer()) {
                $this->addToAssertionCount($container->mockery_getExpectationCount());
            }

            try {
                Mockery::close();
            } catch (InvalidCountException $e) {
                if (!Str::contains($e->getMethodName(), ['doWrite', 'askQuestion'])) {
                    throw $e;
                }
            }
        }

        if (class_exists(Carbon::class)) {
            Carbon::setTestNow();
        }

        if (class_exists(CarbonImmutable::class)) {
            CarbonImmutable::setTestNow();
        }

        $this->afterApplicationCreatedCallbacks = [];
        $this->beforeApplicationDestroyedCallbacks = [];

        Application::forgetBootstrappers();

        Queue::createPayloadUsing(null);

        if ($this->callbackException) {
            throw $this->callbackException;
        }
    }
}
