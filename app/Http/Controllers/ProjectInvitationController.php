<?php

namespace App\Http\Controllers;

use App\Project;
use App\User;
use Illuminate\Http\Request;

class ProjectInvitationController extends Controller
{
    public function store(Project $project)
    {
        $this->authorize('manage', $project);
        $attributes = request()->validate([
            'email'=>['required','exists:users,email']
        ], [
            'email.exists' =>'The user does not have a birdboard account.'
        ]);
        $user = User::whereEmail(request('email'))->first();
        $project->invite($user);

        return redirect($project->path())->withErrors($attributes, 'invite');
        ;
    }
}
