@extends('layouts.dashboard')

@section('css')
    <link href="{{asset('css/reports.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('libs/datepicker/css/datepicker.css') }}" type="text/css" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12 text-center">
            <h2>Employee Payroll Report</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="report-date-container text-center">
                <div class="start-date">
                    <input type='text' class="datepicker" id='datetimepickerStart' placeholder="Start Date..."/>
                </div>
                <div class="end-date">
                    <input type='text' class="datepicker" id='datetimepickerEnd' placeholder="End Date..."/>
                </div>
                <button class="btn btn-default pull-right">Download CSV</button>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-xs-12 payroll-report">
            <h2> <a href="/reports/payrollReport">Payroll Report</a></h2>

            <h2> Payroll report for mm-dd-yyyy to mm-dd-yyyy</h2>
            <hr>
            <ul>
                <li>
                    <div class="row">
                        <div class="col-xs-12 col-md-3">
                            Name:
                        </div>
                        <div class="col-xs-4 col-md-3">
                            Billable Hours:
                        </div>
                        <div class="col-xs-4 col-md-3">
                            Non-Billable Hours:
                        </div>
                        <div class="col-xs-4 col-md-3">
                            Total Hours:
                        </div>
                    </div>
                </li>
                <li>
                    <div class="row">
                        <div class="col-xs-12 col-md-3">
                            Empl 1
                        </div>
                        <div class="col-xs-4 col-md-3">
                            20 Hours
                        </div>
                        <div class="col-xs-4 col-md-3">
                            24.75 Hours
                        </div>
                        <div class="col-xs-4 col-md-3">
                            44.75 Hours
                        </div>
                    </div>
                    <ul class="payroll-report-employee-breakdown">
                        <li>
                            <div class="row">
                                <div class="col-xs-12 col-md-3">
                                    Client/Project:
                                </div>
                                <div class="col-xs-4 col-md-3">
                                    Billable Hours:
                                </div>
                                <div class="col-xs-4 col-md-3">
                                    Non-Billable Hours:
                                </div>
                                <div class="col-xs-4 col-md-3">
                                    Total Hours:
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="row">
                                <div class="col-xs-12 col-md-3">
                                    Client1 / Project 2
                                </div>
                                <div class="col-xs-4 col-md-3">
                                    15 Hours
                                </div>
                                <div class="col-xs-4 col-md-3">
                                    5 Hours
                                </div>
                                <div class="col-xs-4 col-md-3">
                                    20 Hours
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="row">
                                <div class="col-xs-12 col-md-3">
                                    Client2 / Project 1
                                </div>
                                <div class="col-xs-4 col-md-3">
                                    17.5 Hours
                                </div>
                                <div class="col-xs-4 col-md-3">
                                     7.25 Hours
                                </div>
                                <div class="col-xs-4 col-md-3">
                                    24.75 Hours
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
                <li>
                    <div class="row">
                        <div class="col-xs-12 col-md-3">
                            Empl 2
                        </div>
                        <div class="col-xs-4 col-md-3">
                            36 Hours
                        </div>
                        <div class="col-xs-4 col-md-3">
                            4 Hours
                        </div>
                        <div class="col-xs-4 col-md-3">
                            40 Hours
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
@endsection


@section('js')
    <script type="text/javascript" src="{{asset('libs/datepicker/js/bootstrap-datepicker.js')}}"
            charset="UTF-8"></script>
    <script type="text/javascript">
        $('.datepicker').datepicker()
    </script>
@endsection