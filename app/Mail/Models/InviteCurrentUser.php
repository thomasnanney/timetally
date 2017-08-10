<?php

namespace App\Mail\Models;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Workspaces\Models\WorkspaceInvite;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Workspaces\Models\Workspace;

class InviteCurrentUser extends Mailable
{
    use Queueable, SerializesModels;

    public $invite, $workspace;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(WorkspaceInvite $invite, Workspace $workspace)
    {
        $this->invite = $invite;
        $this->workspace = $workspace;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('TimeTallyPremiere@gmail.com')
            ->view('inviteCurrentUser');
    }
}
