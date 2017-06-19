<?php

namespace App\Clients\Controllers;


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


    public function createClient(Request $request) {

        $this->validate($request, [                 //rules
            'name' => 'required|string|min:1',
            'email' => 'required|email',
            'address1' => 'required|string|min:1',
            'address2' => 'sometimes|string',
            'city' => 'required|string|min:1',
            'state' => 'required|string|min:1',
            'postalCode' => 'required|digits:5',
            'description' => 'nullable|string|min:1',
        ],[                                                     //Error messages
            'name.required' => 'Please enter a Company Name',
            'email.required' => 'Please enter an E-Mail',
            'address1.required' => 'Please enter an Address',
            'address2.string' => 'Please enter an Address2',
            'city.required' => 'Please enter a City',
            'state.required' => 'Please enter a State',
            'postalCode.required' => 'Please enter a Postal Code',
            'description.required' => 'Please enter a Description',
        ]);
                // client information
        $client = new Client;
        $client->name = $request->input('name');
        $client->email = $request->input('email');
        $client->address1 = $request->input('address1');
        $client->address2 = $request->input('address2');
        $client->city = $request->input('city');
        $client->state = $request->input('state');
        $client->postalCode = $request->input('postalCode');
        $client->save();
        return response()->json([
            'status' => 'Success',
        ]);


    }


    public function deleteClient(Client $client){
        $client->delete();
        return response()->json([
            'status' => 'Client Successfully Deleted',
        ]);
    }

}