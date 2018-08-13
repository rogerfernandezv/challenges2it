<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\People;
use App\Order;
use App\Address;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Http\Controllers\ProcessController;

class ProcessTest extends TestCase
{

	use RefreshDatabase;

	/**
     * @test
     *
     * Testing index.
     *
     * @return void
     */
    public function index()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * @test
     *
     * Testing people resource.
     *
     * @return void
     */
    public function list_people()
    {
        $response = $this->get('/api/people');

        $response->assertStatus(200);
    }

    /**
     * @test
     *
     * Testing detail people.
     *
     * @return void
     */
    public function show_people()
    {

    	$people = People::create([
		    'name' => 'Roger',
		    'phone' => '11 828378238',
		]);

        $response = $this->get('/api/people/' . $people->id);

        $response->assertStatus(200);
    }

    /**
     * @test
     *
     * Testing detail order.
     *
     * @return void
     */
    public function show_order()
    {

    	$people = People::create([
		    'name' => 'Roger',
		    'phone' => '11 828378238',
		]);

		$address = Address::create([
		    'name' => 'Casa',
		    'address' => 'Rua do nunca',
		    'city' => 'Sao Paulo',
		    'country' => 'Brasil',
		    'people_id' => $people->id,
		]);

		$order = Order::create([
		    'people_id' => $people->id,
		    'address_id' => $address->id,
		]);

        $response = $this->get('/api/order/' . $order->id);

        $response->assertStatus(200);
    }

    /**
     * @test
     *
     * Testing order resource.
     *
     * @return void
     */
    public function list_order()
    {
        $response = $this->get('/api/order');

        $response->assertStatus(200);
    }

    /**
     * @test
     *
     * Testing process people.xml.
     *
     * @return void
     */
    public function store_people_order()
    {
    	$this->assertEquals(0, People::count());

    	$people_test = storage_path('app/testing/people.xml');
    	$order_test = storage_path('app/testing/shiporders.xml');

    	$xml_p = simplexml_load_file($people_test);
    	$xml_o = simplexml_load_file($order_test);

    	$process = new ProcessController;
    	$response = $process->process_people($xml_p);

        $this->assertEquals(3, People::count());
        
    	$response = $process->process_shiporder($xml_o);

        $this->assertEquals(3, Order::count());

    }


}
