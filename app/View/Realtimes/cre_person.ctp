
<script type="text/javascript" src="/js/custom.js"></script>
<?php if(isset($value)){
   
?>
<div class="param" style="min-width:200px;min-height: 20px;">
    <label style="display: block;color:#01a0e2;font-weight: bold;">Անուն Ազգանուն   <button type="button" class="close_ar">x</button></label>
    <div><?php  foreach($value as $data){?>
        <a style="color:black"href="search?id=<?php echo $data["Person"]["id"] ?>" ><?php echo $data["Person"]["firstname"];echo "  "; echo $data["Person"]["lastname"]; echo "<br>"?></a>
<?php }?>
    </div>
</div>
<?php } die();?>