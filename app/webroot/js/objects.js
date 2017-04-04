var keys = {37: 1, 38: 1, 39: 1, 40: 1};

function preventDefault(e) {
    e = e || window.event;
    if (e.preventDefault)
        e.preventDefault();
    e.returnValue = false;
}

function preventDefaultForScrollKeys(e) {
    if (keys[e.keyCode]) {
        preventDefault(e);
        return false;
    }
}
function enableScroll() {
    if (window.removeEventListener)
        window.removeEventListener('DOMMouseScroll', preventDefault, false);
    window.onmousewheel = document.onmousewheel = null;
    window.onwheel = null;
    window.ontouchmove = null;
    document.onkeydown = null;
}
function disableScroll() {
    if (window.addEventListener) // older FF
        window.addEventListener('DOMMouseScroll', preventDefault, false);
    window.onwheel = preventDefault; // modern standard
    window.onmousewheel = document.onmousewheel = preventDefault; // older browsers, IE
    window.ontouchmove = preventDefault; // mobile
    document.onkeydown = preventDefaultForScrollKeys;
}


$(document).on("ready", function () {

//       $.post("/realtimes/new_message",{"new_message":"new_message"},function(data){
//           if(data != 0){
//               $(".new_message").html(data);
//           }else{
//                $(".new_message").html("");
//           }
//        });
//    setInterval(function () { 
//       $.post("/realtimes/new_message",{"new_message":"new_message"},function(data){
//           if(data != 0){
//               $(".new_message").html(data);
//               $("title").html("new message");
//           }else{
//                $(".new_message").html("");
//           }
//        });
//    }, 1500);
//    $(document).on("keyup",function(event){
//             if(event.keyCode == 27) {
//                delete_opacity();
//              }
//    });

    $(document).on("click", function (event) {

        if (event.toElement && event.toElement.className == "opacity") {
            delete_opacity();
        }
       
    });
    
    function delete_opacity() {
        enableScroll();
        $(".personForm").css({"background": "none"});
        $(".cre_person").css({"background": "none"});
        $(".targetDiv").css({"display": "none"});
        $(".all_add").css({"display": "none"});
        $(".add_person").css({"display": "none"});
        $(".provider").css({"display": "none"});
        none($(".output_p"));
        none($(".form"));
        none($(".archives"));
        none($(".personForm"));
        none($(".cre_person"));
        none($("#technical"));
    }
    function none(x) {
        enableScroll();
        $(".opacity").css({"height": "0px", "width": "0px"});
        $(".mypage *").removeAttr("disabled");
        x.html(" ");
    }
    var request_uri = location.pathname + location.search;

    var i = 50;
  

    if (window.location.href.indexOf("/realtimes/connectors") != -1) {
        $(window).scroll(function () {
            if (window.scrollY > 200) {
//                  console.log(parseInt(window.scrollY) );
//                  console.log($(document).height()-$(window).height());
               
               
                if (parseInt(window.scrollY) >= (parseInt($(document).height()) - parseInt($(window).height()))/2) {
                   
                    var c = $("#tbody_con").last()["0"].childElementCount;
                   
                    // $(".load_img").html("<img style='background:none;border-radius:50%;width:50px;height:50px; ' src='/img/load_img2.gif'>");
                    if(i == c){
                         i+=50;
                        $.post("/realtimes/con_ajax", {"limit": c, "uri": request_uri}, function (data) {

                            
                            $(".load_img").html(" ");
                            var a = "<script src='/js/custom.js' type='text/javascript'></script>\n\
                                    <script src='/js/user.js' type='text/javascript'></script>";

                            $("#tbody_con").append(data);
                            $("#scripts").html(a);

                            return false;

                        });
                    }
                }
            }



        });
    }

});

