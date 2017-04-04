<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset('utf8'); ?>
        <?php echo $this->Html->css('style'); ?>
        <?php echo $this->Html->css('connectors'); ?>
    </head>
     
    <body>
         
        <div class = "mypage" >
            <div class="out_menu" >
        
        <div class='top_menu' style="display:none">
             
            <ul >
              
            <li >
                <a class="home" href="/realtimes/search">Ընդհանուր  </a>
            </li>
            <li >
                <a href = "/realtimes/problems">Խնդիրներ</a>
            </li>
            <li >
                <a  href = "/realtimes/connectors">Միացումներ</a>
            </li>
            <li style="margin-left:120px;">
                <a  href = "/manegements/tools">Կառավարում</a>
            </li>
           
        </ul>
           
            <div class='search_con'>
                <form method="POST" action="connectors"  class="search_conetores">
                    <input type="text" name="search_con" type="search" style="z-index:9999; margin-top:30px; width:400px; border:1px solid #2ECCFA; height:15px;" 
                           name="search"class="search_con_conn" id="search" placeholder="search" tabindex="1"
                           autocomplete="off" maxlength="400" autocorrect="off" autocapitalize="off" spellcheck="false" aria-autocomplete="list"/>
                    <input type="submit" value="Որոնել" id='search_con_conn' >
                </form>
            </div>
            <div class="addClientLink" >
                <a id="addClientLinks" >ավելացնել նոր գրանցում </a>
<!--                <a id="print">տպել</a> 
                <a id="created_people">կատարված միացումներ</a>-->
            </div>
            <div class="table_list">
                <table>
             <thead class="ClientResult" style="position:fixed">
                        <tr>
                            <td><div style="width:35px">№</div></td>
                            <td><div style="margin-left:1px;width:43px;">Օր</div></td>
                            <td><div style="width:80px;"><?php 
                                if(isset($direction)){
                                    if($direction == "asc" || $direction=="desc"){
                                        echo "<a href='/realtimes/connectors/sort:created/direction:".$direction."'>Գրանցում</a>"; 
                                    }else{
                                        echo "<a href='/realtimes/connectors/sort:created/direction:desc'>Գրանցում</a>"; 
                                    }
                                }
                               ?></div>
                            </td>
                            <td><div style="width:150px;">ԱԱ</div></td>
                            <td><div style="width: 150px"><?php 
                                if(isset($direction)){
                                    if($direction == "asc" || $direction=="desc"){
                                        echo "<a href='/realtimes/connectors/sort:desc/direction:".$direction."'>Հասցե</a>"; 
                                    }else{
                                        echo "<a href='/realtimes/connectors/sort:desc/direction:desc'>Հասցե</a>"; 
                                    }
                                }
                               ?></div>
                            </td>
                            <td><div style="width:80px;">Հեռ.</div></td>
                            <td><div style="width:180px;">Մեկնաբանություն</div></td>
                             <td><div style="width:180px;">Կատարողի Մեկ․</div></td>
                            <td><div style="width:160px;">Կատարող</div></td>
                            <td><div style="width:80px;">Գրանցող</div></td>
                            <td><div style="width:66px;">Սկիզբ</div></td>
                            <td><div style="width:80px;">Ավարտ</div></td>
                            <td><div style="width:80px;">խմբագրել</div></td>
                        </tr>
                    </thead>
                </table>
                    <div ><a style="right: 10px;z-index: 9999;margin-left: -50px;position:absolute;cursor:pointer;color:#01a0e2;background:#fff;top:10px;padding:10px;text-decoration: none;"href="/users/logout">ելք</a></div>
            </div>
        </div>
    </div>
           
            <div class='search_con'>
                <form method="POST" action="connectors"  class="search_conetores">
                    <input type="text" name="search_con" type="search" style="z-index:9999; margin-top:30px; width:400px; border:1px solid #2ECCFA; height:15px;" 
                           name="search" class="search_conc" id="search" placeholder="search" tabindex="1"
                           autocomplete="off" maxlength="400" autocorrect="off" autocapitalize="off" spellcheck="false" aria-autocomplete="list"/>
                    <input type="submit"value="Որոնել" id='click_serarchc' >
                </form>
            </div>
            <div class="addClientLink">
                <a id="addClientLink" >ավելացնել նոր գրանցում </a>
