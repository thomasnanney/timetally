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

    /**
     * @param Request $request Incoming creating a client
     * @return \Illuminate\Http\JsonResponse On fail, return error messages, on success, return success
     */
    public function createClient(Request $request) {

        $data = $request->input('data');

        $validator = Client::validate($data);

        if ($validator->fails()){
            return response()->json([
                'errors' => 'true',
                'messages' => $validator->errors(),
                'status' => 'fail'
            ]);
        }

        Client::create($data);

        return response()->json([
            'errors' => 'false',
            'messages' => null,
            'status' => 'success'
        ]);
    }

    /**
     * @param Request $request Incoming request for editing a client
     * @param $id int ID of the client to be updated
     * @return \Illuminate\Http\JsonResponse On fail, return error messages, on success return success
     */
    public function editClient(Request $request, $id){

        $data = $request->input('data');

        $validator = Client::validate($data);

        if ($validator->fails()){
            return response()->json([
                'errors' => 'true',
                'messages' => $validator->errors(),
                'status' => 'fail'
            ]);
        }

        // client information
        $client = Client::find($id);
        if($client){
            $client->fill($data);
            $client->save();
            return response()->json([
                'errors' => 'false',
                'messages' => null,
                'status' => 'success'
            ]);
        }

        return response()->json([
            'errors' => 'true',
            'messages' => array(
                'No client found'
            ),
            'status' => 'fail'
        ]);
    }

    /**
     * @param $id int ID of the client ot be deleted
     * @return \Illuminate\Http\JsonResponse Return a success message on deletion
     */
    public function deleteClient($id){
        if(Client::find($id)){
            Client::destroy($id);

            return response()->json([
                'errors' => 'false',
                'status' => 'success'
            ]);
        }

        return response()->json([
            'errors' => 'true',
            'status' => 'fail',
            'messages' => [
                'Client not found'
            ]
        ]);

    }

}