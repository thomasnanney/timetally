@extends('layouts.dashboard')

@section('css')
    <link href="{{asset('libs/clockpicker/dist/bootstrap-clockpicker.css') }}" type="text/css" rel="stylesheet">
    <link href="{{asset('libs/datepicker/css/datepicker.css') }}" type="text/css" rel="stylesheet">
    <link href="{{asset('css/timer.css')}}" type="text/css" rel="stylesheet">
@endsection

@section('content')
    <div class="timer-container">
        <div class="row">
            <div class="co-xs-12 col-md-8 timer-description">
                <input type="text" class="tk-timer-input" placeholder="Task Description...">
            </div>
            <div class="col-xs-12 col-md-4">
                <div class="row">
                    <div class="timer-project col-xs-4 relative tk-dropdown-container">
                        <span class="tk-dropdown-toggle"> Project/Task</span>
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
                        <div class="tk-arrow"></div>
                    </div>
                    <div class="timer-labels col-xs-1 text-center">
                        <i class="fa fa-tag" aria-hidden="true"></i>
                    </div>
                    <div class="timer-billable col-xs-1 text-center">
                        <i class="fa fa-usd" aria-hidden="true"></i>
                    </div>
                    <div class="timer-set-time col-xs-4 text-center relative tk-dropdown-container">
                        <span class="tk-dropdown-toggle"><div id="clock"></div></span>
                        <div class="set-time-dropdown tk-dropdown">
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="input-group clockpicker">
                                        <input type="text" placeholder="Start time...">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="input-group clockpicker">
                                        <input type="text" placeholder="End time...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div id="datepicker"></div>
                                    <input type="hidden" id="my_hidden_input">
                                </div>
                            </div>
                        </div>
                        <div class="tk-arrow"></div>
                    </div>
                    <div class="timer-start-stop col-xs-1 text-center">
                        <i class="fa fa-play-circle" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="log-container">
        <div class="row">
            <div class="col-xs-12">
                <ul>
                    <li>Today</li>
                    <li>
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                Description 1
                            </div>
                            <div class="col-xs-4 col-md-2">
                                Client 1 - Project 1
                            </div>
                            <div class="col-xs-4 col-md-2 text-right">

                            </div>
                            <div class="col-xs-4 col-md-2">
                                01:30:00
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                Description 2
                            </div>
                            <div class="col-xs-4 col-md-2">
                                Client 1 - Project 1
                            </div>
                            <div class="col-xs-4 col-md-2 text-right">
                                <i class="fa fa-usd" aria-hidden="true"></i>
                            </div>
                            <div class="col-xs-4 col-md-2">
                                01:30:00
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                Description 3
                            </div>
                            <div class="col-xs-4 col-md-2">
                                Client 1 - Project 1
                            </div>
                            <div class="col-xs-4 col-md-2 text-right">
                                <i class="fa fa-usd" aria-hidden="true"></i>
                            </div>
                            <div class="col-xs-4 col-md-2">
                                01:30:00
                            </div>
                        </div>
                    </li>
                </ul>
                <ul>
                    <li>Yesterday</li>
                    <li>
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                Description 1
                            </div>
                            <div class="col-xs-4 col-md-2">
                                Client 1 - Project 1
                            </div>
                            <div class="col-xs-4 col-md-2 text-right">
                                <i class="fa fa-usd" aria-hidden="true"></i>
                            </div>
                            <div class="col-xs-4 col-md-2">
                                01:30:00
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                Description 3
                            </div>
                            <div class="col-xs-4 col-md-2">
                                Client 1 - Project 1
                            </div>
                            <div class="col-xs-4 col-md-2 text-right">

                            </div>
                            <div class="col-xs-4 col-md-2">
                                01:30:00
                            </div>
                        </div>
                    </li>
                </ul>
                <ul>
                    <li>Tuesday - June 6, 2017</li>
                    <li>
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                Description 1
                            </div>
                            <div class="col-xs-4 col-md-2">
                                Client 1 - Project 1
                            </div>
                            <div class="col-xs-4 col-md-2 text-right">
                                <i class="fa fa-usd" aria-hidden="true"></i>
                            </div>
                            <div class="col-xs-4 col-md-2">
                                01:30:00
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                Description 2
                            </div>
                            <div class="col-xs-4 col-md-2">
                                Client 1 - Project 1
                            </div>
                            <div class="col-xs-4 col-md-2 text-right">

                            </div>
                            <div class="col-xs-4 col-md-2">
                                01:30:00
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                Description 3
                            </div>
                            <div class="col-xs-4 col-md-2">
                                Client 1 - Project 1
                            </div>
                            <div class="col-xs-4 col-md-2 text-right">
                                <i class="fa fa-usd" aria-hidden="true"></i>
                            </div>
                            <div class="col-xs-4 col-md-2">
                                01:30:00
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                Description 4
                            </div>
                            <div class="col-xs-4 col-md-2">
                                Client 1 - Project 1
                            </div>
                            <div class="col-xs-4 col-md-2 text-right">

                            </div>
                            <div class="col-xs-4 col-md-2">
                                01:30:00
                            </div>
                        </div>
                    </li><li>
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                Description 5
                            </div>
                            <div class="col-xs-4 col-md-2">
                                Client 1 - Project 1
                            </div>
                            <div class="col-xs-4 col-md-2 text-right">
                                <i class="fa fa-usd" aria-hidden="true"></i>
                            </div>
                            <div class="col-xs-4 col-md-2">
                                01:30:00
                            </div>
                        </div>
                    </li>

                </ul>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script src="{{asset('libs/clockpicker/dist/bootstrap-clockpicker.js')}}"></script>
    <script type="text/javascript" src="{{asset('libs/datepicker/js/bootstrap-datepicker.js')}}"
            charset="UTF-8"></script>
    <script type="text/javascript">
        jQuery('.clockpicker').clockpicker({
            donetext: 'Done',
            twelvehour: true
        });
        jQuery('#datepicker').datepicker();
        jQuery('#datepicker').on('changeDate', function() {
            jQuery('#my_hidden_input').val(
                jQuery('#datepicker').datepicker('getFormattedDate')
            );
        });

        jQuery('.tk-add-new-project').on('click', function(evt){
            evt.preventDefault();
            var root = jQuery(this).closest('.tk-root');
            var subMenus = root.children();

            subMenus.each(function(){
                jQuery(this).hasClass('hidden') ? jQuery(this).removeClass('hidden') : jQuery(this).addClass('hidden');
            });
        });
    </script>
@endsection