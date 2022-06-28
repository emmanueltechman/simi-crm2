var billtype = $('#billtype').val();
var result = '';

function load_pos(search = '') {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: baseurl + 'products/pos/' + billtype,
        dataType: "json",
        method: 'post',
        data: 'keyword=' + search + '&type=product_list&row_num=' + '&wid=' + $("#s_warehouses option:selected").val() + '&cat_id=' + $("#s_category option:selected").val() + '&search_limit=' + $("#search_limit option:selected").val() + '&serial_mode=' + $("#serial_mode:checked").val(),
        success: handleResponse
    });
}

function delay(callback, ms) {
    var timer = 0;
    return function () {
        var context = this, args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function () {
            callback.apply(context, args);
        }, ms || 0);
    };
}

function load_pos_config() {
    var warehouse = localStorage.getItem('warehouse');
    if (warehouse) $("#s_warehouses option[value='" + warehouse + "']").attr("selected", "selected");
    var s_category = localStorage.getItem('s_category');
    if (s_category) $("#s_category option[value='" + s_category + "']").attr("selected", "selected");
    var search_limit = localStorage.getItem('search_limit');
    if (search_limit) $("#search_limit option[value='" + search_limit + "']").attr("selected", "selected");
    var only_serial = localStorage.getItem('serial_mode');
    $('#keyword').attr("placeholder", $('#keyword').attr('data-std_holder'));
    $('#serial_mode').prop('checked', false);
    if (only_serial == 1) {
        $('#keyword').attr("placeholder", $('#keyword').attr('data-serial_holder'));
        $('#serial_mode').prop('checked', true);
    }
}


$(document).on('change', '#s_warehouses', function (e) {
    localStorage.setItem('warehouse', $(this).val());
});
$(document).on('change', '#s_category', function (e) {
    localStorage.setItem('s_category', $(this).val());
});
$(document).on('change', '#search_limit', function (e) {
    localStorage.setItem('search_limit', $(this).val());
});
$(document).on('change', '#serial_mode', function (e) {
    if (this.checked) {
        localStorage.setItem('serial_mode', 1);
        $('#keyword').attr("placeholder", $('#keyword').attr('data-serial_holder'));
    } else {
        localStorage.setItem('serial_mode', '');
        $('#keyword').attr("placeholder", $('#keyword').attr('data-std_holder'));
    }
});






function handleResponse(data) {
    var list_load = '';
    var p_style = localStorage.getItem('pos_style');
    if (p_style == 1 || !p_style) {
        data.forEach(function (elementObject) {
            list_load += '<a class="items product" data-product_id="' + elementObject.id + '" data-product_name="' + elementObject.name + '" data-price="' + elementObject.price + '" data-tax="' + elementObject.taxrate + '" data-discount="' + elementObject.disrate + '"  data-unit="' + elementObject.unit + '" data-code="' + elementObject.code + '" data-alert="' + elementObject.alert + '" data-serial="' + elementObject.serial + '"><div class="cons-name color"><div class="added-message"><div class="message-holder"><p>Added</p><i class="icon-check-box-ln-1"></i></div></div><div class="title ">' + elementObject.name + '</div></div><div class=cons-info><div class=cost>' +cur_dy+ elementObject.price + '</div><div class=clear></div></div></a>';
        });
    }
    if (p_style == 2) {
        data.forEach(function (elementObject) {
            list_load += '<a class="items product" data-product_id="' + elementObject.id + '" data-product_name="' + elementObject.name + '" data-price="' + elementObject.price + '" data-tax="' + elementObject.taxrate + '" data-discount="' + elementObject.disrate + '"  data-unit="' + elementObject.unit + '" data-code="' + elementObject.code + '" data-alert="' + elementObject.alert + '" data-serial="' + elementObject.serial + '"><div class="cons-name"><div class="added-message"><div class="message-holder"><p>Added</p><i class="icon-check-box-ln-1"></i></div></div><img src="' + asset_url + 'img/products/' + elementObject.image + '" class="avatar-100 align-content-center" title="' + elementObject.name + '"></div><div class="title display-hidden">' + elementObject.name + '</div><div class="cons-info border-top"><div class=cost>' +cur_dy+ elementObject.price + '</div><div class=clear></div></div></a>';
        });
    }
    if (p_style == 3) {
        data.forEach(function (elementObject) {
            list_load += '<a class="items list" data-product_id="' + elementObject.id + '" data-product_name="' + elementObject.name + '" data-price="' + elementObject.price + '" data-tax="' + elementObject.taxrate + '" data-discount="' + elementObject.disrate + '"  data-unit="' + elementObject.unit + '" data-code="' + elementObject.code + '" data-alert="' + elementObject.alert + '" data-serial="' + elementObject.serial + '"><div class="cons-name"><div class="added-message"><div class="message-holder"><p>Added</p><i class="icon-check-box-ln-1"></i></div></div><img src="' + asset_url + 'img/products/' + elementObject.image + '" class="avatar-50 align-content-left mr-1" title="' + elementObject.name + '"><div class="title display-inline">' + elementObject.name + '</div></div><div class=cons-info><div class="cost">' +cur_dy+ elementObject.price + '</div><div class=clear></div></div></a>';

        });

    }

    list_load += '</div>';
    $('#product_group').html(list_load);


}

