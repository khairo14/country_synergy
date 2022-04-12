const { data } = require('jquery');
const { message } = require('laravel-mix/src/Log');

require('./bootstrap');
require('./components');

// start of scan page
$(document).on("click",".scan",function(){
    window.location.href=('/scan');
});

$(document).ready(function(){
    $('.scan_products').change(function(){
        var pr_label = $('.scan_products').val();
        var pr_count = $(".product_tbl tr").length;

        var row_data1 = [];
        $(".product_tbl tr").each(function(){
            var data1 = $(this).find('td').eq(1).text();
            row_data1.push(data1);
        });

        if(pr_label == " "){
            $(".message1").text("'Please Scan again'");
            $(".scan_products").val("");
            $(".scan_products").focus();
            $(".scan_products").attr("placeholder","Scan code");
        }else if(pr_count >= 21){
            $(".message1").text("'Pallete limit already exceed'");
            $(".scan_products").val("");
            $(".scan_products").focus();
            $(".scan_products").attr("placeholder","Scan code");
        }else if($.inArray(pr_label,row_data1) != -1){
            $(".message1").text("Product Already Scanned");
            $(".scan_products").val("");
            $(".scan_products").focus();
            $(".scan_products").attr("placeholder","Scan code");
        }else{
            $.ajax({
                url: "/checkStocks",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: { "pr_label": pr_label},
                success: function (result) {
                    // alert(JSON.stringify(result));
                    if(result === 'false'){
                        $(".message1").text("'Product Already exist check records'");
                    }else{
                        $(".product_tbl").append(
                            "<tr class='table-row'>"
                            +"<td class='table-cell text-center text-sm border border-slate-600 w-auto'>"+pr_count+"</td>"
                            +"<td class='table-cell text-center text-sm border border-slate-600 w-auto'>"+pr_label+"</td>"
                            +"</tr>"
                        );
                    }
                },

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
    $('.next_scan').on("click",function(e){
        e.preventDefault();
        $(".product_card").hide();
        $(".pallete_card").show();

        $(".scan_pallete").val("");
        $(".scan_pallete").focus();
        $(".scan_pallete").attr("placeholder","Scan pallete code");
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
                console.log(result.message);
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
