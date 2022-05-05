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
        $("#tbl_cont2").load(location.href +" #product_tbl");

        var pr_label = $('.scan_products').val();
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
                    if(result.status == 0){
                        $(".message1").text(JSON.stringify(result.message.message));
                        $(".message1").addClass("bg-red-500");
                        getStocks(or);
                        setTimeout(function(){
                            $(".message1").text("");
                            $(".message1").removeClass("bg-red-500");
                        },3000);
                    }else{
                        var pr = result.message;
                        $.each(pr,function(i,val){
                            var scan =
                            "<tr>"
                            +"<td class='py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-gray-700 uppercase sm:pl-6'>"+val.plu+"</td>"
                            +"<td class='px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase'>"+val.PRname+"</td>"
                            +"<td class='px-3 py-3 text-sm font-bold tracking-wide text-center text-gray-500 uppercase'>"+val.PKcount+"</td>"
                            +"<td class='px-3 py-3 text-sm font-bold tracking-wide text-center text-gray-500 uppercase'>"+val.OrCount+"</td>"
                            +"<td class='px-3 py-3 text-sm font-bold bg-green-300 tracking-wide text-center text-black uppercase'>"+val.remaining+"</td>"
                            +"</tr>";
                        $(".product_tbl").append(scan);

                        });

                    }
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
    $('.scan_bin').change(function(){
        var bin_label = $('.scan_bin').val();
        var or_id = $(".order_id").val();

        var bin_count = $(".bin_tbl tr").length;

        var row_data3 = [];
        $(".bin_tbl tr").each(function(){
            var data3 = $(this).find('td').eq(0).text();
            row_data3.push(data3);
        });

        if(bin_label == " "){
            $(".message3").text("Please Scan Again");
            $(".message3").addClass("bg-red-500");
            $(".scan_bin").val("");
            $(".scan_bin").focus();
            $(".scan_bin").attr("placeholder","Enter location");
            setTimeout(function(){
                $(".message3").text("");
                $(".message3").removeClass("bg-red-500");
            },3000);
        }else if(bin_count >= 2){
            $(".message3").text("1 Location at a time");
            $(".message3").addClass("bg-red-500");
            $(".scan_bin").val("");
            $(".scan_bin").focus();
            $(".scan_bin").attr("placeholder","Enter Location");
            setTimeout(function(){
                $(".message3").text("");
                $(".message3").removeClass("bg-red-500");
            },3000);
        }else if($.inArray(bin_label,row_data3) != -1){
            $(".message3").text("Location already Set");
            $(".message3").addClass("bg-red-500");
            $(".scan_bin").val("");
            $(".scan_bin").focus();
            $(".scan_bin").attr("placeholder","Enter Location");
            setTimeout(function(){
                $(".message3").text("");
                $(".message3").removeClass("bg-red-500");
            },3000);
        }else{
            $.ajax({
                url: "/checkBin",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: { "bin_label": bin_label,'or_id':or_id},
                success: function (result) {
                    if(result.status == 1){
                        getBin(or_id);
                    }else{
                        $(".message3").text(result.message);
                        $(".message3").addClass("bg-red-500");
                        setTimeout(function(){
                            $(".message3").text("");
                            $(".message3").removeClass("bg-red-500");
                        },3000);
                    }

                }, error: function (request, status, error) {
                    alert(request.responseText);
                }
            });

            $(".scan_bin").val("");
            $(".scan_bin").focus();
            $(".scan_bin").attr("placeholder","Scan Bin Code");
        }
    });
});

