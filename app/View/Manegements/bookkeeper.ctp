<html>
    <head>
       <?php echo $this->Html->charset('utf8'); ?>
            <?php echo $this->Html->css('tools'); ?>
            <?php echo $this->Html->css('style'); ?>
            <?php echo $this->Html->css('teamTools'); ?>
            <?php echo $this->Html->script('jquery'); ?>
            <?php echo $this->Html->script('custom'); ?>
             <?php echo $this->Html->script('tools_style'); ?>
            <?php echo $this->Html->css('warehouse'); ?>
            <?php echo $this->Html->script('warehouse'); ?>
            <?php echo $this->Html->script('team'); ?>
            <?php echo $this->Html->css('team'); ?>
    </head>
    <body>
     
          <div class ="menutools">
                    <ul class="menu_bar_tools ">
                        <li class ="tools"  ><label data="1"><a style="color:#000;text-decoration: none;"href="tools">Գործիքներ</a></label></li>
                        <li class="War" > <label data="2" ><a style="color:#000;text-decoration: none;"href="warehouse">Պահեստ</a></label></li>
                        <li class="Teams" ><label data="3"><a style="color:#000;text-decoration: none;"href="team">Աշխատակազմ</a></label></li>
                        <li class="bookkeeper" ><label data="4" style="border-bottom:2px solid red;"><a style="color:#000;text-decoration: none;"href="bookkeeper">Հաշվապահություն</a></label></li>
                    </ul>
                </div>
          
           <div class = "mypage">
<div class="bookkeeper">
    <ul>
        <li><a href="#">1.կատարել վճարում</a></li>
        <li><a href="#">1.Բաժանորդներ</a></li>
        <li><a href="#">2.Պայմանագրեր և հաշվապահական բլանկներ</a></li>
        <li><a href="#">3.Մուտք/Ելք</a></li>
        <li><a href="#">4.Գրաֆիկներ</a></li>
        <li><a href="#">5.Անալիտիկ բանաձեվեր - դուրս բերել գրաֆիկորեն</a></li>
        <li><a href="#">6.Դրամարկղ</a></li>
    </ul>
</div>
<div class = "payments">
    <?php if(isset($_GET["id"])){
        $id = $_GET["id"];
        
       echo $client["Person"]["firstname"] . " " . $client["Person"]["lastname"];
       echo $this->Form->create("fees");
       echo $this->Form->input('id',array("div"=>false,"type"=>"hidden","value"=>$id));
       echo $this->Form->input('money',array("label"=>false,"div"=>false,"type"=>"number"));
       echo $this->Form->submit("վճարել",array("div"=>false));
       echo $this->Form->end();
       
     }
    ?>
   
</div>

            </div>
            <div class="menupage">
                
            </div>
        </div>
    </body>
</html>
