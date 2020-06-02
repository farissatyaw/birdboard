@extends('layouts.app')

@section('content')
<div class="container">

    <form method="POST" action="/projects">
        @csrf
        <a>Tittle </a><br><input name="tittle" size="50" value="{{old('Tittle')}}"></input>
            <br>
        <a>Description </a><br><input name="description" size="100"value="{{old('Body')}}"></input>
        <br>
        <button type="Submit">Submit</button>
        <a href="/projects">Cancel</a>
    </form>

</div>
@endsection