<html>
    <head>
           <?php echo $this->Html->charset('utf8'); ?>
            <?php echo $this->Html->css('tools'); ?>
            <?php echo $this->Html->css('style'); ?>
            <?php echo $this->Html->css('team'); ?>
            <?php echo $this->Html->css('teamTools'); ?>
            <?php echo $this->Html->script('jquery'); ?>
        
            <?php echo $this->Html->script('custom'); ?>
            <?php echo $this->Html->script('tools_style'); ?>
            <?php echo $this->Html->script('TeamTools'); ?>
            <?php echo $this->Html->script('map'); ?>
            <?php echo $this->Html->script('md5'); ?>
            <?php echo $this->Html->script('Tools_ware'); ?>
            <?php echo $this->Html->css('warehouse'); ?>
            <?php echo $this->Html->script('warehouse'); ?>
            <?php echo $this->Html->script('team'); ?>
    </head>
    <body>
     
        <div class ="menutools">
            <ul class="menu_bar_tools ">
                <li class ="tools"  ><label data="1"><a style="color:#000;text-decoration: none;"href="tools">Գործիքներ</a></label></li>
                <li class="War" > <label data="2" ><a style="color:#000;text-decoration: none;"href="warehouse">Պահեստ</a></label></li>
                <li class="Teams" ><label data="3" style="border-bottom:2px solid red;"><a style="color:#000;text-decoration: none;"href="team">Աշխատակազմ</a></label></li>
                <li class="bookkeeper" ><label data="4" ><a style="color:#000;text-decoration: none;"href="bookkeeper">Հաշվապահություն</a></label></li>
            </ul>
        </div>
     <div class = "mypage" style="width: 100%; min-height: 800px;">
      <div class="all_team">
          <div class = "add_person">
             <button type="button" class="close_ar">x</button>
                            <div style="color:#3eb5f1;height:30px;">Աշխատողի տվյալներ</div>
            
                <?php
                echo $this->Form->create("Team", array(
                    "enctype"=>"multipart/form-data",
                    'label' => false,
                    'div' => false,
                    "required"=>"required"));
                echo $this->Form->input("firstname", array(
                    "placeholder" => "անուն",
                    'label' => false,
                    "type" => "text",
                    "required"=>"required"));
                echo $this->Form->input("id", array(
                    "placeholder" => "անուն",
                    'label' => false,
                    "type" => "text",
                    "style"=>"display:none"));
              
                echo $this->Form->input("lastname", array(
                    "placeholder" => "ազգանուն",
                    'label' => false,
                    "required"=>"required"));
                ?>
                <input type="date" placeholder="ծննդյան ամսաթիվ" name='data[Team][date]' id="data_birth"><?php
                
                echo $this->Form->input("email", array(
                    "placeholder" => "էլ հասցե",
                    'label' => false,
                    "required"=>false));
                echo $this->Form->input("username", array(
                    "placeholder" => "մուտքանուն",
                    'label' => false,
                    "required"=>"required"));
                echo $this->Form->input("adresses", array(
                    "placeholder" => "Հասցե",
                    'label' => false,
                    "type" => "text"));
                ?> <div class="adress">
                                <select name="data[Team][city]"class = "region"   required  placeholder ="նշեք մարզը"  id="Person_C">
                                    <option selected="false" value style="display:none;" disabled="disabled">Նշեք Մարզը</option>
                                    <option value="Երևան">Երևան</option>
                                    <option value="Արմավիր">Արմավիր</option>
                                    <option value="Արարատ">Արարատ</option>
                                    <option value="Սյունիք">Սյունիք</option>
                                    <option value="Վայոց Ձոր">Վայոց Ձոր</option>
                                    <option value="Կոտայք">Կոտայք</option>
                                    <option value="Գեղարքունիք">Գեղարքունիք</option>
                                    <option value="Շիրակ">Շիրակ</option>
                                    <option value="Լոռի">Լոռի</option>
                                    <option value="Տավուշ">Տավուշ</option>
                                    <option value="Արագածոտն">Արագածոտն</option>
                                </select>

                                <div  >
                               <input name="data[Team][village]" id='Teamvillage' Autocomplete = "off" oninvalid="setCustomValidity('ընտրեք միայն գյուղերի ցանկից')" onchange="try {
                                                setCustomValidity('ընտրեք միայն գյուղերի ցանկից')
                                            } catch (e) {
                                            }" placeholder="նշեք գյուղը" maxlength="250" type="text" class="village"><br>

                                    <div class="villagesearchresult" style="position: absolute"></div> 
                                </div>
                                <div  >
                                    <input name="data[Team][street]" placeholder="նշեք փողոցը" Autocomplete = "off"  maxlength="250" type="text" class="street"><br>

                                    <div class="streetsearchresult" style="position: absolute"></div>  </div>                           
                                <input name="data[Team][home]" placeholder="նշեք տունը" maxlength="250" type="text" id="PersonAdress" >
                            </div><input style='display:block' id='Teamtel1' name="data[Team][telefon1]" placeholder="հեռախոսահամար1"  maxlength="9" minlength="9" required="" pattern="\d{9}" oninvalid="setCustomValidity('հեռախոսահամարը բախկացած է 9 թվից')" onchange="try {
                                        setCustomValidity('')
                                    } catch (e) {
                                    }">
                            <input style='display:block' id='Teamtel2' name="data[Team][telefon2]" placeholder="հեռախոսահամար2"  maxlength="9" minlength="9" pattern="\d{9}" oninvalid="setCustomValidity('հեռախոսահամարը բախկացած է 9 թվից')" onchange="try {
                                        setCustomValidity('')
                                    } catch (e) {
                                    }">
                            <select style="" name="data[Team][role]" id='Teamrole' class = "region" Autocomplete = "off"  maxlength="50" type="text" id="PersonCity" required="required">
                    <?php
                   foreach ($role as $value) {
                            ?>
                                <option style=" ;cursor:pointer;" class="target" data = "<?php echo $value["role"]["category"] ?>">
                                <?php echo $value["role"]["category"] ?></option>
                        <?php } ?>

                            </select>
                            <select style='display:block' id='Teamsex'   name="data[Team][sex]" class = "region" Autocomplete = "off"  maxlength="50" type="text" id="PersonCity" required="required">

                                <option value="1">արական</option>
                                <option value="0">իգական</option>

                            </select>
            
                <?php
            echo $this->Form->input("image", array(
                    'label' => false,
                    "placeholder" => "պաշտոնը",
                    'class'=>'input_file',
                   'type' => 'file',
                    "accept"=>"image/jpeg,image/png,image/gif",
                ));
                ?><div class="img"></div><?php
                $options = array(
                    'label' => 'ավելացնել',
                    'id' => 'signup',
                );
                echo $this->Form->end($options);
                ?>
                        </div>
               <div class="team">
                       
                    <?php
                    if (isset($role)) {
                        foreach ($role as $value) {
                            ?>
                        <div style="border-bottom: 1px solid #fff;width:100%;position: relative;height: 30px;">
                            <div style="float: left;margin:1px;cursor:pointer;"id="<?php echo $value["role"]["id"]?>role" class="target" data = "<?php echo $value["role"]["category"] ?>"><?php echo $value["role"]["category"] ?>

                            </div>
  <!--                           <button class='message'value="<?php echo $value["role"]["id"] ?>" style="  outline:none;margin: 1px;height: 17px;background:#666;border:none;float: right; cursor:pointer;"><img style="width:25px;height: 25px;"src='../img/email.png'></button>
                          <button class='edit_role'value="<?php echo $value["role"]["id"] ?>" style="margin: 1px;height: 17px;background:#666;border:none;float: right; cursor:pointer;"><img style="width:20px;height: 20px;"src='../img/edit_pencil.png'></button>
                            <button class="delete_role"data="<?php echo $value["role"]["category"] ?>" value="<?php echo $value["role"]["id"] ?>" style="margin: 1px;width:auto;color:#fff;background: #666;border-radius: 100%;;margin-right: 2px; border:none;float: right; cursor:pointer;">x</button>-->
                        </div>

                                <?php }
                    } ?>
                    <form class="view_role" method="post"action="team" style="width:140px;">

                        </form>
                        <button class="add_role" style=" margin-left: 60px;background: none;border:none;color:green;font-size: 20px;">+</button>
               </div>
                    <div class="menu_bar" style="width:100%;height: 20px;">
                       
                        <span class="showSingle" id='show_1'target="1" style='padding-bottom :3px;padding-right :3px;padding-left :3px;float:right;cursor: pointer;border: none;border-radius: 4px; font-size: 15px;'>նոր աշխատող </span>
<!--                       // <span class="showSingle" target="2" style="height:20px;display:inline-block;margin-left: 10px;cursor:pointer;">լավագույն աշխատող</span>
                        <span class="showSingle" target="2" style="height:20px;display:inline-block;margin-left: 10px;cursor:pointer;">Տույժեր</span>
                        <span class="showSingle" target="2" style="height:20px;display:inline-block;margin-left: 10px;cursor:pointer;">Գրաֆիկներ</span>-->
                    </div>
                     <div  class="view_team1"></div>
                    <div class="view_team">
                        <div id="update"></div>
                       
                    </div>
                  
         
                

            
            </div>
         </div>
    </body>
</html>