@extends('layouts.base')
@section('titulo')
	Inicio
@endsection
@section('CSS')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css"/>
@endsection
@section('content')
    {!! $calendar->calendar() !!}
@endsection
@section('JS')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
    {!! $calendar->script() !!}
@endsection