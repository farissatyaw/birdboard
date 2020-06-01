@extends('layouts.app')

@section('content')
    <h1>Birdboard</h1>
    <ul>
    @foreach($projects as $project)
        <li>{{$project->tittle}}</li>
    @endforeach
    </ul>
    
    
@endsection