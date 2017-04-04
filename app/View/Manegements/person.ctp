
<?php echo $this->Html->css('connectors'); ?>
<?php 
    if(isset($people)){
    foreach ($people as $data) {
        //var_dump($data);
    }
?>
<script type="text/javascript" src="/js/custom.js"></script>
<script type="text/javascript" src="/js/user.js"></script>
<link rel="stylesheet" href="/css/c.css">
<body>
     <button type="button" class="closeadding">x</button>
    <form  class = "form_page" action="search" id="PersonAddForm" method="post" accept-charset="utf-8">       
        <div class = "left_div">
            <label>անձնական տվյալներ</label>
            <?php if($data["Person"]["change_legal"] == 0){
                ?>
            <input type='text' name='data[Person][company_name]' required value="<?php if($data["legal"]["company_name"]){ echo $data["legal"]["company_name"];}?>" placeholder='company_name'>
                                        <select style="width:182px;margin-left: 3px;  height: 20px;border: 1px solid #2ECCFA"  name='data[Person][type]'>
                                                <option value='ՍՊԸ'><?php if($data["legal"]["type_company"]){ echo $data["legal"]["type_company"];}?></option>
                                                <option value='ՍՊԸ'>ՍՊԸ</option>
                                                <option value='ՊՓԲԸ'>ՊՓԲԸ</option>
                                                <option value='ՓԲԸ'>ՓԲԸ</option>
                                                <option value='ԱՁ'>ԱՁ</option>
                                        </select><br>
                <input name="data[Person][tax]" placeholder="հվհհ"  maxlength="50" type="text" id="LegalPersonLastname">
                <input name="data[Person][account]" placeholder="բանկի հհ" maxlength="50" type="text" id="LegalPersonLastname">
                <input name="data[Person][name_bank]" placeholder="բանկի անվանում" maxlength="50" type="text" id="LegalPersonLastname">
                <input name="data[Person][type_bank]" placeholder="տիպ" maxlength="50" type="text" id="LegalPersonLastname">
               
             
            <?php } ?>
            <div style="display:none;"><input type="hidden" name="_method" value="POST"></div>
              <?php if($data["Person"]["change_legal"] != 0){?>
            <input style="display:none" name="data[Person][id]" value="<?php echo $data["Person"]["id"];?>">
            <input name="data[Person][firstname]" class="a" value="<?php  if($data["Person"]["firstname"]){ echo $data["Person"]["firstname"];}?>"placeholder="անուն" type="text" required title="անունը պետք է լինի 2 նիշից ավելին" required="required" pattern=".{3,}" 
                   oninvalid="setCustomValidity('անունը պետք է լինի 2 նիշից ավելին')"
                   onchange="try {
                               setCustomValidity('')
                           } catch (e) {
                           }">
            <input name="data[Person][lastname]" placeholder="ազգանուն" value="<?php  if($data["Person"]["lastname"]){ echo $data["Person"]["lastname"];}?>" maxlength="20" type="text">
            
              
            <input name="data[Person][pasport_seria]" maxlength="9" placeholder="Անփնագրի սերիա"  pattern="[A-Za-z0-9]{2}\d{7}"   title="9 նիշ"
                   oninvalid="setCustomValidity('պասպորտ ի  սերիան պետք ե լինի 9ը նիշ')" onchange="try {
                               setCustomValidity('') } catch (e) {}"  id="PersonLastname">                     
            <input name="data[Person][add_pasport_time]" placeholder="Տրված է" maxlength="50" pattern="\d{1,2}.\d{1,2}.\d{4}" 
                   id="PersonLastname"  oninvalid="setCustomValidity('գրեք ամսաթիվը կետերով')" onchange="try {
                               setCustomValidity('')
                           } catch (e) {
                           }" id="Person_addpas" >
                <input name="data[Person][by_whom]" placeholder="ում կողմից" maxlength="3"   pattern="\d{3}"  title="3 թիվ"
                   oninvalid="setCustomValidity('3 թիվ')" onchange="try {
                               setCustomValidity('')
                           } catch (e) {
                           }" id="Personby_whom">
      
          
                <input name="data[Person][post_index]" placeholder="Փ.ինդեքս" maxlength="250" type="text" id="PersonAdress" >
            
              
               
                <input name="data[Person][telefon]" placeholder="հեռախոսահամար" maxlength="9"minlength="9"value="<?php  if($data["Telefon"]["telefon"]){$tel =  $data["Telefon"]["telefon"];$len = strlen($tel);if($len !=9){$tel = substr($tel, 0,9-$len); echo $tel;}else{ echo $tel;}}?>" required="" pattern="\d{9}" oninvalid="setCustomValidity('հեռախոսահամարը բախկացած է 9 թվից')" onchange="try {
                        setCustomValidity('')
                    } catch (e) {
                    }" id="PersonTel"> 
                <input name="data[Person][tel_name]" placeholder="անուն" value="<?php  if($data["Telefon"]["tel_name"]){ echo $data["Telefon"]["tel_name"];}?>" type="text"  >
                <button type="button" class="persontel"> + </button><br/>
                <p class="control-group"></p>
                  <input name="data[Person][gps]"  placeholder="GPS" pattern="\d{2}.\d{6},\d{2}.\d{6}" oninvalid="setCustomValidity('2 թիվ.6թիվ,2թիվ.6թիվ')"  id="Person_gps">
                <input name="data[Person][email]"type ="email"  oninvalid="setCustomValidity('ստուգեք ձեր գրած էլ պոստը')" onchange="try {
                            setCustomValidity('')
                        } catch (e) {
                        }" placeholder="էլ պոստ" autocomplete="off" id="PersonEmail">
                 
                <?php } if($data["Person"]["change_legal"] == 0){
                    ?> 
                        <input name="data[Person][telefon]" placeholder="հեռախոսահամար" maxlength="9"minlength="9"value="<?php  if($data["Telefon"]["telefon"]){$tel =  $data["Telefon"]["telefon"];$len = strlen($tel);if($len !=9){$tel = substr($tel, 0,9-$len); echo $tel;}else{ echo $tel;}}?>" required="" pattern="\d{9}" oninvalid="setCustomValidity('հեռախոսահամարը բախկացած է 9 թվից')" onchange="try {
                                    setCustomValidity('')
                                } catch (e) {
                                }" id="PersonTel"> 
                        <input name="data[Person][firstname]" class="a" value="<?php  if($data["Person"]["firstname"]){ echo $data["Person"]["firstname"];}?>"placeholder="անուն" type="text" required title="անունը պետք է լինի 2 նիշից ավելին" required="required" pattern=".{3,}" 
                                oninvalid="setCustomValidity('անունը պետք է լինի 2 նիշից ավելին')"
                                onchange="try {
                                            setCustomValidity('')
                                        } catch (e) {
                                        }">
                        <input name="data[Person][lastname]" placeholder="ազգանուն" value="<?php  if($data["Person"]["lastname"]){ echo $data["Person"]["lastname"];}?>" maxlength="20" type="text">
                        
                        <input name="data[Person][position]" placeholder="պաշտոն"  type="text" id="LegalPersonFirstname">
                        <button type="button" class="persontel_leg"> + </button><br/>
                            <p class="control-group"></p>
                              <input name="data[Person][gps]"  placeholder="GPS" pattern="\d{2}.\d{6},\d{2}.\d{6}" oninvalid="setCustomValidity('2 թիվ.6թիվ,2թիվ.6թիվ')"  id="Person_gps">
                <input name="data[Person][email]"type ="email"  oninvalid="setCustomValidity('ստուգեք ձեր գրած էլ պոստը')" onchange="try {
                            setCustomValidity('')
                        } catch (e) {
                        }" placeholder="էլ պոստ" autocomplete="off" id="PersonEmail">
                <?php } ?>
                
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
                    <input name="data[Person][street]" Autocomplete = "off" value="<?php  if($data["Street"]["street_name"]){ echo $data["Street"]["street_name"];}?>" placeholder="նշեք փողոցը"  maxlength="250" type="text" class="street"  required="required">
                    <br>
                     <div class="streetsearchresult" style="position: absolute"></div>
                </div>
                <input name="data[Person][home]" placeholder="նշեք տունը"value="<?php  if($data["Adress"]["home"]){ echo $data["Adress"]["home"];}?>" maxlength="250" type="text" id="PersonAdress" required="required">
            </div>
        <div style="width: 800px;height: 100px;float: left;">
            <textarea name="data[Person][comment]" style="width: 100%;height: 50px;max-width: 100%;max-height: 200px;display:block;text-align: left;"><?php if($data["Person"]["comment"]){echo trim($data["Person"]["comment"]); }?></textarea>
        </div>
        <div style="float:left">
       
            <input  id="signup"style="width: 100px;height:20px" class="adding" type="submit" value="ավելացնել">
         </div>
        </form>

    <?php die();}?>
