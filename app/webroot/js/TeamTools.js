$(document).on("ready", function () {
    
    var click = [];
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
    today = yyyy + '-' + mm + '-' + dd;
 
    var divTeamUser = "<select id='team_login' class='station_ragion'><option selected='false' value='1' >անձնակազմ</option>";
   
    $(".teamToolslogin").on("click", function () {
        
         $(".output_tools").html(' ');
        
        var date = [];
        var select = "<input type='date' id='firstDate' min='2015-01-01' style='width:160px;height:20px;border:1px' value='" + today + "'/>\n\
                        <input type='date' id='lastDate' min='2015-01-01' style='width:160px;height:20px;border:1px' value='" + today + "'/>\n\
                        <span class='select_teams'></span>\n\
                        <span class='count'>0</span><span class='select_item'>  <button>Որոնել</button></span>\n\
                        ";
     
        //miacnel people  table con_perosn@ vercnel :) 
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
        $(".output_region button").on("click",function(){
           var date = [];
            date["1"] = $("#firstDate").val();
            date["2"] = $("#lastDate").val();
           
            date["3"] = $("#team_login").val();
            obj = post_date(date);
        });
    });

    function post_date(x) {
        
           $(".view_tools").css({"background":"#fff","position":"relative"});
          var img = "<img style='z-indez:9999;position:absolute;left:40%;top:20%;width;100px;height:100px;'src='../img/loader1.gif'>";
              $(".output_tools").html(img);
             
        $.post("TeamTools", {"date": x}, function (data) {
             
            if(data){
             
                 $(".view_tools").css({"background":"#FFF","opacity":1});
                 $(".output_tools").html(' ');
                 obj = $.parseJSON(data); 
                   if(obj)
                    print_data(obj, x);
                
            }
        });
    }

    function print_data(obj, date, username) {
        var array = [];
        var change;
        var search;
        var team_serarch;
        var table = "<table><thead ><tr >\n\
                <td <div class='logins'>Լոգին</div></td><td><div class='logins'>միացում կատարող</div>\n\
                </td><td><div  class='logins'>ամսաթիվ</td></div><td><div >դիտել ավելին</div></td></tr></thead>";
        
        var i = 0;
      
        $.each(obj.tech, function (key, value) {
            
            search = array.indexOf(value.Technical_data.username);

            team_serarch = array1.indexOf(value.person.con_person);
          

                if (search === -1 && !username) {
                    if (value.estate.team_user === null )
                        value.estate.team_user = "գրանցված չէ։";
                    table += "<tbody><tr><td>" + value.Technical_data.username + "</td>\n\
                                    <td>" + value.estate.team_user + "</td>\n\
                                    <td>" + value.Technical_data.created + "</td>\n\
                                    <td><button class='edit_logins' value='" + value.Technical_data.id + "' style='margin:0px auto;color: rgb(255, 255, 255); \n\
                                        background: rgb(1, 160, 226);border:none;margin-left:50px;\n\
                                        border-radius:50%;cursor:pointer;font-weight:bold'>...</button></td>\n\
                            </tr>\n\
                             </tr>\n\
                                <td  colspan='5'><div class='append' id='append" + value.Technical_data.id + "'></div></td>\n\
                             <tr>\n\
                            </tbody>";
                    i++;
                } else if (search === -1 && value.estate.team_user === username) {
                    if (value.estate.team_user === null )
                        value.estate.team_user = "գրանցված չէ։";
                    table += "<tbody><tr><td>" + value.Technical_data.username + "</td>\n\
                                    <td>" + value.estate.team_user + "</td>\n\
                                    <td>" + value.Technical_data.created + "</td>\n\
                                    <td><button class='edit_logins' value='" + value.Technical_data.id + "' style='margin:0px auto;color: rgb(255, 255, 255); \n\
                                        background: rgb(1, 160, 226);border:none;margin-left:50px;\n\
                                        border-radius:50%;cursor:pointer;font-weight:bold'>...</button></td>\n\
                            </tr>\n\
                             </tr>\n\
                                <td  colspan='5'><div class='append' id='append" + value.Technical_data.id + "'></div></td>\n\
                             <tr>\n\
                            </tbody>";
                    i++;
                }
                array.push(value.Technical_data.username);

            
        });

        table += "</table>";

        $(".output_tools").html(table);

        $(".count").html(i);
       
        $(".edit_logins").on("click", function () {
            $(".append").html(' ');
            var user_id = $(this).val();
            var f = click.indexOf(user_id);
          
            if(f ===-1){
                 click.push(user_id);
                 change = 1;
            }else{
                 click = [];
                 change=null;
                   $("#append" + user_id + "").html(' ');
            }
            if(change !== null){
            var table1 = "<table><thead><tr><td><div class='logins_estate'>գրանցող</div></td><td><div class='logins_estate'>ապրանքի անուն</div></td><td><div class='logins_estate'>տեսակ</div>\n\
                    </td><td><div class='logins_estate'>քանակ</div></td><td><div class='logins_estate'>ամսաթիվ</div></td></tr></thead>";
            $.each(obj.tech, function (key, value) {
                if (value.estate.user_id === user_id) {

                    if (value.estate.auth_user === null)
                        value.estate.auth_user = "Anush";
                    table1 += "<tbody>  \n\
                                            <tr style='color:red'> \n\
                                                <td>" + value.estate.auth_user + "</td>\n\
                                                <td>" + value.prod_name.product_name + "</td>\n\
                                                <td>" + value.estate.species + "</td>\n\
                                                <td>" + value.estate.quantity + "</td>\n\
                                                <td>" + value.estate.created + "</td>\n\
                                            </tr>\n\
                                        </tbody>";
                }
            });
            table1 += "</table>";
            $("#append" + user_id + "").html(table1);
        }else{
           
        }
        });
    
    }
});