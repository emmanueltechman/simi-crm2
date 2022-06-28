@extends ('core.layouts.app')
@section ('title', trans('general.dashboard_title').' | '.config('core.cname'))
@section('content')
    <!-- BEGIN: Content-->
    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Stats -->
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="media align-items-stretch">
                                    <div class="p-2 text-center bg-primary bg-darken-2">
                                        <i class="fa fa-file-text-o font-large-2 white"></i>
                                    </div>
                                    <div class="p-2 bg-gradient-x-primary white media-body">
                                        <h5>{{trans('dashboard.today_invoices')}}</h5>
                                        <h5 class="text-bold-400 mb-0"><i
                                                    class="ft-plus"></i> <span id="dash_1"><i
                                                        class="fa fa-spinner spinner"></i></span>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="media align-items-stretch">
                                    <div class="p-2 text-center bg-warning bg-darken-2">
                                        <i class="icon-basket-loaded font-large-2 white"></i>
                                    </div>
                                    <div class="p-2 bg-gradient-x-warning white media-body">
                                        <h5>{{trans('dashboard.today_sales')}}</h5>
                                        <h5 class="text-bold-400 mb-0"><i
                                                    class="ft-arrow-up"></i><span id="dash_2"><i
                                                        class="fa fa-spinner spinner"></i></span>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="media align-items-stretch">
                                    <div class="p-2 text-center bg-danger bg-darken-2">
                                        <i class="icon-notebook font-large-2 white"></i>
                                    </div>
                                    <div class="p-2 bg-gradient-x-danger white media-body">
                                        <h5>{{trans('dashboard.month_invoices')}}</h5>
                                        <h5 class="text-bold-400 mb-0"><i
                                                    class="ft-arrow-up"></i><span id="dash_3"><i
                                                        class="fa fa-spinner spinner"></i></span>
                                        </h5>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="media align-items-stretch">
                                    <div class="p-2 text-center bg-success bg-darken-2">
                                        <i class="icon-wallet font-large-2 white"></i>
                                    </div>
                                    <div class="p-2 bg-gradient-x-success white media-body">
                                        <h5>{{trans('dashboard.month_sales')}}</h5>
                                        <h5 class="text-bold-400 mb-0"><i
                                                    class="ft-arrow-up"></i> <span id="dash_4"><i
                                                        class="fa fa-spinner spinner"></i></span>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Stats -->
                <!--Product sale & buyers -->
                <div class="row match-height">
                    <div class="col-xl-8 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{trans('dashboard.sales_invoice_graph')}}</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="reload-a"><i class="ft-shopping-cart"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div id="products-sales" class="height-300"></div>
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-6 col-12">
                                            <div class="card">
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <div class="media">
                                                            <div class="media-body text-left w-100">
                                                                <h3 class="info"><span id="dash_5"><i
                                                                                class="fa fa-spinner spinner"></i></span>
                                                                </h3>
                                                                <span>{{trans('dashboard.today_sales')}}</span>
                                                            </div>

                                                        </div>
                                                        <div class="progress progress-sm mt-1 mb-0">
                                                            <div class="progress-bar bg-info" role="progressbar"
                                                                 style="width: 80%"
                                                                 aria-valuenow="25" aria-valuemin="0"
                                                                 aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-12">
                                            <div class="card">
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <div class="media">
                                                            <div class="media-body text-left w-100">
                                                                <h3 class="success"><span id="dash_6"><i
                                                                                class="fa fa-spinner spinner"></i></span>
                                                                </h3>
                                                                <span>{{trans('dashboard.today_income')}}</span>
                                                            </div>

                                                        </div>
                                                        <div class="progress progress-sm mt-1 mb-0">
                                                            <div class="progress-bar bg-success" role="progressbar"
                                                                 style="width: 80%"
                                                                 aria-valuenow="25" aria-valuemin="0"
                                                                 aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-12">
                                            <div class="card">
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <div class="media">
                                                            <div class="media-body text-left w-100">
                                                                <h3 class="danger"><span id="dash_7"><i
                                                                                class="fa fa-spinner spinner"></i></span>
                                                                </h3>
                                                                <span>{{trans('dashboard.today_expenses')}}</span>
                                                            </div>

                                                        </div>
                                                        <div class="progress progress-sm mt-1 mb-0">
                                                            <div class="progress-bar bg-danger" role="progressbar"
                                                                 style="width: 80%"
                                                                 aria-valuenow="25" aria-valuemin="0"
                                                                 aria-valuemax="100"></div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-12">
                                            <div class="card">
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <div class="media">
                                                            <div class="media-body text-left w-100">
                                                                <h3 class="purple"><span id="dash_8"><i
                                                                                class="fa fa-spinner spinner"></i></span>
                                                                </h3>
                                                                <span>{{trans('dashboard.today_revenue')}}</span>
                                                            </div>

                                                        </div>
                                                        <div class="progress progress-sm mt-1 mb-0">
                                                            <div class="progress-bar bg-purple" role="progressbar"
                                                                 style="width: 80%"
                                                                 aria-valuenow="25" aria-valuemin="0"
                                                                 aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{trans('dashboard.recent_buyers')}}</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="reload1"><i class="ft-users"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content px-1">
                                <div id="recent-buyers_p" class="media-list height-450 position-relative">
                                    @foreach($data['customers'] as $customer)
                                        <a href="#" class="media border-0">
                                            <div class="media-left pr-1">
                                            <span class="avatar avatar-md avatar-online"><img
                                                        class="media-object rounded-circle"
                                                        src="{{Storage::disk('public')->url('app/public/img/customer/' . $customer->customer->picture)}}">
                                                <i></i>
                                            </span>
                                            </div>
                                            <div class="media-body w-100">
                                                <h6 class="list-group-item-heading">{{$customer->customer->name}}<span
                                                            class="  float-right st-{{$customer['status']}} ml-1">{{trans('payments.'.$customer['status'])}}</span>
                                                </h6>
                                                <p class="list-group-item-text mb-0">
                                                </p>
                                            </div>
                                        </a>

                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--/ Product sale & buyers -->
                <!--Recent Orders & Monthly Salse -->
                <div class="row match-height">
                    <div class="col-xl-8 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{trans('dashboard.recent_invoices')}}</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a href="{{route('biller.invoices.create')}}"
                                               class="btn btn-primary btn-sm rounded">{{trans('invoices.add_sale')}}</a>
                                        </li>
                                        <li><a href="{{route('biller.invoices.index')}}"
                                               class="btn btn-success btn-sm rounded">{{trans('invoices.manage_invoices')}}</a>
                                        </li>
                                        <li></li>


                                    </ul>
                                </div>
                            </div>
                            <div class="card-content">

                                <div class="table-responsive">
                                    <table id="recent-orders"
                                           class="table table-hover mb-0 ps-container ps-theme-default">
                                        <thead>
                                        <tr>
                                            <th>{{ trans('invoices.invoice')}}</th>
                                            <th>{{ trans('customers.customer') }}</th>
                                            <th>{{ trans('invoices.invoice_due_date') }}</th>
                                            <th>{{ trans('general.amount') }}</th>
                                            <th>{{ trans('general.status') }}</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $prefixes=prefixes();

                                        @endphp
                                        @foreach($data['invoices'] as $invoice)

                                            <tr>
                                                <td class="text-truncate"><a
                                                            href="{{route('biller.invoices.show',[$invoice['id']])}}">@switch($invoice['i_class'])
                                                            @case(0)
                                                            {{$prefixes->where('class','=',1)->first()->value}}
                                                            @break
                                                            @case(1)
                                                            {{$prefixes->where('class','=',10)->first()->value}}
                                                            @break
                                                            @case($invoice['i_class']>1)
                                                            {{$prefixes->where('class','=',6)->first()->value}}
                                                            @break
                                                        @endswitch #{{$invoice['tid']}}</a></td>
                                                <td class="text-truncate">{{$invoice->customer->name}}</td>
                                                <td class="text-truncate">{{dateFormat($invoice['invoiceduedate'])}}</td>
                                                <td class="text-truncate">{{amountFormat($invoice['total'])}}</td>
                                                <td class="text-truncate"><span
                                                            class="st-{{$invoice['status']}}">{{trans('payments.'.$invoice['status'])}}</span>
                                                </td>

                                            </tr>

                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-header">
                                    <div class="chart-title mb-1 text-center">
                                        <h3>{{trans('dashboard.income_vs_expenses')}}</h3>
                                    </div>
                                    <hr>
                                </div>
                                <div class="card-body sales-growth-chart">

                                    <div class="dashboard-sales-breakdown-chart height-350"
                                         id="income-compare-chart"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!--/Recent Orders & Monthly Salse -->
                <div class="row match-height">
                    <div class="col-xl-8 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{trans('dashboard.recent')}} <a
                                            href="{{route('biller.transactions.index')}}"
                                            class="btn btn-primary btn-sm rounded">{{trans('transactions.transactions')}}</a>
                                </h4>
                                <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="reload1"><i class="ft-books
