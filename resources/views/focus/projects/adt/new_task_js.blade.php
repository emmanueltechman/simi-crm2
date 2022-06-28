$("#submit-data_tasks").on("click", function (e) {
e.preventDefault();
var form_data = [];
form_data['form'] = $("#data_form_task").serialize();
form_data['url'] = $('#action-url_task').val();
$('#AddTaskModal').modal('toggle');
addObject(form_data, true);
});
$('#AddTaskModal').on('shown.bs.modal', function () {
$('[data-toggle="datepicker"]').datepicker({
autoHide: true,
format: '{{config('core.user_date_format')}}'
});
$('.from_date').datepicker('setDate', 'today');
$('.from_date').datepicker({autoHide: true, format: '{{date(config('core.user_date_format'))}}'});
$('.to_date').datepicker('setDate', '{{dateFormat(date('Y-m-d', strtotime('+30 days', strtotime(date('Y-m-d')))))}}');
$('.to_date').datepicker({autoHide: true, format: '{{date(config('core.user_date_format'))}}'});
$("#tags").select2();
$("#employee").select2();
$("#projects").select2();
$('#color_t').colorpicker();
});

