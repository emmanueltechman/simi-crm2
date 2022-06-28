var billtype = $('#billtype').val();
$('#addproduct').on('click', function () {
    var cvalue = parseInt($('#ganak').val()) + 1;
    var nxt = parseInt(cvalue);
    $('#ganak').val(nxt);
    var functionNum = "'" + cvalue + "'";
    count = $('#saman-row div').length;
//product row
    var data = '<tr><td><input type="text" class="form-control" name="product_name[]" placeholder="Enter Product name or Code" id="productname-' + cvalue + '"></td><td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1" ><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td> <td><input type="text" class="form-control req prc" name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td><td> <input type="text" class="form-control vat" name="product_tax[]" id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td> <td id="texttaxa-' + cvalue + '" class="text-center">0</td> <td><input type="text" class="form-control discount" name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td> <td><span class="currenty">' + currency + '</span> <strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span></strong></td> <td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="total_tax[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="total_discount[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="product_id[]" id="pid-' + cvalue + '" value="0"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" attr-org="" value=""> <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""><input type="hidden" name="unit_m[]" id="unit_m-' + cvalue + '" value="1"> <input type="hidden" name="serial[]" id="serial-' + cvalue + '" value=""></tr><tr><td colspan="6"><textarea class="form-control"  id="dpid-' + cvalue + '" name="product_description[]" placeholder="Enter Product description" autocomplete="off"></textarea><br></td> <td colspan="2"><select class="form-control unit" data-uid="' + cvalue + '" name="u_m[]" style="display: none"></select></td></tr>';
    //ajax request
    // $('#saman-row').append(data);
    $('tr.last-item-row').before(data);

    row = cvalue;

    $('#productname-' + cvalue).autocomplete({
        source: function (request, response) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseurl + 'products/search/' + billtype,
                dataType: "json",
                method: 'post',
                data: 'keyword=' + request.term + '&type=product_list&row_num=' + row + '&wid=' + $("#s_warehouses option:selected").val() + '&serial_mode=' + $("#serial_mode:checked").val(),
                success: function (data) {
                    response($.map(data, function (item) {
                        return {
                            label: item.name,
                            value: item.name,
                            data: item
                        };
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function (event, ui) {
            id_arr = $(this).attr('id');
            id = id_arr.split("-");
            var t_r = ui.item.data.taxrate;
            var custom = accounting.unformat($("#taxFormat option:selected").val(), accounting.settings.number.decimal);
            if (custom > 0) {
                t_r = custom;
            }
            var discount = ui.item.data.disrate;
            var dup;
            var custom_discount = $('#custom_discount').val();
            if (custom_discount > 0) discount = deciFormat(custom_discount);
            $('.pdIn').each(function () {
                if ($(this).val() == ui.item.data.id) dup = true;
            });
            if (dup) {
                alert('Already Exists!!');
                return;
            }
            $('#amount-' + id[1]).val(1);
            $('#price-' + id[1]).val(accounting.formatNumber(ui.item.data.price));
            $('#pid-' + id[1]).val(ui.item.data.id);
            $('#vat-' + id[1]).val(accounting.formatNumber(t_r));
            $('#discount-' + id[1]).val(accounting.formatNumber(discount));
            $('#dpid-' + id[1]).val(ui.item.data.product_des);
            $('#unit-' + id[1]).val(ui.item.data.unit).attr('attr-org', ui.item.data.unit);
            $('#hsn-' + id[1]).val(ui.item.data.code);
            $('#alert-' + id[1]).val(ui.item.data.alert);
            $('#serial-' + id[1]).val(ui.item.data.serial);

            rowTotal(cvalue);
            billUpyog();
            if (typeof unit_load === "function") {
                unit_load();
                $('.unit').show();
            }
        },
        create: function (e) {
            $(this).prev('.ui-helper-hidden-accessible').remove();
        }
    });

});

//caculations
var precentCalc = function (total, percentageVal) {
    var pr = (total / 100) * percentageVal;
    return parseFloat(pr);
};
//format
var deciFormat = function (minput) {
    if (!minput) minput = 0;
    return parseFloat(minput).toFixed(2);
};
var formInputGet = function (iname, inumber) {
    var inputId;
    inputId = iname + '-' + inumber;
    var inputValue = $(inputId).val();

    if (inputValue == '') {

        return 0;
    } else {
        return inputValue;
    }
};

//ship calculation
var coupon = function () {
    var cp = 0;
    if ($('#coupon_amount').val()) {
        cp = accounting.unformat($('#coupon_amount').val(), accounting.settings.number.decimal);
    }
    return cp;
};
var shipTot = function () {
    var ship_val = accounting.unformat($('.shipVal').val(), accounting.settings.number.decimal);
    var ship_p = 0;
    if ($("#taxFormat option:selected").attr('data-trate')) {
        var ship_rate = $("#taxFormat option:selected").attr('data-trate');
    } else {
        var ship_rate = accounting.unformat($('#ship_rate').val(), accounting.settings.number.decimal);
    }
    var tax_status = $("#ship_taxtype").val();
    if (tax_status == 'exclusive') {
        ship_p = (ship_val * ship_rate) / 100;
        ship_val = ship_val + ship_p;
    } else if (tax_status == 'inclusive') {
        ship_p = (ship_val * ship_rate) / (100 + ship_rate);
    }
    $('#ship_tax').val(accounting.formatNumber(ship_p));
    $('#ship_final').html(accounting.formatNumber(ship_p));
    return ship_val;
};

//product total
var samanYog = function () {
    var itempriceList = [];
    var idList = [];
    var r = 0;
    $('.ttInput').each(function () {
        var vv = accounting.unformat($(this).val(), accounting.settings.number.decimal);
        var vid = $(this).attr('id');
        vid = vid.split("-");
        itempriceList.push(vv);
        idList.push(vid[1]);
        r++;
    });
    var sum = 0;
    var taxc = 0;
    var discs = 0;
    for (var z = 0; z < idList.length; z++) {
        var x = idList[z];
        if (itempriceList[z] > 0) {
            sum += itempriceList[z];
        }
        var t1 = accounting.unformat($("#taxa-" + x).val(), accounting.settings.number.decimal);
        var d1 = accounting.unformat($("#disca-" + x).val(), accounting.settings.number.decimal);
        if (t1 > 0) {
            taxc += t1;
        }
        if (d1 > 0) {
            discs += d1;
        }
    }

    $("#discs").html(accounting.formatNumber(discs));
    $("#taxr").html(accounting.formatNumber(taxc));
    return accounting.unformat(sum, accounting.settings.number.decimal);
};

//actions
var deleteRow = function (num) {
    var totalSelector = $("#subttlform");
    var prodttl = accounting.unformat($("#total-" + num).val(), accounting.settings.number.decimal);
    var subttl = accounting.unformat(totalSelector.val(), accounting.settings.number.decimal);
    var totalSubVal = subttl - prodttl;
    totalSelector.val(totalSubVal);
    $("#subttlid").html(accounting.formatNumber(totalSubVal));
    var totalBillVal = totalSubVal + shipTot - coupon;
    //final total
    var clean = accounting.formatNumber(totalBillVal);
    $("#mahayog").html(clean);
    $("#invoiceyoghtml").val(clean);
    $("#invoiceyoghtml").html(clean);
};


var billUpyog = function () {
    var out = 0;
    var disc_val = accounting.unformat($('.discVal').val(), accounting.settings.number.decimal);
    if (disc_val) {
        $("#subttlform").val(accounting.formatNumber(samanYog()));
        var disc_rate = $('#discountFormat option:selected').attr('data-type1');

        switch (disc_rate) {
            case '%':
                out = precentCalc(accounting.unformat($('#subttlform').val(), accounting.settings.number.decimal), disc_val);
                break;
            case 'b_per':
                out = precentCalc(accounting.unformat($('#subttlform').val(), accounting.settings.number.decimal), disc_val);
                break;
            case 'flat':
                out = accounting.unformat(disc_val, accounting.settings.number.decimal);
                break;
            case 'b_flat':
                out = accounting.unformat(disc_val, accounting.settings.number.decimal);
                break;
        }
        out = parseFloat(out).toFixed(two_fixed);

        $('#disc_final').html(accounting.formatNumber(out));
        $('#after_disc').val(accounting.formatNumber(out));
    } else {
        $('#disc_final').html(0);
    }
    var totalBillVal = accounting.formatNumber(samanYog() + shipTot() - coupon() - out);
    $("#mahayog").html(totalBillVal);
    $("#subttlform").val(accounting.formatNumber(samanYog()));
    $("#invoiceyoghtml").val(totalBillVal);
    $("#bigtotal").html(totalBillVal);
};


var rowTotal = function (numb) {
    //most res
    var result;
    var page = '';
    var totalValue = 0;
    var amountVal = accounting.unformat($("#amount-" + numb).val(), accounting.settings.number.decimal);
    var priceVal = accounting.unformat($("#price-" + numb).val(), accounting.settings.number.decimal);
    var discountVal = accounting.unformat($("#discount-" + numb).val(), accounting.settings.number.decimal);
    var vatVal = accounting.unformat($("#vat-" + numb).val(), accounting.settings.number.decimal);
    var taxo = 0;
    var disco = 0;
    var totalPrice = amountVal.toFixed(two_fixed) * priceVal;
    var tax_status = $("#taxFormat option:selected").attr('data-type2');
    var disFormat = $("#discount_format").val();
    if ($("#inv_page").val() == 'new_i' && formInputGet("#pid", numb) > 0) {
        var alertVal = accounting.unformat($("#alert-" + numb).val(), accounting.settings.number.decimal);
        if (alertVal <= +amountVal) {
            var aqt = alertVal - amountVal;
            alert('Low Stock! ' + accounting.formatNumber(aqt));
        }
    }
    //tax after bill

    if (tax_status == 'exclusive') {
        if (disFormat == '%' || disFormat == 'flat') {
            //tax

            var Inpercentage = precentCalc(totalPrice, vatVal);
            totalValue = totalPrice + Inpercentage;
            taxo = accounting.formatNumber(Inpercentage);
            if (disFormat == 'flat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalValue - discountVal;
            } else if (disFormat == '%') {
                var discount = precentCalc(totalValue, discountVal);
                totalValue = totalValue - discount;
                disco = accounting.formatNumber(discount);
            }

        } else {
//before tax
            if (disFormat == 'b_flat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalPrice - discountVal;
            } else if (disFormat == 'b_per') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = totalPrice - discount;
                disco = accounting.formatNumber(discount);
            }

            //tax
            var Inpercentage = precentCalc(totalValue, vatVal);
            totalValue = totalValue + Inpercentage;
            taxo = accounting.formatNumber(Inpercentage);
        }

    } else if (tax_status == 'inclusive') {
        if (disFormat == '%' || disFormat == 'flat') {
            //tax
            var Inpercentage = (totalPrice * vatVal) / (100 + vatVal);
            totalValue = totalPrice;
            taxo = accounting.formatNumber(Inpercentage);
            if (disFormat == 'flat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalValue - discountVal;
            } else if (disFormat == '%') {
                var discount = precentCalc(totalValue, discountVal);
                totalValue = totalValue - discount;
                disco = accounting.formatNumber(discount);
            }
        } else {
//before tax
            if (disFormat == 'b_flat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalPrice - discountVal;
            } else if (disFormat == 'b_per') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = totalPrice - discount;
                disco = accounting.formatNumber(discount);
            }
            //tax
            var Inpercentage = (totalPrice * vatVal) / (100 + vatVal);
            totalValue = totalValue;
            taxo = accounting.formatNumber(Inpercentage);
        }
    } else {
        taxo = 0;
        if (disFormat == '%' || disFormat == 'flat') {
            if (disFormat == 'flat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalPrice - discountVal;
            } else if (disFormat == '%') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = totalPrice - discount;
                disco = accounting.formatNumber(discount);
            }

        } else {
//before tax
            if (disFormat == 'b_flat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalPrice - discountVal;
            } else if (disFormat == 'b_per') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = totalPrice - discount;
                disco = accounting.formatNumber(discount);
            }
        }
    }

    $("#result-" + numb).html(accounting.formatNumber(totalValue));
    $("#taxa-" + numb).val(taxo);
    $("#texttaxa-" + numb).text(taxo);
    $("#disca-" + numb).val(disco);
    $("#total-" + numb).val(accounting.formatNumber(totalValue));
    samanYog();
};
var changeTaxFormat = function () {
    var t_format = $('#taxFormat option:selected');
    if (t_format.attr('data-type2')) {

        $("#tax_format").val(t_format.attr('data-type2'));
        $("#tax_format_type").val(t_format.attr('data-type3'));
        $("#tax_format_id").val(t_format.attr('data-type4'));
        var trate = t_format.val();

    } else {
        $("#tax_format").val('off');
        var trate = 0;
    }
    var discount_format = $("#discount_format").val();
    trate = accounting.unformat(trate, accounting.settings.number.decimal);
    formatRest(t_format.attr('data-type2'), discount_format, trate);
}

