<?php

/**
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version());
 
?>


<?php $a = $_SERVER['REQUEST_URI'];if($a != "/"){ ?>
<!DOCTYPE html>

<meta name="google-site-verification" content="ZtGUrw94vttmZK-FDViVu6rXXi6w738CWiM-s_3K_wo" />

  <?php echo $this->Html->css("message"); ?>
  <?php // if($this->Session->read()){  var_dump($this->Session->read()["message"]); }?>
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
<div class="messages_output_div"></div>
<?php }
echo $this->Html->meta('icon');

echo $this->fetch('meta');
echo $this->fetch('css');
echo $this->fetch('script');
?>

        <?php echo $this->Session->flash(); ?>

        <?php echo $this->fetch('content'); //echo $this->element('sql_dump');?>
     


