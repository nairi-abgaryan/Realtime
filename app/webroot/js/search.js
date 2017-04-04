$(document).ready(function () { 
  
    $(".call_history").on("click", function () {
        var id = $(this).attr("data");
         console.log(id);
        $.post("call_history", {"tel_id": id}, function (data) {
			
            var obj = $.parseJSON(data);
            var output = "<div class='test' style='height:300px;margin-left:-200px;\n\
                             overflow-x:hidden;overflow: auto;position:relative;z-index:9999;background:#fff;'>\n\
                            <button type='button' style='top:0%;right:0%;' class='closeadding'>x</button>\n\
                                  <audio id='audio' preload='auto' tabindex='0' controls='' type='audio/mpeg'>\n\
                                        <source type='audio/mp3' >\n\
                                    </audio>\n\
                    <table>\n\
                        <thead>\n\
                            <tr>\n\
                                <td>Մուտքանուն</td>   \n\
                                <td>Տևողություն</td>   \n\
                                <td>Սկիզբ</td>   \n\
                                <td></td>   \n\
                                <td></td>   \n\
                                <td></td>   \n\
                            </tr>\n\
                        </thead><tbody> <ul id='playlist'>";
            var i =0;
            $.each(obj,function(key,value){
                i++;
                var href = value.call_history.href;
              
                  var  name='Ձայնագրություն'+i;
               
                var res = href.substr(13);
                 if(!value.call_history.comment){
                            value.call_history.comment = '';
                    }
                if(value.call_history.src.length == 3){
                          var icon ;
                        if(value.call_history.disposition=='FAILED' || value.call_history.billsec==0){
                            icon = '/img/icon/out2.png';
                        }else{
                            icon ='/img/icon/out.png';
                        }
                        if(i==1){
                            var play = " <li class='active play'><a href='http://asterisk.realtime.am"+res+"'>"+name+"</a></li>";
                        }else{
                           var play = " <li class='play'><a href='http://asterisk.realtime.am"+res+"'>"+name+"</a></li>";
                        }
                        if(i==1){
                            var play = " <li class='active play'><a href='http://asterisk.realtime.am"+res+"'>"+name+"</a></li>";
                        }else{
                              var play = " <li class='play'><a href='http://asterisk.realtime.am"+res+"'>"+name+"</a></li>";
                        }
                    output += "<tr><td width='200px'><span class='number' style='width:200px;'>"+value.tech.tel_user+"</span></td>\n\
                                <td width='200px'><span  style='width:200px;'>"+value.call_history.billsec+"</span></td>\n\
                                <td width='200px'> <span  style='width:200px;'>"+value.call_history.created+"<span></td>\n\
                                <td width='30px'>  <span  style='width:20px;'><img width='10px';height='10px'; src ='"+icon+"'></span></td>\n\
                                <td width='30px' style='cursor:pointer'><span>\n\
                                    "+play+"</span></td>\n\
                                </tr>\n\
                                <tr>  <td colspan='7'>\n\
                                    <div style='height:20px;'>\n\
                                    <textarea style='float:left;width:40%;height:15px;'id='comment"+value.call_history.id+"'>"+value.call_history.comment+"</textarea>\n\
                                    <button style='float:left' class='save_comment' data='"+value.call_history.id+"'>save</button></div></td>\n\
                                </tr>";
                    
                }else{
                     var icon ;
                        if(value.call_history.disposition=='FAILED' || value.call_history.billsec==0){
                            icon = '/img/icon/out1.png';
                        }else{
                            icon ='/img/icon/inc.png';
                        }
                     if(i==1){
                            var play = " <li class='active play'><a href='http://asterisk.realtime.am"+res+"'>"+name+"</a></li>";
                        }else{
                              var play = " <li class='play' ><a href='http://asterisk.realtime.am"+res+"'>"+name+"</a></li>";
                        }
                      output += "<tr><td width='200px'><span class='number'>"+value.tech.tel_user+"</span></td>\n\
                                <td width='200px'><span>"+value.call_history.billsec+"</span></td>\n\
                                <td width='200px'><span>"+value.call_history.created+"<span></td>\n\
                                <td width='30px'><span><img width='10px';height='10px'; src ='"+icon+"'></span></td>\n\
                                 <td width='30px' style='cursor:pointer'><span>\n\
                                   "+play+"</span></td>\n\
                                </tr>\n\
                                <tr>\n\
                                    <td colspan='7'><div style='height:20px;'>\n\
                                    <textarea  style='float:left;width:40%;height:15px;' id='comment"+value.call_history.id+"'>"+value.call_history.comment+"</textarea>\n\
                                    <button  style='float:left' class='save_comment'data='"+value.call_history.id+"'>save</button></div></td>\n\
                                </tr>";
                }
                
            });
            output+="</ul><tbody></div>";
            efect(output);
           var audio;
var playlist;
var tracks;
var current;

init();
            function init(){
                current = 0;
                audio = $('#audio');
                playlist = $('.play');
                tracks = playlist.find('a');

                len = tracks.length - 1;
                audio[0].volume = .10;
                playlist.find('a').click(function(e){
                    e.preventDefault();
                    link = $(this);
                    current = link.parent().index();
                    run(link, audio[0]);
                });
//                audio[0].addEventListener('ended',function(e){
//                    current++;
//                    if(current == len){
//                        current = 0;
//                        link = playlist.find('a')[0];
//                    }else{
//                        link = playlist.find('a')[current];    
//                    }
//                    run($(link),audio[0]);
//                });
            }
            function run(link, player){
                    player.src = link.attr('href');
                    par = link.parent();
                    par.addClass('active').siblings().removeClass('active');
                    audio[0].load();
                    audio[0].play();
            }
           $(".closeadding").on("click",function(){
               none($("#technical"));
           })
            $(".save_comment").on("click",function(){
                var call_id = $(this).attr("data");
                var comment = $("#comment"+call_id+"").val();
                $.post("call_history",{"comment":comment,"call_id":call_id},function(data){
                    if(data){
                        alert("Պահպանված է!!!");
                    }else{
                          alert("Պահպանված չէ!!!");
                    }
                    return;
                });
            });
            return;
        });
    });
   function efect (data){
        var height = $(window).height();
            var body_height = $("body").height();
            if (height > body_height) {

            } else {
                height = body_height;
        }
     
        $(".opacity").css({"width": "100%", "height": "" + height + "", "z-index": "1", "opacity": "0.7", "background": "black", "position": "absolute", "left": "0px", "right": "0px", "top": "0px"});
        $(".mypage *").attr("disabled", "disabled");
       $('#technical').css({"background":"#fff"});
       $('#technical').html(data);
//       $(".technical").css({"background":"#fff"});
       $(document).keyup(function(e) {
                 if (e.keyCode === 27 )  none($('#technical'));   // esc
       });
   }
    $(".categorys").on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var id = $(this).attr("data");
        $(".users").css({"display": "none"});
        $("#" + id + "output").css({"display": "block"});
        $("li").removeClass('active');
        $(this).closest('li').addClass('active');
    });
    
    $(".new_users").on("click", function () {

    });
    $(".modem_ip").on("click", function () {
        var ip = $(this).attr("data");
        window.open("http://192.168.252.22/ping/index.php?ping=" + ip + "", "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=200, left=0, width=900, height=350");
    });
    $(".pers_payment").dblclick(function(){
        alert("asda");
    });
    $(".user").on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
