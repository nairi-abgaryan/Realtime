<html>
<head>
	<head>
            <?php echo $this->Html->charset('utf8'); ?>
            <?php echo $this->Html->css('style'); ?>
            <?php echo $this->Html->css('connectors'); ?>
            <?php echo $this->Html->css('problem'); ?>
            <?php echo $this->Html->script('jquery'); ?>
            <?php echo $this->Html->script('objects'); ?>
            <?php echo $this->Html->script('custom'); ?>
            <?php echo $this->Html->script('user'); ?>
	</head>
       
<body>
      <div class="new_user_technical">

        <div id="technical" style="position:fixed"></div></div>
	<div class = "mypage">
                <div class="out_menu" >
        
        <div class='top_menu' style="display:none">
             
            <ul >
              
            <li>
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
                <form method="POST" action="problems"  class="search_conetores">
                    <input type="text" name="search_con" type="search" 
                           style="z-index:9999; margin-top:30px; width:400px; border:1px solid #2ECCFA; height:15px;" 
                           name="search" id="search" placeholder="search" tabindex="1"
                           autocomplete="off" maxlength="400" autocorrect="off" class='search_problemtop' autocapitalize="off" spellcheck="false" aria-autocomplete="list"/>
              
                    <input type="submit" value="Որոնել" id='click_serarch_problem' >
                </form>
   
        </div>
                <div class="addClientLinkP">
			<a class = "problems_add">ավելացնել նոր գրառում </a>
<!--			<a id="print">տպել</a> -->
<!--			<a id="archive">դիտել արխիվը</a> -->
                       <?php if(isset($actived)){
                           
                            if($actived == 1){
                               
                          
                           ?>
                      
                           <?php }else{}}?>
		</div>
		
            <div class="table_list">
                <table>
             <thead class="ClientResult" style="position:fixed">
                        <tr>
                            <td><div style="margin-left: 5px;width:35px">№</div></td>
                            <td><div style="width:45px">Օր</div></td>
                            <td>
                                <div style="width:80px;"> 
                                   <?php echo $this->Paginator->sort('created', 'Գրանցում');?> 
                                </div>
                            </td>
                            <td><div style="width:95px;"><?php echo $this->Paginator->sort('username', 'Ծածկանուն') ;?></div></td>
                            <td><div style="width: 150px"><?php 
                               echo $this->Paginator->sort('desc', 'Հասցե'); 
                               ?></div>
                            </td>
                            <td><div style="width:100px;">Հեռախոս</div></td>
                            <td><div style="width:151px;"><?php echo $this->Paginator->sort('comment', 'Մեկնաբանություն');?></div></td>
                            <td><div style="width:170px;"><?php echo $this->Paginator->sort('comment_team', 'Կատ․մեկնաբանություն');?> </div></td>
                            <td><div style="width:160px;"><?php echo $this->Paginator->sort('pro_person', 'Կատարող');?></div></td>
                            <td><div style="width:90px;"><?php echo $this->Paginator->sort('reg_person', 'Գրանցող');?></div></td>
                            <td><div style="width:90px;">Սկիզբ</div></td>
                            <td><div style="width:90px;">Ավարտ</div></td>
                            <td><div style="width:90px;"><?php if(isset($url)){ echo "չեղյալ համարել"; }else{echo "խմբագրել";} ?></div></td>
                        </tr>
                    </thead>
                </table>
                    <div ><a style="right: 20px;z-index: 9999;margin-left: -50px;position:absolute;cursor:pointer;color:#01a0e2;background:#fff;top:10px;padding:10px;text-decoration: none;"href="/users/logout">ելք</a></div>
            </div>
        </div>
    </div>
            <div class='container'>
		
            <div class='search_con'>
                <form method="POST" action="problems"  class="search_conetores">
                    <input type="text" name="search_con" type="search" 
                           style="z-index:9999; margin-top:30px; width:400px; border:1px solid #2ECCFA; height:15px;" 
                           name="search" id="search" placeholder="search" tabindex="1"
                           autocomplete="off" maxlength="400" autocorrect="off"class='search_problem' autocapitalize="off" spellcheck="false" aria-autocomplete="list"/>
              
                    <input type="submit"value="Որոնել" id='click_problem' >
                </form>
   
   
            </div>
            
		<div class="addClientLinkP">
			<a class = "problems_add">ավելացնել նոր գրառում </a>
