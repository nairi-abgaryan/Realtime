<div class='header'>

    <div class="opacity"></div>
    <script src="/js/jquery.js" type="text/javascript"></script>
    <script src="/js/objects.js" type="text/javascript"></script>

    <div class="sms" style="list-style: none;">
        <button id="sms" href = "#"><a href="/realtimes/message"><img width='50px' height="auto" src="../img/s.png"></a></button>
        <span class="new_message"></span>
    </div>

    <div id="menu" >

        <ul class="clearfix">
            <li>
                <a id="SearchPage" href="/realtimes/search">Ընդհանուր  </a>
            </li>
            <li >
                <a id="problem" href = "/realtimes/problems">Խնդիրներ</a>
            </li>
            <li >
                <a id="connectors" href = "/realtimes/connectors">Միացումներ</a>
            </li>
        </ul>
        <ul class="clearfixs">

            <li >
                <a id="manegement" href = "/manegements/tools">Կառավարում</a>
            </li>

        </ul>

        <div class = "logo"></div>

        <div style="color:#01a0e2;font-size: 18px;width:auto;position:absolute;top:40px;right:0%;"><?php echo "սպասարկող.<span class='auth_user' >" . $current_user["username"]; ?></span><hr>
        </div>
    </div>
    <div class = "logout"><a href="/users/logout">ելք</a></div>
</div>