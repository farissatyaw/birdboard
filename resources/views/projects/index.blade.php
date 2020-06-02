@extends('layouts.app')

@section('content')
<header class="flex items-center mb-3 py-4">
    <div class="flex w-full justify-between items-center">
        <h2 class="text-sm text-grey-dark font-normal">My Projects</h2>
        <a href="/projects/create" class="button">New Project</a>
    </div>
</header>

<main class="lg:flex lg:flex-wrap -mx-3">
    @forelse($projects as $project)
        <div class="lg:w-1/3 px-3 pb-6">
            <div class="bg-white rounded-lg p-5 shadow"style="height:200px">
                <h3 class="font-normal text-xl py-4 -ml-5 border-l-4 border-blue-light pl-4 mb-3">
                    <a href="{{$project->path()}}" class="text-black no-underline">{{$project->tittle}}</a>
                </h3>
                    <div class="text-grey-dark">{{\Illuminate\Support\Str::limit($project->description, 100)}}</div>
            </div>
        </div>  
    @empty
        <div>No Projects yet</div>
    @endforelse
</main>   
@endsection