@extends('layouts.app')

@section('content')
    <h1>Birdboard</h1>
    {{$project -> tittle}}
    <div>
        {{$project->description}}
    </div>
    
@endsection