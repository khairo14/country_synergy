const { each } = require('jquery');
const moment = require('moment');

require('./bootstrap');
require('./components');

// scan product in
$(document).ready(function(){
    $("#scan_pcode").change(function(){
        var pcode = ($(this).val()).trim();
        var row_data1 = [];
        $("#scnproducts_body tr").each(function(){
            var data1 = $(this).find('td').eq(0).text();
            row_data1.push(data1);
        });

        if(pcode == " " || pcode == ""){
          $(".scan_pcode_message").text('Please Scan Product');
          setTimeout(function(){
            $(".scan_pcode_message").text('');
          },5000);
        }else if($.inArray(pcode,row_data1) != -1){
            $(".scan_pcode_message").text('Product Already Scanned');
            setTimeout(function(){
              $(".scan_pcode_message").text('');
              $("#scan_pcode").val('');
              $("#scan_pcode").focus();
            },5000);
        }else{
            var cx = $("#exist_cust1 option:selected").val();
            $.ajax({
                url: "/home/scan-in/check-product",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: { "label": pcode,'cust':cx},
                success: function (result) {
                    if(result.status == 1){
                        var gtin = result.message[0].gtin;
                        var pname = result.message[0].product_name;
                        var plu = result.message[0].product_code;
                        $("#scan_pcode").val('');
                        $("#scan_pcode").focus();
                        var prod = "<tr>"
                                +"<td class='py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6'>"
                                +"<p class='w-12 truncate overflow-clip'>"+pcode+"</p>"
                                +"</td>"
                                +"<td class='px-3 py-4 text-sm text-gray-500 whitespace-nowrap'>"+gtin+"</td>"
                                +"<td class='px-3 py-4 text-sm text-gray-500 whitespace-nowrap'>"+plu+"</td>"
                                +"<td class='px-3 py-4 text-sm text-gray-500 whitespace-nowrap'><p class='w-12 truncate overflow-clip'>"+pname+"</p></td>"
                                +"<td class='relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6'>"
                                    +"<a href='#' class='rm_prod text-indigo-600 hover:text-indigo-900'>"
                                        +"<svg xmlns='http://www.w3.org/2000/svg' class='w-6 h-6' fill='none' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2'>"
                                            +"<path stroke-linecap='round' stroke-linejoin='round' d='M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16' />"
                                        +"</svg>"
                                    +"</a>"
                                +"</td>"
                                +"</tr>";
                        $("#scnproducts_body").append(prod);
                    }else if(result.status == 2){
                        $("#scan_pcode").val('');
                        $("#scan_pcode").focus();
                        $(".scan_pcode_message").text(result.message);
                            setTimeout(function(){
                                $(".scan_pcode_message").text('');
                            },5000);
                        var prod = "<tr>"
                                +"<td class='py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6'>"
                                +"<p class='w-12 truncate overflow-clip'>"+pcode+"</p>"
                                +"</td>"
                                +"<td class='px-3 py-4 text-sm text-gray-500 whitespace-nowrap'></td>"
                                +"<td class='px-3 py-4 text-sm text-gray-500 whitespace-nowrap'></td>"
                                +"<td class='px-3 py-4 text-sm text-gray-500 whitespace-nowrap'></td>"
                                +"<td class='relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6'>"
                                    +"<a href='#' class='rm_prod text-indigo-600 hover:text-indigo-900'>"
                                        +"<svg xmlns='http://www.w3.org/2000/svg' class='w-6 h-6' fill='none' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2'>"
                                            +"<path stroke-linecap='round' stroke-linejoin='round' d='M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16' />"
                                        +"</svg>"
                                    +"</a>"
                                +"</td>"
                                +"</tr>";
                        $("#scnproducts_body").append(prod);
                    }else{
                        $("#scan_pcode").val('');
                        $("#scan_pcode").focus();
                        $(".scan_pcode_message").text(result.message);
                            setTimeout(function(){
                                $(".scan_pcode_message").text('');
                            },5000);
                    }
                }, error: function (request, status, error) {
                    alert(request.responseText);
                }
            });
        }
    });
});

$(document).on("click",".rm_prod",function(){
    $(this).closest("tr").remove();
});

$(document).ready(function(){
    $(".gen_label").on("click",function(){
        var prod_count = $(".scnproducts tr").length;
        if(prod_count <= 1){
            $(".scan_pcode_message").text('Please Scan Product');
            $("#labelModal").toggle();
            $("#labelModal_body").toggle();
            setTimeout(function(){
              $("#scan_pcode").val('');
              $("#scan_pcode").focus();
              $(".scan_pcode_message").text('');
            },5000);
        }else{
            var min = 10000000;
            var max = 99999900;
            var random = Math.floor(Math.random()*(max-min + 1))+min;
            var cx = $("#exist_cust1 option:selected").val();
            var label = cx.toString().padStart(2,'0') + random;
            var qty = $("#scnproducts_body tr").length;

            $("#pallet_card_no").show();
            $("#labelModal").hide();
            $("#scnproducts").hide();
            $("#prod_loc").focus();
            $("#scnpallet_tbl_body2 tr").find('td p').eq(0).text(label);
            $("#scnpallet_tbl_body2 tr").find('td').eq(1).text(qty);

        }
    });
});

$(document).ready(function(){
    $("#prod_loc").on("change",function(){
       var loc = ($("#prod_loc").val()).trim();

        if(loc == "" || loc == " "){
            $(".scan_loc_message2").text('Please Scan Location');
            $("#loc").focus();
            $("#loc").val("");
            setTimeout(function(){
                $(".scan_loc_message2").text('');
            },5000);
        }else{
            $.ajax({
                url: "/home/scan-in/check-location",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: {"loc":loc},
                success: function (result) {
                    if(result.status == 0){
                        $("#location2").attr("data",result.message[0].id);
                        $("#location2").val(result.message[0].name);
                    }else{
                        $("#location2").attr("data","0");
                        $("#location2").val(loc);
                        $(".scan_loc_message2").text(result.message);
                        $("#prod_loc").focus();
                        $("#prod_loc").val("");
                        setTimeout(function(){
                            $(".scan_loc_message2").text('');
                        },5000);
                    }
                }
            });
        }
    });
});

$(document).ready(function(){
    $("#bst_before3").val($.datepicker.formatDate('dd/mm/yy', new Date()));
    var cur_date = new Date();
    $( "#bst_before3" ).datepicker({
        language: 'en',
        startDate: cur_date,
        setDate: cur_date,
        dateFormat: "dd/mm/yy",
        autoClose: true,
        changeMonth: true,
        changeYear: true,
        });
});

$(document).ready(function(){
    $("#bst_before3").on("change",function(){
        $bst_date = $(this).val();
        $("#bbefore3").val($bst_date);

        $("._bst_before3").toggle();
        $("._prod_loc").toggle();
        $("#prod_loc").focus();
    });
});

$(document).ready(function(){
    $(".save-pallet3").on("click",function(){
        var prod_data = [];
        $("#scnproducts_body tr").each(function(){
            var data1 = $(this).find('td p').eq(0).text();
            var data2 = $(this).find('td').eq(1).text();
            var item = {};
            item.label = data1;
            item.gtin = data2;
            prod_data.push(item);
        });

        var label = $("#scnpallet_tbl_body2 tr").find('td p').eq(0).text();
        var qty = $("#scnpallet_tbl_body2 tr").find('td').eq(1).text();
        var bst_date = $("#bbefore3").val();
        var loc = ($("#location2").val()).trim();
        var cx = $("#exist_cust1 option:selected").val();

        if(bst_date == ""){
            $(".scan_loc_message2").text('Please Select Date');
            $("#bst_before3").focus();
            setTimeout(function(){
                $(".scan_pallet_message").text('');
            },5000);
        }else if(loc == "" || loc ==" "){
            $(".scan_loc_message2").text('Please Scan Location');
            $("#location2").focus();
            setTimeout(function(){
                $(".scan_pallet_message").text('');
            },5000);
        }else{
            $.ajax({
                url: "/home/scan-in/scan-products",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: {'cx':cx,'products':prod_data,'label':label,'qty':qty,'loc':loc,'best_date':bst_date},
                success: function (result) {
                    // console.log(result);
                    $(".print_card").show();
                    $("#pallet_card_no").hide();
                    $("#print_label").append(result);
                }, error: function (request, status, error) {
                    alert(request.responseText);
                }
            });
        }

    });
});
// end scan product in

// scan pallet in option yes
$(document).ready(function(){
    $("#scnpallet").on("change", function(){
        var p_name = ($(this).val()).trim();

        if(p_name == "" || p_name == " "){
            $(".scan_pallet_message").text('Pallet label cannot empty');
            setTimeout(function(){
                $(".scan_pallet_message").text('');
            },5000);
        }else{
            $.ajax({
                url: "/home/scan-in/check-pallet",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: { "p_label":p_name},
                success: function (result) {
                    if(result.status == 1){
                        $("#scnpallet_tbl_body tr").find('td p').eq(0).text(p_name);
                        $("._scnpallet").toggle();
                        $("._box_qty").toggle();
                        $("#box_qty").focus();
                    }else{
                        $(".scan_pallet_message").text(result.message);
                        setTimeout(function(){
                            $(".scan_pallet_message").text('');
                        },5000);

                        setTimeout(function(){
                            $("#scnpallet").val("");
                            $("#scnpallet").focus();
                        },500);
                    }

                }, error: function (request, status, error) {
                    alert(request.responseText);
                }
            });
        }
    });
});

$(document).ready(function(){
    $("#box_qty").on("change",function(){
        var qty = ($("#box_qty").val()).trim();

        if(qty == "" || qty ==" "){
            $(".scan_pallet_message").text('Please Enter Quantity');
            setTimeout(function(){
                $(".scan_pallet_message").text('');
            },5000);
        }else{
            $("#scnpallet_tbl_body tr").find('td').eq(1).text(qty);
            $("._box_qty").toggle();
            $("._bst_before").toggle();
            $("#bst_before").focus();
        }

    });
});

