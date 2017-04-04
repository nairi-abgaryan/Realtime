$(document).on("ready",function(){
    
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!
    var obj = null;
    var yyyy = today.getFullYear();
    if (dd < 10) {
        dd = '0' + dd;
    }
    if (mm < 10) {
        mm = '0' + mm;
    }
    var array1 = [];
    var array2 = [];
    var team_name;
    today = yyyy + '-' + mm + '-' + dd;
  
     var divTeamUser = "<select class='selects' id='team_login'><option selected='true' value='1' >անձնակազմ</option>";
   
     var select_prod_name = "<select id='select_prod_name' class='selects'><option selected='true' value='1' >ապրանքի անուն</option>";
    $(".Tools_wareHouse").on("click",function(){
        var date = [];
           $(".output_tools").html(' ');
        var select = "<input type='date' id='firstDate' min='2015-01-01' style='width:160px;height:20px;border:1px' value='" + today + "'/>\n\
                        <input type='date' id='lastDate' min='2015-01-01' style='width:160px;height:20px;border:1px' value='" + today + "'/>\n\
                        <span class='select_teams'></span>  \n\
                         <span class='prod_names'></span>  <button>Որոնել</button>  \n\
                        ";
         $(".output_region").html(select);
        if(array1.length == 0){
            $.post("TeamTools",{"all_team":"all_team"},function(team){
                    var team_obj = $.parseJSON(team);

                     $.each(team_obj, function (key, values) {
                                divTeamUser += "<option>" + values.Team.username + "</option>";
                                array1.push(values.Team.username);
                     });
                    $(".select_teams").html(divTeamUser);
            });
        } else{
            $(".select_teams").html(divTeamUser);
        }
         if(array2.length == 0){
               $.post("Tools_ware",{"prod":"prod"},function(prod){
                var prod_name = $.parseJSON(prod);
                $.each(prod_name, function (key, values) {
                        select_prod_name += "<option>" + values.Product_name.product_name + "</option>";
                        array2.push(select_prod_name);
                });

                $(".prod_names").html(select_prod_name);
            });
        }else{
            $(".prod_names").html(select_prod_name);
        }
       
        $(".output_region button").on("click",function(){
            var date = [];
             date["1"] = $("#firstDate").val();
             date["2"] = $("#lastDate").val();
              date["3"] = $("#team_login").val();
              date["4"] = $("#select_prod_name").val();
             obj = post_date(date);
         });
    });
    function post_date(x,username,prod_name) {
          $(".view_tools").css({"background":"#fff","position":"relative"});
          var img = "<img style='z-indez:9999;position:absolute;left:40%;top:20%;width;100px;height:100px;'src='../img/loader1.gif'>";
                $(".output_tools").html(img);
       
        $.post("Tools_ware", {"date": x}, function (data) {
             
            if(data){
                $(".view_tools").css({"background":"#FFF","opacity":1});
              
                obj = $.parseJSON(data);
                print_data(obj,x);
            }
        });
        
    }
    function print_data(obj, date, username,prod_name) {
        var array = [];

        var search;
        var team_serarch;
        var prod_serarch;
      
        var table = "<table><thead><tr><td><div class='tools_ware'>գրանցող</div></td><td><div class='tools_ware'>անուն</div></td><td><div class='tools_ware'>տեսակ</div>\n\
                    </td><td><div class='tools_ware'>քանակ</div></td><td><div class='tools_ware'>Աշխատող</div></td><td><div class='tools_ware'>ամսաթիվ</div></td></tr></thead>";
         $.each(obj.logs, function (key, value) {
                 
                         if(value.written_log.auth_user === null )
                             value.written_log.auth_user ="Anush";
                         var username1 = (typeof value.written_log.username1 == 'string')?(value.written_log.username1+"ը փոխանցել է "+value.written_log.username+' ին') :value.written_log.username;
                               
                              table += "<tbody>  \n\
                                            <tr > \n\
                                                <td>" + value.written_log.auth_user + "</td>\n\
                                                <td>" + value.written_log.product_name + "</td>\n\
                                                <td>" + value.written_log.species + "</td>\n\
                                                <td>" + value.written_log.quantity + "</td>\n\
                                                <td>" + username1 +"</td>\n\
                                                <td>" + value.written_log.created + "</td>\n\
                                            </tr>\n\
                                        </tbody>";
             });
            table += "</table>";
            $(".output_tools").html(table);
        var i = 0;
        return;
    }
});