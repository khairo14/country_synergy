const { data, get } = require('jquery');

require('./bootstrap');
require('./components');

// start of scan page
$(document).on("click",".scan",function(){
    window.location.href=('/scan');
});
$(document).ready(function(){
    $(".order_id").change(function(){
        var or_id = $(".order_id").val();
        $("#tbl_cont").load(location.href +" #order_tbl");
        $("#tbl_cont2").load(location.href +" #order_tbl2");

        setTimeout(function(){
            $.ajax({
                url: "/scan/order",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: { "or_id": or_id},
                success: function (result) {
                    if(result.status == 0){
                        var message = "<tr class='table-row'>"
                            +"<td colspan='3' class='table-cell bg-red-200 text-center text-sm border border-slate-600 w-auto'>"+result.message+"</td>"
                            +"</tr>";
                            $(".order_tbl").append(message);
                            $(".next0_scan").removeClass("inline-flex");
                    }else{
                        $.each(result.products, function(index,val){
                            var pr_code = val.products[0].product_code;
                            var pr_qty = val.qty;
                            var pr_name = val.products[0].product_name;

                            var orders = "<tr>"
                                +"<td class='py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-gray-700 uppercase sm:pl-6'>"+pr_code+"</td>"
                                +"<td class='px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase'>"+pr_name+"</td>"
                                +"<td class='px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase'>"+pr_qty+"</td>"
                                +"</tr>";

                            setTimeout(function(){
                                $(".order_tbl2").append(orders);
                            },1000);
                            $(".order_tbl").append(orders);

                        });
                        $(".next0_scan").addClass('inline-flex');
                    }
                }, error: function (request, status, error) {
                        alert(request.responseText);
                }
            },500);
        });

    });
});

$(document).ready(function(){
    $('.scan_products').change(function(){
        var pr_label = $('.scan_products').val();
        var pr_count = $(".product_tbl tr").length;
        var or = $(".order_id").val();

        var row_data1 = [];
        $(".product_tbl tr").each(function(){
            var data1 = $(this).find('td').eq(1).text();
            row_data1.push(data1);
        });

        if(pr_label == " "){
            $(".message1").text("Please Scan again");
            $(".message1").addClass("bg-red-500");
            $(".scan_products").val("");
            $(".scan_products").focus();
            $(".scan_products").attr("placeholder","Scan code");
            setTimeout(function(){
                $(".message1").text("");
                $(".message1").removeClass("bg-red-500");
            },3000);
        }else if(pr_count >= 21){
            $(".message1").text("Pallete limit already exceed");
            $(".message1").addClass("bg-red-500");
            $(".scan_products").val("");
            $(".scan_products").focus();
            $(".scan_products").attr("placeholder","Scan code");
            setTimeout(function(){
                $(".message1").text("");
                $(".message1").removeClass("bg-red-500");
            },3000);
        }else if($.inArray(pr_label,row_data1) != -1){
            $(".message1").text("Product Already Scanned");
            $(".message1").addClass("bg-red-500");
            $(".scan_products").val("");
            $(".scan_products").focus();
            $(".scan_products").attr("placeholder","Scan code");
            setTimeout(function(){
                $(".message1").text("");
                $(".message1").removeClass("bg-red-500");
            },3000);
        }else{
            $.ajax({
                url: "/checkStocks",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: { "pr_label": pr_label,"or_id":or},
                success: function (result) {
                    console.log(result);
                    // if(result.status == 0){
                    //     $(".message1").text(result.message);
                    // }else{
                    //     var pr = result.message.products;
                    //     var scan =
                    //         "<tr>"
                    //         +"<td class='py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-gray-700 uppercase sm:pl-6'>"+pr_count+"</td>"
                    //         +"<td class='px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase'><p class='truncate hover:text-clip w-32'>"+pr_label+"</p></td>"
                    //         +"<td class='px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase'>"+pr[0].product_code+'-'+pr[0].product_name+"</td>"
                    //         +"<td class='px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase'>"
                    //         +"<button type='button' class='rm_scan'>"
                    //         +"<svg xmlns='http://www.w3.org/2000/svg' class='w-6 h-6' fill='none' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2'>"
                    //             +"<path stroke-linecap='round' stroke-linejoin='round' d='M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16' />"
                    //         +"</svg>"
                    //         +"</button>"
                    //         +"</td>"
                    //         +"</tr>"
                    //     $(".product_tbl").append(scan);
                    // }
                }, error: function (request, status, error) {
                    alert(request.responseText);
                }

            });
            $(".scan_products").val("");
            $(".scan_products").focus();
            $(".scan_products").attr("placeholder","Scan code");
        }
    });
});

