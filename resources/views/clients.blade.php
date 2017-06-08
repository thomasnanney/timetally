@extends('layouts.dashboard')

@section('css')
@endsection

@section('content')
    <div class="row">
    <div class="timer-container">
        <div class="row">
            <div class="col-md-2 text-left ">
                <h1>Clients</h1>
            </div>
        <div class="col-md-8 ">
            <input type="text" placeholder="Search Clients...">
        </div>
            <div class="col-md-2 tk-dropdown-container relative">
                <button type="button" class="btn tk-dropdown-toggle">Add Client</button>
                <div class="tk-dropdown set-project-dropdown tk-root">
                    <div class="tk-search-projects-dropdown ">
                        <div class="row">
                            <div class="col-xs-12">
                                <input type="text" placeholder="Search projects...">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <ul class="tk-projects-found">
                                    <li class="tk-project-name">Project 1</li>
                                    <li class="tk-project-name">Project 2</li>
                                    <li class="tk-project-name">Project 3</li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="tk-add-new-project text-center">
                                    <a href="#">Create New Project +</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tk-add-new-project-dropdown hidden">
                        <form>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" placeholder="Company Name...">
                                </div>
                                <div class="input-group">
                                    <input type="text" placeholder="Project Name...">
                                </div>
                            </div>
                            <div class="input-group text-right">
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </form>
                        <hr>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="tk-add-new-project text-center">
                                    <a href="#">Search Projects</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    <hr>
    <div class="row">
    <div class="timer-container">
        <div class="row">
            <div class="col-xs-4 col-md-4 ">
                <h1>A Cool Company</h1>
                <p>123 Roadway Drive, San Antonio, TX</p>
            </div>
            <div class="col-xs-4 col-md-4 ">
                <h2>Contact</h2>
                <p>Jerry Seinfeld</p>
                <p>jerry.seinfeld@gmail.com</p>
                <p>(555) 555-5555</p>
            </div>
            <div class="col-xs-4 col-md-4 ">
                <p>Currently there are <strong>4 active projects</strong> and <strong>2 workspaces</strong> being used</p>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-4 col-md-4 ">
                <div class="panel panel-default">
                    <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6">
                        <p><strong>Project A</strong></p>
                        <p><strong>Workspace:</strong> Department A</p>
                        </div>
                        <div class="col-md-6 text-right">
                            <p><a>Manage Project</a></p>
                            <p><a>Manage Workspace</a></p>
                        </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <p><strong>Start Date:</strong> June 4, 2017 <strong>End Date:</strong> June 26, 2017</p>
                        <p><strong>Projected Cost:</strong> $1,200.00</p>
                        <p><strong>Projected Time:</strong> 120 hours</p>
                        <p><strong>Current Time:</strong> 67 hours 46 minutes</p>
                    </div>
                </div>
            </div>
             <div class="col-xs-4 col-md-4 ">
                <div class="panel panel-default">
                    <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6">
                        <p><strong>Project A</strong></p>
                        <p><strong>Workspace:</strong> Department A</p>
                        </div>
                        <div class="col-md-6 text-right">
                            <p><a>Manage Project</a></p>
                            <p><a>Manage Workspace</a></p>
                        </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <p><strong>Start Date:</strong> June 4, 2017 <strong>End Date:</strong> June 26, 2017</p>
                        <p><strong>Projected Cost:</strong> $1,200.00</p>
                        <p><strong>Projected Time:</strong> 120 hours</p>
                        <p><strong>Current Time:</strong> 67 hours 46 minutes</p>
                    </div>
                </div>
            </div>
            <div class="col-xs-4 col-md-4 ">
                <div class="panel panel-default">
                    <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6">
                        <p><strong>Project A</strong></p>
                        <p><strong>Workspace:</strong> Department A</p>
                        </div>
                        <div class="col-md-6 text-right">
                            <p><a>Manage Project</a></p>
                            <p><a>Manage Workspace</a></p>
                        </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <p><strong>Start Date:</strong> June 4, 2017 <strong>End Date:</strong> June 26, 2017</p>
                        <p><strong>Projected Cost:</strong> $1,200.00</p>
                        <p><strong>Projected Time:</strong> 120 hours</p>
                        <p><strong>Current Time:</strong> 67 hours 46 minutes</p>
                    </div>
                </div>
            </div>
             <div class="col-xs-4 col-md-4 ">
                <div class="panel panel-default">
                    <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6">
                        <p><strong>Project A</strong></p>
                        <p><strong>Workspace:</strong> Department A</p>
                        </div>
                        <div class="col-md-6 text-right">
                            <p><a>Manage Project</a></p>
                            <p><a>Manage Workspace</a></p>
                        </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <p><strong>Start Date:</strong> June 4, 2017 <strong>End Date:</strong> June 26, 2017</p>
                        <p><strong>Projected Cost:</strong> $1,200.00</p>
                        <p><strong>Projected Time:</strong> 120 hours</p>
                        <p><strong>Current Time:</strong> 67 hours 46 minutes</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <hr>
        <div class="row">
    <div class="timer-container">
        <div class="row">
            <div class="col-xs-4 col-md-4 ">
                <h1>A Cool Company</h1>
                <p>123 Roadway Drive, San Antonio, TX</p>
            </div>
            <div class="col-xs-4 col-md-4 ">
                <h2>Contact</h2>
                <p>Jerry Seinfeld</p>
                <p>jerry.seinfeld@gmail.com</p>
                <p>(555) 555-5555</p>
            </div>
            <div class="col-xs-4 col-md-4 ">
                <p>Currently there are <strong>4 active projects</strong> and <strong>2 workspaces</strong> being used</p>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-4 col-md-4 ">
                <div class="panel panel-default">
                    <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6">
                        <p><strong>Project A</strong></p>
                        <p><strong>Workspace:</strong> Department A</p>
                        </div>
                        <div class="col-md-6 text-right">
                            <p><a>Manage Project</a></p>
                            <p><a>Manage Workspace</a></p>
                        </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <p><strong>Start Date:</strong> June 4, 2017 <strong>End Date:</strong> June 26, 2017</p>
                        <p><strong>Projected Cost:</strong> $1,200.00</p>
                        <p><strong>Projected Time:</strong> 120 hours</p>
                        <p><strong>Current Time:</strong> 67 hours 46 minutes</p>
                    </div>
                </div>
            </div>
             <div class="col-xs-4 col-md-4 ">
                <div class="panel panel-default">
                    <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6">
                        <p><strong>Project A</strong></p>
                        <p><strong>Workspace:</strong> Department A</p>
                        </div>
                        <div class="col-md-6 text-right">
                            <p><a>Manage Project</a></p>
                            <p><a>Manage Workspace</a></p>
                        </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <p><strong>Start Date:</strong> June 4, 2017 <strong>End Date:</strong> June 26, 2017</p>
                        <p><strong>Projected Cost:</strong> $1,200.00</p>
                        <p><strong>Projected Time:</strong> 120 hours</p>
                        <p><strong>Current Time:</strong> 67 hours 46 minutes</p>
                    </div>
                </div>
            </div>
            <div class="col-xs-4 col-md-4 ">
                <div class="panel panel-default">
                    <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6">
                        <p><strong>Project A</strong></p>
                        <p><strong>Workspace:</strong> Department A</p>
                        </div>
                        <div class="col-md-6 text-right">
                            <p><a>Manage Project</a></p>
                            <p><a>Manage Workspace</a></p>
                        </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <p><strong>Start Date:</strong> June 4, 2017 <strong>End Date:</strong> June 26, 2017</p>
                        <p><strong>Projected Cost:</strong> $1,200.00</p>
                        <p><strong>Projected Time:</strong> 120 hours</p>
                        <p><strong>Current Time:</strong> 67 hours 46 minutes</p>
                    </div>
                </div>
            </div>
             <div class="col-xs-4 col-md-4 ">
                <div class="panel panel-default">
                    <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6">
                        <p><strong>Project A</strong></p>
                        <p><strong>Workspace:</strong> Department A</p>
                        </div>
                        <div class="col-md-6 text-right">
                            <p><a>Manage Project</a></p>
                            <p><a>Manage Workspace</a></p>
                        </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <p><strong>Start Date:</strong> June 4, 2017 <strong>End Date:</strong> June 26, 2017</p>
                        <p><strong>Projected Cost:</strong> $1,200.00</p>
                        <p><strong>Projected Time:</strong> 120 hours</p>
                        <p><strong>Current Time:</strong> 67 hours 46 minutes</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <hr>
    
@endsection


@section('js')
    
@endsection