function changeStyle() {
    var style_pos = localStorage.getItem('pos_style');
    switch (style_pos) {
        case '1':
            localStorage.setItem('pos_style', '2');
            break;
        case '2':
            localStorage.setItem('pos_style', '3');
            break;
        case '3':
            localStorage.setItem('pos_style', '1');
            break;
        default :
            localStorage.setItem('pos_style', '2');

    }
    load_pos();
}


$('#invoice_tab').click(function () {
    $(this).siblings().removeClass('active');
    $(this).addClass('active');
    $('#items_load').hide();
    $('#search_product').hide();
    $('#invoice_config').show();
});

$('#products_tab').click(function () {
    $(this).siblings().removeClass('active');
    $(this).addClass('active');
    $('#invoice_config').hide();
    $('#items_load').show();
    $('#search_product').show();
});

$('#drafts').click(function () {
    $(this).siblings().removeClass('active');
    $(this).addClass('active');
    $('#items_load').hide();
    $('#invoice_config').hide();
    $('#search_product').hide();
    $('#drafts_load').show();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: baseurl + 'drafts_load',
        dataType: "html",
        method: 'post',
        success: function (data) {
            $('#drafts_list').html(data);
        }
    });


});


// inventory switch
$('#inventory_view').click(function () {
    $('#products_tab').siblings().removeClass('active');
    $('#products_tab').addClass('active');
    $('#invoice_config').hide();
    $('#items_load').show();
    $('.sm-footer').show();


    $('#sales_box .rose_wrap_left').show();
    $('#sales_box').removeClass('full-height');

    $('.receipt_panel').hide();
});

$('.customer_mobile_view').click(function () {
    $('#invoice_tab').siblings().removeClass('active');
    $('#invoice_tab').addClass('active');
    $('#items_load').hide();
    $('#search_product').hide();
    $('#invoice_config').show();


    $('.sm-footer').show();


    $('#sales_box .rose_wrap_left').show();
    $('#sales_box').removeClass('full-height');
    $('.receipt_panel').hide();
});


$('.view_invoice_config').click(function () {
    $('#invoice_tab').siblings().removeClass('active');
    $('#invoice_tab').addClass('active');
    $('#items_load').hide();
    $('#search_product').hide();
    $('#invoice_config').show();
});


$('#return_panel').click(function () {
    $('.sm-footer').hide();
    $('#sales_box .rose_wrap_left').hide();
    $('#sales_box').addClass('full-height');
    $('.receipt_panel').show();
});


$('.choose-section li').click(function () {
    $(this).addClass('active').siblings().removeClass('active');
});


