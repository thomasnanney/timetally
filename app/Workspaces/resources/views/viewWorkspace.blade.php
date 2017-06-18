@extends('layouts.dashboard')

@section('css')
    <link href="{{asset('css/workspace.css')}}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <div class="container">
        <div class="tile raise">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="no-list-style horizontal-menu text-center thin-border-bottom">
                        <li class="tab active">Settings</li>
                        <li class="tab">Users</li>
                        <li class="tab">Projects</li>
                        <li class="tab">Clients</li>
                    </ul>
                </div>
            </div>
            <div class="pane-container">
                <div class="pane medium-container margin-center">
                    <div class="row">
                        <div class="col-xs-12 ">
                            <label>Workspace Name:</label>
                            <input type="text" class="tk-form-input">
                        </div>
                    </div>
                </div>
                <div class="pane medium-container margin-center">
                    <ul class="no-list-style no-margin no-padding list">
                        <li>User 1</li>
                        <li>User 1</li>
                        <li>User 1</li>
                        <li>User 1</li>
                    </ul>
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <a href="#">+ Add User</a>
                        </div>
                    </div>
                </div>
                <div class="pane medium-container margin-center">
                    <ul class="no-list-style no-margin no-padding list">
                        <li>Project 1</li>
                        <li>Project 1</li>
                        <li>Project 1</li>
                        <li>Project 1</li>
                    </ul>
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <a href="#">+ Add Project</a>
                        </div>
                    </div>

                </div>
                <div class="pane medium-container margin-center">
                    <ul class="no-list-style no-margin no-padding list">
                        <li>Client 1</li>
                        <li>Client 1</li>
                        <li>Client 1</li>
                        <li>Client 1</li>
                    </ul>
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <a href="#">+ Add Client</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')

@endsection