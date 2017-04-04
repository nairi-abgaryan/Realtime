$(document).ready( function(){ 
    $('body').keyup(function (e) {
              if(e.keyCode === 13)
              $('#submit').click();

    });
});