//        clearInterval(aa);
//        clearTimeout(aa);
        var username = $(this).text();
        $('li').removeClass('active');
        $(this).closest('li').addClass('active');
        $(".list").empty();
        var id_user = $(this).attr("data_model");
        var id = $(this).attr("title");
        var id_p = $(this).attr("data_model");
        var ping = $(this).attr("data");
        var modem = $(this).attr("alt");
        $(".output").css({"display": "none"});
        $(".users").css({"display": "none"});
        $(".users").css({"display": "none"});
        var a = $("#" + id + "users").css({"display": "block"});
        $.post('edit_payment', {'id': id}, function (data) {
         
            var append_payment = "<div class=view_prof> <table><thead><tr><td>վճարող</td><td>գումար</td><td>ամսաթիվ</td></tr></thead>";
            
            var obj = jQuery.parseJSON(data);
            $.each(obj, function (key, value) {
                    
                    if(value.Transaction.balance_change){
                    append_payment += "<tbody style='border-bottom:1px solid #ccc;height:30px;'>\n\
                            <tr>\n\
                                <td width='120px'>" + value.Transaction.paying_user + "</td>\n\
                                <td width='80px'> " + value.Transaction.balance_change + "</td>\n\
                                <td width='150px' > " + value.Transaction.created + "</td>\n\
                            </tr> \n\
                        </tbody>";
                }else{
                      append_payment += "<tbody style='border-bottom:1px solid #ccc;height:30px;'>\n\
                            <tr>\n\
                                <td width='120px'>" + value.Transaction.paying_user + "</td>\n\
                                <td width='150px'> " + value.log.data + "</td>\n\
                                <td width='100px' > " + value.Transaction.created + "</td>\n\
                            </tr> \n\
                        </tbody>";
                }
               
            });
            append_payment += "</table></div>";

            $("#read_payment" + id + "").html(append_payment);
        });
        var i = 0;
        var timeout = 0;
        var count = [];
        var avg_count = 0;
        var output;
        var data_ping = modem;