var counter = 0;
$(document).on('click', '.items', function (e) {

    var flag = true;
    var pid = $(this).attr('data-product_id');
    var discount = $(this).attr('data-discount');
    var stock = accounting.unformat($(this).attr('data-alert'), accounting.settings.number.decimal);
    $('.pdIn').each(function () {
        if ($(this).val() == pid) {

            var pi = $(this).attr('id');
            var arr = pi.split('-');
            pi = arr[1];

            $('#discount-' + pi).val(discount);
            var stotal = accounting.unformat($('#amount-' + pi).val(), accounting.settings.number.decimal) + 1;
            if (stotal <= stock) {
                $('#amount-' + pi).val(accounting.formatNumber(stotal));
                $('#keyword').val('').focus();
            }
            rowTotal(pi);
            billUpyog();

            flag = false;
        }
    });
    if (flag) {
        var ganak = $('#ganak').val();
        var cvalue = parseInt(ganak);
        var unit='';
        if('null' !=$(this).attr('data-unit')) unit=$(this).attr('data-unit');
        counter++;
        $('#total-item').text('(' + counter + ')');
        var  discount = $(this).attr('data-discount');
          var custom_discount = $('#custom_discount').val();
        if (custom_discount > 0) discount = custom_discount;

        var item = '<div class=item><input type="hidden" name="product_name[]" id="productname-' + cvalue + '" value="' + $(this).attr('data-product_name') + '"><input type="hidden" class="form-control req prc" name="product_price[]" id="price-' + cvalue + '" value="' + $(this).attr('data-price') + '"><input type="hidden" class="form-control vat " name="product_tax[]" id="vat-' + cvalue + '"  value="' + $(this).attr('data-tax') + '"><input type="hidden" class="form-control discount" name="product_discount[]" id="discount-' + cvalue + '" value="' + discount + '"><input type="hidden" name="total_tax[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="total_discount[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '"  value="0"><input type="hidden" class="pdIn" name="product_id[]" id="pid-' + cvalue + '" value="' + $(this).attr('data-product_id') + '"><input type="hidden" attr-org="" name="unit[]" id="unit-' + cvalue + '" value="' + unit + '"><input type="hidden" name="unit_m[]" id="unit_m-' + cvalue + '" value="1"><input type="hidden" name="code[]" id="hsn-' + cvalue + '" value="' + $(this).attr('data-code') + '"><input type="hidden" name="serial[]" id="serial-' + cvalue + '" value="' + $(this).attr('data-serial') + '"><input type="hidden" id="alert-' + cvalue + '" value="' + $(this).attr('data-alert') + '" name="alert[]"><div class="remove-item"><i class="fa fa-minus-circle"></i></div><div class="name"><div class="title">' +  $(this).attr('data-product_name') + '</div><select class="display-inline form-control form-control-sm unit col-3 mt-1" data-uid="0" name="u_m[]" style="display: none">  </select></div><div class="quantity">' +  $(this).attr('data-price')  + '<input type="text" class="form-control req amnt display-inline mousetrap mt-1" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(0), billUpyog()" autocomplete="off" value="1"><div class="quantity-nav mt-1"><div class="quantity-button quantity-up">+</div><div class="quantity-button quantity-down">-</div></div></div><div class=clear></div></div>';

        $('.selected_items').append(item);

        $('#ganak').val(cvalue + 1);
        $(this).find('.added-message').show().delay('500').fadeOut();
        $('#empty_cart').hide();
        if (typeof unit_load === "function") {
            unit_load();
            $('.unit').show();
        }

        rowTotal(cvalue);
        billUpyog();
    }
    var sound=document.getElementById("beep");sound.play();

});
$(document).on('click', '.remove-item', function (e) {
    $(this).parent().remove();
    billUpyog();
});
if ($(window).height() < 700) {
    $('.info-data').hide();
    $('.info-toggle-collapse').hide();
    $('.info-toggle-expand').show();


    $('.bottom-section').removeClass('is-expanded');
    $('.money').removeClass('is-expanded');


    $('.bottom-section').addClass('is-collapsed');
    $('.money').addClass('is-collapsed');

    $('#bt_section').removeClass('mt-1');
}

if ($(window).height() > 600) {
    $('#bt_section').addClass('btn_margin');
}


$('.choose-section li').click(function () {
    $(this).addClass('active').siblings().removeClass('active');
});


$('#pos_basic_pay').on("click", function (e) {
    e.preventDefault();
    if ($("#notify").length == 0) {
        $("#c_body").html('<div id="notify" class="alert m-1" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message"></div></div>');
    }
    $('#pos_payment').modal('toggle');
    $("#notify .message").html("<strong>Processing</strong>: .....");
    $("#notify").removeClass("alert-danger").addClass("alert-primary").fadeIn();
    $("html, body").animate({scrollTop: $('#notify').offset().top - 100}, 1000);
    var o_data = [];
    o_data['form'] = $("#data_form").serialize();
    o_data['url'] = $('#pos_action').val();
    addObject(o_data, true);
});

$('#pos_save_draft').on("click", function (e) {
    e.preventDefault();
    if ($("#notify").length == 0) {
        $("#c_body").html('<div id="notify" class="alert m-1" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message"></div></div>');
    }
    $('#save_draft_modal').modal('toggle');
    $("#notify .message").html("<strong>Processing</strong>: .....");
    $("#notify").removeClass("alert-danger").addClass("alert-primary").fadeIn();
    $("html, body").animate({scrollTop: $('#notify').offset().top - 100}, 1000);
    var o_data = [];
    o_data['form'] = $("#data_form").serialize();
    o_data['url'] = $('#pos_action_draft').val();
    addObject(o_data);
});
