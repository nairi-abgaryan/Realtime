
  
        <div class = "addForm">
            <form action="../realtimes/connectors" id="ClientAddForm" method="post" accept-charset="utf-8">
                 <select name="data[Client][person]" "style="width:300px;margin: 1px;" class = "category" Autocomplete = "off" required oninvalid="setCustomValidity('նշեք կամ ֆիզ.անձ կամ իրավ. անձ')"  onchange="try {setCustomValidity('') } placeholder ="նշեք մարզը" maxlength="50" type="text" id="PersonCity">
                        <option selected="false" value style="display:none;" disabled="disabled">ընտրեք</option>
                        <option value="1">Ֆիզիկական Անձ</option>
                        <option value="0">Իրավաբանական անձ</option>
                       
                    </select>
                    <div class="company"></div>
                <div style="display:none;"><input type="hidden" name="_method" value="POST" required>
                </div><div class="input text"><input name="data[Client][firstname]" placeholder="անուն" required type="text" id="ClientFirstname"></div>
                <div class="input text"><input name="data[Client][lastname]" placeholder="ազգանուն" maxlength="50"required type="text" id="ClientLastname"></div><div class="input text required"><input name="data[Client][city]" placeholder="նշեք մարզը" maxlength="50" type="text" id="ClientCity" required="required">
                </div>
                <div>
                    <select name="data[Client][city]""style="width:182px;margin: 1px;" class = "region" Autocomplete = "off" required oninvalid="setCustomValidity('ընտրեք մարզը')"  onchange="try {setCustomValidity('') } placeholder ="նշեք մարզը" maxlength="50" type="text" id="PersonCity">
                        <option selected="false" value style="display:none;" disabled="disabled">Նշեք Մարզը</option>
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
                <div class="input text required"><input name="data[Client][adress]" read-only placeholder=" բնակության հասցեն" maxlength="250" type="text" id="ClientAdress" required="required">
                </div><div class="control-group"><input name="data[Client][telefon]"required="" pattern="\d{9}" oninvalid="setCustomValidity('հեռախոսահամարը բախկացած է 9 թվից')" onchange="try {
                        setCustomValidity('')
                    } catch (e) {
                    }" placeholder="հեռախոսահամար">
                    <input name="data[Client][telName]" required placeholder="անուն" type="text"></div><div class="input text"><input name="data[Client][reg]" required placeholder="գրանցող" type="text" id="Clientreg"></div>
                <textarea name="data[Client][comment]" placeholder="մեկնաբանություն" class="textarea" id="ClientAdress" required="required"></textarea>
                <button type="button" class="closeadding">չեղյալ համարել</button>
                <input id="signup" class="adding"  type="submit" value="ավելացնել"></form>
        </div>
  <?php die();?>