$(document).ready(function(){
    $("#bst_before").val($.datepicker.formatDate('dd/mm/yy', new Date()));
    var cur_date = new Date();
    $( "#bst_before" ).datepicker({
        language: 'en',
        startDate: cur_date,
        setDate: cur_date,
        dateFormat: "dd/mm/yy",
        autoClose: true,
        changeMonth: true,
        changeYear: true,
        });
});

$(document).ready(function(){
    $("#bst_before").on("change",function(){
        $bst_date = $(this).val();
        $("#bbefore").val($bst_date);

        $("._bst_before").toggle();
        $("._loc").toggle();
        $("#loc").focus();
    });
});

$(document).ready(function(){
    $("#loc").on("change",function(){
       var loc = ($("#loc").val()).trim();

        if(loc == "" || loc == " "){
            $(".scan_pallet_message").text('Please Scan Location');
            $("#loc").focus();
            $("#loc").val("");
            setTimeout(function(){
                $(".scan_pallet_message").text('');
            },5000);
        }else{
            $.ajax({
                url: "/home/scan-in/check-location",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: {"loc":loc},
                success: function (result) {
                    if(result.status == 0){
                        $("#location").attr("data",result.message[0].id);
                        $("#location").val(result.message[0].name);
                    }else{
                        $("#location").attr("data","0");
                        $("#location").val(loc);
                        $(".scan_pallet_message").text(result.message);
                        $("#loc").focus();
                        $("#loc").val("");
                        setTimeout(function(){
                            $(".scan_pallet_message").text('');
                        },5000);
                    }
                }
            });
        }
    });
});

$(document).ready(function(){
    $(".save-pallet").on("click",function(){
        var td_qty = $("#scnpallet_tbl_body tr").find('td').eq(1).text();
        var td_lbl = $("#scnpallet_tbl_body tr").find('td p').eq(0).text();
        var bst_date = $("#bbefore").val();
        var loc = $("#location").val();
        var cx = $("#exist_cust1 option:selected").val();

        if(td_lbl == ""){
            $(".scan_pallet_message").text('Pallet Label Cannot Be Empty');
            $("#scnpallet").focus();
            setTimeout(function(){
                $(".scan_pallet_message").text('');
            },5000);
        }else if(td_qty == ""){
            $(".scan_pallet_message").text('Please Enter Quantity');
            $("#scnpallet").focus();
            setTimeout(function(){
                $(".scan_pallet_message").text('');
            },5000);
        }else if(loc == ""){
            $(".scan_pallet_message").text('Please Enter Location');
            $("#scnpallet").focus();
            setTimeout(function(){
                $(".scan_pallet_message").text('');
            },5000);
        }else{
            $.ajax({
                url: "/home/scan-in/add-pallet",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: { "cx":cx,'plabel':td_lbl,'qty':td_qty,'loc':loc,'best_date':bst_date},
                success: function (result) {
                    $(".print_card").show();
                    $("#pallet_card_yes").hide();
                    $("#print_label").append(result);
                }, error: function (request, status, error) {
                    alert(request.responseText);
                }
            });
        }
    });
});

$(document).on("click",".rm_pallet",function(){
    $("#scnpallet_tbl_body tr").find('td p').eq(0).text("");
    $("#scnpallet_tbl_body tr").find('td').eq(1).text("");

    $("._scnpallet").show();
    $("._box_qty").hide();
    $("._loc").hide();
    $("#scnpallet").val("");
    $("#box_qty").val("");
    $("#loc").val("");
    $("#location").val("");
    $("#scnpallet").focus();
});

// scan pallet in option no
$(document).on("click",".option_no",function(){
    var min = 10000000;
    var max = 99999900;
    var random = Math.floor(Math.random()*(max-min + 1))+min;
    var cx = $("#exist_cust1 option:selected").val();
    var label = cx.toString().padStart(2,'0') + random;

    $.ajax({
        url: "/home/scan-in/check-pallet",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        method: 'post',
        data: { "p_label":label},
        success: function (result) {
            if(result.status == 1){
                $("#scnpallet_tbl_body2 tr").find('td p').eq(0).text(label);
                $("#box_qty2").focus();
            }else{
               var random1 = Math.floor(Math.random()*(max-min + 1))+min;
               var label1 = cx.toString().padStart(2,'0') + random1;
               $("#scnpallet_tbl_body2 tr").find('td p').eq(0).text(label1);
               $("#box_qty2").focus();
            }

        }, error: function (request, status, error) {
            alert(request.responseText);
        }
    });

});

$(document).ready(function(){
    $("#bst_before2").val($.datepicker.formatDate('dd/mm/yy', new Date()));
    var cur_date = new Date();
    $( "#bst_before2" ).datepicker({
        language: 'en',
        startDate: cur_date,
        setDate: cur_date,
        dateFormat: "dd/mm/yy",
        autoClose: true,
        changeMonth: true,
        changeYear: true,
        });
});

$(document).ready(function(){
    $("#loc2").on("change",function(){
       var loc = ($("#loc2").val()).trim();

        if(loc == "" || loc == " "){
            $(".scan_pallet_message2").text('Please Scan Location');
            $("#loc2").focus();
            $("#loc2").val("");
            setTimeout(function(){
                $(".scan_pallet_message2").text('');
            },5000);
        }else{
            $.ajax({
                url: "/home/scan-in/check-location",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: {"loc":loc},
                success: function (result) {
                    if(result.status == 0){
                        $("#location2").attr("data",result.message[0].id);
                        $("#location2").val(result.message[0].name);
                    }else{
                        $("#location2").attr("data","0");
                        $("#location2").val(loc);
                        $(".scan_pallet_message2").text(result.message);
                        $("#loc2").focus();
                        $("#loc2").val("");
                        setTimeout(function(){
                            $(".scan_pallet_message2").text('');
                        },5000);
                    }
                }
            });
        }
    });
});

$(document).ready(function(){
    $("#box_qty2").on("change",function(){
        var qty = ($("#box_qty2").val()).trim();

        if(qty == "" || qty ==" "){
            $(".scan_pallet_message2").text('Please Enter Quantity');
            setTimeout(function(){
                $(".scan_pallet_message2").text('');
            },5000);
        }else{
            $("#scnpallet_tbl_body2 tr").find('td').eq(1).text(qty);
            $("._box_qty2").toggle();
            $("._bst_before2").toggle();
            $("#bst_before2").focus();
        }
    });
});

$(document).ready(function(){
    $("#bst_before2").on("change",function(){
        var bst_date = $(this).val();
        $("#_bbefore").val(bst_date);
        $("._bst_before2").toggle();
        $("._loc2").toggle();
        $("#loc2").focus();
    });
});

$(document).on("click",".print",function(){
    var tbl = $("#print_table");
    var style = "<style type='text/css'>"
            +"#print_table{width:100%; height:100%; border-collapse:collapse;}"
            +"#print_table_body tr{text-align:center;padding:5px;}"
            +".clnt,.act_purpose,.rcvd_date,.lbl{border:1px solid #000; border-collapse:collapse; text-align:center;}"
            +"</style>";

    style += tbl.prop('outerHTML');
    var wme = window.open("","","width=1200","height=900");
    wme.document.write(style);
    wme.document.close();
    wme.focus();
    wme.print();
    // wme.close();
});

$(document).ready(function(){
    $(".save-pallet2").on("click",function(){
        var td_qty = $("#scnpallet_tbl_body2 tr").find('td').eq(1).text();
        var td_lbl = $("#scnpallet_tbl_body2 tr").find('td p').eq(0).text();
        var loc = $("#location2").val();
        var bst_before = $("#_bbefore").val();
        var cx = $("#exist_cust1 option:selected").val();

        if(td_qty == ""){
            $(".scan_pallet_message2").text('Please Enter Quantity');
            $("#scnpallet2").focus();
            setTimeout(function(){
                $(".scan_pallet_message2").text('');
            },5000);
        }else if(loc == ""){
            $(".scan_pallet_message2").text('Please Enter Location');
            $("#scnpallet2").focus();
            setTimeout(function(){
                $(".scan_pallet_message2").text('');
            },5000);
        }else{
            $.ajax({
                url: "/home/scan-in/add-pallet",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: { "cx":cx,'plabel':td_lbl,'qty':td_qty,'loc':loc,'best_date':bst_before},
                success: function (result) {
                    $(".print_card").show();
                    $("#pallet_card_no").hide();
                    $("#print_label").append(result);
                }, error: function (request, status, error) {
                    alert(request.responseText);
                }
            });
        }
    });
});

$(document).on("click",".scan_page",function(){
    window.location.reload();
});

// Scan In Addtopallet
$(document).ready(function(){
    $("#addtopallet").on("change",function(){
        var pl = ($(this).val()).trim();

        if(pl == ""){
            $(".addtopallet_message").text('Please Scan Pallet');
            $("#addtopallet").val('');
            $("#addtopallet").focus();
            setTimeout(function(){
                $(".addtopallet_message").text('');
            },5000);
        }else{
            $.ajax({
                url: "/home/scan-in/checkStockPallet",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: {'label':pl},
                success: function (result) {
                    if(result.status == 1){
                        var p_id = result.message['pallet'];
                        var cx = result.message['customer'];

                        $(".pallet_lbl").text(pl);
                        $(".pallet_lbl").attr('data-id',p_id['0']['id']);
                        $("#cx").val(cx['0']['id']);
                        $("._prodtopallet").show();
                        $("#prodtopallet").focus();
                        $(".b_btn").show();
                        $("#addtopallet").val('');
                        $("._addtopallet").hide();
                    }else{
                        $(".addtopallet_message").text(result.message);
                        $("#addtopallet").val('');
                        $("#addtopallet").focus();
                        setTimeout(function(){
                            $(".addtopallet_message").text('');
                        },5000);
                    }
                }
            });
        }
    });
});

