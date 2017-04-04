</body>
</html>

<?php echo $this->Html->css('connectors'); ?>
<?php 
    if(isset($edit)){
    foreach ($edit as $data) {
     
    } 
    
?>
<script type="text/javascript" src="/js/custom.js"></script>
<script type="text/javascript" src="/js/user.js"></script>
<link rel="stylesheet" href="../css/c.css">
<body>
     <button type="button" class="closeadding">x</button>
    <form   class = "form_page"action="/manegements/edit_con" style="width:800px"id="PersonAddForm" method="post" accept-charset="utf-8">       
        <div class = "left_div">
             <input name="data[Person][id]" value = "<?php if($data["Person"]["id"]){echo $data["Person"]["id"];} ?>" style="display:none">
            <label>անձնական տվյալներ</label>
            <?php if($data["Person"]["change_legal"] == 0){
                ?>
            <input type='text' name='data[Person][company_name]' required value="<?php if($data["legal"]["company_name"]){ echo $data["legal"]["company_name"];}?>" placeholder='company_name'>
                                        <select style="width:182px;margin-left: 3px;  height: 29px;border: 1px solid #2ECCFA"  name='data[Person][type]'>
                                                <option value='ՍՊԸ'><?php if($data["legal"]["type_company"]){ echo $data["legal"]["type_company"];}?></option>
                                                <option value='ՍՊԸ'>ՍՊԸ</option>
                                                <option value='ՊՓԲԸ'>ՊՓԲԸ</option>
                                                <option value='ՓԲԸ'>ՓԲԸ</option>
                                                <option value='ԱՁ'>ԱՁ</option>
                                        </select>
                <input name="data[Person][tax]" value = "<?php if($data["legal"]["tax"]){echo $data["legal"]["tax"];} ?>" placeholder="հվհհ"  maxlength="50" type="text" id="LegalPersonLastname">
                <input name="data[Person][position]"value = "<?php if($data["legal"]["position"]){echo $data["legal"]["position"];} ?>"placeholder="պաշտոն"  type="text" id="LegalPersonFirstname">
                <input name="data[Person][name_bank]"value = "<?php if($data["legal"]["name_bank"]){echo $data["legal"]["name_bank"];} ?>"placeholder="բանկի անվանում" maxlength="50" type="text" id="LegalPersonLastname">
                <input name="data[Person][type_bank]"value ="<?php if($data["legal"]["type_bank"]){echo $data["legal"]["type_bank"];} ?>"placeholder="տիպ" maxlength="50" type="text" id="LegalPersonLastname">
                <input name="data[Person][account]"value="<?php if($data["legal"]["account"]){echo $data["legal"]["account"];} ?>"placeholder="հհ" maxlength="50" type="text" id="LegalPersonLastname">
            <?php } ?>
            <div style="display:none;"><input type="hidden" name="_method" value="POST"></div>
            <input name="data[Person][firstname]" class="a" value="<?php  if($data["Person"]["firstname"]){ echo $data["Person"]["firstname"];}?>"placeholder="անուն" type="text" required title="անունը պետք է լինի 2 նիշից ավելին" required="required" pattern=".{3,}" 
                   oninvalid="setCustomValidity('անունը պետք է լինի 2 նիշից ավելին')"
                   onchange="try {
                               setCustomValidity('')
                           } catch (e) {
                           }">
            <input name="data[Person][lastname]" placeholder="ազգանուն" value="<?php  if($data["Person"]["lastname"]){ echo $data["Person"]["lastname"];}?>" maxlength="20" type="text">
            
            
                
               
               
                <input name="data[Person][telefon]" placeholder="հեռախոսահամար" maxlength="9"minlength="9"value="<?php  if($data["Telefon"]["telefon"]){$tel =  $data["Telefon"]["telefon"];echo $tel;}?>" required="" pattern="\d{9}" oninvalid="setCustomValidity('հեռախոսահամարը բախկացած է 9 թվից')" onchange="try {
                        setCustomValidity('')
                    } catch (e) {
                    }" id="PersonTel"> 
                <input name="data[Person][telefons]" placeholder="հեռախոսահամար" maxlength="9"minlength="9"value="<?php  if($data["Telefon"]["tel1"]){$tel =  $data["Telefon"]["tel1"];echo $tel;}?>"  id="PersonTel"> 
                <input name="data[Person][telefonss]" placeholder="հեռախոսահամար" maxlength="9"minlength="9"value="<?php  if($data["Telefon"]["tel2"]){$tel =  $data["Telefon"]["tel2"];echo $tel;}?>"  id="PersonTel"> 
                <input name="data[Person][tel_name]" placeholder="անուն" value="<?php  if($data["Telefon"]["tel_name"]){ echo $data["Telefon"]["tel_name"];}?>" type="text"   >
                <?php  if($data["Telefon"]["tel_name"]){
                    
                }else{
               ?> <button type="button" class="persontel"> + </button><br/><?php
                }?>
                <p class="control-group"></p>

        </div>
          <div class="adress">
                <div  style="float: left;">
                <select name="data[Person][city]"style="width:182px;margin-left: 3px;" class = "region" Autocomplete = "off"required oninvalid="setCustomValidity('ընտրեք մարզը')"  onchange="try {setCustomValidity('') }" placeholder ="նշեք մարզը" maxlength="50" type="text" id="Person_C">
                    <option value="<?php  if($data["Adress"]["city"]){ echo $data["Adress"]["city"];}?>"><?php  if($data["Adress"]["city"]){ echo $data["Adress"]["city"];}?></option>
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
                    </div>
                <div  style="float: left;">
                <input name="data[Person][village]" Autocomplete = "off" value="<?php  if($data["Village"]["village_name"]){ echo $data["Village"]["village_name"];}?>" oninvalid="setCustomValidity('ընտրեք միայն գյուղերի ցանկից')" onchange="try {
                                    setCustomValidity('ընտրեք միայն գյուղերի ցանկից')
                                } catch (e) {
                                }" placeholder="նշեք գյուղը" maxlength="250" type="text" id="village_r" class="village"><br>
                
                <div class="villagesearchresult" style="position: absolute"></div>
                </div>
                <div style="float: left;">
                    <input name="data[Person][street]" Autocomplete = "off" value="<?php  if($data["Street"]["street_name"]){ echo $data["Street"]["street_name"];}?>" placeholder="նշեք փողոցը"  maxlength="250" type="text" class="street" >
                    <br>
                     <div class="streetsearchresult" style="position: absolute"></div>
                </div>
                <input name="data[Person][home]" placeholder="նշեք տունը"value="<?php  if($data["Adress"]["home"]){ echo $data["Adress"]["home"];}?>" maxlength="250" type="text" id="PersonAdress">
            </div>
                <div style="float: left;">
                    <textarea style="width:650px;height:50px;border:1px solid #2ECCFA" name="data[Person][comment]" Autocomplete = "off"  placeholder="Մեկնաբանություն"  type="text"  ><?php  if($data["Person"]["comment"]){ echo $data["Person"]["comment"];}?></textarea>
                    <br>
                     
                </div>
            <div style="float:left">
                
                <input  id="signup" class="adding"   type="submit" value="խմբագրել">
            </div>
        </form>

</body>
    <?php } die();?>
