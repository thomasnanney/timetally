<?php

namespace App\Workspaces\Controllers;

use Illuminate\Http\Request;
use App\Core\Controllers\Controller;

class WorkspacesController extends Controller
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
        return view('workspaces');
    }

    public function getViewWorkspace(){
//        if($workspace){
//
//        }
        return view('viewWorkspace');
//        return redirect('/workspaces');
    }
}
