<?php

namespace App\Clients\Controllers;

use App\Clients\Requests\CreateClient;
use Illuminate\Http\Request;
use App\Core\Controllers\Controller;
use App\Clients\Models\Client;

class ClientsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('clients');
    }

    public function store(CreateClient $request){
        $client = new Client;

        $client->name = $request->input('name');
        $client->email = $request->input('email');
        $client->address1 = $request->input('address1');
        $client->address2 = 'filler';
        $client->city = $request->input('city');
        $client->state = $request->input('state');
        $client->postalCode = $request->input('postalCode');
        $client->description = $request->input('description');

        $client->save();

        return $client;
    }

    public function update(CreateClient $request, $id){

        $client = Client::find($id);

        $client->name = $request->input('name');
        $client->email = $request->input('email');
        $client->address1 = $request->input('address1');
        $client->address2 = 'filler';
        $client->city = $request->input('city');
        $client->state = $request->input('state');
        $client->postalCode = $request->input('postalCode');
        $client->description = $request->input('description');

        $client->save();

        return $client;
    }

    public function delete($id){

        $client = Client::find($id);

        $client->delete();

    }
}