@extends('adminlte::page')

@section('title', 'Stocks')

@section('content_header')
    <h1>Stocks</h1>
@stop

@section('content')
    <livewire:stocks.index />
@stop
