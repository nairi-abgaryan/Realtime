<html>
<head>
	<head>
            <?php echo $this->Html->charset('utf-8'); ?>
            <?php echo $this->Html->css('style'); ?>
            <?php echo $this->Html->css('connectors'); ?>
            <?php echo $this->Html->css('problem'); ?>
            <?php echo $this->Html->script('jquery'); ?>
            <?php echo $this->Html->script('objects'); ?>
            <?php echo $this->Html->script('custom'); ?>
            <?php echo $this->Html->script('user'); ?>
	</head>
       
<body>
       <div><button class="export">export exel </button></div>
       <div class="auth_user" data="<?php if( isset($auth_user)){ echo $auth_user["username"]; };?>"></div>
     <div class = "logout"><a href="/users/logout">ելք</a></div>
      <div class="new_user_technical">
       
        <div id="technical" style="position:fixed"></div></div>
	<div class = "mypage">
            <div class='container'>
		<div class="ClientResults">
	          <div class="ClientResults">
                      <div class="problem" style="width: 100%;font-size:17px;font-weight: bold;height: 30px;">Խնդիրներ</div>
                      <table style="width:100%" id="headerTable">
                    <thead class="ClientResult">
                        <tr>
                             <td ><div style="width:35px">№</div></td>
                            <td>Օր</td>
                            <td><?php 
                                if(isset($direction)){
                                    if($direction == "asc" || $direction=="desc"){
                                        echo "<a href='/realtimes/problem_list/sort:created/direction:".$direction."'>Գրանցում</a>"; 
                                    }else{
                                        echo "<a href='/realtimes/problem_list/sort:created/direction:desc'>Գրանցում</a>"; 
                                    }
                                }
                               ?></td>
                            <td>ԱԱ</td>
                            <td><?php 
                                if(isset($direction)){
                                    if($direction == "asc" || $direction=="desc"){
                                        echo "<a href='/realtimes/problem_list/sort:Adress.city/direction:".$direction."'>Մարզ</a>"; 
                                    }else{
                                        echo "<a href='/realtimes/problem_list/sort:Adress.city/direction:desc'>Մարզ</a>"; 
                                    }
                                }
                               ?></td>
                            <td><?php 
                                if(isset($direction)){
                                    if($direction == "asc" || $direction=="desc"){
                                        echo "<a href='/realtimes/problem_list/sort:desc/direction:".$direction."'>Հասցե</a>"; 
                                    }else{
                                        echo "<a href='/realtimes/problem_list/sort:desc/direction:desc'>Հասցե</a>"; 
                                    }
                                }
                               ?></td>
                            <td>Հեռախոսահամարներ</td>
                            <td >Մեկնաբանություն</td>
                            <td >Կատարողի Մեկնաբանություն</td>
                            <td>Գրանցող</td>
                            <td>Խմբագրել</td>
                            <td>Ավարտ</td>
                        </tr>
                    </thead>
                    <tbody class="StyleClientResult">
                    
                        <?php if(isset($data)){ $i=0; ?>
                        <?php   foreach ($data as $value) {  $i++; ?>
                            <tr>
                                <td ><div style="width:35px"><?php echo $i;?></div></td>
                                <td> <?php 
                                    date_default_timezone_set('Etc/GMT-4');
                                    $time = $value["problem"]["created"];
                                    $datetime1 = new DateTime($time);
                                    $datetime2 = new DateTime();
                                    $interval = $datetime1->diff($datetime2);
                                    echo $interval->format('%R%a');
                                    ?>
                                </td>
                                <td><?php 
                                $time = $value["problem"]["created"];
                                    echo date("d.m.y H:i", strtotime($time));
                                 ?>
                                </td>
                                
                                <td>
                                    <?php echo $value["technical_data"]["username"];?>
                                </td>
                                <td>
                                    <?php echo $value["Adress"]["city"];?>
                                </td>
                                <td><p class="ex">
                                    <?php echo $value["Village"]["village_name"]; if($value["Adress"]["street_id"]){
                                        echo ",". $value["Street"]["street_name"];
                                        if($value["Adress"]["home"]){
                                            echo ",". $value["Adress"]["home"];
                                        }
                                    } ?></p>
                                </td>
                                <td><?php echo $value["Telefon"]["telefon"];
                                        echo ",".$value["Telefon"]["tel_name"];
                                        ?></td>
                                <td ><p class="ex"><?php echo $value["problem"]["comment"] ?></p></td>
                              
                                  <td ><p class="ex" id='comment_team<?php echo $value["problem"]["id"] ?>'><?php echo $value["problem"]["comment_team"] ?></p></td>
                                 <td>
                                     <?php echo $value["problem"]["reg_person"]; ?>
                                 </td>
                             
                                 <td>
                                    <?php if(isset($value["problem"]["pro_person"]) || isset($value["problem"]["pro_persontree"]) || isset($value["problem"]["pro_persontwo"])){?>
                                        <button class="edit_problem" data="<?php if(isset($username)): echo $username; endif;?>" style="" value="<?php echo $value["problem"]["id"]?>">Խմբագրել</button><?php
                                    }?>
                                 </td>
                                <td>
                                    <?php if(isset($value["problem"]["pro_person"]) || isset($value["problem"]["pro_persontree"]) || isset($value["problem"]["pro_persontwo"])){?>
                                        <button class="end_problems" style="" value="<?php echo $value["problem"]["id"]?>">ավարտել</button><?php
                                    }?>
                                </td>
                             
                            </tr>
                            
                        <?php }} 
                       ?> <tr>
                                <td colspan="9">
                                     <div class="problem" style="width: 100%;font-size:17px;font-weight: bold;height: 30px;">ՄԻացումներ</div>
                                </td>
                            </tr><?php
                        if(isset($people)){
                            $i = 0;
                            foreach ($people as $values) { $i++;?> 
                            
                            <tr>
                                  <td ><div style="width:35px"><?php echo $i;?></div></td>
                                <td> <?php
                                    date_default_timezone_set('Etc/GMT-4');
                                    $time = $values["Person"]["created"];
                                    $datetime1 = new DateTime($time);
                                    $datetime2 = new DateTime();
                                    $interval = $datetime1->diff($datetime2);
                                    echo $interval->format('%R%a');
                                    ?></td>
                                <td><?php 
                                $time = $values["Person"]["created"];
                                    echo date("d.m.y H:i", strtotime($time));
                                 ?></td>
                                <td><?php if($values["Person"]["change_legal"] == 1){ echo $values["Person"]["firstname"]; ?><br/>
                                <?php echo $values["Person"]["lastname"]; }else{
                                    echo $values["legal"]["company_name"]; ?><br/>
                                    <?php echo $values["legal"]["type_company"];
                                }?></td>
                                <td><?php echo $values["Adress"]["city"] ?></td>
                                <td style="text-align: center;width:100px;word-break: break-all;">
                                    <?php echo $values["Village"]["village_name"]; if($values["Adress"]["street_id"]){
                                        echo ",". $values["Street"]["street_name"];
                                        if($values["Adress"]["home"]){
                                            echo ",". $values["Adress"]["home"];
                                        }
                                    } ?>
                                </td> 
                                <td>  <div style="text-align: center;width:150px;word-break: break-all;"><?php echo $values["Telefon"]["telefon"];
                                        if($values["Telefon"]["tel1"])
                                            echo ",".$values["Telefon"]["tel1"];
                                        if($values["Telefon"]["tel2"])
                                            echo ",".$values["Telefon"]["tel2"];
                                        echo ",".$values["Telefon"]["tel_name"];
                                        ?></div></td>
                                <td  ><?php echo $values["Person"]["comment"] ?></td>
                                
                                <td  ><div class="comm_team<?php echo $values["Person"]["id"] ?>">
                                    <?php echo $values["Person"]["comment_team"] ?></div></td>
                                <td><?php echo $values["Person"]["auth_user"] ?></td>
                             
                                <td>
                                   
                                  
                                </td>
                                <td>
                                     <?php  if(isset($values["Person"]["con_person"]) || isset($values["Person"]["conperson_two"]) || isset($values["Person"]["conperson_tree"])){?>
                                    <button class="edit_conn_problem_list" style="" value="<?php echo $values["Person"]["id"]?>"> Խմբագրել</button><?php
                                    }?>
                                </td>
                            </tr>
                        <?php }} ?>
                        </div>
                    </tbody>
                    
                </table>
                     
            </div>
		</div>
	 
           
	</div>
     <div class="opacity" style="width:150%"></div>
        </div>
       
</body>
            <div style="position: absolute; left: 50%;top:30%;">
               <div style="position: relative; left: -50%;top:-50%; width:500px;height:auto;z-index:9999;">
                   <button class="closes"style="display:none;position: absolute;right:0px;top:0px;">x</button>
                   <div class="form" style="width:500px"></div>
               </div>
           </div>
          
            
            <div style="position: absolute; left: 50%;top:30%;">
               <div style="position: relative; left: -50%;top:-50%;height:auto;">
                    <div class="archives" style="z-index: 9999"></div>
               </div>
           </div>
            
</html>
<?php die();?>
