"use strict";

/* valid */
function selectCustomer(data) {
    $('#customer_id').val(data.id);
    $('#custom_discount').val(data.discount_c);
    $('#customer_name').html('<strong>' + data.name + '</strong>');
    $('#pos_customer').html('<strong>' + data.name + '</strong>');
    $('#customer_address1').html('<strong>' + data.address + '<br>' + data.city + '</strong>');
    $('#customer_phone').html('Phone: <strong>' + data.phone + '</strong><br>Email: <strong>' + data.email + '</strong>');
    if (data.random_password) {
        $('#customer_pass').html('Password: <strong>' + data.random_password);
    } else {
        $('#customer_pass').html('');
    }
    $("#customer-box").val();
    $("#customer-box-result").hide();
    $(".sbox-result").hide();
    $("#customer").show();
}

function selectUsers(data) {
    $('#customer_id').val(data.id);
    $('#custom_discount').val(data.discount_c);
    $('#customer_name').html('<strong>' + data.name + '</strong>');
    $('#customer_address1').html('<strong>' + data.address + '<br>' + data.city + '</strong>');
    $('#customer_phone').html('Phone: <strong>' + data.phone + '</strong><br>Email: <strong>' + data.email + '</strong>');
    if (data.random_password) {
        $('#customer_pass').html('Password: <strong>' + data.random_password);
    } else {
        $('#customer_pass').html('');
    }
    $("#suppliers-box").val();


    $("#suppliers").show();
    $("#suppliers-box-result").hide();
}

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 44 || charCode > 57)) {
        return false;
    }
    return true;
}

function addObject(action, trigger_n = false) {
    var form_name = false;
    if (action['form_name']) form_name = action['form_name'];
    var errorNum = farmCheck(form_name);
    if ($("#notify").length == 0) {
        $("#c_body").html('<div id="notify" class="alert m-1" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message"></div></div>');
    }
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>: It appears you have forgotten to complete something!");
        $("html, body").scrollTop($("body").offset().top);
    } else {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: action['url'],
            type: 'POST',
            data: action['form'],
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $("#data_form").remove();
                    if (trigger_n) trigger(data);
                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                     $("#submit-data").show();
                }
            },
            error: function (data) {
                var message = '';
                $.each(data.responseJSON.errors, function (key, value) {
                    message += value + ' ';
                });
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + message);
                $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
                $("#submit-data").show();
            }
        });
    }
}

function farmCheck(form_name = false) {
    var errorNum = 0;
    if (form_name) {
        $('#' + form_name + " .required").each(function (i, obj) {
            if ($(this).val() === '') {
                $(this).parent().addClass("has-error");
                errorNum++;
            } else {
                $(this).parent().removeClass("has-error");
            }
        });
    } else {
        $(".required").each(function (i, obj) {
            if ($(this).val() === '') {
                $(this).parent().addClass("has-error");
                errorNum++;
            } else {
                $(this).parent().removeClass("has-error");
            }
        });
    }
    return errorNum;
}

$(document).ready(function () {

    $("#customer-box").keyup(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: baseurl + 'customers/search',
            data: 'keyword=' + $(this).val(),
            beforeSend: function () {
                $("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {
                $("#customer-box-result").show();
                $("#customer-box-result").html(data);
                $("#customer-box").css("background", "none");
            }
        });
    });

    $(".user-box").keyup(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var box_id = $(this).attr('data-section');
        $.ajax({
            type: "POST",
            url: baseurl + box_id + '/search',
            data: 'keyword=' + $(this).val(),
            beforeSend: function () {
                $("#" + box_id + "-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {
                $("#" + box_id + "-box-result").show();
                $("#" + box_id + "-box-result").html(data);
                $("#" + box_id + "-box").css("background", "none");
            }
        });
    });

    //universal create
    $("#submit-data").on("click", function (e) {
        e.preventDefault();
        var form_data = [];
        form_data['form'] = $("#data_form").serialize();
        form_data['url'] = $('#action-url').val();
         $("#submit-data").hide();
        addObject(form_data);
    });
});
$(".submit_data_model").click(function (e) {
    e.preventDefault();
    var modal_id = $(this).attr('data-model_id');
    var form_data = [];
    form_data['form'] = $("#data_form_model_" + modal_id).serialize();
    form_data['url'] = $("#action-url-model_" + modal_id).val();
    addObject(form_data);
});
$(".submit_data_model_page").click(function (e) {
    e.preventDefault();
    var modal_id = $(this).attr('data-model_id');
    var form_data = [];
    form_data['form'] = $("#data_form_model_" + modal_id).serialize();
    form_data['url'] = $("#action-url-model_" + modal_id).val();
    form_data['person'] = 1;
    addObjectPage(form_data);
});

