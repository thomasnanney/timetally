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
        <div class="timer-container col-xs-12">
            <h1>Dashboard</h1>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-xs-12 col-md-8">
            <div class="row">
                <div class="col-xs-12">
                    <h2>Weekly Report</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 text-center">
                    <div class="chart-toggle-container">
                        <span>Me  </span>
                        <label class="switch">
                            <input type="checkbox">
                            <div class="slider round"></div>
                        </label>
                        <span>  Team</span>
                    </div>
                </div>
            </div>
            <div class="ct-chart ct-perfect-fourth">
            </div>
        </div>
        <div class="col-xs-12 col-md-4 activity-sidebar">
            <div class="row">
                <div class="col-sm-4">
                    <h2>Most Contributions this Week</h2>
                    <h1>Jerry Seinfeld</h2>
                </div>
                <div class="col-sm-8 portrait-container">
                    <img src="{{asset('images/seinfeld3.png')}}">
                </div>
            </div>
            <br>
            <h2>Activity</h2>
            <hr>
            <div class="row">
                <div class="col-sm-8">
                    <p style="font-size: 14px"><strong>Jane Doe from <a>Department A</a> worked on <a>Project B</a></strong></p>
                    <p style="font-size: 14px">Worked on fixing a problem with the thing</p>
                </div>
                <div class="col-sm-4">
                    <p>a day ago</p>
                    <p>01:30:00</p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-8">
                    <p style="font-size: 14px"><strong>Jane Doe from <a>Department A</a> worked on <a>Project B</a></strong></p>
                    <p style="font-size: 14px">Worked on fixing a problem with the thing</p>
                </div>
                <div class="col-sm-4">
                    <p>a day ago</p>
                    <p>01:30:00</p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-8">
                    <p style="font-size: 14px"><strong>Jane Doe from <a>Department A</a> worked on <a>Project B</a></strong></p>
                    <p style="font-size: 14px">Worked on fixing a problem with the thing</p>
                </div>
                <div class="col-sm-4">
                    <p>a day ago</p>
                    <p>01:30:00</p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-8">
                    <p style="font-size: 14px"><strong>Jane Doe from <a>Department A</a> worked on <a>Project B</a></strong></p>
                    <p style="font-size: 14px">Worked on fixing a problem with the thing</p>
                </div>
                <div class="col-sm-4">
                    <p>a day ago</p>
                    <p>01:30:00</p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-8">
                    <p style="font-size: 14px"><strong>Jane Doe from <a>Department A</a> worked on <a>Project B</a></strong></p>
                    <p style="font-size: 14px">Worked on fixing a problem with the thing</p>
                </div>
                <div class="col-sm-4">
                    <p>a day ago</p>
                    <p>01:30:00</p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-8">
                    <p style="font-size: 14px"><strong>Jane Doe from <a>Department A</a> worked on <a>Project B</a></strong></p>
                    <p style="font-size: 14px">Worked on fixing a problem with the thing</p>
                </div>
                <div class="col-sm-4">
                    <p>a day ago</p>
                    <p>01:30:00</p>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script src="{{asset('/libs/chartist-js/dist/chartist.min.js')}}"></script>
    <script type="text/javascript">
        var data = {
            // A labels array that can contain any sort of values
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
            // Our series array that contains series objects or in this case series data arrays
            series: [
                [10, 12, 8, 6, 6],
                [9, 8, 6, 1, 6]
            ]
        };

        var options = {
            height: 500
        };

        new Chartist.Bar('.ct-chart', data, options).on('draw', function(data) {
            if (data.type === 'bar') {
                data.element.attr({
                    style: 'stroke-width: 50px'
                });
            }
        });
    </script>
@endsection