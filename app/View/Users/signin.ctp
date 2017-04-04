<?php echo $this->Form->create('User'); 
echo "Please enter your username and password";
echo $this->Form->input('username');
echo $this->Form->input('password');
echo $this->Form->end('Sign In');

 ?>

