$(document).ready(function () {

    $(".close_new").on("click", function () {
       none($("#technical"));
    });
      function none(x){
        $(".opacity").css({"height":"0px","width":"0px"});
        $(".mypage *").removeAttr( "disabled" );
        x.html("");
    }
    $(".close").on("click",function(){
        none($(".form"));
    });
 
    $(".station").on("keyup", function (event) {
        var count = 1;
        var found = 0;
        var searchField = $('.station').val();
        var myExp = new RegExp(searchField, "i");
        var output = "<div class='stations'>";
        if (searchField.length <= 2) {
            $('.stations').remove();
        }
         $(".station")[0].setCustomValidity("ընտրեք միայն կայանների ցանկից");
        if (searchField.length >= 3) {
            
                $.post('station', {'station': searchField}, function (data) {
             
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
                        }
                        else {
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
                        }
                        else {

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
    });
    $(window).keydown(function (event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            return false;
        }
    });
    $('.PersonUser').on('keyup', function () {
        var searchField = $('.PersonUser').val();
        $.post('user', {'q': searchField}, function (data) {

           
            var obj = jQuery.parseJSON(data);//de siktir ejicse eee hambal sik
            if (obj.length !== 0) {
              
                $(".PersonUser")[0].setCustomValidity("այդ անունով օգտատեր կա");
            }
            else {
                $('.PersonUser').attr('required', true);
                $(".PersonUser")[0].setCustomValidity('');
            }
        });

    });
    
    $("#Person_C").on("change", function () {
        var city_val = $("#Person_C").val();

        if (city_val !== null) {
            $(".village").attr("disabled", false);
        }
        $('.village').val("");
        $('.villagesearch').remove();
    });

    var k = 0;
    $('.village').on('keyup', function (event) {
        village_search(k,event);
    });
    $('.villagesearch').remove();
    var k = 0;
    $("#PersonAdress").on("keyup", function () {
        $('.streetsearch').remove();
        $('.villagesearch').remove();
    });
    $('.street').on('keyup', function (event) {
        $('.villagesearch').remove();
        var count = 1;
        var found = 0;
        var searchField = $('.street').val();
        var myExp = new RegExp(searchField, "i");
        var output = '<div class="streetsearch">';
        if (searchField.length <= 2) {
            $('.streetsearch').remove();
        }
        if (searchField.length >= 3) {
            $.post('street', {'q': searchField}, function (data) {

                var obj = jQuery.parseJSON(data);
                $.each(obj, function (key, value) {
                    $.each(value, function (key, value) {
                        if (value.street_name.search(myExp) !== -1) {
                            found = 1;
                            output += "<div id=div" + count + " class='result' data='" + value.street_name + "' style = 'cursor:pointer;display:block;'>" + value.street_name + "</div>";
                            count++;
                        }
                        else {
                            $('.streetsearch').remove();
                        }
                    });
                });
                if (found === 1) {
                    output += '</div>';
                    $('.streetsearchresult').removeClass('update-hidden');
                    $('.streetsearchresult').html(output);
                    var option = $('.result');
                    option.click(function () {
                        $('.street').val($(this).html());
                        $('.streetsearch').remove();
                    });
                    if (event.keyCode == 40) {

                        if (k == count - 1) {
                            k = count - 1;
                            $("#div" + k + "").css({"background": "#01a0e2", "color": "#fff"});
                        } else {
                            k++;
                            $("#div" + k + "").css({"background": "#01a0e2", "color": "#fff"});
                        }

                    }
                    if (event.keyCode == 38) {
                        if (k == 1) {
                            k = 1;
                            $("#div" + k + "").css({"background": "#01a0e2", "color": "#fff"});
                        } else {
                            k--;
                            $("#div" + k + "").css({"background": "#01a0e2", "color": "#fff"});
                        }
                    }
                    if (event.keyCode == 13) {
                        var l = $("#div" + k + "").attr("data");
                        var validate = $('.street').val(l);
                        $('.streetsearch').remove();
                    }
                }
                else {
                    $('.streetsearch').remove();
                }
            });
        }
        else {
            $('.streetsearch').remove();
        }
    });
    $('.streetsearch').remove();
    $('#Personby_whom').on('change keyup', function () {
        var sanitized = $(this).val().replace(/[^0-9]/g, '');
        $(this).val(sanitized);
        var value = $('#Personby_whom').val();
        if (value >= 1) {
            $('#Personby_whom').attr('required', true);
        } else {
            $('#Personby_whom').attr('required', false);
        }
    });
    $('#PersonTel').on('change keyup', function () {
        var sanitized = $(this).val().replace(/[^0-9]/g, '');
        // Update value
        $(this).val(sanitized);
        $('#PersonTel').attr('required', true);
    });
    $('#PersonEmail').on('change keyup', function () {

        var value = $('#PersonEmail').val();
        if (value >= 1) {
            $('#PersonEmail').attr('required', true);
        } else {
            $('#PersonEmail').attr('required', false);
        }
    });
    $('#Person_gps').on('change keyup', function () {
        var value = $('#Person_gps').val();
        if (value >= 1) {
            $('#Person_gps').attr('required', true);
        } else {
            $('#Person_gps').attr('required', false);
        }
    });
    $('#Person_addpas').on('change keyup', function () {

        var value = $('#Person_addpas').val();
        if (value >= 1) {
            $('#Person_addpas').attr('required', true);
        } else {
            $('#Person_addpas').attr('required', false);
        }
    });

});