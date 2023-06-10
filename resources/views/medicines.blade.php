@extends('adminlte::page')

@section('title', 'Management Obat')

@section('content_header')
    <h1>Management Obat</h1>
@stop

@section('content')
    <livewire:medicines.index />
@stop
