<?php

namespace App\Projects\Controllers;

use Illuminate\Http\Request;
use App\Core\Controllers\Controller;
use App\Projects\Models\Project;
use App\Projects\Models\Projects_user;

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
                'billableType.required' => 'Please enter Billable Type',
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
                return response()->json([
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
        $project->endDate = $data['endDate'];
        $project->projectedTime = $data['projectedTime'];
        $project->projectedRevenue = $data['projectedRevenue'];
        $project->billableType = $data['billableType'];
        $project->save();
        return response()->json([
            'status' => 'Success',
        ]);
    }

    public function deleteProject() {
    }

    /**
     * Update the project scope
     * @param $request incoming data
     * @param $project of the client to be deleted
     * @return redirect
     */
    public function postUpdateScope(Request $request, Project $project) {
        if(isset($request->data['input'])) {
            $data = $request->data['input'];
            $rules = [
                'scope' => 'required|string|min:1',
            ];
            $messages = [
                'scope.required' => 'Please enter the Project as public or private',
            ];
            $v = Validator::make($data, $rules, $messages);
            if($v->failes()) {
                return response()->json([
                    'status' => 'Fail',
                    'errors' => $v->errors(),
                ]);
            }
        }

        $project->scope = $data['scope'];
        $project->save();
        return response()->json([
            'status' => 'Project scope successfully updated.',
        ]);
    }

    /**
     * Update the project Projected Revenue
     * @param $request incoming data
     * @param $project of the client to be deleted
     * @return redirect
     */
    public function postUpdateProjectedRevenue(Request $request, Project $project) {
        if(isset($request->data['input'])) {
            $data = $request->data['input'];
            $rules = [
                'projectedRevenue' => 'required|decimal',
            ];
            $messages = [
                'projectedRevenue.required' => 'Please enter the Projected Revenue',
            ];
            $v = Validator::make($data, $rules, $messages);
            if($v->failes()) {
                return response()->json([
                    'status' => 'Fail',
                    'errors' => $v->errors(),
                ]);
            }
        }

        $project->projectedRevenue = $data['projectedRevenue'];
        $project->save();
        return response()->json([
            'status' => 'Projected Revenue successfully updated.',
        ]);
    }

    /**
     * Update the project Billable Rate
     * @param $request incoming data
     * @param $project of the client to be deleted
     * @return redirect
     */
    public function postUpdateBillableRate(Request $request, Project $project) {
        if(isset($request->data['input'])) {
            $data = $request->data['input'];
            $rules = [
                'billableType' => 'sometimes|required|string|min:1',
                'billableHourlyType' => 'sometimes|required|string|min:1',
                'billableRate' => 'required|decimal',
            ];
            $messages = [
                'billableType.required' => 'Please enter Fixed Cost or Hourly rate',
                'billableHourlyType.required' => 'Please enter hourly rate as Per Employee or General',
                'billableRate.required' => 'Please enter the Billable Rate',
            ];
            $v = Validator::make($data, $rules, $messages);
            if($v->failes()) {
                return response()->json([
                    'status' => 'Fail',
                    'errors' => $v->errors(),
                ]);
            }
        }

        $project->billableType = $data['billableType'];
        $project->billableHourlyType = $data['billableHourlyType'];
        $project->billableRate = $data['billableRate'];
        $project->save();
        return response()->json([
            'status' => 'Billable rates successfully updated.',
        ]);
    }

}