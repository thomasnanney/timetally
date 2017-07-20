@extends('layouts.dashboard')

@section('css')
    <link href="{{asset('libs/clockpicker/dist/bootstrap-clockpicker.css') }}" type="text/css" rel="stylesheet">
    <link href="{{asset('libs/datepicker/css/datepicker.css') }}" type="text/css" rel="stylesheet">
    <link href="{{asset('css/timer.css')}}" type="text/css" rel="stylesheet">
@endsection

@section('content')

    <div id="timerManager"></div>

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