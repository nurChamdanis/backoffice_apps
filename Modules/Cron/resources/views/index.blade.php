@extends('cron::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('cron.name') !!}</p>
@endsection
