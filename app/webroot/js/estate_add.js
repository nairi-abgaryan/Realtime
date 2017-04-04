$(document).ready(function () {
    $(".con_person").on("change", function () {     // select username in search page 
        var team_user = $(this).val();
        var add_id = $(this).attr("data");
      
        $(".team_ok").on("click", function () {
            team_product(team_user, add_id);
            $(this).css({"pointer-events":"none"});
            $(".con_person").css({"pointer-events":"none"});
        });
        $(".delete_ok").on("click",function(){
            location.reload();
        });
       
    });
      $(".delete_ok").on("click",function(){
            location.reload();
        });
    $(".team_ok").on("click", function () {
            
            var add_ids = $(this).attr("data-bind");
            var add_id = $(this).attr("data");
            
            var team_user = $("#con_person"+add_id+"").val();
       
            if(team_user != null){
                team_product(team_user, add_ids);
                $(this).css({"pointer-events":"none"});
                $(".con_person").css({"pointer-events":"none"});
            }else{
                alert("Նշեք անունը");
                return;
            }
        });
    var prod_count = 1;
    var object = {
        div: function (obj) {


            var div = "<div id='dataRows' class='all_item'>\n\
                        <div class='fieldRow' id='template'>\n\
                                       <select class='prod_names' data='' style='width:100px;font-size:14px;font-weight:bold' id='names'>\n\
                                                        <option selected='false' value style='display:none;width:100px' disabled='disabled'>Նշեք</option>";
            $(".close").remove();
            var close = "<div  class='close'><button style='margin:0px auto;'>ավարտել</button></div><div class='end_creat'></div>";
            var count = "<input type='number' style='width:60px;font-size:14px;font-weight:bold' class='prod_count' value='' id='prod_count'>\n\
                <button class='add_new'style='color: #fff;border: 1px solid green; background: #848484'  id='add_new'>+</button>\n\
                <button class='button remove' style='color: #fff;border: none; background: red' id='btnDel'  style='color:red'>x</button>";
            var array = [];
            var add;
            var search;
            if(obj != {}){
              
                $.each(obj, function (key, value) {
                    search = array.indexOf(value.product_name.product_name);
                    if (search === -1 && value.written_item.quantity != 0 && value.product_name.product_name != null) {
                        
                        add = array.push(value.product_name.product_name);
                        div += "<option  value='" + value.product_name.id + "'>" + value.product_name.product_name + "</option>";
                    }

                });
            }else{
                 div += "<option></option>";
            }
            div += "</select><span class='space_add' id='space_add' data=''></span>";

            count += "</div>";
            array = [];
            
            return div + count + close;
        }
    };

    function team_product(team_user, add_id) {    //in team product 

        if (team_user) {
                         
            $.post('estate', {'team': team_user}, function (data) {
                if (data) {
                    var obj = jQuery.parseJSON(data);

                    var div = object.div(obj);
                    
                    $("#table_Prod" + add_id + "").html(div);
                 
                    var span;
                    $(".prod_names").on("change", function () {
                        span = $(this).attr("data");
                      
                        var space_select = "<select class='prod_spaces'  style='width:120px;font-size:14px;font-weight:bold' id='prod_spaces" + span + "' data='" + span + "'>";
                        var name_prod = $(this).val();
                         
                        $.each(obj, function (key, value) {
                            if (value.written_item.product_id === name_prod)
                                    space_select += "<option >" + value.written_item.species + "</option>";
                        });
                        space_select += "</select>";
                        $("#space_add" + span + "").html(space_select);
                    });
                    var template = jQuery("#template"),
                            dataRows = jQuery("#dataRows");

                    jQuery(".add_new").on("click", function () {
                        var lengt = $(".fieldRow .prod_names").last().attr("data");
                      
                        var newRow = template.clone(true, true),
                            fieldRows = dataRows.find(".fieldRow");
                            console.log(newRow);
                           
                        newRow.attr('id', 'data', 'row' + (lengt + 1)).find('[id]', '[data]').each(function () {
                            jQuery(this).attr("id", jQuery(this).attr("id") + (lengt + 1));
                            jQuery(this).attr("data", jQuery(this).attr("data") + (lengt + 1));
                           
                        });
                        fieldRows.filter(":last").after(newRow);
                       
                        $("#prod_count"+(lengt+1)+"").val(' ');
                        $("#prod_spaces"+(lengt+1)+"").remove();
                    });
                    dataRows.on("click", ".remove", function () {
                        jQuery(this).parent().remove();
                    });
                    $(".close").on("click", function () {
                        var prod_count = $(".space_add").last().attr("data");
                        var variable_change = 1;
                        var prod_names = [];
                        var prod_counts = [];
                        var prod_spacieses = [];
                        var prod_all = [];
                        if (prod_count == '') {
                            prod_count = 1;
                        }
                        var obj_count = 0;
                        var length = $(".fieldRow").length;
                        var prod_count = $(".prod_names").last().attr("data");
                         prod_count=prod_count.replace(/[^0-9]/g,"").length;
                        
                        for (var i=0; parseInt(i) <= prod_count; i++) {
                           var c='1';
                            for(var j=1;j<i;j++){
                               c+='1';
                            }
                            if (i !== 1 && $("#names" + c + "").val()) {
                                prod_all["names" + i + ""] = $("#names" + c + "").val();
                                prod_all["counts" + i + ""] = $("#prod_count" + c + "").val();
                                prod_all["species" + i + ""] = $("#prod_spaces" + c + "").val();

                            } else if($("#names").val()){
                                prod_all["names" + i + ""] = $("#names").val();
                                prod_all["counts" + i + ""] = $("#prod_count").val();
                                prod_all["species" + i + ""] = $("#prod_spaces").val();
                            }
                            
                        
                            if (prod_all["counts" + i + ""] > 0) {
                               
                                $.each(obj, function (key, value) {
                                    
                                 if (value.written_item.product_id == prod_all["names" + i + ""] 
                                            && value.written_item.species == prod_all["species" + i + ""] 
                                            && parseInt(value.written_item.quantity) < parseInt(prod_all["counts" + i + ""])) {
                                        if (i === 1) {
                                            $("#prod_count").val(0).css({"border": "1px solid red"});
                                            prod_all["counts" + i + ""] = 0;
                                            variable_change = 0;

                                        } else {
                                            $("#prod_count" + c + "").val(0).css({"border": "1px solid red"});
                                            prod_all["counts" + i + ""] = 0;
                                            variable_change = 0;
                                        }
                                         
                                    } else if (value.written_item.product_id == prod_all["names" + i + ""] 
                                            && value.written_item.species.trim() == prod_all["species" + i + ""].trim() 
                                            && parseInt(value.written_item.quantity) >= parseInt(prod_all["counts" + i + ""])) {
                                    
                                        prod_all["count_prod" + i + ""] = parseFloat(value.written_item.quantity) - parseFloat(prod_all["counts" + i + ""]);
                                       var check = prod_names.indexOf(prod_all["names" + i + ""] + "/" + prod_all["species" + i + ""] + ":" + prod_all["counts" + i + ""] + ";" + prod_all["count_prod" + i + ""] + "|" + value.written_item.id);
                                       console.log(prod_all["names" + i + ""] + "/" + prod_all["species" + i + ""] + ":" + prod_all["counts" + i + ""] + ";" + prod_all["count_prod" + i + ""] + "|" + value.written_item.id);
                                        if(check == -1){
                                            prod_names[i] = prod_all["names" + i + ""] + "/" + prod_all["species" + i + ""] + ":" + prod_all["counts" + i + ""] + ";" + prod_all["count_prod" + i + ""] + "|" + value.written_item.id;
                                         }
                                    } else {
                                       
                                    }


                                });

                            } else {
                               
                            }
                            

                            
                        }
                        
                     
                        if (variable_change === 1) {
                            var height = $(window).height();
                            var body_height = $("body").height();
                            if (height > body_height) {

                            } else {
                                height = body_height;
                            }

                            var name_prod = $("#name_prod").val();
                            var space_name = $("#space_name").val();
                              
                               
                            $.post("estate", {"prod_all": prod_names, "add_id": add_id, "team_user": team_user}, function (data) {
                                                        console.log(data);
                                if (data) {
                                   location.reload();
                                }
                            });
                        } else {

                        }


                    });
                }else{
                    var obj = {};
                    var div = object.div(obj);
                }
            });

        }
    }
    $(".quentitys").on("keypress", function (event) {
        if (event.which !== 8 && isNaN(String.fromCharCode(event.which))) {
            event.preventDefault();
        }
    });
    $(".add_property").on("click", function (event) {

        var product = [];
        product["3"] = $(this).attr("data");
        product["4"] = $("#con_person" + product["3"] + "").val();
        product["0"] = $("#quantity" + product["3"] + "").val();
        product["1"] = $("#prod_s" + product["3"] + "").val();
        product["2"] = $("#prod_name" + product["3"] + "").val();

        var prod_name = product["2"];
        var species = product["1"];
        var team_user = product["4"];
        var quantity = product["0"];
        var output = '<div>';

        if (product) {

            $.post('technical_data', {'l': product}, function (data) {
               
                output += "<span>" + prod_name + "</span> <span style='margin-left:50px;'>" + quantity + " </span> " + team_user + " " + "<br>";
                $(".read_property").html(output);
                
                if (data) {
                    $(this).click();
                }
            });

        }

    });
});