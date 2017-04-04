<html>
    <head>
        <meta charset='utf-8' />
        <link href='/css/fullcalendar.css' rel='stylesheet' />
        <link href='/css/fullcalendar.print.css' rel='stylesheet' media='print' />
        <script src='/js/jquery.min.js'></script>
        <script src='/js/moment.min.js'></script>
        <script src='/js/fullcalendar.js'></script>
        <script>

            $(document).ready(function () {
                var username = $("#username_now").attr("data");
               
                var obj;
                var month = Date();
                mont_events(username,month);
              function mont_events(username,month) {
             
                    $.post("calendar", {"month": month, "username": username}, function (data) {
                       
                        obj = $.parseJSON(data);
                        calendar(obj);
                    });
                }
                
                function calendar(obj) {
                 
                    $('#calendar').fullCalendar({
                       
                        header: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'month,agendaWeek,agendaDay'
                            
                        },
                        defaultDate: month,
                        selectable: true,
                        selectHelper: true,
                        
                        select: function (start, end, data) {
                            
                            //var title = prompt('Event Title:');
                            var eventData = this.options.data;
                            var color;
                            var count;
                            var username = $("#username_now").attr("data");
                            var div = "<input placeholder='վերնագիր' class='title' type='text'/>\n\
                                                    <input placeholder='միավորներ' style='width:60px;' class='count' type='number'>\n\
                                                    <input placeholder='գույն' class='color' type='color' value='#3a87ad' /><br>\n\
                                                    <button class='cool' style='color:#fff;list-style: none;height:25px;border:none;cursor: pointer;border-radius:5px;background: #00a753; font-size: 14px;'>խրախուսել</button>\n\
                                                    <button class='wrong' style='color:#fff;list-style: none;height:25px;border:none;cursor: pointer;border-radius:3px;background: #ed1c24; font-size: 14px;'>տուժել</button>\n\
                                                    <button class='note' style='color:#fff;list-style: none;height:25px;border:none;cursor: pointer;border-radius:3px;background: #3b5eab; font-size: 14px;'>նշում</button>";
                            $("#countusername").css({"display": "block"});

                            $("#countusername").html(div);

                            $(".cool").on("click", function () {
                                var title = $(".title").val();
                                if (!title) {
                                    alert("լրացրեք վերնագիր դաշտը");
                                    return;
                                }
                                var count = $(".count").val();
                                if (!count) {
                                    alert("լրացրեք միավորներ դաշտը");
                                    return;
                                }
                                var color = $(".color").val();
                                post(title, count, color, start, end);
                            });
                            $(".wrong").on("click", function () {
                                var title = $(".title").val();
                                if (!title) {
                                    alert("լրացրեք վերնագիր դաշտը");
                                    return;
                                }
                                var count = $(".count").val();
                                if (!count) {
                                    alert("լրացրեք միավորներ դաշտը");
                                    return;
                                }
                                else {
                                    count = -count;
                                }
                                var color = $(".color").val();
                                post(title, count, color, start, end);

                            });
                            $(".note").on("click", function () {
                                var title = $(".title").val();
                                if (!title) {
                                    alert("լրացրեք վերնագիր դաշտը");
                                    return;
                                }
                                var count = 0;
                                var color = $(".color").val();
                                post(title, count, color, start, end);
                            });
                            function post(title, count, color, start, end) {
                                if (title) {
                             
                                    eventData = {
                                        title: title,
                                        color: color,
                                        count: count,
                                        start: start,
                                        end: end,
                                        username: username
                                    };
  
                                    $('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
                                    var end = eventData.end._d;
                                    var start = eventData.start._d;
                                    var title = eventData.title;

                                    $.post("calendar", {"start": start, "title": title, "end": end, "color": color, "username": username, "count": count}, function (data) {
                                          
                                        $("#countusername").html("");
                                        $("#count").html(data);
                                        $("#countusername").css({"display": "none"});
                                    });
                                }
                            }
                            $('#calendar').fullCalendar('unselect');
                        },
                        editable: true,
                        eventLimit: true, // allow "more" link when too many events
                        events:obj
                    });


                }
            });

        </script>
        <style>

            body {
                margin: 40px 10px;
                padding: 0;
                font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
                font-size: 14px;
            }

            #calendar {
                max-width: 900px;
                margin: 0 auto;
            }

        </style>
    </head>
    <body>
        <div id='countusername' style="display:none;position:fixed;z-index:9999;width:300px;min-height: 50px;background: #000;"></div>
        <div>
            <span style="font-size:17px;font-weight: bold;">Միավորներ </span>
            <span style="color:red;margin-left: 10px;font-size:17px;font-weight: bold;" id='count'></span>
        </div>
        <div id='calendar'></div>
        <?php if(isset($username))?>
        <div id='username_now' data="<?php echo $username; ?>"></div>

    </body>
</html>
<?php die();?>