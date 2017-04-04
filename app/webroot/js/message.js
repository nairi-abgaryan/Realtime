$(document).on("ready", function () {
    $(".roles").on("click", function (){

    });
    $(".team").first().addClass("active");
      var src = $(".active img").attr("src");
    $(".team").on("click", function () {
        $(".team").removeClass("active");
        $(this).addClass("active");
        var username = $(".active").attr("data");
        $(".chat").css({"display":"none"});
        $("#chat"+username+"").css({"display":"block"});
        
        $("#new"+username+"").html("");
        var src = $(".active img").attr("src");
       
        $.post("message", {"show_message": username}, function (data) {
            show(data,src);
        });
    });
    var username = $(".active").attr("data");
    $.post("message", {"load": "username"}, function (data) {
           
    });

    var username = $(".active ").attr("data");
   
    src = $("#"+username+"").attr("src");
    function scroll(){
         $(".show_message").animate({ scrollTop: 1000+$(document).height() }, "slow");
    }
 
  
   
    $("#chat"+username+"").css({"display":"block"});
        $.post("message", {"show_message": username}, function (data) {
            scroll();
            show(data);
        });
    var auth_user = $(".auth_user").text();
    $("#"+auth_user+"").css({"display":"none"});
    response(src);
    function response(src){
         
        $.post("message",{"response":auth_user},function(json){
            
                 if (json != 0) {
                        var obj = $.parseJSON(json);
                        var count = 0;
                        
                           var output ='<div>';
                          
                          $.each(obj,function(key,value){
                               $.each(value,function(key,value){
                        
                                count =  parseInt($("#new"+value.username_send+"").text());
                                    if(value.username_rec== auth_user){
                                        var name='order';
                                    }else{
                                        var name='self';
                                    }
                                if(count){
                                       count =  $("#new"+value.username_send+"").html(count);
                                          var output ='<div>';
                                            output += "<li class="+name+">\n\
                                                <div class='avatar'><img src='"+src+"' draggable='false'/></div>\n\
                                                <div class='msg'>\n\
                                                    <p>"+value.message+"</p>\n\
                                                    <time>"+value.created+"</time>\n\
                                                </div>\n\
                                            </li>";
                                         output +="</div>";
                                     $("#chat"+value.username_send+"").append(output);
                                      scroll();
                                }else{
                                       var output ='<div>';
                                        output += "<li class="+name+">\n\
                                                <div class='avatar'><img src='"+src+"' draggable='false'/></div>\n\
                                                <div class='msg'>\n\
                                                    <p>"+value.message+"</p>\n\
                                                    <time>"+value.created+"</time>\n\
                                                </div>\n\
                                            </li>";
                                         output +="</div>";
                                        $("#chat"+value.username_send+"").append(output);
                                          scroll();
                                        count = 1;
                                        count =  $("#new"+value.username_send+"").html(count);
                                }
                             });
                          });
                          
                     }
                     else {
                          
                     }
            });
    }
    setInterval(function(){
        
    var username = $(".active ").attr("data");
    src = $("#"+username+" img").attr("src");
       response(src);
    }, 2000,function(){
         scroll();
    });
    function cursor(data) {
        var el = data.get(0);
        var elemLen = el.value.length;
        el.selectionStart = elemLen;
        el.selectionEnd = elemLen;
        el.focus();
    }

    $(document).on("keyup",function(event){
        if(event.keyCode==13){
          var text_message = $(".message_input").val();
           $(".message_input").val("");
           username = $(".active").attr("data");
            cursor($(".message_input"));
           message_send(username, text_message);
       }
    })
    
    $(".send").on("click", function () {
        var text_message = $(".message_input").val();
        $(".message_input").val("");
        username = $(".active").attr("data");
         cursor($(".message_input"));
        message_send(username, text_message);
     
    });
    function message_send(username, text) {
        if(username && text!=''){
             var src = $("#"+auth_user+" img").attr("src");
        $.post("message", {"username": username, "message": text}, function (data) {
            
            if(data){
                $(".message_input").html("");
                var obj = $.parseJSON(data);
                var output ='<div>';
                output += "<li class='self'>\n\
                                    <div class='avatar'><img src='"+src+"' draggable='false'/></div>\n\
                                    <div class='msg'>\n\
                                        <p>"+obj.message+"</p>\n\
                                        <time>"+obj.created+"</time>\n\
                                    </div>\n\
                                </li>";
                output +="</div>";
                
                $("#chat"+obj.username_rec+"").append(output);
                  scroll();
            }
        });
        }
    }
    
    function show(data,img){
        var src = $("#"+auth_user+" img").attr("src");
        
       if (data.length !== 2) {
        
                var obj = $.parseJSON(data);
             
                var output ='<div>';
                if(!obj.username_rec){
                $.each(obj, function (key, value) {
                        
                       $.each(value, function (key, value) {
                    
                      
                    if(value.username_rec == auth_user){
                            output +="<li class='order'>\n\
                                 <div class='avatar'><img src='"+img+"' draggable='false'/></div>\n\
                                 <div class='msg'>\n\
                                     <p>"+value.message+"</p>\n\
                                     <time>"+value.created+"</time>\n\
                                 </div>\n\
                             </li>";
                        }else{
                            output +="<li class='self'>\n\
                                 <div class='avatar'><img src='"+src+"' draggable='false'/></div>\n\
                                 <div class='msg'>\n\
                                     <p>"+value.message+"</p>\n\
                                     <time>"+value.created+"</time>\n\
                                 </div>\n\
                             </li>";
                        }
                 });
            });
        }else{
           
        }
        output +="</div>";
       
         $(".chat").html(output);
           scroll();
        }else {
                $(".chat").html(" ");
            }
        }
});