$(document).ready(function(){
    $('.scan_pallete').change(function(){
        var pl_label = $('.scan_pallete').val();
        var pl_count = $(".pallete_tbl tr").length;

        var row_data2 = [];
        $(".pallete_tbl tr").each(function(){
            var data2 = $(this).find('td').eq(0).text();
            row_data2.push(data2);
        });

        if(pl_label == " "){
            $(".message2").text("Please Scan Again");
            $(".scan_pallete").val("");
            $(".scan_pallete").focus();
            $(".scan_pallete").attr("placeholder","Scan pallete code");
        }else if(pl_count >= 2){
            $(".message2").text("1 Pallete at a time");
            $(".scan_pallete").val("");
            $(".scan_pallete").focus();
            $(".scan_pallete").attr("placeholder","Scan pallete code");
        }else if($.inArray(pl_label,row_data2) != -1){
            $(".message2").text("Pallete already Scanned");
            $(".scan_pallete").val("");
            $(".scan_pallete").focus();
            $(".scan_pallete").attr("placeholder","Scan pallete code");
        }else{
            $.ajax({
                url: "/check/pallete",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: { "pl_label": pl_label},
                success: function (result) {
                    if(result === 'false'){
                        $(".message2").text("'Pallete already stored in Bin'");
                    }else{
                        $(".pallete_tbl").append(
                            "<tr class='table-row'>"
                            +"<td class='table-cell text-center text-sm border border-slate-600 w-auto'>"+pl_label+"</td>"
                            +"</tr>"
                        );
                    }
                },
            });
            $(".scan_pallete").val("");
            $(".scan_pallete").focus();
            $(".scan_pallete").attr("placeholder","Scan pallete code");
        }
    });
});

$(document).ready(function(){
    $('.scan_bin').change(function(){
        var bin_label = $('.scan_bin').val();
        var bin_count = $(".bin_tbl tr").length;

        var row_data3 = [];
        $(".bin_tbl tr").each(function(){
            var data3 = $(this).find('td').eq(0).text();
            row_data3.push(data3);
        });

        if(bin_label == " "){
            $(".message3").text("Please Scan Again");
            $(".scan_bin").val("");
            $(".scan_bin").focus();
            $(".scan_bin").attr("placeholder","Scan Bin Code");
        }else if(bin_count >= 2){
            $(".message3").text("1 Bin Location at a time");
            $(".scan_bin").val("");
            $(".scan_bin").focus();
            $(".scan_bin").attr("placeholder","Scan Bin Code");
        }else if($.inArray(bin_label,row_data3) != -1){
            $(".message3").text("Bin already Scanned");
            $(".scan_bin").val("");
            $(".scan_bin").focus();
            $(".scan_bin").attr("placeholder","Scan Bin Code");
        }else{

            $(".bin_tbl").append(
                "<tr class='table-row'>"
                +"<td class='table-cell text-center text-sm border border-slate-600 w-auto'>"+bin_label+"</td>"
                +"</tr>"
            );

            $(".scan_bin").val("");
            $(".scan_bin").focus();
            $(".scan_bin").attr("placeholder","Scan Bin Code");
        }
    });
});

