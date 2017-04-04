$(document).ready(function () {
    var team_obj;

    $.post("TeamTools", {"all_team": "all_team"}, function (team) {
        team_obj = $.parseJSON(team);
    });

    /**
     * used jobs function get url /tools/{date1}/{date2}/{worker}/{type}
     */
    $('.jobs').on("click", function (event) {
        $(".output_region").html("");
        $(".output_tools").html("");
        var date = [];
        var fields =
            "<form class='jobsForm'>" +
            "<input type='date' id='firstDate' min='2015-01-01' '/>" +
            "<input type='date' id='lastDate' min='2015-01-01' '/>" +
            "<select class='type'>" +
                "<option value='listProblems'> Խնդիրներ </option>" +
                "<option value='listConnection'>Միացումներ</option>" +
            "</select>";

        var select = '<select class="worker"><option value=0 >Նշեք Աշխատողին</option>';

        $.each(team_obj, function (key, values) {
            select += "<option>" + values.Team.username + "</option>";
        });

        select += '</select>';
        fields += select + " <button type='button'>Որոնել</button></form>";
        $(".output_region ").html(fields);
        $(".jobsForm button").on("click", function () {

            var created = $("#firstDate").val();
            if(!created){
                $("#firstDate").css({"border":"1px solid red"});
                return false;
            }

            var updated = $("#lastDate").val();
            if(!updated){
                $("#lastDate").css({"border":"1px solid red"});
                return false;
            }

            var worker = $(".worker").val();

            var type = $(".type").val();

            $.get("/tools/"+type+"/"+created+"/"+updated+"/"+worker+"",function (data) {
                $(".output_tools").html(data);
                return;
            })
        })
    });
    $(".person_ad").on("click", function () {
         var i=0;
       all_client(i);
    });

    $(".default_credit").on("click", function () {
        $(".output_region").html("");
        $(".output_tools").html("");
        default_credit();
    });
    $(".stoped_client").on("click", function () {
          $(".output_region").html("");
        $(".output_tools").html("");
        stoped_client();
    });
    $(".active_client").on("click", function () {
          $(".output_region").html("");
        $(".output_tools").html("");
        active_client();
    });
    $(".disable_client").on("click", function () {
          $(".output_region").html("");
        $(".output_tools").html("");
        disable_client();
    });
    $(".pay_debt").click(function () {
        $(".output_region").html("");
        $(".output_tools").html("");
        pay_debt();
    });
    $('.pay_history').on("click", function () {
        $(".output_region").html("");
        $(".output_tools").html("");

        pay_history();
    });
    $(".pay_credit_all").click(function () {
        pay_credit_all();
    });
    $(".pay_credit").click(function () {
         $(".output_region").html("");
        $(".output_tools").html("");
        pay_credit();
    });
    $(".pay_not_credit").click(function () {
        pay_not_credit();
    });
    $(".no_credit").on("click", function () {
        $(".output_region").html("");
        $(".output_tools").html("");
         no_credit();
    });
    $(".none_call").click(function(){
        $(".output_region").html("");
        $(".output_tools").html("");
        none_call();
    });
      $(".view_center").click(function(){
        $(".output_region").html("");
        $(".output_tools").html("");
        view_center();
    });
    $(".add_center").on("click",function(){
        add_center();
    });
    function add_center() {
        view_center();
        var input = "<div class='addCenter'>";
        input += "<label style='margin-top:1px;'>Անվանում*</label><input type='text' placeholder='Անվանում'>";
        input += "<label style='margin-top:1px;'>Հեռախոսահամար*</label><input type='number' placeholder='Հեռախոսահամար'>";
        input +="<div  ><select id='Person_C' name='region'  style='width:150px;height:28px;border:1px solid #ccc;'>\n\
                                                <option value='0'>նշեք մարզը</option>\n\
                                                <option value='Արմավիր'>Արմավիր</option>\n\
                                                <option value='Արարատ'>Արարատ</option>\n\
                                                <option value='Սյունիք'>Սյունիք</option>\n\
                                                <option value='Վայոց Ձոր'>Վայոց Ձոր</option>\n\
                                                <option value='Կոտայք'>Կոտայք</option>\n\
                                                <option value='Գեղարքունիք'>Գեղարքունիք</option>\n\
                                                <option value='Շիրակ'>Շիրակ</option>\n\
                                                <option value='Լոռի'>Լոռի</option>\n\
                                                <option value='Տավուշ'>Տավուշ</option>\n\
                                                <option value='Արագածոտն'>Արագածոտն</option>\n\
                                                <option value='Երևան'>Երևան</option>\n\
                                        </select>\n\
                   <input name='village' Autocomplete = 'off' style='width:320px;' disabled='disabled' placeholder='գյուղը' type='text' class='village'><br>\n\
                     <div class='villagesearchresult' style='position: absolute;margin-left:160px;z-index:1'></div> ";
        var div = "<div class='add_centers'><button class='close_tarrif'>x</button>";
        div += input;
        div += "<button class='end_center_close' >Ավարտել</button></div>";
        div += "</div>";
        personForm(div);
        $("#Person_C").on("change", function () {
             enable_village(this);
         });
         var k = 0;
         $(".village").on("keyup", function (event) {
             village_search(k, event);
         });
         $(".end_center_close").on("click",function(){
                var values = $(".addCenter input").map(function () {
                        return $(this).val();
                    }).get();
                    var region = $("#Person_C").val();
                    var village = $(".village").val();
                     values.push(region);
                     if(region == 0 || village ==''){
                         alert("Մարզը և գյուղը պարտադիր են");return;
                     }else{

                         $.post("view_center",{"add_center":values},function(data){
                            center_output(data);
                              none();
                         });

                     }


         });
           function none(){
                    $(".opacity").css({"height":"0px","width":"0px"});
                        $(".mypage *").removeAttr( "disabled" );
                            $(".personForm").html("");
                    }
                   $(".close_tarrif").on("click",function(){
                        none();
                   });
    }
    function view_center(regions){

        var region = "<div class='view_center_head'><h4>Ցույց է տալիս մեր վճարման կետերը</h4><div class='select_item'>";
        region += "<select class='view_center_select'>\n\
                                                <option value='null'>Նշեք մարզը</option>\n\
                                                <option value='Արմավիր'>Արմավիր</option>\n\
                                                <option value='Արարատ'>Արարատ</option>\n\
                                                <option value='Սյունիք'>Սյունիք</option>\n\
                                                <option value='Վայոց Ձոր'>Վայոց Ձոր</option>\n\
                                                <option value='Կոտայք'>Կոտայք</option>\n\
                                                <option value='Գեղարքունիք'>Գեղարքունիք</option>\n\
                                                <option value='Շիրակ'>Շիրակ</option>\n\
                                                <option value='Լոռի'>Լոռի</option>\n\
                                                <option value='Տավուշ'>Տավուշ</option>\n\
                                                <option value='Արագածոտն'>Արագածոտն</option>\n\
                                                 <option value='Երևան'>Երևան</option>\n\
                                        </select><button>Որոնել</button>";
        region += "</div>";



        $(".output_region").html(region);
        $(".view_center_head button").on("click",function(){
            var region_select =  $(".view_center_select").val();
            if(region_select != "null"){
             $.post("view_center",{"center":region_select},function(data){
                        center_output(data);

                });
            }else{
                alert("Նշեք Մարզը");
            }

        });

    }
    function center_output(data){
        var obj= JSON.parse(data);
        var output = "<div class='output_center'><table>";
            output+="<thead><tr><td style='width:200px;'>Գյուղ</td><td>Անուն</td><td style='width:200px;'>Հեռախոսահամար</td><td>Խմբագրել</td><td>Ջնջել</td></tr></thead><tbody>";
            $.each(obj,function(key,value){
                output+="<tr><td>"+value.v.village_name+"</td>";
                output+="<td>"+value.p.center_name+"</td>";
                output+="<td><span id=''>"+value.p.phone+"</td>";
                output+="<td><button data='"+value.p.id+"' alt='"+value.v.region_name+"' class='edit_center'>Խմբագրել</button></td>";
                output+="<td><button data='"+value.p.id+"' alt='"+value.v.region_name+"'class='delete_center'>Ջնջել</button></td></tr>";
            });
            output+='</tbody></table>';
            $(".output_tools").html(output);
            $(".edit_center").on("click",function(){
                var id = $(this).attr("data");
                var region = $(this).attr("alt");
                var input='';
                $.each(obj,function(key,value){
                    if(value.p.id==id){
                        input+="<label style='margin-top:10px;'>Անվանում*</label><input type='text' value='"+value.p.center_name+"'>";
                        input+="<label style='margin-top:10px;'>Հեռախոսահամար*</label><input type='number'value='"+value.p.phone+"'>";
                    }
                });
                var  div = "<div class='edit_view'><button class='close_tarrif'>x</button>";
                div+=input;
                div+="<button class='edit_center_close' >Ավարտել</button>";
                div+="</div>";
                personForm(div);

                $(".edit_center_close").click(function(){
                    var values = [];

                    var values = $(".edit_view input").map(function () {
                        return $(this).val();
                    }).get();
                     values.push(id);
                     values.push(region);

                    $.post("view_center",{"edit_values":values},function(data){
                           center_output(data);
                           none();
                    });
                });
                 function none(){
                    $(".opacity").css({"height":"0px","width":"0px"});
                        $(".mypage *").removeAttr( "disabled" );
                            $(".personForm").html("");
                    }
                   $(".close_tarrif").on("click",function(){
                        none();
                   });
            });

            $(".delete_center").on("click",function(){
                  var r = confirm("Ջնջում էք վճարման կետը՞");
                   if(r){
                        var id = $(this).attr("data");
                        var region = $(this).attr("alt");
                        var values = [];
                        values.push(id);
                        values.push(region);
                        $.post("view_center",{"delete_values":values},function(datas){
                            center_output(datas);

                        });
                   }
            });


    }
    function none_call(){
         var div = "<h4>Ցույց է տալիս այն բաժանորդներին ում համարը գրանցված չէ </h4>\n\
                        <div class='menu_disabled'>\n\
                        <ul class='none_calls'>\n\
                            <li ><input type='date' class='change_dis' >\n\
                                <input type='date' class='change_dis' >\n\
                                <input type='text' class='number'></li><button>Որոնել</button>\n\
                        </ul><div class='log_html'></div></div>";
          $(".output_region").html(div);
          $(".none_calls button").click(function(){
                var values = $(".none_calls input").map(function () {
                    return $(this).val();
                }).get();

                print_call(values);

          });
          $(".number").on("keyup",function(event){
              if(event.keyCode==13){
                    var values = $(".none_calls input").map(function () {
                    return $(this).val();
                }).get();

                print_call(values);
              }
          });
    }
    function print_call(values){

         if(values.length!=0 ){
                    $.post("/realtimes/call_history",{"values":values},function(data){
                        if(data==0){
                              alert("Լրացրեք դաշտերից որևէ մեկը");
                        }else{
                             var obj = $.parseJSON(data);
            var output = "<div class='test'><audio id='audio' preload='auto' tabindex='0' controls='' type='audio/mpeg'>\n\
                                        <source type='audio/mp3' >\n\
                                    </audio>\n\
                    <table>\n\
                        <thead>\n\
                            <tr>\n\
                                <td>Աշխատակից</td>   \n\
                                <td>Հեռախոս</td>\n\
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
                     var number;
                if(value.call_history.dst.length>3){
                     number = value.call_history.dst;
                }else if(value.call_history.src.length>3){
                     number = value.call_history.src;
                }else{

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
                    output += "<tr>\n\
                                <td width='200px'><span class='number' style='width:200px;'>"+value.tech.tel_user+"</span></td>\n\
                                <td width='200px'><span class='number' style='width:200px;'>"+number+"</span></td>\n\
                                <td width='200px'><span  style='width:200px;'>"+value.call_history.billsec+"</span></td>\n\
                                <td width='200px'> <span  style='width:200px;'>"+value.call_history.created+"<span></td>\n\
                                <td width='30px'>  <span  style='width:20px;'><img width='10px';height='10px'; src ='"+icon+"'></span></td>\n\
                                <td width='30px' style='cursor:pointer'><span>\n\
                                    "+play+"</span></td>\n\
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
                                   <td width='200px'><span class='number' style='width:200px;'>"+number+"</span></td>\n\
                                        <td width='200px'><span>"+value.call_history.billsec+"</span></td>\n\
                                        <td width='200px'><span>"+value.call_history.created+"<span></td>\n\
                                        <td width='30px'><span><img width='10px';height='10px'; src ='"+icon+"'></span></td>\n\
                                         <td width='30px' style='cursor:pointer'><span>\n\
                                   "+play+"</span></td>\n\
                        </tr>";
                }

            });
            output+="</ul><tbody></div>";
           $(".output_tools").html(output);
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
//               
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

                        }
                    });
               }else{
                   alert("Լրացրեք դաշտերից որևէ մեկը");
               }
    }
    $(".log_disabled").on("click", function () {

        $(".output_region").html("");
        $(".output_tools").html("");
        var div = "<h4>Նշեք ամսաթիվը այնուհետև դիտել կոճակը։Ցույց է տալիս ավտոմատ համակարգով անջատված բաժանորդներին</h4><div class='menu_disabled'>\n\
                        <ul>\n\
                            <li><input type='date'  ></li><button class='change_dis'>Որոնել</button>\n\
                        </ul><div class='log_html'></div></div>";
        $(".output_region").html(div);

        $(".change_dis").on("click",function(){
            var date = $(".menu_disabled input").val();
            var json = [];

             $.getJSON("../json/"+date+".json")
                .done(function(json) {
                        print_log(date,json);
                    }).fail(function() {
                    alert('Չկա տվյալ ամսաթվով');
                });
        });
        function print_log(date,json){

           var div = "<div class='menu_disableds'>\n\
                        <ul><li><a id='today'>Ընդանուր</a></li>\n\
                            <li><a id='no_credit'>Առանց կրեդիտ</a></li>\n\
                            <li><a id='credit'>Կրեդիտով</a></li>\n\
                            <li><a id='credit_default'>Հիմնական կրեդիտով</a></li>\n\
                        </ul><div class='output_clients'></div><div class='output_client'></div></div>";
            $(".log_html").html(div);
            $(".output_client").html("");
            $(".output_clients").html(" ");



            $(".menu_disableds a").on("click", function (e) {
                $.getJSON("../json/"+date+"counter.json", function (datas) {

                   var conuter = datas;
                   var attr = e.target.id;
                   $(".output_client").html(" ");
                   $(".output_clients").html(" ");
                    var output = "";
                    if (attr != "today") {
                        var all_size = Object.size(json[attr]);
                        output += "<div> քանակը " + all_size + "<button class='see_client'>Դիտել</button></div>";
                        $(".output_clients").html(output);

                        $(".see_client").on("click", function () {
                           var table = '<table><thead><tr><td>username</td><td>պարտք</td><td>Կրեդիտ</td><td>Վճարման օր</td><td>Կատեգորիա</td></thead><tbody>';
                            $.each(json[attr], function (key, value) {
                                  if(attr == "no_credit"){
                                       var  count = 0;
                                    }else if(value.Payment.credit>0){
                                        count = value.Payment.credit
                                    }else if(value.Payment.credit > 0 && value.Payment.counter_credit>0){
                                       count= parseInt(value.Payment.counter_credit) + parseInt(value.Payment.credit);
                                    }else if(value.Payment.credit = 0 && value.Payment.counter_credit>0){
                                       count = parseInt(value.Payment.counter_credit) + parseInt(value.Payment.credit) + parseInt(conuter);
                                    }else {
                                       var count = parseInt(value.Payment.counter_credit) + parseInt(value.Payment.credit) + parseInt(conuter);
                                    }
                                table += "<tr>\n\
                                        <td>" + value.tech.username + "</td>\n\
                                        <td>" + count + "</td>\n\
                                        <td>" + value.Payment.credit + "</td>\n\
                                        <td>" + value.Payment.payday + "</td>\n\
                                        <td>Անջատված</td>\n\
                                    </tr>";

                            });
                            table += "</tbody></table>";
                            $(".output_client").html(table);

                        });
                    }else {
                        var all_size = Object.size(json["no_credit"]) + Object.size(json["credit_default"]) + Object.size(json["credit"]);
                        output += "<div>քանակը " + all_size + "<button class='see_client'>Դիտել</button></div>";
                        $(".output_clients").html(output);

                        $(".see_client").on("click", function () {
                            var table = '<table><thead><tr><td>username</td><td>պարտք</td><td>Կրեդիտ</td><td>Վճարման օր</td><td>Կատեգորիա</td></thead><tbody>';
                            $.each(json, function (key, value) {
                                $.each(value, function (key, value) {

                                    if(value.Payment.no_credit == 1){
                                       var  count = 0;
                                    }else if(value.Payment.credit > 0 && value.Payment.counter_credit>0){
                                        count=parseInt(value.Payment.counter_credit) + parseInt(value.Payment.credit);
                                    }else if(value.Payment.credit = 0 && value.Payment.counter_credit>0){
                                       count = parseInt(value.Payment.counter_credit) + parseInt(value.Payment.credit) + parseInt(conuter);
                                    }else{
                                       var count = parseInt(value.Payment.counter_credit) + parseInt(value.Payment.credit) + parseInt(conuter);
                                    }

                                    table += "<tr>\n\
                                        <td>" + value.tech.username + "</td>\n\
                                        <td>" + count +"</td>\n\
                                        <td>" + value.Payment.credit + "</td>\n\
                                        <td>" + value.Payment.payday + "</td>\n\
                                        <td>Անջատված</td>\n\
                                    </tr>";

                                });
                            });
                            table += "</tbody></table>";
                            $(".output_client").html(table);

                        });
                    }
                });
            });

            Object.size = function (obj) {
                var size = 0, key;
                for (key in obj) {
                    if (obj.hasOwnProperty(key))
                        size++;
                }
                return size;
            };
       }
    });
    $(".client").on("click",function(){
                $(".output_tools").html(" ");
                var value = $(this).attr("data");
                post_client(value);
    });
    function post_client(value){
          $.post("persons_day", {"client": value}, function (data) {
                var obj = $.parseJSON(data);
                all_client(obj,value);
          });
    }
    function post_cleint_category(value,category){
       $.post("persons_day", {"client": value,"category":category}, function (data) {
                    var obj = $.parseJSON(data);
                    all_client(obj,value);
        });
    }
   function all_client(obj,value){
            $(".output_tools").html(" ");
            var a ="";
            var c;
            var b = "";

            if(value == 2){
                var d = "<h4>Ակտիվ բաժանորդների քանակը՝<span style='color:red'>" + obj["0"]["0"]["all_active"] + "</span></h4>"
                    d += "<h4>personal pay ակտիվ բաժանորդներ՝<span style='color:red'>" + obj["0"]["0"]["pers_pay"] + "</span></h4>"
                    d += "<h4>Առանց պարտք ակտիվ բաժանորդներ՝<span style='color:red'>" + obj["0"]["0"]["client_not_credit"] + "</span></h4>"
                    d += "<h4>Կրեդիտով Ակտիվ բաժանորդներ՝<span style='color:red'>" + obj["0"]["0"]["client_credit"] + "</span></h4>"
                var option = "<option value='1'>personal pay ակտիվ բաժանորդներ</option>\n\
                              <option value='2'>Առանց պարտք ակտիվ բաժանորդներ</option>\n\
                              <option value='3'>Կրեդիտով Ակտիվ բաժանորդներ</option>";
            }else if(value==0){
                var d = "<h4>Անջատված բաժանորդների քանակը՝<span style='color:red'>" + obj["0"]["0"]["dis_client"] + "</span></h4>"
                    d += "<h4>old բաժանորդների քանակ՝<span style='color:red'>" + obj["0"]["0"]["old"] + "</span></h4>"
                    d += "<h4>Անջատված personal pay ակտիվ բաժանորդներ՝<span style='color:red'>" + obj["0"]["0"]["pers_pay"] + "</span></h4>"
                    d += "<h4>Առանց պարտք անջատված բաժանորդներ՝<span style='color:red'>" + obj["0"]["0"]["client_not_credit"] + "</span></h4>"
                    d += "<h4>Կրեդիտով անջատված բաժանորդներ՝<span style='color:red'>" + obj["0"]["0"]["client_credit"] + "</span></h4>"
                var option = "<option value='4'>Առանց պարտքի անջատված բաժանորդներ</option>\n\
                              <option value='6'>Պարտք ունեցող անջատված բաժանորդներ</option>\n\
                              <option value='7'>_old բաժանորդներ</option>";
            }
           else if(value==1){
                var d = "<h4>Կասեցված բաժանորդների քանակը՝<span style='color:red'>" + obj["0"]["0"]["dis"] + "</span></h4>"
                option="<option value='8'>Կասեցված բաժանորդներ</option>";
           }
            var k = "<div class='filter'>"+d+"\n\
                        <select >\n\
                         <option value='5'>Նշեք կարգավիճակը</option>";
                k+= option;
                k+="</select><button>Դիտել</button></div>";
           $(".output_region").html(k);
          $(".filter button").click(function(data){
              var page = 0;
              var select_value = $(".filter select").val();
              if(select_value == 5){
                 return alert("Նշեք կարգավիճակը");
              }else{
                 client(value,select_value,page)
              };
          });
   }
   function client(value,select_value,page){
          $.post("persons_day", {"client_category": value,"select_category":select_value,"page":page}, function (data) {
                        all_client_view(data,value,page,select_value);
          });
   }
   function all_client_view(data,value,page,select_value){

          if (data.length !== 2) {
                var table = "";
                var obj = $.parseJSON(data);
                //JSONToCSVConvertor(obj, "Vehicle Report", true);
                var jsonObj = [];
                var pages = obj.count["0"]["0"]["count(*)"];
                pages = parseInt(pages/200);

                var a='';
                for(var d=0;d<=pages;d++){
                     a+="<button class='page_client'data='"+ parseInt(d*200) +"' style='margin-left:1px;'>"+d+"</button>";
                }

                table+= "<div class='output_client' style='margin-top:30px;'><div > \n\
                                \n\
                       </div><button class='exel'>export to exel</button><table id='headerTable'>\n\
                                <thead>\n\
                                    <tr>\n\
                                        <td>Լոգին</td>\n\
                                        <td>Կրեդիտ</td>\n\
                                        <td>Պարտք</td>\n\
                                        <td>Տարիֆ․</td>\n\
                                        <td>Personal pay․</td>\n\
                                        <td>Ակտիվ է միջև</td>\n\
                                        <td>Կարգավիճակ</td>\n\
                                </tr></thead><tbody class='append_client'>";



                $.each(obj.all, function (key, value) {

                    if (value.Payment.category == 0) {
                        value.Payment.category = "Անջատված"
                    } else if (value.Payment.category == 2) {
                        value.Payment.category = "Ակտիվ"
                    } else if (value.Payment.category == 1) {
                        value.Payment.category = "Կասցեված"
                    }
                    if(value.Payment.pers_pay == null){
                        value.Payment.pers_pay='no';
                    }
                    var item = {}
                    item ["username"] = value.tech.username;
                    item ["payday"] = value.Payment.payday;;
                    item ["category"] = value.Payment.category;
                    item ["tarrif"] = value.Service.service_name;
                    table += "<tr><td>" + value.tech.username + "</td>";
                    table += "<td>" + value.Payment.credit + "</td>";
                    table += "<td>" + value.Payment.counter_credit + "</td>";
                    table += "<td>" + value.Service.service_name + "</td>";
                    table += "<td>" + value.Payment.pers_pay + "</td>";
                    table += "<td>" + value.Payment.payday + "</td>";
                    table += "<td>" + value.Payment.category + "</td></tr>\n\
                    ";
                    jsonObj.push(item);

                });
                jsonObj = JSON.stringify(jsonObj);



            $(".exel").remove();

                table += "</tbody></table><tr><div style='height:40px;width:100%'>"+a+"</div></tr></div>";
                $(".output_tools").html(table);
                $(".page_client").click(function(){
                    var page = $(this).attr("data");
                   return client(value,select_value,page);
                });


            $(".exel").on("click", function () {
                fnExcelReport();
            });

        }
       return false;
   }
    function pay_debt(){
         $(".output_tools").html(" ");
         $(".output_client").html();
            $(".output_day").remove();
            var input = "<div class='output_day'style='float:right;margin:40px;height:50px;' ><label>սկիզբ</label><input type ='number'class='day' value='1'></br>\n\
               <label>վերջ</label> <input type ='number'class='day_two' value='10'><button class='search_day'>որոնել</button></div>";
            $(".output_tools ").append(input);
            var day = $(".day").val();
            var day_two = $(".day_two").val();
            $(".output_client").append("<input type='number'>");

            $(".search_day").on("click", function () {
                var day = $(".day").val();
                var day_two = $(".day_two").val();
                post(day, day_two);
            })

            function post(day, day_two) {

                $.post("persons_day", {"pay_debt": day, "day_two": day_two}, function (data) {
                    $(".output_client").append(img);
                    if (data) {
                        $(".img").remove();
                        pay(data);
                    }
                });
            }
            post(day, day_two);
    }
    function pay_history(){
         $(".output_tools").html(" ");
          var d = new Date();

            var month = d.getMonth() + 1;
            var day = d.getDate();

            var output = d.getFullYear() + '-' +
                    (('' + month).length < 2 ? '0' : '') + month + '-' +
                    (('' + day).length < 2 ? '0' : '') + day;
            var input = "<h4>Ընտրեք ամսաթիվը ։Ցույց է տալիս<br>\n\
                                 այն բաժանորդներին ում վճարման օրը <span style='color:red'>նշված ամսաթիվն է</span></h4>\n\
                        <div class='filter_pay' >\n\
                            <input  type='date' style=' width:200px;border:1px solid rgb(1, 160, 226); height: 20px;' value='" + output + "' class='date_payment'>\n\
                            <button class='search_pay'>Որոնել</button>\n\
                        </div>";
            $(".output_region").html(input);
            $(".search_pay").on("click", function () {
            var date = $(".date_payment").val();
                $.post("persons_day", {"date_history": date}, function (data) {
                    call_history(data);

                });
            });
    }
    function  default_credit(){
         $(".output_tools").html(" ");
        var input = "<h4>Ցույց է տալիս <span style='color:red'>հիմնական կրեդիտի օրը </span> </h4>";
        $(".output_region ").html(input);
        $.post("persons_day", {"default_credit": "values"}, function (data) {

            input = "<div class='output_day' ><input value='"+data+"' type='number'><button>Խմբագրել</button></div>";
            $(".output_tools").html(input);
            $(".output_day button").on("click",function(){
                   var r = confirm("Փոփոխում էք հիմնական կրեդիտի օրը?");
                   if(r){
                        var val = $(".output_day input").val();
                        $.post("persons_day", {"change_credit": val}, function (data) {

                            if(data == 1){
                                alert("Փոփոխված է");
                            }else{
                            alert("Փոփոխված չէ");
                        }
                        });
                   }
            });
        });

   }

    function pay_credit_all(){
          $(".output_tools").html(" ");
            var filter = "<h4>Ընտրեք Կարգավիճակը այնուհետև մուտքագրեք օրերի միջակայքը։<br>\n\
                               Ցույց է տալիս այն <span style='color:red'>կրեդիտով և պարտքով բաժանորդներին</span></h4>\n\
                            <div class ='filter'><select >\n\
                                <option value='5'>Կատեգորիա</option>\n\
                                <option value='2'>Ակտիվ</option>\n\
                                <option value='0'>Անջատված </option>\n\
                          </select>";
            filter += "<input class='start_credit'type='number' >\n\
                           <input  class='end_credit' type='number'>\n\
                           <button type='button'class='search'>Որոնել</button></div>";
            $(".output_region ").html(filter);
            $('.search').on("click", function () {
                var values = $(".filter input").map(function () {
                    return $(this).val();
                }).get();
                var category = $(".filter select").val();
                values.push(category);
                $.post("persons_day", {"pay_credit": values}, function (data) {

                    pay(data);
                });
            });

    }
    function pay_credit(){
          $(".output_tools").html(" ");
         $(".output_day").remove();
            var input = "<h4>Մուտքագրեք օրը։ Ցույց է տալիս այդ այն բաժանորդներին ովքեր <br>\n\
                        <span style='color:red'>ունեն կրեդիտ</span> և վճարման օրը գտնվում է աըսօրվանից միջև այդ թվի միջակայքում</h4>\
                    <div class='output_day' >\n\
                            <input type ='number' class='day' >\n\
                            <button class='send_day'>Որոնել</button></div>";
            $(".output_client").remove();
            $(".output_region").html(input);
            $(".send_day").on("click", function () {
            var day = $(".day").val();
            $.post("persons_day", {"day": day}, function (data) {

                    pay(data);
            });
        });
    }
    function pay_not_credit(){
         $(".output_tools").html(" ");

            var input = "<h4>Մուտքագրեք թիվը։ Ցույց է տալիս այդ այն բաժանորդներին ովքեր <br>\n\
                        <span style='color:red'>չունեն կրեդիտ </span> և վճարման օրը գտնվում է աըսօրվանից միջև այդ թվի միջակայքում</h4>\
                    <div class='output_day' >\n\
                        <input type ='number'class='day' >\n\
                        <button class='send_day'>Որոնել</button>\n\
                    </div>";
            $(".output_region ").html(input);
            $(".send_day").on("click", function () {
                var day = $(".day").val();

                $.post("persons_day", {"pay_not_credit": day}, function (data) {

                    pay(data);
                });
            });
    }
    function no_credit(){
         $(".output_tools").html(" ");
            var input = "<h4>Սեխմեք որոնել կոճակը ։ <br>\n\
                        Ցույց է տալիս <span style='color:red'>no-credit բաժանորդներին</span> </h4>\
                    <div class='output_day' >\n\
                        <button class='send_day'>Որոնել</button>\n\
                    </div>";
            $(".output_region ").html(input);
            $(".send_day").on("click", function () {
                $.post("persons_day", {"no_credit": "day"}, function (data) {
                    pay(data);
                });
            });

    }
       function call_history(data) {

            var table = "<div class='output_client'><div >\n\
                        <button class='exel'>export to exel</button>\n\
                        </div><table id='headerTable'>\n\
                                <thead>\n\
                                    <tr>\n\
                                        <td>Լոգին</td>\n\
                                        <td>Գումար</td>\n\
                                        <td>Կատարող</td>\n\
                                        <td>Տարիֆ․</td>\n\
                                        <td>Տիպը</td>\n\
                                        <td>Օր</td>\n\
                                </tr></thead><tbody>";

            if (data.length !== 2) {
                var obj = $.parseJSON(data);
                // JSONToCSVConvertor(obj, "Vehicle Report", true);
                var jsonObj = [];
                var bank_pay = 0;
                var casa = 0;
                $.each(obj, function (key, value) {

                    var item = {}
                    if (value.Transaction.type == 'bank') {
                        bank_pay += parseInt(value.Transaction.balance_change);
                    }
                    if (value.Transaction.type == 'casa') {
                        var a = parseInt(value.Transaction.balance_change);
                        casa += a;
                    }
                    item ["username"] = value.tech.username;
                    item ["tarrif"] = value.service_names.service_name;
                    item ["payment"] = value.Transaction.balance_change;
                    item ["paying_user"] = value.Transaction.paying_user;
                    item ["type"] = value.Transaction.type;
                    item ["created"] = value.Transaction.created;
                    table += "<tr><td>" + value.tech.username + "</td>";
                    table += "<td>" + value.Transaction.balance_change + "</td>";
                    table += "<td>" + value.Transaction.paying_user + "</td>";
                    table += "<td>" + value.service_names.service_name + "</td>";
                    table += "<td>" + value.Transaction.type + "</td>";
                    table += "<td>" + value.Transaction.created + "</td></tr>";
                    jsonObj.push(item);

                });
                jsonObj = JSON.stringify(jsonObj);

                table += "<tr><td colspan='6'>bank: " + bank_pay + "</td></tr><tr><td colspan='6'>casa: " + casa + "</td></tr></tbody></table></div>";

            }
            $(".output_tools table").remove();
            $(".exel").remove();
            $(".output_tools").html(table);
            $(".exel").on("click", function () {
               fnExcelReport();
            });
        }

        function pay(data) {

            $(".output_tools").html(" ");
            var table = "<div class='output_client'><div >\n\
                        <button class='exel'>export to exel</button>\n\
                        </div><table id='headerTable'>\n\
                                <thead>\n\
                                    <tr>\n\
                                        <td>Լոգին</td>\n\
                                        <td>Կրեդիտ</td>\n\
                                        <td>Պարտք</td>\n\
                                        <td>Տարիֆ․</td>\n\
                                        <td>Ակտիվ է միջև</td>\n\
                                        <td>Կարգավիճակ</td>\n\
                                </tr></thead><tbody>";

            if (data.length !== 2) {
                var obj = $.parseJSON(data);
                // JSONToCSVConvertor(obj, "Vehicle Report", true);
                var jsonObj = [];
                $.each(obj, function (key, value) {
                    if (value.Payment.category == 0) {
                        value.Payment.category = "Անջատված"
                    } else if (value.Payment.category == 2) {
                        value.Payment.category = "Ակտիվ"
                    } else if (value.Payment.category == 1) {
                        value.Payment.category = "Կասցեված"
                    }
                    var item = {}
                    item ["username"] = value.tech.username;
                    item ["firstname"] = value.Person.firstname;
                    item ["lastname"] = value.Person.lastname;
                    ;
                    item ["telefon"] = value.Telefon.telefon;
                    item ["tel1"] = value.Telefon.tel1;
                    item ["payday"] = value.Payment.payday;
                    ;
                    item ["category"] = value.Payment.category;
                    item ["tarrif"] = value.Service.service_name;
                    item ["adress"] = value.Adress.city + ' ' + value.Village.village_name + " " + value.Street.street_name + " " + value.Adress.home;
                    table += "<tr><td>" + value.tech.username + "</td>";
                    table += "<td>" + value.Payment.credit + "</td>";
                    table += "<td>" + value.Payment.counter_credit + "</td>";
                    table += "<td>" + value.Service.service_name + "</td>";
                    table += "<td>" + value.Payment.payday + "</td>";
                    table += "<td>" + value.Payment.category + "</td></tr>";
                    jsonObj.push(item);

                });
                jsonObj = JSON.stringify(jsonObj);

                table += "</tbody></table></div>";

            }
            $(".output_tools table").remove();
            $(".exel").remove();
            $(".output_tools").html(table);
            $(".exel").on("click", function () {
                fnExcelReport();
            });
        }
    $(".access_view").on("click",function(){
        view_access();
    });
    function view_access(){
        $(".output_tools").html(" ");
         var obj;

        $.post("access", function (data) {
            obj = $.parseJSON(data);
            var page = [];
            var role = [];
            var perm = [];

            var    div = "<button class='add_role'>Ավելացնել նոր դեր</button><div class='access_view'><table><thead>\n\
                                                    <tr><td>Էջ</td>";
            var i = 0;

                    $.each(obj.roles, function (key, value) {
                        i++;

                        if(role.indexOf(value.user_roles.role) == -1 && value.user_roles.role != null){
                            role.push(value.user_roles.role);
                            div += "<td><div >" + value.user_roles.role + "</div>";
                        }
                    });
                   div+= "</tr> </thead><tr></tbody>";
             var i = 0;
            var count = obj.all*obj.roles;
            $.each(obj.all, function (key, value) {
                 $.each(obj.roles, function (key, values) {
                if(page.indexOf(value.page.page_uniname) == -1 && value.page.page_uniname != null){
                    page.push(value.page.page_uniname);
                    div += "<tr><td><div style='width:120px;height:23px;'>" + value.page.page_uniname + "</div></td>";
                }
                if(value.perm.role === values.user_roles.id){
                    if(value.perm.perm )
                    div+="<td class='perm'> <input data="+values.user_roles.id+" checked alt="+ value.page.id +" type='checkbox'></td>";
                    else
                     div+="<td class='perm'> <input data="+values.user_roles.id+" alt="+ value.page.id +" type='checkbox'></td>";
                 }else if(value.perm.perm == null) {
                    div+="<td class='perm'> <input data="+values.user_roles.id+" alt="+ value.page.id +" type='checkbox'></td>";
                 }
               });
             });

            div += "</tbody></table><button class='save_permi'>save</button>";

            $(".output_region").html(div);
            var values = [];
            $('.save_permi').click(function() {

                inputs = $('.perm input');
                inputs.each(function() {
                    var value = $(this).val();
                    var addmin_id = $(this).attr("data");
                    var page_id = $(this).attr("alt");
                    if( $( this ).attr( 'type' ) === 'checkbox' ) {
                        value = +$(this).is( ':checked' );

                    }
                     values.push(addmin_id,page_id,value);
                });
                add_access(values);
            });
            $(".add_role").on("click",function(){
                var    div = "<div class='edit_view'><button class='close_tarrif'>x</button>";
                div+="<label style='margin-top:50px;'>Անվանում*</label><input type='text'>";
                div+="<button style='float:right;background:rgb(1, 160, 226);'  class='add_role' >Ավարտել</button>";
                div+="</div>";
                personForm(div);
                $(".add_role").on("click",function(){
                    var role = $(".edit_view input").val();
                    if(role.length<3){
                        alert("Լրացրեք դաշտը");
                    }else{
                        $.post("add_access",{"role":role},function(data){

                            alert("Պահպանված է");
                            none();
                            return view_access();
                        });
                    }
                });
                function none(){
                    $(".opacity").css({"height":"0px","width":"0px"});
                        $(".mypage *").removeAttr( "disabled" );
                        $(".personForm").html("");
                }
               $(".close_tarrif").on("click",function(){
                    none();
               });
            })
        });
    }
    function edit_access(obj,id){
        $.each(obj,function(key,value){
            if(value.permission.id==id){
                alert(id);
            }
        });
    }
    function add_access(values){

                $.post('add_access', {'add_access': values}, function (data) {
                        alert("Պահպանված է");
                       return view_access();
                });

    }
    $(".access_add").click(function(){
        var obj;
          $.post('add_access', {'post_page': "values"}, function (data) {
                       if(data){
                           obj = $.parseJSON(data);
                           add_access(obj);
                       }
           });
    });

    $(".black_list").on("click", function () {
        $.post("black_list", {"list": "list"}, function (data) {
            var div = "<div style='color:black'>";
            var obj = jQuery.parseJSON(data);

            $.each(obj, function (key, value) {
                $.each(value, function (key, value) {

                    div += "<a href='/realtimes/search?data_id=" + value.id + "'>" + value.firstname + " " + value.lastname + "</a>";
                });
            });

            div += '</div>';

            $(".output_region").html(div);

        });
    });


    $(".new_tariff").on("click", function () {
         var    div = "<div class='edit_view'><button class='close_tarrif'>x</button>";
                div+="<label>Անվանում*</label><input type='text'>";
                div+="<label>Գին*</label><input type='number' >";
                div+="<label>Արագություն*</label><input type='number'>";
                div+="<button style='float:right'  class='end_edit' >Ավարտել</button>";
                 div+="</div>";
                  personForm(div);
                $(".end_edit").on("click",function(){
                  var values = [];
                    $('.edit_view input').each(function() {
                        values.push($(this).val());
                    });

                    $.post('add_tariff', {'add_tariffs': values}, function (data) {
                        none();
                            return view_tariff();
                    });
                });
                function none(){
                    $(".opacity").css({"height":"0px","width":"0px"});
                        $(".mypage *").removeAttr( "disabled" );
                        $(".personForm").html("");
                }
               $(".close_tarrif").on("click",function(){
                    none();
               });
    });

    $(".view_all_tariff").on("click", function () {
        view_tariff();
    });
    function view_tariff() {
        $.post('add_tariff', {'view_tariff': "a"}, function (data) {

            var output = "<div class='tarrif'><table>\n\
                                <thead>\n\
                                    <tr>\n\
                                        <td>Անվանում</td>\n\
                                        <td>Գին</td>\n\
                                        <td>Արագություն</td>\n\
                                        <td>Բաժանորդների քանակ</td>\n\
                                        <td>Խմբագրել</td>\n\
                                        <td>Ջնջել</td>\n\
                                    </tr>\n\
                                </thead>\n\
                        <tbody>";
            var obj = jQuery.parseJSON(data);

            $.each(obj.serice_name, function (key, value){
                    $.each(obj.count, function (key, values) {
                    if (value.Service_name.id == key ){
                          console.log(values);
                            output += "<tr>\n\
                                            <td style='width:190px;'>" + value.Service_name.service_name + "</td>\n\
                                            <td style='width:150px;'>" + value.Service_name.price + "դրամ</td>\n\
                                            <td style='width:150px;'>" + value.Service_name.speed + "Mb</td>\n\
                                            <td style='width:150px;'><div class='count"+value.Service_name.id+"' style='display:inline'>" + values + "</div></td>\n\
                                            <td><button class='edit_tariff' data='"+value.Service_name.id+"' style='margin-left:45px ;' >Խմբագրել</button></td>\n\
                                            <td><button class='delete_tariff' data='"+value.Service_name.id+"'  style='background:red;color:#fff;margin-left:60px ;'>Ջնջել</button></td>\n\
                                        </tr>";
                        }
                    });
            });
            output += '</tbody></table></div>';
           $(".output_region").html(output);
           $(".output_tools").html("");
            $(".edit_tariff").on("click",function(){
                var id = $(this).attr("data");
                var div = "<div class='edit_view'><button class='close_tarrif'>x</button>";
                var arr = [];
                  $.each(obj.serice_name, function (key, value){
                        if(value.Service_name.id == id){
                            div+="<label>Անվանում*</label><input type='text' value='"+value.Service_name.service_name +"'>";
                            div+="<label>Գին*</label><input type='number' value='"+value.Service_name.price +"'>";
                            div+="<label>Արագություն*</label><input type='number' value='"+value.Service_name.speed +"'>";
                            div+="<button style='float:right' data='"+value.Service_name.id+"' class='end_edit' >Ավարտել</button>";
                            arr.push(value.Service_name.id);
                            arr.push(value.Service_name.service_name);
                            arr.push(value.Service_name.price);
                            arr.push(value.Service_name.speed);
                        }
                  });
                div+="</div>";
                personForm(div);
                $(".close_tarrif").on("click",function(){
                  none();
                });
                function none(){
                      $(".opacity").css({"height":"0px","width":"0px"});
                    $(".mypage *").removeAttr( "disabled" );
                    $(".personForm").html("");
                }
                $(".end_edit").on("click",function(){
                  var values = [];
                    $('.edit_view input').each(function() {
                        values.push($(this).val());
                    });

                    values.push($(this).attr("data"));

                    $.post('add_tariff', {'edit_tariff': values}, function (data) {
                            none();
                            return view_tariff();
                    });
                });
            });
            $(".delete_tariff").on("click", function () {
                var id = $(this).attr("data");
                var count = parseInt($(".count"+id+"").text());
                if(count>0){
                    alert("Դուք չեք կարող ջնջել այդ սակագնային պլանը");
                }else{
                   var r = confirm("Հաստատում էք՞");
                    if(r){
                        $.post('add_tariff', {'delete_id': id}, function (data) {
                            alert("Սակագնային պլանը ջնջված է");
                            return view_tariff();
                        });
                    }
                }
            });
        });
    }

    function personForm(output){

            var height = $(window).height();
            var body_height = $("body").height();
            if (height > body_height) {

            } else {
                height = body_height;
            }

            $(".add_person").css({"display": "block"});
            $(".opacity").css({"display": "block"});
            $(".opacity").css({"width": "100%", "height": "" + height + "", "z-index": "1", "opacity": "0.7", "background": "black", "position": "absolute", "left": "0px", "right": "0px", "top": "0px"});
            $(".personForm").css({"background": "#fff", "position": "fixed",  "z-index": "9999","margin-top":"50px;"});
            return $(".personForm").html(output);

   }
    function add_server() {
        $(".output_region").html("");
        var output = "<li><a class='view_all_server'style='cursor:pointer'>Սեռվերների ցանկ</a></li>\n\
                                 <div><div >";
        output += "<select id='server_region'  style='width:150px;height:28px;border:1px solid #ccc;'><option value='Արմավիր'>Արմավիր</option>\n\
                                                     <option value='Արարատ'>Արարատ</option>\n\
                                                     <option value='Սյունիք'>Սյունիք</option>\n\
                                                     <option value='Վայոց Ձոր'>Վայոց Ձոր</option>\n\
                                                     <option value='Կոտայք'>Կոտայք</option>\n\
                                                     <option value='Գեղարքունիք'>Գեղարքունիք</option>\n\
                                                     <option value='Շիրակ'>Շիրակ</option>\n\
                                                     <option value='Լոռի'>Լոռի</option>\n\
                                                     <option value='Տավուշ'>Տավուշ</option>\n\
                                                     <option value='Արագածոտն'>Արագածոտն</option>\n\
                                             </select>\n\
                         <input id='server_name'type='text' placeholder='Սեռվերի անունը' style='width:160px;height:28px;border:1px solid #ccc;'> \n\
                         <input id='server_ip'type='text' placeholder='Սեռվերի IP' style='width:160px;height:28px;border:1px solid #ccc;'> \n\
                         <button class='add_server' style='width:150px;height:28px;border:1px solid #ccc;'>ավելացնել</button>";
        output += "</div>";

        $(".output_region").html(output);
        $(".view_all_server").on("click", function () {
            $(".output_region").html("");
            add_delete();
        });
        $(".add_server").on("click", function () {
            var add_server = [];
            add_server["0"] = $("#server_region").val();
            add_server["1"] = $("#server_name").val();
            add_server["2"] = $("#server_ip").val();
            if (add_server["0"] && add_server["1"] && add_server["2"]) {
                $.post('add_server', {'add_server': add_server}, function (data) {
                    return add_server();
                });
            }
        });

    }



    $(".view_all_server").on("click", function () {
        $(".output_region").html("");
        add_delete();
    });
    function add_delete() {
        $.post('add_server', {'view_server': "a"}, function (data) {

            var output = "<li><a class='server' href='#'>ավելացնել Սեռվեր</a></li>\n\
                                 <div>";
            var obj = jQuery.parseJSON(data);
            $.each(obj, function (key, value) {
                $.each(value, function (key, value) {
                    output += "  <div class='view_server'>\n\
                                        <input  class='" + value.id + "server_region' style='width:150px;'value='" + value.server_region + "'>\n\
                                        <input class='" + value.id + "server_name' style='width:150px;'value='" + value.server_name + "'>\n\
                                        <input class='" + value.id + "server_ip'style='width:150px;'value='" + value.server_ip + "'>\n\
                                        <button class='delete_server' style='float:right' value='" + value.id + "'>Ջնջել</button>\n\
                                        <button class='edit_server' style='float:right' value='" + value.id + "'>խմբագրել</button></div>";

                });
            });
            output += '</div>';
            $(".output_region").html(output);
            $(".server").on("click", function () {
                add_server();
            });

            $(".delete_server").on("click", function () {
                var txt;
                var r = confirm("դուք ցանկանումեք ջնջել տվյալ սեռվեռը?");
                if (r == true) {
                    var id = $(this).val();
                    $.post('add_server', {'delete_server': id}, function (data) {
                        return add_delete();
                    });
                } else {
                    txt = "You pressed Cancel!";
                }

            });
            $(".edit_server").on("click", function () {
                var id = $(this).val();
                var update_server = [];
                update_server["0"] = $("." + id + "server_region").val();
                update_server["1"] = $("." + id + "server_name").val();
                update_server["2"] = $("." + id + "server_ip").val();
                update_server["3"] = id;

                $.post('add_server', {'edit_server': update_server}, function (data) {
                    return add_delete();
                });
            });
        });
    }


    function add_station() {
        $(".output_region").html("");
        var output = "<div class='station_add'><button class='close_tarrif'>x</button>";
        output += "<div class='new_station' ><select id='Person_C' name='region'  style='width:150px;height:28px;border:1px solid #ccc;'>\n\
                                                <option value='0'>նշեք մարզը</option>\n\
                                                <option value='Արմավիր'>Արմավիր</option>\n\
                                                <option value='Արարատ'>Արարատ</option>\n\
                                                <option value='Սյունիք'>Սյունիք</option>\n\
                                                <option value='Վայոց Ձոր'>Վայոց Ձոր</option>\n\
                                                <option value='Կոտայք'>Կոտայք</option>\n\
                                                <option value='Գեղարքունիք'>Գեղարքունիք</option>\n\
                                                <option value='Շիրակ'>Շիրակ</option>\n\
                                                <option value='Լոռի'>Լոռի</option>\n\
                                                <option value='Տավուշ'>Տավուշ</option>\n\
                                                <option value='Արագածոտն'>Արագածոտն</option>\n\
                                                <option value='Երևան'>Երևան</option>\n\
                                        </select>\n\
                   <input name='village' Autocomplete = 'off' disabled='disabled' placeholder='գյուղը' type='text' class='village'><br>\n\
                     <div class='villagesearchresult' style='position: absolute;margin-left:130px;z-index:1'></div> \n\
                    <input id='station_name'type='text'name='name' placeholder='անվանում' style='width:160px;height:24px;border:1px solid #ccc;'> \n\
                    <input id='station_ip' name='ip'required pattern='^([0-9]{1,3}\.){3}[0-9]{1,3}$' type='text' placeholder='IP' style='width:160px;height:24px;border:1px solid #ccc;'> \n\
                    <input id='station_gps'name='gps'type='gps' placeholder='GPS' style='width:150px;height:24px;border:1px solid #ccc;'>  \n\
                    <div style='position:relative'>\n\
                    <input type='text'name='user'placeholder='Բաժանորդ' autocomplete='off' id='login'  \n\
                        name='text' autocorrect='off' /> <div id='update' class='update-hidden'></div>  \n\
                    <input type='text'name='price' placeholder='վարձավճար' style='width:150px;height:24px;border:1px solid #ccc;'>  \n\
                    <input type='text'name='next_station' class='station' placeholder='հարևան կայան' style='width:150px;height:24px;border:1px solid #ccc;'>  \n\
                    <input type='text'name='property' placeholder='Գույք' style='width:150px;height:24px;border:1px solid #ccc;'>\n\
                    <label>միջանկյալ</label>\n\
                    <input class='rad' type='radio'value ='1' checked name='gender' style='height:28px;border:1px solid #ccc;'> \n\
                     <label>Բաժանորդային</label>\n\
                     <input class='rad' type='radio' value='2' name='gender' style='height:28px;border:1px solid #ccc;'></div> </div>\n\
                    <button class='add_station' style='width:150px;height:28px;border:1px solid #ccc;'>ավելացնել</button>";
        output += "<span class='stations_result' style=''></span></div>";

        personForm(output);
        $(".view_all_station").on("click", function () {
            view_station();
        });
        var k = 0;
        $("#login").on("keyup", function (event) {
            var user = $(this).val();
            if (user.length >= 3) {
                if (event.keyCode == 27) {
                    $('.searchresults').remove();
                    return;// esc
                } else {
                    search_user(user, k, event);
                }
            }
        });

        $("#Person_C").on("change", function () {
            enable_village(this);
        });
        var k = 0;
        $(".village").on("keyup", function (event) {
            village_search(k, event);
        });
        $(".station").on("keyup", function (event) {
            var station = $(this).val();
            if (station.length >= 3) {
                if (event.keyCode == 27) {
                    $('.searchresults').remove();
                    return;// esc
                } else {
                    station_search(station, event, k);
                }
            }
        });
        $(".add_station").on("click", function () {
            var values = $(".new_station input")
                    .map(function () {
                        if ($(this).attr("class") == 'rad') {
                            if ($(this).is(":checked")) {
                                return $(this).val();
                            }
                        } else {
                            return $(this).val();
                        }
                    }).get();
            var station_ragion = $("#Person_C").val();
            values["10"]=station_ragion;
                $.post('add_tariff', {'add_station': values}, function (data) {

                    if (data) {
                        none($(".personForm"));
                        function none(x){
                            $(".opacity").css({"height":"0px","width":"0px"});
                            $(".mypage *").removeAttr( "disabled" );
                            x.html("");
                        }
                        return view_station();
                    } else {
                        alert("կայանը ավելացված չէ!!!");
                    }
                });

        });
    }
   $(".station").on("click",function(){
                add_station();
                    $(".close_tarrif").on("click",function(){
                        none($(".personForm"));
                    });
                function none(x){
                    $(".opacity").css({"height":"0px","width":"0px"});
                    $(".mypage *").removeAttr( "disabled" );
                    x.html("");
                }
    });
    $(".view_all_station").on("click", function () {
        view_station();
    });
    function view_station(regions) {



        var region = "<div class='select_item'>";
        if(region){
              region += "<select class='station_ragion' >\n\
                                                <option value='null'>Նշեք մարզը</option>\n\
                                                <option value='Արմավիր'>Արմավիր</option>\n\
                                                <option value='Արարատ'>Արարատ</option>\n\
                                                <option value='Սյունիք'>Սյունիք</option>\n\
                                                <option value='Վայոց Ձոր'>Վայոց Ձոր</option>\n\
                                                <option value='Կոտայք'>Կոտայք</option>\n\
                                                <option value='Գեղարքունիք'>Գեղարքունիք</option>\n\
                                                <option value='Շիրակ'>Շիրակ</option>\n\
                                                <option value='Լոռի'>Լոռի</option>\n\
                                                <option value='Տավուշ'>Տավուշ</option>\n\
                                                <option value='Արագածոտն'>Արագածոտն</option>\n\
                                                 <option value='Երևան'>Երևան</option>\n\
                                        </select><button>Որոնել</button>";
        region += "</div>";
        }else{
            region += "<select class='station_ragion' >\n\
                                                <option value='"+regions+"'>"+regions+"</option>\n\
                                                <option value='Արմավիր'>Արմավիր</option>\n\
                                                <option value='Արարատ'>Արարատ</option>\n\
                                                <option value='Սյունիք'>Սյունիք</option>\n\
                                                <option value='Վայոց Ձոր'>Վայոց Ձոր</option>\n\
                                                <option value='Կոտայք'>Կոտայք</option>\n\
                                                <option value='Գեղարքունիք'>Գեղարքունիք</option>\n\
                                                <option value='Շիրակ'>Շիրակ</option>\n\
                                                <option value='Լոռի'>Լոռի</option>\n\
                                                <option value='Տավուշ'>Տավուշ</option>\n\
                                                <option value='Արագածոտն'>Արագածոտն</option>\n\
                                                 <option value='Երևան'>Երևան</option>\n\
                                        </select><button>Որոնել</button>";
        region += "</div>";
        }


        $(".output_region").html(region);
        $(".station").on("click", function () {
            add_station();
        });


        $(".select_item button").on("click",function(){
              var value = $(".station_ragion").val();
                if(value!='null'){
               c(value);

               }else
                 alert("նշեք մարզը");
        });


        function none(x){
                    $(".opacity").css({"height":"0px","width":"0px"});
                    $(".mypage *").removeAttr( "disabled" );
                    x.html("");
         }
//        $(".station_ragion").on("change", function () {
//           
//            var value = $(".station_ragion").val();
//            $(".select_item button").on("click",function(){
//                 return  c(value);
//            });
//         });


    }

    function c(regions) {


            var regions = typeof regions !== 'undefined' ?  regions : "Արմավիր";

            $.post('add_tariff', {'view_station': regions}, function (data) {
               if(data != 'null'){
                var output = "<div class='station_output'><table><thaed><tr>\n\
                                        <td>Մարզ</td>\n\
                                        <td>Գյուղ</td>\n\
                                        <td>Անվանում</td>\n\
                                        <td>IP</td>\n\
                                        <td>gps</td>\n\
                                        <td>Բաժանորդ</td>\n\
                                        <td>Վարձավճար</td>\n\
                                        <td>Հարևան կայան</td>\n\
                                        <td>Գույք</td>\n\
                                        <td>Տիպը</td>\n\
                                        <td>Խմբագրել</td>\n\
                                        <td>Ջնջել</td>\n\
                                </tr></thead><tbody>";
                var obj = jQuery.parseJSON(data);
                $.each(obj, function (key, value) {
                        if(value.stations.station_type == 2){
                            value.stations.station_type = "Բաժանորդային";
                        }else if(value.stations.station_type ==1){
                             value.stations.station_type = "Միջանկյալ";
                        }
                        if(!value.village.village_name)
                            value.village.village_name='';
                        if(!value.stations.station_gps)
                            value.stations.station_gps='';
                        if(!value.tech.username)
                            value.tech.username ='';
                        if(!value.stations.station_price)
                            value.stations.station_price='';
                        if(!value.s.station_name)
                            value.s.station_name='';
                        if(!value.stations.station_property)
                            value.stations.station_property='';
                        if(!value.stations.station_type)
                            value.stations.station_type='';
                        output +="<tr style='borde:1px solid #666;font-size;15px;'>\n\
                                            <td>"+value.stations.station_region+"</td>\n\
                                                <td>"+value.village.village_name+"</td>\n\
                                                <td>"+value.stations.station_name+"</td>\n\
                                                <td>"+value.stations.station_ip+"</td>\n\
                                                <td>"+value.stations.station_gps+"</td>\n\
                                                <td>"+value.tech.username+"</td>\n\
                                                <td>"+value.stations.station_price+"</td>\n\
                                                <td>"+value.s.station_name+"</td>\n\
                                                <td>"+value.stations.station_property+"</td>\n\
                                                <td>"+value.stations.station_type+"</td>\n\
                                                <td>   <button class='edit_station'   data=" + value.stations.id + ">խմբագրել</button></div></td> \n\
                                                <td>  <button class='delete_station'style='background:red' alt='"+ value.stations.station_region + "'  data=" + value.stations.id + ">Ջնջել</button></td></tr>";


                });
                output += '</tbody></table></div>';
                $(".output_tools").html(output);
                  $(".delete_station").on("click", function () {

                       var txt;
                       var r = confirm("դուք ցանկանումեք ջնջել տվյալ կայանը?");
                       if (r === true) {
                           var id = $(this).attr("data");
                           var station_region = $(this).attr("alt");

                           $.post('add_tariff', {'delete_station': id}, function (data) {
                                 c(station_region);
                           });
                       } else {
                           txt = "You pressed Cancel!";
                       }
                });
                $(".edit_station").on("click", function () {
                    var id = $(this).attr("data");

                    $.each(obj, function (key, value) {

                    if(value.stations.id == id ){
                        var output = "<div class='station_add'>";
                        output += "<button class='close' style='float:right;color:#fff;background:red;font-weight:bold;border:none;'>x</button><div class='edit_station' ><select id='Person_C' name='region'  style='width:150px;height:28px;border:1px solid #ccc;'>\n\
                                                    <option value="+value.stations.station_region+">"+value.stations.station_region+"</option>\n\
                                                    <option value='Արմավիր'>Արմավիր</option>\n\
                                                    <option value='Արարատ'>Արարատ</option>\n\
                                                    <option value='Սյունիք'>Սյունիք</option>\n\
                                                    <option value='Վայոց Ձոր'>Վայոց Ձոր</option>\n\
                                                    <option value='Կոտայք'>Կոտայք</option>\n\
                                                    <option value='Գեղարքունիք'>Գեղարքունիք</option>\n\
                                                    <option value='Շիրակ'>Շիրակ</option>\n\
                                                    <option value='Լոռի'>Լոռի</option>\n\
                                                    <option value='Տավուշ'>Տավուշ</option>\n\
                                                    <option value='Արագածոտն'>Արագածոտն</option>\n\
                                                    <option value='Երևան'>Երևան</option>\n\
                                            </select>\n\
                       <input name='village' Autocomplete = 'off' value='"+value.village.village_name+"' disabled='disabled' placeholder='գյուղ' type='text' class='village'><br>\n\
                         <div class='villagesearchresult' style='position: absolute;margin-left:130px;z-index:1'></div> \n\
                        <input id='station_name'type='text'name='name'value='"+value.stations.station_name+"' placeholder='անվանում' style='width:160px;height:24px;border:1px solid #ccc;'> \n\
                        <input id='station_ip' value='"+value.stations.station_ip+"' name='ip' required pattern='^([0-9]{1,3}\.){3}[0-9]{1,3}$' type='text' placeholder='IP' style='width:160px;height:24px;border:1px solid #ccc;'> \n\
                        <input id='station_gps' name='gps' value='"+value.stations.station_gps+"' \n\
                                 placeholder='GPS' style='width:150px;height:24px;border:1px solid #ccc;'>  \n\
                        <div style='position:relative'>\n\
                        <input type='text'name='user'value='"+value.tech.username+"' placeholder='Բաժանորդ' autocomplete='off' id='login'  \n\
                            name='text' autocorrect='off' /> <div id='update' class='update-hidden'></div>  \n\
                        <input type='text'name='price'value='"+value.stations.station_price+"' placeholder='վարձավճար' style='width:150px;height:24px;border:1px solid #ccc;'>  \n\
                        <input type='text'name='next_station' value='"+value.s.station_name+"' class='station' placeholder='Հարևան կայան' style='width:150px;height:24px;border:1px solid #ccc;'>  \n\
                        <input type='text'name='property'value='"+value.stations.station_property+"' placeholder='Գույք' style='width:150px;height:24px;border:1px solid #ccc;'>\n\
                        <label>միջանկյալ</label>";

                        if(value.stations.station_type=="Բաժանորդային"){

                            output+="<input class='rad' type='radio' value ='1'  name='gender' style='height:28px;border:1px solid #ccc;'> \n\
                            <label>Բաժանորդային</label>\n\
                            <input class='rad' type='radio' value='2'checked name='gender' style='height:28px;border:1px solid #ccc;'></div> </div>\n\
                            <button class='add_station' style='width:150px;height:28px;border:1px solid #ccc;'>Խմբագրել</button>";
                            output += "<span class='stations_result' style=''></span></div>";
                        }else{
                            output+="<input class='rad' type='radio'value ='1' checked name='gender' style='height:28px;border:1px solid #ccc;'> \n\
                            <label>Բաժանորդային</label>\n\
                            <input class='rad' type='radio' value='2' name='gender' style='height:28px;border:1px solid #ccc;'></div> </div>\n\
                            <button class='add_station' style='width:150px;height:28px;border:1px solid #ccc;'>Խմբագրել</button>";
                            output += "<span class='stations_result' style=''></span></div>" ;
                        }


                        var height = $(window).height();
                        var body_height = $("body").height();
                            if (height > body_height) {

                            } else {
                                height = body_height;
                            }

                            $(".add_person").css({"display": "block"});
                            $(".opacity").css({"display": "block"});
                            $(".opacity").css({"width": "100%", "height": "" + height + "", "z-index": "1", "opacity": "0.7", "background": "black", "position": "absolute", "left": "0px", "right": "0px", "top": "0px"});
                            $(".personForm").css({"background": "#fff", "position": "fixed",  "z-index": "9999","margin-top":"50px;"});
                            $(".personForm").html(output);

                        }
                    });
                    $(".view_all_station").on("click", function () {
                        view_station();
                    });
                    $(".close").click(function(){
                        none($(".personForm"));
                    });
                    var k = 0;
                    $("#login").on("keyup", function (event) {
                        var user = $(this).val();
                        if (user.length >= 3) {
                            if (event.keyCode == 27) {
                                $('.searchresults').remove();
                                return;// esc
                            } else {
                                search_user(user, k, event);
                            }
                        }
                    });

                    $("#Person_C").on("change", function () {

                        enable_village(this);
                    });
                    var k = 0;
                    $(".village").on("keyup", function (event) {
                        village_search(k, event);
                    });
                    $(".station").on("keyup", function (event) {
                        var station = $(this).val();
                        if (station.length >= 3) {
                            if (event.keyCode == 27) {
                                $('.searchresults').remove();
                                return;// esc
                            } else {

                                station_search(station, event, k);
                            }
                        }
                    });
                    $(".add_station").on("click", function () {
                        var values = $(".edit_station input")
                                .map(function () {
                                    if ($(this).attr("class") == 'rad') {
                                        if ($(this).is(":checked")) {
                                            return $(this).val();
                                        }
                                    } else {
                                        return $(this).val();
                                    }
                         }).get();
                        var station_ragion = $("#Person_C").val();
                        values["10"]=station_ragion;
                        values["11"]=id;

                        $.post('add_tariff', {'add_station': values}, function (data) {

                            if (data) {
                             c(station_ragion);
                                none($(".personForm"));
                            } else {
                                alert("ավելացված չէ!!!");
                            }
                        });

                    });
                       function none(x){
                    $(".opacity").css({"height":"0px","width":"0px"});
                    $(".mypage *").removeAttr( "disabled" );
                    x.html("");
         }
                });
                return false;
            }else{
                $(".output_tools").html("Կայան չկա");
            }
            });

        }

});