function addObjectPage(action) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: action['url'],
        type: 'POST',
        data: action['form'],
        dataType: 'json',
        success: function (data) {
            if (action['person'] == 1) {
                selectCustomer(data);
                $('#addCustomer').modal('hide');
            } else {

            }
        },
        error: function (data) {
            $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
            $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
            $("html, body").scrollTop($("body").offset().top);
        }
    });
}

function doTransaction(payment_data) {
    $("#c_body").html('<div id="notify" class="alert" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message"></div></div>');
    var errorNum = farmCheck();
    $('#' + payment_data['modal_id']).modal('hide');
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
        $("#notify .message").html('<strong>Error</strong>: ' + payment_data['modal_error_message']);
        $("html, body").animate({scrollTop: $('#notify').offset().bottom}, 1000);
    } else {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: payment_data['action_url'],
            type: 'POST',
            data: $('#' + payment_data['action_form']).serialize(),
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $('#status').text(data.par1);
                    $('#method').text(data.par2);
                    $('#transaction_activity').append(data.par3);
                    $('#remains').val(data.remains);
                    $('#payment_made').text(data.payment_made);
                    $('#payment_due').text(data.payment_due);
                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }
            }
        });
    }

}

$(document).on('click', '.actionTransaction', function (e) {
    e.preventDefault();
    var action_id = $(this).attr('data-form');
    var payment_data = {};
    payment_data['modal_id'] = 'modal_bill_payment_' + action_id;
    payment_data['modal_error_message'] = $('#modal_error_message_' + action_id).val();
    payment_data['action_form'] = 'bill_payment_' + action_id;
    payment_data['action_url'] = $('#action_url_' + action_id).val();
    doTransaction(payment_data);
});

//load template
$('.send_bill').click(function (e) {
    e.preventDefault();
    $('#template_type').val($(this).attr('data-type'));
});
$('.send_sms').click(function (e) {
    e.preventDefault();
    $('#sms_template_type').val($(this).attr('data-type'));
});
$("#sendEmail").on("show.bs.modal", function (e) {
    var action = [];
    action['url'] = $('#action_url').val();
    action['form'] = $('#send_bill').serialize();
    action['subject'] = '#subject';
    action['body'] = '#email_body';
    action['request'] = '#request';
    loadTemplateObject(action);

});
$("#sendSMS").on("show.bs.modal", function (e) {
    var action = [];
    action['url'] = $('#sms_action_url').val();
    action['form'] = $('#send_sms').serialize();
    action['subject'] = '#subject';
    action['body'] = '#sms_body';
    action['request'] = '#request_sms';
    action['message'] = '#sms_message';
    loadTemplateObject(action);
});

function loadTemplateObject(action) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: action['url'],
        type: 'POST',
        data: action['form'],
        dataType: 'json',
        success: function (data) {
            $(action['subject']).val(data.subject);
            $(action['message']).val(data.body);
            $('.summernote').summernote('code', data.body);
            $(action['body']).show();
            $(action['request']).hide();
        },
        error: function (data) {
            $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
            $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
            $("html, body").scrollTop($("body").offset().top);
        }
    });
}


$('#sendEmail').on('click', '#sendNow', function (e) {
    $("#sendEmail").modal('hide');
    var action = [];
    action['url'] = $("#action_url_send").val();
    action['form'] = $("#send_bill").serialize();
    send_mail(action)
});

$('.modal-footer').on('click', '#sendGeneral', function (e) {
    var f_name = $(this).attr('data-name');
    $(this).hide();
    $("#" + f_name).modal('hide');
    var action = [];
    action['url'] = $("#" + f_name + "_url").val();
    action['form'] = $("#form_" + f_name).serialize();

    send_mail(action);
     $(this).show();
});


$('#sendSMS').on('click', '#sms_sendNow', function (e) {
    $("#sendSMS").modal('hide');
    var action = [];
    action['url'] = $("#sms_action_url_send").val();
    action['form'] = $("#send_sms").serialize();
    send_mail(action)
});

function send_mail(action) {
    var errorNum = farmCheck();
    if ($("#notify").length == 0) {
        $("#c_body").html('<div id="notify" class="alert m-1" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message"></div></div>');
    }
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>: It appears you have forgotten to complete something!");
        $("html, body").scrollTop($("body").offset().top);
    } else {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: action['url'],
            type: 'POST',
            data: action['form'],
            dataType: 'json',
            success: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                $("html, body").scrollTop($("body").offset().top);

            },
            error: function (data) {
                if (!data.message) {
                    data.message = data.statusText;
                }
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });
    }
}


$(document).on('click', ".submit_model", function (e) {
    e.preventDefault();
    var item_id = $(this).attr('data-itemid');
    var o_data = $('#form_model_' + item_id).serialize();
    var action_url = $('#action-url_' + item_id).val();
    $('#pop_model_' + item_id).modal('hide');
    saveMData(o_data, action_url);
});

