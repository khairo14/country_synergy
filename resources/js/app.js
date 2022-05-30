require('./bootstrap');
require('./components');

// scan product
$(document).on("click",".stockIn",function(){
    window.location.href=('/home/scan');
});

$(document).on("click",".stockOut",function(){
    window.location.href=('/home/scan-out');
});

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
          },2000);
        }else if($.inArray(pcode,row_data1) != -1){
            $(".scan_pcode_message").text('Product Already Scanned');
            setTimeout(function(){
              $(".scan_pcode_message").text('');
              $("#scan_pcode").val('');
              $("#scan_pcode").focus();
            },2000);
        }else{
            var cx = $("#exist_cust1 option:selected").val();
            $.ajax({
                url: "/home/scan/check-product",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: { "label": pcode,'cust':cx},
                success: function (result) {
                    if(result.status == 1){
                        var gtin = result.message[0].gtin;
                        var pname = result.message[0].product_name;
                        var plu = result.message[0].product_code;
                        var prod = "<tr>"
                                +"<td class='py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6'>"
                                +"<p class='w-12 truncate overflow-clip'>"+pcode+"</p>"
                                +"</td>"
                                +"<td class='px-3 py-4 text-sm text-gray-500 whitespace-nowrap'>"+gtin+"</td>"
                                +"<td class='px-3 py-4 text-sm text-gray-500 whitespace-nowrap'>"+plu+"-"+pname+"</td>"
                                +"<td class='relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6'>"
                                    +"<a href='#' class='rm_prod text-indigo-600 hover:text-indigo-900'>"
                                        +"<svg xmlns='http://www.w3.org/2000/svg' class='w-6 h-6' fill='none' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2'>"
                                            +"<path stroke-linecap='round' stroke-linejoin='round' d='M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16' />"
                                        +"</svg>"
                                    +"</a>"
                                +"</td>"
                                +"</tr>";
                        $("#scnproducts_body").append(prod);
                        $("#scan_pcode").val('');
                        $("#scan_pcode").focus();
                    }else{
                        $(".scan_pcode_message").text(result.message);
                            setTimeout(function(){
                                $(".scan_pcode_message").text('');
                                $("#scan_pcode").val('');
                                $("#scan_pcode").focus();
                            },2000);
                        var prod = "<tr>"
                                +"<td class='py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6'>"
                                +"<p class='w-12 truncate overflow-clip'>"+pcode+"</p>"
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
                        $("#scnproducts_body").append(prod);
                        $("#scan_pcode").val('');
                        $("#scan_pcode").focus();
                    }
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
            },2000);
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
            },2000);
        }else{
            $.ajax({
                url: "/home/scan/check-location",
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
                        },2000);
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
            },2000);
        }else if(loc == "" || loc ==" "){
            $(".scan_loc_message2").text('Please Scan Location');
            $("#location2").focus();
            setTimeout(function(){
                $(".scan_pallet_message").text('');
            },2000);
        }else{
            $.ajax({
                url: "/home/scan/scan-products",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: {'cx':cx,'products':prod_data,'label':label,'qty':qty,'loc':loc,'best_date':bst_date},
                success: function (result) {
                    console.log(result);
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

// end scan product
// scan pallet option yes
$(document).ready(function(){
    $("#scnpallet").on("change", function(){
        var p_name = ($(this).val()).trim();

        if(p_name == "" || p_name == " "){
            $(".scan_pallet_message").text('Pallet label cannot empty');
            setTimeout(function(){
                $(".scan_pallet_message").text('');
            },2000);
        }else{
            $.ajax({
                url: "/home/scan/check-pallet",
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
                        },2000);

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
            },2000);
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
            },2000);
        }else{
            $.ajax({
                url: "/home/scan/check-location",
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
                        },2000);
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
            },2000);
        }else if(td_qty == ""){
            $(".scan_pallet_message").text('Please Enter Quantity');
            $("#scnpallet").focus();
            setTimeout(function(){
                $(".scan_pallet_message").text('');
            },2000);
        }else if(loc == ""){
            $(".scan_pallet_message").text('Please Enter Location');
            $("#scnpallet").focus();
            setTimeout(function(){
                $(".scan_pallet_message").text('');
            },2000);
        }else{
            $.ajax({
                url: "/home/scan/add-pallet",
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

// scan pallet option no
$(document).on("click",".option_no",function(){
    var min = 10000000;
    var max = 99999900;
    var random = Math.floor(Math.random()*(max-min + 1))+min;
    var cx = $("#exist_cust1 option:selected").val();
    var label = cx.toString().padStart(2,'0') + random;

    $.ajax({
        url: "/home/scan/check-pallet",
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
            },2000);
        }else{
            $.ajax({
                url: "/home/scan/check-location",
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
                        },2000);
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
            },2000);
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
            +"#print_table{width:100%; height:100%; border-collapse:collapse; border:1px solid #000;}"
            +"#print_table_body tr{text-align:center;padding:5px;}"
            +"#print_table_body td{border:1px solid #000; border-collapse:collapse; text-align:center;}"
            +"</style>";

    style += tbl.prop('outerHTML');
    var wme = window.open("","","width=500","height=700");
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
            },2000);
        }else if(loc == ""){
            $(".scan_pallet_message2").text('Please Enter Location');
            $("#scnpallet2").focus();
            setTimeout(function(){
                $(".scan_pallet_message2").text('');
            },2000);
        }else{
            $.ajax({
                url: "/home/scan/add-pallet",
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

// Pallet out
$(document).ready(function(){
    $("#scnpalletout").on("change",function(){
        var pout_name = ($(this).val()).trim();

        if(pout_name == "" || pout_name == " "){
            $(".scan_pallet_message").text('Please Scan Pallet');
            setTimeout(function(){
                $(".scan_pallet_message").text("");
            },2000);
        }else{
            $.ajax({
                url: "/home/scan-out/getPallet",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: { "label": pout_name},
                success: function(result){
                    console.log(result);
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
                        },2000);
                    }
                }, error: function (request, status, error) {
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
$(document).on("click",".srch_stcks",function(){
    var cx = $("#exist_cust1 option:selected").val();
    var date = $("#srch_date").val();

    if(cx == 0){
        $(".srch_message").text('Select Customer');
        setTimeout(function(){
            $(".srch_message").text('');
        },2000)
    }else if(date ==""){
        $(".srch_message").text('Select Date');
        setTimeout(function(){
            $(".srch_message").text('');
        },2000)
    }else{
        searchStocks(cx,date);
    }
});

$(document).on("click",".stock_print",function(){
    var stock_id = $(this).attr('id');
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
    $("#srch_date").on("change",function(){
        alert('asd');
    });
});

$(document).on("click","._print",function(){
alert('a');
});

function searchStocks(cx,date){
    $.ajax({
        url: "/stocks/search-stocks",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        method: 'post',
        data: { "cx":cx,'date':date},
        success: function (result) {
            if(result.status == 1){
                var stocks = result.stocks;
                stocks.forEach(function(stock){
                    var data = "<tr>"
                        +"<td class='whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6'>"
                            +"<p class='w-24 sm:w-24 truncate overflow-clip'>"+stock.pallet+"</p>"
                        +"</td>"
                        +"<td class='whitespace-nowrap px-3 py-4 text-sm text-gray-500'>"
                            +"<a href='#' class='hover:text-red-800 text-red-500'>"+stock.location+"</a></td>"
                        +"<td class='whitespace-nowrap px-3 py-4 text-sm text-gray-500'>"+stock.qty+"</td>"
                        +"<td class='whitespace-nowrap px-3 py-4 invisible sm:visible text-sm text-gray-500'>"+stock.date+"</td>"
                        +"<td class='relative whitespace-nowrap invisible sm:visible py-4 pl-3 pr-4 text-left text-sm font-medium sm:pr-6'>"
                        +   "<a href='#' class='_print text-indigo-600 hover:text-indigo-900'>Print</a>"
                        +"</td>"
                    +"</tr>";

                    $("#stcks_tbl_body").append(data);
                });
            }else{
                $(".srch_message").text(result.stocks);
                setTimeout(function(){
                    $(".srch_message").text('');
                },2000)
            }


        }, error: function (request, status, error) {
            alert(request.responseText);
        }
    });
}