var changeDiscountFormat = function () {
    var d_format = $('#discountFormat option:selected');
    if (d_format.attr('data-type1')) {
        $(".disCol").show();

        $("#discount_format").val(d_format.attr('data-type1'));
    } else {
        $("#discount_format").val(d_format.attr('data-type1'));
        $(".disCol").hide();

    }
    var tax_status = $("#tax_format").val();
    formatRest(tax_status, d_format.attr('data-type1'));
}

function formatRest(taxFormat, disFormat, trate = '') {
    var amntArray = [];
    var idArray = [];

    $('.amnt').each(function () {
        var v = accounting.unformat($(this).val(), accounting.settings.number.decimal);
        var id_e = $(this).attr('id');
        id_e = id_e.split("-");
        idArray.push(id_e[1]);
        amntArray.push(v);
    });
    var prcArray = [];
    $('.prc').each(function () {
        var v = accounting.unformat($(this).val(), accounting.settings.number.decimal);
        prcArray.push(v);
    });
    var vatArray = [];
    $('.vat').each(function () {
        if (trate > 0) {
            var v = accounting.unformat(trate, accounting.settings.number.decimal);
            $(this).val(accounting.formatNumber(v));
        } else {
            var v = accounting.unformat($(this).val(), accounting.settings.number.decimal);
        }
        vatArray.push(v);
    });
    var discountArray = [];
    $('.discount').each(function () {
        var v = accounting.unformat($(this).val(), accounting.settings.number.decimal);
        discountArray.push(v);
    });

    var taxr = 0;
    var discsr = 0;
    for (var i = 0; i < idArray.length; i++) {
        var x = idArray[i];
        amtVal = amntArray[i];
        prcVal = prcArray[i];
        vatVal = vatArray[i];
        discountVal = discountArray[i];
        var result = amtVal * prcVal;
        if (vatVal == '') {
            vatVal = 0;
        }
        if (discountVal == '') {
            discountVal = 0;
        }
        if (taxFormat == 'exclusive') {
            if (disFormat == '%' || disFormat == 'flat') {
                var Inpercentage = precentCalc(result, vatVal);
                var result = result + Inpercentage;
                taxr = taxr + Inpercentage;
                $("#texttaxa-" + x).html(accounting.formatNumber(Inpercentage));
                $("#taxa-" + x).val(accounting.formatNumber(Inpercentage));

                if (disFormat == '%') {
                    var Inpercentage = precentCalc(result, discountVal);
                    result = result - Inpercentage;
                    $("#disca-" + x).val(accounting.formatNumber(Inpercentage));
                    discsr = discsr + Inpercentage;
                } else if (disFormat == 'flat') {
                    result = parseFloat(result) - parseFloat(discountVal);
                    $("#disca-" + x).val(accounting.formatNumber(discountVal));
                    discsr += discountVal;
                }
            } else {
                if (disFormat == 'b_per') {
                    var Inpercentage = precentCalc(result, discountVal);
                    result = result - Inpercentage;
                    $("#disca-" + x).val(accounting.formatNumber(Inpercentage));
                    discsr = discsr + Inpercentage;
                } else if (disFormat == 'b_flat') {
                    result = result - discountVal;
                    $("#disca-" + x).val(accounting.formatNumber(discountVal));
                    discsr += discountVal;
                }

                var Inpercentage = precentCalc(result, vatVal);
                result = result + Inpercentage;
                taxr = taxr + Inpercentage;
                $("#texttaxa-" + x).html(accounting.formatNumber(Inpercentage));
                $("#taxa-" + x).val(accounting.formatNumber(Inpercentage));

            }
        } else if (taxFormat == 'inclusive') {

            if (disFormat == '%' || disFormat == 'flat') {


                var Inpercentage = (result * vatVal) / (100 + vatVal);

                taxr = taxr + Inpercentage;
                $("#texttaxa-" + x).html(accounting.formatNumber(Inpercentage));
                $("#taxa-" + x).val(accounting.formatNumber(Inpercentage));

                if (disFormat == '%') {
                    var Inpercentage = precentCalc(result, discountVal);
                    result = result - Inpercentage;
                    $("#disca-" + x).val(accounting.formatNumber(Inpercentage));
                    discsr = discsr + Inpercentage;
                } else if (disFormat == 'flat') {
                    result = result - discountVal;
                    $("#disca-" + x).val(accounting.formatNumber(discountVal));
                    discsr += discountVal;
                }
            } else {
                if (disFormat == 'b_per') {
                    var Inpercentage = precentCalc(result, discountVal);
                    result = result - Inpercentage;
                    $("#disca-" + x).val(accounting.formatNumber(Inpercentage));
                    discsr = discsr + Inpercentage;
                } else if (disFormat == 'b_flat') {
                    result = result - discountVal;
                    $("#disca-" + x).val(accounting.formatNumber(discountVal));
                    discsr += discountVal;
                }

                var Inpercentage = (result * vatVal) / (100 + vatVal);
                taxr = taxr + Inpercentage;
                $("#texttaxa-" + x).html(accounting.formatNumber(Inpercentage));
                $("#taxa-" + x).val(accounting.formatNumber(Inpercentage));

            }
        } else {

            if (disFormat == '%' || disFormat == 'flat') {

                var result = accounting.unformat($("#amount-" + x).val(), accounting.settings.number.decimal) * accounting.unformat($("#price-" + x).val(), accounting.settings.number.decimal);
                $("#texttaxa-" + x).html('Off');
                $("#taxa-" + x).val(0);
                taxr += 0;

                if (disFormat == '%') {
                    var Inpercentage = precentCalc(result, discountVal);
                    result = result - Inpercentage;
                    $("#disca-" + x).val(accounting.formatNumber(Inpercentage));
                    discsr = discsr + Inpercentage;
                } else if (disFormat == 'flat') {
                    var result = result - discountVal;
                    $("#disca-" + x).val(accounting.formatNumber(discountVal));
                    discsr += discountVal;
                }
            } else {
                if (disFormat == 'b_per') {
                    var Inpercentage = precentCalc(result, discountVal);
                    result = result - Inpercentage;
                    $("#disca-" + x).val(accounting.formatNumber(Inpercentage));
                    discsr = discsr + Inpercentage;
                } else if (disFormat == 'b_flat') {
                    result = result - discountVal;
                    $("#disca-" + x).val(accounting.formatNumber(discountVal));
                    discsr += discountVal;
                }
                $("#texttaxa-" + x).html('Off');
                $("#taxa-" + x).val(0);
                taxr += 0;
            }
        }

        $("#total-" + x).val(accounting.formatNumber(result));
        $("#result-" + x).html(accounting.formatNumber(result));


    }
    var sum = accounting.formatNumber(samanYog());
    $("#subttlid").html(sum);
    $("#taxr").html(accounting.formatNumber(taxr));
    $("#discs").html(accounting.formatNumber(discsr));
    billUpyog();
}