function saveMData(o_data, action_url) {
    if ($("#notify").length == 0) {
        $("#c_body").html('<div id="notify" class="alert m-1" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message"></div></div>');
    }
    var errorNum = farmCheck();
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
        $("#notify .message").html("<strong>Error</strong>");
        $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
    } else {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: action_url,
            type: 'POST',
            data: o_data,
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $('#status').html(data.bill_status);
                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }
            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });
    }
}

$(document).on('click', ".delete-object", function (e) {
    e.preventDefault();

    var o_id = $(this).attr('data-object-id');
    var m_id = $(this).attr('data-object-type');
    $('#object-id_' + m_id).val(o_id);
    $('#delete_model_' + m_id).modal('toggle');

});
$(document).on('click', ".delete-confirm", function (e) {

    var did = $(this).attr('data-object-type');
    var data = [];
    data['trigger'] = $(this).attr('data-object-trigger');
    data['form'] = $('#delete_form_' + did).serialize();
    data['url'] = $('#action-url_' + did).val();
    removeObject_c(data);
});

function removeObject_c(input_data) {
    if ($("#notify").length == 0) {
        $("#c_body").html('<div id="notify" class="alert m-1" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message"></div></div>');
    }
    jQuery.ajax({
        url: input_data['url'],
        type: 'POST',
        data: input_data['form'],
        dataType: 'json',
        success: function (data) {

            if (data.status == "Success") {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
                if (input_data['trigger'] > 0) trigger(data);
            } else {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        },
        error: function (data) {
            $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
            $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
            $("html, body").scrollTop($("body").offset().top);
        }
    });

}

function removeTableData(in1, in2 = false) {

    if ($("#notify").length == 0) {
        $("#c_body").html('<div id="notify" class="alert m-1" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message"></div></div>');
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    jQuery.ajax({
        url: in1,
        type: 'POST',
        dataType: 'json',
        data: {'_method': 'delete'},
        success: function (data) {
            if (data.status == "Success") {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        }
    });
    return false;
}

function miniDash() {
    var action_url = $('#mini_dash').val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: action_url,
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            var i = 1;
            //  var obj = jQuery.parseJSON(data);
            $.each(data, function (key, value) {
                $('#dash_' + i).text(value);
                i++;
            });
        }
    });
}

function unit_load() {
    if ($('.unit').empty()) {
        $('.unit').append($('<option>').text($('meta[name="d_unit"]').attr('content')).attr('value', -1));
        $.each(unit_load_data, function (i, item) {
            $('.unit').append($('<option>').text(item.name).attr('value', item.val).attr('code', item.code));
        });
    }
}

$(document).on('click', ".view_task", function (e) {

    var did = $(this).attr('data-item');
    $.ajax({
        url: $('#loader_url').val(),
        type: 'POST',
        dataType: 'json',
        data: {'id': did},
        success: function (data) {
            $('#t_id').val(data.id);
            $('#t_name').text(data.name);
            $('#ts_description').text(data.short_desc);
            $('#t_description').text(data.description);
            $('#t_start').text(data.start);
            $('#t_end').text(data.duedate);
            $('#t_creator').text(data.creator);
            $('#t_assigned').text(data.assigned);
            $('#t_status').html(data.status);
            $('#t_status_list').empty();
            $('#t_status_list').append(data.status_list);
        }
    });
});

$(document).on('change', '.unit', function () {
    var uid = $(this).attr('data-uid');
    var uim = $('option:selected', this).val();
    var ui_code = $('option:selected', this).attr('code');
    if (uim > -1) {
        $('#unit-' + uid).val(ui_code);
        $('#unit_m-' + uid).val(uim);
        var price = accounting.unformat($("#price-" + uid).val(), accounting.settings.number.decimal);
        if (!$('#price-' + uid).attr('s-price')) $('#price-' + uid).attr('s-price', price);
        if ($('#price-' + uid).attr('s-price')) price = $('#price-' + uid).attr('s-price');
        var priceVal = uim * price;
        $('#price-' + uid).val(accounting.formatNumber(priceVal));
        rowTotal(uid);
        billUpyog();
    } else {
        $('#unit-' + uid).val($('#unit-' + uid).attr('attr-org'));
        $('#unit_m-' + uid).val(1);
        var price = $('#price-' + uid).attr('s-price');
        $('#price-' + uid).val(accounting.formatNumber(price));
        rowTotal(uid);
        billUpyog();
    }
});
function loadNotifications() {
    $.ajax({
        url: baseurl+'u/notification',
        type: 'GET',
        dataType: 'html',
        success: function (data) {
              $('#user_notifications').html(data);
        }
    });
}
function readNotifications(n_id=0) {
    $.ajax({
        url: baseurl+'u/read_notification',
        type: 'GET',
        data:{'nid':n_id},
        dataType: 'html',
        success: function (data) {
              $('#n_count').html(data);
        }
    });
}