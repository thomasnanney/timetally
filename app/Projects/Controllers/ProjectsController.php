<?php

namespace App\Projects\Controllers;

use Illuminate\Http\Request;
use App\Core\Controllers\Controller;
use App\Projects\Models\Project;



class ProjectsController extends Controller
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
        return view('projects');
    }

    public function createProject(Request $request) {

        if(isset($request->data['input'])) {
            $data = $request->data['input'];
            $messages = [
                'projectTitle.required' => 'Please enter a Project Title',
                'description.required' => 'Please enter a Project Description',
                'clientName.required' => 'Please enter a Client Name',
                'startDate.required' => 'Please enter a Start Date',
                'endDate.required' => 'Please enter an End Date',
                'projectedRevenue.required' => 'Please enter Projected Revenue',
                'projectedTime.required' => 'Please enter Projected Time',
                'bilableType.required' => 'Please enter Billable Type',
            ];
            $rules = [
                'projectTitle' => 'required|string|min:1',
                'description' => 'sometimes|required|string|min:1',
                'clientName' => 'required|string|min:1', // needs to be different
                'startDate' => 'required|string|min:1',
                'endDate' => 'required|string|min:1',
                'projectedTime' => 'required|integer|',
                'projectedRevenue' => 'required|decimal',
                'billableType' => 'sometimes|required|string|min:1',
            ];

            $v = Validator::make($data, $rules, $messages);

            if($v->failes()) {
                return respones()->json([
                    'status' => 'Fail',
                    'errors' => $v->errors(),
                ]);
            }
        }
        // project information
        $project = new Project;
        $project->title = $data['title'];
        $project->description = $data['description'];

        // retrieve client ID from DB
        
        $project->startDate = $data['startDate'];
        $project->endDate = $date['endDate'];
        $project->projectedTime = $data['projectedTime'];
        $project->projectedRevenue = $data['projectedRevenue'];
        $project->billableType = $data['billableType'];
        $product->save();
        return respones()->json([
                    'status' => 'Success',
                ]);
    }

    public function deleteProject() {

    }
}