function fnExcelReport()
{
    var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
    var textRange; var j=0;
    tab = document.getElementById('headerTable'); // id of table

    for(j = 0 ; j < tab.rows.length ; j++)
    {
        tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
        //tab_text=tab_text+"</tr>";
    }

    tab_text=tab_text+"</table>";
    tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
    tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
    {
        txtArea1.document.open("txt/html","replace");
        txtArea1.document.write(tab_text);
        txtArea1.document.close();
        txtArea1.focus();
        sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
    }
    else                 //other browser not tested on IE 11
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));

    return (sa);
}
function JSONToCSVConvertor(JSONData, ReportTitle, ShowLabel) {
    //If JSONData is not an object then JSON.parse will parse the JSON string in an Object
    var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;

    var CSV = '';
    //Set Report title in first row or line

    CSV += ReportTitle + '\r\n\n';

    //This condition will generate the Label/Header
    if (ShowLabel) {
        var row = "";

        //This loop will extract the label from 1st index of on array
        for (var index in arrData[0]) {

            //Now convert each value to string and comma-seprated
            row += index + ',';
        }

        row = row.slice(0, -1);

        //append Label row with line break
        CSV += row + '\r\n';
    }

    //1st loop is to extract each row
    for (var i = 0; i < arrData.length; i++) {
        var row = "";

        //2nd loop will extract each column and convert it in string comma-seprated
        for (var index in arrData[i]) {
            row += '"' + arrData[i][index] + '",';
        }

        row.slice(0, row.length - 1);

        //add a line break after each row
        CSV += row + '\r\n';
    }

    if (CSV == '') {
        alert("Invalid data");
        return;
    }

    //Generate a file name
    var fileName = "MyReport_";
    //this will remove the blank-spaces from the title and replace it with an underscore
    fileName += ReportTitle.replace(/ /g, "_");

    var data = CSV;

// add UTF-8 BOM to beginning so excel doesn't get confused.
// *THIS IS THE KEY*
    var BOM = String.fromCharCode(0xFEFF);
    data = BOM + data;

    var btn = document.createElement("button");
    btn.appendChild(document.createTextNode("export to exel"));

    var blob = new Blob([data], {type: "text/csv;charset='UTF-8' "});
    if (window.navigator && window.navigator.msSaveOrOpenBlob) {

        // ie
        var success = window.navigator.msSaveOrOpenBlob(blob, "resume.csv");
        if (!success) {
            alert("Failed");
        }
    } else {

        // not ie
        var a = document.createElement("a");
        a.href = window.URL.createObjectURL(blob);
        a.download = "resume.csv";
        document.body.appendChild(a);
        a.click();

        // is there a problem with removing this from the DOM already?
        a.parentNode.removeChild(a);
    }

    document.body.appendChild(btn);
}