//remove productrow


$('#saman-row').on('click', '.removeProd', function () {

    var pidd = $(this).closest('tr').find('.pdIn').val();
    var retain = $(this).closest('tr').attr('data-re');

    var pqty = $(this).closest('tr').find('.amnt').val();
    pqty = pidd + '-' + pqty;
    if (retain) {
        $('<input>').attr({
            type: 'hidden',
            id: 'restock',
            name: 'restock[]',
            value: pqty
        }).appendTo('form');
    }
    $(this).closest('tr').remove();
    $('#d' + $(this).closest('tr').find('.pdIn').attr('id')).closest('tr').remove();
    $('.amnt').each(function (index) {
        rowTotal(index);
        billUpyog();
    });


    return false;
});
$('#productname-0').autocomplete({
    source: function (request, response) {
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        $.ajax({
            url: baseurl + 'products/search/' + billtype,
            dataType: "json",
            method: 'post',
            data: 'keyword=' + request.term + '&type=product_list&row_num=1&wid=' + $("#s_warehouses option:selected").val() + '&serial_mode=' + $("#serial_mode:checked").val(),
            success: function (data) {
                response($.map(data, function (item) {
                    return {
                        label: item.name,
                        value: item.name,
                        data: item
                    };
                }));
            }
        });
    },
    autoFocus: true,
    minLength: 0,
    select: function (event, ui) {
        var t_r = ui.item.data.taxrate;
        var custom = accounting.unformat($("#taxFormat option:selected").val(), accounting.settings.number.decimal);
        if (custom > 0) {
            t_r = custom;
        }
        var discount = ui.item.data.disrate;
        var custom_discount = $('#custom_discount').val();
        if (custom_discount > 0) discount = deciFormat(custom_discount);
        $('#amount-0').val(1);
        $('#price-0').val(accounting.formatNumber(ui.item.data.price));
        $('#pid-0').val(ui.item.data.id);
        $('#vat-0').val(accounting.formatNumber(t_r));
        $('#discount-0').val(accounting.formatNumber(discount));
        $('#dpid-0').val(ui.item.data.product_des);
        $('#unit-0').val(ui.item.data.unit).attr('attr-org', ui.item.data.unit);
        $('#hsn-0').val(ui.item.data.code);
        $('#alert-0').val(ui.item.data.alert);
        $('#serial-0').val(ui.item.data.serial);
        $('.unit').show();
        unit_load();
        rowTotal(0);
        billUpyog();
    }
});





