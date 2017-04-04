
    <head>
          <?php echo $this->Html->script('jquery'); ?>
          <?php echo $this->Html->script('message'); ?>
          <?php echo $this->Html->css('messages'); ?>
    </head>
    <div class="message">
        <div class="username">
           
        </div>
        <div class="message_text">
            <div class="role">
                 <?php
                if(isset($role)){
                    foreach ($role as $value) {
                        ?> 
                            <button class="roles" value="<?php echo $value["role"]["category"];?>"
                            style="cursor: pointer; height: 25px; border:1px solid #ccc;background: #ccc;">  
                            <?php echo $value["role"]["category"];?>
                        </button>
                       <?php
                    }
                    
                }
                ?>
            </div>
            <div class="text">
                <div class="save_images"></div>
                <div class="write_message"> </div>
            </div>
            
        </div>
    </div>

    <?php die(); ?>