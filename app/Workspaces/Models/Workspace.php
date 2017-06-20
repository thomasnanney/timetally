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
        // TODO: return users assigned to workspace

    }

    public function workspaceProjects() {
        // TODO: return projects assigned to workspace
    }

    public function setOrganization() {
        // TODO: set the organization ID for the workspace
    }
}