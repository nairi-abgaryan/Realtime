$(document).on("ready",function(){
    $(".maps_all").on("click",function(){
        $(".output_tools").html("");
        var div = "<h4>Գրեք կայանի IP ին սեխմեք Որոնել։</h4>\n\
                    <div class='station_maps_view'>\n\
                        <input type='text' placeholder='Կայանի IP ' class='ip_maps' > \n\
                        <button class='go'>Որոնել</button>\n\
                    </div>";
        $(".output_region").html(div);
        $(".go").on("click",function(){
            var ip = $(".ip_maps").val();
           
            $.post("station_map",{"station_ip":ip},function(data){
                 
                localStorage.station_gps = data;
               var iframe = "<iframe src='maps_2' width='800px' height='600px'><iframe>";
               $(".output_tools").html(iframe);
            });
        });
        $(".ip_maps").keyup(function(e){
            if (e.keyCode === 13){
                       $(".go").click();
            }
        });
       
     
    });
});
