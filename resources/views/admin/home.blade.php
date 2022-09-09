@extends('layouts.dashboard')

@section('content')
    <h1>ciao sono la dashboard privata</h1>

    <div>Hello {{$user->name}}!</div>
@endsection