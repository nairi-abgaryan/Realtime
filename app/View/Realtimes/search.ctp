<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;utf-8">
        <?php echo $this->Html->charset('utf8'); ?>
        <?php echo $this->Html->css('style'); ?>
        <?php echo $this->Html->css('search'); ?>
        <?php echo $this->Html->script('custom'); ?>
        <?php echo $this->Html->script('objects'); ?>
        <?php echo $this->Html->script('tools_style'); ?>
        <?php echo $this->Html->script('search'); ?>
        <?php echo $this->Html->script('estate_add'); ?>
        <?php echo $this->Html->script('map'); ?>
    </head>
    <div class="new_user_technical">
        <div id="technical" style="position:fixed"></div>
    </div>
    <div id="you"></div>
    <body >
       <div class = "mypage">
            <div class='container'>
          
            <div id="searcharea">
<!--                <form action = "search" method = "get" autocomplete="off" position:relative>-->
                    <input type = "text"class="search_n"readonly style="position:absolute; z-index: -9999;width: 398px;height: 16px; ">
                    <input type="text" style="z-index:9999;height:18px;" name="se" id="search" placeholder="search"  tabindex="1" autocomplete="off" id="text" maxlength="400"  name="text" autocorrect="off" autocapitalize="off" spellcheck="false" aria-autocomplete="list"/>
                    <button class='search_ids' style="width:100px;">որոնել</button>
