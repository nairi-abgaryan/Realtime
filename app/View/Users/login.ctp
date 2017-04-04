<body onKeyDown="doKey(event)" >
    <div class="users form">
<?php echo $this->Session->flash('auth'); ?>
        <html>
            <head>
        <?php echo $this->Html->charset('utf8'); ?>
        <?php echo $this->Html->css('cake');?>

            </head>
            <body>
                <div class = "mypage" >
                    <div class = "Reg"style="position: relative" >

                        <div style="text-align:left;background: #2ECCFA;text-decoration: none;
                             position:absolute;border: 1px solid 
                             blueviolet;top:200px;right: 0px;">

                        </div>
                    </div>
                    <div class="container">

                        <form id="signup" method="POST" action="">
                           <div class="header">
                                <h3>Մուտք</h3>
                                <p>ՌեալԹայմ ՍՊԸ</p>
                            </div>
                            <div id="sep"></div>
                            <div class="inputs">
                                <input name="data[User][username]" placeholder="մուտքանուն" maxlength="45" type="text" id="UserUsername" required="required">
                                <input type="password" name="data[User][password]" placeholder="Գախտնաբառ" />
                                <input  id="submit" onclick="loadDoc()"type="submit" name="submit" value="Մուտք"> 
                            </div>
                        </form>

                    </div>

                </div>

            </body>
        </html>

    </div>


    <script>
        document.getElementById('UserUsername').focus();
        function doKey(e) {
            evt = e || window.event;
            console.log(evt.keyCode);
            if (evt.keyCode === 13) {
                var user = document.getElementById("UserUsername").value;
                loadDoc();
            }
        }
        function loadDoc() {
            var user = document.getElementById("UserUsername").value;
          
            var xhttp = new XMLHttpRequest();
              
            xhttp.onreadystatechange = function () {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    localStorage.perm = xhttp.responseText;
                   return;
                }
            };
            xhttp.open("POST", "http://newop.realtime.am/onlines/permission", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("user=" + user + "");
        }
    </script>

</body>
