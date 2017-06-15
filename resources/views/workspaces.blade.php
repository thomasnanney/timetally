@extends('layouts.dashboard')

@section('css')

@endsection

@section('content')
    <div class="row timer-container">
        <div class="col-md-4 text-left ">
            <h1>Workspaces</h1>
        </div>
        <div class="col-md-6 timer-description">
            <input type="text" placeholder="Search Workspaces...">
        </div>
        <div class="col-md-2 tk-dropdown-container">
            <button type="button" class="btn tk-dropdown-toggle">Add Workspace</button>
            <div class="tk-dropdown set-project-dropdown tk-root">
                <form>
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" placeholder="Workspace Name...">
                        </div>
                        <div class="input-group">
                            <input type="text" placeholder="Description...">
                        </div>
                    </div>
                    <hr>
                    <div class="text-right">
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
            <div class="tk-arrow"></div>
        </div>
    </div>
    <hr>
    <div class="row workspace-container">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12 col-sm-4 ">
                    <h1>Department A</h1>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <h2>Administrator</h2>
                    <p>Jerry Seinfeld</p>
                    <p>jerry.seinfeld@gmail.com</p>
                    <p>(555) 555-5555</p>
                </div>
                <div class="col-xs-12 col-sm-4 ">
                    <p>Currently there are <strong>3 active projects</strong> and <strong>4 users</strong> in this workspace</p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <table class="table text-center">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>John Doe</td>
                            <td>john.doe@gmail.com</td>
                            <td><a>edit</a></td>
                            <td><button type="button" class="btn">-</button></td>
                        </tr>
                        <tr>
                            <td>Mary Moe</td>
                            <td>mary.moe@gmail.com</td>
                            <td><a>edit</a></td>
                            <td><button type="button" class="btn">-</button></td>
                        </tr>
                        <tr>
                            <td>July Dooley</td>
                            <td>jdoles@hotmail.com</td>
                            <td><a>edit</a></td>
                            <td><button type="button" class="btn">-</button></td>
                        </tr>
                        <tr>
                            <td>July Dooley</td>
                            <td>jdoles@hotmail.com</td>
                            <td><a>edit</a></td>
                            <td><button type="button" class="btn">-</button></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-xs-6 col-md-6 ">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <p><strong>Project A</strong></p>
                                </div>
                                <div class="panel-body">
                                    <p><strong>Start Date:</strong> June 4, 2017 <strong>End Date:</strong> June 26, 2017</p>
                                    <p><strong>Projected Cost:</strong> $1,200.00</p>
                                    <p><strong>Projected Time:</strong> 120 hours</p>
                                    <p><strong>Current Time:</strong> 67 hours 46 minutes</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-6 ">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <p><strong>Project A</strong></p>
                                </div>
                                <div class="panel-body">
                                    <p><strong>Start Date:</strong> June 4, 2017 <strong>End Date:</strong> June 26, 2017</p>
                                    <p><strong>Projected Cost:</strong> $1,200.00</p>
                                    <p><strong>Projected Time:</strong> 120 hours</p>
                                    <p><strong>Current Time:</strong> 67 hours 46 minutes</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-6 ">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <p><strong>Project A</strong></p>
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
        </div>
    </div>

    <div class="row workspace-container">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12 col-sm-4 ">
                    <h1>Department A</h1>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <h2>Administrator</h2>
                    <p>Jerry Seinfeld</p>
                    <p>jerry.seinfeld@gmail.com</p>
                    <p>(555) 555-5555</p>
                </div>
                <div class="col-xs-12 col-sm-4 ">
                    <p>Currently there are <strong>3 active projects</strong> and <strong>4 users</strong> in this workspace</p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <table class="table text-center">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>John Doe</td>
                            <td>john.doe@gmail.com</td>
                            <td><a>edit</a></td>
                            <td><button type="button" class="btn">-</button></td>
                        </tr>
                        <tr>
                            <td>Mary Moe</td>
                            <td>mary.moe@gmail.com</td>
                            <td><a>edit</a></td>
                            <td><button type="button" class="btn">-</button></td>
                        </tr>
                        <tr>
                            <td>July Dooley</td>
                            <td>jdoles@hotmail.com</td>
                            <td><a>edit</a></td>
                            <td><button type="button" class="btn">-</button></td>
                        </tr>
                        <tr>
                            <td>July Dooley</td>
                            <td>jdoles@hotmail.com</td>
                            <td><a>edit</a></td>
                            <td><button type="button" class="btn">-</button></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-xs-6 col-md-6 ">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <p><strong>Project A</strong></p>
                                </div>
                                <div class="panel-body">
                                    <p><strong>Start Date:</strong> June 4, 2017 <strong>End Date:</strong> June 26, 2017</p>
                                    <p><strong>Projected Cost:</strong> $1,200.00</p>
                                    <p><strong>Projected Time:</strong> 120 hours</p>
                                    <p><strong>Current Time:</strong> 67 hours 46 minutes</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-6 ">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <p><strong>Project A</strong></p>
                                </div>
                                <div class="panel-body">
                                    <p><strong>Start Date:</strong> June 4, 2017 <strong>End Date:</strong> June 26, 2017</p>
                                    <p><strong>Projected Cost:</strong> $1,200.00</p>
                                    <p><strong>Projected Time:</strong> 120 hours</p>
                                    <p><strong>Current Time:</strong> 67 hours 46 minutes</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-6 ">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <p><strong>Project A</strong></p>
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
        </div>
    </div>

@endsection

@section('js')

@endsection