$(document).ready(function(){
    $("#prodtopallet").on("change",function(){
        var pcode = ($(this).val()).trim();
        var row_data1 = [];
        $("#scprodtopallet_body tr").each(function(){
            var data1 = $(this).find('td').eq(0).text();
            row_data1.push(data1);
        });

        if(pcode == " " || pcode == ""){
          $(".addtopallet_message").text('Please Scan Product');
          setTimeout(function(){
            $(".addtopallet_message").text('');
          },5000);
        }else if($.inArray(pcode,row_data1) != -1){
            $(".addtopallet_message").text('Product Already Scanned');
            setTimeout(function(){
              $(".addtopallet_message").text('');
              $("#prodtopallet").val('');
              $("#prodtopallet").focus();
            },5000);
        }else{
            var cx = $("#cx").val();
            $.ajax({
                url: "/home/scan-in/check-product",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: { "label": pcode,'cust':cx},
                success: function (result) {
                    if(result.status == 1){
                        var gtin = result.message[0].gtin;
                        var pname = result.message[0].product_name;
                        var plu = result.message[0].product_code;
                        $("#prodtopallet").val('');
                        $("#prodtopallet").focus();
                        var prod = "<tr>"
                                +"<td class='py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6'>"
                                +"<p class='w-12 truncate overflow-clip'>"+pcode+"</p>"
                                +"</td>"
                                +"<td class='px-3 py-4 text-sm text-gray-500 whitespace-nowrap'>"+gtin+"</td>"
                                +"<td class='px-3 py-4 text-sm text-gray-500 whitespace-nowrap'>"+plu+"</td>"
                                +"<td class='px-3 py-4 text-sm text-gray-500 whitespace-nowrap'><p class='w-20 truncate overflow-clip'>"+pname+"</p></td>"
                                +"<td class='relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6'>"
                                    +"<a href='#' class='rm_prod text-indigo-600 hover:text-indigo-900'>"
                                        +"<svg xmlns='http://www.w3.org/2000/svg' class='w-6 h-6' fill='none' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2'>"
                                            +"<path stroke-linecap='round' stroke-linejoin='round' d='M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16' />"
                                        +"</svg>"
                                    +"</a>"
                                +"</td>"
                                +"</tr>";
                        $("#scprodtopallet_body").append(prod);
                    }else if(result.status == 2){
                        $("#prodtopallet").val('');
                        $("#prodtopallet").focus();
                        $(".addtopallet_message").text(result.message);
                            setTimeout(function(){
                                $(".addtopallet_message").text('');
                            },5000);
                        var prod = "<tr>"
                                +"<td class='py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6'>"
                                +"<p class='w-12 truncate overflow-clip'>"+pcode+"</p>"
                                +"</td>"
                                +"<td class='px-3 py-4 text-sm text-gray-500 whitespace-nowrap'></td>"
                                +"<td class='px-3 py-4 text-sm text-gray-500 whitespace-nowrap'></td>"
                                +"<td class='px-3 py-4 text-sm text-gray-500 whitespace-nowrap'></td>"
                                +"<td class='relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6'>"
                                    +"<a href='#' class='rm_prod text-indigo-600 hover:text-indigo-900'>"
                                        +"<svg xmlns='http://www.w3.org/2000/svg' class='w-6 h-6' fill='none' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2'>"
                                            +"<path stroke-linecap='round' stroke-linejoin='round' d='M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16' />"
                                        +"</svg>"
                                    +"</a>"
                                +"</td>"
                                +"</tr>";
                        $("#scprodtopallet_body").append(prod);
                    }else{
                        $("#prodtopallet").val('');
                        $("#prodtopallet").focus();
                        $(".addtopallet_message").text(result.message);
                            setTimeout(function(){
                                $(".addtopallet_message").text('');
                            },5000);
                    }
                }
            });
        }
    });
});

$(document).ready(function(){
    $(".save_add2pallet").on("click",function(){
       var tbl = $("#scprodtopallet_body tr").length;
       var prod_data = [];

       $("#scprodtopallet_body tr").each(function(){
            var data1 = $(this).find('td p').eq(0).text();
            var data2 = $(this).find('td').eq(1).text();
            var item = {};
            item.label = data1;
            item.gtin = data2;
            prod_data.push(item);
        });

        if(tbl < 1){
            $(".addtopallet_message").text('Please Scan Products')
            $("#prodtopallet").val('');
            $("#prodtopallet").focus();
            setTimeout(function(){
                $(".addtopallet_message").text('');
            },5000);
        }else{
            var cx = $("#cx").val();
            var pallet = $(".pallet_lbl").attr('data-id');

            $.ajax({
                url: "/home/scan-in/prodtopallet",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: {'products':prod_data,'cx':cx,'pallet_id':pallet},
                success: function (result) {
                    if(result.status == 1){
                        $(".atp_card").hide();
                        $("#prod_out").val('');
                        $("#scprodtopallet tr").empty();
                        $(".or_done").show();
                        $(".or_done1").addClass('bg-green-500');
                        $(".success").show();
                        $(".co_message").text(result.message);
                    }else{
                        $(".atp_card").hide();
                        $("#prod_out").val('');
                        $("#scprodtopallet tr").empty();
                        $(".or_done").show();
                        $(".or_done1").addClass('bg-red-500');
                        $(".error").show();
                        $(".co_message").text(result.message);
                    }
                }, error: function (request, status, error) {
                    alert(request.responseText);
                }
            });
        }

    });
});

// Product Out
$(document).ready(function(){
    $("#prod_out").on("change",function(){
       var plabel = ($("#prod_out").val()).trim();

       var row_data1 = [];
       $("#prod_out_body tr").each(function(){
            var data1 = $(this).find('td p').eq(0).text();
            row_data1.push(data1);
        });

       if(plabel == ""){
            $(".p_out_message").text("Please Scan Product");
            $("#prod_out").val('');
            $("#prod_out").focus();
            setTimeout(function(){
                $(".p_out_message").text("");
            },5000);
       }else if($.inArray(plabel,row_data1) != -1){
            $(".p_out_message").text("Product Already Scanned");
            $("#prod_out").val('');
            $("#prod_out").focus();
            setTimeout(function(){
                $(".p_out_message").text("");
            },5000);
        }else{
            $.ajax({
                url: "/home/scan-out/checkStock",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: {'label':plabel},
                success: function (result) {
                    // console.log(result.message['label']);
                    if(result.status == 1){
                        var lbl = result.message['label'];
                        var gtin = result.message['gtin'];
                        var pname = result.message['name'];
                        var plu = result.message['plu'];
                        $("#prod_out").val('');
                        $("#prod_out").focus();
                        var prod = "<tr>"
                                +"<td class='py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6'>"
                                +"<p class='w-12 truncate overflow-clip'>"+lbl+"</p>"
                                +"</td>"
                                +"<td class='px-3 py-4 text-sm text-gray-500 whitespace-nowrap'>"+plu+"</td>"
                                +"<td class='px-3 py-4 text-sm text-gray-500 whitespace-nowrap'><p class='w-20 truncate overflow-clip'>"+pname+"</p></td>"
                                +"<td class='relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6'>"
                                    +"<a href='#' class='rm_prod text-indigo-600 hover:text-indigo-900'>"
                                        +"<svg xmlns='http://www.w3.org/2000/svg' class='w-6 h-6' fill='none' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2'>"
                                            +"<path stroke-linecap='round' stroke-linejoin='round' d='M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16' />"
                                        +"</svg>"
                                    +"</a>"
                                +"</td>"
                                +"</tr>";
                        $("#prod_out_body").append(prod);
                    }else if(result.status == 2){
                        var lbl = result.message['label'];
                        $("#prod_out").val('');
                        $("#prod_out").focus();
                        var prod = "<tr>"
                                +"<td class='py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6'>"
                                +"<p class='w-12 truncate overflow-clip'>"+lbl+"</p>"
                                +"</td>"
                                +"<td class='px-3 py-4 text-sm text-gray-500 whitespace-nowrap'></td>"
                                +"<td class='px-3 py-4 text-sm text-gray-500 whitespace-nowrap'></td>"
                                +"<td class='relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6'>"
                                    +"<a href='#' class='rm_prod text-indigo-600 hover:text-indigo-900'>"
                                        +"<svg xmlns='http://www.w3.org/2000/svg' class='w-6 h-6' fill='none' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2'>"
                                            +"<path stroke-linecap='round' stroke-linejoin='round' d='M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16' />"
                                        +"</svg>"
                                    +"</a>"
                                +"</td>"
                                +"</tr>";
                        $("#prod_out_body").append(prod);
                    }else{
                        $(".p_out_message").text(result.message);
                        $("#prod_out").val('');
                        $("#prod_out").focus();
                        setTimeout(function(){
                            $(".p_out_message").text("");
                        },5000);
                    }
                }, error: function (request, status, error) {
                    alert(request.responseText);
                }
            });
       }
    });
});

