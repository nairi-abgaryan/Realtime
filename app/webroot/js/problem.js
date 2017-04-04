$(document).ready(function () {
   $(".page").on("click",function(){
       var value = $(this).val();
       var output = "<div><table>\n\
                            <thead class='ClientResult'>\n\
                                <tr>\n\
                                    <td>Գրանցում</td>\n\
                                    <td>ԱԱ</td>\n\
                                    <td>Հասցե</td>\n\
                                    <td>Հեռախոսահամարներ</td>\n\
                                    <td>Մեկնաբանություն</td>\n\
                                    <td>Կատարող</td>\n\
                                    <td>Գրանցող</td>\n\
                                    <td>խնդրի լուծումը</td>\n\
                                    <td>Սկիզբ</td>\n\
                                    <td>Ավարտ</td>\n\
                                </tr> \n\
                            </thead> \n\ ";
        $.post('archive_problems', {'page_count': value}, function (data) {
            
            var obj = jQuery.parseJSON(data);
            $.each(obj, function (key, value) {
                        if(value.problem.problem_id){
                        output+="<tbody >\n\
                                <tr>\n\
                                    <td>"+ value.problem.id +"</td>\n\
                                    <td>"+ value.people.firstname +" "+ value.people.lastname +"</td>\n\
                                    <td>"+ value.Adress.city +"</td>\n\
                                    <td>"+ value.Telefon.telefon +"</td>\n\
                                    <td>"+ value.problem.comment +"</td>\n\
                                    <td>"+ value.problem.pro_person +"</td>\n\
                                    <td>"+ value.problem.reg_person +"</td>\n\
                                    <td>"+ value.problem.pro_solution +"</td>\n\
                                    <td>"+ value.problem.created +"</td>\n\
                                    <td>"+ value.problem.modified +"</td>\n\
                                </tr> \n\
                            </tbody> \n\ ";
                }if(value.problem.adress){
                         output+="<tbody >\n\
                                <tr>\n\
                                    <td>"+ value.problem.id +"</td>\n\
                                    <td></td>\n\
                                    <td>"+ value.problem.adress +"</td>\n\
                                    <td>"+ value.problem.telefons +"</td>\n\
                                    <td>"+ value.problem.comment +"</td>\n\
                                    <td>"+ value.problem.pro_person +"</td>\n\
                                    <td>"+ value.problem.reg_person +"</td>\n\
                                    <td>"+ value.problem.pro_solution +"</td>\n\
                                    <td>"+ value.problem.created +"</td>\n\
                                    <td>"+ value.problem.modified +"</td>\n\
                                </tr> \n\
                            </tbody> \n\ ";
                }
            
            });
            output += "</table></div>";
            $(".archives_read").html(output);
            });
   });
   $.post('archive_problems', {'page_count': 10}, function (data) {
             var output = "<div><table>\n\
                            <thead class='ClientResult'>\n\
                                <tr>\n\
                                    <td>Գրանցում</td>\n\
                                    <td>ԱԱ</td>\n\
                                    <td>Հասցե</td>\n\
                                    <td>Հեռախոսահամարներ</td>\n\
                                    <td>Մեկնաբանություն</td>\n\
                                    <td>Կատարող</td>\n\
                                    <td>Գրանցող</td>\n\
                                    <td>խնդրի լուծումը</td>\n\
                                    <td>Սկիզբ</td>\n\
                                    <td>Ավարտ</td>\n\
                                </tr> \n\
                            </thead> \n\ ";
            var obj = jQuery.parseJSON(data);
            $.each(obj, function (key, value) {
                        if(value.problem.problem_id){
                        output+="<tbody >\n\
                                <tr>\n\
                                    <td>"+ value.problem.id +"</td>\n\
                                    <td>"+ value.people.firstname +" "+ value.people.lastname +"</td>\n\
                                    <td>"+ value.Adress.city +"</td>\n\
                                    <td>"+ value.Telefon.telefon +"</td>\n\
                                    <td>"+ value.problem.comment +"</td>\n\
                                    <td>"+ value.problem.pro_person +"</td>\n\
                                    <td>"+ value.problem.reg_person +"</td>\n\
                                    <td>"+ value.problem.pro_solution +"</td>\n\
                                    <td>"+ value.problem.created +"</td>\n\
                                    <td>"+ value.problem.modified +"</td>\n\
                                </tr> \n\
                            </tbody> \n\ ";
                }if(value.problem.adress){
                         output+="<tbody >\n\
                                <tr>\n\
                                    <td>"+ value.problem.id +"</td>\n\
                                    <td></td>\n\
                                    <td>"+ value.problem.adress +"</td>\n\
                                    <td>"+ value.problem.telefons +"</td>\n\
                                    <td>"+ value.problem.comment +"</td>\n\
                                    <td>"+ value.problem.pro_person +"</td>\n\
                                    <td>"+ value.problem.reg_person +"</td>\n\
                                    <td>"+ value.problem.pro_solution +"</td>\n\
                                    <td>"+ value.problem.created +"</td>\n\
                                    <td>"+ value.problem.modified +"</td>\n\
                                </tr> \n\
                            </tbody> \n\ ";
                }
            
            });
            output += "</table></div>";
            $(".archives_read").html(output);
            });
            
        $(".close").on("click",function(){
            location.reload();
        });
       
});