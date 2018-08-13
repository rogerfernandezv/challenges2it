<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Product;
use App\Order;
use App\Address;
use App\User;
use App\People;

class ProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'people_xml' => 'mimes:xml',
            'shiporder_xml' => 'mimes:xml',
        ]);

        if($request->file('people_xml'))
            $peoples = $this->process_people(
                                $this->load_xml($request->file('people_xml'))
                            );

        if($request->file('shiporder_xml') and People::count() > 0)
            $shiporders = $this->process_shiporder(
                                $this->load_xml($request->file('shiporder_xml'))
                            );
        $messages = [];

        if(!empty($peoples))
            array_push($messages, 'People registered with success!');

        if(!empty($shiporders))
            array_push($messages, 'Shiporder registered with success!');

        return redirect(route('index'))->with('messages', $messages);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Form_file $file
     * @return SimpleXMLParser
     */
    public function load_xml($file)
    {
        $storage = Storage::put('public', $file);
        $xml = simplexml_load_file(storage_path('app/' . $storage));
        Storage::delete($storage);

        return $xml;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  SimpleXMLParser $shiporder_xml
     * @return array \App\Order
     */
    public function process_shiporder($shiporder_xml)
    {
        $orders = [];

        foreach($shiporder_xml as $shiporder)
        {

            $order = Order::find($shiporder->orderid);
            $person = People::find($shiporder->orderperson);

            if(!is_null($person) && is_null($order))
            {
                $order = new Order;
                $order->id = $shiporder->orderid;
                
                $address = new Address;
                $address->name = $shiporder->shipto->name;
                $address->address = $shiporder->shipto->address;
                $address->city = $shiporder->shipto->city;
                $address->country = $shiporder->shipto->country;
                $address->people_id = $person->id;

                $address->save();
                $order->address_id = $address->id;
                $order->people_id = $person->id;
                $order->save();

                foreach($shiporder->items->item as $i)
                {
                    $product = new Product;
                    $product->title = $i->title;
                    $product->note = $i->note;
                    $product->quantity = $i->quantity;
                    $product->price = $i->price;

                    $product->save();
                    $order->products()->attach($product->id);

                }

                array_push($orders, $order);
            }
        }

        return $orders;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  SimpleXMLParser $people_xml
     * @return array \App\People
     */
    public function process_people($people_xml)
    {
        $peoples = [];

        foreach ($people_xml->person as $person)
        {
            $people = People::find($person->personid);
            if(is_null($people))
            {
                $people = new People;
                $people->name = $person->personname;
                $people->id = $person->personid;

                $phones = [];

                foreach($person->phones->phone as $p)
                    array_push($phones, $p);
                    $people->phone = $p->phone;

                $people->phone = implode(',', $phones);

                array_push($peoples, $people);
                $people->save();
            }
        }

        return $peoples;
    }
}
