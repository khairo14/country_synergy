require('./bootstrap');
require('./components');

// start of scan page
$(document).on("click",".stockIn",function(){
    window.location.href=('/home/scan');
});

$(document).ready(function(){
    $("#scan_pcode").change(function(){
        var row_data1 = [];
        $("#scnproducts_body tr").each(function(){
            var data1 = $(this).find('td').eq(0).text();
            row_data1.push(data1);
        });

        if($(this).val() == " "){
          $(".scan_pcode_message").text('Please Scan Product');
          setTimeout(function(){
            $(".scan_pcode_message").text('');
          },2000);

        }else if($.inArray($(this).val(),row_data1) != -1){
            $(".scan_pcode_message").text('Product Already Scanned');
            setTimeout(function(){
              $(".scan_pcode_message").text('');
              $("#scan_pcode").val('');
              $("#scan_pcode").focus();
            },2000);
        }else{
            var label = $("#scan_pcode").val();
            var cust1 = $("#exist_cust1 option:selected").val();

           $.ajax({
            url: "/home/scan/check-product",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            method: 'post',
            data: { "label": label,'cust':cust1},
            success: function (result) {
                // console.log(result);
                if(result.status == 1){
                    var gtin = result.message[0].gtin;
                    var pname = result.message[0].product_name;
                    var plu = result.message[0].product_code;
                    var prod = "<tr>"
                            +"<td class='py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6'>"
                            +"<p class='w-12 truncate overflow-clip'>"+label+"</p>"
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
                }else if(result.status == 2){

                }else{
                    $(".scan_pcode_message").text(result.message);
                    setTimeout(function(){
                        $(".scan_pcode_message").text('');
                        $("#scan_pcode").val('');
                        $("#scan_pcode").focus();
                      },2000);
                }
            }, error: function (request, status, error) {
                alert(request.responseText);
            }

           });
        }



    });
});

$(document).ready(function(){
    $(".rm_prod").on("click",function(){
        $(this).closest("tr").remove();
    });
});

$(document).ready(function(){
    $(".gen_label").on("click",function(){
        var prod_count = $(".scnproducts tr").length;

        // alert(prod_count);
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
            var old_pallet = $("#scan_oldplabel").val();
            var cust = $("#exist_cust1 option:selected").val();

            var prod_data = [];
            $("#scnproducts_body tr").each(function(){
                var data1 = $(this).find('td').eq(0).text();
                var data2 = $(this).find('td').eq(1).text();

                var item = {};
                item.label = data1;
                item.gtin = data2;

                prod_data.push(item);
            });

            $.ajax({
                url: "/home/scan/scan-products",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: { "old_pallet": old_pallet, 'customer':cust, 'products':prod_data},
                success: function (result) {
                    // console.log(result);
                    if(result.status == 0){
                        $(".scan_pcode_message").text(result.message);
                        $("#labelModal").toggle();
                        $("#labelModal_body").toggle();
                        setTimeout(function(){
                            $("#scan_pcode").val('');
                            $("#scan_pcode").focus();
                            $(".scan_pcode_message").text('');
                          },2000);
                    }else{
                        // alert('sed')
                        // console.log(result.message);
                        $("#labelModal").toggle();
                        $("#labelModal_body").toggle();
                        $("#scnproducts").toggle();
                        $("#prod_printLabel").toggle();
                        $("#pallet_id").val(result.message.pallet_id);
                        $("#qty").val(result.message.qty);
                        // $("#").text(result.message.date);
                        $("#gtin").val(result.message.gtin);
                    }
                }, error: function (request, status, error) {
                    alert(request.responseText);
                }
            });

            // console.log(prod_data);

        }
    });
});

$(document).ready(function(){
    $(".assign").on("click",function(){
        var loc = $("#scan_location").val();
        var pallet_id = $("#pallet_id").val();
        var qty = $("#qty").val();
        var gtin = $("#gtin").val();
        var old_pallet = $("#scan_oldplabel").val();

        // alert(qty);
        if(loc == " "){
            $(".scan_location_message").text('Please Scan Product');
            setTimeout(function(){
              $("#scan_location").focus();
              $(".scan_location_message").text('');
            },2000);
        }else{
            $.ajax({
                url: "/home/scan/assign-location",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: { "old_pallet": old_pallet, 'new_pallet_id':pallet_id, 'qty':qty, 'location':loc,'gtin':gtin},
                success: function (result) {
                    console.log(result);
                    if(result.status ==1){
                        $(".scan_location_message").text('Please Scan Product');
                        setTimeout(function(){
                            $("#scan_location").focus();
                            $(".scan_location_message").text('');
                            window.location.href="/home/scan";
                        },2000);
                    }
                }, error: function (request, status, error) {
                    alert(request.responseText);
                }
            });
        }
    });
});
// end of scan page
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

