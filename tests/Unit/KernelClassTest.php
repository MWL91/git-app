<?php

namespace Tests\Unit;

use App\Console\Kernel;
use PHPUnit\Framework\TestCase;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Foundation\Application;

class KernelClassTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testKernelClass()
    {
        $appMock = $this->createMock(Application::class);
        $dispatcherMock = $this->createMock(Dispatcher::class);
        $scheduleMock = $this->createMock(Schedule::class);

        $kernelClass = new Kernel($appMock, $dispatcherMock);

        $this->assertEquals(null, $kernelClass->schedule($scheduleMock));
    }
}