//        var aa = setInterval(function ping() {
//            $(".max").html("");
//            $(".avg").html("");
//            $(".min").html("");
//            $(".loss").html("");
//            $.post('../../../ping/ping_realtime.php', {'ping': data_ping}, function (data) {
//                i++;
//
//                var value = data.toString();
//
//                if (value.indexOf("Unreachable") == "-1") {
//
//
//
//                    var pos_time = value.indexOf("time");
//                    var pos_ttl = value.indexOf("ttl");
//                    var ttl = value.substr(pos_ttl);
//                    var time = value.substr(pos_time);
//                    pos_ttl = ttl.indexOf(" ");
//                    pos_time = time.indexOf(" ");
//
//                    ttl = ttl.substr(0, pos_ttl);
//                    time = time.substr(0, pos_time);
//                    var time_int_pos = time.indexOf("=");
//                    var time_int = time.substr(time_int_pos + 1);
//                    if ($.isNumeric(time_int)) {
//                        avg_count = parseFloat(avg_count) + parseFloat(time_int);
//
//
//                        count.push(time_int);
//                        var max = Math.max.apply(Math, count); // 3
//                        var min = Math.min.apply(Math, count);
//                        var avg = avg_count / i;
//                        avg = avg.toString();
//                        avg = avg.substr(0, 5);
//                        output = "<div style='font-size:17px'>Reply from " + data_ping +
//                                ":bytes=1440 time=" + time_int + "ms " + ttl + "<span> max" + max + "</span>\n\
//                                <span> min" + min + "</span> <span>loss" + timeout + " </span><span>avg" + avg + "</span> </span></div>";
//
//
//                        $(".max").html(max);
//                        $(".avg").html(avg);
//                        $(".min").html(min);
//                        $(".loss").html(timeout);
//                    } else {
//                        timeout++;
//                        $(".max").html("request timed out");
//                    }
//
//                } else {
//
//                    $(".max").html("Destination host unreachable");
//                }
//
//            });
//
//        }, 1000);
//        $(document).on("click", function () {
//
//            clearInterval(aa);
//        });



        $.post('estate', {'username_id': id}, function (data) {

            var output = "<div class='estate_style'>";
            if (data) {

                var obj = jQuery.parseJSON(data);

                var lastname;
                var firstname;
                var append = "<div class=view_prof> <table><thead><tr><td width='150px'>աշխատակից</td><td width='100px'>տեսակ</td><td width='100px'>քանակ</td><td width='50px'>ելք</td></tr></thead>";
                $.each(obj.estate, function (key, value) {

                    $.each(obj.team, function (key, values) {

                        if (values.Team.username == value.Estate_user.team_user) {
                            lastname = values.Team.lastname;
                            firstname = values.Team.firstname;
                        }
                    });



                    if (value.Estate_user.id && value.Estate_user.quantity > 0) {

                        append += "<tbody style='border-bottom:1px solid #ccc;'>";
                        append += "<tr class='edit_product' ><td id='product_name" + value.Estate_user.id + "' data='" + value.Estate_user.id + "'>" + firstname + " " + lastname + "</td>";
                        append += "<td id='spacies" + value.Estate_user.id + "'>" + value.Estate_user.species + "</td>";
                        append += "<td id='quantity1" + value.Estate_user.id + "'>" + value.Estate_user.quantity + "</td>";
                        append += "<td ><button class='out'style='color: #fff;border: 1px solid green; background: #848484' data=" + value.Estate_user.id + ">ելք</button></td></tr>";

                        append += "<td  colspan='4' style='border-bottom:1px solid #ccc;'>\n\
                                        <div class='out_product'style='display:none' id='out_prod" + value.Estate_user.id + "'>\n\
                                                    <select class='select_out' style='display:none '>\n\
                                                            <option selected='false' value='1' style='display:none;' disabled='disabled'>անձնակազմ</option>\n\
                                                    </select>\n\
                                                        <span class='select_team' id='select_team" + value.Estate_user.id + "'></span>\n\
                                                 <input type='text'min='0'max='" + value.Estate_user.quantity + "'style='width:100px;border: 1px solid #848484; ' id='quantity" + value.Estate_user.id + "' name='product_quantity' style='width:50px;'> \n\
                                                  <button id='min_prod" + value.Estate_user.id + "'style='color: #fff;border: 1px solid green; background: #848484' data=" + value.Estate_user.id + ">հանել</button>\n\
                                        </div>  \n\
                                        </td>\n\
                                    </tr></tbody>";
                    }
                });
                append += "</table></div>";
                $("#read" + id + "").html(append);
                $(".out_product").css({"display": "none"});
                
                $(".out").on('click', function () {
                    var product_id = $(this).attr("data");

                    $("#out_prod" + product_id + "").css({"display": "block"});
                    $("#quantity" + product_id + "").on("keypress", function (event) {
                        if (event.which !== 8 && isNaN(String.fromCharCode(event.which))) {
                            event.preventDefault();
                        }
                    });
                    
                    $.post('/manegements/tools', {'team': "a"}, function (data) {

                        var obj = jQuery.parseJSON(data);
                        var select = "<select class='sel_team'style='color: #fff;border: 1px solid green; background: #848484' id='team" + product_id + "'>";
                        $.each(obj, function (key, value) {
                            $.each(value, function (key, value) {
                                select += "<option value=" + value.username + ">" + value.firstname + value.lastname + "</option>";
                            });
                        });
                        select += "</select>";

                        $("#select_team" + product_id + "").html(select);
                    });

                    $("#min_prod" + product_id + "").on("click", function () {
                        var change_user = $("#team" + product_id + "").val();
                        var product_name = $("#product_name" + product_id + "").attr("data");
                        var spacies = $("#spacies" + product_id + "").text();
                        var quantity = $("#quantity" + product_id + "").val();
                        var values = $("#quantity1" + product_id + "").text();

                        if (change_user) {

                        } else {
                            change_user = "null";
                        }
                        if (parseInt(quantity) <= parseInt(values)) {

                            $.post('change_house', {'user_id': id, 'username': username, 'change_user': change_user, 'product_name': product_name, 'spacies': spacies, 'quantity': quantity}, function (data) {
                           
                                if (data == 1) {
                                    $(document).ajaxStop(function () {
                                        location.reload();
                                    });
                                }
                            });
                        }
                        else {
                            alert("աշխատողի մոտ չկա տվյալ քանակի ապրանք:");
                        }
                    });
                });

            } else {
                $(".read_property").html("");
            }
        });

    });

    
    $(".disable").on("click", function () {
        var ping = $(".disable").attr("data");
        var modem = $(".disable").attr("alt");
        var data_ping = [];
        data_ping["0"] = ping;
        data_ping["1"] = modem;
        $.post('disable', {'ping': data_ping}, function (data) {
        });
    });
    $(".disable_perpay").on("click",function(){
        var value = $(this).attr("data");
       
    });
    $(".change_category").on("click", function () {
        $(".none").css({"display": "none"});
        var div_block = $(this).attr("alt");
        $(".change_category" + div_block + "").css({"display": "block"});
        var div = $(".change_category" + div_block + "");
        $(".payment_append" + div_block + "").append(div);
    });
    $(".changeed_button").on("click", function () {
        var data_id = $(this).attr("data");
        var value = $(".selected" + data_id + "").val();
        if(value==4){
            var price = $(".selected" + data_id + "").attr("data");
            var day_active = $(".selected" + data_id + "").attr("alt");
            var d = new Date();
            var n = d.getFullYear();
            var m = d.getMonth();
            var mont_day = new Date(n,m,1,-1).getDate();
            price =  parseInt(price/mont_day*day_active);

            var answer = confirm("Բաժանորդը հրաժարվում է մեր ծառաություննեից?");
            if (answer) {
                  var answer = confirm("Դուք պետք է վճարեք "+price+" դրամ");
                  if(answer){
                      if (value) {
                        $.post("bookkeeper", {"category": value, "id_payment": data_id,"price":price}, function (data) {
                                var obj = $.parseJSON(data);
                                print_page(obj);
                            });
                    }
                  }
            }
        }else{
             var answer = confirm("Հաստատեք անջատելը!!");
                  if(answer){
                      if (value) {
                        var price = 0;
                        $.post("bookkeeper", {"category": value, "id_payment": data_id,"price":price}, function (data) {
                                var obj = $.parseJSON(data);
                                print_page(obj);
                        });
                    }
              }
        }
        return;
        
    });
    $(".add_day").on("click", function () {
        $(".none").css({"display": "none"});
        var div_block = $(this).attr("alt");
        $(".add_day" + div_block + "").css({"display": "block"});
        var div = $(".add_day" + div_block + "");
        $(".payment_append" + div_block + "").append(div);
    });
    $(".add_credit").on("click", function () {
        $(".none").css({"display": "none"});
        var div_block = $(this).attr("alt");
        $(".add_credit" + div_block + "").css({"display": "block"});
        var div = $(".add_credit" + div_block + "");
        $(".payment_append" + div_block + "").append(div);
    });
    $(".changeed_credit").on("click", function () {
        var data_id = $(this).attr("data");
        var value = $("." + data_id + "add_credit").val();

        var answer = confirm("" + value + " օր credit Հաստատում էք? ");
        if (answer) {


            var date = $("." + data_id + "payday").text();

            if (value > 0) {

                $.post("bookkeeper", {"day_count_credit": value, "id": data_id, "date": date}, function (data) {
                 
                       var obj = $.parseJSON(data);
                       print_page(obj);
                });
            }
        }
    });
    $(".changeed_day").on("click", function () {
        var data_id = $(this).attr("data");
        var value = $("." + data_id + "day").val();
        var date = $("." + data_id + "payday").text();

        $.post("bookkeeper", {"day_count": value, "id_payment": data_id, "date": date}, function (data) {
                      var obj = $.parseJSON(data);
                       print_page(obj);
        });

    });
    $(".payment").on("click", function () {
        $(".none").css({"display": "none"});
        var div_block = $(this).attr("alt");
        $(".payment" + div_block + "").css({"display": "block"});
        var div = $(".payment" + div_block + "");
        $(".payment_append" + div_block + "").append(div);

    });
    $(".close_p").on('click', function () {
        $(".payment_append div").css({"display": "none"});
    });
    $(".payment_text").on("keypress", function (event) {
        if (event.which !== 8 && isNaN(String.fromCharCode(event.which))) {
            event.preventDefault();
        }
        var value = $(".payment_text").val();
        var input = $(".payment_text");
        input.css({"maxlength": 5});
        input.css({"font-size": "14px", "font-weight": "Medium"});


    });
    $(".payment_continue").on("click", function () {
        var id = $(this).attr("data");
        $.post('bookkeeper', {'continue': id}, function (data) {
            if (data) {
              var obj = $.parseJSON(data);
              print_page(obj);
            }
        });
    });
    $(".save_nocredit").on("click", function () {
        var id = $(this).attr("data");
        var value = $("#nocredit" + id + "").is(':checked');
        if (value == false) {
            var answer = confirm("Հանում  էք no-credit ը?");
        } else {
            var answer = confirm("Դարձնում էք no-credit?");
        }
        if (answer) {
            $.post('bookkeeper', {"no_credit": value, "nocredit_id": id}, function (data) {
                console.log(data);
            });
        }
    });
    $(".add_payment").on("click", function () {

        var id = $(this).attr("data");
        var k = $("#payment_text" + id + "");
        var type = $("#payment_type" + id + "").val();

        var answer = confirm("" + k.val() + " դրամ Հաստատում էք? ");
        if (answer) {
            var value = [];
            value["1"] = $(this).attr("data");
            value["0"] = parseInt(k.val().trim());
            
            if (value["0"] && value["1"]) {
                $.post('bookkeeper', {'id': value, "type": type}, function (data) {
                     
                    if (data) {
                  
                        var obj = $.parseJSON(data);
                       
                       print_page(obj);
                        return false;
                    }
                });
            } else {
                alert("նշեք գումարը");
            }
        }
    });
    function print_page(obj) {
        var def_credit = obj.def_credit.credit.credit;
        obj = obj.payment.Payment;
        
        var date2 = new Date(obj.credit_date);
        var date1 = new Date();
        var timeDiff = Math.abs(date2.getTime() - date1.getTime());
        var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
        console.log(obj);
        
        obj.pers_pay =   parseInt(obj.pers_pay);
      
   
      
        if(obj.pers_pay == 0){
             $("." + obj.id + "payday").html("0000:00:00");
        }else{
            $("." + obj.id + "payday").html(obj.payday);
        }
        
        if(obj.no_credit == 1){
              $("#no_credit"+obj.id+"").attr('checked',false);
        }else{
              $("#no_credit"+obj.id+"").attr('checked',true);
              
        }
        $("#balance"+obj.id+"").html(obj.balance);
        $("#credit"+obj.id+"").html(obj.credit);
        $("#counter_credit"+obj.id+"").html(obj.counter_credit);
        $("#payment_text"+obj.data_id+"").val(obj.pers_pay);
        //$("." + obj.id + "payday").html(obj.payday);
        $(".close_p").click();
        var paymentadd =  $("#paymentadd"+obj.id+"");
        var selected =  $("#selected"+obj.id+"");
        var payment_continue =  $("#payment_continue"+obj.id+"");
        var add_credit = $("#add_credit"+obj.id+"");
        var add_day = $("#add_day"+obj.id+"");
        var change_category = $("#change_category"+obj.id+"");
        if(obj.category ==2 || obj.category  == 0 || obj.category ==4){
                paymentadd.css({"display":"inline"});
        }else {
            paymentadd.css({"display":"none"});
        }
        if(obj.category == 1){
            payment_continue.css({"display":"inline"});
        }else{
            payment_continue.css({"display":"none"});
        }
        if(obj.category ==2 && obj.credit == 0 ){
            add_day.css({"display":"inline"});
        }else{
            add_day.css({"display":"none"});
        }
        if(obj.category ==2){
            change_category.css({"display":"inline"});
        }else{
            change_category.css({"display":"none"});
        }
        if(obj.credit == 0 && obj.category == 0 || obj.category ==4){
            add_credit.css({"display":"inline"});
        }else{
            add_credit.css({"display":"none"});
        }
        if(diffDays > 0 && obj.credit == 0){
            $(".selected"+obj.id+" option[value='0']").remove();
            $(".selected"+obj.id+" option[value='4']").remove();
            $(".selected"+obj.id+" option[value='1']").remove();
            $(".selected"+obj.id+"").append('<option value="1">Կասեցնել</option><option value="4">Հրաժարվել</option>');
        }else{
            $(".selected"+obj.id+" option[value='0']").remove();
            $(".selected"+obj.id+" option[value='4']").remove();
            $(".selected"+obj.id+" option[value='1']").remove();
            
            $(".selected"+obj.id+"").append('<option value="0">Անջատել</option><option value="1">Կասեցնել</option>');
        }
       
        if (obj.category == 1) {
           $(".category"+obj.id+"").html("<span class='disabled_cat disabled_cat"+obj.id+"'>Կասեցված "+obj.payday_now+"</span>");
        } else if(obj.category == 0 ){
           $(".category"+obj.id+"").html("<span class='disabled_cat disabled_cat"+obj.id+"'>Անջատված</span>");
        }else if (obj.category == 4) {
           $(".category"+obj.id+"").html("<span class='disabled_cat"+obj.id+"'>Հրաժարված</span>");
        }else{
            $(".category"+obj.id+"").html("<span class='active_cat active_cat"+obj.id+"'>Ակտիվ</span>");
        }
    }
    $('.add_problems').on('click', function () {
        $('.add_problems_form').css("display", "block");
        var id = $(this).attr("data");
        $(".problems_text" + id + "").val("");
        var el = $(".problems_text" + id + "").get(0);
        var elemLen = el.value.length;
        el.selectionStart = elemLen;
        el.selectionEnd = elemLen;
        el.focus();
    });
    $('.closee').on('click', function () {
        $('.add_problems_form').css("display", "none");
    });

    $('.add_p').on('click', function () {
        var problem = [];

        problem["1"] = $(this).attr('data');
        problem["0"] = $(".problems_text" + problem["1"] + "").val();
      
        if (problem !== 0) {
            var id = problem["1"];
            var user = $(".problem_user" + id + "").val();
            $.post('clientpage', {'add_p': problem, "user": user}, function (data) {
               
              
                $('.add_problems_form').css("display", "none");
                var obj = $.parseJSON(data);
                var p = "";

                $.each(obj, function (key, value) {
                    if (value.Problem.comment) {
                       
                        p += "<div style='float:left;width:100%;border-bottom:1px solid #e8e8e8;'>\n\
                         <div style='width:300px;float:left;font-size:14px;font-weight:bold'>գրանցող-" + value.Problem.reg_person + "</div>\n\
                         <div style='width:300px;float:left;font-size:14px;font-weight:bold'>կատարող -" + value.Problem.pro_person + "</div>\n\
                                <div style='width:100px;float:left;font-weight:bold;font-size:14px'>օր-" + value.Problem.created + "</div>\n\
                                <div style='width:300px;float:left;font-size:14px'>խնդիր-" + value.Problem.comment + "</div>\n\
                         </div>";
                    }
                });
                $("#problem" + id + "").html(p);
            });

        }
    });
    
    $('.add_comments').on('click', function () {
        var id = $(this).attr("data");
        $('.add_comments_form').css("display", "block");
        $(".comments_text" + id + "").val();
        var el = $(".comments_text" + id + "").get(0);
        var elemLen = el.value.length;
        el.selectionStart = 0;
        el.selectionEnd = 0;

        el.focus();
    });

    $('.close').on('click', function (e) {

        $('.add_comments_form').css("display", "none");
    });
    $('.add').on('click', function () {
        var comment = [];
        comment["1"] = $(this).attr('data');
        comment["0"] = $(".comments_text" + comment["1"] + "").val();

        if (comment !== 0) {
            var id = comment["1"];
            $.post('clientpage', {'comment': comment}, function (data) {
                $('.add_comments_form').css("display", "none");
                var obj = $.parseJSON(data);

                var p = "";
                $.each(obj, function (key, value) {
                    if (value.Comment.comment) {

                        p += " <div style='float:left;width:100%;border-bottom:1px solid #e8e8e8;'>\n\
                                <div style='width:90px;float:left;font-size:14px'>" + value.Comment.created + "</div>\n\
                                <div style='width:300px;float:left;font-size:14px'>" + value.Comment.comment + "</div>\n\
                         </div>";
                    }
                });
                $("#com" + id + "").html(p);
            });
        }
    });

    var dd = $(".dropdown-container");
    $(".view").css({"cursor": "pointer"});
    var slide = 0;
    var open = [];
    $(".header_search").click(function (e) {

       
       if(e.toElement.className != "new_user"){
        var id = $(this).attr("data");
        var gps = $(this).attr("alt");
       


        var change_open = open.indexOf(id);

        if (change_open !== -1) {
            $("#dropdown-container" + id + "").css({"display": "none"});
            open = [];
        } else {

            open["0"] = id;
            $(".pay").remove();
            $(".actived").remove();
            $(".user_profile").html();
            $(".users").css({"display": "none"});

            e.preventDefault();
            e.stopPropagation();
            dd.hide();
            $(this).next().show();
            $(".dropdown-container").css('min-height', '300px');
            $(".hide").click(function () {
                
                dd.hide();
                $(this).css({"display": "block"});
            });
            var tech_ip = [];

            $('li').removeClass('active');
            $("#active" + id + "").addClass('active');
            tech_ip["0"] = id;
            tech_ip["1"] = $(this).attr("title");
            $(".output").css({"display": "block"});
             if (gps) {
                var pos = gps.indexOf(",");
                if (pos) {
                    var lat = gps.substr(pos + 1);
                    lat = parseFloat(lat);
                    var lng = gps.substr(0, pos);
                    lng = parseFloat(lng);
                    localStorage.id_map = id;
                    localStorage.lat = lat;
                    localStorage.lng = lng;

                    var div = "<iframe width='100%' height='100%' src='http://newop.realtime.am/realtimes/maps'></iframe>";
                    $("#map" + id + "").html(div);
                }
            }

            $.post('clientpage', {'problem_id': id}, function (data) {
                $('.add_problems_form').css("display", "none");
                $('.form_parment').css("display", "none");
                var obj = $.parseJSON(data);
                var p = "";
                $.each(obj, function (key, value) {
                        var created = value.Problem.created.substr(0,10);
                        var modified = value.Problem.modified.substr(0,10);
                       
                    if (value.Problem.comment) {
                        if(!value.Problem.reg_person)
                            value.Problem.reg_person='';
                        if(!value.Problem.pro_person)
                            value.Problem.pro_person ='';
                         if(!value.Problem.created)
                            value.Problem.created ='';
                         if(!value.Problem.comment)
                            value.Problem.comment ='';
                        if(!value.Problem.pro_solution)
                            value.Problem.pro_solution ='';
                        if(created.indexOf(modified) != -1)
                            modified ='';
                       
                        p += "<div style='float:left;width:100%;border-bottom:2px solid #ccc;'>\n\
                         <div style='width:300px;float:left;font-size:14px;font-weight:bold';border-bottom:1px solid #e8e8e8;>գրանցող-" + value.Problem.reg_person + "</div>\n\
                         <div style='width:300px;float:left;font-size:14px;font-weight:bold;border-bottom:1px solid #e8e8e8;'>կատարող -" + value.Problem.pro_person + "</div>\n\
                                <div style='width:100px;float:left;font-weight:bold;font-size:14px'>օր-" + created + "</div>\n\
                                <div style='width:300px;float:left;font-size:14px;border-bottom:1px solid #e8e8e8;'>\n\
                                    <span style='font-weight:bold;color:red;'>խնդիր-</span>" + value.Problem.comment + "\
                                </div><div style='width:300px;float:left;font-size:14px;'>\n\
                                    <span style='font-weight:bold;color:green'>Լուծում-</span>-"+value.Problem.pro_solution+"\
                                          <div style='float:right;font-weight:bold;font-size:14px'>Ամսաթիվ-" + modified + "</div>\n\
</div>\n\
                         </div>";
                    }
                });
                $("#problem" + id + "").html(p);
            });
            $.post('clientpage', {'comment_id': id}, function (data) {
                $('.add_comments_form').css("display", "none");
                $('.form_parment').css("display", "none");
                var obj = $.parseJSON(data);

                var p = "";
                $.each(obj, function (key, value) {
                    if (value.Comment.comment) {
                     
                        p += " <div style='float:left;width:100%;border-bottom:1px solid #e8e8e8;'>\n\
                                <div style='width:90px;float:left;font-size:14px'>" + value.Comment.created + "</div>\n\
                                <div style='width:300px;float:left;font-size:14px'>" + value.Comment.comment + "</div>\n\
                         </div>";
                    }
                });
                $("#com" + id + "").html(p);
            });
            $("#dropdown-container" + id + "").css({"display": "block"});

        }
        }
    });
    slide = 0;
    $(document).click(function () {
        dd.hide();
        $("a.dropdown-link").css({"display": "block"});
        open = [];
    });
    function none(x) {
        $(".opacity").css({"height": "0px", "width": "0px"});
        $(".mypage *").removeAttr("disabled");
        x.html("");
    }
    dd.click(function (e) {
        e.stopPropagation();
    });
    var k = -1;
    cursor();
   $(".pers_payment").on("keyup",function(){
       var save = "<button>save</button>";
       var pay_id = $(this).attr("data");
       $(".pers_payments"+pay_id+"").html(save);
       var value = $(this).val();
       if(value == ""){
           $(".pers_payments"+pay_id+"").html(" ");
       }
       $(".pers_payments"+pay_id+" button").on("click",function(){
               var answer = confirm("Բաժանորդը օգտվելու է"+value+" դրամով հաստատւմ էք?");
                  if(answer){
                      $.post("bookkeeper",{"value":value,pay_id:pay_id},function(data){
                            $(".pers_payments"+pay_id+"").html(" ");
                             var obj = $.parseJSON(data);
                                print_page(obj);
                               
                      });
                  }
       });
   });
   $(".disable_perpay").on("click",function(){
       var pay_id = $(this).attr("data");
       var a = $("#"+pay_id+"personalpay").val();
      
       if(a){
            var answer = confirm("disable personalpay?");
                 if(answer){
                           $.post("bookkeeper",{"disable":"value",pay_id:pay_id},function(data){
                                 $("#"+pay_id+"personalpay").val("");
                                  var obj = $.parseJSON(data);
                                    print_page(obj);
                           });
                 }
        }
   });
