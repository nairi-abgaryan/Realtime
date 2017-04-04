<html>
    <head>
            <?php echo $this->Html->charset('utf8'); ?>
            <?php echo $this->Html->css('tools'); ?>
            <?php echo $this->Html->css('style'); ?>
            <?php echo $this->Html->css('teamTools'); ?>
            <?php echo $this->Html->css('warehouse'); ?>
            <?php echo $this->Html->css('team'); ?>
            <?php echo $this->Html->script('custom'); ?>
            <?php echo $this->Html->script('tools'); ?>
            <?php echo $this->Html->script('tools_style'); ?>
            <?php echo $this->Html->script('TeamTools'); ?>
            <?php echo $this->Html->script('map'); ?>
            <?php echo $this->Html->script('md5'); ?>
            <?php echo $this->Html->script('Tools_ware'); ?>
            <?php echo $this->Html->script('team'); ?>
    </head>
    <body>
        <div class ="menutools">
            <ul class="menu_bar_tools ">
                <li class ="tools"  ><label data="1" style="border-bottom:2px solid red;"><a style="color:#000;text-decoration: none;"href="tools">Գործիքներ</a></label></li>
                <li class="War" > <label data="2" ><a style="color:#000;text-decoration: none;"href="warehouse">Պահեստ</a></label></li>
                <li class="Teams" ><label data="3"><a style="color:#000;text-decoration: none;"href="team">Աշխատակազմ</a></label></li>
                <li class="bookkeeper" ><label data="4" ><a style="color:#000;text-decoration: none;"href="bookkeeper">Հաշվապահություն</a></label></li>
            </ul>
        </div>
        <div class = "mypage" style="width:100%;">
            <div id='page1' class="page nav nav-pills">

                <div class="all_tools" style="width:auto;float:left;">
                    <div class="tools_name">
                        <ul> 
                            <li>
                                <a  href="#">Սակագնային Պլան</a>
                                <ul>
                                    <li><a class = 'view_all_tariff' href='#'>դիտել բոլորը</a></li>
                                    <li><a class = 'new_tariff' href='#'>նոր սակագնային պլան</a></li>
                                </ul>
                            </li>
                        </ul>
                        <ul>
                            <li>
                                <a style="cursor:pointer">Կայանների ցանկի թարմացում</a>
                                <ul>
                                    <li><a class = 'view_all_station' href='#'>դիտել </a></li>
                                    <li><a class='station' href='#'>ավելացնել կայան</a></li>
                                </ul>
                            </li>
                        </ul>
<!--                        <ul>
                            <li class="view_all_server"><a  style="cursor:pointer">Սեռվերների ցանկի թարմացում</a>
                             </li>
                        </ul>-->
                        <!--                        <ul>
                                                    <li><a >Պահեստի կարգավորումներ</a></li>
                                                </ul>-->
                        <!--                        <ul>
                                                    <li><a >Ձեվավորել միկրոտիկ սերվերի հրամանը</a></li>
                                                </ul>-->
<!--                        <ul>
                            <li><a  class="black_list" style="cursor: pointer">սև ցուցակ</a></li>
                        </ul>-->
                        <ul>
                            <li><a class="Tools_wareHouse" style="cursor: pointer">դուրս գրված ապրանք</a></li>
                        </ul>
                        <ul>
                            <li><a class="teamToolslogin" style="cursor: pointer">Բացված Լոգիններ</a></li>
                        </ul>
                         <ul>
                            <li><a class="maps_all" style="cursor: pointer">Քարտեզներ</a></li>
                        </ul>
                         <ul>
                            <li>
                                <a  style="cursor: pointer">Վճարման տվյալներ</a>
                                <ul>
                                    <li class='pay_credit'><a href='#'>Վճարման օրը կրեդիտով</a></li>
                                    <li class='pay_not_credit'><a href='#'>Վճարման օրը առանց կրեդիտ</a></li>
                                    <li class='pay_credit_all'><a href='#'>Կրեդիտով Բաժանորդներ</a></li>
                                    <li class='pay_history'><a href='#'>ՎՃարման պատմություն</a></li>
                                    <li class='no_credit'><a href='#'>no-credit Բաժանորդներ</a></li>
                                    <li class='default_credit'><a href='#'>default credit</a></li>
                                </ul>
                            </li>
                         </ul>
                        <ul>
                             <li>  
                                 <a style="cursor: pointer">Բաժանորդներ</a>
                                    <ul>
                                        <li class='client' data='2'><a href='#'>Ակտիվ Բաժանորդներ</a></li>
                                        <li class='client' data='0'><a href='#'>Անջատված Բաժանորդներ</a></li>
                                        <li class='client' data='1'><a href='#'>Կասեցված Բաժանորդներ</a></li>
                                    </ul>
                             </li>
                        </ul>
                        <ul>
                           <li class='log_disabled'><a href='#'>Ավտոմատ համակարգ</a></li>
                        </ul>
                         <ul>
                            <li>
                                <a  style="cursor: pointer" class='access_view' data='2'>Կարգավորում</a>
                            </li>
                        </ul>
                        <ul>
                            <li>
                                <a  style="cursor: pointer" class='none_call' data='2'>Զանգեր</a>
                            </li>
                        </ul>
                        <ul>
                             <li>  
                                 <a style="cursor: pointer">Վճարման կետեր</a>
                                    <ul>
                                        <li class='view_center' data='2'><a href='#'>Դիտել բոլորը</a></li>
                                        <li class='add_center' data='0'><a href='#'>Ավելացնել</a></li>
                                    </ul>
                             </li>
                        </ul>
                         <ul>
                             <li>  
                                 <a style="cursor: pointer" class="jobs">Կատարված Աշխատանքներ</a>
                             </li>
                        </ul>
                    </div>
                </div>

                <div class = "price_plan" style="display: none">
                    <div class ="internet">
                        <div>Ինտերնետ Ծառաություններ</div>
                                <?php
                                if (isset($inet)) {

                                    foreach ($inet as $value) {

                                        if ($value) {
                                            ?>
                        <label><?php echo $value['service_name']["service_name"]; ?></label>
                        <div><?php echo $value['service_name']["id"]; ?> </div><br>
                                            <?php
                                        }
                                    }
                                } 
                                ?>  
                    </div>
                </div>
                <div class="view_tools" style="float:left">
                    <div class='output_region'> 

                    </div>
                    <div class='output_tools'> 
                        
                    </div>
                </div>
                <div class="clear"></div>
            </div>
         
       
                

            
            </div>

        </div>
         
        <div class="opacity"></div>
        <div style="position: absolute; left: 50%;top:30%;">
               <div style="position: relative; left: -50%;top:-50%; width:800px;height:auto;">
                   <div class="personForm" ></div> 
               </div>
        </div>



    </body>
</html>