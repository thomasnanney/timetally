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

        return Client::createClient($data);


    }

    /**
     * @param Request $request Incoming request for editing a client
     * @param $id int ID of the client to be updated
     * @return \Illuminate\Http\JsonResponse On fail, return error messages, on success return success
     */
    public function editClient(Request $request, $id){
        $data = $request->input('data');

        return Client::editClient($data, $id);

    }

    /**
     * @param $id int ID of the client ot be deleted
     * @return \Illuminate\Http\JsonResponse Return a success message on deletion
     */
    public function deleteClient($id){
       return Client::deleteClient($id);
    }

}