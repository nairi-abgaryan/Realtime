
<html>
    <head>
        <?php echo $this->Html->charset('utf8'); ?>
        <?php echo $this->Html->css('style'); ?>
     </head>
    <body>
        <div class = "Reg">
            <?php
                echo $this->Form->create("User",array(
                    'class'=>'registration',
                    'label'=>false,
                    'div'=>false));
                echo $this->Form->input("firstname",array(
                    "placeholder"=>"անուն",
                    'label'=>'անուն',
                    "type"=>"text"));
                echo $this->Form->input("lastname",array(
                    "placeholder"=>"ազգանուն",
                    'label'=>'ազգանուն'));
                echo $this->Form->input("email",array(
                    "placeholder"=>"էլ հասցե",
                    'type' => 'email'));
                echo $this->Form->input("username",array(
                    "placeholder"=>"մուտքանուն",
                    'label'=>'մուտքանուն'));
                echo $this->Form->input("password",array(
                    "placeholder"=>"գախտնաբառ",
                    'label'=>'գախտնաբառ',
                    'type' => 'password'));
               echo $this->Form->input("pass2",array(
                    "placeholder"=>"գրեք նույն գախտնաբառը",
                    'label'=>'գախտնաբառ',
                   'type' => 'password', 'label' => 'Repeat password'));
               
                echo $this->Form->input("position", array(
                    'options' => array("Ադմին", "օպերատոր","հաշվապահ" ,"մենեջեր"),
                    'label'=> 'նշեք ձեր պաշտոնը',
                    "empty"=>"պաշտոնը",
                    ));
                $options = array(                   
                    'label' => 'ավելացնել',
                    'id' => 'signup',
                    'formnovalidate' => true,
                    );
                echo $this->Form->end('Sign Up');
            ?>
         </div>
    </body>
</html>
