<!-- app/View/Users/add.ctp -->
<?php echo $this->Html->css('style');?>
<?php echo $this->Html->css('cake');?>
<div class="mypage" >
 <?php echo $this->Html->css('cake');?>
<?php echo $this->Form->create('User');?>
    <fieldset>
        <?php echo $this->Form->input('username');
        echo $this->Form->input('email');
        echo $this->Form->input('password');
        echo $this->Form->input('password_confirm', array('label' => 'Confirm Password *', 'maxLength' => 255, 'title' => 'Confirm password', 'type'=>'password'));
        ?>
        <select name='data[User][role]'>
            <?php if(isset($role)){ foreach ($role as $value) {
                      ?>
            <option value="<?php echo (int)$value["user_role"]["id"]?> "> <?php echo $value["user_role"]["role"]?> </option>
            <?php  } }
             ?>
        </select>
        <?php
         
        echo $this->Form->submit(
                'Add User', array('class' => 'form-submit',  'title' => 'Click here to add the user',"style"=>'border:1px solid black; font-size: 20px;') ); 
?>
    </fieldset>
<?php echo $this->Form->end(); ?>
</div>
<?php 
if($this->Session->check('Auth.User')){
echo $this->Html->link( "Return to Dashboard",   array('action'=>'index') ); 
echo "<br>";
echo $this->Html->link( "Logout",   array('action'=>'logout') ); 
}else{
echo $this->Html->link( "Return to Login Screen",   array('action'=>'login') ); 
}
?>
