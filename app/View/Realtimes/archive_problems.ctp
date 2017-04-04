<script type="text/javascript" src="/js/problem.js"> </script>

<div class="archives_read"></div>
<button style="position:absolute;left:1000px;background:red;font-weight:bold;border:none;color:#fff;" class="close">X</button>
<?php
if(isset($page)){

   for($i=1;$i<=$page;$i++){
       ?><button style="cursor:pointer;top:2px;left:20%"class="page" value="<?php echo $i*10; ?>"><?php echo $i; ?></button><?php
    }

}
die();
?>