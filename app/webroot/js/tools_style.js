$(document).on("ready",function(){
    
    var height =  $(document).height();
     function none(x){
        $(".opacity").css({"height":"0px","width":"0px"});
        $(".mypage *").removeAttr( "disabled" );
        x.css({"display":"none"});
       
    }
    $('.mypage').css({"min-height":height});
  
    $(".close").on("click",function(){
        var div = $(this).closest("div");
        none(div);
    });
    
});
