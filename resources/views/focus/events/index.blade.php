@extends ('core.layouts.app')

@section ('title', trans('labels.backend.events.management'))

@section('page-header')
    <h1>{{ trans('labels.backend.events.management') }}</h1>
@endsection

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

                                <div id='events_cal'>
                                    <div class="text-center font-large-1 purple"><i class="fa fa-spinner spinner"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="event_interface">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                </div>
                <div class="modal-body">
                    <div class="error"></div>
                    <form id="event-form">


                        <div class="row form-group">
                            <label class="col-md-2 control-label"
                                   for="title">{{trans('general.title')}}</label>
                            <div class="col-md-8">
                                <input id="title" name="title" type="text" class="form-control input-md"/>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-2"
                                   for="description">{{trans('general.description')}}</label>
                            <div class="col-md-8">
                                <textarea class="form-control" id="description" name="description" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-2"
                                   for="description">{{trans('miscs.color')}}</label>
                            <div class="col-md-2">
                                {{ Form::text('color', '#0b97f4', ['class' => 'form-control round', 'id'=>'color','placeholder' => trans('miscs.color'),'autocomplete'=>'off']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 col-xs-12 mt-1">
                                <div class="row">
                                    <label class="col-sm-4 col-xs-6 control-label"
                                           for="sdate">{{trans('meta.from_date')}}</label>

                                    <div class="col-sm-6 col-xs-6">
                                        <input type="text" class="form-control from_date required"
                                               placeholder="Start Date" name="start" id="start"
                                               autocomplete="false" data-toggle="datepicker">

                                        <input type="time" id="time_from" name="time_from" class="form-control"
                                               value="00:00">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12 mt-1">
                                <div class="row">
                                    <label class="col-sm-4 col-xs-6  control-label"
                                           for="sdate">{{trans('meta.to_date')}}</label>

                                    <div class="col-sm-6 col-xs-6 ">
                                        <input type="text" class="form-control required to_date"
                                               placeholder="End Date" name="end" id="end"
                                               data-toggle="datepicker" autocomplete="false">

                                        <input type="time" name="time_to" id="time_to" class="form-control"
                                               value="23:59">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-amber"
                            data-dismiss="modal">{{trans('general.close')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after-styles')
    {{ Html::style('core/app-assets/vendors/css/calendars/fullcalendar.min.css') }}
    {{ Html::style('core/app-assets/css-'.visual().'/plugins/calendars/fullcalendar.css') }}
    {!! Html::style('focus/css/bootstrap-colorpicker.min.css') !!}

@endsection
@section('after-scripts')
    {{ Html::script('core/app-assets/vendors/js/extensions/moment.min.js') }}
    {{ Html::script('core/app-assets/vendors/js/extensions/fullcalendar.min.js') }}
    {{ Html::script('core/app-assets/vendors/js/extensions/gcal.js') }}
    {{ Html::script('core/app-assets/vendors/js/extensions/locale-all.js') }}
    {{ Html::script('focus/js/bootstrap-colorpicker.min.js') }}

    <script type="text/javascript">
        $(function () {
            setTimeout(function () {
                draw_data()
            }, {{config('master.delay')}});
        });

        function draw_data() {
            $('[data-toggle="datepicker"]').datepicker({
                autoHide: true,
                format: '{{config('core.user_date_format')}}'
            });
            /****************************************
             *                Languages                *
             ****************************************/
            var initialLocaleCode = 'en';

            $('#events_cal').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay,listMonth'
                },
                defaultDate: '{{date('Y-m-d')}}',
                locale: initialLocaleCode,
                buttonIcons: true, // show the prev/next text
                weekNumbers: true,
                navLinks: true, // can click day/week names to navigate views
                editable: true,
                resizable: true,

                selectable: true,
                selectHelper: true,
                eventLimit: true, // allow "more" link when too many events
                events: '{{route('biller.events.load_events')}}'
                , // Make the event resizable true
                select: function (start, end) {

                    //$('#start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
                    //  $('#end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
                    // Open modal to add event
                @permission('create-event')
                    modal({
                        // Available buttons when adding
                        buttons: {
                            add: {
                                id: 'add-event', // Buttons id
                                css: 'btn-success', // Buttons class
                                label: 'Add' // Buttons label
                            }
                        },
                        title: 'Add Event',
                        start: start.format('{{config('core.user_date_format')}}'),
                        end: end.format('{{config('core.user_date_format')}}'),
                        start_to: '00:00',
                        end_to: '00:00',
                    });
                    $('#event-form input ').removeAttr('readonly');
                    $('#event-form textarea ').removeAttr('readonly');
                    @endauth
                },

                eventDrop: function (event, delta, revertFunc, start, end, id) {
                @permission('edit-event')
                    start = event.start.format('YYYY-MM-DD HH:mm:ss');
                    if (event.end) {
                        end = event.end.format('YYYY-MM-DD HH:mm:ss');
                    } else {
                        end = start;
                    }

                    $.post('{{route('biller.events.update_event')}}', 'id=' + event.id + '&start=' + start + '&end=' + end + '&' + crsf_token + '=' + crsf_hash, function (result) {
                        $('.alert').addClass('alert-success').text('Event updated successful');
                        $('.modal').modal('hide');
                        $('#events_cal').fullCalendar("refetchEvents");
                        hide_notify();

                    });
                    @endauth


                },
                eventResize: function (event, dayDelta, minuteDelta, revertFunc) {


                },

                // Event Mouseover
                eventMouseover: function (calEvent, jsEvent, view) {

                    var tooltip = '<div class="event-tooltip">' + calEvent.description + '</div>';
                    $("body").append(tooltip);

                    $(this).mouseover(function (e) {
                        $(this).css('z-index', 10000);
                        $('.event-tooltip').fadeIn('500');
                        $('.event-tooltip').fadeTo('10', 1.9);
                    }).mousemove(function (e) {
                        $('.event-tooltip').css('top', e.pageY + 10);
                        $('.event-tooltip').css('left', e.pageX + 20);
                    });
                },
                eventMouseout: function (calEvent, jsEvent) {
                    $(this).css('z-index', 8);
                    $('.event-tooltip').remove();
                },
                // Handle Existing Event Click
                eventClick: function (calEvent, jsEvent, view) {
                    // Set currentEvent variable according to the event clicked in the calendar
                    currentEvent = calEvent;
                    if (!currentEvent.end) currentEvent.end = currentEvent.start;
                    // Open modal to edit or delete event
                    modal({
                        // Available buttons when editing
                        buttons: {
                            @permission('delete-event')               delete: {
                                id: 'delete-event',
                                css: 'btn-danger',
                                label: 'Delete'
                            }, @endauth
                                @permission('edit-event')                     update: {
                                id: 'update-event',
                                css: 'btn-success',
                                label: 'Update'
                            }  @endauth
                        },
                        title: '{{trans('general.event')}} ' + calEvent.title + '',
                        event: calEvent,
                        start: currentEvent.start.format('{{config('core.user_date_format')}}'),
                        end: currentEvent.end.format('{{config('core.user_date_format')}}'),
                        start_to: currentEvent.start.format('HH:mm'),
                        end_to: currentEvent.end.format('HH:mm'),
                    });

                    $('#update-event').hide();
                @permission('edit-event')
                    $('.modal-footer').prepend('<button type="button" id="update-event-unlock" class="btn btn-success">{{trans('general.edit')}}</button>');
                    @endauth
                    $('#event-form input ').attr('readonly', 'readonly');
                    $('#event-form textarea ').attr('readonly', 'readonly');

                }
            });

            $('#event_interface').on('shown.bs.modal', function () {
                $('#color').colorpicker();
            });


            // Handle Click on Add Button
            $('.modal').on('click', '#add-event', function (e) {
                if (validator(['title', 'description'])) {
                    $.post('{{route('biller.events.store')}}', $('#event-form').serialize(), function (result) {

                        if ($("#notify").length == 0) {
                            $("#c_body").html('<div id="notify" class="alert m-1" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message"></div></div>');
                        }
                        $("#notify .message").html(result);
                        $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                        $("html, body").scrollTop($("body").offset().top);


                        $('.modal').modal('hide');
                        $('#events_cal').fullCalendar("refetchEvents");
                        //hide_notify();
                    });
                }
            });


            // Handle click on Update Button
            $('.modal').on('click', '#update-event', function (e) {
                $.post('{{route('biller.events.update_event')}}', 'id=' + currentEvent.id + '&' + $('#event-form').serialize(), function (result) {
                    $('.alert').addClass('alert-success').text('Event updated successful');
                    $('.modal').modal('hide');
                    $('#events_cal').fullCalendar("refetchEvents");
                    hide_notify();
                });
            });

            $('.modal').on('click', '#update-event-unlock', function (e) {
                $('#event-form input ').removeAttr('readonly');
                $('#event-form textarea').removeAttr('readonly');
                $('#update-event').show();
                $('#update-event-unlock').hide();

            });

            // Handle Click on Delete Button

            $('.modal').on('click', '#delete-event', function (e) {
                $.post('{{route('biller.events.delete_event')}}', 'id=' + currentEvent.id, function (result) {
                    $('.alert').addClass('alert-success').text('Event deleted successful !');
                    $('.modal').modal('hide');
                    $('#events_cal').fullCalendar("refetchEvents");
                    hide_notify();
                });
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
                    $('#events_cal').fullCalendar('option', 'locale', this.value);
                }
            });
        }

        function hide_notify() {
            setTimeout(function () {
                $('.alert').removeClass('alert-success').text('');
            }, 4000);
        }


        // Dead Basic Validation For Inputs
        function validator(elements) {
            var errors = 0;
            $.each(elements, function (index, element) {
                if ($.trim($('#' + element).val()) == '') errors++;
            });
            if (errors) {
                $('.error').html('Please insert title and description');
                return false;
            }
            return true;
        }

        // Prepares the modal window according to data passed
        function modal(data) {
            // Set modal title
            $('.modal-title').html(data.title);
            // Clear buttons except Cancel
            $('.modal-footer button:not(".btn-default")').remove();
            // Set input values
            $('#title').val(data.event ? data.event.title : '');
            $('#description').val(data.event ? data.event.description : '');
            $('#color').val(data.event ? data.event.color : '#3a87ad');
            $('.from_date').datepicker('setDate', data.start);
            $('.to_date').datepicker('setDate', data.end);
            $('#time_from').val(data.start_to);
            $('#time_to').val(data.end_to);
            // Create Butttons
            $.each(data.buttons, function (index, button) {
                $('.modal-footer').prepend('<button type="button" id="' + button.id + '" class="btn ' + button.css + '">' + button.label + '</button>')
            })
            //Show Modal
            $('.modal').modal('show');
        }


    </script>
@endsection
