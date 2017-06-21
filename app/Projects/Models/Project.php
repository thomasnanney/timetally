<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //set fillable and guarded
    protected $fillable = array(
        'title',
        'description',
        'billableType',
        'projectedRevenue',
        'startDate',
        'endDate',
        'projectedTime',
    );

    public function projectUsers() {
        // TODO: return users assigned to projects

    }

    public static function deleteProject($id){
        Project::destroy($id);
        return response()->json([
            'status' => 'success'
        ]);
    }
}