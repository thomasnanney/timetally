@extends('layouts.dashboard')

@section('css')
    <link href="{{asset('css/workspace.css')}}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <div class="container">
        <div id="workspaceSettings"></div>
    </div>

@endsection

@section('js')

@endsection

@section('vars')
    <script>
        var tk = {};
        tk.workspace = {!! json_encode($workspace) !!};
    </script>
@endsection