$(document).ready(function(){
    $('.next0_scan').on("click",function(e){
        e.preventDefault();
        var or_id = $(".order_id").val();
        var tbl_length = $(".order_tbl tr").length;
        if(or_id != ""){
            $(".order_card").hide();
            $(".product_card").show();
            $(".scan_products").focus();
            $(".scan_products").attr("placeholder","Scan code");
        }else{
            var message = "Please Input order number"
            var items = "<tr class='table-row'>"
                        +"<td colspan='3' class='table-cell bg-red-200 text-center text-sm border border-slate-600 w-auto'>"+message+"</td>"
                        +"</tr>";
                        $(".order_tbl").append(items);
            setTimeout(function(){
                $("#tbl_cont").load(location.href +" #order_tbl");
            },2000)
        }

    });
    $('.next_scan').on("click",function(e){
        e.preventDefault();
        $(".product_card").hide();
        $(".pallete_card").show();

        $(".scan_pallete").val("");
        $(".scan_pallete").focus();
        $(".scan_pallete").attr("placeholder","Scan pallete code");
    });
    $(document).on("click",".rm_scan",function(){
        $(this).closest("tr").remove();
        $(".scan_products").focus();
        $(".scan_products").attr("placeholder","Scan code");
    });

    $('.next2_scan').on("click",function(e){
        e.preventDefault();
        $(".product_card").hide();
        $(".pallete_card").hide();
        $(".bin_card").show();

        $(".scan_bin").val("");
        $(".scan_bin").focus();
        $(".scan_bin").attr("placeholder","Scan Bin Code");
    });

    $(".prev_scan").on("click",function(e){
        e.preventDefault();
        $(".pallete_card").hide();
        $(".bin_card").hide();
        $(".product_card").show();

        $(".scan_products").val("");
        $(".scan_products").focus();
        $(".scan_products").attr("placeholder","Scan code");
    });

    $(".prev2_scan").on("click",function(e){
        e.preventDefault();
        $(".pallete_card").show();
        $(".product_card").hide();
        $(".bin_card").hide();

        $(".scan_pallete").val("");
        $(".scan_pallete").focus();
        $(".scan_pallete").attr("placeholder","Scan pallete code");
    });

});

$(document).on("click",".complete_scan",function(){
    pr_data = [];
    pl_data = [];
    bin_data = [];

    $(".product_tbl_body tr").each(function () {
        var rows = $(this);
        var a = rows.find("td:eq(1)").text();
        pr_data.push(a);
    });

    $(".pallete_tbl_body tr").each(function () {
        var rows = $(this);
        var b = rows.find("td:eq(0)").text();
        pl_data.push(b);
    });

    $(".bin_tbl_body tr").each(function () {
        var rows = $(this);
        var c = rows.find("td:eq(0)").text();
        bin_data.push(c);
    });

    if(pr_data == "" || pl_data == "" || bin_data == ""){
        $(".message3").text("Please check Products/Pallete/Bin tables");
        $(".scan_bin").val("");
        $(".scan_bin").focus();
        $(".scan_bin").attr("placeholder","Scan Bin Code");
    }else{
        $.ajax({
            url: "/store/products",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            method: 'post',
            data: { "pr_data": pr_data,"pl_data":pl_data,"bin_data":bin_data},
            dataType: 'JSON',
            success: function (result) {
                // alert(JSON.stringify(result));
                // console.log(result.message);
                window.location.reload();
            },
        });
    }

});
// end of scan page
// App Blade Users
$(document).ready(function(){
    $(".logout").on("click",function(){
        $.ajax({
            url: "/sign-out",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            method: 'post',
            success: function (result) {
                if(result === '0'){
                    window.location = '/';
                }
            },
        });
    });
});

// End of App Blade

// Products Page
$(document).on("click",".up_prods",function(){
    var cm = $('#cm_prods').attr('data');

    if(cm === ''){
        $('.ul_warning').show();
        $('.ul_form').hide();
        $('.fl_ul').hide();
    }else{
        $('.fl_ul').show();
        $('.ul_form').show();
        $('#cm_id').val(cm);
        $('.ul_warning').hide();

    }
});

