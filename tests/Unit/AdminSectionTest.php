<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

use App\User;
use App\Invoice;
use App\ConfirmOrder;

class ExampleTest extends TestCase
{
    use DatabaseMigrations;

    public function testLoginPage()
    {
        $response = $this->get("/");
        $response->assertRedirect(route('login'));
    }

    public function testAdminDashboard()
    {
        $adminuser = User::create(['name'=>'Test User', 'email'=>'test@gmail.com', 'password'=>'1234','role'=>'admin']);
        $this->actingAs($adminuser);
        $response = $this->get(route('dashboard'));
        $response->assertStatus(200);
    }

    public function testItemList()
    {
        $adminuser = User::create(['name'=>'Test User', 'email'=>'test@gmail.com', 'password'=>'1234','role'=>'admin']);
        $this->actingAs($adminuser);
        $response = $this->get(route('items'));
        $response->assertStatus(200);
    }

    public function testAdminSaveItems()
    {
        $adminuser = User::create(['name'=>'Test User', 'email'=>'test@gmail.com', 'password'=>'1234','role'=>'admin']);
        $this->actingAs($adminuser);
        $response = $this->post(route('saveItem'), array(
            'name'=>'Test Food',
            'price'=>'200'
        ));

        $response->assertSessionHas('success');
    }

    public function testAdminEditItems()
    {
        $adminuser = User::create(['name'=>'Test User', 'email'=>'test@gmail.com', 'password'=>'1234','role'=>'admin']);
        $this->actingAs($adminuser);
        $response = $this->post(route('editItem'), array(
            'itemid'=>'1',
            'name'=>'Test Food',
            'price'=>'200'
        ));

        $response->assertSessionHas('success');
    }

    public function testAdminDeleteItems()
    {
        $adminuser = User::create(['name'=>'Test User', 'email'=>'test@gmail.com', 'password'=>'1234','role'=>'admin']);
        $this->actingAs($adminuser);
        $response = $this->post(route('deleteItem'), array(
            'itemid'=>'1'
        ));

        $response->assertSessionHas('success');
    }

    public function testMakeOrder()
    {
        $adminuser = User::create(['name'=>'Test User', 'email'=>'test@gmail.com', 'password'=>'1234','role'=>'admin']);
        $this->actingAs($adminuser);
        $response = $this->get(route('makeOrder'));
        $response->assertStatus(200);
    }

    public function testMakeDraft()
    {
        $adminuser = User::create(['name'=>'Test User', 'email'=>'test@gmail.com', 'password'=>'1234','role'=>'admin']);
        $this->actingAs($adminuser);
        $response = $this->post(route('deleteItem'), array(
            'invoiceno'=>'1',
            'itemid'=>'1',
            'itemname'=>'Test Item',
            'unitprice'=>'200',
            'qty'=>'2'
        ));

        $response->assertSessionHas('success');
    }

    public function testRemoveItem()
    {
        $adminuser = User::create(['name'=>'Test User', 'email'=>'test@gmail.com', 'password'=>'1234','role'=>'admin']);
        $this->actingAs($adminuser);
        $response = $this->post(route('deleteItem'), array(
            'invid'=>'1',
            'invoiceno'=>'1'
        ));

        $response->assertSessionHas('success');
    }

    public function testAddOrder()
    {
        $adminuser = User::create(['name'=>'Test User', 'email'=>'test@gmail.com', 'password'=>'1234','role'=>'admin']);
        $this->actingAs($adminuser);
        $response = $this->get(route('addOrder', '1'));
        $response->assertStatus(200);
    }

    public function testConfirmOrder()
    {
        $adminuser = User::create(['name'=>'Test User', 'email'=>'test@gmail.com', 'password'=>'1234','role'=>'admin']);
        $this->actingAs($adminuser);
        $response = $this->post(route('confirmOrder'), array(
            'invoiceno'=>'1',
            'gtotal'=>'200'
        ));
        $response->assertRedirect(route('printCopy', '1'));
    }

    public function testConfirmList()
    {
        $adminuser = User::create(['name'=>'Test User', 'email'=>'test@gmail.com', 'password'=>'1234','role'=>'admin']);
        $this->actingAs($adminuser);
        $response = $this->get(route('confirmList'));
        $response->assertStatus(200);
    }

    public function testPrintCopy()
    {
        $adminuser = User::create(['name'=>'Test User', 'email'=>'test@gmail.com', 'password'=>'1234','role'=>'admin']);
        $this->actingAs($adminuser);
        $invoice = Invoice::create([
            'invoiceno'=>'1',
            'itemid'=>'1',
            'itemname'=>'Test Item',
            'unitprice'=>'200',
            'qty'=>'1',
            'total'=>'200',
        ]);
        $conforder = ConfirmOrder::create([
            'invoiceno'=>$invoice->invoiceno,
            'gtotal'=>'200',
            'invoicedate'=>'2022-01-08'
        ]);
        $response = $this->get(route('printCopy', $invoice->invoiceno));
        $response->assertStatus(200);
    }

    public function testAccount()
    {
        $adminuser = User::create(['name'=>'Test User', 'email'=>'test@gmail.com', 'password'=>'1234','role'=>'admin']);
        $this->actingAs($adminuser);
        $response = $this->get(route('account'));
        $response->assertStatus(200);
    }

    public function testAccountSearch()
    {
        $adminuser = User::create(['name'=>'Test User', 'email'=>'test@gmail.com', 'password'=>'1234','role'=>'admin']);
        $this->actingAs($adminuser);
        $response = $this->get(route('accountDate', '2020-01-08'));
        $response->assertStatus(200);
    }

    public function testWaiterList()
    {
        $adminuser = User::create(['name'=>'Test User', 'email'=>'test@gmail.com', 'password'=>'1234','role'=>'admin']);
        $this->actingAs($adminuser);
        $response = $this->get(route('waiterlist'));
        $response->assertStatus(200);
    }

    public function testAddWaiter()
    {
        $adminuser = User::create(['name'=>'Test User', 'email'=>'test@gmail.com', 'password'=>'1234','role'=>'admin']);
        $this->actingAs($adminuser);
        $response = $this->post(route('addWaiter'), array(
            'name'=>'Test Waiter',
            'email'=>'waiter@test.com',
            'pass1'=>'1234',
            'pass2'=>'1234'
        ));

        $response->assertSessionHas('success');
    }

    public function testRemoveWaiter()
    {
        $adminuser = User::create(['name'=>'Test User', 'email'=>'test@gmail.com', 'password'=>'1234','role'=>'admin']);
        $this->actingAs($adminuser);
        $response = $this->post(route('removeWaiter'), array(
            'uid'=>'2'
        ));

        $response->assertSessionHas('success');
    }

}
