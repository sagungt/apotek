@extends('adminlte::page')

@section('title', 'Stocks')

@section('content_header')
    <h1>Pembelian</h1>
@stop

@section('content')
    <livewire:stocks.index :is-history="false" />
@stop
