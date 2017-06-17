@extends('layouts.dashboard')

@section('css')
    <link href="{{asset('css/workspace.css')}}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <div class="container">
        <h1>Workspaces</h1>
        <div class="list table workspace-list">
            <div class="list-header table-row thick-border-bottom">
                <div class="table-cell valign-bottom"></div>
                <div class="table-cell valign-bottom">
                    Workspace
                </div>
                <div class="table-cell valign bottom">

                </div>
            </div>
            <div class="thin-border-bottom table-row">
                <div class="table-cell valign-bottom tk-dropdown-container relative">
                    <i class="fa fa-bars clickable pad-right tk-dropdown-toggle" aria-hidden="true"></i>
                    <div class="tk-dropdown set-project-dropdown tk-root">
                        <ul class="no-list-style no-margin no-padding text-center">
                            <li><a href="{{url('/workspaces/view/1')}}">Settings</a></li>
                            <li>Leave</li>
                        </ul>
                    </div>
                    <div class="tk-arrow"></div>
                </div>
                <div class="table-cell valign-bottom">Workspace 1</div>
                <div class="table-cell valign-bottom">

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 text-center large-container dark drop">
                <a href="#">Add Workspace</a>
            </div>
        </div>
    </div>

@endsection

@section('js')

@endsection