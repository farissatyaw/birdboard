<?php

namespace App\Http\Controllers;

use App\Project;
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
            'description'=>'required'
    ]);

        Project::create($attributes);
        return redirect('/projects');
    }
    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }
}
