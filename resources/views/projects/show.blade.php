@extends('layouts.app')

@section('content')
<header class="flex items-center mb-3 py-4">
    <div class="flex w-full justify-between items-ends">
        <p class="text-sm text-grey-dark font-normal">
           <a href="/projects" class="text-sm text-grey-dark font-normal no-underline"> My Projects </a> / {{$project->tittle}}
        </p>
        <a href="/projects/create" class="button">New Project</a>
    </div>
</header>

<main class='container'>
    <div class="lg:flex -mx-3">
        <div class="lg:w-3/4 px-3 mb-8">
            <div class="mb-6">
                <h2 class="text-grey-dark font-normal text-lg mb-3">Tasks</h2>  
                <div class="card mb-3">Lorem Ipsum.</div>
                <div class="card mb-3">Lorem Ipsum.</div>
                <div class="card mb-3">Lorem Ipsum.</div>
                
            </div>
            
            <div class="mb-6">
                <h2 class="text-grey-dark font-normal text-lg">General Notes</h2>  
            </div>

            <textarea class="card w-full" style="min-height:200px">Lorem Ipsum.</textarea>
        </div>
        <div class="lg:w-1/4 px-3">
                @include('projects.card')
        </div>
    </div>
</main> 
@endsection