$(document).ready(function(){
    $(".tk_pr_out").on("click",function(){
        var stcks = $("#prod_out_body tr").length;
        var prod_data = [];

        if(stcks < 1){
            $(".p_out_message").text("Please Scan Product");
            $("#prod_out").val('');
            $("#prod_out").focus();
            setTimeout(function(){
                $(".p_out_message").text("");
            },5000);
        }else{
            $("#prod_out_body tr").each(function(){
                var data1 = $(this).find('td p').eq(0).text();
                var data2 = $(this).find('td').eq(1).text();
                var item = {};
                item.label = data1;
                item.plu = data2;
                prod_data.push(item);
            });
            $.ajax({
                url: "/home/scan-out/checkOutProduct",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: {'prods':prod_data},
                success: function (result) {
                    if(result.status == 1){
                        $("#scprod_out").hide();
                        $("#prod_out").val('');
                        $("#prod_out_body tr").empty();
                        $(".or_done").show();
                        $(".or_done1").addClass('bg-green-500');
                        $(".success").show();
                        $(".co_message").text(result.message);
                    }else{
                        $("#scprod_out").hide();
                        $("#prod_out").val('');
                        $("#prod_out_body tr").empty();
                        $(".or_done").show();
                        $(".or_done1").addClass('bg-red-500');
                        $(".error").show();
                        $(".co_message").text(result.message);
                    }
                }, error: function (request, status, error) {
                    alert(request.responseText);
                }
            });
        }

    });
});

$(document).ready(function(){
    $(".cmplte_order").on("click",function(){
        window.location.reload();
    });
});
// Pallet out
$(document).ready(function(){
    $("#scnpalletout").on("change",function(){
        var pout_name = ($(this).val()).trim();

        if(pout_name == "" || pout_name == " "){
            $(".scan_pallet_message").text('Please Scan Pallet');
            setTimeout(function(){
                $(".scan_pallet_message").text("");
            },5000);
        }else{
            $.ajax({
                url: "/home/scan-out/getPallet",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: { "label": pout_name},
                success: function(result){
                    // console.log(result);
                    if(result.status == 1){
                        var qty = result.message.qty;
                        var loc = result.message.location;
                        var label = result.message.pallet;

                        $("#scnpalletout").val("");
                        $("#scnpalletout").focus();
                        $("#scnpalletout_tbl_body tr").find('td p').eq(0).text(label[0].name);
                        $("#scnpalletout_tbl_body tr").find('td').eq(1).text(qty);
                        $("#scnpalletout_tbl_body tr").find('td').eq(2).text(loc[0].name);
                    }else{
                        $("#scnpalletout").val("");
                        $("#scnpalletout").focus();
                        $(".scan_pallet_message").text(result.message);
                        setTimeout(function(){
                            $(".scan_pallet_message").text("");
                        },5000);
                    }
                }, error: function (request, status, error) {
                    alert(request.responseText);
                }
            });
        }
    });
});

$(document).ready(function(){
    $(".tk_out").on("click",function(){
        var lbl = $("#scnpalletout_tbl_body tr").find('td p').eq(0).text();

        if(lbl == ""){
            $(".scan_pallet_message").text('Please Scan Pallet');
            $("#scnpalletout").val("");
            $("#scnpalletout").focus();
            setTimeout(function(){
                $(".scan_pallet_message").text("");
            },5000);
        }else{
            $.ajax({
                url: "/home/scan-out/palletOut",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: { "label": lbl},
                success: function(result){
                    if(result.status == 1){
                        $("#scannerOut").hide();
                        $(".scnpalletout_tbl").val('');
                        $("#scnpalletout_tbl_body tr").empty();
                        $(".or_done").show();
                        $(".or_done1").addClass('bg-green-500');
                        $(".success").show();
                        $(".co_message").text(result.message);
                    }else{
                        $("#scannerOut").hide();
                        $(".scnpalletout_tbl").val('');
                        $("#scnpalletout_tbl_body tr").empty();
                        $(".or_done").show();
                        $(".or_done1").addClass('bg-red-500');
                        $(".error").show();
                        $(".co_message").text(result.message);
                    }
                }, error: function (request, status, error) {
                    alert(request.responseText);
                }
            });
        }
    });
});

$(document).on("click",".print_docket",function(){
    var tbl = $("#docket_table");
    var style = "<style type='text/css'>"
            +"#docket_table{width:auto; height:auto; border-collapse:collapse;}"
            +"#docket_table thead{padding:5px}"
            +".th1 img{width:50%; height:50px; object-position:2% 100%;}"
            +".th1_a{column-span:1; text-align:left;} .th1_b{column-span:2} .th1_c{column-span:3}"
            +".th2_a,.th2_b,.th2_c,.th3_a,.th3_b,.th3_c{border:1px solid #000; border-collapse:collapse; text-align:center;}"
            +".th1,.th2,.th3,.th4,.th5,.th6,{column-count:6; padding:5px;}"
            +".th4 th,.th5 td,.th6 td{text-align:left;}"
            +".th4_a,.th5_a,.th6_a{column-count:1; column-span:1;}"
            +".th4_b,.th5_b,.th6_b{column-count:2; column-span:2;}"
            +".th4_c,.th5_c,.th6_c{column-count:3; column-span:3;}"
            +".th7_a,.th8_a,.th7_c,.th8_c{column-count:1; column-span:1;}"
            +".th7_b,.th8_b{column-count:4; column-span:4;}"
            +".th7,.th8{text-align:left; height:2%}"
            +".th7,.th8{border:1px solid #000; border-collapse: collapse; text-align:center;}"
            +"</style>";

    style += tbl.prop('outerHTML');
    var wme = window.open("","","width=1200","height=900");
    wme.document.write(style);
    wme.document.close();
    wme.focus();
    wme.print();
    // wme.close();
});

// Order Out
$(document).ready(function(){
    $("#orderout").on("change",function(){
        var order_id = ($(this).val()).trim();
        $(".or_num").empty();
        $(".or_out_tbl_body").empty();

        if(order_id == "" || order_id == " "){
            $(".orderout_message").text('Please Enter Order #');
            $(".orderout_message").addClass('bg-red-300');
            $("#orderout_prod").val("");
            $("#orderout_prod").focus;
            setTimeout(function(){
                $(".orderout_message").text("");
                $(".orderout_message").removeClass('bg-red-300');
            },5000);
        }else{
            $.ajax({
                url: "/home/scan-out/getOrder/"+order_id,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'get',
                success: function(result){
                    if(result.status == 1){
                        var order = result.message['order'];
                        var or_line = result.message['or_line'];
                        $(".or_num").append("Order #"+order[0]['id']);
                        $(".or_num").attr('data-id',order[0]['id']);

                        or_line.forEach(function(or_line){
                            var or_dtls = "<tr class='px-2 text-center divide-x divide-black'>";
                                if(or_line['or_plu'] != null){
                                    or_dtls +="<td class='px-2 py-2 text-xs font-medium tracking-wide text-center text-gray-500 uppercase'>"+or_line['or_plu']+"</td>"
                                }else if(or_line['sc_plu'] != null){
                                    or_dtls +="<td class='px-2 py-2 text-xs font-medium tracking-wide text-center text-gray-500 uppercase'>"+or_line['sc_plu']+"</td>"
                                }else{
                                    or_dtls +="<td class='px-2 py-2 text-xs font-medium tracking-wide text-center text-gray-500 uppercase'>0000</td>"
                                }

                                if(or_line['or_prod_name'] != null){
                                    or_dtls +="<td class='px-2 py-2 text-xs font-medium tracking-wide text-center text-gray-500 uppercase'>"+or_line['or_prod_name']+"</td>"
                                }else if(or_line['sc_prod_name'] != null){
                                    or_dtls +="<td class='px-2 py-2 text-xs font-medium tracking-wide text-center text-gray-500 uppercase'>"+or_line['sc_prod_name']+"</td>"
                                }else{
                                    or_dtls +="<td class='px-2 py-2 text-xs font-medium tracking-wide text-center text-gray-500 uppercase'>No Name Avbl</td>"
                                }

                                or_dtls +="<td class='px-2 py-2 text-xs font-medium tracking-wide text-center text-gray-500 uppercase'>"+or_line['or_qty']+"</td>"
                                +"<td class='px-2 py-2 text-xs font-medium tracking-wide text-center text-gray-500 uppercase'>"+or_line['sc_qty']+"</td>"
                                +"</tr>";

                            $(".or_out_tbl_body").append(or_dtls);
                        });
                        $("#orderout").val("");
                        $(".orderout").hide();
                        $(".order_dtls").show();
                        $(".prod_or_out").show();
                        $("#orderout_prod").focus();
                    }else{
                        $(".orderout_message").text(result.message);
                        $(".orderout_message").addClass('bg-red-300');
                        $("#orderout").val("");
                        $("#orderout").focus;
                        setTimeout(function(){
                            $(".orderout_message").text("");
                            $(".orderout_message").removeClass('bg-red-300');
                        },5000);
                    }
                }, error: function (request, status, error) {
                    alert(request.responseText);
                }
            });
        }
    });
});

