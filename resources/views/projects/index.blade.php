@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Birdboard</h1>
        <ul>
        @forelse($projects as $project)
            <li>
                <a href="{{$project->path()}}">{{$project->tittle}}</a>
            </li>
        @empty
        <li>No Project Yet</li>
        @endforelse
        </ul>
</div>
    
    
    
@endsection