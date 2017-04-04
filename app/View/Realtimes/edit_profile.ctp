<?php if(isset($station)){ ?>
<?php echo $this->Html->css('style'); ?>
<?php echo $this->Html->css('connectors'); ?>
<script type='text/javascript' src='../js/jquery.js'></script>
<script type='text/javascript' src='../js/user.js'></script>

<form   class = "form_page"action="/realtimes/technical_data" style="width:600px;" method="post" accept-charset="utf-8"> 
    <div class="technical">
        <label style="display: block;color:#01a0e2;">տեխնիկական տվյալներ</label>
        <input name="data[Person][username]" required class="PersonUser" placeholder="օգտատեր" maxlength="50" type="text" class="PersonUser" >
        <input name="data[Person][password]" placeholder="Գաղտնաբառ"  pattern=".{5,}" oninvalid="setCustomValidity('գաղտնաբառը պետք է գերազանցի 5 նիշը')" onchange="try {
                        setCustomValidity('')
                    } catch (e) {
                    }" type="text" id="PersonAdress" > 
          <select style="width:150px;" name="data[Person][station]"  Autocomplete = "off" placeholder="կայան" maxlength="50" type="text" id="PersonCity" required="required">
                    <option selected="false" value="" style="display:none;" disabled="disabled">կայան</option>
                    <?php foreach ($station as $value) { ?>
                        <option>
                            <?php echo $value["Station"]["station_name"]; ?>
                        </option>

                        <?php
                    }
                
                ?>       
        <input name="data[Person][con_type]" placeholder="միացման տիպ" maxlength="250" type="text" id="PersonAdress" >
        <input name="data[Person][modem]" placeholder="մոդեմ" maxlength="250" pattern=".{3,}" oninvalid="setCustomValidity('3 նիշից ավելի')" onchange="try {
                        setCustomValidity('')
                    } catch (e) {
                    }" type="text" id="PersonAdress">
        <input name="data[Person][ap]" placeholder="AP" maxlength="250" type="text" id="PersonAdress" >
        <input name="data[Person][vlan]" placeholder="VLAN"  maxlength="10" type="number" id="PersonAdress">


        <div class=""  style="margin:5px"> 
            <?php if (isset($service_name)) { ?>
                <select style="width:300px;" name="data[Person][service]"  Autocomplete = "off" placeholder="նշեք ծառաությունը" maxlength="50" type="text" id="PersonCity" required="required">
                    <option selected="false" value="" style="display:none;" disabled="disabled">Ընտրեք ծառայությունը</option>
                    <?php foreach ($service_name as $value) { ?>
                        <option>
                            <?php echo $value["Service_name"]["service_name"]; ?>
                        </option>

                        <?php
                    }
                }
                ?>
            </select>
            
        </div>
        
    </div>
    <input type="submit" value="ստեղծել" style="width:100px;height:28px;border:1px solid green;margin-left:83%;margin-top:5px;color:#fff;background: #039540;border-radius: 4px;">
</form>
<?php echo $this->Session->flash(); ?>
<?php }?>