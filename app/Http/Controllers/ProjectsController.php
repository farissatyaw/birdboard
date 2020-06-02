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
            
    ]);

        auth()->user()->projects()->create($attributes);
        return redirect('/projects');
    }

    public function create()
    {
        return view('projects.create');
    }
    public function show(Project $project)
    {
        if (auth()->user()->isNot($project->user)) {
            abort(403);
        }
        return view('projects.show', compact('project'));
    }
}
