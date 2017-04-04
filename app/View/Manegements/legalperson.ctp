<script type="text/javascript" src="../js/custom.js"></script>
<script type="text/javascript" src="../js/user.js"></script>
<body>
    <form class="form_page" action="../realtimes/connectors"id="dsa" method="POST" accept-charset="utf-8">
        <div class = "left_div">
            <label>անձնական տվյալներ</label>
            <div style="display:none;"><input type="hidden" name="_method" value="POST"></div>
            <input name="data[LegalPerson][company_name]" placeholder="Ընկերության անուն" required title="Ընկերության անուն պետք է լինի 2 նիշից ավելին" required="required" pattern=".{2,}" 
                   oninvalid="setCustomValidity('Ընկերության անուն պետք է լինի 2 նիշից ավելին')"
                   onchange="try {
                               setCustomValidity('')
                           } catch (e) {
                           }"type="text" id="LegalPersonFirstname">
        
            <input name="data[LegalPerson][lastname]" placeholder="ազգանուն" required title="ազգանուն պետք է լինի 2 նիշից ավելին" required="required" pattern=".{3,}" 
                   oninvalid="setCustomValidity('ազգանուն պետք է լինի 2 նիշից ավելին')"
                   onchange="try {
                               setCustomValidity('')
                           } catch (e) {
                           }"maxlength="50" type="text" id="LegalPersonLastname">

            
            <label>իրավաբանական հասցե</label>
            <select style="width:100%;" name="data[LegalPerson][legal_city]"style="width:182px;margin: 3px;" class = "region" Autocomplete = "off" placeholder ="նշեք մարզը" maxlength="50" type="text" id="PersonCity">
                <option selected="false" value style="display:none;" disabled="disabled">Նշեք Մարզը</option>
                <option value="Արմավիր">Արմավիր</option>>
                <option value="Արարատ">Արարատ</option>>
                <option value="Սյունիք">Սյունիք</option>>
                <option value="Վայոց Ձոր">Վայոց Ձոր</option>>
                <option value="Կոտայք">Կոտայք</option>>
                <option value="Գեղարքունիք">Գեղարքունիք</option>>
                <option value="Շիրակ">Շիրակ</option>>
                <option value="Լոռի">Լոռի</option>>
                <option value="Տավուշ">Տավուշ</option>>
                <option value="Արագածոտն">Արագածոտն</option>>
            </select>
            <input name="data[LegalPerson][village_legal]" placeholder="նշեք գյուղը" autocomplete="off" maxlength="250" type="text" oninvalid="setCustomValidity('ընտրեք միայն գյուղերի ցանկից')" onchange="try {
                                setCustomValidity('ընտրեք միայն գյուղերի ցանկից')
                            } catch (e) {
                            }" class="village">
            <span class="villagesearchresult"></span>
            <input name="data[LegalPerson][street_legal]"autocomplete="off" placeholder="նշեք փողոցը" maxlength="250" type="text" class="street" required="required">
            <span class="streetsearchresult"></span>                            
            <input name="data[LegalPerson][home_legal]" placeholder="նշեք տունը" maxlength="250" type="text" id="LegalPersonAdress" required="required">
            <input name="data[LegalPerson][post_index_legal]" placeholder="Փ.ինդեքս" maxlength="250" type="text" id="LegalPersonAdress" required="required">

            <label>գործունեության հասցե</label>
            <select style="width:100%;"name="data[LegalPerson][city]"style="width:182px;margin: 3px;" class = "region" Autocomplete = "off" required oninvalid="setCustomValidity('ընտրեք մարզը')"  onchange="try {setCustomValidity('') } placeholder ="նշեք մարզը" maxlength="50" type="text" id="PersonCity">
                <option selected="false" value style="display:none;" disabled="disabled">Նշեք Մարզը</option>
                <option value="Արմավիր">Արմավիր</option>>
                <option value="Արարատ">Արարատ</option>>
                <option value="Սյունիք">Սյունիք</option>>
                <option value="Վայոց Ձոր">Վայոց Ձոր</option>>
                <option value="Կոտայք">Կոտայք</option>>
                <option value="Գեղարքունիք">Գեղարքունիք</option>>
                <option value="Շիրակ">Շիրակ</option>>
                <option value="Լոռի">Լոռի</option>>
                <option value="Տավուշ">Տավուշ</option>>
                <option value="Արագածոտն">Արագածոտն</option>>
            </select>
            <input name="data[LegalPerson][village]" Autocomplete = "off" placeholder="նշեք գյուղը" oninvalid="setCustomValidity('ընտրեք միայն գյուղերի ցանկից')" onchange="try {
                                setCustomValidity('ընտրեք միայն գյուղերի ցանկից')
                            } catch (e) {
                            }"  type="text" class="villages" >
            <span class="villagesearchresults"></span>
            <input name="data[LegalPerson][street]" Autocomplete = "off" placeholder="նշեք փողոցը" maxlength="250" type="text" class="streets" required="required">
            <span class="streetsearchresults"></span>                            
            <input name="data[LegalPerson][home]" placeholder="նշեք տունը" maxlength="250" type="text" id="LegalPersonAdress" required="required">
            <input name="data[LegalPerson][post_index]" placeholder="Փ.ինդեքս" maxlength="250" type="text" id="LegalPersonAdress" required="required">
        </div>
    </div>
    <div class="technical">
        <label>տեխնիկական տվյալներ</label>
        <input name="data[LegalPerson][user]"  placeholder="օգտատեր" maxlength="50" type="text" class="PersonUser" >
        <input name="data[LegalPerson][password]" placeholder="Գաղտնաբառ" required pattern=".{5,}" oninvalid="setCustomValidity('գաղտնաբառը պետք է գերազանցի 5 նիշը')" onchange="try {
                    setCustomValidity('')
                } catch (e) {
                }" type="text" id="PersonAdress" required="required">
        <input name="data[LegalPerson][station]" placeholder="կայան"  pattern=".{3,}" oninvalid="setCustomValidity('3 նիշից ավելի')" onchange="try {
                    setCustomValidity('')
                } catch (e) {
                }" type="text" id="PersonAdress" required="required">                            
        <input name="data[LegalPerson][con_type]" placeholder="միացման տիպ" maxlength="250" type="text" id="PersonAdress" required="required">
        <input name="data[LegalPerson][ip_range]" placeholder="IP range" maxlength="250" type="text" pattern="\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}"  oninvalid="setCustomValidity('ստուգեք ձեր գրած IP ')" onchange="try {
                    setCustomValidity('')
                } catch (e) {
                }"id="PersonAdress" required="required">
        <input name="data[LegalPerson][modem]" placeholder="մոդեմ" maxlength="250" pattern=".{3,}" oninvalid="setCustomValidity('3 նիշից ավելի')" onchange="try {
                    setCustomValidity('')
                } catch (e) {
                }" type="text" id="PersonAdress" required="required">
        <input name="data[LegalPerson][ap]" placeholder="AP" maxlength="250" type="text" id="PersonAdress" required="required">
        <input name="data[LegalPerson][vlan]" placeholder="VLAN" maxlength="250" type="text" id="PersonAdress" required="required">
    </div>
    <div class=""  style="margin:5px"> 
        <?php if (isset($service_name)) {?>
                <select style="width:300px;margin-left:6px" name="data[LegalPerson][service]" class = "region" Autocomplete = "off" placeholder="նշեք ծառաությունը" maxlength="50" type="text" id="PersonCity" required="required">
                    <option selected="false" value="" style="display:none;" disabled="disabled">Ընտրեք Ծառաությունը</option>>
                    <?php foreach ($service_name as $value) { ?>
                        <option>
                            <?php echo $value["Service_name"]["service_name"]; ?>
                        </option>

                    <?php
                    }
                }
                ?>
            </select>
         <input name="data[LegalPerson][price]" placeholder="բաժանորդի վճարած սկզբնական գումարը" maxlength="250" type="number" id="PersonAdress" required="required">

    </div>
    <div class="user_property">
        <label>Գույք կցված օգտատիրոջը</label>
        <input name="data[LegalPerson][type]" placeholder="տեսակ" maxlength="50" type="text" id="LegalPersonCity" required="required">
        <input name="data[LegalPerson][model]" placeholder="մոդել" maxlength="250" type="text" id="LegalPersonAdress" required="required">
        <input name="data[LegalPerson][quantity]" placeholder="քանակ" pattern="\d{0,9}" oninvalid="setCustomValidity('գրեք միայն թվեր')" onchange="try {
                    setCustomValidity('')
                } catch (e) {
                }" type="text" id="LegalPersonAdress" required="required">                            
        <input name="data[LegalPerson][malux]" placeholder="մալուխ" maxlength="250" type="text" id="LegalPersonAdress" required="required">
        <input name="data[LegalPerson][ftp]" placeholder="FTP cat5e" maxlength="250" type="text" id="LegalPersonAdress" required="required">
        <input name="data[LegalPerson][length]" placeholder="չապս" maxlength="250" type="text" id="LegalPersonAdress" required="required">
    </div>
    <div class="gps_div">
        <label>GPS</label>
        <input name="data[LegalPerson][gps]" placeholder="GPS" pattern="\d{2}.\d{6},\d{2}.\d{6}"oninvalid="setCustomValidity('2 թիվ.6թիվ,2թիվ.6թիվ')" onchange="try {
                    setCustomValidity('')
                } catch (e) {
                }" required="">
                <input name="data[LegalPerson][email]" type="email" required oninvalid="setCustomValidity('ստուգեք ձեր գրած էլ պոստը')" onchange="try {
                    setCustomValidity('')
                } catch (e) {
                }" placeholder="էլ պոստ" ><br>
        <input name="data[LegalPerson][telefon]" placeholder="հեռախոսահամար" placeholder="հեռախոսահամար" required="" pattern="\d{9}" oninvalid="setCustomValidity('հեռախոսահամարը բախկացած է 9 թվից')" onchange="try {
                    setCustomValidity('')
                } catch (e) {
                }">
        <input name="data[LegalPerson][tel_name]" placeholder="անուն" type="text" required="">
         <button type="button" class="legaltel"> + </button>
        <p class="control-group"></p>
       
    </div>
    <div class="button">
        <button type="button" class="closelegalform" style="width:200px;height: 35px;border-radius: 4px; font-size:18px; margin-top:8px;" >չեղյալ համարել</button>
        <input id="signup" class="adding" style="width:200px;height: 35px;border-radius: 4px; font-size:18px; margin:3px;" type="submit" value="ավելացնել">
    </div>
</form>
</body>