$(document).ready(function(){
    $("#orderout_prod").on("change",function(){
        var label = ($(this).val()).trim();
        var order_id = $(".or_num").attr('data-id');
        $(".or_out_tbl_body").empty();

        if(label == "" || label ==" "){
            $(".orderout_message").text('Scan Products');
            $(".orderout_message").addClass('bg-red-300');
            $("#orderout_prod").val("");
            $("#orderout_prod").focus;
            setTimeout(function(){
                $(".orderout_message").text("");
                $(".orderout_message").removeClass('bg-red-300');
            },5000);
        }else{
            $.ajax({
                url: "/home/scan-out/orderProd",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: { "label": label,"order_id":order_id},
                success: function(result){
                    // console.log(result);
                    if(result.status == 1){
                        var or_line = result.message['or_line'];
                        or_line.forEach(function(or_line){
                            var or_dtls = "<tr class='px-2 text-center divide-x divide-black'>";
                                if(or_line['or_plu'] != null){
                                    or_dtls +="<td class='px-2 py-2 text-xs font-medium tracking-wide text-center text-gray-500 uppercase'>"+or_line['or_plu']+"</td>";
                                }else if(or_line['sc_plu'] != null){
                                    or_dtls +="<td class='px-2 py-2 text-xs font-medium tracking-wide text-center text-gray-500 uppercase'>"+or_line['sc_plu']+"</td>";
                                }else{
                                    or_dtls +="<td class='px-2 py-2 text-xs font-medium tracking-wide text-center text-gray-500 uppercase'>0000</td>";
                                }

                                if(or_line['or_prod_name'] != null){
                                    or_dtls +="<td class='px-2 py-2 text-xs font-medium tracking-wide text-center text-gray-500 uppercase'>"+or_line['or_prod_name']+"</td>";
                                }else if(or_line['sc_prod_name'] != null){
                                    or_dtls +="<td class='px-2 py-2 text-xs font-medium tracking-wide text-center text-gray-500 uppercase'>"+or_line['sc_prod_name']+"</td>";
                                }else{
                                    or_dtls +="<td class='px-2 py-2 text-xs font-medium tracking-wide text-center text-gray-500 uppercase'>No Name Avbl</td>";
                                }

                                or_dtls +="<td class='px-2 py-2 text-xs font-medium tracking-wide text-center text-gray-500 uppercase'>"+or_line['or_qty']+"</td>"
                                +"<td class='px-2 py-2 text-xs font-medium tracking-wide text-center text-gray-500 uppercase'>"+or_line['sc_qty']+"</td>"
                                +"</tr>";

                            $(".or_out_tbl_body").append(or_dtls);
                        });
                        $(".orderout_message").text('Product Succefully Added to Order');
                        $(".orderout_message").addClass('bg-green-300');
                        $("#orderout_prod").val("");
                        $("#orderout_prod").focus;
                        setTimeout(function(){
                            $(".orderout_message").text("");
                            $(".orderout_message").removeClass('bg-green-300');
                        },5000);
                    }else{
                        $(".orderout_message").text(result.message);
                        $(".orderout_message").addClass('bg-red-300');
                        $("#orderout_prod").val("");
                        $("#orderout_prod").focus;
                        setTimeout(function(){
                            $(".orderout_message").text("");
                            $(".orderout_message").removeClass('bg-red-300');
                        },5000);
                    }
                }, error: function (request, status, error) {
                    alert(request.responseText);
                }
            });
        }

    });
});

$(document).ready(function(){

});

// transfer
$(document).ready(function(){
    $("#trnsfr_prod").on("change",function(){
        var lbl = ($(this).val()).trim();
        var row_data1 = [];
        $("#trnsfr_tbl_body tr").each(function(){
            var data1 = $(this).find('td').eq(0).text();
            row_data1.push(data1);
        });

        if(lbl == "" || lbl == " "){
            $(".trnsfr_message").text("Please Scan Product");
            $("#trnsfr_prod").val("");
            $("#trnsfr_prod").focus();
            setTimeout(function(){
                $(".trnsfr_message").text("");
            },5000);
        }else if($.inArray(lbl,row_data1) != -1){
            $(".trnsfr_message").text("Product Already Scanned");
            $("#trnsfr_prod").val("");
            $("#trnsfr_prod").focus();
            setTimeout(function(){
                $(".trnsfr_message").text("");
            },5000);
        }else{
            $.ajax({
                url: "/home/transfer/product-check",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: { "lbl": lbl},
                success: function(result){
                    if(result.status == 1){
                        var prd = result.message;

                        var data = "<tr>"
                            +"<td class='whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6'>"
                                +"<p class='w-24 sm:w-24 truncate overflow-clip'>"+prd.label+"</p>"
                            +"</td>"
                            +"<td class='whitespace-nowrap px-2 py-4 text-sm text-gray-500'>"+prd.plu+"</td>"
                            +"<td class='relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6'>"
                                +"<a href='#' class='rm_prod text-indigo-600 hover:text-indigo-900'>"
                                    +"<svg xmlns='http://www.w3.org/2000/svg' class='w-6 h-6' fill='none' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2'>"
                                        +"<path stroke-linecap='round' stroke-linejoin='round' d='M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16' />"
                                    +"</svg>"
                                +"</a>"
                            +"</td>"
                        +"</tr>";

                        $("#trnsfr_tbl_body").append(data);
                        $("#trnsfr_prod").val("");
                        $("#trnsfr_prod").focus();
                    }else{
                        $(".trnsfr_message").text(result.message);
                        $("#trnsfr_prod").val("");
                        $("#trnsfr_prod").focus();
                        setTimeout(function(){
                            $(".trnsfr_message").text("");
                        },5000);
                    }
                }, error: function (request, status, error) {
                    alert(request.responseText);
                }
            });
        }

    });
});

$(document).ready(function(){
    $("#trnsfr_dd").val($.datepicker.formatDate('dd/mm/yy', new Date()));
    var cur_date = new Date();
    $( "#trnsfr_dd" ).datepicker({
        language: 'en',
        startDate: cur_date,
        setDate: cur_date,
        dateFormat: "dd/mm/yy",
        autoClose: true,
        changeMonth: true,
        changeYear: true,
        });
});

// Stock Take
$(document).ready(function(){
    $("#stkPallet").on("change",function(){
        $(".stk_Pallet_tbl_body").empty();
        var pname = ($(this).val()).trim();

        if(pname == " " || pname == ""){
            $(".stk_take_message").text('Please Scan Pallet');
            $(".stk_take_message").addClass('bg-red-300');
            $("#stkPallet").val("");
            $("#stkPallet").focus();
            setTimeout(function(){
                $(".stk_take_message").text("");
                $(".stk_take_message").removeClass('bg-red-300');
            },5000);
        }else{
            $.ajax({
                url: "/home/stock-take/checkPallet",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: { "pname": pname},
                success: function(result){
                    if(result.status == 1){
                        var pname = result.message['pallet'];
                        var lname = result.message['location'];
                        var items = result.message['stk_line'];
                        $.map( items, function( val, i ) {
                            var prods = "<tr>"
                                        +"<td class='py-1 pl-4 pr-3 text-sm text-center font-medium text-gray-900 whitespace-nowrap sm:pl-6'>"+val['plu']+"</td>"
                                        +"<td class='py-1 pl-4 pr-3 text-sm text-center font-medium text-gray-500 whitespace-nowrap sm:pl-6'>"+val['name']+"</td>"
                                        +"<td class='py-1 pl-4 pr-3 text-sm text-center font-medium text-gray-500 whitespace-nowrap sm:pl-6'>"+val['count']+"</td>"
                                        +"</tr>";
                                $(".stk_Pallet_tbl_body").append(prods);
                        });
                        $("#stkPallet").val("");
                        $("#stkPallet").focus();
                        $(".p_name").text(pname);
                        $(".loc_name").text(lname);
                        $("._stkPallet").hide();
                        $("._stkProducts").show();
                        $("._new_stock").show();
                        $("#stkProduct").val("");
                        $("#stkProduct").focus();

                        $(".up_stk").hide();
                        $(".back_stk").show();
                        $(".cmplt_stk").show();
                    }else if(result.status == 2){
                        $(".stk_take_message").text(result.message);
                        $(".stk_take_message").addClass('bg-red-300');
                        $("#stkPallet").val("");
                        $("#stkPallet").focus();
                        setTimeout(function(){
                            $(".stk_take_message").text("");
                            $(".stk_take_message").removeClass('bg-red-300');
                        },5000);
                    }else{
                        $(".stk_take_message").text(result.message);
                        $(".stk_take_message").addClass('bg-red-300');
                        $("#stkPallet").val("");
                        $("#stkPallet").focus();
                        setTimeout(function(){
                            $(".stk_take_message").text("");
                            $(".stk_take_message").removeClass('bg-red-300');
                        },5000);
                    }
                }
            });
        }
    });
});

// $(document).ready(function(){
//     $(".up_stk").on("click",function(){
//         var upTrigger = $(".stk_Pallet_tbl_body tr").length;

//         if(upTrigger < 1){
//             $(".stk_take_message").text('Please Scan Pallet');
//             $(".stk_take_message").addClass('bg-red-300');
//             $("#stkPallet").val("");
//             $("#stkPallet").focus();
//             setTimeout(function(){
//                 $(".stk_take_message").text("");
//                 $(".stk_take_message").removeClass('bg-red-300');
//             },5000);
//         }else{
//             $("._stkPallet").hide();
//             $("._stkProducts").show();
//             $("._new_stock").show();
//             $("#stkProduct").val("");
//             $("#stkProduct").focus();

//             $(".up_stk").hide();
//             $(".back_stk").show();
//             $(".cmplt_stk").show();
//         }
//     });
// });

$(document).ready(function(){
    $(".back_stk").on("click",function(){
        $("._stkPallet").show();
        $("._stkProducts").hide();
        $("._new_stock").hide();
        $("#stkPallet").val("");
        $("#stkPallet").focus();

        // $(".up_stk").show();
        $(".back_stk").hide();
        $(".cmplt_stk").hide();
    });
});

