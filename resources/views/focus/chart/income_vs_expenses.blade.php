$(document).ready(function () {
var cat_data = [{label: "{{trans('accounts.Income')}}", value: {{intval($chart_result['income'])}}},{label: "{{trans('accounts.Expenses')}}",  value: {{intval($chart_result['expense'])}}}
];
draw_c(cat_data);
});

function draw_c(cat_data) {
var cat_color = ['#4DB380', '#E64D66',
];
$('#result-chart').empty();

Morris.Donut({
element: 'result-chart',
data: cat_data,
resize: true,
colors: cat_color,
gridTextSize: 6,
gridTextWeight: 400
});
}
