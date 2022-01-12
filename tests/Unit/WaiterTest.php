<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

use App\User;

class WaiterTest extends TestCase
{
    use DatabaseMigrations;

    public function testWaiterDashboard()
    {
        $waiteruser = User::create(['name'=>'Test User 3', 'email'=>'test3@gmail.com', 'password'=>'1234','role'=>'waiter']);
        $this->actingAs($waiteruser);
        $response = $this->get(route('waiter_dashboard'));
        $response->assertStatus(200);
    }

    public function testWaiterConfirm()
    {
        $waiteruser = User::create(['name'=>'Test User 3', 'email'=>'test3@gmail.com', 'password'=>'1234','role'=>'customer']);
        $this->actingAs($waiteruser);
        $response = $this->post(route('waiter_confirm'), array(
            'orderid'=>'1'
        ));

        $response->assertSessionHas('success');
    }
}
