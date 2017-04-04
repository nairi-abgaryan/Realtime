<body>
        <form action="/Realtime/realtimes/connectors" id="LegalPersonAddForm" method="post" accept-charset="utf-8">            <div>
                        <div style="display:none;"><input type="hidden" name="_method" value="POST"></div>
                        <input name="data[LegalPerson][company_name]" placeholder="Ընկերության անուն" type="text" id="LegalPersonFirstname">
                        <input name="data[LegalPerson][type_company]" placeholder="տիպ" type="text" id="LegalPersonFirstname">
                        <input name="data[LegalPerson][tax]" placeholder="հվհհ" maxlength="50" type="text" id="LegalPersonLastname">                     
                    </div>
                    <div>
                        <input name="data[LegalPerson][position]" placeholder="պաշտոն" type="text" id="LegalPersonFirstname">
                        <input name="data[LegalPerson][firstname]" placeholder="անուն" type="text" id="LegalPersonFirstname">
                        <input name="data[LegalPerson][lastname]" placeholder="ազգանուն" maxlength="50" type="text" id="LegalPersonLastname">
                    </div>
                    <div>
                        <input name="data[LegalPerson][name_bank]" placeholder="բանկի անվանում" maxlength="50" type="text" id="LegalPersonLastname">
                        <input name="data[LegalPerson][type_bank]" placeholder="տիպ" maxlength="50" type="text" id="LegalPersonLastname">
                        <input name="data[LegalPerson][account]" placeholder="հհ" maxlength="50" type="text" id="LegalPersonLastname">
                    </div>
                    <div>
                            <label>իրավաբանական հասցե</label>
                            <input name="data[LegalPerson][city_legal]" placeholder="նշեք մարզը" maxlength="50" type="text" id="LegalPersonCity" required="required">
                            <input name="data[LegalPerson][village_legal]" placeholder="նշեք գյուղը" maxlength="250" type="text" id="LegalPersonAdress" required="required">
                            <input name="data[LegalPerson][street_legal]" placeholder="նշեք փողոցը" maxlength="250" type="text" id="LegalPersonAdress" required="required">                            
                            <input name="data[LegalPerson][home_legal]" placeholder="նշեք տունը" maxlength="250" type="text" id="LegalPersonAdress" required="required">
                            <input name="data[LegalPerson][post_index_legal]" placeholder="Փ.ինդեքս" maxlength="250" type="text" id="LegalPersonAdress" required="required">
                    </div>
                     <div>
                            <label>գործունեության հասցե</label>
                            <input name="data[LegalPerson][city]" placeholder="նշեք մարզը" maxlength="50" type="text" id="LegalPersonCity" required="required">
                            <input name="data[LegalPerson][village]" placeholder="նշեք գյուղը" maxlength="250" type="text" id="LegalPersonAdress" required="required">
                            <input name="data[LegalPerson][street]" placeholder="նշեք փողոցը" maxlength="250" type="text" id="LegalPersonAdress" required="required">                            
                            <input name="data[LegalPerson][home]" placeholder="նշեք տունը" maxlength="250" type="text" id="LegalPersonAdress" required="required">
                            <input name="data[LegalPerson][post_index]" placeholder="Փ.ինդեքս" maxlength="250" type="text" id="LegalPersonAdress" required="required">
                    </div>
                    <div class="control-group">
                            <input name="data[LegalPerson][telefon]" placeholder="հեռախոսահամար">
                            <input name="data[LegalPerson][email]" placeholder="էլ պոստ">
                            <input name="data[LegalPerson][telName]" placeholder="անուն" type="text">
                            <button type="button" class="addtels"> + </button><br/>
                    </div>
                    <div class="reg">
                        <input name="data[LegalPerson][conectionPerson]" placeholder="գրեք ով է կատարել միացումը" type="text" id="LegalPersonreg">
                    </div>
                    <button type="button" class="closeadding">չեղյալ համարել</button>
                    <input id="signup" class="adding" formnovalidate="formnovalidate" type="submit" value="ավելացնել">
            </form>
    </body>
<script type="text/javascript" src="/Realtime/js/custom.js"></script>
