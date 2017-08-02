@extends('layouts.dashboard')

@section('css')
    <link href="{{asset('css/reports.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('libs/datepicker/css/datepicker.css') }}" type="text/css" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12 payroll-report">
            <h2> <a href="/reports/timeEntryReportPDF">PDF report</a></h2>
            <h2> <a href="/reports/timeEntryReportCSV">CSV report</a></h2>
        </div>
    </div>
    {{--<div id="reportManager"></div>--}}
@endsection


@section('js')
    <script type="text/javascript" src="{{asset('libs/datepicker/js/bootstrap-datepicker.js')}}"
            charset="UTF-8"></script>
    <script type="text/javascript">
        $('.datepicker').datepicker()
    </script>
@endsection