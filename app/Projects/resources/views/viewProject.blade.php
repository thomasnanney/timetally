@extends('layouts.dashboard')

@section('css')
    <link href="{{asset('css/projects.css')}}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <div class="container">
        <div id="viewProject"></div>
    </div>

@endsection

@section('js')

@endsection

@section('vars')
    <script>
        var tk = {};
        tk.project = {!! json_encode($project) !!};
    </script>
@endsection