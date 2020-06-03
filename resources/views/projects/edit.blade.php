@extends('layouts.app')

@section('content')
<div class="container">

    <form method="POST" action="{{$project->path()}}">
        @csrf
        @method('PATCH')
        <a>Tittle </a><br><input name="tittle" size="50" value="{{$project->tittle}}"></input>
            <br>
        <a>Description </a><br><input name="description" size="100"value="{{$project->description}}"></input>
        <br>
        <button type="Submit" class="button">Update</button>
        <a class="text-red no-underline"href="{{$project->path()}}">Cancel</a>
    </form>
    @if($errors->any())
    <div class="field mt-6">
        @foreach($errors->all() as $error)
            <li class="text-red">{{$error}}</li>
        @endforeach
    </div>
    @endif
</div>
@endsection