"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table class="table table-hover mb-1">
                                        <thead>
                                        <tr>
                                            <th>{{trans('transactions.payment_date')}}</th>
                                            <th>{{ trans('transactions.account_id') }}</th>
                                            <th>{{ trans('transactions.debit') }}</th>
                                            <th>{{ trans('transactions.credit') }}</th>

                                            <th>{{ trans('transactions.method') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>


                                        @foreach ($transactions as $item)

                                            <tr>
                                                <td class="text-truncate"><a
                                                            href="{{route('biller.transactions.show',[$item['id']])}}">{{dateFormat($item['payment_date'])}}
                                                        #{{$item['id']}}</a></td>
                                                <td class="text-truncate">{{@$item->account->holder}}</td>
                                                <td class="text-truncate">{{amountFormat($item['debit'])}} </td>
                                                <td class="text-truncate">{{amountFormat($item['credit'])}}</td>
                                                <td class="text-truncate">{{$item['method']}}</td>
                                            </tr>

                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-12">
                        <div class="card">
                            <div class="card-header ">
                                <h4 class="card-title">{{trans('dashboard.stock_alert')}}</h4>

                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">

                                    @foreach ($data['stock_alert'] as $product)

                                        <li class="list-group-item"><span
                                                    class="badge badge-danger float-xs-right">{{+$product['qty']}} {{$product->product['unit']}}</span>
                                            <a href="{{route('biller.products.show',[$product->product_id])}}">{{$product->product['name']}} {{$product['name']}}   </a><small
                                                    class="purple"> <i
                                                        class="ft-map-pin"></i>{{$product->warehouse['title']}}</small>
                                        </li>

                                    @endforeach

                                </ul>

                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="row">
                <div class="col-xl-7 col-lg-12">
                    <div class="card" id="transactions">

                        <div class="card-body">
                            <h4>{{trans('dashboard.cash_flow')}}</h4>
                            <p>{{trans('dashboard.cash_flow_graph')}}</p>
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1"
                                       href="#sales"
                                       aria-expanded="true">{{trans('accounts.Income')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2"
                                       href="#transactions1"
                                       aria-expanded="false">{{trans('accounts.Expenses')}}</a>
                                </li>


                            </ul>
                            <div class="tab-content pt-1">
                                <div role="tabpanel" class="tab-pane active" id="sales" aria-expanded="true"
                                     data-toggle="tab">
                                    <div id="dashboard-income-chart"></div>

                                </div>
                                <div class="tab-pane" id="transactions1" data-toggle="tab" aria-expanded="false">
                                    <div id="dashboard-expense-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{trans('dashboard.task_manager')}} <a
                                        href="{{route('biller.todo')}}"><i
                                            class="icon-arrow-right deep-orange"></i></a></h4>
                        </div>

                        <div class="card-content  p-1">
                            <div id="daily-activity">
                                <table id="tasks-table"
                                       class="table table-striped table-bordered zero-configuration font-size-base"
                                       cellspacing="0"
                                       width="100%">

                                    <thead>
                                    <tr class="font-size-small">
                                        <th>{{ trans('tasks.task') }}</th>
                                        <th>{{ trans('tasks.start') }}</th>
                                        <th>{{ trans('tasks.duedate') }}</th>
                                        <th>{{ trans('tasks.status') }}</th>

                                    </tr>
                                    </thead>

                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="loader_url" value="{{route('biller.tasks.load')}}">
    <input type="hidden" id="mini_dash" value="{{route('biller.mini_dash')}}">
    <!-- END: Content-->
    @include('focus.projects.modal.task_view')
@endsection
@section('after-styles')
    {!! Html::style('core/app-assets/vendors/css/charts/morris.css') !!}
@endsection
@section('extra-scripts')
    {{ Html::script('core/app-assets/vendors/js/charts/raphael-min.js') }}
    {{ Html::script('core/app-assets/vendors/js/charts/morris.min.js') }}
    {{ Html::script(mix('js/dataTable.js')) }}
    <script type="text/javascript">
        const ps = new PerfectScrollbar('#recent-buyers_p', {
            wheelSpeed: 2,
            wheelPropagation: true,
            minScrollbarLength: 20
        });
        $(window).on("load", function () {

            setTimeout(function () {
                loadDash();
            }, 1500);
        });

        function loadDash() {

            var action_url = $('#mini_dash').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: action_url,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                    var i = 1;
                    //  var obj = jQuery.parseJSON(data);
                    $.each(data.dash, function (key, value) {
                        $('#dash_' + i).text(value);
                        i++;
                    });
                    drawIncomeChart(data.income_chart);
                    drawExpenseChart(data.expense_chart);
                    drawCompareChart(data.inv_exp);
                    sales(data.sales);

                }
            });
            //ajax_end


            var dataTable = $('#tasks-table').dataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                "searching": false,
                "paging": false,
                "info": false,
                "bLengthChange": false,
                "sDom": 't',
                language: {
                    @lang('datatable.strings')
                },
                ajax: {
                    url: '{{ route("biller.tasks.get") }}',
                    type: 'post'
                },
                columns: [
                    {data: 'tags', name: 'tags'},
                    {data: 'start', name: 'start'},
                    {data: 'duedate', name: 'duedate'},
                    {data: 'status', name: 'status'},
                ],
                buttons: [],
                order: [[0, "desc"]],
                searchDelay: 500,
                dom: 'Blfrtip'
            });
            $('#tasks-table_wrapper').removeClass('form-inline');
            window.dispatchEvent(new Event('resize'));

        }

        function drawCompareChart(inv_exp) {
            $('#dashboard-sales-breakdown-chart').empty();
            Morris.Donut({
                element: 'income-compare-chart',
                data: [{
                    label: "{{trans('accounts.Income')}}",
                    value: inv_exp.income
                },
                    {
                        label: "{{trans('accounts.Expenses')}}",
                        value: inv_exp.expense
                    }
                ],
                resize: true,
                colors: ['#34cea7', '#ff6e40'],
                gridTextSize: 6,
                gridTextWeight: 400
            });
        }


        function drawIncomeChart(dataIncome) {
            $('#dashboard-income-chart').empty();
            Morris.Area({
                element: 'dashboard-income-chart',
                data: dataIncome,
                xkey: 'x',
                ykeys: ['y'],
                ymin: 'auto 40',
                labels: ['{{trans('general.amount')}}'],
                xLabels: "day",
                hideHover: 'auto',
                yLabelFormat: function (y) {
                    // Only integers
                    if (y === parseInt(y, 10)) {
                        return y;
                    } else {
                        return '';
                    }
                },
                resize: true,
                lineColors: [
                    '#00A5A8',
                ],
                pointFillColors: [
                    '#00A5A8',
                ],
                fillOpacity: 0.4,
            });
        }

        function drawExpenseChart(dataExpenses) {

            $('#dashboard-expense-chart').empty();
            Morris.Area({
                element: 'dashboard-expense-chart',
                data: dataExpenses,
                xkey: 'x',
                ykeys: ['y'],
                ymin: 'auto 0',
                labels: ['{{trans('general.amount')}}'],
                xLabels: "day",
                hideHover: 'auto',
                yLabelFormat: function (y) {
                    // Only integers
                    if (y === parseInt(y, 10)) {
                        return y;
                    } else {
                        return '';
                    }
                },
                resize: true,
                lineColors: [
                    '#ff6e40',
                ],
                pointFillColors: [
                    '#34cea7',
                ]
            });
        }

        function sales(sales_data) {
            var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            Morris.Area({
                element: 'products-sales',
                data: sales_data,
                xkey: 'y',
                ykeys: ['sales', 'invoices'],
                labels: ['sales', 'invoices'],
                behaveLikeLine: true,
                xLabelFormat: function (x) { // <--- x.getMonth() returns valid index
                    var day = x.getDate();
                    var month = months[x.getMonth()];
                    return day + ' ' + month;
                },
                resize: true,
                pointSize: 0,
                pointStrokeColors: ['#00B5B8', '#FA8E57', '#F25E75'],
                smooth: true,
                gridLineColor: '#E4E7ED',
                numLines: 6,
                gridtextSize: 14,
                lineWidth: 0,
                fillOpacity: 0.9,
                hideHover: 'auto',
                lineColors: ['#00B5B8', '#F25E75']
            });
        }

        $('a[data-toggle=tab').on('shown.bs.tab', function (e) {
            window.dispatchEvent(new Event('resize'));
        });
    </script>
@endsection
