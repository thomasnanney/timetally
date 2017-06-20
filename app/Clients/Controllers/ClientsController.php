<?php

namespace App\Clients\Controllers;

use Illuminate\Http\Request;
use App\Core\Controllers\Controller;

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

    public function getAdd(){
        return view('addClient');
    }

    public function getView(){
        return view('viewClient');
    }
}