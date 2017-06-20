<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Workspace extends Model
{
    //set fillable and guarded
    protected $fillable = array(
        'name',
        'description',
        'organizationID',
    );

    public function workspaceUsers() {
        // TODO: return users assigned to projects

    }
}