<!--			<a id="print">տպել</a> -->
<!--			<a id="archive">դիտել արխիվը</a> -->
                       <?php if(isset($actived)){
                           
                            if($actived == 1){
                               
                          
                           ?>
                      
                           <?php }else{}}?>
		</div>
		
		<div class="ClientResults">
	          <div class="ClientResults">
                <table style="width:100%">
                    <thead class="ClientResult">
                        <tr>
                            <td><div style="width:35px">№</div></td>
                            <th> <div style="width:45px">Օր</div></th>
                            <td><?php echo $this->Paginator->sort('created', 'Գրանցում');?> </td>
                            <td><?php echo $this->Paginator->sort('username', 'Ծածկանուն') ;?> </td>
                            <td><?php echo $this->Paginator->sort('desc', 'Հասցե');?>  </td>
                            <td>Հեռախոս</td>
                            <td ><?php echo $this->Paginator->sort('comment', 'Մեկնաբանություն');?></td>
                            <td><?php echo $this->Paginator->sort('comment_team', 'Կատ․մեկնաբանություն');?> </td>
                            <td><?php echo $this->Paginator->sort('pro_person', 'Կատարող');?></td>
                            <td><?php echo $this->Paginator->sort('reg_person', 'Գրանցող');?></td>
                            <td>Սկիզբ</td>
                            <td>Ավարտ</td>
                            <td><?php if(isset($url)){ echo "չեղյալ համարել"; }else{echo "խմբագրել";} ?></td>
                           </tr>
                    </thead>
                     <tbody  class="StyleClientResult">
                        
                        <?php if(isset($no_activeted) ){ $i = 0;?>
                        <?php   foreach ($no_activeted as $value) {  $i++;?>
                            <tr>
                                <td><div style="width:35px"><?php echo $i; ?></div></td>
                                <td> <div style="width:45px"><?php 
                                    date_default_timezone_set('Etc/GMT-4');
                                    $time = $value["problem"]["created"];
                                    $datetime1 = new DateTime($time);
                                    $datetime2 = new DateTime();
                                    $interval = $datetime1->diff($datetime2);
                                    echo $interval->format('%R%a');
                                  
                                    ?></div></td>
                                <td><div style="width:80px;"><?php 
                                $time = $value["problem"]["created"];
                                    echo date("d.m.y H:i", strtotime($time));
                                    ?></div></td>
                                <td><div style="width:95px;"><?php echo $value["technical_data"]["username"];?></div></td>
                               
                                <td><p class="ex" style="width:100px;"><?php echo $value["adress"]["city"] ?>
                                    <?php echo $value["village"]["village_name"]; if($value["adress"]["street_id"]){
                                        echo ",". $value["street"]["street_name"];
                                        if($value["adress"]["home"]){
                                            echo ",". $value["adress"]["home"];
                                        }
                                    } ?></p>
                                </td>
                                <td><div  style="width:100px;"><?php echo $value["telefon"]["telefon"];
                                        echo "<br>".$value["telefon"]["tel1"];
                                        ?></div></td>
                                <td ><div style="width:150px"><?php echo $value["problem"]["comment"] ?></div></td>
                                <td><div style="width:170px;">
                                    <?php if($value["problem"]["pro_solution"]){?>
                                        <div  style="" value="<?php echo $value["problem"]["id"]?>"><?php echo $value["problem"]["pro_solution"]?></div><?php
                                        }?></div>
                                </td>
                                <td style="position: relative;">
                                    <?php if($value["problem"]["pro_person"]){
                                       echo $value["problem"]["pro_person"];
                                      
                                    } else{ ?>
                                    <form class="conection" method="post" action="problems">
                                       <select  name = "pro_person1">
                                             <option selected="false" value style="display:none;" disabled="disabled">Նշեք անունը</option>
                                             <?php if(isset($mexanik)){
                                                    foreach ($mexanik as $values) {?>
                                                <option value="<?php echo $values["Team"]["username"];?>"><?php echo $values["Team"]["username"];?></option>
                                              <?php }}?>
                                        </select>
                                        <input name="id1" value="<?php echo $value["problem"]["id"]?>" style="display:none">
                                        <input type ="submit" value="+">
                                    </form><?php   }?>
                                </td>
                                
                                 <td><?php echo $value["problem"]["reg_person"]; ?></td>
                                <td><?php 
                                    $times = $value["problem"]["modified"];
                                    echo date("d.m.y H:i", strtotime($times )); ?></td>
                                
                                <td>
                                    <?php if($value["problem"]["pro_person"]){?>
                                        <button class="ok_problem" style="" data="<?php echo $value["problem"]["id"]?>" value="<?php echo $value["problem"]["id"]?>">հաստատել</button><?php
                                    }?>
                                </td>
                                <td>
                                    <button class="no_active" style="background: red;font-size: 15px;" value="<?php echo $value["problem"]["id"]?>">չեղյալ համարել</button>
                                </td>
                            </tr>

                        <?php }} ?>
                        </div>
          
                    </tbody>
                    <tbody class="StyleClientResult">
                         <?php $count=0;?> 
                                      
                         
                        <?php if(isset($problem) &&  isset($url)==false && isset($j)){ 
                            $i = 20;
                           ?>
                        <?php foreach($problem as $value): $i--; ?>           
                        
                            <tr>
                                <td><div style="width:35px;"><?php echo (int)($j)*20-(int)$i;?></div></td>
                                <td><div style="width:45px;"> <?php 
                                    date_default_timezone_set('Etc/GMT-4');
                                    $time = $value["problem"]["created"];
                                    $datetime1 = new DateTime($time);
                                    $datetime2 = new DateTime();
                                    $interval = $datetime1->diff($datetime2);
                                    echo $interval->format('%R%a');
                                  
                                    ?></td>
                                <td><div style="width:80px;"><?php 
                                $time = $value["problem"]["created"];
                                    echo date("d.m.y H:i", strtotime($time));
                                    ?></div></td>
                                <td><div style="width:95px;"><?php echo $value["technical_data"]["username"];?></div></td>
                               
                                <td><div style="width: 150px">
                                    <?php 
                                 
                                    if(is_null($value["problem"]["adress"])):
                                         echo trim($value["adress"]["city"])." ".$value["village"]["village_name"]."<br>"; 
                                            if($value["adress"]["street_id"]):
                                                echo ",". $value["street"]["street_name"];
                                                if($value["adress"]["home"]):
                                                    echo ",". $value["adress"]["home"];
                                                endif;
                                            endif;
                                    else:
                                        echo $value["problem"]["adress"];
                                    endif;
                                    ?></div>
                                </td>
                                <td><div style="width: 100px">
                                    <?php 
                                    if(is_null($value["problem"]["telefons"])){
                                        echo $value["telefon"]["telefon"]."<br>".$value["telefon"]["tel1"];
                                    }else{
                                        echo $value["problem"]["telefons"];
                                    }
                                    ?></div></td>
                              
                                <td ><p class="ex"><?php echo $value["problem"]["comment"] ?></p></td>
                                 <td ><p class="ex"><?php echo $value["problem"]["comment_team"] ?></p></td>
                               <?php if(isset($url)){?> <td></td> <?php } ?>
                                <td style="position: relative;">
                                    <div class="pro_person_output<?php echo $value["problem"]["id"];?>">
                                    <?php if($value["problem"]["pro_person"]){
                                  
                                       ?><div  id="row<?php echo $value["problem"]["pro_person"].$value["problem"]["id"];?>">
                                           <?php      echo $value["problem"]["pro_person"];?>
                                           <button class="delete_pro" style="font-weight: bold;color:#fff;width:20px;background: red;position: absolute;right: 6px;" data='<?php echo $value["problem"]["pro_person"]?>' value="<?php echo $value["problem"]["id"]?>">x</button></div></div><?php
                                        } ?>
                                     <?php if($value["problem"]["pro_persontwo"]){
                                     
                                       ?><div id="row<?php echo $value["problem"]["pro_persontwo"].$value["problem"]["id"];?>">
                                           <?php   echo $value["problem"]["pro_persontwo"];?>
                                           <button class="delete_pro" style="font-weight: bold;color:#fff;width:20px;background: red;position: absolute;right: 6px;" data='<?php echo $value["problem"]["pro_persontwo"]?>'  value="<?php echo $value["problem"]["id"]?>">x</button></div><?php
                                        } ?>
                                        <?php if($value["problem"]["pro_persontree"]){
                                     
                                       ?><div id="row<?php echo $value["problem"]["pro_persontree"].$value["problem"]["id"];?>">
                                           <?php   echo $value["problem"]["pro_persontree"];?><button class="delete_pro" style="font-weight: bold;color:#fff;width:20px;background: red;position: absolute;right: 6px;"data='<?php echo $value["problem"]["pro_persontree"]?>' value="<?php echo $value["problem"]["id"]?>">x</button></div><?php
                                        } ?>
                                       <select  name = "pro_person" class="pro_person<?php echo $value["problem"]["id"]?>">
                                             <option selected="false" value style="display:none;" disabled="disabled">Նշեք անունը</option>
                                             <?php if(isset($mexanik)){
                                                    foreach ($mexanik as $values) {?>
                                                <option value="<?php echo $values["Team"]["username"];?>"><?php echo $values["Team"]["username"];?></option>
                                              <?php }}?>
                                        </select>
                                       <input name="id" class="id_problem<?php echo $value["problem"]["id"]?>" value="<?php echo $value["problem"]["id"]?>" style="display:none">
                                        <input type ="submit" class="add_pro_person"data='<?php echo $value["problem"]["id"]?>' value="+">
                                 <?php  ?>
                                </td>
                                
                                 <td><?php echo $value["problem"]["reg_person"]; ?></td>
                                <td><?php 
                                    $times = $value["problem"]["modified"];
                                    echo date("d.m.y H:i", strtotime($times )); ?>
                                </td>
                                <td>
                                    <?php if($value["problem"]["pro_person"]){?>
                                        <button class="end_problems" style="" value="<?php echo $value["problem"]["id"]?>">ավարտել</button><?php
                                    }?>
                                </td>
                                <td>
                                    <button class="edit_problem" style="" value="<?php echo $value["problem"]["id"]?>">խմբագրել</button>
                                </td>
                            </tr>
                               <?php endforeach; ?>
                    <?php unset($user); ?>
                        <?php } ?>
                        </div>
                    </tbody>
                    
                    <tbody>
                     <?php
                    
                     if(isset($All_problem) && !$active){?>
                        <?php   foreach ($All_problem as $value) {  ?>
                            <tr>
                                <td> <?php 
                                    date_default_timezone_set('Etc/GMT-4');
                                    $time = $value["Problem"]["created"];
                                    $datetime1 = new DateTime($time);
                                    $datetime2 = new DateTime();
                                    $interval = $datetime1->diff($datetime2);
                                    echo $interval->format('%R%a');
                                    ?></td>
                                <td><?php 
                                $time = $value["Problem"]["created"];
                                    echo date("d.m.y H:i", strtotime($time));
                                 ?></td>
                                <td></td>
                               
                                <td><?php echo $value["Problem"]["adress"] ?></td>
                                <td><?php echo $value["Problem"]["telefons"]; ?></td>
                                <td width="40%"><p class="ex"><?php echo $value["Problem"]["comment"] ?></p></td>
                                <td style="position: relative;">
                                    <?php if($value["Problem"]["pro_person"]){
                                       echo $value["Problem"]["pro_person"];
                                       ?><button class="delete_pro" style="width:15px;text-align: center;background: red;position: absolute;right: 6px;" value="<?php echo $value["Problem"]["id"]?>">x</button><?php
                                    } else{ ?>
                                    <form class="conection" method="post" action="problems">
                                       <select  name = "pro_person">
                                             <option selected="false" value style="display:none;" disabled="disabled">Նշեք անունը</option>
                                             <?php if(isset($mexanik)){
                                                    foreach ($mexanik as $values) {?>
                                                <option value="<?php echo $values["Team"]["username"];?>"><?php echo $values["Team"]["username"];?></option>
                                              <?php }}?>
                                        </select>
                                        <input name="id" value="<?php echo $value["Problem"]["id"]?>" style="display:none">
                                        <input type ="submit" value="+">
                                    </form>
                                        <?php }?>
                                </td>
                                
                                 <td><?php echo $value["Problem"]["reg_person"];?></td>
                                <td><?php 
                                    $times = $value["Problem"]["modified"];
                                    echo date("d.m.y H:i", strtotime($times )); ?></td>
                                <td>
                                    <?php if($value["Problem"]["pro_person"]){?>
                                        <button class="end_problems" style="" value="<?php echo $value["Problem"]["id"]?>">ավարտել</button><?php
                                    }?>
                                </td>
                                 <td>
                                       <button class="edit_problem" style="color:#fff;" value="<?php echo $value["Problem"]["id"]?>">խմբագրել</button>
                                 </td>
                            </tr>

                        <?php }} ?>
                        </div>
                    </tbody>
                   
                </table>
            </div>
		</div>
              
        <?php if(isset($url)):echo ""; else:
            // Shows the next and previous links
echo $this->Paginator->prev(
  '« prev',
  null,
  null,
  array('class' => 'disabled')
);
            echo $this->Paginator->numbers();


echo $this->Paginator->next(
  'Next »',
  null,
  null,
  array('class' => 'disabled')
);

// prints X of Y, where X is current page and Y is number of pages
echo $this->Paginator->counter(); endif;?>
           
	</div>
        </div>
        <div class="opacity"></div>
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
