<div class="technical">
            <label>տեխնիկական տվյալներ</label>
            <input name="data[Person][user]"  placeholder="օգտատեր" maxlength="50" type="text" class="PersonUser" >
            <input name="data[Person][password]" placeholder="Գաղտնաբառ" required pattern=".{5,}" oninvalid="setCustomValidity('գաղտնաբառը պետք է գերազանցի 5 նիշը')" onchange="try {
                        setCustomValidity('')
                    } catch (e) {
                    }" type="text" id="PersonAdress" required="required">
            <input name="data[Person][station]" placeholder="կայան"  pattern=".{3,}" oninvalid="setCustomValidity('3 նիշից ավելի')" onchange="try {
                        setCustomValidity('')
                    } catch (e) {
                    }" type="text" id="PersonAdress" required="required">                            
            <input name="data[Person][con_type]" placeholder="միացման տիպ" maxlength="250" type="text" id="PersonAdress" required="required">
            <input name="data[Person][ip_range]" placeholder="IP range" maxlength="250" type="text" pattern="\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}"  oninvalid="setCustomValidity('ստուգեք ձեր գրած IP ')" onchange="try {
                        setCustomValidity('')
                    } catch (e) {
                    }"id="PersonAdress" required="required">
            <input name="data[Person][modem]" placeholder="մոդեմ" maxlength="250" pattern=".{3,}" oninvalid="setCustomValidity('3 նիշից ավելի')" onchange="try {
                        setCustomValidity('')
                    } catch (e) {
                    }" type="text" id="PersonAdress" required="required">
            <input name="data[Person][ap]" placeholder="AP" maxlength="250" type="text" id="PersonAdress" required="required">
            <input name="data[Person][vlan]" placeholder="VLAN" maxlength="250" type="text" id="PersonAdress" required="required">
        </div>
       
        <div class="user_property">
            <label>Գույք կցված օգտատիրոջը</label>
            <input name="data[Person][type]" placeholder="տեսակ" maxlength="50" type="text" id="PersonCity" required="required">
            <input name="data[Person][model]" placeholder="մոդել" maxlength="250" type="text" id="PersonAdress" required="required">
            <input name="data[Person][quantity]" placeholder="քանակ" pattern="\d{0,9}" oninvalid="setCustomValidity('գրեք միայն թվեր')" onchange="try {
                        setCustomValidity('')
                    } catch (e) {
                    }" type="text" id="PersonAdress" required="required">                            
            <input name="data[Person][malux]" placeholder="մալուխ" maxlength="250" type="text" id="PersonAdress" required="required">
            <input name="data[Person][ftp]" placeholder="FTP cat5e" maxlength="250" type="text" id="PersonAdress" required="required">
            <input name="data[Person][length]" placeholder="չապս" maxlength="250" type="text" id="PersonAdress" required="required">
        </div>