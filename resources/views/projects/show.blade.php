@extends('layouts.app')

@section('content')
    <div class='container'>
        <h1>Birdboard</h1>
        {{$project -> tittle}}
        <div>
            {{$project->description}}
        </div>
    </div> 
@endsection