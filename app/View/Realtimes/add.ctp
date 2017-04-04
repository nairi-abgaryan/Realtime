
<script type="text/javascript" src="/js/custom.js"></script>
<script type="text/javascript" src="/js/user.js"></script>
<body>
  <button type="button" class="closeadding">x</button>
    <div class = "addForm">
        <form action="../realtimes/connectors" id="ClientAddForm" method="post" accept-charset="utf-8">
            <select name="data[Person][leg]" style="width:300px;margin: 1px;" class = "category" maxlength="50" type="text" id="PersonCity">
                <option value="1">Ֆիզիկական Անձ</option>
                <option value="0">Իրավաբանական անձ</option>

            </select>
            <div class="company"></div>
            <div style="display:none;"><input type="hidden" name="_method"  value="POST" ></div>
            <div class="input text">
                <input name="data[Person][firstname]" placeholder="անուն" required type="text" id="ClientFirstname">
                <input name="data[Person][lastname]" placeholder="ազգանուն"required maxlength="50" type="text" id=" ClientLastname">
            </div>
            <div class="adress">
                <select name="data[Person][city]"style="width:182px;margin: 1px;" class = "region"  required  placeholder ="նշեք մարզը"  id="Person_C">
                    <option selected="false" value style="display:none;" disabled="disabled">Նշեք Մարզը</option>
                    <option value="Երևան">Երևան</option>
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
 
                <div  style="float: left;">
                <input name="data[Person][village]" Autocomplete = "off" disabled="disabled" oninvalid="setCustomValidity('ընտրեք միայն գյուղերի ցանկից')" onchange="try {
                                    setCustomValidity('ընտրեք միայն գյուղերի ցանկից')
                                } catch (e) {
                                }" placeholder="նշեք գյուղը" maxlength="250" type="text" class="village"><br>
                
                <div class="villagesearchresult" style="position: absolute"></div>  </div>
                <div  style="float: left;">
                <input name="data[Person][street]" placeholder="նշեք փողոցը" Autocomplete = "off"  maxlength="250" type="text" class="street"><br>
                
                <div class="streetsearchresult" style="position: absolute"></div>  </div>                           
                <input name="data[Person][home]" placeholder="նշեք տունը" maxlength="250" type="text" id="PersonAdress" >
            </div><div class="control-group"><input name="data[Person][telefon]" placeholder="հեռախոսահամար"value="0" maxlength="9"minlength="9" required="" pattern="\d{9}" oninvalid="setCustomValidity('հեռախոսահամարը բախկացած է 9 թվից')" onchange="try {
                        setCustomValidity('')
                    } catch (e) {
                    }" > 
                <input name="data[Person][tel_name]"  placeholder="անուն" type="text"><button type="button" class="persontel"> + </button><br/></div>
            <textarea name="data[Person][comment]" placeholder="մեկնաբանություն" class="textarea" id="ClientAdress" ></textarea>
          
            <input class="adding"  type="submit" value="ավելացնել"></form>
    </div>
</body>
<?php die();?>
