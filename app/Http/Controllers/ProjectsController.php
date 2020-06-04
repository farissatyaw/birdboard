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
        $attributes=request()->validate([
            'tittle'=>'sometimes|required',
            'description'=>'sometimes|required',
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
        $project->update($this->validateRequest());

        return redirect($project->path());
    }
    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }
    public function destroy(Project $project)
    {
        $this->authorize('update', $project);
        $project->delete();
        return redirect('/projects');
    }

    protected function validateRequest()
    {
        return request()->validate([
            'tittle'=>'sometimes|required',
            'description'=>'sometimes|required',
            'notes'=>'max:255'
    
    ]);
    }
}
