<?php

namespace App\Http\Controllers;

use App\Project;
use App\User;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects=Project::all();
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
    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }
}
