<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

use App\User;
use App\Invoice;
use App\ConfirmOrder;

class CustomerTest extends TestCase
{
    use DatabaseMigrations;

    public function testCustomerDashboard()
    {
        $adminuser = User::create(['name'=>'Test User 2', 'email'=>'test2@gmail.com', 'password'=>'1234','role'=>'customer']);
        $this->actingAs($adminuser);
        $response = $this->get(route('customer_dashboard'));
        $response->assertStatus(200);
    }

    public function testCustomerMakeDraft()
    {
        $adminuser = User::create(['name'=>'Test User 2', 'email'=>'test2@gmail.com', 'password'=>'1234','role'=>'customer']);
        $this->actingAs($adminuser);
        $response = $this->post(route('customer_makedraft'), array(
            'invoiceno'=>'1',
            'itemid'=>'1',
            'itemname'=>'1',
            'unitprice'=>'1',
            'qty'=>'1',
        ));

        $response->assertSessionHas('success');
    }

    public function testCustomerRemoveItem()
    {
        $adminuser = User::create(['name'=>'Test User 2', 'email'=>'test2@gmail.com', 'password'=>'1234','role'=>'customer']);
        $this->actingAs($adminuser);
        $response = $this->post(route('customer_removeitem'), array(
            'invoiceno'=>'1',
            'itemid'=>'1',
            'itemname'=>'1',
            'unitprice'=>'1',
            'qty'=>'1',
        ));

        $response->assertSessionHas('success');
    }

    public function testCustomerAddAnother()
    {
        $adminuser = User::create(['name'=>'Test User 2', 'email'=>'test2@gmail.com', 'password'=>'1234','role'=>'customer']);
        $this->actingAs($adminuser);
        $response = $this->get(route('customer_addorder', '1'));
        $response->assertStatus(200);
    }


    public function testCustomerConfirmOrder()
    {
        $adminuser = User::create(['name'=>'Test User 2', 'email'=>'test2@gmail.com', 'password'=>'1234','role'=>'customer']);
        $this->actingAs($adminuser);
        $response = $this->post(route('customer_removeitem'), array(
            'invoiceno'=>'1',
            'gtotal'=>'200',
            'paymethod'=>'Rocket',
            'txnid'=>'1',
            'qty'=>'1',
        ));

        $response->assertSessionHas('success');
    }

    public function testCustomerPendingOrder()
    {
        $adminuser = User::create(['name'=>'Test User 2', 'email'=>'test2@gmail.com', 'password'=>'1234','role'=>'customer']);
        $this->actingAs($adminuser);
        $response = $this->get(route('customer_pendingorder'));
        $response->assertStatus(200);
    }


    public function testCustomerPrintCopy()
    {
        $adminuser = User::create(['name'=>'Test User 2', 'email'=>'test@gmail.com', 'password'=>'1234','role'=>'customer']);
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

}
