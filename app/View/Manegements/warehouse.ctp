<html>
    <head>
         <?php echo $this->Html->charset('utf8'); ?>
            <?php echo $this->Html->css('tools'); ?>
            <?php echo $this->Html->css('team'); ?>
            <?php echo $this->Html->css('style'); ?>
            <?php echo $this->Html->css('teamTools'); ?>
            <?php echo $this->Html->css('warehouse'); ?>
            <?php echo $this->Html->script('custom'); ?>
            <?php echo $this->Html->script('tools'); ?>
            <?php echo $this->Html->script('tools_style'); ?>
            <?php echo $this->Html->script('TeamTools'); ?>
            <?php echo $this->Html->script('map'); ?>
            <?php echo $this->Html->script('md5'); ?>
            <?php echo $this->Html->script('Tools_ware'); ?>
            <?php echo $this->Html->script('warehouse'); ?>
            <?php echo $this->Html->script('team'); ?>
     </head>
    <body>
      
            <div class ="menutools">
                    <ul class="menu_bar_tools ">
                        <li class ="tools"  ><label data="1"><a style="color:#000;text-decoration: none;"href="tools">Գործիքներ</a></label></li>
                        <li class="War" > <label data="2" style="border-bottom:2px solid red;"><a style="color:#000;text-decoration: none;"href="warehouse">Պահեստ</a></label></li>
                        <li class="Teams" ><label data="3"><a style="color:#000;text-decoration: none;"href="team">Աշխատակազմ</a></label></li>
                        <li class="bookkeeper" ><label data="4" ><a style="color:#000;text-decoration: none;"href="bookkeeper">Հաշվապահություն</a></label></li>
                    </ul>
                </div>
          
          <div class = "mypage">
                <div style="border-top:1px solid #ccc;height:10px;border-radius: 1px;text-align: right;color:#666;font-weight: bold;font-size: 16px"> </div>
                <div class="werehouse">

                    <div class="warehouse_page" style="position: relative;">
                        <div class="warehouse" style="background: #666;color:#fff" >

                            <ul>
                                    <?php if(isset($menu_product)){
                                        foreach ($menu_product as $value) {
                                              if(!$value["Product_name"]["product_realtime"]){
                                            ?><li style="margin:10px;"> <?php

                                            ?>

                                    <a id='<?php echo $value["Product_name"]["id"];?>'class='data_species'data='<?php echo $value["Product_name"]["product_name"];?>' alt='<?php echo $value["Product_name"]["product_name"];?>'>
                                                    <?php echo $value["Product_name"]["product_name"];?></a>

                                </li>
                                                <?php }else{
                                                    ?><li style="margin:10px"> <?php

                                            ?>

                                    <a id='<?php echo $value["Product_name"]["id"];?>'class='data_species'data='<?php echo $value["Product_name"]["product_name"];?>' alt='<?php echo $value["Product_name"]["product_name"];?>'>
                                                    <?php echo substr($value["Product_name"]["product_name"],0,-9)?><span style="font-size:10px;width:30px;height:20px;background:#f60;color:#fff;border:none;">realtime</span></a>

                                </li>
                                                <?php
                                                }
                                        }

                                    }?>
                                <span class="showSingless"id='show1' target="1" style="width:150px;color:#f60;text-align: center;font-size:20px;display:inline-block;cursor:pointer;">+</span>
                            </ul>

                        </div>



                        <div class="view"style="width:800px" >
                            <div class="provider" style="display:none">
                                  <button class='close' style='border:none;font-weight: bold;margin-right:0px;height:20px;float:right;width:20px;background:#f60;color:#fff;'>x</button>
                                <form action='../manegements/warehouse' method='POST'>
                                    

                                    <input name='provider_name' type='text' placeholder='ընկերության անվանում'>

                                    <input name='adress' type='adress' placeholder='հասցե'>

                                    <input name='telefon' placeholder='հեռախոսահամար'  maxlength='9' minlength='9'>

                                    <input name='bank_name' type='name_banek' placeholder='բանկի անուն'>

                                    <input name='account' type='account' placeholder='հաշվեհամար'>
                                   
                                    <select name='legal'>
                                        <option>ֆիզ. անձ</option>
                                        <option>իրավ. անձ</option>
                                    </select>
                                    <br>
                                     <input type='submit' class="add_providers" value='ավելացնել' style='width:120px;'>
                                </form>
                            </div>
                            <div class="product_view">
                                <span class="view_s"></span>
                                <div class="targetDiv" id ="div_create">
                                    <div class="prod_countss"></div>
                                    <button class='close' style='border:none;font-weight: bold;margin-right:0px;height:20px;float:right;width:20px;background:#f60;color:#fff;'>x</button>
                       <?php
                       echo $this->Form->create("add_creat_product",array(
                           
                           'label'=>false,
                           'div'=>false));
                       echo $this->Form->input("product_name",array(
                           "placeholder"=>"ապրանքի անվանումը",
                           'label'=>false,
                           "type"=>"text",
                           "class"=>"prod_names"));
                       echo $this->Form->input("species",array(
                           "placeholder"=>"ապրանքի տեսակ",
                           'label'=>false,
                           "type"=>"text",
                           "class"=>"prod_species"));
                       echo $this->Form->input("add",array(
                           "type"=>"hidden",
                               ));
                       echo $this->Form->input("quantity",array(
                           "placeholder"=>"քանակը",
                           'type'=>"number",
                           'value'=>0,
                           "class"=>"prod_countss",
                           'label'=>false));
                        ?>
                                    <select  name="data[add_creat_product][provider_name]" class = "region" 
                                             Autocomplete = "off" placeholder="նշեք անունը" maxlength="50" type="text" id="PersonCity"
                                             required="required">

                                        <option>
                                            Realtime արտադրանք 
                                        </option>

                                    </select><?php
                       $options = array(                   
                           'label' => 'ավելացնել',
                           'style' => 'width:100px;display:inline-block;float:right;height:20px;',
                           'id' => 'signup',
                           'class'=>'add_prop_realtime',
                           'formnovalidate' => true,
                           );
                       echo $this->Form->end($options);
                   ?>

                                </div>

                                <div class="targetDiv" id ="div2">
                                    <button class='close' style='border:none;font-weight: bold;margin-right:0px;height:20px;float:right;width:20px;background:#f60;color:#fff;'>x</button>
                <?php
                echo $this->Form->create("tools",array(
                    
                    'label'=>false,
                    'div'=>false));
                echo $this->Form->input("product_name",array(
                    "placeholder"=>"ապրանքի անվանումը",
                    'label'=>false,
                    'class'=>'name_prod',
                    "type"=>"text"));
                echo $this->Form->input("species",array(
                    "placeholder"=>"ապրանքի տեսակ",
                    'class'=>'name_space',
                    'label'=>false,
                    "type"=>"text"));
                echo $this->Form->input("quantity",array(
                    "placeholder"=>"քանակը",
                    'type'=>"number",
                    "value"=>" ",
                    "required"=>"required",
                    'label'=>false));
                if (isset($name)) { ?>
                                    <select  name="data[tools][username]" class = "region" Autocomplete = "off" placeholder="նշեք անունը" maxlength="50" type="text" id="PersonCity" required="required">
                                        <option selected="false" value="" style="display:none;" disabled="disabled">նշեք անունը</option>
                    <?php foreach ($name as $value) { ?>
                                        <option>
                            <?php echo $value["Team"]["username"]; ?>
                                        </option>

                    <?php
                    }
                }
                ?></select><?php
                  echo $this->Form->input("minus",array(
                    "type"=>"hidden",
                       ));
                $options = array(                   
                    'label' => 'հանել',
                    'div'=>false,
                    'id' => 'minus_prod',
                    'style' => 'width:100px;float:right;height:20px;',
                    
                    );
                echo $this->Form->end($options);
            ?>
                                </div>

                            </div>


                        </div>
                        <div class="menu_bar_ware" >

                            <span class="showSingle" target="3" id='provider' >Մատակարարներ</span>
                            <span class="wastreles" target="2" id='wastreles' >Խոտան</span>
                            <span class="create_product" target="2" id='create_product' >ստեղծել ապրանք</span>
                        </div>
        <?php echo $this->Session->flash(); ?>
                    </div>

                </div>


                <div class="clear"></div>
                <div class="output"></div>

            </div>
            <div class="targetDiv" id ="div3" style="display:none">
                <button class='close' style='border:none;font-weight: bold;margin-right:0px;height:20px;float:right;width:20px;background:#f60;color:#fff;'>x</button>
                <?php
                echo $this->Form->create("tools",array(
                   
                    'label'=>false,
                    'div'=>false));
                echo $this->Form->input("product_name",array(
                    "placeholder"=>"ապրանքի անվանումը",
                    'label'=>false,
                    'div'=>false,
                    'class'=>'name_prod',
                    "type"=>"text"));
                 echo $this->Form->input("wastreles_out",array(
                    "placeholder"=>"ապրանքի անվանումը",
                    'label'=>false,
                      'div'=>false,
                      'class'=>'wastreles_out',
                    "style"=>"display:none"));
                echo $this->Form->input("species",array(
                    "placeholder"=>"ապրանքի տեսակ",
                    'class'=>'name_space',
                    'div'=>false,
                    'label'=>false,
                    "type"=>"text"));
                echo $this->Form->input("quantity",array(
                    "placeholder"=>"քանակը",
                    'type'=>"number",
                    'div'=>false,
                    'label'=>false));
             
                echo $this->Form->input("minus",array(
                    "type"=>"hidden",
                        ));
                $options = array(                   
                    'label' => 'հանել',
                    'id' => 'minus_ware',
                    'style' => ' border-radius: 3px; margin-right: 18px;width:100px;float:right;height:20px;',
                    
                    );
                echo $this->Form->end($options);
            ?>
       
            </div>
        <div class="clear"></div>
        <div class="output"></div>
        <div class="output_p"></div>
        <div class="opacity"></div>
    </body>
</html>