$(document).ready(function () {
    $("#show_1").on("click", function () {

        var height = $(window).height();
        var body_height = $("body").height();
        if (height > body_height) {

        } else {
            height = body_height;
        }

        $(".add_person").css({"display": "block"});
        $(".opacity").css({"display": "block"});
        $(".opacity").css({"width": "100%", "height": "" + height + "", "z-index": "1", "opacity": "0.7", "background": "black", "position": "absolute", "left": "0px", "right": "0px", "top": "0px"});
        $(".add_person").css({"background": "#fff", "position": "fixed", "z-index": "9999", "margin-top": "50px;"});
        $(".close_ar").on("click", function () {
            none($(".add_person"));
        });
    });
    function save(atr) {
        if (window.localStorage) { // Выполнить
            localStorage.atr = atr;
            localStorage.menu = "Աշխատակազմ";
        }
    }

    function none(x) {
        $(".opacity").css({"height": "0px", "width": "0px"});
        $(".mypage *").removeAttr("disabled");
        x.css({"display": "none"});
    }
    $(".add_role").on("click", function () {
        var output = "<input name='add_role' class='add_i' tipe='text'>";
        $(".view_role").html(output);
    });
    $(".delete_role").on("click", function () {
        var txt;
        var r = confirm("դուք ցանկանումեք ջնջել տվյալ պաշտոնը?");
        if (r === true) {
            var id = $(this).val();
            var data = $(this).attr('data');
            $.post('team', {'delete_role': id, 'data': data}, function (data) {

                if (data === 1) {
                    alert("stop!!!!!!!!");
                    location.reload();
                    return false;
                } else {
                    location.reload();
                    return false;
                }
            });
        } else {
            txt = "You pressed Cancel!";
        }
    });
    $(".edit_role").on("click", function () {
        $(".changed_r").remove();
        var id = $(this).val();
        var value = $("#" + id + "role").text();

        //alert(value);
        var output = "<div class='changed_r'style='width:150px;position: absolue;height: 23px;'>\n\
                        <input class='change_role' style='float:left;width:90px;border:1px solid black;' value='" + value + "' tipe='text'>\n\
                        <button  style='height=21px;border:none;background:red;color:#fff;float:left'class='save_change_role'>save</button></div>";
        $("#" + id + "role").append(output);
        $(".save_change_role").on("click", function () {
            var change_elemet = $(".change_role").val();
            $.post('team', {'id': id, 'change_elemet': change_elemet}, function (data) {
                location.reload();
                return false;
            });
        });
    });


    var change;
    var array = [];
    $(".target").on("click", function (e) {
        var value = $(this).text();
        var id = $(this).attr("id");
        var atr = id;
        save(atr);
        view_team(value);
    });
    function view_more(username, obj, id) {
        var array = [];
        var array_prod = [];
        $(".view_more").html(" ");
        var table_more = "";
        
        $.each(obj, function (key, value) {
            $.each(value, function (key, value) {
                if (value.id == id) {
                    table_more += "<td  colspan='6'><div class='append_team' id=" + value.username + "><div class='user_edit'>\n\
                                                                <div class='img'><img src='../img/" + value.image_name + "'/></div>\n\
                                                                <div class='username'>" + value.username + "</div>\n\
                                                                <div class='telefon1'>" + value.telefon1 + "</div>\n\
                                                                <div class='telefon2'>" + value.telefon2 + "</div>\n\
                                                                <div class='email'>" + value.email + "</div>\n\
                                                                <div class='adress' style='width:160px;word-wrap:break-word'>" + value.adress + "</div>\n\
                                    </div><span class='categories' id='categories" + value.username + "'></span>\n\
                                    <div class='appends' id='" + value.username + "s'></div></div></td>";
                }
            });
        });

        $("#view_more" + id + "").html(table_more);

//             
        var category = "<div class='category_prod'><select class='prod_select'>\n\\n\
                                    <option value='0'>Ապրանքի տեսակը</option>\n\
                                    <option value='2'>ծախսանյութ</option>\n\
                                    <option value='1'>գործիքներ</option>\n\
                                    <option value='3'>տեխնիկա</option></select><select class='prod_name_select' disabled='disabled'><option >Ապրանքի անվանում</option></select><button >Դիտել</button><div class='select_prod'></div>\n\
                                    </div><button class='calendar_button' value='calendar'>calendar</button>";
        $("#categories" + username + "").html(category);
        $(".calendar_button").on("click",function(){
        
             $("#" + username + "s").html("<iframe width='1024px'height='800px' src='http://newop.realtime.am/manegements/calendar?id="+id+"'></iframe>");
        });
        $(".prod_select").on("change", function () {
          
            var category = $(this).val();
            if (category == 0) {
                $(".prod_name_select").attr({"disabled": "disabled'"})
                return;
            } else {
                $.post('team', {'all': username, "category": category}, function (data1) {
                 
                    var select_product_name = "";
                    var obj1 = jQuery.parseJSON(data1);
                    $.each(obj1, function (key, value) {
                        if (value.product_name.product_name) {

                            var f = array_prod.indexOf(value.product_name.product_name);
                            if (f === -1) {
                                array_prod.push(value.product_name.product_name);
                                select_product_name += "<option value='" + value.product_name.id + "'>" + value.product_name.product_name + "</option>";
                                change = 1;
                            } else {

                            }

                        }
                    });
                    array_prod = [];

                    select_product_name;
                    var val_select_prod = $(".prod_name_select").html(select_product_name);
                    $(".prod_name_select").removeAttr("disabled");
                    $(".category_prod button").on("click", function () {
                        var category = $(".category_prod select").val();
                       
                        if (category == 0) {
                            alert("Նշեք ապրանքի տեսակը");
                            return;
                        } else {
                            var prod_name = $(".prod_name_select").val();
                           
                            view_product(obj1,prod_name,username);
                        }
                    });
                });
                 
            }
        });
       

        return false;

    }
    function archive_team(user) {


        var r = confirm("Հեռացնում էք աշխատանքից?");
        if (r === true) {
            $.post('user', {"user": user}, function (data) {
                $("#show_team" + user + "").remove();
            });
        }

    }
    function edit_team(id, obj) {


        var height = $(window).height();
        var body_height = $("body").height();
        if (height > body_height) {

        } else {
            height = body_height;
        }

        $(".add_person").css({"display": "block"});
        $(".opacity").css({"display": "block"});
        $(".opacity").css({"width": "100%", "height": "" + height + "", "z-index": "1", "opacity": "0.7", "background": "black", "position": "absolute", "left": "0px", "right": "0px", "top": "0px"});
        $(".add_person").css({"background": "#fff", "position": "fixed", "z-index": "9999", "margin-top": "50px;"});
        $(".close_ar").on("click", function () {
            none($(".add_person"));
        });
        $.each(obj, function (key, value) {
            $.each(value, function (key, value) {
                if (value.id == id) {
                    $("#Person_C").remove();
                    $("#Teamvillage").css({"display": "none"});
                    $("#PersonAdress").css({"display": "none"});
                    $("#TeamAdresses").css({"display": "block"});
                    $(".street").css({"display": "none"});
                    $("#TeamId").val(value.id);
                    $("#TeamFirstname").val(value.firstname);
                    $("#TeamUsername").val(value.username);
                    $("#TeamAdresses").val(value.adress);
                    $("#data_birth").val(value.date);
                    $("#TeamLastname").val(value.lastname);
                    $("#TeamEmail").val(value.email);
                    $("#Teamsex").val(value.sex);
                    $("#Teamrole").val(value.role);
                    $("#Teamtel1").val(value.telefon1);
                    $("#Teamtel2").val(value.Teamtel2);
                }
            });
        });
        return false;

    }
    function view_team(value) {
        $.post('team', {'datas': value}, function (data) {

            var obj = jQuery.parseJSON(data);
            var output = "<div><table><thead><tr><td></td><td></td><td></td><td></td><td></td><td></td></tr></thead>";
            $.each(obj, function (key, value) {
                $.each(value, function (key, value) {
                    output += "\<tr class='show_team' id='show_team" + value.id + "'>\n\
                                        <td><div class='team_imges' style='width:100px;'><img src='../img/" + value.image_name + "'></div></td>\n\
                                        <td><div style='width:100px;'>" + value.firstname + "</div></td>\n\
                                        <td style='width:100px;'><div>" + value.lastname + "</div>\n\
                                        </td><td><div >" + value.telefon1 + "</div></td>\n\
                                        <td><div style='cursor:pointer'>\n\
                                            <button class='view_t' data=" + value.username + " alt=" + value.id + " style='cursor: pointer;border: none;border-radius: 4px; font-size: 15px;color: #fff;background: #52ac62;'>...</button></div></td>\n\
                                        <td style='width:100px;'><div ><button class='edit_t' data=" + value.id + " >խմբագրել</button>\n\
                                        </td>\n\
                                    </tr><tr class='view_more' id='view_more" + value.id + "'></tr>";

                });
            });

            output += "</table></div>";
            $(".view_team").html(output);

            $(".edit_t").on("click", function () {
                var id = $(this).attr("data");
                edit_team(id, obj);
            });
            $(".archive").on("click", function () {
                var user = $(this).attr('data');
                archive_team(user);
            });
            $(".view_t").on("click", function () {
                var username = $(this).attr("data");
                var id = $(this).attr("alt");
                view_more(username, obj, id);
            });
            return false;
        });
    }

    function change_prod_team(obj, username, category, change_prod) {

        var array_prod = [];
        var append = "<div class=view_prof> <table><thead><tr><td>ապրանքի անունը</td><td>տեսակը</td><td>քանակը</td><td>ելք</td></tr></thead>";
        $.each(obj, function (key, value) {

            if (value.written_item.username && value.product_name.product_name === change_prod) {
                append += "<tr class='edit_product'><td id='product_name" + value.written_item.id + "' data='" + value.product_name.id + "'><div>" + value.product_name.product_name + "</div></td>";
                append += "<td id='spacies" + value.written_item.id + "'><div>" + value.written_item.species + "</div></td>";
                append += "<td id='quantity1" + value.written_item.username + value.written_item.id + "'><div>" + value.written_item.quantity + "</div></td>";
                append += "<td ><button class='out'alt=" + value.written_item.username + " data=" + value.written_item.id + ">ելք</button></td></tr>";

                append += "<td  colspan='4'>\n\
                                        <div class='out_products'style='display:none;width:700px;' id='out_prod" + value.written_item.id + "'>\n\
                                                    <select class='select_out'>\n\
                                                            <option selected='false' value style='display:none;' disabled='disabled'>Նշեք</option>\n\
                                                            <option value='1'>անձնակազմ</option>\n\
                                                            <option value='2'>խոտան</option>\n\
                                                            <option value='3'>պահեստ</option>\n\
                                                    </select>\n\
                                                        <span class='select_team' id='select_team" + value.written_item.id + "'></span>\n\
                                                 <input type='text'min='0'max='" + value.written_item.quantity + "' id='quantity" + value.written_item.id + "' name='product_quantity' style='width:50px;'> \n\
                                                  <button id='min_prod" + value.written_item.id + "' data=" + value.written_item.id + ">հանել</button>\n\
                                        </div>  \n\
                                        </td>";
            }
        });
        append += "</table></div>";
        $("#" + username + "s").html(append);
        $(".out").on('click', function () {
            var id = $(this).attr("data");
            var username = $(this).attr("alt");
            team_prod_out(id, username);
            $(".out_products").css({"display": "none"});
            return false;
        });
    }
   function edit_cu(id){
         $(".count_edit").css({"display":"none"});
                $("#count_edit"+id+"").css({"display":"block"});
                $("#count_edit"+id+" button").on("click",function(){
                    var value = $("#count_edit"+id+" input").val();
                    
                    $.post("edit_countu",{"value":value,"id":id},function(data){
                       
                       $(".count_edit").css({"display":"none"});
                       $("#countprod"+id+"").html(data);
                       return;
                    });
                });
    }
    function view_product(obj, prod_name, username) {
        
        var username_a = $(".auth_user").text();
        var append = "<div class=view_prof> <table><thead><tr><td>ապրանքի անունը</td><td>տեսակը</td><td>քանակը</td><td>ելք</td></tr></thead>";
        $.each(obj, function (key, value) {
                
            if (value.written_item.username == username && value.written_item.product_id == prod_name) {
                if (username_a == 'Anush') {
                        var edit_button ="<button style='display:none' class='edit_countbt' data='"+value.written_item.id+"'><img src='/img/icon/edit.png' width='15px' ></button>";
                        var edit_count = "<div class='count_edit' style='display:none' id='count_edit"+value.written_item.id+"'>\n\
                                                <input type='number' value='" + value.written_item.quantity + "' \n\
                                                                   alt='" + value.written_item.id + "' class='count_an'>\n\
                                                <button><img src='/img/icon/save.png' width='20px' height='20px'></button></div>"
                    } else {
                        var edit_button = '';
                        var edit_count ='';
                }
                append += "<tr class='edit_product'><td id='product_name" + value.written_item.id + "' alt='" + value.product_name.category + "' data='" + value.product_name.id + "'><div>" + value.product_name.product_name + "</div></td>";
                append += "<td id='spacies" + value.written_item.id + "'><div>" + value.written_item.species + "</div></td>";
                append += "<td id='quantity1" + value.written_item.username + value.written_item.id + "'>"+edit_count+edit_button+"\n\
                                <div><span id='countprod"+value.written_item.id+"'>" + value.written_item.quantity + "</span></div></td>";
                append += "<td ><button class='out'alt=" + value.written_item.username + " data=" + value.written_item.id + ">ելք</button></td></tr>";

                append += "<tr class='show_o'><td  colspan='4'>\n\
                                        <div class='out_product' style='display:none;width:90%' id='out_prod" + value.written_item.id + "'>\n\
                                                    <select class='select_out' id='select_out"+value.written_item.id+"'>\n\
                                                            <option selected='false' value style='display:none;' disabled='disabled'>Նշեք</option>\n\
                                                            <option value='1'>անձնակազմ</option>\n\
                                                            <option value='2'>խոտան</option>\n\
                                                            <option value='3'>պահեստ</option>\n\
                                                    </select>\n\
                                                  <span class='select_team' id='select_team" + value.written_item.id + "'></span>\n\
                                                 <input type='text'min='0' max='" + value.written_item.quantity + "' id='quantity" + value.written_item.id + "' name='product_quantity' style='width:50px;'> \n\
                                                 <button id='min_prod" + value.written_item.id + "' data=" + value.written_item.id + ">հանել</button>\n\
                                        </div>  \n\
                                        </td></tr>";
            }
        });
        append += "</table></div>";
        $("#" + username + "s").html(append);
          $(".edit_countbt").on("click",function(){
                var id = $(this).attr("data");
                return edit_cu(id);
            });
        $(".out").on('click', function () {
              var id = $(this).attr("data");
            var username = $(this).attr("alt");
            $(".out_product").css({"display": "none"});
            $("#out_prod" + id + "").css({"display": "block"});
            $("#quantity" + id + "").on("keypress", function (event) {
                if (event.which !== 8 && isNaN(String.fromCharCode(event.which))) {
                    event.preventDefault();
                }
            });
          
            $(".select_out").on("change", function () {
                var value = $(this).val();

                if (value === '1') {
                    $.post('team', {'team': username}, function (data) {
                       
                        var obj = jQuery.parseJSON(data);
                        var select = "<select class='sel_team' id='team" + id + "'>";
                        $.each(obj, function (key, value) {
                            $.each(value, function (key, value) {
                                select += "<option value=" + value.username + ">" + value.username + "</option>";
                            });
                        });
                        select += "</select>";
                        $("#select_team" + id + "").html(select);
                    });
                } else {
                    $(".select_team").html("");
                }
            });
            $("#min_prod" + id + "").on("click", function () {   
                 var change_user = $("#team" + id + "").val();
                 var product_name = $("#product_name" + id + "").attr("data");
                 var category = $("#product_name" + id + "").attr("alt");
                 var spacies = $("#spacies" + id + "").text();
                 var quantity = $("#quantity" + id + "").val();
                 var values = $("#quantity1" + username + id + "").text();
                   var value = $("#select_out"+id+"").val();
                
                  team_prod_out(category,prod_name,change_user, quantity,values,spacies,username,id,value,product_name)
            });
           
            //

        });
    }

    function  team_prod_out(category,prod_name,change_user, quantity,values,spacies,username,id,value,product_name){



        

            if (change_user) {

            } else {
                change_user = "null";
            }
            if (parseInt(quantity) <= parseInt(values)) {
                $.post('team', {'category':category,'value': value, 'username': username, 'change_user': change_user, 'product_name': product_name, 'spacies': spacies, 'quantity': quantity}, function (data) {
                 $(".out_product").css({"display":"none"});
                     
                    var obj = $.parseJSON(data);
                  
                    view_product(obj, prod_name, username);
                });

            }
            else {
                return alert("աշխատողի մոտ չկա տվյալ քանակի ապրանք:");
            }
     

    }
    $("#Person_C").on("change", function () {

        var city_val = $("#Person_C").val();

        if (city_val === "Երևան") {
            $(".village").attr("disabled", "disabled").off('click');
            return false;
        }
        if (city_val !== null) {
            $(".village").attr("disabled", false);
        }
        $('.village').val("");
        $('.villagesearch').remove();

    });
    var k = 0;
    $('.village').on('keyup', function (event) {
        if (!name) {
            $(".village")[0].setCustomValidity("ընտրեք միայն գյուղերի ցանկից");
        }
        var count = 1;
        var found = 0;
        var searchField = $('.village').val();
        var myExp = new RegExp(searchField, "i");
        var output = "<div class='villagesearch'>";
        var city_val = $("#Person_C").val();
        if (searchField.length <= 2) {
            $('.villagesearch').remove();
        }
        if (searchField.length >= 3) {
            $.post('village', {'q': searchField, 'city_val': city_val}, function (data) {

                var obj = jQuery.parseJSON(data);
                $.each(obj, function (key, value) {
                    $.each(value, function (key, value) {
                        if (value) {
                            if (searchField === value.village_name) {
                                $('.village').attr('required', true);
                                $(".village")[0].setCustomValidity('');

                            }
                            if (value.village_name.search(myExp) !== -1 && count <= 5) {
                                found = 1;
                                output += "<div id=" + count + " class='results' data='" + value.village_name + "'style = 'cursor:pointer;display:block;'>" + value.village_name + "</div>";
                                count++;
                            }
                        }
                        else {
                            $('.villagesearch').remove();
                        }
                    });
                });
                if (found === 1) {
                    output += "</div>";
                    $('.villagesearchresult').removeClass('update-hidden');
                    $('.villagesearchresult').html(output);
                    var option = $('.results');
                    var name = option.click(function name() {
                        var validate = $('.village').val($(this).html());
                        $('.villagesearch').remove();
                        if (validate) {
                            $('.village').attr('required', true);
                            $(".village")[0].setCustomValidity('');
                        }
                        else {

                        }
                        if (!name) {
                            $(".village")[0].setCustomValidity("ընտրեք միայն գյուղերի ցանկից");
                        }
                    });
                    if (event.keyCode === 40) {

                        if (k === count - 1) {
                            k = count - 1;
                            $("#" + k + "").css({"background": "#01a0e2", "color": "#fff"});
                        } else {
                            k++;
                            $("#" + k + "").css({"background": "#01a0e2", "color": "#fff"});
                        }

                    }
                    if (event.keyCode === 38) {

                        if (k === 1) {
                            k = 1;
                            $("#" + k + "").css({"background": "#01a0e2", "color": "#fff"});
                        } else {
                            k--;
                            $("#" + k + "").css({"background": "#01a0e2", "color": "#fff"});
                        }
                    }
                    if (event.keyCode === 13) {
                        var c = $("#" + k + "").attr("data");

                        var validate = $('.village').val(c);
                        $('.villagesearch').remove();
                        if (validate) {
                            $('.village').attr('required', true);
                            $(".village")[0].setCustomValidity('');
                        }
                    }
                }
                else {
                    $('.villagesearch').remove();
                }
            });
            if (!name) {
                $(".village")[0].setCustomValidity("ընտրեք միայն գյուղերի ցանկից");
            }
        }
        else {
            $('.villagesearch').remove();
        }
    });
    $('.villagesearch').remove();
    var k = 0;


});