<!--            <a id="print">տպել</a> 
                <a id="created_people">կատարված միացումներ</a>-->
            </div>
            
        
            <div class="ClientResults">
                <table>
                    <thead class="ClientResult">
                        <tr>
                            <td ><div style="width:35px">№</div></td>
                            <td><div style="width:43px">Օր</div></td>
                            <td> <div style="width:80px;"><?php 
                                if(isset($direction)){
                                    if($direction == "asc" || $direction=="desc"){
                                        echo "<a href='/realtimes/connectors/sort:created/direction:".$direction."'>Գրանցում</a>"; 
                                    }else{
                                        echo "<a href='/realtimes/connectors/sort:created/direction:desc'>Գրանցում</a>"; 
                                    }
                                }
                                ?></div>
                            </td>
                            <td>ԱԱ</td>
                            <td <div style="width: 150px"><?php 
                                if(isset($direction)){
                                    if($direction == "asc" || $direction=="desc"){
                                        echo "<a href='/realtimes/connectors/sort:desc/direction:".$direction."'>Հասցե</a>"; 
                                    }else{
                                        echo "<a href='/realtimes/connectors/sort:desc/direction:desc'>Հասցե</a>"; 
                                    }
                                }
                               ?>
                            </div> </td>
                            <td><div style="width:80px;">Հեռ.</div></td>
                            <td><div style="width:180px;">Մեկնաբանություն</div></td>
                            <td><div style="width:180px;">Կատարողի Մեկ․</div></td>
                            <td>Կատարող</td>
                            <td>Գրանցող</td>
                            <td>Սկիզբ</td>
                            <td>Ավարտ</td>
                            <td>խմբագրել</td>
                        </tr>
                    </thead>
                    <tbody class="StyleClientResult" id="tbody_con">
                  
                        <?php if(isset($value)){ $i = 0;?>
                        <?php foreach ($value as $value) { $i++; ?>
                        <tr data="<?php echo $i; ?>" >
                              <td><?php echo $i;?></td>
                                <td><div style="width:43px"> <?php
                                    date_default_timezone_set('Etc/GMT-4');
                                    $time = $value["Person"]["created"];
                                    $datetime1 = new DateTime($time);
                                    $datetime2 = new DateTime();
                                    $interval = $datetime1->diff($datetime2);
                                    echo $interval->format('%R%a');
                                    ?></div></td>
                                <td><?php 
                                $time = $value["Person"]["created"];
                                    echo date("d.m.y H:i", strtotime($time));
                                 ?></td>
                                <td><div style="width:150px;">
                                    <?php if($value["Person"]["change_legal"] == 1){ echo $value["Person"]["firstname"]; ?><br/>
                                <?php echo $value["Person"]["lastname"]; }else{
                                    echo $value["legal"]["company_name"]; ?><br/>
                                    <?php echo $value["legal"]["type_company"];
                                }?></div></td>
                               
                                <td >
                                    <div style="text-align: center;width:150px;word-break: break-all;">
                                    <?php echo $value["Adress"]["city"]." ";
                                     echo $value["Village"]["village_name"]."<br>";
                                     if($value["Adress"]["street_id"]){
                                        echo  $value["Street"]["street_name"];
                                        if($value["Adress"]["home"]){
                                            echo ",". $value["Adress"]["home"]."<br>";
                                        }
                                    } ?>
                                        </div>
                                </td>
                                <td><div style="text-align: center;width:80px;word-break: break-all;">
                                    <?php 
                                        echo $value["Telefon"]["telefon"]."<br>";
                                        if($value["Telefon"]["tel1"])
                                            echo $value["Telefon"]["tel1"]."<br>";
                                        if($value["Telefon"]["tel2"])
                                            echo $value["Telefon"]["tel2"]."<br>";
                                        echo $value["Telefon"]["tel_name"]."<br>";
                                        ?></div></td>
                                <td  ><div style="width:180px;"><?php echo $value["Person"]["comment"] ?></div></td>
                                <td  ><div style="width:180px;"><?php echo $value["Person"]["comment_team"] ?></div></td>
                                <td style="position: relative;width:170px">
                                    <div id="cre_persons<?php  echo (int)$value["Person"]["id"];?>" style='font-size:12px;'>
                                    <?php if($value["Person"]["con_person"] || $value["Person"]["conperson_tree"] || $value["Person"]["conperson_two"]){
                                        ?>
                                 
                                    <div id='con_persons<?php  echo $value["Person"]["id"];?>'  >
                                            <select  name = "con_person" id='con_person<?php  echo $value["Person"]["id"];?>'>
                                                  <option selected="false" value style="display:none;" disabled="disabled">Նշեք անունը</option>
                                                  <?php if(isset($mexanik)){
                                                         foreach ($mexanik as $values) {?>
                                                     <option value="<?php echo $values["Team"]["username"];?>"><?php echo $values["Team"]["username"];?></option>
                                                   <?php }}?>
                                             </select>
                                           <button class="con_persons" value="<?php  echo $value["Person"]["id"];?>">+</button>
                                   </div>
                                    <?php if($value["Person"]["con_person"]):?>
                                    <div id='con_p<?php  echo $value["Person"]["con_person"]; echo $value["Person"]["id"]?>' style='font-size:13px;font-weight: bold;'><?php
                                       echo $value["Person"]["con_person"];
                                       ?>
                                        <button data="con_person" alt='<?php echo $value["Person"]["con_person"]?>' class="delete" style="font-weight: bold;color:#fff;width:20px;background: red;position: absolute;right: 6px;" 
                                                value="<?php echo $value["Person"]["id"]?>">x</button>
                                    </div>
                                    <?php endif;?>
                                     <?php if($value["Person"]["conperson_two"]):?>
                                         <div id='con_p<?php  echo $value["Person"]["conperson_two"]; echo $value["Person"]["id"];?>'style='font-size:13px;font-weight: bold;'><?php
                                                echo $value["Person"]["conperson_two"];
                                                ?>
                                                 <button data='conperson_two' alt='<?php echo $value["Person"]["conperson_two"]?>' class="delete" style="font-weight: bold;color:#fff;width:20px;background: red;position: absolute;right: 6px;" 
                                                         value="<?php echo $value["Person"]["id"]?>">x</button>
                                             </div>
                                    <?php endif;?>
                                     <?php if($value["Person"]["conperson_tree"]):?>
                                        <div id='con_p<?php  echo $value["Person"]["conperson_tree"]; echo $value["Person"]["id"]?>' style='font-size:13px;font-weight: bold;'><?php
                                                echo $value["Person"]["conperson_tree"];
                                                ?>
                                                 <button data="conperson_tree" alt='<?php echo $value["Person"]["conperson_tree"]?>' class="delete" style="font-weight: bold;color:#fff;width:20px;background: red;position: absolute;right: 6px;" 
                                                         value="<?php echo $value["Person"]["id"]?>">x</button>
                                        </div>
                                    </div>
                                    <?php endif;?>
                                   <?php
                                    } else{ ?>
                                       <div id='con_persons<?php  echo $value["Person"]["id"];?>'>
                                            <select  name = "con_person" id='con_person<?php  echo $value["Person"]["id"];?>'>
                                                  <option selected="false" value style="display:none;" disabled="disabled">Նշեք անունը</option>
                                                  <?php if(isset($mexanik)){
                                                         foreach ($mexanik as $values) {?>
                                                     <option value="<?php echo $values["Team"]["username"];?>"><?php echo $values["Team"]["username"];?></option>
                                                   <?php }}?>
                                             </select>
                                           <button class="con_persons" value="<?php  echo $value["Person"]["id"];?>">+</button>
                                        </div>
                                       <div id='con_p<?php  echo $value["Person"]["id"];?>'></div>
                                  <?php }?>
                                </td>
                                
                                <td><div style="width:70px;"><?php echo $value["Person"]["auth_user"] ?></div></td>
                                <td><?php 
                                    $times = $value["Person"]["modified"];
                                    echo date("d.m.y H:i", strtotime($times )); ?></td>
                                <td>
                                    <?php if($value["Person"]["con_person"] || $value["Person"]["conperson_two"] || $value["Person"]["conperson_tree"]){ 
                                            if($value["Person"]["con_person"]):?>
                                                <button class="endConnection"  id='endConnection<?php echo $value["Person"]["id"]?>' style="color:#fff" value="<?php echo $value["Person"]["id"]?>">ավարտել</button>
                                                <?php else: ?><button class="endConnection" id='endConnection<?php echo $value["Person"]["id"]?>' style="color:#fff" value="<?php echo $value["Person"]["id"]?>">ավարտել</button><?php  endif;?>
                                                <button class="endCon_history" id='endCon_history<?php echo $value["Person"]["id"]?>' style="color:#fff" value="<?php echo $value["Person"]["id"]?>">հրաժարվել</button><?php
                                      }else{ ?>
                                          <button class="endConnection" id='endConnection<?php echo $value["Person"]["id"]?>' style="display:none;color:#fff" value="<?php echo $value["Person"]["id"]?>">ավարտել</button>
                                         <button class="endCon_history" id='endCon_history<?php echo $value["Person"]["id"]?>' style="display:none;color:#fff" value="<?php echo $value["Person"]["id"]?>">հրաժարվել</button><?php
                                    }?>
                                </td>
                                <td> <button style="background:#009c44;color:#fff" class="edit_con" value="<?php echo $value["Person"]["id"]?>">խմբագրել</button></td>
                            </tr>
                        <?php }} ?>
                        
                    </tbody>

                </table>
            </div>
            <div class="addClientForm"></div>
            
            <div class="legalpersonForm"></div>
           
        </div>
       
            <div style="position: absolute; left: 50%;top:30%;">
               <div style="position: relative; left: -50%;top:-50%; width:800px;height:auto;">
                   <div class="personForm" ></div>
               </div>
           </div>
           
           <div style="position: absolute; left: 50%;top:30%;">
               <div style="position: relative; left: -50%;top:-50%; width:800px;height:auto; ">
                   <button class="close"style="display:none;position: absolute;right:-22px;top:0px;z-index: 9999">x</button>
                   <div class="cre_person" ></div>
               </div>
           </div>
        <div class="input_pro">
            
        </div>
        <div class="opacity"></div>
          
            <div style="position: absolute; left: 55%;top:90%;">
               <div style="position: relative; left: -50%;top:90%; width:800px;height:auto; ">
                   <div class="load_img" style="position:fixed;margin-left: 300px;"></div> 
               </div>
           </div>
    </body>
    <div id="scripts">
        <?php echo $this->Html->script('custom'); ?>
        <?php echo $this->Html->script('user'); ?>
    </div>
</html>