function getStocks(or_id){
    $.ajax({
        url: "/getStocks/"+or_id,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        method: 'get',
        data: {'or_id':or_id},
        success: function(result){
            if(result != ""){
                var pr = result;
                $.each(pr,function(i,val){
                    var intRem = parseInt(val.remaining);
                    var scan =
                        "<tr>"
                        +"<td class='py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-gray-700 uppercase sm:pl-6'>"+val.plu+"</td>"
                        +"<td class='px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase'>"+val.PRname+"</td>"
                        +"<td class='px-3 py-3 text-sm font-bold tracking-wide text-center text-gray-500 uppercase'>"+val.PKcount+"</td>"
                        +"<td class='px-3 py-3 text-sm font-bold tracking-wide text-center text-gray-500 uppercase'>"+val.OrCount+"</td>";

                    if(intRem <= 0){
                        scan +="<td class='px-3 py-3 text-sm font-bold bg-red-300 tracking-wide text-center text-black uppercase'>0</td>";
                    }else{
                        scan +="<td class='px-3 py-3 text-sm font-bold bg-green-300 tracking-wide text-center text-black uppercase'>"+val.remaining+"</td>";
                    }
                    scan +="</tr>";
                $(".product_tbl").append(scan);

                });
            }
        }, error: function (request, status, error) {
            alert(request.responseText);
        }
    });
}

function getBin(or_id){
    $.ajax({
        url: "/getBin/"+or_id,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        method: 'get',
        data: { "or_id": or_id},
        success: function (result) {
            if(result.bin_id != 0){
                    var bin =
                    "<tr>"
                    +"<td class='py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-gray-700 uppercase sm:pl-6'>"+result.location+"</td>"
                    +"<td class='px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase'>"
                        +"<button type='button' class='inline-flex items-center px-3 py-2 border border-transparent shadow-sm text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500'"
                        +"id="+result.bin_id+">Change Location"
                        +"</button>"
                    +"</td></tr>";

                    $(".bin_tbl_body").append(bin);
            }

        }, error: function (request, status, error) {
            alert(request.responseText);
        }
    });
}

function getType(or_id){
    $.ajax({
        url: "/orderType/"+or_id,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        method: 'get',
        data: { "or_id": or_id},
        success: function (result) {
            if(result === "In"){
                $(".next1_scan").addClass('inline-flex');
                $(".complete_scan").removeClass('inline-flex');
            }else if(result === "Out"){
                $(".next1_scan").removeClass('inline-flex');
                $(".complete_scan").addClass('inline-flex');
            }else{
                $(".message1").text("Error");
                $(".message1").addClass("bg-red-500");
                $(".scan_products").val("");
                $(".scan_products").focus();
                $(".scan_products").attr("placeholder","Scan code");
            }
        }, error: function (request, status, error) {
            alert(request.responseText);
        }
    });
}

$(document).ready(function(){
    $('.next0_scan').on("click",function(e){
        e.preventDefault();

        $("#tbl_cont2").load(location.href +" #product_tbl");
        var or_id = $(".order_id").val();

        if(or_id != ""){
            $(".order_card").hide();
            $(".product_card").show();
            $(".scan_products").focus();
            $(".scan_products").attr("placeholder","Scan code");
            getStocks(or_id);
            getType(or_id);
        }

    });
    $('.next1_scan').on("click",function(e){
        e.preventDefault();
        $("#tbl_cont3").load(location.href +" #bin_tbl");
        var or_id = $(".order_id").val();

        $(".product_card").hide();
        $(".bin_card").show();

        $(".scan_bin").val("");
        $(".scan_bin").focus();
        $(".scan_bin").attr("placeholder","Scan Bin Code");
        setTimeout(function(){
            getBin(or_id);
        },500);
    });

    $(".prev_scan").on("click",function(e){
        e.preventDefault();

        $(".product_card").hide();
        $(".order_card").show();

        $("#order_id").focus();
        $("#order_id").attr("placeholder","Enter Order Number");

    });

    $(".prev1_scan").on("click",function(e){
        e.preventDefault();
        $("#tbl_cont2").load(location.href +" #product_tbl");

        setTimeout(function(){
            var or_id = $(".order_id").val();
            getStocks(or_id);
        },1000);

        $(".product_card").show();
        $(".bin_card").hide();

        $(".scan_products").val("");
        $(".scan_products").focus();
        $(".scan_products").attr("placeholder","Scan code");
    });

    $(".complete_scan").on("click",function(){
        window.location.reload();
    });
    $(".complete1_scan").on("click",function(){
        window.location.reload();
    });
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
// stocks page
$("stcks_tbl").ready(function(){
    // $.ajax({

    // });
});

function allStocks(){

};
// end of stocks page
