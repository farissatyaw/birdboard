<?php

namespace App\Http\Controllers;

use App\Project;
use App\User;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects=auth()->user()->projects;
        return view('projects.index', compact('projects'));
    }
    public function store()
    {
        $attributes= request()->validate([
            'tittle'=>'required',
            'description'=>'required',
            'notes'=>'max:255'
            
    ]);

        $project=auth()->user()->projects()->create($attributes);
        return redirect($project->path());
    }

    public function create()
    {
        return view('projects.create');
    }
    public function show(Project $project)
    {
        $this->authorize('update', $project);
        return view('projects.show', compact('project'));
    }
    public function update(Project $project)
    {
        $this->authorize('update', $project);
        $project->update(request(['notes']));

        return redirect($project->path());
    }
}
