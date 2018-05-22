<?php

namespace Tests\Unit;

use App\Http\Controllers\BadTestingController;
use App\Http\Controllers\GoodTestingController;
use App\User;
use Illuminate\Contracts\Auth\Guard;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    public function testBadControllerIndex()
    {
        $badTestingController = new BadTestingController();
        $user = new User();
        $user->name = 'Adam';
        \Auth::shouldReceive('user')
            ->andReturn($user);
        $response = $badTestingController->index();
        $this->assertSame($response->getData()->user_name, 'Adam');

        $badTestingController = new BadTestingController();
        $badTestingController->index();
        $this->assertSame($response->getData()->user_name, null);
    }

    public function testGoodControllerIndex()
    {
        $user = new User();
        $user->name = 'Adam';
        $guard = \Mockery::mock(Guard::class)
                ->shouldReceive('user')
                ->andReturn($user)
                ->getMock();
        $goodTestingController = new GoodTestingController($guard);
        $response = $goodTestingController->index();
        $this->assertSame($response->getData()->user_name, 'Adam');

        $guard = \Mockery::mock(Guard::class)
            ->shouldReceive('user')
            ->andReturn(new User())
            ->getMock();
        $goodTestingController = new GoodTestingController($guard);
        $response = $goodTestingController->index();
        $this->assertSame($response->getData()->user_name, null);
    }
}