$(document).ready(function(){
    $("#stkProduct").on("change",function(){
        var lbl = ($(this).val()).trim();
        var pallet = ($(".p_name").text()).trim();

        var row_data1 = [];
        $(".new_stock_body tr").each(function(){
            var data1 = $(this).find('td').eq(0).text();
            row_data1.push(data1);
        });

        if(lbl == "" || lbl == " "){
            $(".stk_take_message").text('Please Scan Product');
            $(".stk_take_message").addClass('bg-red-300');
            $("#stkProduct").val("");
            $("#stkProduct").focus();
            setTimeout(function(){
                $(".stk_take_message").text("");
                $(".stk_take_message").removeClass('bg-red-300');
            },5000);
        }else if($.inArray(lbl,row_data1) != -1){
            $(".stk_take_message").text('Product Already Scanned');
            $(".stk_take_message").addClass('bg-red-300');
            $("#stkProduct").val("");
            $("#stkProduct").focus();
            setTimeout(function(){
                $(".stk_take_message").text('');
                $(".stk_take_message").text("");
                $(".stk_take_message").removeClass('bg-red-300');
            },5000);
        }else{
            $.ajax({
                url: "/home/stock-take/checkProduct",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: { "lbl": lbl,"pallet":pallet},
                success: function(result){
                    if(result.status == 1){
                        var prod = result.message2;
                        var prod = "<tr>"
                                    +"<td class='hidden py-1 pl-4 pr-3 text-sm text-center font-medium text-gray-900 whitespace-nowrap sm:pl-6'>"+lbl+"</td>"
                                    +"<td class='whitespace-nowrap px-3 py-1 text-center text-sm text-gray-500'>"+prod['plu']+"</td>"
                                    +"<td class='whitespace-nowrap px-3 py-1 text-center text-sm text-gray-500'>"+prod['name']+"</td>"
                                    +"<td class='relative py-1 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6'>"
                                        +"<a href='#' class='rm_prod text-indigo-600 hover:text-indigo-900'>"
                                            +"<svg xmlns='http://www.w3.org/2000/svg' class='w-6 h-6' fill='none' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2'>"
                                                +"<path stroke-linecap='round' stroke-linejoin='round' d='M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16' />"
                                            +"</svg>"
                                        +"</a>"
                                    +"</td>"
                                    +"</tr>";

                        $(".new_stock_body").append(prod);

                        $(".stk_take_message").text(result.message);
                        $(".stk_take_message").addClass('bg-green-300');
                        $("#stkProduct").val("");
                        $("#stkProduct").focus();
                        setTimeout(function(){
                            $(".stk_take_message").text("");
                            $(".stk_take_message").removeClass('bg-green-300');
                        },3000);
                    }else{
                        $(".stk_take_message").text('Please Scan Product');
                        $(".stk_take_message").addClass('bg-red-300');
                        $("#stkProduct").val("");
                        $("#stkProduct").focus();
                        setTimeout(function(){
                            $(".stk_take_message").text("");
                            $(".stk_take_message").removeClass('bg-red-300');
                        },5000);
                    }
                },error: function (request, status, error) {
                    alert(request.responseText);
                }
            });
        }
    });
});

$(document).ready(function(){
    $(".cmplt_stk").on("click",function(){
        var upTrigger = $(".new_stock_body tr").length;
        var pallet = $(".p_name").text();
        var loc = $(".loc_name").text();

        var prod_data = [];
        $(".new_stock_body tr").each(function(){
            var data1 = $(this).find('td').eq(0).text();
            var item = {};
            item.label = data1;
            prod_data.push(item);
        });

        if(upTrigger < 1){
            $(".stk_take_message").text('Please Scan Products');
            $(".stk_take_message").addClass('bg-red-300');
            $("#stkPallet").val("");
            $("#stkPallet").focus();
            setTimeout(function(){
                $(".stk_take_message").text("");
                $(".stk_take_message").removeClass('bg-red-300');
            },5000);
        }else{
            $.ajax({
                url: "/home/stock-take/saveProducts",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: { "pallet": pallet,"products":prod_data,'loc':loc},
                success: function(result){
                    if(result.status == 1){
                        $(".or_done").show();
                        $(".success").show();
                        $(".co_message").text(result.message);
                        $(".card1").hide();
                        $(".card2").hide();

                        $(".new_stock_body").empty();
                        $(".stk_Pallet_tbl_body").empty();
                        $(".p_name").text("");
                        $(".loc_name").text("");
                    }else{
                        $(".new_stock_body").empty();
                        $(".stk_Pallet_tbl_body").empty();
                        $(".p_name").text("");
                        $(".loc_name").text("");
                        $(".card1").hide();
                        $(".card2").hide();

                        $(".or_done").show();
                        $(".error").show();
                        $(".co_message").text(result.message);
                    }
                },error: function (request, status, error) {
                    alert(request.responseText);
                }
            });
        }
    });
});
// end scan pallet

// locations
$(document).ready(function(){
    $(".add_loc").on("click",function(){
        var name = $("#name").val();
        $.ajax({
            url: "/location/add",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            method: 'post',
            data: { "name": name},
            success: function(result){
                if(result.status == 1){
                    $(".message").css('display','');
                    $(".message").text(result.message);
                    $(".message").addClass('text-green-500');
                    $("#name").val('');
                    $("#name").focus();
                    setTimeout(function(){
                        $(".message").css('display','none');
                    },3000);
                    $("#c0").load(location.href +" #c1");
                }else{
                    $(".message").css('display','');
                    $(".message").text(result.message);
                    $(".message").addClass('text-red-500');
                    setTimeout(function(){
                        $(".message").css('display','none');
                    },3000);
                }
            }, error: function (request, status, error) {
                alert(request.responseText);
            }
        });
    });
});

$(document).ready(function(){
    $("#loc_name").on("change",function(){
        var name = $("#loc_name option:selected").text();
        $("#edit_name").val(name);
    })
});

$(document).ready(function(){
    $(".edit_loc").on("click",function(){
        var loc_id = $("#loc_name option:selected").val();
        var loc_name = $("#edit_name").val();
        $.ajax({
            url: "/location/edit",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            method: 'post',
            data: { "id": loc_id,'name': loc_name},
            success: function (result) {
                if(result.status == 1){
                    $(".message1").css('display','');
                    $(".message1").text(result.message);
                    $(".message1").addClass('text-green-500');
                    $("#edit_name").val('');
                    $("#edit_name").attr('placeholder','Select Location to Edit');
                    setTimeout(function(){
                        $(".message1").css('display','none');
                        window.location.reload();
                    },3000);

                }else{
                    $(".message1").css('display','');
                    $(".message1").text(result.message);
                    $(".message1").addClass('text-red-500');
                    setTimeout(function(){
                        $(".message1").css('display','none');
                    },3000);
                }
            },error: function (request, status, error) {
                alert(request.responseText);
            }
        });
    });
});

$(document).ready(function(){
    $("#loc_upload").on("change",function(){
        var files = $("#loc_upload").val();
        if(files.length > 0){
            var fdata = new FormData();
            fdata.append('file', $("#loc_upload")[0].files[0]);
            $.ajax({
                url: "/location/import",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: fdata,
                dataType:'json',
                processData: false,
                contentType: false,
                success: function (result) {
                    if(result.status == 1){
                        $(".message3").css('display','');
                        $(".message3").text(result.message);
                        $(".message3").addClass('text-green-500');
                        setTimeout(function(){
                            $(".message3").css('display','none');
                            $("#c0").load(location.href +" #c1");
                            $("#s_loc0").load(location.href +" #s_loc1");
                        },3000);
                    }else{
                        $(".message3").css('display','');
                        $(".message3").text(result.message);
                        $(".message3").addClass('text-red-500');
                        setTimeout(function(){
                            $(".message3").css('display','none');
                        },3000);
                    }
                }, error: function (request, status, error) {
                            alert(request.responseText);
                }

            });
        }else{

        }
    });
});
// end locations

// Products
$(document).ready(function(){
    $("#prod_upload").on("change",function(){

    var cm_id = $("#prod_comp").val();
    var files = $("#prod_upload").val();

        if(files.length > 0){
            var fdata = new FormData();
            fdata.append('file', $("#prod_upload")[0].files[0]);
            fdata.append('cm_id',cm_id);

            $.ajax({
                url: "/product-import",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: fdata,
                dataType:'json',
                processData: false,
                contentType: false,
                success: function (result) {
                    if(result.status ==1){
                        $(".message3").css('display','');
                        $(".message3").text(result.message);
                        $(".message3").addClass('text-green-500');
                        setTimeout(function(){
                            $(".message3").css('display','none');
                            $("#p0").load(location.href +" #p1");
                            window.location.reload();
                        },3000);
                    }else{
                        $(".message3").css('display','');
                        $(".message3").text(result.message);
                        $(".message3").addClass('text-red-500');
                        setTimeout(function(){
                            $(".message3").css('display','none');
                        },3000);
                    }
                },error: function (request, status, error) {
                    alert(request.responseText);
                }

            });
        }
    });

});

$(document).ready(function(){
    $(".add_prod").on("click", function(){
        var p_comp = $("#prod_comp option:selected").val();
        var p_code = $("#prod_code").val();
        var p_name = $("#prod_name").val();
        var p_gtin = $("#prod_gtin").val();
        var p_brand = $("#prod_brand").val();
        var p_desc = $("#prod_desc").val();
        var p_size = $("#prod_size").val();

        if(p_code == ""){
            $("#modal-message").text("** All Fields Required **");
            $("#prod_code").focus();
        }
        if(p_name == ""){
            $("#modal-message").text("** All Fields Required **");
            $("#prod_name").focus();
        }
        if(p_gtin == ""){
            $("#modal-message").text("** All Fields Required **");
            $("#prod_gtin").focus();
        }
        if(p_brand == ""){
            $("#modal-message").text("** All Fields Required **");
            $("#prod_brand").focus();
        }
        if(p_desc == ""){
            $("#modal-message").text("** All Fields Required **");
            $("#prod_desc").focus();
        }
        if(p_size == ""){
            $("#modal-message").text("** All Fields Required **");
            $("#prod_size").focus();
        }

        if(p_code != "" && p_name != "" && p_gtin != "" && p_brand != "" && p_desc != "" && p_size !=""){
           $.ajax({
            url: "/products/add",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            method: 'post',
            data: { "p_code": p_code,"p_name": p_name,"p_gtin": p_gtin,
                    'p_brand': p_brand,"p_desc": p_desc,"p_size": p_size,
                    'p_comp':p_comp},
            success: function (result) {
                if(result.status == 1){
                    $("#modal-message").css('display','');
                    $("#modal-message").text(result.message);
                    $("#modal-message").addClass('bg-green-500');
                    setTimeout(function(){
                        $("#modal-message").css('display','none');
                        $("#p0").load(location.href +" #p1");
                        window.location.reload();
                    },3000);
                }else{
                    $("#modal-message").css('display','');
                    $("#modal-message").text(result.message);
                    $("#modal-message").addClass('bg-red-500');
                    setTimeout(function(){
                        $("#modal-message").css('display','none');
                    },3000);
                }
            },

           });
        }


    });
});