<!--                </form>-->
            </div>
            <div id="update" class="update-hidden"></div>
            <div id="updates" class="update-hidden"></div>
            <div class = "searchresult" id = "searchresult"></div>
            <div class = "searchresult">
                <table>
                    <thead class="styleborder" style="margin-top:10px;">
                        <tr>
                            <td  width="90px" height='34px' align="center">Օգտատեր</td>
                            <td width="129px" height='34px' align="center">Անուն ազգանուն</td>
                            <td width="380px" height='34px' align="center">Հասցե</td>
                            <td width="141px" height='34px' align="center">Մոդեմ</td>
                            <td width="141px" height='34px' align="center">Վլան</td>
                            <td width="144px" height='34px' align="center">Ծառաություններ</td>
                            <td width="121px" height='34px' align="center">Կարգավիճակ</td>
                        </tr>
                    </thead>
                    <?php
                    if (isset($values)) {
                        
                        $count = 0;
                        foreach ($values as $value) {
                            $count++;
                            ?>
                    <tbody  class="header_search" data='<?php echo $value["Person"]["id"] ?>' alt = '<?php echo $value["Gps"]["gps"] ?>'style="border-bottom:1px solid #01a0e2;">

                        <tr class="view" id ="dropdown-link" style="height: 50px;">
            
                            <td><?php if($value["Technical"]["username"]){ 
                                       
                                        if(isset($username) && !empty($username)){
                                                         
                                                        foreach ($username as $val) {
                                                            if($value["Person"]["id"] == $val["technical_data"]["data_id"]){
//                                                                var_dump($val["technical_data"]["id"]); 
                                                                ?>
                                                    <div style="width:150px;height:23px; margin:1px 0px 0px 1px;text-align: center;">
                                                    <span style ="width:100%;height:100%;float:left"><?php echo $val["technical_data"]["username"] ?></span></div>
                                                        <?php }}}?><?php
                            }else{
                                                ?><button class="new_user" style="color:#01a0e2;z-index:9999" value="<?php echo $value["Person"]["id"]?>">նոր օգտատեր</button><?php
                                            }
                                        ?>
                            </td>
                            <td><?php echo $value["Person"]["firstname"] ?>
                                <span><?php echo $value["Person"]["lastname"] ?></span></td>

                            <td>
                                <span><?php echo $value["Adress"]["city"]; ?></span>
                                <span><?php echo $value["Village"]["village_name"]; ?></span>
                                <span><?php echo $value["Street"]["street_name"]; ?></span>
                                <span><?php echo $value["Adress"]["home"]; ?></span>
                            </td>

                          
                            <td style="position:relative;" class='copyed_ip'width='120px'> 
                            
                                <?php if(isset($username)){ 
                                   
                                        foreach ($username as $val) {
                                     
                                                if($value["Person"]["id"] == $val["technical_data"]["data_id"]){
                                                   if($val["technical_data"]["modem"])
                                                            echo $val["technical_data"]["modem"]."<br>"; 
                                        }}}  
                                    ?>
                                </td>
                            <td> <?php if(isset($username)){ 
                                   
                                        foreach ($username as $val) {
                                     
                                                if($value["Person"]["id"] == $val["technical_data"]["data_id"]){
                                                    ?>
                                                    <?php if($val["technical_data"]["vlan"])
                                                            echo $val["technical_data"]["vlan"]."<br>"; 
                                        }}}  
                                    ?></td>
                            <td>
                                <span>
                                   <?php if(isset($username)){ 
                                   
                                        foreach ($username as $val) {
                                     
                                                if($value["Person"]["id"] == $val["technical_data"]["data_id"]){
                                                    ?>
                                                    <?php if($val["Service"]["service_name"])
                                                            echo $val["Service"]["service_name"]."<br>"; 
                                        }}}  
                                    ?>
                                    
                                </span>
                            </td>
                          
                            <td>
                              
                                    <?php if(isset($username)){ 

                                    foreach ($username as $val) {

                                         if(isset($val["Payment"]["category"])){
                                        if($value["Person"]["id"] == $val["technical_data"]["data_id"]){
                                            
                                                ?>  <div class="category<?php echo $val["Payment"]["id"]?>"><span class="active_cat active_cat<?php echo $val["Payment"]["id"]?>">
                                                <?php if($val["Payment"]["category"] == 2)
                                                    { echo "Ակտիվ"; }else{ echo " ";}?>
                                            </span><br>
                                            <span class="disabled_cat category_change<?php echo $val["Payment"]["id"]?>">
                                                <?php if($val["Payment"]["category"] == 0){ echo "Անջատված"; }else{ echo " ";}?>
                                                <?php if($val["Payment"]["category"] == 4){ echo "Հրաժարված"; }else{ echo " ";}?>
                                            </span>
                                            <span class="disabled_cat category_change<?php echo $val["Payment"]["id"]?>">
                                                <?php if($val["Payment"]["category"] == 1){ echo "Կասեցված"; }else{ echo " ";}?>
                                            </span> </div>
                                    <?php }}} }
                                    ?>
                               
                            </td>
                        </tr>

                        
                        <tr>
                            <td colspan="8" >


                                <div id="dropdown-1" class="dropdown dropdown-processed" style="position: relative;">
                                    
                                    <?php if($value["Technical"]["username"]){?>
                                    <a class="dropdown-link" id="dropdown-link<?php echo $value["Person"]["id"] ?>" href="#" title="<?php echo $value["Technical"]["id"] ?>" data="<?php echo $value["Person"]["id"] ?>"></a>

                                        <?php }else{ ?>
                                    <a class="dropdown-link" id="dropdown-link<?php echo $value["Person"]["id"] ?>" href="#"title="<?php echo $value["Technical"]["id"] ?>" data="<?php echo $value["Person"]["id"] ?>"></a>
                                    <?php }?>
                                    <div class="dropdown-container" id='dropdown-container<?php echo $value["Person"]["id"] ?>' style="display: none; border:1px solid #e8e8e8;">

                                        <ul>

                                            <div style="width:100%;height:35px;" class="menu_users">
                                                <li style="width:150px;height:23px; margin:1px 0px 0px 1px;text-align: center; " class='active' id='active<?php echo $value["Person"]["id"]?>'>
                                                    <span style ="width:100%;height:100%;float:left" data="<?php echo $value["Person"]["id"]?>" class = "categorys ">կարգավիճակ</span></li>
                                                        <?php  if(isset($username) && !empty($username)){
                                                            
                                                        foreach ($username as $val) {
                                                            if($value["Person"]["id"] == $val["technical_data"]["data_id"]){
                                                               // var_dump($val["technical_data"]["id"]); 
                                                                ?>
                                                <li style="width:150px;height:23px; margin:1px 0px 0px 1px;text-align: center;">
                                                    <span style ="width:100%;height:100%;float:left"title="<?php echo $val["technical_data"]["id"] ?>"data_model='<?php echo $value["Person"]["id"]?>' alt="<?php echo $val["technical_data"]["modem"] ?>" data="<?php echo $val["technical_data"]["ip_range"] ?>" class = "user"><?php echo $val["technical_data"]["username"] ?></span></li>
                                                        <?php }}}?>
                                                <div class="<?php echo $value["Person"]["id"] ?>user_profile" style="display:inline">

                                                </div>
                                                <li style="width:150px;height:23px; margin:1px 0px 0px 1px;text-align: center;">
                                                    <button style ="z-index:9999;font-size:15px;padding:0px;height:20px;cursor:pointer;background: none;border: 0px solid;outline: 0; "value="<?php echo $value["Person"]["id"];?>" class="new_user">նոր օգտատեր</button>

                                            </div>
                                        </ul>
                                            <div id="<?php echo $value["Person"]["id"]?>output" class="output"style="position: relative" >
                                               
                                                   
                                                <div style='width:400px;float:left;'> 
                                                      <label style="display: block;color:#01a0e2;font-weight: bold;">Անձնական տվյալներ
                                                           <button class="edit" style="height:20px;font-size:14px;float:right;color: #fff;border: 1px solid green; background: #848484" value="<?php echo $value["Person"]["id"];?>">խմբագրել</button>
                                                      </label>
                                                <?php if ($value["Person"]) {
                                                            if($value["Person"]["change_legal"]){
                                                            ?>
                                               
                                                    <p style="border-bottom:1px solid #e8e8e8;" >
                                                        <span style='width:150px;float:left'>Ֆիզ.Անձ</span>
                                                        <span style="margin-left: 2px;font-weight: bold; "><?php echo $value["Person"]["firstname"] ?></span>
                                                        <span style="margin-left: 2px;font-weight: bold;"><?php echo $value["Person"]["lastname"] ?></span>
                                                    </p>
                                                    <p style="border-bottom:1px solid #e8e8e8;">
                                                        <span style='width:150px;float:left'>Անձնագիր</span>
                                                        <span style="margin-left: 2px;"><?php echo $value["Person"]["pasport_seria"] ?></span>
                                                        տրված է:
                                                        <span style="margin-left: 2px;"><?php echo $value["Person"]["add_pasport_time"] ?></span></p>
                                                    <p style="border-bottom:1px solid #e8e8e8;">
                                                        <span style='width:150px;float:left'>Մարզ,գյուղ</span>
                                                        <span><?php echo $value["Adress"]["city"]; ?> </span>  <span><?php echo  $value["Village"]["village_name"]; ?></span>
                                                    </p>
                                                   <p style="border-bottom:1px solid #e8e8e8;">
                                                        <span style='width:150px;float:left'>Փողոց,տուն</span>
                                                          <span><?php echo $value["Street"]["street_name"]; ?> </span> <span><?php echo  $value["Adress"]["home"]; ?></span>
                                                    </p>
                                                    
                                                    <?php }else{
                                                                    ?>
                                                        <p style="border-bottom:1px solid #e8e8e8;">
                                                            <span style='width:150px;float:left'>Ընկերություն</span>
                                                            <span> <?php echo $value["legal"]["company_name"]; ?> </span><span><?php if(isset($value["legal"]["company_name"])){echo $value["legal"]["type_company"]; }?></span>
                                                        </p>
                                                        <p style="border-bottom:1px solid #e8e8e8;">
                                                            <span style='width:150px;float:left'>Տնօրեն</span>
                                                            <span style="font-size: 15px;font-weight: bold;"><?php if($value["Person"]["firstname"] ) echo $value["Person"]["firstname"] ?></span>
                                                            <span style="font-size: 15px;font-weight: bold;"><?php if(isset($value["Person"]["lastname"] )){echo $value["Person"]["lastname"];}?></span>
                                                        </p>
                                                        
                                                        <p style="border-bottom:1px solid #e8e8e8;">
                                                            <span style='width:150px;float:left'>Բանկ</span>
                                                            <span> <?php if($value["legal"]["name_bank"])echo $value["legal"]["name_bank"]; ?> 
                                                            </span><span><?php if($value["legal"]["type_bank"])echo $value["legal"]["type_bank"]; ?></span>
                                                        </p>
                                                        <p style="border-bottom:1px solid #e8e8e8;">
                                                            <span style='width:150px;float:left'>հհ</span>
                                                            <span> <?php if($value["legal"]["account"])echo $value["legal"]["account"]; ?> </span>
                                                        </p>
                                                         <p style="border-bottom:1px solid #e8e8e8;">
                                                            <span style='width:150px;float:left'>ՀՎՀՀ</span>
                                                            <span><?php if($value["legal"]["tax"])echo $value["legal"]["tax"]; ?></span>
                                                        </p>
                                                        <p style="border-bottom:1px solid #e8e8e8;">
                                                            <span style='width:150px;float:left'>Մարզ</span>
                                                            <span><?php echo $value["Adress"]["city"]; ?> </span>
                                                        </p>
                                                        <p style="border-bottom:1px solid #e8e8e8;">
                                                            <span style='width:150px;float:left'>Գյուղ</span>
                                                            <span><?php echo $value["Village"]["village_name"]; ?></span>
                                                        </p>
                                                        <p style="border-bottom:1px solid #e8e8e8;">
                                                            <span style='width:150px;float:left'>Փողոց</span>
                                                            <span><?php echo $value["Street"]["street_name"]; ?></span>
                                                        </p>
                                                         <p style="border-bottom:1px solid #e8e8e8;">
                                                            <span style='width:150px;float:left'>Տուն</span>
                                                            <span><?php echo $value["Adress"]["home"]; ?></span>
                                                        </p>
                                                  
                                                               <?php }?>
                                                        <p style="border-bottom:1px solid #e8e8e8;">
                                                            <span style='width:150px;float:left'>Հեռ.</span>
                                                            <span> <?php echo $value["Telefon"]["tel_name"] ?></span>
                                                            <span> <?php echo $value["Telefon"]["telefon"] ?></span> <span> <?php echo $value["Telefon"]["tel1"] ?></span>
                                                            <span> <?php echo $value["Telefon"]["tel2"] ?></span>
                                                        </p>
                                                         
                                                         <?php if($value["Person"]["change_legal"]==0){
                                                                        ?>
                                                            <p style="border-bottom:1px solid #e8e8e8;">
                                                                <span style='width:150px;float:left'>Հեռ1.</span>
                                                                <span> <?php echo $value["legal_data"]["name"]." ".$value["legal_data"]["tel"]." ".$value["legal_data"]["pos"] ?></span>
                                                            </p>
                                                             <?php if($value["legal_data"]["tel1"]){ ?>
                                                            <p style="border-bottom:1px solid #e8e8e8;height:30px;">
                                                                <span style='width:150px;float:left;'>Հեռ2.</span>
                                                                 <span><?php echo $value["legal_data"]["name1"]." ".$value["legal_data"]["tel1"]." ".$value["legal_data"]["pos1"] ?></span>
                                                            </p>
                                                             <?php } if($value["legal_data"]["tel2"]){ ?>
                                                            <p style="border-bottom:1px solid #e8e8e8;">
                                                                <span style='width:150px;float:left'>Հեռ3.</span>
                                                               <span><?php echo $value["legal_data"]["name2"]." ".$value["legal_data"]["tel2"]." ".$value["legal_data"]["pos2"] ?></span>
                                                            </p>
                                                            
                                                                <?php }
                                                            }?>
                                                        <p style="border-bottom:1px solid #e8e8e8;">
                                                            <span style='width:150px;float:left'>Միացման օր</span>
                                                          <span ><?php echo $value["Technical"]["created"] ?></span>
                                                        </p>
                                                         <p style="border-bottom:1px solid #e8e8e8;">
                                                            <span style='width:150px;float:left'>Էլ․ հասցե</span>
                                                          <span ><?php echo $value["Person"]["email"] ?></span>
                                                        </p>
                                                         <p style="border-bottom:1px solid #e8e8e8;">
                                                            <span style='width:150px;float:left'>ՄԻացում Կատարող</span>
                                                          <span ><?php if($value["Person"]["con_person"]):echo $value["Person"]["con_person"];
                                                          elseif($value["Person"]["conperson_two"]):echo  $value["Person"]["conperson_two"];
                                                          elseif($value["Person"]["conperson_tree"]): echo $value["Person"]["conperson_tree"]; endif;?></span>
                                                        </p>
                                                        <p style="border-bottom:1px solid #e8e8e8;">
                                                            <span style='width:150px;float:left'>call history</span>
                                                            <span >
                                                                <button class="call_history" data="<?php echo $value["Person"]["id"] ?>" style="float: left; list-style: none;cursor: pointer;border-radius: 3px;border:none;background: #009c44;font-size: 14px;">դիտել</button>
                                                            </span>
                                                        </p>
                                                   
                                                   
                                                </div>  
                                                <div style="width:400px;float:left;margin-left: 10px;border-left:1px solid #ccc;">
                                                  <div class="problems" style="max-height: 300px;width:400px;float:left;margin-left: 10px;overflow-y:scroll;">
                                                    <label style="display: block;color:#01a0e2;font-weight: bold;">Խնդիրներ</label>
                                                    <button class = "add_problems" data="<?php echo $value["Person"]["id"]?>"
                                                            style="height:20px;font-size:14px;float:right;color: #fff;border: 1px solid green; background: #848484">ավելացնել</button>
                                                    <div class="add_problems_form"style="display:none">
                                                        <select class="problem_user<?php echo $value["Person"]["id"]?> problem_user" >
                                                            <?php if(isset($username) && !empty($username)){
                                                                 foreach ($username as $val) {
                                                                     if($value["Person"]["id"] == $val["technical_data"]["data_id"]){
                                                             ?>
                                                            <option value="<?php echo $val["technical_data"]["id"]?>"><?php echo $val["technical_data"]["username"]?></option>
                                                            <?php }}}?>
                                                        </select>
                                                        <textarea  class="problems_text<?php echo $value["Person"]["id"]?>" type ="text"
                                                                   style="border: 1px solid green;width:350px; max-width:350px;height:70px;">
                                                        </textarea>
                                                        <button class = "add_p" data = "<?php echo $value["Person"]["id"] ?>"
                                                                "style="color: #fff;border: 1px solid green; background: #01a0e2">ավելացնել</button>
                                                        <button class = "closee"style="color: #fff;border: 1px solid green; background: #01a0e2">չեղյալ համարել</button>

                                                    </div>
                                                    <div class="html_problem" id ="problem<?php echo $value["Person"]["id"]?>"></div>
                                                </div>
                                                <div class="comment" style="width:400px;float:left;margin: 20px 0px 0px 10px;border-top:1px solid #ccc;">
                                                  
                                                    <label style="display: block;color:#01a0e2;font-weight: bold;">մեկնաբանություն</label>
                                                   <?php  if(strpos(iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $value["Person"]["comment"]),"?")===0): echo $value["Person"]["comment"]; else: echo  iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $value["Person"]["comment"]); endif;?>
                                                    <button class = "add_comments" data="<?php echo $value["Person"]["id"]?>" style="height:20px;font-size:14px;float:right;color: #fff;border: 1px solid green; background: #848484">Ավելացնել</button>
                                                    <div class="add_comments_form"style="display:none">
                                                        <textarea  class="comments_text<?php echo $value["Person"]["id"]?>" type ="text"style="border: 1px solid green;width:350px; max-width:350px;height:70px;"> </textarea>

                                                        <button class = "add" data = "<?php echo $value["Person"]["id"] ?>"style="color: #fff;border: 1px solid green; background: #01a0e2">ավելացնել</button>
                                                        <button class = "close"style="color: #fff;border: 1px solid green; background: #01a0e2">չեղյալ համարել</button>

                                                    </div>
                                                    <div class="comment_html" id="com<?php echo $value["Person"]["id"]?>"> </div>
                                                </div>
                                                    </div>
                                                <div style="width:350px;height: 300px;float:left;margin-left: 30px;"> 
                                                    <label style="display: block;color:#01a0e2;font-weight: bold;">Քարտեզ</label>
                                                    <div id="map<?php  echo $value["Person"]["id"] ?>" style="border:1px solid #ccc;width:350px;height: 250px;">
                                                      
                                                    </div>
                                                        <div class="clear"></div>
                                                 </div>
 
                                             
                                              
                                                
                                            </div>
                                          <div class="clear"></div>
                                             <?php 
                                                    if(isset($username) && !empty($username)){
                                                          
                                                        foreach ($username as $val) {
                                                      
                                                            if($value["Person"]["id"] == $val["technical_data"]["data_id"]){
                                                                //var_dump($value["Technical"]["id"]); 
                                                                ?>

                                            <div id="<?php echo  $val["technical_data"]["id"]?>users" class="users" style="display:none;position:relative;">
                                               
                                                <div style="position:relative;" >
                                                    
                                                    <div style="float:left;border-right: 1px solid #e8e8e8">
                                                       
                                                         <label style="display: block;color:#01a0e2;font-weight: bold;border-bottom: 2px solid #ccc;">
                                                             Տեխնիկական տվյալներ
                                                             <button style="height:20px;font-size:14px;float:right;color: #fff;border: 1px solid green; background: #848484"class="tech_edit"value="<?php echo $val["technical_data"]["id"]?>">Խմբագրել</button>
                                                         </label>
                                                          
                                                        <div class="p" style="width:430px">
                                                            <p style="border-bottom:1px solid #ccc;">
                                                                  <span style='width:150px;font-weight: bold;color:red;font-size: 18px;'>ID</span>
                                                                  <span style='width:250px;font-weight: bold;color:red;font-size: 18px;'><?php echo '00'.$val["technical_data"]["unical_id"] ?></span>
                                                            </p>
                                                            <p style="border-bottom:1px solid #ccc;">
                                                                  <span style='width:150px;float:left'>Կապի տեսակ</span>
                                                                  <span ><?php echo $val["technical_data"]["con_type"] ?></span>
                                                            </p>
                                                            <p style="border-bottom:1px solid #ccc;">
                                                                 <span style='width:150px;float:left'>Կայան</span>
                                                                 <span ><?php echo $val["technical_data"]["station"] ?></span>
                                                                 <span > ip <?php echo $val["Station"]["station_ip"] ?></span>
                                                            </p>
                                                            <p style="border-bottom:1px solid #ccc;">
                                                                <span style='width:150px;float:left'>Մոդեմ</span>
                                                                <span class="modem_ping">
                                                                    
                                                                    <textarea id ='copy<?php echo $val["technical_data"]["id"] ?>' style="border:none; height:30px;  outline: none !important; max-width: 120px; width: 120px; max-height: 30px; "readonly class="js-copytextarea"><?php echo $val["technical_data"]["modem"] ?></textarea>
                                                                </span>
                                                            
                                                            </p>
                                                           
                                                            <p style="border-bottom:1px solid #ccc;">
                                                                  <span style='width:150px;float:left'>Վլան</span>
                                                                 <span><?php echo $val["technical_data"]["vlan"]; ?> </span>
                                                            </p>
                                                             <p style="border-bottom:1px solid #ccc;">
                                                                  <span style='width:150px;float:left'>ip_range</span>
                                                                 <span ><?php echo $val["technical_data"]["ip_range"] ?></span>
                                                             </p>
                                                              <div class="modemdrop">
                                                                          <button class="dropbtn">menu</button>
                                                                          <div class="modemdrop-content">
                                                                            <li  > <span class="modem_ping">
                                                                                            <button class='modem_ip'style="width: 100%;height:30px;border:none" target="blank" data="<?php echo $val["technical_data"]["modem"]?>">
                                                                                                <?php echo $val["technical_data"]["modem"] ?>
                                                                                            </button>
                                                                                       </span></li>
                                                                            <li >  <button class="js-textareacopybtn" data='<?php echo $val["technical_data"]["id"] ?>' style="width:100%;height:30px;border:none;">
                                                                                    Copy modem ip</button>
                                                                </li>
                                                                <li class='clients'><a href="?se=<?php echo $val["technical_data"]["modem"] ?>">Բաժանորդներ<a></li>
                                                                            <li class="clients_map"alt='<?php echo $value["Gps"]["gps"] ?>' data="<?php echo $val["technical_data"]["modem"] ?>">Քարտեզ</li>
                                                                            <li >Trace route</li>
                                                                          </div>
                                                                        </div>
                                                            
                                                            
                                                        </div>
                                                     
                                                        <div class="ping" style="display: none">պինգ:
                                                            <div>կորուստ:<span  class="loss"></span></div>
                                                            <div>միջին:<span  class="avg"></span></div>
                                                            <div>մաքսիմում:<span  class="max"></span></div>
                                                        </div>
                                                    </div>
                                                     <div style="float:left;margin-left:10px;width:350px;border-right: 1px solid #ccc">
                                                         
                                                        <label style="display: block;color:#01a0e2;font-weight: bold;">վճարումների ցանկ</label>
                                                       
                                                       
    <!--                                                        <button class="disable" alt="<?php echo $value["Technical"]["modem"] ?>" data="<?php echo $value["Technical"]["ip_range"] ?>">անջատել ինտերնետը</button>-->
                                                        <div class="read_payment" id="read_payment<?php echo $val["technical_data"]["id"]?>"></div>
                                                            <div style="float:left;width:350px;border-right: 1px solid #ccc">
                                                                <label style="display: block;color:#01a0e2;font-weight: bold;border-bottom: 1px solid #ccc">կարգավիճակ
                                                                    <span class="category<?php echo $val["Payment"]["id"]; ?>">
                                                                        <span class="active_cat<?php echo $val["technical_data"]["id"]?>"><?php if($val["Payment"]["category"] == 2){ echo "Ակտիվ"; }?></span>
                                                                        <span class="disabled_cat<?php echo $val["technical_data"]["id"]?>"><?php if($val["Payment"]["category"] == 0){ echo "Անջատված"; }?><?php if($val["Payment"]["category"] == 4){ echo "Հրաժարված"; }?></span>
                                                                        <span class="disabled_cat"><?php if($val["Payment"]["category"] == 1){ echo "Կասեցված "; echo $val["Payment"]["payday_now"];}?></span>
                                                                    </span>
                                                                </label>
                                                                <p style="border-bottom:1px solid #ccc;">
                                                                   <span style='width:150px;float:left'>Ակտիվ է մինջև</span>
                                                                   <span  class="<?php echo $val["Payment"]["id"];?>payday">
                                                                       <?php 
                                                                     
                                                                            if($val["Payment"]["pers_pay"]!="0"):
                                                                                echo $val["Payment"]["payday"]; 
                                                                            else: 
                                                                                echo "0000:00:00" ; endif;
                                                                       ?>
                                                                       
                                                                   </span>
                                                                 
                                                               </p>
                                                                 <?php if($val["Payment"]["pers_pay"] != "no"): ?>
                                                                 <p style="border-bottom:1px solid #ccc;">
                                                                   <i style='width:150px;float:left'>personalpay</i> 
                                                                   <input class = "pers_payment" type="number" style="width:60px;" data="<?php echo $val["Payment"]["id"];?>" id="<?php echo $val["Payment"]["id"];?>personalpay" value="<?php echo $val["Payment"]["pers_pay"]; ?>">
                                                                   <span class="pers_payments<?php echo $val["Payment"]["id"];?>"></span>
                                                                   <button class="disable_perpay" data="<?php echo $val["Payment"]["id"];?>" style="color:red">disable</button>
                                                               </p>
                                                               <?php endif;?>
                                                                 <p style="border-bottom:1px solid #ccc;">
                                                                   <span style='width:150px;float:left'>no-credit</span>
                                                                   <span  class="<?php echo $val["Payment"]["id"];?>no_credit">
                                                                       <?php if($val["Payment"]["no_credit"]): 
                                                                       echo "<input type='checkbox' id='nocredit".$val["Payment"]["id"]."' checked class='no_credit' data=".$val["Payment"]["no_credit"]." >";
                                                                       else: echo "<input type='checkbox' id='nocredit".$val["Payment"]["id"]."'  class='no_credit' data=".$val["Payment"]["no_credit"]." >"; endif ; ?>
                                                                       <button data="<?php echo  $val["Payment"]["id"]?>" class="save_nocredit">save</button></span>
                                                               </p>
                                                                <p style="border-bottom:1px solid #ccc;">
                                                                    <span style='width:150px;float:left'>Հաշվի մնացորդ</span>
                                                                    <span id="balance<?php echo $val["Payment"]["id"] ?>"><?php echo $val["Payment"]["balance"] ?></span>
                                                               </p>
                                                                <p style="border-bottom:1px solid #ccc;">
                                                                    <span style='width:150px;float:left'>Կրեդիտ</span>
                                                                    <span id="credit<?php echo $val["Payment"]["id"] ?>"> <?php echo $val["Payment"]["credit"]." " ?> օր</span>
                                                               </p>
                                                                <p style="border-bottom:1px solid #ccc;">
                                                                    <span style='width:150px;float:left'>Պարտք</span>
                                                                    <span id="counter_credit<?php echo $val["Payment"]["id"] ?>"> 
                                                                      <?php 
                                                                            $credit_date = $val["Payment"]["credit_date"]; 
                                                                            $datetime2 = new DateTime($credit_date);
                                                                            $datetime1 = new DateTime();
                                                                            $interval = $datetime2->diff($datetime1);
                                                                            $interval = $interval->format('%R%a');
                                                                            echo $val["Payment"]["counter_credit"];
                                                                        ?> Օր
                                                                  </span>
                                                               </p>
                                                            </div>
                                                        <div>
                                                            
                                                            <div class="form_parment none payment<?php  echo $val["Payment"]["id"];?>" >
                                                                <select id="payment_type<?php echo $val["technical_data"]["id"];?>">
                                                                    <option value="casa">casa</option>
                                                                    <option value="bank">bank</option>
                                                                </select>
                                                                <?php if(is_null($val["Payment"]["pers_pay"])): ?>
                                                                <input  class="payment_text" id="payment_text<?php echo $val["technical_data"]["id"];?>"value='<?php echo $val["Service"]["price"];?>' type ="text" placeholder="գումարը"
                                                                        style="border: 1px solid green; margin: 2px;width:180px;height:20px;" maxlength='6'>
                                                                <?php else:?>
                                                                <input  class="payment_text" id="payment_text<?php echo $val["technical_data"]["id"];?>"value='<?php echo $val["Payment"]["pers_pay"];?>' type ="text" placeholder="գումարը"
                                                                        style="border: 1px solid green; margin: 2px;width:180px;height:20px;" maxlength='6'>
                                                                <?php endif;?>
                                                                <button class = "add_payment" data = "<?php echo $val["technical_data"]["id"]; ?>"style="color: #fff;border: 1px solid green; background: #848484">վճարել</button>
                                                                <button class = "close_p"style="color: #fff;border: none; background: red">x</button>

                                                            </div>
                                                            <div class='pay_div'>
                                                                <?php  if(isset($credit_default)):
                                                                        $datetime2 = new DateTime($val["Payment"]["payday"]);
                                                                        $datetime1 = new DateTime();
                                                                        $interval = $datetime2->diff($datetime1);
                                                                        $interval = (int)$interval->format('%R%a');
                                                                        $pay_id = (int)$val["Payment"]["id"];
                                                                        $tech_id = (int)$val["technical_data"]["id"]; ;
                                                                        $category = (int)$val["Payment"]["category"];
                                                                        $credit = (int)$val["Payment"]["credit"];
                                                                       
                                                                        endif;
                                                                ?>
                                                         
                                                             <button class="payment_continue"id='payment_continue<?php echo $val["Payment"]["id"]; ?>' <?php if($category == 1):?>style="display:inline"<?php else: ?>style='display:none' readonly<?php endif; ?> alt="<?php echo $val["Payment"]["id"]; ?>" data="<?php echo $val["technical_data"]["id"]; ?>">Շարունակել</button>
                                                             <button class="add_credit button_pay"id='add_credit<?php echo $val["Payment"]["id"]; ?>' <?php if(($interval - $credit_default)>=0 || $category ==0  || $category == 4):?>style="display:inline"<?php else: ?>style='display:none' readonly<?php endif; ?> alt="<?php echo $pay_id;?>" data="<?php echo $tech_id ?>">Տալ Կրեդիտ</button>
                                                             <button class="payment button_pay" id="paymentadd<?php echo $pay_id; ?>"<?php if($category ==2 || $category == 0 || $category == 4):?>style="display:inline"<?php else: ?>style='display:none' readonly <?php endif; ?>  alt="<?php echo $pay_id; ?>" data="<?php echo $tech_id;?>">կատարել վճարում</button>
                                                             <button class="change_category button_pay" id='change_category<?php echo $pay_id; ?>' <?php if($category ==2 ):?>style="display:inline"<?php else: ?>style='display:none' readonly<?php endif; ?>  alt="<?php echo $pay_id; ?>" data="<?php echo $tech_id; ?>">Փոխել կարգավիճակը</button>
                                                             <button class="add_day button_pay" id="add_day<?php echo $pay_id; ?>" <?php if($category ==2 && $credit==0):?>style="display:inline"<?php else: ?>style='display:none' readonly<?php endif; ?>  alt="<?php echo $pay_id; ?>" data="<?php echo $tech_id; ?>">Ավելացնել օր</button>
                                                                
                                                            <div style="display:none" class="add_day<?php echo $val["Payment"]["id"]; ?> none">
                                                                <input type="number" class="<?php echo $val["Payment"]["id"]; ?>day">
                                                                <button data="<?php echo $val["Payment"]["id"]; ?>"style="color: #fff;border: 1px solid green; background: #848484" class="changeed_day">Ավելացնել</button>
                                                                <button class = "close_p"style="color: #fff;border: none; background: red">x</button>
                                                            </div>
                                                            <div style="display:none" class="add_credit<?php echo $val["Payment"]["id"]; ?> none">
                                                                <input type="number" class="<?php echo $val["Payment"]["id"]; ?>add_credit">
                                                                <button data="<?php echo $val["Payment"]["id"]; ?>" style="color: #fff;border: 1px solid green; background: #848484" class="changeed_credit">Ավելացնել</button>
                                                                <button class = "close_p"style="color: #fff;border: none; background: red">x</button>
                                                            </div>
                                                            <div class="change_category<?php echo $val["Payment"]["id"]; ?> none" style="display:none">
                                                                     <?php  if(isset($credit_default)){
                                                                        $date2 = $newDate = date("Y-m-d", strtotime($val["Payment"]["credit_date"]));
                                                                        $date1 = date("Y-m-d");
                                                                        $datetime1 = date_create($date1);
                                                                        $datetime2 = date_create($date2);
                                                                        $interval = date_diff($datetime1, $datetime2);
                                                                        $interval = (int) $interval->format('%R%a');
                                                                     }
                                                                        echo $interval;?>
                                                                <select data ="<?php  echo $val["Service"]["price"]?>"alt="<?php echo $interval;?>" class="selected<?php echo $val["Payment"]["id"]; ?>">
                                                                 
                                                                   <?php  if(isset($credit_default)){
                                                                        $date2 = $newDate = date("Y-m-d", strtotime($val["Payment"]["credit_date"]));
                                                                     
                                                                        $date1 = date("Y-m-d");
                                                                        $datetime1 = date_create($date1);
                                                                        $datetime2 = date_create($date2);
                                                                        $interval = date_diff($datetime1, $datetime2);
                                                                        $interval = (int) $interval->format('%R%a');
                                                                       if(($interval )<=0):
                                                                          
                                                                         ?>  <option value="0">Անջատել</option>
                                                                           <?php
                                                                       else:
                                                                          ?>    <option value="4">Հրաժարվել</option>
                                                                           <?php
                                                                       endif;
                                                                   }?>
                                                                    <option value="1">Կասեցնել</option>
                                                                </select>
                                                                <button style="color: #fff;border: 1px solid green; background: #848484" data="<?php echo $val["Payment"]["id"]; ?>" class="changeed_button">Փոփոխել</button>
                                                                <button class = "close_p"style="color: #fff;border: none; background: red">x</button>
                                                            </div>
                                                            <div style="margin:20px 0px;" class="payment_append payment_append<?php echo $val["Payment"]["id"]; ?>">
                                                                
                                                            </div>
                                                            </div>
                                                        </div>
                                                         
                                                    </div>
                                                    <div class="estate" style="float:left;margin-left: 14px;width:420px">
                                                          <label style="display: block;color:#01a0e2;font-weight: bold;">Գույք կցված օգտատիրոջը</label>
                                                        <div class="user_property"></div>
                                                        
                                                       <div class="read_property" id='read<?php echo $val["technical_data"]["id"];?>'> </div>
                                                       <label style="display: block;color:#01a0e2;font-weight: bold;">Ավելացնել</label>
                                                             <?php if(isset($team)){ ?>
                                                        <select style="width:150px;color: #fff;border: 1px solid green; background: #848484"   Autocomplete = "off" placeholder="նշեք ծառաությունը" maxlength="50"
                                                                type="text" class="con_person" data="<?php echo $val["technical_data"]["id"] ?>" id="con_person<?php echo $value["Person"]["id"] ?>" required="required">
                                                                <option selected="false" value="0" style="display:none;" disabled="disabled">Նշեք անունը</option>
                                                                 <?php foreach ($team as $values) { ?>
                                                                        <option value='<?php echo $values["Team"]["username"]?>'>
                                                                                    <?php echo $values["Team"]["firstname"]; ?>
                                                                                    <?php echo $values["Team"]["lastname"]; ?>
                                                                        </option>
                                                                    <?php } ?>
                                                        </select>
                                                            <?php }?>
                                                            
                                                       <button class="team_ok"   style='color: #fff;border: 1px solid green; background: #848484'data-bind="<?php echo $val["technical_data"]["id"] ?>" alt="<?php echo $value["Person"]["con_person"] ?>" data="<?php echo $value["Person"]["id"] ?>">հաստատել</button>
                                                        <button class="delete_ok"  style='color: #fff;border: none; background: red'>x</button>
                                                       <div class="table_Prod" id="table_Prod<?php echo $val["technical_data"]["id"] ?>"> </div>

                                                    </div>
                                                   <div class="clear"></div>
                                                </div>
                                            </div>
                                                     <?php }
                                                    }}
                                                ?>
                                    </div>



                                    </ul>
                                </div>


                    </div>

                    </td> 

                    </tbody>
                                <?php
                            }
                        }
                    }
                    ?>
                </table>
            </div>
            <div id="alert"></div>
           
        </div>
        </div>
          
         <div class="opacity"></div>
           <div style="position: absolute; left: 20%;top:3%;">
               <div style="position: relative; left: -50%;top:-50%;height:auto;">
                  
                   <div class="maps" style="z-index: 9999"></div>
               </div>
           </div>
        <script language="JavaScript">
                        var copyTextareaBtn = $(".js-textareacopybtn");

                        copyTextareaBtn.on('click', function(event) {
                            var data = $(this).attr("data");
                            console.log(data);
                          var copyTextarea = document.querySelector("#copy"+data+"");
                          copyTextarea.select();
                
                          try {
                            var successful = document.execCommand('copy');
                            
                            var msg = successful ? 'successful' : 'unsuccessful';

                          } catch (err) {

                          }
                        });
        </script>

    </body>

</html>
