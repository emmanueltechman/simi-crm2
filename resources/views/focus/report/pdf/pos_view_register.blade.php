@extends ('core.layouts.app')
@section ('title', $lang['title'] . ' | ' .trans('features.reports'))
@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h4 class="content-header-title mb-0">{{ $lang['title'] }}</h4>

            </div>

        </div> <div class="content-body">
            <div class="row">
                <div class="col-12">
                    <div class="card"> <div class="card-content">

                            <div class="card-body">
    <table class="table table-striped table-bordered zero-configuration" cellspacing="0"
           width="100%" id="pos_reg-table">
        <thead>
        <tr class="heading">
            <th>{{trans('general.employee')}}</th>
            <th>{{trans('pos.opened_on')}}</th>
            <th>{{trans('pos.closed_on')}}</th>
            <th>{{trans('general.status')}}</th>
            <th>{{trans('general.description')}}</th>
        </tr>
        </thead>
        <tbody
        @php
            $fill = false;

            foreach ($register_entries as $row) {
                if ($fill == true) {
                    $flag = ' mfill';
                } else {
                    $flag = '';
                }

                $balance=json_decode($row->data,true);
                $bal='';
                foreach ($balance as $key=>$amount_row){
                    $bal.='<strong>'.$key.'</strong> : '.amountFormat($amount_row).' <br>';
                }


                $st='<span class="st-paid" title="active"><i class="fa fa-check"></i></span>';
                if($row['closed_at']){

                    $row['closed_at']=dateTimeFormat($row['closed_at']);
                    $st='<span class="st-due" title="closed"><i class="fa fa-close"></i></span>';

                }


                echo '<tr class="item' . $flag . '"><td>' . $row->user->first_name.' '.$row->user->last_name . '</td><td>' . dateTimeFormat($row['created_at']) . '</td><td>' . $row['closed_at'] . '</td><td>' . $st . '</td><td>' . $bal . '</td></tr>';
                $fill = !$fill;
            }
        @endphp
        </tbody>
    </table>
    <br>
                            </div></div></div></div></div></div></div>
@endsection
@section('after-scripts')
    {{-- For DataTables --}}
    {{ Html::script(mix('js/dataTable.js')) }}

    <script>
        //Below written line is short form of writing $(document).ready(function() { })
        $(function () {
            setTimeout(function () {
                draw_data()
            }, {{config('master.delay')}});

        });


        function draw_data() {

            var dataTable = $('#pos_reg-table').dataTable({
                responsive: true,
                language: {
                    @lang('datatable.strings')
                },
                buttons: {
                    buttons: [
                        {extend: 'csv', footer: true, exportOptions: {columns: [0, 1]}},
                        {extend: 'excel', footer: true, exportOptions: {columns: [0, 1]}},
                        {extend: 'print', footer: true, exportOptions: {columns: [0, 1]}}
                    ]
                }
            });
            $('#pos_reg-table_wrapper').removeClass('form-inline');
        }
    </script>
@endsection