$(document).ready(function(){
    $(".prod_edit").on("click", function(){
        var id = $(this).attr('data');
        $("#edit_prod_id").val(id);

        $.ajax({
            url: "/products/get",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            method: 'post',
            data: { "id": id},
            success: function (result) {
                console.log(result);
                $("#edit_prod_code").val(result.product['0'].product_code);
                $("#edit_prod_name").val(result.product['0'].product_name);
                $("#edit_prod_gtin").val(result.product['0'].gtin);
                $("#edit_prod_brand").val(result.product['0'].brand);
                $("#edit_prod_comp").val(result.product['0'].company_id);
                $("#edit_prod_desc").val(result.product['0'].description);
                $("#edit_prod_size").val(result.product['0'].size);
            },
        });
    });
});

$(document).ready(function(){
    $(".edit_prod").on("click",function(){
        var p_id = $("#edit_prod_id").val();
        var p_code = $("#edit_prod_code").val();
        var p_name = $("#edit_prod_name").val();
        var p_gtin = $("#edit_prod_gtin").val();
        var p_brand = $("#edit_prod_brand").val();
        var p_desc = $("#edit_prod_desc").val();
        var p_size = $("#edit_prod_size").val();

        if(p_code == ""){
            $("#modal-message").text("** All Fields Required **");
            $("#prod_code").focus();
        }
        if(p_name == ""){
            $("#modal-message").text("** All Fields Required **");
            $("#prod_name").focus();
        }
        if(p_gtin == ""){
            $("#modal-message").text("** All Fields Required **");
            $("#prod_gtin").focus();
        }
        if(p_brand == ""){
            $("#modal-message").text("** All Fields Required **");
            $("#prod_brand").focus();
        }
        if(p_desc == ""){
            $("#modal-message").text("** All Fields Required **");
            $("#prod_desc").focus();
        }
        if(p_size == ""){
            $("#modal-message").text("** All Fields Required **");
            $("#prod_size").focus();
        }

        if(p_code != "" && p_name != "" && p_gtin != "" && p_brand != "" && p_desc != "" && p_size !=""){
            $.ajax({
             url: "/products/edit",
             headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
             method: 'post',
             data: { "p_code": p_code,"p_name": p_name,"p_gtin": p_gtin,
                     "p_brand": p_brand,"p_desc": p_desc,"p_size": p_size,
                     "p_id":p_id},
             success: function (result) {
                 if(result.status == 1){
                     $("#edit-modal-message").css('display','');
                     $("#edit-modal-message").text(result.message);
                     $("#edit-modal-message").addClass('bg-green-500');
                     setTimeout(function(){
                         $("#edit-modal-message").css('display','none');
                         $("#p0").load(location.href +" #p1");
                         window.location.reload();
                     },3000);
                 }else{
                     $("#edit-modal-message").css('display','');
                     $("#edit-modal-message").text(result.message);
                     $("#edit-modal-message").addClass('bg-red-500');
                     setTimeout(function(){
                         $("#edit-modal-message").css('display','none');
                     },3000);
                 }
             },

            });
         }

    });
});
// end Products

// stocks page
$(document).ready(function(){
    $("#flter").on("change",function(){
        var fltr = $(this).val();
        if(fltr.length > 1){
            $("#plu_fltr").show();
            $("#rcvd_dte_fltr").show();
        }else{
            if(fltr == 1){
                $("#plu_fltr").show();
            }
            else{
                $("#plu_fltr").hide();
            }
            if(fltr == 2){
                $("#rcvd_dte_fltr").show();
            }else{
                $("#rcvd_dte_fltr").hide();
            }
        }
    });
});

$(document).on("click",".srch_stcks",function(){
    var cx = $("#exist_cust1 option:selected").val();

    if(cx == 0){
        $(".srch_message").text('Select Customer');
        setTimeout(function(){
            $(".srch_message").text('');
        },5000)
    }else{
        if($("#plu_fltr").css("display") != "none"){
            var plu = $("#fltr_plu option:selected").val();
        }else{
            plu = "";
        }
        if($("#rcvd_dte_fltr").css("display") != "none"){
            var date = $("#srch_date").val();
        }else{
            date = "";
        }
        $("#stcks_tbl_body").empty();
        searchStocks(cx,date,plu);
    }
});

$(document).on("click",".stock_print",function(){
    var stock_id = $(this).attr('data-id');
    $(".print_table").empty();
    $.ajax({
        url: "/stocks/print-stock",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        method: 'post',
        data: {'stock_id':stock_id},
        success: function (result) {
            $("#printModal").show();
            $("#printModalBody").show();
            $(".print_table").append(result);
            $(".scan_page").hide();
        }, error: function (request, status, error) {
            alert(request.responseText);
        }
    });
});

$(document).ready(function(){
    $("#pallet1").on("change",function(){
        var id = $(this).val();
        $(".prod-tbl-body").empty();

        if(id == ""){
            alert("Error 515");
        }else{
            $.ajax({
                url: "/stocks/viewProductby/"+id,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'get',
                success: function (result) {
                    if(result != ""){
                        var products = result.products;
                        products.forEach(function(product){

                        var products = "<tr>"
                                    +"<td class='py-1 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6'>"+product['plu']+"</td>"
                                    +"<td class='px-1 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase'>"+product['label']+"</td>"
                                    +"<td class='px-1 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase'>"+product['name']+"</td>"
                                    +"<td class='hidden invisible px-1 py-4 text-sm text-gray-500 whitespace-nowrap sm:visible'>"+product['gtin']+"</td>"
                                    +"<td class='px-1 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase'>"+product['weight']+"</td>"
                                    +"<td class='invisible px-1 py-4 text-sm text-gray-500 whitespace-nowrap sm:visible'>"+product['best_before']+"</td>"
                                    +"<td class='invisible px-1 py-4 text-sm text-gray-500 whitespace-nowrap sm:visible'>"+product['rcvd']+"</td>"
                                    +"<td class='relative flex flex-row invisible py-4 pl-3 pr-4 text-sm font-medium text-left whitespace-nowrap sm:visible sm:pr-6'>"
                                        +"<a href='#' id='' class='px-2 text-green-600 hover:text-green-900'>"
                                            +"<svg xmlns='http://www.w3.org/2000/svg' class='w-6 h-6' fill='none' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2'>"
                                                +"<path stroke-linecap='round' stroke-linejoin='round' d='M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4' />"
                                            +"</svg>"
                                        +"</a>"
                                        +"<a href='#' id='' class='px-2 text-red-600 hover:text-red-900'>"
                                            +"<svg xmlns='http://www.w3.org/2000/svg' class='w-6 h-6' fill='none' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2'>"
                                                +"<path stroke-linecap='round' stroke-linejoin='round' d='M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16' />"
                                            +"</svg>"
                                        +"</a>"
                                    +"</td>"
                                    +"</tr>";
                        $(".prod-tbl-body").append(products);

                        });
                    }
                }
            });
        }
    });
});

