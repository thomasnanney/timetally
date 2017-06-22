@extends('layouts.dashboard')

@section('css')
    <link href="{{asset('css/workspace.css')}}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <div class="tk-container">
        <div id="viewClient"></div>
    </div>
@endsection

@section('js')

@endsection

@section('vars')
    <script>
        var tk = {};
        tk.client = <?php echo json_encode($client, true) ?>;
    </script>
@endsection