@extends('layouts.app')

@section('content')
<header class="flex items-center mb-3 py-4">
    <div class="flex w-full justify-between items-ends">
        <p class="text-sm text-grey-dark font-normal">
           <a href="/projects" class="text-sm text-grey-dark font-normal no-underline"> My Projects </a> / {{$project->tittle}}
        </p>
        <a href="{{$project->path() . '/edit'}}" class="button">Edit Project</a>
    </div>
</header>

<main class='container'>
    <div class="lg:flex -mx-3">
        <div class="lg:w-3/4 px-3 mb-8">
            <div class="mb-6">
                <h2 class="text-grey-dark font-normal text-lg mb-3">Tasks</h2>
                @foreach($project->tasks as $task)
                <div class="card mb-3">
                    <form method="POST" action="{{$task->path()}}">
                        @csrf
                        <div class="flex items-center">
                        <input name="body" value="{{$task->body }}" class="w-full {{$task->completed ? 'text-grey' : ''}}">
                        <input name="completed" type="checkbox" onchange="this.form.submit()" {{$task->completed ? 'checked' : ''}}>
                        </div>
                    </form>
                </div>
                @endforeach
                <div class="card mb-3">
                    <form method="POST" action="{{$project->path() . '/tasks'}}">
                        @csrf
                        <input placeholder="Add Taks.." class="w-full" name="body"></div>
                    </form>   
            </div>
            
            <div class="mb-6">
                <h2 class="text-grey-dark font-normal text-lg">General Notes</h2>  
            </div>
            <form method="POST" action="{{$project->path()}}">
                @csrf
                @method('PATCH')

                <textarea name="notes" class="card w-full mb-3" style="min-height:200px" placeholder="Leave your notes here">{{$project->notes}}</textarea>
                <button type="submit" class="button">Save</button>
            </form>
        </div>
        <div class="lg:w-1/4 px-3">
                @include('projects.card')
        </div>
    </div>
</main> 
@endsection