function searchStocks(cx,date,plu){
    $.ajax({
        url: "/stocks/search-stocks",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        method: 'post',
        data: { "cx":cx,'date':date,'plu':plu},
        success: function (result) {
            if(result.status == 1){
                var stocks = result.stocks;
                stocks.forEach(function(stock){
                    var data = "<tr>"
                        +"<td class='whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6'>"
                            +"<a href='/stocks/viewProduct/"+stock.palletid+"' data-id='"+stock.palletid+"' class='prod_view text-indigo-600 hover:text-indigo-900'>"
                                    +"<p class='w-24 sm:w-24 truncate overflow-clip'>"+stock.pallet+"</p>"
                            +"</a>"
                        +"</td>"
                        +"<td class='whitespace-nowrap px-3 py-4 text-sm text-gray-500'>"
                            +"<a href='#' class='hover:text-red-800 text-red-500'>"+stock.location+"</a></td>"
                        +"<td class='whitespace-nowrap px-3 py-4 invisible sm:visible text-sm text-gray-500'>";
                        var sc = stock.sc_line;
                        $.map( sc, function( val, i ) {
                            data += val['plu']+"</br>";
                        });
                        data +="</td>";
                        data +="<td class='whitespace-nowrap px-3 py-4 invisible sm:visible text-sm text-gray-500'>"
                        $.map( sc, function( val, i ) {
                            data += val['name']+"</br>";
                        });
                        data +="</td>";
                        data +="<td class='whitespace-nowrap px-3 py-4 invisible sm:visible text-sm text-gray-500'>"
                        $.map( sc, function( val, i ) {
                            data += val['count']+"</br>";
                        });
                        data +="</td>"
                                +"<td class='whitespace-nowrap px-3 py-4 invisible sm:visible text-sm text-gray-500'>"+stock.best_before+"</td>"
                                +"<td class='whitespace-nowrap px-3 py-4 invisible sm:visible text-sm text-gray-500'>"+stock.stored+"</td>"
                                +"<td class='relative whitespace-nowrap invisible sm:visible py-4 pl-3 pr-4 text-left text-sm font-medium sm:pr-6'>"
                                +   "<a href='#' data-id='"+stock.stockid+"' class='stock_print text-indigo-600 hover:text-indigo-900'>Print Label</a>"
                                +"</td>";

                    data +="</tr>";

                    $("#stcks_tbl_body").append(data);
                });
            }else if(result.status == 2){
                stocks = result.stocks[0];
                $.map( stocks, function( val, i ) {
                    var prods = "<tr>"
                                +"<td class='whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6'>"
                                    +"<a href='/stocks/viewProduct/"+val['palletid']+"' data-id='"+val['palletid']+"' class='prod_view text-indigo-600 hover:text-indigo-900'>"
                                            +"<p class='w-24 sm:w-24 truncate overflow-clip'>"+val['pallet']+"</p>"
                                    +"</a>"
                                +"</td>"
                                +"<td class='whitespace-nowrap px-3 py-4 text-sm text-gray-500'>"
                                    +"<a href='#' class='hover:text-red-800 text-red-500'>"+val['location']+"</a></td>"
                                +"<td class='px-3 py-4 text-sm text-gray-500 whitespace-nowrap'>"+val['plu']+"</td>"
                                +"<td class='px-3 py-4 text-sm text-gray-500 whitespace-nowrap'>"+val['name']+"</td>"
                                +"<td class='px-3 py-4 text-sm text-gray-500 whitespace-nowrap'>"+val['count']+"</td>"
                                +"<td class='px-3 py-4 text-sm text-gray-500 whitespace-nowrap'>"+val['best_before']+"</td>"
                                +"<td class='px-3 py-4 text-sm text-gray-500 whitespace-nowrap'>"+val['received_date']+"</td>"
                                +"<td class='relative invisible py-4 pl-3 pr-4 text-sm font-medium text-left whitespace-nowrap sm:visible sm:pr-6'>"
                                +"</td>"
                                +"</tr>";
                    $("#stcks_tbl_body").append(prods);
                });
            }else if(result.status == 3){
                stocks = result.stocks;
                stocks.forEach(function(stock){
                    var data = "<tr>"
                        +"<td class='whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6'>"
                            +"<a href='/stocks/viewProduct/"+stock.palletid+"' data-id='"+stock.palletid+"' class='prod_view text-indigo-600 hover:text-indigo-900'>"
                                    +"<p class='w-24 sm:w-24 truncate overflow-clip'>"+stock.pallet+"</p>"
                            +"</a>"
                        +"</td>"
                        +"<td class='whitespace-nowrap px-3 py-4 text-sm text-gray-500'>"
                            +"<a href='#' class='hover:text-red-800 text-red-500'>"+stock.location+"</a></td>"
                        +"<td class='whitespace-nowrap px-3 py-4 invisible sm:visible text-sm text-gray-500'>";
                        var sc = stock.sc_line;
                        $.map( sc, function( val, i ) {
                            data += val['plu']+"</br>";
                        });
                        data +="</td>";
                        data +="<td class='whitespace-nowrap px-3 py-4 invisible sm:visible text-sm text-gray-500'>"
                        $.map( sc, function( val, i ) {
                            data += val['name']+"</br>";
                        });
                        data +="</td>";
                        data +="<td class='whitespace-nowrap px-3 py-4 invisible sm:visible text-sm text-gray-500'>"
                        $.map( sc, function( val, i ) {
                            data += val['count']+"</br>";
                        });
                        data +="</td>"
                                +"<td class='whitespace-nowrap px-3 py-4 invisible sm:visible text-sm text-gray-500'>"+stock.best_before+"</td>"
                                +"<td class='whitespace-nowrap px-3 py-4 invisible sm:visible text-sm text-gray-500'>"+stock.stored+"</td>"
                                +"<td class='relative whitespace-nowrap invisible sm:visible py-4 pl-3 pr-4 text-left text-sm font-medium sm:pr-6'>"
                                +   "<a href='#' data-id='"+stock.stockid+"' class='stock_print text-indigo-600 hover:text-indigo-900'>Print Label</a>"
                                +"</td>";

                    data +="</tr>";

                    $("#stcks_tbl_body").append(data);
                });
            }else{
                $(".srch_message").text(result.stocks);
                setTimeout(function(){
                    $(".srch_message").text('');
                },5000)
            }


        }, error: function (request, status, error) {
            alert(request.responseText);
        }
    });
}
$(document).on("click",".print_stock",function(){
    var c_date = moment().format('DD-MM-YYYY');
    var pname = "cs_"+c_date+"Stock";

    $("#stcks_tbl").tableExport({
        type:'csv',
        mso: {fileFormat:'xlsx',worksheetName: pname},
        headings: true,
        fileName: pname,
        bootstrap: true,
        exportHiddenCells: false,
        // ignoreColumn: ["GTIN","MOVE / DELETE"],
    });
});

$(document).on("click",".print_palletProds",function(){
    var c_date = moment().format('DD-MM-YYYY');
    var pallet = $("#pallet1 option:selected").text();
    var pname = "cs_"+c_date+"Stock";
    $("#prod-tbl").tableExport({
        type:'csv',
        mso: {fileFormat:'xlsx',worksheetName: pname},
        headings: true,
        fileName: pallet,
        bootstrap: true,
        exportHiddenCells: false,
        ignoreColumn: ["GTIN","MOVE / DELETE"],
    });
});

// $(document).on("click",".print-product",function(){
//     var pname = $(".pallet_name").val();
//     $("#prod-tbl").tableHTMLExport({
//         type:'csv',
//         filename:pname+'.csv',
//         ignoreColumns:'.acciones,#primero',
//         ignoreRows: '#ultimo'});
// });

// orders
$(document).ready(function(){
    $("#cx1").on("change",function(){
        var id = $(this).val();
        $("#products").empty();
        $(".or_tbl_body").empty();
        $.ajax({
            url: "/orders/get-product/"+id,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            method: 'get',
            success: function (result) {
                result.forEach(function(result){
                    var val = result.id;
                    var plu = result.product_code;
                    var pr_name = result.product_name;
                    var gtin = result.gtin;
                    var option = "<option value="+val+" data-id="+gtin+">"+plu+" - "+pr_name+"</option>";

                    $("#products").append(option);
                });
            }
        });
    });
});

$(document).ready(function(){
    $(".add_or").on("click",function(){
        var pr_id = $("#products option:selected").val();
        var prod = $("#products option:selected").text();
        var gtin = $("#products option:selected").attr('data-id');
        const arr = prod.split("-");
        var plu = arr[0];
        var name = arr[1];
        var qty = $("#order_qty").val();

        if(plu == ""){
            $(".or_message").text("Please Select Products");
            $(".or_message").addClass("bg-red-300");
            setTimeout(function(){
                $(".or_message").text("");
                $(".or_message").removeClass("bg-red-300");
            },5000);
        }else if(qty == ""){
            $(".or_message").text("Please Enter Quantity");
            $(".or_message").addClass("bg-red-300");
            setTimeout(function(){
                $(".or_message").text("");
                $(".or_message").removeClass("bg-red-300");
            },5000);
        }else{
            var pr_line = "<tr>"
            +"<td class='py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6'>"
            +"<p class='w-12 truncate overflow-clip'>"+plu+"</p>"
            +"</td>"
            +"<td class='px-3 py-4 text-sm text-gray-500 whitespace-nowrap'>"+gtin+"</td>"
            +"<td class='px-3 py-4 text-sm text-gray-500 whitespace-nowrap'>"+name+"</td>"
            +"<td class='px-3 py-4 text-sm text-gray-500 whitespace-nowrap'><p class='w-12 truncate overflow-clip'>"+qty+"</p></td>"
            +"<td class='relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6'>"
                +"<a href='#' class='rm_prod text-indigo-600 hover:text-indigo-900'>"
                    +"<svg xmlns='http://www.w3.org/2000/svg' class='w-6 h-6' fill='none' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2'>"
                        +"<path stroke-linecap='round' stroke-linejoin='round' d='M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16' />"
                    +"</svg>"
                +"</a>"
            +"</td>"
            +"</tr>";

            $(".or_tbl").append(pr_line);
            var qty = $("#order_qty").val("");
        }

    });
});

$(document).ready(function(){
    $(".add_order").on("click",function(){
        var pr = $(".or_tbl_body tr").length;
        var or_type = $("#orderType").val();
        var cx = $("#cx1 option:selected").val();

        var prod_data = [];
        $(".or_tbl_body tr").each(function(){
            var data1 = $(this).find('td').eq(0).text();
            var data2 = $(this).find('td').eq(1).text();
            var data3 = $(this).find('td').eq(2).text();
            var data4 = $(this).find('td').eq(3).text();
            var item = {};
            item.plu = data1;
            item.gtin = data2;
            item.pname = data3;
            item.qty = data4;
            prod_data.push(item);
        });

        if(pr == 0){
            $(".or_message").text("Add Products First");
            $(".or_message").addClass("bg-red-300");
            setTimeout(function(){
                $(".or_message").text("");
                $(".or_message").removeClass("bg-red-300");
            },5000);
        }else{
            $.ajax({
                url: "/orders/add-order",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data:{'cx':cx,'or_type':or_type,'products':prod_data},
                success: function (result) {
                    if(result.status == 1){
                        $(".or_message").addClass("bg-green-300");
                        $(".or_message").text(result.message);
                        $(".or_tbl_body").empty();
                        setTimeout(function(){
                            $(".or_message").text("");
                            $(".or_message").removeClass("bg-green-300");
                        },5000);
                    }else{
                        $(".or_message").addClass("bg-red-300");
                        $(".or_message").text(result.message);
                        $(".or_tbl_body").empty();
                        setTimeout(function(){
                            $(".or_message").text("");
                            $(".or_message").removeClass("bg-red-300");
                        },5000);
                    }
                }, error: function (request, status, error) {
                    alert(request.responseText);
                }
            });
        }
    });
});
// end orders