$(document).on('click', ".quantity-up", function (e) {
    var spinner = $(this);
    var input = spinner.closest('.quantity').find('input[name="product_qty[]"]');
    var oldValue = accounting.unformat(input.val(), accounting.settings.number.decimal);

    var newVal = oldValue + 1;
    spinner.closest('.quantity').find('input[name="product_qty[]"]').val(accounting.formatNumber(newVal));
    spinner.closest('.quantity').find('input[name="product_qty[]"]').trigger("change");
    var id_arr = $(input).attr('id');
    id = id_arr.split("-");
    rowTotal(id[1]);
    billUpyog();
    return false;
});

$(document).on('click', ".quantity-down", function (e) {
    var spinner = $(this);
    var input = spinner.closest('.quantity').find('input[name="product_qty[]"]');
    var oldValue = accounting.unformat(input.val(), accounting.settings.number.decimal);
    var min = 1;
    if (oldValue <= min) {
        var newVal = oldValue;
    } else {
        var newVal = oldValue - 1;
    }
    spinner.closest('.quantity').find('input[name="product_qty[]"]').val(accounting.formatNumber(newVal));
    spinner.closest('.quantity').find('input[name="product_qty[]"]').trigger("change");
    var id_arr = $(input).attr('id');
    id = id_arr.split("-");
    rowTotal(id[1]);
    billUpyog();
    return false;
});



