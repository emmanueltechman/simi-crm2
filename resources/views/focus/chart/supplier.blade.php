$(document).ready(function () {
var cat_data = [
<?php foreach ($chart_result as $item) {
    echo '{y: "' . $item->supplier['name'] . '", a: ' . $item['amount'] . ' },';
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
'#85362b',
],
barFillColors: [
'#34cea7',
],
barOpacity: 0.6,
});
}