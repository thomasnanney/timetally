@extends('layouts.dashboard')

@section('css')
    <link href="{{asset('/css/dashboard.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('/libs/chartist-js/dist/chartist.min.css')}}">
@endsection

@section('content')
    @if (session('warning'))
        <div class="error-box error text-center">
            {{ session('warning') }}
        </div>
    @endif
    <div class="row">
        <div class="col-xs-12 text-center">
            <h1>Under Construction<br/>Get to testing everything else!</h1>
        </div>
    </div>
@endsection


@section('js')

@endsection