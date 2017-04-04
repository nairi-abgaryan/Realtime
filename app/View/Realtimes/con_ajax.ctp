<?php if(isset($value) && isset($i)){ ?>
                        <?php foreach ($value as $value) { $i++; ?>
                            <tr>
                                <td><div style="width:35px"> <?php echo $i?></div></td>
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
                                <td><div style="width:150px;"><?php if($value["Person"]["change_legal"] == 1){ echo $value["Person"]["firstname"]; ?><br/>
                                <?php echo $value["Person"]["lastname"]; }else{
                                    echo $value["legal"]["company_name"]; ?><br/>
                                    <?php echo $value["legal"]["type_company"];
                                    }?></div></td>
                               
                                <td>
                                    <div style="text-align: center;width:150px;word-break: break-all;">
                                    <?php echo $value["Adress"]["city"]." ";
                                     echo $value["Village"]["village_name"]; 
                                     echo "<br>";
                                     if($value["Adress"]["street_id"]){
                                        echo  $value["Street"]["street_name"];
                                        if($value["Adress"]["home"]){
                                            echo ",". $value["Adress"]["home"];
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
                                <td style="position: relative;">
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
                                
                                <td><div style="width:70px;word-break: break-all;"><?php echo $value["Person"]["auth_user"] ?></div></td>
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
                        <?php }} die();?>