$(document).on("click",".fl_ul",function(){
    var cm_id = $("#cm_id").val();
    var files = $("#file-upload").val();

    if(files.length > 0){
        var fdata = new FormData();
        fdata.append('file', $("#file-upload")[0].files[0]);
        fdata.append('cm_id',cm_id);
        $.ajax({
            url: "/file-import",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            method: 'post',
            data: fdata,
            dataType:'json',
            processData: false,
            contentType: false,
            success: function (result) {
                // alert(JSON.stringify(result));
                if(result.status == 0){
                    $('.ul_modal').hide();
                    $('.ul_modal_body').hide();
                    $('.alert_err').show();
                    $('.alert_err_body p').text(result.message);
                    $('.alert_err_body h3').text("Prducts Upload");
                    setTimeout(function(){
                        $('.alert_err').css("display","none");
                        $("#pr_table").load(location.href +" #pr_table");
                    },2000);
                }else{
                    $('.ul_modal').hide();
                    $('.ul_modal_body').hide();
                    $('.alert_suc').show();
                    $('.alert_suc_body p').text(result.message);
                    $('.alert_suc_body h3').text("Prducts Upload");

                    setTimeout(function(){
                        $('.alert_suc').css("display","none");
                        $("#pr_table").load(location.href +" #pr_table");
                    },2000);
                }
            },

        });
    }else{
        $('.ul_modal').hide();
        $('.ul_modal_body').hide();
        $('.alert_err').show();
        $('.alert_err_body p').text("no file uploaded");
        $('.alert_err_body h3').text("Prducts Upload");
        setTimeout(function(){
            $('.alert_err').css("display","none");
            $("#pr_table").load(location.href +" #pr_table");
        },2000);
    }



});

$(document).ready(function(){
    var cm = $('#cm_prods').attr('data');

       $("#cm_prods").on("change",function(){
        alert(cm);
       });
});

// Orders Page
$(document).ready(function(){
    $('.products').select2();

    $(".or_next").on("click",function(){
        $(".or_p1").toggle();
        $(".or_p2").toggle();

        var cm_id = $("#company option:selected").val();

        $.ajax({
            url: "/get-productList",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            method: 'post',
            data: {"cm_id":cm_id},
            success: function (result) {
                if(result.status == 1){
                    $.each(result.products, function(index,val){
                        var pr_id = val.id;
                        var pr_code = val.product_code;
                        var pr_name = val.product_name;

                        $("#products").append(
                            "<option value="+ pr_id +">"+pr_code+"-"+pr_name+"</option>"
                        );
                    });
                }

            }, error: function (request, status, error) {
                alert(request.responseText);
        }
        });
    });

    $(".or_back").on("click",function(){
        $(".or_p1").toggle();
        $(".or_p2").toggle();
    });

    $(".add_pr").on("click",function(){
        var pr_id = $("#products option:selected").val();
        var pr_qty =$("#pr_qty").val();
        if(pr_id != null){
            if(pr_qty != "")
                $.ajax({
                    url: "/get-product",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    method: 'post',
                    data: {"pr_id":pr_id},
                    success: function (result) {
                        if(result.status == 1){
                            var pr = result.product;
                            // alert(JSON.stringify(pr[0].product_code));
                            $(".or_tbl_body").append(
                                "<tr>"+
                                "<td class='whitespace-nowrap py-4 pl-4 text-sm text-gray-500'>"+pr[0].product_code+"</td>"+
                                "<td class='whitespace-nowrap px-3 py-4 text-sm text-gray-500'>"+pr[0].product_name+"</td>"+
                                "<td class='whitespace-nowrap px-3 py-4 text-sm text-gray-500'>"+pr_qty+"</td>"+
                                "<td class='whitespace-nowrap px-3 py-4 text-sm text-gray-500'>"+
                                "<button type='button' class='rm_pr'>"+
                                    "<svg xmlns='http://www.w3.org/2000/svg' class='h-6 w-6' fill='none' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2'>"+
                                        "<path stroke-linecap='round' stroke-linejoin='round' d='M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16' />"+
                                    "</svg>"+
                                "</button>"+
                                "</td>"+
                                "</tr>"
                            );
                        }

                    },
                });
            else{
                alert("Please Enter Quantity");
            }
        }else{
            alert("invalid Product");
        }
    });

    $(".or_next2").on("click",function(){
        var cm_id = $("#company option:selected").val();
        var or_typ = $("#OrderType option:selected").val();

        var prdata = [];
        $(".or_tbl_body tr").each(function () {
            var rows = $(this);

            var a = rows.find("td:eq(0)").text();
            var b = rows.find("td:eq(1)").text();
            var c = rows.find("td:eq(2)").text();

            var obj = {};
            obj.col1 = a;
            obj.col2 = b;
            obj.col3 = c;

            prdata.push(obj);
        });
        // alert(JSON.stringify(prdata));
        if(prdata.length > 0){
            $.ajax({
                url: "/save-order",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: {"cm_id":cm_id,"or_typ":or_typ,"pr_data":prdata},
                success: function (result) {
                    // console.log(result);
                    if(result.status == 0){
                        $('.alert_err').show();
                        $('.alert_err_body p').text(result.message);
                        $('.alert_err_body h3').text("Orders");
                        setTimeout(function(){
                            $('.alert_err').css("display","none");
                            window.location.href = "/orders";
                        },2000);
                    }else{
                        $('.alert_suc').show();
                        $('.alert_suc_body p').text(result.message);
                        $('.alert_suc_body h3').text("Prducts Upload");
                        setTimeout(function(){
                            $('.alert_suc').css("display","none");
                            window.location.href = "/orders";
                        },2000);
                    }
                }
                // ,error: function (request, status, error) {
                //     alert(request.responseText);
                // }
            });
        }else{
            alert('add products first');
        }

    });
});