//   $(".search_ids").bind("paste",function(event){
//                cursor();
//                  var searchField = $('#search').val();
//                 
//                $(".search_n").css({"z-index": "-9999"});
//                var a= search(searchField,event);
//               
//                return false;
//   });
  $("#searcharea input").bind('paste', function(event) {
        var _this = this;
        // Short pause to wait for paste to complete
        setTimeout( function() {
            var text = $(_this).val();
            search(text,event);
        }, 10);
    });
   function search(searchField,event){
        var url= "";
       if(event.keyCode == 27) {
                $('.searchresults').remove();  return;// esc
        }
       
        var myExp = new RegExp(searchField, "i");
        var found = 0;
        var count = 0;
        var l = 1;
        var ipformat = /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.$/;
        var ipformat2 = /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;

       if(searchField == parseInt(searchField)){
             if (event.keyCode === 13 ) {
                    cursor();
                    $(".search_n").css({"z-index": "-9999"});
                    window.location.href = "?se=" + searchField.trim() + "";
                    return false;
            }
            $(".search_ids").on("click",function(){
                cursor();
                $(".search_n").css({"z-index": "-9999"});
                window.location.href = "?se=" + searchField.trim() + "";
                return false;
            });
           
        }else if (searchField.match(ipformat) || searchField.match(ipformat2))
        {

            $.post('ip_adress', {'q': searchField}, function (data) {
                if (data != "") {
                    var output = '<div class="searchresults">';
                    var obj = jQuery.parseJSON(data);
                    $.each(obj, function (key, value) {
                        $.each(value, function (key, value) {
                           
                            if (searchField.indexOf("192.168") != "-1") {
                                found = 1;
                                output += "<a href=search?se=" + value.modem + " alt="+value.data_id+" id=" + count + " class='result' data='" + value.modem + "'>" + value.modem + " </a>";
                                count++;
                                url+=value.data_id+" ";
                            } else {
                                found = 1;
                                output += "<a href=search?se=" + value.ip_range + " alt="+value.data_id+" id=" + count + " class='result' data='" + value.ip_range + "'>" + value.ip_range + " </a>";
                                count++;
                                url+=value.data_id+" ";
                            }

                        });
                    });
                    output += '</div>';
                    $(".search_ids").on("click",function(){
                        enters(url);
                    });
                    
                    if (found === 1) {
                        $('#update').removeClass('update-hidden');
                        $('#update').html(output);

                        if (event.keyCode === 40) {

                            k++;
                            a();
                        }
                        if (event.keyCode === 38) {

                            if (k === -1) {

                            } else {
                                k--;
                                b();
                            }
                        }
                        if (event.keyCode === 13) {
                            enters(url);
                        }
                    }
                    else {
                        $('.searchresults').remove();
                    }
                } else {
                    $('.searchresults').remove();
                }
            });
        } else if (/^[a-zA-Z0-9- ]*$/.test(searchField) == false && searchField.indexOf(" ") && searchField.indexOf(" ") !== -1 && searchField.split(' ').length === 2)
        {

           

            $.post('searchresult', {'log_search': searchField}, function (data) {
                
                if (data != "") {
                    var output = '<div class="searchresults">';
                    var obj = jQuery.parseJSON(data);
                    $.each(obj, function (key, val) {
                        $.each(val, function (key, value) {
                            if (count <= 4) {
                                //console.log(count);
                                found = 1;
                                output += "<a href=search?data_id=" + value.id + " alt="+value.id+" id=" + count + " class='result'data='" + value.firstname + " " + value.lastname + "'>" + value.firstname + " " + value.lastname + "</a>";
                                count++;
                                url+=value.id+" ";
                            }
                        });
                    });
                    $(".search_ids").on("click",function(){
                        enters(url);
                    });
                    
                    if (found === 1) {
                        $('#update').removeClass('update-hidden');
                        $('#update').html(output);

                        if (event.keyCode === 40) {

                            k++;
                            a();
                        }
                        if (event.keyCode === 38) {

                            if (k === -1) {

                            } else {
                                k--;
                                b();
                            }
                        }
                        if (event.keyCode === 13) {
                            enters(url);
                        }
                    }
                    else {
                        $('.searchresults').remove();
                    }

                }
                else {
                    $('.searchresults').remove();
                }
            });
            return;
        } else if (/^[a-zA-Z0-9-_]*$/.test(searchField) == true && searchField.length >= 3 )
        {
           
            $.post('searchresult', {'login': searchField}, function (data) {
               
                var output = '<div class="searchresults">';
                var obj = jQuery.parseJSON(data);
              
                $.each(obj, function (key, val) {
                    $.each(val, function (key, value) {
                        if (value.username.search(myExp) !== -1) {
                            found = 1;
                            output += "<a href=search?data_id=" + value.data_id + " alt="+value.data_id+" id=" + count + " class='result' data='" + value.username + "'>" + value.username + " </a>";
                            url+=value.data_id+" ";
                            count++;
                        }
                        else {
                            $('.searchresults').remove();
                        }

                    });
                });
                output += '</div>';
                $(".search_ids").on("click",function(){
                   enters(url);
                });
                if (found === 1) {
                    $('#update').removeClass('update-hidden');
                    $('#update').html(output);

                    if (event.keyCode === 40) {

                        k++;
                        a();
                    }
                    if (event.keyCode === 38) {

                        if (k === -1) {

                        } else {
                            k--;
                            b();
                        }
                    }
                    if (event.keyCode === 13) {
                        
                        enters(url);
                    }
                } else {
                    $('.searchresults').remove();
                }
            });
        } else if (/^[a-zA-Z0-9-]*$/.test(searchField) == false && searchField.length >= 3 && searchField !== parseInt(searchField)) {

            $.post('searchresult', {'q': searchField}, function (data) {
               
                if (data != "[]") {
                    var output = '<div class="searchresults">';
                    var obj = jQuery.parseJSON(data);
                  
                    $.each(obj, function (key, val) {
                        $.each(val, function (key, value) {
                            if (value.lastname.search(myExp) !== -1 || value.firstname.search(myExp) !== -1 && count <= 4) {
                                found = 1;
                                output += "<a href=search?data_id=" + value.id + " alt="+value.id+" id=" + count + " class='result' data='" + value.firstname + " " + value.lastname + "'>" + value.firstname + " " + value.lastname + "</a>";
                                count++;
                                url+=value.id+' ';
                            }
                            else {
                                $('.searchresults').remove();
                            }

                        });
                    });
                    output += '</div>';
                     $(".search_ids").on("click",function(){
                        enters(a);
                     });
                    if (found === 1) {
                        $('#update').removeClass('update-hidden');
                        $('#update').html(output);

                        if (event.keyCode === 40) {
                            k++;

                            a();
                        }
                        if (event.keyCode === 38) {

                            if (k === -1) {

                            } else {
                                k--;
                                b();
                            }
                        }
                        if (event.keyCode === 13) {
                            enters(url);
                        }
                    }

                }
                else {
                    $('.searchresults').remove();
                }
            });
        } else {
            $('.searchresults').remove();
        }
        function enter() {
            cursor();
            $(".search_n").css({"z-index": "-9999"});
            $("#search").val($("#" + k + "").attr("data"));
            var value = $("#search").val();
            value = value.replace(/\s/g, '+');
            window.location.href = "?se=" + value.trim() + "";
            return false;
        }
       function enters(a) {
            cursor();
            $(".search_n").css({"z-index": "-9999"});
            $("#search").val($("#" + k + "").attr("data"));
            if(k !== -1){
                var data_id = $("#" + k + "").attr("alt");
                window.location.href = "?data_id=" + data_id + "";
            }else{
                window.location.href = "?se=" + a.trim() + "";
            }
            
            return false;
        }
        function a() {
          
            if (k === count) {
                k = -1;
                $(".search_n").css({"z-index": "-9999"});
                var input = $("#search");
                input[0].selectionStart = input[0].selectionEnd = input.val().length;
            } else {
                $("#" + k + "").css({"background": "#01a0e2", "color": "#fff"});
                $(".search_n").css({"z-index": "9999"});
                $(".search_n").val($("#" + k + "").attr("data"));
            }
            if(event.keycode===13){
                var data_id =  $("#" + k + "").attr("alt");
                window.location.href = "?data_id=" + data_id.trim() + "";
                return false;
            }
           
        }
        function b() {
            if (k === -1) {
                k = -1;
                $(".search_n").css({"z-index": "-9999"});
                var input = $("#search");
                input[0].selectionStart = input[0].selectionEnd = input.val().length;
            }
            else {
                $("#" + k + "").css({"background": "#01a0e2", "color": "#fff"});
                $(".search_n").css({"z-index": "9999"});
                $(".search_n").val($("#" + k + "").attr("data"));

            }
           
        }
   }
    $('#search').on("keyup", function (event) {
        var url= "";
       if(event.keyCode == 27) {
                $('.searchresults').remove();  return;// esc
        }
        var searchField = $('#search').val();
        search(searchField,event);return;
        
    });
    function cursor() {
        var el = $("#search").get(0);
        var elemLen = el.value.length;
        el.selectionStart = elemLen;
        el.selectionEnd = elemLen;
        el.focus();
    }
    $(".search_n").on("click", function () {
        cursor();
        $(".search_n").css({"z-index": "-9999"});
        $("#search").val($("#" + k + "").attr("data").trim().split(','));
        k = -1;
    });


    $(".new_user").on("click", function () {
        var value = $(this).val();
        

        $.post('add_sess', {'new_user': value}, function (data) {
            if (data) {
               
                var a = $('#technical').load('../realtimes/technical_data');
                efect(a);
            }

        });
        var height = $(window).height();
        var body_height = $("body").height();
        if (height > body_height) {

        } else {
            height = body_height;
        }
     
        $(".close").on("click", function () {
            none($("#technical"));
        });

    });
    $(".edit").on("click", function () {
        var id = $(this).val();

        var output = "<div class='edit_profile'style='position:relative; height: 320px;'><button class='close' style='position:absolute;right:0px;top:0px;border:none;background:#f60;color:#fff;font-weight:bold;'>x</button>";
        $.post("edit_profile", {"profile": id}, function (data) {

            var obj = jQuery.parseJSON(data);
            $.each(obj, function (key, value) {
             
               
                if (!value.Gps.gps)
                    value.Gps.gps = '';
                if (!value.Person.pasport_seria)
                    value.Person.pasport_seria = '';
                if (!value.Person.add_pasport_time)
                    value.Person.add_pasport_time = '';
                if (!value.Person.email)
                    value.Person.email = '';
                if (!value.Person.by_whom)
                    value.Person.by_whom = '';
                if (!value.Adress.home)
                    value.Adress.home = '';
                if (!value.Telefon.tel_name)
                    value.Telefon.tel_name = '';
                if (!value.Telefon.tel1)
                    value.Telefon.tel1 = '';
                 if (!value.Telefon.tel2)
                    value.Telefon.tel2 = '';
                if (!value.Village.village_name || value.Village.village_name == "null")
                    value.Village.village_name = '';
                if (!value.Adress.city || value.Adress.city == "null")
                    value.Adress.city = 'Երևան';
                if (!value.Adress.home || value.Adress.home == "null")
                    value.Adress.home = '';
                if (!value.Street.street_name || value.Street.street_name == "null")
                    value.Street.street_name = '';
                output += "<form action='/realtimes/search' method='post' class='view_server' >";
                 if(value.Person.change_legal == 0){ 
                    output+="<label>Ընկերություն</label><input  name='data[Person][company_name]' placeholder='Ընկերություն' value='" + value.legal.company_name + "'>\n\
                             <label style='width:100px;margin-left:30px;'>հհ</label><input  name='data[Person][account]' placeholder='հհ' value='" + value.legal.account + "'>\n\
                             <label>Բանկ</label><input  name='data[Person][name_bank]' placeholder='Բանկ' value='" + value.legal.name_bank + "'> \n\
                             <label>ՀՎՀՀ</label><input  name='data[Person][tax]' placeholder='ՀՎՀՀ' value='" + value.legal.tax + "'>\n\ "
                }else{
                    output += "<span>Ա․ սերիա</span><input name='data[Person][pasport_seria]' placeholder='անփնագրի սերիա' value='" + value.Person.pasport_seria + "'>\n\
                                        <span>տրված է</span><input name='data[Person][add_pasport_time]' placeholder='տրված է' value='" + value.Person.add_pasport_time + "'>\n\
                                        <span>ՈՒմ կողմից</span><input name='data[Person][by_whom]' placeholder='ոմ կողմից' value='" + value.Person.by_whom + "'>\n\
\n\                                     <span>email</span><input name='data[Person][email]' placeholder='email' value='" + value.Person.email + "'>";
                }
                 output +=   "<input  name='data[Person][id]' style='display:none'value='" + value.Person.id + "'>\n\
                                    <span>անուն*</span><input  name='data[Person][firstname]'required placeholder='անուն' value='" + value.Person.firstname + "'>\n\
                                      <span>ազգանուն*</span><input name='data[Person][lastname]' required placeholder='ազգանուն'value='" + value.Person.lastname + "'>\n\
                                        <span>Մարզ</span><select id='Person_C' name='data[Person][city]'style='width:150px;height:28px;border:1px solid #ccc;'><option value='Արմավիր'>Արմավիր</option>\n\
                                                     <option selected='selected' value=" + value.Adress.city + ">" + value.Adress.city + "</option>\n\
                                                     <option value='Արարատ'>Արարատ</option>\n\
                                                     <option value='Երևան'>Երևան</option>\n\
                                                     <option value='Սյունիք'>Սյունիք</option>\n\
                                                     <option value='Վայոց Ձոր'>Վայոց Ձոր</option>\n\
                                                     <option value='Կոտայք'>Կոտայք</option>\n\
                                                     <option value='Գեղարքունիք'>Գեղարքունիք</option>\n\
                                                     <option value='Շիրակ'>Շիրակ</option>\n\
                                                     <option value='Լոռի'>Լոռի</option>\n\
                                                     <option value='Տավուշ'>Տավուշ</option>\n\
                                                     <option value='Արագածոտն'>Արագածոտն</option>\n\
                                             </select>\n\
                                        <span>Գյուղ</span><input name='data[Person][village]' placeholder='գյուղը' class = 'village'Autocomplete = 'off' oninvalid='setCustomValidity('ընտրեք միայն գյուղերի ցանկից')' onchange='try {\n\
                                            setCustomValidity('ընտրեք միայն գյուղերի ցանկից')\n\
                                        } catch (e) {\n\
                                        } required value='" + value.Village.village_name + "'><div class='villagesearchresult_t'  placeholder='email'  style=''></div>\n\
                                        <span>փողոց</span><input name='data[Person][street]' placeholder='փողոց' value='" + value.Street.street_name + "'>\n\
                                        <span>տուն</span><input name='data[Person][home]' placeholder='տուն' value='" + value.Adress.home + "'>\n\
                                        <span>1.հեռախոս.</span><input name='data[Person][telefon]' placeholder='հեռ.' value='" + value.Telefon.telefon + "'>\n\
                                        <span>2.հեռախոս</span><input name='data[Person][telefons]' placeholder='հեռ.' value='" + value.Telefon.tel1 + "'>\n\
                                        <span>3.հեռախոս</span><input name='data[Person][telefonss]' placeholder='հեռ.' value='" + value.Telefon.tel2 + "'>\n\
                                        <span>gps</span><input name='data[Person][gps]'style='width:200px' placeholder='gps' value='" + value.Gps.gps + "'>\n\
                                         <span style='display:block;margin-top:10px;margin-bottom:10px'>մեկնաբանություն</span><textarea name='data[Person][comment]' placeholder='մեկնաբանություն'>" + value.Person.comment + "</textarea>\n\
                                        <input class='edit_profiles'  style='border:none;float:right;display:block;border-radius:5px;z-index:9999;bottom:2px;color: #fff;background: #009c44;' type='submit' data='" + value.Person.id + "' value='փոփոխել'></form>";

            });

            output += '</div>';
            var height = $(window).height();
            var body_height = $("body").height();
            if (height > body_height) {

            } else {
                height = body_height;
            }
            $(".opacity").css({"width": "100%", "height": "" + height + "", "z-index": "1", "opacity": "0.7", "background": "black", "position": "absolute", "left": "0px", "right": "0px", "top": "0px"});

            $(".mypage *").attr("disabled", "disabled");
            $(".new_user_technical").css({"display": "block"});
            $('#technical').html(output);
            $(".close").on("click", function () {
                none($('#technical'));
            });
//            $("body").on("click", function (evt) {
//               var a = evt.target.closest('.edit_profile');
//                if(a){
//                        return;
//                    } else {
//                    none($('#technical'));
//                    }
//            });
            $(document).keyup(function(e) {
                 if (e.keyCode === 27)  none($('#technical'));   // esc
              });
            $(".edit_profiles").on("click", function () {
                var id = $(this).attr("data");

                $.post('add_sess', {'end': id}, function (data) {
                    console.log(data);
                });
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
                                    if (value.village_name.search(myExp) !== -1) {
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
                            $('.villagesearchresult_t').removeClass('update-hidden');
                            $('.villagesearchresult_t').html(output);
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
                                console.log(c);
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
            //$("#technical").html(output);
        });
    });
    $(document).on("click", function () {

    });
    $(".tech_edit").on("click", function (e) {
        var id = $(this).val();
        $.post('edit_profile', {'edit_tech': id}, function (data) {

            var output = "<div class='edit_profile' style='position:relative'><button class='close' style='font-weight:bold;color:#fff;background:#f60;position:absolute;right:0px;z-index:9999'>x</button>";
            var a = "";
            var obj = jQuery.parseJSON(data);

            $.each(obj.tech, function (key, value) {
                var select = "<span>Ծառաություն</span><select class='" + value.id + "service' style='width:200px;height:24px;border:1px solid black;'>";
                if (value.station !== "not_station") {
                    a += "<span>կայան</span><input type=text class='station' value='" + value.station + "'>";

                } else {
                    a += "<span>կայան</span><input type=text class='station' placeholder='կայան' value='կայանը գրանցված չի'>";
                }
                if (value.username) {
                    if (value.ap == null)
                        value.ap = '';
                    if (value.password == null)
                        value.password = '';
                    if (value.con_type == null)
                        value.con_type = '';
                    if (value.vlan == null)
                        value.vlan = '';
                    if (value.modem == null)
                        value.modem = '';
                    output += "<div style='position:relative' class='technical_edit'>  <label style='display: block;color:#01a0e2;font-weight: bold;'>Տեխնիկական տվյալներ</label>\n\
                              <span>մուտքանուն</span><input class='" + value.id + "username'id = 'PersonUser' type='text'placeholder='մուտքանուն'value='" + value.username + "'>\n\
                              <span>գախտնաբառ</span><input class='" + value.id + "password' type='text' placeholder='գախտնաբառ'value='" + value.password + "'>\n\
                              <span>միացման տիպ</span><input class='" + value.id + "con_type'type='text'placeholder='միացման տիպ'value='" + value.con_type + "'>\n\
                              <span>ap</span><input class='" + value.id + "ap'type='text'placeholder='ap'value='" + value.ap + "'>\n\
                              <span>vlan</span><input class='" + value.id + "vlan'type='text'placeholder='vlan'value='" + value.vlan + "'>\n\
                              <span>մոդեմ</span><input class='" + value.id + "modem'type='text'placeholder='մոդեմ ip'value='" + value.modem + "'>\n\
                              <button class='add' style='border:none;position:absolute;right:4px;border-radius:5px;z-index:9999;bottom:2px;color: #fff;background: #009c44;' type='text'value='" + value.id + "'>փոփոխել</button>";

                }
                $.each(obj.service_name, function (key, values) {
                    if (value.service_id === values.Service_name.id) {
                        select += "<option selected='selected' value='" + values.Service_name.id + "'>" + values.Service_name.service_name + "</option>";
                    } else {
                        select += "<option value='" + values.Service_name.id + "'>" + values.Service_name.service_name + "</option>";
                    }
                });
                select += "</select>";
                output += select;
            });
            a += "<span class='stations_result' style=''></span>";


            output += a;

            var height = $(window).height();
            var body_height = $("body").height();
            if (height > body_height) {

            } else {
                height = body_height;
            }
            $(".opacity").css({"width": "100%", "height": "" + height + "", "z-index": "1", "opacity": "0.7", "background": "black", "position": "absolute", "left": "0px", "right": "0px", "top": "0px"});

            $(".mypage *").attr("disabled", "disabled");

            $('#technical').html(output);
            $(".close").on("click", function () {
                none($('#technical'));
            });
            $(".add").on("click", function () {
                var tech = [];
                var id = $(this).val();
                tech["0"] = $("." + id + "username").val();
                tech["1"] = $("." + id + "password").val();
                tech["2"] = $("." + id + "con_type").val();
                tech["3"] = $("." + id + "ap").val();
                tech["4"] = $("." + id + "vlan").val();
                tech["5"] = $("." + id + "modem").val();
                tech["8"] = $("." + id + "service").val();
                tech["6"] = $(".station").val();
                tech["7"] = id;
                $.post('edit_profile', {'update_tech': tech}, function (data) {

                    location.reload();
                });
            });
             $(document).keyup(function(e) {
                 if (e.keyCode === 27 )  none($('#technical'));   // esc
       });
            $('#PersonUser').on('keyup', function () {
                var searchField = $('#PersonUser').val();
                $.post('user', {'q': searchField}, function (data) {


                    var obj = jQuery.parseJSON(data);//de siktir ejicse eee hambal sik
                    if (obj.length !== 0) {

                        $("#PersonUser")[0].setCustomValidity("այդ անունով օգտատեր կա");
                    }
                    else {
                        $('#PersonUser').attr('required', true);
                        $("#PersonUser")[0].setCustomValidity(''); 
                    }
                });

            });
            $(".station").on("keyup", function (event) {
                 var station = $(this).val();
                    if(station.length >= 3 ){
                         if(event.keyCode == 27) {
                        $('.searchresults').remove();  return;
                    }else{
                        station_search(station,event,k);
                    }  
                }
            });

        });
    });
    $('#cssmenu').prepend('<div id="menu-button">Menu</div>');
    $('#cssmenu #menu-button').on('click', function () {
        var menu = $(this).next('ul');
        if (menu.hasClass('open')) {
            menu.removeClass('open');
        }
        else {
            menu.addClass('open');
        }
    });
    $(".clients_map").on("click", function () {
        var modem_ip = $(this).attr("data");
        var center = $(this).attr("alt");
        if (modem_ip && center) {
            $.post("modem_search", {"modem_ip": modem_ip}, function (data) {
                localStorage.modem_gps = data;
                localStorage.center = center;
                var height = $(window).height();
                var body_height = $("body").height();
                if (height > body_height) {

                } else {
                    height = body_height;
                }
                $(".opacity").css({"width": "100%", "height": "" + height + "", "z-index": "1", "opacity": "0.7", "background": "black", "position": "absolute", "left": "0px", "right": "0px", "top": "0px"});

                $(".mypage *").attr("disabled", "disabled");
                $(".maps").css({"background": "#fff", "z-index": "9999"});
                $(".maps").css({"display": "block"});
                var iframe = "<iframe src='maps_2' width='100%' height='100%'><iframe>";

                $(".maps").html(iframe);
                $(".close").on("click", function () {
                    none($("#technical"));
                });
                $(document).on("click", function () {
                    $(".maps").css({"display": "none"});
                    none($(".maps"));
                });
            });

        }
    });

});
