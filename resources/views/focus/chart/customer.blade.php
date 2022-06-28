$(document).ready(function () {
var cat_data = [
<?php foreach ($chart_result as $item) {
    echo '{y: "' . $item->customer['name'] . '", a: ' . $item['amount'] . ' },';
}
?>
];
draw_c(cat_data);
});

function draw_c(cat_data) {
$('#result-chart').empty();
Morris.Bar({
element: 'result-chart',
data: cat_data,
xkey: 'y',
ykeys: ['a'],
labels: ['{{trans('general.amount')}}'],
barColors: [
'#008319',
],
barFillColors: [
'#0089CE',
],
barOpacity: 0.6,
});
}