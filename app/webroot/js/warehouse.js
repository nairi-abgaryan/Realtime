$(document).ready(function () {
    var team_obj = null;
    var provider = null;
    window.pc = "";
    var product_category = null;
    call_provider();
    if (window.localStorage && localStorage.testObject && localStorage.provider){
         team_obj = localStorage.testObject;
         provider = localStorage.provider;
    }else{
        call_team();
        call_provider();
        return;
    }
 
    if (window.localStorage  && localStorage.product_category){
            product_category = localStorage.product_category;
    }else{
        call_categor_prod();
        return;
    }
    function call_team(){
        $.post("warehouse",{"team":"x"},function(data){
        
            team_obj = $.parseJSON(data);
            localStorage.setItem('testObject', JSON.stringify(team_obj));
            var retrievedObject = localStorage.getItem('testObject');
        });
     }
    function call_provider(){
         $.post("provider",{"provider_name":"x"},function(data){
            provider = $.parseJSON(data);
            
            localStorage.setItem('provider', JSON.stringify(provider));
            var retrievedObject = localStorage.getItem('provider');
        });
    }
    function call_categor_prod(){
         $.post("provider",{"product_category":"x"},function(data){
            provider = $.parseJSON(data);
            
            localStorage.setItem('product_category', JSON.stringify(provider));
            var retrievedObject = localStorage.getItem('product_category');
        });
    }
 
    provider = $.parseJSON(provider);
     
    product_category = $.parseJSON(product_category);
    var select_provider = "<div><select class='add_ware_select' style='background:#666;color:#fff;'><option value='0' selected='selected'>Մատակարար</option>";
    $.each(provider, function(key, value){
         $.each(value, function(key, a){
              select_provider += "<option>"+a.provider_name+"</option>";
         });
   });
    var prod_category = "<select class='product_category' style='background:#666;color:#fff;'><option value='0' selected='selected'>Տեսակը</option>";
    $.each(product_category, function(key, value){
        
         $.each(value, function(key, b){
           
              prod_category += "<option>"+b.category_name+"</option>";
         });
   });
   prod_category += "</select>";
   select_provider += "</select>";
   select_provider += prod_category+"</div>";
  
   var div1 = "<div id='div1' class='all_add'>\n\
        <button class='close' style='cursor:pointer;border:none;margin-right:0px;height:20px;float:right;width:20px;background:#f60;color:#fff;'>x</button>\n\
        <input   class='product_name' type='text' placeholder='ապրանքի անվանումը' class='prod_names' id='toolsProductName'>\n\
        <input  class='prod_speciess' name='data[tools][spacies]' type='text' placeholder='ապրանքի տեսակ'  id='toolsSpecies' >\n\
        <input name='data[tools][quantity]' placeholder='քանակը' value='0' class='prod_counts_add' type='number' id='toolsQuantity' >\n\
        <button style='width:100px;float:right;cursor:pointer;'  class='add_prod_ware'  >ավելացնել</button>";
    div1 += select_provider;
   function none(x){
        $(".opacity").css({"height": "0px", "width": "0px"});
        $(".mypage *").removeAttr("disabled");
        x.html("");
    }
    function style(div){
         var height = $(window).height();
                var body_height = $("body").height();
                if (height > body_height) {

                } else {
                    height = body_height;
                }
        $(".name_space").prop('readonly', true);
            $(".name_prod").prop('readonly', true);
            $(".name_prod").css('background', "#ccc");
            $(".name_space").css('background', "#ccc");

            
            $(".opacity").css({"display": "block"});
            $(".opacity").css({"width": "100%", "height": "" + height + "", "z-index": "1", "opacity": "0.7", "background": "black", "position": "absolute", "left": "0px", "right": "0px", "top": "0px"});
            $(".body *").attr("disabled", "disabled").off('click');
            $(".close").css({"display": "block"});
            $(".output_p").html(div);
    }
    $("#wastreles").on("click", function () {
        var id = $(this).attr("id");
        save(id);
        $.post('warehouse', {'wastreles': id}, function (data) {

            var obj = jQuery.parseJSON(data);
            var div = "<div><table><thead><tr><td>անունը</td><td>տեսակը</td><td>քանակը</td><td>ում կողմից</td><td>ամսաթիվ</td><td>ելք</td></tr></thead>";
            $.each(obj, function (key, value) {

                $(".view_s").show();
                div += "<tbody><tr>\n\
                                    <td><div style='width:120px' id='prod_name" + value.wastreles.id + "'>   " + value.wastreles.product_name + "</div> </td>\n\
                                    <td> <div style='width:120px' id='prod_space" + value.wastreles.id + "'>    " + value.wastreles.species + "</div> </td>\n\
                                    <td> <div style='width:120px'>    " + value.wastreles.quantity + "</div> </td>\n\
                                      <td> <div style='width:120px'>    " + value.wastreles.username + "</div> </td>\n\
                                      <td> <div style='width:120px'>    " + value.wastreles.created + "</div> </td>\n\
                                    <td><button class='out_pr' alt='" + value.wastreles.id + "' style='cursor:pointer;border:none;border-radius: 4px;font-size: 15px;color: #fff;background: #52ac62;'>ելք</button></td>\n\
                                    \n\
                        </tr></tbody>";

            });
            div += "</table></div>";
            $(".view_s").html(div);
            $(".out_pr").on("click", function (e) {
                var id = $(this).attr("alt");
                var prod_name = $("#prod_name" + id + "").text();
                var prod_space = $("#prod_space" + id + "").text();
                $(".name_prod").val("" + prod_name + "");
                $(".name_space").val("" + prod_space + "");
                $(".wastreles_out").val("" + id + "");
             
                e.stopPropagation();
                e.preventDefault();
                var height = $(window).height();
                var body_height = $("body").height();
                if (height > body_height) {

                } else {
                    height = body_height;
                }
                $(".name_space").prop('readonly', true);
                $(".name_prod").prop('readonly', true);
                $(".name_prod").css('background', "#ccc");
                $(".name_space").css('background', "#ccc");

                $("#div3").css({"display": "block"});
                $(".opacity").css({"display": "block"});
                $(".opacity").css({"width": "100%", "height": "" + height + "", "z-index": "1", "opacity": "0.7", "background": "black", "position": "absolute", "left": "0px", "right": "0px", "top": "0px"});
                $("#div3").css({"background": "#fff", "position": "fixed", "width": "400px", "z-index": "9999", "left": "30%", "top": "30%"});
                $(".body *").attr("disabled", "disabled");
                $(".close").css({"display": "block"});
                $(".out_product").html($("#div3"));
              
                $(".close").on("click", function () {

                });
               
            });
        });
    });
    $("#minus_ware").click(function(){
        localStorage.atr = 'wastreles';
        localStorage.menu = 'պահեստ';
                     
    });
    
    function save_team(x){
        if (window.localStorage) { // Выполнить

            localStorage.team = x;
        }
    }
    function save(atr) {
        if (window.localStorage) { // Выполнить

            localStorage.atr = atr;
        }
    }
    window.onload = function () {

        if (window.localStorage && localStorage.atr ) {

            $("#" + localStorage.atr + "").click();
        }
        if (window.localStorage && localStorage.menu==='Պահեստ' &&  localStorage.atr ) {
            $(".War label").trigger('click');
            $("#" + localStorage.atr + "").click();
          
          
        }
        if (window.localStorage && localStorage.menu==='Աշխատակազմ' &&  localStorage.atr ) {
            $(".Teams label").trigger('click');
            $("#" + localStorage.atr + "").click();
          }
         return false;
    };
    $(".data_species").on("click", function () {

        var product_name = $(this).attr("alt");
        var id = $(this).attr("data");
         
        var atr = $(this).attr("id");
         var prod_id = atr;
        save(atr);
        var change;
        var clicks = [];
        var open_array = [];
        var username = $(".auth_user").text();
       
        $.post('warehouse', {'product_w': id}, function (data) {
            
            var obj = jQuery.parseJSON(data);
            var div = "<div><table><thead><tr><td>տեսակը</td><td>քանակը</td><td>դիտել ավելին</td><td>մուտք</td><td>ելք</td></tr></thead>";
            $.each(obj, function (key, value) {

                ///durs hanel xotanic
                $(".view_s").show();
                if (!value.product_count.product_realtime) {
                    if (username == 'Anush') {
                        var edit_button ="<button style='display:none' class='edit_countbt' data='"+value.product_count.id+"'><img src='/img/icon/edit.png' width='15px' ></button>";
                        var edit_count = "<div class='count_edit' style='display:none' id='count_edit"+value.product_count.id+"'>\n\
                                                <input type='number' value='" + value.product_count.count + "' \n\
                                                                   alt='" + value.product_count.id + "' class='count_an'>\n\
                                                <button><img src='/img/icon/save.png' width='20px' height='20px'></button></div>"
                    } else {
                        var edit_button = '';
                        var edit_count ='';
                    }
                    var md5 = $.md5(value.product_count.species);
                div += "<tbody><tr>\n\
                                    <td><div style='width:250px'>   " + value.product_count.species + "</div> </td>\n\
                                    <td>"+edit_count+edit_button+"<div id='count"+md5+"' style='width:200px'> <span id='countprod"+value.product_count.id+"'>" + value.product_count.count + "</span></div> </td>\n\
                                     <td><button class='edit_p' alt='" + value.product_count.species + "' title='" + value.product_count.id + "' data='" + value.product_count.product_name + "' style='font-weight:bold;border-radius:50%;cursor:pointer;border:none;font-size: 15px;color: #000;background: #f1f1f1;'>...</button></td>\n\
                                    <td><button class='showSingles' alt='" + value.product_count.species + "' title='" + value.product_count.id + "' data='" + value.product_count.product_name + "' style='cursor:pointer;border:none;border-radius: 4px;font-size: 15px;color: #000;background: #81F781;'>մուտք</button></td>\n\
                                    <td><button class='out_pr' alt='" + value.product_count.id + "' style='cursor:pointer;border:none;border-radius: 4px;font-size: 15px;color: #000;background: #81F781;'>ելք</button></td>\n\
                                    \n\
                        </tr>\n\
                            <td  colspan='5'><div class='append' id='append" + value.product_count.id + "'></div></td>\n\
                        <tr>\n\
                        </tr></tbody>";
                }else{
                    if (username == 'Anush') {
                        var edit_button ="<button style='display:none' class='edit_countbt' data='"+value.product_count.id+"'><img src='/img/icon/edit.png' width='15px' ></button>";
                        var edit_count = "<div class='count_edit' style='display:none' id='count_edit"+value.product_count.id+"'>\n\
                                                <input type='number' value='" + value.product_count.count + "' \n\
                                                                   alt='" + value.product_count.id + "' class='count_an'>\n\
                                                <button><img src='/img/icon/save.png' width='20px' height='20px'></button></div>"
                    } else {
                        var edit_button = '';
                        var edit_count ='';
                    }
                    div += "<tbody><tr>\n\
                                    <td><div style='width:250px'>   " + value.product_count.species + "</div> </td>\n\
                                    <td>"+edit_count+edit_button+"<div style='width:200px'><span id='countprod"+value.product_count.id+"'> " + value.product_count.count + "<span></div> </td>\n\
                                     <td><button class='edit_pR' alt='" + value.product_count.product_realtime + "'title='"+ value.product_count.id + "' data='" + value.product_count.created + "'  style='font-weight:bold;border-radius:50%;cursor:pointer;border:none;font-size: 15px;color: #000;background: #f1f1f1;'>...</button></td>\n\
                                    <td><button class='show_prod' alt='" + value.product_count.species + "' name='" + value.product_count.product_realtime + "' title='" + value.product_count.id + "'  data='" + value.product_count.product_name + "' style='cursor:pointer;border:none;border-radius: 4px;font-size: 15px;color: #000;background: #81F781;'>մուտք</button></td>\n\
                                    <td><button class='out_pr' alt='" + value.product_count.id + "' style='cursor:pointer;border:none;border-radius: 4px;font-size: 15px;color: #000;background: #81F781;'>ելք</button></td>\n\
                                    \n\
                        </tr>\n\
                            <td  colspan='5'><div class='appends' id='appends" + value.product_count.id + "'></div></td>\n\
                        <tr>\n\
                        </tr></tbody>";
                }

            });
            
            div += "</table></div>";
            $(".view_s").html(div);
            $(".edit_countbt").on("click",function(){
                var id = $(this).attr("data");
                return edit_cw(id);
            });
            
            $(".edit_pR").on("click",function(){
                
                var data = $(this).attr("alt");
                var created = $(this).attr("data");
                var id = $(this).attr("title");
             
                
                var x = open_array.indexOf(id);
            
                    if(x === -1){
                         open_array.push(id);
                         change = 1;
                    }else{
                           open_array = [];
                         change=null;
                           $("#appends" + id + "").html(' ');
                    }
                    if(change !== null){
                        edit_pR(data,created,id);
                    }
            });
            $(".edit_p").on("click", function () {

                var name = $(this).attr("alt");
                var name_p = $(this).attr("data");
                var id = $(this).attr("title");
                 var x = clicks.indexOf(id);
          
                    if(x ===-1){
                         clicks.push(id);
                         change = 1;
                    }else{
                         clicks = [];
                         change=null;
                           $("#append" + id + "").html(' ');
                    }
                    if(change !== null){
                        edit_product(name,name_p,id);
                    }
              
            });
            $(".show_prod").on("click",function(e){
                var name = $(this).attr("alt");
                var name_p = $(this).attr("data");
                var name_realtime = $(this).attr("name");
                var id = $(this).attr("title");
                $(".prod_species").val(name);
                   $(".prod_species").prop('readonly', true);
                $(".prod_names").prop('readonly', true);
                $(".prod_names").val(name_p);
                  
                add_r(id, name, name_p,name_realtime);
            });
            $(".showSingles").on("click", function (e) {
                var name = $(this).attr("alt");
                var name_p = $(this).attr("data");
                var id = $(this).attr("title");
                $(".prod_species").val(name);
                $(".prod_names").prop('readonly', true);
                $(".prod_names").val(name_p);
                call_provider();
                add(e, name, name_p);
                
            });
           
            jQuery('.out_pr').click(function (e) {
                
                var id = $(this).attr("alt");
                    out_realtime_product(id,e,prod_id);
                    
            });

        });
    });
    function edit_cw(id){
         $(".count_edit").css({"display":"none"});
                $("#count_edit"+id+"").css({"display":"block"});
                $("#count_edit"+id+" button").on("click",function(){
                    var value = $("#count_edit"+id+" input").val();
                    $.post("edit_countw",{"value":value,"id":id},function(data){
                       $(".count_edit").css({"display":"none"});
                       $("#countprod"+id+"").html(data);
                       return;
                    });
                });
    }
    function out_realtime_product(id,e,prod_id){
                      
                $.post('warehouse', {'product_k': id}, function (data) {
             
                    var obj = jQuery.parseJSON(data);
                    $.each(obj, function (key, value) {
                        $(".name_space").val("" + value.product_count.species + "");
                        $(".name_prod").val("" + value.product_count.product_name + "");
                    });
                });
                 
              
                var height = $(window).height();
                var body_height = $("body").height();
                if (height > body_height) {

                } else {
                    height = body_height;
                }
                $(".name_space").prop('readonly', true);
                $(".name_prod").prop('readonly', true);
                $(".name_prod").css('background', "#ccc");
                $(".name_space").css('background', "#ccc");

                $("#div2").css({"display": "block"});
                $(".opacity").css({"display": "block"});
                $(".opacity").css({"width": "100%", "height": "" + height + "", "z-index": "1", "opacity": "0.7", "background": "black", "position": "absolute", "left": "0px", "right": "0px", "top": "0px"});
                $("#div2").css({"background": "#fff", "position": "fixed",  "z-index": "9999", });
                $(".body *").attr("disabled", "disabled").off('click');
                $(".close").css({"display": "block"});
                $(".out_product").html($("#div2"));
                $(".close").on("click", function () { 
                
                });
                
              

    }
    function edit_pR(data,created,id){
         
           $(".appends").html("");
          var count = data.indexOf('++');
       
          var names = [];
          if(count !==-1)
          subsstring(data,count);
     
          function subsstring(data,count){
             var name = data.substr(0,count);
             names.push(name);
             var str = data.substr(count+2);
                     
             count = str.indexOf('++');
             
             if(count !== -1){
                subsstring(str,count);
             }
          }
         
           var output = "<div style=' word-wrap: break-word;width: 400px;'>";
          
          $.each(names, function(key,value){
             output  += "<span>"+value+"</span><br>";
              
          });
          output +="</div>";
          
          $("#appends" + id + "").html(output);

                 
    }
    function edit_product(name,name_p,id){
   

                $(".append").html("");
                $.post('warehouse', {'product': name_p, 'name': name}, function (data) {

                    if (data) {
                        var objs = jQuery.parseJSON(data);
                        var output = "<table><thead><tr><td>մատակարար</td><td>հեռախոս</td><td>քանակը</td><td>ամսաթիվը</td></tr></thead>";
                        $.each(objs, function (key, value) {

                            output += "<tr class='edit_product'><td>" + value.provider.provider_name + "</td>";
                            output += "<td>" + value.provider.telefon + "</td>";
                            output += "<td>" + value.warehouses.quantity + "</td>";
                            output += "<td>" + value.warehouses.created + "</td></tr>";
                        });
                        output += "</table>";

                        $("#append" + id + "").html(output);
                    }
                });
           
        }
        
//    $(".provider_name").on("keyup",function(){
//        var value = $(this).val();
//         $.post('provider', {'provider_find': value}, function (data) {
//              var obj = jQuery.parseJSON(data);
//               var output;
//                $.each(obj, function (key, value) {
//                   output = "<span style='display:block'>";
//                   output += value.provider.provider_name;
//                });
//                output += "</span>";
//                $(".outprovider").html(output);
//         });
//    });
   
    var scroll = $("body").scrollTop(); 
   
    $("#provider").on("click", function () {

        $.post('provider', {'provider': "data"}, function (data) {
            var obj = jQuery.parseJSON(data);
   
            var output = "<div style='float:left'>\n\
                        <table><thead><tr><td>Տիպ</td><td>Անուն</td><td>Հասցե</td><td>Հեռ․</td><td>Բանկի անուն․</td><td>Հաշվեհամար․</td><td>Խմբագրել․</td><td>Ջնջել․</td></tr></thead>";
            $.each(obj, function (key, value) {
                $.each(value, function (key, value) {
                 

                            output += "<tr style='border-bottom:1px solid #ccc' ><td>" + value.legal_type + "</td>";
                            output += "<td>" + value.provider_name + "</td>";
                            output += "<td>" + value.adress + "</td>";
                            output += "<td>" + value.telefon + "</td>";
                            output += "<td>" + value.bank_name + "</td>";
                            output += "<td>" + value.account + "</td>";
                            output += "<td><button style='width:80px;background:#009c44;color:#fff;border-radius:2px;border:none;' class='edit_provier' data="+value.id+">Խմբագրել</button></td>";
                            output += "<td><button  style='width:80px;background:#009c44;color:#fff;border-radius:2px;border:none;'class='delete_provier' data="+value.id+">Ջնջել</button></td>";
                                    "</tr>";
                   
                      
                });
            });
              output += "</table><button class='add_prov' style='float:right;border:none;border-radius: 4px;font-size: 15px;color: #fff;background: #52ac62;'>ավելացնել</button>";
       
              
            $(".view_s").html(output);
            $(".delete_provier").on("click",function(){
                  var answer = confirm("Հաստատում էք?");
                    if (answer){
                        var id = $(this).attr("data");
                        $.post('provider', {'delete_prov': id}, function (data) {
                                   none($(".output_p"));
                                   $("#provider").click();

                        });
                    }
            });
            $(".edit_provier").on("click",function(){
                var id_edit = $(this).attr("data");
                var edit = "<div class='edit_prov'><button class='close'>x</button>";
                $.each(obj, function (key, value) {
                    if(value.provider.id == id_edit){
                        
                        if(value.provider.legal_type == 'ֆիզ. անձ'){
                            var option ='<option>ֆիզ. անձ</option> <option>իրավ. անձ</option>';
                        }else{
                             var option ='<option>իրավ. անձ</option><option>ֆիզ. անձ</option>';
                        }
                        edit+="<select name='legal'>"+option+"</select>";
                        edit+="<input class='id'style='display:none' value="+value.provider.id+">";
                        edit+="<input class='prov_name' value="+value.provider.provider_name+">";
                        edit+="<input class='adress' value="+value.provider.adress+">";
                        edit+="<input class='telefon' value="+value.provider.telefon+">";
                        edit+="<input class='bank_name' value="+value.provider.bank_name+">";
                        edit+="<input class='account' value="+value.provider.account+">";
                    }
                });
                edit+="<button class='end'>Ավարտել</button></div>";
               style(edit);
               $(".close").on("click",function(){
                     none($(".output_p"));
               });
               
               $(".edit_prov .end").on("click",function(){
                   var arr = [];
                   var values = [];
                    $('.edit_prov select').each(function() {
                            values.push($(this).val());
                    });
                        $('.edit_prov input').each(function() {
                            values.push($(this).val());
                        });
                     $.post('provider', {'edit_prov': values}, function (data) {
                           none($(".output_p"));
                           $("#provider").click();
                     });
               });
            });
            
            $(".add_prov").on("click", function () {
               
                  var height = $("body").height();
                        var window_height = $(window).height();
                        if (height < window_height) {
                            height = window_height;
                        }
                        var offset = $(this).offset();
                        $(".opacity").css({"display": "block"});
                        $(".opacity").css({"width": "100%", "height": "" + height + "", "z-index": "1", 
                            "opacity": "0.7", "background": "black", "position": "absolute", "left": "0px", "right": "0px", "top": "0px"});
                        $(".provider").css({"display":"block","background": "#fff", "position": "fixed", 
                            "left": "30%", "top": "30%","z-index":"9999"});
                        $(".body *").attr("disabled", "disabled");
                        $(".close").css({"display": "block"});
                        $('.edit_input').css({"position": "relative", "z-index": "9999", "background": "#fff"});
                        $("#provider").click();
            });
            $(".edit_prof").on("click", function () {
                $(".edit_input").remove();
                var data_e = $(this).attr("alt");
                $.post('provider', {'edit_profile': data_e}, function (data) {
                    var obj = jQuery.parseJSON(data);
                    var k = "<div style='position:fixed;top:50px;z-index:9999;top:40%;'><div class='edit_input'><button class='close' style='margin-right:0px;height:20px;float:right;width:20px;background:#f60;color:#fff;'>x</button>";
                    $.each(obj, function (key, value) {

                        k += "<input id='firstname" + value.id + "' type='text' value='" + value.account + "'>\n\
                                        <input  id='lastname" + value.id + "'type='text' value='" + value.legal_type + "'>\n\
                                        <input id='username" + value.id + "' type='text' value='" + value.provider_name + "'>\n\
                                        <input id='adress" + value.id + "' type='text' value='" + value.adress + "'>\n\
                                        <input id='telefon" + value.id + "'type='text' value='" + value.telefon + "'>\n\
                                        <input id='bank_name" + value.id + "'type='text' value='" + value.bank_name + "'>\n\
                                        <button value='" + value.id + "' class='update_team' id='" + value.id + "'>update</button>";

                    });
                    k += "</div></div>";

                    $(".edit_input").remove();
                    var app = $("." + data_e + "edit_prov").html(k);
                    $(".close").on("click", function () {
                        return a();
                    });
                    if (app) {
                        var height = $("body").height();
                        var window_height = $(window).height();
                        if (height < window_height) {
                            height = window_height;
                        }
                        var offset = $(this).offset();
                        $(".opacity").css({"display": "block"});
                        $(".opacity").css({"width": "100%", "height": "" + height + "", "z-index": "1", "opacity": "0.7", "background": "black", "position": "absolute", "left": "0px", "right": "0px", "top": "0px"});
                        $("." + data_e + "edit_prov").css({"background": "#fff", "position": "absolute", "left": "60%", "top": "30%"});
                        $(".body *").attr("disabled", "disabled").off('click');
                        $(".close").css({"display": "block"});
                        $('.edit_input').css({"position": "relative", "z-index": "9999", "background": "#fff"});
                        $(".update_team").on("click", function () {
                            var id = $(this).attr("id");
                            var update = [];
                            update["0"] = $("#firstname" + id + "").val();
                            update["1"] = $("#lastname" + id + "").val();
                            update["2"] = $("#username" + id + "").val();
                            update["3"] = $("#adress" + id + "").val();
                            update["4"] = $("#telefon" + id + "").val();
                            update["6"] = $("#bank_name" + id + "").val();
                            update["5"] = id;
                            $.post('provider', {'update_profile': update}, function (data) {
                                scroll = $("body").scrollTop();
                                return a();
                            });
                        });
                    }
                });
            });
          
                        
        });
      
    });
   
   
    function add_r(e, x, y,data){
       var name_array = [];
       var array_all_count = [];
       var array_all_space = [];
       var array_space = [];
       var array_name = [];
       var array_count = [];
        if(data){
           
            var pos1,pos2,pos3,length,count;
             var f = "++";
            count = data.split(f).length;
            
             
              for(var i=0;i<count-1;i++){
                length = data.length;
                pos1 = data.indexOf("/");
                pos2= data.indexOf(":");
                pos3 = data.indexOf("++");

                var name,name1,name2;
                    name = data.substr(0,pos1);
                    name1 = data.substr(pos1+1,pos2-pos1-1);
                    name2 = data.substr(pos2+1,pos3-pos2-1);
                    name_array.push(name,name1,name2);
                    data = data.substr(pos3+2,length-pos3-1);
                    array_all_space["space"+ i +""] = name1;
                    array_all_count["count"+ i +""] = name2;
              }
           
        }
        $.post("add_realtime",{"data_r":name_array,"id":e},function(data){
           
            var obj = jQuery.parseJSON(data);
            $.each(obj, function (key, value) {
                for(var k=0;k<=i;k++){
                    if(value.product_count.species === array_all_space["space"+ k +""]){
                        var count_o = parseInt(value.product_count.count/array_all_count["count"+ k +""]);
                        if(count_o === 0){
                            array_space.push(value.product_count.species);
                            array_name.push(value.product_count.product_name);
                        }
                       array_count.push(count_o);
                    }
                }
                  
            });
        
            var count = Math.min.apply(Math,array_count); // 1
           
            var height = $(window).height();
            var body_height = $("body").height();
            if (height > body_height) {

            } else {
                height = body_height;
            }
            if(count === 0){
                $("#div_create").css({"min-height":"150px",});
                $("#div_create div").css({"display":"none",});
                $("#div_create select").css({"display":"none",});
              
                var span ="<span style='color:red;font-size:14px;font-weight:bold'>ՈՒշադրություն!!! դուք չեք կարող ավելացնել տվյալ ապրանքից քանի որ՝</span><br>";
               
                for(var l=0; l < array_space.length;l++){
                    if(array_space[l])
                    span +="<span>"+array_name[l]+"</span><span> " + array_space[l] + " </span><span>ի քանակը 0 Է։</span></br>";
                }
                
                  $("#div_create").append(span);
            }
            else{
                var count_change;
                count_change = "<span style='color:red;font-size:14px;font-weight:bold'>այս ապրանքի տեսակից կարեղ եք ավելացնել ամենաշատը "+count+" հատ!!!</span>";
            }
            $(".prod_countss").html(count_change);
          
            $("#div_create").css({"display": "block"});
            $(".opacity").css({"display": "block"});
            $(".opacity").css({"width": "100%", "height": "" + height + "", "z-index": "1", "opacity": "0.7", "background": "black", "position": "absolute", "left": "0px", "right": "0px", "top": "0px"});
            $("#div_create").css({"background": "#fff", "position": "fixed", "width": "450px", "z-index": "9999", "left": "30%", "top": "30%"});
            $(".body *").attr("disabled", "disabled").off('click');
            $(".close").css({"display": "block"});
            $(".out_product").html($("#div_create"));
            $(".prod_countss").on('keyup',function(e){
                if($(this).val() > count)
                    $(".prod_countss").val(' ');
                if($(this).val() == 0)
                     $(".add_prop_realtime").css({'display':"none"});
                 if($(this).val() > 0)
                      $(".add_prop_realtime").css({'display':"block"});
               
            });
           $(".add_prop_realtime").css({'display':"none"});
         
                  
            
        }); 
        return;
    }

    function add(e, x, y,data) {
       
                   
        var height = $(window).height();
        var body_height = $("body").height();
        if (height > body_height) {

        } else {
            height = body_height;
        }
       
       
        $(".opacity").css({"display": "block"}); 
        $(".opacity").css({"width": "100%", "height": "" + height + "", "z-index": "1", "opacity": "0.7", "background": "black", "position": "absolute", "left": "0px", "right": "0px", "top": "0px"});
        $("#div1").css({"background": "#fff", "position": "fixed", "width": "450px", "z-index": "9999", "left": "30%", "top": "30%"});
        $(".body *").attr("disabled", "disabled").off('click');
      
        $("body").append(div1);
       
         if(x && y){
            $(".product_name").val(y);
            $(".product_name").attr("disabled", "disabled");
            $(".prod_speciess").val(x);
        }
        $(".add_prod_ware").on("click",function(){
             
            var prod_name = $(".product_name").val();
            var prod_space= $(".prod_speciess").val();
            var count_now = $(".prod_counts_add").val();
            var provider = $(".add_ware_select").val();
            var prod_category = $(".product_category").val();
            if(prod_category == 0){
                alert("նշեք տեսակը!")
            }
            if(provider == 0){
                alert("նշեք Մատակարարին!")
            }
             var md5 = $.md5(prod_space);
            var count = $("#count"+md5+"").text();
                
            if(count){
                var  count_view =  parseInt(count_now)  +  parseInt(count);
                 $("#count"+md5+"").text(count_view);     
            }else{
               
            }
           
            if(count_now > 0 && prod_category != 0 && provider!=0){
            $.post("add_ware", {"product_category":prod_category,"prod_name": prod_name,"prod_space":prod_space,"count":count_now,"provider":provider}, function (data) {
         
                    if(!count && data){
                        localStorage.atr = data;
                        localStorage.menu = 'պահեստ';
                        location.reload();
                    }else{
                        none($(".all_add"));
                    }
            });
        }else{
            alert("քանակը պետք է մեծ լինի 0 ից ");
        }
          
        });
        $(".close").on("click",function(){
            none($(".all_add"));
        });
        
     
    }
   
    $("#show1").on("click", function (e) {
        
        add(e);
    });
    jQuery('.warehouse').click(function () {
        if (!jQuery(event.target).hasClass('targetDiv')) {
            jQuery('.targetDiv').hide();
        }
    });
    var prod_count = 1;
    var object = {
        div: function (obj, prod_count) {


            var div = "<div id='dataRows' class='all_item'><div class='fieldRow' id='template'>\n\
                <select class='prod_names' data='' required id='names'><option selected='false' value style='display:none;' disabled='disabled'>Նշեք</option>";
            $(".close").remove();
            var close = "<div  class='close'><button style='margin:0px auto;'>ավարտել</button></div><div class='end_creat'></div>";


            var count = "<input type='number'  class='prod_count' id='prod_count'>\n\
                <button class='add_new' id='add_new'>+</button>\n\
                <button class='button remove' id='btnDel'  style='color:red'>X</button>";
            $.each(obj.prod_name, function (key, value) {

                $.each(value, function (key, value) {

                    if (value)
                        div += "<option >" + value.product_name + "</option>";
                });

            });

            div += "<select><span class='space_add'id='space_add' data=''></span>";

            count += "</div>";
            return div + count + close;
        },
        element: function (element) {
            var end_creat = "  <input type='text' placeholder='ապրանքի անունը' id='name_prod'> \n\
                                <input type='text' id='space_name'  placeholder='ապրանքի տեսակը'> \n\
                                <input type='number' placeholder='քանակը' id='quantity_prod' ><button class='ok'>ok</button>";
            return end_creat;
        }
    };


    
     $(".create_product").on("click", function (event) {

        
        var element = object.element(element);
        creat_element(element);
        
       
    });
    function creat_element(element){
        $(".view_s").html(element);
       
        var atr = "create_product";
            save(atr);
      
        $(".ok").on("click",function(){
            var name_prod = $("#name_prod").val();
            var space_name = $("#space_name").val();
            var quantity_prod = $("#quantity_prod").val();
            properti_add(name_prod,space_name,quantity_prod);
        });
    }
    function properti_add(name_prod,space_name,quantity_prod){
      
        if(name_prod !== '' && space_name!=='' && quantity_prod>0){
           $(".ok").css({"display":"none"});
            creat_product(quantity_prod);
        }
    }
    function creat_product(count_x) {
       
            var x = "prod_name";

            $.post("product_name", {"x": x}, function (data) {
                var obj = jQuery.parseJSON(data);
                var div = object.div(obj, prod_count);
                $(".view_s").append(div);
               


                $(".delete_p").on("click", function () {

                });
                var span;

                $(".prod_names").on("change", function () {
                    span = $(this).attr("data");

                    var space_select = "<select class='prod_spaces' id='prod_spaces" + span + "' data='" + span + "'>";
                    var name_prod = $(this).val();
                    $.each(obj, function (key, value) {
                        $.each(value, function (key, value) {
                            if(value.product_count && value.product_count.product_name === name_prod)
                                 space_select += "<option >" + value.product_count.species + "</option>";
                        });
                    });
                    space_select += "</select>";
                    $("#space_add" + span + "").html(space_select);
                });
                var template = jQuery("#template"),
                        dataRows = jQuery("#dataRows");

                jQuery(".add_new").on("click", function () {

                    var newRow = template.clone(true, true),
                            fieldRows = dataRows.find(".fieldRow");

                    newRow.attr('id', 'data', 'row' + (fieldRows.length + 1)).find('[id]', '[data]').each(function () {

                        jQuery(this).attr("id", jQuery(this).attr("id") + (fieldRows.length + 1));
                        jQuery(this).attr("data", jQuery(this).attr("data") + (fieldRows.length + 1));

                    });

                    fieldRows.filter(":last").after(newRow);

                });

                dataRows.on("click", ".remove", function () {

                    jQuery(this).parent().remove();


                });
                $(".prod_count").on("keyup", function () {
                    $(this).css({"border": "1px solid black"});
                });

                $(".close button").on("click", function () {
                    var prod_count = $(".space_add").last().attr("data");
                    var variable_change = 1;
                    var prod_names = [];
                    var prod_counts = [];
                    var prod_spacieses = [];
                    var prod_all = [];
                    for (var i = 1; i <= prod_count; i++) {

                        if (i !== 1) {
                            prod_all["names" + i + ""] = $("#names" + i + "").val();
                            prod_all["counts" + i + ""] = $("#prod_count" + i + "").val();
                            prod_all["species" + i + ""] = $("#prod_spaces" + i + "").val();

                        } else {
                            prod_all["names" + i + ""] = $("#names").val();
                            prod_all["counts" + i + ""] = $("#prod_count").val();
                            prod_all["species" + i + ""] = $("#prod_spaces").val();
                        }


                        if (prod_all["counts" + i + ""] != 0 && prod_all["names" + i + ""] != null) {
                            $.each(obj.prod_count, function (key, value) {

                                if (value.product_count.product_name === prod_all["names" + i + ""] && value.product_count.species === prod_all["species" + i + ""] && parseFloat(value.product_count.count) < (parseFloat(prod_all["counts" + i + ""])*parseFloat(count_x))) {

                                    if (i === 1) {
                                        $("#prod_count").val(0).css({"border": "2px solid red"});
                                        prod_all["counts" + i + ""] = 0;
                                        variable_change = 0;

                                    } else {
                                        $("#prod_count" + i + "").val(0).css({"border": "2px solid red"});
                                        prod_all["counts" + i + ""] = 0;
                                        variable_change = 0;

                                    }
                                } else if (value.product_count.product_name === prod_all["names" + i + ""] && value.product_count.species === prod_all["species" + i + ""] && parseFloat(value.product_count.count) >= (parseFloat(prod_all["counts" + i + ""])*parseFloat(count_x))) {
                                    prod_all["count_prod" + i + ""] = parseFloat(value.product_count.count) - parseFloat(prod_all["counts" + i + ""])*parseFloat(count_x);

                                } else {

                                }
                                prod_names[i] = prod_all["names" + i + ""] + "/" + prod_all["species" + i + ""] + ":" + prod_all["counts" + i + ""] + ";" + prod_all["count_prod" + i + ""] + "|" + count_x;
                            });
                        } else {
                            variable_change = 0;
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
                        $.post("creat", {"prod_all": prod_names,"name_prod":name_prod,"space_name":space_name}, function (data) {
                            if(data){
                                  localStorage.atr = data;
                                localStorage.menu = 'պահեստ';
                                location.reload();
                            }
                        });
                    } else {

                    }


                });
            });


            
    }
});
