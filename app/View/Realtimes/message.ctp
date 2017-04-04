
<head>
   
    <?php echo $this->Html->css('style'); ?>
    <?php echo $this->Html->css('messages'); ?>
    <?php echo $this->Html->script('jquery'); ?>
    <?php echo $this->Html->script('message'); ?>
    <?php echo $this->Html->script('custom'); ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <div class="mypage">
<div class="message_table">
    <div class="username">
        <?php
        if (isset($team)) {
            foreach ($team as $value) {
               
                 echo "<div class='team' id=" . trim($value["Team"]["username"]) . "  data=" . trim($value["Team"]["username"]) . ">"
                . "<img width='32px' height='36px' src='/img/" . trim($value["Team"]["image_name"]) . "'>"
                . "<span >" . trim($value["Team"]["firstname"]) . " " . trim($value["Team"]["lastname"]) . "</span>"
                . "<span style='width:20px;border-radius:50%;color:red;position:absolute;left:200px;' id='new" . trim($value["Team"]["username"])."'></span>"
                ."</div>";
            }
        }
        ?>
    </div>
<div class="message_text">

        <div class="text">
            <div class="show_message">
<!--                <div class="menu">
                    <div class="back"><i class="fa fa-chevron-left"></i> <img src="http://i.imgur.com/DY6gND0.png" draggable="false"/></div>
                    <div class="name">Alex</div>
                    <div class="last">18:09</div>
                </div>-->
                <?php 
                     if (isset($team)){
                            foreach ($team as $value) {
                      ?>   <div class="chat" id="chat<?php echo $value["Team"]["username"];?>"></div>
                          <?php
                     }}
                ?>
              
<!--                    <li class="other">
                        <div class="avatar"><img src="http://i.imgur.com/DY6gND0.png" draggable="false"/></div>
                        <div class="msg">
                            <p>Hola!</p>
                            <p>Te vienes a cenar al centro? <emoji class="pizza"/></p>
                            <time>20:17</time>
                        </div>
                    </li>
                    <li class="self">
                        <div class="avatar"><img src="http://i.imgur.com/HYcn9xO.png" draggable="false"/></div>
                        <div class="msg">
                            <p>Puff...</p>
                            <p>Aún estoy haciendo el contexto de Góngora... <emoji class="books"/></p>
                            <p>Mejor otro día</p>
                            <time>20:18</time>
                        </div>
                    </li>-->
              
            </div>
            <div class="write_message"> 
                <textarea class="message_input"></textarea>
                <input type="submit" value="ուղարկել" class="send">
            </div>
        </div>

    </div>
    <div class="role" >

    </div>

</div>
    </div>
</body>
</html>
