$(document).ready(function () {
var cat_data = [
<?php foreach ($chart_result as $item) {
    echo '{y: "' . $item['product_name'] . '", a: ' . $item['amount'] . ' },';
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
labels: ['{{trans('products.qty')}}'],
barColors: [
'#0089CE',
],
barFillColors: [
'#34cea7',
],
barOpacity: 0.6,
});
}