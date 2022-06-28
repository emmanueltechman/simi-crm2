@extends ('core.layouts.app')
@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-content collapse show">
                            <div class="card-body">
                                <form class="col-3">
                                    <div class="form-group d-flex justify-content-between">
                                        <label class="col-form-label pr-2">Language:</label>
                                        <div class="full-calender-languages">
                                            <select id='lang-selector' class="custom-select form-control"></select>
                                        </div>
                                    </div>
                                </form>

                                <div id='fc-languages'></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('after-styles')
    {{ Html::style('core/app-assets/vendors/css/calendars/fullcalendar.min.css') }}
    {{ Html::style('core/app-assets/css-'.visual().'/plugins/calendars/fullcalendar.css') }}

@endsection
@section('after-scripts')
    {{ Html::script('core/app-assets/vendors/js/extensions/moment.min.js') }}
    {{ Html::script('core/app-assets/vendors/js/extensions/fullcalendar.min.js') }}
    {{ Html::script('core/app-assets/vendors/js/extensions/gcal.js') }}
    {{ Html::script('core/app-assets/vendors/js/extensions/locale-all.js') }}

    <script type="text/javascript">
        $(function () {

            /****************************************
             *                Languages                *
             ****************************************/
            var initialLocaleCode = 'en';

            $('#fc-languages').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay,listMonth'
                },
                defaultDate: '{{date('Y-m-d')}}',
                locale: initialLocaleCode,
                buttonIcons: false, // show the prev/next text
                weekNumbers: true,
                navLinks: true, // can click day/week names to navigate views
                editable: false,
                eventLimit: true, // allow "more" link when too many events
                events: '{{route('biller.load_attendance')}}'
            });

            // build the locale selector's options
            $.each($.fullCalendar.locales, function (localeCode) {
                $('#lang-selector').append(
                    $('<option/>')
                        .attr('value', localeCode)
                        .prop('selected', localeCode == initialLocaleCode)
                        .text(localeCode)
                );
            });

            // when the selected option changes, dynamically change the calendar option
            $('#lang-selector').on('change', function () {
                if (this.value) {
                    $('#fc-languages').fullCalendar('option', 'locale', this.value);
                }
            });
        });

    </script>
@endsection