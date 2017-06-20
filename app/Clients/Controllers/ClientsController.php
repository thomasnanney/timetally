<?php

namespace App\Clients\Controllers;

use Validator;
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

        $data = $request->all();

        $rules = array (
            'name' => 'required|string|min:1',
            'email' => 'required|email',
            'address1' => 'required|string|min:1',
            'address2' => 'sometimes|string',
            'city' => 'required|string|min:1',
            'state' => 'required|string|min:1',
            'postalCode' => 'required|digits:5',
            'description' => 'nullable|string|min:1'
        );

        $messages = array(
            'name.required' => 'Please enter a Company Name',
            'email.required' => 'Please enter an E-Mail',
            'address1.required' => 'Please enter an Address',
            'address2.string' => 'Please enter an Address2',
            'city.required' => 'Please enter a City',
            'state.required' => 'Please enter a State',
            'postalCode.required' => 'Please enter a Postal Code',
            'description.required' => 'Please enter a Description'
        );

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()){
            return response()->json([
                'errors' => 'true',
                'messages' => $validator->errors(),
                'status' => 'fail'
            ]);
        }

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
            'errors' => 'false',
            'status' => 'success',
        ]);


    }


    public function editClient(Request $request, $id){
        $data = $request->all();

        $rules = array (
            'name' => 'required|string|min:1',
            'email' => 'required|email',
            'address1' => 'required|string|min:1',
            'address2' => 'sometimes|string',
            'city' => 'required|string|min:1',
            'state' => 'required|string|min:1',
            'postalCode' => 'required|digits:5',
            'description' => 'nullable|string|min:1'
        );

        $messages = array(
            'name.required' => 'Please enter a Company Name',
            'email.required' => 'Please enter an E-Mail',
            'address1.required' => 'Please enter an Address',
            'address2.string' => 'Please enter an Address2',
            'city.required' => 'Please enter a City',
            'state.required' => 'Please enter a State',
            'postalCode.required' => 'Please enter a Postal Code',
            'description.required' => 'Please enter a Description'
        );

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()){
            return response()->json([
                'errors' => 'true',
                'messages' => $validator->errors(),
                'status' => 'fail'
            ]);
        }

        // client information
        $client = Client::find($id);
        $client->name = $request->input('name');
        $client->email = $request->input('email');
        $client->address1 = $request->input('address1');
        $client->address2 = $request->input('address2');
        $client->city = $request->input('city');
        $client->state = $request->input('state');
        $client->postalCode = $request->input('postalCode');
        $client->save();
        return response()->json([
            'errors' => 'false'


    }


    public function deleteClient($id){
       $client = Client::find($id);
       $client->delete();
       return response()->json([
            'status' => 'success'
        ]);
    }

}