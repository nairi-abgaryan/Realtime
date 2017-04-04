var pathName = location.pathname;
var team_obj;
$(document).ready(function () {
    $.post("TeamTools", {"all_team": "all_team"}, {async:false}, function (team) {
        team_obj = $.parseJSON(team);
    });

    $(".edit_conn_problem_list").on("click",function(){
        var id = $(this).attr("value");
        var comm = $(".comm_team"+id+"").text();
        
        var val = tamplate_edit(comm);
        
        $(".add_prob").on("click", function () {
               
                val = $(".edit_p").val();
             
                $.post('/realtimes/clientpage', {'comment_team': val," person_id_team":id}, function (data) {
                    
                    $(".comm_team"+id+"").html(val);
                   none($(".archives"));
                });
        });
        return;
    });
    setInterval(function () {
        $.post("auth", {"CAKEPHP": "CAKEPHP"}, function (data) {
           
        });
    }, 100000);
   
      
    function none(x) { 
        $(".opacity").css({"height": "0px", "width": "0px"});
        $(".mypage *").removeAttr("disabled");
       
        x.html("");
    }

    $('.search_problem').keyup(function (e) {
        if (e.keyCode === 13){
          
           $('#click_problem').click();
        }
    });
    $('.search_problemtop').keyup(function (e) {
        if (e.keyCode === 13){
           
           $('#click_serarch_problem').click();
        }
    });
    
    $('.search_con_conn').keyup(function (e) {
        if (e.keyCode === 13){
           
           $('#search_con_conn').click();
        }
    });
    $('.search_conc').keyup(function (e) {
        if (e.keyCode === 13){
           $('#click_serarchc').click();
        }
    });
   
    function cursor() {
        var el = $("#search").get(0);
        var elemLen = el.value.length;
        el.selectionStart = elemLen;
        el.selectionEnd = elemLen;
        el.focus();
    }
    $("#TeamPosition").on('change', function admin() {
        var value = $("#TeamPosition").val();
        if (value == 0) {
            var password = prompt("your password");
         
            if (password == "admin") {
                return true;
            }
            else {
                location.reload();
            }
        }
    });
    $("#print").on("click", function () {
        var divContents = $(".ClientResults").html();
        var printWindow = window.open('', '', 'height=400,width=800');
        printWindow.document.write('<html><head><title>DIV Contents</title>');
        printWindow.document.write('</head><body >');
        printWindow.document.write(divContents);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    });

    if (location.href == "http://192.168.252.22/Realtime/") {
        $('html').keydown(function (e) {

            if (e.which === 13) {
                $('#signup').click();
                return false;    //<---- Add this line
            }
        });
    }
    if (location.href == "/Realtime/realtimes/problems")
    {
        $('#problem').css({'background': '#01a0e2', 'color': '#fff'});

    }
  
    if (location.href == "/Realtime/realtimes/search")
    {

        $('#SearchPage').css({'background': '#01a0e2', 'color': '#fff'});
    }
    if (location.href == "/Realtime/realtimes/connectors")
    {
        cursor();
        $('#connectors').css({'background': '#01a0e2', 'color': '#fff'});
    }

    var url = window.location.href;

    if (url.indexOf("search") !== -1) {
        $('#SearchPage').css({'background': '#01a0e2', 'color': '#fff'});
    }
    if (url.indexOf("problems") !== -1) {
        $('#problem').css({'background': '#01a0e2', 'color': '#fff'});
    }
    if (url.indexOf("connectors") !== -1) {
        $('#connectors').css({'background': '#01a0e2', 'color': '#fff'});
    }
    if (url.indexOf("connectors") !== -1) {
        $('#connectors').css({'background': '#01a0e2', 'color': '#fff'});
    }
    if (url.indexOf("manegement") !== -1) {
        $('#manegement').css({'background': '#01a0e2', 'color': '#fff'});
    }
    if (url.indexOf("connectors") !== -1) {
        $('#connectors').css({'background': '#01a0e2', 'color': '#fff'});
    }
    $('.addClientLink').on('click', function () {
        load_add();
    });
    function load_add(){
          var height = $(window).height();
        var body_height = $("body").height();
        if (height > body_height) {

        } else {
            height = body_height;
        }
        $(".opacity").css({"width": "100%", "height": "" + height + "", "z-index": "1", "opacity": "0.7", "background": "black", "position": "absolute", "left": "0px", "right": "0px", "top": "0px"});

        $('.personForm').css({"display": "block", "position": "fixed", "min-height": "200px", "width": "850px", "z-index": "9999", "background": "#fff"});
        $(".mypage *").attr("disabled", "disabled").off('click');
        $('.personForm').load('/realtimes/add');
    }
    $(".closeadding").on("click", function () {
        none($('.personForm'));
    });
  
    $(".category").on("click", function () {
        var value = $(".category").val();
        if (value == 0) {
            var input = "<input type='text' name='data[Person][company_name]' required placeholder='company_name'>\n\
                                        <select name='data[Person][type]'>\n\
                                                <option value='ՍՊԸ'>ՍՊԸ</option>\n\
                                                <option value='ՓԲԸ'>ՓԲԸ</option>\n\
                                                <option value='ՊՕԱԿ'>ՊՕԱԿ</option>\n\
                                                <option value='ԲԲԸ'>ԲԲԸ</option>\n\
                                                <option value='ՀԿ'>ՀԿ</option>\n\
                                                <option value='ԱՁ'>ԱՁ</option>\n\
                                        </select>";
            $(".company").html(input);
        }
        if (value == 1) {
            $(".company input").css({"display": "none"});
            $(".company select").css({"display": "none"});
        }
    });
    function cre_person(id,data,pers) {
        //var value = $( this ).val();
      
     
        
        $.post('/realtimes/clientpage', {'deletes': id,"person":data}, function (data) {
           
            $("#con_persons" + id + "").css({"display": "block"});
            $("#endConnection" + id + "").css({"display": "none"});
            $("#endCon_history" + id + "").css({"display": "none"});
            
        });
    }
   
    $(".delete").on("click", function () {
        var con_id = $(this).val();
        var data = $(this).attr("data");
        var pers = $(this).attr("alt");
        $(this).parent().remove();
        cre_person(con_id,data,pers);
    });
    $(".con_persons").on("click", function () {
        var id = $(this).val();
       
        var value = $("#con_person" + id + "").val();
        if(value){
            $.post('/realtimes/clientpage', {'update_con': value, "id": id}, function (data) {
       
                if (data !=0  ) {

                    var value = $("#con_person" + id + "").val();
                    var div = 
                      "<div id='con_p"+value+id+"' style='font-size:13px;font-weight: bold;''> "+value+"\n\
                            <button data='"+data+"' alt='"+value+"' class='delete' style='font-weight: bold;color:#fff;width:20px;background: red;position: absolute;right: 6px;' value='"+id+"'>\n\
                                x</button>\n\
                        </div>";
                    $("#cre_persons" +id + "").append(div);
                    $("#endConnection" + id + "").css({"display": "block"});
                    $("#endCon_history" + id + "").css({"display": "block"});
                    $(".delete").on('click', function () {
                        var deleted_id = $(this).val();
                          $(this).parent().remove();
                        var con_id = $(this).val();
                        var datas = $(this).attr("data");
                        var pers = $(this).attr("alt");

                        cre_person(con_id,datas,pers);
                        $("#con_persons" + deleted_id + "").css({"display:block;background": "/img/loader.gif"});
                    });
                }else{

                }
            });
        }else{
            alert("նշեք կատարողին");
        }

    });
    $(".no_active").on("click",function(){
          var value = $(this).val();
           var  parent_tr = $(this).closest("tr");
            var height = $(window).height();
            var body_height = $("body").height();
            var  parent_tr = $(this).closest("tr");
            if (height > body_height) {

            } else {
                height = body_height;
            }
            var data =  $(this).attr("data");
            $(".opacity").css({"display":"block","width": "100%", "height": "" + height + "", "z-index": "1", "opacity": "0.7", "background": "black", "position": "absolute", "left": "0px", "right": "0px", "top": "0px"});

            $(".cre_person").css({"background": "#fff"});
            var value = $(this).val();

            var input = "<div style='left:40%;text-align:center;width:450px;background:#fff;position:fixed;height:160px;'>\n\
                                        <button class='close_p' style='z-index:9999;position:absolute;right:1px;background:red;font-weight:bold;border:none;color:#fff;'>x</button>  \n\
                                    <label style='position:relative;left:10px;top:10px;display: block;color:#01a0e2;font-weight: bold;text-align:left'>Մեկնաբանություն</label>\n\
                                   <textarea type='text'style='position:relative;left:-4px;top:15px;z-index:99999;width:400px;height:70px;background:#FFF;' class='pro_solution'></textarea>\n\
                                      \n\
                                <button data='' class='end_problem' value='" + value + "' style='  border: none;position: absolute;right: 1px;border-radius: 5px; z-index: 9999; bottom: 2px;color: #fff;background: #009c44;width:100px;'>Ավարտել</button></div>\n\ ";
            $(".archives").css({"display": "block"});

            $(".archives").html(input);
            $(".close_p").on("click", function () {
                  console.log(event);
                none($(".archives"));
              
            });
//          
            $(".archive").css({"z-index": "9999", "position": "relative"});
            $(".end_problem").on("click", function (event) {
            var value = [];
                value["0"] = $(".pro_solution").val();
                value["1"] = $(this).val();

                if(!data){
                    data = 0;
                }
               
                    $.post("clientpage",{"no_active":value},function(data){

                            if(data){
                               parent_tr.remove();
                                 none($(".archives"));
                                 $(document).on("keyup",function(event){

                                });
                            }
                    });
            });
         
        
          
    });
    $(".ok_problem").on("click",function(){
        var answer = confirm("Հաստատում էք?");
	if (answer){
            var data =  $(this).attr("data");
            var  parent_tr = $(this).closest("tr");
            var value = $(this).val();
        
            $.post('clientpage', {'ok_problem': value}, function (data) {
                
               
                if(data){
                    $(".opacity").css({"display":"none"});
                    $(".archives").html("");
                     parent_tr.remove();
                 }
            });
           
	}
	else{
		
	}
    });
    $(".end_problems").on("click", function (event) {

        var height = $(window).height();
        var body_height = $("body").height();
        var  parent_tr = $(this).closest("tr");
        if (height > body_height) {

        } else {
            height = body_height;
        }
        var data =  $(this).attr("data");
        $(".opacity").css({"display":"block","width": "150%", "height": "" + height + "", "z-index": "1", "opacity": "0.7", "background": "black", "position": "absolute", "left": "0px", "right": "0px", "top": "0px"});

        $(".cre_person").css({"background": "#fff"});
        var value = $(this).val();
     
        var input = "<div style='left:40%;text-align:center;width:450px;background:#fff;position:fixed;height:160px;'>\n\
                                    <button class='close_p' style='z-index:9999;position:absolute;right:1px;background:red;font-weight:bold;border:none;color:#fff;'>x</button>  \n\
                                <label style='position:relative;left:10px;top:10px;display: block;color:#01a0e2;font-weight: bold;text-align:left'>Մեկնաբանություն</label>\n\
                               <textarea type='text'style='position:relative;left:-4px;top:15px;z-index:99999;width:400px;height:70px;background:#FFF;' class='pro_solution'></textarea>\n\
                                  \n\
                            <button data='' class='end_problem' value='" + value + "' style='  border: none;position: absolute;right: 1px;border-radius: 5px; z-index: 9999; bottom: 2px;color: #fff;background: #009c44;width:100px;'>Ավարտել</button></div>\n\ ";
        $(".archives").css({"display": "block"});
         
        $(".archives").html(input);
        $(".close_p").on("click", function () {
                none($(".archives"));
        });
      
        $(".archive").css({"z-index": "9999", "position": "relative"});
       
    
          
        $(".end_problem").on("click", function () {
            var value = [];
            value["0"] = $(".pro_solution").val();
            value["1"] = $(this).val();
            
            if(!data){
                data = 0;
            }
            if(pathName == '/realtimes/problem_list')
            {
                var auth_user = $(".auth_user").attr("data");
                value["3"] = auth_user;
                $.post('/realtimes/clientpage', {'end_problem': value,"data":data}, function (data) {
                
                if(data){
                    $(".opacity").css({"display":"none"});
                    $(".archives").html("");
                     parent_tr.remove();
                 }
            });
            }else{
                $.post('/realtimes/clientpage', {'end_problem': value,"data":data}, function (data) {

                    if(data){
                        $(".opacity").css({"display":"none"});
                        $(".archives").html("");
                         parent_tr.remove();
                     }
                });//
            }
        });
    });
    $(".end_conn").on("click",function(event){
        
        var height = $(window).height();
        var body_height = $("body").height();
        var  parent_tr = $(this).closest("tr");
        if (height > body_height) {

        } else {
            height = body_height;
        }
        
        $(".opacity").css({"display":"block","width": "100%", "height": "" + height + "", "z-index": "1", "opacity": "0.7", "background": "black", "position": "absolute", "left": "0px", "right": "0px", "top": "0px"});

        $(".cre_person").css({"background": "#fff"});
        var value = $(this).val();
      
        var input = "<div style='left:40%;text-align:center;width:450px;background:#fff;position:fixed;height:160px;'>\n\
                                    <button class='close_p' style='z-index:9999;position:absolute;right:1px;background:red;font-weight:bold;border:none;color:#fff;'>x</button>  \n\
                                <label style='position:relative;left:10px;top:10px;display: block;color:#01a0e2;font-weight: bold;text-align:left'>Մեկնաբանություն</label>\n\
                               <textarea type='text'style='position:relative;left:-4px;top:15px;z-index:99999;width:400px;height:70px;background:#FFF;' class='pro_solution'></textarea>\n\
                                  \n\
                            <button class='end_conn_buuton' value='" + value + "' style='  border: none;position: absolute;right: 1px;border-radius: 5px; z-index: 9999; bottom: 2px;color: #fff;background: #009c44;width:100px;'>Ավարտել</button></div>\n\ ";
        $(".archives").css({"display": "block"});
         
        $(".archives").html(input);
        $(".close_p").on("click", function () {
            none($(".archives"));
        });
      
        $(".archive").css({"z-index": "9999", "position": "relative"});
         $(".end_conn_buuton").on("click", function () {
        
            var comment = $(".pro_solution").val();
            var person_id = $(this).val();
            
            
            $.post('clientpage', {'comment': comment,"person_id":person_id}, function (data) {
              
                 if(data){
                    $(".opacity").css({"display":"none"});
                    $(".archives").html("");
                     parent_tr.remove();
                 }
            });//
        });
        
    });
    $(".add_pro_person").click(function(){
           var id = $(this).attr("data");
           var id = $(".id_problem"+id+"").val();
           var pro_person = $(".pro_person"+id+"").val();
           var div = "\n\
                <div id='row"+pro_person+id+"'>\n\
                            <span>"+pro_person+"</span>\n\
                             <button class='delete_pro'data="+pro_person+" style='font-weight: bold;color:#fff;width:20px;background: red;position: absolute;right: 6px;' value="+id+">x</button></div>";
          if(pro_person){
            $.post("problems",{"id":id,"pro_person":pro_person},function(data){
              if(data==1){
                  $(".pro_person_output"+id+"").append(div);
                   $(".delete_pro").on("click", function () {
                            var value = $(this).val();
                            var data = $(this).attr("data");
                            $("#row"+data+id+"").remove();
                           delete_properson(value,data);
                  });
              }else{
              }
           });
            }else{
                alert("Նշեք կատարողին");
            }
       });
       $(".delete_pro").on("click", function () {
                var value = $(this).val();
                var data = $(this).attr("data");
                var id = $(this).attr("value");
                $("#row"+data+id+"").remove();
               delete_properson(value,data);
      });
       function delete_properson(value,data){
           
             $.post('/realtimes/clientpage', {'delete_pro': value,"data":data}, function (data) {
                     console.log(value,data);
              });
       }
    function tamplate_edit(comment){
      var height = $(window).height();
     var body_height = $("body").height();
     if (height > body_height) {

     } else {
         height = body_height;
     }
     $(".opacity").css({"width": "150%", "height": "" + height + "", "z-index": "1", "opacity": "0.7", "background": "black", "position": "absolute", "left": "0px", "right": "0px", "top": "0px"});

     $(".cre_person").css({"background": "#fff"});
     $(".mypage *").attr("disabled", "disabled");
        var output = "<div>";
        comment = comment.trim();
         output += "<div class='edit_prov'><div class='edit_input' style='height:120px'>\n\
                                          <button class='close'style='color:#fff;background:red;border:none;float:right;font-weight:bold'>x</button><br>\n\
                                                 <textarea class='edit_p'>"+comment+"</textarea>\n\
                                          <input type='submit'style=' border: none;position: absolute;right: 1px;border-radius: 5px; z-index: 9999; bottom: 2px;color: #fff;background: #009c44;width:100px;' value='Խմբագրել' class='add_prob'>\n\
                                         </div></div>";
        output+="</div>"
         $(".archives").css({"display": "block"});
         $(".archives").html(output);
         $(".close").on("click", function () {
             none($(".archives"));
         });

         $(".add_prob").on("click", function () {
             var val = [];
             val["0"] = $(".edit_p").val();

         });
    }
    $(".edit_problem").on("click", function (event) {
        var height = $(window).height();
        var body_height = $("body").height();
        if (height > body_height) {

        } else {
            height = body_height;
        }
        $(".opacity").css({"width": "150%", "height": "" + height + "", "z-index": "1", "opacity": "0.7", "background": "black", "position": "absolute", "left": "0px", "right": "0px", "top": "0px"});

        $(".cre_person").css({"background": "#fff"});
        $(".mypage *").attr("disabled", "disabled");
        var id = $(this).val();
        var username = $(this).attr("data");
     
        $.post('/realtimes/clientpage', {'edit_problem': id}, function (data) {
              
            var obj = jQuery.parseJSON(data);
            var output = "<div>";
            $.each(obj, function (key, value) {
                $.each(value, function (key, value) {
                    console.log(window.location.href.indexOf('problem_list'));
                    if(window.location.href.indexOf('problem_list') !==(-1)){
                         var comment= value.comment_team;
                    }else{
                        var comment = value.comment;
                       
                         
                    }
                    if(comment == null){
                        comment='';
                    }
                    output += "<div class='edit_prov'><div class='edit_input' style='height:120px'>\n\
                                             <button class='close'style='color:#fff;background:red;border:none;float:right;font-weight:bold'>x</button><br>\n\
                                                    <textarea class='edit_p'  name='problem_edit'>" + comment + "</textarea>\n\
                                             <input type='submit'style=' border: none;position: absolute;right: 1px;border-radius: 5px; z-index: 9999; bottom: 2px;color: #fff;background: #009c44;width:100px;' value='Խմբագրել' class='add_prob'>\n\
                                            </div></div>";
                });
            });
            output += "</div>";
            $(".archives").css({"display": "block"});
            $(".archives").html(output);
            $(".close").on("click", function () {
                none($(".archives"));
            });
          
            $(".add_prob").on("click", function () {
                var val = [];
                val["0"] = $(".edit_p").val();
                val["1"] = id;
                
                if(!username){
                    username='1';
                }
                $.post('/realtimes/clientpage', {'edit_problem_add': val,"username":username}, function (data) {
                    location.reload();
                });
            });
        });

    });

    $("#archive").on("click", function () {

        var height = $(window).height();
        var body_height = $("body").height();
        if (height > body_height) {

        } else {
            height = body_height;
        }
        $(".opacity").css({"width": "100%", "height": "" + height + "", "z-index": "1", "opacity": "0.7", "background": "black", "position": "absolute", "left": "0px", "right": "0px", "top": "0px"});

        $(".mypage *").attr("disabled", "disabled");

        $("#technical").load('../realtimes/archive_problems');

        $("#technical").append(close);

    });
    $('.endConnection').on('click', function () {
        var height = $(window).height();
        var body_height = $("body").height();
        if (height > body_height) {

        } else {
            height = body_height;
        }
        $(".opacity").css({"width": "100%", "height": "" + height + "", "z-index": "1", "opacity": "0.7", "background": "black", "position": "absolute", "left": "0px", "right": "0px", "top": "0px"});

        $(".personForm").css({"display": "block", "min-height": "100px"});
        var img = "<img style='margin-left:340px;margin-top:20px;height:auto' src='/img/loader1.gif'>";
        $(".personForm").html(img);
        $(".mypage *").attr("disabled", "disabled").off('click');

        var value = $(this).val();
     
        $.post('/Manegements/person', {'end': value}, function (data) {
            $('.personForm').html(data);
            $('.personForm').css({"position": "fixed", "width": "850px", "z-index": "9999", "background": "#fff"});
        }); 
         disableScroll();
         $(document).on("keyup",function(event){
             if(event.keyCode == 27){
                 
                 $(".personForm").css({"background": "none"});
                 none($(".personForm"));
                 enableScroll();
             }
          });
    });
    $(".endCon_history").on("click", function () {
        var id = $(this).val();
        var txt;
        var r = confirm("Բաժանորդը ցանկանում է հրաժարվել մեր ծառաություններից?");
        if (r == true) {
            var id = $(this).val();
            $.post('connectors', {'delete_people': id}, function (data) {
                location.reload();
                return false;
            });
        } else {
            txt = "You pressed Cancel!";
        }
    });
    $('.edit_con').on('click', function () {
        var height = $(window).height();
        var body_height = $("body").height();
        if (height > body_height) {

        } else {
            height = body_height;
        }

        $(".opacity").css({"width": "100%", "height": "" + height + "", "z-index": "1", "opacity": "0.7", "background": "black", "position": "absolute", "left": "0px", "right": "0px", "top": "0px"});
        var img = "<img style='margin-left:340px;margin-top:20px;height:auto' src='/img/loader1.gif'>";
        $(".personForm").css({"display": "block", "min-height": "100px"});
        $(".personForm").html(img);
        var value = $(this).val();
        $.post('/Manegements/edit_con', {'id_e': value}, function (data) {
            $('.personForm').html(data);
            $('.personForm').css({"position": "fixed", "width": "850px", "z-index": "9999", "background": "#fff"});
        });   
        disableScroll();
         $(document).on("keyup",function(event){
             if(event.keyCode == 27){
                 
                 $(".personForm").css({"background": "none"});
                 none($(".personForm"));
                 enableScroll();
             }
          });
    });
    $('.problems_add').on('click', function () {

        var height = $(window).height();
        var body_height = $("body").height();
        if (height > body_height) {
        
        } else {
            height = body_height;
        }
        $(".opacity").css({"width": "100%", "height": "" + height + "", "z-index": "1", "opacity": "0.7", "background": "black", "position": "absolute", "left": "0px", "right": "0px", "top": "0px"});

        $('.form').css({"position": "fixed"});
        $('.form').css({"background": "#fff"});
        $("#add_problem").css({"width": "100px"});
        var div = "<div class = 'problemForms' style='position:relative'><button style='position:absolute;left:96%;background:red;font-weight:bold;border:none;color:#fff;' class='close'>X</button>\n\
                 <form action='problems' id='ProblemAddForm' method='post' accept-charset='utf-8'>\n\
			<div style='min-height:160px;'>\n\
                        <div style='display:none;'><input type='hidden' name='_method' value='POST'></div>\n\
                        <div id='update' class='update-hidden'></div>\n\
                       <div class='control-group'>\n\
                            <input name='data[Problem][telefon]' placeholder='Հեռախոսահամար(ներ)'>\n\
                            <input name='data[Problem][name]' placeholder='Անուն'>\n\
                        </div>\n\
                        <div class='input text required' style='margin-top:15px'>\n\
                            <input name='data[Problem][adress]' style=' width:93%;border:1px solid black; margin:1px; background: #f1f1f1;'placeholder=' Բնակության հասցեն' maxlength='250' type='text' id='ProblemProblem' required='required'>\n\
                        </div>\n\
                       <div class='control-group'>\n\
                            <textarea name='data[Problem][comment]'style='' placeholder='Մեկնաբանություն' class='textarea' id='ProblemProblem' required='required'></textarea>\n\
                        </div>\n\
                        <div class='button'>\n\
                       <input id='add_problem' class='add_problem' formnovalidate='formnovalidate' type='submit' value='Ավելացնել'>\n\
        	</div>\n\
        	</form>\n\
            </div>";
        $('.form').html(div);
     });
    $(".clienttel").on('click', function () {
        $.get('../app/webroot/ajax/clienttel.ctp', function (resspons) {
            $('.control-group').append(resspons);
        });
    });
    $(".legaltel").on('click', function () {
        $.get('../app/webroot/ajax/legaltel.ctp', function (resspons) {
            $('.control-group').append(resspons);
        });
    });
    $(".addservice").on('click', function () {
        $.get('../app/webroot/ajax/service.ctp', function (resspons) {
            $('.service').append(resspons);
        });
    });
    $(".L_addservice").on('click', function () {
        $.get('../app/webroot/ajax/L_service.ctp', function (resspons) {
            $('.service').append(resspons);
        });
    });
    $(".persontel").on('click', function () {
        $.get('../app/webroot/ajax/persontel.ctp', function (resspons) {
            $('.control-group').append(resspons);
            return 0;
        });
    });
    var i = 0;
    $(".persontel_leg").on('click', function () {
        i++;
        var output = "<div>";
        if (i === 1) {
            output += "<input name='data[Person][telefon1]'value='' placeholder='Õ°Õ¥Õ¼Õ¡Õ­Õ¸Õ½Õ¡Õ°Õ¡Õ´Õ¡Ö€' maxlength='9'minlength='9' id='PersonTel'> ";
            output += "<input name='data[Person][firstname1]'value='' class='a' placeholder='Õ¡Õ¶Õ¸Ö‚Õ¶' >";
            output += "<input name='data[Person][lastname1]'value='' placeholder='Õ¡Õ¦Õ£Õ¡Õ¶Õ¸Ö‚Õ¶' >";
            output += "<input name='data[Person][position1]'value='' placeholder='ÕºÕ¡Õ·Õ¿Õ¸Õ¶'  type='text' id='LegalPersonFirstname'></div>";
            $('.control-group').html(output);
        }
        if (i === 2) {

            output += "<input name='data[Person][telefon2]'value='' placeholder='Õ°Õ¥Õ¼Õ¡Õ­Õ¸Õ½Õ¡Õ°Õ¡Õ´Õ¡Ö€' maxlength='9'minlength='9' id='PersonTel'> ";
            output += "<input name='data[Person][firstname2]'value='' class='a' placeholder='Õ¡Õ¶Õ¸Ö‚Õ¶' >";
            output += "<input name='data[Person][lastname2]'value='' placeholder='Õ¡Õ¦Õ£Õ¡Õ¶Õ¸Ö‚Õ¶' >";
            output += "<input name='data[Person][position2]'value='' placeholder='ÕºÕ¡Õ·Õ¿Õ¸Õ¶'  type='text' id='LegalPersonFirstname'></div>";

            $('.control-group').append(output);
        }
        if (i === 3) {

            output += "<input name='data[Person][telefon3]'value='' placeholder='Õ°Õ¥Õ¼Õ¡Õ­Õ¸Õ½Õ¡Õ°Õ¡Õ´Õ¡Ö€' maxlength='9'minlength='9' id='PersonTel'> ";
            output += "<input name='data[Person][firstname3]'value='' class='a' placeholder='Õ¡Õ¶Õ¸Ö‚Õ¶' >";
            output += "<input name='data[Person][lastname3]'value='' placeholder='Õ¡Õ¦Õ£Õ¡Õ¶Õ¸Ö‚Õ¶' >";
            output += "<input name='data[Person][position3]'value='' placeholder='ÕºÕ¡Õ·Õ¿Õ¸Õ¶'  type='text' id='LegalPersonFirstname'></div>";
            $('.control-group').append(output);
        }

    });
    $(".closelegalform").on('click', function () {
        $(".legalpersonForm").remove();
    });
    $(".closepersonform").on('click', function (event) {
        location.reload();
        event.preventDefault();
        return false;
    });
    $("#created_people").on("click", function () {
        var height = $(window).height();
        var body_height = $("body").height();
        if (height > body_height) {

        } else {
            height = body_height;
        }
        $(".opacity").css({"width": "100%", "height": "" + height + "", "z-index": "1", "opacity": "0.7", "background": "black", "position": "absolute", "left": "0px", "right": "0px", "top": "0px"});

        $('.cre_person').css({"display": "block", "position": "fixed", "min-height": "150px", "width": "500px", "z-index": "9999", "background": "#fff"});
        $(".mypage *").attr("disabled", "disabled");


        $('.cre_person').load('/realtimes/cre_person');


    });

    $(".close_ar").on("click", function () {
        none($('.cre_person'));
    });
     
//            setInterval(function() {
//                $.post('/Realtime/realtimes/sessia', {'start': "a"}, function (data) {
//                });
//            }, 30000);
//             setInterval(function() {
//                $.post('/Realtime/realtimes/sessia', {'modified': "modified"}, function (data) {
//                });
//            }, 30000);
//            var now = new Date();
//            var time = now.getTime();
//            var expireTime = time + 1000*36000;
//            now.setTime(expireTime);
//            var tempExp = 'Wed, 31 Oct 2012 08:50:17 GMT';
//            document.cookie = 'cookie=ok;expires='+now.toGMTString()+';path=/';
////            console.log(document.cookie);
////            console.log(document.cookie);
 
        $(".export").on("click",function(){
            $.post("/realtimes/problem_list",{"exel":"exel"},function(data){
                    var jsonObj = [];
                    var obj = $.parseJSON(data);
               
                   
                     $.each(obj.data,function(key,value){
                        var  item = {}
                         item["day"] = value.problem.created;
                         item["comment"] = value.problem.comment;
                         item["reg_person"] = value.problem.reg_person;
                         item["Telefon"] = value.Telefon.telefon + " " + value.Telefon.telefon ;
                         item["username"] = value.problem.username;
                         item["Adress"] = value.Adress.city + " " + value.Village.village_name + " " + value.Street.street_name + " "+ value.Adress.home;
                         jsonObj.push(item);
                         
                     });
                      $.each(obj.people,function(key,value){
                        var  item = {}
                         item["day"] = value.Person.created;
                         item["comment"] = value.Person.comment;
                          item["reg_person"] = value.Person.auth_user;
                         item["Telefon"] = value.Telefon.telefon + " " + value.Telefon.telefon ;
                         item["username"] = value.Person.firstname + " " + value.Person.lastname;
                         item["Adress"] = value.Adress.city + " " + value.Village.village_name + " " + value.Street.street_name + " "+ value.Adress.home;
                         jsonObj.push(item);
                        
                     });
                     if(jsonObj ){
                      
                        jsonObj =  JSON.stringify(jsonObj);
                        fnExcelReport();
                     }
                    
            });
        });
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
    fileName += ReportTitle.replace(/ /g,"_");   
     
var data = CSV;

// add UTF-8 BOM to beginning so excel doesn't get confused.
// *THIS IS THE KEY*
var BOM = String.fromCharCode(0xFEFF);
data = BOM + data;

var btn = document.createElement("button");
btn.appendChild(document.createTextNode("export to exel"));

  var blob = new Blob([data], {type:  "text/csv;charset=UTF-8"});
  if (window.navigator && window.navigator.msSaveOrOpenBlob) {

    // ie
    var success = window.navigator.msSaveOrOpenBlob(blob, "problem_list.csv");
    if (!success) {
      alert("Failed");
    }
  } else {
    var a = document.createElement("a");
    a.href = window.URL.createObjectURL(blob);
    a.download = "problem_list.csv";
    document.body.appendChild(a);
    a.click();

   
    a.parentNode.removeChild(a);
  }

document.body.appendChild(btn);
}