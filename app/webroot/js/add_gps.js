$(document).on("ready",function(){
    $(".header").remove();
    
    $.post("../json/client.json",function(data){
        var obj = {};
        var array = [];
        var name =[];
        var i=0;
        
        $.each(data.features,function(key,value){
            i++;
//                 console.log(value.geometry.coordinates);
//                 console.log(value.properties.Name);
               
                 array[value.properties.name]=value.geometry.coordinates;
                 name.push(value.properties.name);
        });
     
        var obj = $.extend({}, array);
      
        $.post("/Test/realtimes/adress_1",{"array":obj},function(a){
            console.log(a);
        });
      
    });
     
});