if (window.location.href.indexOf("/realtimes/connectors") != -1 || window.location.href.indexOf("/realtimes/problems") != -1) {
    $(window).scroll(function () {

        if (parseInt($(window).scrollTop()) > 50) {
            $(".top_menu").css({"display": "block"});
        } else {
            $(".top_menu").css({"display": "none"});
        }
    });
}
function search_user(user, event, k) {
    var url = "";

    if (event.keyCode == 27) {
        $('.searchresults').remove();
        return;// esc
    }
    var searchField = user
    var myExp = new RegExp(searchField, "i");
    var found = 0;
    var count = 0;
    var l = 1;

    if (searchField.length > 2) {
        $.post('/realtimes/searchresult', {'login': searchField}, function (data) {

            var output = '<div class="searchresults">';
            var obj = jQuery.parseJSON(data);

            $.each(obj, function (key, val) {
                $.each(val, function (key, value) {
                    if (value.username.search(myExp) !== -1) {
                        found = 1;
                        output += "<div alt=" + value.data_id + " id=" + count + " class='result' data='" + value.username + "'>" + value.username + " </div>";
                        url += value.data_id + " ";
                        count++;
                    } else {
                        $('.searchresults').remove();
                    }

                });
            });
            output += '</div>';

            if (found === 1) {
                $('#update').removeClass('update-hidden');
                $('#update').html(output);
                $(".result").on("click", function () {
                    var val = $(this).attr("data");
                    $("#login").val(val);
                    $('.searchresults').remove();
                });


            } else {
                $('.searchresults').remove();
            }
        });
    }
    function a() {

        if (k === count) {
            k = -1;
            $(".search_n").css({"z-index": "-9999"});
            var input = $("#search");
            input[0].selectionStart = input[0].selectionEnd = input.val().length;
        } else {
            $("#" + k + "").css({"background": "#01a0e2", "color": "#fff"});
            $(".search_n").css({"z-index": "9999"});
            $(".search_n").val($("#" + k + "").attr("data"));
        }
        if (event.keycode === 13) {
            var data_id = $("#" + k + "").attr("alt");
            window.location.href = "?data_id=" + data_id.trim() + "";
            return false;
        }

    }



}
function station_search(searchField, event, k) {
    var count = 1;
    var found = 0;


    var myExp = new RegExp(searchField, "i");
    var output = "<div class='stations'>";
    if (searchField.length <= 2) {
        $('.stations').remove();
    }

    if (searchField.length >= 3) {

        $.post('/realtimes/station', {'station': searchField}, function (data) {

            var obj = jQuery.parseJSON(data);

            $.each(obj, function (key, value) {
                $.each(value, function (key, value) {

                    if (value) {
                        if (searchField === value.station_name) {
                            $('.station').attr('required', true);
                            $(".station")[0].setCustomValidity('');

                        }
                        if (value.station_name.search(myExp) !== -1) {
                            found = 1;
                            output += "<div id=" + count + " class='results' data='" + value.station_name + "'style = 'cursor:pointer;display:block;'>" + value.station_name + "</div>";
                            count++;
                        }
                    } else {
                        $('.stations').remove();
                    }
                });
            });
            if (found === 1) {
                output += "</div>";
                $('.stations_result').removeClass('update-hidden');
                $('.stations_result').html(output);
                var option = $('.results');
                var name = option.click(function name() {
                    var validate = $('.station').val($(this).html());
                    $('.stations').remove();
                    if (validate) {
                        $('.station').attr('required', true);
                        $(".station")[0].setCustomValidity('');
                    } else {

                    }
                    if (!name) {
                        $(".station")[0].setCustomValidity("ընտրեք միայն կայանների ցանկից");
                    }
                });
                if (event.keyCode === 40) {

                    if (k === count - 1) {
                        k = count - 1;
                        $("#" + k + "").css({"background": "#01a0e2", "color": "#fff"});
                    } else {
                        k++;
                        $("#" + k + "").css({"background": "#01a0e2", "color": "#fff"});
                    }

                }
                if (event.keyCode === 38) {
                    if (k === 1) {
                        k = 1;
                        $("#" + k + "").css({"background": "#01a0e2", "color": "#fff"});
                    } else {
                        k--;
                        $("#" + k + "").css({"background": "#01a0e2", "color": "#fff"});
                    }
                }
                if (event.keyCode === 13) {
                    var c = $("#" + k + "").attr("data");

                    var validate = $('.station').val(c);
                    $('.stations').remove();
                    if (validate) {
                        $('.station').attr('required', true);
                        $(".station")[0].setCustomValidity('');
                    }
                }
            } else {
                $('.stations').remove();
            }

        });
    } else {
        $('.stations').remove();
    }
}
function enable_village(data) {

    var city_val = $(data).val();
    if (city_val !== null && city_val != 0) {
        $(".village").attr("disabled", false);
    } else {

        $(".village").attr("disabled", true);
    }
    $('.village').val("");
    $('.villagesearch').remove();

}
function village_search(k, event) {
    if (!name) {
        $(".village")[0].setCustomValidity("ընտրեք միայն գյուղերի ցանկից");
    }
    var count = 1;
    var found = 0;
    var searchField = $('.village').val();
    var myExp = new RegExp(searchField, "i");
    var output = "<div class='villagesearch'>";
    var city_val = $("#Person_C").val();
    if (searchField.length <= 2) {
        $('.villagesearch').remove();
    }
    if (searchField.length >= 3) {

        $.post('/realtimes/village', {"q": searchField, "city_val": city_val}, function (data) {

            var obj = jQuery.parseJSON(data);
            $.each(obj, function (key, value) {
                $.each(value, function (key, value) {
                    if (value) {
                        if (searchField === value.village_name) {
                            $('.village').attr('required', true);
                            $(".village")[0].setCustomValidity('');

                        }
                        if (value.village_name.search(myExp) !== -1 && count <= 5) {
                            found = 1;
                            output += "<div id=" + count + " class='results' data='" + value.village_name + "'style = 'cursor:pointer;display:block;'>" + value.village_name + "</div>";
                            count++;
                        }
                    } else {
                        $('.villagesearch').remove();
                    }
                });
            });
            if (found === 1) {
                output += "</div>";
                $('.villagesearchresult').removeClass('update-hidden');
                $('.villagesearchresult').html(output);
                var option = $('.results');
                var name = option.click(function name() {
                    var validate = $('.village').val($(this).html());
                    $('.villagesearch').remove();
                    if (validate) {
                        $('.village').attr('required', true);
                        $(".village")[0].setCustomValidity('');
                    } else {

                    }
                    if (!name) {
                        $(".village")[0].setCustomValidity("ընտրեք միայն գյուղերի ցանկից");
                    }
                });
                if (event.keyCode === 40) {

                    if (k === count - 1) {
                        k = count - 1;
                        $("#" + k + "").css({"background": "#01a0e2", "color": "#fff"});
                    } else {
                        k++;
                        $("#" + k + "").css({"background": "#01a0e2", "color": "#fff"});
                    }

                }
                if (event.keyCode === 38) {

                    if (k === 1) {
                        k = 1;
                        $("#" + k + "").css({"background": "#01a0e2", "color": "#fff"});
                    } else {
                        k--;
                        $("#" + k + "").css({"background": "#01a0e2", "color": "#fff"});
                    }
                }
                if (event.keyCode === 13) {
                    var c = $("#" + k + "").attr("data");

                    var validate = $('.village').val(c);
                    $('.villagesearch').remove();
                    if (validate) {
                        $('.village').attr('required', true);
                        $(".village")[0].setCustomValidity('');
                    }
                }
            } else {
                $('.villagesearch').remove();
            }
        });
        if (!name) {
            $(".village")[0].setCustomValidity("ընտրեք միայն գյուղերի ցանկից");
        }
    } else {
        $('.villagesearch').remove();
    }
}
