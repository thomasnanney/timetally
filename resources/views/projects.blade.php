@extends('layouts.dashboard')

@section('css')
    <link href="{{asset('libs/datepicker/css/datepicker.css') }}" type="text/css" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
    <div class="timer-container">
        <div class="row">
            <div class="col-md-2 text-left ">
                <h1>Projects</h1>
            </div>
        <div class="col-md-8 ">
            <input type="text" placeholder="Search Projects...">
        </div>
            <div class="col-md-2 tk-dropdown-container">
                <button type="button" class="btn tk-dropdown-toggle">Create Client</button>
                <div class="tk-dropdown set-project-dropdown tk-root">
                    <form>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" placeholder="Client Name...">
                            </div>
                            <div class="input-group">
                                <input type="text" placeholder="Project Name...">
                            </div>
                            <div class="input-group">
                                <input class="datepicker" type="text" placeholder="Start Date...">
                            </div>
                            <div class="input-group">
                                <input class="datepicker" type="text" placeholder="End Date...">
                            </div>
                            <div class="input-group">
                                <input type="text" placeholder="Estimated Hours...">
                            </div>
                            <div class="input-group">
                                <input type="text" placeholder="Projected Revenue...">
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
        </div>
    </div>
    <hr>
    <div class="row">
    <div class="timer-container">
        <div class="row">
            <div class="col-xs-4 col-md-4">
                <h1>Project A</h1>
                <p><strong>Client:</strong> A Cool Company
                <strong>Workspace:</strong> Department A</p>
            </div>
            <div class="col-xs-8 col-md-8 text-left">
                <p><strong>Start Date:</strong> June 4, 2017 <strong>End Date:</strong> June 26, 2017</p>
                <p><strong>Projected Time:</strong> 120 hours</p>
                <p><strong>Current Time:</strong> 67 hours 46 minutes</p>
               
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-4 col-md-4 table-responsive">
            <h4>Contributions</h4>
            <table class="table text-center">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Hours</th>
                        <th>Billable Rate (per hour)</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>John Doe</td>
                        <td>36</td>
                        <td>$35.50</td>
                        <td><a>edit</a></td>
                        <td><button type="button" class="btn">-</button></td>
                    </tr>
                    <tr>
                        <td>Mary Moe</td>
                        <td>20</td>
                        <td>$36.50 </td>
                        <td><a>edit</a></td>
                        <td><button type="button" class="btn">-</button></td>
                    </tr>
                    <tr>
                        <td>July Dooley</td>
                        <td>11</td>
                        <td>$31.50</td>
                        <td><a>edit</a></td>
                        <td><button type="button" class="btn">-</button></td>
                    </tr>
                </tbody>
            </table>
            <button type="button" class="btn">Add Group Member</button>
            </div>
             <div class="col-xs-8 col-md-8 ">
                 <p>Did you ever hear the tragedy of Darth Plagueis The Wise? I thought not. 
                It’s not a story the Jedi would tell you. 
                It’s a Sith legend. Darth Plagueis was a Dark Lord of the Sith, so powerful and so wise he could use the Force to 
                influence the midichlorians to create life… 
                He had such a knowledge of the dark side that he could even keep the ones he cared about from dying. 
                The dark side of the Force is a pathway to many abilities some consider to be unnatural. 
                He became so powerful… the only thing he was afraid of was losing his power, which eventually, of course, he did. 
                Unfortunately, he taught his apprentice everything he knew, then his apprentice killed him in his sleep. 
                Ironic. He could save others from death, but not himself.</p>
            </div>
        </div>
        <hr>
        </div>
    </div>
    <hr>
    <div class="row">
    <div class="timer-container">
        <div class="row">
            <div class="col-xs-4 col-md-4">
                <h1>Project A</h1>
                <p><strong>Client:</strong> A Cool Company
                <strong>Workspace:</strong> Department A</p>
            </div>
            <div class="col-xs-8 col-md-8 text-left">
                <p><strong>Start Date:</strong> June 4, 2017 <strong>End Date:</strong> June 26, 2017</p>
                <p><strong>Projected Cost:</strong> $1,200.00</p>
                <p><strong>Projected Time:</strong> 120 hours</p>
                <p><strong>Current Time:</strong> 67 hours 46 minutes</p>
               
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-4 col-md-4 table-responsive">
            <h4>Contributions</h4>
            <table class="table text-center">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Hours</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>John Doe</td>
                        <td>36</td>
                        <td><a>edit</a></td>
                        <td><button type="button" class="btn">-</button></td>
                    </tr>
                    <tr>
                        <td>Mary Moe</td>
                        <td>20</td>
                        <td><a>edit</a></td>
                        <td><button type="button" class="btn">-</button></td>
                    </tr>
                    <tr>
                        <td>July Dooley</td>
                        <td>11</td>
                        <td><a>edit</a></td>
                        <td><button type="button" class="btn">-</button></td>
                    </tr>
                </tbody>
            </table>
            <button type="button" class="btn">Add Group Member</button>
            </div>
             <div class="col-xs-8 col-md-8 ">
                 <p>Did you ever hear the tragedy of Darth Plagueis The Wise? I thought not. 
                It’s not a story the Jedi would tell you. 
                It’s a Sith legend. Darth Plagueis was a Dark Lord of the Sith, so powerful and so wise he could use the Force to 
                influence the midichlorians to create life… 
                He had such a knowledge of the dark side that he could even keep the ones he cared about from dying. 
                The dark side of the Force is a pathway to many abilities some consider to be unnatural. 
                He became so powerful… the only thing he was afraid of was losing his power, which eventually, of course, he did. 
                Unfortunately, he taught his apprentice everything he knew, then his apprentice killed him in his sleep. 
                Ironic. He could save others from death, but not himself.</p>
            </div>
        </div>

    </div>
    </div>
@endsection


@section('js')
    <script type="text/javascript" src="{{asset('libs/datepicker/js/bootstrap-datepicker.js')}}"
            charset="UTF-8"></script>
    <script type="text/javascript">
        jQuery('.datepicker').datepicker();
    </script>
@endsection