$(document).on("click",".rm_pr",function(){
    $(this).closest("tr").remove();
});

$(document).ready(function(){
    $("#pr_tbl").ready(function(){
        var cust = $("#company").val();
        getOrder(cust);
    });
    $(document).on("change","#company",function(){
        var cust = $(this).val();
        $("#pr_tbl").load(location.href +" #pr_tbl");
        getOrder(cust);
    });

    function getOrder(order){
        var cust = order;
        $.ajax({
            url: "/get-company-order",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            method: 'post',
            data: {'comp_id':cust},
            success: function (result) {
                // console.log(result);
                if(result.status == "1"){
                    setTimeout(function(){
                        $.each(result.message,function(index,val){
                            var prod = "<tr>"
                                        +"<td class='py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6'>"+val.order_id+"</td>"
                                        +"<td class='px-3 py-4 text-sm text-gray-500 whitespace-nowrap'>"+val.or_typ+"</td>"
                                        +"<td class='px-3 py-4 text-sm text-gray-500 whitespace-nowrap'>"
                                        +"<div class='pr-pc grid grid-rows'>";
                                            $.each(val.products,function(i,p){
                                                prod += "<span class='w-full px-2 py-1'>"+p.products.product_code+"</span>"
                                            });

                                prod += "</div>"
                                        +"</td>"
                                        +"<td class='px-3 py-4 text-sm text-gray-500 whitespace-nowrap'>"
                                            +"<div class='pr-pn grid grid-rows'>";
                                            $.each(val.products,function(i,p){
                                                prod += "<span class='w-full px-2 py-1'>"+p.products.product_name+"</span>"
                                            });
                                prod += "</div>"
                                        +"</td>"
                                        +"<td class='px-3 py-4 text-sm text-gray-500 whitespace-nowrap'>"
                                            +"<div class='pr-qty grid grid-rows'>";
                                            $.each(val.products,function(i,p){
                                                prod += "<span class='w-full px-2 py-1'>"+p.qty+"</span>"
                                            });
                                prod += "</div>"
                                        +"</td>"
                                        +"<td class='px-3 py-4 text-sm text-gray-500 whitespace-nowrap'>0</td>"
                                        +"<td class='px-3 py-4 text-sm text-gray-500 whitespace-nowrap'>"+val.dispatch+"</td>"
                                        +"<td class='px-3 py-4 text-sm text-gray-500 whitespace-nowrap'>Place Status Here</td>"
                                        +"<td class='px-3 py-4 text-sm text-gray-500 whitespace-nowrap'>"
                                        +"<button type='button' class='edit_orders' data-val="+val.order_id+">"
                                            +"<svg xmlns='http://www.w3.org/2000/svg' class='w-6 h-6' fill='none' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2'>"
                                                +"<path stroke-linecap='round' stroke-linejoin='round' d='M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z' />"
                                            +"</svg>"
                                        +"</button>"
                                        +"</td>"
                                +"</tr>";

                                $(".pr_tbl_body").append(prod);
                        });
                    },500);
                }else{
                    setTimeout(function(){
                        var prod = "<tr>"
                            +"<td colspan='8' class='py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6'>"
                            +"<span class='w-full flex items-center text-md'>"+result.message+"</span>"
                            +"</td>"
                            +"</tr>";
                        $(".pr_tbl_body").append(prod);
                    },500);
                }
            }, error: function (request, status, error) {
                alert(request.responseText);
            }

        });
    }
});

// End of Orders Page
