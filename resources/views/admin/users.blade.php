@extends('adminlte::page')

@section('title', 'Management User')

@section('content_header')
    <h1>Management User</h1>
@stop

@section('content')
    <livewire:users.index />
@stop
