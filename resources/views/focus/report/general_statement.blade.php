@extends ('core.layouts.app')
@section ('title', $lang['title'].' | ' . trans('features.reports'))
@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-body">
                <div class="card">
                    <div class="card-header">
                        <h5> {{$lang['title']}}</h5>
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                <li><a data-action="close"><i class="ft-x"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content">
                        <div id="notify" class="alert alert-success" style="display:none;">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>

                            <div class="message"></div>
                        </div>
                        <div class="card-body">
                            @include('focus.report.'.$lang['module'])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('extra-scripts')
    {{ Html::script('focus/js/select2.min.js') }}
    <script type="text/javascript">
        $('[data-toggle="datepicker"]').datepicker({
            autoHide: true,
            format: '{{config('core.user_date_format')}}'
        });
        $('.from_date').datepicker('setDate', '{{dateFormat(date('Y-m-d', strtotime('-30 days', strtotime(date('Y-m-d')))))}}');
        $('.from_date').datepicker({autoHide: true, format: '{{date(config('core.user_date_format'))}}'});
        $('.to_date').datepicker('setDate', 'today');
        $('.to_date').datepicker({autoHide: true, format: '{{date(config('core.user_date_format'))}}'});

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#person").select2({
            tags: [],
            ajax: {
                @if($lang['module']=='customer_statement' OR $lang['module']=='product_customer_statement')
                url: '{{route('biller.customers.select')}}',
                @elseif($lang['module']=='supplier_statement' OR $lang['module']=='product_supplier_statement')
                url: '{{route('biller.suppliers.select')}}',
                @endif
                dataType: 'json',
                type: 'POST',
                quietMillis: 50,
                data: function (person) {
                    return {
                        person: person
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                },
            }
        });

        $("#products_l").select2();
        $("#wfrom").on('change', function () {
            var tips = $('#wfrom').val();
            $("#products_l").select2({

                tags: [],
                ajax: {
                    url: '{{route('biller.products.product_search_post',['label'])}}',
                    dataType: 'json',
                    type: 'POST',
                    quietMillis: 50,
                    data: function (product) {

                        return {
                            keyword: product,
                            wid: tips

                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    },
                }
            });
        });

    </script>
@endsection
